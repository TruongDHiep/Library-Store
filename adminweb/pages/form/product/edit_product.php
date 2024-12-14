<?php if (!empty($_SESSION['current_admin'])) { 

include 'controller/loaiSachController.php';
include 'controller/sachController.php';
include 'controller/hinhAnhController.php';
$loaiSachController = new LoaiSachController($mysqli);
$loaiSachList = $loaiSachController->getAllLoaiSach();


// Trích xuất mã sách từ URL
if (isset($_GET['sid'])) {
    $maSach = $_GET['sid'];

    // Sử dụng mã sách để lấy thông tin của sách từ cơ sở dữ liệu
    $sachController = new SachController($mysqli);
    $sachInfo = $sachController->getSachByMaSach($maSach);


    $hinhAnhController = new HinhAnhController($mysqli);
    $hinhAnhList = $hinhAnhController->getImagesByBookId($maSach);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    .preview-image {
            width: 200px;
            height: 200px;
            margin: 10px 0;
            border: 1px solid #ccc;
        }

        .preview-imager img{
            width: 100%;
            height: 100%;
            
        }
</style>
<body>
    


<div id="formContainer">
    <div class="add-title">
        <h3>Sửa sản phẩm</h3>
    </div>

    <form method="post" action="" id="editform">
        <div class="row">
            <?php if (isset($sachInfo) && !empty($sachInfo)) : ?>
                <!-- Kiểm tra xem có thông tin sách hay không -->
                <div class="right-info">
                    <!-- Các trường nhập liệu cho sản phẩm -->
                    <input type="hidden" id="maSach" name="maSach" value="<?php echo $sachInfo['maSach']?>">
                    <input type="text" name="tensach" placeholder="Tên sách" value="<?php echo $sachInfo['tenSach']; ?>">
                    <input type="text" name="tacgia" placeholder="Tác giả" value="<?php echo $sachInfo['TacGia']; ?>">
                    <input type="text" name="nhaxuatban" placeholder="Nhà xuất bản" value="<?php echo $sachInfo['NXB']; ?>">
                    <input type="text" name="giaNhap" placeholder="Giá nhập" value="<?php echo $sachInfo['giaNhap']; ?>">
                    <input type="text" name="giaXuat" placeholder="Giá xuất" value="<?php echo $sachInfo['giaXuat']; ?>">
                    <input type="text" name="taiBan" placeholder="Tái bản" value="<?php echo $sachInfo['taiBan']; ?>">
                    <input type="text" name="soluong" placeholder="Số lượng" value="<?php echo $sachInfo['soLuong']; ?>">

                    <select name="theloai" class="select">
                        <option value="none">Chọn thể loại</option>
                        <?php foreach ($loaiSachList as $loaiSach) : ?>
                            <option value="<?php echo $loaiSach['maLoai']; ?>" <?php if ($loaiSach['maLoai'] == $sachInfo['maLoai']) echo 'selected'; ?>><?php echo $loaiSach['tenLoai']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <input type="text" name="khuyenMai" placeholder="Khuyến mãi" value="<?php echo $sachInfo['khuyenMai']; ?>">
                    <input type="text" name="trangThai" placeholder="Trạng thái" value="<?php echo $sachInfo['trangThai']; ?>">

                    <div class="input-item form-group">
                        <label for="product_description" class="" style="font-size:30px; margin: 10px;">Mô tả sản phẩm</label>
                        <textarea id="product_description" name="mota"><?php echo $sachInfo['moTa']; ?></textarea>
                        <span class="form-message"></span>
                    </div>
                </div>

                <div class="left-info">
                    <div class="product-image">
                        <input type="file" class="d-none" id="product_image" name="product_image[]" accept="image/*" multiple onchange="previewImages(event)">
                        <div id="image-preview-container">
                            <?php if (!empty($hinhAnhList)) : ?>
                                <?php foreach ($hinhAnhList as $hinhAnh) : ?>
                                    <img class="preview-image" src="img/<?php echo $hinhAnh['maHinh']; ?>" alt="">
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p>Không có hình ảnh cho sách này.</p>
                            <?php endif; ?>
                        </div>

                        <div class="group_btnformproduct">
                            <button type="submit"  class="btn btn-primary"  id="saveButton">Sửa sản phẩm</button>
                            <button type="button"><a href="admin.php?action=product&query=product">Hủy </a></button>
                            <button type="reset" onclick="window.location.href=window.location.href">reset</button>
                        </div>
                    </div>
                <?php else : ?>
                    <p>Không tìm thấy thông tin sách.</p>
                <?php endif; ?>
                </div>
    </form>
</div>

</body>
</html>

<?php  
} 
?>


<script>
    function previewImages(event) {
        var container = document.getElementById('image-preview-container');
        container.innerHTML = ''; // Clear previous previews

        var files = event.target.files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (file.type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = document.createElement('img');
                    img.src = event.target.result;
                    img.classList.add('preview-image');
                    container.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    }
</script>

<script>
    CKEDITOR.replace('product_description');
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveButton').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('editform'));

        // Lấy nội dung của trường mô tả và thêm vào FormData object
        var motaContent = CKEDITOR.instances['product_description'].getData();
        formData.append('mota', motaContent);
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/product/update_product.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    window.location.href = 'admin.php?action=product&query=product';

                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});

</script>