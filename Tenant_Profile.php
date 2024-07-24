<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: Login_Register.html');
    exit();
}

// Database connection settings
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

// Get current user information
$current_email = $_SESSION['email'];
$sql = "SELECT name, email, country_code, phone_number, gender, nationality, occupation, usertype, avatar_path FROM $table WHERE email=?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param('s', $current_email);
$stmt->execute();
$stmt->bind_result($name, $email, $country_code, $phone_number, $gender, $nationality, $occupation, $usertype, $avatar_path);
$stmt->fetch();
$stmt->close();

$_SESSION['avatar_path'] = $avatar_path; // Store avatar path in session

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        update_profile($mysqli);
    }

    // Handle avatar upload
    if ($_FILES['avatar']['size'] > 0) {
        $uploadDirectory = "uploads/";

        // Check if upload directory exists, create if not
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        $avatar_path = $uploadDirectory . basename($_FILES['avatar']['name']);

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path)) {
            // Update database with avatar path
            $sql = "UPDATE $table SET avatar_path=? WHERE email=?";
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $mysqli->error);
            }

            $stmt->bind_param('ss', $avatar_path, $current_email);
            if ($stmt->execute()) {
                $_SESSION['avatar_path'] = $avatar_path; // Update session with avatar path
                $_SESSION['success'] = "Avatar updated successfully.";
            } else {
                $_SESSION['error'] = "Error in updating avatar: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $_SESSION['error'] = "Error uploading avatar.";
        }
    } else {
        // If no new avatar uploaded, retain current avatar path
        $avatar_path = $_POST['current_avatar'];
    }
}

$mysqli->close();

function update_profile($mysqli) {
    global $table, $avatar_path;
    $sql = "UPDATE $table SET name=?, email=?, country_code=?, phone_number=?, gender=?, nationality=?, occupation=?, usertype=?, avatar_path=? WHERE email=?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $country_code = $_POST['country_code'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $occupation = $_POST['occupation'];
    $usertype = $_POST['usertype'];
    $current_email = $_SESSION['email'];

    // Handle avatar upload (already handled above in $_POST['update_profile'] section)

    if (!empty($name) && !empty($email) && !empty($country_code) && !empty($phone_number) && !empty($gender) && !empty($nationality) && !empty($occupation) && !empty($usertype)) {
        $stmt->bind_param('ssssssssss', $name, $email, $country_code, $phone_number, $gender, $nationality, $occupation, $usertype, $avatar_path, $current_email);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Profile updated successfully.";
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['country_code'] = $country_code;
            $_SESSION['phone_number'] = $phone_number;
            $_SESSION['gender'] = $gender;
            $_SESSION['nationality'] = $nationality;
            $_SESSION['occupation'] = $occupation;
            $_SESSION['usertype'] = $usertype;
            // No need to update avatar_path in session here; it's updated in the avatar upload section
            echo "<script>alert('Profile updated successfully');window.location.href='Tenant_Profile.php'</script>";
        } else {
            $_SESSION['error'] = "Error in updating profile: " . $stmt->error;
            echo "<script>alert('Error in updating profile: " . $stmt->error . "');window.location.href='Tenant_Profile.php'</script>";
        }
    } else {
        $_SESSION['error'] = "Please fill in all required fields";
        echo "<script>alert('Please fill in all required fields');window.location.href='Tenant_Profile.php'</script>";
    }

    $stmt->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>Profile</title>
    <link href="Tenant_Homepage.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap-grid.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #efe1d1; 
            margin: 0;
        }
        
        .profile-section {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            text-align: center;
        }


        img#profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            cursor: pointer;
        }

        input[type="file"] {
            display: none;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="email"], input[type="tel"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .profile-section form > input[type="text"],
        .profile-section form > input[type="email"] {
        margin-right: 10px; /* Adjust the margin-right as needed */
        width: calc(100% - 22px); /* Ensure equal width for both inputs */
        }

        .phone_number {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .country-code {
            width: 25%;
        }

        button {
            background-color: #6f4e37;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: wheat;
        }

        .avatar-wrapper {
    cursor: pointer;
    display: inline-block;
    position: relative;
    border: 2px solid #000; 
    border-radius: 50%; 
    width: 104px; 
    height: 104px; 
    overflow: hidden; 
}

.avatar-wrapper img {
    border-radius: 50%;
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); 
}
    </style>
</head>
<body>

<section class="header">
        <div class="header-container">
            <div class="header-box">
                <div class="logo">
                    <img src="img/logo.png" alt="Logo" width="140px" height="120px">
                </div>
                <nav class="nav" aria-label="Main Navigation">
                    <ul>
                        <li><a href="Tenant_Homepage.php">Homepage</a></li>
                        <li class="dropdown">
                            <a href="Tenant_Catalogue.php" class="dropbtn">Catalogue <ion-icon name="caret-down-outline"></ion-icon></a>
                            <div class="dropdown-content">
                                <a href="Tenant_Catalogue.php">All Residential</a>
                                <a href="Tenant_BungalowVilla_Catalogue.php">Bungalow/Villa</a>
                                <a href="Tenant_AppartmentCondo_Catalogue.php">Apartment/Condo/Service Residence</a>
                                <a href="Tenant_SemiDetachedCatalogue.php">Semi-Detached House</a>
                                <a href="Tenant_TerraceLinkHouse_Catalogue.php">Terrace/Link House</a>
                            </div>
                        </li>
                        <li><a href="Tenant_AboutUs.php">About Us</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropbtn">More<ion-icon name="caret-down-outline"></ion-icon></a>
                            <div class="dropdown-content">
                                <a href="Tenant_News.php">News</a>
                                <a href="Tenant_LocalAmenities.php">Neighbourhood Facility</a>
                                <a href="Tenant_FAQ.php">FAQ</a>
                            </div>
                        </li>
                    </ul>
                </nav>
    
                <div class="header-buttons">
                    <button id="notification-btn" class="notification-btn">
                        <img src="https://cdn-icons-png.flaticon.com/128/2645/2645897.png" alt="Notifications"> 
                        <span id="notification-count" class="notification-count">1</span>
                    </button>
    
                    <div id="notification-modal" class="notification-modal">
                        <div class="notification-modal-content">
                            <span class="closebutton">&times;</span>
                            <p id="notification-message">You have a new appointment. Do you want to approve, decline, or reschedule?</p>
                            <button id="approve-btn">Approve</button>
                            <button id="decline-btn">Decline</button>
                            <button id="reschedule-btn">Reschedule</button>
                        </div>
                    </div>

                    <div class="profile-btn">
                        <a href="#" class="dropbtn">
                            <img src="<?php echo htmlspecialchars($avatar_path); ?>" alt="Avatar" class="avatar">
                            Profile
                            <ion-icon name="caret-down-outline"></ion-icon>
                        </a>
                        <div class="dropdown-content">
                            <a href="Tenant_Profile.php">Profile Info</a>
                            <a href="#change-password">Change Password</a>
                            <a href="Guest_Homepage.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>      

    <div class="profile-section">
    <form action="Tenant_Profile.php" method="POST" enctype="multipart/form-data">
        <div id="avatar-wrapper" class="avatar-wrapper">
            <img id="profile-picture" src="<?php echo htmlspecialchars($avatar_path); ?>" alt="Profile Picture">
            <input type="file" id="avatar-upload" name="avatar" accept="image/*">
        </div>
        <h1>My Profile</h1>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required placeholder="Full Name">
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required placeholder="Email Address">
        <div class="phone_number">
            <input type="text" class="country-code" name="country_code" value="<?php echo htmlspecialchars($country_code); ?>" required placeholder="+60">
            <input type="tel" class="phone-number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required placeholder="Phone Number">
        </div>
        <select name="gender" required>
            <option value="" disabled selected>Gender</option>
            <option value="male" <?php echo ($gender == 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo ($gender == 'female') ? 'selected' : ''; ?>>Female</option>
        </select>
        <select name="nationality" required>
            <option value="" disabled selected>Nationality</option>
            <option value="malaysian" <?php echo ($nationality == 'malaysian') ? 'selected' : ''; ?>>Malaysian</option>
            <option value="singaporean" <?php echo ($nationality == 'singaporean') ? 'selected' : ''; ?>>Singaporean</option>
        </select>
        <select name="occupation" required>
            <option value="" disabled selected>Occupation</option>
            <option value="professional" <?php echo ($occupation == 'professional') ? 'selected' : ''; ?>>Professional</option>
            <option value="student" <?php echo ($occupation == 'student') ? 'selected' : ''; ?>>Student</option>
            <option value="family" <?php echo ($occupation == 'family') ? 'selected' : ''; ?>>Family</option>
            <option value="single" <?php echo ($occupation == 'single') ? 'selected' : ''; ?>>Single individual</option>
            <option value="retiree" <?php echo ($occupation == 'retiree') ? 'selected' : ''; ?>>Retiree</option>
            <option value="foreigner" <?php echo ($occupation == 'foreigner') ? 'selected' : ''; ?>>Foreigner</option>
            <option value="temporary" <?php echo ($occupation == 'temporary') ? 'selected' : ''; ?>>Temporary worker</option>
            <option value="other" <?php echo ($occupation == 'other') ? 'selected' : ''; ?>>Other</option>
        </select>
        <select name="usertype" required>
            <option value="" disabled selected>User Type</option>
            <option value="tenant" <?php echo ($usertype == 'tenant') ? 'selected' : ''; ?>>Tenant</option>
            <option value="landlord" <?php echo ($usertype == 'landlord') ? 'selected' : ''; ?>>Landlord</option>
        </select>
        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</div>



<section class="footer">
        <div class="footer-container">
            <div class="footer-box">
                <h3>Quick Links</h3>
                <a href="Tenant_Homepage.php">Homepage</a>
                <a href="Tenant_Catalogue.php">Catalogue</a>
                <a href="Tenant_AboutUs.php">About Us</a>
            </div>
            
            <div class="footer-box">
                <h3>More</h3>
                <a href="LaTenant_News.php">News</a>
                <a href="Tenant_LocalAmenities.php">Neighbourhood Facility</a>
                <a href="Tenant_FAQ.php">FAQ</a>
            </div>
    
            <div class="footer-box">
                <h3>Follow Us</h3>
                <ul class="list-inline-item">
                    <li><a href="#" class="social-link"><ion-icon name="logo-facebook"></ion-icon> Facebook</a></li>
                    <li><a href="#" class="social-link"><ion-icon name="logo-instagram"></ion-icon> Instagram</a></li>
                    <li><a href="#" class="social-link"><ion-icon name="logo-twitter"></ion-icon> Twitter</a></li>
                </ul>
            </div> 
        </div>
    
        <div class="policy-and-copyright">
            <div class="policy-links">
                <a href="Tenant_AcceptableUsePolicy.php">Acceptable Use Policy</a>
                <a href="Tenant_TermsosService.php">Terms of Service</a>
                <a href="Tenant_PrivacyPolicy.php">Privacy Policy</a>
            </div>
    
            <div class="copyright">
                <p>© 2024 Ong Hui Min & Yuthikkaa A/P Velavan. All rights reserved.</p>
            </div>
        </div>
    </section>

    <script>
   document.addEventListener("DOMContentLoaded", function() {
        const avatarUpload = document.getElementById("avatar-upload");
        const profilePicture = document.getElementById("profile-picture");

        profilePicture.addEventListener("click", function() {
            avatarUpload.click();
        });

        avatarUpload.addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePicture.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
    
</body>
</html>