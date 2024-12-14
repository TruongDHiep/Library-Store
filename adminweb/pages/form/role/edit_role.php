<?php if (!empty($_SESSION['current_admin'])) { 

    include 'controller/quyenController.php'; // Đảm bảo tên file và đường dẫn là chính xác
    //include 'controller/ctq_cnController.php';
    include 'controller/chucnangController.php';

    $maQuyen = $_GET['sid']; // Lấy mã quyền từ URL

    // Lấy thông tin quyền cần chỉnh sửa
    $quyenController = new QuyenController($mysqli);
    $quyen = $quyenController->getQuyenBMaQuyen($maQuyen);

    // Kiểm tra xem quyền có tồn tại hay không
    if (!$quyen) {
        echo "Không tìm thấy quyền!";
        exit;
    }
    ?>

    <div class="editFormContainer">
        <h2>Chỉnh sửa quyền</h2>
        <form id="editForm" action="pages/form/update_role.php" method="post">
            <input type="hidden" name="maQuyen" value="<?php echo $quyen['maQuyen']; ?>">
            <input type="text" id="editTenQuyen" name="tenQuyen" placeholder="Tên quyền" value="<?php echo $quyen['tenQuyen']; ?>" placeholder="Tên quyền" required pattern=".{1,}"><br><br>
            <select name="trangThai" id="trangThai">
                <option value="1" <?php if ($quyen['trangThai'] == 1) echo "selected"; ?>>Hiện</option>
                <option value="0" <?php if ($quyen['trangThai'] == 0) echo "selected"; ?>>Ẩn</option>
            </select>


            <div class="group_btnformporder">
                <button type="submit" class="btn btn-primary" id="saveButton">Cập nhật</button>
                <button type="cancel" class="btn btn-danger"><a class="cancel_order" href="admin.php?action=roles&query=roles"> Hủy </a></button>
            </div>
            <?php

            $ctq_cnController = new CTQ_CN_Controller($mysqli);
            $ctq_cnData =  $ctq_cnController->getCTQ_CNByMaQuyen($maQuyen);

            // Lấy tất cả chức năng từ bảng chức năng
            $chucnangController = new ChucNangController($mysqli);
            $cnData = $chucnangController->getAllChucNang();

            if (!empty($cnData)) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>Chức năng</th>
                                <th>Thêm</th>
                                <th>Sửa</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>";
                foreach ($cnData as $cn) {
                    echo "<tr>";
                    echo "<td>" . $cn["TenCN"] . "</td>";
                    $checkedThem = '';
                    $checkedSua = '';
                    $checkedXoa = '';
                    // Kiểm tra xem mã chức năng có tồn tại trong bảng kết nối ctq_cn không
                    foreach ($ctq_cnData as $ctq_cn) {
                        if ($ctq_cn['maCN'] == $cn['MaCN']) {
                            if ($ctq_cn['maQuyen'] == $quyen['maQuyen']) {
                                if ($ctq_cn['hoatDong'] == 't') {
                                    $checkedThem = 'checked';
                                }
                                if ($ctq_cn['hoatDong'] == 's') {
                                    $checkedSua = 'checked';
                                }
                                if ($ctq_cn['hoatDong'] == 'x') {
                                    $checkedXoa = 'checked';
                                }
                            }
                        }
                    }
                    echo "<td> <input type='checkbox' name='chucnang[" . $cn["MaCN"] . "][them]' value='1' $checkedThem> </td>";
                    echo "<td> <input type='checkbox' name='chucnang[" . $cn["MaCN"] . "][sua]' value='1' $checkedSua> </td>";
                    echo "<td> <input type='checkbox' name='chucnang[" . $cn["MaCN"] . "][xoa]' value='1' $checkedXoa> </td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "Không có dữ liệu quyền";
            }
            ?>


        </form>
    </div>

    <?php  
} 
?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn chặn việc gửi yêu cầu mặc định của form

            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'pages/form/role/update_role.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;
                        // Hiển thị thông báo thành công hoặc lỗi tùy thuộc vào phản hồi từ máy chủ
                        alert(response);
                        window.location.href = 'admin.php?action=roles&query=roles';
                    } else {
                        alert('Có lỗi xảy ra khi gửi yêu cầu.');
                    }
                }
            };
            xhr.send(formData);
        });
    });

    </script>