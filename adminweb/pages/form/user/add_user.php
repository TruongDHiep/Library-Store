<?php
include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\UsersController.php';

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem các trường thông tin đã được điền đầy đủ chưa
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['status']) && isset($_POST['role'])) {
        // Lấy dữ liệu từ form
        $email = $_POST['email'];
        $password = $_POST['password'];
        $status = $_POST['status'];
        $role = $_POST['role'];

        // Tạo kết nối đến CSDL
        if ($mysqli->connect_error) {
            die("Kết nối đến CSDL thất bại: " . $mysqli->connect_error);
        }

        // Tạo instance của controller
        $taikhoanController = new UserController($mysqli);

        // Thêm tài khoản bằng cách gọi hàm addTaiKhoan() từ controller
        $result = $taikhoanController->addUser($email, $password, $status, $role);

        // Kiểm tra và trả về kết quả
        if ($result) {
            echo "Tài khoản đã được thêm thành công!";
        } else {
            echo "Đã xảy ra lỗi khi thêm tài khoản!";
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin!";
    }
} else {
    echo "Phương thức yêu cầu không hợp lệ!";
}
?>
