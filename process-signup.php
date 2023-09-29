<?php
// Check if the submitted username is empty
if (empty($_POST["username"])) {
    die("Username is required");
}

// Check if the submitted email is a valid email address
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

// Check if the submitted password is at least 8 characters long
if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

// Check if the submitted password contains at least one letter (case-insensitive)
if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

// Check if the submitted password contains at least one number
if (!preg_match("/[0-9]/i", $_POST["password"])) {
    die("Password must contain at least one number");
}

// Check if the submitted password and password confirmation match
if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

// Hash the submitted password using the default hashing algorithm
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Include the database configuration from "database.php"
$mysqli = require __DIR__ . "/database.php";

// SQL query to insert user data into the "user" table
$sql = "INSERT INTO user (username, email, password_hash) 
        VALUES (?, ?, ?)";

// Initialize a MySQLi prepared statement
if (!$stmt = $mysqli->stmt_init()) {
    die("SQL error: " . $mysqli->error);
}

// Prepare the SQL statement
$stmt->prepare($sql);

// Bind parameters to the prepared statement
$stmt->bind_param("sss",
    $_POST["username"],
    $_POST["email"],
    $password_hash,
);

// Execute the prepared statement
if ($stmt->execute()) {
    // Redirect the user to a "signup-success.html" page upon successful registration
    header("Location: signup-success.html");
    exit;
} else {
    // Handle database insertion errors
    if ($mysqli->errno === 1062) {
        die("Email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
?>