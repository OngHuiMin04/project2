<?php
// fetch-notifications.php

header('Content-Type: application/json');

// Database connection
$mysqli = new mysqli('localhost', 'username', 'password', 'database');

// Check connection
if ($mysqli->connect_error) {
    echo json_encode(['message' => 'Connection failed: ' . $mysqli->connect_error]);
    exit();
}

// Fetch notifications
$sql = "SELECT booking_id, property_name, booking_date FROM bookings WHERE status='pending'";
$result = $mysqli->query($sql);

if (!$result) {
    echo json_encode(['message' => 'Error executing query: ' . $mysqli->error]);
    exit();
}

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'booking_id' => $row['booking_id'],
        'property_name' => $row['property_name'],
        'booking_date' => $row['booking_date']
    ];
}

$mysqli->close();

echo json_encode(['notifications' => $notifications]);
?>
