<?php
include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\EmloyeeController.php';

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form

$tennv = $_POST['tennv'];
$diaChi = $_POST['diachinv'];
$SDT = $_POST['sdtnv'];
$ngayvaolam = $_POST['ngayvaolamnv'];

// Khởi tạo một đối tượng EmloyeeController
$EmloyeeController = new EmloyeeController($mysqli);

// Gọi phương thức addEmloyee từ EmloyeeController và truyền dữ liệu vào
$result = $EmloyeeController->addEmloyee( $tennv, $diaChi, $SDT, $ngayvaolam);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "Thêm nhân viên thành công!";
} else {
    echo "Thêm nhân viên không thành công!";
}
?>
