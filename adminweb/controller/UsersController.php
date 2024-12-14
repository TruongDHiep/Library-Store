<?php
include __DIR__ . '/../model/UserModel.php';

class UserController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new UserModel($mysqli);
    }

    // Thêm tham số $keyword với giá trị mặc định là rỗng
    public function displayUser() {
    
         return $this->model->getAllUser();
    
    }

    // Đảm bảo tên tham số phù hợp với cách bạn gọi nó trong AJAX
   // Trong UserController.php

public function searchUser($keyword, $page, $itemsPerPage) {
    return $this->model->searchUser($keyword, $page, $itemsPerPage);
}


    public function getUserBymaTK($maTK){
        return $this->model->getTaiKhoanBymaTK($maTK);
    }
    public function updateUserBymaTK ($maTK, $taiKhoan, $matKhau,  $trangThai,$maQuyen){
        return $this->model->editUser($maTK, $taiKhoan, $matKhau,  $trangThai,$maQuyen);
    }
    public function deleteUser($maTK){
        return $this->model->deleteUser($maTK);
    }
    public function getrole (){
        return $this->model->getRoles();
    }

    public function getTaiKhoanByTaiKhoanAndPassword ($taiKhoan, $matKhau){
        return $this->model->getTaiKhoanByTaiKhoanAndPassword($taiKhoan, $matKhau);
    }

    public function addUser ($taiKhoan, $matKhau, $trangThai, $maQuyen){
        return $this->model->addUser($taiKhoan, $matKhau, $trangThai, $maQuyen);
    }
    public function getUserByPage ($page, $itemsPerPage){
        return $this->model->getUserByPage($page, $itemsPerPage);
    }
    public function countAllUser (){
        return $this->model->countAllUser();
    }     
    public function countSearchUser($keyword) {
        return $this->model->countSearchUser($keyword);
    } 
}
?>
