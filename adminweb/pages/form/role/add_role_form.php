<?php if (!empty($_SESSION['current_admin'])) { ?> 

<div class="add-title">
    <h3>Thêm quyền</h3>
</div>

<input type="text" name="tenQuyen" placeholder="Tên quyền" style="margin: 30px; width: 200px;" required pattern=".{1,}">
<button class="btn btn-primary" type="button" id="saveButton">Thêm quyền</button>

<?php
include 'controller/chucnangController.php';
$chucnangcontroller = new ChucNangController($mysqli);
$cnData = $chucnangcontroller->getAllChucNang();

if (!empty($cnData)) {
    echo "<table>
            <thead>
                <tr>
                    <th>Chức năng</th>
                    <th>Thêm</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($cnData as $cn) {
        echo "<tr>"; 
        echo "<td>" . $cn["TenCN"] . "</td>";
        echo "<td> <input type='checkbox' name='chucnang[]' value='" . $cn["MaCN"] . "' data-action='them'> </td>";
        echo "<td> <input type='checkbox' name='chucnang[]' value='" . $cn["MaCN"] . "' data-action='sua'> </td>";        
        echo "<td> <input type='checkbox' name='chucnang[]' value='" . $cn["MaCN"] . "' data-action='xoa'> </td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "Không có dữ liệu quyền";
}
?>

<?php  
} 
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thêm sự kiện click cho nút "Thêm quyền"
    document.getElementById('saveButton').addEventListener('click', function() {
        var tenQuyen = document.querySelector('input[name="tenQuyen"]').value;
        var checkboxes = document.querySelectorAll('input[name="chucnang[]"]:checked');

        // Kiểm tra xem đã chọn ít nhất một chức năng chưa
        if (checkboxes.length === 0) {
            alert('Vui lòng chọn ít nhất một chức năng để gán quyền.');
            return;
        }

        // Tạo một đối tượng FormData để gửi dữ liệu form qua AJAX
        var formData = new FormData();
        formData.append('tenQuyen', tenQuyen);

        // Thêm giá trị của các checkbox đã chọn vào FormData
        checkboxes.forEach(function(checkbox) {
            formData.append('chucnang[' + checkbox.value + '][' + checkbox.dataset.action + ']', 1);
        });

        // Gửi yêu cầu AJAX để xử lý form
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/role/add_role.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Hiển thị thông báo thành công
                    alert(xhr.responseText);
                    window.location.href = 'admin.php?action=roles&query=roles';

                } else {
                    // Hiển thị thông báo lỗi
                    alert('Đã xảy ra lỗi khi thêm quyền.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>
