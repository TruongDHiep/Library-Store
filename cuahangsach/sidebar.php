<?php
// Các danh sách sản phẩm và thể loại có thể đọc từ cơ sở dữ liệu hoặc các nguồn dữ liệu khác
require_once 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
require_once 'C:\xampp\htdocs\fahasa\adminweb\controller\loaiSachController.php';

$loaiSachController = new LoaiSachController($mysqli);
$categories = $loaiSachController->getAllLoaiSach();


$priceRanges = [
    "0đ - 150,000đ",
    "150,000đ - 300,000đ",
    "300,000đ - 500,000đ",
    "500,000đ - 700,000đ",
    "700,000đ - trở lên"
];
?>

<link rel="stylesheet" href="../cuahangsach/assets/css/sidebar.css">


<div class="left-sidebar">
    <div class="container">
        <div class="container-iner">
            <h3 style="margin-bottom: 20px;">NHÓM SẢN PHẨM</h3>
            <ol class="category-list">
                <li class="list-item"><a href="" style="font-size: 18px;" class = "a-danhmuc" data-theloai="all">TẤT CẢ NHÓM SẢN PHẨM</a></li>
                <?php foreach ($categories as $category) : ?>
                <li class="list-item"><a href="" style= "margin-left:20px;" class ="a-danhmuc" data-theloai="<?= $category['maLoai'] ?>"><?= $category['tenLoai']?></a></li>
                <?php endforeach; ?>
            </ol>

            <div class="title" id="price">GIÁ</div>
            <div class="list-check-box price-list">
                <?php foreach ($priceRanges as $priceRange) : ?>
                <input class="checkprice" style="margin-left: 20px" type="checkbox" id="<?= strtolower(substr($priceRange,0,1)) ?>"
                    name="price">
                <label for="<?= strtolower(substr($priceRange,0,1)) ?>"><?= $priceRange ?></label><br>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<script>
    $(document).ready(function() {
        $('.list-item').click(function() {
            $('.list-item').removeClass('active_sidebar');
            $(this).addClass('active_sidebar');
        });
    });
// Lấy tất cả các checkbox
const checkboxes = document.querySelectorAll('.checkprice');

// Thêm hàm xử lý sự kiện cho mỗi checkbox
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // Nếu checkbox đã được chọn trước đó
        if (this.dataset.checked === "true") {
            // Tắt nó đi
            this.checked = false;
            this.dataset.checked = "false";
        } else {
            // Nếu không, bật nó lên và tắt tất cả các checkbox khác
            checkboxes.forEach(otherCheckbox => {
                if (otherCheckbox !== this) {
                    otherCheckbox.checked = false;
                    otherCheckbox.dataset.checked = "false";
                }
            });
            this.dataset.checked = "true";
        }
    });
});
</script>

