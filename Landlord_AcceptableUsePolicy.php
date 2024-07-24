<?php
session_start();
$email = $_SESSION['email']; 

$host = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ayrentals"; 


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("SELECT avatar_path FROM users WHERE email = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($avatarPath);
$stmt->fetch();
$stmt->close();

$conn->close();


if (empty($avatarPath)) {
    $avatarPath = 'img\login.jpg'; 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>Acceptable Use Policy</title>
    <link href="Landlord_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Landlord_AcceptableUsePolicy.css" rel="stylesheet" type="text/css"/>
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
                                <a href="Landlord_News.php">News</a>
                                <a href="Landlord_LocalAmenities.php">Neighbourhood Facility</a>
                                <a href="Landlord_FAQ.php">FAQ</a>
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
                            <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="Avatar" class="avatar">
                            Profile
                            <ion-icon name="caret-down-outline"></ion-icon>
                        </a>
                        <div class="dropdown-content">
                            <a href="Landlord_Profile.php">Profile Info</a>
                            <a href="Landlord_ManageProperties.php">My Properties</a>
                            <a href="Guest_Homepage.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    <br>

    <section class="nav1"></section>
    <nav>
        <a href="Landlord_Homepage.php"><i class="fas fa-home"></i></a> <span class="separator">&gt;</span> <span> <a href="Landlord_AcceptableUsePolicy.php" class="terms-of-service">Policy of Acceptable Use</a>
    </nav>
    </section>

    <section class="Policy">
        <div class="sidebar-wrapper">
            <table class="sidebar-table">
                <thead>
                    <tr>
                        <th colspan="2">Policy of AYRENTALS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="Landlord_AcceptableUsePolicy.php">Acceptable Use Policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="Landlord_TermsofService.php">Terms of Service</a></td>
                    </tr>
                    <tr>
                        <td><a href="landlord_PrivacyPolicy.php">Privacy Policy</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="AcceptableUsePolicy">
            <h1>Policy Of Acceptable Use</h1>
            <p><strong>Last modified:</strong> 2 June 2024</p>
            <p>
                In using the services provided by AYRENTALS Sdn. Bhd. , you agree not to:
            </p>
            <ol>
                <li>Violate any law, statute or regulation (including but not limited to the Communications and Multimedia Content Code);</li>
                <li>Infringe the copyright, patent, trademark, trade secret or other intellectual property right of any party, including but not limited to AYRENTALS;</li>
                <li>Sell counterfeit goods;</li>
                <li>Sell any goods or provide any services prohibited by law;</li>
                <li>Engage in money laundering activities;</li>
                <li>Engage in gambling activities;</li>
                <li>Engage in any immoral activity or potentially immoral activity, including but not limited to prostitution and pornography;</li>
                <li>Impersonate any person or entity, or falsely state or otherwise misrepresent your affiliation with a person or entity;</li>
                <li>Act in a manner that is defamatory, libelous, threatening or harassing;</li>
                <li>Provide false, inaccurate or misleading information;</li>
                <li>Engage in potentially fraudulent, suspicious or illegal activity and/or transactions;</li>
                <li>"Stalk" or otherwise harass another user of the Website ("User");</li>
                <li>Send unsolicited emails to any User or use AYRENTALS's services to collect payments for sending, or assisting in sending unsolicited emails to third parties;</li>
                <li>Disclose or distribute another User’s personal information to a third party, or use such information in marketing without User's consent;</li>
                <li>Take any action that imposes an unreasonable or disproportionately large load on AYRENTALS's infrastructure;</li>
                <li>Upload, or cause to be uploaded, any content to the Website that contains viruses, or any other items that may damage, interfere with, or adversely affect or hinder access to the Website;</li>
                <li>Engage in, nor cause other Users to engage in, spamming, phishing, improper, malicious or, in AYRENTALS's absolute discretion, fraudulent clicking, impressions or marketing activities relating to the Website;</li>
                <li>In AYRENTALS's absolute discretion, reflect poorly on or tarnish the reputation of AYRENTALS;</li>
                <li>Modify, adapt, reformat, recompile, transmit, publish, license, reverse engineer, disassemble, reconstruct, decompile, copy or create derivative works of, transfer or sell any services on the Website or 
                    part thereof, including source codes or algorithms, except as expressly authorised by AYRENTALS in writing, or to the extent permitted by law;</li>
                <li>Alter, remove, cover or otherwise deface any identification, trademark, copyright or other notice from any aspect of the services on the Website;</li>
            </ol>
        </div>
    </section>

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
</body>
</html>


