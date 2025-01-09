<?php

// Database connection credentials
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$database = "inet_pet_adoption_db"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
