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
        <label for="studentFile" class="file-upload-button">Choose File</label><span id="student-file-name"></span>
        <input type="file" name="studentFile" id="studentFile" accept=".csv" class="common-button" required style="display: none;" onchange="updateFileName()">
        <br />
        <input type="submit" name="import" class="register" value="Import students" />
    </form>

    <script>
        function updateFileName() {
            var input = document.getElementById('studentFile');
            var fileNameSpan = document.getElementById('student-file-name');
            if (input.files.length > 0) {
                var fileName = input.files[0].name;
                fileNameSpan.textContent = ' ' + fileName; // Add a space for visual separation
            } else {
                fileNameSpan.textContent = '';
            }
        }
    </script>

</body>
</html>