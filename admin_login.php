<?php
session_start();

$conn = new mysqli("localhost", "root", "", "lighting_emotion");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header("Location: login.php?error=Please enter both fields");
    exit();
}

$sql = "SELECT * FROM admins WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if ($row['password'] === $password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: Dashborad.html"); // Or change to Dashboard.php
    } else {
        header("Location: login.php?error=Invalid password");
    }
} else {
    header("Location: login.php?error=User not found");
}

$stmt->close();
$conn->close();
exit();
