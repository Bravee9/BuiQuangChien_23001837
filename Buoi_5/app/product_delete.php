<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: product_delete.php
 * Mục đích: Xử lý xóa sản phẩm theo ID.
 * Kiểm soát truy cập: Bắt buộc đăng nhập.
 * Trước khi xóa phải xác nhận. Nếu sản phẩm không tồn tại, hiển thị thông báo phù hợp.
 */

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/product.php';

// Kiểm soát truy cập: Bắt buộc đăng nhập
requireLogin();

$pageTitle = 'Xác nhận xóa sản phẩm - Shopping Cart';

// 1. Lấy ID từ GET hoặc POST
$id = $_GET['id'] ?? ($_POST['id'] ?? null);
$id = filter_var($id, FILTER_VALIDATE_INT);

// Trường hợp ID không hợp lệ
if ($id === false || $id <= 0) {
    header('Location: product_list.php?msg=invalid_id');
    exit;
}

// 2. Kiểm tra xem sản phẩm có tồn tại trong CSDL hay không
$product = getProductById($id);

// Nếu sản phẩm không tồn tại, hiển thị thông báo phù hợp theo yêu cầu đề bài
if (!$product) {
    require_once __DIR__ . '/view/header.php';
    ?>
    <div class="card" style="max-width: 600px; margin: 40px auto; text-align: center;">
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            <h3 style="margin-bottom: 8px;">⚠️ Sản phẩm không tồn tại!</h3>
            <p>Sản phẩm có mã định danh <strong>#<?= (int)$id ?></strong> không tồn tại trong hệ thống hoặc đã bị xóa trước đó.</p>
        </div>
        <a href="product_list.php" class="btn btn-primary">
            ⬅️ Quay lại danh sách sản phẩm
        </a>
    </div>
    <?php
    require_once __DIR__ . '/view/footer.php';
    exit;
}

// 3. Xử lý xóa khi đã có xác nhận (thực hiện qua phương thức POST để bảo mật)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $deleted = deleteProduct($id);
    if ($deleted) {
        header('Location: product_list.php?msg=deleted');
        exit;
    } else {
        header('Location: product_list.php?msg=delete_failed');
        exit;
    }
}

// 4. Nếu chưa gửi POST xác nhận, hiển thị giao diện xác nhận trước khi xóa
require_once __DIR__ . '/view/header.php';
?>

<div class="card delete-confirm-box">
    <h3>⚠️ XÁC NHẬN XÓA SẢN PHẨM</h3>
    <p>Hành động này sẽ xóa vĩnh viễn sản phẩm khỏi hệ thống và không thể hoàn tác.</p>
    <p>Bạn có chắc chắn muốn xóa sản phẩm sau?</p>

    <!-- Thẻ tóm tắt thông tin sản phẩm chuẩn bị xóa -->
    <div class="product-summary-card">
        <div class="product-summary-item">
            <strong>Mã sản phẩm (ID):</strong>
            <span>#<?= (int)$product['id'] ?></span>
        </div>
        <div class="product-summary-item">
            <strong>Tên sản phẩm:</strong>
            <span style="color: #dc2626; font-weight: bold;"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <div class="product-summary-item">
            <strong>Đơn giá:</strong>
            <span><?= number_format((float)$product['price'], 0, ',', '.') ?> VNĐ</span>
        </div>
        <div class="product-summary-item">
            <strong>Số lượng tồn kho:</strong>
            <span><?= (int)$product['quantity'] ?> cái</span>
        </div>
    </div>

    <!-- Form gửi lệnh POST xác nhận xóa -->
    <form action="product_delete.php" method="POST">
        <input type="hidden" name="id" value="<?= (int)$product['id'] ?>">
        <input type="hidden" name="confirm" value="yes">
        
        <div class="form-actions" style="justify-content: center;">
            <button type="submit" class="btn btn-danger">
                🗑️ Đồng ý xóa vĩnh viễn
            </button>
            <a href="product_list.php" class="btn btn-secondary">
                ❌ Hủy bỏ / Quay lại
            </a>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/view/footer.php';
?>
