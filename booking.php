<?php
session_start();

// Retrieve and clear messages and booking ID
$message   = $_SESSION['booking_message'] ?? '';
$bookingId = $_SESSION['booking_id']      ?? '';
unset($_SESSION['booking_message'], $_SESSION['booking_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Book Now - Lighting Emotion</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Open Sans', sans-serif; background: #f7f7f7; margin: 0; }
    nav { background: #222; padding: 15px; text-align: center; }
    nav a { color: #f06292; margin: 0 15px; text-decoration: none; font-weight: bold; }
    .container { max-width: 600px; margin: 60px auto; background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
    h1 { text-align: center; font-family: 'Playfair Display', serif; color: #f06292; margin-bottom: 30px; }
    .message { text-align: center; color: green; font-weight: bold; margin-bottom: 20px; }
    label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
    input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 6px; font-size: 1em; }
    button { background-color: #f06292; color: #fff; padding: 12px; border: none; font-size: 1.1em; border-radius: 6px; cursor: pointer; width: 100%; }
    button:hover { background-color: #e91e63; }
  </style>
</head>
<body>
  <nav>
    <a href="index.html">Home</a>
    <a href="about.html">About</a>
    <a href="packages.html">Packages</a>
    <a href="booking.php">Book Now</a>
    <a href="payment.php">Payment</a>
    <a href="testimonials.php">Submit_Testimonial</a>
    <a href="contact.php">Contact</a>
  </nav>

  <div class="container">
    <h1>Book Your Event</h1>
    <?php if (!empty($message)): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($bookingId)): ?>
      <div class="message">Your Booking ID: <strong><?= htmlspecialchars($bookingId) ?></strong></div>
    <?php endif; ?>

    <form action="submit_booking.php" method="POST">
      <label for="full_name">Full Name</label>
      <input type="text" id="full_name" name="full_name" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" />

      <label for="phone">Phone</label>
      <input type="text" id="phone" name="phone" required />

      <label for="event_date">Event Date</label>
      <input type="date" id="event_date" name="event_date" required />

      <label for="package_id">Select Package</label>
      <select id="package_id" name="package_id" required>
        <option value="">-- Choose Package --</option>
        <option value="1">Basic Package</option>
        <option value="2">Standard Package</option>
        <option value="3">Premium Package</option>
        <option value="4">Luxury Royal Package</option>
      </select>

      <label for="location">Event Location</label>
      <input type="text" id="location" name="location" required />

      <label for="notes">Additional Notes</label>
      <textarea id="notes" name="notes" rows="4" placeholder="Any special requests..."></textarea>

      <button type="submit">Confirm Booking</button>
    </form>
  </div>
</body>
</html>
