
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

    <h1>Careers</h1>
    <p>At Finance First, we are always looking for passionate individuals to join our team.
    If you are interested in a career with us, please send your resume and cover letter to careers@financefirst.ca.
    We are currently hiring for the following positions:</p>    
    <p>We offer competitive salaries, benefits, and a positive work environment.
    If you are interested in any of these positions, please apply today!</p>
    <p>Thank you for your interest in Finance First. We look forward to hearing from you!</p>

    <div class="careers-info">
        <h2>Why Work With Us?</h2>
        <p>We are committed to creating a diverse and inclusive workplace where everyone can thrive.
        Our team is made up of individuals from various backgrounds and experiences, and we believe that this diversity
        is what makes us strong. We value innovation, collaboration, and a passion for helping others.</p>
        <p>If you share our values and are excited about the opportunity to make a difference in people's financial lives,
        we encourage you to apply!</p>
    </div>  

    <div>
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
    
    



    </body>
    </html>