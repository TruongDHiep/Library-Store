<?php
class CTQ_CN_Model
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getAllCTQ_CN()
    {
        $query = "SELECT * FROM ctq_cn";
        $result = $this->mysqli->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addCTQ_CN($maQuyen, $maCN, $hoatDong)
    {
        $query = "INSERT INTO ctq_cn (maQuyen, maCN, hoatDong) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("iis", $maQuyen, $maCN, $hoatDong);
        return $stmt->execute();
    }

    public function deleteCTQ_CNByMaQuyen($maQuyen)
    {
        $query = "DELETE FROM ctq_cn WHERE maQuyen = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $maQuyen);
        return $stmt->execute();
    }

    public function getCTQ_CNByMaQuyen($maQuyen)
    {
        // Chuẩn bị truy vấn SQL
        $query = "SELECT * FROM ctq_cn WHERE maQuyen = ?";

        // Chuẩn bị và thực thi câu truy vấn
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $maQuyen);
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();

        // Chuyển đổi kết quả thành mảng
        $ctq_cnData = array();
        while ($row = $result->fetch_assoc()) {
            $ctq_cnData[] = $row;
        }

        // Trả về dữ liệu kết quả
        return $ctq_cnData;
    }


    public function updateCTQ_CN($maQuyen, $maCN, $hoatDong)
    {
        $query = "UPDATE ctq_cn SET hoatDong = ? WHERE maQuyen = ? AND maCN = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("sii", $hoatDong, $maQuyen, $maCN);
        return $stmt->execute();
    }

    public function deleteCTQ_CN($maQuyen, $maCN)
    {
        $query = "DELETE FROM ctq_cn WHERE maQuyen = ? AND maCN = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("ii", $maQuyen, $maCN);
        return $stmt->execute();
    }

    public function searchCTQ_CN($maQuyen, $maCN)
    {
        $query = "SELECT * FROM ctq_cn WHERE maQuyen = ? AND maCN = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("ii", $maQuyen, $maCN);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
