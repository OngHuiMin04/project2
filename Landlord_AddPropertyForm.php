<?php
session_start();
$userId = $_SESSION['email']; 


$host = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ayrentals"; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find the best rental properties and landlords in Johor Bahru.">
    <meta name="keywords" content="rental properties, landlords, Johor Bahru, house vacancies">
    <title>Add Property</title>
    <link href="homepage.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap-grid.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<style>
body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: #efe1d1; 
}

.property-form {
    width: 60%;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
}

.property-form h2 {
    text-align: left;
    font-size: 24px;
}

.checkbox-container {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin-bottom: 20px;
}

.checkbox-container input[type="checkbox"] {
    margin-right: 10px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.form-group label {
    font-size: 16px;
    margin-bottom: 5px;
}

.form-group input[type="text"],
.form-group select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.email-group {
    display: flex;
    align-items: center; /* Align items vertically centered */
    margin-bottom: 20px;
}

.email-group label {
    font-size: 16px;
    margin-right: 10px; /* Add some space between the label and input */
    width: 150px; /* Adjust width as needed */
}

.email-group input, .email-group select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    flex: 1; /* Allow the input to take up the remaining space */
}


.checkbox-group {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.checkbox-group input[type="checkbox"] {
    margin-right: 10px;
}

.upload-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    margin: 20px 0;
    width: 100%;
}

.upload-box {
    width: 30%; 
    border: 2px dashed #ccc;
    border-radius: 10px;
    text-align: center;
    padding: 10px;
    margin: 10px;
    transition: border-color 0.3s;
    border-color: #6f4e37;
}

.upload-box:hover {
    border-color: rgb(255, 211, 164); 
}

.upload-icon {
    width: 20px; 
    height: 20px; 
}

.upload-link {
    display: none;
}

.image-preview {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.image-preview img {
    width: auto; 
    height: auto; 
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.button-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.button-container button {
    padding: 10px 20px;
    background-color: #6f4e37;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    color: white;
}

.button-container button:hover {
    background-color: wheat;
}

.back-button {
    display: flex;
    align-items: center;
    color: white;
}

.arrow-left {
    margin-right: 5px;
}


@media (min-width: 768px) {
    .form-group {
        flex-direction: row;
        align-items: center;
    }

    .form-group label {
        width: 150px;
        margin-bottom: 0;
    }

    .form-group input[type="text"],
    .form-group select {
        flex: 1;
    }

    .form-group input[type="text"]:nth-child(2),
    .form-group select:nth-child(2) {
        margin-left: 10px;
    }
}

</style>
</head>

<body>
<form class="property-form" action="upload.php" method="POST" enctype="multipart/form-data">
        <h2>Where is your property located?</h2>
        
        <div class="form-group">
            <label for="propertyName">Property Name</label>
            <input type="text" id="propertyName" name="propertyName" placeholder="Eg: Manhattan@Austin Heights">
        </div>
        <div class="form-group">
            <label for="residentialname">Residential Name</label>
            <select id="residentialname" name="residentialname">
                <option value="Taman Austin Height">Taman Austin Height</option>
                <option value="Taman Bukit Indah">Taman Bukit Indah</option>
                <option value="Horizon Hills">Horizon Hills</option>
                <option value="Taman Kempas Indah">Taman Kempas Indah</option>
                <option value="Taman Molek">Taman Molek</option>
                <option value="Taman Mount Austin">Taman Mount Austin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Eg: 54, Jln Indah 11/3, Taman Bukit Indah 2, Johor">
        </div>

        <h2>Share some details about your property</h2>
        <div class="form-group">
            <label for="propertyType">Property Type</label>
            <select id="propertyType" name="propertyType">
                <option value="A">Bungalow/Villa</option>
                <option value="B">Apartment/Condo/Service Residence</option>
                <option value="C">Semi-Detached House</option>
                <option value="D">Terrace/Link House</option>
            </select>
        </div>
        <div class="form-group">
            <label for="rentcategory">Rent Category</label>
            <select id="rentcategory" name="rentcategory">
                <option value="whole unit">Whole unit</option>
                <option value="one room">One room</option>
            </select>
        </div>
        <div class="form-group">
            <label for="bedroom">Bedroom</label>
            <select id="bedroom" name="bedroom">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6+</option>
            </select>
        </div>
        <div class="form-group">
            <label for="bathroom">Bathroom</label>
            <select id="bathroom" name="bathroom">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6+</option>
            </select>
        </div>
        <div class="form-group">
            <label for="parking">Parking</label>
            <select id="parking" name="parking">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3+</option>
            </select>
        </div>
        <div class="form-group">
            <label for="size">Build-up size</label>
            <input type="text" id="size" name="size" placeholder="sqft">
        </div>
        <div class="form-group">
            <label for="floorLevel">Floor Level</label>
            <select id="floorLevel" name="floorLevel">
                <option>Single</option>
                <option>Double</option>
                <option>Triple</option>
            </select>
        </div>
        <div class="form-group">
            <label for="furnishing">Furnishing</label>
            <select id="furnishing" name="furnishing">
                <option>Unfurnished</option>
                <option>Semi-furnished</option>
                <option>Fully furnished</option>
            </select>
        </div>
        <div class="form-group">
            <label for="facilities">Facilities</label>
            <input type="text" id="facilities" name="facilities" placeholder="Eg: Playground, 24/7 security">
            </select>
        </div>

        <h2>How much is your rental price?</h2>
        <div class="form-group">
            <label for="price">Monthly Rental (RM)</label>
            <input type="text" id="price" name="price" placeholder="Eg: 1500">
        </div>
        <div class="form-group">
            <label for="deposit">Security Deposit (RM)</label>
            <input type="text" id="deposit" name="deposit" placeholder="Eg: 3000">
        </div>

        <h2>Availability</h2>
        <div class="form-group">
            <label for="vAvailable">Viewing Availability</label>
            <select id="vAvailable" name="vAvailable">
                <option>Weekends</option>
                <option>Weekdays</option>
                <option>All days</option>
            </select>
        </div>
        <div class="form-group">
            <label for="pAvailable">Property Availability</label>
            <select id="pAvailable" name="pAvailable">
                <option>Immediately</option>
                <option>In a day</option>
                <option>In a week</option>
                <option>In 2 weeks</option>
            </select>
        </div>

        <h2>Your Email</h2>
        <div class="email-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Your email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" readonly>
    </div>

        <h2>Upload Photos of your property</h2>
<div class="upload-container">
    <div class="upload-box">
        <label for="upload_photo_0">
            <div id="preview_0" class="image-preview">
                <img src="img/uploadicon.png" alt="Upload Icon" class="upload-icon">
            </div>
            <input type="file" id="upload_photo_0" name="upload_photo[]" class="upload-link" onchange="previewImage(event, 0)">
        </label>
    </div>
    <div class="upload-box">
        <label for="upload_photo_1">
            <div id="preview_1" class="image-preview">
                <img src="img/uploadicon.png" alt="Upload Icon" class="upload-icon">
            </div>
            <input type="file" id="upload_photo_1" name="upload_photo[]" class="upload-link" onchange="previewImage(event, 1)">
        </label>
    </div>
    <div class="upload-box">
        <label for="upload_photo_2">
            <div id="preview_2" class="image-preview">
                <img src="img/uploadicon.png" alt="Upload Icon" class="upload-icon">
            </div>
            <input type="file" id="upload_photo_2" name="upload_photo[]" class="upload-link" onchange="previewImage(event, 2)">
        </label>
    </div>
    <div class="upload-box">
        <label for="upload_photo_3">
            <div id="preview_3" class="image-preview">
                <img src="img/uploadicon.png" alt="Upload Icon" class="upload-icon">
            </div>
            <input type="file" id="upload_photo_3" name="upload_photo[]" class="upload-link" onchange="previewImage(event, 3)">
        </label>
    </div>
    <div class="upload-box">
        <label for="upload_photo_4">
            <div id="preview_4" class="image-preview">
                <img src="img/uploadicon.png" alt="Upload Icon" class="upload-icon">
            </div>
            <input type="file" id="upload_photo_4" name="upload_photo[]" class="upload-link" onchange="previewImage(event, 4)">
        </label>
    </div>
</div>

        <div class="button-container">
        <button type="button" class="back-button" onclick="goBack()">
                <ion-icon name="arrow-back-outline" class="arrow-left"></ion-icon>
                Back
            </button>
            <button type="submit">Submit</button>
        </div>
    </form>



    <script>
 function goBack() {
    window.location.href = "Landlord_ManageProperties.php";
}

function previewImage(event, index) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('preview_' + index);
        output.innerHTML = '<img src="' + reader.result + '" alt="Image Preview">';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>