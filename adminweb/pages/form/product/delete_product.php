<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\sachController.php'; 
include 'C:\xampp\htdocs\fahasa\adminweb\controller\hinhAnhController.php'; 


// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Lấy dữ liệu từ form
$maSach = $_POST['maSach'];

// Khởi tạo một đối tượng HoaDonController
$sachController = new sachController($mysqli);
$hinhanhcontroller = new HinhAnhController($mysqli);

// Gọi phương thức updateHoaDonByMaHD từ HoaDonController

$result2 = $sachController->deleteSach($maSach);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result2) {
    echo "
    Xoá sách thành công!
    ";
    
} else {
    echo "
    Xoá sách không thành công!
    ";
}
?>
