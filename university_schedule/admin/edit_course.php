<?php
require_once '../config/database.php';

if (isset($_POST['course_id'], $_POST['course_name'])) {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];

    $db = new Database();
    $conn = $db->getConnection();

    $query = "UPDATE Courses SET course_name = :course_name WHERE course_id = :course_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':course_name', $course_name);
    $stmt->bindParam(':course_id', $course_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
