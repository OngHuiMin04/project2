<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ayrentals";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_id = $_POST['appointment_id'];
    $house_id = $_POST['house_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $sql = "INSERT INTO appointments (appointment_id, house_id, appointment_date, appointment_time)
            VALUES ('$appointment_id', '$house_id', '$appointment_date', '$appointment_time')";

    if ($conn->query($sql) === TRUE) {
        echo "New appointment created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
