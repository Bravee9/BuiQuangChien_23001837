<?php
/**
 * STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
 * COURSE: [2026] MAT3542 1 - WEB APPLICATION DEVELOPMENT
 * LAB 9: PRODUCT IMAGE UPLOAD AND SERVER-SIDE PAGINATION
 * File: api/products.php
 * Purpose: RESTful API for products with server-side pagination (GET, POST, PUT, DELETE)
 */

require_once __DIR__ . '/dbConnect.php';

handleApiCors('GET, POST, PUT, DELETE, OPTIONS');
$pdo = getPdoConnection();

// Determine HTTP method (with safe override support)
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
if ($method === 'POST' && isset($_POST['_method']) && is_string($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
} elseif (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) && is_string($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
    $method = strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
}

/**
 * Strictly parse an integer value from JSON payload or query input.
 * Rejects booleans, floats, scientific notation, and non-digit strings.
 *
 * @param mixed $value
 * @return int|null
 */
function parseStrictInt($value): ?int {
    if (is_int($value)) {
        return $value;
    }
    if (is_bool($value) || is_float($value) || is_array($value) || is_object($value) || $value === null) {
        return null;
    }
    $trimmed = trim((string)$value);
    if ($trimmed === '' || !preg_match('/^-?\d+$/', $trimmed)) {
        return null;
    }
    $filtered = filter_var($trimmed, FILTER_VALIDATE_INT);
    return $filtered === false ? null : (int)$filtered;
}

/**
 * Parse positive integer ID from query parameter.
 */
function parsePositiveId($rawId): ?int {
    $id = parseStrictInt($rawId);
    if ($id === null || $id <= 0) {
        return null;
    }
    return $id;
}

/**
 * Parse JSON request body cleanly.
 */
function getJsonRequestPayload(): ?array {
    $raw = file_get_contents('php://input');
    if ($raw !== false && trim($raw) !== '') {
        $decoded = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return null;
        }
        return $decoded;
    }
    return !empty($_POST) ? $_POST : null;
}

/**
 * Validate product payload:
 * - name: trimmed string, 1..100 characters
 * - price: integer > 0
 * - stock: integer >= 0
 */
function validateProductPayload($data): array {
    if (!is_array($data)) {
        return [false, 'Dữ liệu yêu cầu phải là định dạng JSON hợp lệ.', []];
    }

    if (!array_key_exists('name', $data) || is_array($data['name']) || is_bool($data['name'])) {
        return [false, 'Vui lòng nhập tên sản phẩm.', []];
    }
    $name = trim((string)$data['name']);
    $nameLength = mb_strlen($name, 'UTF-8');
    if ($nameLength < 1 || $nameLength > 100) {
        return [false, 'Tên sản phẩm sau khi bỏ khoảng trắng hai đầu phải có từ 1 đến 100 ký tự.', []];
    }

    if (!array_key_exists('price', $data) || $data['price'] === '' || $data['price'] === null) {
        return [false, 'Vui lòng nhập đơn giá sản phẩm.', []];
    }
    $price = parseStrictInt($data['price']);
    if ($price === null || $price <= 0) {
        return [false, 'Đơn giá phải là số nguyên lớn hơn 0.', []];
    }

    if (!array_key_exists('stock', $data) || $data['stock'] === '' || $data['stock'] === null) {
        return [false, 'Vui lòng nhập số lượng tồn kho.', []];
    }
    $stock = parseStrictInt($data['stock']);
    if ($stock === null || $stock < 0) {
        return [false, 'Số lượng tồn kho phải là số nguyên không âm (>= 0).', []];
    }

    return [true, '', [
        'name'  => $name,
        'price' => $price,
        'stock' => $stock,
    ]];
}

switch ($method) {
    // =========================================================================
    // GET: Trả về danh sách sản phẩm có phân trang (page >= 1, limit = 5)
    // =========================================================================
    case 'GET':
        // Validate `page` query parameter (positive integer, defaults to 1 if omitted)
        if (!array_key_exists('page', $_GET)) {
            $page = 1;
        } else {
            $page = parseStrictInt($_GET['page']);
            if ($page === null || $page < 1) {
                sendJsonResponse([
                    'success' => false,
                    'message' => 'Tham số page không hợp lệ. Giá trị page phải là số nguyên dương (>= 1).',
                ], 400);
            }
        }

        // Validate `limit` query parameter (must equal 5, defaults to 5 if omitted)
        if (!array_key_exists('limit', $_GET)) {
            $limit = 5;
        } else {
            $limit = parseStrictInt($_GET['limit']);
            if ($limit === null || $limit !== 5) {
                sendJsonResponse([
                    'success' => false,
                    'message' => 'Tham số limit không hợp lệ. Giá trị limit phải bằng 5.',
                ], 400);
            }
        }

        try {
            $countStmt = $pdo->query('SELECT COUNT(*) FROM products');
            $total = (int)$countStmt->fetchColumn();
            $totalPages = max(1, (int)ceil($total / $limit));

            // Clamp page to last valid page if requested page exceeds total_pages
            $actualPage = min($page, $totalPages);
            $offset = ($actualPage - 1) * $limit;

            $stmt = $pdo->prepare('SELECT id, name, price, stock, image FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset');
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            $formatted = array_map(function (array $item): array {
                $image = ($item['image'] !== null && trim((string)$item['image']) !== '')
                    ? (string)$item['image']
                    : null;

                return [
                    'id'    => (int)$item['id'],
                    'name'  => (string)$item['name'],
                    'price' => (int)$item['price'],
                    'stock' => (int)$item['stock'],
                    'image' => $image,
                ];
            }, $rows);

            sendJsonResponse([
                'success'    => true,
                'data'       => $formatted,
                'pagination' => [
                    'page'        => $actualPage,
                    'limit'       => $limit,
                    'total'       => $total,
                    'total_pages' => $totalPages,
                ],
            ], 200);
        } catch (PDOException $e) {
            sendJsonResponse([
                'success' => false,
                'message' => 'Lỗi truy vấn cơ sở dữ liệu: ' . $e->getMessage(),
            ], 500);
        }
        break;

    // =========================================================================
    // POST: Thêm sản phẩm mới (trả về mã sản phẩm mới để phục vụ upload ảnh)
    // =========================================================================
    case 'POST':
        $payload = getJsonRequestPayload();
        [$isValid, $errorMsg, $validData] = validateProductPayload($payload);
        if (!$isValid) {
            sendJsonResponse([
                'success' => false,
                'message' => $errorMsg,
            ], 400);
        }

        try {
            $stmt = $pdo->prepare('INSERT INTO products (name, price, stock, image) VALUES (:name, :price, :stock, NULL)');
            $stmt->execute([
                ':name'  => $validData['name'],
                ':price' => $validData['price'],
                ':stock' => $validData['stock'],
            ]);

            $newId = (int)$pdo->lastInsertId();

            sendJsonResponse([
                'success' => true,
                'message' => 'Thêm sản phẩm thành công.',
                'data'    => [
                    'id'    => $newId,
                    'name'  => $validData['name'],
                    'price' => $validData['price'],
                    'stock' => $validData['stock'],
                    'image' => null,
                ],
            ], 201);
        } catch (PDOException $e) {
            sendJsonResponse([
                'success' => false,
                'message' => 'Không thể thêm sản phẩm: ' . $e->getMessage(),
            ], 500);
        }
        break;

    // =========================================================================
    // PUT: Cập nhật thông tin sản phẩm theo id (?id=...), giữ nguyên cột image
    // =========================================================================
    case 'PUT':
        $id = parsePositiveId($_GET['id'] ?? null);
        if ($id === null) {
            sendJsonResponse([
                'success' => false,
                'message' => 'Mã sản phẩm (id) trên URL không hợp lệ.',
            ], 400);
        }

        try {
            $checkStmt = $pdo->prepare('SELECT id, image FROM products WHERE id = :id');
            $checkStmt->execute([':id' => $id]);
            $existing = $checkStmt->fetch();

            if (!$existing) {
                sendJsonResponse([
                    'success' => false,
                    'message' => "Không tìm thấy sản phẩm với id = {$id}.",
                ], 404);
            }
        } catch (PDOException $e) {
            sendJsonResponse([
                'success' => false,
                'message' => 'Lỗi kiểm tra sản phẩm: ' . $e->getMessage(),
            ], 500);
        }

        $payload = getJsonRequestPayload();
        [$isValid, $errorMsg, $validData] = validateProductPayload($payload);
        if (!$isValid) {
            sendJsonResponse([
                'success' => false,
                'message' => $errorMsg,
            ], 400);
        }

        try {
            $updateStmt = $pdo->prepare('UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id');
            $updateStmt->execute([
                ':name'  => $validData['name'],
                ':price' => $validData['price'],
                ':stock' => $validData['stock'],
                ':id'    => $id,
            ]);

            $currentImage = ($existing['image'] !== null && trim((string)$existing['image']) !== '')
                ? (string)$existing['image']
                : null;

            sendJsonResponse([
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công.',
                'data'    => [
                    'id'    => $id,
                    'name'  => $validData['name'],
                    'price' => $validData['price'],
                    'stock' => $validData['stock'],
                    'image' => $currentImage,
                ],
            ], 200);
        } catch (PDOException $e) {
            sendJsonResponse([
                'success' => false,
                'message' => 'Không thể cập nhật sản phẩm: ' . $e->getMessage(),
            ], 500);
        }
        break;

    // =========================================================================
    // DELETE: Xóa sản phẩm theo id (?id=...) và dọn ảnh nếu có
    // =========================================================================
    case 'DELETE':
        $id = parsePositiveId($_GET['id'] ?? null);
        if ($id === null) {
            sendJsonResponse([
                'success' => false,
                'message' => 'Mã sản phẩm (id) trên URL không hợp lệ.',
            ], 400);
        }

        try {
            $checkStmt = $pdo->prepare('SELECT id, name, image FROM products WHERE id = :id');
            $checkStmt->execute([':id' => $id]);
            $existing = $checkStmt->fetch();

            if (!$existing) {
                sendJsonResponse([
                    'success' => false,
                    'message' => "Không tìm thấy sản phẩm với id = {$id} để xóa.",
                ], 404);
            }

            $delStmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
            $delStmt->execute([':id' => $id]);

            // Remove orphan image file from uploads folder after DB deletion succeeds
            removeUploadedImageFile($existing['image'] ?? null);

            sendJsonResponse([
                'success' => true,
                'message' => "Đã xóa sản phẩm \"{$existing['name']}\" thành công.",
                'data'    => ['id' => $id],
            ], 200);
        } catch (PDOException $e) {
            sendJsonResponse([
                'success' => false,
                'message' => 'Không thể xóa sản phẩm: ' . $e->getMessage(),
            ], 500);
        }
        break;

    // =========================================================================
    // Default: Phương thức không được hỗ trợ
    // =========================================================================
    default:
        sendJsonResponse([
            'success' => false,
            'message' => "Phương thức HTTP '{$method}' không được hỗ trợ.",
        ], 405);
        break;
}
