<?php
include('admin/inc/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$session_id = session_id();
if (empty($session_id)) {
    die('Session not started.');
}

try {
    $stmt = $pdo->prepare("
        SELECT id, product_id, product_name, product_model, product_image, product_price, quantity
        FROM tbl_cart
        WHERE session_id = ?
    ");
    $stmt->execute([$session_id]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $subtotal = 0;
    foreach ($cart_items as $item) {
        $subtotal += (float)$item['product_price'] * (int)$item['quantity'];
    }
    
} catch (Throwable $e) {
    die('Error fetching cart data: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | Numerology Website | Numerlogy</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- stylesheet -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/airdatepicker/datepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/mycss.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/cart.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!-- favicon -->
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    
    
    <link rel="stylesheet" type="text/css" href="assets/css/checkout-page.css" />

</head>

<body>

    <div class="as_main_wrapper">

        <!-- START HEADER -->
        <?php include('include/header.php'); ?>
        <!-- END HEADER -->

        <section class="as_breadcrum_wrapper" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1>Checkout</h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;">Home &nbsp;>> </a></li>
                            <li><a style="color: var(--primary-color); font-size:18px;">&nbsp; Checkout </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        <section>
            <div class="container">
                <form method="post" enctype="multipart/form-data" action="pay.php">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="as_contact_form" style="background: var(--white2-color); margin-bottom: 100px; margin-top: 150px;">
                                <h4 class="as_subheading" style="color: var(--primary-color);">Billing Details</h4>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label>Name</label>
                                        <input type="text" name="customer_name" class="form-control" placeholder="Full Name" required>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label>Email</label>
                                        <input type="email" name="customer_email" class="form-control" placeholder="Email Address" required>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label>Mobile No.</label>
                                        <input type="text" name="customer_mobile" class="form-control" placeholder="Mobile Number" required>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label>Address</label>
                                        <textarea name="customer_address" class="form-control" placeholder="Address" required></textarea>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label>City</label>
                                        <input type="text" name="customer_city" class="form-control" placeholder="City" required>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label>State</label>
                                        <input type="text" name="customer_state" class="form-control" placeholder="State" required>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <label>Country</label>
                                        <input type="text" name="customer_country" class="form-control" placeholder="Country" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="as_contact_form" style="background: var(--white2-color); margin-bottom: 100px; margin-top: 150px;">
                                <div class="your-order-area">
                                    <h3 style="color:var(--primary-color);">Your order</h3>
                                    <?php if (empty($cart_items)) : ?>
                                        <p>Your cart is empty.</p>
                                    <?php else : ?>
                                        <div class="your-order-wrap gray-bg-4">
                                            <div class="your-order-info-wrap">
                                                <div class="your-order-info">
                                                    
                                                        <li style="color:var(--primary-color); list-style:none; padding-bottom:10px;">Product <span>Total</span></li>
                                                  
                                                </div>
                                                <div class="your-order-middle" >
                                                    <ul>
                                                        <?php foreach ($cart_items as $index => $item) : ?>
                                                            <li>
                                                                <span style="color:var(--primary-color);">
                                                                    <?= htmlspecialchars($item['product_name']) ?> x <?= $item['quantity'] ?>
                                                                </span>
                                                                <span style="color:var(--primary-color);">₹<?= number_format($item['product_price'] * $item['quantity'], 2) ?></span>
                                                                <input type="hidden" name="cart_items[<?= $index ?>][product_id]" value="<?= $item['product_id'] ?>">
                                                                <input type="hidden" name="cart_items[<?= $index ?>][product_name]" value="<?= htmlspecialchars($item['product_name']) ?>">
                                                                <input type="hidden" name="cart_items[<?= $index ?>][product_price]" value="<?= $item['product_price'] ?>">
                                                                <input type="hidden" name="cart_items[<?= $index ?>][quantity]" value="<?= $item['quantity'] ?>">
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>

                                                <div class="your-order-middle  " style="border-top: 1px solid  var(--primary-color); padding-top:0px;">
                                                    <ul style="padding-top: 20px;">
                                                        <li class="d-flex justify-content-between">
                                                            <h6 style="color:var(--primary-color);">Total</h6>
                                                            <h6 style="color:var(--primary-color);">₹<?= number_format($subtotal, 2) ?></h6>
                                                            <input type="hidden" name="subtotal" value="<?= number_format($subtotal, 2, '.', '') ?>">
                                                        </li>
                                                    </ul>
                                                </div>
                                               
                                            </div>
                                        </div>

                                        <!-- ✅ Replaced <a> with submit button below -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center as_padderTop20">
                                            <button type="submit" class="as_btn" style="border:none; background:none;">Place Order</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Footer -->
        <?php include('include/footer.php'); ?>
    </div>

    <!-- Scripts -->
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugin/slick/slick.min.js"></script>
    <script src="assets/js/plugin/countto/jquery.countTo.js"></script>
    <script src="assets/js/plugin/airdatepicker/datepicker.min.js"></script>
    <script src="assets/js/plugin/airdatepicker/i18n/datepicker.en.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/rocket-loader.min.js" data-cf-settings="dea942b4e5104683ffff5739-|49" defer></script>
</body>

</html>
