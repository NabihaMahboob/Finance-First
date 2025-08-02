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

// Initialize message and toast class for notifications
$message = "";
$toastClass = "";

// Check if the user is logged in, if
// not then redirect them to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$userid = $_SESSION['user_id'] ?? null;
$firstName = $_SESSION['user_first_name'] ?? 'User';
if (empty($userid)) {
    $message = "Error: Please log in again.!";
    $toastClass = "error-toast";    
    header("Location: login.php");
    exit();
}  

if (isset($_POST['delete_id'])) {
    $deleteId = (int)$_POST['delete_id'];

    $deleteSql = "DELETE FROM forums WHERE post_id = $deleteId";
    if (mysqli_query($conn, $deleteSql)) {
        $message = "Forum post deleted successfully.";
        $toastClass = "success-toast";
    } else {
        $message = "Error deleting post: " . mysqli_error($conn);
        $toastClass = "error-toast";
    }
}
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
        <a href="admin_dashboard.php">Admin Dashboard</a>
        <a href="requests.php">Requests</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="edit_forum.php">Edit Forum</a>
        <a href="change_shop.php">Edit Shop</a>
        </div>

        <div>
            <a href="../main_pages/logout.php">Logout</a>  
        </div>
    </nav>

    <h2>Welcome to the Edit Forum Page</h2>
    <img src="../media/adminForum.jpg" class="adminForumImage"> </src>
    <p>Here you can create and manage forums for discussions.</p>
    <p>Use the navigation links above to access different sections of the admin panel.</p>
    <p>For any assistance, please contact support.</p>
    <p>To add a new forum, please fill out the form below.</p>
    
     <?php if ($message): ?>
            <div class="<?php echo $toastClass; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <!-- Form to add forum -->
    <form action="edit_forum.php" method="post">
        <p>Forum Title:</p>
        <input type="text" name="forum_title" required>
        <p>Forum Description:</p>   
        <textarea name="forum_description" required></textarea>
        <br>
        <input type="submit" value="Add Forum">
    </form> 

    <?php

    $sql = "SELECT * FROM forums ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display forum post
            echo "<div class='forum_post'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<p>Posted by: " . htmlspecialchars($row['first_name']) . " on " . date("F j, Y, g:i a", strtotime($row['created_at'])) . "</p>";
            echo "<p>Likes: " . $row['likes'] . "</p>";
            
            // Delete button
            echo "<form class='delete_forum' method='post' onsubmit=\"return confirm('Are you sure you want to delete this post?');\">";
            echo "<input type='hidden' name='delete_id' value='" . $row['post_id'] . "'>";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";

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