<?php
session_start();
$userId = $_SESSION['user_id']; // 假设用户ID存储在会话中

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar'])) {
    $target_dir = "uploads/avatars/";
    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 检查是否是图片
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // 检查文件大小
    if ($_FILES["avatar"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // 允许的文件格式
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // 检查$uploadOk是否为0
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            // 更新数据库中的avatar_path
            $conn = new mysqli('localhost', 'username', 'password', 'database'); // 更新为你的数据库连接信息
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("UPDATE users SET avatar_path = ? WHERE id = ?");
            $stmt->bind_param("si", $target_file, $userId);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            echo "The file " . basename($_FILES["avatar"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
