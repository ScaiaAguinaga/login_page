<?php
// Initialize a flag to track if the login attempt is invalid
$is_invalid = false;

// Check if the HTTP request method is POST (form submission)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include the database configuration from "database.php"
    $mysqli = require __DIR__ . "/database.php";

    // Construct an SQL query to select a user by email address
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                    $mysqli->real_escape_string($_POST["email"]));

    // Execute the SQL query
    $result = $mysqli->query($sql);

    // Fetch the user's data as an associative array
    $user = $result->fetch_assoc();

    // Check if a user with the provided email exists
    if ($user) {
        // Verify the submitted password against the hashed password stored in the database
        if (password_verify($_POST["password"], $user["password_hash"])) {
            // Start a new session or resume the existing session
            session_start();

            // Regenerate a new session ID to prevent session fixation attacks
            session_regenerate_id();

            // Store the user's ID in the session for authentication
            $_SESSION["user_id"] = $user["id"];

            // Redirect the user to the "index.php" page upon successful login
            header("Location: index.php");
            exit;
        } else {
            // Password does not match, set $is_invalid to true
            $is_invalid = true;
        }
    } else {
        // No user with the provided email exists, set $is_invalid to true
        $is_invalid = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Login</h1>

    <?php if ($is_invalid): ?>
        <!-- Display an error message if the login attempt was invalid -->
        <em>Invalid login</em>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email</label>
        <!-- Display the previously submitted email value (if any) and HTML-encode it -->
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <button>Log in</button>
    </form>
</body>
</html>