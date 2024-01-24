<?php
// Include necessary files
require_once("../db/db.php");
require_once("event-comments.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $db = new Db();
    $connection = $db->getConnection();

    if (isset($_POST['comment']) && isset($_POST['review']) && isset($_POST['event_id'])) {
        $commentText = $_POST['comment'];
        $review = $_POST['review'];
        $eventId = $_POST['event_id'];

        // Perform validation and sanitization on $commentText and $eventId

        $eventComments = new EventComment($connection);
        $result = $eventComments->addCommentToEvent($eventId, $commentText, $review);

        // Return a JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }
}
?>
