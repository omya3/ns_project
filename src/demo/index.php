<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/css/style.css"> <!-- Custom styles if needed -->
</head>
<body>
    <div class="container mt-5">
        <h2>Registration Form: <?php echo "this is cool just register guys !! "; ?></h2>

        <!-- Display success or error messages -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'success'): ?>
                <div class="alert alert-success" role="alert">
                    Registration successful!
                </div>
            <?php elseif ($_GET['status'] == 'error'): ?>
                <div class="alert alert-danger" role="alert">
                    Registration failed! Error: <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="process.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
