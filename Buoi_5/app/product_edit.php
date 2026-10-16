<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: product_edit.php
 * Mục đích: Hiển thị thông tin hiện tại của sản phẩm và cập nhật dữ liệu.
 * Kiểm soát truy cập: Bắt buộc đăng nhập.
 * Kiểm tra dữ liệu trước khi cập nhật.
 */

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/product.php';

// Kiểm soát truy cập: Bắt buộc đăng nhập
requireLogin();

$pageTitle = 'Cập nhật sản phẩm - Shopping Cart';

// 1. Lấy và kiểm tra ID từ GET hoặc POST
$id = $_GET['id'] ?? ($_POST['id'] ?? null);
$id = filter_var($id, FILTER_VALIDATE_INT);

if ($id === false || $id <= 0) {
    header('Location: product_list.php?msg=invalid_id');
    exit;
}

// 2. Lấy thông tin hiện tại của sản phẩm
$product = getProductById($id);
if (!$product) {
    header('Location: product_list.php?msg=not_found');
    exit;
}

$name = $product['name'];
$price = $product['price'];
$quantity = $product['quantity'];
$errors = [];

// 3. Xử lý cập nhật khi người dùng gửi form (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');

    // Kiểm tra tên không được rỗng
    if ($name === '') {
        $errors[] = 'Tên sản phẩm không được để trống.';
    } elseif (mb_strlen($name, 'UTF-8') > 100) {
        $errors[] = 'Tên sản phẩm không được vượt quá 100 ký tự.';
    }

    // Kiểm tra giá > 0
    if ($price === '') {
        $errors[] = 'Giá sản phẩm không được để trống.';
    } elseif (!is_numeric($price)) {
        $errors[] = 'Giá sản phẩm phải là một số hợp lệ.';
    } elseif ((float)$price <= 0) {
        $errors[] = 'Giá sản phẩm phải lớn hơn 0 (Giá > 0).';
    }

    // Kiểm tra số lượng >= 0
    if ($quantity === '') {
        $errors[] = 'Số lượng sản phẩm không được để trống.';
    } elseif (filter_var($quantity, FILTER_VALIDATE_INT) === false) {
        $errors[] = 'Số lượng sản phẩm phải là một số nguyên hợp lệ.';
    } elseif ((int)$quantity < 0) {
        $errors[] = 'Số lượng sản phẩm phải lớn hơn hoặc bằng 0 (Số lượng >= 0).';
    }

    // Nếu dữ liệu hợp lệ -> thực hiện cập nhật
    if (empty($errors)) {
        $updated = updateProduct($id, $name, (float)$price, (int)$quantity);
        if ($updated) {
            header('Location: product_list.php?msg=updated');
            exit;
        } else {
            $errors[] = 'Không thể cập nhật sản phẩm vào CSDL. Vui lòng thử lại sau.';
        }
    }
}

require_once __DIR__ . '/view/header.php';
?>

<div class="card" style="max-width: 650px; margin: 0 auto;">
    <div class="card-header-bar">
        <div>
            <h2 class="card-title">✏️ Cập Nhật Sản Phẩm #<?= (int)$id ?></h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 4px;">
                Chỉnh sửa thông tin tên, đơn giá và số lượng tồn kho
            </p>
        </div>
        <a href="product_list.php" class="btn btn-secondary btn-sm">
            ⬅️ Quay lại danh sách
        </a>
    </div>

    <!-- Hiển thị danh sách lỗi (nếu có) -->
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
require_once __DIR__ . '/view/footer.php';
?>
