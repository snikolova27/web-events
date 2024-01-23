<?php
// Assuming you have a database connection and relevant classes
require_once("../db/db.php");
require_once("event.php");
require_once("../event-comments/event-comments.php");
require_once("../event-recordings/event-recordings.php");
require_once("../event-resources/event-resources.php");


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

    <h2><?php echo "{$eventDetails['event_name']}" ?></h2>
    <p>Start Date: <?php echo "{$eventDetails['start_date_time']}" ?></p>
    <p>Start Date: <?php echo $eventDetails['end_date_time']; ?></p>
    <p>Subject: <?php echo $eventDetails['subject_name']; ?></p>
    <p>Led by: <?php echo $eventDetails['faculty_member_name']; ?></p>


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

    <h3>Event recordings</h3>
    <?php if ($approvedLinks) : ?>
        <ul>
            <?php foreach ($approvedLinks as $approvedLink) : ?>
                <li><a href="<?php echo $approvedLink['link']; ?>" target="_blank"><?php echo $approvedLink['link_title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No recordings for this event.</p>
    <?php endif; ?>

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

    <p><a href="events.php" class="common-button">Back to Events</a></p>
</body>

</html>