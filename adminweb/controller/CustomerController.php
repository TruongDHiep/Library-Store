<?php
include __DIR__ . '/../model/CustomerModel.php';

class CustomerController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new CustomerModel($mysqli);
    }

    // Thêm tham số $keyword với giá trị mặc định là rỗng
    public function displayCustomer() {
    
         return $this->model->getAllCustomer();
    
    }



    public function getCustomerBymaKH($maKH){
        return $this->model->getCustomerByMaKH($maKH);
    }
    public function updateCustomerBymaKH ($maKH,$tenNV,$SDT,$diaChi,$ngayVaoLam ){
        return $this->model->editCustomer($maKH,$tenNV,$SDT,$diaChi,$ngayVaoLam);
    }
    public function deleteCustomer($maKH){
        return $this->model->deleteCustomer($maKH);
    }
    public function addCustomer($tenNV, $diaChi, $SDT, $ngayVaoLam){
        return $this->model->addCustomer($tenNV, $diaChi, $SDT, $ngayVaoLam);
    }
    public function getCustomerByPage ($page, $itemsPerPage){
        return $this->model->getCustomerByPage($page, $itemsPerPage);
    }
    public function countAllCustomer (){
        return $this->model->countAllCustomer();
    }

}
?>
