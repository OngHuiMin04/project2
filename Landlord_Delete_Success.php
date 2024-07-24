<?php
session_start();


if (isset($_SESSION['delete_success']) && $_SESSION['delete_success'] === true) {
    $message = "Property deleted successfully for ";
} else {
    $message = "Failed to delete property for ";
}


if (isset($_GET['propertyType'])) {
    $propertyType = $_GET['propertyType'];
} else {
    $propertyType = ""; 
}


switch ($propertyType) {
    case 'A':
        $message .= "Bungalow or Villa.";
        $redirect_url = 'Landlord_BungalowVilla_Catalogue.php';
        break;
    case 'B':
        $message .= "Apartment or Condo.";
        $redirect_url = 'Landlord_ApartmentCondo_Catalogue.php';
        break;
    case 'C':
        $message .= "Semi-Detached House.";
        $redirect_url = 'Landlord_SemiDetachedCatalogue.php';
        break;
    case 'D':
        $message .= "Terrace or Link House.";
        $redirect_url = 'Landlord_TerraceLinkHouse_Catalogue.php';
        break;
    default:
        $message .= "Unknown type.";
        $redirect_url = 'Landlord_Catalogue.php'; 
        break;
}


$redirect_time = 3;


unset($_SESSION['delete_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding-top: 50px;
        }
        .message {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin: auto;
            width: 50%;
        }
    </style>
</head>
<body>
    <div class="message">
        <h2><?php echo $message; ?></h2>
        <p>Redirecting back to catalogue in <?php echo $redirect_time; ?> seconds...</p>
    </div>

    <script>
        setTimeout(function() {
            var redirect_url = '<?php echo $redirect_url; ?>';
            if (redirect_url) {
                window.location.href = redirect_url;
            } else {
                window.location.href = 'Landlord_Catalogue.php'; 
            }
        }, <?php echo $redirect_time * 1000; ?>); 
    </script>
</body>
</html>
