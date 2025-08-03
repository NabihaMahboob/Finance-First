<?php
// Include the database connection file
include '../database/db_connection.php';

// Start the session
session_start();

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

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $role = $_POST['role'] ?? 'user';

    $checkEmailStmt = $conn->prepare("SELECT email FROM userdata WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    // Check if an account already exists with this email
    if ($checkEmailStmt->num_rows > 0) {
        $message = "Email already exists. Please use a different email.";
        $toastClass = "error-toast";
    // Check if any fields are empty
    } elseif (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $message = "All fields are required.";
        $toastClass = "error-toast";
    // Check if the email is valid
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        $toastClass = "error-toast";
    // Check if the password length is greater than 5
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters long.";
        $toastClass = "error-toast";
    // Check if the password meets requirement
    } elseif (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $message = "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
        $toastClass = "error-toast";
    // Checks first and last name minimum length
    } elseif (strlen($firstName) < 2 || strlen($lastName) < 2) {
        $message = "First name and last name must be at least 2 characters long.";
        $toastClass = "error-toast";
    // Checks first and last name maximum length
    } elseif (strlen($firstName) > 50 || strlen($lastName) > 50) {
        $message = "First name and last name must not exceed 50 characters.";
        $toastClass = "error-toast";
    // Checks email maximum length
    } elseif (strlen($email) > 100) {
        $message = "Email must not exceed 100 characters.";
        $toastClass = "error-toast";
    // Checks password maximum length
    } elseif (strlen($password) > 255) {
        $message = "Password must not exceed 255 characters.";
        $toastClass = "error-toast";
    // Checks confirm password maximum length
    } elseif (strlen($confirmPassword) > 255) {
        $message = "Confirm password must not exceed 255 characters.";
        $toastClass = "error-toast";
    // Checks if password and confirm password matches
    } elseif ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
        $toastClass = "error-toast";
    // Checks the type of role
    } elseif (!in_array($role, ['user', 'admin'])) {
        $message = "Invalid account type selected.";
        $toastClass = "error-toast";
    } else {
        // Insert the user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertStmt = $conn->prepare("INSERT INTO userdata (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $insertStmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $role);
        
        // Error registering
        if (!$insertStmt->execute()) {
            $message = "Error registering user: " . $insertStmt->error;
            $toastClass = "error-toast";
        } else {
            // Registration successful
            $message = "Registration successful!";
            $toastClass = "success-toast";
            $newUserId = $insertStmt->insert_id;
            // Set session variables for logged-in user
            $_SESSION['user_id'] = $newUserId;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $firstName . ' ' . $lastName;
            $_SESSION['user_role'] = $role;
            $_SESSION['user_first_name'] = $firstName;
            $_SESSION['user_last_name'] = $lastName;
            // Redirect to dashboard
            header("Location: ../dashboard/dashboard.php");
            exit();
        }
        $insertStmt->close();
        
    }
    $checkEmailStmt->close();
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
    <!-- Nav Bar-->
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
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        </div>

    </nav>

    <!-- Displays error or succes message -->
    <?php if (!empty($message)): ?>
        <div class="<?php echo $toastClass; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    
        <!-- Forum post form-->
        <form method="post" action="">
        <h1>Register</h1>
        <p>First Name</p>
        <input type="text" name="first_name" placeholder="Enter your first name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required>
        <p>Last Name</p>
        <input type="text" name="last_name" placeholder="Enter your last name" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" required>
        <p>Email:</p>
        <input type="text" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
        <p>Password:</p>
        <input type="password" name="password" placeholder="Enter your password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
        <p>Confirm Password:</p>
        <input type="password" name="confirm_password" placeholder="Confirm your password">
        <br></br>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="login.php">Login</a></p>
        <p>By registering, you agree to our <a href="terms.php" target="_blank">Terms of Service</a> and <a href="privacy.php" target="_blank">Privacy Policy</a>.</p>
        <p>Need help? <a href="../main_pages/contact.php">Contact us</a></p>
        
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