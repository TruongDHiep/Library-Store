<?php if (!empty($_SESSION['current_admin'])) { 
include 'controller/loaiSachController.php';
$maLoai = $_GET['lid'];
$controller = new LoaiSachController($mysqli);
$cate = $controller->timtheoma($maLoai);

?>
<div class="editFormContainer" >

    <h2>Sửa loại sách</h2>
    <form id="editForm" action="pages\form\update_cate.php" method="post">
        <input type="hidden"  name="maLoai" value="<?php echo $cate['maLoai']?>">
        <label for="edittenNCC">tên thể loại</label>
        <input type="text"  name="tenLoai" value="<?php echo $cate['tenLoai']?>" required pattern=".{1,}"><br><br>

        <label for="editdiaChi">Chi tiết</label>
        <input type="text"  name="chiTiet" value="<?php echo $cate['chiTiet']?>" required><br><br>


        <label for="editTrangThai">Trạng thái</label>
        <input type="text"  name="trangThai" value="<?php echo $cate['trangThai']?>" required><br><br>

        <div class="group_btnformporder">
                    <button type="button" class="btn btn-primary" id="saveButton">Lưu</button>


                    <button type="cancel" class="btn btn-danger"><a class="" href="admin.php?action=category&query=category"> Hủy </a></button>


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
        xhr.open('POST', 'pages/form/category/update_cate.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    window.location.href = 'admin.php?action=category&query=category';

                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>