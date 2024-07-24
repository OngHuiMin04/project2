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
            <img src="img/nd3.jpg" class="news__main-cover news__main-cover--desktop" />
           
            <div class="news__main-content">
              <h1 class="news__main-title">Follow the Johor way': Business groups want stringent action over 'rental' of licences to foreigners</h1>
              <div class="news__main-info">
                <p class="news__main-subtitle">
                  <h3>Foreigners can manage businesses but they must have valid permits and should only be in industries where locals have no interest.</h3>
                </p>
                <br>
                <hr>
                <br>
                <div class="newsbox" style="text-align: center;">
                  <p><span><i>16/2/2024</i></span></p>
                  <p><span>by <b>Aliza Shah</b></span></p>
              </div>
              <hr>
              </div>
            </div>
            <hr><br>
            <div class="newsparagraph">
          <p><b>KUALA LUMPUR: </b> Two business groups have urged Putrajaya to adopt the Johor state government's plan to blacklist business owners who 'rent' their licences to foreigners.</p>
          <p>Malay Chamber of Commerce Malaysia (MCCM) president Norsyahrin Hamidon said foreigners who rented licenses from local business owners did not pay taxes.</p>
          <p>"Foreigners can manage businesses but they must have valid permits and should only be in industries where locals have no interest.</p>
          <p> "They can't become business owners because they don't pay taxes," he told the New Straits Times adding rent-seeking activities affected local business owners.</p>  
          <p>Johor Housing and Local Government Committee chairman Datuk Mohd Jafni Md Shukor previously said local business owners who abuse their licences by renting them out to foreigners will be blacklisted and have their licences cancelled.</p>
          <p>The measure, he added was to curb illegal foreign business ownership.Kuala Lumpur and Selangor Indian Chamber of Commerce and Industry president Nivas Ragavan praised the Johor government's initiative.
            He said enforcement efforts to curb rent-seeking should begin at the local level. He also said state and the federal authorities should also crack down on the practice.</p> 
          <p>"Strict action should be taken against locals renting out their business licenses and premises to foreigners, including cancelling their licenses and blacklisting them.</p>
          <p>"The foreigners involved should be dealt with, and this includes repatriating and blacklisting them," he said.</p>
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
                </p>ick Lee
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
