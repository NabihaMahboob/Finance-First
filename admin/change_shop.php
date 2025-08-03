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
// Check if the user is logged in, if
// not then redirect them to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}           


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price1 = $_POST['price1'];
    $option1_name = mysqli_real_escape_string($conn, $_POST['option1_name']);
    $option1_value = mysqli_real_escape_string($conn, $_POST['option1_value']);
    $price2 = $_POST['price2'];
    $option2_name = mysqli_real_escape_string($conn, $_POST['option2_name']);
    $option2_value = mysqli_real_escape_string($conn, $_POST['option2_value']);

    $sql = "INSERT INTO products (name, image, description, price1, option1_name, option1_value, price2, option2_name, option2_value) 
            VALUES ('$name', '$image', '$description', '$price1', '$option1_name', '$option1_value', '$price2', '$option2_name', '$option2_value')";
    mysqli_query($conn, $sql);
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price1 = $_POST['price1'];
    $option1_name = mysqli_real_escape_string($conn, $_POST['option1_name']);
    $option1_value = mysqli_real_escape_string($conn, $_POST['option1_value']);
    $price2 = $_POST['price2'];
    $option2_name = mysqli_real_escape_string($conn, $_POST['option2_name']);
    $option2_value = mysqli_real_escape_string($conn, $_POST['option2_value']);

    $sql = "UPDATE products SET 
            name = '$name',
            image = '$image',
            description = '$description',
            price1 = '$price1',
            option1_name = '$option1_name',
            option1_value = '$option1_value',
            price2 = '$price2',
            option2_name = '$option2_name',
            option2_value = '$option2_value'
            WHERE id = $id";
    mysqli_query($conn, $sql);
}

$result = mysqli_query($conn, "SELECT * FROM products");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Edit Shop</title>
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

    <h2>Welcome to the Edit Shop Page</h2>
    <img class="admin-shop" src="../media/adminShopImg.jpg" ></img>
    <p>Here you can manage the shop's offerings and services.</p>
    <p>Use the navigation links above to access different sections of the admin panel.</p>
    <p>For any assistance, please contact support.</p>

    <!-- Form to add product -->
   <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required><br>
        <input type="text" name="image" placeholder="Image Filename (no extension)" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="text" name="option1_name" placeholder="Option 1 Label" required>
        <input type="text" name="option1_value" placeholder="Option 1 Value" required>
        <input type="number" step="0.01" name="price1" placeholder="Price for Option 1" required><br>
        <input type="text" name="option2_name" placeholder="Option 2 Label" required>
        <input type="text" name="option2_value" placeholder="Option 2 Value" required>
        <input type="number" step="0.01" name="price2" placeholder="Price for Option 2" required><br>
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <h2>Existing Products</h2>
    <div class="edit-products-list">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <!-- Editable forms with each product -->
        <form method="POST" class="edit-product">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <label>Name:</label><br>
            <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required><br>

            <label>Image Filename (no extension):</label><br>
            <input type="text" name="image" value="<?= htmlspecialchars($row['image']) ?>" required><br>

            <label>Description:</label><br>
            <textarea name="description"><?= htmlspecialchars($row['description']) ?></textarea><br>

            <label>Option 1:</label><br>
            <input type="text" name="option1_name" value="<?= htmlspecialchars($row['option1_name']) ?>" required>
            <input type="text" name="option1_value" value="<?= htmlspecialchars($row['option1_value']) ?>" required>
            <input type="number" step="0.01" name="price1" value="<?= $row['price1'] ?>" required><br>

            <label>Option 2:</label><br>
            <input type="text" name="option2_name" value="<?= htmlspecialchars($row['option2_name']) ?>" required>
            <input type="text" name="option2_value" value="<?= htmlspecialchars($row['option2_value']) ?>" required>
            <input type="number" step="0.01" name="price2" value="<?= $row['price2'] ?>" required><br>

            <button type="submit" name="update_product">Update</button>
            <a href="admin_products.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
        </form>
    <?php endwhile; ?>
    </div>

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