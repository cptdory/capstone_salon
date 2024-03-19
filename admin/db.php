<?php

$hostname = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "login_register";
$conn = mysqli_connect($hostname, $dbusername, $dbpassword, $dbname);
if (!$conn) {
    die ("Something went wrong");
}


?>