<?php
// Start or resume the PHP session
session_start();

// Check if a user is logged in by verifying the presence of the "user_id" session variable
if (isset($_SESSION["user_id"])) {
    // Include the database configuration from "database.php"
    $mysqli = require __DIR__ . "/database.php";

    // Construct an SQL query to select user data by their ID stored in the session
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";

    // Execute the SQL query
    $result = $mysqli->query($sql);

    // Fetch the user's data as an associative array
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Home</h1>

    <?php if (isset($user)): ?>
        <!-- Display content if a user is logged in -->
        <p>You are logged in.</p>
        <p>Hello <?= htmlspecialchars($user["username"]) ?></p>
        <p><a href="logout.php">Log out</a></p>
    <?php else : ?>
        <!-- Display content if no user is logged in -->
        <p><a href="login.php">Log in</a> or <a href="signup.html">Sign up</a></p>
    <?php endif; ?>
</body>
</html>