<?php
    $mysqli = new mysqli("localhost:3306", "root", "", "cuahangsach");

    // Kiểm tra kết nối
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
    

    // Đặt charset utf8
    if (!$mysqli->set_charset("utf8")) {
        printf("Error loading character set utf8: %s\n", $mysqli->error);
        exit();
    }
?>