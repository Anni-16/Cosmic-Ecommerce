<?php include('admin/inc/config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | Numerology Website | Payement Error</title>
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
    
    <link rel="stylesheet" type="text/css" href="assets/css/failure-page.css" />

</head>

<body>
   
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
                                                <div class="ribbon-inner">Failed</div>
                                            </div>
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <h1 class="text-center">Payment Failed</h1>

                                                </div>

                                            </div>
                                            <hr>

                                            <div class="row table-row">
                                                <table class="table table-striped">
                                                    <p class="text-center">Payment Failed, but no error details were provided. Please try again or Contact Support. </td>
                                                    </p>

                                                </table>

                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-lg-12 margintop">
                                                    <div class="" style="display: flex; align-items: center;  justify-content: center; flex-direction: column;">

                                                        <a href="cart.php" class="btn " id="invoice-print" style="background-color:var(--primary-color); color:white;  margin: 0 auto;">
                                                            Try Again</a>
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