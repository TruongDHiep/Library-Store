<?php
include __DIR__ . '/../model/sachModel.php';

class SachController {
    private $sachModel;

    public function __construct($mysqli) {
        $this->sachModel = new sachModel($mysqli);
    }

    public function addSach($tensach, $tacgia, $nhaxuatban, $giaNhap, $giaXuat, $soluong, $theloai, $taiban, $khuyenmai, $mota, $trangthai) {
        // Gọi phương thức thêm sách từ model
        return $this->sachModel->addSach($tensach, $tacgia, $nhaxuatban, $giaNhap, $giaXuat, $taiban, $theloai, $soluong, $khuyenmai, $mota, $trangthai);
    }
    

    public function getAllSach() {
        return $this->sachModel->getAllSach();
    }

    public function searchSach($keyword, $page, $itemsPerPage) {
        return $this->sachModel->searchSach($keyword, $page, $itemsPerPage);
    }

    public function deleteSach($maSach) {
        return $this->sachModel->deleteSach($maSach);
    }

    public function updateMaLoai($maLoai) {
        return $this->sachModel->updateMaLoai($maLoai);
    }

    public function editSach($maSach, $tenSach, $TacGia, $NXB, $giaNhap, $giaXuat, $taiBan, $maLoai, $soLuong, $khuyenMai, $moTa, $trangThai) {
        return $this->sachModel->editSach($maSach, $tenSach, $TacGia, $NXB, $giaNhap, $giaXuat, $taiBan, $maLoai, $soLuong, $khuyenMai, $moTa, $trangThai);
    }

    public function getSachByMaSach($maSach) {
        return $this->sachModel->getSachByMaSach($maSach);
    }

    public function getsachganday() {
        return $this->sachModel->getLatestBookID();
    }
    public function getsachByPage ($page, $itemsPerPage){
        return $this->sachModel->getsachByPage($page, $itemsPerPage);
    }
    public function countAllsach (){
        return $this->sachModel->countAllsach();
    }
    public function countsearch($keyword) {
        return $this->sachModel->countsearch($keyword);
    }
}


?>
