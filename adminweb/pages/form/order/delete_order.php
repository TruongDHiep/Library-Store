<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\HoaDonController.php'; // Đường dẫn đến HoaDonController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Lấy dữ liệu từ form
$maHD = $_POST['maHD'];

// Khởi tạo một đối tượng HoaDonController
$hoaDonController = new HoaDonController($mysqli);

// Gọi phương thức updateHoaDonByMaHD từ HoaDonController
$result = $hoaDonController->deleteHoaDon($maHD);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Xoá hóa đơn thành công!
    ";
    
} else {
    echo "
    Xoá hóa đơn không thành công!
    ";
}
?>
