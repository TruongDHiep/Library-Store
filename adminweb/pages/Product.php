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
    if ($ctq['maCN'] == 1) {
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
<div class="filer">
    <h1 class="mt-4" >Danh sách sản phẩm</h1>
    <div class="headfiler">
        <div class="search">
            <input id="searchInput" type="text" placeholder="Tìm kiếm..." value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
        </div>

        <div class="add">
        <?php if ($buttons['them']) : ?>
            <a class="btn btn-primary" href="admin.php?action=product&query=product_add"><i class="fa fa-plus"></i> Thêm sản phẩm</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="script/sorttable.js"></script>
<?php
// Include file config
include 'controller/sachController.php';
include 'controller/hinhAnhController.php';


// Khởi tạo đối tượng UsersController
$sachcontroller = new sachController($mysqli);
$hinhanhcontroller = new hinhAnhController($mysqli);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 4; // Số sản phẩm trên mỗi trang
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
echo $keyword;
// Nếu có từ khóa tìm kiếm, tìm kiếm sách theo từ khóa
if ($keyword != '') {
    $sachData = $sachcontroller->searchSach($keyword, $page, $itemsPerPage);
} else {
    $sachData = $sachcontroller->getsachByPage($page, $itemsPerPage);
}
if (!empty($sachData)) {
    // Hiển thị dữ liệu sách
    echo "<table class='sortable'>
            <thead>
                <tr>
                    <th class='maSach'>Mã sách</th>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Nhà xuất bản</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thể loại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($sachData as $sach) {
        echo "<tr>"; // Bắt đầu một hàng mới
        echo "<td>" . $sach["maSach"] . "</td>";
        echo "<td class='ten_sach'>";
        // Lấy thông tin hình ảnh của sách từ bảng hinhAnh
        $hinhAnh = $hinhanhcontroller->getImagesByBookId($sach['maSach']);
        // Kiểm tra xem có hình ảnh nào cho sách này không
        if (!empty($hinhAnh)) {
            // Hiển thị hình ảnh đầu tiên
            echo "<div><img class='pic_list' src='./img/" . $hinhAnh[0]["maHinh"] . "'/></div>";
        } else {
            // Nếu không có hình ảnh, hiển thị một hình ảnh mặc định hoặc thông báo không có hình ảnh
            echo "Không có hình ảnh";
        }
        echo "<div>" . $sach["tenSach"] . "</div></td>";
        echo "<td>" . $sach["TacGia"] . "</td>";
        echo "<td>" . $sach["NXB"] . "</td>";
        echo "<td>" . $sach["giaXuat"] . "</td>";
        echo "<td>" . $sach["soLuong"] . "</td>";
        echo "<td>" . $sach["maLoai"] . "</td>";
        echo '<td class="hanhdong">';
        if ($buttons['xoa']) {
               echo' <button id="delete" class="deleteButton" data-id="' . $sach["maSach"] . '" current-page="'. $page.'"><i class="fa-solid fa-trash"></i></button>';
        }
        if ($buttons['sua']) {
              echo'  <button class="editButton" ><a class="prodcut_a" href="admin.php?action=product&query=product_edit&sid=' . $sach["maSach"] . '"><i class="fa-solid fa-pen-to-square"></i></a></button>';
        }  
              echo' </td>';
        echo "</tr>"; // Kết thúc hàng
    }
    echo "</tbody></table>";
    if ( $keyword) {
        $totalPages = ceil($sachcontroller->countsearch($keyword) / $itemsPerPage);
        if ($totalPages > 1) {
     
            echo "<div class='pagination'>";
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a class='pagination-link-search' href='#' data-page='$i' keyword='$keyword' >$i</a>";
            }
            echo "</div>";
        }
    } else {
        $totalPages = ceil($sachcontroller->countAllsach()/ $itemsPerPage);
        if ($totalPages > 1) {
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a class='pagination-link' href='#' data-page='$i'>$i</a>";
        }
        echo "</div>";
    }
    }
} else {
    // Hiển thị thông báo nếu không có dữ liệu sách
    echo "Không có dữ liệu sách.";
}
?>
</div>
<script>
  


// Function to load employee data for a specific page via AJAX
function loadproductData(page) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "admin.php?action=product&query=product&page=" + page, true);
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
function loadProductDatasearch(page,keyword) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "admin.php?action=product&query=product&page=" + page + "&keyword=" + encodeURIComponent(keyword), true);
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
            var searchInput = document.getElementById("searchInput");
            searchInput.focus();
            var val = searchInput.value; // Lưu giữ giá trị hiện tại của input
            searchInput.value = ''; // Xóa giá trị của input
            searchInput.value = val;
        }
    };
    xhr.send();
}
 
// Function to extract table content from the response
function extractTableContent(response) {
    // Assuming the response contains a table with class "product-table"
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
            var confirmation = confirm('Bạn có muốn xoá sản phẩm !');
            // Nếu người dùng đồng ý
            if (confirmation) {
                var maSach = this.getAttribute("data-id");
                var currentPage = this.getAttribute("current-page"); 
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "pages/form/product/delete_product.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Hiển thị thông báo từ phản hồi
                            alert(xhr.responseText);
                            loadproductData(currentPage);
                        
                        } else {
                            alert("Có lỗi xảy ra khi gửi yêu cầu.");
                        }
                    }
                };
                // Gửi yêu cầu với dữ liệu maSach
                xhr.send("maSach=" + maSach);
            }
        });
    });

    var paginationLinks = document.querySelectorAll(".pagination-link");
    paginationLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

            var page = this.getAttribute("data-page"); // Lấy số trang từ thuộc tính data-page
            loadproductData(page); // Gọi hàm để tải dữ liệu của trang mới
        });
    });

   
    var paginationLinks = document.querySelectorAll(".pagination-link-search");
    paginationLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            var page = this.getAttribute("data-page");
            var keyword = this.getAttribute ("keyword")
            loadProductDatasearch(page,keyword);
        });
    });

    var searchInput = document.querySelector("#searchInput");
    searchInput.addEventListener("input", function() {
        var keyword = searchInput.value.toLowerCase().trim();
        loadProductDatasearch(1, keyword); // Gọi hàm để tải dữ liệu với từ khóa tìm kiếm từ trang 1
    });

    
}

</script>