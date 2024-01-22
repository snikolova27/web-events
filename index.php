<?php

require_once("db/db.php");
require_once("user/user.php");
require_once("faculty-member/faculty-member.php");
session_start();

// Check if the user is authenticated (has a valid session)
if (isset($_SESSION['user_token'])) {
  // Redirect to the home page if  authenticated
  header("Location: home/home.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css"  href="/styles/common.css" />
    <title>Web events - Home</title>
  </head>
  <body>
    <h1>Welcome to Web events</h1>
    <div class="menu">
      <a href="register/register_student.html" class="common-button"
        >Register as student</a
      >
      <a href="register/register_faculty_member.html" class="common-button"
        >Register as faculty member</a
      >
      <a href="signin/signin.php" class="common-button">Sign In</a>
    </div>
  </body>
</html>
