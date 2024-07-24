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
    <link href="Tenant_Homepage.css" rel="stylesheet" type="text/css"/>
    <title>News</title>
    <link href="Tenant_News.css" rel="stylesheet" type="text/css"/>

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
                                <a href="Tenant_ApartmentCondo_Catalogue.php">Apartment/Condo/Service Residence</a>
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
    
    <div class="topbanner">
            <img src = "img/news.png" alt = "">
        </div>
 <div class="mainnews">  
    <section class = "banner">
        <div class = "banner-main-content">
            <h2>GET JOHOR'S LATEST NEWS</h2>
            <h3>Stay ahead of the market with the latest rental trends and insights, right at your fingertips.</h3>

            <button>
                <a href = "Tenant_AboutUs.php">Know More</a>
            </button>
        </div>
       
        <div class = "banner-sub-content">
            <div class = "hot-topic">
                <img src = "img/n1.jpg" alt = "">

            </div>
           

            <div class = "hot-topic">
              

                <div class = "hot-topic-content">
                    <h2>Residents in 1,238 low-rent Johor apartments to be evicted</h2>
                    <p>Property agents say workers seek accommodation close to border but commute to work in Singapore due to its stronger currency.</p>
                    <h3>By Bernama</h3>
                   
                    <a href = "Tenant_NewsDetails1.php">Read More</a>
                </div>
            </div>

            <div class = "hot-topic">
                

                <div class = "hot-topic-content">
                    <h2>Malaysia's Axis-REIT sells former steel site in Johor to data center company</h2>
                    <p>The deal is valued at RM162 million ($33.9m) and is set to close in the second half of the year.</p>
                    <h3>By Dan Swinhoe</h3>

                    <a href = "Tenant_NewsDetails2.php">Read More</a>
                </div>
            </div>

            <div class = "hot-topic">
                <img src = "img/n2.jpg" alt = "">
            </div>
        </div>
    </section>
    
    <hr>

    <main>
        <section class = "main-container-left">
            <h2>Top Stories</h2>
            

            <div class = "container-bottom-left">
                <article>
                    <img src = "img/news3.webp">
                    <div>
                        <h3>'Follow the Johor way': Business groups want stringent action over 'rental' of licences to foreigners</h3>
                        <p>By Aliza Shah</p>

                        <a href = "Tenant_NewsDetails3.php">Read More</a>
                    </div>
                </article>

                <article>
                    <img src = "img/news4.jpg">
                    <div>
                        <h3>Connectivity is key even as more Singaporeans eye cheaper life in Johor Bahru</h3>
                        <p>By Hadi Azmi</p>

                        <a href = "Tenant_NewsDetails4.php">Read More</a>
                    </div>
                </article>
            </div>
        </section>

        <section class = "main-container-right">
            <h2>Latest Stories</h2>
            
            <article>
                <h4>just in </h4>
                <div>
                    <h2>Malaysia's home rental up 5.5% in 2023, says IQI's new index</h2>

                    <p>By The Malaysian Reserve</p>

                    <a href = "Tenant_NewsDetails5.php">Read More </a>
                </div>
                <img src = "img/n1_1.jpg">
            </article>

            <article>
                <h4>just in </h4>
                <div>
                    <h2>Affordable units reclaimed by state</h2>

                    <p>By Remar Nordin</p>

                    <a href = "Tenant_NewsDetails6.php">Read More </a>
                </div>
                <img src = "img/n1_2.jpg">
            </article>

            <article>
                <h4>just in </h4>
                <div>
                    <h2>How a focus on Chinese buyers 'doomed' Malaysia's Forest City</h2>

                    <p>By Patrick Lee</p>

                    <a href = "Tenant_NewsDetails7.php">Read More </a>
                </div>
                <img src = "img/n1_3.jpg">
            </article>

            <article>
                <h4>just in </h4>
                <div>
                    <h2>Johor property sales set to boom with announcement</h2>

                    <p>By Venesa Devi</p>

                    <a href = "Tenant_NewsDetails8.php">Read More </a>
                </div>
                <img src = "img/n1_4.jpg">
            </article>

            <article>
                <h4>just in </h4>
                <div>
                    <h2>Demand outstrips supply for rental units in Johor</h2>

                    <p>By Zazali Musa</p>

                    <a href = "Tenant_NewsDetails9.php">Read More </a>
                </div>
                <img src = "img/n1_5.jpg">
            </article>
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
                <a href="Tenant_News.php">News</a>
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
                <a href="Tenant_TermsofService.php">Terms of Service</a>
                <a href="Tenant_PrivacyPolicy.php">Privacy Policy</a>
            </div>
    
            <div class="copyright">
                <p>© 2024 Ong Hui Min & Yuthikkaa A/P Velavan. All rights reserved.</p>
            </div>
        </div>
    </section>
    
    <script src="script.js"></script>
</body>
</html>
