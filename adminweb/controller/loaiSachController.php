<?php
include __DIR__ . '/../model/loaiSachModel.php';

class LoaiSachController {
    private $loaiSachModel;

    public function __construct($mysqli) {
        $this->loaiSachModel = new LoaiSachModel($mysqli);
    }

    public function getAllLoaiSach() {
        return $this->loaiSachModel->getAllLoaiSach();
    }

    public function addLoaiSach($tenLoai, $chiTiet, $trangThai) {
        return $this->loaiSachModel->addLoaiSach($tenLoai, $chiTiet, $trangThai);
    }

    public function editLoaiSach($maLoai, $tenLoai, $chiTiet, $trangThai) {
        return $this->loaiSachModel->editLoaiSach($maLoai, $tenLoai, $chiTiet, $trangThai);
    }

    public function deleteLoaiSach($maLoai) {
        return $this->loaiSachModel->deleteLoaiSach($maLoai);
    }

    public function searchLoaiSach($keyword) {
        return $this->loaiSachModel->searchLoaiSach($keyword);
    }
    public function timtheoma($maLoai) {
        return $this->loaiSachModel->getloaisachByMa($maLoai);
    }
    public function getloaiSachByPage($page, $itemsPerPage){
        return $this->loaiSachModel->getloaiSachByPage($page, $itemsPerPage);
    }
    public function countAlloaiSach(){
        return $this->loaiSachModel->countAlloaiSach();
    }
}
?>
