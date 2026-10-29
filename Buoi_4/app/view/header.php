<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837
 * File: view/header.php
 * Mục đích: Phần đầu trang HTML dùng chung cho toàn bộ ứng dụng
 */

if (!isset($pageTitle)) {
    $pageTitle = 'Quản lý sản phẩm - Giỏ hàng';
}

// Lấy tên file hiện tại để kích hoạt class active cho menu
$currentScript = basename($_SERVER['SCRIPT_NAME']);
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
            <a href="product_list.php" class="brand-title">
                <span class="brand-badge">SC</span>
                <span>SHOPPING CART SYSTEM</span>
            </a>
            <nav class="nav-links">
                <a href="product_list.php" class="nav-link <?= ($currentScript === 'product_list.php' || $currentScript === 'index.php') ? 'active' : '' ?>">
                    Danh sách sản phẩm
                </a>
                <a href="product_add.php" class="nav-link <?= ($currentScript === 'product_add.php') ? 'active' : '' ?>">
                    Thêm sản phẩm
                </a>
            </nav>
        </div>
    </header>

    <main class="main-container">
