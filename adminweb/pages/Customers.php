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
    if ($ctq['maCN'] == 4) {
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
<h1 class="mt-4">Quản lí khách hàng</h1>

<div class="search">
    <input type="text" id="searchInput" placeholder="Tìm kiếm...">
    <i class="fa fa-magnifying-glass"></i>
</div>
<script src="script/sorttable.js"></script>
<?php

include 'controller/CustomerController.php';


$controller = new CustomerController($mysqli);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 15; // Số khách hàng trên mỗi trang
$CustomerData = $controller->getCustomerByPage($page,$itemsPerPage);


if (!empty($CustomerData)) {
    // Hiển thị dữ liệu hóa đơn
    // Ví dụ: 
    echo"<table class='sortable'>
            <thead>
                <tr>
                    <th>Mã KH</th>
                    <th>Tên khách hàng</th>
                    <th>Địa chỉ</th>
                    <th>SDT</th>
                    <th>Tài khoản</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($CustomerData as $Customer) {
        if($Customer['trangThai']==1){
        echo "<tr>"; // Bắt đầu một hàng mới
        echo "<td class='hienthi'>" . $Customer["maKH"] . "</td>";
        echo "<td class='hienthi'>" . $Customer["tenKH"] . "</td>";
        echo "<td class='hienthi'>" . $Customer["diaChi"] . "</td>";
        echo "<td class='hienthi'>" . $Customer["SDT"] . "</td>";
        echo "<td class='hienthi'>" . $Customer["maTK"] . "</td>";
        echo '<td class="hanhdong">';
        if ($buttons['xoa']) {
             echo'   <button id="delete"  class="deleteButton" data-id="' . $Customer["maKH"] . '" current-page="'. $page.'"><i class="fa-solid fa-trash"></i></button>';
        }
        if ($buttons['sua']) { 
             echo'   <button class="editButton" ><a class="customer_a" href="admin.php?action=customer&query=customer_edit&sid=' . $Customer["maKH"] . '"><i class="fa-solid fa-pen-to-square"></i></a></button>';
        }
            echo' </td>';
        echo "</tr>"; // Kết thúc hàng
        }
    }   
    echo "</tbody></table>";
    $totalPages = ceil($controller->countAllCustomer() / $itemsPerPage);

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
            loadcustomerData(page); // Gọi hàm để tải dữ liệu của trang mới
        });
    });
});

// Function to load employee data for a specific page via AJAX
function loadcustomerData(page) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "admin.php?action=customer&query=customer&page=" + page, true);
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
    // Assuming the response contains a table with class "customer-table"
    var parser = new DOMParser();
    var htmlDoc = parser.parseFromString(response, "text/html");
    var tableContent = htmlDoc.querySelector(".sb-nav-fixed #layoutSidenav_content").innerHTML;
    return tableContent;
}

document.addEventListener("DOMContentLoaded", function() {
    attachEventListeners();
});
function attachEventListeners() {
    var deleteButtons = document.querySelectorAll(".deleteButton");
    deleteButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            // Hiển thị hộp thoại xác nhận
            var confirmation = confirm('Bạn có muốn xoá khách hàng !');
            // Nếu người dùng đồng ý
            if (confirmation) {
                var maKH = this.getAttribute("data-id");
                var currentPage = this.getAttribute("current-page"); 
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "pages/form/customer/delete_customer.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Hiển thị thông báo từ phản hồi
                            alert(xhr.responseText);
                         
                            loadcustomerData(currentPage);
                        
                        } else {
                            alert("Có lỗi xảy ra khi gửi yêu cầu.");
                        }
                    }
                };
                // Gửi yêu cầu với dữ liệu maKH
                xhr.send("maKH=" + maKH);
            }
        });
    });

    var paginationLinks = document.querySelectorAll(".pagination-link");
    paginationLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

            var page = this.getAttribute("data-page"); // Lấy số trang từ thuộc tính data-page
            loadcustomerData(page); // Gọi hàm để tải dữ liệu của trang mới
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



