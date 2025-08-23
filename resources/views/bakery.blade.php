<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">

<head>
    <!-- ===== META ===== -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description"
        content="Crustella — Premium café & bakery template: signature menu, online ordering CTAs, services, gallery, testimonials, dark mode, and event coffee-stand booking." />
    <meta name="theme-color" content="#C46E3A" />
    <title>Crustella — Café & Bakery</title>
    <link rel="icon" href="assets/img/favicon.png" />

    <!-- Early theme init (prevents flash & fixes toggle reliability) -->
    <script>
        (function() {
            try {
                var saved = localStorage.getItem('theme');
                if (saved) document.documentElement.setAttribute('data-bs-theme', saved);
            } catch (e) {}
        })();
    </script>

    <!-- ===== FONTS & CSS ===== -->
    <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

    <style>
        /* ============================================================
       Warm café palette + creamy UI
    ============================================================ */
        :root {
            --accent: #C46E3A;
            --accent-600: #A75B2F;
            --accent-700: #8F4E29;
            --cocoa: #5A3E2B;
            --bg: #FFF7EF;
            --muted: #6B7280;
            --surface: #FFFFFF;
            --surface-2: #FFF2E5;
            --border: #EADFD5;
            --ring: rgba(196, 110, 58, .25);
            --radius: 18px;
            --shadow-1: 0 6px 20px rgba(2, 6, 23, .06);
            --shadow-2: 0 16px 40px rgba(2, 6, 23, .10);
            --success: #16a34a;
        }

        [data-bs-theme="dark"] {
            --bg: #0E1114;
            --surface: #12161B;
            --surface-2: #10141A;
            --border: #222A35;
            --muted: #9AA3AF;
            --cocoa: #E6E6E6;
            --shadow-1: 0 6px 20px rgba(0, 0, 0, .35);
            --shadow-2: 0 16px 40px rgba(0, 0, 0, .45);
        }

        html {
            scroll-behavior: smooth
        }

        body {
            font-family: 'Manrope', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            color: var(--cocoa);
            background: radial-gradient(900px 480px at 80% -10%, rgba(196, 110, 58, .08), transparent 60%), var(--bg);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Inter', sans-serif;
            letter-spacing: -.015em;
            font-weight: 800
        }

        .text-muted {
            color: var(--muted) !important
        }

        section {
            scroll-margin-top: 96px
        }

        /* Skeleton shimmer */
        .skel {
            position: relative;
            overflow: hidden;
            border-radius: 14px;
            background: #eee
        }

        [data-bs-theme="dark"] .skel {
            background: #1a1f26
        }

        .skel::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .25), transparent);
            animation: shimmer 1.35s linear infinite;
        }

        .skel.loaded::before {
            opacity: 0;
            visibility: hidden
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%)
            }

            100% {
                transform: translateX(100%)
            }
        }

        /* Buttons */
        .btn-primary {
            --bs-btn-bg: var(--accent);
            --bs-btn-border-color: var(--accent);
            --bs-btn-hover-bg: var(--accent-600);
            --bs-btn-hover-border-color: var(--accent-600);
            border-radius: 12px;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(196, 110, 58, .22)
        }

        .btn-outline-primary {
            --bs-btn-color: var(--accent);
            --bs-btn-border-color: var(--accent);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: var(--accent);
            --bs-btn-hover-border-color: var(--accent);
            border-radius: 12px;
            font-weight: 700
        }

        .btn-light {
            border-radius: 12px;
            font-weight: 700
        }

        /* Utility bar */
        .nav-utility {
            border-bottom: 1px solid var(--border);
            background: linear-gradient(90deg, #FFF1E6, #FFEADB)
        }

        [data-bs-theme="dark"] .nav-utility {
            background: linear-gradient(90deg, #171c22, #12171e)
        }

        .nav-utility .link-utility {
            color: var(--cocoa);
            text-decoration: none
        }

        .nav-utility .link-utility:hover {
            text-decoration: underline
        }

        /* Navbar */
        .nav-elevated {
            position: sticky;
            top: 0;
            z-index: 1040;
            background: rgba(255, 255, 255, .86);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            transition: background .25s ease, box-shadow .25s ease, padding .2s ease;
            padding: .7rem 0;
        }

        [data-bs-theme="dark"] .nav-elevated {
            background: rgba(16, 19, 24, .85)
        }

        .nav-elevated.scrolled {
            background: var(--surface);
            box-shadow: 0 10px 28px rgba(0, 0, 0, .06);
            padding: .45rem 0;
        }

        #scrollProgress {
            position: absolute;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, var(--accent), #FFB680);
            border-bottom-right-radius: 3px;
            border-top-right-radius: 3px;
            transition: width .15s ease;
        }

        .navbar .nav-link {
            font-weight: 600;
            padding: .45rem .8rem;
            border-radius: 999px;
            color: var(--cocoa)
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            background: rgba(196, 110, 58, .10)
        }

        .navbar .nav-link:focus-visible {
            outline: 0;
            box-shadow: 0 0 0 4px var(--ring)
        }

        /* Mega dropdown (centered) */
        .dropdown.position-static .dropdown-menu.mega {
            display: block;
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
            transform: translate(-50%, 8px);
            left: 50% !important;
            top: 100% !important;
            transition: opacity .15s ease;
        }

        .dropdown.position-static.show .dropdown-menu.mega {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
        }

        .dropdown-menu.mega {
            min-width: 760px;
            max-width: 980px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: var(--surface);
            box-shadow: var(--shadow-2);
            padding: 1rem;
        }

        .mega .mega-link {
            color: var(--cocoa);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem
        }

        .mega .mega-link:hover {
            text-decoration: underline
        }

        .mega .seasonal-card {
            display: flex;
            align-items: center;
            gap: .75rem
        }

        .mega .seasonal-card img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 12px
        }

        /* Search under nav */
        .nav-search {
            border-top: 1px solid var(--border);
            background: rgba(255, 255, 255, .86);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px)
        }

        [data-bs-theme="dark"] .nav-search {
            background: rgba(16, 19, 24, .85)
        }

        .nav-search-form {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .75rem 0
        }

        .nav-search-input {
            border-radius: 12px;
            border: 1px solid var(--border)
        }

        /* Hero */
        .hero {
            position: relative;
            padding: 72px 0 56px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, rgba(255, 215, 190, .55), rgba(255, 240, 225, .4)), var(--bg);
            isolation: isolate
        }

        .hero .bg-img {
            position: absolute;
            inset: 0;
            z-index: -1;
            opacity: .35;
            background-size: cover;
            background-position: center;
            filter: contrast(1.05) saturate(1.05)
        }

        [data-bs-theme="dark"] .hero .bg-img {
            opacity: .25
        }

        .hero .badge-soft {
            background: #fff;
            color: var(--accent);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .42rem .75rem;
            font-weight: 700;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .06)
        }

        /* Cards */
        .card-soft {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-1)
        }

        .feature {
            padding: 1.25rem;
            transition: transform .18s ease, box-shadow .18s ease
        }

        .feature:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-2)
        }

        .feature .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: var(--accent);
            background: rgba(196, 110, 58, .12);
            border: 1px solid var(--border);
            font-size: 1.25rem;
            margin-bottom: .6rem
        }

        /* Menu filter */
        .menu .nav-link {
            border-radius: 10px;
            font-weight: 700;
            color: var(--muted)
        }

        .menu .nav-link.active {
            color: var(--cocoa);
            background: rgba(196, 110, 58, .10);
            border: 1px solid rgba(196, 110, 58, .28)
        }

        /* Promo */
        .promo {
            background: var(--surface-2);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 46px 0
        }

        /* Reviews */
        .reviews .review-card {
            padding: 1.25rem
        }

        .reviews .avatar {
            border-radius: 50%;
            object-fit: cover
        }

        .reviews .source-badge {
            display: inline-block;
            font-size: .75rem;
            padding: .25rem .5rem;
            border-radius: 6px;
            background: rgba(196, 110, 58, .12);
            border: 1px solid var(--border);
            color: var(--cocoa)
        }

        .reviews .carousel-indicators {
            position: static;
            margin-top: 1rem;
            gap: .5rem
        }

        .reviews .carousel-indicators button {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: #fff;
            overflow: hidden
        }

        [data-bs-theme="dark"] .reviews .carousel-indicators button {
            background: #0f141c
        }

        .reviews .carousel-indicators img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 50%
        }

        .review-nav .btn {
            border-radius: 999px;
            padding: .35rem .9rem;
            font-weight: 700
        }

        .review-nav .btn i {
            vertical-align: -1px
        }

        /* Services */
        .service-card {
            padding: 1.25rem
        }

        .service-card .badge {
            background: rgba(196, 110, 58, .12);
            color: var(--accent);
            border: 1px solid var(--border)
        }

        /* Booking form (enhanced) */
        .stand-card {
            padding: 1.25rem
        }

        .chip-group {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem
        }

        .chip {
            position: relative
        }

        .chip input {
            position: absolute;
            opacity: 0;
            inset: 0;
            cursor: pointer
        }

        .chip label {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .5rem .8rem;
            border: 1px solid var(--border);
            border-radius: 999px;
            cursor: pointer;
            user-select: none
        }

        .chip input:checked+label {
            border-color: var(--accent);
            background: rgba(196, 110, 58, .10)
        }

        .input-icon {
            position: relative
        }

        .input-icon i {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: .6
        }

        .input-icon input {
            padding-left: 2rem
        }

        .estimate-pill {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .35rem .7rem;
            border-radius: 999px;
            border: 1px dashed var(--border);
            background: var(--surface-2)
        }

        /* CTA / Footer */
        .cta {
            background: linear-gradient(135deg, #FFEBDD, #FFF6EE);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 64px 0
        }

        [data-bs-theme="dark"] .cta {
            background: linear-gradient(135deg, #141b23, #0f141c)
        }

        .site-footer {
            background: var(--surface);
            border-top: 1px solid var(--border)
        }

        .mobile-cta {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1050;
            display: none;
            gap: .7rem;
            align-items: center;
            justify-content: space-between;
            padding: .7rem .9rem;
            background: var(--surface);
            border-top: 1px solid var(--border);
            box-shadow: 0 -8px 24px rgba(0, 0, 0, .08)
        }

        @media (max-width: 991.98px) {
            .mobile-cta {
                display: flex
            }
        }
    </style>
</head>

<body>

    <!-- ===== NAV UTILITY ===== -->
    <div class="nav-utility d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center small py-1">
            <div class="d-flex gap-3 align-items-center">
                <span><i class="bi bi-clock"></i> Open daily 7:00–22:00</span>
                <span class="text-muted">•</span>
                <span><i class="bi bi-geo-alt"></i> Old Town</span>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <a href="#" class="link-utility">Gift cards</a>
                <a href="#contact" class="link-utility">Contact</a>
                <a href="#stand" class="link-utility">Coffee stand booking</a>
            </div>
        </div>
    </div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg nav-elevated" id="siteNav" aria-label="Main navigation">
        <div id="scrollProgress" aria-hidden="true"></div>
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#overview">
                <img src="{{ asset('assets/img/gallery/logo.png') }}" alt="Crustella" height="40" width="40"
                    style="border-radius:10px; object-fit:cover">
                <strong>Crustella</strong>
            </a>

            <!-- Desktop nav -->
            <div class="d-none d-lg-flex align-items-center ms-auto">
                <ul class="navbar-nav align-items-lg-center gap-1">

                    <!-- Mega: Menu -->
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link dropdown-toggle" href="#menu" id="menuMega" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-expanded="false">Menu</a>
                        <div class="dropdown-menu mega" aria-labelledby="menuMega">
                            <div class="row g-4 px-2 px-lg-3">
                                <div class="col-6 col-xl-3">
                                    <h6 class="fw-bold mb-2">Coffee</h6>
                                    <ul class="list-unstyled small m-0">
                                        <li class="mb-2"><a class="mega-link" href="#menu"><i
                                                    class="bi bi-cup-hot"></i> Espresso & Americano</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#menu"><i
                                                    class="bi bi-cup-hot"></i> Latte & Cappuccino</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#menu"><i
                                                    class="bi bi-cup-straw"></i> Iced & Cold Brew</a></li>
                                    </ul>
                                </div>
                                <div class="col-6 col-xl-3">
                                    <h6 class="fw-bold mb-2">Bakery</h6>
                                    <ul class="list-unstyled small m-0">
                                        <li class="mb-2"><a class="mega-link" href="#menu"><i
                                                    class="bi bi-bag-heart"></i> Croissants & Viennoiseries</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#menu"><i
                                                    class="bi bi-cake"></i> Cakes & Tarts</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#menu"><i
                                                    class="bi bi-basket"></i> Sourdough & Breads</a></li>
                                    </ul>
                                </div>
                                <div class="col-6 col-xl-3">
                                    <h6 class="fw-bold mb-2">Brunch</h6>
                                    <ul class="list-unstyled small m-0">
                                        <li class="mb-2"><a class="mega-link" href="#menu"><i
                                                    class="bi bi-egg-fried"></i> Avo Toast</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#menu"><i
                                                    class="bi bi-egg"></i> Brioche French Toast</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#menu"><i
                                                    class="bi bi-emoji-smile"></i> Kids & Gluten-free</a></li>
                                    </ul>
                                </div>
                                <div class="col-6 col-xl-3">
                                    <div class="p-3 rounded-3 border"
                                        style="border-color:var(--border)!important;background:var(--surface-2)">
                                        <div class="small text-muted mb-2">Seasonal pick</div>
                                        <div class="seasonal-card">
                                            <img src="{{ asset('assets/img/gallery/sticky-cinnamon-roll.png') }}"
                                                alt="Cinnamon roll">
                                            <div>
                                                <div class="fw-bold">Sticky Cinnamon Roll</div>
                                                <div class="small text-muted">Limited batch • Pre-order</div>
                                            </div>
                                        </div>
                                        <a href="#menu" class="btn btn-primary btn-sm w-100 mt-3">Explore menu</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="#catering">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#story">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>

                    <!-- Search & Theme -->
                    <li class="nav-item">
                        <button class="btn btn-outline-primary" id="searchBtn" aria-expanded="false"
                            aria-controls="navSearchWrap" aria-label="Open search">
                            <i class="bi bi-search"></i>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button id="themeBtn" class="btn btn-outline-primary" aria-label="Toggle dark mode"><i
                                class="bi bi-moon-stars"></i></button>
                    </li>

                    <!-- CTAs -->
                    <li class="nav-item ms-1"><a href="#stand" class="btn btn-outline-primary">Book coffee stand</a>
                    </li>
                    <li class="nav-item ms-1"><a href="#" class="btn btn-primary">Order pickup</a></li>
                </ul>
            </div>

            <!-- Mobile toggler -->
            <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNav" aria-label="Open menu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Expandable Search -->
        <div id="navSearchWrap" class="nav-search collapse">
            <div class="container">
                <form class="nav-search-form" role="search" aria-label="Site search"
                    onsubmit="event.preventDefault();document.getElementById('searchClose').click();">
                    <i class="bi bi-search"></i>
                    <input class="form-control nav-search-input" type="search"
                        placeholder="Search menu, pastries, coffee…" aria-label="Search">
                    <button class="btn btn-light" type="button" id="searchClose" aria-label="Close search"><i
                            class="bi bi-x-lg"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Offcanvas mobile menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel"
        style="background:var(--surface); border-left:1px solid var(--border)">
        <div class="offcanvas-header"
            style="border-bottom:1px solid var(--border); background:linear-gradient(90deg,#FFF1E6,#FFE2CC)">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/img/gallery/logo.png') }}" alt="Crustella" height="28" width="28"
                    style="border-radius:6px; object-fit:cover">
                <strong id="offcanvasNavLabel">Crustella</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-grid gap-2 mb-3">
                <a href="#" class="btn btn-primary"><i class="bi bi-bag"></i> Order pickup</a>
                <a href="#stand" class="btn btn-outline-primary" data-close><i class="bi bi-calendar2-check"></i>
                    Book coffee stand</a>
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item" href="#menu" data-close>Menu</a>
                <a class="list-group-item" href="#gallery" data-close>Gallery</a>
                <a class="list-group-item" href="#catering" data-close>Services</a>
                <a class="list-group-item" href="#story" data-close>About</a>
                <a class="list-group-item" href="#contact" data-close>Contact</a>
            </div>
            <div class="border-top mt-3 pt-3" style="border-color:var(--border)!important;">
                <div class="d-flex gap-2">
                    <button id="themeBtnMobile" class="btn btn-light w-100" type="button"><i
                            class="bi bi-moon-stars"></i> Theme</button>
                    <button class="btn btn-light w-100" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navSearchWrap"><i class="bi bi-search"></i> Search</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== HERO ===== -->
    <header class="hero" id="overview">
        <div class="bg-img" style="background-image:url('{{ asset('assets/img/gallery/hero.png') }}');"></div>
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge-soft d-inline-flex align-items-center gap-2 mb-3"><i
                            class="bi bi-star-fill"></i> Freshly baked every morning</span>
                    <h1 class="display-5 mb-3">Artisan <span
                            style="background:linear-gradient(90deg,var(--accent),#FFB680);-webkit-background-clip:text;background-clip:text;color:transparent">bakery</span>
                        & specialty coffee</h1>
                    <p class="lead text-muted mb-4">From buttery croissants to slow-fermented sourdough, paired with
                        single-origin espresso. Cozy, fast, and consistently delicious.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#menu" class="btn btn-primary btn-lg">Explore menu</a>
                        <a href="#stand" class="btn btn-outline-primary btn-lg">Book coffee stand</a>
                    </div>
                    <div class="d-flex gap-4 mt-4 flex-wrap text-muted small">
                        <div><i class="bi bi-clock"></i> Open daily 7:00–22:00</div>
                        <div><i class="bi bi-wifi"></i> Work-friendly</div>
                        <div><i class="bi bi-bag-check"></i> Pickup ready in ~10min</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="skel" id="heroShot" style="border-radius:22px;">
                        <img src="{{ asset('assets/img/gallery/bakery.png') }}" alt="Fresh pastry tray"
                            class="w-100 h-100" style="object-fit:cover; display:block" loading="eager"
                            fetchpriority="high" width="900" height="600" />
                    </div>
                    <p class="small text-muted mt-2 text-center">All photos are placeholders—replace with your licensed
                        images.</p>
                </div>
            </div>

            <!-- Trust bar -->
            <div class="mt-5 pt-3">
                <div class="text-center text-muted mb-2">Loved by locals & travelers</div>
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                    <!-- Reviews -->
                    <img src="{{asset('assets/img/gallery/google_review.png')}}" alt="Google rating 4.9 out of 5" height="44"
                        loading="lazy"
                        style="border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff;object-fit:cover">

                    <img src="assets/img/clients/tripadvisor-choice.png" alt="Tripadvisor Travelers’ Choice"
                        height="44" loading="lazy"
                        style="border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff;object-fit:cover">

                    <img src="assets/img/clients/yelp-love.png" alt="Yelp — People Love Us" height="44"
                        loading="lazy"
                        style="border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff;object-fit:cover">

                    <!-- Press / local -->
                    <img src="assets/img/clients/oldtown-weekly.png" alt="Featured in Oldtown Weekly" height="44"
                        loading="lazy"
                        style="border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff;object-fit:cover">

                    <!-- Client logo -->
                    <img src="assets/img/clients/hotel-oasis.png" alt="Catering partner — Hotel Oasis" height="44"
                        loading="lazy"
                        style="border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff;object-fit:cover">
                </div>
            </div>

        </div>
    </header>

    <!-- ===== METRICS ===== -->
    <section class="py-4" style="background:var(--surface)">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">12yr</div>
                    <div class="text-muted small">craft baking</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">+40</div>
                    <div class="text-muted small">daily bakes</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">4.8★</div>
                    <div class="text-muted small">avg rating</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">~10m</div>
                    <div class="text-muted small">pickup time</div>
                </div>
            </div>
            <div class="my-4"
                style="height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent)"></div>
        </div>
    </section>

    <!-- ===== SIGNATURE MENU ===== -->
    <section id="menu" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="mb-1">Signature Menu</h2>
                <p class="text-muted">Small batch, baked all day. Coffee roasted weekly.</p>
            </div>

            <ul class="nav nav-pills justify-content-center gap-2 mt-3 menu" id="menuTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-filter="all" type="button">All</button>
                </li>
                <li class="nav-item"><button class="nav-link" data-filter="coffee" type="button">Coffee</button>
                </li>
                <li class="nav-item"><button class="nav-link" data-filter="bakery" type="button">Bakery</button>
                </li>
                <li class="nav-item"><button class="nav-link" data-filter="brunch" type="button">Brunch</button>
                </li>
            </ul>

            <div class="row g-4 mt-1" id="menuGrid">
                <!-- Coffee -->
                <div class="col-sm-6 col-lg-4" data-category="coffee">
                    <div class="card-soft feature h-100">
                        <div class="skel"><img src="{{asset('assets/img/dishes/item_1.png')}}" alt="Vanilla Latte" class="w-100"
                                loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-3">
                            <h6 class="mb-0">Vanilla Latte</h6><strong>$4.9</strong>
                        </div>
                        <p class="text-muted small mb-2">Velvety milk + double shot.</p>
                        <div class="d-flex gap-2"><button class="btn btn-outline-primary btn-sm"><i
                                    class="bi bi-bag-plus"></i> Add</button><button class="btn btn-light btn-sm">Hot /
                                Iced</button></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4" data-category="coffee">
                    <div class="card-soft feature h-100">
                        <div class="skel"><img src="{{asset('assets/img/dishes/item_6.png')}}" alt="Americano" class="w-100"
                                loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-3">
                            <h6 class="mb-0">Americano</h6><strong>$3.5</strong>
                        </div>
                        <p class="text-muted small mb-2">Bold espresso, hot water finish.</p>
                        <div class="d-flex gap-2"><button class="btn btn-outline-primary btn-sm"><i
                                    class="bi bi-bag-plus"></i> Add</button><button
                                class="btn btn-light btn-sm">Classic</button></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4" data-category="coffee">
                    <div class="card-soft feature h-100">
                        <div class="skel"><img src="{{asset('assets/img/dishes/item_9.png')}}" alt="Cold Brew" class="w-100"
                                loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-3">
                            <h6 class="mb-0">Cold Brew</h6><strong>$4.2</strong>
                        </div>
                        <p class="text-muted small mb-2">12-hour steep, super smooth.</p>
                        <div class="d-flex gap-2"><button class="btn btn-outline-primary btn-sm"><i
                                    class="bi bi-bag-plus"></i> Add</button><button
                                class="btn btn-light btn-sm">Iced</button></div>
                    </div>
                </div>

                <!-- Bakery -->
                <div class="col-sm-6 col-lg-4" data-category="bakery">
                    <div class="card-soft feature h-100">
                        <div class="skel"><img src="{{asset('assets/img/dishes/item_4.png')}}" alt="Butter Croissant"
                                class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-3">
                            <h6 class="mb-0">Butter Croissant</h6><strong>$3.2</strong>
                        </div>
                        <p class="text-muted small mb-2">Flaky, laminated with AOP butter.</p>
                        <div class="d-flex gap-2"><button class="btn btn-outline-primary btn-sm"><i
                                    class="bi bi-bag-plus"></i> Add</button><button
                                class="btn btn-light btn-sm">Best-seller</button></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4" data-category="bakery">
                    <div class="card-soft feature h-100">
                        <div class="skel"><img src="{{asset('assets/img/dishes/item_2.png')}}" alt="Blueberry Muffin"
                                class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-3">
                            <h6 class="mb-0">Blueberry Muffin</h6><strong>$3.1</strong>
                        </div>
                        <p class="text-muted small mb-2">Moist crumb, bursting berries.</p>
                        <div class="d-flex gap-2"><button class="btn btn-outline-primary btn-sm"><i
                                    class="bi bi-bag-plus"></i> Add</button><button class="btn btn-light btn-sm">Fresh
                                daily</button></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4" data-category="bakery">
                    <div class="card-soft feature h-100">
                        <div class="skel"><img src="{{asset('assets/img/dishes/item_10.png')}}" alt="Cinnamon Roll"
                                class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-3">
                            <h6 class="mb-0">Cinnamon Roll</h6><strong>$3.8</strong>
                        </div>
                        <p class="text-muted small mb-2">Sticky glaze, warm spices.</p>
                        <div class="d-flex gap-2"><button class="btn btn-outline-primary btn-sm"><i
                                    class="bi bi-bag-plus"></i> Add</button><button
                                class="btn btn-light btn-sm">Seasonal</button></div>
                    </div>
                </div>

                <!-- Brunch -->
                <div class="col-sm-6 col-lg-4" data-category="brunch">
                    <div class="card-soft feature h-100">
                        <div class="skel"><img src="{{asset('assets/img/dishes/item_5.png')}}" alt="Sourdough Avo Toast"
                                class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-3">
                            <h6 class="mb-0">Sourdough Avo Toast</h6><strong>$8.9</strong>
                        </div>
                        <p class="text-muted small mb-2">Heirloom tomatoes, feta, herbs.</p>
                        <div class="d-flex gap-2"><button class="btn btn-outline-primary btn-sm"><i
                                    class="bi bi-bag-plus"></i> Add</button><button
                                class="btn btn-light btn-sm">Vegetarian</button></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4" data-category="brunch">
                    <div class="card-soft feature h-100">
                        <div class="skel"><img src="{{asset('assets/img/dishes/item_7.png')}}" alt="Brioche French Toast"
                                class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-3">
                            <h6 class="mb-0">Brioche French Toast</h6><strong>$9.9</strong>
                        </div>
                        <p class="text-muted small mb-2">Maple, berries, mascarpone.</p>
                        <div class="d-flex gap-2"><button class="btn btn-outline-primary btn-sm"><i
                                    class="bi bi-bag-plus"></i> Add</button><button
                                class="btn btn-light btn-sm">Weekend fav</button></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4" data-category="brunch">
                    <div class="card-soft feature h-100">
                        <div class="skel"><img src="{{asset('assets/img/dishes/item_8.png')}}" alt="Herb Omelette"
                                class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-3">
                            <h6 class="mb-0">Herb Omelette</h6><strong>$7.9</strong>
                        </div>
                        <p class="text-muted small mb-2">Chives, gruyère, side salad.</p>
                        <div class="d-flex gap-2"><button class="btn btn-outline-primary btn-sm"><i
                                    class="bi bi-bag-plus"></i> Add</button><button
                                class="btn btn-light btn-sm">Gluten-free</button></div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary"><i class="bi bi-journal-text"></i> Download full
                    menu (PDF)</a>
            </div>
        </div>
    </section>

    <!-- ===== PROMO STRIP ===== -->
    <section class="promo">
        <div class="container">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="skel" style="width:72px;height:72px;border-radius:14px;flex:0 0 auto;">
                            <img src="{{ asset('assets/img/gallery/sticky-cinnamon-roll.png') }}" alt="Cinnamon roll"
                                width="72" height="72" style="object-fit:cover" loading="lazy">
                        </div>
                        <div>
                            <h5 class="mb-1">Seasonal favorite: Sticky Cinnamon Roll</h5>
                            <p class="text-muted mb-0 small">Baked at 9am, noon & 4pm — limited batch. Pre-order to
                                guarantee yours.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#" class="btn btn-primary">Pre-order now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== GALLERY ===== -->
    <section id="gallery" class="py-5">
        <div class="container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-3">
                <h2 class="m-0">Gallery</h2>
                <p class="text-muted m-0">Tap a photo to view.</p>
            </div>

            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-tile" data-full="assets/img/gallery/1-large.jpg">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/pastry_detail.png') }}"
                                alt="Pastry detail" class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-tile" data-full="assets/img/gallery/4-large.jpg">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/cakes.png') }}" alt="Cakes"
                                class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-tile" data-full="assets/img/gallery/3-large.jpg">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/fresh_bread.png') }}"
                                alt="Fresh bread" class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-tile"
                        data-full="{{ asset('assets/img/gallery/latte_art.png') }}">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/latte_art.png') }}"
                                alt="Latte art" class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-tile" data-full="assets/img/gallery/5-large.jpg">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/brunch_table.png') }}"
                                alt="Brunch table" class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-tile" data-full="assets/img/gallery/6-large.jpg">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/outdoor_setting.png') }}"
                                alt="Outdoor seating" class="w-100" loading="lazy"></div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true" aria-labelledby="galleryLabel">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <button type="button" class="btn-close ms-auto m-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <div class="modal-body p-0">
                        <img id="galleryFull" src="" alt="Gallery full view" class="w-100"
                            style="display:block">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="py-5 reviews" aria-labelledby="reviewsTitle">
        <div class="container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-3">
                <div>
                    <h2 id="reviewsTitle" class="m-0">What guests say</h2>
                    <p class="text-muted m-0">Real reviews from regulars.</p>
                </div>
                <div class="rating-summary d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <strong class="fs-3 lh-1">4.9</strong>
                        <div class="rating-stars text-warning" aria-label="Average rating 4.9 out of 5">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                class="bi bi-star-half"></i>
                        </div>
                    </div>
                    <span class="text-muted small">1,200+ verified reviews</span>
                </div>
            </div>

            <div id="tCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000"
                data-bs-pause="hover">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <article class="review-card card-soft" aria-label="Review from Sarah M.">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('assets/img/gallery/review_1.png') }}" alt="Portrait of Sarah"
                                    class="avatar" width="56" height="56" loading="lazy" decoding="async">
                                <div>
                                    <div class="fw-bold d-flex align-items-center gap-2">Sarah M. <span
                                            class="source-badge">Google</span></div>
                                    <div class="text-warning" aria-label="5 out of 5 stars">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <blockquote class="mb-0">Best croissant in town. Coffee is consistently excellent.
                            </blockquote>
                        </article>
                    </div>

                    <div class="carousel-item">
                        <article class="review-card card-soft" aria-label="Review from Omar K.">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('assets/img/gallery/people_3.png') }}" alt="Portrait of Omar"
                                    class="avatar" width="56" height="56" loading="lazy" decoding="async">
                                <div>
                                    <div class="fw-bold d-flex align-items-center gap-2">Omar K. <span
                                            class="source-badge">Tripadvisor</span></div>
                                    <div class="text-warning" aria-label="5 out of 5 stars">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <blockquote class="mb-0">Fast pickup for the office—cinnamon rolls disappear in minutes.
                            </blockquote>
                        </article>
                    </div>

                    <div class="carousel-item">
                        <article class="review-card card-soft" aria-label="Review from Lina A.">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('assets/img/gallery/people_2.png') }}" alt="Portrait of Lina"
                                    class="avatar" width="56" height="56" loading="lazy" decoding="async">
                                <div>
                                    <div class="fw-bold d-flex align-items-center gap-2">Lina A. <span
                                            class="source-badge">Yelp</span></div>
                                    <div class="text-warning" aria-label="5 out of 5 stars">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <blockquote class="mb-0">Cozy vibe for laptops—great Wi-Fi and plenty of plugs.
                            </blockquote>
                        </article>
                    </div>
                </div>

                <!-- Avatar indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#tCarousel" data-bs-slide-to="0" class="active"
                        aria-label="Go to Sarah’s review">
                        <img src="{{ asset('assets/img/gallery/review_1.png') }}" alt="" aria-hidden="true">
                    </button>
                    <button type="button" data-bs-target="#tCarousel" data-bs-slide-to="1"
                        aria-label="Go to Omar’s review">
                        <img src="{{ asset('assets/img/gallery/people_3.png') }}" alt="" aria-hidden="true">
                    </button>
                    <button type="button" data-bs-target="#tCarousel" data-bs-slide-to="2"
                        aria-label="Go to Lina’s review">
                        <img src="{{ asset('assets/img/gallery/people_2.png') }}" alt="" aria-hidden="true">
                    </button>
                </div>
            </div>

            <!-- Better external controls -->
            <div class="review-nav d-flex justify-content-center justify-content-lg-end gap-2 mt-3">
                <button class="btn btn-outline-primary btn-sm" type="button" data-bs-target="#tCarousel"
                    data-bs-slide="prev" aria-label="Previous">
                    <i class="bi bi-chevron-left"></i> Prev
                </button>
                <button class="btn btn-primary btn-sm" type="button" data-bs-target="#tCarousel"
                    data-bs-slide="next" aria-label="Next">
                    Next <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- ===== SERVICES ===== -->
    <section id="catering" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="mb-1">Services</h2>
                <p class="text-muted">For offices, events, and fellow cafés.</p>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft service-card h-100">
                        <span class="badge rounded-pill mb-2"><i class="bi bi-calendar2-check"></i> Events</span>
                        <h6 class="fw-bold">Coffee Stand for Events</h6>
                        <p class="text-muted small">Espresso bar + baristas on-site. Optional pastries.
                            Indoors/outdoors.</p>
                        <a href="#stand" class="btn btn-outline-primary btn-sm">Book your date</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft service-card h-100">
                        <span class="badge rounded-pill mb-2"><i class="bi bi-briefcase"></i> Office</span>
                        <h6 class="fw-bold">Corporate Ordering</h6>
                        <p class="text-muted small">Recurring breakfast trays + coffee boxes for teams & meetings.</p>
                        <a href="#contact" class="btn btn-outline-primary btn-sm">Request info</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft service-card h-100">
                        <span class="badge rounded-pill mb-2"><i class="bi bi-shop"></i> Wholesale</span>
                        <h6 class="fw-bold">Pastry Wholesale</h6>
                        <p class="text-muted small">Daily viennoiseries and cakes supplied to cafés & hotels.</p>
                        <a href="#contact" class="btn btn-outline-primary btn-sm">Become a partner</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STORY ===== -->
    <section id="story" class="py-5" style="background:var(--surface)">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="skel" style="border-radius:22px;">
                        <img src="{{ asset('assets/img/gallery/our_bakers.png') }}" alt="Our bakers"
                            class="w-100 h-100" style="object-fit:cover" loading="lazy">
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="badge text-bg-light border fw-semibold mb-2"
                        style="border-color:var(--border)!important;color:var(--accent)!important;">Our story</span>
                    <h3 class="fw-bold">Led by craft, guided by season</h3>
                    <p class="text-muted">We source stone-ground flour, farm-fresh eggs, and roast beans weekly. Expect
                        a rotating menu focused on comfort, freshness, and subtle surprises.</p>
                    <ul class="list-unstyled text-muted small">
                        <li>• Slow ferment sourdough</li>
                        <li>• Plant-forward brunch options</li>
                        <li>• Wholesale pastries for cafés</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== EVENT COFFEE STAND (enhanced form) ===== -->
    <section id="stand" class="py-5">
        <div class="container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-3">
                <div>
                    <h2 class="m-0">Book a Coffee Stand</h2>
                    <p class="text-muted m-0">We bring espresso, baristas, and optional pastries to your venue.</p>
                </div>
                <div class="estimate-pill">
                    <i class="bi bi-cash-coin"></i>
                    <span class="small text-muted">Instant estimate</span>
                    <strong id="estimate">$0</strong>
                </div>
            </div>

            <div class="card-soft stand-card">
                <form class="row g-3 needs-validation" id="standForm" novalidate>
                    <!-- Contact -->
                    <div class="col-md-6">
                        <div class="input-icon">
                            <i class="bi bi-person"></i>
                            <input type="text" class="form-control" id="orgName" required
                                placeholder="Your name">
                        </div>
                        <div class="invalid-feedback">Please enter your name.</div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-icon">
                            <i class="bi bi-envelope"></i>
                            <input type="email" class="form-control" id="email" required
                                placeholder="you@example.com" autocomplete="email">
                        </div>
                        <div class="invalid-feedback">Enter a valid email.</div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-icon">
                            <i class="bi bi-telephone"></i>
                            <input type="tel" class="form-control" id="phone" required
                                placeholder="+1 555 000 000" autocomplete="tel">
                        </div>
                        <div class="invalid-feedback">Enter your phone number.</div>
                    </div>

                    <!-- Time & size -->
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" required>
                        <div class="invalid-feedback">Select a date.</div>
                    </div>
                    <div class="col-md-3">
                        <label for="start" class="form-label">Start time</label>
                        <input type="time" class="form-control" id="start" required>
                        <div class="invalid-feedback">Select a start time.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">Duration</label>
                        <div class="chip-group">
                            <div class="chip">
                                <input type="radio" name="duration" id="d2" value="2" checked>
                                <label for="d2">2 hours</label>
                            </div>
                            <div class="chip">
                                <input type="radio" name="duration" id="d3" value="3">
                                <label for="d3">3 hours</label>
                            </div>
                            <div class="chip">
                                <input type="radio" name="duration" id="d4" value="4">
                                <label for="d4">4 hours</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="attendees" class="form-label">Attendees</label>
                        <div class="input-group">
                            <button class="btn btn-light" type="button" id="minusAtt"><i
                                    class="bi bi-dash"></i></button>
                            <input type="number" min="1" class="form-control text-center" id="attendees"
                                required value="50">
                            <button class="btn btn-light" type="button" id="plusAtt"><i
                                    class="bi bi-plus"></i></button>
                        </div>
                        <div class="form-text">A rough estimate is fine.</div>
                    </div>

                    <!-- Package -->
                    <div class="col-12">
                        <label class="form-label d-block">Package</label>
                        <div class="chip-group">
                            <div class="chip">
                                <input type="radio" name="package" id="pkg1" value="coffee" checked>
                                <label for="pkg1"><i class="bi bi-cup-hot"></i> Espresso bar</label>
                            </div>
                            <div class="chip">
                                <input type="radio" name="package" id="pkg2" value="coffee_pastry">
                                <label for="pkg2"><i class="bi bi-cup-hot"></i> Coffee + Pastries</label>
                            </div>
                            <div class="chip">
                                <input type="radio" name="package" id="pkg3" value="full_brunch">
                                <label for="pkg3"><i class="bi bi-egg-fried"></i> Coffee + Pastries + Light
                                    Brunch</label>
                            </div>
                        </div>
                        <div class="form-text">Cups, lids, sugars included. Alt milk on request.</div>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <input id="notes" class="form-control" placeholder="Notes (venue, access, allergies…)">
                    </div>

                    <!-- Actions -->
                    <div class="col-12 d-flex flex-wrap gap-2 align-items-center">
                        <button class="btn btn-primary" type="submit">Request booking</button>
                        <button class="btn btn-light" type="reset">Reset</button>
                        <span id="formStatus" class="text-muted"></span>
                    </div>
                    <p class="small text-muted m-0">Estimates are indicative; final quote may vary by logistics & menu.
                    </p>
                </form>
            </div>
        </div>

        <!-- Toast -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="standToast" class="toast align-items-center text-bg-success border-0" role="status"
                aria-live="polite" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">Request received! We'll confirm availability and send a quote.</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CONTACT / MAP & HOURS ===== -->
    <section id="contact" class="py-5" style="background:var(--surface)">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-5">
                    <h2 class="fw-bold">Visit us</h2>
                    <p class="text-muted">123 Baker St, Old Town • Open daily 7:00–22:00</p>
                    <div class="card-soft p-4 h-100">
                        <h6 class="fw-bold">Contact</h6>
                        <p class="text-muted mb-3 small">Phone: +1 555 123 456 • Email: hello@crustella.com</p>
                        <div class="border-top my-2" style="border-color:var(--border)!important;"></div>
                        <h6 class="fw-bold">Hours</h6>
                        <ul class="list-unstyled text-muted small mb-0">
                            <li>Mon–Fri: 7:00 – 22:00</li>
                            <li>Sat–Sun: 8:00 – 23:00</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="skel" style="border-radius:22px; height:100%;">
                        <img src="{{asset('assets/img/gallery/map.png')}}" alt="Map and directions" class="w-100 h-100"
                            style="object-fit:cover" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta text-center">
        <div class="container">
            <h2 class="fw-bold mb-2">Hungry now?</h2>
            <p class="mb-4 text-muted">Order pickup and we’ll have it ready in ~10 minutes.</p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="#" class="btn btn-light btn-lg"><i class="bi bi-bag"></i> Order pickup</a>
                <a href="#menu" class="btn btn-outline-primary btn-lg">See menu</a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="site-footer pt-5">
        <div class="container pb-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card-soft p-3 h-100" style="background:var(--surface-2)">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ asset('assets/img/gallery/logo.png') }}" alt="Crustella" height="36"
                                width="36" style="border-radius:8px; object-fit:cover">
                            <strong>Crustella</strong>
                        </div>
                        <p class="small text-muted mb-3">A neighborhood café & bakery serving honest pastries and
                            specialty coffee.</p>
                        <div class="d-flex">
                            <a href="#" class="btn btn-light btn-sm me-2"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="btn btn-light btn-sm me-2"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="btn btn-light btn-sm"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-3">Explore</h6>
                    <ul class="list-unstyled small m-0">
                        <li class="mb-2"><a class="link-body-emphasis" href="#menu">Menu</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#gallery">Gallery</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#catering">Services</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#stand">Coffee stand booking</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-3">
                    <h6 class="fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled small m-0">
                        <li class="mb-2"><a class="link-body-emphasis" href="#">Gift cards</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#">Wholesale</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#">Allergens</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#contact">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Newsletter</h6>
                    <p class="small text-muted mb-2">Get weekly specials & early drops.</p>
                    <form id="newsletterForm" class="d-flex gap-2">
                        <input type="email" required class="form-control" placeholder="your@email.com">
                        <button class="btn btn-primary" type="submit">Subscribe</button>
                    </form>
                    <div id="newsletterMsg" class="small mt-2" aria-live="polite"></div>
                </div>
            </div>

            <hr class="my-4" style="border-color:var(--border)">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between pb-4">
                <p class="small text-muted mb-2 mb-md-0">&copy; <span id="year"></span> Crustella. All rights
                    reserved.</p>
                <div class="d-flex align-items-center gap-3">
                    <a href="#overview" class="btn btn-outline-primary btn-sm" id="toTopBtn"><i
                            class="bi bi-arrow-up"></i> Top</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile sticky CTA -->
    <div class="mobile-cta">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-cup-hot"></i>
            <span class="small">Order your coffee now</span>
        </div>
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-primary btn-sm">Order pickup</a>
            <a href="#stand" class="btn btn-light btn-sm">Book stand</a>
        </div>
    </div>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image skeleton remove
            document.querySelectorAll('.skel img').forEach(img => {
                const done = () => img.parentElement.classList.add('loaded');
                if (img.complete) done();
                else {
                    img.addEventListener('load', done);
                    img.addEventListener('error', done);
                }
            });

            // Navbar progress + year
            const nav = document.getElementById('siteNav');
            const progress = document.getElementById('scrollProgress');
            const setProgress = () => {
                const st = document.documentElement.scrollTop || document.body.scrollTop;
                const h = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const pct = Math.max(0, Math.min(1, st / h));
                progress.style.width = (pct * 100).toFixed(2) + '%';
                nav?.classList.toggle('scrolled', window.scrollY > 8);
            };
            setProgress();
            window.addEventListener('scroll', setProgress);
            document.getElementById('year').textContent = new Date().getFullYear();

            // Search open/close
            const searchBtn = document.getElementById('searchBtn');
            const searchWrap = document.getElementById('navSearchWrap');
            const searchClose = document.getElementById('searchClose');
            const bsCollapse = searchWrap ? new bootstrap.Collapse(searchWrap, {
                toggle: false
            }) : null;
            const openSearch = () => {
                bsCollapse?.show();
                searchBtn?.setAttribute('aria-expanded', 'true');
                setTimeout(() => searchWrap?.querySelector('input')?.focus(), 120);
            }
            const closeSearch = () => {
                bsCollapse?.hide();
                searchBtn?.setAttribute('aria-expanded', 'false');
            }
            searchBtn?.addEventListener('click', () => searchWrap?.classList.contains('show') ? closeSearch() :
                openSearch());
            searchClose?.addEventListener('click', closeSearch);
            document.addEventListener('click', (e) => {
                if (!searchWrap?.classList.contains('show')) return;
                if (!searchWrap.contains(e.target) && e.target !== searchBtn) closeSearch();
            });

            // Offcanvas close on link
            const offcanvasEl = document.getElementById('offcanvasNav');
            offcanvasEl?.querySelectorAll('[data-close]').forEach(a => a.addEventListener('click', () => bootstrap
                .Offcanvas.getInstance(offcanvasEl)?.hide()));

            // Theme toggle (desktop + mobile) — robust
            const themeBtn = document.getElementById('themeBtn');
            const themeBtnMobile = document.getElementById('themeBtnMobile');
            const syncIcon = (el) => {
                if (!el) return;
                el.innerHTML = document.documentElement.getAttribute('data-bs-theme') === 'dark' ?
                    '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon-stars"></i>';
            };
            const toggleTheme = () => {
                const next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' :
                    'dark';
                document.documentElement.setAttribute('data-bs-theme', next);
                try {
                    localStorage.setItem('theme', next);
                } catch (e) {}
                syncIcon(themeBtn);
                syncIcon(themeBtnMobile);
            };
            syncIcon(themeBtn);
            syncIcon(themeBtnMobile);
            themeBtn?.addEventListener('click', toggleTheme);
            themeBtnMobile?.addEventListener('click', toggleTheme);

            // Menu filtering — reliable (event delegation)
            (function() {
                const tabs = document.getElementById('menuTabs');
                const grid = document.getElementById('menuGrid');
                if (!tabs || !grid) return;
                tabs.addEventListener('click', (e) => {
                    const btn = e.target.closest('button[data-filter]');
                    if (!btn) return;
                    tabs.querySelectorAll('.nav-link').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    const cat = btn.getAttribute('data-filter');
                    grid.querySelectorAll('[data-category]').forEach(card => {
                        const show = (cat === 'all') || (card.getAttribute('data-category') ===
                            cat);
                        card.classList.toggle('d-none', !show);
                    });
                });
            })();

            // Gallery modal
            (function() {
                const modalEl = document.getElementById('galleryModal');
                const galleryImg = document.getElementById('galleryFull');
                if (!modalEl || !galleryImg) return;
                const modal = new bootstrap.Modal(modalEl);
                document.getElementById('gallery').addEventListener('click', (e) => {
                    const a = e.target.closest('.gallery-tile');
                    if (!a) return;
                    e.preventDefault();
                    galleryImg.src = a.dataset.full;
                    modal.show();
                });
            })();

            // Booking form — estimate + UX
            (function() {
                const form = document.getElementById('standForm');
                const toast = new bootstrap.Toast(document.getElementById('standToast'));
                const estimateEl = document.getElementById('estimate');
                const att = document.getElementById('attendees');
                const plus = document.getElementById('plusAtt'),
                    minus = document.getElementById('minusAtt');

                function durationVal() {
                    return parseInt((document.querySelector('input[name="duration"]:checked') || {
                        value: '2'
                    }).value, 10);
                }

                function packageVal() {
                    return (document.querySelector('input[name="package"]:checked') || {
                        value: 'coffee'
                    }).value;
                }

                function calcEstimate() {
                    const attendees = Math.max(0, parseInt(att.value || '0', 10));
                    const hours = durationVal();
                    const pkg = packageVal();
                    let perHead = 5;
                    if (pkg === 'coffee_pastry') perHead = 9;
                    if (pkg === 'full_brunch') perHead = 15;
                    let total = attendees * perHead + Math.max(0, hours - 2) * 150;
                    estimateEl.textContent = '$' + total.toLocaleString();
                }
                ['change', 'input'].forEach(ev => {
                    document.querySelectorAll('input[name="duration"], input[name="package"]').forEach(
                        el => el.addEventListener(ev, calcEstimate));
                });
                att.addEventListener('input', calcEstimate);
                plus?.addEventListener('click', () => {
                    att.value = String((parseInt(att.value || '0', 10) || 0) + 10);
                    calcEstimate();
                });
                minus?.addEventListener('click', () => {
                    att.value = String(Math.max(1, (parseInt(att.value || '1', 10) || 1) - 10));
                    calcEstimate();
                });

                window.addEventListener('load', calcEstimate);
                calcEstimate();

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    if (!form.checkValidity()) {
                        e.stopPropagation();
                        form.classList.add('was-validated');
                        return;
                    }
                    document.getElementById('formStatus').textContent = 'Sending…';
                    await new Promise(r => setTimeout(r, 700));
                    document.getElementById('formStatus').textContent = 'Request received.';
                    form.reset();
                    form.classList.remove('was-validated');
                    calcEstimate();
                    toast.show();
                });
            })();

            // Back to top
            document.getElementById('toTopBtn')?.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Newsletter demo
            const nForm = document.getElementById('newsletterForm');
            const nMsg = document.getElementById('newsletterMsg');
            nForm?.addEventListener('submit', (e) => {
                e.preventDefault();
                nMsg.textContent = 'Thanks! You’re subscribed.';
                nMsg.className = 'small mt-2 text-success';
                nForm.reset();
                setTimeout(() => {
                    nMsg.textContent = '';
                    nMsg.className = 'small mt-2';
                }, 3500);
            });
        });
    </script>
</body>

</html>
