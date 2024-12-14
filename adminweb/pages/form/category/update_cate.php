<?php

include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\loaiSachController.php'; // Đường dẫn đến supplierController.php

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maLoai = $_POST['maLoai'];
$tenLoai = $_POST['tenLoai'];
$chiTiet = $_POST['chiTiet'];
$trangThai = $_POST['trangThai'];

// Khởi tạo một đối tượng supplierController
$loaisachController = new LoaiSachController($mysqli);

// Gọi phương thức updatesupplierBymaNCC từ supplierController
$result = $loaisachController->editLoaiSach($maLoai, $tenLoai, $chiTiet, $trangThai);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "
    Cập nhật loại sách thành công!
    ";
    
} else {
    echo "
    Cập nhật loại sách không thành công!
    ";
}
?>
