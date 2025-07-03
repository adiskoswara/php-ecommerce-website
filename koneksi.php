<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "tokoonline";

$con = mysqli_connect($hostname, $username, $password, $database_name);

if ($con->connect_error) {
    echo "koneksi database rusak";
    die("Error!");
}

?>