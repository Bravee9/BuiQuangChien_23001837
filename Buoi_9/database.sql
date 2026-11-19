-- ====================================================================
-- STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
-- COURSE: [2026] MAT3542 1 - WEB APPLICATION DEVELOPMENT
-- LAB 9: PRODUCT IMAGE UPLOAD AND SERVER-SIDE PAGINATION
-- File: database.sql
-- ====================================================================

CREATE DATABASE IF NOT EXISTS `buoi9_vuejs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `buoi9_vuejs`;

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `price` INT NOT NULL,
    `stock` INT NOT NULL,
    `image` VARCHAR(255) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Note: If upgrading an existing table from Session 8 without dropping data:
-- ALTER TABLE `products` ADD COLUMN `image` VARCHAR(255) NULL DEFAULT NULL;

-- Sample dataset with 12 products (5 items per page -> 3 pages: 5, 5, 2)
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
