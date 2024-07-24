<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>About Us</title>
    <link rel="icon" href="img/logo.png">
    <link href="Guest_Homepage.css" rel="stylesheet" type="text/css"/>
    <link href="Guest_AboutUs.css" rel="stylesheet" type="text/css"/>
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

    <section class="nav1"></section>
    <nav>

        <a href="Guest_Homepage.php"><i class="fas fa-home"></i></a> &gt; <span><a href="Guest_AboutUs.php">About Us</a></span>
    </nav>
<div class="bannerup">
    <img src="img/aboutus.png">
</div>
<div="whole">
    <section class="story-section">
        <div class="story-container">
            <div class="story-image">
                <img src="img/Our_Story.jpg" alt="Story Image">
            </div>
            <div class="story-text">
                <h2>Our Story</h2>
                <p>Welcome to AYRENTALS, your trusted solution for house rentals in Johor Bahru. Our journey began with the real-life experiences of our friends and 
                   family members who work in this bustling capital city of Johor. They shared countless stories of the struggles they faced in renting houses – the 
                   cumbersome process, the difficulty in finding a home that suits their needs, and the challenges in signing contracts and resolving issues. These 
                   shared experiences highlighted the need for a more streamlined and user-friendly rental process.
                   Motivated by these challenges, we set out to create a solution that would transform the house rental experience. Our goal was to alleviate the 
                   anxiety and helplessness often felt during the rental process. With AYRENTALS, we aim to simplify renting for both tenants and landlords, offering 
                   a smoother and more enjoyable experience. Therefore, AYRENTALS is being developed that will bring more efficiency to our users.</p>
            </div>
        </div>
    </section>
    

    <section class="vision-section">
        <div class="vision-image">
            <img src="img/vision.jpg" alt="Vision Image">
        </div>
        <div class="vision-container">
            <div class="vision-text">
                <h2>Our Vision</h2>
                <p>To revolutionize the rental experience by providing a seamless platform where tenants effortlessly discover available and suitable homes, while empowering owners to manage bookings efficiently.</p>
            </div>
        </div>
    </section>    

    <section class="mission-section">
        <div class="outer-container">
            <div class="mission-container">
                <div class="mission-text">
                    <h2>Our Mission</h2>
                    <p>To develop an intuitive home rental system that swiftly connects tenants with ideal properties, streamlines the property search process to save valuable time, and enhances communication between tenants and landlords for seamless booking management.</p>
                </div>
            </div>
                <div class="mission-image">
                    <img src="img/mission.jpg" alt="Mission Image">
                </div>
        </div>
    </section>
    
    <h1 class="heading">Contact Us</h1>
    <section class="contact">
        <div class="contact-container">
            <div class="container-wrapper">
                <div class="contact-form">
                    <h3>Send me a message</h3>
                    <form id="contact-form" action="contact.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="contact-input" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="contact-input" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <select name="user_type" id="user_type" class="contact-select" required>
                                <option value="" disabled selected>Tell us a bit about yourself</option>
                                <option value="guest">I'm a Guest</option>
                                <option value="tenant">I'm a Tenant</option>
                                <option value="owner">I'm a Landlord</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="message" class="contact-textarea" cols="30" rows="10" placeholder="Any Feedback" required></textarea>
                        </div>
                        <button type="submit" class="contact-button">Submit</button>
                    </form>
                </div>
    
                <div class="alert-success" id="success-message" style="display:none;">
                    <span>Message Sent! Thank you for contacting us.</span>
                </div>
    
                <div class="alert-error" id="error-message" style="display:none;">
                    <span>Something went wrong! Please try again.</span>
                </div>
    
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <p><i class="fas fa-envelope"></i> ayrentals@gmail.com</p>
                    <p><i class="fas fa-phone"></i> (+607) 278 3456</p>
                    <p><i class="fas fa-phone"></i> (+60) 123 456 789</p>
                    <img src="img\contactform_pic.jpeg" alt="Contact Image" class="contact-image">
                </div>
            </div>
        </div>
    </section>
</div>   


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
const form = document.getElementById('contact-form');
form.addEventListener('submit', function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Get the form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const userType = document.getElementById('user_type').value;
    const message = document.getElementById('message').value;

    // Check if required fields are filled
    if (name.trim() === '' || email.trim() === '' || userType.trim() === '' || message.trim() === '') {
        alert('Please fill in all required fields.');
        return;
    }

    // Submit the form data using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                showMessage('success-message');
            } else {
                showMessage('error-message');
            }
        }
    };

    // Encode form data for sending
    const formData = `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&user_type=${encodeURIComponent(userType)}&message=${encodeURIComponent(message)}`;
    xhr.send(formData);
});

// Function to show message and hide after 1 second
function showMessage(messageId) {
    // Get the message element by its ID
    var messageElement = document.getElementById(messageId);

    // Display the message
    messageElement.style.display = 'block';

    // Set a timeout to hide the message after 1 second
    setTimeout(function() {
        messageElement.style.display = 'none';
        clearForm();
    }, 1000);
}

// Function to clear the form
function clearForm() {
    form.reset();
}
</script>
    

<script src="script.js"></script>
</body>
</html>


