<?php

require_once("../db/db.php");
require_once("../user/user.php");
require_once("../faculty-member/faculty-member.php");
require_once("../student/student.php");

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

// Create a user object
$user = new User($connection);

// Get current user information
$currentUser = $user->getUserById($userId);

$facultyMember = new FacultyMember($connection);
$currentFacultyMember = $facultyMember->getFacultyMemberByUserId($userId);

$student = new Student($connection);
$currentStudent = $student->getStudentByUserId($userId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../styles/common.css" />

  <title>Web events - Home </title>
</head>

<body>
  <h1>Welcome to Web events</h1>
  <div class="menu">
    <a href="../subjects/subjects.php" class="common-button">Browse subjects
    </a>
    <?php
    // Check if the user is an admin to display the "Create Subject" button
    if ($currentUser['is_admin'] === 1) {
    ?>
      <a href="../subjects/create_subject.html" class="common-button">Create subject</a>
      <a href="../fm-x-subject/assign_subject_view.php" class="common-button">Assign subject </a>
      <a href="../event-recordings/event_recordings_approval_page.php" class="common-button">Event recordings awaiting approval</a>
      <a href="../student/import_students.html" class="common-button">Import students</a>
      <a href="../faculty-member/import_faculty_members.html" class="common-button">Import faculty members</a>
    <?php
    }
    ?>
    <?php
    // Check if the user is a student to display the "My attendances" button
    if ($currentStudent) {
    ?>
      <a href="../attendance/my_attendances.php" class="common-button">My attendances</a>
    <?php
    }
    ?>
    <?php
    // Check if the user is a faculty member or an admin to display the Attendances" button
    if ($currentFacultyMember || $currentUser['is_admin'] === 1) {
    ?>
      <a href="../events/create_event_view.php" class="common-button">Create an event</a>
      <a href="../attendance/attendances_page.php" class="common-button">Attendances</a>
    <?php
    }
    ?>
    <a href="../events/events.php" class="common-button">Browse events</a>
    <a href="../logout/logout.php" class="common-button">Log out</a>
  </div>
</body>

</html>