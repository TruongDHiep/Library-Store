<?php
include 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\quyenController.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\chucnangController.php';
include 'C:\xampp\htdocs\fahasa\adminweb\controller\ctq_cnController.php';

// Kiểm tra nếu có dữ liệu được gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Kiểm tra nếu dữ liệu tên quyền được gửi từ form và có chức năng được chọn để gán quyền
    if (!empty($_POST['tenQuyen']) && !empty($_POST['chucnang'])) {
        // Xử lý thêm quyền mới vào cơ sở dữ liệu
        $tenQuyen = $_POST['tenQuyen'];
        $trangThai = 1; // Giả sử quyền được thêm là hoạt động

        $quyenController = new QuyenController($mysqli);
        $quyenController->addQuyen($tenQuyen, $trangThai);
        $maQuyen = $mysqli->insert_id; // Lấy mã quyền vừa được thêm vào CSDL

        if ($maQuyen) {
            // Lấy danh sách các chức năng được chọn để gán quyền
            $chucnangData = $_POST['chucnang'];

            $ctq_cnController = new CTQ_CN_Controller($mysqli);

            // Duyệt qua mỗi chức năng được chọn để gán quyền
            foreach ($chucnangData as $maCN => $actions) {
                // Kiểm tra nếu các quyền được gán cho chức năng
                $them = isset($actions['them']) ? 't' : 'f'; // 't' nếu được chọn, 'f' nếu không được chọn
                $sua = isset($actions['sua']) ? 's' : 'f'; // 's' nếu được chọn, 'f' nếu không được chọn
                $xoa = isset($actions['xoa']) ? 'x' : 'f'; // 'x' nếu được chọn, 'f' nếu không được chọn

                // Thêm quyền cho chức năng vào cơ sở dữ liệu
                if ($them == 't'){
                    $ctq_cnController->addCTQ_CN($maQuyen, $maCN, $them);
                }
                elseif ($sua == 's'){
                    $ctq_cnController->addCTQ_CN($maQuyen, $maCN, $sua);
                }
                elseif ($xoa == 'x'){
                    $ctq_cnController->addCTQ_CN($maQuyen, $maCN, $xoa);
                }




            }

            echo "Thêm quyền và gán quyền cho chức năng thành công!";
        } else {
            echo "Đã xảy ra lỗi khi thêm quyền!";
        }
    } else {
        echo "Vui lòng nhập tên quyền và chọn ít nhất một chức năng để gán quyền!";
    }
} else {
    echo "Phương thức yêu cầu không hợp lệ!";
}
?>
