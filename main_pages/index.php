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
    <title>Finance First</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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

        <form method="POST" action="" class="theme-selector">
        <select name="theme" onchange="this.form.submit()">
        <option value="style" <?= ($theme == 'style') ? 'selected' : '' ?>>Default</option>
        <option value="night-mode" <?= ($theme == 'night-mode') ? 'selected' : '' ?>>Night Mode</option>
        <option value="pink" <?= ($theme == 'pink') ? 'selected' : '' ?>>Pink</option>
        </select>
        </form>

        <div class="home-header">
            <div class="home-intro">
                <h1>Take Control of Your Financial Future</h1>
                <p>At Finance First, we believe that everyone deserves access to the tools and resources needed to achieve
                financial success. Our platform is designed to provide you with the knowledge and support you need to
                make informed financial decisions.</p>
                <div class="home-buttons">
                <a href="register.php" class="get-started">Get Started Now! <i class="material-icons md-18">arrow_forward</i></a>  
                <a href="about.php" class="learn-more">Learn More</a> 
                </div>
            
            </div>



            <div class="home-info">
            <p>Welcome to Finance First, your go-to platform for financial education and resources.
            We are dedicated to helping you manage your finances effectively, whether you're budgeting, saving, or investing.
            Our community is here to support you every step of the way.</p>
            <p>Explore our tools, join discussions in our forums, and connect with others who share your financial goals.
            Together, we can empower each other to achieve financial success.</p>
            <p>Join us today and take the first step towards a brighter financial future!</p>
            </div>

        </div>

        <div>
            <h2>Why Join?</h2>
            <iframe src="https://www.youtube.com/embed/iVjuM1c_ZW0?si=502yBBqwBrXeas44" class="importance-video" title="YouTube video player" 
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

        <div class="services">
            <h2>Our Sevices</h2>
            <div class="services-list">
                <div class="debt-consolidation">
                <i class="material-icons md-18">payments</i>
                <h3>Debt consolidation solutions</h3>
                <p>We offer personalized debt consolidation plans to help you manage and reduce your debt effectively.</p>
                </div>

                <div class="financial-planning">
                <i class="material-icons md-18">account_balance_wallet</i>
                <h3>Personalized financial planning guidance</h3>
                <p>Our financial experts provide tailored advice to help you create a solid financial plan.</p>
                </div>

                <div class="financial-tools">
                <i class="material-icons md-18">handyman</i>
                <h3>Budgeting tools and resources</h3>
                <p>Access a variety of budgeting tools to help you track your expenses and save more effectively.</p>
                </div>

                <div class="investment-advice">
                <i class="material-icons md-18">trending_up</i>
                <h3>Investment advice and strategies</h3>
                <p>Get expert insights on investment opportunities and strategies to grow your wealth.</p>
                </div>

                <div class="credit-score">
                <i class="material-icons md-18">credit_score</i>
                <h3>Resources for improving credit scores</h3>
                <p>Learn how to improve your credit score with our comprehensive resources and tips.</p>
                </div>

                <div class="financial-education">
                <i class="material-icons md-18">school</i>
                <h3>Community forums for discussion and support</h3>
                <p>Join our community forums to discuss financial topics, share experiences, and get support from others.</p>
                </div>

                <div class="expert-assistance">
                <i class="material-icons md-18">support_agent</i>
                <h3>Access to financial experts for personalized assistance</h3>
                <p>Connect with financial experts who can provide personalized assistance and answer your questions.</p>
                </div>

                <div class="newsletters">
                <i class="material-icons md-18">article</i>
                <h3>Regular updates and newsletters with financial tips</h3>
                <p>Subscribe to our newsletters for regular updates and tips on managing your finances.</p>
                </div>

                <div class="workshops">
                <i class="material-icons md-18">computer</i>
                <h3>Workshops and webinars on financial topics</h3>
                <p>Participate in our workshops and webinars to learn more about various financial topics.</p>
                </div>
            </div>
        </div>
        

</body>

<footer>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d184552.67410029974!2d-79.5428651034961!3d43.71812280463856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d4cb90d7c63ba5%3A0x323555502ab4c477!2sToronto%2C%20ON!5e0!3m2!1sen!2sca!4v1753924038204!5m2!1sen!2sca" 
            width="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <p>&copy; 2025 Finance First. All rights reserved.</p>
        

    </footer>
</html>

