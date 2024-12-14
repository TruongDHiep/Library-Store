<?php
include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\SachController.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\hinhAnhController.php';


// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem các trường thông tin đã được điền đầy đủ chưa
    if (isset($_POST['tensach']) && isset($_POST['tacgia']) && isset($_POST['nhaxuatban']) && isset($_POST['soluong']) && isset($_POST['theloai']) && isset($_POST['taiBan']) && isset($_POST['khuyenMai']) && isset($_POST['trangThai']) && isset($_POST['giaNhap']) && isset($_POST['giaXuat']) && isset($_POST['mota'])) {

        // Tạo kết nối đến CSDL
        if ($mysqli->connect_error) {
            die("Kết nối đến CSDL thất bại: " . $mysqli->connect_error);
        }

        // Tạo instance của controller
        $sachController = new SachController($mysqli);
        $hinhAnhController = new HinhAnhController($mysqli);

        // Lấy dữ liệu từ form
        $tensach = $_POST['tensach'];
        $tacgia = $_POST['tacgia'];
        $nhaxuatban = $_POST['nhaxuatban'];
        $giaNhap = $_POST['giaNhap'];
        $giaXuat = $_POST['giaXuat'];
        $taiBan = $_POST['taiBan'];
        $theloai = $_POST['theloai'];
        $soluong = $_POST['soluong'];
        $khuyenMai = $_POST['khuyenMai'];
        $mota = $_POST['mota'];
        $trangThai = $_POST['trangThai'];

        // Thêm sách bằng cách gọi hàm addSach() từ controller
        $result = $sachController->addSach($tensach, $tacgia, $nhaxuatban, $giaNhap, $giaXuat,  $taiBan, $theloai, $soluong, $khuyenMai, $mota, $trangThai);

        // Kiểm tra và trả về kết quả
        if ($result) {
            echo "Sản phẩm đã được thêm thành công!";

            // Xử lý tải lên ảnh và lưu vào thư mục và cơ sở dữ liệu
            if (!empty($_FILES['product_image']['name'][0])) {
                $targetDirectory = "C:\\xampp\\htdocs\\fahasa\\adminweb\\img\\"; // Thư mục lưu trữ ảnh

                foreach ($_FILES['product_image']['name'] as $key => $image) {
                    $targetFile = $targetDirectory . basename($image);
                    if (move_uploaded_file($_FILES['product_image']['tmp_name'][$key], $targetFile)) {
                        // Lưu thông tin ảnh vào cơ sở dữ liệu
                        $tenHinh = basename($image);
                        $maSach = $mysqli->insert_id; // Lấy mã sách vừa được thêm vào CSDL

                        // Thêm vào bảng hinhAnh với mã sách và tên ảnh
                        $insertImageResult = $hinhAnhController->addImage($maSach, $tenHinh);
                        if ($insertImageResult) {
                        echo "Ảnh đã được thêm vào CSDL.";
                    } else {
                    echo "Có lỗi xảy ra khi thêm ảnh vào CSDL.";
                    }

                }
            }

        } else {
            echo "Đã xảy ra lỗi khi thêm sản phẩm!";
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin!";
    }
} else {
    echo "Phương thức yêu cầu không hợp lệ!";
}
}
?>
