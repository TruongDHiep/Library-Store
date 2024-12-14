<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: sans-serif;
    }

    body {
        /* font-size: 16px;     */
        background-color: #F0F0F0;
    }

    #wrapper {
        width: 1230px;
        border: 1px solid #fff;
        margin: 20px auto;
        background-color: #fff;
    }

    .tabs {
        width: 600px;
        margin: 100px auto;
    }

    .tabs .nav-tabs {
        display: flex;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
        border-bottom: 3px solid #ddd;
    }

    .tabs .nav-tabs li {
        margin-right: 10px;
        width: 50%;
    }

    .tabs .nav-tabs li a {
        display: block;
        text-align: center;
        padding: 6px 10px;
        text-decoration: none;
        position: relative;
        color: #ddd;
        transition: 0.2s;
    }

    .tabs .nav-tabs li a:link {
        font-size: 15pt;
        font-weight: 500;
    }

    .tabs .nav-tabs li a::after {
        content: "";
        height: 3px;
        width: 90%;
        position: absolute;
        left: 20px;
        bottom: -3px;
        background-color: transparent;
        transition: background-color 0.2s;
    }

    .nav-tabs li.active-tab a,
    .nav-tabs li a:hover {
        color: #C92127;
    }

    .tabs .nav-tabs li.active-tab a::after,
    .nav-tabs li a:hover::after {
        background-color: #C92127;
    }

    .box-content {
        display: none;
        margin: 0 auto;
        width: 600px;
        height: 400px;
        /* border: 1px solid #ccc; */
        padding: 20px;
    }

    .box-content form {
        width: 80%;
        margin: 20px auto;
    }

    .box-content form input {
        margin: 5px 0;
        height: 50px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .box-content form input::placeholder {
        font-size: 1.2em;
        font-weight: 500;
    }

    .box-content form #button-box {
        text-align: center;
    }

    .box-content form button {
        height: 45px;
        width: 250px;
        background-color: #C92127;
        border: none;
        font-weight: bold;
    }

    .box-content form button:hover {
        background-color: #FF0000;
    }

    .email-box,
    .password-box {
        position: relative;
        width: 100%;
        margin-bottom: 20px;
    }

    .box-content input {
        width: 100%;
    }

    .form-label {
        display: block;
        margin-left: 10px;
    }

    .password-box .labelbox {
        display: flex;
        justify-content: space-between;
    }

    .password-box .eye {
        display: absolute;
        transform: translateY(145%);
        float: right;
        cursor: pointer;
        margin: 0 20px;
        cursor: pointer;
        max-width: 20px;
    }

    .hidden {
        display: none;
    }

    .register-term {
        margin-top: 20px;
        text-align: center;
        padding: 8px 0;
        font-size: 0.9em;
        line-height: 1.5em;
    }

    label.error {
        display: block;
        color: red;
        font-size: 1.1em;
        margin-left: 20px;
    }

    #error-login-massage {
        margin-top: 10px;
        text-align: center;
    }
</style>

<body>
    <div id="login-register-page">
        <div id="wrapper">
            <div class="tabs">
                <ul class="nav-tabs">
                    <li id="nav-tab-login" class="active-tab"><a href="#user_login">Đăng nhập</a></li>
                    <li id="nav-tab-register"><a href="#user_register">Đăng ký</a></li>
                </ul>
                <div class="tabs-content">
                    <div id="user_login" class="box-content">
                        <!-- <h1>Đăng nhập tài khoản</h1> -->
                        <form id="login-form" action="./login.php" method="Post" autocomplete="off">
                            <div class="email-box">
                                <label for="input_email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="input_email" placeholder="Email">
                            </div>
                            <div class="password-box">
                                <div class="labelbox">
                                    <label for="input_password" class="form-label">Mật khẩu</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="eye eye-close">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="eye eye-open hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                                <input type="password" name="password" class="form-control" id="input_password" placeholder="Mật khẩu">
                            </div>
                            <div id="button-box">
                                <button type="submit" class="btn btn-primary">Đăng nhập</button>
                            </div>
                            <label id="error-login-massage" class="error" for="error"></label>
                        </form>
                    </div>
                    <div id="user_register" class="box-content">
                        <!-- <h1>Đăng ký tài khoản</h1> -->
                        <form id="register-form" method="Post" autocomplete="off">
                            <div class="email-box">
                                <label for="input_email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="input_email" placeholder="Email">
                            </div>
                            <div class="password-box">
                                <div class="labelbox">
                                    <label for="input_password_reg" class="form-label">Mật khẩu</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="eye eye-close-reg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="eye eye-open-reg hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                                <input type="password" name="password" class="form-control" id="input_password_reg" placeholder="Mật khẩu">
                            </div>
                            <div id="button-box">
                                <button type="submit" class="btn btn-primary">Đăng ký</button>
                            </div>
                            <div class="register-term">
                                Bằng việc đăng ký, bạn đã đồng ý với Fahasa.com về<br>
                                <a href="https://www.fahasa.com/dieu-khoan-su-dung" target="_blank" style=""> Điều khoản dịch vụ</a>
                                &nbsp;&amp;&nbsp;
                                <a href="https://www.fahasa.com/dieu-khoan-su-dung" target="_blank" style="">Chính sách bảo mật</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js">
</script>
<script>
$("#login-form").validate({
    rules: {
        email: {
            required: true,
            email: true,
        },
        password: {
            required: true,
        },
    },
    messages: {
        email: {
            required: "Bạn chưa nhập email",
            email: "Email chưa đúng định dạng",
        },
        password: {
            required: "Bạn phải nhập password",
            minlength: "Password tối thiểu là 6 ký tự"
        },
    },
    submitHandler: function(form) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: './login_action_user.php',
            data: $(form).serializeArray(),
            success: function(response) {
                try {
                    var string = JSON.parse(response);
                    if (string.status === 1) {
                        alert(string.message);
                        location.href = './index.php';
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
    // $("#login-form").submit(function(event) {
    //     event.preventDefault();
    //     $.ajax({
    //         type: "POST",
    //         url: './action.php',
    //         data: $(this).serializeArray(),
    //         success: function(response) {
    //             try {
    //                 var string = JSON.parse(response);
    //                 if (string.status === 1) {
    //                     alert(string.message);
    //                     location.href = './index.php';
    //                 } else {
    //                     alert(string.message);
    //                 }
    //             } catch (error) {
    //                 console.error("Error parsing JSON:", error);
    //                 console.log("Invalid JSON response:", response);
    //             }
    //         }
    //     });
    // });
</script>
<script>
    $("#register-form").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: "check_email.php"
            },
            password: {
                required: true,
                minlength: 6
            },
        },
        messages: {
            email: {
                required: "Bạn chưa nhập email",
                email: "Email chưa đúng định dạng",
                remote: "Email đã tồn tại trong hệ thống"
            },
            password: {
                required: "Bạn phải nhập password",
                minlength: "Password tối thiểu là 6 ký tự"
            },
        },
        submitHandler: function(form) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: './reg_action_user.php',
                data: $(form).serializeArray(),
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 0) { //Đăng nhập lỗi
                        alert(response.message);
                    } else { //Đăng nhập thành công
                        alert(response.message);
                        location.href = './index.php?page=khachhang';
                    }
                }
            });
        }
    });
</script>
<script>
    const input = document.getElementById('input_password');
    const eyeOpen = document.querySelector('.eye-open');
    const eyeClose = document.querySelector('.eye-close');
    eyeOpen.addEventListener('click', function() {
        eyeOpen.classList.add('hidden');
        eyeClose.classList.remove('hidden');
        input.type = 'password';
    });
    eyeClose.addEventListener('click', function() {
        eyeClose.classList.add('hidden');
        eyeOpen.classList.remove('hidden');
        input.type = 'text';
    });
</script>
<script>
    const input2 = document.getElementById('input_password_reg');
    const eyeOpen2 = document.querySelector('.eye-open-reg');
    const eyeClose2 = document.querySelector('.eye-close-reg');
    eyeOpen2.addEventListener('click', function() {
        eyeOpen2.classList.add('hidden');
        eyeClose2.classList.remove('hidden');
        input2.type = 'password';
    });
    eyeClose2.addEventListener('click', function() {
        eyeClose2.classList.add('hidden');
        eyeOpen2.classList.remove('hidden');
        input2.type = 'text';
    });
</script>
<script>
    $(document).ready(function() {
        $('.box-content:first').show();
        $('.nav-tabs li a').click(function() {
            if ($(this).parent().hasClass('active-tab')) {
                return false;
            }
            $('.box-content').hide();
            $('.nav-tabs li').removeClass('active-tab');
            $(this).parent().addClass('active-tab');

            let id_tab_content = $(this).attr('href');
            $('box-content').hide();
            $(id_tab_content).fadeIn();
            return false;
        });
    });
</script>
