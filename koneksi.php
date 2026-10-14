<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "data_penghuni_kos";
$port = 3307;

$db = mysqli_connect($hostname,$username,$password,$database,$port);
if ($db -> connect_error){
    echo "gagal";
}
echo "berhasil";
?>