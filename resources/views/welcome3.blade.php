<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Le Gourmet – Digital Menu</title>
    <meta name="description" content="Le Gourmet digital food & drink menu" />
    <link rel="shortcut icon" href="assets/img/favicon.png" />

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/all.min.css" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

    <!-- Custom styles -->
    <style>
        :root {
            --clr-primary: #ff6b00;
            --clr-primary-dark: #e05f00;
            --clr-secondary: #005eaa;
            --clr-bg: #f9f9f9;
            --radius: 10px;
            --shadow-sm: 0 2px 6px rgba(0, 0, 0, .08);
        }

        /* ======== Base ======== */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Inter", sans-serif;
            background: var(--clr-bg);
            color: #333;
            line-height: 1.55;
        }

        h1,
        h2,
        h3 {
            font-weight: 600;
        }

        /* ======== Header ======== */
        .menu-header {
            background: linear-gradient(135deg, var(--clr-primary) 0%, var(--clr-primary-dark) 100%);
            color: #fff;
            text-align: center;
            padding: 3.5rem 1rem;
            position: relative;
            overflow: hidden;
        }

        .menu-header::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 100%;
            height: 60px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1440 80"><path fill="%23f9f9f9" d="M0 0h1440v80L0 0z"/></svg>') no-repeat bottom center/cover;
        }

        .menu-logo {
            width: 140px;
        }

        .menu-name {
            font-size: 2.75rem;
            margin-top: 1rem;
            letter-spacing: .5px;
        }

        .tagline {
            font-size: 1.05rem;
            opacity: .9;
        }

        .contact-list {
            gap: 1.25rem;
            margin-top: 1.25rem;
        }

        .contact-list i {
            color: #fff;
            margin-right: .4rem;
        }

        /* ======== Category Tabs ======== */
        .category-nav .nav-link {
            border: 0;
            color: #555;
            font-weight: 500;
            padding: .6rem 1rem;
            margin: 0 .2rem;
            border-radius: var(--radius);
            transition: background .25s;
        }

        .category-nav .nav-link.active,
        .category-nav .nav-link:hover {
            background: var(--clr-primary);
            color: #fff;
        }

        /* ======== Menu Cards ======== */
        .menu-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 1.6rem;
            transition: transform .25s;
        }

        .menu-card:hover {
            transform: translateY(-4px);
        }

        .menu-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .menu-card-body {
            padding: 1rem 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .menu-card h3 {
            font-size: 1.1rem;
            margin-bottom: .25rem;
        }

        .price-badge {
            background: var(--clr-secondary);
            color: #fff;
            border-radius: var(--radius);
            padding: .25rem .75rem;
            font-weight: 600;
            font-size: .9rem;
        }

        /* ======== Footer ======== */
        .simple-footer {
            background: #202020;
            color: #aaa;
            padding: 1.75rem 0;
            text-align: center;
        }

        .simple-footer a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <!-- ===== HEADER ===== -->
    <header class="menu-header">
        <div class="container position-relative">
            <img src="assets/img/logo/logo.svg" alt="Le Gourmet Logo" class="menu-logo">
            <h1 class="menu-name">Le Gourmet</h1>
            <p class="tagline fst-italic">Fresh • Local • Delicious</p>

            <div class="d-flex flex-wrap justify-content-center contact-list">
                <span><i class="fa-solid fa-location-dot"></i>123 Main St, Casablanca</span>
                <span><i class="fa-solid fa-phone-volume"></i>+212 6 00 00 00 00</span>
                <span><i class="fa-regular fa-clock"></i>09:00 – 23:00</span>
            </div>
        </div>
    </header>

    <!-- ===== MENU SECTION ===== -->
    <section class="py-5">
        <div class="container">

            <!-- Category navigation -->
            <ul class="nav justify-content-center mb-4 category-nav" id="menuTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="fastfood-tab" data-bs-toggle="pill"
                        data-bs-target="#fastfood" type="button" role="tab" aria-controls="fastfood"
                        aria-selected="true"><i class="fa-solid fa-burger me-1"></i>Fast Food</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="drinks-tab" data-bs-toggle="pill" data-bs-target="#drinks"
                        type="button" role="tab" aria-controls="drinks" aria-selected="false"><i
                            class="fa-solid fa-martini-glass-citrus me-1"></i>Drink & Juice</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pizza-tab" data-bs-toggle="pill" data-bs-target="#pizza"
                        type="button" role="tab" aria-controls="pizza" aria-selected="false"><i
                            class="fa-solid fa-pizza-slice me-1"></i>Chicken Pizza</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pasta-tab" data-bs-toggle="pill" data-bs-target="#pasta"
                        type="button" role="tab" aria-controls="pasta" aria-selected="false"><i
                            class="fa-solid fa-bowl-food me-1"></i>Fresh Pasta</button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <!-- ========== FAST FOOD ========== -->
                <div class="tab-pane fade show active" id="fastfood" role="tabpanel" aria-labelledby="fastfood-tab">
                    <div class="row">
                        <!-- Item -->
                        <div class="col-md-6">
                            <div class="d-flex menu-card">
                                <img src="assets/img/menu/menuThumb1_1.png" alt>
                                <div class="menu-card-body flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3>Chinese Pasta</h3>
                                        <span class="price-badge">$15.99</span>
                                    </div>
                                    <p class="mb-0 text-muted">A fusion twist with wok-tossed veggies.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Repeat or loop dynamically as needed -->
                        <div class="col-md-6">
                            <div class="d-flex menu-card">
                                <img src="assets/img/menu/menuThumb1_2.png" alt>
                                <div class="menu-card-body flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3>Chicken Fried Rice</h3>
                                        <span class="price-badge">$25.99</span>
                                    </div>
                                    <p class="mb-0 text-muted">Classic street-style fried rice.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex menu-card">
                                <img src="assets/img/menu/menuThumb1_3.png" alt>
                                <div class="menu-card-body flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3>Chicken Pizza</h3>
                                        <span class="price-badge">$11.99</span>
                                    </div>
                                    <p class="mb-0 text-muted">Stone-baked, extra mozzarella.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex menu-card">
                                <img src="assets/img/menu/menuThumb1_4.png" alt>
                                <div class="menu-card-body flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3>Chicken Noodles</h3>
                                        <span class="price-badge">$14.50</span>
                                    </div>
                                    <p class="mb-0 text-muted">Egg noodles, shredded chicken, soy glaze.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========== DRINKS ========== -->
                <div class="tab-pane fade" id="drinks" role="tabpanel" aria-labelledby="drinks-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex menu-card">
                                <img src="assets/img/menu/menuThumb1_6.png" alt>
                                <div class="menu-card-body flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3>Mango Smoothie</h3>
                                        <span class="price-badge">$5.99</span>
                                    </div>
                                    <p class="mb-0 text-muted">Ripe mango, yogurt, honey drizzle.</p>
                                </div>
                            </div>
                        </div>
                        <!-- more drink items… -->
                    </div>
                </div>

                <!-- ========== PIZZA ========== -->
                <div class="tab-pane fade" id="pizza" role="tabpanel" aria-labelledby="pizza-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex menu-card">
                                <img src="assets/img/menu/menuThumb1_8.png" alt>
                                <div class="menu-card-body flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3>BBQ Chicken Pizza</h3>
                                        <span class="price-badge">$12.99</span>
                                    </div>
                                    <p class="mb-0 text-muted">Tangy BBQ sauce, grilled chicken, onions.</p>
                                </div>
                            </div>
                        </div>
                        <!-- more pizza items… -->
                    </div>
                </div>

                <!-- ========== PASTA ========== -->
                <div class="tab-pane fade" id="pasta" role="tabpanel" aria-labelledby="pasta-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex menu-card">
                                <img src="assets/img/menu/menuThumb1_9.png" alt>
                                <div class="menu-card-body flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3>Spinach Ricotta Ravioli</h3>
                                        <span class="price-badge">$13.49</span>
                                    </div>
                                    <p class="mb-0 text-muted">House-made ravioli in sage butter.</p>
                                </div>
                            </div>
                        </div>
                        <!-- more pasta items… -->
                    </div>
                </div>

            </div><!-- /.tab-content -->
        </div><!-- /.container -->
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="simple-footer">
        <div class="container">
            <p class="mb-2">&copy; 2025 Le Gourmet. All rights reserved.</p>
            <p class="mb-0 small">Made with <i class="fa-solid fa-heart"></i> in Nador</p>
        </div>
    </footer>

    <!-- JS (Bootstrap + dependencies) -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
