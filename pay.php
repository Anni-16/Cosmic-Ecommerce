<?php
session_start();
include('./admin/inc/config.php');
include('gatway-config.php'); // Contains RAZORPAY_KEY_ID and RAZORPAY_KEY_SECRET

// Check if form data exists
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['customer_name']) || empty($_POST['cart_items'])) {
    echo "<script>alert('Invalid request.'); window.location.href = 'checkout.php';</script>";
    exit;
}

// Collect billing details
$customer_name    = trim($_POST['customer_name']);
$customer_email   = trim($_POST['customer_email']);
$customer_mobile  = trim($_POST['customer_mobile']);
$customer_address = trim($_POST['customer_address']);
$customer_city    = trim($_POST['customer_city']);
$customer_state   = trim($_POST['customer_state']);
$customer_country = trim($_POST['customer_country']);

// Validate cart items
$cart_items = $_POST['cart_items'];
if (!is_array($cart_items) || count($cart_items) === 0) {
    echo "<script>alert('Your cart is empty!'); window.location.href = 'cart.php';</script>";
    exit;
}

// Calculate subtotal
$sub_total = 0;
$product_info = '';

foreach ($cart_items as $item) {
    $product_price = (float)$item['product_price'];
    $quantity = (int)$item['quantity'];
    $sub_total += $product_price * $quantity;
    $product_info .= htmlspecialchars($item['product_name']) . ' (x' . $quantity . '), ';
}
$product_info = rtrim($product_info, ', ');

// GST (18%)
$gst = $sub_total * 0.18;
$grand_total = $sub_total + $gst;
$amount_in_paise = round($grand_total * 100); // Razorpay needs amount in paise

// Store order details in session
$_SESSION['order_details'] = [
    'customer_name'    => $customer_name,
    'customer_email'   => $customer_email,
    'customer_phone'   => $customer_mobile,
    'customer_address' => $customer_address,
    'customer_city'    => $customer_city,
    'customer_state'   => $customer_state,
    'customer_country' => $customer_country,
    'product_info'     => $product_info,
    'sub_total'        => $sub_total,
    'gst'              => $gst,
    'grand_total'      => $grand_total,
    'cart_items'       => $cart_items
];

// Initialize Razorpay
require 'razorpay-php/Razorpay.php';
use Razorpay\Api\Api;

try {
    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    $orderData = [
        'receipt' => uniqid('order_'),
        'amount' => $amount_in_paise,
        'currency' => 'INR',
        'payment_capture' => 1
    ];

    $razorpayOrder = $api->order->create($orderData);
    $order_id = $razorpayOrder['id'];

    $_SESSION['order_details']['order_id'] = $order_id;

    $razorpay_data = [
        'key' => RAZORPAY_KEY_ID,
        'amount' => $amount_in_paise,
        'currency' => 'INR',
        'name' => 'Cosmic Energies',
        'description' => $product_info,
        'order_id' => $order_id,
        'prefill' => [
            'name' => $customer_name,
            'email' => $customer_email,
            'contact' => $customer_mobile
        ],
        'theme' => [
            'color' => 'var(--primary-color)'
        ]
    ];

} catch (Exception $e) {
    echo "<script>alert('Error creating Razorpay order: " . addslashes($e->getMessage()) . "'); window.location.href = 'cart.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <script>
        function initiatePayment() {
            var options = <?php echo json_encode($razorpay_data); ?>;

            options.handler = function (response) {
                window.location.href = "razorpay_success.php?payment_id=" +
                    encodeURIComponent(response.razorpay_payment_id) +
                    "&order_id=" + encodeURIComponent(response.razorpay_order_id) +
                    "&signature=" + encodeURIComponent(response.razorpay_signature);
            };

            options.modal = {
                ondismiss: function () {
                    window.location.href = "payment-error.php";
                }
            };

            var rzp = new Razorpay(options);
            rzp.open();
        }

        window.onload = initiatePayment;
    </script>
</body>
</html>
