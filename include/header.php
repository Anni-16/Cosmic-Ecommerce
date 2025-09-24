<div class="main-header">
    <div class="top-header" style="background-color: var(--white2-color);  ">
        <div class="row" style="margin-bottom: 0;">
            <div class="col-lg-12">
                <div class="as_info_detail">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_contact WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);

                    if ($result) {
                        $address     = $result['address'];
                        $phone_no_1  = $result['phone_no_1'];
                        $phone_no_2  = $result['phone_no_2'];
                        $email       = $result['email'];
                        $map_links   = $result['map_links'];
                        $shop_time   = $result['shop_time'];
                    }
                    ?>

                    <ul>
                        <li>
                            <a href="tel:<?php echo ($phone_no_1); ?>">
                                <div class="as_infobox" style="color: var(--primary-color);">
                                    <span class="as_infoicon">
                                        <img src="./assets/my-images/chat-green.png" alt="" style="width: 20px;">
                                    </span>
                                    <?php echo ($phone_no_1); ?>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:<?php echo ($email); ?>">
                                <div class="as_infobox" style="color: var(--primary-color);">
                                    <span class="as_infoicon">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <span><?php echo ($email); ?></span>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div class="as_right_info">
                        <div class="as_share_box2">
                            <ul>
                                <?php
                                $i = 0;
                                $statement = $pdo->prepare("SELECT * FROM tbl_social WHERE status = 1");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($result as $row) {
                                    $i++;

                                ?>
                                    <li>
                                        <a href="<?php echo ($row['social_url']); ?>" target="_blank" style="background-color: var(--primary-color);">
                                            <i class="<?php echo ($row['social_icon']); ?>"></i>
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

    <!-- Header Start -->
    <section class="as_header_wrapper" style="background-color: var(--primary-color); background-size: cover; background-position: top;">
        <div class="as_logo" style="background-color: var(--primary-color); padding: 0 !important; margin: 0;" id="mobile-header-none2">
            <a href="index.php" style="display: block; padding: 0; margin: 0;">
                <img src="assets/my-images/new-logo2.png" alt="" style="width: 100%; " id="logo-hide-mobile">
                <img src="assets/images/logo.png" alt="" style="width: 100px;  " id="logo-show-mobile">
            </a>
        </div>
        <div class="as_header_detail" style="background: var(--primary-color);">
            <div class="as_menu_wrapper2" style="display: flex; justify-content: space-between; ">
                <span class="as_toggle bg_overlay" id="mobile-toggle">
                    <div class="" id="logo-show-mobile">
                        <img src="./assets/my-images/footer-logo.png" alt="" style="width: 70px; padding: 20px 0;">
                    </div>
                    <img src="assets/images/svg/menu.svg" alt="" class="as_cart_wrapper">
                </span>
                <div class="as_menu">

                    <style>
                        .as_header_detail ul li a {
                            color: var(--white2-color);
                            text-decoration: none;
                            transition: color 0.3s ease;
                        }

                        .as_header_detail ul li a.active {
                            color: #fff !important;
                            font-weight: 600;
                        }
                    </style>

                    <ul>

                        <?php
                        $current_page = basename($_SERVER['PHP_SELF']);
                        ?>

                        <li><a href="index.php" style="color: var(--white2-color);" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">Home</a></li>
                        <li><a href="numerology.php" style="color: var(--white2-color);" class="<?= ($current_page == 'numerology.php' || $current_page == 'numerology-detail.php') ? 'active' : '' ?>">Numerology</a>
                            <ul class="as_submenu">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_numerology WHERE status = 1 ORDER BY page_order ASC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($result as $row) {
                                ?>
                                    <li>
                                        <a href="numerology-detail.php?url=<?php echo $row['url']; ?>">
                                            <?php echo ($row['ser_name']); ?>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>

                        </li>
                        <li><a href="vaastu.php" style="color: var(--white2-color);" class="<?= ($current_page == 'vaastu.php' || $current_page == 'vaastu-detail.php') ? 'active' : '' ?>"> Vaastu</a>
                            <ul class="as_submenu">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_vaastu ORDER BY page_order ASC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                ?>
                                    <li>
                                        <a href="vaastu-detail.php?url=<?php echo $row['url']; ?>">
                                            <?= ($row['ser_name']);
                                            ?>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>

                        </li>
                        <li>
                            <a href="shop.php" style="color: var(--white2-color);" class="<?= ($current_page == 'shop.php' || $current_page == 'shop-category.php') ? 'active' : '' ?>">Products</a>
                            <ul class="as_submenu">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_product_category WHERE status = 1 ORDER BY cat_id DESC");
                                $statement->execute();
                                $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($categories as $category) {
                                ?>
                                    <li>
                                        <a href="shop-category.php?cat_url=<?php echo $category['cat_url']; ?>">
                                            <?php echo ($category['cat_name']); ?>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li><a href="blog.php" style="color: var(--white2-color);" class="<?= ($current_page == 'blog.php') ? 'active' : '' ?>">Blogs</a></li>
                        <li><a href="about.php" style="color: var(--white2-color);" class="<?= ($current_page == 'about.php') ? 'active' : '' ?>">about</a></li>
                        <li><a style="color: var(--white2-color);" class="<?= ($current_page == 'services.php') ? 'active' : '' ?>">Services</a>
                            <ul class="as_submenu">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_services WHERE status = 1 ORDER BY id DESC");
                                $statement->execute();
                                $servcies = $statement->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($servcies as $service) {
                                ?>
                                    <li>
                                        <a href="services.php?url=<?= $service['url']; ?>">
                                            <?= $service['ser_name']; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>

                        </li>
                        <li><a href="contact.php" style="color: var(--white2-color);" class="<?= ($current_page == 'contact.php') ? 'active' : '' ?>">contact</a></li>
                        <li><a href="news-events.php" style="color: var(--white2-color);" class="<?= ($current_page == 'news-events.php') ? 'active' : '' ?>">News & Events</a></li>
                    </ul>

                </div>

                <?php
                // Include database configuration
                include 'admin/inc/config.php';

                // Start session if not already started
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $session_id = session_id();
                if (empty($session_id)) {
                    die('Session not started.');
                }

                // Function to count total cart items
                function getCartItemCount($pdo, $session_id)
                {
                    // Check if $pdo is defined and valid
                    if (!isset($pdo) || !$pdo instanceof PDO) {
                        error_log('Database connection not available.', 3, 'errors.log');
                        return 0;
                    }

                    try {
                        $stmt = $pdo->prepare("SELECT COUNT(*) as item_count FROM tbl_cart WHERE session_id = ?");
                        $stmt->execute([$session_id]);
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        return $result['item_count'] ?? 0;
                    } catch (Exception $e) {
                        error_log('Cart Count Query Error: ' . $e->getMessage(), 3, 'errors.log');
                        return 0;
                    }
                }

                // Get cart count, only if $pdo is defined
                $cart_count = isset($pdo) ? getCartItemCount($pdo, $session_id) : 0;
                ?>

                <div class="as_right_info">
                    <div id="cart-my">
                        <div class="nav">
                            <div class="box">
                                <div class="cart-count"><?php echo ($cart_count); ?></div>
                                <img src="assets/images/svg/cart.svg" alt="" name="cart" id="cart-icon" style=" margin-top: -5px;">
                            </div>

                            <div class="cart">
                                <div class="cart-title">Cart Items</div>
                                <div class="cart-content">
                                    <!-- Cart items will be populated dynamically, e.g., via JavaScript or PHP -->
                                </div>

                                <div class="total">
                                    <div class="total-title">Total</div>
                                    <div class="total-price">Rs.0</div>
                                </div>

                                <a href="cart.php">
                                    <button id="button-cart" class="as_btn add-cart">Place Order</button>
                                </a>

                                <ion-icon name="close" id="cart-close"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="as_body_overlay"></span>
        </div>
    </section>
    <!-- Header End -->
</div>