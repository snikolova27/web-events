<?php

require_once("../db/db.php");
require_once("../user/user.php");
require_once("../faculty-member/faculty-member.php");
require_once("../student/student.php");

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

echo '<nav class="navbar">';
echo '<a href="../home/home.php" class="nav-link">Home</a>';

if ($currentUser['is_admin'] === 1) {
    echo '<a href="../subjects/create_subject_view.php" class="nav-link">Create Subject</a>';
    echo '<a href="../fm-x-subject/assign_subject_view.php" class="nav-link">Assign subject </a>';
    echo '<a href="../event-recordings/event_recordings_approval_page.php" class="nav-link">Event recordings awaiting approval</a>';
    echo '<a href="../student/import_students_view.php" class="nav-link">Import students</a>';
    echo '<a href="../faculty-member/import_faculty_members_view.php" class="nav-link">Import faculty members</a>';
    echo '<a href="../student/export_students.php" class="nav-link">Export students</a>';
    echo '<a href="../faculty-member/export_faculty_members.php" class="nav-link">Export faculty members</a>';
}

if ($currentStudent) {
    echo '<a href="../attendance/my_attendances.php" class="nav-link">My attendances</a>';
}

if ($currentFacultyMember || $currentUser['is_admin'] === 1) {
    echo '<a href="../events/create_event_view.php" class="nav-link">Create an event</a>';
    echo '<a href="../attendance/attendances_page.php" class="nav-link">Attendances</a>';
}

echo '<a href="../events/events.php" class="nav-link">Browse events</a>';
echo '<a href="../logout/logout.php" class="nav-link">Log out</a>';

echo '</nav>';
?>