<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837
 * File: model/product.php
 * Mục đích: Tầng Model quản lý các truy vấn CSDL cho bảng products.
 * Sử dụng Prepared Statements để ngăn chặn triệt để tấn công SQL Injection.
 */

require_once __DIR__ . '/../common/dbConnect.php';

/**
 * Lấy toàn bộ danh sách sản phẩm từ bảng products
 *
 * @return array Danh sách các sản phẩm (mỗi phần tử là mảng kết hợp)
 */
function getAllProducts() {
    $conn = getDbConnection();
    try {
        $sql = "SELECT id, name, price, quantity FROM products ORDER BY id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Lỗi trong getAllProducts(): " . $e->getMessage());
        return [];
    }
}

/**
 * Lấy thông tin chi tiết một sản phẩm theo ID
 *
 * @param int $id Mã định danh sản phẩm
 * @return array|null Trả về mảng thông tin sản phẩm nếu tìm thấy, ngược lại trả về null
 */
function getProductById($id) {
    // Kiểm tra tính hợp lệ của ID (phải là số nguyên dương)
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        return null;
    }

    $conn = getDbConnection();
    try {
        $sql = "SELECT id, name, price, quantity FROM products WHERE id = :id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $product = $stmt->fetch();
        return $product ? $product : null;
    } catch (PDOException $e) {
        error_log("Lỗi trong getProductById({$id}): " . $e->getMessage());
        return null;
    }
}

/**
 * Thêm một sản phẩm mới vào cơ sở dữ liệu
 *
 * @param string $name Tên sản phẩm
 * @param float|string $price Giá sản phẩm
 * @param int $quantity Số lượng tồn kho
 * @return bool True nếu thêm thành công, False nếu thất bại
 */
function addProduct($name, $price, $quantity) {
    $conn = getDbConnection();
    try {
        $sql = "INSERT INTO products (name, price, quantity) VALUES (:name, :price, :quantity)";
        $stmt = $conn->prepare($sql);
        
        // Ràng buộc tham số chặt chẽ
        $stmt->bindValue(':name', trim($name), PDO::PARAM_STR);
        $stmt->bindValue(':price', (string)$price, PDO::PARAM_STR);
        $stmt->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Lỗi trong addProduct(): " . $e->getMessage());
        return false;
    }
}

/**
 * Cập nhật thông tin sản phẩm theo ID
 *
 * @param int $id Mã sản phẩm cần sửa
 * @param string $name Tên sản phẩm mới
 * @param float|string $price Giá sản phẩm mới
 * @param int $quantity Số lượng mới
 * @return bool True nếu cập nhật thành công, False nếu thất bại
 */
function updateProduct($id, $name, $price, $quantity) {
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        return false;
    }

    $conn = getDbConnection();
    try {
        $sql = "UPDATE products SET name = :name, price = :price, quantity = :quantity WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindValue(':name', trim($name), PDO::PARAM_STR);
        $stmt->bindValue(':price', (string)$price, PDO::PARAM_STR);
        $stmt->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Lỗi trong updateProduct({$id}): " . $e->getMessage());
        return false;
    }
}

/**
 * Xóa một sản phẩm theo ID
 *
 * @param int $id Mã sản phẩm cần xóa
 * @return bool True nếu xóa thành công, False nếu thất bại
 */
function deleteProduct($id) {
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        return false;
    }

    $conn = getDbConnection();
    try {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Lỗi trong deleteProduct({$id}): " . $e->getMessage());
        return false;
    }
}
?>
