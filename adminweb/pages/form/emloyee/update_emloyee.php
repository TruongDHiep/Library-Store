<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\EmloyeeController.php'; // Đường dẫn đếnEmloyeeController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maNV = $_POST['maNV'];
$tenNV = $_POST['tenNV'];
$diaChi = $_POST['diaChi'];
$SDT = $_POST['SDT'];
$ngayVaoLam  = $_POST['ngayVaoLam'];
// Khởi tạo một đối tượngEmloyeeController
$EmEmloyeeController = new EmloyeeController($mysqli);

// Gọi phương thức updateEmEmloyeeBymaNV từEmloyeeController
$result = $EmEmloyeeController->updateEmloyeeBymaNV($maNV, $tenNV, $diaChi, $SDT, $ngayVaoLam);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Cập nhật nhân viên thành công!
    ";
    
} else {
    echo "
    Cập nhật nhân viên không thành công!
    ";
}
?>
