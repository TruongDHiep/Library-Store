<div id="formContainer">
    <form method="post" action="" id="formSuppliers" style="display:flex; justify-content: center; align-items:center; flex-direction: column; flex-wrap:wrap">
        <div class="add-title">
            <h3>Thêm nhà cung cấp</h3>
        </div>
        <!-- Các trường nhập liệu cho nhà cung cấp -->
        <input style="width: 40%;" type="hidden" name="mancc" placeholder="Mã nhà cung cấp" required>
        <input style="width: 40%;" type="text" name="tenncc" placeholder="Tên nhà cung cấp" required pattern=".{1,}">
        <input style="width: 40%;" type="text" name="diachincc" placeholder="Địa chỉ" required pattern=".{1,}">
        <input style="width: 40%;" type="number" name="sdtncc" placeholder="Số điện thoại" required pattern="[0-9]{10,}">
         <div class="group_btnformsupplier">
            <button class="btn btn-primary" type="submit">Thêm nhà cung cấp</button>
            <button type="button" class="btn btn-danger"><a href="admin.php?action=suppliers&query=suppliers">Hủy</a></button>
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
        xhr.open('POST', 'pages/form/suppliers/add_supplier.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    window.location.href = 'admin.php?action=suppliers&query=suppliers';
                    // Sau khi thêm nhà cung cấp thành công, có thể thực hiện các hành động cập nhật giao diện nếu cần
                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>
