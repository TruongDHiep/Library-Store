<?php
class SachModel {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAllSach() {
        $sql = "SELECT * FROM sach";
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function addSach($tensach, $tacgia, $nhaxuatban, $giaNhap, $giaXuat, $soluong, $theloai, $taiBan, $khuyenMai, $moTa, $trangThai) {
        // Xử lý thêm sách vào CSDL
        $sql = "INSERT INTO sach (tenSach, TacGia, NXB, giaNhap, giaXuat, taiBan, maLoai, soLuong, khuyenMai, moTa, trangThai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sssiiiiiisi", $tensach, $tacgia, $nhaxuatban, $giaNhap, $giaXuat, $taiBan, $theloai, $soluong, $khuyenMai, $moTa, $trangThai);
        return $stmt->execute();
    }
    
    public function deleteSach($maSach) {
        $sql = "UPDATE sach SET trangThai = 0 WHERE maSach = ? ";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $maSach);
        return $stmt->execute();
    }

    public function updateMaLoai($maLoai) {
        $sql = "UPDATE sach SET  maLoai = null WHERE maLoai = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $maLoai);
        return $stmt->execute();
    }



    public function getSachByMaSach($maSach) {
        $sql = "SELECT * FROM sach WHERE maSach = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $maSach);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function editSach($maSach, $tenSach, $TacGia, $NXB, $giaNhap, $giaXuat, $taiBan, $maLoai, $soLuong, $khuyenMai, $moTa, $trangThai) {
        $sql = "UPDATE sach SET tenSach = ?, TacGia = ?, NXB = ?, giaNhap = ?, giaXuat = ?, taiBan = ?, maLoai = ?, soLuong = ?, khuyenMai = ?, moTa = ?, trangThai = ? WHERE maSach = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sssiiiiiisii", $tenSach, $TacGia, $NXB, $giaNhap, $giaXuat, $taiBan, $maLoai, $soLuong, $khuyenMai, $moTa, $trangThai, $maSach);
        return $stmt->execute();
    }
    
  
    public function searchSach($keyword, $page, $itemsPerPage) {
        $offset = ($page - 1) * $itemsPerPage;
        $keyword = "%" . $this->mysqli->real_escape_string($keyword) . "%";
        $query = "SELECT * FROM sach WHERE tenSach LIKE ? OR TacGia LIKE ? LIMIT ?, ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("ssii", $keyword, $keyword, $offset, $itemsPerPage);
        $stmt->execute();
        $result = $stmt->get_result();
        $sachData = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $sachData;
    }
    public function getLatestBookID() {
        // Thực hiện truy vấn để lấy mã sách mới nhất từ cơ sở dữ liệu
        // Giả sử câu truy vấn như sau, điều chỉnh cho phù hợp với cấu trúc của cơ sở dữ liệu của bạn
        $query = "SELECT MAX(maSach) AS latest_id FROM sach";
        $result = $this->mysqli->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['latest_id'];
        }
        return null;
    }
    
    public function getsachByPage($page, $itemsPerPage) {
        $page = $this->mysqli->real_escape_string($page);
        $itemsPerPage = $this->mysqli->real_escape_string($itemsPerPage);
        $offset = ($page - 1) * $itemsPerPage; // Tính toán vị trí bắt đầu của mục trong trang hiện tại
    
        $sql = "SELECT * FROM sach WHERE trangThai =1 LIMIT $offset, $itemsPerPage ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function countAllsach() {
        $sql = "SELECT COUNT(*) AS total FROM sach WHERE trangThai=1";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function countSearch($keyword) {
        // Thực hiện escape các đầu vào để tránh SQL Injection
        $keyword = '%' . $this->mysqli->real_escape_string($keyword) . '%';
    
        // Câu lệnh SQL để đếm số lượng hóa đơn trong khoảng ngày
        $sql = "SELECT COUNT(*) AS total FROM sach WHERE tenSach LIKE ? OR TacGia LIKE ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total = $row['total'];
        $stmt->close();
    
        return $total;
    }
    
}
?>
