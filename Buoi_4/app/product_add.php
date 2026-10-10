<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837
 * File: product_add.php
 * Mục đích: Hiển thị form và xử lý thêm sản phẩm mới vào cơ sở dữ liệu.
 * Kiểm tra tính hợp lệ dữ liệu (Validation) và phòng chống lỗi đầu vào.
 */

require_once __DIR__ . '/model/product.php';

$pageTitle = 'Thêm sản phẩm mới - Shopping Cart';

$name = '';
$price = '';
$quantity = '';
$errors = [];

// Xử lý dữ liệu khi người dùng gửi form (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Nhận và làm sạch dữ liệu đầu vào
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';

    // 2. Kiểm tra dữ liệu (Validation) theo đúng yêu cầu đề bài
    // Kiểm tra tên sản phẩm
    if ($name === '') {
        $errors[] = 'Tên sản phẩm không được để trống.';
    } elseif (mb_strlen($name, 'UTF-8') > 100) {
        $errors[] = 'Tên sản phẩm không được vượt quá 100 ký tự (theo thiết kế cơ sở dữ liệu).';
    }

    // Kiểm tra giá sản phẩm (Giá > 0)
    if ($price === '') {
        $errors[] = 'Giá sản phẩm không được để trống.';
    } elseif (!is_numeric($price)) {
        $errors[] = 'Giá sản phẩm phải là một số hợp lệ.';
    } elseif ((float)$price <= 0) {
        $errors[] = 'Giá sản phẩm phải lớn hơn 0 (Giá > 0).';
    }

    // Kiểm tra số lượng sản phẩm (Số lượng >= 0 và là số nguyên)
    if ($quantity === '') {
        $errors[] = 'Số lượng sản phẩm không được để trống.';
    } elseif (filter_var($quantity, FILTER_VALIDATE_INT) === false) {
        $errors[] = 'Số lượng sản phẩm phải là một số nguyên hợp lệ.';
    } elseif ((int)$quantity < 0) {
        $errors[] = 'Số lượng sản phẩm phải lớn hơn hoặc bằng 0 (Số lượng >= 0).';
    }

    // 3. Nếu không có lỗi, tiến hành thêm sản phẩm vào CSDL
    if (empty($errors)) {
        $result = addProduct($name, (float)$price, (int)$quantity);
        if ($result) {
            // Chuyển hướng về trang danh sách sản phẩm kèm thông báo thành công
            header('Location: product_list.php?msg=added');
            exit;
        } else {
            $errors[] = 'Không thể thêm sản phẩm vào cơ sở dữ liệu. Vui lòng thử lại sau.';
        }
    }
}

// Gọi phần Header giao diện dùng chung
require_once __DIR__ . '/view/header.php';
?>

<div class="card" style="max-width: 650px; margin: 0 auto;">
    <div class="card-header-bar">
        <h2 class="card-title">➕ Thêm Sản Phẩm Mới</h2>
        <a href="product_list.php" class="btn btn-secondary btn-sm">
            ⬅️ Quay lại danh sách
        </a>
    </div>

    <!-- Hiển thị lỗi nếu có -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>Vui lòng kiểm tra lại thông tin:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form nhập thông tin sản phẩm -->
    <form action="product_add.php" method="POST" autocomplete="off">
        <div class="form-group">
            <label for="name">Tên sản phẩm <span class="required">*</span></label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   class="form-control" 
                   placeholder="Nhập tên sản phẩm (tối đa 100 ký tự)" 
                   maxlength="100" 
                   value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" 
                   required>
            <div class="form-help">Ví dụ: iPhone 15 Pro Max, Bàn phím cơ...</div>
        </div>

        <div class="form-group">
            <label for="price">Giá sản phẩm (VNĐ) <span class="required">*</span></label>
            <input type="number" 
                   id="price" 
                   name="price" 
                   class="form-control" 
                   placeholder="Nhập giá sản phẩm (> 0)" 
                   step="0.01" 
                   min="0.01" 
                   value="<?= htmlspecialchars($price, ENT_QUOTES, 'UTF-8') ?>" 
                   required>
            <div class="form-help">Giá phải lớn hơn 0 (có thể có phần thập phân).</div>
        </div>

        <div class="form-group">
            <label for="quantity">Số lượng <span class="required">*</span></label>
            <input type="number" 
                   id="quantity" 
                   name="quantity" 
                   class="form-control" 
                   placeholder="Nhập số lượng tồn kho (>= 0)" 
                   step="1" 
                   min="0" 
                   value="<?= htmlspecialchars($quantity, ENT_QUOTES, 'UTF-8') ?>" 
                   required>
            <div class="form-help">Số lượng phải là số nguyên không âm (>= 0).</div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                💾 Thêm sản phẩm
            </button>
            <a href="product_list.php" class="btn btn-secondary">
                ❌ Hủy bỏ
            </a>
        </div>
    </form>
</div>

<?php
// Gọi phần Footer giao diện dùng chung
require_once __DIR__ . '/view/footer.php';
?>
