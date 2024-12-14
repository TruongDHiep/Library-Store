<?php
class EmloyeeModel {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAllEmloyyee() {
        $sql = "SELECT * FROM nhanvien";
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

    public function searchEmloyee($keyword) {
        $keyword = $this->mysqli->real_escape_string($keyword);
        $sql = "SELECT * FROM nhanvien WHERE maNV LIKE '%$keyword%' OR maKH LIKE '%$keyword%' OR maNV LIKE '%$keyword%' OR tongTien LIKE '%$keyword%' OR ngayTao LIKE '%$keyword%' OR trangThai LIKE '%$keyword%'";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function deleteEmloyee($maNV) {
        $maNV = $this->mysqli->real_escape_string($maNV);
        
    
        // Xoá hoá đơn
        $sql = "UPDATE nhanvien SET trangThai = '0' WHERE maNV = '$maNV'";
        $resultDeletenhanvien = $this->mysqli->query($sql);
    
        // Kiểm tra kết quả của cả hai câu truy vấn
        if ( $resultDeletenhanvien) {
            return true; // Trả về true nếu cả hai câu truy vấn đều thành công
        } else {
            return false; // Trả về false nếu có bất kỳ lỗi nào xảy ra trong quá trình thực hiện
        }
    }
    
    

    public function editEmloyee($maNV,$tenNV,$SDT,$diaChi,$ngayVaoLam ) {
 
       

        $sql = "UPDATE nhanvien SET tenNV='$tenNV',SDT='$SDT',diaChi='$diaChi',ngayVaoLam='$ngayVaoLam'  WHERE maNV = '$maNV'";
        return $this->mysqli->query($sql);
    }
    public function getEmloyeeByMaNV($maNV) {
        $maNV = $this->mysqli->real_escape_string($maNV);
        $sql = "SELECT * FROM nhanvien WHERE maNV = '$maNV'";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Trả về null nếu không tìm thấy hóa đơn
        }
    }
    public function addEmloyee( $tenNV, $diaChi, $SDT, $ngayVaoLam) {
        // Xử lý dữ liệu mới ở đây nếu cần
        
        $tenNV = $this->mysqli->real_escape_string($tenNV);
        $diaChi = $this->mysqli->real_escape_string($diaChi);
        $SDT = $this->mysqli->real_escape_string($SDT);
        $ngayVaoLam = $this->mysqli->real_escape_string($ngayVaoLam);
    
        $sql = "INSERT INTO nhanvien (tenNV, diaChi, SDT, ngayVaoLam ,trangThai) VALUES ('$tenNV', '$diaChi', '$SDT', '$ngayVaoLam',1)";
        return $this->mysqli->query($sql);
    }
    public function getEmloyyeeByPage($page, $itemsPerPage) {
        $page = $this->mysqli->real_escape_string($page);
        $itemsPerPage = $this->mysqli->real_escape_string($itemsPerPage);
        $offset = ($page - 1) * $itemsPerPage; // Tính toán vị trí bắt đầu của mục trong trang hiện tại
    
        $sql = "SELECT * FROM nhanvien WHERE trangThai = 1 LIMIT $offset, $itemsPerPage ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function countAllEmloyyee() {
        $sql = "SELECT COUNT(*) AS total FROM nhanvien WHERE trangThai=1";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
}
?>