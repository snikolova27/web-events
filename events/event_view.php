<?php
// Assuming you have a database connection and relevant classes
require_once("../db/db.php");
require_once("event.php");
require_once("../event-comments/event-comments.php");
require_once("../event-recordings/event-recordings.php");
require_once("../event-resources/event-resources.php");
require_once("../user/user.php");
require_once("../student/student.php");
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

// Get event ID from the query parameters
$eventId = isset($_GET['event_id']) ? $_GET['event_id'] : null;

// Redirect to an browse events page if no event ID is provided
if (!$eventId) {
    header("Location: events.php");
    exit();
}

// Create a database connection
$db = new Db();
$connection = $db->getConnection();

// Create event, event-comments, event resources and event recordings
$event = new Event($connection);
$eventComments = new EventComment($connection);
$eventRecordings = new EventRecording($connection);
$eventResources = new EventResource($connection);

// Get event details
$eventDetails = $event->getEventDetailsById($eventId);

// Redirect to an error page if the event is not found
if (!$eventDetails) {
    header("Location: error.php");
    exit();
}

// Get comments for the event
$comments = $eventComments->getAllCommentsForEvent($eventId);

// Get resources for the event
$resources = $eventResources->getAllResourceLinksForEvent($eventId);

// Get approved recordings for the event
$approvedLinks = $eventRecordings->getApprovedEventRecordingsByEventId($eventId);


$student = new Student($connection);
$currentStudent = $student->getStudentByUserId($userId);

$attendance = new Attendance($connection);
$didCurrentStudentAttendEvent = $attendance->getAttencersByFnAndEventId($eventId, $currentStudent['fn']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/common.css">
    <title>Event Details - Web events</title>
</head>

<body>
    <h1>Event Details</h1>
    <div class="horizontal-menu">
        <p><a href="events.php" class="common-button">Back to Events</a></p>
    </div>

    <h2><?php echo "{$eventDetails['event_name']}" ?></h2>
    <p>Start Date: <?php echo "{$eventDetails['start_date_time']}" ?></p>
    <p>Start Date: <?php echo $eventDetails['end_date_time']; ?></p>
    <p>Subject: <?php echo $eventDetails['subject_name']; ?></p>
    <p>Led by: <?php echo $eventDetails['faculty_member_name']; ?></p>


    <?php
    // Check if the user is a student to display the "Sign up for event" button
    if ($currentStudent && !$didCurrentStudentAttendEvent) {
    ?>
        <hr>
        <div id="signupModal" class="modal">
            <div class="modal-content">
                <h2>Event Sign Up</h2>
                <p>Enter the event password to sign up:</p>
                <input type="password" id="eventPassword" placeholder="Event Password" data-eventid="<?php $eventId ?>">
                <button onclick="submitSignUp()" class="common-button">Sign up for event</button>
                <p id="signupMessage"></p>
            </div>
        </div>
        <hr>
    <?php
    }
    ?>

    <h3>Comments</h3>
    <?php if ($comments) : ?>
        <ul>
            <?php foreach ($comments as $comment) : ?>
                <li><?php echo $comment['comment']; ?></li>
            <?php endforeach; ?>
        </ul>

    <?php else : ?>
        <p>No comments for this event.</p>
    <?php endif; ?>
    <?php if ($didCurrentStudentAttendEvent) {
    ?>
        <button class="common-button">Add comment</button>
    <?php
    }
    ?>

    <h3>Event recordings</h3>
    <?php if ($approvedLinks) : ?>
        <ul>
            <?php foreach ($approvedLinks as $approvedLink) : ?>
                <li><a href="<?php echo $approvedLink['link']; ?>" target="_blank"><?php echo $approvedLink['link']; ?></a></li>
            <?php endforeach; ?>
        </ul>

    <?php else : ?>
        <p>No recordings for this event.</p>
    <?php endif; ?>
    <?php if ($didCurrentStudentAttendEvent) {
    ?>
        <button class="common-button">Add link to event recordings</button>
    <?php
    }
    ?>

    <h3>Resources</h3>
    <?php if ($resources) : ?>
        <ul>
            <?php foreach ($resources as $resource) : ?>
                <li><a href="<?php echo $approvedLink['link']; ?>" target="_blank"><?php echo $approvedLink['link_title']; ?></a></li>
                <?php endforeach; ?>resource
        </ul>

    <?php else : ?>
        <p>No resources for this event.</p>
    <?php endif; ?>
    <?php if ($didCurrentStudentAttendEvent) {
    ?>
        <button class="common-button">Add link to resource</button>
    <?php
    }
    ?>



    <script>
        // Get the modal
        var modal = document.getElementById('signupModal');

        // Function to open the modal
        function openModal(eventId) {
            modal.style.display = "block";
            // Pass the event ID to the modal for further processing
            document.getElementById("eventPassword").setAttribute("data-eventid", eventId);
        }

        // Function to reset modal fields
        function resetModal() {
            document.getElementById("eventPassword").value = "";
            document.getElementById("signupMessage").innerText = "";
        }

        // Function to handle event sign-up
        function submitSignUp() {
            var eventId = document.getElementById("eventPassword").getAttribute("data-eventid");
            var eventPassword = document.getElementById("eventPassword").value;

            // Perform AJAX request to validate event password and sign up
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response from the server
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("signupMessage").innerText = response.message;
                }
            };
            xhr.open("POST", "process_event_signup.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("eventId=" + eventId + "&eventPassword=" + eventPassword);
        }

        // Trigger the modal to open automatically when the page loads
        window.onload = function() {
            <?php
            // Echo the PHP variable $eventId into a JavaScript variable
            echo "var phpEventId = " . json_encode($eventId) . ";";
            ?>
            // Open the modal with the PHP variable $eventId
            openModal(phpEventId);
        };
    </script>
</body>

</html>