<?php
class ImportModel {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAllImport() {
        $sql = "SELECT * FROM phieunhap";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Các phương thức khác

    public function searchImport($keyword) {
        $keyword = $this->mysqli->real_escape_string($keyword);
        $sql = "SELECT * FROM phieunhap WHERE maPN LIKE '%$keyword%' OR maNCC LIKE '%$keyword%' OR maNV LIKE '%$keyword%' OR tongTien LIKE '%$keyword%' OR ngayTao LIKE '%$keyword%'";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function deleteImport($maPN) {
        $maPN = $this->mysqli->real_escape_string($maPN);
        $sql = "UPDATE phieunhap SET trangThai = 0 WHERE maPN = '$maPN'";
        return $this->mysqli->query($sql);
    }
    

    public function editImport($maPN, $maNCC, $maNV, $tongTien, $ngayTao) {
        // Xử lý dữ liệu mới ở đây nếu cần
        $maPN = $this->mysqli->real_escape_string($maPN);
        $maNCC = $this->mysqli->real_escape_string($maNCC);
        $maNV = $this->mysqli->real_escape_string($maNV);
        $tongTien = $this->mysqli->real_escape_string($tongTien);
        $ngayTao = $this->mysqli->real_escape_string($ngayTao);

        $sql = "UPDATE phieunhap SET maNCC = '$maNCC', maNV = '$maNV', tongTien = '$tongTien', ngayTao = '$ngayTao' WHERE maPN = '$maPN'";
        return $this->mysqli->query($sql);
    }
    public function getImportBymaPN($maPN) {
        $maPN = $this->mysqli->real_escape_string($maPN);
        $sql = "SELECT * FROM phieunhap WHERE maPN = '$maPN'";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Trả về null nếu không tìm thấy hóa đơn
        }
    }  
     public function addImport( $maNCC, $maNV, $tongTien, $ngayTao) {
        // Xử lý dữ liệu mới ở đây nếu cần
        
        $maNCC = $this->mysqli->real_escape_string($maNCC);
        $maNV = $this->mysqli->real_escape_string($maNV);
        $tongTien = $this->mysqli->real_escape_string($tongTien);
        $ngayTao = $this->mysqli->real_escape_string($ngayTao);
    
        $sql = "INSERT INTO phieunhap (maNCC, maNV, tongTien, ngayTao,trangThai) VALUES ('$maNCC', '$maNV', '$tongTien', '$ngayTao',1)";
        return $this->mysqli->query($sql);
    }
    
    public function getchitietimportByMaPN ($maPN){
        $sql = "SELECT * FROM chitietphieunhap WHERE chitietphieunhap.maPN= $maPN";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getimportByPage($page, $itemsPerPage) {
        $page = $this->mysqli->real_escape_string($page);
        $itemsPerPage = $this->mysqli->real_escape_string($itemsPerPage);
        $offset = ($page - 1) * $itemsPerPage; // Tính toán vị trí bắt đầu của mục trong trang hiện tại
    
        $sql = "SELECT * FROM phieunhap WHERE trangThai = 1 LIMIT $offset, $itemsPerPage ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function countAllimport() {
        $sql = "SELECT COUNT(*) AS total FROM phieunhap WHERE trangThai=1";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    
}
?>