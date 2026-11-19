# MAT3542 1 - Web Application Development

This repository contains practical laboratory assignments and source code for the course **Web Application Development** (Course Code: MAT3542 1).

---

## Student Information

- **Full Name:** Bui Quang Chien
- **Student ID:** 23001837
- **Class:** K68A3
- **Course:** [2026] MAT3542 1 - Web Application Development
- **Institution:** VNU University of Science (HUS), Vietnam National University, Hanoi

---

## Repository Structure

```text
.
├── Buoi_1/                              # Fundamentals of PHP: Variables, Arrays, Functions, and OOP Basics
│   ├── Bai_thuc_hanh_PHP_Buoi_1.pdf
│   ├── _web_shell.php                   # Browser console shell wrapper (CLI plain-text preserved)
│   ├── index.php                        # Overview navigation hub for Session 1
│   ├── bai1.php
│   ├── bai2.php
│   ├── bai3.php
│   ├── bai4.php
│   └── assets/
│       └── style.css                    # Bravechat Dark Workspace stylesheet
├── Buoi_2/                              # PHP Advanced Functions and Object-Oriented Programming
│   ├── Bai_thuc_hanh_buoi_2.pdf
│   ├── _web_shell.php                   # Browser console shell wrapper (CLI plain-text preserved)
│   ├── index.php                        # Overview navigation hub for Session 2
│   ├── bai1.php
│   ├── bai2.php
│   └── assets/
│       └── style.css                    # Bravechat Dark Workspace stylesheet
├── Buoi_3/                              # Relational Database Management with MySQL
│   ├── Bai_thuc_hanh_buoi_3_MYSQL.pdf
│   └── BuiQuangChien_23001837_ThucHanhBuoi3.sql
├── Buoi_4/                              # Full-stack PHP and MySQL Shopping Cart CRUD
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
├── Buoi_5/                              # PHP and MySQL User Authentication and Access Control
│   ├── De_thuc_hanh_PHP_MySQL_Quan_ly_gio_hang_va_dang_ky_dang_nhap.pdf
│   ├── BuiQuangChien_23001837_ThucHanhBuoi5.sql
│   └── app/
│       ├── common/
│       │   ├── dbConnect.php            # PDO connection with exception handling
│       │   └── auth.php                 # Session management and access control helpers
│       ├── model/
│       │   ├── product.php              # Product model with PDO prepared statements
│       │   └── user.php                 # User model with password_hash and verify
│       ├── view/
│       │   ├── header.php               # Shared navigation and user identity bar
│       │   └── footer.php               # Shared footer
│       ├── assets/
│       │   └── style.css                # Responsive user interface styling
│       ├── index.php                    # Router based on authentication state
│       ├── login.php                    # User sign-in handler
│       ├── register.php                 # User account registration handler
│       ├── logout.php                   # Session termination and invalidation
│       ├── product_list.php             # Protected product list view
│       ├── product_add.php              # Protected product creation view
│       ├── product_edit.php             # Protected product modification view
│       └── product_delete.php           # Protected product removal with confirmation
├── Buoi_6/                              # Vue.js Fundamentals: Data Binding, Directives, and Computed Properties
│   ├── Bai tap thuc hanh buoi 6 - VueJs.pdf
│   ├── index.html                       # Navigation hub for Session 6
│   ├── bai1.html                        # Exercise 1: Student Information Card
│   ├── bai2.html                        # Exercise 2: Cinema Ticket Booking System
│   ├── bai3.html                        # Exercise 3: Personal Task Management (Todo Application)
│   └── assets/
│       ├── css/
│       │   └── style.css                # Shared responsive stylesheet
│       ├── js/
│       │   └── vue.global.js            # Standalone Vue 3 runtime build
│       └── images/
│           ├── student-avatar.svg
│           └── student-avatar-alt.svg
├── Buoi_7/                              # Advanced Vue 3: Directives, Computed, Watch, Components, Props, and $emit
│   ├── Bai tap thuc hanh 7 - vuejs.pdf
│   ├── index.html                       # Navigation hub for Session 7
│   ├── bai1.html                        # Exercise 1: Product List with Search, Filter, Sort, and Statistics
│   ├── bai2.html                        # Exercise 2: Product Catalog with Component <the-san-pham>
│   ├── bai3.html                        # Exercise 3: Shopping Cart with Props and Custom Events ($emit)
│   ├── components/
│   │   ├── TheSanPham.js                # Separate reusable component definition for Exercise 2
│   │   └── DongGioHang.js               # Separate shopping cart row component for Exercise 3
│   └── assets/
│       ├── css/
│       │   └── style.css                # Responsive stylesheet for Session 7
│       ├── js/
│       │   └── vue.global.js            # Standalone Vue 3 runtime build
│       └── images/
│           ├── laptop.jpg
│           ├── keyboard.jpg
│           ├── mouse.jpg
│           ├── pen.jpg
│           ├── notebook.jpg
│           ├── backpack.jpg
│           ├── bottle.jpg
│           └── default-product.jpg
├── Buoi_8/                              # Full-Stack Integration: RESTful PHP API and Vue 3 CRUD Application
│   ├── Bai tap thuc hanh 8 - api vuejs.pdf
│   ├── database.sql                     # Database schema and seed data for products table
│   ├── index.html                       # Vue 3 reactive Single Page Application for product CRUD
│   ├── api/
│   │   ├── dbConnect.php                # PDO connection helper with schema initialization
│   │   └── products.php                 # RESTful API controller (GET, POST, PUT, DELETE) with validation
│   └── assets/
│       ├── css/
│       │   └── style.css                # Responsive stylesheet for Session 8
│       └── js/
│           └── vue.global.js            # Standalone Vue 3 runtime build
├── Buoi_9/                              # Full-Stack Extension: Image Upload and Server-Side Pagination
│   ├── Bai tap thuc hanh 9 - upload file and pagination.pdf
│   ├── database.sql                     # Extended products schema (with image column) and 12 sample rows
│   ├── index.html                       # Vue 3 SPA with file preview, upload retry flow, and pagination controls
│   ├── api/
│   │   ├── dbConnect.php                # PDO connector with schema upgrade checks and upload cleanup helpers
│   │   ├── products.php                 # Paginated GET (5/page), POST, PUT, DELETE REST endpoints
│   │   └── upload.php                   # Multipart image uploader validating binary MIME, size, and product ID
│   ├── uploads/                         # Storage directory for uploaded product images
│   └── assets/
│       ├── css/
│       │   └── style.css                # Responsive stylesheet for Session 9
│       └── js/
│           └── vue.global.js            # Standalone Vue 3 runtime build
├── Midterm/                             # Midterm Practical Examination
│   └── BuiQuangChien_23001837.php       # PHP programming test with validation and security
└── README.md
```

---

## Detailed Curriculum and Laboratory Modules

### Session 1: PHP Fundamentals, Arrays, Loops, and Basic OOP
- `bai1.php`: Fundamental PHP syntax, variables, indexed and associative arrays, array traversal, and average calculation.
- `bai2.php`: Function modularization (`calculateAverageScore`, `getRank`, `displayStudent`).
- `bai3.php`: Complex array operations (`findBestStudent`, `findWorstStudent`, `countPassedStudents`, `findStudentByName`).
- `bai4.php`: Object-Oriented Programming (OOP) foundation utilizing the `Student` class.

### Session 2: Advanced Functions and Object-Oriented Architecture
- `bai1.php`: Shopping Cart management module:
  - `CartItem` class: Item encapsulation, price, quantity, and subtotal calculation (`getTotal`).
  - `ShoppingCart` class: Product collection management (`addItem`, `removeItem`, `calculateTotal`, `displayCart`).
  - Validation: Positive price and quantity constraints, empty cart handling, non-existent product error handling.
- `bai2.php`: Cinema Ticketing management module:
  - `Movie` class: Movie ID, title, unit price, capacity, and remaining seats.
  - Core business methods: `bookTicket`, `cancelTicket`, `getSoldSeats`, `getRevenue`, `displayInfo`.
  - Analytical helpers: `findMovieById`, `getTotalRevenue`, `getBestSellingMovie`.
  - Edge cases: Negative or zero tickets, booking exceeding available seats, canceling more tickets than sold.

### Session 3: Relational Database Architecture with MySQL
- `BuiQuangChien_23001837_ThucHanhBuoi3.sql`: Comprehensive SQL script for database creation, table schemas, and data manipulation queries:
  - **Exercise 1 (Shopping Cart):** Table `cart_items` with `INSERT`, `SELECT`, filtering, sorting, `UPDATE`, `DELETE`, and aggregate computations (`SUM`).
  - **Exercise 2 (Cinema Management):** Table `movies` with remaining seat updates, revenue analysis, and subquery calculations identifying peak performing movies using `MAX`.

### Session 4: Full-Stack PHP and MySQL Shopping Cart CRUD
- `BuiQuangChien_23001837_ThucHanhBuoi4.sql`: Database schema initialization for `shopping_cart` and table `products`.
- `app/common/dbConnect.php`: Secure PDO database connector with UTF-8 character encoding and sanitized exception handling.
- `app/model/product.php`: Model layer implementing CRUD operations with PDO Prepared Statements:
  - `getAllProducts()`: Retrieves all product records.
  - `getProductById($id)`: Fetches product details by primary key.
  - `addProduct($name, $price, $quantity)`: Inserts new product record.
  - `updateProduct($id, $name, $price, $quantity)`: Updates existing product record.
  - `deleteProduct($id)`: Removes product record.
- `app/product_list.php`: Data presentation table with management actions.
- `app/product_add.php`: Input validation and sanitized record creation.
- `app/product_edit.php`: Record modification interface.
- `app/product_delete.php`: Safe record removal with POST confirmation.

### Session 5: User Authentication and Access Control Architecture
- `BuiQuangChien_23001837_ThucHanhBuoi5.sql`: Extended schema incorporating `users` table and secure password hashing.
- `app/common/auth.php`: Session lifecycle manager, session fixation mitigation via `session_regenerate_id`, and route protection (`requireLogin`, `isLoggedIn`).
- `app/model/user.php`: User authentication and registration models utilizing Bcrypt (`password_hash`, `password_verify`).
- `app/register.php`: Account registration with validation and duplicate prevention.
- `app/login.php`: Authentication endpoint with credential verification.
- `app/logout.php`: Session termination endpoint.
- Route protection applied to all administrative endpoints (`product_list.php`, `product_add.php`, `product_edit.php`, `product_delete.php`).

### Session 6: Vue.js Fundamentals
- `index.html`: Portal and documentation overview for Session 6.
- `bai1.html`: **Student Information Card**
  - Application bootstrapping via `createApp` and reactive state initialization via `data()`.
  - Data binding with interpolation `{{ }}`, `v-text`, `v-bind:src`, and `v-bind:alt`.
  - Conditional rendering using `v-if`, `v-else-if`, and `v-else` for academic evaluation classification (Distinction: 8.0 - 10.0, Good: 6.5 - <8.0, Average: 5.0 - <6.5, Unsatisfactory: <5.0).
  - Dynamic class and style binding (`:class`, `:style`) for classification visualization.
  - Status toggling with `v-if` and biographical information toggling with `v-show`.
  - Interactive testing panel for real-time reactivity verification across boundary scores.
- `bai2.html`: **Cinema Ticket Booking System**
  - Two-way data binding with modifiers: `v-model.trim` for customer name and `v-model.number` for ticket quantity.
  - Form controls: Dropdown `select` for showtimes, `radio` group for ticket tiers (Standard: 70,000 VND, VIP: 100,000 VND), and `checkbox` for combo snacks (45,000 VND).
  - Dynamic computation of total cost via `computed`: Total = Ticket Price * Quantity + Combo Price.
  - Quantity boundaries constrained to integers in [1, 10] with step controls.
  - Submission prevention and handling with `@submit.prevent` rendering an immediate boarding pass receipt.
  - Standard verification test case: 2 VIP tickets with combo snack equals exactly 245,000 VND.
- `bai3.html`: **Personal Task Management (Todo Application)**
  - Task schema: `{ id, title, completed, createdAt }`.
  - Task creation via button click or Enter key modifier (`@keyup.enter`) with non-empty string validation.
  - List rendering with `v-for` and unique key binding `:key="task.id"`.
  - Completion status toggle with checkbox and strikethrough styling.
  - Task filtering across three states: All, Active, and Completed.
  - Computed summary statistics (`totalTasks`, `uncompletedTasks`, `completedTasks`).
  - Batch removal of completed items and contextual empty-state notices.
  - State persistence via `localStorage`.

### Session 7: Advanced Vue 3 (Directives, Watch, Mounted, Components, Props, $emit)
- `index.html`: Navigation hub and technical overview for Session 7.
- `bai1.html`: **Product Management with Search, Filtering, and Statistics**
  - Dataset: 7 initial products categorized across 3 categories (Electronics, Stationery, Lifestyle).
  - Stock status visualization: In-Stock vs. Out-of-Stock badge indicators.
  - Case-insensitive search on product names (`searchQuery.trim().toLowerCase()`).
  - Category filtering across all items and individual categories.
  - Price sorting: Ascending and descending sort without mutating the original source array (`[...array].sort()`).
  - Combined filtering: Search keyword, category selection, and price sorting operate cohesively.
  - Product creation with strict validation: non-empty name, price > 0, and integer stock >= 0.
  - Product removal with window confirmation.
  - Computed metrics: Displayed count vs. total count ratio, total inventory valuation (price * stock) of displayed items.
  - Watcher implementation: `watch` monitors `searchQuery` length, triggering a prompt when length equals exactly 1 character, and clearing it when empty or >= 2 characters.
  - Lifecycle hook: `mounted()` sets application status to "Ready" (`pageStatus = 'Sẵn sàng'`).
- `bai2.html` & `components/TheSanPham.js`: **Product Catalog with Custom Component**
  - Component separation: Clean architecture with `<the-san-pham>` defined in `components/TheSanPham.js`.
  - Component registration: Registered globally via `app.component('the-san-pham', TheSanPham)` prior to `app.mount()`.
  - Props validation:
    - `ten`: Type `String`, required.
    - `gia`: Type `Number`, required, validator ensuring non-negative.
    - `anh`: Type `String`, default fallback image `default-product.jpg`.
    - `moTa`: Type `String`, default placeholder description.
    - `soLuongTon`: Type `Number`, default 0.
  - Independent component state: Description toggle state `hienThiMoTa` stored within each component's local `data()`, preventing cross-component state leakage.
  - Out-of-stock behavior: Automatic out-of-stock badge and button lock (`disabled`) when `soLuongTon <= 0`.
- `bai3.html` & `components/DongGioHang.js`: **Shopping Cart with Props and Custom Events ($emit)**
  - One-Way Data Flow: Parent maintains central cart state; child `<dong-gio-hang>` consumes props and emits change requests.
  - Item schema: `{ id, ten, donGia, soLuong }`.
  - Component communication:
    - Event `doi-so-luong`: Emits product ID and new quantity clamped to [1, 99].
    - Event `yeu-cau-xoa`: Emits product ID to request removal.
  - Child immutability: Child never mutates received props directly.
  - Parent state management: Validates received payload integers within [1, 99] before updating the array.
  - Computed summary: Parent computes total item count and total payable price.
  - Empty state: Displays "Cart is Empty" notice when all items are removed, with an action to reload test data.
  - Standard verification test case: 2 pens (5,000 VND each) and 3 notebooks (12,000 VND each) yield total quantity of 5 and total price of 46,000 VND.

### Session 8: Full-Stack Integration (RESTful PHP API and Vue 3)
- `database.sql`:
  - Definition of `products` table schema (`id INT AUTO_INCREMENT PRIMARY KEY`, `name VARCHAR(100) NOT NULL`, `price INT NOT NULL`, `stock INT NOT NULL`).
  - Seed records: `Bút bi` (5,000 VND, stock 20), `Vở ô ly` (12,000 VND, stock 15), `Thước kẻ` (8,000 VND, stock 0).
- `api/dbConnect.php`:
  - Secure PDO database connection helper with UTF-8 character encoding and sanitized exception handling.
  - Automatic database verification and table creation fallback.
- `api/products.php`:
  - RESTful API routing supporting `GET`, `POST`, `PUT`, and `DELETE` HTTP methods.
  - Format compliance: Standardized JSON responses containing boolean `success`, data payload `data`, and feedback `message`.
  - Server-side parameter validation:
    - `name`: Trimmed length between 1 and 100 characters.
    - `price`: Integer strictly greater than 0 (`price > 0`).
    - `stock`: Integer greater than or equal to 0 (`stock >= 0`). Invalid inputs (such as negative stock or decimal values) are rejected with HTTP 400 prior to database execution.
  - Parameterized queries using PDO prepared statements to prevent SQL injection vulnerabilities.
  - Entity existence verification returning HTTP 404 when attempting to update or delete non-existent IDs.
- `index.html`:
  - Single-page application built with Vue 3 reactive Composition/Options API.
  - Automatic initial data hydration via `GET api/products.php` in `mounted()`.
  - Reactive product table rendered with `v-for`, including visual badges for in-stock and out-of-stock statuses.
  - Two-way data binding with `v-model` for product form inputs (name, price, stock).
  - Mode switching between Add (`POST`) and Edit (`PUT api/products.php?id=X`).
  - Safe record deletion with explicit window confirmation dialog before dispatching `DELETE api/products.php?id=X`.
  - Seamless in-place UI updates without full page reloads following mutations.
  - Contextual user feedback alerts for API successes and errors.

### Session 9: Product Image Upload and Server-Side Pagination
- `database.sql`:
  - Extended `products` table with nullable `image VARCHAR(255) NULL DEFAULT NULL`.
  - Seeded 12 sample products supporting multi-page backend pagination (5 items per page across 3 pages: 5, 5, 2).
- `api/dbConnect.php`:
  - Automatic schema verification adding the `image` column if upgrading an older database, seeding only upon initial table creation so deleting all records preserves the empty state.
  - Safe path-checked helper `removeUploadedImageFile()` for removing superseded or deleted product images.
- `api/products.php`:
  - Server-side paginated `GET api/products.php?page=1&limit=5` endpoint:
    - Validates `page` as a positive integer (`>= 1`, default `1`) and `limit` as `5` (default `5`), returning HTTP 400 for invalid parameters.
    - Orders records by `id DESC`, counts total products, computes `total_pages = max(1, ceil(total / limit))`, and clamps out-of-range `page` parameters to `total_pages` returning the valid page and slice.
    - Returns `{ success, data, pagination: { page, limit, total, total_pages } }`.
  - `POST` returns the newly inserted product ID for subsequent multipart image upload.
  - `PUT` preserves the existing `image` column when modifying product fields without uploading a new image.
  - `DELETE` deletes the product row and cleans up any associated image stored in `uploads/`.
- `api/upload.php`:
  - `POST` endpoint accepting `multipart/form-data` (`product_id`, `image`).
  - Checks `post_max_size` overflow, `UPLOAD_ERR_*` codes, and enforces file size strictly in `[1 byte, 2 MB]`.
  - Verifies actual file binary headers using both `finfo` (`FILEINFO_MIME_TYPE`) and `getimagesize()`, accepting only genuine JPEG (`image/jpeg`) and PNG (`image/png`) files.
  - Generates unique filenames (`product_{id}_{random}.{ext}`) inside `uploads/`, updates the `image` column via PDO prepared statements, and cleans up old images only after the new upload and database update succeed.
- `index.html`:
  - File input with instant image preview (`URL.createObjectURL` with memory cleanup via `URL.revokeObjectURL`), current-image preview during edits, and client-side format/size validation.
  - Two-step save workflow: persists JSON fields via `api/products.php`, then uploads image via `FormData` to `api/upload.php`.
  - Retry workflow on upload failure: retains saved product data (switching to edit mode without creating duplicate rows), preserves any existing image URL, and provides a retry action.
  - Table thumbnails with `"Chưa có ảnh"` fallback badge and pagination controls (`Trước`, `Sau`, `"Trang X / Y — Tổng Z sản phẩm"`) with automatic boundary locking and page adjustment after additions, edits, and deletions.

---

## Execution Instructions

### 1. Database Initialization

#### For Session 4:
```bash
mysql -u root -p < Buoi_4/BuiQuangChien_23001837_ThucHanhBuoi4.sql
```

#### For Session 5:
```bash
mysql -u root -p < Buoi_5/BuiQuangChien_23001837_ThucHanhBuoi5.sql
```

#### For Session 8:
```bash
mysql -u root -p < Buoi_8/database.sql
```

#### For Session 9:
```bash
mysql -u root -p < Buoi_9/database.sql
```

### 2. Local Web Server Execution

#### PHP Applications (Session 4 and Session 5):
Run the built-in PHP development server:
```bash
# Launch server for Session 5
php -S localhost:8000 -t Buoi_5/app/
```
Then navigate to: `http://localhost:8000`

Default test accounts:
- Administrator: `admin` / `admin123`
- Standard User: `chienbq` / `123456`

#### Full-Stack RESTful Applications (Session 8 and Session 9):
Run the built-in PHP development server targeting the target session directory:
```bash
# Launch server for Session 8
php -S localhost:8000 -t Buoi_8/

# Launch server for Session 9
php -S localhost:8000 -t Buoi_9/
```
Then navigate to: `http://localhost:8000`

#### Vue.js Applications (Session 6 and Session 7):
All Vue.js exercises are client-side implementations using modern standards. They can be executed directly without requiring PHP or backend services:
1. Open HTML files directly in any modern browser:
   - Session 6 Hub: `Buoi_6/index.html`
   - Session 7 Hub: `Buoi_7/index.html`
2. Or serve via lightweight HTTP server using Node.js:
```bash
# Serve Session 7 using Node.js npx serve
npx serve Buoi_7
```
```bash
# Serve Session 7 using Python
python -m http.server 8000 --directory Buoi_7
```
Then open: `http://localhost:8000`
