<?php
// Include the database connection file
include '../database/db_connection.php';
    
// Start the session
session_start();

// Handle theme selection from POST request and store in session
if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}

// Determine which theme to use, default to 'style'
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
    <title>Finance First About US</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/<?= htmlspecialchars($cssFile) ?>">
    <meta name="description" content="Affordable financial help for everyone. Learn more about what we do.">
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

    <!-- Displays about page content -->
    <div class="about-content">
    <h1>About Us</h1>
    <p>Finance First is a platform created by financial experts to help you manage your finances.
    It provides tools and resources to help you budget, save, and invest wisely 
    while also offering a community for support and advice. We provide many products and services including courses and book
    to assist you with your financial goals. We 
    believe that everyone should have access to financial education and resources,
    and our goal is to empower individuals to take control of their financial future.</p>
    <p>Our team is dedicated to providing the best possible experience for our users,
    and we are constantly working to improve our platform. We value your feedback and
    encourage you to reach out with any questions or suggestions. Thank you for choosing Finance!
    </p>
    </div>


    <div class="principles">
    <h2>Our 5 Principles</h2>
    <ul>
        <li>Financial Education: We provide resources to help you understand financial concepts.</li>
        <li>Community Support: Join discussions and connect with others on similar financial journeys.</li>
        <li>Personalized Guidance: Get tailored advice to meet your unique financial needs.</li>
        <li>Tools and Resources: Access budgeting tools, investment strategies, and more.</li>
        <li>Continuous Improvement: We are committed to enhancing our platform based on user feedback.</li>
    </ul>
    </div>

    <div class="leadership">
    <h2>Leadership</h2>
    <p>Our leadership team consists of experienced financial professionals who are passionate about helping others
    achieve financial success. They bring a wealth of knowledge and expertise to the platform, ensuring that our 
    users receive the best possible guidance and support.</p>   
    <p>We are proud to have a diverse team that reflects our commitment to inclusivity and understanding the 
    financial needs of all individuals. Together, we strive to create a platform that empowers everyone to take 
    control of their financial future.</p>
    <p>Thank you for being a part of our community. We look forward to supporting you on your financial journey!</p>
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