<?php
require_once 'C:\xampp\htdocs\fahasa\adminweb\config\config.php';
require_once 'C:\xampp\htdocs\fahasa\adminweb\controller\loaiSachController.php';

$loaiSachController = new LoaiSachController($mysqli);
$theloaiheader = $loaiSachController->getAllLoaiSach();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION['user_logged_in'])) {
    if ($_SESSION['user_logged_in'] === true && $_SESSION['user_role'] === 'admin') {
        header("Location: admin.php");
        exit;
    }
}

// Xử lý yêu cầu POST trực tiếp
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['maLoai'])) {
        $maLoai = $_POST['maLoai'];

        // Truy vấn CSDL với giá trị maLoai
        $sql = "SELECT * FROM sach s 
                JOIN HinhAnh ha ON s.maSach = ha.maSach
                WHERE maLoai = $maLoai
                LIMIT 6";

        $result = $mysqli->query($sql);

        // Xử lý kết quả và hiển thị
        if ($result && $result->num_rows > 0) {
            echo '<div class="search-grid">';
            foreach ($result as $row) {
                echo '<div class="search-grid-item">';
                echo '<a href="product.php?id=' . $row['maSach'] . '" style="text-decoration: none; color: black;">';
                echo '<div class="search-grid-image">';
                echo '<img src="../adminweb/img/' . $row['maHinh'] . '" alt="">';
                echo '</div>';
                echo '<div class="search-grid-info">';
                echo '<span class="search-grid-info-title">' . $row['tenSach'] . '</span>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>Không có kết quả.</p>';
        }
        exit; // Kết thúc xử lý sau khi gửi kết quả
    }
}
?>


<title>FAHASA</title>
<link rel="icon" href="../cuahangsach/icon/fahasa-logo.png" type="image/png">
<!-- Phần HTML -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="../cuahangsach/assets/css/header.css">

<nav>
    <div class="top-bar-desktop">
        <div class="top-bar mouse-hover">
            <div class="top-bar-left">
                <a href="./index.php?page=home">
                    <div class="top-bar-logo" alt="logo"></div>
                </a>
            </div>

            <div class="top-bar-category mouse-hover">
                <span class="top-bar-category-menu"></span>
                <span class="top-bar-category-seemore"></span>
                <div class="top-bar-category-container">
                    <div class="top-bar-category-container-left">
                        <h1>Danh mục sản phẩm</h1>
                        <?php foreach ($theloaiheader as $category) : ?>
                            <!-- Sử dụng thẻ <a> với href không có giá trị -->
                            <a href="./index.php?page=prolist&theloai=<?= $category['maLoai'] ?>" class="category-link" data-maloai="<?= $category['maLoai'] ?>"><?= $category['tenLoai'] ?></a>
                        <?php endforeach; ?>
                    </div>

                    <div class="top-bar-category-container-right">
                        <!-- Container để hiển thị kết quả -->
                        <div class="search-grid"></div>
                    </div>
                </div>
            </div>

            <div class="top-bar-search-container">
                <div class="top-bar-search">
                    <input type="text" placeholder="Tìm kiếm sản phẩm mong muốn...">
                    <span id="button_timkiem" class="top-bar-button"><span class="top-bar-search-icon"></span></span>
                </div>
            </div>

            <div class="center_center mouse-hover top-notif ">
                <!-- <a href="./index.php?page=gioithieu" class="top-button-icon">
                    <div class="center_center" style="margin-bottom:3px;">
                        <div class="icon_nofi_gray">
                            <i class="fa-solid fa-book"></i>
                        </div>
                    </div>
                    <div class="center_center">
                        <div class="top_menu_label">Giới thiệu</div>
                    </div>
                </a> -->
            </div>
            <div class="center_center mouse-hover">
                <a href="./index.php?page=giohang" class="top-button-icon">
                    <div class="center_center" style="margin-bottom:3px;">
                        <div class="icon_cart_gray"></div>
                    </div>
                    <div class="center_center">
                        <div class="top_menu_label">Giỏ hàng</div>
                    </div>
                </a>
            </div>
            <div class="center_center mouse-hover top-account">
                <?php if (!empty($_SESSION['current_user'])) { ?>
                    <a href="./index.php?page=khachhang" class="top-button-icon">
                        <div class="center_center" style="margin-bottom:3px;">
                            <div class="icon_account_gray"></div>
                        </div>
                        <div class="center_center">
                            <div class="top_menu_label">Tài khoản</div>
                        </div>
                    </a>
                <?php } else { ?>
                    <a href="./index.php?page=login" class="top-button-icon">
                        <div class="center_center" style="margin-bottom:3px;">
                            <div class="icon_account_gray"></div>
                        </div>
                        <div class="center_center">
                            <div class="top_menu_label">Đăng nhập</div>
                        <?php } ?>
                        <?php
                        if (!empty($_SESSION['current_user'])) {
                            $currentUser = $_SESSION['current_user'];
                        ?>
                            <div class="top-dropdown" style="padding: 5px 10px 15px 10px;margin-top: 10px; width: 16%">
                                <li>Xin chào <?= $currentUser['email'] ?></li>
                                <a href="./index.php?page=khachhang">
                                    <button style="cursor: pointer;margin-top: 5px;" type="button" class="button-default active">
                                        <span>Tài khoản</span>
                                    </button></a>
                                <a href="./logout.php">
                                    <button style="cursor: pointer;margin-top: 5px;" type="button" class="button-default">
                                        <span>Đăng xuất</span>
                                    </button>
                                </a>
                            <?php } ?>
                            </div>
                        </div>
            </div>
        </div>
    </div>
    <div class="top-bar-mobile">
        <div class="top-banner-mobile">
            <a>
                <img src="https://cdn0.fahasa.com/skin/frontend/ma_vanese/fahasa/images/fahasa-logo.png" alt="FAHASA.COM">
            </a>
        </div>

        <div class="top-bar-child-mobile">
            <div class="top-bar-category-mobile mouse-hover">
                <span class="ico_menu_white"></span>
            </div>

            <div class="top-bar-search-mobile">
                <input type="text" placeholder="Tìm kiếm sản phẩm mong muốn...">
            </div>

            <div class="top-bar-mobile-icon center_center">
                <span class="icon_cart_white"></span>
            </div>

            <div class="top-bar-mobile-icon center_center">
                <span class="login-cutomer-icon"></span>
            </div>
        </div>
    </div>
</nav>

<script>
    document.querySelectorAll('.category-link').forEach(function(link) {
        link.addEventListener('mouseenter', function(event) {
            event.preventDefault();
            var maLoai = this.getAttribute('data-maloai');

            // Truy vấn CSDL với giá trị maLoai
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo $_SERVER["PHP_SELF"]; ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var searchGrid = document.querySelector('.search-grid');
                    searchGrid.innerHTML = xhr.responseText; // Hiển thị kết quả
                }
            };
            xhr.send('maLoai=' + maLoai);
        });
    });
</script>
<script>
    document.querySelector('#button_timkiem').addEventListener('click', function() {
        var searchValue = document.querySelector('.top-bar-search input').value;
        if (searchValue.trim() !== '') {
            window.location.href = './index.php?page=prolist&theloai=all&timkiem=' + encodeURIComponent(
                searchValue);
        }
    });
</script>