<?php
session_start();

// Initialize error message
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the form
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Check if fields are empty
    if (empty($username) || empty($password)) {
        $error = 'Username and password are required.';
    } else {
        // Load users from CSV
        if (file_exists('model/user.csv')) {
            $users = array_map('str_getcsv', file('model/user.csv'));
        } else {
            die("Error: users.csv file not found.");
        }

        // Check for valid credentials
        $valid = false;
        foreach ($users as $user) {
            if ($user[0] === $username && $user[1] === $password) {
                $valid = true;
                break;
            }
        }

        if ($valid) {
            // Redirect to the games display page
            header('Location: view/games.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="view/styles.css">
</head>
<body>
    <div class="login-form">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
