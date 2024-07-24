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
    <title>Neighbourhood Facility</title>
    <link href="Tenant_Homepage.css" rel="stylesheet" type="text/css" />
    <link href="Tenant_LocalAmenities.css" rel="stylesheet" type="text/css" />
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

    <div class="bannerup">
            <img src="img/neighbourhoodfacilities.png" alt="Neighbourhood Facilities">
        </div>
    <section class="areainsider">
      
        <div class="area-box">
            <div class="box-container">
                <a href="Tenant_AustinHeight_detail.php">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front" style="background-image:url('img/Austin_Heights.jpeg')"></div>
                            <div class="flip-box-back">Taman Austin Height</div>
                        </div>
                    </div>
                    <a href="Tenant_AustinHeight_detail.php">
                        <button class="show-more">Show More</button>
                    </a>
            </div>
            <div class="box-container">
                <a href="Tenant_TBI_detail.php">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front" style="background-image:url('img/taman_bukit_indah.jpg')"></div>
                            <div class="flip-box-back">Taman Bukit Indah</div>
                        </div>
                    </div>
                </a>
                <a href="Tenant_TBI_detail.php">
                    <button class="show-more">Show More</button>
                </a>
            </div>
            <div class="box-container">
                <a href="Tenant_Horizon_detail.php">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front" style="background-image:url('img/horizon_hills.jpg')"></div>
                            <div class="flip-box-back">Horizon Hills</div>
                        </div>
                    </div>
                </a>
                <a href="Tenant_Horizon_detail.php">
                    <button class="show-more">Show More</button>
                </a>
            </div>
            <div class="box-container">
                <a href="Tenant_KempasIndah_detail.php">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front" style="background-image:url('img/kempas_indah.jpg')"></div>
                            <div class="flip-box-back">Taman Kempas Indah</div>
                        </div>
                    </div>
                </a>
                <a href="Tenant_KempasIndah_detail.php">
                    <button class="show-more">Show More</button>
                </a>
            </div>
            <div class="box-container">
                <a href="Tenant_Molek_detail.php">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front" style="background-image:url('img/taman_molek.jpg')"></div>
                            <div class="flip-box-back">Taman Molek</div>
                        </div>
                    </div>
                </a>
                <a href="Tenant_Molek_detail.php">
                    <button class="show-more">Show More</button>
                </a>
            </div>
            <div class="box-container">
                <a href="Tenant_MountAustin_detail.php">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front" style="background-image:url('img/Mount-Austin-JB.jpg')"></div>
                            <div class="flip-box-back">Taman Mount Austin</div>
                        </div>
                    </div>
                </a>
                <a href="Tenant_MountAustin_detail.php">
                    <button class="show-more">Show More</button>
                </a>
            </div>
        </div>
    </section>

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
        document.addEventListener('DOMContentLoaded', function () {
            const boxes = document.querySelectorAll('.box');

            boxes.forEach(box => {
                box.addEventListener('click', function () {
                    const innerBox = box.querySelector('.box-inner');
                    innerBox.style.transform = innerBox.style.transform === 'rotateY(180deg)' ? 'rotateY(0deg)' : 'rotateY(180deg)';
                });
            });
        });
    </script>
</body>

</html>