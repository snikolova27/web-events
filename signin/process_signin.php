<?php
require_once '../db/db.php';
require_once '../user/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a database connection
    $db = new Db();
    $connection = $db->getConnection();

    // Create an instance of the User class
    $user = new User($connection);

    // Set user properties
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    // Check if the user exists
    $userData = $user->getUserByEmail();

    if ($userData) {
         // Verify the entered password
         if (password_verify($user->password, $userData['password'])) {
            // Password is correct, user is signed in
            echo "Sign-in successful. Welcome, {$userData['names']}!";
        } else {
            // Redirect with incorrect password error
            header("Location: signin.php?error=incorrect_password");
            exit();
        }
    } else {
        // Redirect with user not found error
        header("Location: signin.php?error=user_not_found");
        exit();
    }
} else {
    // Redirect if accessed directly
    header("Location: signin.php");
    exit();
}
