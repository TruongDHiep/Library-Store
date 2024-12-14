<?php
session_start();
include 'connection_db.php';

if (isset($_POST['thanhtoan'])) {
    if (!isset($_SESSION['current_user'])) {
        $errorMessage = "Vui lòng đăng nhập trước khi thanh toán.";
        echo json_encode(['status' => 'error', 'message' => $errorMessage]);
        exit;
    }

    if (empty($_SESSION['cart'])) {
        $errorMessage = "Vui lòng chọn ít nhất một sản phẩm trước khi thanh toán.";
        echo json_encode(['status' => 'error', 'message' => $errorMessage]);
        exit;
    }

    // Lấy mã khách hàng từ session
    $maKH = $_SESSION['current_user'];

    // Tính tổng tiền từ giỏ hàng
    $tongTien = 0;
    foreach ($_SESSION['cart'] as $item) {
        $tongTien += ($item['giaXuat'] - ($item['giaXuat'] * $item['khuyenMai'] / 100)) * $item['quantity'];
    }

    // Lấy ngày tạo hóa đơn là ngày hiện tại
    $ngayTao = date('Y-m-d');

    // Thiết lập trạng thái hóa đơn là đã thanh toán
    $trangThai = 1;

    // Thực hiện truy vấn để thêm hóa đơn vào cơ sở dữ liệu
    $result = mysqli_query($con, "INSERT INTO `hoadon`(`maKH`, `maNV`, `tongTien`, `ngayTao`, `trangThai`) VALUES ('$maKH', 1, '$tongTien', '$ngayTao', $trangThai)");

    // Kiểm tra và gửi phản hồi
    if ($result) {
        $successMessage = "Đã thanh toán thành công!";
        echo json_encode(['status' => 'success', 'message' => $successMessage]);
    } else {
        $errorMessage = "Có lỗi xảy ra khi thực hiện thanh toán. Vui lòng thử lại sau.";
        echo json_encode(['status' => 'error', 'message' => $errorMessage]);
    }
} else {
    $errorMessage = "Không có yêu cầu thanh toán được gửi đến server.";
    echo json_encode(['status' => 'error', 'message' => $errorMessage]);
}
