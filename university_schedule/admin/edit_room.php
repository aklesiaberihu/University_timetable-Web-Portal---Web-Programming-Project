<?php
require_once '../config/database.php';

if (isset($_POST['room_id'], $_POST['room_number'])) {
    $room_id = $_POST['room_id'];
    $room_number = $_POST['room_number'];

    $db = new Database();
    $conn = $db->getConnection();

    $query = "UPDATE Rooms SET room_number = :room_number WHERE room_id = :room_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':room_number', $room_number);
    $stmt->bindParam(':room_id', $room_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
