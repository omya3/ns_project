<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Login</h2>

        <!-- Display success or error messages -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'error'): ?>
                <div class="alert alert-danger" role="alert">
                    Login failed! Error: <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="process_login.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required placeholder='Enter your username'>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder='Enter your password'>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Link to Registration -->
        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
