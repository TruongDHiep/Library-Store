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
    if ($ctq['maCN'] == 3) {
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
<h1 class="mt-4">Quản lí nhân viên</h1>
<div class="headfiler">
    <div class="search">
             <input type="text" placeholder="Tìm kiếm...">
             <i class="fa fa-magnifying-glass"></i>
    </div>
    <div class="add">
    <?php if ($buttons['them']) : ?>
        <a class="btn btn-primary"  href="admin.php?action=emloyee&query=emloyee_add"><i class="fa fa-plus"></i>Add Emloyee</a>
        <?php endif; ?>
    </div>
</div>
<script src="script/sorttable.js"></script>

<?php

include 'controller/EmloyeeController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 15; // Số nhân viên trên mỗi trang
$controller = new EmloyeeModel($mysqli);
$NhanvienData = $controller->getEmloyyeeByPage($page, $itemsPerPage);


if (!empty($NhanvienData)) {
    // Hiển thị dữ liệu hóa đơn
    // Ví dụ: 
    echo"<table class='sortable'>
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Tên NV</th>
                    <th>SDT</th>
                    <th>Địa chỉ</th>
                    <th>Ngày vào làm</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($NhanvienData as $nhanVien) {
    if($nhanVien['trangThai']==1){
        echo "<tr>"; // Bắt đầu một hàng mới
        echo "<td class='hienthi'>" . $nhanVien["maNV"] . "</td>";
        echo "<td class='hienthi'>" . $nhanVien["tenNV"] . "</td>";
        echo "<td class='hienthi'>" . $nhanVien["SDT"] . "</td>";
        echo "<td class='hienthi'>" . $nhanVien["diaChi"] . "</td>";
        echo "<td class='hienthi'>" . $nhanVien["ngayVaoLam"] . "</td>";
        echo '<td class="hanhdong">';
        if ($buttons['xoa']) {
              echo'  <button id="delete"  class="deleteButton" data-id="' . $nhanVien["maNV"] . '" current-page="'. $page.'"><i class="fa-solid fa-trash"></i></button>';
        }
        if ($buttons['sua']) {
            echo'  <button class="editButton" ><a class="order_a" href="admin.php?action=emloyee&query=emloyee_edit&sid=' . $nhanVien["maNV"] . '"><i class="fa-solid fa-pen-to-square"></i></a></button>';
             
        }
       echo' </td>';
        echo "</tr>"; // Kết thúc hàng
      }
    }
    echo "</tbody></table>";

    // Tính toán số lượng trang
    $totalPages = ceil($controller->countAllEmloyyee() / $itemsPerPage);

    // Hiển thị phân trang nếu có nhiều hơn một trang
    if ($totalPages > 1) {
        echo "<div class='pagination'>";
        // Thay đổi các liên kết trong phân trang để chúng gửi yêu cầu AJAX
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a class='pagination-link' href='#' data-page='$i'>$i</a>";
        }
        echo "</div>";
    }   
} else {
    // Hiển thị thông báo nếu không có dữ liệu hóa đơn
    echo "Không có dữ liệu hóa đơn.";
}
?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var paginationLinks = document.querySelectorAll(".pagination-link");

    paginationLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

            var page = this.getAttribute("data-page"); // Lấy số trang từ thuộc tính data-page
            loadEmloyeeData(page); // Gọi hàm để tải dữ liệu của trang mới
        });
    });
});

// Function to load employee data for a specific page via AJAX
function loadEmloyeeData(page) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "admin.php?action=emloyee&query=emloyee&page=" + page, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Extract the table content from the response
            var response = xhr.responseText;
            var tableContent = extractTableContent(response);
            
            // Update the table content in the current page
            var tableContainer = document.querySelector(".sb-nav-fixed #layoutSidenav_content");
            tableContainer.innerHTML = tableContent;

            var script = document.createElement('script');
            script.src = 'script/sorttable.js';
            document.head.appendChild(script);
            attachEventListeners();
            
        }
    };
    xhr.send();
}

// Function to extract table content from the response
function extractTableContent(response) {
    // Assuming the response contains a table with class "emloyee-table"
    var parser = new DOMParser();
    var htmlDoc = parser.parseFromString(response, "text/html");
    var tableContent = htmlDoc.querySelector(".sb-nav-fixed #layoutSidenav_content").innerHTML;
    return tableContent;
}
function getCurrentPage() {
      // Lấy URL hiện tại
      var currentURL = window.location.href; 
    // Phân tích URL để trích xuất tham số truy vấn 'page'
    var urlParams = new URLSearchParams(new URL(currentURL).search);
    // Lấy giá trị của tham số 'page'
    var currentPage = urlParams.get('page');
    // Kiểm tra nếu currentPage có giá trị null hoặc undefined
    // Thì trả về giá trị mặc định là 1
    return currentPage || 1; 
}
document.addEventListener("DOMContentLoaded", function() {
    attachEventListeners();
});
function attachEventListeners() {
    var deleteButtons = document.querySelectorAll(".deleteButton");
    deleteButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            // Hiển thị hộp thoại xác nhận
            var confirmation = confirm('Bạn có muốn xoá nhân viên !');
            // Nếu người dùng đồng ý
            if (confirmation) {
                var maNV = this.getAttribute("data-id");
                var currentPage = this.getAttribute("current-page"); 
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "pages/form/emloyee/delete_emloyee.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Hiển thị thông báo từ phản hồi
                            alert(xhr.responseText);
                            // Gọi lại hàm để load dữ liệu trang hiện tại
                            loadEmloyeeData(currentPage);
                        } else {
                            alert("Có lỗi xảy ra khi gửi yêu cầu.");
                        }
                    }
                };
                // Gửi yêu cầu với dữ liệu maNV
                xhr.send("maNV=" + maNV);
            }
        });
    });

    var paginationLinks = document.querySelectorAll(".pagination-link");
    paginationLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

            var page = this.getAttribute("data-page"); // Lấy số trang từ thuộc tính data-page
            loadEmloyeeData(page); // Gọi hàm để tải dữ liệu của trang mới
        });
    });
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
                row.style.display = ""; // Hiển thị hàng nếu có từ khóa khớp
            } else {
                row.style.display = "none"; // Ẩn hàng nếu không có từ khóa khớp
            }
        });
    });
}
</script>




