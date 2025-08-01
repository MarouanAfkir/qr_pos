<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Le Gourmet – Digital Menu built on Fresheat theme resources" />

    <title>Le Gourmet | Digital Menu</title>
    <link rel="shortcut icon" href="assets/img/favicon.png" />

    <!-- Theme core styles (unchanged) -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/css/magnific-popup.css" />
    <link rel="stylesheet" href="assets/css/meanmenu.css" />
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/nice-select.css" />
    <link rel="stylesheet" href="assets/css/main.css" />

    <!-- Minimal extra tweaks (only colors / cards) -->
    <style>
        /* ===== HERO ===== */
        .digital-hero {
            background-image: linear-gradient(135deg, #ff6400 0%, #ff4700 100%);
            position: relative;
            color: #fff;
            padding: 4.5rem 0 5rem;
            overflow: hidden;
        }

        .digital-hero .shape-burger,
        .digital-hero .shape-fry {
            position: absolute;
            opacity: 0.15;
            animation: float 7s ease-in-out infinite;
        }

        .shape-burger {
            top: -60px;
            left: -60px;
        }

        .shape-fry {
            right: -70px;
            bottom: -70px;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(22px)
            }
        }

        .digital-hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        /* ===== MENU CARD ===== */
        .menu-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 7px rgba(0, 0, 0, .08);
            overflow: hidden;
            transition: .25s ease;
            margin-bottom: 2rem;
        }

        .menu-card:hover {
            transform: translateY(-4px);
        }

        .menu-thumb {
            width: 110px;
            height: 110px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .price-badge {
            background: #ff4700;
            color: #fff;
            padding: .25rem .75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: .9rem;
            white-space: nowrap;
        }

        /* ===== FOOTER ===== */
        .simple-footer {
            background: #131313;
            color: #9b9b9b;
            padding: 2rem 0;
            text-align: center;
        }

        .simple-footer a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>

<body class="bg-color2">

    <!-- ===== HERO / HEADER ===== -->
    <header class="digital-hero">
        <!-- Floating theme shapes -->
        <img src="assets/img/shape/burger-shape.png" alt class="shape-burger d-none d-md-block" />
        <img src="assets/img/shape/fry-shape.png" alt class="shape-fry d-none d-md-block" />

        <!-- Content -->
        <div class="container text-center position-relative z-index-2">
            <img src="assets/img/logo/logoWhite.svg" alt="Le Gourmet" class="mb-3 wow fadeInDown"
                data-wow-delay=".1s" style="width:160px" />

            <h1 class="wow fadeInUp" data-wow-delay=".2s">Le Gourmet</h1>
            <p class="fs-5 fst-italic text-white-50 wow fadeInUp" data-wow-delay=".3s">Fresh • Local • Delicious</p>

            <div class="d-flex flex-wrap justify-content-center gap-3 mt-3 wow fadeInUp" data-wow-delay=".4s">
                <span><i class="fa-solid fa-location-dot me-1"></i>123 Main St, Casablanca</span>
                <span><i class="fa-solid fa-phone-volume me-1"></i>+212 6 00 00 00 00</span>
                <span><i class="fa-regular fa-clock me-1"></i>09:00 – 23:00</span>
            </div>
        </div>
    </header>

    <!-- ===== MENU ===== -->
    <section class="food-menu-section section-padding fix">
        <div class="burger-shape"><img src="assets/img/shape/burger-shape.png" alt></div>
        <div class="fry-shape"><img src="assets/img/shape/fry-shape.png" alt></div>

        <div class="food-menu-wrapper style1">
            <div class="container">

                <!-- Title -->
                <div class="title-area text-center">
                    <div class="sub-title wow fadeInUp" data-wow-delay=".2s">
                        <img src="assets/img/icon/titleIcon.svg" class="me-1" alt>OUR MENU
                        <img src="assets/img/icon/titleIcon.svg" class="ms-1" alt>
                    </div>
                    <h2 class="title wow fadeInUp" data-wow-delay=".3s">Taste the Difference</h2>
                </div>

                <!-- Tabs -->
                <div class="food-menu-tab mt-4">
                    <ul class="nav nav-pills justify-content-center mb-4" id="menuTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="fastfood-tab" data-bs-toggle="pill"
                                data-bs-target="#fastfood" type="button" role="tab" aria-controls="fastfood"
                                aria-selected="true"><img src="assets/img/menu/menuIcon1_1.png" alt>Fast Food</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="drinks-tab" data-bs-toggle="pill" data-bs-target="#drinks"
                                type="button" role="tab" aria-controls="drinks" aria-selected="false"><img
                                    src="assets/img/menu/menuIcon1_2.png" alt>Drinks</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pizza-tab" data-bs-toggle="pill" data-bs-target="#pizza"
                                type="button" role="tab" aria-controls="pizza" aria-selected="false"><img
                                    src="assets/img/menu/menuIcon1_3.png" alt>Pizza</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pasta-tab" data-bs-toggle="pill" data-bs-target="#pasta"
                                type="button" role="tab" aria-controls="pasta" aria-selected="false"><img
                                    src="assets/img/menu/menuIcon1_4.png" alt>Pasta</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="menuTabsContent">
                        <!-- === FAST FOOD === -->
                        <div class="tab-pane fade show active" id="fastfood" role="tabpanel"
                            aria-labelledby="fastfood-tab">
                            <div class="row">
                                <!-- Card -->
                                <div class="col-md-6">
                                    <div class="d-flex menu-card">
                                        <img src="assets/img/menu/menuThumb1_1.png" alt class="menu-thumb">
                                        <div class="flex-grow-1 p-3">
                                            <div
                                                class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                <h3>Chinese Pasta</h3>
                                                <span class="price-badge">$15.99</span>
                                            </div>
                                            <p class="mb-0 text-muted">Wok-tossed noodles with veggies.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Repeat … -->
                                <div class="col-md-6">
                                    <div class="d-flex menu-card">
                                        <img src="assets/img/menu/menuThumb1_2.png" alt class="menu-thumb">
                                        <div class="flex-grow-1 p-3">
                                            <div
                                                class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                <h3>Chicken Fried Rice</h3>
                                                <span class="price-badge">$25.99</span>
                                            </div>
                                            <p class="mb-0 text-muted">Street-style classic with soy glaze.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add more cards or loop server-side -->
                            </div>
                        </div>

                        <!-- === DRINKS === -->
                        <div class="tab-pane fade" id="drinks" role="tabpanel" aria-labelledby="drinks-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex menu-card">
                                        <img src="assets/img/menu/menuThumb1_6.png" alt class="menu-thumb">
                                        <div class="flex-grow-1 p-3">
                                            <div
                                                class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                <h3>Mango Smoothie</h3>
                                                <span class="price-badge">$5.99</span>
                                            </div>
                                            <p class="mb-0 text-muted">Ripe mango, yogurt & honey.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- … -->
                            </div>
                        </div>

                        <!-- === PIZZA === -->
                        <div class="tab-pane fade" id="pizza" role="tabpanel" aria-labelledby="pizza-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex menu-card">
                                        <img src="assets/img/menu/menuThumb1_8.png" alt class="menu-thumb">
                                        <div class="flex-grow-1 p-3">
                                            <div
                                                class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                <h3>BBQ Chicken Pizza</h3>
                                                <span class="price-badge">$12.99</span>
                                            </div>
                                            <p class="mb-0 text-muted">Grilled chicken, smoky BBQ sauce.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- … -->
                            </div>
                        </div>

                        <!-- === PASTA === -->
                        <div class="tab-pane fade" id="pasta" role="tabpanel" aria-labelledby="pasta-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex menu-card">
                                        <img src="assets/img/menu/menuThumb1_9.png" alt class="menu-thumb">
                                        <div class="flex-grow-1 p-3">
                                            <div
                                                class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                <h3>Spinach Ricotta Ravioli</h3>
                                                <span class="price-badge">$13.49</span>
                                            </div>
                                            <p class="mb-0 text-muted">Sage-butter finish, house-made pasta.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- … -->
                            </div>
                        </div>
                    </div><!-- /.tab-content -->
                </div><!-- /.food-menu-tab -->
            </div><!-- /.container -->
        </div><!-- /.food-menu-wrapper -->
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="simple-footer">
        <div class="container">
            <p class="mb-2">&copy; 2025 Le Gourmet. All rights reserved.</p>
            <p class="mb-0 small">Made with <i class="fa-solid fa-heart"></i> in Nador</p>
        </div>
    </footer>

    <!-- Theme JS files -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.waypoints.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/viewport.jquery.js"></script>
    <script src="assets/js/magnific-popup.min.js"></script>
    <script src="assets/js/tilt.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/jquery.meanmenu.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/nice-select.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
