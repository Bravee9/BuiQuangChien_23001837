<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: common/auth.php
 * Mục đích: Quản lý session, kiểm tra trạng thái đăng nhập và kiểm soát quyền truy cập
 */

/**
 * Khởi động phiên làm việc (Session) an toàn
 */
function startAppSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Kiểm tra xem người dùng hiện tại đã đăng nhập hay chưa
 *
 * @return bool True nếu đã đăng nhập, ngược lại False
 */
function isLoggedIn() {
    startAppSession();
    return !empty($_SESSION['user_id']) && !empty($_SESSION['username']);
}

/**
 * Lấy tên người dùng hiện đang đăng nhập
 *
 * @return string|null
 */
function getLoggedUser() {
    startAppSession();
    return $_SESSION['username'] ?? null;
}

/**
 * Lấy ID của người dùng hiện đang đăng nhập
 *
 * @return int|null
 */
function getLoggedUserId() {
    startAppSession();
    return $_SESSION['user_id'] ?? null;
}

/**
 * Kiểm soát quyền truy cập: bắt buộc phải đăng nhập
 * Nếu chưa đăng nhập, tự động chuyển hướng về trang login.php
 */
function requireLogin() {
    startAppSession();
    if (!isLoggedIn()) {
        header('Location: login.php?msg=login_required');
        exit;
    }
}

/**
 * Lưu thông tin phiên đăng nhập cho người dùng
 *
 * @param array $user Mảng thông tin người dùng từ CSDL (id, username)
 */
function loginUser($user) {
    startAppSession();
    session_regenerate_id(true); // Phòng chống Session Fixation
    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['username'] = $user['username'];
}

/**
 * Đăng xuất và hủy bỏ toàn bộ phiên làm việc
 */
function logoutUser() {
    startAppSession();
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), 
            '', 
            time() - 42000,
            $params["path"], 
            $params["domain"],
            $params["secure"], 
            $params["httponly"]
        );
    }
    session_destroy();
}
