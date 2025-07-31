<?php
session_start();
include '../database/db_connection.php';
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
    <title>Add Forum</title>
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

    <h1>Shop</h1>
    <h2>Browse our specialized services and products</h2>
    <p>Welcome to the Finance First shop! Here you can find various financial products and services to help you manage your finances better.</p>
    <p>Feel free to explore our offerings and make purchases as needed.</p>

    <?php
    // Fetch products from the database or define them statically
    // For simplicity, we will define them statically here.
    // In a real application, you would fetch these from a database.
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    echo '<div class="shop-products">';
    
    while ($row = mysqli_fetch_assoc($result)) {
        $name = htmlspecialchars($row['name']);
        $description = htmlspecialchars($row['description']);
        $imageName = htmlspecialchars($row['image']);

        // Sanitize filename or use logic to match images correctly
        $imageFilename = strtolower(str_replace(' ', '', $imageName)) . '.jpg';
        $imagePath = "../media/" . $imageFilename;

        $option1_name = htmlspecialchars($row['option1_name']);
        $option1_price = number_format($row['price1'], 2);
        $option2_name = htmlspecialchars($row['option2_name']);
        $option2_price = number_format($row['price2'], 2);

        echo '
        <div class="product">
            <img src="' . $imagePath . '" alt="' . $name . '">
            <h3>' . $name . '</h3>
            <p>' . $description . '</p>
            <p><strong>' . $option1_name . ':</strong> $' . $option1_price . '</p>
            <p><strong>' . $option2_name . ':</strong> $' . $option2_price . '</p>
            <button>Add to Cart</button>
        </div>';
    }

    echo '</div>';
} else {
    echo '<p>No products found.</p>';
}
?>

        <footer>
            <p>&copy; 2023 Finance First. All rights reserved.</p>
        </footer>
    

</body>
</html>
