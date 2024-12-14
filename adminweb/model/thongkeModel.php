<?php
class StaticModel
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getdoanhthuloaipByngay($ngayBD, $ngayKT)
    {
        $ngayBD = $this->mysqli->real_escape_string($ngayBD);
        $ngayKT = $this->mysqli->real_escape_string($ngayKT);


        $sql = "SELECT loaisach.tenLoai, COUNT(hoadon.maHD) AS soLuongHoaDon, SUM(chitiethoadon.giaTien * chitiethoadon.soLuong) AS tongDoanhThu
        FROM hoadon
        JOIN chitiethoadon ON hoadon.maHD = chitiethoadon.maHD
        JOIN sach ON chitiethoadon.maSach = sach.maSach
        JOIN loaisach ON sach.maLoai = loaisach.maLoai
        WHERE hoadon.ngayTao BETWEEN '$ngayBD' AND '$ngayKT'
        GROUP BY sach.maLoai
        ORDER BY tongDoanhThu DESC        
        ";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function gettongdoanhthu()
    {
        $sql = "SELECT  SUM(chitiethoadon.giaTien * chitiethoadon.soLuong) AS tongDoanhThu
        FROM chitiethoadon";
        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }


    public function getSachBanChay($ngayBD, $ngayKT)
    {
        $ngayBD = $this->mysqli->real_escape_string($ngayBD);
        $ngayKT = $this->mysqli->real_escape_string($ngayKT);

        $sql = "SELECT s.tenSach, COUNT(*) AS soLuongBan, SUM(cthd.giaTien * cthd.soLuong) AS tongDoanhThu
        FROM Sach s
        JOIN ChiTietHoaDon cthd ON s.maSach = cthd.maSach
        JOIN HoaDon hd ON cthd.maHD = hd.maHD
        JOIN HinhAnh ha ON s.maSach = ha.maSach
        WHERE hd.ngayTao BETWEEN '$ngayBD' AND '$ngayKT'
        GROUP BY s.tenSach
        ORDER BY tongDoanhThu DESC
        LIMIT 5;        
        ";

        $result = $this->mysqli->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
