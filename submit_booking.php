<?php
session_start();

// 1. Database connection
$conn = new mysqli("localhost", "root", "", "lighting_emotion");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Fetch + sanitize form data
$full_name  = trim($_POST['full_name']  ?? '');
$email      = trim($_POST['email']      ?? '');
$phone      = trim($_POST['phone']      ?? '');
$event_date = $_POST['event_date']      ?? '';
$package_id = $_POST['package_id']      ?? '';
$location   = trim($_POST['location']    ?? '');
$notes      = trim($_POST['notes']      ?? '');

// 3. Basic validation
if (empty($full_name) || empty($phone) || empty($event_date) 
    || empty($package_id) || empty($location)) {
    $_SESSION['booking_message'] = "❌ Please fill in all required fields.";
    header("Location: booking.php");
    exit();
}

// 4. Generate a unique booking code
function generateBookingId() {
    return 'BK-'
        . date('ymd')
        . '-'
        . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
}
$bookingCode = generateBookingId();

// 5. Insert or fetch client
$clientStmt = $conn->prepare("INSERT INTO clients (full_name, email, phone) VALUES (?, ?, ?)");
$clientStmt->bind_param("sss", $full_name, $email, $phone);
$clientStmt->execute();
$client_id = $clientStmt->insert_id;
$clientStmt->close();

// 6. Insert booking with that booking_id
$sql = "INSERT INTO bookings 
          (booking_id, client_id, event_date, package_id, location, notes) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sissss", 
    $bookingCode, 
    $client_id, 
    $event_date, 
    $package_id, 
    $location, 
    $notes
);

if ($stmt->execute()) {
    $_SESSION['booking_message'] = "✅ Your booking has been confirmed!";
    $_SESSION['booking_id']      = $bookingCode;
} else {
    $_SESSION['booking_message'] = "❌ Error saving booking: " . $stmt->error;
}

$stmt->close();
$conn->close();

// 7. Redirect back to the form
header("Location: booking.php");
exit();
