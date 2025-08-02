<?php

// Start the session
session_start();

// Include the database connection file
include '../database/db_connection.php';
// Check if the user is logged in, if
// not then redirect them to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

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
    <!-- Nav Bar -->
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
                    
                </div>
            </div>
            <a href="appointment.php">Appointment</a>
            <a href="forums_logged_in.php">Forums</a>
            <a href="shop.php">Shop</a>
        </div>

        <div>
            <span>Welcome, <?php echo htmlspecialchars($firstName); ?>!</span>
            <a href="../main_pages/logout.php">Logout</a>
        </div>
    </nav>


    <h1> Book an Appointment</h1>
    <video autoplay muted loop class="calendar-video">
        <source src="../media/calendar.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <h2>Choose a date and time for your appointment</h2>
    
    <!-- Form to request an appointment -->
    <form action="appointment.php" method="post">
        <p>Date:</p>
        <input type="date" name="date" required>
        <p>Time:</p>
        <input type="time" name="time" required>
        <p>Service:</p>
        <select name="service" required>
            <option value="" disabled selected>Select a service</option>
            <option value="debt-consolidation">Debt Consolidation</option>
            <option value="financial-planning">Financial Planning</option>
            <option value="budgeting_help">Budgeting Help</option>
            <option value="investment_planning">Investment Planning</option>
            <option value="credit_score_improvement">Credit Score Improvement</option>
            <option value="other">Other</option>
            
        </select>
        <p>Comments:</p>
        <textarea name="comments" placeholder="Any specific questions or topics you want to discuss?"></textarea>
        <br></br>
        <button class="appointment-submit" type="submit">Book Appointment</button>
    </form>
<?php
// Adds appointment to database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);       
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);
    $email = $_SESSION['email'];
    $name = $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];
    $sql = "INSERT INTO appointments (name, email, date, time, service, comments) VALUES ('$name', '$email', '$date', '$time', '$service', '$comments')";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='success-toast'>Your appointment has been booked successfully!</div>";
    } else {
        echo "<div class='error-toast'>Error: " . mysqli_error($conn) . "</div>";
    }
    mysqli_close($conn);
}
?>

<!-- Leads to cancel page -->
    <p>Need to cancel? <a href="edit_appointment.php" target="_blank">Cancel Appointment</a></p>

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