<?php
// Include the database configuration from "database.php"
$mysqli = require __DIR__ . "/database.php";

// Get the email parameter from the URL query string ($_GET)
$email = $_GET["email"];

// Construct an SQL query to check if the email already exists in the "user" table
$sql = sprintf("SELECT * FROM user
                WHERE email = '%s'",
                $mysqli->real_escape_string($email));

// Execute the SQL query
$result = $mysqli->query($sql);

// Check if the query returned any rows (email exists)
$is_available = $result->num_rows === 0;

// Set the response content type to JSON
header("Content-Type: application/json");

// Return a JSON response indicating email availability
echo json_encode(["available" => $is_available]);
?>
