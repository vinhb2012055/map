<?php
$host ="localhost";
$uname = "root";
$pwd = '';
$db_name = "httt_dialy";
$conn = mysqli_connect($host, $uname, $pwd, $db_name);
mysqli_set_charset($conn, 'UTF8');
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
} else{
    echo"Kết nối thành công";
}
?>