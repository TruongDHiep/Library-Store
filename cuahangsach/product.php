<?php
session_start();
require_once("header.php");
ob_start();
include('./Helper.php');

if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', ',') . "{$suffix}";
        }
    }
}

$conn = new Helper();
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = "SELECT * FROM sach JOIN hinhanh on sach.maSach = hinhanh.maSach WHERE sach.maSach = ?";
$para = $product_id;
$product = $conn->fetchOne($stmt, $product_id);
$product_temp = $product;
$temp = $product;


// if (!$product) {
//     header('Location: index.php?page=index');
// }
// This is a simulated database query; replace this with your actual data retrieval logic
ob_end_flush();
?>

<link rel="stylesheet" href="../cuahangsach/assets/font/fontawesome/css/all.css">

<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../cuahangsach/assets/css/product.css">


<div class="product">
    <div class="main-container">
        <div class="container">
            <div class="container-inner">
                <div id="product-view-buy" class="product-view">

                    <div class="product-view-image" style="width: 500px;">
                        <!-- <img src="../cuahangsach/assets/img/<?php echo $temp['maHinh'] ?>" alt="" title=""> -->
                        <img src="../adminweb/img/<?php echo $temp['maHinh'] ?>" alt="" title="">

                    </div>
                    <div class="product-view-detail">
                        <h1><?php echo $temp['tenSach'] ?></h1>
                        <div class="product-view-sa">
                            <div class="product-view-sa_one">
                                <div class="product-view-sa-supplier">
                                    <span>Nhà cung cấp:</span>
                                    <?php echo $temp['NXB'] ?>
                                </div>
                                <div class="product-view-sa-author">
                                    <span>Tác giả:</span>
                                    <span><?php echo $temp['TacGia'] ?></span>
                                </div>
                            </div>
                            <div class="product-view-sa_two ">
                                <div class="product-view-sa-supplier">
                                    <span>Nhà xuất bản:</span>
                                    <?php echo $temp['NXB'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="product-view-price">
                            <div class="price-box">
                                <p class="special-price">
                                    <span class="price" id=""><?php echo money($temp['giaXuat'] - ($temp['giaXuat'] * $temp['khuyenMai'] / 100)) ?></span>
                                </p>
                                <p class="old-price">
                                    <span class="price" id=""><?php echo money($temp['giaXuat']) ?></span>
                                    <span class="discount-percent">-<?php echo $temp['khuyenMai'] ?>%</span>
                                </p>
                            </div>
                        </div>
                        <div class="product-detail-discount">
                            <div class="product-quantity-box">
                                <label for="qty">Số lượng:</label>
                                <div class="product-quantity-box-block">
                                    <a class="btn-subtract-qty" onclick="subtractQty();">
                                        <i class="fa-solid fa-minus"></i>
                                    </a>
                                    <input type="text" name="qty" id="qty" maxvalue="999" minvalue="1" value="1" onkeypress="return validateNumber(event)" onblur="validateQty();" title="SL" class="input-text qty">
                                    <a class="btn-add-qty" onclick="addQty()">
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="product-view-add-box">
                            <button type="button" title="Thêm vào giỏ hàng" class="btn-cart-to-cart" onmousedown="shrinkButton(this)" onmouseup="expandButton(this)" onclick="addToCart(<?php echo $temp['maSach'] ?>)">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span>Thêm vào giỏ hàng</span>
                            </button>
                            <button type="button" title="Mua ngay" class="btn-buy-now" onmousedown="shrinkButton(this)" onmouseup="expandButton(this)" onclick="buyNow(<?php echo $temp['maSach']; ?>)">
                                <span>Mua ngay </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="product_view_info" class="content product_view_content">
                    <div class="product_view_content-title">Thông tin sản phẩm</div>
                    <div class="product_view_tab_content_ad">
                        <div class="product_view_tab_content_additional">
                            <table class="data-table table-additional">
                                <colgroup>
                                    <col width="25%">
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th class="table-label">
                                            Mã hàng </th>
                                        <td class="data_sku">
                                            <?php echo $temp['maSach'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th class="table-label">
                                            Tên Nhà Cung Cấp </th>
                                        <td class="data_supplier">
                                            <?php echo $temp['NXB'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-label">
                                            Tác giả </th>
                                        <td class="data_author">
                                            <?php echo $temp['TacGia'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th class="table-label">
                                            NXB </th>
                                        <td class="data_publisher">
                                            <?php echo $temp['NXB'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th class="table-label">
                                            Năm XB </th>
                                        <td class="data_publish_year">
                                            <?php echo $temp['taiBan'] ?> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="clear"></div>
                        <div id="product_tabs_description_contents">
                            <div id="desc_content" class="std">
                                <p style="text-align: justify;"><strong><?php echo $temp['tenSach'] ?></strong></p>
                                <?php echo $temp['moTa'] ?>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once("footer.php");
?>

<script>

    function validateNumber(event) {
        let keyCode = event.keyCode;

        if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 96 && keyCode <= 105)) {
            return true;
        } else {
            return false;
        }
    }

    function validateQty() {
        let inputQty = document.getElementById('qty');
        let quantity = parseInt(inputQty.value);

        if (isNaN(quantity) || quantity < 1 || quantity > 999) {
            inputQty.value = 1;
        }
    }

    function addQty() {
        let inputQty = document.getElementById('qty');
        let currentValue = parseInt(inputQty.value);

        if (!isNaN(currentValue)) {
            let newValue = currentValue + 1;
            if (newValue <= 999) {
                inputQty.value = newValue;
            }
        }
    }

    function subtractQty() {
        let inputQty = document.getElementById('qty');
        let currentValue = parseInt(inputQty.value);

        if (!isNaN(currentValue)) {
            let newValue = currentValue - 1;
            if (newValue >= 1) {
                inputQty.value = newValue;
            }
        }
    }

    function shrinkButton(button) {
        button.style.transform = 'scale(0.98)';
    }

    function expandButton(button) {
        button.style.transform = 'scale(1)';
    }

    function addToCart(productId, redirectToCart = false) {
        let quantity = parseInt(document.getElementById('qty').value);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../cuahangsach/update_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    if (redirectToCart) {
                        window.location.href = './index.php?page=giohang';
                    } else {
                        alert("Thêm giỏ hàng thành công");
                    }
                } else {
                    alert(response.message);
                }
            }
        };
        xhr.send('productId=' + productId + '&quantity=' + quantity);
    }

    function buyNow(productId) {
        addToCart(productId, true);
    }
</script>