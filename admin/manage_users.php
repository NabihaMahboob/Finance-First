<?php

// Start the session
session_start();

// Include database connection
include '../database/db_connection.php';

// Initialize message and toast class for notifications
$message = "";
$toastClass = "";

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if (!in_array($role, ['user', 'admin'])) {
        $role = 'user'; 
    }

    $sql = "INSERT INTO userdata (first_name, last_name, email, password, role) 
            VALUES ('$first_name', '$last_name', '$email', '$hashedPassword', '$role')";

    if (mysqli_query($conn, $sql)) {
        $message = "User added successfully";
        $toastClass = "success-toast";
    } else {
        $message = "User could not be added.";
        $toastClass = "error-toast";
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if (mysqli_query($conn, "DELETE FROM userdata WHERE id = $id")) {
        $message = "User deleted successfully";
        $toastClass = "success-toast";
    } else {
        $message = "User could not be deleted.";
        $toastClass = "error-toast";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $id = intval($_POST['id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE userdata SET 
            first_name = '$first_name',
            last_name = '$last_name',
            email = '$email',
            password = '$hashedPassword',
            role = '$role'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        $message = "User edited successfully";
        $toastClass = "success-toast";    
    } else {
        $message = "User could not be edited.";
        $toastClass = "error-toast";
    }
}

$result = mysqli_query($conn, "SELECT * FROM userdata ORDER BY first_name ASC");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Manage Users</title>
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

    <h2>Welcome to the User Management Page</h2>
    <p>Here you can view and manage user accounts.</p>
    <p>Use the navigation links above to access different sections of the admin panel.</p>
    <p>For any assistance, please contact support.</p>
    <p>To view user details, please select from the options provided below.</p>


        <!-- Displays error or succes message -->
    <?php if (!empty($message)): ?>
        <div class="<?php echo $toastClass; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="manage_users.php">
        <h2>Add User</h2>
        <input type="text" name="first_name" placeholder="First name" required>
        <input type="text" name="last_name" placeholder="Last name" required>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
        </select>
        <br></br>
        <input type="submit" name="add_user" value="Add User">
        </form>



    <h2>Existing Users</h2>
    <div class="edit-users-list">
    <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <!-- Editable forms with each product -->
         <div class="edit-user">
        <form method="POST" class="edit-user-form">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <label>First Name:</label><br>
            <input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>" required><br>

            <label>Last Name:</label><br>
            <input type="text" name="last_name" value="<?= htmlspecialchars($row['last_name']) ?>" required><br>

            <label>Email:</label><br>
            <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required><br>

            <label>Password:</label><br>
            <input type="password" name="password" placeholder="Enter a new password" value="<?= htmlspecialchars($row['password']) ?>" required><br>
            <small>Note: Password will be encrypted when saved</small><br>

            <label>Account Type:</label><br>
                <select name="role" required>
                <option value="user" <?= ($row['role'] ?? 'user') === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= ($row['role'] ?? 'user') === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select><br><br>

            <button type="submit" name="update_user">Update</button>
            <a href="manage_users.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
        </form>
    </div>
    <?php endwhile; ?> 
    </div>

     <?php else: ?>
        <p>No users found in the database.</p>
    <?php endif; ?>
    


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
        <li><a href="../wiki/admin_wiki.php" target="_blank">Admin</a></li>
    </ul>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d184552.67410029974!2d-79.5428651034961!3d43.71812280463856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d4cb90d7c63ba5%3A0x323555502ab4c477!2sToronto%2C%20ON!5e0!3m2!1sen!2sca!4v1753924038204!5m2!1sen!2sca" 
            width="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <p>&copy; 2025 Finance First. All rights reserved.</p>

        

    </footer>

    </body>

</html>