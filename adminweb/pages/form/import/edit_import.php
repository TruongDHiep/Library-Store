<?php 
include 'controller/ImportController.php';
include 'controller/SupplierController.php';
include 'controller/EmloyeeController.php';

$maPN = $_GET['sid'];
$controller = new ImportController($mysqli);
$Import = $controller->getimportBymaPN($maPN);

$controllerEmloyee = new EmloyeeController($mysqli);

$controllersupplier = new SupplierController($mysqli);

?>
<div class="editFormContainer" >

    <h2>Sửa nhà cung cấp</h2>
    <form id="editForm" action="pages\form\Imports\update_Import.php" method="post">
        <input type="hidden" id="editmaPN" name="maPN" value="<?php echo $Import['maPN']?>">
        <label  for="maNCC">nhà cung cấp :</label>
        <select id="maNCC" name="maNCC" required>
        <?php
        $currentSupplier = $Import['maNCC']; // Lấy giá trị hiện tại của nhà cung cấp từ biến $Import
        $allSuppliers = $controllersupplier->displaysupplier(); // Lấy tất cả nhà cung cấp từ phương thức getAllSupplier
    
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $supplier) {
                $selected = ($currentSupplier == $supplier['maNCC']) ? 'selected' : ''; // Kiểm tra nếu giá trị hiện tại trùng khớp với giá trị trong danh sách
                echo "<option value='{$supplier['maNCC']}' $selected>{$supplier['tenNCC']}</option>";
            }
        } else {
            echo "<option value=''>Không có nhà cung cấp </option>";
        }
        ?>
        </select><br><br>
        <label for="maNV">Nhân viên:</label>
                <select id="maNV" name="maNV" required>
                    <?php
                    $currentEmployee = $Import['maNV']; // Lấy giá trị hiện tại của nhân viên từ biến $Import
                    $allEmployees = $controllerEmloyee->displayEmloyee(); // Lấy tất cả nhân viên từ phương thức getAllEmployee

                    if (!empty($allEmployees)) {
                        foreach ($allEmployees as $employee) {
                            $selected = ($currentEmployee == $employee['maNV']) ? 'selected' : ''; // Kiểm tra nếu giá trị hiện tại trùng khớp với giá trị trong danh sách
                            echo "<option value='{$employee['maNV']}' $selected>{$employee['tenNV']}</option>";
                        }
                    } else {
                        echo "<option value=''>Không có nhân viên</option>";
                    }
                    ?>
        </select><br><br>

        <label for="edittongTien">Tổng tiền: </label>
        <input type="number" id="edittongTien" name="tongTien" value="<?php echo $Import['tongTien']?>" required><br><br>

        <label for="editngayTao">Ngày tạo</label>
        <input type="date" id="editngayTao" name="ngayTao" value="<?php echo $Import['ngayTao']?>" required><br><br>

        <div class="group_btnformporder">
                    <button  type="button" class="btn btn-primary" id="saveButton">Lưu</button>


                   <a class="btn btn-danger" href="admin.php?action=import&query=import"> Hủy </a>


                    <button type="reset" class="btn btn-light">reset</button>
                </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveButton').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('editForm'));
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/import/update_import.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    window.location.href = 'admin.php?action=import&query=import';
                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>