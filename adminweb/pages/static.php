<?php
include 'C:\xampp\htdocs\fahasa\adminweb\controller\thongkeController.php';
$thongkecontroller = new StaticController($mysqli);

$ngayBD = $_GET['ngayBD'] ?? date('Y-m-d', strtotime('-1 year'));
$ngayKT = $_GET['ngayKT'] ?? date('Y-m-d');

$doanhthuLoai = $thongkecontroller->getdoanhthuByngay($ngayBD, $ngayKT);
$datadt = array();
foreach ($doanhthuLoai as $key => $value) {
  $datadt[] = $value['tongDoanhThu'];
  $dataloai[] = $value['tenLoai'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thống kê</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>

<body>


  <div style="width: 50%;" class="container-fluid px-4">
    <form action="" method="get">
      <div style="display: flex; flex-wrap: nowrap; justify-content: space-around;" class="inputdate">
        <input class="dateinput" id="BDinput" type="date" name="ngayBD" value="<?php echo $ngayBD; ?>">
        <input class="dateinput" id="TKinput" type="date" name="ngayKT" value="<?php echo $ngayKT; ?>">
      </div>
    </form>
    <div class="chart">
      <canvas id="myChart" style="width:100%;"></canvas>
    </div>
  </div>

  

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var ngayBD = document.getElementById('BDinput');
      var ngayKT = document.getElementById('TKinput');
      var myChart;

      // Hàm này sẽ được gọi khi người dùng chọn ngày
      function fetchData() {
        var startDate = ngayBD.value;
        var endDate = ngayKT.value;

        // Tạo một yêu cầu AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'controller/thongkeController.php?ngayBD=' + startDate + '&ngayKT=' + endDate, true);
        xhr.onload = function() {
          if (this.status == 200) {
            // Giả sử hàm PHP của bạn trả về dữ liệu dưới dạng JSON
            var data = JSON.parse(this.responseText);

            // Cập nhật labels và data của biểu đồ với dữ liệu mới
            myChart.data.labels = data.labels;
            myChart.data.datasets[0].data = data.data;
            myChart.data.datasets[0].backgroundColor = generateRandomColors(data.labels.length);

            // Cập nhật biểu đồ
            myChart.update();
          }
        };
        xhr.send();
      }


      // Thêm sự kiện 'change' cho các thẻ input
      ngayBD.addEventListener('change', fetchData);
      ngayKT.addEventListener('change', fetchData);

      const data = {
        labels: <?php echo json_encode($dataloai); ?>,
        datasets: [{
          label: 'Doanh thu theo loại sách',
          data: <?php echo json_encode($datadt); ?>,
          backgroundColor: generateRandomColors(<?php echo count($dataloai); ?>),
          hoverOffset: 4
        }]
      };

      const config = {
        type: 'doughnut',
        data: data,
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      };

      // Khởi tạo biểu đồ
      var ctx = document.getElementById('myChart').getContext('2d');
      myChart = new Chart(ctx, config);

      function generateRandomColors(count) {
        var colors = [];
        for (var i = 0; i < count; i++) {
          var red = Math.floor(Math.random() * 256);
          var green = Math.floor(Math.random() * 256);
          var blue = Math.floor(Math.random() * 256);
          var color = "rgb(" + red + ", " + green + ", " + blue + ")";
          colors.push(color);
        }
        return colors;
      }

    });
  </script>
</body>

</html>