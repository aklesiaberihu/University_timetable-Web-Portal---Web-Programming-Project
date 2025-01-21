<?php
session_start();

// If the user is already logged in, redirect based on role
if (isset($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];
    if ($role === 'admin') {
        header("Location: admin/dashboard.php");
        exit();
    } elseif ($role === 'faculty') {
        header("Location: faculty/schedule_management.php");
        exit();
    } elseif ($role === 'student') {
        header("Location: student/view_schedule.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body id="welcome-body">
    <header id="welcome-header">
        <h1>Welcome to the University Schedule Management System</h1>
        <p>Your one-stop solution for managing schedules and timetables.</p>
    </header>

    <main id="welcome-main">
        <p>Please log in to continue.</p>
        <a href="login.php" class="btn">Login</a>
    </main>

    <footer id="welcome-footer">
        <p>&copy; <?= date('Y'); ?> University Schedule Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
