<?php
class HinhAnhModel {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function addImage($maSach, $maHinh) {
        $maSach = $this->mysqli->real_escape_string($maSach);
        $maHinh = $this->mysqli->real_escape_string($maHinh);

        $sql = "INSERT INTO hinhanh (maSach, maHinh) VALUES ('$maSach', '$maHinh')";
        return $this->mysqli->query($sql);
    }

    public function deleteImage($maSach) {
        $maSach = $this->mysqli->real_escape_string($maSach);
        $sql = "DELETE FROM hinhanh WHERE maSach = '$maSach'";
        return $this->mysqli->query($sql);
    }

    public function getImagesByBookId($maSach) {
        $maSach = $this->mysqli->real_escape_string($maSach);
        $sql = "SELECT * FROM hinhanh WHERE maSach = '$maSach'";
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
?>
