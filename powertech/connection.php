<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Default password for root in XAMPP is empty
$database = 'login_system';
$port = 3306;

// Establishing connection
$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>