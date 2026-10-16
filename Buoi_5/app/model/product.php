<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: model/product.php
 * Mục đích: Tầng Model xử lý các thao tác CSDL cho bảng products.
 * Sử dụng Prepared Statements để phòng chống SQL Injection.
 */

require_once __DIR__ . '/../common/dbConnect.php';

/**
 * Lấy toàn bộ danh sách sản phẩm
 *
 * @return array Danh sách sản phẩm (mảng kết hợp)
 */
function getAllProducts() {
    $conn = getDbConnection();
    try {
        $sql = "SELECT id, name, price, quantity FROM products ORDER BY id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Lỗi getAllProducts(): " . $e->getMessage());
        return [];
    }
}

/**
 * Lấy thông tin một sản phẩm theo ID
 *
 * @param int $id Mã định danh sản phẩm
 * @return array|null Trả về mảng thông tin sản phẩm hoặc null nếu không tồn tại
 */
function getProductById($id) {
    $conn = getDbConnection();
    try {
        $sql = "SELECT id, name, price, quantity FROM products WHERE id = :id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch();
        return $product ? $product : null;
    } catch (PDOException $e) {
        error_log("Lỗi getProductById(): " . $e->getMessage());
        return null;
    }
}

/**
 * Thêm một sản phẩm mới vào cơ sở dữ liệu
 *
 * @param string $name Tên sản phẩm
 * @param float $price Đơn giá sản phẩm (> 0)
 * @param int $quantity Số lượng sản phẩm (>= 0)
 * @return bool True nếu thêm thành công, ngược lại False
 */
function addProduct($name, $price, $quantity) {
    $conn = getDbConnection();
    try {
        $sql = "INSERT INTO products (name, price, quantity) VALUES (:name, :price, :quantity)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', trim($name), PDO::PARAM_STR);
        $stmt->bindValue(':price', (float)$price);
        $stmt->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Lỗi addProduct(): " . $e->getMessage());
        return false;
    }
}

/**
 * Cập nhật thông tin sản phẩm theo ID
 *
 * @param int $id Mã sản phẩm cần cập nhật
 * @param string $name Tên sản phẩm mới
 * @param float $price Giá sản phẩm mới
 * @param int $quantity Số lượng mới
 * @return bool True nếu cập nhật thành công, ngược lại False
 */
function updateProduct($id, $name, $price, $quantity) {
    $conn = getDbConnection();
    try {
        $sql = "UPDATE products 
                SET name = :name, price = :price, quantity = :quantity 
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->bindValue(':name', trim($name), PDO::PARAM_STR);
        $stmt->bindValue(':price', (float)$price);
        $stmt->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Lỗi updateProduct(): " . $e->getMessage());
        return false;
    }
}

/**
 * Xóa một sản phẩm theo ID
 *
 * @param int $id Mã sản phẩm cần xóa
 * @return bool True nếu xóa thành công, ngược lại False
 */
function deleteProduct($id) {
    $conn = getDbConnection();
    try {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Lỗi deleteProduct(): " . $e->getMessage());
        return false;
    }
}
