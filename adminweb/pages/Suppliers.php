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
    if ($ctq['maCN'] == 5) {
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
<h1 class="mt-4">Quản lí nhà cung cấp</h1>
<div class="headfiler">
    <div class="search">
        <input type="text" placeholder="Tìm kiếm...">
        <i class="fa fa-magnifying-glass"></i>
    </div>
    <div class="add">
    <?php if ($buttons['them']) : ?>  
        <a class="btn btn-primary" href="admin.php?action=suppliers&query=suppliers_add"><i class="fa fa-plus"></i>Add Suppliers</a>
        <?php endif; ?>
    </div>
</div>
<div class="table">
<script src="script/sorttable.js"></script>

<?php
// Bao gồm file config
include 'controller/SupplierController.php';

// Khởi tạo đối tượng SupplierController
$controller = new SupplierController($mysqli);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 5; // Số nhà cung cấp trên mỗi trang
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if ($keyword) {
    $supplierData = $controller->searchSupplier($keyword, $page, $itemsPerPage);
    $totalSuppliers = $controller->countSearchSupplier($keyword); // Cập nhật phương thức này để đếm dựa trên từ khóa
} else {
    $supplierData = $controller->getSupplierByPage($page, $itemsPerPage);
    $totalSuppliers = $controller->countAllSupplier();
}

if (!empty($supplierData)) {
    // Hiển thị dữ liệu nhà cung cấp
    echo "<table class='sortable'>
            <thead>
                <tr>
                    <th>Mã nhà cung cấp</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($supplierData as $supplier) {
        if($supplier['trangThai'] == 1){
            echo "<tr>";
            echo "<td>" . $supplier["maNCC"] . "</td>";
            echo "<td>" . $supplier["tenNCC"] . "</td>";
            echo "<td>" . $supplier["diaChi"] . "</td>";
            echo "<td>" . $supplier["SDT"] . "</td>";
            echo '<td class="hanhdong">';
            if ($buttons['xoa']) {
                echo'<button id="delete" class="deleteButton" data-id="' . $supplier["maNCC"] . '" current-page="'. $page.'"><i class="fa-solid fa-trash"></i></button>';
            }
            if ($buttons['sua']){
                echo'<button class="editButton"><a class="order_a" href="admin.php?action=supplier&query=supplier_edit&sid=' . $supplier["maNCC"] . '"><i class="fa-solid fa-pen-to-square"></i></a></button>';
                 
            }
            echo'</td>';
            echo "</tr>";
        }
    }
    echo "</tbody></table>";

    $totalPages = ceil($totalSuppliers / $itemsPerPage);

    if ($totalPages > 1) {
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a class='pagination-link' href='#' data-page='$i'>$i</a>";
        }
        echo "</div>";
    }   
} else {
    echo "Không có dữ liệu nhà cung cấp.";
}
?>


</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    function attachEventListeners() {
        document.querySelectorAll(".deleteButton").forEach(button => {
            button.addEventListener("click", function() {
                var confirmation = confirm('Bạn có muốn xoá nhà cung cấp !');
                if (confirmation) {
                    var maNCC = this.getAttribute("data-id");
                    var currentPage = this.getAttribute("current-page");
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "pages/form/suppliers/delete_supplier.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            alert(xhr.responseText);
                            loadSuppliersData(currentPage);
                        } else if (xhr.readyState === XMLHttpRequest.DONE) {
                            alert("Có lỗi xảy ra khi gửi yêu cầu.");
                        }
                    };
                    xhr.send("maNCC=" + maNCC);
                }
            });
        });

        document.querySelectorAll(".pagination-link").forEach(link => {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                var page = this.getAttribute("data-page");
                loadSuppliersData(page);
            });
        });
    }

    function loadSuppliersData(page, keyword = '') {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "admin.php?action=suppliers&query=suppliers&page=" + page + "&keyword=" + keyword, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var response = xhr.responseText;
                var tableContainer = document.querySelector(".table tbody");
                tableContainer.innerHTML = extractTableContent(response);
                attachEventListeners();
            }
        };
        xhr.send();
    }

    function extractTableContent(response) {
        var parser = new DOMParser();
        var htmlDoc = parser.parseFromString(response, "text/html");
        var tableContent = htmlDoc.querySelector(".sortable tbody").innerHTML;
        return tableContent;
    }

    var searchInput = document.querySelector(".search input");
    searchInput.addEventListener("input", function() {
        var keyword = searchInput.value.trim();
        loadSuppliersData(1, keyword);
    });

    attachEventListeners();
    loadSuppliersData(1);
});

</script>
