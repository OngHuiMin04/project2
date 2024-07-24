<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "ayrentals";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get parameters from URL
$taman = isset($_GET['taman']) ? $_GET['taman'] : '';
$propertyType = isset($_GET['propertyType']) ? $_GET['propertyType'] : 'all';
$price = isset($_GET['price']) ? $_GET['price'] : 'any';
$bedroom = isset($_GET['bedroom']) ? $_GET['bedroom'] : 'any';

// Initialize SQL query
$sql = "SELECT p.propertyId, p.propertyName, p.residentialname, p.address, p.price, p.bedroom, p.bathroom, p.size, p.propertyType, p.rentcategory, up.file_path 
        FROM properties p
        JOIN uploaded_photos up ON p.propertyId = up.propertyId
        WHERE p.propertyType IN ('A', 'B', 'C', 'D')";

// Add conditions based on parameters
$conditions = [];

if ($taman) {
    $conditions[] = "p.residentialname LIKE '%" . $conn->real_escape_string($taman) . "%'";
}
if ($propertyType != 'all') {
    $conditions[] = "p.propertyType = '" . $conn->real_escape_string($propertyType) . "'";
}
if ($price != 'any') {
    $conditions[] = "p.price <= '" . $conn->real_escape_string($price) . "'";
}
if ($bedroom != 'any') {
    $conditions[] = "p.bedroom = '" . $conn->real_escape_string($bedroom) . "'";
}

// Only append WHERE clause if there are conditions
if (count($conditions) > 0) {
    $sql .= " AND " . implode(' AND ', $conditions);
}

// Debugging SQL query - Comment out or remove this line to hide SQL query
// echo $sql;

// Execute the query
$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

$properties = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $properties[$row['propertyType']][$row['propertyId']][] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>Catalogue</title>
    <link href="Guest_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Guest_Catalogue.css" rel="stylesheet" type="text/css"/>
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
                        <li><a href="Guest_Homepage.php">Homepage</a></li>
                        <li class="dropdown">
                            <a href="Guest_Catalogue.php" class="dropbtn">Catalogue <ion-icon name="caret-down-outline"></ion-icon></a>
                            <div class="dropdown-content">
                                <a href="Guest_Catalogue.php">All Residential</a>
                                <a href="Guest_BungalowVilla_Catalogue.php">Bungalow/Villa</a>
                                <a href="Guest_AppartmentCondo_Catalogue.php">Apartment/Condo/Service Residence</a>
                                <a href="Guest_SemiDetachedCatalogue.php">Semi-Detached House</a>
                                <a href="Guest_TerraceLinkHouse_Catalogue.php">Terrace/Link House</a>
                            </div>
                        </li>
                        <li><a href="Guest_AboutUs.php">About Us</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropbtn">More<ion-icon name="caret-down-outline"></ion-icon></a>
                            <div class="dropdown-content">
                                <a href="Guest_News.php">News</a>
                                <a href="Guest_LocalAmenities.php">Neighbourhood Facility</a>
                                <a href="Guest_FAQ.php">FAQ</a>
                            </div>
                        </li>
                    </ul>
                </nav>
    
                <div class="header-buttons">
                    <a href="Login_Register.html">
                        <button id="login-btn">Login</button>
                      </a>
                </div>
            </div>
        </div>
    </section>     

    <section class="nav1"></section>
    <nav>
        <a href="Guest_Homepage.php"><i class="fas fa-home"></i></a> &gt; <span><a href="Guest_Catalogue.php">Catalogue</a></span>
    </nav>
    <div class="bannerup">
    <img src="img/allresidential.png">
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
    // Define property type
    $propertyTypes = [
        'A' => [
            'title' => 'A) Bungalow/Villa',
            'button_class' => 'Bungalow/Villa',
            'middlebanner' => '<img src="img/bungaloweachcat.png" alt="Bungalow/Villa Image" style="display: block; margin: 0 auto 25px; width: 1300px; height: 170px;" />'
        ],
        'B' => [
            'title' => 'B) Apartment/Condo/Service Residence',
            'button_class' => 'Apartment/Condo/Service Residence',
            'middlebanner' => '<img src="img/apartmenteachcat.png" alt="Apartment Image" style="display: block; margin: 0 auto 25px; width: 1300px; height: 170px;" />'
        ],
        'C' => [
            'title' => 'C) Semi-Detached House',
            'button_class' => 'Semi-Detached House',
            'middlebanner' => '<img src="img/semideachcat.png" alt="Semi-Detached House Image" style="display: block; margin: 0 auto 25px; width: 1300px; height: 170px;" />'
        ],
        'D' => [
            'title' => 'D) Terrace/Link House',
            'button_class' => 'Terrace/Link House',
            'middlebanner' => '<img src="img/terraceeachcat.png" alt="Terrace/Link House Image" style="display: block; margin: 0 auto 25px; width: 1300px; height: 170px;" />'
        ],
    ];
    
    

    // Repeat each property type
    foreach ($propertyTypes as $propertyType => $typeInfo) {
        ?>
        <section class="catalogue">
            <div class="middlebanner">
                <?php echo $typeInfo['middlebanner']; ?>
            </div>
            <div class="catalogue-box">
                <?php if (isset($properties[$propertyType])): ?>
                    <?php foreach ($properties[$propertyType] as $propertyId => $property) : ?>
                        <div class="card">
                            <a href="<?php echo htmlspecialchars($property[0]['propertyName']); ?>.html" class="card-link"></a>
                            <div class="image slideshow-container" id="slideshow<?php echo htmlspecialchars($propertyId); ?>">
                                <?php foreach ($property as $index => $photo) : ?>
                                    <div class="mySlides fade">
                                        <img src="<?php echo htmlspecialchars($photo['file_path']); ?>" style="width:100%;height:300px">
                                    </div>
                                <?php endforeach; ?>
                                <a class="prev" onclick="plusSlides(-1, 'slideshow<?php echo htmlspecialchars($propertyId); ?>')">&#10094;</a>
                                <a class="next" onclick="plusSlides(1, 'slideshow<?php echo htmlspecialchars($propertyId); ?>')">&#10095;</a>
                            </div>
                            <div class="details">
                                <div class="property-id" style="font-size: 24px; font-weight: bold; margin-bottom: 5px; color: #333;">
                                    Property ID: <?php echo htmlspecialchars($propertyId); ?>
                                </div>
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
                                    <a href="Guest_HomeDetails.php?propertyId=<?php echo htmlspecialchars($propertyId); ?>" class="button <?php echo htmlspecialchars($typeInfo['button_class']); ?>">
                                        <i class="fas fa-building"></i> <?php echo htmlspecialchars($typeInfo['button_class']); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="width: 100%; text-align: center;">
                    <p style="font-size: 24px; text-align: center; font-weight: bold; margin: 20px 0;">
                        No properties of type '<?php echo htmlspecialchars($propertyType); ?>' found.
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
    ?>





<section class="footer">
        <div class="footer-container">
            <div class="footer-box">
                <h3>Quick Links</h3>
                <a href="Guest_Homepage.php">Homepage</a>
                <a href="Guest_Catalogue.php">Catalogue</a>
                <a href="Guest_AboutUs.php">About Us</a>
            </div>
            
            <div class="footer-box">
                <h3>More</h3>
                <a href="Guest_News.php">News</a>
                <a href="Guest_LocalAmenities.php">Neighbourhood Facility</a>
                <a href="Guest_FAQ.php">FAQ</a>
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
                <a href="Guest_AcceptableUsePolicy.php">Acceptable Use Policy</a>
                <a href="Guest_TermsosService.php">Terms of Service</a>
                <a href="Guest_PrivacyPolicy.php">Privacy Policy</a>
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

