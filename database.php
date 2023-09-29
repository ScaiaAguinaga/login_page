<?php
// Database connection configuration
$host = "localhost";    // Hostname of the database server
$dbname = "login_db";   // Name of the database
$username = "root";     // Username for database access
$password = "";         // Password for database access (empty for localhost)

// Create a new MySQLi (MySQL Improved) database connection object
$mysqli = new mysqli(hostname: $host, 
                    username: $username, 
                    password: $password, 
                    database: $dbname);

// Check for a connection error
if ($mysqli->connect_errno) {
    // If there's an error, terminate the script and display an error message
    die("Connection error: " . $mysqli->connect_error);
}

// Return the database connection object
return $mysqli;
?>
