<?php
// Include necessary files
require_once("../db/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $db = new Db();
    $connection = $db->getConnection();

    if (isset($_POST['import'])) {
        $file = $_FILES['facultyMemberFile'];
    
        // Check if there was an error during file upload
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Open the file for reading
            $handle = fopen($file['tmp_name'], 'r');
    
            // Skip the header line
            fgetcsv($handle);
    
            // Loop through each row in the CSV
            while (($data = fgetcsv($handle)) !== FALSE) {
                // Insert into 'users' table
                $hashedHardcodedPassword = password_hash('12345', PASSWORD_BCRYPT);
                $insertUserQuery = "INSERT INTO users (names, email, password, is_admin) VALUES (?, ?, ?, 0)";
                $userStmt = $connection->prepare($insertUserQuery);
                $userStmt->execute([$data[0], $data[1], $hashedHardcodedPassword]); // $data[0] is name, $data[1] is email
                
                // Get the last inserted ID, which is the user_id for the student
                $userId = $connection->lastInsertId();

                // Insert into 'students' table
                $insertFacultyMemberQuery = "INSERT INTO faculty_members (user_id) VALUES (?)";
                $facultyMemberStmt = $connection->prepare($insertFacultyMemberQuery);
                $facultyMemberStmt->execute([$userId]);
            }
    
            // Close the file handle
            fclose($handle);
    
            echo "Students imported successfully.";
            header("Location: ../home/home.php");
            exit();
        } else {
            echo "Error uploading file.";
            header("Location: ../home/home.php");
            exit();
        }
    }    
}