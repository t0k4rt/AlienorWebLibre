<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_alienorweblibre = "localhost";
$database_alienorweblibre = "alienorweblibre";
$username_alienorweblibre = "root";
$password_alienorweblibre = "bl4ckb1rd";
$alienorweblibre = mysql_connect($hostname_alienorweblibre, $username_alienorweblibre, $password_alienorweblibre) or trigger_error(mysql_error(),E_USER_ERROR);
?>