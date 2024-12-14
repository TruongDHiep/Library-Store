<?php
class QuyenModel
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getAllQuyen()
    {
        $query = "SELECT * FROM quyen";
        $result = $this->mysqli->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addQuyen($tenQuyen, $trangThai)
    {
        $query = "INSERT INTO quyen (tenQuyen, trangThai) VALUES (?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("si", $tenQuyen, $trangThai);
        return $stmt->execute();
    }

    public function updateQuyen($maQuyen, $tenQuyen, $trangThai)
    {
        $query = "UPDATE quyen SET tenQuyen = ?, trangThai = ? WHERE maQuyen = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("sii", $tenQuyen, $trangThai, $maQuyen);
        return $stmt->execute();
    }

    public function deleteQuyen($maQuyen)
    {
        $query = "DELETE FROM quyen WHERE maQuyen = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $maQuyen);
        return $stmt->execute();
    }

    public function searchQuyen($keyword)
    {
        $query = "SELECT * FROM quyen WHERE tenQuyen LIKE ?";
        $keyword = "%{$keyword}%";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuyenByMaQuyen($maQuyen) {
        $query = "SELECT * FROM quyen WHERE maQuyen = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $maQuyen);
        $stmt->execute();
        $result = $stmt->get_result();
        $quyen = $result->fetch_assoc();
        $stmt->close();
        return $quyen;
    }
    
}
?>
