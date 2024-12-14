<?php
include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\ImportController.php';

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maNCC = $_POST['mancc'];
$maNV = $_POST['manv'];
$tongTien = $_POST['tongtien'];
$ngayTao = $_POST['ngaytao'];

// Khởi tạo một đối tượng ImportController
$ImportController = new ImportController($mysqli);

// Gọi phương thức addImport từ ImportController và truyền dữ liệu vào
$result = $ImportController->addImport( $maNCC, $maNV, $tongTien, $ngayTao);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "Thêm phiếu nhập thành công!";
} else {
    echo "Thêm phiếu nhập không thành công!";
}
?>
