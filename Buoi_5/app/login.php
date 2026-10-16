<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: login.php
 * Mục đích: Form và xử lý đăng nhập hệ thống quản lý sản phẩm.
 * Sử dụng password_verify() để kiểm tra mật khẩu đã băm trong database.
 */

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/user.php';

// Nếu người dùng đã đăng nhập rồi, tự động chuyển đến trang danh sách sản phẩm
if (isLoggedIn()) {
    header('Location: product_list.php');
    exit;
}

$pageTitle = 'Đăng nhập - Hệ thống Quản lý Giỏ hàng';
$username = '';
$error = '';

// Lấy thông báo từ URL (nếu có)
$msg = $_GET['msg'] ?? '';
$infoMessage = '';
$alertType = 'info';

switch ($msg) {
    case 'login_required':
        $infoMessage = '⚠️ Bạn cần đăng nhập để truy cập trang quản lý sản phẩm!';
        $alertType = 'warning';
        break;
    case 'logged_out':
        $infoMessage = '✅ Bạn đã đăng xuất thành công khỏi hệ thống!';
        $alertType = 'success';
        break;
    case 'register_success':
        $infoMessage = '🎉 Đăng ký tài khoản thành công! Vui lòng đăng nhập.';
        $alertType = 'success';
        break;
}

// Xử lý gửi form đăng nhập (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Kiểm tra các trường không được để trống
    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập đầy đủ Tên đăng nhập và Mật khẩu!';
    } else {
        // Kiểm tra thông tin đăng nhập với dữ liệu trong bảng users
        $user = authenticateUser($username, $password);
        if ($user) {
            // Đăng nhập thành công -> lưu session và chuyển hướng tới product_list.php
            loginUser($user);
            header('Location: product_list.php?msg=login_success');
            exit;
        } else {
            // Thông tin không chính xác -> hiển thị thông báo lỗi phù hợp
            $error = 'Tên đăng nhập hoặc mật khẩu không chính xác. Vui lòng thử lại!';
        }
    }
}

require_once __DIR__ . '/view/header.php';
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">🔐</div>
            <h2 class="auth-title">Đăng Nhập</h2>
            <p class="auth-subtitle">Hệ thống Quản lý Giỏ hàng & Sản phẩm</p>
        </div>

        <!-- Thông báo điều hướng -->
        <?php if (!empty($infoMessage)): ?>
            <div class="alert alert-<?= $alertType ?>">
                <?= htmlspecialchars($infoMessage, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <!-- Thông báo lỗi khi đăng nhập sai -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="username">Tên đăng nhập <span class="required">*</span></label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       class="form-control" 
                       placeholder="Nhập tên đăng nhập của bạn" 
                       value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" 
                       required 
                       autofocus>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu <span class="required">*</span></label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control" 
                       placeholder="Nhập mật khẩu" 
                       required>
            </div>

            <div class="form-actions" style="margin-top: 25px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    🚀 Đăng nhập
                </button>
            </div>
        </form>

        <div class="auth-switch">
            Chưa có tài khoản? <a href="register.php">Đăng ký ngay tại đây</a>
        </div>

        <div class="sample-accounts-box">
            <h4>💡 Tài khoản mẫu sẵn có trong CSDL:</h4>
            <ul>
                <li>👤 Admin: <code>admin</code> / Mật khẩu: <code>admin123</code></li>
                <li>👤 User: <code>chienbq</code> / Mật khẩu: <code>123456</code></li>
            </ul>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/view/footer.php';
?>
