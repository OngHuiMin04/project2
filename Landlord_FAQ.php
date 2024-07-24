<?php
session_start();
$email = $_SESSION['email']; // 假设用户的电子邮件存储在会话中

$host = "localhost";
$username = "root"; // 修改为你的数据库用户名
$password = ""; // 修改为你的数据库密码
$dbname = "ayrentals"; // 修改为你的数据库名称

// 创建数据库连接
$conn = new mysqli($host, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 准备查询语句，获取用户头像路径
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

// 如果头像路径为空，设置默认头像路径
if (empty($avatarPath)) {
    $avatarPath = 'img\login.jpg'; // 设置默认头像路径
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>Frequently Asked Questions</title>
    <link href="Landlord_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Landlord_FAQ.css" rel="stylesheet" type="text/css"/>
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
                            <a href="#change-password">Change Password</a>
                            <a href="Guest_Homepage.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    

    <section class="nav1"></section>
    <nav>
    <a href="Landlord_Homepage.php"><i class="fas fa-home"></i></a> &gt; <span><a href="Landlord_FAQ.php">Frequently Asked Questions</a></span>
    </nav>
    <div class="bannerup">
    <img src="img/faq.png">
</div>
<div class="whole"><br>
    <section class="center">
        <div class="faq-section">
            <h2>General</h2>
            <div class="faq-question">
                <button class="faq-question-btn">
                    <h3>How do I create an account?</h3>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq answer">
                    <p>To create an account, click on the "Login" button on the homepage, fill in the required information, and follow the on-screen instructions to complete the registration process.</p>
                </div>
            </div>
            <div class="faq-question">
                <button class="faq-question-btn">
                    <h3>Is there a fee to use?</h3>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq answer">
                    <p>Creating an account and browsing listings on AYRENTALS is free. However, service fees may apply when booking a rental or listing a property. Detailed fee information can be found on our pricing page.</p>
                </div>
            </div>
        </div>
        
        <div class="faq-section">
            <h2>For Renters</h2> 
            <div class="faq-question">
                <button class="faq-question-btn">
                    <h3>How do I search for a rental property?</h3>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq answer">
                    <p>You can search for rental properties by entering your desired location, and other preferences in the search bar and filter on the homepage.</p>
                </div>
            </div>
            <div class="faq-question">
                <button class="faq-question-btn">
                    <h3>How do I book a property?</h3>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq answer">
                    <p>Once you find a property you like, click on the listing to view more details. If you wish to proceed, click the "Book Now" button, and follow the instructions to complete your booking.</p>
                </div>
            </div>
        </div>
    
        <div class="faq-section">
            <h2>For Property Owners</h2> 
            <div class="faq-question">
                <button class="faq-question-btn">
                    <h3>How do I list my property?</h3>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq answer">
                    <p>To list your property, log in to your account, go to the "My Properties" section, and click on "Add New Property." Fill in the required details about your property, upload photos, and publish your listing.</p>
                </div>
            </div>
            <div class="faq-question">
                <button class="faq-question-btn">
                    <h3>How much does it cost to list a property?</h3>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq answer">
                    <p>Listing a property on AYRENTALS is free. However, a service fee is charged for each booking made through the platform. Detailed fee information is available on our pricing page.</p>
                </div>
            </div>
            <div class="faq-question">
                <button class="faq-question-btn">
                    <h3>Can I set my own rental rates and rules?</h3>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq answer">
                    <p>Yes, as a property owner, you can set your own rental rates, availability, and house rules. You can update these settings at any time through your account dashboard.</p>
                </div>
            </div>
            <div class="faq-question">
                <button class="faq-question-btn">
                    <h3>How do I get paid for bookings?</h3>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq answer">
                    <p>Payments are processed through our secure payment system. Funds will be transferred to your designated bank account within a specified period after the guest's check-in date.</p>
                </div>
            </div>
        </div>
    </section><br><br>
</div>
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
        const faqButtons = document.querySelectorAll('.faq-question-btn');
    
        faqButtons.forEach(button => {
            button.addEventListener('click', () => {
                button.nextElementSibling.classList.toggle('active');
            });
        });
    </script>
    
</body>
</html>
