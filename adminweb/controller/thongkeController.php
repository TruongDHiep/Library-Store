<?php
include __DIR__ . '/../model/thongkeModel.php';

class StaticController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new StaticModel($mysqli);
    }

    public function getdoanhthuByngay ($ngayBD,$ngayKT){
        return $this->model->getdoanhthuloaipByngay($ngayBD,$ngayKT);
    }
    public function gettongdoanhthu(){
        return $this->model->gettongdoanhthu();
    }

    public function getSachBanChay($ngayBD,$ngayKT){
        return $this->model->getSachBanChay($ngayBD,$ngayKT);
    }
    
}
?>