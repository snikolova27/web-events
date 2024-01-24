<?php
// Include necessary files
require_once("../db/db.php");
require_once("event-recordings.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $db = new Db();
    $connection = $db->getConnection();

    if (isset($_POST['recording']) && isset($_POST['event_id'])) {
        $recordingLink = $_POST['recording'];
        $eventId = $_POST['event_id'];

        // Perform validation and sanitization on $commentText and $eventId

        $eventRecordings = new EventRecording($connection);
        $result = $eventRecordings->addRecordingToEvent($eventId, $recordingLink);

        // Return a JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }
}
?>
