<?php
include '../database/db_connection.php';

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

$message = "";
$toastClass = "";

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

    if ($checkEmailStmt->num_rows > 0) {
        $message = "Email already exists. Please use a different email.";
        $toastClass = "error-toast";
    } elseif (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $message = "All fields are required.";
        $toastClass = "error-toast";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        $toastClass = "error-toast";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters long.";
        $toastClass = "error-toast";
    } elseif (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $message = "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
        $toastClass = "error-toast";
    } elseif (strlen($firstName) < 2 || strlen($lastName) < 2) {
        $message = "First name and last name must be at least 2 characters long.";
        $toastClass = "error-toast";
    } elseif (strlen($firstName) > 50 || strlen($lastName) > 50) {
        $message = "First name and last name must not exceed 50 characters.";
        $toastClass = "error-toast";
    } elseif (strlen($email) > 100) {
        $message = "Email must not exceed 100 characters.";
        $toastClass = "error-toast";
    } elseif (strlen($password) > 255) {
        $message = "Password must not exceed 255 characters.";
        $toastClass = "error-toast";
    } elseif (strlen($confirmPassword) > 255) {
        $message = "Confirm password must not exceed 255 characters.";
        $toastClass = "error-toast";
    } elseif ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
        $toastClass = "error-toast";
    } elseif (!in_array($role, ['user', 'admin'])) {
        $message = "Invalid account type selected.";
        $toastClass = "error-toast";
    } else {
        // Here you would typically insert the user into the database
        // For now, we will just display a success message
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertStmt = $conn->prepare("INSERT INTO userdata (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $insertStmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $role);
        
        if (!$insertStmt->execute()) {

            $message = "Error registering user: " . $insertStmt->error;
            $toastClass = "error-toast";
        } else {
            // Registration successful
            $message = "Registration successful!";
            $toastClass = "success-toast";

            $newUserId = $insertStmt->insert_id;
            session_start();
            $_SESSION['user_id'] = $newUserId;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $firstName . ' ' . $lastName;
            $_SESSION['user_role'] = $role;
            $_SESSION['user_first_name'] = $firstName;
            $_SESSION['user_last_name'] = $lastName;
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

    <?php if (!empty($message)): ?>
        <div class="<?php echo $toastClass; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
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

        
</body>
</html>