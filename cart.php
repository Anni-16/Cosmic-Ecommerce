<?php
include('admin/inc/config.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get session ID
$session_id = session_id();
if (empty($session_id)) {
    die('Session not started.');
}

try {
    // Fetch cart items for the current session
    $stmt = $pdo->prepare("
        SELECT id, product_id, product_name, product_model, product_image, product_price, quantity
        FROM tbl_cart
        WHERE session_id = ?
    ");
    $stmt->execute([$session_id]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate totals
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
    <title>Cosmicenergies | Numerology Website | Cart</title>
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

    <style>
        .as_breadcrum_wrapper {
            padding-top: 200px;
        }

        .main-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            width: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .as_banner_wrapper {
            padding-top: 200px;
        }

        .button-disable .as_btn:after,
        .as_btn:before {
            border-left: 0px solid var(--secondary-color) !important;
        }

        .button-disable .as_btn:before {
            border-right: 0px solid var(--secondary-color) !important;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        /* Border for all cells */
        .table th,
        .table td {
            border: 1px solid var(--white2-color);
            text-align: left;
        }

        /* Table header styling */
        .table th {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }

        /* Trash icon hover */
        .table .close_pro i {
            color: var(--primary-color);
            cursor: pointer;
            font-size: 18px;
        }

        .table .close_pro i:hover {
            color: red;
        }
    </style>

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
                        <h1>Cart</h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a href=" " style="color: var(--primary-color); font-size:18px;  ">&nbsp;Cart </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="as_cartsingle_wrapper as_padderTop80 as_padderBottom80" style="background: var(--white-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="table-responsive a_cart_table">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="color: var(--primary-color);">Products</th>
                                        <th style="color: var(--primary-color);">Price</th>
                                        <th style="color: var(--primary-color);">Quantity</th>
                                        <th style="color: var(--primary-color);">Total</th>
                                        <th style="color: var(--primary-color);">Action</th>
                                    </tr>
                                    <?php if (empty($cart_items)) : ?>
                                        <tr>
                                            <td colspan="5" style="color: var(--primary-color); text-align: center;">Your cart is empty.</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($cart_items as $item) : ?>
                                            <tr data-cart-id="<?php echo $item['id']; ?>">
                                                <td>

                                                    <span class="prod_thumb">
                                                        <img src="./admin/uploads/products/<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>" class="img-responsive" style="width: 40px;">
                                                    </span>
                                                    <div class="product_details">
                                                        <h4 style="color: var(--primary-color);"><a href="#"><?php echo $item['product_name']; ?></a></h4>
                                                    </div>
                                                </td>
                                                <td style="color: var(--primary-color);">₹<?php echo number_format((float)$item['product_price'], 2); ?></td>
                                                <td style="color: var(--primary-color);"><?php echo $item['quantity']; ?> </td>
                                                <td style="color: var(--primary-color);" class="item-total">₹<?php echo number_format((float)$item['product_price'] * (int)$item['quantity'], 2); ?></td>
                                                <td style="color: var(--primary-color);">
                                                    <span class="close_pro" data-cart-id="<?php echo $item['id']; ?>"><i class="fa fa-trash"></i></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td style="color: var(--primary-color);">Total</td>
                                            <td style="color: var(--primary-color);" id="cart-subtotal">₹<?php echo number_format($subtotal, 2); ?></td>
                                        </tr>

                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between"  >
                        <a href="#" id="backBtn" class="proceed_btn as_btn">Back</a>

                        <a href="shop.php" class="proceed_btn as_btn" value="Apply Cupon Code">Back To Shop </a>
                        <a href="checkout.php" class="proceed_btn as_btn" value="Apply Cupon Code">checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Section Start -->
        <?php include('include/footer.php'); ?>
        <!-- Footer Copyright Section End  -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.close_pro').on('click', function() {
                // Get the cart ID from the data attribute
                var cartId = $(this).data('cart-id');

                // Confirm deletion (optional)
                if (!confirm('Are you sure you want to delete this item from the cart?')) {
                    return;
                }

                // Send AJAX request to updated_cart.php
                $.ajax({
                    url: 'update_cart.php',
                    type: 'POST',
                    data: {
                        cart_id: cartId,
                        action: 'delete'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message); // Show success message
                            // Optionally, remove the item from the DOM
                            $('[data-cart-id="' + cartId + '"]').closest('tr').remove();
                            // Optionally, refresh the cart or update the UI
                            window.location.reload(); // Reload page to reflect changes
                        } else {
                            alert(response.message); // Show error message
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });
    </script>




    <!-- javascript -->
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/slick/slick.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/countto/jquery.countTo.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/airdatepicker/datepicker.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/airdatepicker/i18n/datepicker.en.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/custom.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/rocket-loader.min.js" data-cf-settings="dea942b4e5104683ffff5739-|49" defer></script>

    <script>
        document.getElementById('backBtn').addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default link behavior
            history.back();
        });
    </script>

</body>

</html>