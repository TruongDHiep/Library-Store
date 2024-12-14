<?php

// Kiểm tra xem session 'selectedItems' đã được đặt và có dữ liệu hay không
if (isset($_SESSION['selectedItems']) && !empty($_SESSION['selectedItems'])) {
    // Lấy dữ liệu 'selectedItems' từ session
    $selectedItems = $_SESSION['selectedItems'];

    // Đây là một ví dụ về cách duyệt và sử dụng dữ liệu trong $selectedItems
    foreach ($selectedItems as $item) {
        $maSach = $item['maSach'];
        $soLuong = $item['soLuong'];
        $giaSach = $item['giaSach'];

        // Xử lý logic với từng sản phẩm ở đây
        echo "Mã Sách: $maSach, Số Lượng: $soLuong, Giá Sách: $giaSach <br>";
    }

    // Sau khi sử dụng xong, có thể xóa session 'selectedItems' nếu cần
    // unset($_SESSION['selectedItems']);
} else {
    // Trường hợp không có dữ liệu trong session 'selectedItems'
    echo "Không có dữ liệu sản phẩm trong session.";
}
?>

<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        background-color: #ccc;
    }

    #information-account {
        width: 100%;
        background-color: #ccc;
        margin-bottom: 10px;
    }

    .account-container {
        display: flex;
        gap: 10px;
        width: 1230px;
        /* height: 1000px; */
        /* background-color: white; */
        justify-content: space-between;
        margin: 0 auto;
    }

    .block-content {
        position: relative;
        background: white;
        width: 29%;
        margin-top: 10px;

    }

    .block-title {
        padding: 15px;
        text-align: center;
        font-size: 20px;
        font-weight: 900;
        color: #C92127;
    }

    .block-content ul {
        list-style-type: none;
        padding: 0 20px;
        margin: 0;
    }

    .block-content ul li {
        padding: 10px 10px;
        border-bottom: 1px solid #ccc;
    }

    .block-content ul li a {
        text-decoration: none;
        color: black;
        font-size: 16px;
        display: block;

    }

    .block-content ul li a:hover {
        color: #C92127;
    }

    .btn_xacnhan {
        display: block;
        padding: 10px 20px;
        font-size: 16px;
        background-color: #C92127;
        border: none;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        margin: 20px auto;
    }


    #account-content,
    #reset-password,
    #order-content {
        padding: 15px;
        background: white;
        width: 71%;
        /* height: 500px; */
        margin-top: 10px;
        display: none;
        text-align: center;
        margin: 15 auto;
        border-radius: 8px;
    }

    .account-content-title {
        padding: 15px;
        /* text-align: center; */
        font-size: 20px;
        /* font-weight: 900; */
        /* color: #C92127; */
    }

    .account-input-1 {
        padding: 10px;
        margin: 0 auto;
        width: 60%;
        /* display: flex; */
        /* justify-content: space-between; */
        /* align-items: center; */
        text-align: left;

    }

    .account-input-1 label {
        display: block;
        font-size: 16px;
        margin-bottom: 10px;
        /* font-weight: 900; */
    }

    .input-box {
        width: 100%;
    }

    .account-input-1 input {
        width: 100%;
        height: 35px;
        margin-bottom: 5px;
        padding: 8px 20px;
        border: 1px solid #ccc;
    }

    .active-info {
        background-color: #c2c2c2;
        display: block;
    }

    .active-info a {
        color: #C92127;
    }

    label.error {
        display: block;
        color: red;
        font-size: 1.1em;
        margin-left: 20px;
        margin-bottom: 0;
    }
</style>

<body>
    <div id="information-account">
        <div class="account-container">

            <div id="account-content" class="box-content active-info">
                <div class="account-content-title">
                    <h3>Thông tin Người nhận</h3>
                </div>
                <form id="infor_form" action="" method="post">
                    <div class="account-input-1">
                        <label for="">Họ và tên</label>
                        <div class=input-box>
                            <input name="tenKH" type="text" placeholder="Nhập họ và tên" value="<?php echo $_SESSION['current_user']['tenKH'] ?>">
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
                            <input name="SDT" type="text" placeholder="Nhập số điện thoại" value="<?php echo $_SESSION['current_user']['SDT'] ?>">
                        </div>

                    </div>
                    <div class="account-input-1">
                        <label for="">Địa chỉ</label>
                        <div class=input-box>

                            <input name="diaChi" type="text" placeholder="Nhập địa chỉ" value="<?php echo $_SESSION['current_user']['diaChi'] ?>">
                        </div>

                    </div>
                    <button class="btn_xacnhan" type="submit" class="btn btn-primary" onclick="xacnhanClicked()">Xác nhận</button>
                </form>
            </div>

        </div>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js">
</script>
<script>
    function xacnhanClicked() {
        let maSach = "<?php $item['maSach']?>";
        let soLuong = "<?php $item['soLuong'] ?>";
        let giaSach = "<?php $item['giaSach'] ?>";
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../cuahangsach/process_payment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert(response.message);
                    window.location.href = './index.php?page=khachhang';
                } else {
                    alert(response.message);
                }
            } else {
                alert('Có lỗi xảy ra khi gửi yêu cầu.');
            }
        };
        const params = 'maSach=' + encodeURIComponent(maSach) + '&soLuong=' + encodeURIComponent(soLuong) + '&giaSach=' + encodeURIComponent(giaSach);
        xhr.send(params);
    }


    $(document).ready(function() {
        $('.box-content:first').show();
        $('.list_link li a').click(function() {
            if ($(this).parent().hasClass('active-info')) {
                return false;
            }
            $('.box-content').hide();
            $('.list_link li').removeClass('active-info');
            $(this).parent().addClass('active-info');
            let id_tab_content = $(this).attr('href');
            $('.box-content').hide();
            $(id_tab_content).fadeIn(0.1);
            return false;
        });
    });

    $("#repass_form").validate({
        rules: {
            oldpass: {
                required: true,
                remote: "./check_pass.php"
            },
            newpass: {
                required: true,
                minlength: 6
            },
            repass: {
                required: true,
                equalTo: "#input_newpass"
            }
        },
        messages: {
            oldpass: {
                required: "Bạn chưa nhập mật khẩu hiện tại",
                remote: "Mật khẩu hiện tại không đúng"
            },
            newpass: {
                required: "Bạn chưa nhập mật khẩu mới",
                minlength: "Mật khẩu tối thiểu là 6 ký tự"
            },
            repass: {
                required: "Bạn chưa nhập lại mật khẩu",
                minlength: "Mật khẩu tối thiểu là 6 ký tự",
                equalTo: "Mật khẩu không trùng khớp"
            }
        },
        submitHandler: function(form) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: './repass.php',
                data: $(form).serializeArray(),
                success: function(response) {
                    try {
                        var string = JSON.parse(response);
                        if (string.status === 1) {
                            alert(string.message);
                            $('#repass_form').trigger("reset");
                        } else {
                            $("#error-login-massage").html(string.message).show();
                        }
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        console.log("Invalid JSON response:", response);
                    }
                }
            });
        }
    });

    $("#infor_form").validate({
        rules: {
            tenKH: {
                required: true,
            },
            SDT: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            diaChi: {
                required: true,
            }
        },
        messages: {
            tenKH: {
                required: "Bạn chưa nhập tên",
            },
            SDT: {
                required: "Bạn chưa nhập số điện thoại",
                number: "Số điện thoại không hợp lệ",
                minlength: "Số điện thoại phải là 10 số",
                maxlength: "Số điện thoại phải là 10 số"
            },
            diaChi: {
                required: "Bạn chưa nhập địa chỉ",
            }
        },
        submitHandler: function(form) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: './update_infor.php',
                data: $(form).serializeArray(),
                success: function(response) {
                    try {
                        var string = JSON.parse(response);
                        if (string.status === 1) {
                            alert(string.message);
                            location.reload();
                        } else {
                            $("#error-login-massage").html(string.message).show();
                        }
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        console.log("Invalid JSON response:", response);
                    }
                }
            });
        }
    });

    function loadDonhang() {
        $.ajax({
            url: 'loadDonhang.php',
            type: 'GET',
            data: {
                page: page,
            },
            success: function(response) {
                $data = JSON.parse(response);
                $total_pages = $data.total_pages;
                $result_products = $data.products;
                if ($result_products.length === 0) {
                    $('#order_content').html('<p style="margin:10px;">Không tìm thấy sản phẩm nào</p>');
                    return;
                } else {
                    var grid_products = $('#order_content');
                    grid_products.empty();

                    // $result_products.forEach(function(sach) {
                    //     if (sach.khuyenMai > 0) {
                    //         $giaMoi = sach.giaXuat * (1 - sach.khuyenMai / 100);
                    //         $discount_percent = '<div class="discount-percent">' + sach.khuyenMai +
                    //             '%</div>';
                    //         $book_price = '<p class="book-price">' + $giaMoi + ' VNĐ</p>';
                    //         $old_price = '<p class="old-price">' + sach.giaXuat + ' VNĐ</p>';
                    //     } else {
                    //         $discount_percent = '';
                    //         $book_price = '<p class="book-price">' + sach.giaXuat + ' VNĐ</p>';
                    //         $old_price = '';
                    //     }
                    //     if (sach.hinhAnh == null) {
                    //         sach.hinhAnh = 'https://via.placeholder.com/150';
                    //     }
                    //     $product_item = '<div class="grid-item">' + $discount_percent + '<img src="' +
                    //         sach
                    //         .hinhAnh + '" class="book-image" alt="' + sach.tenSach + '">' +
                    //         '<p class="book-title">' + sach.tenSach + '</p>' + $book_price +
                    //         $old_price +
                    //         '</div>';

                    //     grid_products.append($product_item);
                    // });

                    var pagination = $('#pagination');
                    pagination.empty();
                    for (var i = 1; i <= $total_pages; i++) {
                        var button = $('<a onclick="loadProduct(' + i + ')">' + i + '</a>');
                        if (i === page) {
                            button.addClass('active');
                        }
                        pagination.append(button);
                    }
                }


            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>