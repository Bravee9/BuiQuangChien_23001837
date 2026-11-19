<?php
/**
 * STUDENT: BUI QUANG CHIEN - ID: 23001837 - CLASS: K68A3
 * Purpose: Transparent browser wrapper rendering CLI output inside Bravechat Dark Workspace UI
 * while preserving pure plain-text output when executed via PHP CLI.
 */

if (PHP_SAPI !== 'cli' && !defined('BRAVECHAT_CLI_WEB_SHELL')) {
    define('BRAVECHAT_CLI_WEB_SHELL', true);
    ob_start();

    register_shutdown_function(function () {
        $rawOutput = ob_get_clean();
        if ($rawOutput === false) {
            $rawOutput = '';
        }

        $scriptName = basename($_SERVER['SCRIPT_NAME'] ?? 'bai1.php');
        $navItems = [
            'index.php' => 'Tổng quan',
            'bai1.php'  => 'Bài 1: Mảng & Vòng lặp',
            'bai2.php'  => 'Bài 2: Tách hàm',
            'bai3.php'  => 'Bài 3: Xử lý danh sách',
            'bai4.php'  => 'Bài 4: OOP Student',
        ];
        $pageLabel = $navItems[$scriptName] ?? $scriptName;
        $lines = preg_split("/\r\n|\n|\r/", rtrim($rawOutput, "\r\n"));
        ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="color-scheme" content="dark">
  <title>Buổi 1 - <?= htmlspecialchars($pageLabel, ENT_QUOTES, 'UTF-8') ?> | Bùi Quang Chiến</title>
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
        <?php foreach ($navItems as $file => $label): ?>
          <a href="<?= htmlspecialchars($file, ENT_QUOTES, 'UTF-8') ?>" class="nav-link <?= $scriptName === $file ? 'active' : '' ?>">
            <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
          </a>
        <?php endforeach; ?>
      </nav>
      <div class="student-tag">
        <strong>Bùi Quang Chiến</strong>
        <span>23001837</span>
      </div>
    </div>
  </header>

  <main class="main-content">
    <div class="page-intro">
      <h2 class="page-title"><?= htmlspecialchars($pageLabel, ENT_QUOTES, 'UTF-8') ?></h2>
      <p class="page-subtitle">Kết quả thực thi PHP được hiển thị trong giao diện Console chuẩn Bravechat Dark Workspace.</p>
    </div>

    <section class="card">
      <div class="card-header">
        <span class="card-title">php <?= htmlspecialchars($scriptName, ENT_QUOTES, 'UTF-8') ?></span>
        <div style="display: flex; align-items: center; gap: 8px;">
          <span class="badge-cli">stdout</span>
          <button type="button" class="btn btn-outline btn-sm" id="copyConsoleBtn">Sao chép kết quả</button>
        </div>
      </div>
      <div class="console-panel" id="consoleOutput" tabindex="0" role="region" aria-label="Kết quả chạy PHP">
        <?php foreach ($lines as $idx => $line):
            $rowClass = 'console-line';
            if (strpos($line, '===') !== false || strpos($line, '---') !== false) {
                $rowClass .= ' console-heading';
            } elseif (strpos($line, '=>') !== false) {
                $rowClass .= ' console-result';
            } elseif (stripos($line, 'Lỗi:') !== false) {
                $rowClass .= ' console-error';
            }
        ?>
          <div class="<?= $rowClass ?>">
            <span class="console-ln"><?= $idx + 1 ?></span>
            <span class="console-text"><?= $line === '' ? ' ' : htmlspecialchars($line, ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <footer class="app-footer">
    <strong>Bùi Quang Chiến (23001837)</strong> - Lớp K68A3 - MAT3542 1 Phát triển ứng dụng web
  </footer>

  <script>
    (function () {
      const btn = document.getElementById('copyConsoleBtn');
      const rawText = <?= json_encode($rawOutput, JSON_UNESCAPED_UNICODE) ?>;
      if (!btn || !navigator.clipboard) return;
      btn.addEventListener('click', function () {
        navigator.clipboard.writeText(rawText).then(function () {
          btn.textContent = 'Đã sao chép';
          setTimeout(function () { btn.textContent = 'Sao chép kết quả'; }, 1500);
        });
      });
    })();
  </script>
</body>
</html>
        <?php
    });
}
