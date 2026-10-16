<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: model/user.php
 * Mục đích: Tầng Model quản lý người dùng (Users), mã hóa mật khẩu và xác thực
 */

require_once __DIR__ . '/../common/dbConnect.php';

/**
 * Tìm người dùng theo tên đăng nhập (username)
 *
 * @param string $username Tên đăng nhập
 * @return array|null Trả về mảng thông tin người dùng nếu tìm thấy, ngược lại null
 */
function getUserByUsername($username) {
    $conn = getDbConnection();
    try {
        $sql = "SELECT id, username, password FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', trim($username), PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user ? $user : null;
    } catch (PDOException $e) {
        error_log("Lỗi getUserByUsername(): " . $e->getMessage());
        return null;
    }
}

/**
 * Kiểm tra xem tên đăng nhập đã tồn tại trong CSDL hay chưa
 *
 * @param string $username Tên đăng nhập cần kiểm tra
 * @return bool True nếu đã tồn tại, False nếu chưa
 */
function checkUsernameExists($username) {
    $conn = getDbConnection();
    try {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', trim($username), PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log("Lỗi checkUsernameExists(): " . $e->getMessage());
        return false;
    }
}

/**
 * Đăng ký tài khoản người dùng mới
 * Mật khẩu được mã hóa an toàn bằng password_hash() (Bcrypt) trước khi lưu
 *
 * @param string $username Tên đăng nhập
 * @param string $plainPassword Mật khẩu văn bản thuần
 * @return bool True nếu đăng ký thành công, ngược lại False
 */
function registerUser($username, $plainPassword) {
    $conn = getDbConnection();
    try {
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', trim($username), PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Lỗi registerUser(): " . $e->getMessage());
        return false;
    }
}

/**
 * Xác thực thông tin đăng nhập của người dùng
 * Sử dụng password_verify() để kiểm tra mật khẩu đã băm
 *
 * @param string $username Tên đăng nhập
 * @param string $plainPassword Mật khẩu do người dùng nhập vào
 * @return array|false Trả về mảng thông tin user nếu xác thực thành công, ngược lại False
 */
function authenticateUser($username, $plainPassword) {
    $user = getUserByUsername($username);
    if (!$user) {
        return false;
    }

    if (password_verify($plainPassword, $user['password'])) {
        return $user;
    }

    return false;
}
