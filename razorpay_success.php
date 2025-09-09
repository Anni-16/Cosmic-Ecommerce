<?php
session_start();
include('gatway-config.php'); // Razorpay credentials
include('./admin/inc/config.php'); // PDO $pdo connection

// PHPMailer setup
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Razorpay SDK setup
require 'razorpay-php/Razorpay.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

// -- Step 1: Validate required parameters --
if (
    !isset($_GET['payment_id'], $_GET['order_id'], $_GET['signature']) ||
    !isset($_SESSION['order_details'])
) {
    die('Missing payment or order details. Please contact support.');
}

$payment_id = $_GET['payment_id'];
$razorpay_order_id = $_GET['order_id'];
$signature = $_GET['signature'];

$order = $_SESSION['order_details'];
$session_id = session_id();

// -- Step 2: Verify payment signature --
$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
try {
    $api->utility->verifyPaymentSignature([
        'razorpay_order_id'   => $razorpay_order_id,
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature'  => $signature
    ]);
} catch (SignatureVerificationError $e) {
    die('Payment verification failed: ' . htmlspecialchars($e->getMessage()));
}

// -- Step 3: Insert order and items into database --
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO tbl_order
            (session_id, order_id, payment_id, customer_name, customer_email, customer_phone,
             customer_address, customer_city, customer_state, customer_country,
             sub_total, gst, grand_total, payment_status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Success', NOW())
    ");
    $stmt->execute([
        $session_id,
        $razorpay_order_id,
        $payment_id,
        $order['customer_name'],
        $order['customer_email'],
        $order['customer_phone'],
        $order['customer_address'],
        $order['customer_city'],
        $order['customer_state'],
        $order['customer_country'],
        $order['sub_total'],
        $order['gst'],
        $order['grand_total']
    ]);

    $order_db_id = $pdo->lastInsertId();

    $item_stmt = $pdo->prepare("
        INSERT INTO tbl_order_items
            (order_id, product_id, product_name, product_price, quantity, total_price)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    foreach ($order['cart_items'] as $item) {
        $total_price = $item['product_price'] * $item['quantity'];
        $item_stmt->execute([
            $order_db_id,
            $item['product_id'],
            $item['product_name'],
            $item['product_price'],
            $item['quantity'],
            $total_price
        ]);
    }

    $pdo->prepare("DELETE FROM tbl_cart WHERE session_id = ?")->execute([$session_id]);
    $pdo->commit();

    unset($_SESSION['order_details']);
} catch (Exception $e) {
    $pdo->rollBack();
    die("Failed to process your order: " . htmlspecialchars($e->getMessage()));
}

// -- Step 4: Send confirmation emails to customer and admin --
$admin_email = 'info@cosmicenergies.in'; // Replace with your admin email

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@cosmicenergies.in'; // your Gmail
    $mail->Password   = 'lflkcvbhvwbhvrui';   // Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->isHTML(true);
    $mail->setFrom('info@cosmicenergies.in', 'Cosmic Energies');

    // Email to Customer
    $mail->addAddress($order['customer_email']);
    $mail->Subject = 'Your Order Confirmation';
    $mail->Body = "
        <h2>Thank you, {$order['customer_name']}!</h2>
        <p>Your order <strong>{$razorpay_order_id}</strong> is confirmed.</p>
        <p><strong>Total Paid:</strong> ₹" . number_format($order['grand_total'], 2) . "</p>
        <h4>Shipping Address:</h4>
        <p>{$order['customer_address']}, {$order['customer_city']}, {$order['customer_state']}, {$order['customer_country']}</p>
        <h4>Products:</h4>
        <p>{$order['product_info']}</p>
        <p>If you have any questions, contact us anytime.</p>";

    $mail->send();
    $mail->clearAddresses();

    // Email to Admin
    $mail->addAddress($admin_email);
    $mail->Subject = 'New Order Received';
    $mail->Body = "
        <h2>New Order Placed</h2>
        <p><strong>Order ID:</strong> {$razorpay_order_id}</p>
        <p><strong>Customer:</strong> {$order['customer_name']}</p>
        <p><strong>Email:</strong> {$order['customer_email']}</p>
        <p><strong>Phone:</strong> {$order['customer_phone']}</p>
        <p><strong>Total:</strong> ₹" . number_format($order['grand_total'], 2) . "</p>
        <p><strong>Shipping Address:</strong> {$order['customer_address']}, {$order['customer_city']}, {$order['customer_state']}, {$order['customer_country']}</p>
        <h4>Products:</h4>
        <p>{$order['product_info']}</p>";

    $mail->send();
} catch (Exception $e) {
    file_put_contents('mail_error.log', date('c') . " - Email error: {$mail->ErrorInfo}\n", FILE_APPEND);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | Numerology Website | Payement Successfull</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <!-- stylesheet -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/airdatepicker/datepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/mycss.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/cart.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <!-- This Google Font used in Captions -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">


</head>

<body>

    <style>
        body {
            background-color: var(--secondary-color);
        }

        .panel {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        h1.text-center {
            font-size: 2rem;
            color: #28a745;
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

        .btn {
            font-size: 16px;
            border-radius: 4px;
        }

        /* === RIBBON STYLING === */
        .invoice-ribbon {
            position: relative;
            height: 0;
            z-index: 1;
        }

        .ribbon-inner {
            background: #28a745;
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

        /* === BUTTON HOVER === */
        .btn:hover {
            opacity: 0.9;
        }

        /* === PRINT BUTTON (Optional Icon Handling) === */
        .print i.fa-print {
            margin-right: 6px;
        }

        @media screen and (min-width: 1400px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                max-width: 1320px;
            }
        }

        @media only screen and (min-width: 993px) {
            .container {
                width: 90%;
            }
        }
    </style>

    <div class="as_main_wrapper" style="background:#fff">
        <!-- START HEADER -->
        <?php include('include/header.php') ?>
        <!-- END HEADER -->

        <div class="register-section">
            <div class="container">
                <div class="row">
                    <div id="content" class="col-sm-12  all-blog my-account" style="padding-left: 20px;">
                        <div class="container bootstrap snippets bootdeys">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default invoice " id="invoice">
                                        <div class="panel-body content">
                                            <div class="invoice-ribbon" style="display: flex; justify-content: right;">
                                                <div class="ribbon-inner">PAID</div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <h1 class="text-center">Payment Successfull</h1>
                                                    <p class="text-center">Thank You For Your Purchase</p>
                                                </div>

                                            </div>
                                            <hr>

                                            <div class="row table-row">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">Payment Id :
                                                            </td>
                                                            <td class="text-center h6" style="width: 50%; "><?= htmlspecialchars($payment_id) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">Order Id : </td>
                                                            <td class="text-center h6" style="width: 50%; "><?= htmlspecialchars($razorpay_order_id) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">Name : </td>
                                                            <td class="text-center h6" style="width: 50%; "> <?= htmlspecialchars($order['customer_name']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">Email : </td>
                                                            <td class="text-center h6" style="width: 50%; "><?= htmlspecialchars($order['customer_email']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">Phone : </td>
                                                            <td class="text-center h6" style="width: 50%; "><?= htmlspecialchars($order['customer_phone']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">Address : </td>
                                                            <td class="text-center h6" style="width: 50%; "><?= htmlspecialchars("{$order['customer_address']}, {$order['customer_city']}, {$order['customer_state']}, {$order['customer_country']}") ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">Products : </td>
                                                            <td class="text-center h6" style="width: 50%; "> <?= htmlspecialchars($order['product_info']) ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">Sub Total Amount:
                                                            </td>
                                                            <td class="text-center h6" style="width: 50%; ">₹<?= number_format($order['sub_total'], 2) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">GST (18%) Amount:
                                                            </td>
                                                            <td class="text-center h6" style="width: 50%; ">₹<?= number_format($order['gst'], 2) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center h6" style="width: 50%;">Total :
                                                            </td>
                                                            <td class="text-center h6" style="width: 50%; "> ₹<?= number_format($order['grand_total'], 2) ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-lg-12 margintop">
                                                    <div class="" style="display: flex; align-items: center;  justify-content: center; flex-direction: column;">
                                                        <p class="lead marginbottom mb-4">THANK YOU!</p>
                                                        <a href="index.php" class="btn " id="invoice-print" style="background-color:var(--primary-color); color:white;  margin: 0 auto;">
                                                            Return Home</a>
                                                        <br>
                                                        <button type="button" class="print btn" id="invoice-print" style="background-color:var(--primary-color); color:white; margin: 0 auto">
                                                            <i class="fa fa-print"></i>Print!
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section Start -->
        <?php include('include/footer-index.php'); ?>
        <!-- Footer Copyright Section End  -->


    </div>


    <!-- javascript -->
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/slick/slick.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/countto/jquery.countTo.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/airdatepicker/datepicker.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/airdatepicker/i18n/datepicker.en.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/custom2.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/cart.js"></script>
    <script src="assets/js/rocket-loader.min.js" data-cf-settings="dea942b4e5104683ffff5739-|49" defer></script>
    <script>
        document.querySelector('.print').addEventListener('click', function() {
            var printContents = document.getElementById('invoice').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // Optional: reloads to restore JS functionality
        });
    </script>


</body>

</html>