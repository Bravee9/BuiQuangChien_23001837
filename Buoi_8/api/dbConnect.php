<?php
/**
 * STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
 * COURSE: [2026] MAT3542 1 - WEB APPLICATION DEVELOPMENT
 * LAB 8: PHP REST API AND VUE.JS
 * File: api/dbConnect.php
 * Purpose: Secure PDO database connection with automatic table check
 */

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_NAME') ?: 'buoi8_vuejs';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$dbCharset = 'utf8mb4';

function getPdoConnection(): PDO {
    global $dbHost, $dbPort, $dbName, $dbUser, $dbPass, $dbCharset;
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_TIMEOUT            => 5,
    ];

    try {
        // First try connecting to the target database directly
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset={$dbCharset}";
        $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
    } catch (PDOException $e) {
        // If database does not exist, connect to server and create database + table
        try {
            $serverDsn = "mysql:host={$dbHost};port={$dbPort};charset={$dbCharset}";
            $serverPdo = new PDO($serverDsn, $dbUser, $dbPass, $options);
            $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $serverPdo->exec("USE `{$dbName}`");

            $serverPdo->exec("
                CREATE TABLE IF NOT EXISTS `products` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(100) NOT NULL,
                    `price` INT NOT NULL,
                    `stock` INT NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");

            // Check if table is empty, insert initial required sample records
            $countStmt = $serverPdo->query("SELECT COUNT(*) AS total FROM `products`");
            $total = (int)$countStmt->fetchColumn();
            if ($total === 0) {
                $serverPdo->exec("
                    INSERT INTO `products` (`name`, `price`, `stock`) VALUES
                    ('Bút bi', 5000, 20),
                    ('Vở ô ly', 12000, 15),
                    ('Thước kẻ', 8000, 0);
                ");
            }

            $pdo = $serverPdo;
        } catch (PDOException $innerError) {
            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi kết nối cơ sở dữ liệu: ' . $innerError->getMessage()
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    return $pdo;
}
