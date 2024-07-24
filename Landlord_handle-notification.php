<?php
// Landlord_handle-notification.php

header('Content-Type: application/json');

// Get POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check for required parameters
if (!isset($data['action']) || !isset($data['id']) || !isset($data['type'])) {
    echo json_encode(['message' => 'No action, ID, or type specified.']);
    exit();
}

$action = $data['action'];
$id = $data['id']; // Booking or appointment ID
$type = $data['type']; // 'booking' or 'appointment'
$newTime = $data['newTime'] ?? ''; // New time for rescheduling
$appointmentDate = $data['appointmentDate'] ?? ''; // Required for appointments
$appointmentTime = $data['appointmentTime'] ?? ''; // Required for appointments
$oldAppointmentTime = $data['oldAppointmentTime'] ?? ''; // Required for rescheduling

// Database connection
$mysqli = new mysqli('localhost', 'username', 'password', 'database');

// Check connection
if ($mysqli->connect_error) {
    echo json_encode(['message' => 'Connection failed: ' . $mysqli->connect_error]);
    exit();
}

// Prepare the response message
$responseMessage = '';

if ($action == 'approve' || $action == 'decline') {
    if ($type === 'booking') {
        // Handle booking
        $sql = "UPDATE bookings SET status=? WHERE booking_id=?";
        $status = ($action == 'approve') ? 'approved' : 'declined';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $status, $id);
    } elseif ($type === 'appointment') {
        // Handle appointment
        $sql = "UPDATE appointments SET status=? WHERE propertyId=? AND appointment_date=? AND appointment_time=?";
        $status = ($action == 'approve') ? 'approved' : 'declined';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssss", $status, $id, $appointmentDate, $appointmentTime);
    } else {
        $responseMessage = 'Invalid type specified.';
        echo json_encode(['message' => $responseMessage]);
        exit();
    }

    if ($stmt->execute()) {
        $responseMessage = ucfirst($type) . ' ' . $action . 'd successfully.';
    } else {
        $responseMessage = 'Error ' . $action . 'ing ' . $type . ': ' . $stmt->error;
    }
    $stmt->close();
} elseif ($action == 'reschedule' && !empty($newTime)) {
    if ($type === 'appointment') {
        // Handle appointment rescheduling
        $sql = "UPDATE appointments SET appointment_time=? WHERE propertyId=? AND appointment_date=? AND appointment_time=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssss", $newTime, $id, $appointmentDate, $appointmentTime);

        if ($stmt->execute()) {
            $responseMessage = 'Appointment rescheduled successfully to ' . $newTime;
        } else {
            $responseMessage = 'Error rescheduling appointment: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $responseMessage = 'Invalid type for rescheduling.';
        echo json_encode(['message' => $responseMessage]);
        exit();
    }
} else {
    $responseMessage = 'Invalid action or missing newTime for rescheduling.';
}

$mysqli->close();
echo json_encode(['message' => $responseMessage]);
?>
