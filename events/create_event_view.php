<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../styles/forms.css" />
    <link rel="stylesheet" type="text/css" href="../styles/common.css" />

    <title>Event Creation - Web events</title>
  </head>
  <body>
    <?php
      require_once "../db/db.php";
      require_once "../subjects/subject.php"; 
      require_once "../faculty-member/faculty-member.php"; 

      session_start();

      // Check if the user is authenticated (has a valid session)
      if (!isset($_SESSION['user_token'])) {
          // Redirect to the sign-in page if not authenticated
          header("Location: ../signin/signin.php");
          exit();
      }

      // Access the user's ID if needed
      $userId = $_SESSION['user_id'];

      $db = new Db();
      $connection = $db->getConnection();

      $subject = new Subject($connection); 
      $subjects = $subject->getAllSubjects(); 

      $facultyMember = new FacultyMember($connection);

      $facultyMemberData = $facultyMember->getFacultyMemberByUserId($userId);
      if (!$facultyMemberData) {
        echo "Unable to fetch faculty member with user id: " . $userData['id'];
        header("Location: ../home/home.php");
        exit();
      }

      $subjects = $facultyMember->getAssignedSubjects($facultyMemberData['fm_id']);
    ?>
    <h1>Create an event</h1>
    <form class="form" action="create_event.php" method="post">
      <label for="event_name">Event name:</label>
      <input type="text" id="event_name" name="event_name" required />
      <br />
      <label for="fm_x_subject_id">Subject name:</label>
      <select id="fm_x_subject_id" name="fm_x_subject_id" required>
        <?php foreach ($subjects as $subject): ?>
          <option value="<?php echo htmlspecialchars($subject['fm_x_subject_id']); ?>">
            <?php echo htmlspecialchars($subject['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <br />
      <label for="start_date_time">Start Date Time:</label>
      <input type="datetime-local" id="start_date_time" name="start_date_time" required />
      <br />
      <label for="end_date_time">End Date Time:</label>
      <input type="datetime-local" id="end_date_time" name="end_date_time" required />
      <br />
      <label for="event_password">Event password:</label>
      <input type="text" id="event_password" name="event_password" required />
      <input type="submit" class="register" value="Create event" />
      <a href="../home/home.php" class="common-button">Back to home</a>
    </form>
  </body>
</html>
