<?php
session_start();

// Ensure that the user is an admin
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Fetch all timetables
$query = "SELECT 
    cs.schedule_id, 
    co.course_id, 
    co.instructor_id, 
    r.room_number, 
    r.building, 
    ts.day_of_week, 
    ts.start_time, 
    ts.end_time, 
    cs.start_date, 
    cs.end_date
FROM ClassSchedule cs
JOIN CourseOfferings co ON cs.offering_id = co.offering_id
JOIN Rooms r ON cs.room_id = r.room_id
JOIN TimeSlots ts ON cs.slot_id = ts.slot_id";
$stmt = $conn->prepare($query);
$stmt->execute();
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Timetables</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h2>Manage Timetables</h2>
        <button id="addTimetableBtn">Add New Timetable</button>

        <table id="timetableTable">
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Instructor ID</th>
                    <th>Room</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedules as $schedule): ?>
                    <tr id="schedule_<?php echo $schedule['schedule_id']; ?>">
                        <td><?php echo $schedule['course_id']; ?></td>
                        <td><?php echo $schedule['instructor_id']; ?></td>
                        <td><?php echo $schedule['room_number'] . ' (' . $schedule['building'] . ')'; ?></td>
                        <td><?php echo $schedule['day_of_week']; ?></td>
                        <td><?php echo $schedule['start_time'] . ' - ' . $schedule['end_time']; ?></td>
                        <td><?php echo $schedule['start_date']; ?></td>
                        <td><?php echo $schedule['end_date']; ?></td>
                        <td>
                            <button class="editBtn" data-id="<?php echo $schedule['schedule_id']; ?>">Edit</button>
                            <button class="deleteBtn" data-id="<?php echo $schedule['schedule_id']; ?>">Delete</button>
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
