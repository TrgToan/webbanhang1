<?php
session_start(); // Bắt đầu phiên

// Xóa tất cả các biến phiên
$_SESSION = [];

// Hủy phiên
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit();
?>
