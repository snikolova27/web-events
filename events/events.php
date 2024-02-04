<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/common.css">
    <link rel="stylesheet" type="text/css" href="../styles/subjects.css">
    <link rel="stylesheet" type="text/css" href="../styles/navbar.css" />
    <title>Events - Web events</title>
</head>

<body>
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
    <h1>Events</h1>
    <?php include_once("../navbar/navbar.php"); ?>
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
                    echo "<tr class='clickable-row' data-href='event_view.php?event_id={$event['id']}'>";
                    echo "<td>{$event['id']}</td>";
                    echo "<td>{$event['event_name']}</td>";
                    echo "<td>{$event['subject_name']}</td>";
                    echo "<td>{$event['faculty_member_name']}</td>";
                    echo "<td>{$event['start_date_time']}</td>";
                    echo "<td>{$event['end_date_time']}</td>";
                    echo "<td>{$attendance->getAttendancesByEventId($event['id'])}</td>";
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rows = document.querySelectorAll("tr.clickable-row");
            rows.forEach(row => {
                row.addEventListener("click", function() {
                    window.location.href = this.dataset.href;
                });
            });
        });
    </script>
</body>

</html>