<?php

require_once("../db/db.php");
require_once("../user/user.php");
require_once("../faculty-member/faculty-member.php");
require_once("../events/event.php");
require_once("attendance.php");
require_once('../student/student.php');

session_start();

// Check if the user is authenticated (has a valid session)
if (!isset($_SESSION['user_token'])) {
    // Redirect to the sign-in page if not authenticated
    header("Location: ../signin/signin.php");
    exit();
}

// Access the user's ID if needed
$userId = $_SESSION['user_id'];

// Create a database connection
$db = new Db();
$connection = $db->getConnection();

// Create a Event object
$event = new Event($connection);

// Create a User object
$user = new User($connection);

// Get all subjects
$events = $event->getAllEvents();

// Get current user information
$currentUser = $user->getUserById($userId);

$student = new Student($connection);
$currentStudent = $student->getStudentByUserId($userId);

if (!$currentStudent) {
    // Redirect to the sign-in page if not authenticated
    header("Location: ../signin/signin.php");
    exit();
}

$attendance = new Attendance($connection);
$attentedEvents = $attendance->getEventsWithDetailsForFn($currentStudent['fn']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/common.css">
    <link rel="stylesheet" type="text/css" href="../styles/subjects.css">
    <link rel="stylesheet" type="text/css" href="../styles/navbar.css" />
    <title>My attendances - Web events</title>
</head>

<body>
    <h1> My attendances </h1>
    <?php include_once("../navbar/navbar.php"); ?>
    <?php
    // Check if there are events
    if ($attentedEvents) {
    ?>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Subject Name</th>
                    <th>Led by</th>
                    <th>Start Date Time</th>
                    <th>End Date Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display the events in the table
                foreach ($events as $event) {
                    echo "<tr>";
                    echo "<td><a href=../events/event_view.php?event_id={$event['id']}>{$event['event_name']}</a></td>";
                    echo "<td>{$event['subject_name']}</td>";
                    echo "<td>{$event['faculty_member_name']}</td>";
                    echo "<td>{$event['start_date_time']}</td>";
                    echo "<td>{$event['end_date_time']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        // Display message when no events are available
        echo '<p class="no-results">No events available.</p>';
    }
    ?>
</body>

</html>