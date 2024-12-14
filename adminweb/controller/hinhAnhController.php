<?php
include __DIR__ . '/../model/hinhAnhModel.php';

class HinhAnhController {
    private $imageModel;

    public function __construct($mysqli) {
        $this->imageModel = new HinhAnhModel($mysqli);
    }

    public function addImage($maSach, $maHinh) {
        return $this->imageModel->addImage($maSach, $maHinh);
    }

    public function deleteImage($maHinh) {
        return $this->imageModel->deleteImage($maHinh);
    }

    public function getImagesByBookId($maSach) {
        return $this->imageModel->getImagesByBookId($maSach);
    }
}
?>
