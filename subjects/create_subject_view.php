<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../styles/forms.css" />
    <link rel="stylesheet" type="text/css" href="../styles/common.css" />
    <link rel="stylesheet" type="text/css" href="../styles/navbar.css" />

    <title>Subject Creation - Web events</title>
  </head>
  <body>
    <h1>Create a subject</h1>
    <?php include_once("../navbar/navbar.php"); ?>
    <form class="form" action="create_subject.php" method="post">
      <label for="name">Subject name:</label>
      <input type="text" id="name" name="name" required />
      <br />
      <input type="submit" class="register" value="Create subject" />
    </form>
  </body>
</html>
