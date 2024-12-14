<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\HoaDonController.php';

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['maHD'])) {
        $maHDs = json_decode($_POST['maHD']);
        // Xử lý các mã hóa đơn
        foreach ($maHDs as $maHD) {
            $hoaDonController = new HoaDonController($mysqli);
            $result = $hoaDonController->duyet($maHD); 
        }
     
    echo "duyệt thành công !";
        
    } else {
        echo "Không có mã hóa đơn nào được chọn.";
    }
}

?>
