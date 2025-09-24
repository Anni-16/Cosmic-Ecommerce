<?php include('admin/inc/config.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get session ID
$session_id = session_id();
if (empty($session_id)) {
    die('Session not started.');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | Numerology Website | Shop</title>
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
    
    <link rel="stylesheet" type="text/css" href="assets/css/shop-page.css" />
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
                        <h1>Shop</h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a href="shop.php" style="color: var(--primary-color); font-size:18px;  ">&nbsp; Products </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>



        <!-- Products Section Start -->
        <section class="as_product_wrapper as_padderBottom80 as_padderTop80" style="background: var(--white-color);">
            <div class="container">
                <div class="row d-flex justify-content-center"> 
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE a_is_active = 1 ORDER BY a_id DESC");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <div class="col-lg-3">
                        <div class="as_blog_sidebar " style="padding-top: 30px;">
                            <div class="as_service_widget as_padderBottom40" style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; padding:20px;">
                                <h3 class="as_heading">Filter Results By</h3>
                                <ul class="numerology-list">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_product_category WHERE status = 1 ORDER BY cat_id DESC");
                                    $statement->execute();
                                    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($categories as $category) {
                                    ?>
                                        <li style="font-size:18px; ">
                                            <a href="shop-category.php?cat_url=<?php echo $category['cat_url']; ?>" style="color:var(--primary-color)">
                                                <?php echo ($category['cat_name']); ?>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <li style="font-size:18px;">
                                        <a style="padding-bottom: 10px;">Price Filter</a>
                                        <div class="range-slider">
                                            <input value="233" min="0" max="10000" step="500" type="range" />
                                            <input value="6666" min="0" max="10000" step="500" type="range" />
                                            <span>
                                                <input type="number" value="100" min="0" max="10000" style="color: var(--primary-color);" />
                                                &nbsp; To &nbsp;
                                                <input type="number" value="1000" min="0" max="10000" style="color: var(--primary-color);" />
                                            </span>
                                        </div>
                                        <div class="btn btn-primary" style="width: 100%; margin-top:30px; background:var(--primary-color); border:1px solid var(--primary-color); ">
                                            Search</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 text-center">
                    
                        <style>
                             #sortby {
                                border:1px solid var(--primary-color);
                                color: var(--primary-color);
                                /* color: var(--primary-color);
                                background-color: var(--secondary-color); */
                                text-align: center;
                            }
                        </style>
                    

                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="item-filter">
                                    <ul class="item-short-area" style="display: flex; justify-content:flex-end">
                                        <p style="padding-top: 10px;"> Sort By : &nbsp;</p>
                                        <select id="sortby" name="sort" class="short-item" style="text-align: center; ">
                                            <option value="default">Default</option>
                                            <option value="price_asc">Lowest Price</option>
                                            <option value="price_desc">Highest Price</option>
                                            <option value="name_asc">A to Z</option>
                                            <option value="name_desc">Z to A</option>
                                        </select>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <style>
                        .as_btn:before { 
                            border-right: 15px solid var(--primary-color) !important;
                        }

                        .as_btn:after, .as_btn:before { 
                            border-left: 15px solid var(--primary-color); 
                        }
                    </style>


                        <div class="row " id="product-list">
                            <?php foreach ($result as $row) : ?>
                                <div class="col-lg-4 col-md-6" >
                                    <div class="as_product_box product-card-animation" style="height:480px;">
                                        <div class="as_product_img product-img">
                                            <a href="shop-detail.php?url=<?php echo $row['url']; ?>">
                                                <img src="./admin/uploads/products/<?php echo $row['a_photo']; ?>" style="width: 400px;" alt="<?php echo $row['a_name']; ?>">
                                            </a>
                                        </div>
                                        <div class="text-center hover-hide">
                                            <h4 class="as_subheading">
                                                <a href="shop-detail.php?url=<?php echo $row['url']; ?>">
                                                    <?php echo $row['a_name']; ?>
                                                </a>
                                            </h4>
                                            <span class="as_price">₹ <?php echo $row['a_current_price']; ?></span>
                                            
                                        </div>
                                        <div class="text-layer">
                                            <h4 class="as_subheading">
                                                <a href="shop-detail.php?url=<?php echo $row['url']; ?>">
                                                    <?php echo $row['a_name']; ?>
                                                </a>
                                            </h4> 
                                            <span class="as_price">₹ <?php echo $row['a_current_price']; ?></span>
                                            <div class="show-animation" id="show-button">
                                                <a href="shop-detail.php?url=<?php echo $row['url']; ?>" class="as_btn" style="background-color: var(--primary-color);">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
    </div>
    </section>

    <!-- Products Section End -->

    <!-- Footer Section Start -->
    <?php include('include/footer.php'); ?>
    <!-- Footer Copyright Section End  -->

    </div>

    <!-- javascript -->
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/slick/slick.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/countto/jquery.countTo.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/airdatepicker/datepicker.min.js" type="dea942b4e5104683ffff5739-text/javascript">
    </script>
    <script src="assets/js/plugin/airdatepicker/i18n/datepicker.en.js" type="dea942b4e5104683ffff5739-text/javascript">
    </script>
    <script src="assets/js/custom.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/rocket-loader.min.js" data-cf-settings="dea942b4e5104683ffff5739-|49" defer></script>

    <script>
        (function() {
            var parent = document.querySelector(".range-slider");
            if (!parent) return;
            var
                rangeS = parent.querySelectorAll("input[type=range]"),
                numberS = parent.querySelectorAll("input[type=number]");
            rangeS.forEach(function(el) {
                el.oninput = function() {
                    var slide1 = parseFloat(rangeS[0].value),
                        slide2 = parseFloat(rangeS[1].value);
                    if (slide1 > slide2) {
                        [slide1, slide2] = [slide2, slide1];
                        // var tmp = slide2;
                        // slide2 = slide1;
                        // slide1 = tmp;
                    }
                    numberS[0].value = slide1;
                    numberS[1].value = slide2;
                }
            });
            numberS.forEach(function(el) {
                el.oninput = function() {
                    var number1 = parseFloat(numberS[0].value),
                        number2 = parseFloat(numberS[1].value);
                    if (number1 > number2) {
                        var tmp = number1;
                        numberS[0].value = number2;
                        numberS[1].value = tmp;
                    }
                    rangeS[0].value = number1;
                    rangeS[1].value = number2;
                }
            });
        })();
    </script>

    <!-- Product Filter -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const select = document.getElementById('sortby');
            const container = document.getElementById('product-list');
            const originalItems = Array.from(container.children); // Keep original order for "default"
            select.addEventListener('change', function() {
                const value = this.value;
                let items = Array.from(container.children);
                if (value === 'price_asc') {
                    items.sort((a, b) => getPrice(a) - getPrice(b));
                } else if (value === 'price_desc') {
                    items.sort((a, b) => getPrice(b) - getPrice(a));
                } else if (value === 'name_asc') {
                    items.sort((a, b) => getName(a).localeCompare(getName(b)));
                } else if (value === 'name_desc') {
                    items.sort((a, b) => getName(b).localeCompare(getName(a)));
                } else if (value === 'default') {
                    items = originalItems;
                }
                container.innerHTML = '';
                items.forEach(item => container.appendChild(item));
            });

            function getPrice(el) {
                const priceText = el.querySelector('.as_price').textContent.replace(/[^\d.]/g, '');
                return parseFloat(priceText) || 0;
            }

            function getName(el) {
                return el.querySelector('.as_subheading').textContent.trim().toLowerCase();
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productContainer = document.getElementById('product-list');
            const products = Array.from(productContainer.querySelectorAll('.col-lg-4'));
            // Price Filter Elements
            const priceMinInput = document.querySelector('.range-slider input[type="number"]:first-child');
            const priceMaxInput = document.querySelector('.range-slider input[type="number"]:last-child');
            const searchBtn = document.querySelector('.btn.btn-primary');
            // Handle Price Filter on Search Button Click
            searchBtn.addEventListener('click', function() {
                const min = parseFloat(priceMinInput.value) || 0;
                const max = parseFloat(priceMaxInput.value) || 10000;
                products.forEach(product => {
                    const priceText = product.querySelector('.as_price').textContent.replace(
                        /[^\d.]/g, '');
                    const price = parseFloat(priceText);
                    if (price >= min && price <= max) {
                        product.style.display = '';
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
            // Optional: Sync range sliders with number inputs
            const sliders = document.querySelectorAll('.range-slider input[type="range"]');
            sliders[0].addEventListener('input', () => {
                priceMinInput.value = sliders[0].value;
            });
            sliders[1].addEventListener('input', () => {
                priceMaxInput.value = sliders[1].value;
            });
            priceMinInput.addEventListener('input', () => {
                sliders[0].value = priceMinInput.value;
            });
            priceMaxInput.addEventListener('input', () => {
                sliders[1].value = priceMaxInput.value;
            });
        });
    </script>

</body>

</html>