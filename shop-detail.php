<?php
require_once('admin/inc/config.php');

if (!isset($_GET['url']) || empty($_GET['url'])) {
    echo "Product not found.";
    exit;
}

$url = $_GET['url'];


$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE url = ? AND a_is_active = 1");
$statement->execute([$url]);
$product = $statement->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit;
}
$a_id = $product['a_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | <?= $product['a_name']; ?> | <?= $product['meta_title']; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="<?= $product['meta_title']; ?>">
    <meta name="keyword" content="<?= $product['meta_keyword']; ?>">
    <meta name="description" content="<?= $product['meta_descr']; ?>">
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
 
        .as_tab_wrapper .nav-tabs>li>button:hover,
        .as_tab_wrapper .nav-tabs>li>button {
            color: var(--primary-color);
        }

        .as_tab_wrapper .nav-tabs>li>button:hover,
        .as_tab_wrapper .nav-tabs>li>button.active {
            background-color: var(--primary-color) !important;
            color: var(--white-color);
        }

        .main-image {
            width: 100%;
            margin: 20px auto;
        }

        .big-image {
            width: 100%;
            overflow: hidden;
            cursor: zoom-in;
            border: 1px solid #ddd;
            position: relative;
        }

        .big-image img {
            width: 100%;
            display: block;
            transition: transform 0.3s ease;
        }

        .thumbnail-image {
            display: flex;
            align-items: center;
            margin-top: 15px;
            position: relative;
        }

        .thumb-slider-wrapper {
            overflow: hidden;
            width: 400px;
            /* 4 thumbnails * 100px each */
        }

        .thumb-slider {
            display: flex;
            transition: transform 0.3s ease;
        }

        .as_prod_img {
            flex: 0 0 100px;
            /* Thumbnail width */
            margin-right: 10px;
        }

        .thumb-img {
            width: 100px;
            height: auto;
            cursor: pointer;
        }

        .thumb-arrow {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .as_prod_img {
            flex: 0 0 auto;
            margin-right: 10px;
            border: 2px solid transparent;
            cursor: pointer;
            width: 80px;
        }

        .as_prod_img img.thumb-img {
            width: 100%;
            display: block;
        }

        .zoom-display {
            display: none;
            position: absolute;
            border: 1px solid #ccc;
            background-color: #fff;
            overflow: hidden;
            z-index: 999;
            background-repeat: no-repeat;
            background-size: 250%;
            /* or whatever zoom level you want */
        }


        .zoom-display img {
            position: absolute;
            pointer-events: none;
        }

        .zoom-container {
            position: relative;
            display: inline-block;
        }

        @media screen and (max-width:480px) {
            .zoom-container {
                display: none;
            }

            #cart-icons-2 {
                flex-direction: column;
                justify-content: center;
            }
        }

        @media screen and (max-width: 768px) {
            .zoom-display {
                position: absolute;
                left: 0 !important;
                right: 0;
                margin: 0 auto;
                top: auto;
            }

            .thumbnail-image {
                flex-wrap: wrap;
                justify-content: center;
            }

            .thumb-slider-wrapper {
                width: 100%;
                overflow-x: auto;
            }

            .thumb-slider {
                justify-content: start;
            }

            .thumb-arrow {
                display: none !important;
            }
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
                        <h1><?= $product['a_name']; ?></h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a href="shop.php" style="color: var(--primary-color); font-size:18px;  ">&nbsp; Products &nbsp;>> </a></li>
                            <li><a style="color: var(--primary-color); font-size:18px;  ">&nbsp; <?= $product['a_name']; ?> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        <section class="as_shopsingle_wrapper as_padderBottom80 as_padderTop80" style="background: var(--white-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="food-cart-box" data-product-id="<?php echo ($product['a_id']); ?>">
                            <div class="food-box">
                                <div class="pro-deatil product-content">
                                    <div class="row" style="background-color: white; border-radius: 20px; padding: 30px 30px;">

                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 col-sm-12">

                                                    <div class="main-image">
                                                        <div class="big-image zoom-container">
                                                            <img src="./admin/uploads/products/<?php echo ($product['a_photo']); ?>" alt="Big Image" class="img-responsive food-img" id="big-img" />
                                                        </div>

                                                        <div class="thumbnail-image">
                                                            <button class="thumb-arrow left">
                                                                <img src="./assets/my-images/my-arrow.png" alt="" style="transform: rotate(-180deg);">
                                                            </button>
                                                            <div class="thumb-slider-wrapper">
                                                                <div class="thumb-slider">
                                                                    <div class="as_prod_img"><img src="./admin/uploads/products/<?php echo ($product['a_photo']); ?>" alt="" class="img-responsive thumb-img"></div>
                                                                    <?php
                                                                    // Fetch additional photos for accessories
                                                                    $photo_query = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE a_id=?");
                                                                    $photo_query->execute([$product['a_id']]);
                                                                    $photos = $photo_query->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($photos as $photo) {
                                                                    ?>
                                                                        <!-- Dynamically loaded image with class -->
                                                                        <div class="as_prod_img"><img src="./admin/uploads/products/<?php echo $photo['photo']; ?>" alt="" class="img-responsive thumb-img"></div>
                                                                    <?php } ?>

                                                                </div>
                                                            </div>
                                                            <button class="thumb-arrow right"><img src="./assets/my-images/my-arrow.png" alt=""></button>
                                                        </div>

                                                    </div>
                                                    <!-- Zoom display container, place it anywhere on the page -->
                                                    <div class="zoom-display" id="zoom-display"></div>

                                                </div>

                                                <div class="col-lg-9 col-md-8 col-sm-12">
                                                    <div>
                                                        <div class="zoom-container" id="zoomContainer"></div>
                                                    </div>

                                                    <div class="as_product_description">
                                                        <h3 class="as_subheading as_margin0 as_padderBottom10 food-title">
                                                            <?php echo ($product['a_name']); ?></h3>
                                                        <h2 class="as_price food-price"> Price: ₹
                                                            <?php echo ($product['a_current_price']); ?> </h2>
                                                        <div class="product_rating as_padderBottom10">
                                                            <span class="ref_number as_font14" style="font-size: 18px;">Product Id :
                                                                <?php echo ($product['a_code']); ?></span>
                                                        </div>

                                                        <p class="as_font14 as_padderBottom10" style="color: var(--primary-color); font-size:18px !important;">
                                                            <?php echo nl2br(($product['a_short_desc'])); ?>
                                                        </p>

                                                        <div class="stock_details as_padderBottom10">
                                                            <span style="font-weight: bold;"><?php echo ($product['a_available']); ?></span>
                                                        </div>

                                                        <div class="" style="display: flex; gap:0 20px;" id="cart-icons-2">
                                                            <div class="prod_quantity as_padderBottom40">
                                                                Quantity
                                                                <div class="quantity" style="border:1px solid var(--secondary-color); color:var(--primary-color)">
                                                                    <button type="button" class="qty_button minus" id="qtyMinus" style="border-right:1px solid var(--secondary-color); color:var(--primary-color)">-</button>
                                                                    <input id="quantityInput" type="text" name="quantity" value="1" min="1" max="100" class="input-text form-control qty text border:1px solid var(--secondary-color); color:var(--primary-color)" title="Qty">
                                                                    <button type="button" class="qty_button plus" id="qtyPlus" style="border-left:1px solid var(--secondary-color); color:var(--primary-color)">+</button>
                                                                </div>
                                                            </div>
                                                            <div class="product_buy" style="margin-top: -18px; padding-top: 0;">
                                                                <form id="add-to-cart-form" method="POST">
                                                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($a_id) ?>">
                                                                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['a_name']) ?>">
                                                                    <input type="hidden" name="product_model" value="<?= htmlspecialchars($product['a_code']) ?>">
                                                                    <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['a_photo']) ?>">
                                                                    <input type="hidden" name="product_price" value="<?= htmlspecialchars($product['a_current_price']) ?>">
                                                                    <input type="hidden" name="quantity" id="formQuantity" value="1">
                                                                    <button type="submit" id="button-cart" data-loading-text="Loading..." class="as_btn" style="background: var(--secondary-color);  margin-top: 18px;" value="">Buy Now</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE a_is_active = 1 ORDER BY a_id DESC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                ?>

                                                <div class="col-lg-12">
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

                                                            </ul>
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

                    <!-- Tabs -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="as_tab_wrapper ">

                            <div class="tab-content" id="myTabContent" style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; padding:20px;">
                                <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="Today">
                                    <h3 class="as_subheading as_orange" style="background: var(--secondary-color); color:var(--primary-color); padding:20px; width:200px; text-align:center;">
                                        Description</h3>
                                    <p class="as_font14 as_padderBottom20" style="color: var(--primary-color); font-size:18px !important;">
                                        <?php echo nl2br(($product['a_content'])); ?>
                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End Tabs -->
                </div>
            </div>
        </section>

        <!-- Products Section Start -->
        <section class="as_product_wrapper as_padderBottom80 as_padderTop80" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center">Related Products</h1>
                        </p>

                        <div class="row as_product_slider" id="product-list">
                            <?php
                            $statement = $pdo->prepare(" SELECT * FROM tbl_product WHERE a_is_featured = 1 ORDER BY a_name ASC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($result as $row) {
                            ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="as_product_box product-card-animation" style="height:480px;">
                                        <div class="as_product_img product-img">
                                            <a href="shop-detail.php?url=<?php echo $row['url']; ?>">
                                                <img src="./admin/uploads/products/<?php echo $row['a_photo']; ?>" style="width: 400px;" alt="Product Image">
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
                                            <div class="show-animation" >
                                                <a href="shop-detail.php?url=<?php echo $row['url']; ?>" class="as_btn" style="background-color: var(--primary-color);">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
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

    <!-- Ensure jQuery is loaded -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Unbind any existing click handlers to prevent duplicates
            $(document).off('click', '#qtyMinus').off('click', '#qtyPlus');

            // Debounce function to prevent multiple rapid clicks
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            // Decrement button
            $(document).on('click', '#qtyMinus', debounce(function() {
                console.log('Minus button clicked'); // Debug
                let qty = parseInt($('#quantityInput').val()) || 1;
                if (qty > 1) {
                    qty--;
                    $('#quantityInput').val(qty);
                    if ($('#formQuantity').length) {
                        $('#formQuantity').val(qty);
                    } else {
                        console.warn('#formQuantity not found'); // Debug
                    }
                }
            }, 200));

            // Increment button
            $(document).on('click', '#qtyPlus', debounce(function() {
                console.log('Plus button clicked'); // Debug
                let qty = parseInt($('#quantityInput').val()) || 1;
                if (isNaN(qty)) {
                    console.warn('Invalid quantity value, defaulting to 1'); // Debug
                    qty = 1;
                }
                if (qty < 100) {
                    qty++;
                    $('#quantityInput').val(qty);
                    if ($('#formQuantity').length) {
                        $('#formQuantity').val(qty);
                    } else {
                        console.warn('#formQuantity not found'); // Debug
                    }
                } else {
                    console.log('Maximum quantity (100) reached'); // Debug
                }
            }, 200));

            // Handle direct input changes
            $(document).on('input', '#quantityInput', function() {
                console.log('Input changed:', $(this).val()); // Debug
                let inputVal = $(this).val();
                // Allow only numeric input
                if (!/^\d*$/.test(inputVal)) {
                    $(this).val(inputVal.replace(/[^0-9]/g, '')); // Remove non-numeric characters
                }
                let qty = parseInt($(this).val()) || 1;
                if (isNaN(qty) || qty < 1) qty = 1;
                if (qty > 100) qty = 100;
                $(this).val(qty);
                if ($('#formQuantity').length) {
                    $('#formQuantity').val(qty);
                } else {
                    console.warn('#formQuantity not found'); // Debug
                }
            });

            // Form submission
            $(document).on('submit', '#add-to-cart-form', function(e) {
                e.preventDefault();
                console.log('Form submitted'); // Debug
                let qty = parseInt($('#quantityInput').val()) || 1;
                if (isNaN(qty) || qty < 1) qty = 1;
                if (qty > 100) qty = 100;
                $('#quantityInput').val(qty);
                if ($('#formQuantity').length) {
                    $('#formQuantity').val(qty);
                } else {
                    console.warn('#formQuantity not found, appending quantity to form data'); // Debug
                }
                // Fallback: Append quantity to form data if #formQuantity is missing
                let formData = $(this).serialize();
                if (!$('#formQuantity').length) {
                    formData += '&quantity=' + qty;
                }
                console.log('Form data:', formData); // Debug
                $.ajax({
                    type: 'POST',
                    url: 'add-to-cart.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        console.log('AJAX Success:', response); // Debug
                        if (response.status === 'success') {
                            alert(response.message);
                            if (response.cart_count !== undefined) {
                                $('.cart-count').text(response.cart_count);
                                // Redirect to cart.php
                                window.location.href = 'cart.php';
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error); // Debug
                        alert('An error occurred. Please try again.');
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
    <script src="assets/js/cart.js"></script>
    <script src="assets/js/rocket-loader.min.js" data-cf-settings="dea942b4e5104683ffff5739-|49" defer></script>

    <script>
        const slider = document.querySelector('.thumb-slider');
        const thumbnails2 = Array.from(slider.children);
        const leftArrow = document.querySelector('.thumb-arrow.left');
        const rightArrow = document.querySelector('.thumb-arrow.right');

        const thumbnailWidth = 110; // width + margin, adjust if needed

        // Clone thumbnails2 to both ends
        thumbnails2.forEach(thumb => {
            const clone = thumb.cloneNode(true);
            slider.appendChild(clone);
        });
        thumbnails2.slice().reverse().forEach(thumb => {
            const clone = thumb.cloneNode(true);
            slider.insertBefore(clone, slider.firstChild);
        });

        // Updated list including clones
        const allThumbs = Array.from(slider.children);

        let currentIndex = thumbnails2.length; // start at first original

        // Position slider to show original thumbnails2 in the middle
        slider.style.transform = `translateX(${-currentIndex * thumbnailWidth}px)`;

        function scrollRight() {
            currentIndex++;
            slider.style.transition = 'transform 0.3s ease';
            slider.style.transform = `translateX(${-currentIndex * thumbnailWidth}px)`;

            if (currentIndex >= thumbnails2.length * 2) {
                // After animation reset position to original instantly
                setTimeout(() => {
                    slider.style.transition = 'none';
                    currentIndex = thumbnails2.length;
                    slider.style.transform = `translateX(${-currentIndex * thumbnailWidth}px)`;
                }, 300);
            }
        }

        function scrollLeft() {
            currentIndex--;
            slider.style.transition = 'transform 0.3s ease';
            slider.style.transform = `translateX(${-currentIndex * thumbnailWidth}px)`;

            if (currentIndex < thumbnails2.length) {
                setTimeout(() => {
                    slider.style.transition = 'none';
                    currentIndex = thumbnails2.length * 2 - 1;
                    slider.style.transform = `translateX(${-currentIndex * thumbnailWidth}px)`;
                }, 300);
            }
        }

        leftArrow.addEventListener('click', scrollLeft);
        rightArrow.addEventListener('click', scrollRight);
    </script> 
    <script>
        const bigImg = document.getElementById('big-img');
        const zoomDisplay = document.getElementById('zoom-display');
        const zoomFactor = 2.5;
        let zoomActive = false;

        function setZoomContainerToBigImage() {
            const rect = bigImg.getBoundingClientRect();
            const scrollTop = window.scrollY;
            zoomDisplay.style.width = rect.width + 'px';
            zoomDisplay.style.height = rect.height + 'px';
            zoomDisplay.style.top = (rect.top + scrollTop) + 'px';
            if (window.innerWidth > 768) {
                // Desktop: place to the right
                zoomDisplay.style.left = (rect.left + rect.width + 20) + 'px';
            } else {
                // Mobile: place below the image
                zoomDisplay.style.left = rect.left + 'px';
                zoomDisplay.style.top = (rect.top + scrollTop + rect.height + 10) + 'px'; // 10px below image
            }
        }
        // Zoom tracking
        function updateZoom(e) {
            if (!zoomActive) return;
            const rect = bigImg.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xPercent = x / rect.width;
            const yPercent = y / rect.height;
            const bgX = xPercent * 100;
            const bgY = yPercent * 100;
            zoomDisplay.style.backgroundPosition = `${bgX}% ${bgY}%`;
        }
        // Load zoom image
        bigImg.addEventListener('load', () => {
            zoomDisplay.style.backgroundImage = `url('${bigImg.src}')`;
            setZoomContainerToBigImage();
        });
        // Resize listener
        window.addEventListener('resize', setZoomContainerToBigImage);
        // Zoom enter
        bigImg.addEventListener('mouseenter', () => {
            zoomActive = true;
            zoomDisplay.style.display = 'block';
            zoomDisplay.style.backgroundImage = `url('${bigImg.src}')`;
            zoomDisplay.style.backgroundSize = `${zoomFactor * 100}%`;
            setZoomContainerToBigImage();
        });
        // Zoom leave
        bigImg.addEventListener('mouseleave', () => {
            zoomActive = false;
            zoomDisplay.style.display = 'none';
        });
        // Move zoom area
        bigImg.addEventListener('mousemove', updateZoom);
        // Thumbnail switch
        const thumbnails = document.querySelectorAll('.thumb-img');
        thumbnails.forEach((thumb) => {
            thumb.addEventListener('click', () => {
                thumbnails.forEach((t) => t.parentElement.classList.remove('active'));
                thumb.parentElement.classList.add('active');
                bigImg.src = thumb.src;
                setTimeout(() => {
                    zoomDisplay.style.backgroundImage = `url('${thumb.src}')`;
                    setZoomContainerToBigImage();
                }, 100);
            });
        });
    </script>


</body>

</html>