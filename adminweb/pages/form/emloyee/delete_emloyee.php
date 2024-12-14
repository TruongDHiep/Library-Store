<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\EmloyeeController.php'; // Đường dẫn đến EmloyeeController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Lấy dữ liệu từ form
$maNV = $_POST['maNV'];

// Khởi tạo một đối tượng EmloyeeController
$EmloyeeController = new EmloyeeController($mysqli);

// Gọi phương thức updateEmloyeeBymaNV$maNV từ EmloyeeController
$result = $EmloyeeController->deleteEmloyee($maNV);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Xoá nhân viên thành công!
    ";
    
} else {
    echo "
    Xoá nhân viên không thành công!
    ";
}
?>
