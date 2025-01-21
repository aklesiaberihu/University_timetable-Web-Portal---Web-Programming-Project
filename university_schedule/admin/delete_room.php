<?php
require_once '../config/database.php';

if (isset($_POST['room_id'])) {
    $room_id = $_POST['room_id'];

    $db = new Database();
    $conn = $db->getConnection();

    $query = "DELETE FROM Rooms WHERE room_id = :room_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':room_id', $room_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
