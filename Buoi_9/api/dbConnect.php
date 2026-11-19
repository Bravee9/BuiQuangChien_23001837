<?php
/**
 * STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
 * COURSE: [2026] MAT3542 1 - WEB APPLICATION DEVELOPMENT
 * LAB 9: PRODUCT IMAGE UPLOAD AND SERVER-SIDE PAGINATION
 * File: api/dbConnect.php
 * Purpose: Secure PDO database connection, schema verification, and shared JSON helpers
 */

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_NAME') ?: 'buoi9_vuejs';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$dbCharset = 'utf8mb4';

/**
 * Send standardized JSON response and terminate execution.
 */
function sendJsonResponse(array $payload, int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/**
 * Configure standard API CORS headers and handle preflight OPTIONS requests.
 */
function handleApiCors(string $allowedMethods = 'GET, POST, PUT, DELETE, OPTIONS'): void {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: {$allowedMethods}");
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

    if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
}

/**
 * Resolve absolute path to uploads directory and ensure it exists.
 */
function getUploadsDirectory(): string {
    $uploadDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0755, true);
    }
    return $uploadDir;
}

/**
 * Safely delete an image file stored inside the uploads directory.
 */
function removeUploadedImageFile(?string $relativePath): void {
    if ($relativePath === null || trim($relativePath) === '') {
        return;
    }

    $uploadDir = realpath(getUploadsDirectory());
    if ($uploadDir === false) {
        return;
    }

    $fileName = basename(str_replace('\\', '/', $relativePath));
    if ($fileName === '' || $fileName === '.' || $fileName === '..') {
        return;
    }

    $candidate = realpath($uploadDir . DIRECTORY_SEPARATOR . $fileName);
    if ($candidate !== false && strpos($candidate, $uploadDir . DIRECTORY_SEPARATOR) === 0 && is_file($candidate)) {
        @unlink($candidate);
    }
}

/**
 * Ensure `products` table exists with the `image` column, seeding only on initial table creation.
 */
function ensureProductsSchemaAndSeed(PDO $pdo): void {
    $tableStmt = $pdo->query("SHOW TABLES LIKE 'products'");
    $tableExists = $tableStmt->fetch() !== false;

    if (!$tableExists) {
        $pdo->exec("
            CREATE TABLE `products` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(100) NOT NULL,
                `price` INT NOT NULL,
                `stock` INT NOT NULL,
                `image` VARCHAR(255) NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Seed 12 sample products on initial creation only (so deleting all items allows empty state)
        $pdo->exec("
            INSERT INTO `products` (`name`, `price`, `stock`, `image`) VALUES
            ('Bút bi Thiên Long', 5000, 20, NULL),
            ('Vở ô ly 96 trang', 12000, 15, NULL),
            ('Thước kẻ nhựa 20cm', 8000, 0, NULL),
            ('Bút chì gỗ 2B', 4000, 50, NULL),
            ('Tẩy gôm học sinh', 6000, 32, NULL),
            ('Kéo văn phòng nhỏ', 25000, 14, NULL),
            ('Băng keo trong 5cm', 15000, 28, NULL),
            ('Giấy in A4 Double A', 85000, 12, NULL),
            ('Bìa hồ sơ lá nhựa', 18000, 40, NULL),
            ('Kẹp giấy kim loại hộp 100c', 11000, 0, NULL),
            ('Máy tính cầm tay Casio', 320000, 7, NULL),
            ('Bảng trắng mini 30x40cm', 95000, 9, NULL);
        ");
        return;
    }

    // Upgrade schema automatically if table existed from Session 8 without `image` column
    $colStmt = $pdo->query("SHOW COLUMNS FROM `products` LIKE 'image'");
    if ($colStmt->fetch() === false) {
        $pdo->exec("ALTER TABLE `products` ADD COLUMN `image` VARCHAR(255) NULL DEFAULT NULL");
    }
}

/**
 * Establish and return singleton PDO instance for MySQL.
 */
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
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset={$dbCharset}";
        $pdo = new PDO($dsn, $dbUser, $dbPass, $options);

        // Ensure table exists and has the `image` column (handles empty pre-created DBs or Session 8 DB upgrades)
        ensureProductsSchemaAndSeed($pdo);
    } catch (PDOException $e) {
        // Attempt creating database and schema if DB/table does not exist yet
        try {
            $serverDsn = "mysql:host={$dbHost};port={$dbPort};charset={$dbCharset}";
            $serverPdo = new PDO($serverDsn, $dbUser, $dbPass, $options);
            $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $serverPdo->exec("USE `{$dbName}`");

            ensureProductsSchemaAndSeed($serverPdo);
            $pdo = $serverPdo;
        } catch (PDOException $innerError) {
            sendJsonResponse([
                'success' => false,
                'message' => 'Lỗi kết nối cơ sở dữ liệu: ' . $innerError->getMessage(),
            ], 500);
        }
    }

    return $pdo;
}
