<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$DATABASE_HOST = 'db';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'time_pass';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Fetch user details
$query = "SELECT * FROM user WHERE username='" . $_SESSION['username']."'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

mysqli_close($con);
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
    <div class="container mt-5">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

        <!-- Display user's profile -->
        <div class="card mb-4">
        <img src="<?php echo !empty($user['profile_image']) ?  htmlspecialchars($user['profile_image']) : './images/default_profile_image.jpg'; ?>" class="card-img-top" alt="Profile Image">
    <h5 class="card-title">Username: <?php echo !empty($user['username']) ? htmlspecialchars($user['username']) : 'Placeholder Username'; ?></h5>
    <p class="card-text">Email: <?php echo !empty($user['email']) ? htmlspecialchars($user['email']) : 'Placeholder Email'; ?></p>
    <p class="card-text">Biography: <?php echo !empty($user['biography']) ? htmlspecialchars($user['biography'] ?? '') : 'No biography available. Maybe you can update it :)'; ?></p>
    <p class="card-text">Balance: Rs. <?php echo !empty($user['balance']) ? htmlspecialchars($user['balance']) : '0.00'; ?></p>
</div>

        </div>
        <br>
        <!-- Buttons for profile management -->
        <div class="text-center">
            <a href="update_profile.php" class="btn btn-primary mx-2">Update Profile</a>
            <a href="view_profiles.php" class="btn btn-success mx-2">View Profiles</a>
            <a href="transfer_money.php" class="btn btn-warning mx-2">Transfer Money</a>
        </div>

        <!-- Logout Button -->
        <div class="text-center mt-3">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <br>
</body>
</html>
