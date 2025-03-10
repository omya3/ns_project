<?php
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

// Fetch user details
$query = "SELECT * FROM user WHERE username='" . $_SESSION['username'] . "'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

// Initialize feedback message
$feedback_message = "";
$message_type = ""; // success or danger

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $biography = $_POST['biography'];

    // Update user details
    $query = "UPDATE user SET email='$email', biography='$biography' WHERE username='" . $_SESSION['username'] . "'";
    if (mysqli_query($con, $query)) {
        $feedback_message .= "Profile updated successfully!\n";
        $message_type = "success";
    } else {
        $feedback_message .= "Error updating profile: " . mysqli_error($con) . "\n";
        $message_type = "danger";
    }

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $image_name = $_FILES['profile_image']['name'];
        $image_tmp = $_FILES['profile_image']['tmp_name'];
        $image_size = $_FILES['profile_image']['size'];
        $image_type = $_FILES['profile_image']['type'];

        // Validate image type
        if ($image_type == "image/jpeg" || $image_type == "image/png") {
            // Move uploaded image to a secure directory
            $upload_dir = '/opt/lampp/htdocs/ns_project/src/uploads/';
            $image_path = 'uploads/' . $image_name; // Store relative path
            if (move_uploaded_file($image_tmp, $upload_dir . $image_name)) {
                // Update database with relative image path
                $query = "UPDATE user SET profile_image='$image_path' WHERE username='" . $_SESSION['username'] . "'";
                if (mysqli_query($con, $query)) {
                    $feedback_message .= "Profile image updated successfully!\n";
                    $message_type = "success";
                } else {
                    $feedback_message .= "Error updating profile image: " . mysqli_error($con) . "\n";
                    $message_type = "danger";
                }
            } else {
                $feedback_message .= "Failed to upload image.\n";
                $message_type = "danger";
            }
        } else {
            $feedback_message .= "Only JPEG and PNG images are allowed.\n";
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
                <textarea class="form-control" id="biography" name="biography" rows="5"><?php echo htmlspecialchars($user['biography']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image:</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image">
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
        </form>

        <!-- Navigation Links -->
        <div class="mt-4 d-flex justify-content-between">
            <a href="home.php" class="btn btn-secondary">Go to Home</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
