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

    <video autoplay muted loop class="calendar-video">
        <source src="../media/calendar.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <h1> Book an Appointment</h1>
    <h2>Choose a date and time for your appointment</h2>
    
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
        <button type="submit">Book Appointment</button>
    </form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../database/db_connection.php';
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

    <p>Need to cancel or reschedule? <a href="edit_appointment.php" target="_blank">Cancel Appointment</a></p>

    <h2>Upcoming Workshops</h2>

    <p>Join our upcoming workshops to learn more about financial topics and improve your financial literacy.</p>
    <ul>
        <li>Workshop on Budgeting - Date: 2023-10-15, Time: 10:00 AM</li>
        <li>Investment Strategies - Date: 2023-10-20, Time: 2:00 PM</li>
        <li>Debt Management - Date: 2023-10-25, Time: 1:00 PM</li>
    </ul>   

</body>
</html>