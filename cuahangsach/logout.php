<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php"); // Redirect to the login page or any other page you want
exit();
?>