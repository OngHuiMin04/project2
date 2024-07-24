<?php
session_start(); // Start the session
$userId = $_SESSION['email']; // Assuming user ID is stored in session

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ayrentals";
$propertyTable = "properties";
$imageTable = "uploaded_photos";
$userTable = "users";

// Establish database connection using PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch property details and images from the database
try {
    if (isset($_GET['propertyId'])) {
        $propertyId = $_GET['propertyId'];
        $stmt = $pdo->prepare("
            SELECT p.propertyId, p.propertyName, p.address, p.price, p.bedroom, p.bathroom, p.size, p.propertyType, p.deposit, p.facilities, p.rentcategory, p.floorLevel, p.furnishing, p.parking, p.residentialname, p.v_available, p.p_available, p.created_at, up.file_path
            FROM $propertyTable p
            JOIN $imageTable up ON p.propertyId = up.propertyId
            WHERE p.propertyId = ?
        ");
        $stmt->execute([$propertyId]);
        $property = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch price details
        $stmt_price = $pdo->prepare("SELECT price, deposit, ayrentalFees, sst, total FROM pricedetails WHERE propertyId = :propertyId");
        $stmt_price->bindParam(':propertyId', $propertyId);
        $stmt_price->execute();
        $details = $stmt_price->fetch(PDO::FETCH_ASSOC);

        // Assign fetched data to variables if they exist
        $price = isset($details['price']) ? $details['price'] : null;
        $deposit = isset($details['deposit']) ? $details['deposit'] : null;
        $ayrentalFees = isset($details['ayrentalFees']) ? $details['ayrentalFees'] : null;
        $sst = isset($details['sst']) ? $details['sst'] : null;
        $total = isset($details['total']) ? $details['total'] : null;
    } else {
        // Handle case where propertyId is not set
        die("Property ID not provided.");
    }

    // Fetch user details if session email is set
    if (isset($_SESSION['email'])) {
        $current_email = $_SESSION['email'];
        $stmt_user = $pdo->prepare("SELECT name, avatar_path, email, phone_number, country_code FROM $userTable WHERE email=?");
        $stmt_user->execute([$current_email]);
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

        // Assign fetched user data to variables if they exist
        $userName = isset($user['name']) ? $user['name'] : 'Unknown';
        $userAvatarPath = isset($user['avatar_path']) ? $user['avatar_path'] : 'default-avatar.png';
        $userEmail = isset($user['email']) ? $user['email'] : '';
        $userPhoneNumber = isset($user['phone_number']) ? $user['phone_number'] : '';
        $userCountryCode = isset($user['country_code']) ? str_replace('+', '', $user['country_code']) : ''; // Remove the plus sign
    } else {
        // Handle case where $_SESSION['email'] is not set
        $user = null; // or handle it according to your application's logic
        $userName = 'Unknown';
        $userAvatarPath = 'default-avatar.png';
        $userEmail = '';
        $userPhoneNumber = '';
        $userCountryCode = '';
    }

} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}

// Function to get property type name based on type code
function getPropertyTypeName($typeCode) {
    switch ($typeCode) {
        case 'A':
            return 'Bungalow/Villa';
        case 'B':
            return 'Apartment/Condo/Service Residence';
        case 'C':
            return 'Semi-Detached House';
        case 'D':
            return 'Terrace/Link House';
        default:
            return 'Unknown';
    }
}

// Fetch avatar path
$conn_avatar = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn_avatar->connect_error) {
    die("Connection failed: " . $conn_avatar->connect_error);
}

// Prepare the query to get the user's avatar path
$stmt = $conn_avatar->prepare("SELECT avatar_path FROM users WHERE email = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($avatarPath);
$stmt->fetch();
$stmt->close();

$conn_avatar->close();

// Set default avatar path if none found
if (empty($avatarPath)) {
    $avatarPath = 'default-avatar.png'; // Set default avatar path
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>Catalogue</title>
    <link href="Landlord_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Landlord_HomeDetails.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
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
                        <li><a href="Landlord_Homepage.php">Homepage</a></li>
                        <li class="dropdown">
                            <a href="Landlord_Catalogue.php" class="dropbtn">Catalogue <ion-icon name="caret-down-outline"></ion-icon></a>
                            <div class="dropdown-content">
                                <a href="Landlord_Catalogue.php">All Residential</a>
                                <a href="Landlord_BungalowVilla_Catalogue.php">Bungalow/Villa</a>
                                <a href="Landlord_ApartmentCondo_Catalogue.php">Apartment/Condo/Service Residence</a>
                                <a href="Landlord_SemiDetachedCatalogue.php">Semi-Detached House</a>
                                <a href="Landlord_TerraceLinkHouse_Catalogue.php">Terrace/Link House</a>
                            </div>
                        </li>
                        <li><a href="Landlord_AboutUs.php">About Us</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropbtn">More<ion-icon name="caret-down-outline"></ion-icon></a>
                            <div class="dropdown-content">
                            <a href="Landlord_Profile.php">Profile Info</a>
                            <a href="Landlord_ManageProperties.php">My Properties</a>
                            <a href="#change-password">Change Password</a>
                            <a href="Guest_Homepage.php">Logout</a>
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
                            <img src="uploads/girl.jpg" alt="Avatar" class="avatar">
                            Profile
                            <ion-icon name="caret-down-outline"></ion-icon>
                        </a>
                        <div class="dropdown-content">
                            <a href="Landlord_Profile.php">Profile Info</a>
                            <a href="Landlord_ManageProperties.php">My Properties</a>
                            <a href="#change-password">Change Password</a>
                            <a href="Guest_Homepage.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    
<br>

<div class="slider-wrapper">
            <div class="slide-container">
            <img src="uploads/1-Storey-Link-House_Kempas1.png" alt="Property Image">
        </div>
            <div class="slide-container">
            <img src="uploads/1-Storey-Link-House_Kempas2.png" alt="Property Image">
        </div>
    </div>
<br>

<div class="container">
        <div class="column1">
            <div class="linkrow">
                <a href="Landlord_Homepage.php">Home</a>
                <p class="separator"> | </p>
                <a href="Landlord_Catalogue.php">Catalogue</a>
                <p class="separator"> | </p>
                <a href="Landlord_LocalAmenities.php?propertyId=A001">
    Taman Bukit Indah</a>

            </div>

<h1>RM 3000/month</h1>
<div class="rentcategory">
    <b>Whole unit</b>
</div><br><br>
<b style="font-size: 22px;">Kiara 2 @ Austin Heights 2</b>
<p style="color: purple; margin-top: 10px; font-size: 18px;">Jalan 7/5, Taman Bukit Indah</p>

<p style=" background-color:lightgrey; border-radius: 10px; padding: 5px 10px; display: inline-block; font-weight: bold;">
            Property ID: A001        </p>
<br>
<hr> 

<div class="icon-row">
    <div class="icon-container">
        <i class="fa-solid fa-house-chimney" style="color:#543310;"></i>
        <p>Bungalow/Villa</p>
    </div>
    <div class="icon-container">
        <i class="fa-solid fa-bed" style="color: #543310;"></i>
        <p>1 Bedrooms</p>
    </div>
    <div class="icon-container">
        <i class="fa-solid fa-bath" style="color:#543310;"></i>
        <p>1 Bathroom</p>
    </div>
    <div class="icon-container">
        <i class="fa-solid fa-ruler" style="color: #543310;"></i>
        <p>1200 sqft</p>
    </div>
</div>
<hr>

<b style="font-size:20px;">Description</b>
<table class="rounded-table">
    <tr>
        <td>Floor Range</td>
        <td>Single</td>
    </tr>
    <tr>
        <td>Furnished</td>
        <td>Unfurnished</td>
    </tr>
    <tr>
        <td>Car parks</td>
        <td>0</td>
    </tr>
    <tr>
        <td>Facilities</td>
        <td>Car Park and Playground</td>
    </tr>
</table>

    </div>

    <div class="column">
            <div class="oblong1">
                <i class="fa-solid fa-circle-check"></i>
                AVAILABLE
            </div>
           
            <div class="rounded-box">
               <b style="font-size: 18px;"> Price Details:</b>
               <table class="pricetable">
               <tr>
    <td>1st month rental:</td>
    <td>RM 0.00</td>
</tr>
<tr>
    <td>Deposit:</td>
    <td>RM 0.00</td>
</tr>
<tr>
    <td>AYRENTAL fees:</td>
    <td>RM 200.00</td>
</tr>
<tr>
    <td>SST(6%):</td>
    <td>RM 0.00</td>
</tr>
<tr>
    <td>Total:</td>
    <td>RM 200.00</td>
</tr>
                
            </table>
        </div>
        <br>
        <table class="info-table">
    <tr>
      <th colspan="2">Home Details</th>
    </tr>
    <tr>
      <td class="icon-cell"><i class="fa-solid fa-house-chimney"></i></td>
      <td><b>Surcharge:</b> applied for rentals less than 12 months</td>
    </tr>
    <tr>
      <td class="icon-cell"><i class="fa-solid fa-eye"></i></td>
      <td><b>Viewing Availability: </b>Weekends</td>
    </tr>
    <tr>
      <td class="icon-cell"><i class="fa-regular fa-calendar-check"></i></td>
      <td><b>Property Availability: </b> Immediately</td>
    </tr>
    <tr>
      <td class="icon-cell"><i class="fa-solid fa-rotate"></i></td>
      <td><b>Last Update:</b> 2024-07-22 23:51:12</td>
    </tr>
  </table>

  <br> 
  <button class="editbutton" onclick="location.href='Landlord_Edit_PropertyCat.php?propertyId=A001'">
    Edit Property
</button>
<br><br>
<form id="deletePropertyForm" method="POST" action="Landlord_Delete_Property.php">
    <input type="hidden" name="propertyId" value="A001">
    <input type="hidden" name="propertyType" value="A">
    <button type="submit" class="editbutton">Delete Property</button>
</form>



      
<br><br>
<!-- Display success or error messages if redirected back with parameters -->
</div>
</div>
    </div>
<br>
<section class="footer">
        <div class="footer-container">
            <div class="footer-box">
                <h3>Quick Links</h3>
                <a href="Landlord_Homepage.php">Homepage</a>
                <a href="Landlord_Catalogue.php">Catalogue</a>
                <a href="Landlord_AboutUs.php">About Us</a>
            </div>
            
            <div class="footer-box">
                <h3>More</h3>
                <a href="Landlord_News.php">News</a>
                <a href="Landlord_LocalAmenities.php">Neighbourhood Facility</a>
                <a href="Landlord_FAQ.php">FAQ</a>
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
                <a href="Landlord_AcceptableUsePolicy.php">Acceptable Use Policy</a>
                <a href="Landlord_TermsofService.php">Terms of Service</a>
                <a href="Landlord_PrivacyPolicy.php">Privacy Policy</a>
            </div>
    
            <div class="copyright">
                <p>© 2024 Ong Hui Min & Yuthikkaa A/P Velavan. All rights reserved.</p>
            </div>
        </div>
    </section>

    <script>
function confirmAndRedirect(event, message, redirectUrl) {
    if (!confirm(message)) {
        event.preventDefault(); // Cancel form submission if user clicks 'Cancel'
    } else {
        window.location.href = redirectUrl; // Redirect to delete success page if user clicks 'OK'
    }
}
</script>


    <script src="script.js"></script>
    <script src="homedetails.js"></script>
</body>
</html>