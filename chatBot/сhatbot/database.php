<?php

$db_host = 'localhost';
$db_user = 'u2406909_default';
$db_pass = 'X27QcbwX8Hk1f87W';
$db_name = 'u2406909_default';
        
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        
if (!$conn) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
    }
mysqli_set_charset($conn, "utf8");

?>