<?php
// Database configuration
$host = 'localhost';
$db = 'scholar';
$user = 'root'; // Update this with your MySQL username
$pass = '';     // Update this with your MySQL password

// Connect to the database
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
