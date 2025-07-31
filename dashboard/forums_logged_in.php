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
    <h1>Forums</h1>
    <h2>Join the discussion and connect with others</h2>
    <p>Welcome to the Finance First forums! Here you can share your thoughts, ask questions, and connect with others in the community.</p>
    <p>Feel free to start a new topic or join an existing discussion.</p>

    <button onclick="window.location.href='add_forum.php'" class="add_forum_button">Add New Forum</button>
    
    <?php

$sql = "SELECT * FROM forums ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='forum_post'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p>Posted by: " . htmlspecialchars($row['first_name']) . " on " . date("F j, Y, g:i a", strtotime($row['created_at'])) . "</p>";
        echo "<p>Likes: " . $row['likes'] . "</p>";
        echo "<button class='like_button' data-forum-id='" . $row['user_id'] . "'>Like</button>";
        echo "</div>";
    }
} else {
    echo "<p>No forums available. Be the first to start a discussion!</p>";
}   
?>
    



</body>
</html>