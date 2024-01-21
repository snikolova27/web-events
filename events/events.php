<?php
session_start();

// Check if the user is authenticated (has a valid session)
if (!isset($_SESSION['user_token'])) {
    // Redirect to the sign-in page if not authenticated
    header("Location: ../signin/signin.php");
    exit();
}

// Access the user's ID if needed
$userId = $_SESSION['user_id'];

// Show events

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Web events</title>
</head>
<body>
    <h1>Welcome to the Events page</h1>
    <p>User ID: <?php echo $userId; ?></p>
    <!-- render events -->

     <!-- Logout link -->
     <a href="../logout/logout.php">Logout</a>
</body>
</html>
