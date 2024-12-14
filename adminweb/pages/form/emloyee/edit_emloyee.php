<?php 
include 'controller/EmloyeeController.php';
$maNV = $_GET['sid'];
$controller = new EmloyeeModel($mysqli);
$hoaDon = $controller->getEmloyeeByMaNV($maNV);

?>
<div class="editFormContainer" >

    <h2>Sửa Nhân viên</h2>
    <form id="editForm" action="pages\form\emloyee\update_emloyyee.php" method="post">
        <input type="hidden" id="editmaNV" name="maNV" value="<?php echo $hoaDon['maNV']?>">
        <label for="edittenNV">Tên nhân viên</label>
        <input type="text" id="edittenNV" name="tenNV" value="<?php echo $hoaDon['tenNV']?>" required pattern=".{1,}"><br><br>

        <label for="editSDT">SDT</label>
        <input type="text" id="editSDT" name="SDT" value="<?php echo $hoaDon['SDT']?>" required pattern="[0-9]{10,}"><br><br>

        <label for="editdiaChi">Địa chỉ</label>
        <input type="text" id="editdiaChi" name="diaChi" value="<?php echo $hoaDon['diaChi']?>" required pattern=".{1,}"><br><br>

        <label for="editngayVaoLam">Ngày vào làm</label>
        <input type="text" id="editngayVaoLam" name="ngayVaoLam" value="<?php echo $hoaDon['ngayVaoLam']?>" required><br><br>

        <div class="group_btnformporder">
                    <button type="button" class="btn btn-primary" id="saveButton">Lưu</button>


                    <a class="btn btn-danger" href="admin.php?action=emloyee&query=emloyee"> Hủy </a>


                    <button type="reset" class="btn btn-light">reset</button>
                </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveButton').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('editForm'));
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/emloyee/update_emloyee.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    window.location.href = 'admin.php?action=emloyee&query=emloyee';
                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>