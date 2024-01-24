<?php
require_once '../db/db.php';
require_once("event-recordings.php");

session_start();

// Check if the user is authenticated (has a valid session)
if (!isset($_SESSION['user_token'])) {
    // Redirect to the sign-in page if not authenticated
    header("Location: ../signin/signin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a database connection
    $db = new Db();
    $connection = $db->getConnection();

    // Create instances of EventRecording
    $eventRecording = new EventRecording($connection);

    $eventId = $_POST["eventId"];
    $link = $_POST["link"];

    $updatedRecording = $eventRecording->approveLinkForEvent($link, $eventId);

    if ($updatedRecording) {
        $response = array("success" => true, "message" => "Link approval successful!");
    } else {
        $response = array("success" => false, "message" => "Link approval was not successful. Please try again.");
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}