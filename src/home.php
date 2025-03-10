
<?php
session_start();

// Restrict access to logged-in users
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5 text-center">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Your current balance is: <strong>Rs. <?php echo htmlspecialchars($_SESSION['balance']); ?></strong></p>

        <!-- Logout Button -->
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>
</body>
</html>
