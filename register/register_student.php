<?php
require_once '../db/db.php';
require_once '../user/user.php';
require_once '../student/student.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a database connection
    $db = new Db();
    $connection = $db->getConnection();

    // Create instances of User and Student classes
    $user = new User($connection);
    $student = new Student($connection);

    // Set user properties
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->names - $_POST['name'];

    // Create the user
    try {
        $user->create();
        // Set student properties
        $student->fn = $_POST['fn'];
        $student->major = $_POST['major'];
        $student->adm_group = $_POST['adm_group'];
        $last_registered_user =$user->getLastRegisteredUser();
        $student->user_id = $last_registered_user['id'];

        try {
            $student->create();
        } catch (PDOException $e) {
            echo "Error creating student: " . $e->getMessage();
            return null;
        }

        header("Location: ../home/home.html");
        exit();
    } catch (PDOException $e) {
        echo "Error creating user: " . $e->getMessage();
        return null;
    }
}
