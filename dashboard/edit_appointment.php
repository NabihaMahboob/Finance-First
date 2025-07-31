<?php
session_start();
include '../database/db_connection.php';

if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}
$theme = $_SESSION['theme'] ?? 'style';
$cssFile = match ($theme) {
    'night-mode' => 'night-mode.css',
    'pink' => 'pink.css',
    default => 'style.css',
};

// Check if the user is logged in, if
// not then redirect them to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];
$sql = "SELECT * FROM appointments WHERE email = '$email' ORDER BY date, time";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>title</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/<?= htmlspecialchars($cssFile) ?>">
</head>

<body>
    <h1>Booked Appointments and Workshops</h1>
    <h2>Cancel or Change Your Appointments</h2>

    <table cellpadding="8">
  <tr>
    <th>Date</th><th>Time</th><th>Service</th><th>Status</th><th>Actions</th>
  </tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?= htmlspecialchars($row['date']) ?></td>
    <td><?= htmlspecialchars($row['time']) ?></td>
    <td><?= htmlspecialchars($row['service']) ?></td>
    <td><?= htmlspecialchars($row['status']) ?></td>
    <td>
      <?php if ($row['status'] !== 'cancelled') { ?>
        <!-- Cancel Button -->
        <form action="edit_appointment.php" method="POST" style="display:inline;">
          <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
          <button type="submit">Cancel</button>
          <?php

          // Handle cancellation
          if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'])) {
              $appointment_id = $_POST['appointment_id'];
              $cancel_sql = "UPDATE appointments SET status='cancelled' WHERE id='$appointment_id'";
              if (mysqli_query($conn, $cancel_sql)) {
                  echo "<p>Appointment cancelled successfully.</p>";
              } else {
                  echo "<p>Error cancelling appointment: " . mysqli_error($conn) . "</p>";
              }
              // Redirect to avoid resubmission
              header("Location: edit_appointment.php");
              exit();
          }
          ?>
        </form>

        <!-- Change Button -->
        <form action="edit_appointment.php" method="GET" style="display:inline;">
          <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
          <button type="submit">Change</button>
          <?php
          // Handle change request  
          if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['appointment_id'])) {
              $appointment_id = $_GET['appointment_id'];
              $change_sql = "SELECT * FROM appointments WHERE id='$appointment_id'";
              $change_result = mysqli_query($conn, $change_sql);
              if ($change_row = mysqli_fetch_assoc($change_result)) {
                  // Display form to change appointment details
                  echo '<form action="edit_appointment.php" method="POST">';
                  echo '<input type="hidden" name="appointment_id" value="' . $change_row['id'] . '">';
                  echo 'New Date: <input type="date" name="new_date" value="' . htmlspecialchars($change_row['date']) . '" required>';
                  echo 'New Time: <input type="time" name="new_time" value="' . htmlspecialchars($change_row['time']) . '" required>';
                  echo '<button type="submit">Update</button>';
                  echo '</form>';
              } else {
                  echo "<p>Error fetching appointment details.</p>";
              }
          }
          // Handle update request
          if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_date
              ']) && isset($_POST['new_time'])) {
              $new_date = $_POST['new_date'];
              $new_time = $_POST['new_time'];
              $appointment_id = $_POST['appointment_id'];
              $update_sql = "UPDATE appointments SET date='$new_date', time='$new_time' WHERE id='$appointment_id'";
              if (mysqli_query($conn, $update_sql)) {
                  echo "<p>Appointment updated successfully.</p>";
              } else {
                  echo "<p>Error updating appointment: " . mysqli_error($conn) . "</p>";
              }
              // Redirect to avoid resubmission
              header("Location: edit_appointment.php");
              exit();
          }
          ?>
        </form>
      <?php } else { echo '—'; } ?>
    </td>
  </tr>
<?php } ?>
</table>
</body>
</html>