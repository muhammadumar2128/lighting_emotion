

<?php
session_start();
// 1. Connect to DB
$conn = new mysqli("localhost","root","","lighting_emotion");
if($conn->connect_error){ die("DB Error: ".$conn->connect_error); }

// 2. Grab POST data
$booking_id = trim($_POST['booking_id'] ?? '');
$rating     = (int)($_POST['rating'] ?? 0);
$text       = trim($_POST['text'] ?? '');

// 3. Basic validation
if(!$booking_id || !$rating || !$text){
  $_SESSION['testimonial_message'] = "❌ All fields are required.";
  header("Location: testimonials.php"); exit();
}

// 4. Lookup client_id by booking_id
$stmt = $conn->prepare("SELECT client_id FROM bookings WHERE booking_id=?");
$stmt->bind_param("s",$booking_id);
$stmt->execute();
$stmt->bind_result($client_id);
if(!$stmt->fetch()){
  $_SESSION['testimonial_message'] = "❌ Invalid Booking ID.";
  $stmt->close(); $conn->close();
  header("Location: testimonials.php"); exit();
}
$stmt->close();

// 5. Insert into testimonials
$insert = $conn->prepare(
  "INSERT INTO testimonials (client_id, rating, testimonial_text) VALUES (?, ?, ?)"
);
$insert->bind_param("iis", $client_id, $rating, $text);
if($insert->execute()){
  $_SESSION['testimonial_message'] = "✅ Thank you! Your testimonial has been submitted.";
} else {
  $_SESSION['testimonial_message'] = "❌ DB Error: ".$insert->error;
}
$insert->close();
$conn->close();

// 6. Redirect back
header("Location: testimonials.php"); exit();
?>