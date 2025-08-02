
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
    <title>Finance First Careers</title>
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

    <!-- Displays career page information -->
    <h1>Careers</h1>
    <div class="careers-about">
        <img src="../media/careersImage.jpg"></img>
        <div class="careers-about-text">
        <p>At Finance First, we are always looking for passionate individuals to join our team.
        If you are interested in a career with us, please send your resume and cover letter to careers@financefirst.ca.
        We are currently hiring for the following positions:</p>    
        <p>We offer competitive salaries, benefits, and a positive work environment.
        If you are interested in any of these positions, please apply today!</p>
        <p>Thank you for your interest in Finance First. We look forward to hearing from you!</p>
        </div>
    </div>

    <div class="careers-info">
        <h2>Why Work With Us?</h2>
        <p>We are committed to creating a diverse and inclusive workplace where everyone can thrive.
        Our team is made up of individuals from various backgrounds and experiences, and we believe that this diversity
        is what makes us strong. We value innovation, collaboration, and a passion for helping others.</p>
        <p>If you share our values and are excited about the opportunity to make a difference in people's financial lives,
        we encourage you to apply!</p>
    </div>  

    <div class="current-openings">
        <h2>Current Openings</h2>
        <ul>
            <li><strong>Financial Advisor:</strong> Help clients achieve their financial goals through personalized advice and planning.</li>
            <li><strong>Content Writer:</strong> Create engaging and informative content for our website and social media platforms.</li>
            <li><strong>Software Developer:</strong> Develop and maintain our web applications to enhance user experience.</li>
            <li><strong>Community Manager:</strong> Foster a supportive online community and engage with users across our platforms.</li>
        </ul>
        <p>If you are interested in any of these positions, please send your resume and cover letter to <a href="mailto:careers@financefirst.ca">careers@financefirst.ca</a>
        </p>
    </div>

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