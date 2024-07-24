<?php
session_start();
header('content-type:text/html;charset=utf-8');
$host="localhost";
$user="root";
$password="";
$db="ayrentals"; // 替换为实际的数据库名
$table = "users"; // 替换为实际的表名

$mysqli = new mysqli($host, $user, $password, $db);
if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->set_charset('utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        register($mysqli);
    } elseif (isset($_POST['login'])) {
        login($mysqli);
    }
}
$mysqli->close();

function register($mysqli) {
    global $table;
    $sql = "INSERT INTO $table (name, email, country_code, phone_number, password, gender, nationality, occupation, usertype) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $mysqli_stmt = $mysqli->prepare($sql);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $country_code = $_POST['country_code'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password']; // 不要进行密码哈希处理
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $occupation = $_POST['occupation'];
    $usertype = $_POST['usertype'];

    if (!empty($name) && !empty($email) && !empty($country_code) && !empty($phone_number) && !empty($password) && !empty($gender) && !empty($nationality) && !empty($occupation) && !empty($usertype)) {
        $mysqli_stmt->bind_param('sssssssss', $name, $email, $country_code, $phone_number, $password, $gender, $nationality, $occupation, $usertype);

        if ($mysqli_stmt->execute()) {
            $_SESSION['success'] = "Registration successful. Please log in.";
            echo "<script>alert('Congratulations, Register Successful!');window.location.href='Login_Register.html'</script>";
        } else {
            $_SESSION['error'] = "Error in registration: " . $mysqli_stmt->error;
            echo "<script>alert('Error in registration: " . $mysqli_stmt->error . "');window.location.href='Login_Register.html'</script>";
        }
    } else {
        $_SESSION['error'] = "Please fill in all required fields";
        echo "<script>alert('Please fill in all required fields');window.location.href='Login_Register.html'</script>";
    }
    $mysqli_stmt->free_result();
    $mysqli_stmt->close();
}

?>