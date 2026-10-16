<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: product_list.php
 * Mục đích: Danh sách sản phẩm trong giỏ hàng.
 * Kiểm soát quyền truy cập: bắt buộc phải đăng nhập mới xem được.
 * Hiển thị các cột: ID | Tên sản phẩm | Giá | Số lượng | Chức năng [Sửa] [Xóa]
 */

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/product.php';

// Kiểm soát truy cập: Nếu chưa đăng nhập thì tự động chuyển về login.php
requireLogin();

$pageTitle = 'Danh sách sản phẩm - Shopping Cart';

// Lấy danh sách sản phẩm từ Model
$products = getAllProducts();

// Xử lý thông báo từ URL (nếu có)
$msg = $_GET['msg'] ?? '';
$alertType = 'success';
$alertMessage = '';

switch ($msg) {
    case 'login_success':
        $alertMessage = '🎉 Chào mừng bạn đã đăng nhập thành công vào hệ thống!';
        break;
    case 'added':
        $alertMessage = '✅ Thêm sản phẩm mới thành công!';
        break;
    case 'updated':
        $alertMessage = '✅ Cập nhật thông tin sản phẩm thành công!';
        break;
    case 'deleted':
        $alertMessage = '✅ Đã xóa sản phẩm thành công khỏi hệ thống!';
        break;
    case 'not_found':
        $alertType = 'danger';
        $alertMessage = '⚠️ Sản phẩm không tồn tại hoặc đã bị xóa trước đó!';
        break;
    case 'delete_failed':
        $alertType = 'danger';
        $alertMessage = '❌ Không thể xóa sản phẩm do có lỗi xảy ra!';
        break;
    case 'invalid_id':
        $alertType = 'warning';
        $alertMessage = '⚠️ Mã sản phẩm (ID) không hợp lệ!';
        break;
}

require_once __DIR__ . '/view/header.php';
?>

<div class="card">
    <div class="card-header-bar">
        <div>
            <h2 class="card-title">📦 Quản Lý Danh Sách Sản Phẩm</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">
                Tổng số mặt hàng hiện có: <strong><?= count($products) ?></strong> sản phẩm
            </p>
        </div>
        <div>
            <a href="product_add.php" class="btn btn-primary">
                ➕ Thêm sản phẩm mới
            </a>
        </div>
    </div>

    <!-- Thông báo trạng thái thao tác -->
    <?php if (!empty($alertMessage)): ?>
        <div class="alert alert-<?= $alertType ?>">
            <?= htmlspecialchars($alertMessage, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <!-- Bảng hiển thị danh sách sản phẩm -->
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 80px;" class="text-center">ID</th>
                    <th>Tên sản phẩm</th>
                    <th style="width: 180px;" class="text-right">Giá</th>
                    <th style="width: 140px;" class="text-center">Số lượng</th>
                    <th style="width: 180px;" class="text-center">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 40px; color: var(--text-muted);">
                            📭 Hiện chưa có sản phẩm nào trong giỏ hàng.<br>
                            Hãy nhấn nút <strong>"Thêm sản phẩm mới"</strong> ở trên để tạo sản phẩm đầu tiên!
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td class="text-center font-bold">#<?= (int)$p['id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></strong>
                            </td>
                            <td class="text-right price-text">
                                <?= number_format((float)$p['price'], 0, ',', '.') ?> VNĐ
                            </td>
                            <td class="text-center">
                                <?php 
                                $qty = (int)$p['quantity'];
                                $badgeClass = 'in-stock';
                                if ($qty === 0) {
                                    $badgeClass = 'out-stock';
                                } elseif ($qty < 10) {
                                    $badgeClass = 'low-stock';
                                }
                                ?>
                                <span class="quantity-badge <?= $badgeClass ?>">
                                    <?= $qty ?> cái
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons" style="justify-content: center;">
                                    <a href="product_edit.php?id=<?= (int)$p['id'] ?>" class="btn btn-warning btn-sm" title="Sửa sản phẩm">
                                        ✏️ Sửa
                                    </a>
                                    <a href="product_delete.php?id=<?= (int)$p['id'] ?>" class="btn btn-danger btn-sm" title="Xóa sản phẩm">
                                        🗑️ Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/view/footer.php';
?>
