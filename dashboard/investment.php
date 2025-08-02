<?php

// Start the session
session_start();

// Include the database connection file
include '../database/db_connection.php';

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

// Sets session information
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <h1>Learn About Investments</h1>
    <p>Here you can find resources and tools to help you make informed investment decisions.</p>
    <p>Use the navigation links above to access different sections of your dashboard.</p>
    <p>For any assistance, please contact support.</p>

    
<!-- TradingView Widget BEGIN -->
<div class="investment_chart">
  <div class="investment_chart_widget"></div>
  <div class="investment_chart_copyright"><a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/?exchange=NASDAQ" rel="noopener nofollow" target="_blank"><span class="blue-text">Stock Chart by TradingView</span></a></div>
  <script src="../scripts/script.js"></script>
  <!--<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
    {
    "allow_symbol_change": true,
    "calendar": false,
    "details": false,
    "hide_side_toolbar": true,
    "hide_top_toolbar": false,
    "hide_legend": false,
    "hide_volume": false,
    "hotlist": false,
    "interval": "D",
    "locale": "en",
    "save_image": true,
    "style": "1",
    "symbol": "NASDAQ:AAPL",
    "theme": "light",
    "timezone": "Etc/UTC",
    "backgroundColor": "#ffffff",
    "gridColor": "rgba(46, 46, 46, 0.06)",
    "watchlist": [],
    "withdateranges": false,
    "compareSymbols": [],
    "studies": [],
  "autosize": true
}
  </script>-->
</div>
<!-- TradingView Widget END -->


<?php


$sql = "SELECT * FROM external_articles ORDER BY added_on DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

echo "<div class='investment-articles'>";
echo "<h2>Recommended Investment Reads</h2>";
// Displays articles from database
while ($row = mysqli_fetch_assoc($result)) {
  echo "<div class='article'>";
  echo "<a href='{$row['url']}' target='_blank'>{$row['title']}</a>";
  echo "<p><em>Source: {$row['source']}</em></p>";
  echo "</div>";
}

echo "</div>";

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