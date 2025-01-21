$(document).ready(function () {
    // Add Course
    $('#addCourseBtn').click(function () {
        let course_code = prompt('Enter Course Code:');
        let course_name = prompt('Enter Course Name:');
        let description = prompt('Enter Course Description:');
        let credits = prompt('Enter Course Credits:');
        let level = prompt('Enter Course Level (undergraduate/graduate):');

        if (course_code && course_name && description && credits && level) {
            console.log('Sending Add Course request...');
            $.ajax({
                url: 'add_course.php',
                type: 'POST',
                data: {
                    course_code: course_code,
                    course_name: course_name,
                    description: description,
                    credits: credits,
                    level: level
                },
                success: function(response) {
                    console.log('Response from add_course.php: ', response);
                    if (response === 'success') {
                        location.reload();  
                    } else {
                        alert('Failed to add course.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error: ', error);
                }
            });
        }
    });

    // Edit Course
    $('.editBtn').click(function () {
        let courseId = $(this).data('id');
        let courseName = prompt('Enter new Course Name:');
        
        if (courseName) {
            console.log('Sending Edit Course request...');
            $.ajax({
                url: 'edit_course.php',
                type: 'POST',
                data: { course_id: courseId, course_name: courseName },
                success: function(response) {
                    console.log('Response from edit_course.php: ', response);
                    if (response === 'success') {
                        location.reload();  
                    } else {
                        alert('Failed to update course.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error: ', error);
                }
            });
        }
    });

    // Delete Course
    $('.deleteBtn').click(function () {
        let courseId = $(this).data('id');
        if (confirm('Are you sure you want to delete this course?')) {
            console.log('Sending Delete Course request...');
            $.ajax({
                url: 'delete_course.php',
                type: 'POST',
                data: { course_id: courseId },
                success: function(response) {
                    console.log('Response from delete_course.php: ', response);
                    if (response === 'success') {
                        $('#course_' + courseId).remove();  
                    } else {
                        alert('Failed to delete course.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error: ', error);
                }
            });
        }
    });

// Add Room
$('#addRoomBtn').click(function () {
    let room_number = prompt('Enter Room Number:');
    let building = prompt('Enter Building:');
    let floor = prompt('Enter Floor:');
    let capacity = prompt('Enter Capacity:');
    let room_type = prompt('Enter Room Type (lecture_hall, classroom, lab, seminar_room):');
    let has_projector = confirm('Has Projector?');
    let has_whiteboard = confirm('Has Whiteboard?');
    let has_computer = confirm('Has Computer?');
    let is_accessible = confirm('Is Accessible?');

    if (room_number && building && floor && capacity && room_type) {
        $.ajax({
            url: 'add_room.php',
            type: 'POST',
            data: {
                room_number: room_number,
                building: building,
                floor: floor,
                capacity: capacity,
                room_type: room_type,
                has_projector: has_projector ? 1 : 0,
                has_whiteboard: has_whiteboard ? 1 : 0,
                has_computer: has_computer ? 1 : 0,
                is_accessible: is_accessible ? 1 : 0
            },
            success: function(response) {
                if (response === 'success') {
                    location.reload();  
                } else {
                    alert('Failed to add room.');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error: ', error);
            }
        });
    }
});

// Edit Room
$('.editBtn').click(function () {
    let roomId = $(this).data('id');
    let roomNumber = prompt('Enter new Room Number:');
    
    if (roomNumber) {
        $.ajax({
            url: 'edit_room.php',
            type: 'POST',
            data: { room_id: roomId, room_number: roomNumber },
            success: function(response) {
                if (response === 'success') {
                    location.reload();  
                } else {
                    alert('Failed to update room.');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error: ', error);
            }
        });
    }
});

// Delete Room
$('.deleteBtn').click(function () {
    let roomId = $(this).data('id');
    if (confirm('Are you sure you want to delete this room?')) {
        $.ajax({
            url: 'delete_room.php',
            type: 'POST',
            data: { room_id: roomId },
            success: function(response) {
                if (response === 'success') {
                    $('#room_' + roomId).remove();  
                } else {
                    alert('Failed to delete room.');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error: ', error);
            }
        });
    }
});

// Add Timetable Entry
$('#addTimetableBtn').click(function () {
    let offering_id = prompt('Enter Offering ID:');
    let room_id = prompt('Enter Room ID:');
    let slot_id = prompt('Enter Time Slot ID:');
    let start_date = prompt('Enter Start Date (YYYY-MM-DD):');
    let end_date = prompt('Enter End Date (YYYY-MM-DD):');

    if (offering_id && room_id && slot_id && start_date && end_date) {
        $.ajax({
            url: 'add_timetable.php',
            type: 'POST',
            data: {
                offering_id: offering_id,
                room_id: room_id,
                slot_id: slot_id,
                start_date: start_date,
                end_date: end_date
            },
            success: function(response) {
                if (response === 'success') {
                    location.reload();
                } else {
                    alert('Failed to add timetable entry.');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });
    }
});

// Edit Timetable Entry
$('.editBtn').click(function () {
    let schedule_id = $(this).data('id');
    let start_date = prompt('Enter new Start Date (YYYY-MM-DD):');
    let end_date = prompt('Enter new End Date (YYYY-MM-DD):');

    if (start_date && end_date) {
        $.ajax({
            url: 'edit_timetable.php',
            type: 'POST',
            data: {
                schedule_id: schedule_id,
                start_date: start_date,
                end_date: end_date
            },
            success: function(response) {
                if (response === 'success') {
                    location.reload();
                } else {
                    alert('Failed to update timetable entry.');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });
    }
});

// Delete Timetable Entry
$('.deleteBtn').click(function () {
    let schedule_id = $(this).data('id');
    if (confirm('Are you sure you want to delete this timetable entry?')) {
        $.ajax({
            url: 'delete_timetable.php',
            type: 'POST',
            data: { schedule_id: schedule_id },
            success: function(response) {
                if (response === 'success') {
                    $('#schedule_' + schedule_id).remove();
                } else {
                    alert('Failed to delete timetable entry.');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });
    }
});


});
