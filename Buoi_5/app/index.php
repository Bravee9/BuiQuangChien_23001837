<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: index.php
 * Mục đích: Điểm vào ứng dụng.
 * Tự động kiểm tra session: nếu đã đăng nhập thì sang product_list.php, ngược lại sang login.php
 */

require_once __DIR__ . '/common/auth.php';

if (isLoggedIn()) {
    header('Location: product_list.php');
} else {
    header('Location: login.php');
}
exit;
