<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<script src="https://kit.fontawesome.com/1d4366ccab.js" crossorigin="anonymous"></script>

<link rel="stylesheet" href="../cuahangsach/assets/css/home.css">



<?php
require_once '../adminweb/config/config.php';
require_once '../adminweb/controller/sachController.php';
require_once '../adminweb/controller/hinhAnhController.php';
// require_once '../adminweb/controller/loaiSachController.php';
$sachControllerr = new SachController($mysqli);
$loaiSachController = new LoaiSachController($mysqli);
$hinhanhcontroller = new HinhAnhController($mysqli);
$dataSach = $sachControllerr->getAllSach();
$dataloaisach = $loaiSachController->getAllLoaiSach();


?>


<div id="wrapper">

    <div class="banner">
        <div class="top-banner">
            <div class="prev-btn-banner">
                <i class="fa-solid fa-angle-left"></i>
            </div>
            <div class="next-btn-banner">
                <i class="fa-solid fa-angle-right"></i>
            </div>

            <div class="top-banner-image active">
                <img src="./assets/img/banner/banner4.jpg">
            </div>
            <div class="top-banner-image next">
                <img src="./assets/img/banner/banner5.jpg">
            </div>
            <div class="top-banner-image">
                <img src="./assets/img/banner/banner6.jpg">
            </div>
            <div class="top-banner-image">
                <img src="./assets/img/banner/banner7.jpg">
            </div>
            <div class="top-banner-image prev">
                <img src="./assets/img/banner/banner3.jpg">
            </div>

            <div class="pagination-banner">
                <span class="pagination-bullet 1 active"></span>
                <span class="pagination-bullet 2"></span>
                <span class="pagination-bullet 3"></span>
                <span class="pagination-bullet 4"></span>
                <span class="pagination-bullet 5"></span>
            </div>
        </div>

        <div class="bottom-banner">
            <div class="bottom1"><a href="">
                    <img src="./assets/img/banner/banner1.jpg">
                </a></div>
            <div class="bottom2"><a href="">
                    <img src="./assets/img/banner/banner2.jpg">
                </a></div>
        </div>
    </div>


        <div class="tabs">
            <div class="tab-title">
                <h2>Danh mục sản phẩm</h2>
            </div>
            <div class="tabs-line">
                <div></div>
            </div>
            <div class="cate-content">
                <?php
                if (!empty($dataloaisach)) {
                    foreach ($dataloaisach as $loaisach) {
                        echo '<div class="cate-item"> ';
                        $sql1 = "SELECT hinhAnh.*
                        FROM hinhAnh
                        JOIN sach ON hinhAnh.maSach = sach.maSach
                        JOIN loaisach ON sach.maLoai = loaisach.maLoai
                        WHERE loaisach.maLoai = " . $loaisach['maLoai'] . " LIMIT 1";
                    $hinhResult = $mysqli->query($sql1);
                    if ($hinhResult && $hinhResult->num_rows > 0) {
                        $hinhRow = $hinhResult->fetch_assoc();
                        if (!empty($hinhRow['maHinh'])) {
                            echo '<a href="index.php?page=prolist&theloai=' . $loaisach['maLoai'] . '" style="text-decoration: null;">';
                            echo '<div class="cate-item-image"> ';
                            echo '<img src="../adminweb/img/' . $hinhRow['maHinh'] . '" alt="">';
                            echo '</div>';

                            echo '<div class="cate-item-title"> ';
                            echo '<a href="index.php?page=prolist&theloai=' . $loaisach['maLoai'] . '">' . $loaisach['tenLoai'] . '</a>';
                            echo '</div>';
                            echo '</a>';
                        }
                        echo '</div>';
                    }
                }
            }

            ?>

        </div>
    </div>



    <div class="tabs">
        <div class="tab-title" style="border: solid black 1px; color: white; background-color: black; font-size: 12px; font-weight: 550;">
            <h2>Bảng xếp hạng sách bán chạy</h2>
        </div>
        <div class="tabs-content-rising">
            <div class="list-rising">
                <?php
                $sql1 = "SELECT *, COUNT(*) AS soLuongBan
            FROM Sach s
            JOIN ChiTietHoaDon cthd ON s.maSach = cthd.maSach
            JOIN HoaDon hd ON cthd.maHD = hd.maHD
            Join HinhAnh ha ON s.maSach = ha.maSach
            GROUP BY s.tenSach
            ORDER BY soLuongBan DESC
            LIMIT 5;";
                $number = 1;
                $Result = $mysqli->query($sql1);
                if ($Result && $Result->num_rows > 0) {
                    foreach ($Result as $Row) {
                        if (!empty($Row['maSach'])) {
                            // Convert $Row to JSON format

                            $rowData = json_encode($Row);
                            echo '<div class="item-rising" data-info=\'' . $rowData . '\'>';
                                echo '<div class="number-rising">';
                                    echo '<div>' . $number . ' </div>';
                                        echo '<i class="fa-solid fa-arrow-up"></i>';
                                    echo '</div>';
                                    echo '<a href="product.php?id=' . $Row['maSach'] . '">';
                                        echo '<div class="item-image">';
                                            echo '<img src="../adminweb/img/' . $Row['maHinh'] . '" alt="">';
                                        echo '</div>';
                                        echo '<div class="item-title">';
                                            echo '<a href="product.php?id=' . $Row['maSach'] . '">' . $Row['tenSach'] . '</a>';
                                        echo '</div>';
                                    echo '</a>';
                            echo '</div>';
                        }
                        $number++;
                    }
                }
                ?>
            </div>
            <div class="detail-rising">
                <div class="detail-content" id="item-detail">
                    <div class="detail-item-image">
                        <img id="item-image" src="" alt="">
                    </div>
                    <div class="item-info">
                        <div class="item-name"></div>
                        <div class="item-author"></div>
                        <div class="item-NXB"></div>
                        <div class="detail-new-price">
                            <div class="item-price"></div>
                            <div class="item-promo"></div>
                        </div>
                        <div class="item-old-price" style="color:grey;"></div>
                        <div class="item-des"></div>

                    </div>

                </div>
            </div>
        </div>
        <a href="index.php?page=prolist&theloai=all" class="btn-more">Xem thêm</a>

    </div>

    <div class="tabs">
        <div class="tab-title">
            <h2>Nhà xuất bản nổi bật</h2>
        </div>
        <ul class="nav-tabs">
            <li class="active-tab"><a href="#tab1" onclick="switchTab('#tab1')">Kim Đồng </a></li>
            <li><a href="#tab2" onclick="switchTab('#tab2')">Thanh Niên</a></li>
            <li><a href="#tab3" onclick="switchTab('#tab3')">Lao Động</a></li>
        </ul>
        <div class="tabs-content">
            <div class="prev-btn" onclick="moveTabs(-1)"><i class="fa-solid fa-angle-left"></i></div>

            <div id="tab1" class="tab-content-item">

                <?php
                $count = 0;
                if (!empty($dataSach)) {
                    foreach ($dataSach as $sach) {
                        if ($sach['NXB'] === 'Kim Đồng' && $count < 10) {
                            if ($count > 4)
                                echo '<div class="item" style="display: none;">';
                            else
                                echo '<div class="item">';
                            $hinhAnh = $hinhanhcontroller->getImagesByBookId($sach['maSach']);
                            // Kiểm tra xem có hình ảnh nào cho sách này không
                            echo '<a href="product.php?id=' . $Row['maSach'] . '" style="text-decoration: none;color: black;">';
                            if (!empty($hinhAnh)) {
                                // Hiển thị hình ảnh đầu tiên
                                echo "<div><img class='book-image' src='../adminweb/img/" . $hinhAnh[0]["maHinh"] . "'/></div>";
                            } else {
                                // Nếu không có hình ảnh, hiển thị một hình ảnh mặc định hoặc thông báo không có hình ảnh
                                echo "Không có hình ảnh";
                            }
                            echo '<div class="book-info">';
                            echo '<div class="book-name">' . $sach["tenSach"] . '</div>';
                            if ($sach['khuyenMai'] > 0) {
                                $newprice = $sach['giaXuat'] * $sach['khuyenMai'] / 100;
                                echo '<div class="new-book-price">';
                                echo '<div class="new-book-price">' . number_format($newprice, 0, ',', '.') . ' đ</div>';
                                echo '<div class="book-promo">-' . $sach['khuyenMai'] . '%</div>';
                                echo '</div>';
                                echo '<div class="old-book-price">' . number_format($sach["giaXuat"], 0, ',', '.') . ' đ</div>';
                            } else {
                                echo '<div class="book-price">' . number_format($sach["giaXuat"], 0, ',', '.') . ' đ</div>';
                            }
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            $count++;
                        }
                    }
                } else {
                    echo "Không có sách nào trong cơ sở dữ liệu.";
                }

                ?>

            </div>


            <div id="tab2" class="tab-content-item">

                <?php
                $count = 0;
                if (!empty($dataSach)) {
                    foreach ($dataSach as $sach) {
                        if ($sach['NXB'] === 'Thanh Niên' && $count < 10) {
                            if ($count > 4)
                                echo '<div class="item" style="display: none;">';
                            else
                                echo '<div class="item">';
                            $hinhAnh = $hinhanhcontroller->getImagesByBookId($sach['maSach']);
                            // Kiểm tra xem có hình ảnh nào cho sách này không
                            echo '<a href="product.php?id=' . $Row['maSach'] . '" style="text-decoration: none; color: black;">';

                            if (!empty($hinhAnh)) {
                                // Hiển thị hình ảnh đầu tiên
                                echo "<div><img class='book-image' src='../adminweb/img/" . $hinhAnh[0]["maHinh"] . "'/></div>";
                            } else {
                                // Nếu không có hình ảnh, hiển thị một hình ảnh mặc định hoặc thông báo không có hình ảnh
                                echo "Không có hình ảnh";
                            }
                            echo '<div class="book-info">';
                            echo '<div class="book-name">' . $sach["tenSach"] . '</div>';
                            if ($sach['khuyenMai'] > 0) {
                                $newprice = $sach['giaXuat'] * $sach['khuyenMai'] / 100;
                                echo '<div class="new-book-price">';
                                echo '<div class="new-book-price">' . number_format($newprice, 0, ',', '.') . ' đ</div>';
                                echo '<div class="book-promo">-' . $sach['khuyenMai'] . '%</div>';
                                echo '</div>';
                                echo '<div class="old-book-price">' . number_format($sach["giaXuat"], 0, ',', '.') . ' đ</div>';
                            } else {
                                echo '<div class="book-price">' . number_format($sach["giaXuat"], 0, ',', '.') . ' đ</div>';
                            }

                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            $count++;
                        }
                    }
                } else {
                    echo "Không có sách nào trong cơ sở dữ liệu.";
                }

                ?>

            </div>


            <div id="tab3" class="tab-content-item">

                <?php
                $count = 0;
                if (!empty($dataSach)) {
                    foreach ($dataSach as $sach) {
                        if ($sach['NXB'] === 'Lao Động' && $count < 10) {
                            if ($count > 4)
                                echo '<div class="item" style="display: none;">';
                            else
                                echo '<div class="item">';
                            $hinhAnh = $hinhanhcontroller->getImagesByBookId($sach['maSach']);
                            // Kiểm tra xem có hình ảnh nào cho sách này không
                            echo '<a href="product.php?id=' . $Row['maSach'] . '" style="text-decoration: none; color: black;">';

                            if (!empty($hinhAnh)) {
                                // Hiển thị hình ảnh đầu tiên
                                echo "<div><img class='book-image' src='../adminweb/img/" . $hinhAnh[0]["maHinh"] . "'/></div>";
                            } else {
                                // Nếu không có hình ảnh, hiển thị một hình ảnh mặc định hoặc thông báo không có hình ảnh
                                echo "Không có hình ảnh";
                            }
                            echo '<div class="book-info">';
                            echo '<div class="book-name">' . $sach["tenSach"] . '</div>';
                            if ($sach['khuyenMai'] > 0) {
                                $newprice = $sach['giaXuat'] * $sach['khuyenMai'] / 100;
                                echo '<div class="new-book-price">';
                                echo '<div class="new-book-price">' . number_format($newprice, 0, ',', '.') . ' đ</div>';
                                echo '<div class="book-promo">-' . $sach['khuyenMai'] . '%</div>';
                                echo '</div>';
                                echo '<div class="old-book-price">' . number_format($sach["giaXuat"], 0, ',', '.') . ' đ</div>';
                            } else {
                                echo '<div class="book-price">' . number_format($sach["giaXuat"], 0, ',', '.') . ' đ</div>';
                            }

                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            $count++;
                        }
                    }
                } else {
                    echo "Không có sách nào trong cơ sở dữ liệu.";
                }

                ?>

            </div>

            <div class="next-btn" onclick="moveTabs(1)"><i class="fa-solid fa-angle-right"></i></div>

        </div>

        <a href="index.php?page=prolist&theloai=all" class="btn-more">Xem thêm</a>
    </div>
</div>

<script src="https://kit.fontawesome.com/1d4366ccab.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

</script>
<script>
    $(document).ready(function() {
        $('.tab-content-item').hide();
        $('.tab-content-item:first').fadeIn();
        $('.nav-tabs li a').click(function() {
            $('.tab-content-item').hide();
            $('.nav-tabs li').removeClass('active-tab');
            $(this).parent().addClass('active-tab');

            let id_tab_content = $(this).attr('href');
            $('tab-content-item').hide();
            $(id_tab_content).fadeIn();
            return false;
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const itemList = document.querySelectorAll(".item-rising");
        const itemDetail = document.getElementById("item-detail");
        const itemImage = document.getElementById("item-image");
        const itemName = document.querySelector(".item-name");
        const itemAuthor = document.querySelector(".item-author");
        const itemNXB = document.querySelector(".item-NXB");
        const itemPrice = document.querySelector(".item-price");
        const itemDes = document.querySelector(".item-des");
        const itemPromo = document.querySelector(".item-promo");
        const itemOldPrice = document.querySelector(".item-old-price");

        // Hàm kích hoạt item
        function activateItem(item) {
            const rowData = JSON.parse(item.getAttribute("data-info"));
            // const itemInfo = item.getAttribute("data-info");
            // Tách chỉ mô tả từ dữ liệu JSON
            // const description = extractDescription(itemInfo);
            // itemDes.innerHTML = description;

            const itemNameData = rowData.tenSach;
            const itemAuthorData = rowData.TacGia;
            const itemNXBData = rowData.NXB;
            const itemImageData = "../adminweb/img/" + rowData.maHinh;
            const itemDesData = rowData.moTa.replace(/<[^>]+>/g, '');
            const itemPromoData = rowData.khuyenMai;
            const itemPriceData = rowData.giaXuat * (100 - itemPromoData) / 100;
            const itemOldPriceData = rowData.giaXuat;

            itemName.textContent = itemNameData;
            itemAuthor.textContent = "Tác giả: " + itemAuthorData;
            itemNXB.textContent = "Nhà xuất bản: " + itemNXBData;
            itemImage.src = itemImageData;
            itemPrice.textContent = "Giá: " + itemPriceData.toLocaleString() + "đ";
            itemDes.innerHTML = itemDesData;
            if (itemPromoData > 0) {
                itemPromo.textContent = "-" + itemPromoData + "%";
                itemPromo.style.display = "inline-block";
            } else {
                itemPromo.style.display = "none";
            }
            itemOldPrice.textContent = itemOldPriceData.toLocaleString() + "đ";
        }

        // Kích hoạt sự kiện cho item đầu tiên khi trang được tải
        const firstItem = itemList[0];
        activateItem(firstItem);

        // Gắn sự kiện mouseover cho từng item trong danh sách
        itemList.forEach(function(item) {
            item.addEventListener("mouseover", function() {
                activateItem(item);
            });
        });
    });

    function extractDescription(itemInfo) {
        try {
            const parsedData = JSON.parse(itemInfo);
            return parsedData.moTa; // Trả về chỉ mô tả
        } catch (error) {
            console.error("Error parsing JSON data:", error);
            return ""; // Trả về một chuỗi trống nếu có lỗi
        }
    }

    // Hàm để cập nhật currentTab khi chuyển tab
    function switchTab(tabId) {
        currentTab = tabId;
        moveTabs(-1);
        updateButtons(-1, 10);
    }




    var currentTab = "#tab1";
    var visibleItems = 5;
    var tabStates = {};

    function moveTabs(direction) {
        var $currentTab = $(currentTab);
        var $items = $currentTab.find('.item');
        var totalItems = $items.length;

        tabStates[currentTab] = $items.filter(':visible').first().index();

        // Tính toán vị trí mới của tab
        var currentIndex = $items.filter(':visible').first().index();
        var newIndex = currentIndex + direction * visibleItems;

        // Xử lý trường hợp khi newIndex nhỏ hơn 0
        if (newIndex < 0) {
            newIndex = 0;
        }

        // Xử lý trường hợp khi newIndex vượt quá tổng số lượng items
        if (newIndex >= totalItems) {
            newIndex = totalItems - visibleItems;
        }

        // Hiển thị 5 item kế tiếp hoặc trước đó
        $items.hide().slice(newIndex, newIndex + visibleItems).show();



        // Cập nhật trạng thái nút "Prev" và "Next"
        updateButtons(newIndex, totalItems);


    }


    // Hàm cập nhật trạng thái của nút "Prev" và "Next"
    function updateButtons(index, totalItems) {
        var $prevBtn = $('.prev-btn');
        var $nextBtn = $('.next-btn');

        if (index <= 0) {
            $prevBtn.hide();
            $nextBtn.show();
        } else if (index >= totalItems - visibleItems) {
            $prevBtn.show();
            $nextBtn.hide();
        } else {
            $prevBtn.show();
            $nextBtn.show();
        }
    }

    // Ẩn nút "Prev" khi ban đầu
    $(document).ready(function() {
        $('.prev-btn').hide();
    });





    $(document).ready(function() {
        var currentBannerIndex = 0;
        var totalBanners = $('.top-banner-image').length;
        var bannerInterval;
        startBannerInterval();

        function updateBulletStatus() {
            $('.pagination-bullet').css('background-color', 'gray');
            $('.pagination-bullet').eq(currentBannerIndex).css('background-color', '#C92127');
        }

        function moveToBanner(index) {
            $('.top-banner-image').removeClass('active').removeClass('prev').removeClass('next');
            $('.top-banner-image').eq(index).addClass('active');

            currentBannerIndex = index;
            updateBulletStatus();
        }

        function updateBulletActive(index) {
            $('.pagination-bullet').removeClass('active');
            $('.pagination-bullet').eq(index).addClass('active');
        }

        function moveNext() {
            currentBannerIndex = (currentBannerIndex === totalBanners - 1) ? 0 : currentBannerIndex + 1;
            moveToBanner(currentBannerIndex);
        }

        $('.prev-btn-banner').click(function() {
            currentBannerIndex = (currentBannerIndex === 0) ? totalBanners - 1 : currentBannerIndex - 1;
            moveToBanner(currentBannerIndex);
        });

        $('.next-btn-banner').click(function() {
            moveNext();
        });

        $('.pagination-bullet').click(function() {
            var index = $(this).index();
            moveToBanner(index);
        });

        function startBannerInterval() {
            bannerInterval = setInterval(function() {
                moveNext();
            }, 5000);
        }

        function stopBannerInterval() {
            clearInterval(bannerInterval);
        }


        // Dừng chuyển đổi tự động khi rê chuột vào banner
        $('.top-banner').hover(function() {
            stopBannerInterval();
        }, function() {
            startBannerInterval();
        });
    });
</script>