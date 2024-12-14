<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\UsersController.php';

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maTk = $_POST['maTK'];
$tenTk = $_POST['taiKhoan'];
$matKhau = $_POST['matKhau'];
$maQuyen = $_POST['maQuyen'];
$trangThai = $_POST['trangThai']; // Chỉ lấy dữ liệu trạng thái

// Khởi tạo một đối tượng UserController
$usercontroller = new UserController($mysqli);

// Gọi phương thức updateTrangThaiByMaTK từ UserController
$result = $usercontroller->updateUserBymaTK($maTk,$tenTk, $matKhau, $trangThai, $maQuyen);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "Cập nhật trạng thái thành công!";
} else {
    echo "Cập nhật trạng thái không thành công!";
}
?>
