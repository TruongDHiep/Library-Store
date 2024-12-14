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
        $maSach = $_POST['maSach'];
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
        $result = $sachController->editSach($maSach, $tensach, $tacgia, $nhaxuatban, $giaNhap, $giaXuat,  $taiBan, $theloai, $soluong, $khuyenMai, $mota, $trangThai);

        if ($result) {
            echo "Sản phẩm đã được thêm thành công !  $mota $tensach ";
        
            if (!empty($_FILES['product_image']['name'][0])) {
                $targetDirectory = "C:\\xampp\\htdocs\\fahasa\\adminweb\\img\\";
                
                // Ensure the target directory exists and is writable
                if (!is_dir($targetDirectory)) {
                    mkdir($targetDirectory, 0755, true);
                }
                
                $oldImages = $hinhAnhController->getImagesByBookId($maSach);
                
                $delImageResult = $hinhAnhController->deleteImage($maSach);
                
                if ($delImageResult) {
                    foreach ($oldImages as $oldImage) {
                        $imagePath = $targetDirectory . $oldImage['maHinh'];
                        if (file_exists($imagePath)) {
                            if (unlink($imagePath)) {
                                echo "Ảnh " . $oldImage['maHinh'] . " đã được xóa khỏi thư mục.";
                            } else {
                                echo "Có lỗi xảy ra khi xóa ảnh " . $oldImage['maHinh'] . " từ thư mục.";
                            }
                        } else {
                            echo "Ảnh " . $oldImage['maHinh'] . " không tồn tại trong thư mục.";
                        }
                    }
                    
                    foreach ($_FILES['product_image']['name'] as $key => $image) {
                        $targetFile = $targetDirectory . basename($image);
                        
                        // Check if file already exists, if yes, generate a unique filename
                        $count = 1;
                        while (file_exists($targetFile)) {
                            $targetFile = $targetDirectory . pathinfo($image, PATHINFO_FILENAME) . '_' . $count . '.' . pathinfo($image, PATHINFO_EXTENSION);
                            $count++;
                        }
                        
                        if (move_uploaded_file($_FILES['product_image']['tmp_name'][$key], $targetFile)) {
                            $tenHinh = basename($targetFile);
                            $insertImageResult = $hinhAnhController->addImage($maSach, $tenHinh);
                            
                            if ($insertImageResult) {
                                echo "Ảnh " . $tenHinh . " đã được thêm vào CSDL.";
                            } else {
                                echo "Có lỗi xảy ra khi thêm ảnh " . $tenHinh . " vào CSDL.";
                            }
                        }
                    }
                } else {
                    echo "Đã xảy ra lỗi khi xóa các ảnh của sách có mã " . $maSach . " từ CSDL!";
                }
            } else {
                echo "Vui lòng chọn ít nhất một ảnh để tải lên!";
            }
        }
    }
}            