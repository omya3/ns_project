<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'time_pass';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Fetch user details based on user_id
$user_id = $_GET['username'];
$query = "SELECT * FROM user WHERE username='" . $user_id . "'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="mt-4 d-flex justify-content-between">
            <a href="home.php" class="btn btn-secondary">Go to Home</a>
            <a href="view_profiles.php" class="btn btn-success mx-2">Back to profiles</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <br>
        <h2>Profile of <?php echo $user['username']; ?></h2>

        <div class="card">
            <!-- Resize profile image -->
            <img src="<?php echo !empty($user['profile_image']) ?  htmlspecialchars($user['profile_image']) : './images/default_profile_image.jpg'; ?>" class="card-img-top img-fluid img-thumbnail" alt="Profile Image" >
            <div class="card-body">
                <h5 class="card-title">Username: <?php echo $user['username']; ?></h5>
                <p class="card-text">Biography: <?php  echo htmlspecialchars($user['biography'] ?? 'No biography available. ');?></p>
            </div>
        </div>
    </div>
</body>
</html>
