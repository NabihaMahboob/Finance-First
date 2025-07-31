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
        <a href="admin_dashboard.php">Admin Dashboard</a>
        <a href="requests.php">Requests</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="edit_forum.php">Add Forum</a>
        <a href="change_shop.php">Edit Shop</a>
        </div>

        <div>
            <a href="../main_pages/logout.php">Logout</a>  
        </div>
    </nav>

    <h2>Welcome to the Add Forum Page</h2>
    <p>Here you can create and manage forums for discussions.</p>
    <p>Use the navigation links above to access different sections of the admin panel.</p>
    <p>For any assistance, please contact support.</p>
    <p>To add a new forum, please fill out the form below.</p>

    <?php   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $forumTitle = mysqli_real_escape_string($conn, $_POST['forum_title']);
        $forumDescription = mysqli_real_escape_string($conn, $_POST['forum_description']);

        $sql = "INSERT INTO forums (user_id, first_name, title, description, created_at, updated_at, likes, is_deleted) 
        VALUES ('$userid', '$firstName', '$forumTitle', '$forumDescription', NOW(), NOW(), 0, 0)";        
        if (mysqli_query($conn, $sql)) {
            $message = "Forum added successfully!";
            $toastClass = "success-toast";    
        } else {
            $message = "Error adding forum: " . mysqli_error($conn);
            $toastClass = "error-toast";
        }
        
    }
    ?>

     <?php if ($message): ?>
            <div class="<?php echo $toastClass; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>
    <form action="edit_forum.php" method="post">
        <p>Forum Title:</p>
        <input type="text" name="forum_title" required>
        <p>Forum Description:</p>   
        <textarea name="forum_description" required></textarea>
        <br>
        <input type="submit" value="Add Forum">
    </form> 
    
    
</body>
</html>