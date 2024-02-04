<?php

require_once("../db/db.php");
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

// Create a attendance object
$attendance = new Attendance($connection);

// Get current user 
$attendanceInformation = $attendance->getAllAttendancesWithEventInfo();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/common.css">
    <link rel="stylesheet" type="text/css" href="../styles/subjects.css">
    <link rel="stylesheet" type="text/css" href="../styles/navbar.css" />
    <title>Attendances - Web events</title>
</head>

<body>
    <h1> Attendances </h1>
    <?php include_once("../navbar/navbar.php"); ?>
    <?php
    // Check if there are subjects
    if ($attendanceInformation) {
    ?>
        <table>
            <thead>
                <tr>
                    <th>Faculty number</th>
                    <th>Event name</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Subject</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display the attendanceInformation in the table
                foreach ($attendanceInformation as $row) {
                    echo "<tr>";
                    echo "<td>{$row['fn']}</td>";
                    echo "<td>{$row['event_name']}</td>";
                    echo "<td>{$row['start_date_time']}</td>";
                    echo "<td>{$row['end_date_time']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        // Display message when no attendanceInformation is available
        echo '<p class="no-results">No attendance information available.</p>';
    }
    ?>
</body>

</html>