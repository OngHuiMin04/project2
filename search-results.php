<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "ayrentals";      // Ensure this is the correct database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$taman = isset($_GET['taman']) ? $conn->real_escape_string($_GET['taman']) : '';
$propertyType = isset($_GET['residential']) ? $conn->real_escape_string($_GET['residential']) : 'all';
$priceRange = isset($_GET['price']) ? $conn->real_escape_string($_GET['price']) : 'any';
$bedroom = isset($_GET['bedroom']) ? $conn->real_escape_string($_GET['bedroom']) : 'any';

// Build the SQL query
$query = "SELECT p.*, d.price AS priceDetails
          FROM properties p
          LEFT JOIN pricedetails d ON p.propertyId = d.propertyId
          WHERE 1=1";

if (!empty($taman)) {
    $query .= " AND p.residentialname LIKE '%$taman%'";
}

if ($propertyType != 'all') {
    $query .= " AND p.propertyType = '$propertyType'";  // Use 'propertyType' instead of 'residential'
}

if ($priceRange != 'any') {
    // Assuming priceRange is in the format '500-1500'
    $priceParts = explode('-', $priceRange);
    if (count($priceParts) == 2) {
        $minPrice = $priceParts[0];
        $maxPrice = $priceParts[1];
        $query .= " AND d.price BETWEEN '$minPrice' AND '$maxPrice'";
    }
}

if ($bedroom != 'any') {
    $query .= " AND p.bedroom = '$bedroom'";
}

$result = $conn->query($query);

if (!$result) {
    die("Query Failed: " . $conn->error);
}

// Display the results
if ($result->num_rows > 0) {
    echo '<table>
            <thead>
                <tr>
                    <th>Property ID</th>
                    <th>Property Name</th>
                    <th>Residential Name</th>
                    <th>Address</th>
                    <th>Postcode</th>
                    <th>Property Type</th>
                    <th>Rent Category</th>
                    <th>Bedroom</th>
                    <th>Bathroom</th>
                    <th>Parking</th>
                    <th>Size</th>
                    <th>Floor Level</th>
                    <th>Furnishing</th>
                    <th>Facilities</th>
                    <th>Price</th>
                    <th>Deposit</th>
                    <th>Available Date</th>
                    <th>Contact Email</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . htmlspecialchars($row['propertyId']) . '</td>
                <td>' . htmlspecialchars($row['propertyName']) . '</td>
                <td>' . htmlspecialchars($row['residentialname']) . '</td>
                <td>' . htmlspecialchars($row['address']) . '</td>
                <td>' . htmlspecialchars($row['postcode']) . '</td>
                <td>' . htmlspecialchars($row['propertyType']) . '</td>
                <td>' . htmlspecialchars($row['rentcategory']) . '</td>
                <td>' . htmlspecialchars($row['bedroom']) . '</td>
                <td>' . htmlspecialchars($row['bathroom']) . '</td>
                <td>' . htmlspecialchars($row['parking']) . '</td>
                <td>' . htmlspecialchars($row['size']) . '</td>
                <td>' . htmlspecialchars($row['floorLevel']) . '</td>
                <td>' . htmlspecialchars($row['furnishing']) . '</td>
                <td>' . htmlspecialchars($row['facilities']) . '</td>
                <td>' . htmlspecialchars($row['price']) . '</td>
                <td>' . htmlspecialchars($row['deposit']) . '</td>
                <td>' . htmlspecialchars($row['v_available']) . '</td>
                <td>' . htmlspecialchars($row['email']) . '</td>
              </tr>';
    }
    echo '  </tbody>
          </table>';
} else {
    echo '<p>No results found.</p>';
}

$conn->close();
?>
