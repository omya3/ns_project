<?php
require_once 'logger.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Set secure cookie parameters before starting the session
session_set_cookie_params(0, '/', '', true, true);

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

logUserActivity($_SESSION['username'], basename(__FILE__));

// Database connection
$DATABASE_HOST = 'db';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'time_pass';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Fetch transaction history using prepared statements
$stmt = $con->prepare("SELECT * FROM transactions WHERE sender_username=? OR recipient_username=? ORDER BY transaction_date DESC");
$stmt->bind_param("ss", $_SESSION['username'], $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Transfer History</h2>

        <!-- Navigation Links -->
        <div class="mt-4 d-flex justify-content-between">
            <a href="home.php" class="btn btn-secondary">Go to Home</a>
            <a href="view_profiles.php" class="btn btn-success mx-2">View Profiles</a>
            <a href="transfer_money.php" class="btn btn-warning mx-2">Transfer Money</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <br>

        <!-- Display transaction history -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Sender</th>
                        <th>Recipient</th>
                        <th>Amount</th>
                        <th>Comment</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($transaction = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $transaction['id']; ?></td>
                            <td><?php echo $transaction['sender_username']; ?></td>
                            <td><?php echo $transaction['recipient_username']; ?></td>
                            <td><?php echo $transaction['amount']; ?></td>
                            <td><?php echo $transaction['comment']; ?></td>
                            <td><?php echo $transaction['transaction_date']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No transactions found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
