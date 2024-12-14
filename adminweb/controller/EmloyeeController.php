<?php
include __DIR__ . '/../model/EmloyeeModel.php';

class EmloyeeController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new EmloyeeModel($mysqli);
    }

    // Thêm tham số $keyword với giá trị mặc định là rỗng
    public function displayEmloyee() {
    
         return $this->model->getAllEmloyyee();
    
    }

    // Đảm bảo tên tham số phù hợp với cách bạn gọi nó trong AJAX
    public function searchEmloyee($keyword) {
        return $this->model->searchEmloyee($keyword);
    }

    public function getEmloyeeBymaNV($maNV){
        return $this->model->getEmloyeeByMaNV($maNV);
    }
    public function updateEmloyeeBymaNV ($maNV,$tenNV,$SDT,$diaChi,$ngayVaoLam ){
        return $this->model->editEmloyee($maNV,$tenNV,$SDT,$diaChi,$ngayVaoLam);
    }
    public function deleteEmloyee($maNV){
        return $this->model->deleteEmloyee($maNV);
    }
    public function addEmloyee($tenNV, $diaChi, $SDT, $ngayVaoLam){
        return $this->model->addEmloyee($tenNV, $diaChi, $SDT, $ngayVaoLam);
    }
    public function getEmloyeeByPage($page, $itemsPerPage){
        return $this->model->getEmloyyeeByPage($page, $itemsPerPage);
    }
    public function countAllEmloyyee(){
        return $this->model->countAllEmloyyee();
    }
}
?>
