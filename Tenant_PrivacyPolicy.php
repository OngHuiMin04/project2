<title>L's HOTEL - ABOUT</title>
    <link rel="icon" href="img/icon.jpg">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>Privacy Policy</title>
    <link href="Tenant_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Tenant_PrivacyPolicy.css" rel="stylesheet" type="text/css"/>
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
    <br>

    <section class="nav1"></section>
    <nav>
        <a href="Tenant_Homepage.php"><i class="fas fa-home"></i></a> <span class="separator">&gt;</span> <span> <a href="Tenant_PrivacyPolicy.php" class="terms-of-service">Privacy Policy</a>
    </nav>
    </section>
    
    <section class="Policy">
        <div class="sidebar-wrapper">
            <table class="sidebar-table">
                <thead>
                    <tr>
                        <th colspan="2">Policy of AYRENTALS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="Tenant_AcceptableUsePolicy.php">Acceptable Use Policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="Tenant_TermsofService.php">Terms of Service</a></td>
                    </tr>
                    <tr>
                        <td><a href="Tenant_PrivacyPolicy.php">Privacy Policy</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="PrivacyPolicy">
            <h1>Privacy Policy</h1>
            <p class="left-align"><strong>Last modified: 2 June 2024</strong></p>
            <p class="left-align">
             This Privacy Policy describes how we collect, use, and disclose information when you use our home rental platform.
            </p>
           <br>
           <ol>
            <li>
              <p><strong>1. Information We Collect</strong></p>
              <ul>
                <li>Personal Information: When you create an account, we may collect your name, email address, phone number, and payment information.</li>
                <li>Property Information: If you list a property on our platform, we may collect information about the property, including its location, features, and photos.</li>
                <li>Usage Information: We collect information about how you use our platform, including your interactions with listings, bookings, and other users.</li>
                <li>Communication: We may collect information from your communications with us, including emails and messages through our platform.</li>
              </ul>
            </li>
            
            <li>
              <p><strong>2. How We Use Information</strong></p>
              <ul>
                <li>Providing Services: To provide and maintain our home rental platform, including facilitating bookings and payments.</li>
                <li>Improving Services: To analyze usage trends and improve the functionality and user experience of our platform.</li>
                <li>Communications: To communicate with you about your account, bookings, and updates to our platform.</li>
                <li>Marketing: With your consent, to send you promotional materials and offers about our services and partners.</li>
              </ul>
            </li>
            
            <li>
              <p><strong>3. Information Sharing</strong></p>
              <ul>
                <li>Service Providers: We may share information with third-party service providers who assist us in operating our platform.</li>
                <li>Legal Compliance: We may disclose information if required by law or in response to legal requests.</li>
                <li>Business Transfers: In connection with a merger, acquisition, or sale of assets, we may transfer information to the acquiring entity.</li>
              </ul>
            </li>
            
            <li>
              <p><strong>4. Your Choices</strong></p>
              <ul>
                <li>Account Information: You can update or delete your account information at any time by logging into your account settings.</li>
                <li>Communication Preferences: You can opt out of receiving promotional emails by following the instructions in the email.</li>
              </ul>
            </li>
            
            <li>
              <p><strong>5. Data Security</strong></p>
              <p>We take reasonable measures to protect the security of your information, but no method of transmission over the internet or electronic storage is 100% secure.</p>
            </li>
            
            <li>
              <p><strong>6. User's Privacy</strong></p>
              <p>Our platform is not intended for individuals under the age of 21, and we do not knowingly collect personal information from individuals under 21.</p>
            </li>
            
            <li>
              <p><strong>7. Changes to this Privacy Policy</strong></p>
              <p>We may update this Privacy Policy from time to time. If we make material changes, we will notify you by email or through our platform.</p>
            </li>
            
            <li>
              <p><strong>8. Contact Us</strong></p>
              <p>If you have any questions or concerns about this Privacy Policy, please contact us at ayrentals@gmail.com.</p>
            </li>
          </ol>
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
</body>
</html>
