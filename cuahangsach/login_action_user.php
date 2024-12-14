<?php
session_start();
include 'connection_db.php';

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $con->prepare("SELECT taikhoan.*, khachhang.maKH, khachhang.tenKH, khachhang.diaChi, khachhang.SDT 
                           FROM taikhoan 
                           JOIN khachhang ON taikhoan.maTK = khachhang.maTK 
                           WHERE taikhoan.email = ? AND taikhoan.matKhau = ? AND taikhoan.trangThai = 1 AND taikhoan.maQuyen = 2");
    $stmt->bind_param("ss", $_POST['email'], $_POST['password']); // "ss" means two strings

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['current_user'] = $user;
        echo json_encode(array(
            'status' => 1,
            'message' => 'Đăng nhập thành công'
        ));
    } else {
        echo json_encode(array(
            'status' => 0,
            'message' => 'Thông tin đăng nhập không đúng'
        ));
    }

    // Close the statement and the connection
    $stmt->close();
    mysqli_close($con);
    exit;
} else {
    echo json_encode(array(
        'status' => 0,
        'message' => 'Thông tin đăng nhập không đúng'
    ));
    exit;
}
?>