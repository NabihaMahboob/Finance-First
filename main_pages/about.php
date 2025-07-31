<?php
// Include the database connection file
include '../database/db_connection.php';
    
// Start the session to manage user state and theme
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

    



    

</body>
</html>