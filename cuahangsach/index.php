

<?php
session_start();

ob_start();
require_once("header.php");
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case "home":
            require_once("home.php");
            break;
        case "login":
            require_once("loginregister_page.php");
            break;
        case "register":
            require_once("loginregister_page.php");
            break;
        case "gioithieu":
            require_once("gioithieu.php");
            break;
        case "giohang":
            require_once("shopcart.php");
            break;
        case "prolist":
            require_once("pro-list.php");
            break;
        case "khachhang":
            require_once("thongtinkhachhang.php");
            break;
        case "nguoinhan":
            require_once("thanhtoan.php");
            break;
        default:
            require_once("home.php");
            break;
    }
} else {
    require_once("home.php");
}
require_once("footer.php");
ob_end_flush();
?>