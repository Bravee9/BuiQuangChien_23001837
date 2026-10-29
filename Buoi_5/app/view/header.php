<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: view/header.php
 * Mục đích: Header giao diện dùng chung cho toàn bộ ứng dụng
 */

require_once __DIR__ . '/../common/auth.php';

if (!isset($pageTitle)) {
    $pageTitle = 'Quản lý giỏ hàng & Sản phẩm';
}

$currentScript = basename($_SERVER['SCRIPT_NAME']);
$loggedIn = isLoggedIn();
$currentUser = getLoggedUser();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header class="app-header">
        <div class="header-container">
            <a href="<?= $loggedIn ? 'product_list.php' : 'login.php' ?>" class="brand-title">
                <span class="brand-badge">SC</span>
                <span>SHOPPING CART SYSTEM</span>
            </a>

            <nav class="nav-links">
                <?php if ($loggedIn): ?>
                    <a href="product_list.php" class="nav-link <?= ($currentScript === 'product_list.php' || $currentScript === 'index.php') ? 'active' : '' ?>">
                        Danh sách sản phẩm
                    </a>
                    <a href="product_add.php" class="nav-link <?= ($currentScript === 'product_add.php') ? 'active' : '' ?>">
                        Thêm sản phẩm
                    </a>
                <?php else: ?>
                    <a href="login.php" class="nav-link <?= ($currentScript === 'login.php' || $currentScript === 'index.php') ? 'active' : '' ?>">
                        Đăng nhập
                    </a>
                    <a href="register.php" class="nav-link <?= ($currentScript === 'register.php') ? 'active' : '' ?>">
                        Đăng ký
                    </a>
                <?php endif; ?>
            </nav>

            <div class="user-panel">
                <?php if ($loggedIn): ?>
                    <div class="user-badge">
                        <span>Tài khoản:</span>
                        <strong><?= htmlspecialchars($currentUser, ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                    <a href="logout.php" class="btn btn-outline btn-sm btn-logout" title="Đăng xuất khỏi hệ thống">
                        Đăng xuất
                    </a>
                <?php else: ?>
                    <span class="guest-badge">Chưa đăng nhập</span>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="app-main">
