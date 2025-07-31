<?php
session_start();
include '../database/db_connection.php';

if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}
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
                    <a href="#">Link 3</a>
                </div>
            </div>
            <a href="appointment.php">Appointment</a>
            <a href="forums_logged_in.php">Forums</a>
            <a href="Shop.php">Shop</a>
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
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
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
  </script>
</div>
<!-- TradingView Widget END -->


<?php

$sql = "SELECT * FROM external_articles ORDER BY added_on DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

echo "<div class='investment-articles'>";
echo "<h2>Recommended Investment Reads</h2>";

while ($row = mysqli_fetch_assoc($result)) {
  echo "<div class='article'>";
  echo "<a href='{$row['url']}' target='_blank'>{$row['title']}</a>";
  echo "<p><em>Source: {$row['source']}</em></p>";
  echo "</div>";
}

echo "</div>";

?>
</body>
</html>