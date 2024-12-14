<?php
session_start();
include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
$error = false;
if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $mysqli->prepare("SELECT * FROM `taikhoan` WHERE `email` = ? AND `matkhau` = ? AND `trangthai` = 1 AND `maQuyen` = 1");
    $stmt->bind_param("ss", $_POST['email'], $_POST['password']); // "ss" means two strings

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        $_SESSION['current_admin'] = $admin;
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
    mysqli_close($mysqli);
    exit;
} else {
    echo json_encode(array(
        'status' => 0,
        'message' => 'Thông tin đăng nhập không đúng'
    ));
    exit;
}
?>