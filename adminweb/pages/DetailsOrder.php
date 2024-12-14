<?php
// Kết nối đến cơ sở dữ liệu và thực hiện truy vấn để lấy chi tiết hoá đơn
// Giả sử bạn đã có một hàm hoặc lớp để thực hiện điều này

include 'controller/HoaDonController.php';
include 'controller/hinhAnhController.php';
include 'controller/sachController.php';
include 'controller/loaiSachController.php';
include 'controller/CustomerController.php';

$maHD = $_GET['maHD'];

$CustomerController = new CustomerModel($mysqli);
$loaiSachController= new LoaiSachModel($mysqli);
$controllersach= new SachController($mysqli);
$hinhanhcontroller = new hinhAnhController($mysqli);
$controller = new HoaDonController($mysqli);

$chitiethoadon = $controller->getchitietHoaDonBymaHD($maHD);
$hoaDon= $controller->getHoaDonByMaHD($maHD);
if(!empty($hoaDon)){
$customer = $CustomerController->getCustomerBymaKH($hoaDon['maKH']);

echo'<section class="h-100 gradient-custom">
<div class="container py-5 h-100">
  <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-lg-10 col-xl-8">
      <div class="card" style="border-radius: 10px;">
        <div class="card-header px-4 py-5">
          <h5 class="text-muted mb-0">Cảm ơn Hoá Đơn của bạn, <span style="color: #a8729a;">'.$customer['tenKH'].' </span>!</h5>
        </div>';
}
if (!empty($chitiethoadon)) {
    // Hiển thị chi tiết hoá đơn dưới dạng HTML
    foreach ($chitiethoadon as $chitiet) {
        
      
                echo'<div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="lead fw-normal mb-0" style="color: #a8729a;"> Hoá đơn</p>
                    <p class="small text-muted mb-0">Mã hoá đơn : '.$chitiet["maHD"] .'</p>
                  </div>
                  <div class="card shadow-0 border mb-4">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-2">';
                    
                        $hinhAnh = $hinhanhcontroller->getImagesByBookId($chitiet["maSach"] );
                       
                        // Kiểm tra xem có hình ảnh nào cho sách này không
                        if (!empty($hinhAnh)) {
                            // Hiển thị hình ảnh đầu tiên
                            echo "<div><img class='pic_list' src='./img/" . $hinhAnh[0]["maHinh"] . "'/></div>";
                        } else {
                            // Nếu không có hình ảnh, hiển thị một hình ảnh mặc định hoặc thông báo không có hình ảnh
                            echo "Không có hình ảnh";
                        }
                        echo'
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">';
                        $sach=$controllersach->getSachByMaSach($chitiet['maSach']);
                        $loaisach=$loaiSachController->getloaisachByMa($sach['maLoai']);
                        echo'
                          <p class="text-muted mb-0">'.$sach['tenSach'].'</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                          <p class="text-muted mb-0 small">'.$sach['giaXuat'].'</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                          <p class="text-muted mb-0 small">'.$loaisach['tenLoai'].'</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                          <p class="text-muted mb-0 small">khuyến mãi: '.$sach['khuyenMai'].'%</p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                          <p class="text-muted mb-0 small">'.$sach['TacGia'].'</p>
                        </div>
                      </div>
                      <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                     
                    </div>
                  </div>
                  
                  <div class="d-flex justify-content-between pt-2">
                    <p class="fw-bold mb-0">Chi tiết</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Giá tiền:</span> '. number_format($chitiet['giaTien']).' vnd</p>
                  </div>
      
                  <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0">Mã hoá đơn : '.$maHD.'</p>
                    
                  </div>
      
                  <div class="d-flex justify-content-between">
                    <p class="text-muted mb-0">Ngày tạo : '.$hoaDon['ngayTao'].'</p>
                  
                  </div>
                  <div class="d-flex justify-content-between">
                  <p class="text-muted mb-0">Số lượng: '.$chitiet['soLuong'].'</p>
                
                </div>
                 
                </div>';
               
        // Lặp lại cho mỗi trường thông tin
    }
    echo' <div class="row d-flex align-items-center">
    <div class="col-md-2">
      <p class="text-muted mb-0 small">Trạng thái xử lí</p>
    </div>
    <div class="col-md-10">';
      if($hoaDon['trangThaiHoaDon']==1){
        echo'<div class="progress" style="height: 6px; border-radius: 16px;">
        <div class="progress-bar" role="progressbar"
          style="width: 65%; border-radius: 16px; background-color: #a8729a;" aria-valuenow="65"
          aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div class="d-flex justify-content-around mb-1">
        <p class="text-muted mt-1 mb-0 small ms-xl-5">Đang xử lí</p>
        <p class="text-muted mt-1 mb-0 small ms-xl-5">Đã xử lí</p>
      </div>
    </div>
  </div>';
      }elseif($hoaDon['trangThaiHoaDon']==2){
        echo'<div class="progress" style="height: 6px; border-radius: 16px;">
        <div class="progress-bar" role="progressbar"
          style="width: 35%; border-radius: 16px; background-color: #a8729a; margin-left:65%;"  aria-valuenow="65"
          aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div class="d-flex justify-content-around mb-1">
        <p class="text-muted mt-1 mb-0 small ms-xl-5">Đang xử lí</p>
        <p class="text-muted mt-1 mb-0 small ms-xl-5">Đã xử lí</p>
      </div>
    </div>
  </div>';
      }
    echo'<div class="card-footer border-0 px-4 py-5"
    style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
    <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Tổng tiền : <span class="h2 mb-0 ms-2">'. number_format($hoaDon['tongTien']) .' vnd</span></h5>
    </div>
    </div>
    </div>
    </div>
    </div>
    </section>';
} else {
    echo "Không có dữ liệu chi tiết hoá đơn.";
    
}       

           
          

?>
