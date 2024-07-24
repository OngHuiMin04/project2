<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ayrentals";
$propertyTable = "properties"; // Replace 'properties' with your actual table name
$pricedetailsTable = "pricedetails"; // Replace 'pricedetails' with your actual table name
$imageTable = "uploaded_photos"; // Replace 'uploaded_photos' with your actual table name

// Establish database connection using PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Function to generate unique propertyId based on property type
function generatePropertyId($pdo, $propertyType) {
    // Set a default prefix based on property type
    switch ($propertyType) {
        case 'A':
            $prefix = 'A'; // Bungalow or Villa
            break;
        case 'B':
            $prefix = 'B'; // Apartment, Condo, or Service Residence
            break;
        case 'C':
            $prefix = 'C'; // Semi-Detached House
            break;
        case 'D':
            $prefix = 'D'; // Terrace or Link House
            break;
        default:
            $prefix = ''; // Handle unknown types gracefully
            break;
    }

    // Query to get the last propertyId for the given prefix
    $stmt = $pdo->prepare("SELECT MAX(SUBSTRING(propertyId, 2) + 0) AS maxId FROM properties WHERE propertyId LIKE ?");
    $stmt->execute([$prefix . '%']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxId = $row['maxId'];

    // Generate new propertyId
    if ($maxId !== null) {
        $newId = $prefix . str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newId = $prefix . '001'; // If no existing IDs, start with 001
    }

    return $newId;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    if (isset($_POST['propertyType'])) {
        // Retrieve form data
        $propertyType = $_POST['propertyType'];
        $propertyId = generatePropertyId($pdo, $propertyType);
        $propertyName = $_POST['propertyName'] ?? '';
        $residentialname = $_POST['residentialname'] ?? '';
        $rentcategory = $_POST['rentcategory'] ?? '';
        $address = $_POST['address'] ?? '';
        $postcode = $_POST['postcode'] ?? '';
        $bedroom = $_POST['bedroom'] ?? '';
        $bathroom = $_POST['bathroom'] ?? '';
        $parking = $_POST['parking'] ?? '';
        $size = $_POST['size'] ?? '';
        $floorLevel = $_POST['floorLevel'] ?? '';
        $furnishing = $_POST['furnishing'] ?? '';
        $facilities = $_POST['facilities'] ?? '';
        $price = $_POST['price'] ?? '';
        $deposit = $_POST['deposit'] ?? '';
        $v_available = $_POST['vAvailable'] ?? '';
        $p_available = $_POST['pAvailable'] ?? '';
        $email = $_POST['email'] ?? ''; // Assuming you capture the landlord's email from the form or session

        // Convert to float or integer
        $price = floatval($price);
        $deposit = floatval($deposit);

        // Calculate SST (6%) on the sum of first month rental and deposit
        $sst = ($price + $deposit) * 0.06;

        // Calculate the total amount
        $total = $price + $deposit + 200 + $sst; // Assuming ayrentalFees is 200

        // Insert property data into database
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO $propertyTable (propertyId, propertyName, residentialname, address, postcode, propertyType, rentcategory, bedroom, bathroom, parking, size, floorLevel, furnishing, facilities, price, deposit, v_available, p_available, email) 
                                   VALUES (:propertyId, :propertyName, :residentialname, :address, :postcode, :propertyType, :rentcategory, :bedroom, :bathroom, :parking, :size, :floorLevel, :furnishing, :facilities, :price, :deposit, :v_available, :p_available, :email)");
            $stmt->bindParam(':propertyId', $propertyId);
            $stmt->bindParam(':propertyName', $propertyName);
            $stmt->bindParam(':residentialname', $residentialname);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':postcode', $postcode);
            $stmt->bindParam(':propertyType', $propertyType);
            $stmt->bindParam(':rentcategory', $rentcategory);
            $stmt->bindParam(':bedroom', $bedroom);
            $stmt->bindParam(':bathroom', $bathroom);
            $stmt->bindParam(':parking', $parking);
            $stmt->bindParam(':size', $size);
            $stmt->bindParam(':floorLevel', $floorLevel);
            $stmt->bindParam(':furnishing', $furnishing);
            $stmt->bindParam(':facilities', $facilities);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':deposit', $deposit);
            $stmt->bindParam(':v_available', $v_available);
            $stmt->bindParam(':p_available', $p_available);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            echo "New property record created successfully with ID: $propertyId.<br>";

            // Insert price, deposit, ayrentalFees, sst, and total into pricedetails table
            $stmtPricedetails = $pdo->prepare("INSERT INTO $pricedetailsTable (propertyId, price, deposit, ayrentalFees, sst, total) VALUES (:propertyId, :price, :deposit, 200, :sst, :total)");
            $stmtPricedetails->bindParam(':propertyId', $propertyId);
            $stmtPricedetails->bindParam(':price', $price);
            $stmtPricedetails->bindParam(':deposit', $deposit);
            $stmtPricedetails->bindParam(':sst', $sst);
            $stmtPricedetails->bindParam(':total', $total);
            $stmtPricedetails->execute();

            // Process file uploads
            if (isset($_FILES['upload_photo'])) {
                $uploadDirectory = "uploads/";

                // Check if upload directory exists, create if not
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0755, true);
                }

                foreach ($_FILES['upload_photo']['tmp_name'] as $key => $tmpName) {
                    $fileTmpName = $_FILES['upload_photo']['tmp_name'][$key];
                    $fileName = $_FILES['upload_photo']['name'][$key];
                    $fileSize = $_FILES['upload_photo']['size'][$key];
                    $fileError = $_FILES['upload_photo']['error'][$key];
                    $fileType = $_FILES['upload_photo']['type'][$key];
                    
                    // Check if file uploaded successfully and handle errors
                    if ($fileError === UPLOAD_ERR_OK && !empty($fileName)) {
                        $fileDestination = $uploadDirectory . basename($fileName);
                
                        if (move_uploaded_file($fileTmpName, $fileDestination)) {
                            // Insert file information into database
                            $insertSql = "INSERT INTO $imageTable (propertyId, file_name, file_path, file_type, upload_time) 
                                          VALUES (:propertyId, :file_name, :file_path, :file_type, NOW())";
                            $stmt = $pdo->prepare($insertSql);
                            $stmt->bindParam(':propertyId', $propertyId);
                            $stmt->bindParam(':file_name', $fileName);
                            $stmt->bindParam(':file_path', $fileDestination);
                            $stmt->bindParam(':file_type', $fileType);
                            $stmt->execute();
                
                            echo "The file " . htmlspecialchars($fileName) . " has been uploaded and saved to database.<br>";
                        } else {
                            echo "Error uploading " . htmlspecialchars($fileName) . ".<br>";
                        }
                    } elseif ($fileError !== UPLOAD_ERR_OK && !empty($fileName)) {
                        echo "Error with file " . htmlspecialchars($fileName) . ": " . $fileError . "<br>";
                    }
                }
            }

            // Commit the transaction
            $pdo->commit();

        } catch (PDOException $e) {
            // Rollback the transaction in case of error
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}

// Example query to fetch properties added by the logged-in landlord
if (isset($_SESSION['email'])) {
    $loggedInEmail = $_SESSION['email'];
    $stmt = $pdo->prepare("SELECT * FROM $propertyTable WHERE email = :email");
    $stmt->bindParam(':email', $loggedInEmail);
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display properties
    if ($properties) {
        echo "<h2>Properties added by $loggedInEmail:</h2>";
        foreach ($properties as $property) {
            echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
            echo "<p><strong>Property ID:</strong> " . htmlspecialchars($property['propertyId']) . "</p>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($property['propertyName']) . "</p>";
            echo "<p><strong>Residential Name:</strong> " . htmlspecialchars($property['residentialname']) . "</p>";
            echo "<p><strong>Address:</strong> " . htmlspecialchars($property['address']) . "</p>";
            echo "<p><strong>Postcode:</strong> " . htmlspecialchars($property['postcode']) . "</p>";
            echo "<p><strong>Property Type:</strong> " . htmlspecialchars($property['propertyType']) . "</p>";
            echo "<p><strong>Rent Category:</strong> " . htmlspecialchars($property['rentcategory']) . "</p>";
            echo "<p><strong>Bedroom:</strong> " . htmlspecialchars($property['bedroom']) . "</p>";
            echo "<p><strong>Bathroom:</strong> " . htmlspecialchars($property['bathroom']) . "</p>";
            echo "<p><strong>Parking:</strong> " . htmlspecialchars($property['parking']) . "</p>";
            echo "<p><strong>Size:</strong> " . htmlspecialchars($property['size']) . "</p>";
            echo "<p><strong>Floor Level:</strong> " . htmlspecialchars($property['floorLevel']) . "</p>";
            echo "<p><strong>Furnishing:</strong> " . htmlspecialchars($property['furnishing']) . "</p>";
            echo "<p><strong>Facilities:</strong> " . htmlspecialchars($property['facilities']) . "</p>";
            echo "<p><strong>Price:</strong> RM" . number_format($property['price'], 2) . "</p>";
            echo "<p><strong>Deposit:</strong> RM" . number_format($property['deposit'], 2) . "</p>";
            echo "<p><strong>Viewing Available:</strong> " . ($property['v_available'] ? 'Yes' : 'No') . "</p>";
            echo "<p><strong>Post Available:</strong> " . ($property['p_available'] ? 'Yes' : 'No') . "</p>";
            // You can add more details here based on your database schema

            // Display uploaded photos if any
            $stmtPhotos = $pdo->prepare("SELECT * FROM uploaded_photos WHERE propertyId = :propertyId");
            $stmtPhotos->bindParam(':propertyId', $property['propertyId']);
            $stmtPhotos->execute();
            $photos = $stmtPhotos->fetchAll(PDO::FETCH_ASSOC);
            if ($photos) {
                echo "<p><strong>Uploaded Photos:</strong></p>";
                echo "<div style='display: flex; flex-wrap: wrap;'>";
                foreach ($photos as $photo) {
                    echo "<img src='" . htmlspecialchars($photo['file_path']) . "' alt='" . htmlspecialchars($photo['file_name']) . "' style='max-width: 200px; margin-right: 10px; margin-bottom: 10px;'>";
                }
                echo "</div>";
            }

            echo "</div>";
        }
    } else {
        echo "No properties found.";
    }
}
