<?php
include 'controller/SupplierController.php';
include 'controller/EmloyeeController.php';

$controllerEmloyee = new EmloyeeController($mysqli);
$Emloyee = $controllerEmloyee ->displayEmloyee();

$controllersupplier = new SupplierController($mysqli);
$Supplier = $controllersupplier->displaysupplier();
?>

<div id="formContainer">
    <form method="post" action="" id="formimport" style="display:flex; align-content: space-around; align-items:flex-start; flex-direction: column; flex-wrap:wrap">
        <div class="add-title">
            <h3>Thêm phiếu nhập</h3>
        </div>
        <!-- Các trường nhập liệu cho phiếu nhập -->
        <input style="width: 40%; " type="hidden" name="mapn" placeholder="Mã phiếu nhập" required>
        <label  for="mancc">nhà cung cấp :</label>
        <select id="mancc" name="mancc" required>
        <?php
       
        if (!empty($Supplier)) {
            foreach ($Supplier as $ncc) {
                echo "<option value='{$ncc['maNCC']}'>{$ncc['tenNCC']}</option>";
            }
        } else {
            echo "<option value=''>Không có nhà cung cấp </option>";
        }
        ?>
        </select><br>
        <label  for="manv">nhân viên :</label>
        <select  id="manv" name="manv" required>
        <?php
       
        if (!empty($Emloyee)) {
            foreach ($Emloyee as $emloyee) {
                echo "<option value='{$emloyee['maNV']}'>{$emloyee['tenNV']}</option>";
            }
        } else {
            echo "<option value=''>Không có nhân viên </option>";
        }
        ?>
        </select><br>
        <input style="width: 40%; margin-top: 20px;" type="number" name="tongtien" placeholder="tổng tiền " required min="1">>
        <input style="width: 40%; margin-top: 20px;" type="date" name="ngaytao" placeholder="Ngày tạo" required>
        <div class="group_btnformsupplier">
            <button class="btn btn-primary" type="submit">Thêm phiếu nhập</button>
            <button type="button" class="btn btn-danger"><a href="admin.php?action=import&query=import">Hủy</a></button>
            <button type="reset" class="btn btn-light">Reset</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formimport').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn chặn gửi yêu cầu mặc định của form
        
        var formData = new FormData(this);
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/import/add_import.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    window.location.href = 'admin.php?action=import&query=import';
                    // Sau khi thêm phiếu nhập thành công, có thể thực hiện các hành động cập nhật giao diện nếu cần
                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>
