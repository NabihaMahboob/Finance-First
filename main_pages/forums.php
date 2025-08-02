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

    <h1>Forums</h1>
    <h2>Join the discussion and connect with others</h2>
    <p>Welcome to the Finance First forums! Here you can share your thoughts, ask questions, and connect with others in the community.</p>
    <p>Feel free to start a new topic or join an existing discussion.</p>       

    <p><a href="../account_login/login.php">Login</a> to create a Forum Post</p>    
    <?php

    // Gets forum post from database and displays it 
    $sql = "SELECT * FROM forums ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='forum_post'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<p>Posted by: " . htmlspecialchars($row['first_name']) . " on " . date("F j, Y, g:i a", strtotime($row['created_at'])) . "</p>";
            echo "<p>Likes: " . $row['likes'] . "</p>";
            echo "</div>";
            }
    } else {
        echo "<p>No forums available. Be the first to start a discussion!</p>";
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