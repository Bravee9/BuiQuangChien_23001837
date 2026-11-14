<?php
/**
 * STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
 * COURSE: [2026] MAT3542 1 - WEB APPLICATION DEVELOPMENT
 * LAB 8: PHP REST API AND VUE.JS
 * File: api/products.php
 * Purpose: Full RESTful API for products management (GET, POST, PUT, DELETE)
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/dbConnect.php';
$pdo = getPdoConnection();

// Determine HTTP Method (support method override if needed)
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
} elseif (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
    $method = strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
}

/**
 * Validate product payload
 * - name: trimmed, 1 to 100 characters
 * - price: integer > 0
 * - stock: integer >= 0
 *
 * @param array $data
 * @return array [bool $isValid, string $errorMessage, array $sanitizedData]
 */
function validateProductData($data): array {
    if (!is_array($data)) {
        return [false, 'Dữ liệu yêu cầu phải là định dạng JSON hợp lệ.', []];
    }

    // 1. Kiểm tra trường name
    if (!isset($data['name'])) {
        return [false, 'Vui lòng nhập tên sản phẩm.', []];
    }
    $name = trim((string)$data['name']);
    $nameLength = mb_strlen($name, 'UTF-8');
    if ($nameLength < 1 || $nameLength > 100) {
        return [false, 'Tên sản phẩm sau khi bỏ khoảng trắng hai đầu phải có từ 1 đến 100 ký tự.', []];
    }

    // 2. Kiểm tra trường price (số nguyên lớn hơn 0)
    if (!isset($data['price']) || $data['price'] === '' || $data['price'] === null) {
        return [false, 'Vui lòng nhập đơn giá sản phẩm.', []];
    }
    $rawPrice = $data['price'];
    if (!is_numeric($rawPrice) || is_float($rawPrice) || (is_string($rawPrice) && strpos($rawPrice, '.') !== false)) {
        return [false, 'Đơn giá phải là số nguyên lớn hơn 0 (không chấp nhận số thập phân hoặc ký tự lạ).', []];
    }
    $price = (int)$rawPrice;
    if ($price <= 0 || (float)$rawPrice != $price) {
        return [false, 'Đơn giá phải là số nguyên lớn hơn 0.', []];
    }

    // 3. Kiểm tra trường stock (số nguyên không âm: >= 0)
    if (!isset($data['stock']) || $data['stock'] === '' || $data['stock'] === null) {
        return [false, 'Vui lòng nhập số lượng tồn kho.', []];
    }
    $rawStock = $data['stock'];
    if (!is_numeric($rawStock) || is_float($rawStock) || (is_string($rawStock) && strpos($rawStock, '.') !== false)) {
        return [false, 'Số lượng tồn kho phải là số nguyên không âm (không chấp nhận số thập phân hoặc ký tự lạ).', []];
    }
    $stock = (int)$rawStock;
    if ($stock < 0 || (float)$rawStock != $stock) {
        return [false, 'Số lượng tồn kho phải là số nguyên không âm (lớn hơn hoặc bằng 0).', []];
    }

    return [true, '', [
        'name'  => $name,
        'price' => $price,
        'stock' => $stock
    ]];
}

// Router for REST API Methods
switch ($method) {
    // =========================================================================
    // GET: Trả về danh sách sản phẩm
    // =========================================================================
    case 'GET':
        try {
            $stmt = $pdo->query("SELECT id, name, price, stock FROM products ORDER BY id ASC");
            $products = $stmt->fetchAll();

            // Cast columns to proper primitive types
            $formatted = array_map(function($item) {
                return [
                    'id'    => (int)$item['id'],
                    'name'  => (string)$item['name'],
                    'price' => (int)$item['price'],
                    'stock' => (int)$item['stock'],
                ];
            }, $products);

            echo json_encode([
                'success' => true,
                'data'    => $formatted
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi truy vấn cơ sở dữ liệu: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        break;

    // =========================================================================
    // POST: Thêm sản phẩm mới
    // =========================================================================
    case 'POST':
        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true);
        if (!is_array($payload)) {
            $payload = $_POST;
        }

        [$isValid, $errorMsg, $validData] = validateProductData($payload);
        if (!$isValid) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $errorMsg
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)");
            $stmt->execute([
                ':name'  => $validData['name'],
                ':price' => $validData['price'],
                ':stock' => $validData['stock'],
            ]);

            $newId = (int)$pdo->lastInsertId();

            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Thêm sản phẩm thành công.',
                'data'    => [
                    'id'    => $newId,
                    'name'  => $validData['name'],
                    'price' => $validData['price'],
                    'stock' => $validData['stock'],
                ]
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Không thể thêm sản phẩm: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        break;

    // =========================================================================
    // PUT: Cập nhật sản phẩm theo id trên URL (?id=...)
    // =========================================================================
    case 'PUT':
        $rawId = $_GET['id'] ?? null;
        if ($rawId === null || !is_numeric($rawId) || (int)$rawId <= 0 || (int)$rawId != (float)$rawId) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Mã sản phẩm (id) trên URL không hợp lệ.'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $id = (int)$rawId;

        // Check product existence before updating
        try {
            $checkStmt = $pdo->prepare("SELECT id FROM products WHERE id = :id");
            $checkStmt->execute([':id' => $id]);
            if (!$checkStmt->fetch()) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => "Không tìm thấy sản phẩm với id = {$id}."
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi kiểm tra sản phẩm: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true);

        [$isValid, $errorMsg, $validData] = validateProductData($payload);
        if (!$isValid) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $errorMsg
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        try {
            $updateStmt = $pdo->prepare("UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id");
            $updateStmt->execute([
                ':name'  => $validData['name'],
                ':price' => $validData['price'],
                ':stock' => $validData['stock'],
                ':id'    => $id,
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công.',
                'data'    => [
                    'id'    => $id,
                    'name'  => $validData['name'],
                    'price' => $validData['price'],
                    'stock' => $validData['stock'],
                ]
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Không thể cập nhật sản phẩm: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        break;

    // =========================================================================
    // DELETE: Xóa sản phẩm theo id trên URL (?id=...)
    // =========================================================================
    case 'DELETE':
        $rawId = $_GET['id'] ?? null;
        if ($rawId === null || !is_numeric($rawId) || (int)$rawId <= 0 || (int)$rawId != (float)$rawId) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Mã sản phẩm (id) trên URL không hợp lệ.'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $id = (int)$rawId;

        // Check product existence before deleting
        try {
            $checkStmt = $pdo->prepare("SELECT id, name FROM products WHERE id = :id");
            $checkStmt->execute([':id' => $id]);
            $existing = $checkStmt->fetch();
            if (!$existing) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => "Không tìm thấy sản phẩm với id = {$id} để xóa."
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $delStmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
            $delStmt->execute([':id' => $id]);

            echo json_encode([
                'success' => true,
                'message' => "Đã xóa sản phẩm \"{$existing['name']}\" thành công.",
                'data'    => ['id' => $id]
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Không thể xóa sản phẩm: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        break;

    // =========================================================================
    // Default: Phương thức không được hỗ trợ
    // =========================================================================
    default:
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => "Phương thức HTTP '{$method}' không được hỗ trợ."
        ], JSON_UNESCAPED_UNICODE);
        break;
}
