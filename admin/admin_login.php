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

// Show logout success message if redirected from logout
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    $message = "You have been logged out successfully!";
    $toastClass = "success-toast";
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Checks if email or password is empty
    if (empty($email) || empty($password)) {
        $message = "Email and password are required.";
        $toastClass = "error-toast";
    }else{
        // Prepare SQL statement to fetch user by email
        $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, role FROM userdata WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows == 1) {
            // Prevent user login from admin page
            $user = $result->fetch_assoc();
            if($user['role'] == 'user'){
                $message = "Please log in from the user page";
                $toastClass = "error-toast";
            }
            // Verify the password
            elseif (password_verify($password, $user['password'])) {
                $message = "Login successful";
                $toastClass = "success-toast";
                // Set session variables for logged-in user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_first_name'] = $user['first_name'];
                $_SESSION['user_last_name'] = $user['last_name'];
                // Redirect to dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                // Invalid password
                $message = "Invalid email or password.";
                $toastClass = "error-toast";
        }
        } else {
            // No user found with that email
            $message = "No account found with that email.";
            $toastClass = "error-toast";
        }
    $stmt->close();
}
    $conn->close();
    
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
        
        <a href="../main_pages/index.php">Home</a>
        <a href="../main_pages/careers.php">Careers</a>
        <a href="../main_pages/about.php">About</a>
        <a href="../main_pages/forums.php">Forums</a>
        <a href="../main_pages/contact.php">Contact</a>
        </div>
        <div>
            <a href="../account_login/register.php">Register</a>
            <a href="../account_login/login.php">Login</a>
        </div>

    </nav>


        <h1>Welcome Back</h1>
        <h2>Admin Account Login</h2>

        <!-- Displays error or succes message -->
        <?php if ($message): ?>
            <div class="<?php echo $toastClass; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <!-- Admin Login -->
        <form action="admin_login.php" method="post">
        <p>Email:</p>
        <input type="text" name="email" placeholder="Enter your email">
        <p>Password:</p>
        <input type="password" name="password" placeholder="Enter your password">
        <br></br>
        <button type="submit">Login</button>
        <p>Have a User Account? <a href = "../main_pages/login.php">Login Here
        </a></p>
        </form>   

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