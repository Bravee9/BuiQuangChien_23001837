-- ==========================================
-- HỌ VÀ TÊN: BÙI QUANG CHIẾN
-- MÃ SINH VIÊN: 23001837
-- BÀI THỰC HÀNH MYSQL - BUỔI 3
-- ==========================================

-- ==========================================
-- BÀI 1: QUẢN LÝ GIỎ HÀNG
-- ==========================================

-- Tạo database và sử dụng
CREATE DATABASE IF NOT EXISTS shopping_cart;
USE shopping_cart;

-- 1. Tạo bảng cart_items
CREATE TABLE IF NOT EXISTS cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

-- 2.1 Thêm ít nhất 5 sản phẩm vào bảng
INSERT INTO cart_items (name, price, quantity) VALUES
('Áo thun nam', 150000.00, 3),
('Quần jean', 250000.00, 2),
('Giày thể thao', 550000.00, 1),
('Bít tất', 25000.00, 10),
('Mũ lưỡi trai', 80000.00, 6),
('Balo laptop', 350000.00, 2);

-- 2.2 Hiển thị toàn bộ sản phẩm
SELECT * FROM cart_items;

-- 2.3 Hiển thị sản phẩm có giá lớn hơn 100000
SELECT * FROM cart_items WHERE price > 100000;

-- 2.4 Hiển thị sản phẩm có số lượng lớn hơn 5
SELECT * FROM cart_items WHERE quantity > 5;

-- 2.5 Sắp xếp sản phẩm theo giá giảm dần
SELECT * FROM cart_items ORDER BY price DESC;

-- 2.6 Cập nhật giá của một sản phẩm (VD: cập nhật giá của 'Áo thun nam' id = 1)
UPDATE cart_items SET price = 145000.00 WHERE id = 1;

-- 2.7 Cập nhật số lượng của một sản phẩm (VD: cập nhật số lượng của 'Quần jean' id = 2)
UPDATE cart_items SET quantity = 4 WHERE id = 2;

-- 2.8 Xóa một sản phẩm (VD: xóa sản phẩm id = 3)
DELETE FROM cart_items WHERE id = 3;

-- 2.9 Hiển thị tên sản phẩm, giá, số lượng và thành tiền (price * quantity)
SELECT name, price, quantity, (price * quantity) AS total_price FROM cart_items;

-- 2.10 Tính tổng tiền của toàn bộ giỏ hàng
SELECT SUM(price * quantity) AS grand_total FROM cart_items;


-- ==========================================
-- BÀI 2: QUẢN LÝ VÉ XEM PHIM
-- ==========================================

-- Tạo database và sử dụng
CREATE DATABASE IF NOT EXISTS movie_tickets;
USE movie_tickets;

-- 1. Tạo bảng movies
CREATE TABLE IF NOT EXISTS movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

-- 2.1 Thêm ít nhất 5 bộ phim
INSERT INTO movies (title, price, total_seats, available_seats) VALUES
('Avenger: Endgame', 120000.00, 200, 20),
('Mai', 100000.00, 150, 0),
('Đào, Phở và Piano', 80000.00, 100, 60),
('Dune: Part Two', 150000.00, 250, 100),
('Kung Fu Panda 4', 95000.00, 180, 50),
('Godzilla x Kong', 110000.00, 220, 10);

-- 2.2 Hiển thị toàn bộ danh sách phim
SELECT * FROM movies;

-- 2.3 Hiển thị phim có giá vé lớn hơn 100000
SELECT * FROM movies WHERE price > 100000;

-- 2.4 Hiển thị phim còn nhiều hơn 50 ghế
SELECT * FROM movies WHERE available_seats > 50;

-- 2.5 Sắp xếp phim theo giá vé giảm dần
SELECT * FROM movies ORDER BY price DESC;

-- 2.6 Cập nhật số ghế còn lại của một phim (VD: Cập nhật available_seats của phim id = 4)
UPDATE movies SET available_seats = 85 WHERE id = 4;

-- 2.7 Xóa một phim (VD: xóa phim id = 6)
DELETE FROM movies WHERE id = 6;

-- 2.8 Hiển thị số vé đã bán của từng phim: total_seats - available_seats
SELECT title, (total_seats - available_seats) AS sold_tickets FROM movies;

-- 2.9 Tính doanh thu của từng phim: (total_seats - available_seats) * price
SELECT title, (total_seats - available_seats) * price AS revenue FROM movies;

-- 2.10 Tính tổng doanh thu của tất cả các phim
SELECT SUM((total_seats - available_seats) * price) AS total_revenue FROM movies;

-- 2.11 Tìm phim có số vé bán ra nhiều nhất
-- Sử dụng MAX kết hợp với subquery để tìm phim có số vé bán ra cao nhất
SELECT title, (total_seats - available_seats) AS sold_tickets 
FROM movies 
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats) FROM movies
);
