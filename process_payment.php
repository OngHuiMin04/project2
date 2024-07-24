<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ayrentals";

// Establish database connection using PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Retrieve data from the form
$bookingId = $_POST['bookingId'] ?? '';
$paymentMethod = $_POST['payment-method'] ?? '';
$email = $_POST['email'] ?? null;
$cardNumber = $_POST['card-number'] ?? null;
$expiryDate = $_POST['expiry-date'] ?? null;
$cvv = $_POST['cvv'] ?? null;
$tngEmail = $_POST['tng-email'] ?? null;
$pin = $_POST['pin'] ?? null;

// Validate the payment method
if (!in_array($paymentMethod, ['Visa', 'MasterCard', 'Touch n Go'])) {
    die("Invalid payment method selected.");
}

// Prepare SQL statement based on the payment method
if ($paymentMethod === 'Touch n Go') {
    if (empty($tngEmail) || empty($pin)) {
        die("Email and PIN are required for Touch 'n Go payments.");
    }

    $sql = "INSERT INTO payments (payment_method, email, pin, bookingId)
            VALUES (:paymentMethod, :tngEmail, :pin, :bookingId)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute the statement
    try {
        $stmt->execute([
            ':paymentMethod' => $paymentMethod,
            ':tngEmail' => $tngEmail,
            ':pin' => $pin,
            ':bookingId' => $bookingId,
        ]);
        echo "Payment details inserted successfully.";
    } catch (PDOException $e) {
        die("Error inserting payment details: " . $e->getMessage());
    }
} else {
    if (empty($email) || empty($cardNumber) || empty($expiryDate) || empty($cvv)) {
        die("Email, Card Number, Expiry Date, and CVV are required for Visa and MasterCard payments.");
    }

    $sql = "INSERT INTO payments (payment_method, email, card_number, expiry_date, cvv, bookingId)
            VALUES (:paymentMethod, :email, :cardNumber, :expiryDate, :cvv, :bookingId)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute the statement
    try {
        $stmt->execute([
            ':paymentMethod' => $paymentMethod,
            ':email' => $email,
            ':cardNumber' => $cardNumber,
            ':expiryDate' => $expiryDate,
            ':cvv' => $cvv,
            ':bookingId' => $bookingId,
        ]);
        echo "Payment details inserted successfully.";
    } catch (PDOException $e) {
        die("Error inserting payment details: " . $e->getMessage());
    }
}
?>
