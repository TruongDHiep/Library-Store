<?php
require_once("header.php");
include 'connection_db.php';


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

function money($number, $suffix = 'đ')
{
    if (!empty($number)) {
        return number_format($number, 0, ',', ',') . "{$suffix}";
    }
}

if (isset($_SESSION['payment_success']) && $_SESSION['payment_success'] === true) {
    echo '<script>deletePaidItems();</script>';
    $_SESSION['payment_success'] = false;
}

?>

<link rel="stylesheet" href="../cuahangsach/assets/css/shopcart.css">

<div class="main-container">
    <div class="main">
        <div class="container">
            <div class="container-inner">
                <div id="content">
                    <div class="cart">




                        <?php
                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) :
                        ?>
                            <div class="page-title">
                                <div class="page-title-container">
                                    <h1 style="display: inline-block;width: auto;">Giỏ hàng</h1>
                                    <span class="cart-title-num">(<?php echo count($_SESSION['cart']); ?> sản phẩm)</span>
                                </div>
                            </div>

                            <div class="cart-ui-content">
                                <div class="col-sm-8">
                                    <div>
                                        <div class="header-cart-item">
                                            <div class="checkbox-all-product">
                                                <input type="checkbox" class="checkbox-add-cart" id="checkbox-all-products" onchange="selectAllProducts(this)">
                                            </div>
                                            <div>
                                                <span>Chọn tất cả (<span class="num-items-checkbox"><?php echo count($_SESSION['cart']); ?></span>) sản phẩm</span>
                                            </div>
                                            <div>Số lượng</div>
                                            <div>Thành tiền</div>
                                            <div></div>
                                        </div>
                                        <div class="product-cart-left">
                                            <?php
                                            foreach ($_SESSION['cart'] as $item) :
                                            ?>
                                                <div class="item-product-cart product-id-<?php echo $item['maSach']; ?>" id="item-product-cart-<?php echo $item['maSach']; ?>">
                                                    <div class="checked-product-cart">
                                                        <input type="checkbox" id="checkbox-product-<?php echo $item['maSach']; ?>" name="checkbox-product-<?php echo $item['maSach']; ?>" class="checkbox-add-cart">
                                                    </div>
                                                    <div class="img-product-cart">
                                                        <a href="product.php?id=<?php echo $item['maSach']; ?>" class="product-image">
                                                            <img src="../adminweb/img/<?php echo $item['hinhanh']; ?>" width="120px" height="120px" alt="<?php echo $item['tenSach']; ?>">
                                                        </a>
                                                    </div>
                                                    <div class="group-product-info">
                                                        <div class="info-product-cart">
                                                            <div>
                                                                <h2 class="product-name-full-text">
                                                                    <a href="product.php?id=<?php echo $item['maSach']; ?>"><?php echo $item['tenSach']; ?></a>
                                                                </h2>
                                                            </div>
                                                            <div class="price-original">
                                                                <div class="cart-price">
                                                                    <div class="cart-fhsItem-price">
                                                                        <div><span class="price"><?php echo money($item['giaXuat'] - ($item['giaXuat'] * $item['khuyenMai'] / 100)); ?></span></div>
                                                                        <div class="fhsItem-price-old">
                                                                            <span class="price"><?php echo money($item['giaXuat']); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="number-product-cart">
                                                            <div class="product-view-quantity-box">
                                                                <div class="product-view-quantity-box-block">
                                                                    <a class="btn-subtract-qty" onclick="subtractQty(<?php echo $item['maSach']; ?>);">
                                                                        <i class="fa-solid fa-minus"></i>
                                                                    </a>
                                                                    <input type="text" class="qty-carts" id="qty-<?php echo $item['maSach']; ?>" maxvalue="999" minvalue="1" value="<?php echo $item['quantity']; ?>" onkeypress="return validateNumber(event)" onblur="validateQuantity(<?php echo $item['maSach']; ?>)" title="SL" name="cart[<?php echo $item['maSach']; ?>][qty]">
                                                                    <a class="btn-add-qty" onclick="addQty(<?php echo $item['maSach']; ?>)">
                                                                        <i class="fa-solid fa-plus"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="cart-price-total">
                                                                <span class="cart-price">
                                                                    <span class="price"><?php echo money(($item['giaXuat'] - ($item['giaXuat'] * $item['khuyenMai'] / 100)) * $item['quantity']); ?></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="div-of-btn-remove-cart">
                                                        <a onclick="deleteItem('<?php echo $item['maSach']; ?>')" title="Remove Item" class="btn-remove-desktop-cart">
                                                            <i class="fa-regular fa-trash-can" style="font-size: 22px;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="border-product"></div>
                                            <?php
                                            endforeach;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="total-cart-right">
                                        <div class="block-total-cart">


                                            <div id="account-content" class="box-content active-info">
                                                <div class="account-content-title">
                                                    <h3>Thông tin tài khoản</h3>
                                                </div>
                                                <form id="infor_form" action="" method="post">
                                                    <div class="account-input-1">
                                                        <label for="">Họ và tên</label>
                                                        <div class=input-box>
                                                            <input name="tenKH" type="text" disabled placeholder="Nhập họ và tên" value="<?php echo $_SESSION['current_user']['tenKH'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="account-input-1">
                                                        <label for="">Email</label>
                                                        <div class=input-box>
                                                            <input type="text" disabled value="<?php echo $_SESSION['current_user']['email'] ?>">
                                                        </div>

                                                    </div>
                                                    <div class="account-input-1">
                                                        <label for="">Số điện thoại</label>
                                                        <div class=input-box>
                                                            <input name="SDT" type="text" disabled placeholder="Nhập số điện thoại" value="<?php echo $_SESSION['current_user']['SDT'] ?>">
                                                        </div>

                                                    </div>
                                                    <div class="account-input-1">
                                                        <label for="">Địa chỉ</label>
                                                        <div class=input-box>

                                                            <input name="diaChi" type="text" disabled placeholder="Nhập địa chỉ" value="<?php echo $_SESSION['current_user']['diaChi'] ?>">
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>



                                            <!-- <div class="block-total-cart-page">
                                                <div class="title-cart-page-left">Thành tiền</div>
                                                <div class="number-cart-page-right">
                                                    <span class="price">0đ</span>
                                                </div>
                                            </div> -->
                                            <div class="border-product"></div>
                                            <div class="block-total-cart-page title-final-total">
                                                <div class="title-cart-page-left">Tổng Số Tiền (gồm VAT)</div>
                                                <div class="number-cart-page-right">
                                                    <span class="price">0đ</span>
                                                </div>
                                            </div>
                                            <div class="checkout-type-button-cart">
                                                <div class="method-button-cart">
                                                    <form method="POST">
                                                        <!-- Thêm các trường ẩn để lưu thông tin -->
                                                        <?php
                                                        foreach ($_SESSION['cart'] as $item) :
                                                        ?>
                                                            <input type="hidden" id="maSach" name="maSach[]" value="<?php echo $item['maSach'] ?>">
                                                            <input type="hidden" id="soLuong" name="soLuong[]" value="<?php echo $item['quantity'] ?>">
                                                            <input type="hidden" id="giaSach" name="giaSach[]" value="<?php echo ($item['giaXuat'] - ($item['giaXuat'] * $item['khuyenMai'] / 100)); ?>">
                                                        <?php
                                                        endforeach; ?>
                                                        <input type="hidden" id="maKH" name="maKH" value="<?php echo isset($_SESSION['current_user']) ? $_SESSION['current_user'] : ''; ?>">

                                                        <!-- Thêm nút "Thanh Toán" -->
                                                        <button type="button" onclick="thanhToanClicked()" class="button btn-proceed-checkout btn-checkout">
                                                            <span>Thanh Toán</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        else :
                        ?>
                            <div class="emty-cart">
                                <div>
                                    <p>Giỏ hàng trống!</p>
                                    <div class="button-to-home">
                                        <a href="./index.php?page=home">
                                            <button>Đi mua hàng</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-WfTKvy4T/ECtAfe5gIj/aPmkjDve0wLAzrM6cA8kLgP8erpcXyUDQMIzrzjJvvxU" crossorigin="anonymous"></script>
<script>
    function validateNumber(event) {
        let keyCode = event.keyCode;
        return (keyCode >= 48 && keyCode <= 57) || (keyCode >= 96 && keyCode <= 105) || keyCode === 8 || keyCode === 9;
    }

    function validateQuantity(productId) {
        let inputQty = document.getElementById(`qty-${productId}`);
        let quantity = parseInt(inputQty.value);
        if (isNaN(quantity) || quantity < 1 || quantity > 999) {
            inputQty.value = 1;
        }
    }

    function addQty(productId) {
        let inputQty = document.getElementById(`qty-${productId}`);
        let currentValue = parseInt(inputQty.value);
        if (!isNaN(currentValue)) {
            let newValue = currentValue + 1;
            if (newValue <= 999) {
                inputQty.value = newValue;
                updateTotalPrice(productId, newValue);
                updateCartSummary();
            }
        }
    }

    function subtractQty(productId) {
        let inputQty = document.getElementById(`qty-${productId}`);
        let currentValue = parseInt(inputQty.value);
        if (!isNaN(currentValue)) {
            let newValue = currentValue - 1;
            if (newValue >= 1) {
                inputQty.value = newValue;
                updateTotalPrice(productId, newValue);
                updateCartSummary();
            }
        }
    }

    function updateTotalPrice(productId, newQuantity) {
        let item = document.getElementById(`item-product-cart-${productId}`);
        let priceElement = item.querySelector('.cart-price-total .price');
        let orPriceElement = item.querySelector('.cart-fhsItem-price .price');
        let itemPrice = parseFloat(orPriceElement.textContent.replace(/[^0-9.-]+/g, ""));
        priceElement.textContent = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(itemPrice * newQuantity);
        item.setAttribute('data-quantity', newQuantity);
    }


    function selectAllProducts(checkbox) {
        const productCheckboxes = document.querySelectorAll('.checkbox-add-cart');
        productCheckboxes.forEach(itemCheckbox => {
            itemCheckbox.checked = checkbox.checked;
        });
        updateCartSummary()
    }

    const itemCheckboxes = document.querySelectorAll('.checkbox-add-cart');
    itemCheckboxes.forEach(itemCheckbox => {
        itemCheckbox.addEventListener('change', function() {
            updateCartSummary();
        });
    });

    function deleteItem(productId) {
        event.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../cuahangsach/delete-cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const itemElement = document.getElementById(`item-product-cart-${productId}`);
                if (itemElement) {
                    itemElement.remove();
                    updateCartSummary();
                } else {
                    alert('Error: Could not remove item from cart.');
                }
            }
        };
        xhr.send('productId=' + productId);
    }

    function money(number, suffix = 'đ') {
        if (!isNaN(number)) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0
            }).format(number) + suffix;
        }
        return number + suffix;
    }

    function updateCartSummary() {
        let totalItems = document.querySelectorAll('.item-product-cart').length;
        document.querySelector('.cart-title-num').textContent = `(${totalItems} sản phẩm)`;

        let totalPrice = 0;
        let totalUIElement = document.querySelector('.number-cart-page-right .price');

        if (totalItems > 0) {
            document.querySelectorAll('.item-product-cart').forEach(item => {
                let isChecked = item.querySelector('.checkbox-add-cart').checked;
                if (isChecked) {
                    let price = parseFloat(item.querySelector('.cart-price-total .price').textContent.replace(/[^0-9]+/g, ""));
                    console.log(item.querySelector('.cart-price-total .price').textContent.replace(/[^0-9]+/g, ""))
                    totalPrice += price;
                }
            });
        }

        document.querySelectorAll('.number-cart-page-right .price').forEach(total => {
            total.textContent = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0,
            }).format(totalPrice);
        });

        if (totalItems === 0) {
            document.querySelector('.cart').innerHTML = `
        <div class="emty-cart">
            <div>
                <p>Giỏ hàng trống!</p>
                <div class="button-to-home">
                    <a href="./index.php?page=home">
                        <button>Đi mua hàng</button>
                    </a>
                </div>
            </div>
        </div>
        `;
            totalUIElement.textContent = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(0);
        }
    }

    function markProductsAsPaid(productIds) {
        productIds.forEach(productId => {
            sessionStorage.setItem(`paid_${productId}`, true);
        });
    }

    function deletePaidItems() {
        const checkedProductIds = [];
        const checkedProducts = document.querySelectorAll('.item-product-cart .checkbox-add-cart:checked');
        checkedProducts.forEach(checkbox => {
            const productId = checkbox.id.split('-').pop();
            checkedProductIds.push(productId);
        });
        markProductsAsPaid(checkedProductIds);

        checkedProductIds.forEach(productId => {
            const isPaid = sessionStorage.getItem(`paid_${productId}`);
            if (isPaid) {
                deleteItem(productId);
            }
        });
        updateCartSummary();
    }

    function thanhToanClicked() {
        let maSachInputs = document.getElementsByName('maSach[]');
        let soLuongInputs = document.getElementsByName('soLuong[]');
        let giaSachInputs = document.getElementsByName('giaSach[]');
        let maKH = document.getElementsByName('maKH')[0].value; // Lấy mã khách hàng

        const checkedProducts = document.querySelectorAll('.item-product-cart .checkbox-add-cart:checked');

        let tenKH = document.getElementsByName('tenKH')[0].value;
        let SDT = document.getElementsByName('SDT')[0].value;
        let diaChi = document.getElementsByName('diaChi')[0].value;
        console.log(tenKH, SDT, diaChi);



        if ( tenKH == '' ||  SDT == '' || diaChi == '') {
            alert("Vui lòng điền đầy đủ thông tin trước khi thanh toán.");
            window.location.href = './index.php?page=khachhang';
            return;
        }


        if (checkedProducts.length === 0) {
            alert("Vui lòng chọn ít nhất một sản phẩm trước khi thanh toán.");
            return;
        }

        const loggedIn = <?php echo isset($_SESSION['current_user']) ? 'true' : 'false'; ?>;
        if (!loggedIn) {
            alert("Vui lòng đăng nhập trước khi thanh toán.");
            return;
        }

        // Tạo một mảng để lưu các sản phẩm đã chọn
        let selectedItems = [];
        for (let i = 0; i < maSachInputs.length; i++) {
            let maSach = maSachInputs[i].value;
            let soLuong = soLuongInputs[i].value;
            let giaSach = giaSachInputs[i].value;
            selectedItems.push({
                maSach: maSach,
                soLuong: soLuong,
                giaSach: giaSach
            });
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../cuahangsach/process_payment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    deletePaidItems()
                    alert(response.message);
                    window.location.href = './index.php?page=home';
                } else {
                    alert(response.message);
                }
            } else {
                alert('Có lỗi xảy ra khi gửi yêu cầu.');
            }
        };

        // Chuyển đổi mảng selectedItems thành chuỗi JSON để gửi đi
        let params = JSON.stringify(selectedItems);
        xhr.send('data=' + encodeURIComponent(params));
    }
</script>