<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

// If user is already logged in, redirect them to home.php
if (isset($_SESSION['username'])) {
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Welcome to Our Website</h1>
        <p>Please choose an option below:</p>

        <!-- Buttons for Register and Login -->
        <div class="mt-4">
            <a href="register.php" class="btn btn-primary btn-lg mx-2">Register</a>
            <a href="login.php" class="btn btn-success btn-lg mx-2">Login</a>
        </div>
    </div>
</body>
</html>
