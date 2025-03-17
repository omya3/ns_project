<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Set secure cookie parameters before starting the session
session_set_cookie_params(0, '/', '', true, true);

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

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Invalid request!";
        exit();
    }
    
    // Sanitize and validate input
    $username = mysqli_real_escape_string($con, trim($_POST['username']));
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $password = trim($_POST['password']);

    // Check if any field is empty
    if (empty($username) || empty($email) || empty($password)) {
        header('Location: register.php?status=error&message=' . urlencode('All fields are required.'));
        exit();
    }

    // Check if username or email already exists
    $check_user_query = "SELECT * FROM user WHERE username='$username' OR email='$email'";
    $result = mysqli_query($con, $check_user_query);

    if (mysqli_num_rows($result) > 0) {
        header('Location: register.php?status=error&message=' . urlencode('Username or Email already exists.'));
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database using prepared statements
    $stmt = $con->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    if ($stmt->execute()) {
        header('Location: register.php?status=success'); // Redirect with success message
        exit();
    } else {
        header('Location: register.php?status=error&message=' . urlencode('Error registering user.'));
        exit();
    }
}

// Close database connection
mysqli_close($con);
?>
