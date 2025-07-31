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

if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    $message = "You have been logged out successfully!";
    $toastClass = "success-toast";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "Email and password are required.";
        $toastClass = "error-toast";
    }else{
        $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, role FROM userdata WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if($user['role'] == 'user'){
                $message = "Please log in from the user page";
                $toastClass = "error-toast";
            }
            // Verify the password
            elseif (password_verify($password, $user['password'])) {
                $message = "Login successful";
                $toastClass = "success-toast";
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_first_name'] = $user['first_name'];
                $_SESSION['user_last_name'] = $user['last_name'];
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $message = "Invalid email or password.";
                $toastClass = "error-toast";
        }
        } else {
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

        <?php if ($message): ?>
            <div class="<?php echo $toastClass; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

        <?php endif; ?>
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
</body>
</html>