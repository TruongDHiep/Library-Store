<div id="formContainer">
    <form method="post" action="" id="formSuppliers" >
        <div class="add-title">
            <h3>Thêm nhân viên</h3>
        </div>
        <!-- Các trường nhập liệu cho nhân viên -->
        <input style="width: 40%;" type="hidden" name="manv" placeholder="Mã nhân viên" required>
        <input style="width: 40%;" type="text" name="tennv" placeholder="Tên nhân viên" required pattern=".{1,}">
        <input style="width: 40%;" type="text" name="diachinv" placeholder="Địa chỉ" required pattern=".{1,}">
        <input style="width: 40%;" type="number" name="sdtnv" placeholder="Số điện thoại" required pattern="[0-9]{10,}">
        <input style="width: 40%;" type="date" name="ngayvaolamnv" placeholder="Ngày vào làm" required>
        <div class="group_btnformsupplier " >
            <button class="btn btn-primary" type="submit">Thêm nhân viên</button>
            <button type="button" class="btn btn-danger"><a href="admin.php?action=emloyee&query=emloyee">Hủy</a></button>
            <button type="reset" class="btn btn-light">Reset</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formSuppliers').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn chặn gửi yêu cầu mặc định của form
        
        var formData = new FormData(this);
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/emloyee/add_emloyee.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    // Sau khi thêm nhân viên thành công, có thể thực hiện các hành động cập nhật giao diện nếu cần
                    window.location.href="admin.php?action=emloyee&query=emloyee";
                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>
