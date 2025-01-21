<?php
require_once '../config/database.php';

if (isset($_POST['schedule_id'], $_POST['start_date'], $_POST['end_date'])) {
    $schedule_id = $_POST['schedule_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $db = new Database();
    $conn = $db->getConnection();

    $query = "UPDATE ClassSchedule SET start_date = :start_date, end_date = :end_date WHERE schedule_id = :schedule_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':schedule_id', $schedule_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
