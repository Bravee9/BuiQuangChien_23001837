<?php
/**
 * STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
 * File: Buoi_1/index.php
 */
$exercises = [
    ['file' => 'bai1.php', 'num' => '01', 'tag' => 'Arrays & Loops', 'title' => 'Bài 1: Mảng và vòng lặp', 'desc' => 'Khai báo danh sách sinh viên, duyệt mảng với foreach và tính điểm trung bình an toàn.'],
    ['file' => 'bai2.php', 'num' => '02', 'tag' => 'Functions', 'title' => 'Bài 2: Tách hàm xử lý', 'desc' => 'Xây dựng hàm calculateAverageScore, getRank và displayStudent, kiểm thử danh sách rỗng.'],
    ['file' => 'bai3.php', 'num' => '03', 'tag' => 'Collection Queries', 'title' => 'Bài 3: Xử lý danh sách sinh viên', 'desc' => 'Tìm sinh viên điểm cao nhất, thấp nhất, đếm số đạt và tìm kiếm theo họ tên.'],
    ['file' => 'bai4.php', 'num' => '04', 'tag' => 'OOP Basics', 'title' => 'Bài 4: Hướng đối tượng (Student)', 'desc' => 'Đóng gói lớp Student với các phương thức getRank(), isPassed(), display() và hàm thống kê OOP.'],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="color-scheme" content="dark">
  <title>Buổi 1: PHP Cơ bản | Bùi Quang Chiến</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="app-header">
    <div class="header-inner">
      <a href="index.php" class="header-brand">
        <div class="brand-icon" aria-hidden="true">B1</div>
        <div class="brand-text">
          <h1>MAT3542 1 - BUỔI THỰC HÀNH 1</h1>
          <span>PHP Cơ bản: Mảng, Hàm &amp; OOP</span>
        </div>
      </a>
      <nav class="header-nav" aria-label="Điều hướng bài tập buổi 1">
        <a href="index.php" class="nav-link active">Tổng quan</a>
        <a href="bai1.php" class="nav-link">Bài 1</a>
        <a href="bai2.php" class="nav-link">Bài 2</a>
        <a href="bai3.php" class="nav-link">Bài 3</a>
        <a href="bai4.php" class="nav-link">Bài 4</a>
      </nav>
      <div class="student-tag">
        <strong>Bùi Quang Chiến</strong>
        <span>23001837</span>
      </div>
    </div>
  </header>

  <main class="main-content">
    <div class="page-intro">
      <h2 class="page-title">Tổng quan Buổi thực hành 1 - PHP Cơ bản</h2>
      <p class="page-subtitle">Chọn một bài tập bên dưới để chạy và xem kết quả thực thi trong giao diện Console Dark Workspace.</p>
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
