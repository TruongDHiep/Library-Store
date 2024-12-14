<?php
class SupplierModel {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAllSupplier() {
        $sql = "SELECT * FROM nhacungcap";
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

    
    
    public function deletesupplier($maNCC) {
        $maNCC = $this->mysqli->real_escape_string($maNCC);
        $sql = "UPDATE nhacungcap SET trangThai = 0 WHERE maNCC = '$maNCC'";
        return $this->mysqli->query($sql);
    }
    

    public function editsupplier($maNCC, $tenNCC, $diaChi, $SDT) {
        // Xử lý dữ liệu mới ở đây nếu cần
        $maNCC = $this->mysqli->real_escape_string($maNCC);
        $tenNCC = $this->mysqli->real_escape_string($tenNCC);
        $diaChi = $this->mysqli->real_escape_string($diaChi);
        $SDT = $this->mysqli->real_escape_string($SDT);
    

        $sql = "UPDATE nhacungcap SET tenNCC = '$tenNCC', diaChi = '$diaChi', SDT = '$SDT' WHERE maNCC = '$maNCC'";
        return $this->mysqli->query($sql);
    }
    public function getsupplierByMaNCC($maNCC) {
        $maNCC = $this->mysqli->real_escape_string($maNCC);
        $sql = "SELECT * FROM nhacungcap WHERE maNCC = '$maNCC'";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Trả về một hàng từ kết quả truy vấn
        } else {
            return null; // Trả về null nếu không tìm thấy hóa đơn
        }
    }
       
    public function addSupplier( $tenNCC, $diaChi, $SDT, $trangThai) {
        // Xử lý dữ liệu mới ở đây nếu cần
        
        $tenNCC = $this->mysqli->real_escape_string($tenNCC);
        $diaChi = $this->mysqli->real_escape_string($diaChi);
        $SDT = $this->mysqli->real_escape_string($SDT);
        $trangThai = $this->mysqli->real_escape_string($trangThai);
    
        $sql = "INSERT INTO nhacungcap (tenNCC, diaChi, SDT, trangThai) VALUES ('$tenNCC', '$diaChi', '$SDT', '$trangThai')";
        return $this->mysqli->query($sql);
    }
    public function getsupplierByPage($page, $itemsPerPage) {
        $page = $this->mysqli->real_escape_string($page);
        $itemsPerPage = $this->mysqli->real_escape_string($itemsPerPage);
        $offset = ($page - 1) * $itemsPerPage; // Tính toán vị trí bắt đầu của mục trong trang hiện tại
    
        $sql = "SELECT * FROM nhacungcap WHERE trangThai = 1 LIMIT $offset, $itemsPerPage ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function countAllsupplier() {
        $sql = "SELECT COUNT(*) AS total FROM nhacungcap WHERE trangThai=1";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function searchSupplier($keyword, $page, $itemsPerPage) {
        $offset = ($page - 1) * $itemsPerPage;
        $keyword = '%' . $keyword . '%';

        $stmt = $this->mysqli->prepare("SELECT * FROM nhacungcap WHERE tenNCC LIKE ? LIMIT ?, ?");
        $stmt->bind_param("sii", $keyword, $offset, $itemsPerPage);
        $stmt->execute();
        $result = $stmt->get_result();

        $suppliers = [];
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }

        $stmt->close();
        return $suppliers;
    }

    public function countSearchSupplier($keyword) {
        $keyword = '%' . $keyword . '%';

        $stmt = $this->mysqli->prepare("SELECT COUNT(*) as count FROM nhacungcap WHERE tenNCC LIKE ?");
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc()['count'];

        $stmt->close();
        return $count;
    }
}               
?>