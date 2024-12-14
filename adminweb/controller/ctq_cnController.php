<?php
include __DIR__ . '/../model/quyenCnModel.php';

class CTQ_CN_Controller
{
    private $ctq_cn_model;

    public function __construct($mysqli)
    {
        $this->ctq_cn_model = new CTQ_CN_Model($mysqli);
    }

    public function getAllCTQ_CN()
    {
        return $this->ctq_cn_model->getAllCTQ_CN();
    }

    

    public function getCTQ_CNByMaQuyen($maQuyen)
    {
        return $this->ctq_cn_model->getCTQ_CNByMaQuyen($maQuyen);
    }

    public function deleteCTQ_CNByMaQuyen($maQuyen)
    {
        return $this->ctq_cn_model->deleteCTQ_CNByMaQuyen($maQuyen);
    }

  
    public function addCTQ_CN($maQuyen, $maCN, $hoatDong)
    {
        return $this->ctq_cn_model->addCTQ_CN($maQuyen, $maCN, $hoatDong);
    }

    public function updateCTQ_CN($maQuyen, $maCN, $hoatDong)
    {
        return $this->ctq_cn_model->updateCTQ_CN($maQuyen, $maCN, $hoatDong);
    }

    public function deleteCTQ_CN($maQuyen, $maCN)
    {
        return $this->ctq_cn_model->deleteCTQ_CN($maQuyen, $maCN);
    }

    public function searchCTQ_CN($maQuyen, $maCN)
    {
        return $this->ctq_cn_model->searchCTQ_CN($maQuyen, $maCN);
    }
}
?>
