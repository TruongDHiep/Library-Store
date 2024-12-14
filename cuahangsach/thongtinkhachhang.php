<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../admin/css/styleadmin.css">
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

    table,
    td,
    th {
        border: 1px solid #ddd;
        text-align: left;
    }

    table {
        border-collapse: collapse;
        width: 100%;

    }
    th,
    td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }

    th {
        background-color: #3C5B6F;
        color: white;
    }
    </style>
</head>

<body>
    <div id="information-account">
        <div class="account-container">
            <div class="block-content">
                <div class="block-title">
                    <h2>TÀI KHOẢN</h2>
                </div>
                <ul class="list_link">
                    <li>
                        <a href="#account-content">Thông tin tài khoản</a>
                    </li>
                    <li>
                        <a href="#order-content">Đơn hàng của tôi</a>
                    </li>
                    <li>
                        <a href="#reset-password">Đổi mật khẩu</a>
                    </li>
                </ul>
            </div>
            <div id="account-content" class="box-content active-info">
                <div class="account-content-title">
                    <h3>Thông tin tài khoản</h3>
                </div>
                <form id="infor_form" action="" method="post">
                    <div class="account-input-1">
                        <label for="">Họ và tên</label>
                        <div class=input-box>
                            <input name="tenKH" type="text" placeholder="Nhập họ và tên"
                                value="<?php echo $_SESSION['current_user']['tenKH']?>">
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
                            <input name="SDT" type="text" placeholder="Nhập số điện thoại"
                                value="<?php echo $_SESSION['current_user']['SDT'] ?>">
                        </div>

                    </div>
                    <div class="account-input-1">
                        <label for="">Địa chỉ</label>
                        <div class=input-box>

                            <input name="diaChi" type="text" placeholder="Nhập địa chỉ"
                                value="<?php echo $_SESSION['current_user']['diaChi'] ?>">
                        </div>

                    </div>
                    <button class="btn_xacnhan" type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
            <div id="order-content" class="box-content active-info" action="" method="post">
                <div class="account-content-title">
                    <h3>Đơn hàng của bạn</h2>
                    <table id="tb_donhang">

                    </table>
                </div>
            </div>
            <div id="reset-password" class="box-content" action="" method="post">
                <div class="account-content-title">
                    <h3>Đổi mật khẩu</h3>
                </div>
                <form id="repass_form" action="" method="post">
                    <div class="account-input-1">
                        <label for="">Mật khẩu hiện tại</label>
                        <div class=input-box>
                            <input name="oldpass" type="password" id="input_oldpass"
                                placeholder="Nhập mật khẩu hiện tại">
                        </div>
                    </div>
                    <div class="account-input-1">
                        <label for="">Mật khẩu mới</label>
                        <div class=input-box>
                            <input name="newpass" type="password" id="input_newpass" placeholder="Nhập mật khẩu mới">
                        </div>
                    </div>
                    <div class="account-input-1">
                        <label for="">Nhập lại mật khẩu</label>
                        <div class=input-box>
                            <input name="repass" type="password" id="input_renewpass"
                                placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>
                    <button class="btn_xacnhan" type="submit" class="btn btn-primary">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js">
</script>
<script>
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
</script>
<script>
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
</script>
<script>
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
</script>
<script>
function loadDonhang(page) {
    $.ajax({
        url: 'loadDonhang.php',
        type: 'GET',
        data: {
            maKH: <?php echo json_encode($_SESSION['current_user']['maKH']); ?>,
            page: page,
        },
        success: function(response) {
            $data = JSON.parse(response);
            $result_products = $data.products;
            console.log($result_products);
            if ($result_products.length > 0) {
                var table = document.createElement("table");
                var thead = document.createElement("thead");
                var tr = document.createElement("tr");
                var th1 = document.createElement("th");
                var th2 = document.createElement("th");
                var th3 = document.createElement("th");
                var th4 = document.createElement("th");
                th1.textContent = "Mã HD";
                th2.textContent = "Tổng tiền";
                th3.textContent = "Ngày đặt";
                th4.textContent = "Trạng thái";
                tr.appendChild(th1);
                tr.appendChild(th2);
                tr.appendChild(th3);
                tr.appendChild(th4);
                thead.appendChild(tr);
                table.appendChild(thead);
                var tbody = document.createElement("tbody");
                for (var i = 0; i < $result_products.length; i++) {
                    var hoaDon = $result_products[i];
                        var tr = document.createElement("tr");
                        var td1 = document.createElement("td");
                        var td2 = document.createElement("td");
                        var td3 = document.createElement("td");
                        var td4 = document.createElement("td");
                        td1.textContent = hoaDon["maHD"];
                        td2.textContent = hoaDon["tongTien"].toLocaleString();
                        td3.textContent = hoaDon["ngayTao"];
                        if (hoaDon["trangThai"] == 1){
                            td4.textContent = "Đang xử lí";
                        } else if (hoaDon["trangThai"] == 0) {
                            td4.textContent = "Đã hủy";
                        } else if (hoaDon["trangThai"] == 2){
                            td4.textContent = "Đã giao hàng";
                        }
                        tr.appendChild(td1);
                        tr.appendChild(td2);
                        tr.appendChild(td3);
                        tr.appendChild(td4);
                        tbody.appendChild(tr);
                }
                table.appendChild(tbody);
                document.getElementById("tb_donhang").appendChild(table);
            } else {
                console.log("Không có dữ liệu hóa đơn.");
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}
$(document).ready(function() {
    loadDonhang(1);
});
</script>

</html>