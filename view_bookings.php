<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// DB connection
$conn = new mysqli("localhost", "root", "", "lighting_emotion");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Show email sent status
$emailSentMsg = $_SESSION['mail_sent'] ?? '';
unset($_SESSION['mail_sent']);

// Fetch bookings joined with clients and packages
$sql = "SELECT 
            COALESCE(b.booking_id, b.id) AS booking_id,
            c.full_name AS client_name,
            c.email,
            c.phone,
            b.event_date,
            p.package_name,
            b.location,
            b.notes
        FROM bookings b
        JOIN clients c ON b.client_id = c.client_id
        JOIN packages p ON b.package_id = p.package_id
        ORDER BY b.event_date ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Bookings - Admin</title>
  <style>
    body { font-family: Arial; background: #f9f9fa; padding: 20px; margin: 0; }
    nav { background-color: #333; padding: 15px; text-align: center; }
    nav a { color: #fff; text-decoration: none; margin: 0 20px; font-weight: bold; }
    nav a:hover { text-decoration: underline; }
    .status { text-align: center; margin: 15px 0; color: green; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
    th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
    th { background-color: #f06292; color: white; }
    .btn-mail { background: #4caf50; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; }
    .btn-mail:hover { background: #388e3c; }
  </style>
</head>
<body>

<nav>
  <a href="DashBorad.html">Dashboard</a>
  <a href="view_bookings.php">All Bookings</a>
  <a href="logout.php">Logout</a>
</nav>

<h1>All Bookings</h1>

<?php if (!empty($emailSentMsg)): ?>
  <div class="status"><?php echo htmlspecialchars($emailSentMsg); ?></div>
<?php endif; ?>

<table>
  <tr>
    <th>Booking ID</th>
    <th>Client Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Event Date</th>
    <th>Package</th>
    <th>Location</th>
    <th>Notes</th>
    <th>Send Mail</th>
  </tr>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
        <td><?php echo htmlspecialchars($row['client_name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>
        <td><?php echo htmlspecialchars($row['event_date']); ?></td>
        <td><?php echo htmlspecialchars($row['package_name']); ?></td>
        <td><?php echo htmlspecialchars($row['location']); ?></td>
        <td><?php echo htmlspecialchars($row['notes']); ?></td>
        <td>
          <a class="btn-mail" href="send_confirmation.php?email=<?php echo urlencode($row['email']); ?>&booking_id=<?php echo urlencode($row['booking_id']); ?>">Send</a>
        </td>
      </tr>
    <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="9">No bookings found.</td></tr>
  <?php endif; ?>
</table>

<?php $conn->close(); ?>
</body>
</html>
