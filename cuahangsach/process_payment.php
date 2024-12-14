<?php
session_start();

require_once("connection_db.php");

// Kiểm tra xem yêu cầu là POST và thanh toán đã được kích hoạt
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['data'])) {
        exit(json_encode(array("status" => "error", "message" => "Dữ liệu không hợp lệ.")));
    } else {
        $postData = json_decode($_POST['data'], true);

        // Kiểm tra xem dữ liệu đã được giải mã thành công hay không
        if ($postData === null) {
            exit(json_encode(array("status" => "error", "message" => "Không thể giải mã dữ liệu.")));
        }

        // Lấy thông tin người dùng hiện tại (nếu đã đăng nhập)
        $currentUser = isset($_SESSION['current_user']) ? $_SESSION['current_user'] : null;
        if (!$currentUser) {
            exit(json_encode(array("status" => "error", "message" => "Vui lòng đăng nhập trước khi thanh toán.")));
        }

        // Lấy thông tin từ dữ liệu gửi đi
        $maKH = $currentUser['maKH'];
        $ngayTao = date('Y-m-d');
        $trangThai = 1;
        $trangThaiHoaDon = 1;
        $tongTien = 0;

        // Tính tổng tiền và thêm hóa đơn vào bảng 'hoadon'
        $sql = "INSERT INTO `hoadon`(`maKH`, `tongTien`, `ngayTao`, `trangThai`, `trangThaiHoaDon`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisii", $maKH, $tongTien, $ngayTao, $trangThai, $trangThaiHoaDon);
        if ($stmt->execute()) {
            $maHD = $stmt->insert_id;

            // Thêm các chi tiết hóa đơn vào bảng 'chitiethoadon'
            $sqlChiTiet = "INSERT INTO `chitiethoadon` (`maHD`, `maSach`, `soLuong`, `giaTien`) VALUES (?, ?, ?, ?)";
            $stmtChiTiet = $con->prepare($sqlChiTiet);
            foreach ($postData as $item) {
                $maSach = $item['maSach'];
                $soLuong = $item['soLuong'];
                $giaSach = $item['giaSach'];
                $tongTien += $soLuong * $giaSach;
                $stmtChiTiet->bind_param("iiid", $maHD, $maSach, $soLuong, $giaSach);
                $stmtChiTiet->execute();
            }
            $stmtChiTiet->close();

            // Cập nhật tổng tiền vào hóa đơn
            $sqlUpdateTongTien = "UPDATE `hoadon` SET `tongTien` = ? WHERE `maHD` = ?";
            $stmtUpdateTongTien = $con->prepare($sqlUpdateTongTien);
            $stmtUpdateTongTien->bind_param("di", $tongTien, $maHD);
            $stmtUpdateTongTien->execute();
            $stmtUpdateTongTien->close();

            // Trả về phản hồi thành công
            echo json_encode(array("status" => "success", "message" => "Đã thanh toán thành công!"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Có lỗi xảy ra khi thêm hóa đơn. Vui lòng thử lại sau."));
        }

        $stmt->close();
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Yêu cầu không hợp lệ."));
}

$con->close();
?>
