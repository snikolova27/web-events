<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/common.css" />
    <link rel="stylesheet" type="text/css" href="../styles/forms.css" />
    <link rel="stylesheet" type="text/css" href="../styles/navbar.css" />
    <title>Import Students</title>
</head>
<body>
    <h1>Import Students from CSV</h1>
    <?php include_once("../navbar/navbar.php"); ?>
    <form action="import_students.php" class="form" method="post" enctype="multipart/form-data">
        <input type="file" name="studentFile" accept=".csv" class="common-button" required>
        <br />
        <input type="submit" name="import" class="register" value="Import students" />
    </form>
</body>
</html>