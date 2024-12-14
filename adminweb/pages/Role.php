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
    if ($ctq['maCN'] == 7) {
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
    <div class="add_suppliers">
    <?php if ($buttons['them']) : ?>
        <a class="btn btn-primary"  href="admin.php?action=roles&query=roles_add"><i class="fa fa-plus"></i>Thêm quyền</a>
        <?php endif; ?>
    </div>
</div>
<?php
// Include file config
include 'controller/quyenController.php';

// Khởi tạo đối tượng SupplierController
$quyencontroller = new QuyenController($mysqli);
$quyenData = $quyencontroller->getAllQuyen();

if (!empty($quyenData)) {
    // Hiển thị dữ liệu nhà cung cấp
    echo "<table class='sortable'>
            <thead>
                <tr>
                    <th>Mã quyền</th>
                    <th>Tên quyền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($quyenData as $quyen) {
        echo "<tr>"; // Bắt đầu một hàng mới
        echo "<td>" . $quyen["maQuyen"] . "</td>";
        echo "<td>" . $quyen["tenQuyen"] . "</td>";
        echo "<td>" . $quyen["trangThai"] . "</td>";
        echo '<td class="hanhdong">';
        if ($buttons['xoa']) {
              echo'  <button id="delete" class="deleteButton" data-id="' . $quyen["maQuyen"] . '"><i class="fa-solid fa-trash"></i></button>';
        }
        if ($buttons['sua']) {
              echo'  <button class="editButton" ><a class="order_a" href="admin.php?action=roles&query=edit_role&sid=' . $quyen["maQuyen"] . '"><i class="fa-solid fa-pen-to-square"></i></a></button>';
          }  echo' </td>';
        echo "</tr>"; // Kết thúc hàng
    }
    echo "</tbody></table>";
} else {
    // Hiển thị thông báo nếu không có dữ liệu nhà cung cấp
    echo "Không có dữ liệu quyền";
}
?>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
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
});

document.addEventListener("DOMContentLoaded", function() {
    var deleteButtons = document.querySelectorAll(".deleteButton");

    deleteButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            // Hiển thị hộp thoại xác nhận
            var confirmation = confirm('Bạn có muốn xoá nhà cung cấp !');
            // Nếu người dùng đồng ý
            if (confirmation) {
                var maNCC = this.getAttribute("data-id");
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "pages/form/delete_supplier.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Hiển thị thông báo từ phản hồi
                            alert(xhr.responseText);
                            // Sau khi xóa thành công, cập nhật lại giao diện nếu cần
                            window.location.href = 'admin.php?action=roles&query=roles';
                            // Ví dụ: xoá hàng khỏi bảng
                            var row = button.closest("tr");
                            row.parentNode.removeChild(row);
                        } else {
                            alert("Có lỗi xảy ra khi gửi yêu cầu.");
                        }
                    }
                };
                // Gửi yêu cầu với dữ liệu maNCC
                xhr.send("maNCC=" + maNCC);
            }
        });
    });
});
</script>
