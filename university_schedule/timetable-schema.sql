-- Create Users table for auth and role management
CREATE TABLE Users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('admin', 'faculty', 'student') NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- Faculties table
CREATE TABLE Faculties (
    faculty_id INT PRIMARY KEY AUTO_INCREMENT,
    faculty_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Departments table
CREATE TABLE Departments (
    department_id INT PRIMARY KEY AUTO_INCREMENT,
    faculty_id INT,
    department_name VARCHAR(100) NOT NULL,
    description TEXT,
    FOREIGN KEY (faculty_id) REFERENCES Faculties(faculty_id)
);

--   table for Rooms
CREATE TABLE Rooms (
    room_id INT PRIMARY KEY AUTO_INCREMENT,
    room_number VARCHAR(20) NOT NULL,
    building VARCHAR(50) NOT NULL,
    floor INT NOT NULL,
    capacity INT NOT NULL,
    room_type ENUM('lecture_hall', 'classroom', 'lab', 'seminar_room') NOT NULL,
    has_projector BOOLEAN DEFAULT FALSE,
    has_whiteboard BOOLEAN DEFAULT FALSE,
    has_computer BOOLEAN DEFAULT FALSE,
    is_accessible BOOLEAN DEFAULT FALSE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- table of Courses 
CREATE TABLE Courses (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    department_id INT,
    course_code VARCHAR(20) UNIQUE NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    description TEXT,
    credits INT NOT NULL,
    level ENUM('undergraduate', 'graduate', 'phd') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES Departments(department_id)
);

-- Academic Terms table
CREATE TABLE AcademicTerms (
    term_id INT PRIMARY KEY AUTO_INCREMENT,
    term_name VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_active BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--  Course Offerings table 
CREATE TABLE CourseOfferings (
    offering_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    term_id INT,
    instructor_id INT,
    max_students INT NOT NULL,
    current_enrolled INT DEFAULT 0,
    status ENUM('scheduled', 'in_progress', 'completed', 'cancelled') NOT NULL,
    FOREIGN KEY (course_id) REFERENCES Courses(course_id),
    FOREIGN KEY (term_id) REFERENCES AcademicTerms(term_id),
    FOREIGN KEY (instructor_id) REFERENCES Users(user_id)
);

--  table for Time Slots
CREATE TABLE TimeSlots (
    slot_id INT PRIMARY KEY AUTO_INCREMENT,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    UNIQUE KEY unique_time_slot (day_of_week, start_time, end_time)
);

--  Class Schedule table
CREATE TABLE ClassSchedule (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    offering_id INT,
    room_id INT,
    slot_id INT,
    recurring BOOLEAN DEFAULT TRUE,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (offering_id) REFERENCES CourseOfferings(offering_id),
    FOREIGN KEY (room_id) REFERENCES Rooms(room_id),
    FOREIGN KEY (slot_id) REFERENCES TimeSlots(slot_id),
    FOREIGN KEY (created_by) REFERENCES Users(user_id)
);

-- Create table for Student Enrollments 
CREATE TABLE StudentEnrollments (
    enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    offering_id INT,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('enrolled', 'withdrawn', 'completed') DEFAULT 'enrolled',
    FOREIGN KEY (student_id) REFERENCES Users(user_id),
    FOREIGN KEY (offering_id) REFERENCES CourseOfferings(offering_id),
    UNIQUE KEY unique_enrollment (student_id, offering_id)
);

-- Create Schedule Changes
CREATE TABLE ScheduleChangesLog (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    schedule_id INT,
    changed_by INT,
    change_type ENUM('created', 'updated', 'deleted') NOT NULL,
    change_description TEXT NOT NULL,
    previous_value TEXT,
    new_value TEXT,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (schedule_id) REFERENCES ClassSchedule(schedule_id),
    FOREIGN KEY (changed_by) REFERENCES Users(user_id)
);

-- indexes for better performance
CREATE INDEX idx_course_department ON Courses(department_id);
CREATE INDEX idx_offering_course ON CourseOfferings(course_id);
CREATE INDEX idx_offering_term ON CourseOfferings(term_id);
CREATE INDEX idx_schedule_offering ON ClassSchedule(offering_id);
CREATE INDEX idx_schedule_room ON ClassSchedule(room_id);
CREATE INDEX idx_enrollment_student ON StudentEnrollments(student_id);
CREATE INDEX idx_enrollment_offering ON StudentEnrollments(offering_id);

-- Add constraints
ALTER TABLE CourseOfferings
ADD CONSTRAINT check_enrollment 
CHECK (current_enrolled <= max_students);

ALTER TABLE ClassSchedule
ADD CONSTRAINT check_dates 
CHECK (end_date >= start_date);

ALTER TABLE AcademicTerms
ADD CONSTRAINT check_term_dates 
CHECK (end_date >= start_date);
