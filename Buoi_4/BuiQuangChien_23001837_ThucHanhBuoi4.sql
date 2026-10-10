-- ====================================================================
-- HỌ VÀ TÊN: BÙI QUANG CHIẾN
-- MÃ SINH VIÊN: 23001837
-- LỚP: K68A3
-- HỌC PHẦN: MAT3542 1 - Phát triển ứng dụng web
-- BÀI THỰC HÀNH PHP + MYSQL - BUỔI 4: QUẢN LÝ GIỎ HÀNG
-- ====================================================================

-- 1. TẠO CƠ SỞ DỮ LIỆU
CREATE DATABASE IF NOT EXISTS `shopping_cart` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `shopping_cart`;

-- 2. TẠO BẢNG PRODUCTS
-- id: INT PRIMARY KEY, AUTO_INCREMENT
-- name: VARCHAR(100) NOT NULL
-- price: DECIMAL(10,2) NOT NULL
-- quantity: INT NOT NULL
DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `quantity` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. THÊM TỐI THIỂU 5 SẢN PHẨM MẪU BAN ĐẦU
INSERT INTO `products` (`name`, `price`, `quantity`) VALUES
('Điện thoại iPhone 15 Pro Max 256GB', 29990000.00, 15),
('Laptop Dell XPS 13 Core i7', 32500000.00, 8),
('Bàn phím cơ Filco Majestouch 2', 3150000.00, 25),
('Chuột công thái học Logitech MX Master 3S', 2450000.00, 40),
('Tai nghe chống ồn Sony WH-1000XM5', 7990000.00, 12),
('Màn hình đồ họa Dell UltraSharp 27 Inch 4K', 13990000.00, 10);

-- Kiểm tra dữ liệu sau khi chèn
SELECT * FROM `products`;
