
<?php
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['current_admin'])) {
    // Chuyển hướng người dùng đến trang đăng nhập nếu chưa đăng nhập
    header("Location: index.php");
    exit;
}

// Include controller
//include 'C:\xampp\htdocs\fahasa\adminweb\controller\ctq_cnController.php';

// Lấy mã quyền của người dùng từ session
$maQuyen = $_SESSION['current_admin']['maQuyen'];

$ctq_cnController = new CTQ_CN_Controller($mysqli);
$ctq_cnData = $ctq_cnController->getCTQ_CNByMaQuyen($maQuyen);
    
// Khởi tạo mảng chứa thông tin về các nút (thêm, sửa, xóa)
$buttons = array(
    'them' => false, // Mặc định ẩn nút thêm
    'sua' => false,  // Mặc định ẩn nút sửa
    'xoa' => false   // Mặc định ẩn nút xóa
);

// Duyệt qua dữ liệu CTQ_CN để xác định xem nút nào cần hiển thị
foreach ($ctq_cnData as $ctq) {
    if ($ctq['maCN'] == 2) {
        // Nếu có quyền thêm, hiển thị nút thêm
        if ($ctq['hoatDong'] == 't') {
            $buttons['them'] = true;
        }
        // Nếu có quyền sửa, hiển thị nút sửa
        elseif ($ctq['hoatDong'] == 's') {
            $buttons['sua'] = true;
        }
        // Nếu có quyền xóa, hiển thị nút xóa
        elseif ($ctq['hoatDong'] == 'x') {
            $buttons['xoa'] = true;
        }
    }
}

?>
<div class="container-fluid px-4">

<h1 class="mt-4">Quản lí đơn hàng</h1>

<div class="headfiler">
    <div class="search" id="searchInput">
    <input type="text" id="searchInput" placeholder="Tìm kiếm...">
    </div>
    <div class="add" style="display:flex; justify-content: space-between; align-items: center;  ">
    <form method="GET" action="admin.php" style="display: flex;">
                <input type="hidden" name="action" value="order">
                <input type="hidden" name="query" value="order">
                <input id="start_date" type="date" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                <input id="end_date" style="margin-left:10px;" type="date" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                <button id="ngayButton" style="margin-left:10px;" type="submit">Submit</button>
                             
            </form>
    </div>
    <div class="add">
        <a class="btn btn-primary" id="duyet"><i class="fa fa-plus"></i> Duyệt đơn</a>
        <a class="btn btn-primary" id="huy"><i class="fa fa-plus"></i>Huỷ đơn</a>
    </div>
</div>

<script src="script/sorttable.js"></script>

<?php

include 'controller/HoaDonController.php';


$controller = new HoaDonController($mysqli);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 15; // Số hoá đơn trên mỗi trang
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;
echo "từ". $startDate. " đến ". $endDate;
// Kiểm tra giá trị của các trường input date và gọi phương thức phù hợp
if ($startDate && $endDate) {
    $hoaDonData = $controller->getHoaDonByDateRange($startDate, $endDate,$page, $itemsPerPage);
} else {
    $hoaDonData = $controller->getHoaDonByPage($page, $itemsPerPage);
}
if (!empty($hoaDonData)) {
  
    echo "<table class='sortable'>
            <thead>
                <tr>
                    
                    <th>Mã HD</th>
                    <th>Mã KH</th>
                    <th>Tổng tiền</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Duyệt</th>
                    <th>Hành động</th>
                    
                </tr>
            </thead>
            <tbody>";
    foreach ($hoaDonData as $hoaDon) {
        if ($hoaDon['trangThai'] == 1) {
            echo "<tr>"; // Bắt đầu một hàng mới
            echo "<td class='hienthi'>" . $hoaDon["maHD"] . "</td>";
            echo "<td class='hienthi'>" . $hoaDon["maHD"] . "</td>";           
            echo "<td class='hienthi'>" . number_format($hoaDon["tongTien"]) . "</td>";
            echo "<td class='hienthi'>" . $hoaDon["ngayTao"] . "</td>";
            if ($hoaDon["trangThaiHoaDon"] == 1) {
                echo "<td class='hienthi' id='duyet'>đang xử lí</td>";
                echo "<td><input type='checkbox' name='selectedHD[]' value='" . $hoaDon["maHD"] . "'></td>";
            } elseif ($hoaDon["trangThaiHoaDon"] == 2) {
                echo "<td class='hienthi'>Đã xử lí</td>";
                echo "<td></td>";
            } else {
                echo "<td class='hienthi'>đã huỷ</td>";
                echo "<td></td>";
            }
            echo '<td class="hanhdong">';
            if ($buttons['xoa']) {
              echo'  <button id="delete" class="deleteButton" data-id="' . $hoaDon["maHD"] . '" current-page="' . $page . '"><i class="fa-solid fa-trash"></i></button>';
            }
              echo' </td>';
            echo "</tr>"; // Kết thúc hàng
        }
    }
    echo "</tbody></table>";
  
    if ($startDate && $endDate) {
        $totalPages = ceil($controller->coutHoaDonByDateRange($startDate, $endDate,$page, $itemsPerPage) / $itemsPerPage);
        if ($totalPages > 1) {
            echo "<div class='pagination'>";
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a class='pagination-link-date' href='#' data-page='$i' start_date='$startDate' end_date='$endDate' >$i</a>";
            }
            echo "</div>";
        }
    } else {
        $totalPages = ceil($controller->countAllHoaDon() / $itemsPerPage);
        if ($totalPages > 1) {
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a class='pagination-link' href='#' data-page='$i'>$i</a>";
        }
        echo "</div>";
    }
    }
  

    
} else {
    echo "Không có dữ liệu hóa đơn.";
}

?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    attachEventListeners();
    
});
function attachEventListeners() {
    // ---------------------lấy ngày để load lại bảng -----------
    var ngayButton = document.getElementById('ngayButton');
    ngayButton.addEventListener('click', function(event) {
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value;
        if (start_date !== '' && end_date !== '') {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của nút submit
            var form = ngayButton.closest('form');
            form.submit();
        } else {
            alert('Vui lòng chọn ngày đầy đủ.');
        }
    });

    // ----------------------- sự kiện cho nút duyệt --------------------

    var duyetButton = document.getElementById('duyet');
    duyetButton.addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[name="selectedHD[]"]:checked');
        var selectedValues = [];

        checkboxes.forEach(function(checkbox) {
            selectedValues.push(checkbox.value);
        });

        if (selectedValues.length > 0) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'pages/form/order/duyet_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi gửi yêu cầu.');
                    }
                }
            };
            xhr.send('maHD=' + JSON.stringify(selectedValues));
        } else {
            alert('Vui lòng chọn ít nhất một hóa đơn để duyệt.');
        }
    });

// -------------------------- sự kiện cho nút huỷ -------------------------

    var duyetButton = document.getElementById('huy');
    duyetButton.addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[name="selectedHD[]"]:checked');
        var selectedValues = [];

        checkboxes.forEach(function(checkbox) {
            selectedValues.push(checkbox.value);
        });

        if (selectedValues.length > 0) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'pages/form/order/huy_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);
                        location.reload();;
                    } else {
                        alert('Có lỗi xảy ra khi gửi yêu cầu.');
                    }
                }
            };
            xhr.send('maHD=' + JSON.stringify(selectedValues));
        } else {
            alert('Vui lòng chọn ít nhất một hóa đơn để duyệt.');
        }
    });


//    -------------------------- sự kiện chuyển trang chi tiết hoá đơn------------------------

    var tableRows = document.querySelectorAll("tbody tr");

    tableRows.forEach(function(row) {
        row.addEventListener("click", function(event) {
            // Kiểm tra xem người dùng click vào ô hành động hay không
            if (event.target.classList.contains('hienthi')) {
                // Nếu không phải là ô hành động, chuyển trang
                var maHD = row.querySelector("td:first-child").textContent;
                window.location.href = "admin.php?action=details&query=details&maHD=" + maHD;
            }
        });
    });






    var deleteButtons = document.querySelectorAll(".deleteButton");
    deleteButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var confirmation = confirm('Bạn có muốn xoá hoá đơn !');
            if (confirmation) {
                var maHD = this.getAttribute("data-id");
                var currentPage = this.getAttribute("current-page");
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "pages/form/order/delete_order.php", true); // Chỉnh sửa đường dẫn ở đây nếu cần
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                            loadorderData(currentPage);
                        } else {
                            alert("Có lỗi xảy ra khi gửi yêu cầu.");
                        }
                    }
                };
                xhr.send("maHD=" + maHD);
            }
        });
    });

    // Các sự kiện khác như phân trang, tìm kiếm, v.v.
    attachPaginationListeners();
    attachSearchListeners();
}

function loadorderDatadate(page, start_date, end_date) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "admin.php?action=order&query=order&page=" + page + "&start_date=" + start_date + "&end_date=" + end_date, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = xhr.responseText;
            var tableContent = extractTableContent(response);
            var tableContainer = document.querySelector(".sb-nav-fixed #layoutSidenav_content");
            tableContainer.innerHTML = tableContent;

            // Gán lại sự kiện sau khi tải lại nội dung
            attachEventListeners();
        }
    };
    xhr.send();
}


function loadorderData(page) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "admin.php?action=order&query=order&page=" + page, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = xhr.responseText;
            var tableContent = extractTableContent(response);
            var tableContainer = document.querySelector(".sb-nav-fixed #layoutSidenav_content");
            tableContainer.innerHTML = tableContent;

            // Gán lại sự kiện sau khi tải lại nội dung
            attachEventListeners();
        }
    };
    xhr.send();
}

function extractTableContent(response) {
    var parser = new DOMParser();
    var htmlDoc = parser.parseFromString(response, "text/html");
    var tableContent = htmlDoc.querySelector(".sb-nav-fixed #layoutSidenav_content").innerHTML;
    return tableContent;
}

function attachPaginationListeners() {
    var paginationLinks = document.querySelectorAll(".pagination-link");
    paginationLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            var page = this.getAttribute("data-page");
            loadorderData(page);
        });
    });
}
function attachPaginationListeners() {
    var paginationLinks = document.querySelectorAll(".pagination-link-date");
    paginationLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            var page = this.getAttribute("data-page");
            var start_date = this.getAttribute("start_date");
            var end_date = this.getAttribute("end_date");
            loadorderDatadate(page,start_date,end_date);
        });
    });
}

function attachSearchListeners() {
    var searchInput = document.querySelector(".search input");
    searchInput.addEventListener("input", function() {
        var keyword = searchInput.value.toLowerCase().trim();
        var rows = document.querySelectorAll("tbody tr");

        rows.forEach(function(row) {
            var shouldDisplay = false;
            var cells = row.querySelectorAll("td");
            
            cells.forEach(function(cell) {
                if (cell.textContent.toLowerCase().indexOf(keyword) > -1) {
                    shouldDisplay = true;
                }
            });

            if (shouldDisplay) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
}

</script>
