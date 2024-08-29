<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "myaloha";
$port = 3308;

// Create connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>