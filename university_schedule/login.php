<?php
session_start();
require_once 'config/database.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if email and password are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Initialize the database connection
        $db = new Database();
        $conn = $db->getConnection();

        // Check if user exists using email
        $query = "SELECT * FROM Users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Fetch user details
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists and the password matches
        if ($user && $password === $user['password_hash']) {  
            // Set session variables for user
            $_SESSION['user'] = $user;

            // Redirect user based on role
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['role'] == 'faculty') {
                header("Location: faculty/schedule_management.php");
            } else {
                header("Location: student/view_schedule.php");
            }
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Please enter both email and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body id="login-body">
    <header id="login-header">
        <h1>Welcome to University Schedule Management System</h1>
    </header>

    <div id="login-container">
        <h2>Login</h2>

        <!-- Welcome Message -->
        <p class="welcome-message">Please log in to access your dashboard.</p>
        
        <!-- Display error message if any -->
        <?php if ($error_message): ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>
    </div>

    <footer id="login-footer">
        <p>&copy; <?= date('Y'); ?> University Schedule Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>