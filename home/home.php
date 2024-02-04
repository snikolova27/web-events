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
  <link rel="stylesheet" type="text/css" href="../styles/navbar.css" />

  <title>Web events - Home </title>
</head>

<body>
  <h1>Welcome to Web events</h1>
  <?php include_once("../navbar/navbar.php"); ?>
  <div class="content">
    <p>Welcome to Web Events, the ultimate platform for managing and attending academic events! Here, you can browse upcoming events, sign up for ones that interest you, and even access recordings of past events. Faculty members can create and manage their events. Dive into our rich database of subjects, attendances, and educational resources tailored just for you. Get started by exploring our events or managing your attendances today!</p>
  </div>

</body>

</html>