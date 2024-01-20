<?php
require_once '../db/db.php';
require_once '../user/user.php';
require_once '../faculty-member/faculty-member.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a database connection
    $db = new Db();
    $connection = $db->getConnection();

    // Create instances of User and Faculty member classes
    $user = new User($connection);
    $faculty_member = new FacultyMember($connection);

    // Set user properties
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    // Create the user
    try {
        $user->create();
        // Set faculty member properties
        $last_registered_user =$user->getLastRegisteredUser();
        $faculty_member->user_id = $last_registered_user['id'];

        try {
            $faculty_member->create();
        } catch (PDOException $e) {
            echo "Error creating faculty member: " . $e->getMessage();
            return null;
        }

        header("Location: ../home/home.html");
        exit();
    } catch (PDOException $e) {
        echo "Error creating user: " . $e->getMessage();
        return null;
    }
}
