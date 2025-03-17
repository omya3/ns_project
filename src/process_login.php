<?php

require_once 'logger.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

// Database connection
$DATABASE_HOST = 'db';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'time_pass';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Invalid request!";
        exit();
    }

    // Sanitize input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch user from database using prepared statements
    $stmt = $con->prepare("SELECT * FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['balance'] = $user['balance'];
            // echo $_SESSION
            // Redirect to home page

            logUserActivity($_SESSION['username'], basename(__FILE__));

            header('Location: home.php');
            // echo "Hello";
            exit();
        } else {
            // Invalid password
            header('Location: login.php?status=error&message=' . urlencode('Invalid password.'));
            exit();
        }
    } else {
        // User not found
        header('Location: login.php?status=error&message=' . urlencode('User not found.'));
        exit();
    }
}

// Close database connection
mysqli_close($con);
?>
