<?php
session_start();

// Ensure that the user is an admin
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../config/database.php';

// Fetch all rooms from the database
$db = new Database();
$conn = $db->getConnection();
$query = "SELECT * FROM Rooms";
$stmt = $conn->prepare($query);
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h2>Manage Rooms</h2>
        <button id="addRoomBtn">Add New Room</button>
        
        <table id="roomsTable">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Building</th>
                    <th>Floor</th>
                    <th>Capacity</th>
                    <th>Room Type</th>
                    <th>Projector</th>
                    <th>Whiteboard</th>
                    <th>Computer</th>
                    <th>Accessible</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room): ?>
                    <tr id="room_<?php echo $room['room_id']; ?>">
                        <td><?php echo $room['room_number']; ?></td>
                        <td><?php echo $room['building']; ?></td>
                        <td><?php echo $room['floor']; ?></td>
                        <td><?php echo $room['capacity']; ?></td>
                        <td><?php echo $room['room_type']; ?></td>
                        <td><?php echo $room['has_projector'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $room['has_whiteboard'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $room['has_computer'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $room['is_accessible'] ? 'Yes' : 'No'; ?></td>
                        <td>
                            <button class="editBtn" data-id="<?php echo $room['room_id']; ?>">Edit</button>
                            <button class="deleteBtn" data-id="<?php echo $room['room_id']; ?>">Delete</button>
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
