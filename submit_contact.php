<?php
session_start();

// 1. Connect to the database
$conn = new mysqli("localhost", "root", "", "lighting_emotion");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Get form data safely
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// 3. Basic validation
if (empty($name) || empty($email) || empty($message)) {
    $_SESSION['contact_message'] = "❌ Please fill in all fields.";
    header("Location: contact.php");
    exit();
}

// 4. Insert into messages table (without created_at)
$sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    $_SESSION['contact_message'] = "✅ Your message has been sent successfully!";
} else {
    $_SESSION['contact_message'] = "❌ Failed to send message. Please try again.";
}

$stmt->close();
$conn->close();

// 5. Redirect back to the contact page
header("Location: contact.php");
exit();
?>
