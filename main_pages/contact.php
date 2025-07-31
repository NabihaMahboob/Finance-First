<?php
include '../database/db_connection.php';
    
session_start();
if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}
$theme = $_SESSION['theme'] ?? 'style';
$cssFile = match ($theme) {
    'night-mode' => 'night-mode.css',
    'pink' => 'pink.css',
    default => 'style.css',
};
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>title</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/<?= htmlspecialchars($cssFile) ?>">
    <meta name="description" content="Affordable financial help for everyone.">
    <meta name="keywords" content="Finance, Budgeting, Investing, Help">
</head>


<body>
    <nav class="nav-bar">
        <div>
            <h1>Finance First</h1>
        </div>

        <div>
        
        <a class="dropbtn" href="index.php">Home</a>
        <a href="careers.php">Careers</a>
        <a href="about.php">About</a>
        <a href="forums.php">Forums</a>
        <a href="contact.php">Contact</a>
        </div>
        <div>
            <a href="../account_login/register.php">Register</a>
            <a href="../account_login/login.php">Login</a>
        </div>

    </nav>

    <h1>Contact Us</h1>

    <h2>Get your Free Consulation Today</h2>\
    <p>We are here to help you. Please fill out the form below to get in touch with us.</p>
    <form action="contact.php" method="post">
        <p>Name:</p>
        <input type="text" name="name" placeholder="Enter your name" required>
        <p>Email:</p>
        <input type="email" name="email" placeholder="Enter your email" required>
        <p>Message:</p>
        <textarea name="message" placeholder="Enter your message" required></textarea>
        <br><br>
        <input type="submit" value="Send Message">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '../database/db_connection.php';
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $sql = "INSERT INTO contact_requests (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $sql)) {
            echo "<div class='success-toast'>Your message has been sent successfully!</div>";
        } else {
            echo "<div class='error-toast'>Error: " . mysqli_error($conn) . "</div>";
        }
        mysqli_close($conn);
    }
    ?>

    <?php

$sql = "SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  echo '<div class="testimonials">';
  echo '<h2>What Our Users Are Saying</h2>';

  while ($row = mysqli_fetch_assoc($result)) {
    $stars = str_repeat("⭐", $row['rating']);
    echo "
      <div class='testimonial-card'>
        <p class='quote'>“{$row['comment']}”</p>
        <p class='user'>— {$row['name']}</p>
        <p class='rating'>{$stars}</p>
      </div>
    ";
  }

  echo '</div>';
}
?>
    <footer>
        <p>&copy; 2025 Finance First. All rights reserved.</p>
        <p><a href="privacy.php">Privacy Policy</a> | <a href="terms.php">Terms of Service</a></p>
    </footer>


</body>
</html>