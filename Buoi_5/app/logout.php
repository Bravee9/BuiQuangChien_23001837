<?php
/**
 * HỌ VÀ TÊN: BÙI QUANG CHIẾN - MSV: 23001837 - LỚP: K68A3
 * File: logout.php
 * Mục đích: Xóa thông tin phiên đăng nhập bằng session và chuyển hướng người dùng về login.php
 */

require_once __DIR__ . '/common/auth.php';

// Xóa toàn bộ thông tin phiên làm việc
logoutUser();

// Chuyển hướng người dùng về trang đăng nhập với thông báo
header('Location: login.php?msg=logged_out');
exit;
