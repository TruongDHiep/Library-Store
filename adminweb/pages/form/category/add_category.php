<?php
include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\loaiSachController.php';

// Kiểm tra kết nối đã được thiết lập chưa
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy dữ liệu từ form
$maLoai = $_POST['maLoai'];
$tenLoai = $_POST['tenLoai'];
$chiTiet = $_POST['chiTiet'];
$trangThai = (int) 1;


// Khởi tạo một đối tượng SupplierController
$cateController = new LoaiSachController($mysqli);

// Gọi phương thức addSupplier từ SupplierController và truyền dữ liệu vào
$result = $cateController->addLoaiSach($tenLoai, $chiTiet,(int) $trangThai);

// Kiểm tra kết quả và hiển thị thông báo tương ứng
if ($result) {
    echo "Thêm loại sách thành công!";
} else {
    echo "Thêm loại sách không thành công!";
}
?>
