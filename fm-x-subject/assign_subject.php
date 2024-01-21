<?php
require_once '../db/db.php';
require_once '../user/user.php';
require_once '../faculty-member/faculty-member.php';
require_once '../subjects/subject.php';
require_once '../fm-x-subject/fm_x_subject.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a database connection
    $db = new Db();
    $connection = $db->getConnection();

    // Set user properties
    $email = $_POST['faculty_member_email'];
    $subjectName = $_POST['subject_name'];

    $user = new User($connection);
    $userData = $user->getUserByEmail2($email);

    if (!$userData) {
        echo "Unable to fetch user with e-mail: " . $email;
        header("Location: ../home/home.php");
        exit();
    }

    $facultyMember = new FacultyMember($connection);
    $facultyMemberData = $facultyMember->getFacultyMemberByUserId($userData['id']);

    if (!$facultyMemberData) {
        echo "Unable to fetch faculty member with user id: " . $userData['id'];
        header("Location: ../home/home.php");
        exit();
    }

    $subject = new Subject($connection);
    $subjectData = $subject->getSubjectByName($subjectName);

    if (!$subjectData) {
        echo "Unable to fetch subject with name: " . $subjectData['name'];
        header("Location: ../home/home.php");
        exit();
    }

    $fmXSubject = new FmXSubject($connection);

    $fmXSubject->fm_id = $facultyMemberData['fm_id'];
    $fmXSubject->subject_id = $subjectData['id'];
    $fmXSubject->start_date = $_POST['start_date'];
    $fmXSubject->end_date = $_POST['end_date'];

    // Create the fmXSubject
    try {
        $fmXSubject->create();
        header("Location: ../home/home.php");
        exit();
    } catch (PDOException $e) {
        echo "Error creating user: " . $e->getMessage();
        header("Location: ../home/home.php");
        exit();
    }
}
