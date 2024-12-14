<?php
include __DIR__ . '/../model/ImportModel.php';

class importController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new ImportModel($mysqli);
    }

    // Thêm tham số $keyword với giá trị mặc định là rỗng
    public function displayimport() {
    
         return $this->model->getAllimport();
    
    }

    // Đảm bảo tên tham số phù hợp với cách bạn gọi nó trong AJAX
    public function searchimport($keyword) {
        return $this->model->searchimport($keyword);
    }

    public function getimportBymaPN($maPN){
        return $this->model->getImportBymaPN($maPN);
    }
    public function updateimportBymaPN ($maPN, $maNCC, $maNV, $tongTien, $ngayTao){
        return $this->model->editimport($maPN, $maNCC, $maNV, $tongTien, $ngayTao);
    }
    public function deleteimport($maPN){
        return $this->model->deleteimport($maPN);
    }
    public function addimport( $maNCC, $maNV, $tongTien, $ngayTao){
        return $this->model->addimport( $maNCC, $maNV, $tongTien, $ngayTao);

    }
    public function getchitietimport ($maPN){
        return $this->model->getchitietimportByMaPN($maPN);
    }
    public function getimportByPage ($page, $itemsPerPage){
        return $this->model->getimportByPage($page, $itemsPerPage);
    }
    public function countAllimport (){
        return $this->model->countAllimport();
    }
}
?>
