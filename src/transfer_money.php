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

// Initialize feedback messages
$success_messages = [];
$error_messages = [];



// Handle money transfer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo $_POST['csrf_token'];
        echo '<br>';
        echo $_SESSION['csrf_token'];
        echo '<br>';
        echo "Invalid request!";
        exit();
    }

    $recipient_id = trim($_POST['recipient_id']);
    $amount = floatval($_POST['amount']);
    $comment = trim($_POST['comment']);

    // Fetch sender details using prepared statements
    $stmt = $con->prepare("SELECT * FROM user WHERE username=?");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $sender_result = $stmt->get_result();
    $sender = $sender_result->fetch_assoc();

    // Fetch recipient details using prepared statements
    $stmt = $con->prepare("SELECT * FROM user WHERE username=?");
    $stmt->bind_param("s", $recipient_id);
    $stmt->execute();
    $recipient_result = $stmt->get_result();

    if ($recipient_result->num_rows === 0) {
        $error_messages[] = "Recipient not found.";
    } else {
        $recipient = $recipient_result->fetch_assoc();

        // Check if sender has enough balance
        if ($sender['balance'] >= $amount && $amount > 0) {
            // Deduct amount from sender and add to recipient using transactions
            $con->begin_transaction();
            try {
                $stmt = $con->prepare("UPDATE user SET balance=balance-? WHERE username=?");
                $stmt->bind_param("ds", $amount, $_SESSION['username']);
                $stmt->execute();

                $stmt = $con->prepare("UPDATE user SET balance=balance+? WHERE username=?");
                $stmt->bind_param("ds", $amount, $recipient_id);
                $stmt->execute();
                
                // Insert transaction into database
                $stmt = $con->prepare("INSERT INTO transactions (sender_username, recipient_username, amount, comment) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssds", $_SESSION['username'], $recipient_id, $amount, $comment);
                $stmt->execute();

                $con->commit();

                // Log transaction in a file
                $log_message = date('Y-m-d H:i:s') . " - {$sender['username']} transferred Rs. {$amount} to {$recipient['username']}. Comment: {$comment}\n";
                if (file_put_contents('/var/www/html/logs/transaction_log.txt', $log_message, FILE_APPEND) === false) {
                    $error_messages[] = "Failed to write to transaction log.";
                } else {
                    $success_messages[] = "Money transferred successfully!";
                }
            } catch (Exception $e) {
                $con->rollback();
                $error_messages[] = "Error processing transaction.";
            }
        } else {
            $error_messages[] = "Insufficient balance or invalid amount.";
        }
    }
}
// else{
// // Generate CSRF token
// $csrf_token = bin2hex(random_bytes(32));
// $_SESSION['csrf_token'] = $csrf_token;
// }

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Transfer Money</h2>

    <!-- Navigation Links -->
    <div class="mt-4 d-flex justify-content-between">
        <a href="home.php" class="btn btn-secondary">Go to Home</a>
        <a href="transfer_history.php" class="btn btn-info mt-3">View Transfer History</a>
        <a href="view_profiles.php" class="btn btn-success mx-2">View Profiles</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    
    <br>

    <!-- Display success messages -->
    <?php if (!empty($success_messages)): ?>
        <?php foreach ($success_messages as $message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Display error messages -->
    <?php if (!empty($error_messages)): ?>
        <?php foreach ($error_messages as $message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Money Transfer Form -->
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php $csrf_token = bin2hex(random_bytes(32)); $_SESSION['csrf_token'] = $csrf_token;
        echo $csrf_token; ?>">

        <div class="mb-3">
            <label for="recipient_id" class="form-label">Recipient Username:</label>
            <input class="form-control" id="recipient_id" name="recipient_id" required placeholder='Enter recipient username'>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount:</label>
            <input type="number" step=".01" class="form-control" id="amount" name="amount" required placeholder='Enter amount'>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Comment (optional):</label>
            <textarea class="form-control" id="comment" name="comment" rows=3 placeholder='Enter a message'></textarea>
        </div>

        <button type='submit' class='btn btn-warning w-100'>Send Money</button>
        
    </form>

</body></html>
