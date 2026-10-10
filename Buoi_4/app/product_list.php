<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837
 * File: product_list.php
 * Mục đích: Hiển thị danh sách tất cả các sản phẩm trong giỏ hàng.
 * Cung cấp liên kết [Sửa] và [Xóa] với xác nhận an toàn.
 */

require_once __DIR__ . '/model/product.php';

$pageTitle = 'Danh sách sản phẩm - Shopping Cart';

// Lấy danh sách sản phẩm từ CSDL qua Model
$products = getAllProducts();

// Xử lý thông báo phản hồi thao tác từ URL (nếu có)
$msg = isset($_GET['msg']) ? trim($_GET['msg']) : '';
$alertType = 'success';
$alertMessage = '';

switch ($msg) {
    case 'added':
        $alertMessage = '✅ Thêm sản phẩm mới thành công!';
        break;
    case 'updated':
        $alertMessage = '✅ Cập nhật thông tin sản phẩm thành công!';
        break;
    case 'deleted':
        $alertMessage = '✅ Đã xóa sản phẩm thành công!';
        break;
    case 'not_found':
        $alertType = 'danger';
        $alertMessage = '⚠️ Sản phẩm không tồn tại hoặc đã bị xóa trước đó!';
        break;
    case 'delete_failed':
        $alertType = 'danger';
        $alertMessage = '❌ Xóa sản phẩm thất bại. Vui lòng thử lại!';
        break;
    case 'invalid_id':
        $alertType = 'danger';
        $alertMessage = '⚠️ Mã ID sản phẩm không hợp lệ!';
        break;
}

// Gọi phần Header giao diện dùng chung
require_once __DIR__ . '/view/header.php';
?>

<div class="card">
    <div class="card-header-bar">
        <h2 class="card-title">📦 Danh Sách Sản Phẩm</h2>
        <a href="product_add.php" class="btn btn-success">
            ➕ Thêm sản phẩm mới
        </a>
    </div>

    <?php if (!empty($alertMessage)): ?>
        <div class="alert alert-<?= $alertType ?>">
            <?= htmlspecialchars($alertMessage, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($products)): ?>
        <div class="alert alert-warning text-center">
            <p>Hiện tại chưa có sản phẩm nào trong cơ sở dữ liệu.</p>
            <p style="margin-top: 10px;">
                <a href="product_add.php" class="btn btn-primary btn-sm">➕ Bấm vào đây để thêm sản phẩm đầu tiên</a>
            </p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="product-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">ID</th>
                        <th>Tên sản phẩm</th>
                        <th class="text-right" style="width: 180px;">Giá (VNĐ)</th>
                        <th class="text-center" style="width: 130px;">Số lượng</th>
                        <th class="text-center" style="width: 180px;">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="text-center font-bold">
                                #<?= (int)$product['id'] ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></strong>
                            </td>
                            <td class="text-right price-text">
                                <?= number_format((float)$product['price'], 0, ',', '.') ?> đ
                            </td>
                            <td class="text-center">
                                <?php if ((int)$product['quantity'] > 0): ?>
                                    <span class="badge badge-in-stock">
                                        <?= (int)$product['quantity'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-out-stock">
                                        Hết hàng (0)
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="actions-group">
                                    <a href="product_edit.php?id=<?= (int)$product['id'] ?>" class="btn btn-warning btn-sm">
                                        ✏️ Sửa
                                    </a>
                                    <!-- Xác nhận trước khi xóa bằng hộp thoại JavaScript -->
                                    <a href="product_delete.php?id=<?= (int)$product['id'] ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm \'<?= htmlspecialchars(addslashes($product['name']), ENT_QUOTES, 'UTF-8') ?>\' (ID: <?= (int)$product['id'] ?>) không?');">
                                        🗑️ Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px; color: var(--text-muted); font-size: 0.875rem;">
            <em>Tổng cộng: <strong><?= count($products) ?></strong> sản phẩm trong hệ thống.</em>
        </div>
    <?php endif; ?>
</div>

<?php
// Gọi phần Footer giao diện dùng chung
require_once __DIR__ . '/view/footer.php';
?>
