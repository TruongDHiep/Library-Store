<?php
include_once 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
include_once 'C:\xampp\htdocs\fahasa\adminweb\controller\thongkeController.php';
include_once 'C:\xampp\htdocs\fahasa\adminweb\controller\CustomerController.php';
include_once 'C:\xampp\htdocs\fahasa\adminweb\controller\sachController.php';
include_once 'C:\xampp\htdocs\fahasa\adminweb\controller\EmloyeeController.php';

$controller  = new StaticController($mysqli);
$sachController = new SachController($mysqli);
$cutomercontroller = new CustomerController($mysqli);
$emloyeecontroller = new EmloyeeController($mysqli);

$datacustomer = $cutomercontroller->countAllCustomer();
$datadoanhthu = $controller->gettongdoanhthu();
$datassach = $sachController->countAllsach();
$datanv = $emloyeecontroller->countAllEmloyyee();

// Trích xuất giá trị tổng doanh thu từ mảng
$tongDoanhThu = isset($datadoanhthu[0]['tongDoanhThu']) ? $datadoanhthu[0]['tongDoanhThu']  : 0;

// Định dạng lại giá trị số thành dạng có dấu phẩy ngăn cách hàng nghìn
$tongDoanhThuFormatted = number_format($tongDoanhThu);

$ngayBDpie = $_POST['ngayBD-pie'] ?? date('Y-m-d', strtotime('-1 year'));
$ngayKTpie = $_POST['ngayKT-pie'] ?? date('Y-m-d');

$ngayBDcol = $_POST['ngayBD-col'] ?? date('Y-m-d', strtotime('-1 year'));
$ngayKTcol = $_POST['ngayKT-col'] ?? date('Y-m-d');

$doanhthuLoai = $controller->getdoanhthuByngay($ngayBDpie, $ngayKTpie);
$sachBanChay = $controller->getSachBanChay($ngayBDcol, $ngayKTcol);

$datadt = [];
$dataloai = [];
foreach ($doanhthuLoai as $key => $value) {
    $datadt[] = $value['tongDoanhThu'];
    $dataloai[] = $value['tenLoai'];
}

$databc = [];
$datatong = [];
foreach ($sachBanChay as $key => $value) {
    $databc[] = $value['tenSach'];
    $datatong[] = $value['tongDoanhThu'];
}

$data = [
    'labels1' => $dataloai,
    'data1' => $datadt,
    'labels2' => $databc,
    'data2' => $datatong
];




// Xuất dữ liệu dưới dạng JSON
echo json_encode($data);
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Doanh thu :<?php echo $tongDoanhThuFormatted ?> VND </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="">View Details</a>
                    <div class="small text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
                        </svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Khách hàng: <?php echo $datacustomer ?></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
                        </svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Sách:<?php echo $datassach ?> </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
                        </svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Nhan vien: <?php echo $datanv ?></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
                        </svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                </div>
            </div>
        </div>
    </div>

    <div class="static-conten">
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Biểu đồ doanh thu theo loại sách
                    </div>

                    <div style="width: 100%;" class="container-fluid px-4">
                        <form id="dateForm">
                            <div style="display: flex; flex-wrap: nowrap; justify-content: space-around;" class="inputdate">
                                <input class="dateinput-pie" id="BDinput-pie" type="date" name="ngayBD-pie" value="<?php echo $ngayBDpie; ?>">
                                <input class="dateinput-pie" id="TKinput-pie" type="date" name="ngayKT-pie" value="<?php echo $ngayKTpie; ?>">
                                <button type="submit" id="btn-pie" class="btn btn-primary">Xem biểu đồ</button>

                            </div>
                        </form>
                        <div class="chart1">
                            <canvas id="myChart1" style="width:100%;"></canvas>
                        </div>
                    </div>

                    <div class="card-body"><canvas id="myAreaChart1" width="100%" height="40"></canvas></div>
                </div>
            </div>


            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Biểu đồ sản phẩm bán chạy trong khoảng thời gian
                    </div>

                    <div style="width: 100%;" class="container-fluid px-4">
                        <form id="dateFormCol">
                            <div style="display: flex; flex-wrap: nowrap; justify-content: space-around;" class="inputdate">
                                <input class="dateinput-col" id="BDinput-col" type="date" name="ngayBD-col" value="<?php echo $ngayBDcol; ?>">
                                <input class="dateinput-col" id="TKinput-col" type="date" name="ngayKT-col" value="<?php echo $ngayKTcol; ?>">
                                <button type="submit" id="btn-col" class="btn btn-primary">Xem biểu đồ</button>

                            </div>
                        </form>
                        <div class="chart">
                            <canvas id="myChart2" style="width:100%;"></canvas>
                        </div>
                    </div>


                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
    </div>


</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ngayBDpie = document.getElementById('BDinput-pie');
        var ngayKTpie = document.getElementById('TKinput-pie');
        var myChart1;

        function fetchDataPie() {
            var startDate = ngayBDpie.value;
            var endDate = ngayKTpie.value;

            fetchChartDataPie(startDate, endDate);
        }



        // Sự kiện click cho button
        document.getElementById('btn-pie').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của button
            var startDate = document.getElementById('BDinput-pie').value;
            var endDate = document.getElementById('TKinput-pie').value;

            fetchChartDataPie(startDate, endDate);
        });






        function fetchChartDataPie(startDate, endDate) {
            // Tạo yêu cầu AJAX
            var formDataPie = new FormData(); // Tạo biến formData riêng cho biểu đồ pie
            formDataPie.append('ngayBD-pie', startDate);
            formDataPie.append('ngayKT-pie', endDate);

            fetch('pages/Dashboard.php', {
                    method: 'POST',
                    body: formDataPie // Sử dụng formDataPie cho yêu cầu AJAX này
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(textData => {
                    const jsonMatch = textData.match(/\{.*\}/);
                    if (jsonMatch && jsonMatch.length > 0) {
                        const jsonData = JSON.parse(jsonMatch[0]);
                        myChart1.data.labels1 = jsonData.labels1;
                        myChart1.data.datasets[0].data = jsonData.data1;
                        myChart1.data.datasets[0].backgroundColor = generateRandomColors(jsonData.labels1.length);
                        myChart1.update();
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        }





        // Khởi tạo biểu đồ ban đầu
        const dataPie = {
            labels: <?php echo json_encode($dataloai); ?>,
            datasets: [{
                label: 'Doanh thu theo loại sách',
                data: <?php echo json_encode($datadt); ?>,
                backgroundColor: generateRandomColors(<?php echo count($dataloai); ?>),
                hoverOffset: 4
            }]
        };

        const configPie = {
            type: 'doughnut',
            data: dataPie,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };


        var ctxPie = document.getElementById('myChart1').getContext('2d');
        myChart1 = new Chart(ctxPie, configPie);

        // Hàm tạo màu ngẫu nhiên
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




    document.addEventListener('DOMContentLoaded', function() {
        var ngayBDcol = document.getElementById('BDinput-col');
        var ngayKTcol = document.getElementById('TKinput-col');
        var myChart2;

        function fetchDataCol() {
            var startDate = ngayBDcol.value;
            var endDate = ngayKTcol.value;

            fetchChartDataCol(startDate, endDate);
        }

        // Sự kiện click cho button
        document.getElementById('btn-col').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của button
            // Lấy giá trị ngày bắt đầu và ngày kết thúc từ input
            var startDate = document.getElementById('BDinput-col').value;
            var endDate = document.getElementById('TKinput-col').value;

            fetchChartDataCol(startDate, endDate);
        });

        function fetchChartDataCol(startDate, endDate) {
            // Tạo yêu cầu AJAX
            var formDataCol = new FormData(); // Tạo biến formData riêng cho biểu đồ col
            formDataCol.append('ngayBD-col', startDate);
            formDataCol.append('ngayKT-col', endDate);

            fetch('pages/Dashboard.php', {
                    method: 'POST',
                    body: formDataCol // Sử dụng formDataCol cho yêu cầu AJAX này
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(textData => {
                    const jsonMatch = textData.match(/\{.*\}/);
                    if (jsonMatch && jsonMatch.length > 0) {
                        const jsonData = JSON.parse(jsonMatch[0]);
                        myChart2.data.labels = jsonData.labels2;
                        myChart2.data.datasets[0].data = jsonData.data2;
                        myChart2.data.datasets[0].backgroundColor = generateRandomColors(jsonData.labels2.length);
                        myChart2.update();
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        }




        // Khởi tạo biểu đồ ban đầu
        const dataCol = {
            labels: <?php echo json_encode($databc); ?>,
            datasets: [{
                label: 'Doanh thu theo sách bán chạy',
                data: <?php echo json_encode($datatong); ?>,
                backgroundColor: generateRandomColors(<?php echo count($databc); ?>),
                hoverOffset: 4
            }]
        };

        const configCol = {
            type: 'bar',
            data: dataCol,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };

        var ctxCol = document.getElementById('myChart2').getContext('2d');
        myChart2 = new Chart(ctxCol, configCol);

        // Hàm tạo màu ngẫu nhiên
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