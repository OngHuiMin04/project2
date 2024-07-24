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
    <link href="Tenant_Homepage.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                                <a href="Tenant_LocalAmenities.php">Local Amenities</a>
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

    <section class="main">
        <div class="banner">
    <div class="mySlides">
      <div class="numbertext">1 / 6</div>
        <img src="img/1.png" style="width:100%">
    </div>
  
    <div class="mySlides">
      <div class="numbertext">2 / 6</div>
        <img src="img/2.png" style="width:100%">
    </div>
  
    <div class="mySlides">
      <div class="numbertext">3 / 6</div>
        <img src="img/3.png" style="width:100%">
    </div>
  
    <div class="mySlides">
      <div class="numbertext">4 / 6</div>
        <img src="img/4.png" style="width:100%">
    </div>
  
    <div class="mySlides">
      <div class="numbertext">5 / 6</div>
        <img src="img/5.png" style="width:100%">
    </div>
  
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  
    <div class="caption-container">
      <p id="caption"></p>
    </div>
    
    <div class="search-container">
    <input type="hidden" id="usertype" value="Tenant">
        <input type="text" id="search-input" placeholder="Search Taman" class="search-input">
        <button class="search-button" onclick="searchProperties()">Search</button>
        <div class="search-box">
            <div class="dropdown search-dropdown">
                <button class="dropbtn" id="residentialBtn">All Residential<ion-icon name="caret-down-outline"></ion-icon></button>
                <div class="dropdown-content" id="residentialDropdown">
                    <div class="residential-options">
                        <button class="residential-option" data-value="all">All Residential</button>
                        <button class="residential-option" data-value="A">Bungalow/Villa</button>
                        <button class="residential-option" data-value="B">Apartment/Condo/Service Residence</button>
                        <button class="residential-option" data-value="C">Semi-Detached House</button>
                        <button class="residential-option" data-value="D">Terrace/Link House</button>
                    </div>
                    <div class="dropdown-actions">
                        <button class="apply-button" onclick="applyFilter('residential')">Apply Filter</button>
                        <div style="width: 20px;"></div>
                        <button class="clear-button"onclick="clearFilter('residential')">Clear</button>
                    </div>
                </div>
            </div>

            <div class="dropdown search-dropdown">
                <button class="dropbtn" id="priceBtn">Any Price<ion-icon name="caret-down-outline"></ion-icon></button>
                <div class="dropdown-content" id="priceDropdown">
                    <div class="price-options">
                        <button class="price-option" data-value="any">Any Price</button>
                        <button class="price-option" data-value="500-1500">RM 500-RM 1500</button>
                        <button class="price-option" data-value="1501-2500">RM 1501-RM 2500</button>
                        <button class="price-option" data-value="2501-3500">RM 2501-RM 3500</button>
                        <button class="price-option" data-value="3501-4500">RM 3501-RM 4500</button>
                        <button class="price-option" data-value="4501-5500">RM 4501-RM 5500</button>
                        <button class="price-option" data-value="5501-6500">RM 5501-RM 6500</button>
                    </div>
                    <div class="dropdown-actions">
                        <button class="apply-button"onclick="applyFilter('price')">Apply Filter</button>
                        <div style="width: 20px;"></div>
                        <button class="clear-button"onclick="clearFilter('price')">Clear</button>
                    </div>
                </div>
            </div>

            <div class="dropdown search-dropdown">
                <button class="dropbtn" id="bedroomBtn">Bedroom<ion-icon name="caret-down-outline"></ion-icon></button>
                <div class="dropdown-content" id="bedroomDropdown">
                    <div class="bedroom-options">
                        <button class="bedroom-option" data-value="Studio">Studio</button>
                        <button class="bedroom-option" data-value="1">1</button>
                        <button class="bedroom-option" data-value="2">2</button>
                        <button class="bedroom-option" data-value="3">3</button>
                        <button class="bedroom-option" data-value="4">4</button>
                        <button class="bedroom-option" data-value="5+">5+</button>
                    </div>
                    <div class="dropdown-actions">
                        <button class="apply-button"onclick="applyFilter('bedroom')">Apply Filter</button>
                        <div style="width: 20px;"></div>
                        <button class="clear-button"onclick="clearFilter('bedroom')">Clear</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="results"></div>
    </section>
    
    <section class="category">
        <h1 class="heading">Browse by Property Type</h1>
        <div class="category-box">
          <div class="box" style="background-image:url(img/Bungalow_Villa.jpg)">
            <a href="Tenant_BungalowVilla_Catalogue.php"><div class="hovertext">Bungalow/Villa</div></a>
          </div>
          <div class="box" style="background-image:url(img/apartment_condo_service_residence1.jpg)">
            <a href="Tenant_AppartmentCondo_Catalogue.php"><div class="hovertext">Apartment/Condo/Service Residence</div></a>
          </div>
          <div class="box" style="background-image:url(img/semi_detached_house.jpg)">
            <a href="Tenant_SemiDetachedCatalogue.php"><div class="hovertext">Semi-Detached House</div></a>
          </div>
          <div class="box" style="background-image:url(img/terrace_link_house.jpg)">
            <a href="Tenant_TerraceLinkHouse_Catalogue.php"><div class="hovertext">Terrace/Link House</div></a>
          </div>
        </div>
      </section>

      <section class="handpicked">
        <h1 class="heading">Handpicked for You</h1>
        <div class="handpicked-box">
            <div class="card">
                <div class="image" style="background-image:url('img/aah1_1.jpg')"></div>
                <div class="details">
                    <div class="price">RM 2,200 /month</div>
                    <div class="unit-type">Whole Unit</div>
                    <div class="info">
                        <span class="beds">3 <i class="fas fa-bed"></i></span>
                        <span class="baths">2 <i class="fas fa-bath"></i></span>
                        <span class="area">1033 sqft</span>
                    </div>
                    <div class="location">Midori Green@ Austin Heights</div>
                    <div class="address">Jalan Mutiara Emas 8, Taman Mount Austin, 81100 Johor Bahru</div>
                    <a href="Tenant_AppartmentCondo_Catalogue.php" class="button">
                        <i class="fas fa-building"></i> Condominium
                    </a>
                </div>
            </div>
    
            <div class="card">
                <div class="image" style="background-image:url('img/Semi-Detached Mount Austin1.jpg')"></div>
                <div class="details">
                    <div class="price">RM 3,850 /month</div>
                    <div class="unit-type">Whole Unit</div>
                    <div class="info">
                        <span class="beds">4 <i class="fas fa-bed"></i></span>
                        <span class="baths">4 <i class="fas fa-bath"></i></span>
                        <span class="area">2240 sqft</span>
                    </div>
                    <div class="location">Taman Mount Austin</div>
                    <div class="address">Jalan Mutiara Emas 10/11, Mount Austin, Johor Bahru</div>
                    <a href="Tenant_SemiDetachedCatalogue.php" class="button">
                        <i class="fas fa-building"></i> Semi-Detached House
                    </a>
                </div>
            </div>
            
            <div class="card">
                <div class="image" style="background-image:url('img/2-Storey-Link-House_HorizonHills1.png')"></div>
                <div class="details">
                    <div class="price">RM 5,500 /month</div>
                    <div class="unit-type">Whole Unit</div>
                    <div class="info">
                        <span class="beds">5 <i class="fas fa-bed"></i></span>
                        <span class="baths">5 <i class="fas fa-bath"></i></span>
                        <span class="area">2092 sqft</span>
                    </div>
                    <div class="location">Horizon Hills</div>
                    <div class="address">The Hills, Horizon Hills, Iskandar Puteri, Johor</div>
                    <a href="Tenant_TerraceLinkHouse_Catalogue.php" class="button">
                        <i class="fas fa-building"></i> Terrace/Link House
                    </a>
                </div>
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
                <a href="Tenant_TermsosService.php">Terms of Service</a>
                <a href="Tenant_PrivacyPolicy.php">Privacy Policy</a>
            </div>
    
            <div class="copyright">
                <p>© 2024 Ong Hui Min & Yuthikkaa A/P Velavan. All rights reserved.</p>
            </div>
        </div>
    </section>
    <script src="notification.js"></script>
    <script src="script.js"></script>
</body>
</html>
