<?php
include __DIR__ . '/../model/quyenModel.php';

class QuyenController
{
    private $quyenModel;

    public function __construct($mysqli)
    {
        $this->quyenModel = new QuyenModel($mysqli);
    }

    public function getAllQuyen()
    {
        return $this->quyenModel->getAllQuyen();
    }

    public function addQuyen($tenQuyen, $trangThai)
    {
        return $this->quyenModel->addQuyen($tenQuyen, $trangThai);
    }

    public function updateQuyen($maQuyen, $tenQuyen, $trangThai)
    {
        return $this->quyenModel->updateQuyen($maQuyen, $tenQuyen, $trangThai);
    }

    public function deleteQuyen($maQuyen)
    {
        return $this->quyenModel->deleteQuyen($maQuyen);
    }

    public function searchQuyen($keyword)
    {
        return $this->quyenModel->searchQuyen($keyword);
    }

    public function getQuyenbMaQuyen($maQuyen)
    {
        return $this->quyenModel->getQuyenByMaQuyen($maQuyen);
    }



}
?>
