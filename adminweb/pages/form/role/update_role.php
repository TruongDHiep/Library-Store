<?php
include_once 'C:\xampp\htdocs\fahasa\adminweb\controller\quyenController.php'; 
include_once 'C:\xampp\htdocs\fahasa\adminweb\controller\ctq_cnController.php'; 
include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';



// Kiểm tra phương thức yêu cầu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem các dữ liệu cần thiết có tồn tại không
    if (isset($_POST['maQuyen']) && isset($_POST['tenQuyen']) && isset($_POST['chucnang']) && isset($_POST['trangThai'])) {
        // Lấy dữ liệu từ form
        $maQuyen = $_POST['maQuyen'];
        $tenQuyen = $_POST['tenQuyen'];
        $chucnangData = $_POST['chucnang'];
        $trangThai = $_POST['trangThai'];

        // Cập nhật thông tin quyền
        $quyenController = new QuyenController($mysqli);
        $quyenController->updateQuyen($maQuyen, $tenQuyen,$trangThai);

        // Xóa tất cả các quyền đã gán cho quyền này trước đó
        $ctq_cnController = new CTQ_CN_Controller($mysqli);
        $ctq_cnController->deleteCTQ_CNByMaQuyen($maQuyen);

        // Duyệt qua mỗi chức năng được chọn để gán quyền
        foreach ($chucnangData as $maCN => $actions) {
            if (isset($actions['them'])) {
                $ctq_cnController->addCTQ_CN($maQuyen, $maCN, 't');
            }
            if (isset($actions['sua'])) {
                $ctq_cnController->addCTQ_CN($maQuyen, $maCN, 's');
            }
            if (isset($actions['xoa'])) {
                $ctq_cnController->addCTQ_CN($maQuyen, $maCN, 'x');
            }
        }
        

        // Thông báo cập nhật thành công
        echo "Cập nhật quyền thành công!";
    } else {
        // Hiển thị thông báo lỗi nếu thiếu dữ liệu
        echo "Thiếu dữ liệu cần thiết!";
    }
} else {
    // Hiển thị thông báo lỗi nếu không phải phương thức POST
    echo "Phương thức yêu cầu không hợp lệ!";
}
?>
