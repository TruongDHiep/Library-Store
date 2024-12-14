<?php if (!empty($_SESSION['current_admin'])) { 
include 'controller/UsersController.php';
$maTK = $_GET['sid'];
$controller = new UserController($mysqli);
$taikhoan = $controller->getUserBymaTK($maTK);

?>
<div class="editFormContainer" >

    <h2>Sửa Tài Khoản</h2>
    <form id="editForm" action="pages\form\user\update_user.php" method="post">
        <input type="hidden" id="editmaTK" name="maTK" value="<?php echo $taikhoan['maTK']?>">
        
</select><br><br>
        <label for="edittaikhoan">tài khoản</label>
        <input type="text" id="edittaikhoan" name="taiKhoan" value="<?php echo $taikhoan['email']?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"><br><br>

        <label for="editmatKhau">Mật khẩu</label>
        <input type="text" id="editmatkhau" name="matKhau" value="<?php echo $taikhoan['matKhau']?>" requiredrequired pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"><br><br>


        <label for="editTrangThai">Trạng thái</label>
        <input type="text" id="editTrangThai" name="trangThai" value="<?php echo $taikhoan['trangThai']?>" required><br><br>

        <label for="editmaQuyen">Mã quyền :</label>
         <select id="editmaQuyen" name="maQuyen" required>
        <?php
        $roles = $controller->getrole();
        if (!empty($roles)) {
            foreach ($roles as $role) {
                echo "<option value='{$role['maQuyen']}'>{$role['tenQuyen']}</option>";
            }
        } else {
            echo "<option value=''>Không có quyền</option>";
        }
    ?>
</select><br><br>
        <div class="group_btnformporder">
                    <button type="button" class="btn btn-primary" id="saveButton">Lưu</button>


                    <button type="cancel" class="btn btn-danger"><a  href="admin.php?action=user&query=user"> Hủy </a></button>


                    <button type="reset" class="btn btn-light">reset</button>
                </div>
    </form>
</div>

<?php  
} 
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveButton').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('editForm'));
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/user/update_user.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    window.location.href = 'admin.php?action=user&query=user';
                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>