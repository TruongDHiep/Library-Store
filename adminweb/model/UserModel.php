<?php
class UserModel {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAllUser() {
        $sql = "SELECT * FROM taikhoan";
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

    // public function searchUser($keyword) {
    //     $keyword = $this->mysqli->real_escape_string($keyword);
    //     $sql = "SELECT * FROM taikhoan WHERE  maTK LIKE '%$keyword%'  OR email LIKE '%$keyword%' OR matKhau LIKE '%$keyword%'  OR trangThai LIKE '%$keyword%' OR maQuyen LIKE '%$keyword%'";
    //     $result = $this->mysqli->query($sql);
    //     $data = [];
    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             $data[] = $row;
    //         }
    //     }
    //     return $data;
    // }
    public function deleteUser($maTK) {
        $maTK = $this->mysqli->real_escape_string($maTK);
        $sql = "DELETE FROM taikhoan WHERE maTK= '$maTK'";
        return $this->mysqli->query($sql);
    }
    

    public function addUser($taiKhoan, $matKhau, $trangThai, $maQuyen) {
        // Chuẩn bị câu lệnh SQL
        $sql = "INSERT INTO taikhoan (email, matKhau, trangThai, maQuyen) VALUES (?, ?, ?, ?)";
    
        // Tạo statement và bind các giá trị
        $statement = $this->mysqli->prepare($sql);
        $statement->bind_param("ssii", $taiKhoan, $matKhau, $trangThai, $maQuyen);
    
        // Thực thi statement
        $result = $statement->execute();
    
        // Đóng statement
        $statement->close();
    
        return $result;
    }
    

    public function editUser($maTK,  $taiKhoan, $matKhau, $trangThai,$maQuyen) {
        // Xử lý dữ liệu mới ở đây nếu cần
        $maTK = $this->mysqli->real_escape_string($maTK);
        $taiKhoan = $this->mysqli->real_escape_string($taiKhoan);
        $matKhau = $this->mysqli->real_escape_string($matKhau);
        $trangThai = $this->mysqli->real_escape_string($trangThai);
        $maQuyen = $this->mysqli->real_escape_string($maQuyen);

        $sql = "UPDATE taikhoan SET email = '$taiKhoan', matKhau = '$matKhau', trangThai = '$trangThai' , maQuyen='$maQuyen' WHERE maTK = '$maTK'";
        return $this->mysqli->query($sql);
    }
    public function getTaiKhoanBymaTK($maTK) {
        $maTK = $this->mysqli->real_escape_string($maTK);
        $sql = "SELECT * FROM taikhoan WHERE maTK = '$maTK'";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Trả về null nếu không tìm thấy hóa đơn
        }
    }
    public function getRoles() {
        $sql = "SELECT * FROM quyen";
        $result = $this->mysqli->query($sql);
        $roles = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $roles[] = $row;
            }
        }
        return $roles;
    }
   


    public function getTaiKhoanByTaiKhoanAndPassword($account_email, $account_password) {
        $account_email = $this->mysqli->real_escape_string($account_email);
        $account_password = $this->mysqli->real_escape_string($account_password);
        
        $sql = "SELECT * FROM taikhoan WHERE email = '$account_email' AND matKhau = '$account_password'";
        $result = $this->mysqli->query($sql);
    
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null; // Trả về null nếu không tìm thấy tài khoản
        }
    }
    public function getUserByPage($page, $itemsPerPage) {
        $offset = ($page - 1) * $itemsPerPage;
        $stmt = $this->mysqli->prepare("SELECT * FROM taikhoan LIMIT ?, ?");
        $stmt->bind_param("ii", $offset, $itemsPerPage);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchUser($keyword, $page, $itemsPerPage) {
        $offset = ($page - 1) * $itemsPerPage;
        $keyword = '%' . $keyword . '%';
        $stmt = $this->mysqli->prepare("SELECT * FROM taikhoan WHERE email LIKE ? LIMIT ?, ?");
        $stmt->bind_param("sii", $keyword, $offset, $itemsPerPage);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countAllUser() {
        $result = $this->mysqli->query("SELECT COUNT(*) as total FROM taikhoan");
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function countSearchUser($keyword) {
        $keyword = '%' . $keyword . '%';

        $stmt = $this->mysqli->prepare("SELECT COUNT(*) as count FROM taikhoan WHERE email LIKE ?");
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc()['count'];

        $stmt->close();
        return $count;
    }
}
?>