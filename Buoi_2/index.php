<?php
/**
 * STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
 * File: Buoi_2/index.php
 */
$exercises = [
    ['file' => 'bai1.php', 'num' => '01', 'tag' => 'OOP Shopping Cart', 'title' => 'Bài 1: Quản lý Giỏ hàng (CartItem & ShoppingCart)', 'desc' => 'Đóng gói lớp CartItem và ShoppingCart, kiểm tra giá/số lượng âm, xóa theo tên và tính tổng tiền.'],
    ['file' => 'bai2.php', 'num' => '02', 'tag' => 'OOP Cinema System', 'title' => 'Bài 2: Quản lý Đặt vé Rạp chiếu phim (Movie)', 'desc' => 'Xây dựng lớp Movie với đặt vé, hủy vé, kiểm soát ghế trống, tính doanh thu và tìm phim bán chạy nhất.'],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="color-scheme" content="dark">
  <title>Buổi 2: PHP Nâng cao &amp; OOP | Bùi Quang Chiến</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="app-header">
    <div class="header-inner">
      <a href="index.php" class="header-brand">
        <div class="brand-icon" aria-hidden="true">B2</div>
        <div class="brand-text">
          <h1>MAT3542 1 - BUỔI THỰC HÀNH 2</h1>
          <span>PHP Nâng cao &amp; Lập trình OOP</span>
        </div>
      </a>
      <nav class="header-nav" aria-label="Điều hướng bài tập buổi 2">
        <a href="index.php" class="nav-link active">Tổng quan</a>
        <a href="bai1.php" class="nav-link">Bài 1</a>
        <a href="bai2.php" class="nav-link">Bài 2</a>
      </nav>
      <div class="student-tag">
        <strong>Bùi Quang Chiến</strong>
        <span>23001837</span>
      </div>
    </div>
  </header>

  <main class="main-content">
    <div class="page-intro">
      <h2 class="page-title">Tổng quan Buổi thực hành 2 - PHP Nâng cao &amp; OOP</h2>
      <p class="page-subtitle">Chọn bài tập bên dưới để chạy và xem kết quả trong giao diện Console Dark Workspace.</p>
    </div>

    <div class="exercise-grid">
      <?php foreach ($exercises as $ex): ?>
        <article class="exercise-card">
          <div class="exercise-meta">
            <span>EX-<?= $ex['num'] ?></span>
            <span class="badge-cli"><?= htmlspecialchars($ex['tag'], ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <h3><?= htmlspecialchars($ex['title'], ENT_QUOTES, 'UTF-8') ?></h3>
          <p><?= htmlspecialchars($ex['desc'], ENT_QUOTES, 'UTF-8') ?></p>
          <div>
            <a href="<?= htmlspecialchars($ex['file'], ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary btn-sm">Chạy <?= htmlspecialchars($ex['file'], ENT_QUOTES, 'UTF-8') ?></a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </main>

  <footer class="app-footer">
    <strong>Bùi Quang Chiến (23001837)</strong> - Lớp K68A3 - MAT3542 1 Phát triển ứng dụng web
  </footer>
</body>
</html>
