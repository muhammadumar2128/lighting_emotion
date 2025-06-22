
<?php
// 1. Database connection
$conn = new mysqli("localhost","root","","lighting_emotion");
if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }

// 2. Fetch testimonials
$sql = "SELECT t.rating, t.testimonial_text, t.created_at, c.full_name 
        FROM testimonials t
        JOIN clients c ON t.client_id = c.client_id
        ORDER BY t.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>What Our Clients Say - Lighting Emotion</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Open Sans', sans-serif; background: #f7f7f7; margin:0; }
    nav { background: #222; padding: 15px; text-align: center; }
    nav a { color: #f06292; margin: 0 15px; text-decoration: none; font-weight: bold; }
    .container { max-width: 900px; margin: 60px auto; padding: 0 20px; }
    h1 { text-align: center; font-family: 'Playfair Display', serif; color: #f06292; margin-bottom: 40px; }
    .testimonial { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .testimonial h3 { margin:0; font-size: 1.2em; color: #333; }
    .testimonial .rating { color: #f06292; margin-top: 5px; }
    .testimonial p { margin: 15px 0; color: #555; line-height: 1.6; }
    .testimonial .date { font-size: 0.9em; color: #999; }
  </style>
</head>
<body>
  <nav>
    <a href="index.html">Home</a>
    <a href="about.html">About</a>
    <a href="packages.html">Packages</a>
    <a href="booking.php">Book Now</a>
    <a href="testimonials_display.php">See_Testimonials</a>
    <a href="contact.php">Contact</a>
  </nav>
  <div class="container">
    <h1>What Our Clients Say</h1>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="testimonial">
          <h3><?= htmlspecialchars($row['full_name']) ?></h3>
          <div class="rating"><?php for($i=0;$i<$row['rating'];$i++) echo '★'; ?></div>
          <p><?= nl2br(htmlspecialchars($row['testimonial_text'])) ?></p>
          <div class="date"><?= date('F j, Y', strtotime($row['created_at'])) ?></div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No testimonials yet. Be the first to <a href="testimonials.php">submit one</a>!</p>
    <?php endif; ?>
  </div>
</body>
</html>
