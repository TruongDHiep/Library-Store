<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\SupplierController.php'; // Đường dẫn đến supplierController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Lấy dữ liệu từ form
$maNCC = $_POST['maNCC'];

// Khởi tạo một đối tượng supplierController
$supplierController = new supplierController($mysqli);

// Gọi phương thức updatesupplierBymaNCC từ supplierController
$result = $supplierController->deletesupplier($maNCC);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Xoá nhà cung cấp thành công!
    ";
    
} else {
    echo "
    Xoá nhà cung cấp không thành công!
    ";
}
?>
