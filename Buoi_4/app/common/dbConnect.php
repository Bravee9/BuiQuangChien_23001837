<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837
 * File: common/dbConnect.php
 * Mục đích: Khởi tạo kết nối cơ sở dữ liệu MySQL sử dụng PDO.
 * Xử lý ngoại lệ an toàn, chống lộ thông tin nhạy cảm.
 */

// Cấu hình thông số kết nối CSDL MySQL
$dbHost = 'localhost';
$dbPort = '3306';
$dbName = 'shopping_cart';
$dbUser = 'root';
$dbPass = ''; // Mặc định trong XAMPP / Laragon là rỗng
$dbCharset = 'utf8mb4';

/**
 * Hàm lấy đối tượng kết nối PDO
 * Sử dụng pattern singleton/cached connection để tránh tạo nhiều kết nối không cần thiết
 *
 * @return PDO
 */
function getDbConnection() {
    global $dbHost, $dbPort, $dbName, $dbUser, $dbPass, $dbCharset;
    static $connection = null;

    if ($connection === null) {
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset={$dbCharset}";
        
        $options = [
            // Bật chế độ ném ngoại lệ khi có lỗi SQL
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            // Trả về dữ liệu dạng mảng kết hợp (key là tên cột)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Sử dụng cơ chế Native Prepared Statements thực sự của MySQL (chống SQL Injection triệt để)
            PDO::ATTR_EMULATE_PREPARES   => false,
            // Thiết lập timeout kết nối
            PDO::ATTR_TIMEOUT            => 5,
        ];

        try {
            $connection = new PDO($dsn, $dbUser, $dbPass, $options);
        } catch (PDOException $e) {
            // Ghi log chi tiết lỗi cho quản trị viên xem trong file log hệ thống
            error_log('Database Connection Error: ' . $e->getMessage());

            // Không hiển thị lỗi chi tiết hay mật khẩu ra giao diện người dùng (Bảo mật thông tin)
            echo '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #f5c6cb; background-color: #f8d7da; color: #721c24; border-radius: 6px;">';
            echo '<h3 style="margin-top:0;">⚠️ Lỗi kết nối cơ sở dữ liệu!</h3>';
            echo '<p>Hệ thống không thể kết nối tới cơ sở dữ liệu MySQL. Vui lòng kiểm tra lại:</p>';
            echo '<ul>';
            echo '<li>Dịch vụ MySQL đã được khởi động chưa (XAMPP / Laragon)?</li>';
            echo '<li>Cơ sở dữ liệu <code>shopping_cart</code> đã được tạo chưa?</li>';
            echo '<li>Thông tin tài khoản kết nối trong <code>common/dbConnect.php</code> có chính xác không?</li>';
            echo '</ul>';
            echo '<p style="margin-bottom:0;"><small>Gợi ý: Import file <code>BuiQuangChien_23001837_ThucHanhBuoi4.sql</code> vào MySQL trước khi chạy ứng dụng.</small></p>';
            echo '</div>';
            exit;
        }
    }

    return $connection;
}

// Khởi tạo sẵn biến $conn để các file khác có thể trực tiếp sử dụng
$conn = getDbConnection();
?>
