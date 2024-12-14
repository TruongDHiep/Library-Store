<?php
session_start();
include 'connection_db.php';
$result = mysqli_query($con, "SELECT matKhau FROM `taikhoan` WHERE `email` = '". $_SESSION['current_user']['email']."'");

if (isset($_GET['oldpass']) && $_GET['oldpass'] == $result->fetch_assoc()['matKhau']) {
    echo json_encode(true);
} else {
    echo json_encode(false);
}