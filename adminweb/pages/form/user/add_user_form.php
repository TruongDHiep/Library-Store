<?php if (!empty($_SESSION['current_admin'])) {
    include 'C:\xampp\htdocs\fahasa\adminweb\controller\quyenController.php'; // Import QuyenController để lấy danh sách quyền

    // Gọi hàm từ controller để lấy danh sách quyền
    $quyenController = new QuyenController($mysqli);
    $quyenList = $quyenController->getAllQuyen();
?>

    <div id="formContainer">
        <form method="post" action="" id="formUser" style="display:flex; justify-content: center; align-items:center; flex-direction: column; flex-wrap:wrap">
            <div class="add-title">
                <h3>Thêm tài khoản</h3>
            </div>
            <!-- Các trường nhập liệu cho nhà cung cấp -->
            <input style="width: 40%;" type="email" name="email" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
            <input style="width: 40%;" type="password" name="password" placeholder="Mật khẩu" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}">
            <select id="status" name="status">
                <option value="0">Không hoạt động</option>
                <option value="1">Hoạt động</option>
            </select><br><br>

            <label for="role">Quyền:</label><br>
            <select id="role" name="role">
                <?php foreach ($quyenList as $quyen) : ?>
                    <option value="<?= $quyen['maQuyen']; ?>"><?= $quyen['tenQuyen']; ?></option>
                <?php endforeach; ?>
            </select><br><br>


            <div class="group_btnformsupplier">
                <input class="btn btn-primary" type="submit" name="submit" value="Thêm">
                <button type="button" class="btn btn-danger"><a href="admin.php?action=user&query=user">Hủy</a></button>
                <button type="reset" class="btn btn-light">Reset</button>
            </div>
        </form>
    </div>

<?php
}
?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('formUser').addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn chặn gửi yêu cầu mặc định của form

            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'pages/form/user/add_user.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;
                        alert(response); // Hiển thị phản hồi từ máy chủ
                        // Sau khi thêm nhà cung cấp thành công, có thể thực hiện các hành động cập nhật giao diện nếu cần
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