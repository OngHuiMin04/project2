<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

$host = "localhost";
$user = "root";
$password = "";
$db = "ayrentals"; // Replace with your actual database name
$table = "users"; // Replace with your actual table name

$mysqli = new mysqli($host, $user, $password, $db);
if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->set_charset('utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        login($mysqli);
    }
}

$mysqli->close();

function login($mysqli) {
    global $table;
    $sql = "SELECT email, password, usertype FROM $table WHERE email=?";
    $mysqli_stmt = $mysqli->prepare($sql);

    if (!$mysqli_stmt) {
        die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $mysqli_stmt->bind_param('s', $email);

    if ($mysqli_stmt->execute()) {
        $mysqli_stmt->store_result();
        if ($mysqli_stmt->num_rows == 1) {
            $mysqli_stmt->bind_result($email, $stored_password, $usertype);
            $mysqli_stmt->fetch();

            // Check if the passwords match (without hashing)
            if ($password === $stored_password) {
                $_SESSION['email'] = $email; // Store email in session

                // Redirect based on usertype
                if ($usertype === 'tenant') {
                    header('Location: Tenant_Homepage.php');
                    exit();
                } elseif ($usertype === 'landlord') {
                    header('Location: Landlord_Homepage.php');
                    exit();
                } else {
                    // Handle unexpected usertypes here
                    $_SESSION['error'] = "Unknown user type";
                    echo '<div style="color: red;">Unknown user type</div>';
                    header('Location: Login_Register.html');
                    exit();
                }
            } else {
                $_SESSION['error'] = "Invalid email or password";
                echo "<script>alert('Invalid email or password');window.location.href='Login_Register.html'</script>";
                exit();
            }
        } else {
            $_SESSION['error'] = "No user found, please register";
            echo "<script>alert('No user found, please register');window.location.href='Login_Register.html'</script>";
            exit();
        }
    } else {
        $_SESSION['error'] = "Error executing query: " . $mysqli_stmt->error;
        echo "<script>alert('Error executing query: " . $mysqli_stmt->error . "');window.location.href='Login_Register.html'</script>";
        exit();
    }

    $mysqli_stmt->free_result();
    $mysqli_stmt->close();
}
?>

