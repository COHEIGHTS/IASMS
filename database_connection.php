<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "your_database_name"; // Replace with your actual database name

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>