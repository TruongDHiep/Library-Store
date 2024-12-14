<?php if (!empty($_SESSION['current_admin'])) { ?> 

<div id="formContainer">
    <form method="post" action="" id="formCategory" style="display:flex; justify-content: center; align-items:center; flex-direction: column; flex-wrap:wrap">
        <div class="add-title">
            <h3>Thêm loại sách</h3>
        </div>
        <!-- Các trường nhập liệu cho the -->
        <input style="width: 40%;" type="hidden" name="maLoai" placeholder="" required>
        <input style="width: 40%;" type="text" name="tenLoai" placeholder="Tên loại sách" required pattern=".{1,}">
        <input style="width: 40%;" type="text" name="chiTiet" placeholder="Chi tiết" required>
        <div class="group_btnformsupplier">
            <button class="btn btn-primary" type="submit">Thêm thể loại</button>
            <button type="button" class="btn btn-danger"><a href="admin.php?action=category&query=category">Hủy</a></button>
            <button type="reset" class="btn btn-light">Reset</button>
        </div>
    </form>
  <?php  
} 
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formCategory').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn chặn gửi yêu cầu mặc định của form
        
        var formData = new FormData(this);
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/category/add_category.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    // Sau khi thêm the thành công, có thể thực hiện các hành động cập nhật giao diện nếu cần
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
