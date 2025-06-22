<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $booking_id = $_POST['booking_id'] ?? '';
    $event_date = $_POST['event_date'] ?? '';
    $package = $_POST['package_name'] ?? '';

    $subject = "Booking Confirmed - Lighting Emotion";

    $message = "Hello $name,\n\n"
             . "Your booking (ID: $booking_id) for the '$package' package on $event_date has been confirmed.\n"
             . "We look forward to capturing your special moments!\n\n"
             . "Regards,\nLighting Emotion Team";

    $headers = "From: no-reply@lightingemotion.com";

    if (mail($email, $subject, $message, $headers)) {
        $_SESSION['mail_sent'] = "✅ Mail sent to $email";
    } else {
        $_SESSION['mail_sent'] = "❌ Failed to send mail to $email";
    }
}

header("Location: view_bookings.php");
exit();
