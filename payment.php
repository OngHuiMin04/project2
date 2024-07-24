<?php
// payment.php

// Database connection
$dsn = 'mysql:host=localhost;dbname=ayrentals';
$username = 'root';
$password = '';
$options = [];
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Retrieve bookingId from POST or GET request
$bookingId = $_POST['bookingId'] ?? $_GET['bookingId'] ?? null;

if ($bookingId) {
    // Fetch booking details
    $stmt = $pdo->prepare("SELECT propertyId, email FROM bookings WHERE bookingId = ?");
    $stmt->execute([$bookingId]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($booking) {
        $propertyId = $booking['propertyId'];
        $email = $booking['email'];

        // Fetch price details
        $stmt = $pdo->prepare("SELECT price, deposit, ayrentalFees, sst, total FROM pricedetails WHERE propertyId = ?");
        $stmt->execute([$propertyId]);
        $priceDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($priceDetails) {
            $price = $priceDetails['price'];
            $deposit = $priceDetails['deposit'];
            $ayrentalFees = $priceDetails['ayrentalFees'];
            $sst = $priceDetails['sst'];
            $total = $priceDetails['total'];
        } else {
            echo 'No price details found.';
            exit;
        }
    } else {
        echo 'No booking found.';
        exit;
    }
} else {
    echo 'Booking ID not provided.';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="payment.css">
    <title>Payment Page</title>
</head>
<body>
    
    <!-- start: Payment -->
    <section class="payment-section">
        <div class="container">
            <div class="payment-wrapper">
                <div class="payment-left">
                    <div class="payment-header">
                        <div class="payment-header-title">ORDER SUMMARY</div>
                        <hr>
                        <p class="payment-header-description">Make your dream home a reality today; the investment is worth the joy and comfort.</p>
                    </div>
                    <div class="payment-content">
                        <div class="payment-body">
                            <div class="payment-plan">
                                <div class="payment-plan-info">
                                    <div class="payment-plan-info-name">Property ID: <?php echo htmlspecialchars($propertyId); ?></div>
                                </div>
                                <div class="payment-plan-info">
                                    <div class="payment-plan-info-name">Email: <?php echo htmlspecialchars($email); ?></div>
                                </div>
                                <div class="payment-plan-info">
                                    <div class="payment-plan-info-name">Booking ID: <?php echo htmlspecialchars($bookingId); ?></div>
                                </div> 
                            </div>
                            <div class="payment-summary">
                                <div class="payment-summary-item">
                                    <div class="payment-summary-name">1st month rental:</div>
                                    <div class="payment-summary-price"><?php echo htmlspecialchars($price); ?></div>
                                </div>
                                <div class="payment-summary-item">
                                    <div class="payment-summary-name">Deposit:</div>
                                    <div class="payment-summary-price"><?php echo htmlspecialchars($deposit); ?></div>
                                </div>
                                <div class="payment-summary-item">
                                    <div class="payment-summary-name">AYRENTAL fees:</div>
                                    <div class="payment-summary-price"><?php echo htmlspecialchars($ayrentalFees); ?></div>
                                </div>
                                <div class="payment-summary-item">
                                    <div class="payment-summary-name">SST (6%):</div>
                                    <div class="payment-summary-price"><?php echo htmlspecialchars($sst); ?></div>
                                </div>
                                <div class="payment-summary-divider"></div>
                                <div class="payment-summary-item payment-summary-total">
                                    <div class="payment-summary-name">TOTAL:</div>
                                    <div class="payment-summary-price"><?php echo htmlspecialchars($total); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment-right">
                <form method="POST" action="process_payment.php">
    <input type="hidden" name="bookingId" value="123"> <!-- Example bookingId -->

    <div class="payment-method">
        <input type="radio" name="payment-method" id="method-1" value="Visa" checked>
        <label for="method-1" class="payment-method-item">
            <img src="img/visa.png" alt="Visa">
        </label>

        <input type="radio" name="payment-method" id="method-2" value="MasterCard">
        <label for="method-2" class="payment-method-item">
            <img src="img/mastercard.png" alt="MasterCard">
        </label>

        <input type="radio" name="payment-method" id="method-3" value="Touch n Go">
        <label for="method-3" class="payment-method-item">
            <img src="img/tng.png" alt="Touch 'n Go">
        </label>
    </div>

    <div id="card-details">
        <div class="payment-form-group">
            <input type="email" placeholder=" " class="payment-form-control" id="email" name="email">
            <label for="email" class="payment-form-label payment-form-label-required">Email Address</label>
        </div>

        <div class="payment-form-group" id="card-number-group">
            <input type="text" placeholder=" " class="payment-form-control" id="card-number" name="card-number">
            <label for="card-number" class="payment-form-label payment-form-label-required">Card Number</label>
        </div>

        <div class="payment-form-group-flex" id="expiry-cvv-group">
            <div class="payment-form-group">
                <input type="date" placeholder=" " class="payment-form-control" id="expiry-date" name="expiry-date">
                <label for="expiry-date" class="payment-form-label payment-form-label-required">Expiry Date</label>
            </div>
            <div class="payment-form-group">
                <input type="text" placeholder=" " class="payment-form-control" id="cvv" name="cvv">
                <label for="cvv" class="payment-form-label payment-form-label-required">CVV</label>
            </div>
        </div>
    </div>

    <div id="tng-details" style="display: none;">
        <div class="payment-form-group">
            <input type="email" placeholder=" " class="payment-form-control" id="tng-email" name="tng-email">
            <label for="tng-email" class="payment-form-label payment-form-label-required">Email Address</label>
        </div>
        
        <div class="payment-form-group" id="pin-group">
            <input type="text" placeholder=" " class="payment-form-control" id="pin" name="pin">
            <label for="pin" class="payment-form-label payment-form-label-required">PIN</label>
        </div>
    </div>

    <button type="submit" class="payment-form-submit-button"><i class="ri-wallet-line"></i> Pay</button>
</form>

                </div>
            </div>
        </div>
    </section>
    <!-- end: Payment -->

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const cardDetails = document.getElementById('card-details');
    const tngDetails = document.getElementById('tng-details');
    const paymentMethods = document.getElementsByName('payment-method');

    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'Touch n Go') {
                cardDetails.style.display = 'none';
                tngDetails.style.display = 'block';
            } else {
                cardDetails.style.display = 'block';
                tngDetails.style.display = 'none';
            }
        });
    });
});
</script>
</body>
</html>
