<?php
require_once '../db/db.php';
require_once 'subject.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a database connection
    $db = new Db();
    $connection = $db->getConnection();

    // Create instances of Subject
    $subject = new Subject($connection);

    // Set user properties
    $subject->name = $_POST['name'];

    // Create the subject
    try {
        $subject->create();
        header("Location: ../subjects/subjects.php");
        exit();
    } catch (PDOException $e) {
        echo "Error creating user: " . $e->getMessage();
        header("Location: ../home/home.php");
        exit();
    }
}
