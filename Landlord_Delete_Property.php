<?php
session_start();


if (isset($_GET['propertyId'])) {
    $propertyId = $_GET['propertyId'];

  
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "ayrentals";

    
    $conn = new mysqli($host, $user, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    $sql_get_property_type = "SELECT propertyType FROM properties WHERE propertyId = ?";
    $stmt_type = $conn->prepare($sql_get_property_type);

    if ($stmt_type) {
        $stmt_type->bind_param("s", $propertyId);
        $stmt_type->execute();
        $result = $stmt_type->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $propertyType = $row['propertyType'];

         
            $sql_delete_property = "DELETE FROM properties WHERE propertyId = ?";
            $sql_delete_photos = "DELETE FROM uploaded_photos WHERE propertyId = ?";

         
            $stmt_property = $conn->prepare($sql_delete_property);
            $stmt_photos = $conn->prepare($sql_delete_photos);

            if ($stmt_property && $stmt_photos) {
            
                $stmt_property->bind_param("s", $propertyId);
                $stmt_photos->bind_param("s", $propertyId);

           
                $stmt_property->execute();
                $stmt_photos->execute();

             
                if ($stmt_property->affected_rows > 0) {
                  
                    switch ($propertyType) {
                        case 'A':
                            $redirect_url = 'Landlord_BungalowVilla_Catalogue.php';
                            break;
                        case 'B':
                            $redirect_url = 'Landlord_ApartmentCondo_Catalogue.php';
                            break;
                        case 'C':
                            $redirect_url = 'Landlord_SemiDetachedCatalogue.php';
                            break;
                        case 'D':
                            $redirect_url = 'Landlord_TerraceLinkHouse_Catalogue.php';
                            break;
                        default:
                            $redirect_url = 'Landlord_Catalogue.php'; 
                            break;
                    }

                  
                    $_SESSION['delete_success'] = true;

                 
                    $stmt_property->close();
                    $stmt_photos->close();
                    $stmt_type->close();

                    $conn->close();

                
                    header("Location: Landlord_Delete_Success.php?propertyType=$propertyType");
                    exit();
                } else {
                    echo "No property found with the provided ID.";
                }
            } else {
                echo "Prepare statement error: " . $conn->error;
            }
        } else {
            echo "No property found with the provided ID.";
        }

      
        $stmt_type->close();
    } else {
        echo "Prepare statement error: " . $conn->error;
    }

    
    $conn->close();
} else {
    die("Property ID not provided.");
}
?>
