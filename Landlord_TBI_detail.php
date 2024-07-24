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
    <link href="Landlord_Homepage.css" rel="stylesheet" type="text/css" />
    <link href="Landlord_LocalAmenitiesDetail.css" rel="stylesheet" type="text/css" />
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

    <section class="nav1"></section>
    <nav>
        <a href="Landlord_Homepage.php"><i class="fas fa-home"></i></a> &gt; <span><a href="Landlord_LocalAmenities.php">Neighbourhood Facility</a></span> &gt; <span><a href="Landlord_TBI_detail.php">Taman Bukit
                Indah</a></span>
    </nav>

    <main>
        <section class="overview">
            <div class="content">
                <h1>Taman Bukit Indah</h1>
                <p>Bukit Indah is an affluent and desirable suburb of Iskandar Puteri, located just 13km to the west of
                    Johor Bahru's city centre. This vibrant township first began development in 1997.</p>
                <p>Taman Bukit Indah, often referred to simply as Bukit Indah, is a thriving township located in the
                    heart of Iskandar Puteri, Johor. Renowned for its strategic location just 13 kilometers from Johor
                    Bahru's city center, Bukit Indah is celebrated for its well-planned infrastructure and abundant
                    amenities. Established in 1997, this vibrant suburb has grown into a sought-after residential area
                    known for its blend of modern conveniences and natural beauty.</p>
                <p>The township boasts a variety of shopping malls, educational institutions, healthcare facilities, and
                    recreational parks, making it an ideal place for families, professionals, and retirees. Its lush
                    green parks, such as Taman Rekreasi Bukit Indah, provide residents with ample space for outdoor
                    activities and relaxation. Moreover, the community is well-connected with excellent public transport
                    links and easy access to major highways, ensuring seamless connectivity to other parts of Johor and
                    beyond.</p>
                <p>Whether you're looking for a bustling commercial hub or a tranquil residential retreat, Bukit Indah
                    offers the perfect balance of urban living and serene surroundings, making it one of the most
                    desirable neighborhoods in Johor.</p>
            </div>
        </section>


        <section class="stats">
            <div class="stat-item">5<br>Shopping Malls</div>
            <div class="stat-item">18<br>Food Court</div>
            <div class="stat-item">3<br>Petrol Station</div>
            <div class="stat-item">13<br>Education</div>
            <div class="stat-item">10<br>Medical</div>
            <div class="stat-item">8<br>Bank</div>
        </section>

        <section class="map-nearby">
            <div class="content">
                <h2>Map & Nearby</h2>
                <div class="map-container">
                    <div id="map">
                        <iframe
                            src="https://www.google.com/maps/d/embed?mid=1tV6pUDCXyn4AFI3rajYHhrTEbYpqtgY&ehbc=2E312F&noprof=1"
                            width="640" height="480"></iframe>
                    </div>
                </div>
            </div>
        </section>
    </main>

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