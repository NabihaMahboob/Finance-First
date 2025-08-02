<?php

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

// Check if the user is logged in, if
// not then redirect them to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userName = $_SESSION['user_name'] ?? 'User';
$userEmail = $_SESSION['user_email'] ?? '';
$userRole = $_SESSION['user_role'] ?? 'user';
$firstName = $_SESSION['user_first_name'] ?? 'User';


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
    <!-- Nav Bar -->
    <nav class="nav-bar">
        <div>
            <h1>Finance First</h1>
        </div>

        <div>
            <div class="dropdown">
                
                <a class="dropbtn" href="dashboard.php">Dashboard</a>
                <i class="fa fa-caret-down"></i> 
                
                <div class="dropdown-content">
                    <a href="investment.php">Investment</a>
                    <a href="budget.php">Budget</a>
                </div>
            </div>
            <a href="appointment.php">Appointment</a>
            <a href="forums_logged_in.php">Forums</a>
            <a href="shop.php">Shop</a>
        </div>

        <div>
            <span>Welcome, <?php echo htmlspecialchars($firstName); ?>!</span>
            <a href="../main_pages/logout.php">Logout</a>  
        </div>
    </nav>

    <!-- Form to select theme -->
    <form method="POST" action="" class="theme-selector">
        <select name="theme" onchange="this.form.submit()">
        <option value="style" <?= ($theme == 'style') ? 'selected' : '' ?>>Default</option>
        <option value="night-mode" <?= ($theme == 'night-mode') ? 'selected' : '' ?>>Night Mode</option>
        <option value="pink" <?= ($theme == 'pink') ? 'selected' : '' ?>>Pink</option>
        </select>
        </form>
    <h1>Welcome to Your Dashboard</h1>
    <p>Here you can manage your appointments, view forums, and more.</p>

    <!-- Welcome video -->
    <video autoplay muted loop class="welcome-video">
        <source src="../media/user-welcome.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

 

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