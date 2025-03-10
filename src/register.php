<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Register</h2>

        <!-- Display success or error messages -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'success'): ?>
                <div class="alert alert-success" role="alert">
                    Registration successful! Please login.
                </div>
            <?php elseif ($_GET['status'] == 'error'): ?>
                <div class="alert alert-danger" role="alert">
                    Registration failed! Error: <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Registration Form -->
        <form method="POST" action="process_register.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <!-- Link to Login -->
        <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
