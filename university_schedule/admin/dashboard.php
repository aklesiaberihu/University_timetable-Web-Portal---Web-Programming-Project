<?php
session_start();

// Ensure that the user is an admin
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body id="admin-body">
    <!-- Custom Admin Header -->
    <header id="admin-header">
        <h1>Welcome to the Administrator Dashboard</h1>
        <p>Manage rooms, courses, and timetables from one place.</p>
    </header>
    
    <main id="admin-dashboard">
        <h2>Administrator Tools</h2>
        <ul id="admin-links">
            <li><a href="manage_rooms.php">Manage Rooms</a></li>
            <li><a href="manage_courses.php">Manage Courses</a></li>
            <li><a href="manage_timetables.php">Manage Timetables</a></li>
        </ul>
    </main>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
