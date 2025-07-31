<?php
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
    <form method="POST" action="" class="theme-selector">
        <select name="theme" onchange="this.form.submit()">
        <option value="style" <?= ($theme == 'style') ? 'selected' : '' ?>>Default</option>
        <option value="night-mode" <?= ($theme == 'night-mode') ? 'selected' : '' ?>>Night Mode</option>
        <option value="pink" <?= ($theme == 'pink') ? 'selected' : '' ?>>Pink</option>
        </select>
        </form>
    <h1>Welcome to Your Dashboard</h1>
    <p>Here you can manage your appointments, view forums, and more.</p>

    <video autoplay muted loop class="welcome-video">
        <source src="../media/user-welcome.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

 
</body>
</html>