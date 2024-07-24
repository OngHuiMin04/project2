<?php
session_start(); // Start the session

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ayrentals";
$propertyTable = "properties";
$imageTable = "uploaded_photos";
$userTable = "users";

// Establish database connection using PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch property details and images from the database
try {
    if (isset($_GET['propertyId'])) {
        $propertyId = $_GET['propertyId'];
        $stmt = $pdo->prepare("
            SELECT p.propertyId, p.propertyName, p.address, p.price, p.bedroom, p.bathroom, p.size, p.propertyType, p.deposit, p.facilities, p.rentcategory, p.floorLevel, p.furnishing, p.parking, p.residentialname, p.v_available, p.p_available, p.created_at, up.file_path
            FROM $propertyTable p
            JOIN $imageTable up ON p.propertyId = up.propertyId
            WHERE p.propertyId = ?
        ");
        $stmt->execute([$propertyId]);
        $property = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch price details
        $stmt_price = $pdo->prepare("SELECT price, deposit, ayrentalFees, sst, total FROM pricedetails WHERE propertyId = :propertyId");
        $stmt_price->bindParam(':propertyId', $propertyId);
        $stmt_price->execute();
        $details = $stmt_price->fetch(PDO::FETCH_ASSOC);

        // Assign fetched data to variables
        $price = $details['price'];
        $deposit = $details['deposit'];
        $ayrentalFees = $details['ayrentalFees'];
        $sst = $details['sst'];
        $total = $details['total'];
    } else {
        // Handle case where propertyId is not set
        die("Property ID not provided.");
    }

    // Fetch user details if session email is set
    if (isset($_SESSION['email'])) {
        $current_email = $_SESSION['email'];
        $stmt_user = $pdo->prepare("SELECT name, avatar_path, email, phone_number FROM $userTable WHERE email=?");
        $stmt_user->execute([$current_email]);
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
    } else {
        // Handle case where $_SESSION['email'] is not set
        $user = null; // or handle it according to your application's logic
    }

} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}

// Function to get property type name based on type code
function getPropertyTypeName($typeCode) {
    switch ($typeCode) {
        case 'A':
            return 'Bungalow/Villa';
        case 'B':
            return 'Apartment/Condo/Service Residence';
        case 'C':
            return 'Semi-Detached House';
        case 'D':
            return 'Terrace/Link House';
        default:
            return 'Unknown';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>Homepage</title>
    <link href="Guest_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Guest_Homedetails.css" rel="stylesheet" type="text/css"/>
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
<br>

<div class="slider-wrapper">
    <?php foreach ($property as $row): ?>
        <div class="slide-container">
            <img src="<?php echo $row['file_path']; ?>" alt="Property Image">
        </div>
    <?php endforeach; ?>
</div>
<br>

<div class="container">
        <div class="column1">
            <div class="linkrow">
                <a href="Guest_Homepage.php">Home</a>
                <p class="separator"> | </p>
                <a href="Guest_Catalogue.php">Catalogue</a>
                <p class="separator"> | </p>
                <a href=""><?php echo $property[0]['residentialname']; ?></a>
            </div>

<h1>RM <?php echo $property[0]['price']; ?>/month</h1>
<div class="rentcategory">
    <b><?php echo $property[0]['rentcategory']; ?></b>
</div><br><br>
<b style="font-size: 22px;"><?php echo $property[0]['propertyName']; ?></b>
<p style="color: purple; margin-top: 10px; font-size: 18px;"><?php echo $property[0]['address']; ?></p>

<p style=" background-color:lightgrey; border-radius: 10px; padding: 5px 10px; display: inline-block; font-weight: bold;">
            Property ID: <?php echo $property[0]['propertyId']; ?>
        </p>
<br>
<hr> 

<div class="icon-row">
    <div class="icon-container">
        <i class="fa-solid fa-house-chimney" style="color:#543310;"></i>
        <p><?php echo getPropertyTypeName($property[0]['propertyType']); ?></p>
    </div>
    <div class="icon-container">
        <i class="fa-solid fa-bed" style="color: #543310;"></i>
        <p><?php echo $property[0]['bedroom']; ?> Bedrooms</p>
    </div>
    <div class="icon-container">
        <i class="fa-solid fa-bath" style="color:#543310;"></i>
        <p><?php echo $property[0]['bathroom']; ?> Bathroom</p>
    </div>
    <div class="icon-container">
        <i class="fa-solid fa-ruler" style="color: #543310;"></i>
        <p><?php echo $property[0]['size']; ?> sqft</p>
    </div>
</div>
<hr>

<b style="font-size:20px;">Description</b>
<table class="rounded-table">
    <tr>
        <td>Floor Range</td>
        <td><?php echo $property[0]['floorLevel']; ?></td>
    </tr>
    <tr>
        <td>Furnished</td>
        <td><?php echo $property[0]['furnishing']; ?></td>
    </tr>
    <tr>
        <td>Car parks</td>
        <td><?php echo $property[0]['parking']; ?></td>
    </tr>
    <tr>
        <td>Facilities</td>
        <td><?php echo $property[0]['facilities']; ?></td>
    </tr>
</table>

<b style="font-size:20px;">Map</b><br>
<div class="map-container">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.3319246420847!2d103.77477607472503!3d1.5640180984213887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da6e89c758c9d7%3A0xf34b37c7794341e4!2sMANHATTAN%20%40%20Austin%20Heights!5e0!3m2!1sen!2smy!4v1718395029549!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>
    </div>

    <div class="column">
            <div class="oblong1">
                <i class="fa-solid fa-circle-check"></i>
                AVAILABLE
            </div>
           
            <div class="rounded-box">
               <b style="font-size: 18px;"> Price Details:</b>
               <table class="pricetable">
               <tr>
    <td>1st month rental:</td>
    <td>RM <?php echo number_format($price, 2); ?></td>
</tr>
<tr>
    <td>Deposit:</td>
    <td>RM <?php echo number_format($deposit, 2); ?></td>
</tr>
<tr>
    <td>AYRENTAL fees:</td>
    <td>RM <?php echo number_format($ayrentalFees, 2); ?></td>
</tr>
<tr>
    <td>SST(6%):</td>
    <td>RM <?php echo number_format($sst, 2); ?></td>
</tr>
<tr>
    <td>Total:</td>
    <td>RM <?php echo number_format($total, 2); ?></td>
</tr>
                
            </table>
        </div>
        <br>
        <table class="info-table">
    <tr>
      <th colspan="2">Home Details</th>
    </tr>
    <tr>
      <td class="icon-cell"><i class="fa-solid fa-house-chimney"></i></td>
      <td><b>Surcharge:</b> applied for rentals less than 12 months</td>
    </tr>
    <tr>
      <td class="icon-cell"><i class="fa-solid fa-eye"></i></td>
      <td><b>Viewing Availability: </b><?php echo $property[0]['v_available']; ?></td>
    </tr>
    <tr>
      <td class="icon-cell"><i class="fa-regular fa-calendar-check"></i></td>
      <td><b>Property Availability: </b> <?php echo $property[0]['p_available']; ?></td>
    </tr>
    <tr>
      <td class="icon-cell"><i class="fa-solid fa-rotate"></i></td>
      <td><b>Last Update:</b> <?php echo $property[0]['created_at']; ?></td>
    </tr>
  </table>

  <br>
  <div class="contact-box">
    <h3>CONTACT LANDLORD</h3>
    <hr>
    <div class="profile-section">
        <img class="profile-picture" src="img/prof.png" alt="Profile Picture">
        <div class="username">Yuthikkaa</div>
    </div>
    <hr>
    <div class="button-section">
        <a href="https://api.whatsapp.com/send?phone=60165368826" target="_blank">
            <i class="fa-brands fa-whatsapp" style="color:#25D366;"></i> WHATSAPP
        </a>
        <a href="mailto:ayrentals@gmail.com">
            <i class="fa-solid fa-envelope" style="color:white;"></i> EMAIL
        </a>
        <hr>
        <p style="font-size: 14px;">(Typically replies within 12 hours)</p>
    </div>
</div>
<br>
<br><br>
</div>
</div>
</div>
<br>
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

