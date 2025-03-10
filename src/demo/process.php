<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "time_pass";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO user (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to index.php with a success message
        header("Location: index.php?status=success");
        exit();
    } else {
        // Redirect to index.php with an error message
        header("Location: index.php?status=error&message=" . urlencode($conn->error));
        exit();
    }
}

$conn->close();
?>
