<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\CustomerController.php'; // Đường dẫn đến HoaDonController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Lấy dữ liệu từ form
$maKH = $_POST['maKH'];

// Khởi tạo một đối tượng HoaDonController
$CustomerController = new CustomerController($mysqli);

// Gọi phương thức updateHoaDonByMaHD từ HoaDonController
$result = $CustomerController->deleteCustomer($maKH);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Xoá khách hàng thành công!
    ";
    
} else {
    echo "
    Xoá khách hàng không thành công!
    ";
}
?>
