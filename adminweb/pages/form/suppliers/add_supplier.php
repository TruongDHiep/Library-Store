<?php
include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\SupplierController.php';

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maNCC = $_POST['mancc'];
$tenNCC = $_POST['tenncc'];
$diaChi = $_POST['diachincc'];
$SDT = $_POST['sdtncc'];


// Khởi tạo một đối tượng SupplierController
$supplierController = new SupplierController($mysqli);

// Gọi phương thức addSupplier từ SupplierController và truyền dữ liệu vào
$result = $supplierController->addSupplier( $tenNCC, $diaChi, $SDT,1);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "Thêm nhà cung cấp thành công!";
} else {
    echo "Thêm nhà cung cấp không thành công!";
}
?>
