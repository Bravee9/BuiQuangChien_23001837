<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: register.php
 * Mục đích: Form và xử lý đăng ký tài khoản người dùng mới.
 * Kiểm tra dữ liệu, kiểm tra tên trùng và mã hóa mật khẩu bằng password_hash().
 */

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/user.php';

// Nếu người dùng đã đăng nhập rồi, tự động chuyển đến trang danh sách sản phẩm
if (isLoggedIn()) {
    header('Location: product_list.php');
    exit;
}

$pageTitle = 'Đăng ký tài khoản - Hệ thống Quản lý Giỏ hàng';
$username = '';
$errors = [];

// Xử lý gửi form đăng ký (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // 1. Kiểm tra các trường không được để trống
    if ($username === '') {
        $errors[] = 'Tên đăng nhập không được để trống.';
    } elseif (mb_strlen($username, 'UTF-8') < 3 || mb_strlen($username, 'UTF-8') > 50) {
        $errors[] = 'Tên đăng nhập phải có độ dài từ 3 đến 50 ký tự.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors[] = 'Tên đăng nhập chỉ được chứa chữ cái, số và dấu gạch dưới (_).';
    }

    if ($password === '') {
        $errors[] = 'Mật khẩu không được để trống.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Mật khẩu phải có độ dài tối thiểu từ 6 ký tự trở lên.';
    }

    if ($confirmPassword === '') {
        $errors[] = 'Vui lòng xác nhận lại mật khẩu.';
    } elseif ($password !== $confirmPassword) {
        $errors[] = 'Mật khẩu xác nhận không khớp với mật khẩu đã nhập.';
    }

    // 2. Kiểm tra tên đăng nhập chưa tồn tại trong database
    if (empty($errors)) {
        if (checkUsernameExists($username)) {
            $errors[] = "Tên đăng nhập '{$username}' đã tồn tại trong hệ thống. Vui lòng chọn tên khác!";
        }
    }

    // 3. Nếu hợp lệ, lưu vào database bằng password_hash()
    if (empty($errors)) {
        $created = registerUser($username, $password);
        if ($created) {
            // Thông báo kết quả đăng ký thành công và chuyển đến trang đăng nhập
            header('Location: login.php?msg=register_success');
            exit;
        } else {
            $errors[] = 'Có lỗi xảy ra trong quá trình tạo tài khoản. Vui lòng thử lại sau!';
        }
    }
}

require_once __DIR__ . '/view/header.php';
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">📝</div>
            <h2 class="auth-title">Đăng Ký Tài Khoản</h2>
            <p class="auth-subtitle">Tạo tài khoản mới để truy cập hệ thống quản lý</p>
        </div>

        <!-- Hiển thị danh sách lỗi (nếu có) -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Vui lòng kiểm tra lại:</strong>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="username">Tên đăng nhập <span class="required">*</span></label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       class="form-control" 
                       placeholder="Ví dụ: nguyenvana (3 - 50 ký tự)" 
                       maxlength="50" 
                       value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" 
                       required 
                       autofocus>
                <div class="form-help">Chữ cái, số hoặc dấu gạch dưới, không chứa khoảng trắng.</div>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu <span class="required">*</span></label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control" 
                       placeholder="Tối thiểu 6 ký tự" 
                       required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu <span class="required">*</span></label>
                <input type="password" 
                       id="confirm_password" 
                       name="confirm_password" 
                       class="form-control" 
                       placeholder="Nhập lại mật khẩu ở trên" 
                       required>
            </div>

            <div class="form-actions" style="margin-top: 25px;">
                <button type="submit" class="btn btn-success" style="width: 100%; justify-content: center;">
                    ✨ Hoàn tất đăng ký
                </button>
            </div>
        </form>

        <div class="auth-switch">
            Đã có tài khoản? <a href="login.php">Đăng nhập tại đây</a>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/view/footer.php';
?>
