<?php
session_start();

// Ensure that the user is an admin
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../config/database.php';

// Fetch all courses from the database
$db = new Database();
$conn = $db->getConnection();
$query = "SELECT * FROM Courses";
$stmt = $conn->prepare($query);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h2>Manage Courses</h2>
        <button id="addCourseBtn">Add New Course</button>
        
        <table id="coursesTable">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Credits</th>
                    <th>Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr id="course_<?php echo $course['course_id']; ?>">
                        <td><?php echo $course['course_code']; ?></td>
                        <td><?php echo $course['course_name']; ?></td>
                        <td><?php echo $course['description']; ?></td>
                        <td><?php echo $course['credits']; ?></td>
                        <td><?php echo $course['level']; ?></td>
                        <td>
                            <button class="editBtn" data-id="<?php echo $course['course_id']; ?>">Edit</button>
                            <button class="deleteBtn" data-id="<?php echo $course['course_id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="../assets/js/scripts.js"></script>
</body>
</html>
