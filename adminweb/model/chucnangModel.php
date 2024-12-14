<?php
class ChucNangModel
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getAllChucNang()
    {
        $query = "SELECT * FROM chucnang";
        $result = $this->mysqli->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addChucNang($tenCN, $trangThai)
    {
        $query = "INSERT INTO chucnang (tenCN, trangThai) VALUES (?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("si", $tenCN, $trangThai);
        return $stmt->execute();
    }

    public function updateChucNang($maCN, $tenCN, $trangThai)
    {
        $query = "UPDATE chucnang SET tenCN = ?, trangThai = ? WHERE maCN = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("sii", $tenCN, $trangThai, $maCN);
        return $stmt->execute();
    }

    public function deleteChucNang($maCN)
    {
        $query = "DELETE FROM chucnang WHERE maCN = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $maCN);
        return $stmt->execute();
    }

    public function searchChucNang($keyword)
    {
        $query = "SELECT * FROM chucnang WHERE tenCN LIKE ?";
        $keyword = "%{$keyword}%";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
