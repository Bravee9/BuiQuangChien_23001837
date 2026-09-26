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

---

## Hướng dẫn chạy chương trình

Chạy trực tiếp các file PHP qua CLI bằng lệnh:
```bash
# Ví dụ chạy Buổi 2
php Buoi_2/bai1.php
php Buoi_2/bai2.php
```
Hoặc khởi chạy web server tích hợp của PHP:
```bash
php -S localhost:8000
```
