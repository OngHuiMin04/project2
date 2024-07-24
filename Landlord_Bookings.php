<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
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

    // Retrieve and sanitize form data
    $property_id = isset($_POST['propertyId']) ? $_POST['propertyId'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $number_of_pax = isset($_POST['number_of_pax']) ? $_POST['number_of_pax'] : '';
    $tenancy_duration = isset($_POST['tenancy_duration']) ? $_POST['tenancy_duration'] : '';
    $move_in_date = isset($_POST['move_in_date']) ? $_POST['move_in_date'] : '';
    $move_in_time = isset($_POST['move_in_time']) ? $_POST['move_in_time'] : '';

    // Check if the propertyId is already booked
    $stmt_check = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE propertyId = ?");
    $stmt_check->bind_param("s", $property_id);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        echo "This property is already booked.";
    } else {
        // Prepare and bind parameters to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO bookings (propertyId, email, phone, number_of_pax, tenancy_duration, move_in_date, move_in_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $property_id, $email, $phone, $number_of_pax, $tenancy_duration, $move_in_date, $move_in_time);

        // Execute the statement and handle success/failure
        if ($stmt->execute()) {
            // Retrieve the auto-generated bookingId
            $bookingId = $stmt->insert_id;

            // Redirect to payment page with bookingId
            $stmt->close();
            $conn->close();
            header("Location: Landlord_Payment.php?bookingId=" . $bookingId);
            exit(); // Ensure no further code execution after redirection
        } else {
            echo "Error: " . $stmt->error; // Display error message if execution fails
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>
