<?php
session_start();
include 'connection_db.php';
if (isset($_POST['tenKH']) && !empty($_POST['tenKH']) && isset($_POST['SDT']) && !empty($_POST['SDT']) && isset($_POST['diaChi']) && !empty($_POST['diaChi'])){
    $stmt = $con->prepare("UPDATE `khachhang` SET `tenKH` = ?, `SDT` = ?, `diaChi` = ? WHERE `maTK` = ?");
    $stmt->bind_param("ssss", $_POST['tenKH'], $_POST['SDT'], $_POST['diaChi'], $_SESSION['current_user']['maTK']);
    if ($stmt->execute()) {
        // Update the session data
        $_SESSION['current_user']['tenKH'] = $_POST['tenKH'];
        $_SESSION['current_user']['SDT'] = $_POST['SDT'];
        $_SESSION['current_user']['diaChi'] = $_POST['diaChi'];
        
        echo json_encode(array(
            'status' => 1,
            'message' => 'Cập nhật thành công'
        ));
    } else {
        echo json_encode(array(
            'status' => 0,
            'message' => 'Có lỗi khi cập nhật thông tin, xin vui lòng thử lại'
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
