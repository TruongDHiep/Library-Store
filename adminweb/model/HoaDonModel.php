<?php
class HoaDonModel {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAllHoaDon() {
        $sql = "SELECT * FROM hoadon";
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

    public function searchHoaDon($keyword) {
        $keyword = $this->mysqli->real_escape_string($keyword);
        $sql = "SELECT * FROM hoadon WHERE maHD LIKE '%$keyword%' OR maKH LIKE '%$keyword%' LIKE '%$keyword%' OR tongTien LIKE '%$keyword%' OR ngayTao LIKE '%$keyword%' OR trangThai LIKE '%$keyword%'";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function deleteHoaDon($maHD) {
        $maHD = $this->mysqli->real_escape_string($maHD);
        
        // Xoá chi tiết hoá đơn có liên quan đến mã hoá đơn
        $sqlDeleteChiTiet = "DELETE FROM chitiethoadon WHERE maHD = '$maHD'";
        $resultDeleteChiTiet = $this->mysqli->query($sqlDeleteChiTiet);
    
        // Xoá hoá đơn
        $sqlDeleteHoaDon = "DELETE FROM hoadon WHERE maHD = '$maHD'";
        $resultDeleteHoaDon = $this->mysqli->query($sqlDeleteHoaDon);
    
        // Kiểm tra kết quả của cả hai câu truy vấn
        if ($resultDeleteChiTiet && $resultDeleteHoaDon) {
            return true; // Trả về true nếu cả hai câu truy vấn đều thành công
        } else {
            return false; // Trả về false nếu có bất kỳ lỗi nào xảy ra trong quá trình thực hiện
        }
    }
    
    

    public function editHoaDon($maHD, $trangThai) {
 
        $trangThai = $this->mysqli->real_escape_string($trangThai);

        $sql = "UPDATE hoadon SET trangThai = '$trangThai' WHERE maHD = '$maHD'";
        return $this->mysqli->query($sql);
    }
    public function getHoaDonByMaHD($maHD) {
        $maHD = $this->mysqli->real_escape_string($maHD);
        $sql = "SELECT * FROM hoadon WHERE maHD = '$maHD'";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Trả về null nếu không tìm thấy hóa đơn
        }
    }
    public function getchitietHoaDon(){
        $sql = "SELECT * FROM chitiethoadon ";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Trả về null nếu không tìm thấy hóa đơn
        }
    }
    public function searchchitietHoaDon($keyword) {
        $keyword = $this->mysqli->real_escape_string($keyword);
        $sql = "SELECT * FROM chitiethoadon WHERE maHD LIKE '%$keyword%' OR maSach LIKE '%$keyword%' OR giaTien LIKE '%$keyword%' OR soLuong LIKE '%$keyword%' ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getchitietHoaDonBymaHD($maHD){
        $sql = "SELECT * FROM chitiethoadon WHERE maHD ='$maHD'" ;
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getHoaDonByPage($page, $itemsPerPage) {
        $page = $this->mysqli->real_escape_string($page);
        $itemsPerPage = $this->mysqli->real_escape_string($itemsPerPage);
        $offset = ($page - 1) * $itemsPerPage; // Tính toán vị trí bắt đầu của mục trong trang hiện tại
    
        $sql = "SELECT * FROM hoadon WHERE trangThai = 1 LIMIT $offset, $itemsPerPage ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function countAllHoaDon() {
        $sql = "SELECT COUNT(*) AS total FROM hoadon WHERE trangThai=1";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function gettensachbychitiethoadon ($maSach){
        $sql = "SELECT COUNT(*) AS total FROM hoadon WHERE trangThai=1";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function duyet($maHD){
        $maHD = $this->mysqli->real_escape_string($maHD);
    
        // Bắt đầu một transaction
        $this->mysqli->begin_transaction();
    
        try {
            // Cập nhật trạng thái của hoadon
            $sql = "UPDATE hoadon SET trangThaiHoaDon = 2 WHERE maHD = '$maHD'";
            if (!$this->mysqli->query($sql)) {
                throw new Exception("Lỗi khi cập nhật trạng thái hóa đơn: " . $this->mysqli->error);
            }
    
            // Lấy chi tiết hóa đơn để cập nhật số lượng sách
            $sql2 = "SELECT maSach, soLuong FROM chitiethoadon WHERE maHD = '$maHD'";
            $result = $this->mysqli->query($sql2);
            if (!$result) {
                throw new Exception("Lỗi khi lấy chi tiết hóa đơn: " . $this->mysqli->error);
            }
    
            // Cập nhật số lượng sách
            while ($row = $result->fetch_assoc()) {
                $maSach = $row['maSach'];
                $soLuong = $row['soLuong'];
    
                $sql3 = "UPDATE sach SET soLuong = soLuong - $soLuong WHERE maSach = '$maSach'";
                if (!$this->mysqli->query($sql3)) {
                    throw new Exception("Lỗi khi cập nhật số lượng sách: " . $this->mysqli->error);
                }
            }
    
            // Commit transaction nếu không có lỗi
            $this->mysqli->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction nếu có lỗi
            $this->mysqli->rollback();
            return false;
        }
    }
    public function huy($maHD){
        $maHD = $this->mysqli->real_escape_string($maHD);
        $sql="UPDATE hoadon SET trangThaiHoaDon = 0 WHERE maHD = '$maHD' ";
        return $this->mysqli->query($sql);
    }
    public function getHDBymaKH($maKH){
        $sql = "SELECT * FROM hoadon WHERE maKH ='$maKH'" ;
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getHoaDonByDateRange($startDate, $endDate,$offset, $itemsPerPage) {
        // Thực hiện escape các đầu vào để tránh SQL Injection
        $startDate = $this->mysqli->real_escape_string($startDate);
        $endDate = $this->mysqli->real_escape_string($endDate);
    
        // Câu lệnh SQL sử dụng BETWEEN để lọc hóa đơn theo khoảng ngày
        $sql = "SELECT * FROM hoadon WHERE ngayTao BETWEEN '$startDate' AND '$endDate' LIMIT $offset, $itemsPerPage";
        $result = $this->mysqli->query($sql);
        
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }
    public function countHoaDonByDateRange($startDate, $endDate) {
        // Thực hiện escape các đầu vào để tránh SQL Injection
        $startDate = $this->mysqli->real_escape_string($startDate);
        $endDate = $this->mysqli->real_escape_string($endDate);
    
        // Câu lệnh SQL để đếm số lượng hóa đơn trong khoảng ngày
        $sql = "SELECT COUNT(*) AS total FROM hoadon WHERE ngayTao BETWEEN '$startDate' AND '$endDate'";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
}
?>