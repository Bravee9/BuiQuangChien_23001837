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
├── Buoi_5/                              # Bài thực hành PHP + MySQL - Quản lý giỏ hàng & Đăng ký / Đăng nhập
│   ├── De_thuc_hanh_PHP_MySQL_Quan_ly_gio_hang_va_dang_ky_dăng_nhap.pdf
│   ├── BuiQuangChien_23001837_ThucHanhBuoi5.sql
│   └── app/
│       ├── common/
│       │   ├── dbConnect.php            # Kết nối PDO CSDL shopping_cart
│       │   └── auth.php                 # Quản lý session & kiểm soát quyền truy cập
│       ├── model/
│       │   ├── product.php              # CRUD sản phẩm (Prepared Statements)
│       │   └── user.php                 # Xác thực & đăng ký tài khoản (password_hash)
│       ├── view/
│       │   ├── header.php               # Header dùng chung, hiển thị tên user & nút đăng xuất
│       │   └── footer.php               # Footer dùng chung
│       ├── assets/
│       │   └── style.css                # Giao diện responsive, hiện đại
│       ├── index.php                    # Điều hướng thông minh theo trạng thái đăng nhập
│       ├── login.php                    # Form & xử lý đăng nhập (password_verify)
│       ├── register.php                 # Form & xử lý đăng ký tài khoản mới
│       ├── logout.php                   # Đăng xuất & hủy session
│       ├── product_list.php             # Danh sách sản phẩm (yêu cầu đăng nhập)
│       ├── product_add.php              # Thêm sản phẩm & validate dữ liệu (yêu cầu đăng nhập)
│       ├── product_edit.php             # Sửa thông tin sản phẩm (yêu cầu đăng nhập)
│       └── product_delete.php           # Xóa sản phẩm kèm xác nhận an toàn (yêu cầu đăng nhập)
├── Buoi_6/                              # Bài thực hành Vue.js cơ bản (Data Binding, Directives, Computed)
│   ├── Bài tập thực hành buổi 6 - VueJs.pdf
│   ├── index.html                       # Trang chủ điều hướng tổng quan 3 bài tập
│   ├── bai1.html                        # Bài 1: Thẻ thông tin sinh viên (v-bind, v-text, v-if, v-show, :class)
│   ├── bai2.html                        # Bài 2: Đặt vé xem phim (v-model.trim, v-model.number, computed)
│   ├── bai3.html                        # Bài 3: Quản lý công việc cá nhân (v-for, :key, checkbox, filter)
│   └── assets/
│       ├── css/
│       │   └── style.css                # Giao diện Ocean Swiss Minimalist (chuẩn UI/UX hiện đại)
│       ├── js/
│       │   └── vue.global.js            # Thư viện Vue 3 (hỗ trợ chạy offline độc lập)
│       └── images/
│           ├── student-avatar.svg       # Ảnh đại diện sinh viên mẫu
│           └── student-avatar-alt.svg   # Ảnh đại diện sinh viên thay thế
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

### Buổi 5: PHP + MySQL – Quản lý giỏ hàng & Đăng ký / Đăng nhập
- `BuiQuangChien_23001837_ThucHanhBuoi5.sql`:
  - Tạo CSDL `shopping_cart`, bảng `products` (với 6 sản phẩm mẫu) và bảng `users` (`id`, `username`, `password`).
  - Thêm tài khoản mẫu đã được mã hóa an toàn bằng `password_hash()` (Bcrypt):
    - Tài khoản Admin: `admin` / Mật khẩu: `admin123`
    - Tài khoản User: `chienbq` / Mật khẩu: `123456`
- `app/common/dbConnect.php`: Kết nối CSDL bằng PDO, xử lý lỗi an toàn.
- `app/common/auth.php`: Quản lý phiên làm việc (`$_SESSION`), phòng chống Session Fixation (`session_regenerate_id`), cung cấp các hàm `isLoggedIn()`, `requireLogin()`, `loginUser()`, `logoutUser()`.
- `app/model/user.php`: Tầng Model quản lý người dùng:
  - `checkUsernameExists($username)`: Kiểm tra tên đăng nhập đã tồn tại.
  - `registerUser($username, $password)`: Đăng ký người dùng mới, tự động mã hóa mật khẩu với `password_hash()`.
  - `authenticateUser($username, $password)`: Xác thực đăng nhập sử dụng `password_verify()`.
- `app/model/product.php`: Tầng Model quản lý sản phẩm với đầy đủ 5 hàm CRUD bằng Prepared Statements.
- `app/register.php`: Form đăng ký tài khoản với đầy đủ kiểm tra hợp lệ: không để trống, kiểm tra trùng lặp tên, độ dài mật khẩu, xác nhận mật khẩu; chuyển hướng đến trang đăng nhập khi thành công.
- `app/login.php`: Form đăng nhập tài khoản; kiểm tra thông tin qua `password_verify()`, lưu session và chuyển hướng tới `product_list.php`; báo lỗi phù hợp khi thông tin không chính xác; hiển thị gợi ý tài khoản mẫu.
- `app/logout.php`: Hủy phiên đăng nhập (`session_destroy()`) và chuyển hướng về `login.php`.
- **Kiểm soát truy cập (Access Control):**
  - Các trang `product_list.php`, `product_add.php`, `product_edit.php`, `product_delete.php` đều được bảo vệ nghiêm ngặt bằng `requireLogin()`. Nếu chưa đăng nhập, hệ thống tự động chuyển hướng về `login.php?msg=login_required`.
  - Hiển thị tên tài khoản đang đăng nhập và liên kết **Đăng xuất** nổi bật trên thanh điều hướng (`header.php`).
- `app/product_list.php`, `app/product_add.php`, `app/product_edit.php`, `app/product_delete.php`: Hoàn thiện trọn vẹn nghiệp vụ quản lý sản phẩm theo chuẩn đề bài.

### Buổi 6: Lập trình Vue.js cơ bản (Data Binding, Directives & Computed)
- `index.html`: Cổng điều hướng hiện đại, tổng quan mục tiêu & kiến thức của cả 3 bài tập.
- `bai1.html`: **Thẻ thông tin sinh viên**
  - Khai báo và quản lý dữ liệu phản ứng qua `createApp` và `data()`.
  - Hiển thị họ tên bằng `{{ }}`, tên lớp bằng chỉ thị `v-text`.
  - Gắn liên kết và thuộc tính alt ảnh đại diện bằng `v-bind:src` và `v-bind:alt`.
  - Tự động xếp loại học lực dựa trên điểm trung bình bằng chuỗi rẽ nhánh `v-if`, `v-else-if`, `v-else` (Giỏi: 8.0 - 10, Khá: 6.5 - <8.0, Trung bình: 5.0 - <6.5, Chưa đạt: <5.0).
  - Đổi màu xếp loại trực quan bằng `:class` và `:style`.
  - Hiển thị linh hoạt trạng thái "Đang học" / "Đã nghỉ" bằng `v-if` / `v-else`.
  - Bật / tắt phần giới thiệu sinh viên bằng chỉ thị `v-show`.
  - Tích hợp **Bảng điều khiển tương tác (Testing Panel)** cho phép thay đổi dữ liệu, kéo slider điểm trung bình để kiểm chứng tính phản ứng (reactivity) và các trường hợp biên.
- `bai2.html`: **Đặt vé xem phim (CGV HUS Cinema)**
  - Nhập họ tên khách hàng với modifier `v-model.trim`.
  - Chọn suất chiếu qua dropdown `select` (4 suất chiếu phong phú).
  - Chọn loại vé bằng `radio`: Vé thường (70.000 đ) / Vé VIP (100.000 đ).
  - Nhập số lượng vé với `v-model.number`, kiểm tra nghiêm ngặt số nguyên trong khoảng [1, 10], kèm nút tăng/giảm và nút đặt lại form (`resetForm`).
  - Checkbox chọn combo bắp nước (+45.000 đ / đơn đặt vé).
  - Dùng `computed` tính toán tự động tổng tiền theo công thức: `Tổng tiền = Giá vé × Số lượng + Tiền combo`.
  - Nút "Đặt vé" kích hoạt có điều kiện: chỉ bật khi họ tên không rỗng và số lượng hợp lệ.
  - Ngăn chặn reload và xử lý gửi form qua `@submit.prevent`, xuất ngay phiếu xác nhận đặt vé dạng Boarding Pass chuyên nghiệp.
  - *Kiểm tra kết quả chuẩn:* Đặt 2 vé VIP kèm combo cho tổng tiền chính xác **245.000 đồng** (có sẵn nút bấm test nhanh 1-click).
- `bai3.html`: **Quản lý công việc cá nhân (Todo List)**
  - Cấu trúc công việc: `{ id, title, completed, createdAt }`.
  - Thêm công việc qua nút "Thêm" hoặc phím Enter (`@keyup.enter`), chặn tuyệt đối tên rỗng hoặc chỉ có khoảng trắng.
  - Hiển thị danh sách phản ứng bằng `v-for` với `:key="task.id"`.
  - Đánh dấu hoàn thành qua `checkbox`, tự động gạch ngang tên công việc (`text-decoration: line-through`).
  - Xóa từng công việc độc lập.
  - Lọc theo 3 trạng thái: "Tất cả", "Chưa hoàn thành", "Đã hoàn thành".
  - Dùng `computed` tính tổng số công việc (`totalTasks`), số việc chưa hoàn thành (`uncompletedTasks`), và số việc đã hoàn thành.
  - Nút "Xóa các việc đã hoàn thành" thông minh (chỉ bật khi có ít nhất 1 việc hoàn thành).
  - Hiển thị các thông báo trực quan (Empty State) tương ứng khi danh sách rỗng hoặc từng bộ lọc không có dữ liệu.
  - Đồng bộ an toàn với `localStorage` và có nút "Nạp việc mẫu" hỗ trợ người chấm kiểm tra nhanh.

---

## Hướng dẫn chạy chương trình

### 1. Khởi tạo cơ sở dữ liệu

#### Dành cho Buổi 4:
```bash
mysql -u root -p < Buoi_4/BuiQuangChien_23001837_ThucHanhBuoi4.sql
```

#### Dành cho Buổi 5:
```bash
mysql -u root -p < Buoi_5/BuiQuangChien_23001837_ThucHanhBuoi5.sql
```

### 2. Khởi chạy Web Server cục bộ

Sử dụng PHP Built-in Server:

```bash
# Khởi chạy server cho Buổi 5
php -S localhost:8000 -t Buoi_5/app/
```

Sau đó mở trình duyệt và truy cập: `http://localhost:8000`

- **Tài khoản đăng nhập thử nghiệm:**
  - `admin` / `admin123`
  - `chienbq` / `123456`
- Hoặc bấm vào **"Đăng ký ngay tại đây"** để tự tạo tài khoản mới.

### 3. Dành cho Buổi 6 (Vue.js)

Có thể mở trực tiếp các tệp HTML trong trình duyệt:
- Mở `Buoi_6/index.html` hoặc nhấp đúp trực tiếp vào các file `bai1.html`, `bai2.html`, `bai3.html`.
- Hoặc khởi chạy thông qua PHP Built-in Server:
```bash
# Khởi chạy server cho Buổi 6
php -S localhost:8000 -t Buoi_6/
```
Sau đó truy cập: `http://localhost:8000`
