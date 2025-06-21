<?php
// 1. Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "lighting_emotion";

require 'db_connect.php';  // This connects your script to the database



$conn = new mysqli($host, $username, $password, $database);

// 2. Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// 3. Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$event_date = $_POST['event_date'];
$package_id = $_POST['package'];
$notes = $_POST['notes'];

// 4. Generate booking ID
function generateBookingId() {
  $date = date("ymd");
  $random = rand(1000, 9999);
  return "BK-" . $date . "-" . $random;
}
$booking_id = generateBookingId();

// 5. Insert into database
$sql = "INSERT INTO bookings (booking_id, name, email, phone, event_date, package_id, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssis", $booking_id, $name, $email, $phone, $event_date, $package_id, $notes);

if ($stmt->execute()) {
  echo "<h2 style='font-family:sans-serif;color:green;text-align:center;'>Booking Successful!</h2>";
  echo "<p style='text-align:center;font-size:18px;'>Your Booking ID is <strong>$booking_id</strong></p>";
  echo "<p style='text-align:center;'>Please save this for payment and future communication.</p>";
} else {
  echo "<h2 style='color:red;'>Error: " . $stmt->error . "</h2>";
}

$stmt->close();
$conn->close();
?>
