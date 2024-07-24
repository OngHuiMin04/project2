<?php
// Initialize notifications as an empty array
$notifications = [];

// Check if session has been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$dsn = 'mysql:host=localhost;dbname=ayrentals';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception mode for PDO
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Assuming user email is stored in the session
$email = $_SESSION['email'] ?? null;

if ($email) {
    try {
        // Fetch notifications based on user email
        $stmt = $pdo->prepare("SELECT * FROM notifications WHERE email = ? ORDER BY created_at DESC");
        $stmt->execute([$email]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Debugging output
        if (empty($notifications)) {
            echo 'No notifications found for email: ' . htmlspecialchars($email);
        } else {
            foreach ($notifications as $notification) {
                echo 'Notification ID: ' . htmlspecialchars($notification['id']) . '<br>';
                echo 'Message: ' . htmlspecialchars($notification['message']) . '<br>';
                echo 'Type: ' . htmlspecialchars($notification['type']) . '<br>';
                echo 'Created At: ' . htmlspecialchars($notification['created_at']) . '<br>';
                echo 'Booking ID: ' . htmlspecialchars($notification['bookingId']) . '<br>';
                echo 'Property ID: ' . htmlspecialchars($notification['propertyId']) . '<br><hr>';
            }
        }
    } catch (PDOException $e) {
        die("Database query failed: " . $e->getMessage());
    }
} else {
    die('User email not found in session.');
}
?>
