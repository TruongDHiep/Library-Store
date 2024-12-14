<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\sachController.php'; 
include 'C:\xampp\htdocs\fahasa\adminweb\controller\loaiSachController.php'; 


// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Lấy dữ liệu từ form
$maLoai = $_POST['maLoai'];

// Khởi tạo một đối tượng HoaDonController
$sachController = new sachController($mysqli);
$loaisachController = new LoaiSachController($mysqli);



// Gọi phương thức updateHoaDonByMaHD từ HoaDonController
$result1 = $sachController->updateMaLoai($maLoai);
$result2 = $loaisachController->deleteLoaiSach($maLoai);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result1 && $result2) {
    echo "
    Xoá sách thành công!
    ";
    
} else {
    echo "
    Xoá sách không thành công!
    ";
}
?>
