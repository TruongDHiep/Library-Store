<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\CustomerController.php'; // Đường dẫn đếnCustomerController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maKH = $_POST['maKH'];
$tenKH = $_POST['tenKH'];
$diaChi = $_POST['diaChi'];
$SDT = $_POST['SDT'];
$email  = $_POST['email'];
// Khởi tạo một đối tượngCustomerController
$EmCustomerController = new CustomerController($mysqli);

// Gọi phương thức updateEmCustomerBymaKH$maKH từCustomerController
$result = $EmCustomerController->updateCustomerBymaKH($maKH, $tenKH, $diaChi, $SDT, $email);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Cập nhật khach hang thành công!
    ";
    
} else {
    echo "
    Cập nhật khach hang thành công!
    ";
}
?>
