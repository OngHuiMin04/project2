<?php

// Database connection parameters
$servername = "localhost";
$username = "root";      // Your MySQL username
$password = "";          // Your MySQL password (empty if none)
$dbname = "ayrentals";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
