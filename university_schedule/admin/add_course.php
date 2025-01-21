<?php
require_once '../config/database.php';

if (isset($_POST['course_code'], $_POST['course_name'], $_POST['description'], $_POST['credits'], $_POST['level'])) {
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $credits = $_POST['credits'];
    $level = $_POST['level'];

    $db = new Database();
    $conn = $db->getConnection();

    $query = "INSERT INTO Courses (course_code, course_name, description, credits, level) VALUES (:course_code, :course_name, :description, :credits, :level)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':course_code', $course_code);
    $stmt->bindParam(':course_name', $course_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':credits', $credits);
    $stmt->bindParam(':level', $level);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
