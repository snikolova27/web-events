<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/forms.css" />
    <link rel="stylesheet" type="text/css" href="../styles/common.css" />
    <link rel="stylesheet" type="text/css" href="../styles/navbar.css" />
    <title>Import Students</title>
</head>
<body>
    <h1>Import Faculty Members from CSV</h1>
    <?php include_once("../navbar/navbar.php"); ?>
    <form action="import_faculty_members.php" class="form" method="post" enctype="multipart/form-data">
        <label for="facultyMemberFile" class="file-upload-button">Choose File</label><span id="faculty-member-file-name"></span>
        <input type="file" name="facultyMemberFile" id="facultyMemberFile" accept=".csv" class="common-button" required style="display: none;" onchange="updateFileName()">
        <br />
        <input type="submit" name="import" class="register" value="Import faculty members" />
    </form>

    <script>
        function updateFileName() {
            var input = document.getElementById('facultyMemberFile');
            var fileNameSpan = document.getElementById('faculty-member-file-name');
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