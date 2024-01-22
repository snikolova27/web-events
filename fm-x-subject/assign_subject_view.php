<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../styles/forms.css" />
    <link rel="stylesheet" type="text/css" href="../styles/common.css" />

    <title>Subject Assigning - Web events</title>
  </head>
  <body>
    <?php
    require_once "../db/db.php";
    require_once "../subjects/subject.php"; 
    require_once "../faculty-member/faculty-member.php"; 

    $db = new Db();
    $connection = $db->getConnection();

    $subject = new Subject($connection); 
    $subjects = $subject->getAllSubjects(); 

    $facultyMember = new FacultyMember($connection);
    $facultyMembers = $facultyMember->getAllFacultyMembers(); 
    ?>

    <h1>Assign a subject to a faculty member</h1>
    <form class="form" action="assign_subject.php" method="post">
      <label for="subject_name">Subject name:</label>
      <select id="subject_name" name="subject_name" required>
        <?php foreach ($subjects as $subject): ?>
          <option value="<?php echo htmlspecialchars($subject['name']); ?>">
            <?php echo htmlspecialchars($subject['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <br />
      <label for="faculty_member_email">Faculty member name and email:</label>
      <select id="faculty_member_email" name="faculty_member_email" required>
        <?php foreach ($facultyMembers as $member): ?>
          <option value="<?php echo htmlspecialchars($member['email']); ?>">
            <?php echo htmlspecialchars($member['names'] . ' (' . $member['email'] . ')'); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <br />
      <label for="start_date">Start Date:</label>
      <input type="date" id="start_date" name="start_date" required />
      <br />
      <label for="end_date">End Date:</label>
      <input type="date" id="end_date" name="end_date" required />
      <input type="submit" class="register" value="Assign subject" />
      <a href="../index.html" class="common-button">Back to home</a>
    </form>
  </body>
</html>
