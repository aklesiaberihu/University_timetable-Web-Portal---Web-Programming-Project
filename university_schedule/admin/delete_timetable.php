<?php
require_once '../config/database.php';

if (isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];

    $db = new Database();
    $conn = $db->getConnection();

    $query = "DELETE FROM ClassSchedule WHERE schedule_id = :schedule_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':schedule_id', $schedule_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
