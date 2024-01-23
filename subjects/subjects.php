<?php

require_once("../db/db.php");
require_once("../user/user.php");
require_once("../faculty-member/faculty-member.php");
require_once("subject.php");
session_start();

// Check if the user is authenticated (has a valid session)
if (!isset($_SESSION['user_token'])) {
    // Redirect to the sign-in page if not authenticated
    header("Location: ../signin/signin.php");
    exit();
}

// Access the user's ID if needed
$userId = $_SESSION['user_id'];

// Create a database connection
$db = new Db();
$connection = $db->getConnection();

// Create a Subject object
$subject = new Subject($connection);

// Create a User object
$user = new User($connection);

// Get all subjects
$subjects = $subject->getAllSubjects();

// Get current user information
$currentUser = $user->getUserById($userId);

$facultyMember = new FacultyMember($connection);
$currentFacultyMember = $facultyMember->getFacultyMemberByUserId($userId)

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/common.css">
    <link rel="stylesheet" type="text/css" href="../styles/subjects.css">
    <title>Subjects - Web events</title>
</head>

<body>
    <h1> Subjects </h1>
    <div class="horizontal-menu">
        <a href="../home/home.php" class="common-button">Back to home</a>
        <?php
        // Check if the user is a faculty member or an adminto display the Attendances" button
        if ($currentFacultyMember || $currentUser['is_admin'] === 1) {
        ?>
            <a href="create_subject.html" class="common-button">Create a subject</a>
        <?php
        }
        ?>
    </div>
    <?php
    // Check if there are subjects
    if ($subjects) {
    ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display the subjects in the table
                foreach ($subjects as $row) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        // Display message when no subjects are available
        echo '<p class="no-results">No subjects available.</p>';
    }
    ?>



</body>

</html>