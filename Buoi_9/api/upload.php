<?php
/**
 * STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
 * COURSE: [2026] MAT3542 1 - WEB APPLICATION DEVELOPMENT
 * LAB 9: PRODUCT IMAGE UPLOAD AND SERVER-SIDE PAGINATION
 * File: api/upload.php
 * Purpose: Multipart image upload endpoint validating product existence, size (<= 2MB), and actual image type (JPG/JPEG/PNG)
 */

require_once __DIR__ . '/dbConnect.php';

handleApiCors('POST, OPTIONS');

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? '');
if ($method !== 'POST') {
    sendJsonResponse([
        'success' => false,
        'message' => "Phương thức HTTP '{$method}' không được hỗ trợ. Chỉ chấp nhận POST.",
    ], 405);
}

// Handle PHP post_max_size overflow when $_POST and $_FILES become empty
if (empty($_POST) && empty($_FILES) && isset($_SERVER['CONTENT_LENGTH']) && (int)$_SERVER['CONTENT_LENGTH'] > 0) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Dung lượng dữ liệu tải lên vượt quá giới hạn tối đa (2 MB).',
    ], 400);
}

// 1. Validate product_id from FormData
$rawProductId = $_POST['product_id'] ?? $_POST['id'] ?? null;
if (is_array($rawProductId) || $rawProductId === null || !preg_match('/^[1-9]\d*$/', trim((string)$rawProductId))) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Mã sản phẩm (product_id) không hợp lệ.',
    ], 400);
}
$productId = (int)trim((string)$rawProductId);

$pdo = getPdoConnection();

// 2. Check product existence in MySQL before processing file
try {
    $checkStmt = $pdo->prepare('SELECT id, image FROM products WHERE id = :id');
    $checkStmt->execute([':id' => $productId]);
    $existingProduct = $checkStmt->fetch();

    if (!$existingProduct) {
        sendJsonResponse([
            'success' => false,
            'message' => "Không tìm thấy sản phẩm với id = {$productId} để gắn ảnh.",
        ], 404);
    }
} catch (PDOException $e) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Lỗi kiểm tra sản phẩm: ' . $e->getMessage(),
    ], 500);
}

// 3. Validate uploaded file presence and PHP upload error status
$fileField = $_FILES['image'] ?? $_FILES['file'] ?? null;
if (!is_array($fileField) || is_array($fileField['error'])) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Vui lòng chọn một file ảnh hợp lệ (trường image).',
    ], 400);
}

$uploadError = (int)$fileField['error'];
if ($uploadError !== UPLOAD_ERR_OK) {
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE   => 'Dung lượng ảnh vượt quá giới hạn tối đa cho phép (2 MB).',
        UPLOAD_ERR_FORM_SIZE  => 'Dung lượng ảnh vượt quá giới hạn tối đa 2 MB.',
        UPLOAD_ERR_PARTIAL    => 'File ảnh chỉ được tải lên một phần. Vui lòng thử lại.',
        UPLOAD_ERR_NO_FILE    => 'Vui lòng chọn file ảnh để tải lên.',
        UPLOAD_ERR_NO_TMP_DIR => 'Máy chủ thiếu thư mục tạm để lưu file.',
        UPLOAD_ERR_CANT_WRITE => 'Không thể ghi file ảnh lên đĩa máy chủ.',
        UPLOAD_ERR_EXTENSION  => 'Quá trình tải lên bị chặn bởi phần mở rộng PHP.',
    ];
    $status = in_array($uploadError, [UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE, UPLOAD_ERR_EXTENSION], true) ? 500 : 400;
    sendJsonResponse([
        'success' => false,
        'message' => $errorMessages[$uploadError] ?? 'Lỗi tải lên không xác định.',
    ], $status);
}

$tmpPath = (string)($fileField['tmp_name'] ?? '');
$originalName = (string)($fileField['name'] ?? '');
$reportedSize = (int)($fileField['size'] ?? 0);

if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
    sendJsonResponse([
        'success' => false,
        'message' => 'File tải lên không hợp lệ hoặc không tồn tại.',
    ], 400);
}

// 4. Validate file size (1 byte .. 2 MB)
$maxFileSize = 2 * 1024 * 1024; // 2 MB = 2,097,152 bytes
$actualSize = @filesize($tmpPath);
if ($reportedSize <= 0 || $actualSize === false || $actualSize <= 0) {
    sendJsonResponse([
        'success' => false,
        'message' => 'File ảnh rỗng hoặc bị hỏng.',
    ], 400);
}
if ($reportedSize > $maxFileSize || $actualSize > $maxFileSize) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Dung lượng ảnh vượt quá giới hạn tối đa 2 MB.',
    ], 400);
}

// 5. Validate file extension and ACTUAL binary MIME / image content
$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
$allowedExtensions = ['jpg', 'jpeg', 'png'];
if (!in_array($extension, $allowedExtensions, true)) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Định dạng file không hợp lệ. Chỉ chấp nhận ảnh JPG, JPEG hoặc PNG.',
    ], 400);
}

// Check actual MIME using finfo magic bytes when extension is loaded
if (class_exists('finfo')) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $detectedMime = $finfo->file($tmpPath);
    if (!in_array($detectedMime, ['image/jpeg', 'image/png'], true)) {
        sendJsonResponse([
            'success' => false,
            'message' => 'Nội dung file thực tế không phải ảnh JPG, JPEG hoặc PNG hợp lệ.',
        ], 400);
    }
}

// Verify genuine raster image header and dimensions via getimagesize
$imageInfo = @getimagesize($tmpPath);
if ($imageInfo === false || empty($imageInfo[0]) || empty($imageInfo[1])) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Không thể đọc dữ liệu ảnh. File không phải ảnh JPG/PNG hợp lệ.',
    ], 400);
}

$imageType = (int)$imageInfo[2];
if (!in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Loại ảnh thực tế không được hỗ trợ. Chỉ chấp nhận JPG, JPEG hoặc PNG.',
    ], 400);
}

// Determine safe canonical extension from verified image binary type
$safeExtension = ($imageType === IMAGETYPE_PNG) ? 'png' : 'jpg';

// 6. Store image with unique filename inside uploads/
$uploadDir = getUploadsDirectory();
if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Thư mục uploads không tồn tại hoặc không có quyền ghi.',
    ], 500);
}

try {
    $uniqueToken = bin2hex(random_bytes(8));
} catch (Exception $e) {
    $uniqueToken = str_replace('.', '', uniqid('', true));
}

$newFileName = sprintf('product_%d_%s.%s', $productId, $uniqueToken, $safeExtension);
$destinationPath = $uploadDir . DIRECTORY_SEPARATOR . $newFileName;
$relativeDbPath = 'uploads/' . $newFileName;

if (!@move_uploaded_file($tmpPath, $destinationPath)) {
    sendJsonResponse([
        'success' => false,
        'message' => 'Không thể lưu file ảnh vào thư mục uploads.',
    ], 500);
}

// 7. Update image column in MySQL; rollback file if DB update fails
try {
    $updateStmt = $pdo->prepare('UPDATE products SET image = :image WHERE id = :id');
    $updateStmt->execute([
        ':image' => $relativeDbPath,
        ':id'    => $productId,
    ]);

    // Remove previous image only after new file & DB update both succeeded
    $oldImage = $existingProduct['image'] ?? null;
    if ($oldImage !== null && $oldImage !== $relativeDbPath) {
        removeUploadedImageFile($oldImage);
    }

    sendJsonResponse([
        'success' => true,
        'message' => 'Tải ảnh sản phẩm lên thành công.',
        'data'    => [
            'id'    => $productId,
            'image' => $relativeDbPath,
        ],
    ], 200);
} catch (PDOException $e) {
    // Cleanup newly uploaded file so old image reference remains consistent
    if (is_file($destinationPath)) {
        @unlink($destinationPath);
    }

    sendJsonResponse([
        'success' => false,
        'message' => 'Lỗi cập nhật đường dẫn ảnh vào cơ sở dữ liệu: ' . $e->getMessage(),
    ], 500);
}
