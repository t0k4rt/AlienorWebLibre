<?php
session_start();
session_destroy();
session_unset();
unset($_SESSION);
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("location: http://$host$uri/index.php");
?>