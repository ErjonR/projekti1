<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop1_db";

// Krijo lidhjen
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollo lidhjen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

