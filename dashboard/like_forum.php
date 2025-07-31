<?php
session_start();
include '../database/db_connection.php';
$message = "";
$toastClass = "";   
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


if (!isset($_GET['forum_id']) || !is_numeric($_GET['forum_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid forum ID']);
    exit();
}
$forumId = intval($_GET['forum_id']);
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


</body>
</html> 


    