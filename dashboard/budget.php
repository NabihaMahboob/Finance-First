<?php
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

if (!isset($_SESSION['email'])) {
    header("Location: ../account_login/login.php");
    exit();
}
include '../database/db_connection.php';


$userEmail = $_SESSION['user_email'] ?? '';
$userName = $_SESSION['user_name'] ?? 'User';
$userRole = $_SESSION['user_role'] ?? 'user';
$firstName = $_SESSION['user_first_name'] ?? 'User';


// Add entry
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $note = $_POST['note'];

    $stmt = $conn->prepare("INSERT INTO budget (email, type, category, amount, note) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $userEmail, $type, $category, $amount, $note);
    $stmt->execute();
}

// Fetch data
$result = mysqli_query($conn, "SELECT * FROM budget WHERE email='$userEmail' ORDER BY created_at DESC");

$income = 0;
$expense = 0;
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['type'] === 'income') {
        $income += $row['amount'];
    } else {
        $expense += $row['amount'];
    }
    $data[] = $row;
}
$balance = $income - $expense;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Budget Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<h2>My Budget</h2>
<iframe class="budget-video" src="https://www.youtube.com/embed/sVKQn2I4HDM?si=eU0E9AjKc81fuNjt" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
<p><strong>Total Income:</strong> $<?= number_format($income, 2) ?></p>
<p><strong>Total Expenses:</strong> $<?= number_format($expense, 2) ?></p>
<p><strong>Balance:</strong> $<?= number_format($balance, 2) ?></p>

<canvas id="budgetChart"></canvas>

<script>
const ctx = document.getElementById('budgetChart');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Income', 'Expenses'],
        datasets: [{
            label: 'Budget',
            data: [<?= $income ?>, <?= $expense ?>],
            backgroundColor: ['#4caf50', '#f44336'],
            borderWidth: 1
        }]
    }
});
</script>

<h3>Add Entry</h3>
<form class="budget_form" method="POST">
    <label>Type:</label>
    <select name="type" required>
        <option value="income">Income</option>
        <option value="expense">Expense</option>
    </select><br><br>
    
    <label>Category:</label>
    <input type="text" name="category" required><br><br>
    
    <label>Amount ($):</label>
    <input type="number" name="amount" step="0.01" required><br><br>
    
    <label>Note:</label>
    <input type="text" name="note"><br><br>
    
    <button type="submit">Add</button>
</form>

<h3>Transaction History</h3>
<table class="budget_table">
    <tr>
        <th>Type</th><th>Category</th><th>Amount</th><th>Note</th><th>Date</th>
    </tr>
<?php foreach ($data as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['type']) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td>$<?= number_format($row['amount'], 2) ?></td>
        <td><?= htmlspecialchars($row['note']) ?></td>
        <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
    </tr>
<?php endforeach; ?>
</table>

</body>
</html>
