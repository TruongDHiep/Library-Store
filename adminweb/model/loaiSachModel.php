<?php
class LoaiSachModel {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAllLoaiSach() {
        $sql = "SELECT * FROM loaisach";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function addLoaiSach($tenLoai, $chiTiet, $trangThai) {
        $sql = "INSERT INTO loaisach (tenLoai, chiTiet, trangThai) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssi", $tenLoai, $chiTiet, $trangThai);
        return $stmt->execute();
    }

    public function editLoaiSach($maLoai, $tenLoai, $chiTiet, $trangThai) {
        $sql = "UPDATE loaisach SET tenLoai = ?, chiTiet = ?, trangThai = ? WHERE maLoai = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssii", $tenLoai, $chiTiet, $trangThai, $maLoai);
        return $stmt->execute();
    }

    public function deleteLoaiSach($maLoai) {
        $sql = "UPDATE loaisach SET trangThai=0 WHERE maLoai = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $maLoai);
        return $stmt->execute();
    }

    public function searchLoaiSach($keyword) {
        $keyword = "%{$keyword}%";
        $sql = "SELECT * FROM loaisach WHERE tenLoai LIKE ? OR chiTiet LIKE ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }


    public function getloaisachByMa($maLoai) {
        $sql = "SELECT * FROM loaisach WHERE maLoai = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $maLoai);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getloaisachByPage($page, $itemsPerPage) {
        $page = $this->mysqli->real_escape_string($page);
        $itemsPerPage = $this->mysqli->real_escape_string($itemsPerPage);
        $offset = ($page - 1) * $itemsPerPage; // Tính toán vị trí bắt đầu của mục trong trang hiện tại
    
        $sql = "SELECT * FROM loaisach WHERE trangThai = 1 LIMIT $offset, $itemsPerPage ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function countAlloaisach() {
        $sql = "SELECT COUNT(*) AS total FROM loaisach WHERE trangThai=1";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>
