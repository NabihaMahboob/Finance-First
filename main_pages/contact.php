<?php

// Include the database connection file
include '../database/db_connection.php';
    
// Start the session
session_start();

// Handle theme selection from POST request and store in session
if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}

// Set theme and corresponding CSS file
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
    <!-- Nav Bar -->
    <nav class="nav-bar">
        <div>
            <h1>Finance First</h1>
        </div>

        <div>
        
        <a href="index.php">Home</a>
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

    <h2>Get your Free Consulation Today</h2>
    <p>We are here to help you. Please fill out the form below to get in touch with us.</p>
    <!-- Contact form -->
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
    // Adds the contact request to the database
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

// Gets testimonials from the database
$sql = "SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Displays each testimonial
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
    <!-- Footer -->
<footer class="footer">
    <div class="footer-div">
    <ul class="socials">
        <span>Socials</span>
        <li><a href="https://www.linkedin.com/financefirst">LinkedIn</a></li>
        <li><a href="https://www.facebook.com/financefirst">Facebook</a></li>
        <li><a href="https://www.instagram.com/financefirst">Instagram</a></li>
        <li><a href="https://www.tiktok.com/financefirst">Tiktok</a></li>
    </ul>
    
    <ul class="wiki-pages">
        <span>Wiki Pages</span>
        <li><a href="../wiki/register_wiki.php" target="_blank">Login and Registration</a></li>
        <li><a href="../wiki/appointment_wiki.php" target="_blank">Appointments</a></li>
        <li><a href="../wiki/forum_wiki.php" target="_blank">Forums</a></li>
        <li><a href="../wiki/budget_wiki.php" target="_blank">Budget</a></li>
        <li><a href="../wiki/theme_wiki.php" target="_blank">Theme</a></li>
    </ul>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d184552.67410029974!2d-79.5428651034961!3d43.71812280463856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d4cb90d7c63ba5%3A0x323555502ab4c477!2sToronto%2C%20ON!5e0!3m2!1sen!2sca!4v1753924038204!5m2!1sen!2sca" 
            width="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <p>&copy; 2025 Finance First. All rights reserved.</p>

        

    </footer>


</body>
</html>