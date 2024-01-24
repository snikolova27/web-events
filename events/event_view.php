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
$currentFn = $currentStudent ? $currentStudent['fn'] : null;
$didCurrentStudentAttendEvent = $attendance->getAttencersByFnAndEventId($eventId,$currentFn);
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
        <ul id= "commentsList">
            <?php foreach ($comments as $comment) : ?>
                <li><?php echo $comment['comment'], ' ', $comment['review']; ?></li>
            <?php endforeach; ?>
        </ul>

    <?php else : ?>
        <p>No comments for this event.</p>
    <?php endif; ?>
    <?php if ($didCurrentStudentAttendEvent) {
    ?>
        <button class="common-button" onclick="toggleInput('comment')">Add comment</button>
        <div id="commentInput" style="display:none;">
            <input type="text" id="commentText" placeholder="Write a comment">
            <input type="number" id="commentReview" placeholder="What is your review (1-5)">
            <button class="common-button" onclick="submitComment()">Submit</button>
        </div>
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
        <button class="common-button" onclick="toggleInput('recording')">Add link to event recordings</button>
        <div id="recordingInput" style="display:none;">
            <input type="text" id="recording" placeholder="Paste your link to the recording">
            <button class="common-button" onclick="submitRecording()">Submit</button>
        </div>
    <?php
    }
    ?>

    <h3>Resources</h3>
    <?php if ($resources) : ?>
        <ul id="resourcesList">
            <?php foreach ($resources as $resource) : ?>
                <li><a href="<?php echo $resource['link']; ?>" target="_blank"><?php echo $resource['link']; ?></a></li>
                <?php endforeach; ?>
        </ul>

    <?php else : ?>
        <p>No resources for this event.</p>
    <?php endif; ?>
    <?php if ($didCurrentStudentAttendEvent) {
    ?>
        <button class="common-button" onclick="toggleInput('resource')">Add link to resource</button>
        <div id="resourceInput" style="display:none;">
            <input type="text" id="link" placeholder="Paste your resource">
            <button class="common-button" onclick="submitResource()">Submit</button>
        </div>
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

        // Function to toggle input fields
        function toggleInput(type) {
            document.getElementById(type + 'Input').style.display = 'block';
        }

        // Function to submit a comment
        function submitComment() {
            var commentText = document.getElementById('commentText').value;
            var commentReview = document.getElementById('commentReview').value;
            var eventId = <?php echo json_encode($eventId); ?>;
            
            // Validate that the comment is not empty
            if (commentText.trim() === '') {
                alert('Please enter a comment.');
                return;
            }

             // AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../event-comments/add-comment.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                // Check if the request was successful
                if (xhr.status >= 200 && xhr.status < 300) {

                    // Hide the input field
                    document.getElementById('commentInput').style.display = 'none';
                        
                    // Reset the input field
                    document.getElementById('commentText').value = '';
                    document.getElementById('commentReview').value = '';

                    // Optionally, update the UI to show the new comment
                    // This could be adding the new comment to a list of comments, for example
                    var commentsList = document.getElementById('commentsList'); // Assuming you have an element with this ID
                    var newComment = document.createElement('li');
                    newComment.textContent = commentText + ' ' + commentReview;
                    commentsList.appendChild(newComment);
                } else {
                    // Handle request errors here (e.g., network issues)
                    alert('Failed to send request to the server.' + xhr.status);
                }
            };
            xhr.onerror = function () {
                // Handle network errors
                alert('Network error occurred while sending request.');
            };

            // Send the request with the comment data
            xhr.send('comment=' + encodeURIComponent(commentText) + '&review=' + encodeURIComponent(commentReview) + '&event_id=' + encodeURIComponent(eventId));
        }

        // Function to submit a resource
        function submitResource() {
            var resourceLink = document.getElementById('link').value;
            var eventId = <?php echo json_encode($eventId); ?>;
            
            // Validate that the comment is not empty
            if (resourceLink.trim() === '') {
                alert('Please enter a resource link.');
                return;
            }

             // AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../event-resources/add-resource.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                // Check if the request was successful
                if (xhr.status >= 200 && xhr.status < 300) {

                    // Hide the input field
                    document.getElementById('resourceInput').style.display = 'none';
                        
                    // Reset the input field
                    document.getElementById('link').value = '';

                    // Optionally, update the UI to show the new comment
                    // This could be adding the new comment to a list of comments, for example
                    var resourcesList = document.getElementById('resourcesList'); // Assuming you have an element with this ID
                    var newResource = document.createElement('li');
                    var link = document.createElement('a'); // Create an anchor element
                    link.href = resourceLink; // Set the href attribute to your resourceLink
                    link.textContent = resourceLink; // Set the text content to display the link
                    newResource.appendChild(link); // Append the anchor element to the list item
                    resourcesList.appendChild(newResource); // Append the list item to the list
                } else {
                    // Handle request errors here (e.g., network issues)
                    alert('Failed to send request to the server.' + xhr.status);
                }
            };
            xhr.onerror = function () {
                // Handle network errors
                alert('Network error occurred while sending request.');
            };

            // Send the request with the comment data
            xhr.send('link=' + encodeURIComponent(resourceLink) + '&event_id=' + encodeURIComponent(eventId));
        }

        // Function to submit a recording link
        function submitRecording() {
            var recordingLink = document.getElementById('recording').value;
            var eventId = <?php echo json_encode($eventId); ?>;
            
            // Validate that the comment is not empty
            if (recordingLink.trim() === '') {
                alert('Please enter a recording link.');
                return;
            }

             // AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../event-recordings/add-recording.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                // Check if the request was successful
                if (xhr.status >= 200 && xhr.status < 300) {

                    // Hide the input field
                    document.getElementById('recordingInput').style.display = 'none';
                        
                    // Reset the input field
                    document.getElementById('recording').value = '';
                } else {
                    // Handle request errors here (e.g., network issues)
                    alert('Failed to send request to the server.' + xhr.status);
                }
            };
            xhr.onerror = function () {
                // Handle network errors
                alert('Network error occurred while sending request.');
            };

            // Send the request with the comment data
            xhr.send('recording=' + encodeURIComponent(recordingLink) + '&event_id=' + encodeURIComponent(eventId));
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