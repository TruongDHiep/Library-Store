<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\SupplierController.php'; // Đường dẫn đến supplierController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maNCC = $_POST['maNCC'];
$tenNCC = $_POST['tenNCC'];
$diaChi = $_POST['diaChi'];
$SDT = $_POST['SDT'];


// Khởi tạo một đối tượng supplierController
$supplierController = new supplierController($mysqli);

// Gọi phương thức updatesupplierBymaNCC từ supplierController
$result = $supplierController->updatesupplierBymaNCC($maNCC, $tenNCC, $diaChi, $SDT);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Cập nhật nhà cung cấp thành công!
    ";
    
} else {
    echo "
    Cập nhật nhà cung cấp không thành công!
    ";
}
?>
