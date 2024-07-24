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

// Initialize variables
$propertyId = $propertyName = $address = $price = $bedroom = $bathroom = $size = $propertyType = $deposit = $residentialname = $rentcategory = $parking = $floorLevel = $furnishing = $facilities = "";

// Handle form submission to update property
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs if needed
    $propertyId = $_POST['propertyId'];
    $propertyName = $_POST['propertyName'];
    $address = $_POST['address'];
    $price = $_POST['price'];
    $bedroom = $_POST['bedroom'];
    $bathroom = $_POST['bathroom'];
    $size = $_POST['size'];
    $deposit = $_POST['deposit'];
    $residentialname = $_POST['residentialname'];
    $rentcategory = $_POST['rentcategory'];
    $parking = $_POST['parking'];
    $floorLevel = $_POST['floorLevel'];
    $furnishing = $_POST['furnishing'];
    $facilities = $_POST['facilities'];

    // Update property in the database
    $sql = "UPDATE properties SET propertyName = '$propertyName', address = '$address', price = '$price', bedroom = '$bedroom', bathroom = '$bathroom', size = '$size', deposit = '$deposit', residentialname = '$residentialname', rentcategory = '$rentcategory', parking = '$parking', floorLevel = '$floorLevel', furnishing = '$furnishing', facilities = '$facilities' WHERE propertyId = '$propertyId'";

    if ($conn->query($sql) === TRUE) {
        echo "Property updated successfully.";
        // Redirect to the appropriate catalogue page
        redirectToCatalogue($propertyType);
        exit();
    } else {
        echo "Error updating property: " . $conn->error;
    }
} else {
    // Fetch property details based on propertyId from GET parameter
    if (isset($_GET['propertyId'])) {
        $propertyId = $_GET['propertyId'];

        $sql = "SELECT * FROM properties WHERE propertyId = '$propertyId'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $property = $result->fetch_assoc();
            // Assign fetched values to variables for pre-filling form
            $propertyName = $property['propertyName'];
            $address = $property['address'];
            $price = $property['price'];
            $bedroom = $property['bedroom'];
            $bathroom = $property['bathroom'];
            $size = $property['size'];
            $deposit = $property['deposit'];
            $residentialname = $property['residentialname'];
            $rentcategory = $property['rentcategory'];
            $parking = $property['parking'];
            $floorLevel = $property['floorLevel'];
            $furnishing = $property['furnishing'];
            $facilities = $property['facilities'];
        } else {
            echo "Property not found.";
            // Redirect to the appropriate catalogue page
            redirectToCatalogue($propertyType);
            exit();
        }
    } else {
        echo "Property ID not provided.";
        // Redirect to the appropriate catalogue page
        if (isset($_GET['propertyType'])) {
            $propertyType = $_GET['propertyType'];
        }
        redirectToCatalogue($propertyType);
        exit();
    }
}

$conn->close();

function redirectToCatalogue($propertyType) {
    switch ($propertyType) {
        case 'A':
            header("Location: Landlord_BungalowVilla_Catalogue.php");
            exit();
        case 'B':
            header("Location: Landlord_ApartmentCondo_Catalogue.php");
            exit();
        case 'C':
            header("Location: Landlord_SemiDetachedCatalogue.php");
            exit();
        case 'D':
            header("Location: Landlord_TerraceLinkHouse_Catalogue.php");
            exit();
        default:
            header("Location: Landlord_Catalogue.php");
            exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f5f5f5; 
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top:10px;
            color: #333;
        }

        .profile-section {
            background: #fff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #6f4e37;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #6f4e37;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #6f4e37;
            color: black;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: calc(50% - 10px); /* Adjusted width for buttons */
            margin-top: 10px;
        }

        button:hover {
            background-color: #8b6e4b;
            color:#fff;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .cancel-button {
            background-color: #ccc;
        }

        .cancel-button:hover {
            background-color: #999;
        }
    </style>
</head>
<body>
    <div class="profile-section">
        <h2>Edit Property</h2>
        <form class="edit-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="propertyId" value="<?php echo $propertyId; ?>">
            <input type="hidden" name="propertyType" value="<?php echo $propertyType; ?>">
            
            <label for="propertyName">Property Name:</label>
            <input type="text" id="propertyName" name="propertyName" value="<?php echo $propertyName; ?>"><br>

             <label for="residentialname">Residential Name:</label>
            <input type="text" id="residentialname" name="residentialname" value="<?php echo $residentialname; ?>"><br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>"><br>

            <label for="rentcategory">Rent Category:</label>
            <input type="text" id="rentcategory" name="rentcategory" value="<?php echo $rentcategory; ?>"><br>
            
            <label for="bedroom">Bedrooms:</label>
            <input type="number" id="bedroom" name="bedroom" value="<?php echo $bedroom; ?>"><br>
            
            <label for="bathroom">Bathrooms:</label>
            <input type="number" id="bathroom" name="bathroom" value="<?php echo $bathroom; ?>"><br>

            <label for="parking">Parking:</label>
            <input type="text" id="parking" name="parking" value="<?php echo $parking; ?>"><br>
            
            <label for="size">Size (sqft):</label>
            <input type="number" id="size" name="size" value="<?php echo $size; ?>"><br>

            <label for="floorLevel">Floor Level:</label>
            <input type="text" id="floorLevel" name="floorLevel" value="<?php echo $floorLevel; ?>"><br>

            <label for="furnishing">Furnishing:</label>
            <input type="text" id="furnishing" name="furnishing" value="<?php echo $furnishing; ?>"><br>

            <label for="facilities">Facilities:</label>
            <input type="text" id="facilities" name="facilities" value="<?php echo $facilities; ?>"><br>

           <label for="price">Monthly Rental:</label>
            <input type="text" id="price" name="price" value="<?php echo $price; ?>"><br>

            <label for="deposit">Deposit:</label>
            <input type="number" id="deposit" name="deposit" value="<?php echo $deposit; ?>"><br>
    
            
            <div class="button-container">
                <button type="submit">Update</button>
                <button type="button" class="cancel-button" onclick="redirectToCatalogue('<?php echo $propertyType; ?>')">Cancel</button>
            </div>
        </form>
    </div>
    <script>
        function redirectToCatalogue(propertyType) {
            switch (propertyType) {
                case 'A':
                    window.location.href = 'Landlord_BungalowVilla_Catalogue.php';
                    break;
                case 'B':
                    window.location.href = 'Landlord_ApartmentCondo_Catalogue.php';
                    break;
                case 'C':
                    window.location.href = 'Landlord_SemiDetachedCatalogue.php';
                    break;
                case 'D':
                    window.location.href = 'Landlord_TerraceLinkHouse_Catalogue.php';
                    break;
                default:
                    window.location.href = 'Landlord_Catalogue.php';
                    break;
            }
        }
    </script>
</body>
</html>
