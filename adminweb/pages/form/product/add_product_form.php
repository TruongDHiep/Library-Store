<?php if (!empty($_SESSION['current_admin'])) { 
include 'C:\xampp\htdocs\fahasa\adminweb\controller\loaiSachController.php';
// Gọi hàm từ controller để lấy danh sách loại sách
$loaiSachController = new LoaiSachController($mysqli);
$loaiSachList = $loaiSachController->getAllLoaiSach();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
</head>
<body>
    

<div id="formContainer">
    <div class="add-title">
        <h3>Thêm sản phẩm</h3>
    </div>

    <form method="post" action="" id="formproduct">
        <div class="row">
            <div class="right-info">
                <!-- Các trường nhập liệu cho sản phẩm -->
                <input type="text" name="tensach" placeholder="Tên sách">
                <input type="text" name="tacgia" placeholder="Tác giả">
                <input type="text" name="nhaxuatban" placeholder="Nhà xuất bản">
                <input type="text" name="giaNhap" placeholder="Giá nhập">
                <input type="text" name="giaXuat" placeholder="Giá xuất">
                <input type="text" name="taiBan" placeholder="Tái bản">
                <input type="text" name="soluong" placeholder="Số lượng">
                
                <select name="theloai" class="select">
                    <option value="none">Chọn thể loại</option>
                    <?php foreach ($loaiSachList as $loaiSach): ?>
                        <option value="<?php echo $loaiSach['maLoai']; ?>"><?php echo $loaiSach['tenLoai']; ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="text" name="khuyenMai" placeholder="Khuyến mãi">
                <input type="text" name="trangThai" placeholder="Trạng thái">
                
                <div class="input-item form-group">
                    <label for="product_description" class="" style="font-size:30px; margin: 10px;">Mô tả sản phẩm</label>
                    <textarea id="product_description" name="mota"></textarea>
                    <span class="form-message"></span>
                </div>
            </div>

            <div class="left-info">
                <div class="product-image">
                    <input type="file" class="d-none" id="product_image" name="product_image[]" accept="image/*" multiple onchange="previewImages(event)">
                    <label class="label-for-image" for="product_image">
                        <i class="fas fa-upload"></i> &nbsp; Tải lên nhiều hình ảnh
                    </label>
                    <div id="image-preview-container"></div>
                </div>

                <div class="group_btnformproduct">
                    <button class="btn btn-primary" type="submit" name="add_product">Thêm sản phẩm</button>
                    <button type="button" class="btn btn-danger"><a href="admin.php?action=product&query=product">Hủy </a></button>
                    <button type="reset" class="btn btn-light">reset</button>
                </div>
            </div>
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
    document.getElementById('formproduct').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn chặn gửi yêu cầu mặc định của form
        
        var formData = new FormData(this);
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/form/product/add_product.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response); // Hiển thị phản hồi từ máy chủ
                    // Sau khi thêm nhà cung cấp thành công, có thể thực hiện các hành động cập nhật giao diện nếu cần
                    window.location.href = 'admin.php?action=product&query=product';

                } else {
                    alert('Có lỗi xảy ra khi gửi yêu cầu.');
                }
            }
        };
        xhr.send(formData);
    });
});

function uploadImages(files, maSach) {
    var formData = new FormData();
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        formData.append('images[]', file);
    }
    formData.append('maSach', maSach);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload_images.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                console.log(response); // Log phản hồi từ máy chủ
            } else {
                alert('Có lỗi xảy ra khi tải ảnh lên.');
            }
        }
    };
    xhr.send(formData);
}

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

    var maSach = document.querySelector('input[name="maSach"]').value; // Sử dụng mã sách từ trường input ẩn
    uploadImages(files, maSach);
}

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('formproduct');
        var resetButton = form.querySelector('button[type="reset"]');
        resetButton.addEventListener('click', function() {
            var inputs = form.querySelectorAll('input[type="text"], textarea');
            inputs.forEach(function(input) {
                input.value = ''; // Đặt lại giá trị của input và textarea về rỗng
            });
        });
    });
</script>



