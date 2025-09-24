<?php
session_start();
include 'admin/inc/config.php'; // PDO $pdo connection
include 'phonepe_config.php'; // PhonePe credentials

// PHPMailer setup
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// --- Debugging: Log session ID and order details ---
error_log("Session ID: " . session_id());
error_log("Order Details: " . print_r($_SESSION['order_details'], true));
// --- End Debugging ---

// Validate session and required parameters
if (
    !isset($_GET['orderid'], $_GET['moid']) ||
    !isset($_SESSION['order_details']) ||
    session_id() === ''
) {
    die('Missing payment or order details. Please contact support.');
}

$merchant_transaction_id = filter_var($_GET['moid']);
$phonepe_order_id = filter_var($_GET['orderid']);
$order = $_SESSION['order_details'];
$session_id = session_id();

// --- Debugging: Log GET parameters ---
error_log("Merchant Transaction ID: " . $merchant_transaction_id);
error_log("PhonePe Order ID: " . $phonepe_order_id);
// --- End Debugging ---

// Validate order details
if (
    empty($order['customer_name']) || empty($order['customer_email']) ||
    empty($order['customer_mobile']) || empty($order['customer_address']) ||
    empty($order['cart_items']) || empty($order['sub_total'])
) {
    // --- Debugging: Log missing fields ---
    $missing_fields = [];
    if (empty($order['customer_name'])) $missing_fields[] = 'customer_name';
    if (empty($order['customer_email'])) $missing_fields[] = 'customer_email';
    if (empty($order['customer_mobile'])) $missing_fields[] = 'customer_mobile';
    if (empty($order['customer_address'])) $missing_fields[] = 'customer_address';
    if (empty($order['cart_items'])) $missing_fields[] = 'cart_items';
    if (empty($order['sub_total'])) $missing_fields[] = 'sub_total';
    error_log("Missing fields: " . implode(', ', $missing_fields));
    // --- End Debugging ---
    die('Invalid order details. Please contact support.');
}

// $accessToken="GET_FROM_DATABASE";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/order/' . $_GET["moid"] . '/status',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: O-Bearer ' . $accessToken
    ),
));

$response = curl_exec($curl);

curl_close($curl);
$getInfo = json_decode($response, true);

// --- Debugging: Log PhonePe API response ---
error_log("PhonePe API Response: " . print_r($getInfo, true));
// --- End Debugging ---

// Format product_info for email and display
$product_info = '';
foreach ($order['cart_items'] as $item) {
    $product_info .= htmlspecialchars($item['product_name']) . " x " . $item['quantity'] . " (₹" . number_format($item['product_price'] * $item['quantity'], 2) . ")\n";
}

// Insert order and items into database
try {
    $pdo->beginTransaction();

    // Check for duplicate order
    $stmt = $pdo->prepare("SELECT id FROM tbl_orders WHERE merchant_order_id = ?");
    $stmt->execute([$merchant_transaction_id]);
    if ($stmt->fetch()) {
        // Order already processed, skip insertion
        unset($_SESSION['order_details']);
        $pdo->prepare("DELETE FROM tbl_cart WHERE session_id = ?")->execute([$session_id]);
    } else {
        // Insert into tbl_orders
        $stmt = $pdo->prepare("
            INSERT INTO tbl_orders
                (session_id, merchant_order_id, phonepe_order_id, customer_name, customer_email, customer_mobile,
                 customer_address, customer_city, customer_state, customer_country, subtotal, payment_status, order_status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Success', NOW())
        ");
        $stmt->execute([
            $session_id,
            $merchant_transaction_id,
            $phonepe_order_id,
            $order['customer_name'],
            $order['customer_email'],
            $order['customer_mobile'],
            $order['customer_address'],
            $order['customer_city'],
            $order['customer_state'],
            $order['customer_country'],
            $order['sub_total']
        ]);

        // Insert into tbl_order_items
        $order_id = $pdo->lastInsertId();
        foreach ($order['cart_items'] as $item) {
            $stmt = $pdo->prepare("
                INSERT INTO tbl_order_items (order_id, product_id, product_name, product_price, quantity)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $order_id,
                $item['product_id'],
                $item['product_name'],
                $item['product_price'],
                $item['quantity']
            ]);
        }

        $pdo->prepare("DELETE FROM tbl_cart WHERE session_id = ?")->execute([$session_id]);
        $pdo->commit();

        unset($_SESSION['order_details']);
    }
} catch (Exception $e) {
    $pdo->rollBack();
    if (is_writable(dirname($log_file))) {
        file_put_contents($log_file, date('c') . " - Database Error: " . $e->getMessage() . "\n", FILE_APPEND);
    }
    die("Failed to process your order: " . htmlspecialchars($e->getMessage()));
}

// Send confirmation emails
$admin_email = 'info@cosmicenergies.in';
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@cosmicenergies.in';
    $mail->Password = 'lflkcvbhvwbhvrui'; // Move to phonepe_config.php
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->isHTML(true);
    $mail->setFrom('info@cosmicenergies.in', 'Cosmic Energies');

    // Customer email
    $mail->addAddress($order['customer_email']);
    $mail->Subject = 'Your Order Confirmation';
    $mail->Body = "
        <h2>Thank you, {$order['customer_name']}!</h2>
        <p>Your order <strong>{$merchant_transaction_id}</strong> is confirmed.</p>
        <p><strong>Total Paid:</strong> ₹" . number_format($order['sub_total'], 2) . "</p>
        <h4>Shipping Address:</h4>
        <p>" . htmlspecialchars("{$order['customer_address']}, {$order['customer_city']}, {$order['customer_state']}, {$order['customer_country']}") . "</p>
        <h4>Products:</h4>
        <p>" . nl2br($product_info) . "</p>
        <p>If you have any questions, contact us at <a href='mailto:{$admin_email}'>{$admin_email}</a>.</p>";
    $mail->send();
    $mail->clearAddresses();

    // Admin email
    $mail->addAddress($admin_email);
    $mail->Subject = 'New Order Received';
    $mail->Body = "
        <h2>New Order Placed</h2>
        <p><strong>Order ID:</strong> {$merchant_transaction_id}</p>
        <p><strong>Customer:</strong> {$order['customer_name']}</p>
        <p><strong>Email:</strong> {$order['customer_email']}</p>
        <p><strong>Phone:</strong> {$order['customer_mobile']}</p>
        <p><strong>Total:</strong> ₹" . number_format($order['sub_total'], 2) . "</p>
        <p><strong>Shipping Address:</strong> " . htmlspecialchars("{$order['customer_address']}, {$order['customer_city']}, {$order['customer_state']}, {$order['customer_country']}") . "</p>
        <h4>Products:</h4>
        <p>" . nl2br($product_info) . "</p>";
    $mail->send();
} catch (Exception $e) {
    if (is_writable(dirname($log_file))) {
        file_put_contents($log_file, date('c') . " - Email error: {$mail->ErrorInfo}\n", FILE_APPEND);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmic Energies | Payment Successful</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/airdatepicker/datepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/mycss.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/cart.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <style>
        .as_main_wrapper {
            background: var(--white2-color);
        }

        .panel {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin: 150px 0 100px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1.text-center {
            font-size: 2rem;
            color: var(--primary-color);
        }

        p.text-center {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .table {
            margin-top: 20px;
        }

        .table td {
            vertical-align: middle;
        }

        .as_btn {
            background-color: var(--secondary-color);
            color: #fff;
            font-weight: 600;
            border-radius: 4px;
            padding: 0.75rem 1.5rem;
            border: none;
            margin: 0 5px;
        }

        .as_btn:hover {
            background-color: #218838;
        }

        .invoice-ribbon {
            position: relative;
            height: 0;
            z-index: 1;
        }

        .ribbon-inner {
            background: var(--primary-color);
            color: white;
            font-weight: bold;
            text-align: center;
            transform: rotate(45deg);
            position: absolute;
            top: 20px;
            right: -100px;
            width: 250px;
            padding: 8px 0;
            font-size: 14px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
        }

        .print i.fa-print {
            margin-right: 6px;
        }

        @media (max-width: 600px) {
            .panel {
                margin: 100px 1rem;
                padding: 1rem;
            }

            h1.text-center {
                font-size: 1.5rem;
            }

            p.text-center {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="as_main_wrapper">
        <?php include 'include/header.php'; ?>

        <section class="as_breadcrum_wrapper" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1>Payment Successful</h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;">Home &nbsp;>> </a></li>
                            <li><a href="checkout.php" style="color: var(--primary-color); font-size:18px;">Checkout &nbsp;>> </a></li>
                            <li><a href="pay.php" style="color: var(--primary-color); font-size:18px;">Payment &nbsp;>> </a></li>
                            <li><a style="color: var(--primary-color); font-size:18px;">&nbsp; Success</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <section class="payment-success-section" style="background:#fff; padding:50px 0; ">
            <div class="container">
                <div class="panel" style="overflow:hidden;">
                    <div class="invoice-ribbon">
                        <div class="ribbon-inner">PAID</div>
                    </div>
                    <h1 class="text-center">Payment Successful</h1>
                    <p class="text-center">Thank You For Your Purchase</p>
                    <hr>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td class="text-center h6" style="width: 50%;">Transaction ID:</td>
                                <td class="text-center h6" style="width: 50%;"><?php echo htmlspecialchars($merchant_transaction_id); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center h6" style="width: 50%;">Name:</td>
                                <td class="text-center h6" style="width: 50%;"><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center h6" style="width: 50%;">Email:</td>
                                <td class="text-center h6" style="width: 50%;"><?php echo htmlspecialchars($order['customer_email']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center h6" style="width: 50%;">Phone:</td>
                                <td class="text-center h6" style="width: 50%;"><?php echo htmlspecialchars($order['customer_mobile']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center h6" style="width: 50%;">Address:</td>
                                <td class="text-center h6" style="width: 50%;"><?php echo htmlspecialchars("{$order['customer_address']}, {$order['customer_city']}, {$order['customer_state']}, {$order['customer_country']}"); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center h6" style="width: 50%;">Products:</td>
                                <td class="text-center h6" style="width: 50%;"><?php echo nl2br($product_info); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center h6" style="width: 50%;">Total:</td>
                                <td class="text-center h6" style="width: 50%;">₹<?php echo number_format($order['sub_total'], 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mt-4">
                        <div class="col-lg-12 text-center">
                            <p class="lead mb-4">THANK YOU!</p>
                            <a href="index.php" class="as_btn">Return Home</a>
                            <button type="button" class="as_btn print" style="margin-left:30px;"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include 'include/footer.php'; ?>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugin/slick/slick.min.js"></script>
    <script src="assets/js/plugin/countto/jquery.countTo.js"></script>
    <script src="assets/js/plugin/airdatepicker/datepicker.min.js"></script>
    <script src="assets/js/plugin/airdatepicker/i18n/datepicker.en.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        document.querySelector('.print').addEventListener('click', function() {
            var printContents = document.querySelector('.panel').outerHTML;
            var newWindow = window.open('', '_blank');
            newWindow.document.write(`
                <html>
                    <head>
                        <title>Print Invoice</title>
                        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
                        <style>
                            body { font-family: Arial, sans-serif; }
                            .panel { padding: 20px; }
                            h1.text-center { font-size: 2rem; color: var(--primary-color); }
                            p.text-center { font-size: 1.2rem; color: #6c757d; }
                            .table { margin-top: 20px; }
                            .table td { vertical-align: middle; }
                            .invoice-ribbon { position: relative; height: 0; }
                            .ribbon-inner {
                                background: var(--primary-color);
                                color: white;
                                font-weight: bold;
                                text-align: center;
                                transform: rotate(45deg);
                                position: absolute;
                                top: 20px;
                                right: -100px;
                                width: 250px;
                                padding: 8px 0;
                                font-size: 14px;
                                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
                            }
                        </style>
                    </head>
                    <body>
                        ${printContents}
                    </body>
                </html>
            `);
            newWindow.document.close();
            newWindow.print();
            newWindow.close();
        });
    </script>
</body>

</html>