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

// Fetch user details
$stmt = $con->prepare("SELECT * FROM user WHERE username=?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Initialize feedback message
$feedback_message = "";
$message_type = ""; // success or danger

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo $_POST['csrf_token'];
        echo '<br>';
        echo $_SESSION['csrf_token'];
        echo '<br>';
        echo "Invalid request!";
        exit();
    }
    $csrf_token = $_SESSION['csrf_token'];
    
    $email = trim($_POST['email']);
    $biography = trim($_POST['biography']);

    // Update user details using prepared statements
    $stmt = $con->prepare("UPDATE user SET email=?, biography=? WHERE username=?");
    $stmt->bind_param("sss", $email, $biography, $_SESSION['username']);
    if ($stmt->execute()) {
        $feedback_message .= "Profile updated successfully!\n";
        $message_type = "success";
    } else {
        $feedback_message .= "Error updating profile: " . $con->error . "\n";
        $message_type = "danger";
    }

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] != UPLOAD_ERR_OK) {
        $image_name = $_FILES['profile_image']['name'];
        $image_tmp = $_FILES['profile_image']['tmp_name'];
        $image_size = $_FILES['profile_image']['size'];
        $image_type = $_FILES['profile_image']['type'];

        // Validate image type
        if ($image_type == "image/jpeg" || $image_type == "image/png") {
            // Move uploaded image to a secure directory
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' ;
            $image_path = 'uploads/' . $image_name; // Store relative path
            if (move_uploaded_file($image_tmp, $upload_dir . $image_name)) {
                // Update database with relative image path using prepared statements
                $stmt = $con->prepare("UPDATE user SET profile_image=? WHERE username=?");
                $stmt->bind_param("ss", $image_path, $_SESSION['username']);
                if ($stmt->execute()) {
                    $feedback_message .= "Profile image updated successfully!\n";
                    $message_type = "success";
                } else {
                    $feedback_message .= "Error updating profile image: " . $con->error . "\n";
                    $message_type = "danger";
                }
            } else {
                $feedback_message .= "Failed to upload image.\n";
                $message_type = "danger";
            }
        } else {
            $feedback_message .= "Either image size is  too big or the extension is not JPEG or PNG. \n";
            $message_type = "danger";
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Update Profile</h2>

         <!-- Navigation Links -->
         <div class="mt-4 d-flex justify-content-between">
            <a href="home.php" class="btn btn-secondary">Go to Home</a>
            <a href="view_profiles.php" class="btn btn-success mx-2">View Profiles</a>
            <a href="transfer_money.php" class="btn btn-warning mx-2">Transfer Money</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <br>

        <!-- Feedback Message -->
        <?php if (!empty($feedback_message)): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> alert-dismissible fade show" role="alert">
                <?php echo nl2br(htmlspecialchars($feedback_message)); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Profile Update Form -->
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="biography" class="form-label">Biography:</label>
                <textarea class="form-control" id="biography" name="biography" rows="5"><?php echo htmlspecialchars($user['biography'] ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image:</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image">
            </div>

            <input type="hidden" name="csrf_token" value="<?php $csrf_token = bin2hex(random_bytes(32)); $_SESSION['csrf_token'] = $csrf_token; echo $csrf_token; ?>">

            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
        </form>

       
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
