<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\HoaDonController.php';

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maHD = $_POST['maHD'];
$trangThai = $_POST['trangThai']; // Chỉ lấy dữ liệu trạng thái

// Khởi tạo một đối tượng HoaDonController
$hoaDonController = new HoaDonController($mysqli);

// Gọi phương thức updateTrangThaiByMaHD từ HoaDonController
$result = $hoaDonController->updateHoaDonByMaHD($maHD, $trangThai);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "Cập nhật trạng thái thành công!";
} else {
    echo "Cập nhật trạng thái không thành công!";
}
?>
