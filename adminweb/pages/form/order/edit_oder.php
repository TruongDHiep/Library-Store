<?php 
include 'controller/HoaDonController.php';
$maHD = $_GET['sid'];
$controller = new HoaDonController($mysqli);
$hoaDon = $controller->getHoaDonByMaHD($maHD);

?>
<div class="editFormContainer" >

    <h2>Sửa Hóa Đơn</h2>
    <form id="editForm" action="pages\form\order\update_order.php" method="post">
        <input type="hidden" id="editMaHD" name="maHD" value="<?php echo $hoaDon['maHD']?>">
        <label for="editMaKH">Mã KH</label>
        <input type="text" id="editMaKH" name="maKH" value="<?php echo $hoaDon['maKH']?>" required><br><br>

        <label for="editMaNV">Mã NV</label>
        <input type="text" id="editMaNV" name="maNV" value="<?php echo $hoaDon['maNV']?>" required><br><br>

        <label for="editTongTien">Tổng tiền</label>
        <input type="text" id="editTongTien" name="tongTien" value="<?php echo $hoaDon['tongTien']?>" required><br><br>

        <label for="editNgayTao">Ngày tạo</label>
        <input type="text" id="editNgayTao" name="ngayTao" value="<?php echo $hoaDon['ngayTao']?>" required><br><br>

        <label for="editTrangThai">Trạng thái</label>
        <input type="text" id="editTrangThai" name="trangThai" value="<?php echo $hoaDon['trangThai']?>" required><br><br>

        <div class="group_btnformporder">
                    <button type="button" class="btn btn-primary" id="saveButton">Lưu</button>


                    <a class="btn btn-danger" href="admin.php?action=order&query=order"> Hủy </a>


                    <button type="reset">reset</button>
                </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveButton').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('editForm'));
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/order/update_order.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});
</script>