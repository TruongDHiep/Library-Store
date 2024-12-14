<?php
include __DIR__ . '/../model/HoaDonModel.php';

class HoaDonController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new HoaDonModel($mysqli);
    }

    // Thêm tham số $keyword với giá trị mặc định là rỗng
    public function displayHoaDon() {
    
         return $this->model->getAllHoaDon();
    
    }

    // Đảm bảo tên tham số phù hợp với cách bạn gọi nó trong AJAX
    public function searchHoaDon($keyword) {
        return $this->model->searchHoaDon($keyword);
    }

    public function getHoaDonByMaHD($maHD){
        return $this->model->getHoaDonByMaHD($maHD);
    }
    public function updateHoaDonByMaHD ($maHD, $trangThai){
        return $this->model->editHoaDon($maHD, $trangThai);
    }
    public function deleteHoaDon($maHD){
        return $this->model->deleteHoaDon($maHD);
    }
    public function getchitietHoaDon(){
        return $this->model->getchitietHoaDon();
    }
    public function searchchitietHoaDOn($keyword){
        return $this->model->searchchitietHoaDon($keyword);
    }
    public function getchitietHoaDonBymaHD($maHD){
        return $this->model->getchitietHoaDonBymaHD($maHD);
    }
    public function getHoaDonByPage ($page, $itemsPerPage,){
        return $this->model->getHoaDonByPage($page, $itemsPerPage);
    }
    public function countAllHoaDon (){
        return $this->model->countAllHoaDon();
    }
    public function duyet($maHD){
        return $this->model->duyet($maHD);
    }

    public function huy($maHD){
        return $this->model->huy($maHD);
    }
    public function getHoaDonByDateRange($startDate, $endDate,$offset, $itemsPerPage){
        return $this->model->getHoaDonByDateRange($startDate, $endDate,$offset, $itemsPerPage);
    }
    public function coutHoaDonByDateRange($startDate, $endDate,$offset, $itemsPerPage){
        return $this->model->countHoaDonByDateRange($startDate, $endDate,$offset, $itemsPerPage);
    }
}
?>
