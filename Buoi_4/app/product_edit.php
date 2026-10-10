<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837
 * File: product_edit.php
 * Mục đích: Hiển thị thông tin hiện tại của sản phẩm và xử lý cập nhật dữ liệu.
 * Kiểm tra dữ liệu đầu vào nghiêm ngặt trước khi cập nhật vào CSDL.
 */

require_once __DIR__ . '/model/product.php';

$pageTitle = 'Cập nhật sản phẩm - Shopping Cart';

// 1. Lấy và kiểm tra ID từ GET hoặc POST
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);
$id = filter_var($id, FILTER_VALIDATE_INT);

if ($id === false || $id <= 0) {
    header('Location: product_list.php?msg=invalid_id');
    exit;
}

// 2. Lấy thông tin hiện tại của sản phẩm từ Database
$product = getProductById($id);

// Nếu không tìm thấy sản phẩm, thông báo phù hợp
if (!$product) {
    header('Location: product_list.php?msg=not_found');
    exit;
}

// Khởi tạo các giá trị ban đầu theo dữ liệu hiện tại
$name = $product['name'];
$price = $product['price'];
$quantity = $product['quantity'];
$errors = [];

// 3. Xử lý khi người dùng gửi form cập nhật (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';

    // Kiểm tra dữ liệu (Validation)
    // Tên sản phẩm không được rỗng, tối đa 100 ký tự
    if ($name === '') {
        $errors[] = 'Tên sản phẩm không được để trống.';
    } elseif (mb_strlen($name, 'UTF-8') > 100) {
        $errors[] = 'Tên sản phẩm không được vượt quá 100 ký tự.';
    }

    // Giá > 0
    if ($price === '') {
        $errors[] = 'Giá sản phẩm không được để trống.';
    } elseif (!is_numeric($price)) {
        $errors[] = 'Giá sản phẩm phải là một số hợp lệ.';
    } elseif ((float)$price <= 0) {
        $errors[] = 'Giá sản phẩm phải lớn hơn 0 (Giá > 0).';
    }

    // Số lượng >= 0
    if ($quantity === '') {
        $errors[] = 'Số lượng sản phẩm không được để trống.';
    } elseif (filter_var($quantity, FILTER_VALIDATE_INT) === false) {
        $errors[] = 'Số lượng sản phẩm phải là một số nguyên hợp lệ.';
    } elseif ((int)$quantity < 0) {
        $errors[] = 'Số lượng sản phẩm phải lớn hơn hoặc bằng 0 (Số lượng >= 0).';
    }

    // Cập nhật CSDL nếu dữ liệu hợp lệ
    if (empty($errors)) {
        $result = updateProduct($id, $name, (float)$price, (int)$quantity);
        if ($result) {
            header('Location: product_list.php?msg=updated');
            exit;
        } else {
            $errors[] = 'Cập nhật thất bại. Vui lòng kiểm tra lại kết nối hoặc dữ liệu.';
        }
    }
}

// Gọi phần Header giao diện dùng chung
require_once __DIR__ . '/view/header.php';
?>

<div class="card" style="max-width: 650px; margin: 0 auto;">
    <div class="card-header-bar">
        <h2 class="card-title">✏️ Chỉnh Sửa Sản Phẩm (ID: #<?= (int)$id ?>)</h2>
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

    <!-- Form cập nhật thông tin sản phẩm -->
    <form action="product_edit.php?id=<?= (int)$id ?>" method="POST" autocomplete="off">
        <input type="hidden" name="id" value="<?= (int)$id ?>">

        <div class="form-group">
            <label for="name">Tên sản phẩm <span class="required">*</span></label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   class="form-control" 
                   placeholder="Nhập tên sản phẩm" 
                   maxlength="100" 
                   value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" 
                   required>
            <div class="form-help">Tên sản phẩm tối đa 100 ký tự.</div>
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
            <div class="form-help">Giá phải lớn hơn 0.</div>
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
            <button type="submit" class="btn btn-warning">
                💾 Cập nhật sản phẩm
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
