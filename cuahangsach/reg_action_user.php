<?php
session_start();
include 'connection_db.php';

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $con->begin_transaction();
    try {
        // Chèn dữ liệu vào bảng taikhoan
        $stmt = $con->prepare("INSERT INTO `taikhoan` (`email`, `matkhau`, `trangThai`, `maQuyen`) VALUES (?, ?, 1, 2)");
        $stmt->bind_param("ss", $email, $password);

        if (!$stmt->execute()) {
            if (strpos($stmt->error, "Duplicate entry") !== FALSE) {
                throw new Exception('Tên đăng nhập đã tồn tại');
            } else {
                throw new Exception('Có lỗi khi đăng ký, xin mời thử lại');
            }
        }

        // Lấy maTK vừa chèn vào
        $result = $con->query("SELECT maTK FROM `taikhoan` WHERE `email` = '$email'");
        if ($result->num_rows > 0) {
            $maTK = $result->fetch_assoc()['maTK'];

            // Chèn dữ liệu vào bảng khachhang
            $stmt2 = $con->prepare("INSERT INTO `khachhang` (`maTK`, `trangThai`) VALUES (?, 1)");
            $stmt2->bind_param("s", $maTK);

            if (!$stmt2->execute()) {
                throw new Exception('Có lỗi khi đăng ký, xin mời thử lại');
            }

            // Xác nhận giao dịch
            $con->commit();
            $maKH = $con->query("SELECT maKH FROM `khachhang` WHERE `maTK` = '$maTK'")->fetch_assoc()['maKH'];
            $user = array(
                'maTK' => $maTK,
                'email' => $email,
                'matKhau' => $password,
                'tenKH' => '',
                'diaChi' => '',
                'SDT' => '',
                'maKH' => $maKH
            );
            $_SESSION['current_user'] = $user;
            echo json_encode(array(
                'status' => 1,
                'message' => 'Đăng ký thành công'
            ));
        } else {
            throw new Exception('Có lỗi khi đăng ký, xin mời thử lại');
        }

        // Đóng các câu lệnh chuẩn bị
        $stmt->close();
        $stmt2->close();
    } catch (Exception $e) {
        // Hoàn tác giao dịch nếu có lỗi
        $con->rollback();
        echo json_encode(array(
            'status' => 0,
            'message' => $e->getMessage()
        ));
    }

    // Đóng kết nối cơ sở dữ liệu
    $con->close();
} else {
    echo json_encode(array(
        'status' => 0,
        'message' => 'Bạn chưa nhập thông tin'
    ));
}
?>