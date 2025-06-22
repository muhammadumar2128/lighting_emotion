<?php
session_start(); // Start session for flash message

// 1. Connect to the database
$conn = new mysqli("localhost", "root", "", "lighting_emotion");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Get form data safely
$bookingId   = $_POST['bookingId'] ?? '';
$name        = $_POST['name'] ?? '';
$amount      = $_POST['amount'] ?? '';
$method      = $_POST['method'] ?? '';
$transaction = $_POST['transaction'] ?? '';

// 3. Validate fields
if (empty($bookingId) || empty($name) || empty($amount) || empty($method) || empty($transaction)) {
    $_SESSION['payment_message'] = "❌ Please fill in all fields.";
    header("Location: payment.php");
    exit();
}

// 4. Insert into payments table
$sql = "INSERT INTO payments (booking_id, name, amount_paid, payment_method, transaction_ref)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['payment_message'] = "❌ SQL Prepare Error: " . $conn->error;
    header("Location: payment.php");
    exit();
}

$stmt->bind_param("ssdss", $bookingId, $name, $amount, $method, $transaction);

if ($stmt->execute()) {
    $_SESSION['payment_message'] = "✅ Payment submitted successfully!";
} else {
    $_SESSION['payment_message'] = "❌ Error saving payment: " . $stmt->error;
}

$stmt->close();
$conn->close();

// 5. Redirect back to form
header("Location: payment.php");
exit();
?>
