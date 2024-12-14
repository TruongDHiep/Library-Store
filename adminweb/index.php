<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <title>Login Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
.box-content {
    margin: 0 auto;
    width: 1000px;
    height: 400px;
    border: 1px solid #ccc;
    padding: 20px;
    
}

.box-content h1 {
    text-align: center;
}

.box-content form {
    width: 40%;
    margin: 40px auto;
}

.box-content form input {
    margin: 5px 0;
    height: 50px;
}

.box-content form #button-box {
    text-align: center;
}

.box-content form button {
    height: 45px;
    width: 200px;
    background-color: #C92127;
    border: none;
    font-weight: bold;
}
.box-content form button:hover {
    background-color: #FF0000;
}

#password-box {
    position: relative;
    width: 100%;
}

#password-box .eye {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    max-width: 20px;
}

.hidden {
    display: none;
}
</style>
</head>

<body>
    <?php
    session_start(); ?>
    <div id="user_login" class="box-content">
        <h1>Đăng nhập tài khoản</h1>
        <form id="login-form" action="./login.php" method="Post" autocomplete="off">
            <div class="mb-3" id="login-box">
                <!-- <label for="input_username" class="form-label">Tài khoản</label> -->
                <input type="email" name="email" class="form-control" id="input_email" placeholder ="Tài khoản">
            </div>
            <div class="mb-3" id="password-box">
                <!-- <label for="input_password" class="form-label">Mật khẩu</label> -->
                <input type="password" name="password" class="form-control" id="input_password" placeholder ="Mật khẩu">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="eye eye-close">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="eye eye-open hidden">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
            <div id="button-box">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
$("#login-form").submit(function(event) {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: './action.php',
        data: $(this).serializeArray(),
        success: function(response) {
            try {
                var string = JSON.parse(response);
                if (string.status === 1) {
                    alert(string.message);
                    location.href = './admin.php';
                } else {
                    alert(string.message);
                }
            } catch (error) {
                console.error("Error parsing JSON:", error);
                console.log("Invalid JSON response:", response);
            }
        }
    });
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

</html>