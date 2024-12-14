<?php
// Kết nối đến cơ sở dữ liệu
include './config/config.php';

// Hàm lấy dữ liệu từ cơ sở dữ liệu
function fetchDataFromDatabase($mysqli) {
    // Thực hiện truy vấn SQL để lấy dữ liệu cần thiết
    $sql = "SELECT DATE_FORMAT(ngayTao, '%Y-%m') AS thang, SUM(soLuong) AS soLuongBan 
            FROM hoadon 
            JOIN chitiethoadon ON hoadon.maHD = chitiethoadon.maHD 
            WHERE ngayTao BETWEEN '2024-01-01' AND '2024-12-31' 
            GROUP BY DATE_FORMAT(ngayTao, '%Y-%m')";
    $result = $mysqli->query($sql);

    // Chuyển kết quả từ đối tượng kết quả sang mảng
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['thang']] = $row['soLuongBan'];
    }

    // Trả về dữ liệu
    return $data;
}

// Lấy dữ liệu từ cơ sở dữ liệu
$salesData = fetchDataFromDatabase($mysqli);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Statistics</title>
    <!-- Link thư viện Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="chartContainer" style="width: 800px; height: 400px;">
        <canvas id="salesChart"></canvas>
    </div>

    <script>
        // Dữ liệu từ PHP
        var salesData = <?php echo json_encode($salesData); ?>;

        // Tạo mảng chứa nhãn và dữ liệu cho biểu đồ
        var labels = Object.keys(salesData);
        var data = Object.values(salesData);

        // Tạo biểu đồ
        var ctx = document.getElementById('salesChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sản phẩm bán ra',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
