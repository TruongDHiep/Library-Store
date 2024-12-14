<?php
require_once 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';

$itemsPerPage = 5;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$sql = "SELECT * FROM hoadon WHERE maKH = " . $_GET['maKH'];

$result_products = $mysqli->query($sql);
$total_items = $result_products->num_rows;
$total_pages = ceil($total_items / $itemsPerPage);


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