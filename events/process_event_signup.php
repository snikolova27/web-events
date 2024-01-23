<?php
require_once '../db/db.php';
require_once '../attendance/attendance.php';
require_once 'event.php';
require_once "../student/student.php";

session_start();

// Check if the user is authenticated (has a valid session)
if (!isset($_SESSION['user_token'])) {
    // Redirect to the sign-in page if not authenticated
    header("Location: ../signin/signin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a database connection
    $db = new Db();
    $connection = $db->getConnection();

    // Create instances of Event
    $event = new Event($connection);

    // Create instances of Attendance
    $attendance = new Attendance($connection);

    $student = new Student($connection);

    $eventId = $_POST["eventId"];
    $eventPassword = $_POST["eventPassword"];
    $userId = $_SESSION["user_id"];

    $currentStudent = $student->getStudentByUserId($userId);


    // Validate event password 
    $validPassword = validateEventPassword($event, $eventId, $eventPassword);

    if ($validPassword) {
        // Insert entry into attendance table
        $attendanceInserted = insertAttendance($attendance, $eventId, $currentStudent);

        if ($attendanceInserted) {
            $response = array("success" => true, "message" => "Sign up successful!");
        } else {
            $response = array("success" => false, "message" => "Failed to sign up. Please try again.");
        }
    } else {
        $response = array("success" => false, "message" => "Wrong event password. Please try again.");
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

function validateEventPassword($event, $eventId, $eventPassword)
{
    $foundEvent = $event->getEventByIdAndPassword($eventId, $eventPassword);

    return $foundEvent  ? true : false;
}

function insertAttendance($attendance, $eventId, $currentStudent)
{
    if ($currentStudent && $eventId) {
        $attendance->fn = $currentStudent['fn'];
        $attendance->event_id = $eventId;
        return  $attendance->create();
    }
    return false;
}
