<?php
session_start();
include 'connection_db.php';
if (isset($_POST['oldpass']) && !empty($_POST['oldpass']) && isset($_POST['newpass']) && !empty($_POST['newpass'])) {
    $stmt = $con->prepare("UPDATE `taikhoan` SET `matKhau` = ? WHERE `email` = ?");
    $stmt->bind_param("ss", $_POST['newpass'], $_SESSION['current_user']['email']);
    if ($stmt->execute()) {
        echo json_encode(array(
            'status' => 1,
            'message' => 'Đổi mật khẩu thành công'
        ));
    } else {
        echo json_encode(array(
            'status' => 0,
            'message' => 'Có lỗi khi đổi mật khẩu, xin vui lòng thử lại'
        ));
    }
    $stmt->close();
    mysqli_close($con);
} else {
    echo json_encode(array(
        'status' => 0,
        'message' => 'Bạn chưa nhập đủ thông tin'
    ));
}
