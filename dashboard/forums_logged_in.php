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

    <h1>Forums</h1>
    <img class="forumLoggedInImage" src="../media/forumLoggedIn.jpg"></img>
    <h2>Join the discussion and connect with others</h2>
    <p>Welcome to the Finance First forums! Here you can share your thoughts, ask questions, and connect with others in the community.</p>
    <p>Feel free to start a new topic or join an existing discussion.</p>
    <!-- Leads to add forum page -->
    <button onclick="window.location.href='add_forum.php'" class="add_forum_button">Add New Forum</button>
    
    <?php

    $sql = "SELECT * FROM forums ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // Displays all forum posts
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='forum_post'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<p>Posted by: " . htmlspecialchars($row['first_name']) . " on " . date("F j, Y, g:i a", strtotime($row['created_at'])) . "</p>";
            echo "<p>Likes: " . $row['likes'] . "</p>";
            echo "<button class='like_button' data-forum-id='" . $row['user_id'] . "'>❤️</button>";
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