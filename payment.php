<?php
session_start();
$message = $_SESSION['payment_message'] ?? '';
unset($_SESSION['payment_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment - Lighting Emotion</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Open Sans', sans-serif;
      background: url('uploads/payment-bg.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      position: relative;
    }
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.6);
      z-index: 0;
    }
    nav {
      background: rgba(0, 0, 0, 0.7);
      padding: 15px 30px;
      position: relative;
      z-index: 2;
      display: flex;
      justify-content: center;
    }
    nav a {
      color: #f06292;
      text-decoration: none;
      margin: 0 20px;
      font-weight: bold;
      font-size: 1.1em;
    }
    nav a:hover {
      text-decoration: underline;
    }
    .container {
      position: relative;
      z-index: 1;
      max-width: 700px;
      margin: auto;
      padding: 60px 20px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(6px);
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    h1 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5em;
      color: #f8bbd0;
      text-align: center;
      margin-bottom: 30px;
    }
    .confirmation {
      margin-bottom: 25px;
      background-color: #4caf50;
      padding: 15px;
      border-radius: 6px;
      text-align: center;
      color: white;
    }
    form label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      color: #f06292;
    }
    form input, form select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: none;
      border-radius: 6px;
      font-size: 1em;
      background: rgba(255, 255, 255, 0.9);
      color: #333;
    }
    form button {
      margin-top: 25px;
      padding: 12px 25px;
      background-color: #f06292;
      border: none;
      color: white;
      font-size: 1em;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
    }
    form button:hover {
      background-color: #ec407a;
    }
  </style>
</head>
<body>
  <nav>
    <a href="index.html">Home</a>
    <a href="about.html">About</a>
    <a href="packages.html">Packages</a>
    <a href="contact.php">Contact</a>
    <a href="booking.php">Book Now</a>
    <a href="payment.php">Payment</a>
    <a href="login.php">Login</a>
  </nav>

  <div class="container">
    <h1>Complete Your Payment</h1>

    <?php if (!empty($message)): ?>
      <div class="confirmation"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form id="paymentForm" action="submit_payment.php" method="POST">
      <label for="bookingId">Booking ID</label>
      <input type="text" id="bookingId" name="bookingId" required />

      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required />

      <label for="amount">Amount Paid (PKR)</label>
      <input type="number" id="amount" name="amount" required />

      <label for="method">Payment Method</label>
      <select id="method" name="method" required>
        <option value="">-- Select Method --</option>
        <option value="Easypaisa">Easypaisa</option>
        <option value="JazzCash">JazzCash</option>
        <option value="Bank Transfer">Bank Transfer</option>
      </select>

      <label for="transaction">Transaction ID / Reference</label>
      <input type="text" id="transaction" name="transaction" required />

      <button type="submit">Submit Payment</button>
    </form>
  </div>
</body>
</html>
