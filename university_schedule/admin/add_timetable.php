<?php
require_once '../config/database.php';

if (isset($_POST['offering_id'], $_POST['room_id'], $_POST['slot_id'], $_POST['start_date'], $_POST['end_date'])) {
    $offering_id = $_POST['offering_id'];
    $room_id = $_POST['room_id'];
    $slot_id = $_POST['slot_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $db = new Database();
    $conn = $db->getConnection();

    $query = "INSERT INTO ClassSchedule (offering_id, room_id, slot_id, start_date, end_date) 
              VALUES (:offering_id, :room_id, :slot_id, :start_date, :end_date)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':offering_id', $offering_id);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->bindParam(':slot_id', $slot_id);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
