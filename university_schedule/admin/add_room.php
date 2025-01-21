<?php
require_once '../config/database.php';

if (isset($_POST['room_number'], $_POST['building'], $_POST['floor'], $_POST['capacity'], $_POST['room_type'])) {
    $room_number = $_POST['room_number'];
    $building = $_POST['building'];
    $floor = $_POST['floor'];
    $capacity = $_POST['capacity'];
    $room_type = $_POST['room_type'];
    $has_projector = $_POST['has_projector'];
    $has_whiteboard = $_POST['has_whiteboard'];
    $has_computer = $_POST['has_computer'];
    $is_accessible = $_POST['is_accessible'];

    $db = new Database();
    $conn = $db->getConnection();

    $query = "INSERT INTO Rooms (room_number, building, floor, capacity, room_type, has_projector, has_whiteboard, has_computer, is_accessible) 
              VALUES (:room_number, :building, :floor, :capacity, :room_type, :has_projector, :has_whiteboard, :has_computer, :is_accessible)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':room_number', $room_number);
    $stmt->bindParam(':building', $building);
    $stmt->bindParam(':floor', $floor);
    $stmt->bindParam(':capacity', $capacity);
    $stmt->bindParam(':room_type', $room_type);
    $stmt->bindParam(':has_projector', $has_projector);
    $stmt->bindParam(':has_whiteboard', $has_whiteboard);
    $stmt->bindParam(':has_computer', $has_computer);
    $stmt->bindParam(':is_accessible', $is_accessible);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
