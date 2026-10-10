# MAT3542 1 - Phát triển ứng dụng web

Repository lưu trữ mã nguồn các bài tập thực hành môn học **Phát triển ứng dụng web** (Mã học phần: MAT3542 1).

---

## Thông tin sinh viên

- **Họ và tên:** Bùi Quang Chiến
- **Mã sinh viên:** 23001837
- **Lớp:** K68A3
- **Học phần:** [2026] MAT3542 1 - Phát triển ứng dụng web

---

## Cấu trúc thư mục

```text
.
├── Buoi_1/                              # Bài thực hành PHP cơ bản (Biến, mảng, hàm & OOP sơ cấp)
│   ├── Bai_thuc_hanh_PHP_Buoi_1.pdf
│   ├── bai1.php
│   ├── bai2.php
│   ├── bai3.php
│   └── bai4.php
├── Buoi_2/                              # Bài thực hành PHP - Function & OOP
│   ├── Bài thực hành buổi 2.pdf
│   ├── bai1.php
│   └── bai2.php
├── Buoi_3/                              # Bài thực hành MySQL
│   ├── Bài thực hành buổi 3 - MYSQL.pdf
│   └── BuiQuangChien_23001837_ThucHanhBuoi3.sql
├── Buoi_4/                              # Bài thực hành PHP + MySQL - Quản lý giỏ hàng
│   ├── Bai_thuc_hanh_4_quan_ly_gio_hang.pdf
│   ├── BuiQuangChien_23001837_ThucHanhBuoi4.sql
│   └── app/
│       ├── common/
│       │   └── dbConnect.php
│       ├── model/
│       │   └── product.php
│       ├── view/
│       │   ├── header.php
│       │   └── footer.php
│       ├── assets/
│       │   └── style.css
│       ├── index.php
│       ├── product_list.php
│       ├── product_add.php
│       ├── product_edit.php
│       └── product_delete.php
└── README.md
```

---

## Nội dung chi tiết các buổi thực hành

### Buổi 1: PHP cơ bản, Mảng, Vòng lặp & Hướng đối tượng
- `bai1.php`: Làm quen với biến, mảng và vòng lặp (duyệt mảng sinh viên, tính điểm trung bình).
- `bai2.php`: Tách hàm xử lý (`calculateAverageScore`, `getRank`, `displayStudent`).
- `bai3.php`: Xử lý danh sách sinh viên (`findBestStudent`, `findWorstStudent`, `countPassedStudents`, `findStudentByName`).
- `bai4.php`: Lập trình hướng đối tượng (OOP) với class `Student`.

### Buổi 2: PHP – Function & OOP nâng cao
- `bai1.php`: Quản lý giỏ hàng mua sắm (`CartItem`, `ShoppingCart`):
  - Class `CartItem` (tên, giá, số lượng, `getTotal()`).
  - Class `ShoppingCart` quản lý danh sách sản phẩm (`addItem`, `removeItem`, `calculateTotal`, `displayCart`).
  - Kiểm tra hợp lệ: giá và số lượng phải lớn hơn 0; xử lý giỏ hàng rỗng; xóa sản phẩm không tồn tại.
- `bai2.php`: Quản lý vé xem phim (`Movie` & functions xử lý danh sách):
  - Class `Movie` (ID, tên phim, đơn giá, tổng số ghế, số ghế còn lại).
  - Phương thức đặt vé (`bookTicket`), hủy vé (`cancelTicket`), tính số ghế đã bán (`getSoldSeats`), doanh thu (`getRevenue`), hiển thị (`displayInfo`).
  - Các hàm xử lý danh sách: `findMovieById`, `getTotalRevenue`, `getBestSellingMovie`.
  - Xử lý các ngoại lệ / trường hợp lỗi: đặt/hủy số vé $\le 0$, đặt vượt số ghế trống, hủy quá số vé đã bán, tìm phim không tồn tại, danh sách rỗng.

### Buổi 3: Thực hành MySQL
- `BuiQuangChien_23001837_ThucHanhBuoi3.sql`: Tệp chứa tập lệnh SQL bao gồm tạo CSDL, tạo bảng và các câu truy vấn xử lý:
  - **Bài 1 - Quản lý giỏ hàng:** Tạo bảng `cart_items` và thực hiện các lệnh `INSERT`, `SELECT`, lọc, sắp xếp, `UPDATE`, `DELETE`, và tính tổng (`SUM`).
  - **Bài 2 - Quản lý vé xem phim:** Tạo bảng `movies` và thực hiện truy vấn hiển thị, cập nhật ghế trống, tính doanh thu vé bán ra, tìm phim bán được nhiều vé nhất (dùng truy vấn con với `MAX`).

### Buổi 4: PHP + MySQL – Quản lý giỏ hàng (Shopping Cart)
- `BuiQuangChien_23001837_ThucHanhBuoi4.sql`: Tập lệnh tạo CSDL `shopping_cart`, bảng `products` (`id`, `name`, `price`, `quantity`) và chèn 6 sản phẩm mẫu.
- `app/common/dbConnect.php`: Kết nối CSDL MySQL sử dụng PDO, xử lý ngoại lệ an toàn, ẩn thông tin bảo mật, hỗ trợ UTF-8 `utf8mb4`.
- `app/model/product.php`: Tầng Model chứa các hàm thao tác CSDL:
  - `getAllProducts()`: Lấy danh sách toàn bộ sản phẩm.
  - `getProductById($id)`: Lấy chi tiết sản phẩm theo ID.
  - `addProduct($name, $price, $quantity)`: Thêm sản phẩm mới.
  - `updateProduct($id, $name, $price, $quantity)`: Cập nhật thông tin sản phẩm.
  - `deleteProduct($id)`: Xóa sản phẩm khỏi CSDL.
  - *Toàn bộ các hàm đều sử dụng PDO Prepared Statements để phòng chống tấn công SQL Injection.*
- `app/product_list.php`: Hiển thị bảng danh sách sản phẩm với các cột `ID | Tên sản phẩm | Giá | Số lượng | Chức năng`, có nút `[Sửa]` và `[Xóa]`.
- `app/product_add.php`: Form thêm sản phẩm với xác thực chặt chẽ (Tên không rỗng, Giá > 0, Số lượng >= 0).
- `app/product_edit.php`: Form hiển thị thông tin hiện tại và cho phép cập nhật sản phẩm.
- `app/product_delete.php`: Xóa sản phẩm theo ID kèm theo xác nhận an toàn qua POST, hiển thị thông báo lỗi phù hợp khi sản phẩm không tồn tại.
- `app/view/`: Tách `header.php` và `footer.php` tái sử dụng giao diện dùng chung.
- `app/assets/style.css`: Giao diện hiện đại, responsive, thẩm mỹ cao dựa trên HTML cơ bản.

---

## Hướng dẫn chạy chương trình

### 1. Khởi tạo cơ sở dữ liệu (Cho Buổi 4)
Import tệp SQL vào MySQL (qua phpMyAdmin hoặc MySQL CLI):
```bash
mysql -u root -p < Buoi_4/BuiQuangChien_23001837_ThucHanhBuoi4.sql
```

### 2. Khởi chạy Web Server cục bộ
Sử dụng PHP Built-in Server để chạy ứng dụng Buổi 4:
```bash
# Khởi chạy server tại thư mục app của Buổi 4
php -S localhost:8000 -t Buoi_4/app/
```
Sau đó truy cập trình duyệt tại địa chỉ: `http://localhost:8000`
