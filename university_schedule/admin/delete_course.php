<?php
require_once '../config/database.php';

if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    $db = new Database();
    $conn = $db->getConnection();

    $query = "DELETE FROM Courses WHERE course_id = :course_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':course_id', $course_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
