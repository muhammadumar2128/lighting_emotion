
<?php
session_start();
$message = $_SESSION['testimonial_message'] ?? '';
unset($_SESSION['testimonial_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit Testimonial - Lighting Emotion</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Open Sans', sans-serif; background: #f7f7f7; margin: 0; }
    nav { background: #222; padding: 15px; text-align: center; }
    nav a { color: #f06292; margin: 0 15px; text-decoration: none; font-weight: bold; }
    nav a:hover { text-decoration: underline; }
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
    <a href="testimonials.php">Submit_Testimonial</a>
    <a href="testimonials_display.php">See_Testimonials</a>
    <a href="contact.php">Contact</a>
  </nav>

  <div class="container">
    <h1>Submit Your Testimonial</h1>
    <?php if (!empty($message)): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form action="submit_testimonial.php" method="POST">
      <label for="booking_id">Booking ID</label>
      <input type="text" id="booking_id" name="booking_id" required placeholder="e.g. BK-240622-1234" />

      <label for="rating">Your Rating (1-5)</label>
      <select id="rating" name="rating" required>
        <option value="">-- Select Rating --</option>
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <option value="<?= $i ?>"><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
        <?php endfor; ?>
      </select>

      <label for="text">Your Testimonial</label>
      <textarea id="text" name="text" rows="5" required placeholder="Write your feedback..."></textarea>

      <button type="submit">Submit Testimonial</button>
    </form>
  </div>
</body>
</html>