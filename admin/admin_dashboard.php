<?php
session_start();

// Check if the user is logged in, if
// not then redirect them to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
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

    <h2>Welcome to the Admin Dashboard</h2>
    <p>Here you can manage users, view requests, and access other administrative functions.</p>
    <p>Use the navigation links above to access different sections of the admin panel.</p>
    <p>For any assistance, please contact support.</p>   
    <form method="POST" action="" class="theme-selector">
        <select name="theme" onchange="this.form.submit()">
        <option value="style" <?= ($theme == 'style') ? 'selected' : '' ?>>Default</option>
        <option value="night-mode" <?= ($theme == 'night-mode') ? 'selected' : '' ?>>Night Mode</option>
        <option value="pink" <?= ($theme == 'pink') ? 'selected' : '' ?>>Pink</option>
        </select>
        </form> 
</body>
</html>