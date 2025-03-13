<?php

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
$query = "SELECT profile_image FROM user WHERE username = 'omkar'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

// Display the profile_image value
if (!empty($user['profile_image'])) {
    echo $user['profile_image'];
} else {
    echo "No profile image found.";
}


?>