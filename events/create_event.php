<?php
require_once '../db/db.php';
require_once 'event.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a database connection
    $db = new Db();
    $connection = $db->getConnection();

    // Create instances of Event
    $event = new Event($connection);

    // Set event properties
    $event->event_name = $_POST['event_name'];
    $event->event_password = $_POST['event_password'];
    $event->start_date_time = $_POST['start_date_time'];
    $event->end_date_time = $_POST['end_date_time'];
    $event->fm_x_subject_id = $_POST['fm_x_subject_id'];

    // Create the event
    try {
        $event->create();
        header("Location: ../events/events.php");
        exit();
    } catch (PDOException $e) {
        echo "Error creating user: " . $e->getMessage();
        // header("Location: ../home/home.php");
        exit();
    }
}
