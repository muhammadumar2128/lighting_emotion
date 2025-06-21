<?php
$host = "localhost";       // XAMPP default
$username = "root";        // XAMPP default user
$password = "";            // no password by default
$database = "lighting_emotion";  // Make sure you created this in phpMyAdmin

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Optional: you can echo success if needed
// echo "Database connected successfully!";
?>
