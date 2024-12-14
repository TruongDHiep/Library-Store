<?php 
include 'controller/CustomerController.php';
include 'controller/UsersController.php';
$maKH = $_GET['sid'];
$ctrlemail = new UserController($mysqli);
$controller = new CustomerModel($mysqli);
$CustomerData = $controller->getCustomerByMaKH($maKH);

?>
<div class="editFormContainer" >

    <h2>Sửa khách hàng</h2>
    <form id="editForm" action="pages\form\Customer\update_customer.php" method="post">
        <input type="hidden" id="editmaKH" name="maKH" value="<?php echo $CustomerData['maKH']?>">
        <label for="edittenKH">Tên khách hàng</label>
        <input type="text" id="edittenKH" name="tenKH" value="<?php echo $CustomerData['tenKH']?>" required pattern=".{1,}"><br><br>

        <label for="editSDT">SDT</label>
        <input type="text" id="editSDT" name="SDT" value="<?php echo $CustomerData['SDT']?>" required pattern="[0-9]{10,}"><br><br>

        <label for="editdiaChi">Địa chỉ</label>
        <input type="text" id="editdiaChi" name="diaChi" value="<?php echo $CustomerData['diaChi']?>" required pattern=".{1,}"><br><br>

        <label for="editemail">Tài khoản :</label>
            <select id="editemail" name="email" required>
                <?php
                $currentemail = $CustomerData['maTK'];
                $users = $ctrlemail->displayUser();
                if (!empty($users)) {
                    foreach ($users as $tk) {
                        $selected = ($currentemail == $CustomerData['maTK']) ? 'selected' : '';            
                        echo "<option value='{$tk['maTK']}' $selected>{$tk['email']}</option>";
                    }
                } else {
                    echo "<option value=''>Không có tài khoản</option>";
                }
    ?>    
    </select><br><br>
        <div class="group_btnformporder">
                    <button type="button" class="btn btn-primary" id="saveButton">Lưu</button>


                    <a  class="btn btn-danger" href="admin.php?action=customer&query=customer"> Hủy </a>


                    <button type="reset" class="btn btn-light">reset</button>
                </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveButton').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('editForm'));
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/customer/update_customer.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    window.location.href = 'admin.php?action=customer&query=customer';
                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>