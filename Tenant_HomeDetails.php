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
    <title>Catalogue</title>
    <link href="Tenant_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Tenant_HomeDetails.css" rel="stylesheet" type="text/css"/>
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
                            <a href="Tenant_Profile.php">Profile Info</a>
                            
                            <a href="#change-password">Change Password</a>
                            <a href="Guest_Homepage.php">Logout</a>
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
                            <a href="#change-password">Change Password</a>
                            <a href="Guest_Homepage.php">Logout</a>
                        </div>
                    </div>
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
                <a href="Tenant_Homepage.php">Home</a>
                <p class="separator"> | </p>
                <a href="Tenant_Catalogue.php">Catalogue</a>
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
<iframe
        width="600"
        height="450"
        frameborder="0"
        scrolling="no"
        marginheight="0"
        marginwidth="0"
        src="https://www.openstreetmap.org/export/embed.html?width=600&amp;height=450&amp;layer=mapnik&amp;zoom=12&amp;mlat=<?php echo urlencode($address); ?>">
        </iframe>
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
    <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="Avatar" class="avatar">
    <div class="username"><?php echo htmlspecialchars($user['name']); ?></div>
    </div>
    <hr>
    <div class="button-section">
    <a href="https://api.whatsapp.com/send?phone=<?php echo htmlspecialchars($userCountryCode) . htmlspecialchars($userPhoneNumber); ?>" target="_blank">
            <i class="fa-brands fa-whatsapp" style="color:#25D366;"></i> WHATSAPP
        </a>
        <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>">
            <i class="fa-solid fa-envelope" style="color:white;"></i> EMAIL
        </a>
        <hr>
        <p style="font-size: 14px;">(Typically replies within 12 hours)</p>
    </div>
</div>

<br>
<button class="bookingbutton" onclick="OpenBookingPopup()">
    <i class="fa-solid fa-chevron-right"></i>BOOK NOW
</button>

<div id="bookingmodal" class="bookingmodal">
    <div class="bookingcontent">
        <span class="bookclose" onclick="CloseBookingPopup()">&times;</span>
        <div class="bookingcontainer">
            <header>BOOKING</header>
            <form class="card-form" method="POST" action="Tenant_Bookings.php">
                <div id="step1" class="step">
                    <div class="step-content">
                        <div class="step-left">
                            <img src="img/bookform1.png" alt="Step 1 Image" style="width:100%; height:auto;"> 
                            
                        </div>
                        <div class="step-right">
                            <div class="enter">
                                <input type="text" class="enter-field" name="propertyId" required readonly value="<?php echo $property[0]['propertyId']; ?>" />
                                <label class="">Property ID:</label>
                            </div>
                            <div class="enter">
                                <input type="email" class="enter-field" name="email" required/>
                                <label class="enter-label">Email</label>
                            </div>
                            <div class="enter">
                                <input type="tel" class="enter-field" name="phone" required/>
                                <label class="enter-label">Phone Number</label>
                            </div>
                            <div class="bookingaction">
                                <button type="button" class="bookingnextbutton" onclick="nextStep(1)">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="step2" class="step" style="display:none;">
                    <div class="step-content">
                        <div class="step-left">
                            <div style="text-align: center;">
                                <img src="img/bookform2.png" alt="Step 2 Image" style="max-width: 100%; height:auto;">
                            </div>
                        </div>
                        <div class="step-right2">
                            <div class="enter2">
                                <input type="number" class="enter-field2" name="number_of_pax" max="15" required/>
                                <label class="enter-label2">Number of Pax</label>
                            </div><br>
                            <div class="enter2">
                                <select class="enter-field2" name="tenancy_duration" required>
                                    <option value="6 months">6 months</option>
                                    <option value="1 year">1 year</option>
                                    <option value="2 years">2 years</option>
                                    <option value="3 years">3 years</option>
                                </select>
                                <label class="enter-label2">Tenancy Duration</label>
                            </div><br>
                            <div class="enter2">
                                <input type="date" class="enter-field2" name="move_in_date" required/>
                                <label class="enter-label2">Move-In Date</label>
                            </div><br>
                            <div class="enter2">
                                <input type="time" class="enter-field2" name="move_in_time" required/>
                                <label class="enter-label2">Move-In Time</label>
                            </div>
                            <div class="bookingaction2">
                                <div class="action-wrapper">
                                    <i class="fa-solid fa-circle-arrow-left" style="color: #000000; font-size: 30px; margin-left: 20px; cursor: pointer;" onclick="previousStep(1)"></i>
                                    <button type="submit" class="bookingactionbutton">Book Now</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-info">
                <p style="text-align: center;">By filling up the form, you are agreeing to our <a href="TermsofService.html">Terms and Conditions.</a></p>
                <p style="text-align: center;">*Choose date and time according to the availability.</p>
            </div>
        </div>
    </div>
</div>
 <br>
        <br>

        <button class="appointmentbutton" onclick="OpenAppPopup()">
            <i class="fa-solid fa-chevron-right"></i>MAKE APPOINTMENT
        </button>
        <div id="appmodal" class="appmodal">
            <div class="appcontent">
                <span class="close-button" onclick="CloseAppPopup()">&times;</span><br> 
                <img style="width:100%; height: auto;" src="img/app_form.png">
                <div class="appcontainer">
                   
                    <header>APPOINTMENT</header>
                    <form class="card-form" method="POST" action="Tenant_Appointments.php">
                        <div id="order1" class="order">
                           
                            <div class="input">
                                <input type="text" class="input-field" name="propertyId" required readonly value="<?php echo $property[0]['propertyId']; ?>"/>
                                <label class="">Property ID</label>
                            </div>
                            <div class="appaction">
                                <button type="button" class="next-button" onclick="goToNextOrder(1)">Next</button>
                            </div>
                        </div>
                        
                        <div id="order2" class="order" style="display:none;">
                            <div class="input2">
                                <input type="date" class="input-field2" name="appointment_date" required id="dateInput"/>
                                <label class="input-label2">Appointment Date:</label>
                            </div>
                            <div class="input2">
                                <input type="time" class="input-field2" name="appointment_time" required/>
                                <label class="input-label2">Time</label>
                            </div>
                            <div class="appaction">
                                <button type="button" class="previous-button" onclick="goToPreviousOrder(2)" style="background-color:transparent; border: none; font-size: 30px; cursor: pointer;">
                                    <i class="fa-solid fa-circle-arrow-left" style="color: #000000;"></i> 
                               <button type="submit" class="action-button">Make Appointment</button>
                            </div>
                        </div> 
                                
                            </div>
                        </div>
                    </form>
                     <!-- Debugging output -->
    <?php
    if (isset($_GET['success'])) {
        echo '<p style="color:green;">Success: ' . $_GET['success'] . '</p>';
    } elseif (isset($_GET['error'])) {
        echo '<p style="color:red;">Error: ' . $_GET['error'] . '</p>';
    } else {
        echo '<p>No message received.</p>';
    }
    ?>
                    <div class="card-info">
                        <p style="text-align: center;">By filling up the form, you are agreeing to our <a href="TermsofService.html">Terms and Conditions.</a></p>
                        <p style="text-align: center;">*Choose date and time according to the viewing availability.</p>
                    </div>
                </div>
            </div>
        </div>
        
<br><br>
<!-- Display success or error messages if redirected back with parameters -->

</div>








</div>
    </div>





<br>
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
    <script src="homedetails.js"></script>
</body>
</html>

