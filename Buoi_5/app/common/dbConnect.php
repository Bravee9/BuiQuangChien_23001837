<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: common/dbConnect.php
 * Mục đích: Khởi tạo kết nối cơ sở dữ liệu MySQL sử dụng PDO.
 * Xử lý ngoại lệ an toàn, hỗ trợ UTF-8 (utf8mb4) và tái sử dụng kết nối.
 */

$dbHost = 'localhost';
$dbPort = '3306';
$dbName = 'shopping_cart';
$dbUser = 'root';
$dbPass = ''; // Mặc định trong XAMPP / Laragon
$dbCharset = 'utf8mb4';

/**
 * Hàm lấy đối tượng kết nối PDO (Singleton pattern)
 *
 * @return PDO Đối tượng kết nối PDO
 */
function getDbConnection() {
    global $dbHost, $dbPort, $dbName, $dbUser, $dbPass, $dbCharset;
    static $connection = null;

    if ($connection === null) {
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset={$dbCharset}";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $connection = new PDO($dsn, $dbUser, $dbPass, $options);
        } catch (PDOException $e) {
            // Không lộ mật khẩu hoặc cấu hình nhạy cảm ra màn hình
            error_log("Lỗi kết nối CSDL: " . $e->getMessage());
            die("
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #f87171; background: #fef2f2; border-radius: 8px; color: #991b1b;'>
                    <h2 style='margin-top: 0;'>⚠️ Lỗi kết nối Cơ sở dữ liệu!</h2>
                    <p>Không thể kết nối đến máy chủ MySQL hoặc CSDL <strong>shopping_cart</strong> chưa được tạo.</p>
                    <p>Vui lòng đảm bảo rằng MySQL Service đang chạy và đã import file <code>BuiQuangChien_23001837_ThucHanhBuoi5.sql</code>.</p>
                </div>
            ");
        }
    }

    return $connection;
}
