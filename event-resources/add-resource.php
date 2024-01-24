<?php
// Include necessary files
require_once("../db/db.php");
require_once("event-resources.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $db = new Db();
    $connection = $db->getConnection();

    if (isset($_POST['link']) && isset($_POST['event_id'])) {
        $resourceLink = $_POST['link'];
        $eventId = $_POST['event_id'];

        // Perform validation and sanitization on $commentText and $eventId

        $eventResources = new EventResource($connection);
        $result = $eventResources->addResourceToEvent($eventId, $resourceLink);

        // Return a JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }
}
?>
