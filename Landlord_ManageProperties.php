<?php
session_start();

// Redirect to login page if email is not set in session
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$host = "localhost";
$username = "root";
$password = ""; // Assuming empty password for local development
$dbname = "ayrentals";

// Get user email from session
$email = $_SESSION['email'];

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user avatar
    $avatarQuery = "SELECT avatar_path FROM users WHERE email = :email";
    $avatarStmt = $pdo->prepare($avatarQuery);
    $avatarStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $avatarStmt->execute();
    $avatarPath = $avatarStmt->fetchColumn();

    // If avatar path is empty, set default avatar path
    if (empty($avatarPath)) {
        $avatarPath = 'default-avatar.png'; // Set default avatar path
    }

    // Fetch user type from users table
    $usertypeQuery = "SELECT usertype FROM users WHERE email = :email";
    $usertypeStmt = $pdo->prepare($usertypeQuery);
    $usertypeStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $usertypeStmt->execute();
    $usertype = $usertypeStmt->fetchColumn();

    // Initialize property variables
    $properties = [];

    // Construct SQL query based on user type
    if ($usertype == 'landlord') {
        $propertyQuery = "SELECT * FROM properties WHERE email = :email";
        $propertyStmt = $pdo->prepare($propertyQuery);
        $propertyStmt->bindParam(':email', $email, PDO::PARAM_STR);
    } else {
        // Handle unexpected user type (optional)
        echo "Unexpected user type.";
        die();
    }

    // Execute property query
    $propertyStmt->execute();
    $properties = $propertyStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
    die();
}

// Close PDO connection at the end of the script (optional)
$pdo = null;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <style>
        h1 {
            text-align: center;
            color: #343a40;
        }
        .add-property-button-container {
            text-align: right;
            margin-bottom: 20px;
        }
        .add-property-button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .add-property-button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions a {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
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

    <h1>Manage Properties</h1>

    <!-- Link to add new property -->
    <div class="add-property-button-container">
        <a href="Landlord_AddPropertyForm.php" class="button add-property-button">
            <i class="fas fa-plus-circle"></i> Add Property
        </a>
    </div>

    <!-- Display properties in a table -->
    <table>
        <thead>
            <tr>
                <th>Property ID</th>
                <th>Property Name</th>
                <th>Address</th>
                <th>Monthly Rental</th>
                <th>Bedrooms</th>
                <th>Bathrooms</th>
                <th>Sqft</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($properties as $property): ?>
                <tr>
                    <td><?php echo htmlspecialchars($property['propertyId']); ?></td>
                    <td><?php echo htmlspecialchars($property['propertyName']); ?></td>
                    <td><?php echo htmlspecialchars($property['address']); ?></td>
                    <td><?php echo htmlspecialchars($property['price']); ?></td>
                    <td><?php echo htmlspecialchars($property['bedroom']); ?></td>
                    <td><?php echo htmlspecialchars($property['bathroom']); ?></td>
                    <td><?php echo htmlspecialchars($property['size']); ?></td>
                    <td class="actions">
                        <a href="Landlord_Edit_PropertyCat.php?propertyId=<?php echo htmlspecialchars($property['propertyId']); ?>">Edit</a>
                        <a href="Landlord_Delete_Property.php?propertyId=<?php echo htmlspecialchars($property['propertyId']); ?>" onclick="return confirm('Are you sure you want to delete this property?')">Delete</a>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("notification-modal");
            const modalBtn = document.getElementById("notification-btn");
            const closeBtn = document.getElementsByClassName("closebutton")[0];

            // Open modal
            modalBtn.addEventListener("click", function() {
                modal.style.display = "block";
            });

            // Close modal
            closeBtn.addEventListener("click", function() {
                modal.style.display = "none";
            });

            // Close modal when clicking outside
            window.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });

            // Handle approve button click
            document.getElementById("approve-btn").addEventListener("click", function() {
                console.log("Approve button clicked");
                alert("Approved");
                modal.style.display = "none"; // Close modal after action
            });

            // Handle decline button click
            document.getElementById("decline-btn").addEventListener("click", function() {
                console.log("Decline button clicked");
                alert("Declined");
                modal.style.display = "none"; // Close modal after action
            });

            // Handle reschedule button click
            document.getElementById("reschedule-btn").addEventListener("click", function() {
                console.log("Reschedule button clicked");
                window.location.href = "schedule.html"; // Redirect to reschedule page
            });
        });
    </script>
</body>
</html>
