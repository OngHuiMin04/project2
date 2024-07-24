<?php
session_start();

// Check if email is set in session
if (!isset($_SESSION['email'])) {
    die("Session email not set. Please log in.");
}

$email = $_SESSION['email']; // Assuming the user's email is stored in the session

// Database credentials
$host = "localhost";
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "ayrentals"; // Update with your database name

// Function to get user's avatar path
function getUserAvatarPath($conn, $email) {
    $stmt = $conn->prepare("SELECT avatar_path FROM users WHERE email = ?");
    if ($stmt === false) {
        die('SQL Prepare Error (avatar_path): ' . htmlspecialchars($conn->error));
    }
    
    $stmt->bind_param("s", $email);
    
    if (!$stmt->execute()) {
        die('Execute Error (avatar_path): ' . htmlspecialchars($stmt->error));
    }
    
    $stmt->bind_result($avatarPath);
    $stmt->fetch();
    $stmt->close();
    
    // If avatar path is empty, return default path
    if (empty($avatarPath)) {
        return 'img/login.jpg'; // Default avatar path
    }
    
    return $avatarPath;
}

// Function to get landlord's properties
function getLandlordProperties($conn, $email) {
    $sql = "SELECT p.propertyId, p.propertyName, p.address, p.price, p.bedroom, p.bathroom, p.size, p.propertyType, p.rentcategory, up.file_path 
            FROM properties p
            JOIN uploaded_photos up ON p.propertyId = up.propertyId
            WHERE p.email = ? AND p.propertyType IN ('A')";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('SQL Prepare Error (properties): ' . htmlspecialchars($conn->error));
    }
    
    $stmt->bind_param("s", $email);
    
    if (!$stmt->execute()) {
        die('Execute Error (properties): ' . htmlspecialchars($stmt->error));
    }
    
    $result = $stmt->get_result();
    $properties = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $properties[$row['propertyType']][$row['propertyId']][] = $row;
        }
    } else {
        echo "0 results";
    }
    
    $stmt->close();
    
    return $properties;
}

// Create a connection to the database for avatar and properties
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user's avatar path
$avatarPath = getUserAvatarPath($conn, $email);

// Get landlord's properties
$properties = getLandlordProperties($conn, $email);

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>Bungalow/Villa Catalogue</title>
    <link href="Landlord_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Landlord_Catalogue.css" rel="stylesheet" type="text/css"/>
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
        <a href="Landlord_Homepage.php"><i class="fas fa-home"></i></a> &gt; <span><a href="Landlord_BungalowVilla_Catalogue.php">Bungalow/Villa Catalogue</a></span>
    </nav>
    <div class="bannerup">
        <img src="img/bungalowvilla.png">
</div>
    <div class="search-filter-container">
        <input type="text" class="search-input" placeholder="Search Location">
        <button class="search-button">
            <i class="fas fa-search"></i> Search
        </button>
        <button class="filter-button">
            <i class="fas fa-sliders-h"></i> <span class="filter-text">Filter</span> <span class="filter-count">1</span>
        </button>
    </div>


   
    <?php
    $propertyTypes = [
        'A' => ['title' => 'A) Bungalow/Villa', 'button_class' => 'Bungalow/Villa'],
    ];
    ?>
    <div class="catalogue-box">
        <?php foreach ($propertyTypes as $propertyType => $typeInfo) : ?>
            <section class="catalogue">
                <div class="catalogue-box">
                    <?php if (isset($properties[$propertyType]) && is_array($properties[$propertyType])) : ?>
                        <?php foreach ($properties[$propertyType] as $propertyId => $property) : ?>
                            <div class="card">
                                <a href="<?php echo htmlspecialchars($property[0]['propertyName']); ?>.html" class="card-link"></a>
                                <div class="image slideshow-container" id="slideshow<?php echo $propertyId; ?>">
                                    <?php foreach ($property as $index => $photo) : ?>
                                        <div class="mySlides fade">
                                            <img src="<?php echo htmlspecialchars($photo['file_path']); ?>" style="width:100%;height:300px">
                                        </div>
                                    <?php endforeach; ?>
                                    <a class="prev" onclick="plusSlides(-1, 'slideshow<?php echo $propertyId; ?>')">&#10094;</a>
                                    <a class="next" onclick="plusSlides(1, 'slideshow<?php echo $propertyId; ?>')">&#10095;</a>
                                </div>
                                <div class="details">
                                    <div class="property-id">Property ID: <?php echo htmlspecialchars($propertyId); ?></div>
                                    <div class="price">RM <?php echo number_format($property[0]['price'], 2); ?> /month</div>
                                    <div class="unit-type"><?php echo htmlspecialchars($property[0]['rentcategory']); ?></div>
                                    <div class="info">
                                        <span class="beds"><?php echo htmlspecialchars($property[0]['bedroom']); ?> <i class="fas fa-bed"></i></span>
                                        <span class="baths"><?php echo htmlspecialchars($property[0]['bathroom']); ?> <i class="fas fa-bath"></i></span>
                                        <span class="area"><?php echo htmlspecialchars($property[0]['size']); ?> sqft</span>
                                    </div>
                                    <div class="location"><?php echo htmlspecialchars($property[0]['propertyName']); ?></div>
                                    <div class="address"><?php echo htmlspecialchars($property[0]['address']); ?></div>
                                    <div class="button-container">
                                        <a href="Landlord_HomeDetails.php?propertyId=<?php echo htmlspecialchars($propertyId); ?>" class="button <?php echo $typeInfo['button_class']; ?>">
                                            <i class="fas fa-building"></i> <?php echo $typeInfo['button_class']; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        <?php endforeach; ?>
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
    <script src="catalogue.js"></script>
</body>
</html>




    
