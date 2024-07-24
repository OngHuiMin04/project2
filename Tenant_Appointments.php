<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ayrentals";

    try {
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve and sanitize form data
        $property_id = isset($_POST['propertyId']) ? $_POST['propertyId'] : '';
        $appointment_date = isset($_POST['appointment_date']) ? $_POST['appointment_date'] : '';
        $appointment_time = isset($_POST['appointment_time']) ? $_POST['appointment_time'] : '';

        // Prepare and bind parameters to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO appointments (propertyId, appointment_date, appointment_time) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $property_id, $appointment_date, $appointment_time);
        $stmt->execute();

    
        // Close MySQL connection
        $stmt->close();
        $conn->close();

        // Redirect to homedetails.php with success message
        header("Location: Tenant_HomeDetails.php?propertyId=$property_id&success=Appointment%20successful");
        exit();
    } catch (Exception $e) {
        // Redirect to homedetails.php with error message
        header("Location: Tenant_HomeDetails.php?propertyId=$property_id&error=" . urlencode("Error: " . $e->getMessage()));
        exit();
    }
} else {
    // Redirect to homedetails.php if accessed directly without POST data
    header("Location: Tenant_HomeDetails.php");
    exit();
}
?>
