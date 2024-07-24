<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$dbname = "ayrentals";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $userType = $conn->real_escape_string($_POST["user_type"]);
    $message = $conn->real_escape_string($_POST["message"]);

    $sql = "INSERT INTO contact (name, email, user_type, message)
            VALUES ('$name', '$email', '$userType', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>document.getElementById('success-message').style.display='block';</script>";
    } else {
        echo "<script>document.getElementById('error-message').style.display='block';</script>";
    }
}

$conn->close();
?>
