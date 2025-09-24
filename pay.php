<?php
include 'admin/inc/config.php';
include 'phonepe_config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$session_id = session_id();
if (empty($session_id)) {
    die('Session not started.');
}

// Validate form data from checkout.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method.');
}

// Sanitize and validate billing details
$customer_name = filter_var($_POST['customer_name']);
$customer_email = filter_var($_POST['customer_email']);
$customer_mobile = filter_var($_POST['customer_mobile']);
$customer_address = filter_var($_POST['customer_address']);
$customer_city = filter_var($_POST['customer_city']);
$customer_state = filter_var($_POST['customer_state']);
$customer_country = filter_var($_POST['customer_country']);
$cart_items = $_POST['cart_items'] ?? [];
$subtotal = floatval($_POST['subtotal'] ?? 0);

// Validate required fields
if (
    empty($customer_name) || empty($customer_email) || empty($customer_mobile) || 
    empty($customer_address) || empty($customer_city) || empty($customer_state) || 
    empty($customer_country) || empty($cart_items) || $subtotal <= 0
) {
    die('Incomplete or invalid form data.');
}

// Additional email validation
if (!filter_var($customer_email)) {
    die('Invalid email format.');
}

// Store order details in session for payment_success.php
$_SESSION['order_details'] = [
    'customer_name' => $customer_name,
    'customer_email' => $customer_email,
    'customer_mobile' => $customer_mobile,
    'customer_address' => $customer_address,
    'customer_city' => $customer_city,
    'customer_state' => $customer_state,
    'customer_country' => $customer_country,
    'cart_items' => $cart_items,
    'sub_total' => $subtotal
];

// Generate unique merchant order ID
$morderid = uniqid();

// Prepare PhonePe API request
$amount_in_paise = $subtotal * 100; // Convert rupees to paise
$payload = [
    'merchantOrderId' => $morderid,
    'amount' => $amount_in_paise,
    'expireAfter' => 1200,
    'metaInfo' => [
        'udf1' => $customer_name,
        'udf2' => $customer_email,
        'udf3' => $customer_mobile,
        'udf4' => $customer_city,
        'udf5' => 'Checkout from Cosmicenergies'
    ],
    'paymentFlow' => [
        'type' => 'PG_CHECKOUT',
        'message' => 'Payment for order on Cosmicenergies',
        'merchantUrls' => [
            'redirectUrl' => 'http://' . $_SERVER['HTTP_HOST'] . '/payment_success.php?moid=' . $morderid . '&orderid='
        ]
    ]
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: O-Bearer ' . $accessToken
    ],
]);

$response = curl_exec($curl);
$curl_error = curl_error($curl);
curl_close($curl);

if ($curl_error) {
    error_log('PhonePe API Error: ' . $curl_error, 3, 'errors.log');
    die('Payment initiation failed. Please try again later.');
}

$getPaymentInfo = json_decode($response, true);

if (isset($getPaymentInfo['redirectUrl']) && !empty($getPaymentInfo['redirectUrl'])) {
    $orderid = $getPaymentInfo['orderId'];
    $redirectTokenurl = $getPaymentInfo['redirectUrl'];
} else {
    error_log('PhonePe API Response: ' . print_r($getPaymentInfo, true), 3, 'errors.log');
    die('Failed to initiate payment. Please try again.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cosmicenergies | Payment</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/mycss.css">
    <link rel="stylesheet" type="text/css" href="assets/css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <script src="https://mercury.phonepe.com/web/bundle/checkout.js"></script>
    
    <link rel="stylesheet" type="text/css" href="assets/css/pay-page.css">
</head>
<body>
    <div class="as_main_wrapper">
        <?php include 'include/header.php'; ?>

        <section class="as_breadcrum_wrapper" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1>Payment</h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;">Home &nbsp;>> </a></li>
                            <li><a href="checkout.php" style="color: var(--primary-color); font-size:18px;">Checkout &nbsp;>> </a></li>
                            <li><a style="color: var(--primary-color); font-size:18px;">&nbsp; Payment</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="payment-section" style="padding:50px 0;">
            <div class="container">
                <h2>₹ <?= number_format($subtotal,2); ?></h2>
                <h3>Complete Your Payment</h3>
                <button id="payButton" class="as_btn">Pay Now (₹<?php echo number_format($subtotal, 2); ?>)</button>
            </div>
        </section>

        <?php include 'include/footer.php'; ?>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        document.getElementById('payButton').addEventListener('click', function () {
            var tokenUrl = '<?php echo ($redirectTokenurl); ?>';
            function paymentCallback(response) {
                if (response === 'USER_CANCEL') {
                    alert('Payment was cancelled by the user.');
                } else if (response === 'CONCLUDED') {
                    alert('Payment completed successfully.');
                    window.location.href = 'payment_success.php?orderid=<?php echo ($orderid); ?>&moid=<?php echo ($morderid); ?>';
                } else {
                    alert('Payment failed: ' + response);
                }
            }

            if (window.PhonePeCheckout && window.PhonePeCheckout.transact) {
                window.PhonePeCheckout.transact({
                    tokenUrl: tokenUrl,
                    callback: paymentCallback,
                    type: 'IFRAME'
                });
            } else {
                alert('PhonePe Checkout is not available. Please try again later.');
            }
        });
    </script>
</body>
</html>