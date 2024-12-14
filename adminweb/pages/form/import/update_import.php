<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\ImportController.php'; // Đường dẫn đến ImportController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maPN= $_POST['maPN'];
$maNCC = $_POST['maNCC'];
$maNV = $_POST['maNV'];
$tongTien = $_POST['tongTien'];
$ngayTao = $_POST['ngayTao'];

// Khởi tạo một đối tượng ImportController
$ImportController = new ImportController($mysqli);

// Gọi phương thức updateImportBymaNCC từ ImportController
$result = $ImportController->updateimportBymaPN($maPN, $maNCC, $maNV, $tongTien, $ngayTao);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Cập nhật phiếu nhập  thành công!
    ";
    
} else {
    echo "
    Cập nhật phiếu nhập  không thành công!
    ";
}
?>
