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
    <title>Neighbourhood Facility Detail</title>
    <link href="Tenant_Homepage.css" rel="stylesheet" type="text/css" />
    <link href="Tenant_LocalAmenitiesDetail.css" rel="stylesheet" type="text/css" />
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
                            <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="Avatar" class="avatar">
                            Profile
                            <ion-icon name="caret-down-outline"></ion-icon>
                        </a>
                        <div class="dropdown-content">
                            <a href="Tenant_Profile.php">Profile Info</a>
                            <a href="Guest_Homepage.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>      

    <section class="nav1"></section>
    <nav>
        <a href="Tenant_Homepage.php"><i class="fas fa-home"></i></a> &gt; <span><a href="Tenant_LocalAmenities.php">Neighbourhood Facility</a></span> &gt; <span><a href="Tenant_Horizon_detail.php">Horizon
                Hills</a></span>
    </nav>

    <main>
        <section class="overview">
            <div class="content">
                <h1>Horizon Hills</h1>
                <p>Horizon Hills is a prestigious and serene residential development nestled in the heart of Iskandar
                    Puteri, Johor. Established as a luxury gated community, Horizon Hills is renowned for its
                    meticulously planned layout, lush green landscapes, and world-class amenities. The development is
                    built around a stunning 18-hole championship golf course designed by renowned golf architect Ross
                    Watson, offering residents picturesque views and an unparalleled golfing experience.</p>
                <p>Located just a short drive from Johor Bahru's city center and close to key amenities such as shopping
                    malls, international schools, healthcare facilities, and recreational parks, Horizon Hills provides
                    an ideal balance of tranquility and convenience. The community is well-connected with excellent
                    infrastructure and easy access to major highways, ensuring seamless connectivity to Singapore and
                    other parts of Johor.</p>
                <p>With its blend of luxurious living spaces, state-of-the-art facilities, and beautiful natural
                    surroundings, Horizon Hills stands as a premier choice for discerning homeowners seeking an
                    exclusive and peaceful lifestyle.</p>
            </div>
        </section>

        <section class="stats">
            <div class="stat-item">8<br>Shopping Malls</div>
            <div class="stat-item">13<br>Food Court</div>
            <div class="stat-item">0<br>Petrol Station</div>
            <div class="stat-item">10<br>Education</div>
            <div class="stat-item">5<br>Medical</div>
            <div class="stat-item">0<br>Bank</div>
        </section>

        <section class="map-nearby">
            <div class="content">
                <h2>Map & Nearby</h2>
                <div class="map-container">
                    <div id="map">
                        <iframe src="https://www.google.com/maps/d/embed?mid=10aKgOj3pOGKTxaoDNkQzE2Cxp7ZaTUY&ehbc=2E312F&noprof=1" width="640" height="480"></iframe>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
</body>

</html>