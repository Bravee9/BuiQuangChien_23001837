-- ====================================================================
-- HỌ VÀ TÊN: BÙI QUANG CHIẾN
-- MÃ SINH VIÊN: 23001837
-- LỚP: K68A3
-- HỌC PHẦN: MAT3542 1 - Phát triển ứng dụng web
-- BÀI THỰC HÀNH PHP + MYSQL - BUỔI 5: QUẢN LÝ GIỎ HÀNG VÀ ĐĂNG KÝ / ĐĂNG NHẬP
-- ====================================================================

-- 1. TẠO CƠ SỞ DỮ LIỆU
CREATE DATABASE IF NOT EXISTS `shopping_cart` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `shopping_cart`;

-- 2. TẠO BẢNG PRODUCTS (QUẢN LÝ SẢN PHẨM)
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

-- Thêm tối thiểu 5 sản phẩm mẫu ban đầu
INSERT INTO `products` (`name`, `price`, `quantity`) VALUES
('Điện thoại iPhone 15 Pro Max 256GB', 29990000.00, 15),
('Laptop Dell XPS 13 Core i7', 32500000.00, 8),
('Bàn phím cơ Filco Majestouch 2', 3150000.00, 25),
('Chuột công thái học Logitech MX Master 3S', 2450000.00, 40),
('Tai nghe chống ồn Sony WH-1000XM5', 7990000.00, 12),
('Màn hình đồ họa Dell UltraSharp 27 Inch 4K', 13990000.00, 10);

-- 3. TẠO BẢNG USERS (QUẢN LÝ NGƯỜI DÙNG ĐĂNG NHẬP / ĐĂNG KÝ)
-- id: INT PRIMARY KEY, AUTO_INCREMENT
-- username: VARCHAR(50) NOT NULL, UNIQUE
-- password: VARCHAR(255) NOT NULL (Lưu trữ bằng password_hash(), không lưu plain text)
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm tài khoản mẫu:
-- Tài khoản 1:
--   Tên đăng nhập (username): admin
--   Mật khẩu gốc: admin123
--   Mật khẩu đã băm (password_hash bcrypt): $2y$10$/r7hYn1UYttTWFpXg7oFj.QHUyNqjcbR2uEfA0wrkO3owc.KpnnSW
-- Tài khoản 2:
--   Tên đăng nhập (username): chienbq
--   Mật khẩu gốc: 123456
--   Mật khẩu đã băm (password_hash bcrypt): $2y$10$/r7hYn1UYttTWFpXg7oFj.u.CsAoVhyXusERNiy3uh3XJPEyeO5AK

INSERT INTO `users` (`username`, `password`) VALUES
('admin', '$2y$10$/r7hYn1UYttTWFpXg7oFj.QHUyNqjcbR2uEfA0wrkO3owc.KpnnSW'),
('chienbq', '$2y$10$/r7hYn1UYttTWFpXg7oFj.u.CsAoVhyXusERNiy3uh3XJPEyeO5AK');

-- Kiểm tra dữ liệu trong các bảng sau khi khởi tạo
SELECT * FROM `products`;
SELECT `id`, `username`, `password` FROM `users`;
