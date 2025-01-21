<?php
// Start session to handle student session
session_start();

require_once '../config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Handle form submission
$student_id = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
}

// Fetch student schedule if ID is provided
$schedules = [];
if ($student_id) {
    // Query to fetch student's timetable
    $query = "SELECT c.course_name, r.room_number, t.day_of_week, t.start_time, t.end_time, u.first_name AS instructor 
              FROM ClassSchedule cs
              JOIN CourseOfferings co ON cs.offering_id = co.offering_id
              JOIN Courses c ON co.course_id = c.course_id
              JOIN Rooms r ON cs.room_id = r.room_id
              JOIN TimeSlots t ON cs.slot_id = t.slot_id
              JOIN Users u ON co.instructor_id = u.user_id
              JOIN StudentEnrollments se ON co.offering_id = se.offering_id
              WHERE se.student_id = :student_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Schedule</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body id="schedule-body">

    <!-- Custom header -->
    <header id="schedule-header">
        <h1>Welcome, Student!</h1>
        <p>Check your course schedule below by entering your Student ID.</p>
    </header>

    <main id="schedule-main">
        <!-- Form to input student ID -->
        <form id="student-id-form" method="POST">
            <label for="student_id">Enter Student ID:</label>
            <input type="text" id="student_id" name="student_id" required>
            <button type="submit">View Schedule</button>
        </form>

        <?php if ($student_id && $schedules): ?>
            <h2>Your Schedule</h2>
            <table id="schedule-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Room</th>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Instructor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedules as $schedule): ?>
                    <tr>
                        <td><?php echo $schedule['course_name']; ?></td>
                        <td><?php echo $schedule['room_number']; ?></td>
                        <td><?php echo $schedule['day_of_week']; ?></td>
                        <td><?php echo $schedule['start_time']; ?></td>
                        <td><?php echo $schedule['end_time']; ?></td>
                        <td><?php echo $schedule['instructor']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($student_id): ?>
            <p id="no-schedule-message">No schedule found for Student ID: <?php echo htmlspecialchars($student_id); ?>.</p>
        <?php endif; ?>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>