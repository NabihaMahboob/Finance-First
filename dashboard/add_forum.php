<?php
session_start();
include '../database/db_connection.php';
$message = "";
$toastClass = "";


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

    <?php   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $forumTitle = mysqli_real_escape_string($conn, $_POST['forum_title']);
        $forumDescription = mysqli_real_escape_string($conn, $_POST['forum_description']);

        $sql = "INSERT INTO forums (user_id, first_name, title, description, created_at, updated_at, likes, is_deleted) 
        VALUES ('$userid', '$firstName', '$forumTitle', '$forumDescription', NOW(), NOW(), 0, 0)";        
        if (mysqli_query($conn, $sql)) {
            $message = "Forum added successfully!";
            $toastClass = "success-toast";    
            head("Location: forums_logged_in.php");
            exit();
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
    <form action="add_forum.php" method="post">
        <p>Forum Title:</p>
        <input type="text" name="forum_title" required>
        <p>Forum Description:</p>   
        <textarea name="forum_description" required></textarea>
        <br>
        <input type="submit" value="Add Forum" >
    </form> 
    
    

    
    

</body>
</html>