<?php
function logUserActivity($username, $webpage) {
    // Database connection
    $DATABASE_HOST = 'db';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'root';
    $DATABASE_NAME = 'time_pass';
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    // Get client IP address
    $client_ip = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $client_ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $client_ip = $_SERVER['REMOTE_ADDR'];
    }

    // Log activity into the database
    $stmt = $con->prepare("INSERT INTO user_activity_logs (username, webpage, client_ip) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $webpage, $client_ip);
    
    if (!$stmt->execute()) {
        error_log("Failed to log user activity: " . $stmt->error);
    }

    // Close connection
    mysqli_close($con);
}
?>
