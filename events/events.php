<?php

require_once("../db/db.php");
require_once("../user/user.php");
require_once("../faculty-member/faculty-member.php");
require_once("event.php");
require_once("../attendance/attendance.php");

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

$facultyMember = new FacultyMember($connection);
$currentFacultyMember = $facultyMember->getFacultyMemberByUserId($userId);

$attendance = new Attendance($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/common.css">
    <link rel="stylesheet" type="text/css" href="../styles/subjects.css">
    <title>Events - Web events</title>
</head>

<body>
    <h1> Events </h1>
        <div class="horizontal-menu">
            <a href="../home/home.php" class="common-button">Back to home</a>
            <?php
            // Check if the user is a faculty member or an admin to display the button for creation of an event
            if ($currentFacultyMember || $currentUser['is_admin'] === 1) {
            ?>
                <a href="create_event_view.php" class="common-button">Create an event</a>
            <?php
            }
            ?>
        </div>
        <?php
        // Check if there are events
        if ($events) {
        ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Name</th>
                        <th>Subject Name</th>
                        <th>Led by</th>
                        <th>Start Date Time</th>
                        <th>End Date Time</th>
                        <th>Attendees count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display the subjects in the table
                    foreach ($events as $event) {
                        echo "<tr>";
                        echo "<td>{$event['id']}</td>";
                        echo "<td><a href=event_view.php?event_id={$event['id']}>{$event['event_name']}</a></td>";                        echo "<td>{$event['subject_name']}</td>";
                        echo "<td>{$event['faculty_member_name']}</td>";
                        echo "<td>{$event['start_date_time']}</td>";
                        echo "<td>{$event['end_date_time']}</td>";
                        echo "<td>{$attendance ->getAttendancesByEventId($event['id'])}</td>";
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