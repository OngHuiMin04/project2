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
    <title>Homepage - System Name</title>
    <link href="Landlord_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Landlord_NewsDetails.css" rel="stylesheet" type="text/css"/>
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
                            <a href="ManageProperties.php">My Properties</a>
                            <a href="Guest_Homepage.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    

  <main>
    <div class="topnav">
    <a href="Homepage.html"><i class="fas fa-home"></i></a> &gt; <span><a href="News.html">News</a></span>
</div>
    <section class="news">
      <div class="container">
        <div class="news__inner">
          <article class="news__main">
            <img src="img/nd6.jpg" class="news__main-cover news__main-cover--desktop" />
           
            <div class="news__main-content">
              <h1 class="news__main-title">Affordable units reclaimed by state</h1>
              <div class="news__main-info">
                <p class="news__main-subtitle">
                  <h3>MORE than 2,000 units of Rumah Sewa Kerajaan (RSK) and people’s housing projects (PPR) have been reclaimed by the Johor government for issues concerning subletting.</h3>
                </p>
                <br>
                <hr>
                <br>
                <div class="newsbox" style="text-align: center;">
                  <p><span><i>26/2/2024</i></span></p>
                  <p><span>by <b>Remar Nordin</b></span></p>
              </div>
              <hr>
              </div>
            </div>
            <hr><br>
            <div class="newsparagraph">
        <p>State housing and local government committee chairman Datuk Mohd Jafni Md Shukor said this was based on the legalisation and profiling processes that the government initiated back in 2022.</p>
        <p>“We have a total of 14,500 housing units belonging to 13 PPR and seven RKS in the state.</p>
        <p>“The tenants of around 2,000 units were caught subletting to other people, for two to three times of the average monthly rental.</p>
        <p>“So we have revoked the original tenants’ rights and offered new lease contracts to the families that were renting the flats from those tenants.</p>
        <p>“This is provided they meet the requirements such as having a monthly income of below RM3,000.”
            Mohd Jafni said this after launching the Community Empowerment Programme and Community Farm Project at RSK Taman Cendana, Pasir Gudang.</p>
        <p>Mohd Jafni added that RSK Taman Cendana alone required RM9.9mil from the allocation to cover the cost of repainting the building as well as roof and sewerage treatment plant maintenance.</p>
        <p>“There are more than 1,500 units across 20 blocks, and this is one of the RSK projects that offers an affordable monthly rental fee of between RM200 and RM300,” he said.</p>
    </div>
          </article> 
          
          <div class="vl"></div>
          <aside class="news__side">
          
            <h2 class="news__side-title">New</h2>
            <ul class="news__side-list">
              <li class="news__side-item">
              <h3 class="news__side-item__title">
                  <a href="Landlord_NewsDetails9.php">Demand outstrips supply for rental units in Johor</a>
                </h3>
                <p class="news__side-item__description">
                  By Zazali Musa
                </p>
              </li>
              <li class="news__side-item">
                <h3 class="news__side-item__title">
                  <a href="Landlord_NewsDetails8.php">Johor property sales set to boom with announcement</a>
                </h3>
                <p class="news__side-item__description">
                  Venesa Devi
                </p>
              </li>
              <li class="news__side-item">
                <h3 class="news__side-item__title">
                  <a href="Landlord_NewsDetails7.php"> How a focus on Chinese buyers 'doomed' Malaysia's Forest City</a>
                </h3>
                <p class="news__side-item__description">
                  By Patrick Lee
                </p>
              </li>
            </ul>
          </aside>
        </div>
      </div>
    </section>
    <section class="recent">
      <div class="container">
        <div class="recent__inner">
          <ul class="recent__list">
            <li class="recent__item">
              <article class="recent__article">
                <i class="fa-solid fa-user" style="color: #ffffff; font-size: 40px;"></i>
                <div class="recent__article-info">
                  <span class="recent__article-number">Register</span>
                  <h4 class="recent__article-title">
                    <a href="Login_Register.html"> Login to book your own house!
                    </a>
                  </h4>
                 
                </div>
              </article>
            </li>
            <li class="recent__item">
              <article class="recent__article">
                <i class="fa-solid fa-circle-info" style="color: #ffffff; font-size: 40px;"></i>
                <div class="recent__article-info">
                  <span class="recent__article-number">About Us</span>
                  <h4 class="recent__article-title">
                    <a href="Landlord_AboutUs.php"> Learn more about our services
                    </a>
                  </h4>
                 
                </div>
              </article>
            </li>
            <li class="recent__item">
              <article class="recent__article">
                <i class="fa-solid fa-house" style="color: #ffffff; font-size: 40px;";></i>
                <div class="recent__article-info">
                  <span class="recent__article-number">Catalogue</span>
                  <h4 class="recent__article-title">
                    <a href="Landlord_Catalogue.php"> Browse through hundreds of houses
                    </a>
                  </h4>
                  
                </div>
              </article>
            </li>
          </ul>
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
  
    <script src="script.js"></script>
</body>
</html>
