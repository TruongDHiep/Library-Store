<?php
class CustomerModel {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAllCustomer() {
        $sql = "SELECT kh.maKH, kh.tenKH,kh.diaChi,kh.SDT,kh.trangThai,tk.email FROM `khachhang` kh join taikhoan tk on kh.maTK = tk.maTK GROUP BY kh.maKH ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function countCustomer() {
        $sql = "SELECT COUNT(*) FROM `khachhang` kh join taikhoan tk on kh.maTK = tk.maTK GROUP BY kh.maKH ";
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


    public function deleteCustomer($maKH) {
        $maKH = $this->mysqli->real_escape_string($maKH);
        
    
        // Xoá hoá đơn
        $sql = "UPDATE khachhang SET trangThai = 0 WHERE maKH = '$maKH'";
        $resultDeletekhachhang = $this->mysqli->query($sql);
    
        // Kiểm tra kết quả của cả hai câu truy vấn
        if ( $resultDeletekhachhang) {
            return true; // Trả về true nếu cả hai câu truy vấn đều thành công
        } else {
            return false; // Trả về false nếu có bất kỳ lỗi nào xảy ra trong quá trình thực hiện
        }
    }

    public function editCustomer($maKH,$tenKH,$SDT,$diaChi,$maTK ) {
 
       

        $sql = "UPDATE khachhang SET tenKH='$tenKH',diaChi='$diaChi',SDT='$SDT',maTK='$maTK'  WHERE maKH = '$maKH'";
        return $this->mysqli->query($sql);
    }
    public function getCustomerBymaKH($maKH) {
        $maKH = $this->mysqli->real_escape_string($maKH);
        $sql = "SELECT * FROM khachhang WHERE maKH = '$maKH'";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Trả về null nếu không tìm thấy hóa đơn
        }
    }
    public function addCustomer( $tenKH, $diaChi, $SDT, $maTK) {
        // Xử lý dữ liệu mới ở đây nếu cần
        
        $tenKH = $this->mysqli->real_escape_string($tenKH);
        $diaChi = $this->mysqli->real_escape_string($diaChi);
        $SDT = $this->mysqli->real_escape_string($SDT);
        $maTK = $this->mysqli->real_escape_string($maTK);
    
        $sql = "INSERT INTO khachhang (tenKH, diaChi, SDT, maTK ,trangThai) VALUES ('$tenKH', '$diaChi', '$SDT', '$maTK',1)";
        return $this->mysqli->query($sql);
    }
    public function getCustomerByPage($page, $itemsPerPage) {
        $page = $this->mysqli->real_escape_string($page);
        $itemsPerPage = $this->mysqli->real_escape_string($itemsPerPage);
        $offset = ($page - 1) * $itemsPerPage; // Tính toán vị trí bắt đầu của mục trong trang hiện tại
    
        $sql = "SELECT * FROM khachhang WHERE trangThai = 1 LIMIT $offset, $itemsPerPage ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function countAllCustomer() {
        $sql = "SELECT COUNT(*) AS total FROM khachhang WHERE trangThai=1";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>