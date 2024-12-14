<?php
require_once 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';

$itemsPerPage = 12;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$sql = "SELECT * FROM Sach s JOIN HinhAnh ha ON s.maSach = ha.maSach";

if (isset($_GET['timkiem']) && !empty($_GET['timkiem'])) {
    $timkiem = $_GET['timkiem'];
    $sql .= " WHERE tenSach LIKE '%$timkiem%'";
}

if (isset($_GET['theloai']) && !empty($_GET['theloai'])) {
    if ($_GET['theloai'] != 'all') {
        $theloai = $_GET['theloai'];
        $sql .= isset($timkiem) && !empty($timkiem) ? " AND maLoai = '$theloai'" : " WHERE maLoai = '$theloai'";
    }
}
if (isset($_GET['price']) ) {
    if ($_GET['price'] == '0') {
        $sql .= " AND (giaXuat - (giaXuat * khuyenMai)/100) <= 150000";
    } elseif ($_GET['price'] == '1') {
        $sql .= " AND (giaXuat - (giaXuat * khuyenMai)/100) BETWEEN 150000 AND 300000";
    } elseif ($_GET['price'] == '3') {
        $sql .= " AND (giaXuat - (giaXuat * khuyenMai)/100) BETWEEN 300000 AND 500000";
    } elseif ($_GET['price'] == '5') {
        $sql .= " AND (giaXuat - (giaXuat * khuyenMai)/100) BETWEEN 500000 AND 700000";
    } elseif ($_GET['price'] == '7') {
        $sql .= " AND (giaXuat - (giaXuat * khuyenMai)/100) >= 700000";
    }
}
$result_products = $mysqli->query($sql);
$total_items = $result_products->num_rows;
$total_pages = ceil($total_items / $itemsPerPage);

if (isset($_GET['sort']) && !empty($_GET['sort'])) {
    $sort_option = $_GET['sort'] ?? '';
    switch ($sort_option) {
        case 'low-to-high':
            $sql .= " ORDER BY (giaXuat - (giaXuat * khuyenMai)/100) ASC";
            break;
        case 'high-to-low':
            $sql .= " ORDER BY (giaXuat - (giaXuat * khuyenMai)/100) DESC";
            break;
        default:
            break;
    }
}

$start_index = ($current_page - 1) * $itemsPerPage;
$sql .= " LIMIT $start_index, $itemsPerPage";
$result_products = $mysqli->query($sql);

if ($result_products) {
    echo json_encode([
        'total_pages' => $total_pages,
        'products' => $result_products->fetch_all(MYSQLI_ASSOC)
    ]);
} else {
    echo "Có lỗi xảy ra khi thực hiện truy vấn: " . $mysqli->error;
    exit();
}
?>