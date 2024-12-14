<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\ImportController.php'; // Đường dẫn đến ImportController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Lấy dữ liệu từ form
$maPN = $_POST['maPN'];

// Khởi tạo một đối tượng ImportController
$ImportController = new ImportController($mysqli);

// Gọi phương thức updateImportBymaPN từ ImportController
$result = $ImportController->deleteImport($maPN);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Xoá phiếu nhập thành công!
    ";
    
} else {
    echo "
    Xoá phiếu nhập không thành công!
    ";
}
?>
