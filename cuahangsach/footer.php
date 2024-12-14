<style>
    #block-link {
        display: block;
    }

    .footer .container {
        background-color: #9fa7ab;
        margin: 0 auto;
        width: 1230px;
        border-bottom: 1px solid #000;
        border-radius: 8px 8px 0 0;
    }

    .footer .container-inner {
        display: flex;
        padding: 14px 25px;
        align-items: center;
        justify-content: center;
    }

    .footer .container-inner .subscribe-title {
        margin-left: 10px;
        margin-right: 30px;
        display: flex;
        align-items: center;
    }

    .subscribe-title #icon-email {
        margin-right: 10px;
        width: 22.5px;
    }

    .subscribe-title label {
        display: block;
        font-weight: normal;
        font-size: 18px;
        color: #fff;
        margin: 0 auto;
        font-family: sans-serif;
        text-align: center;
        padding-top: 3px;
    }

    .subscribe-action {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        max-width: 630px;
        padding: 2px;
        justify-content: left;
        border-radius: 5px;
    }

    .subscribe-action input {
        width: 500px;
        height: 35px;
        padding: 10px;
        margin-right: 10px;
        border: none;
    }

    .subscribe-action input:focus {
        outline: none;
    }

    .subscribe-action input::placeholder {
        font-size: 13px;
        color: #9fa7ab;
    }

    .subscribe-action button {
        width: 100px;
        height: 35px;
        background-color: #ff6600;
        color: #fff;
        border: 2px solid #fff;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease-in;
    }

    .subscribe-action button:hover {
        font-weight: bold;
        background-color: #ffffff;
        color: #ff6600;
        border: 2px solid #ff6600;
    }

    #foot .topfoot {
        display: flex;
        flex-wrap: wrap;
        width: 1230px;
        background-color: #fff;
        margin: 0 auto;
        font-family: sans-serif;
    }

    #foot .topfoot .footmenu {
        width: 25%;
        padding: 20px;
    }

    #foot .topfoot .footmenu:first-child {
        border-right: 1px solid #282828;
        width: 35%;
    }

    #foot .topfoot .footmenu h3 {
        color: #ff4700;
        padding-bottom: 15px;
        margin: 15px 0;
        font-weight: bold;
        border-bottom: 1px solid #282828;
    }

    #foot .topfoot .footmenu a,
    #foot .topfoot .footmenu p {
        text-decoration: none;
        font-size: 11pt;
        color: #000000;
        line-height: 35px;
        transition: 0.5s;
    }

    #foot .topfoot .footmenu p {
        font-size: 13px;
        margin: 0;
    }

    #foot .topfoot .footmenu a:hover {
        color: #ff4700;
        padding-left: 10px;
    }

    #foot .botfoot {
        height: 50px;
        text-align: center;
        margin: 0 auto;
        color: #999;
        width: 1230px;
        background-color: #fff;
        border-top: 1px solid #282828;
    }

    /* @media screen and (min-width: 1200px){
            .container{
                padding-left: 0;
                padding-right: 0;
            }
            
        }
        @media screen and (max-width: 992px, min-width: 768px){
            .container{
                width: 970px;
            }
            
        }
        @media screen and (min-width: 768px){
            .container{
                width: 750px;
            }
            
        } */
</style>

<div id="block-link" class="footer">
    <div class="container">
        <div class="container-inner">
            <div class="subscribe-title">
                <img id="icon-email" src="../cuahangsach/icon/mail.png" alt="">
                <label for="newsletter">ĐĂNG KÝ NHẬN BẢN TIN</label>
            </div>
            <form class="subscribe-action" action="" method="post">
                <input type="email" name="email" id="newsletter" placeholder="Nhập email của bạn" required>
                <button type="submit">Đăng ký</button>
            </form>
        </div>
    </div>
</div>
<div id="foot">
    <div class="topfoot">
        <div class="footmenu">
            <img src="../cuahangsach/icon/logothuonghieu.png" alt="">
            <p>Địa chỉ: 273 An Dương Vương, P3, Quận 5, TPHCM</p>
            <p>Số điện thoại: 0566490523 </p>
            <p>Fahasa.com nhận đặt hàng trực tuyến và giao hàng tận nơi.</p>
            <p>KHÔNG hỗ trợ đặt mua và nhận hàng trực tiếp tại văn phòng cũng như tất cả Hệ Thống Fahasa trên toàn
                quốc.</p>
        </div>
        <div class="footmenu">
            <h3>HỖ TRỢ</h3>
            <a href="">Chính sách đổi - trả - hoàn tiền</a><br>
            <a href="">Chính sách bảo hành</a><br>
            <a href="">Chính sách vận chuyển</a>
        </div>
        <div class="footmenu">
            <h3>GIỚI THIỆU</h3>
            <a href="./index.php?page=gioithieu">Giới thiệu fahasa</a><br>
            <a href="">Điều khoản sử dụng</a><br>
            <a href="">Hệ thống trung tâm nhà sách</a>
        </div>

    </div>
    <div class="botfoot">
        <p>2018 &#169; Copyright Since1999. All Rights Reserved.</p>
    </div>
</div>