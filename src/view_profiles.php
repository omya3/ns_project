<?php
require_once 'logger.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

// Fetch all users except the current user
$query = "SELECT * FROM user WHERE username != ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

// Handle search functionality
$search_result = null;
if (isset($_GET['search'])) {
    $search_query = "SELECT * FROM user WHERE username LIKE ?";
    $search_term = "%" . $_GET['search'] . "%";
    $stmt = $con->prepare($search_query);
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $search_result = $stmt->get_result();
}

// Close connection at the end of the script
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profiles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Navigation Links -->
        <div class="mt-4 d-flex justify-content-between">
            <a href="home.php" class="btn btn-secondary">Go to Home</a>
            <a href="transfer_money.php" class="btn btn-warning mx-2">Transfer Money</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <br>
        <h2>View Profiles</h2>
        <br>
        <!-- Search bar -->
        <form method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search profiles...">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <?php if (isset($_GET['search'])): ?>
            <!-- Display search results -->
            <?php if ($search_result && $search_result->num_rows > 0): ?>
                <h3>Search Results:</h3>
                <div class="row">
                    <?php while ($search_user = $search_result->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?php echo !empty($search_user['profile_image']) ? htmlspecialchars($search_user['profile_image']) : './images/default_profile_image.jpg'; ?>" class="card-img-top img-fluid img-thumbnail" alt="Profile Image" >
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($search_user['username']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($search_user['biography'] ?? 'No biography available.'); ?></p>
                                    <a href="view_profile.php?username=<?php echo htmlspecialchars($search_user['username']); ?>" class="btn btn-primary">View Profile</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No results found.</p>
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- Display profiles -->
        <div class="row">
            <?php while ($user = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : './images/default_profile_image.jpg'; ?>" class="card-img-top img-fluid img-thumbnail" alt="Profile Image" >
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($user['username']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($user['biography'] ?? 'No biography available.'); ?></p>
                            <a href="view_profile.php?username=<?php echo htmlspecialchars($user['username']); ?>" class="btn btn-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
