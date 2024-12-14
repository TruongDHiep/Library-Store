<?php
include __DIR__ . '/../model/SupplierModel.php';

class supplierController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new SupplierModel($mysqli);
    }

    // Thêm tham số $keyword với giá trị mặc định là rỗng
    public function displaysupplier() {
    
         return $this->model->getAllsupplier();
    
    }

    // Đảm bảo tên tham số phù hợp với cách bạn gọi nó trong AJAX
    public function searchSupplier($keyword, $page, $itemsPerPage) {
        return $this->model->searchSupplier($keyword, $page, $itemsPerPage);
    }

    public function countSearchSupplier($keyword) {
        return $this->model->countSearchSupplier($keyword);
    }

    public function getsupplierBymaNCC($maNCC){
        return $this->model->getsupplierByMaNCC($maNCC);
    }
    public function updatesupplierBymaNCC ($maNCC, $tenNCC, $diaChi, $SDT){
        return $this->model->editsupplier($maNCC, $tenNCC, $diaChi, $SDT);
    }
    public function deletesupplier($maNCC){
        return $this->model->deletesupplier($maNCC);
    }
    public function addSupplier( $tenNCC, $diaChi, $SDT, $trangThai){
        return $this->model->addSupplier($tenNCC, $diaChi, $SDT, $trangThai);

    }
    public function getSupplierByPage ($page, $itemsPerPage){
        return $this->model->getSupplierByPage($page, $itemsPerPage);
    }
    public function countAllSupplier (){
        return $this->model->countAllSupplier();
    }
}
?>
