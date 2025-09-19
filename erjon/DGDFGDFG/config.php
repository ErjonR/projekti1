<?php
// config.php - Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "shopdb";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
