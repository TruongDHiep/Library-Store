<?php 
include 'controller/SupplierController.php';
$maNCC = $_GET['sid'];
$controller = new supplierController($mysqli);
$supplier = $controller->getsupplierBymaNCC($maNCC);

?>
<div class="editFormContainer" >

    <h2>Sửa nhà cung cấp</h2>
    <form id="editForm" action="pages\form\suppliers\update_supplier.php" method="post">
        <input type="hidden" id="editmaNCC" name="maNCC" value="<?php echo $supplier['maNCC']?>">
        <label for="edittenNCC">tên nhà cung cấp</label>
        <input type="text" id="edittenNCC" name="tenNCC" value="<?php echo $supplier['tenNCC']?>" required pattern=".{1,}"><br><br>

        <label for="editdiaChi">Địa chỉ</label>
        <input type="text" id="editdiaChi" name="diaChi" value="<?php echo $supplier['diaChi']?>" required pattern=".{1,}"><br><br>

        <label for="editSDT">Số điện thoại</label>
        <input type="number" id="editSDT" name="SDT" value="<?php echo $supplier['SDT']?>" required pattern="[0-9]{10,}"><br><br>
        
        <div class="group_btnformporder">
                    <button type="button" class="btn btn-primary" id="saveButton">Lưu</button>


                   <a class="btn btn-danger" href="admin.php?action=suppliers&query=suppliers"> Hủy </a>


                    <button type="reset" class="btn btn-light">reset</button>
                </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveButton').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('editForm'));
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/suppliers/update_supplier.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    window.location.href = 'admin.php?action=suppliers&query=suppliers';
                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>