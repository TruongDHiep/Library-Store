<?php
// Kết nối đến cơ sở dữ liệu
include 'config.php';

// Truy vấn cơ sở dữ liệu để lấy danh sách sách
$sql = "SELECT * FROM sach LIMIT 10"; // Giả sử chỉ lấy 10 cuốn sách đầu tiên
$result = $mysqli->query($sql);

// Hiển thị danh sách sách
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="book">';
        echo '<h3>' . $row["tenSach"] . '</h3>';
        echo '<p>' . $row["moTa"] . '</p>';
        // Thêm các thông tin khác của sách nếu cần
        echo '</div>';
    }
} else {
    echo "Không có dữ liệu sách";
}
?>
