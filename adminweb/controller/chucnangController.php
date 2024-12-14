<?php
include __DIR__ . '/../model/chucnangModel.php';

class ChucNangController
{
    private $chucNangModel;

    public function __construct($mysqli)
    {
        $this->chucNangModel = new ChucNangModel($mysqli);
    }

    public function getAllChucNang()
    {
        return $this->chucNangModel->getAllChucNang();
    }

    public function addChucNang($tenCN, $trangThai)
    {
        return $this->chucNangModel->addChucNang($tenCN, $trangThai);
    }

    public function updateChucNang($maCN, $tenCN, $trangThai)
    {
        return $this->chucNangModel->updateChucNang($maCN, $tenCN, $trangThai);
    }

    public function deleteChucNang($maCN)
    {
        return $this->chucNangModel->deleteChucNang($maCN);
    }

    public function searchChucNang($keyword)
    {
        return $this->chucNangModel->searchChucNang($keyword);
    }
}
?>
