<?php
// Bắt đầu hoặc tiếp tục một phiên
session_start();

// Xóa tất cả các biến trong phiên
session_unset();

// Hủy bỏ phiên
session_destroy();

// Sau khi hủy bỏ phiên, bạn có thể chuyển hướng người dùng đến trang khác
// Ví dụ: chuyển hướng đến trang chính của ứng dụng hoặc trang đăng nhập
header("Location: ../cuahangsach/index.php");
exit(); // Đảm bảo dừng kịp thời của mã PHP sau khi chuyển hướng
?>
