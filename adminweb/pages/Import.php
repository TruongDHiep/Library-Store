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
    if ($ctq['maCN'] == 6) {
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
<h1 class="mt-4">Quản lí nhập hàng</h1>
<div class="headfiler">
    <div class="search">
             <input type="text" placeholder="Tìm kiếm...">
             <i class="fa fa-magnifying-glass"></i>
    </div>
    <div class="add">  
    <?php if ($buttons['them']) : ?>    
            <a class="btn btn-primary"  href="admin.php?action=import&query=import_add"><i class="fa fa-plus"></i>
            Add Import</a>   
            <?php endif; ?>
    </div>
</div>
<script src="script/sorttable.js"></script>
<?php
// Include file config
include 'controller/ImportController.php';

// Khởi tạo đối tượng ImportController
$controller = new ImportController($mysqli);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 15; // Số khách hàng trên mỗi trang
$ImportData = $controller->getimportByPage($page,$itemsPerPage);

if (!empty($ImportData)) {
    // Hiển thị dữ liệu phiếu nhập
    echo "<table class='sortable'>
            <thead>
                <tr>
                    <th>Mã phiếu nhập</th>
                    <th>Mã nhà cung cấp</th>
                    <th>Mã nhân viên</th>
                    <th>Tổng tiền</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($ImportData as $Import) {
        if($Import['trangThai']==1){
        echo "<tr>"; // Bắt đầu một hàng mới
        echo "<td class='hienthi'>" . $Import["maPN"] . "</td>";
        echo "<td class='hienthi'>" . $Import["maNCC"] . "</td>";
        echo "<td class='hienthi'>" . $Import["maNV"] . "</td>";
        echo "<td class='hienthi'>" . $Import["tongTien"] . "</td>";
        echo "<td class='hienthi'>" . $Import["ngayTao"] . "</td>";
        echo '<td class="hanhdong">';
        if ($buttons['xoa']) {
              echo'  <button id="delete" class="deleteButton" data-id="' . $Import["maPN"] . ' " current-page="'. $page.'" ><i class="fa-solid fa-trash"></i></button>';
         }
         if ($buttons['sua']) {
         echo' <button class="editButton" ><a class="order_a" href="admin.php?action=Import&query=Import_edit&sid=' . $Import["maPN"] . '&maNV=' . $Import["maNV"] . '&maPN=' . $Import["maPN"] . '"><i class="fa-solid fa-pen-to-square"></i></a></button>';
         }
         echo'</td>';

        echo "</tr>"; // Kết thúc hàng
    }
}
    echo "</tbody></table>";
    $totalPages = ceil($controller->countAllimport() / $itemsPerPage);

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
    // Hiển thị thông báo nếu không có dữ liệu phiếu nhập
    echo "Không có dữ liệu phiếu nhập.";
}
?>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    attachEventListeners();
});

function attachEventListeners() {
    var tableRows = document.querySelectorAll("tbody tr");
    tableRows.forEach(function(row) {
        row.addEventListener("click", function(event) {
            if (event.target.classList.contains('hienthi')) {
                var maPN = row.querySelector("td:first-child").textContent;
                window.location.href = "admin.php?action=details_import&query=details_import&maPN=" + maPN;
            }
        });
    });

    var deleteButtons = document.querySelectorAll(".deleteButton");
    deleteButtons.forEach(function(button) {
        button.addEventListener("click", function(event) {
            event.stopPropagation(); // Ngăn chặn sự kiện click trên hàng bảng
            var confirmation = confirm('Bạn có muốn xoá phiếu nhập!');
            if (confirmation) {
                var maPN = this.getAttribute("data-id");
                var currentPage = this.getAttribute("current-page");
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "pages/form/import/delete_import.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                            loadImportData(currentPage);
                        } else {
                            alert("Có lỗi xảy ra khi gửi yêu cầu.");
                        }
                    }
                };
                xhr.send("maPN=" + maPN);
            }
        });
    });

    var paginationLinks = document.querySelectorAll(".pagination-link");
    paginationLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            var page = this.getAttribute("data-page");
            loadImportData(page);
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
            row.style.display = shouldDisplay ? "" : "none";
        });
    });
}

function loadImportData(page) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "admin.php?action=import&query=import&page=" + page, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = xhr.responseText;
            var tableContainer = document.querySelector(".sb-nav-fixed #layoutSidenav_content");
            tableContainer.innerHTML = extractTableContent(response);
            attachEventListeners(); // Gọi lại hàm để đính kèm sự kiện sau khi tải nội dung mới
        }
    };
    xhr.send();
}

function extractTableContent(response) {
    var parser = new DOMParser();
    var htmlDoc = parser.parseFromString(response, "text/html");
    return htmlDoc.querySelector(".sb-nav-fixed #layoutSidenav_content").innerHTML;
}

</script>
