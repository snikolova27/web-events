<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/forms.css">
    <link rel="stylesheet" href="../styles/common.css">
    <title>Sign In - Web Events</title>
</head>

<body>
    <h1>Sign In to Web events</h1>
    <form class="form" action="process_signin.php" method="post">
        <?php if (isset($_GET['error']) && $_GET['error'] === 'user_not_found') : ?>
            <p class="error">No user found with the provided email. Please check your email or register.</p>
        <?php endif; ?>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required <?php echo (isset($_GET['error']) && $_GET['error'] === 'user_not_found') ? 'class="error-input"' : ''; ?>>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required <?php echo (isset($_GET['error']) && $_GET['error'] === 'incorrect_password') ? 'class="error-input"' : ''; ?>>
        <br>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'incorrect_password') : ?>
            <p class="error">Incorrect password. Please try again.</p>
        <?php endif; ?>
        <input type="submit" value="Sign In" class="register">
        <a href="../index.html" class="back-to-home">Back to home</a>
    </form>
</body>

</html>