-- ====================================================================
-- STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
-- COURSE: [2026] MAT3542 1 - WEB APPLICATION DEVELOPMENT
-- LAB 8: PHP REST API AND VUE.JS SINGLE PAGE APPLICATION
-- File: database.sql
-- ====================================================================

CREATE DATABASE IF NOT EXISTS `buoi8_vuejs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `buoi8_vuejs`;

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `price` INT NOT NULL,
    `stock` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`name`, `price`, `stock`) VALUES
('Bút bi', 5000, 20),
('Vở ô ly', 12000, 15),
('Thước kẻ', 8000, 0);
