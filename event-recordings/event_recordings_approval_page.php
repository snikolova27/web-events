<?php

require_once("../db/db.php");
require_once("event-recordings.php");

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

// Create an event recording object
$eventRecording = new EventRecording($connection);

$notApprovedRecordings = $eventRecording->getNotApprovedEventRecordingsdWithDetails();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/common.css">
    <link rel="stylesheet" type="text/css" href="../styles/subjects.css">
    <title>Event recordings awaiting approval - Web events</title>
</head>

<body>
    <h1> Event recordings awaiting approval </h1>
    <?php
    // Check if there are subjects
    if ($notApprovedRecordings) {
    ?>
        <table>
            <thead>
                <tr>
                    <th>Event name</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Subject</th>
                    <th>Led by</th>
                    <th>Link</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display the notApprovedRecordings in the table
                foreach ($notApprovedRecordings as $row) {
                    echo "<tr>";
                    echo "<td>{$row['event_name']}</td>";
                    echo "<td>{$row['start_date_time']}</td>";
                    echo "<td>{$row['end_date_time']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['names']}</td>";
                    echo "<td>{$row['link']}</td>";
                    echo "<td><button onclick=\"approveRecording({$row['event_id']}, '{$row['link']}')\" class='common-button'>Approve</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <script>
            // JavaScript function to handle the approval
            function approveRecording(eventId, link) {
                // You can use AJAX to send the approval request to the server
                // Here, I'm providing a simple alert as an example\
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.status == 200) {
                        // Handle the response from the server
                        var response = JSON.parse(xhr.responseText);
                        alert(response.message);
                        window.location.reload();

                    }
                };
                xhr.open("POST", "process_event_link_approval.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("eventId=" + eventId + "&link=" + link);

            }
        </script>
    <?php
    } else {
        // Display message when no notApprovedRecordings is available
        echo '<p class="no-results">No event recordings awaiting approval available.</p>';
    }
    ?>
    <div class="menu">
        <a href="../home/home.php" class="common-button">Back to home</a>

    </div>
</body>

</html>