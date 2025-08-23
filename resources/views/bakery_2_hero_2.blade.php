<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">

<head>
    <!-- ===== META ===== -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description"
        content="Crustella — Café & bakery template (Demo 2 • Hero v3): cinematic hero with live countdown, quick-add dock, weekly specials carousel, drink configurator, subscriptions & gifts, workshops, FAQ, press band, improved cart offcanvas, and enhanced gallery lightbox." />
    <meta name="theme-color" content="#C46E3A" />
    <title>Crustella — Café & Bakery (Demo 2 — Hero v3)</title>
    <link rel="icon" href="assets/img/favicon.png" />

    <!-- Early theme init -->
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

        /* ============================================================
       HERO v3 — Cinematic split + quick-add dock + live countdown
    ============================================================ */
        .hero {
            position: relative;
            border-bottom: 1px solid var(--border);
            isolation: isolate;
            padding: 0;
            /* managed by v3 blocks */
        }

        .hero-v3 {
            min-height: clamp(520px, 72vh, 760px);
            display: grid;
            place-items: stretch;
            background: var(--bg);
        }

        .hero-v3 .hero-media {
            position: absolute;
            inset: 0;
            z-index: -2;
            overflow: hidden;
            border-bottom: 1px solid var(--border);
        }

        .hero-v3 .hero-media::before {
            content: "";
            position: absolute;
            inset: -6%;
            background-image: url('{{ asset('assets/img/gallery/hero.png') }}');
            background-size: cover;
            background-position: center;
            filter: contrast(1.03) saturate(1.05);
            animation: kenburns 22s ease-in-out infinite alternate;
            transform-origin: 70% 30%;
        }

        @keyframes kenburns {
            0% {
                transform: scale(1) translate3d(0, 0, 0);
            }

            100% {
                transform: scale(1.12) translate3d(-1%, -1%, 0);
            }
        }

        .hero-v3 .media-overlay {
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                radial-gradient(60rem 35rem at 85% -5%, rgba(196, 110, 58, .20), transparent 60%),
                linear-gradient(180deg, rgba(0, 0, 0, .0), rgba(0, 0, 0, .06) 60%, rgba(0, 0, 0, .14)),
                linear-gradient(120deg, rgba(255, 250, 245, .85), rgba(255, 250, 245, .55) 38%, rgba(255, 250, 245, .25) 60%, rgba(255, 250, 245, .1));
            mix-blend-mode: multiply;
        }

        [data-bs-theme="dark"] .hero-v3 .media-overlay {
            background:
                radial-gradient(60rem 35rem at 85% -5%, rgba(196, 110, 58, .16), transparent 60%),
                linear-gradient(180deg, rgba(0, 0, 0, .0), rgba(0, 0, 0, .35) 60%, rgba(0, 0, 0, .6)),
                linear-gradient(120deg, rgba(14, 17, 20, .86), rgba(14, 17, 20, .72) 38%, rgba(14, 17, 20, .5) 60%, rgba(14, 17, 20, .35));
        }

        .hero-v3 .container {
            padding-top: clamp(42px, 9vh, 72px);
            padding-bottom: clamp(18px, 2vh, 24px);
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .5rem .8rem;
            font-weight: 700;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .06)
        }

        [data-bs-theme="dark"] .hero-kicker {
            background: #0f141c
        }

        .hero-title {
            margin-top: 1rem;
            margin-bottom: .5rem;
        }

        .hero-title .grad {
            background: linear-gradient(90deg, var(--accent), #FFB680);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent
        }

        .hero-cta {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem;
            margin-top: 1rem
        }

        .hero-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: .9rem
        }

        .hero-meta .pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .35rem .6rem;
            background: rgba(196, 110, 58, .08);
            font-weight: 600;
        }

        .hero-ticker {
            position: relative;
            margin-top: 1rem;
            border-top: 1px dashed var(--border);
            border-bottom: 1px dashed var(--border);
            padding: .5rem 0;
            overflow: hidden;
            mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
        }

        .hero-ticker .rowline {
            white-space: nowrap;
            animation: marquee 24s linear infinite;
            display: inline-block;
        }

        .hero-ticker .rowline span {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            margin-right: 1.25rem;
            opacity: .9
        }

        @keyframes marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* Quick-add dock */
        .hero-dock {
            margin-top: clamp(14px, 3vh, 24px);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-2);
            padding: .85rem;
        }

        .hero-dock .chip-add {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .35rem .55rem .35rem .35rem;
            background: var(--surface-2);
        }

        .hero-dock .chip-add img {
            height: 28px;
            width: 28px;
            border-radius: 8px;
            object-fit: cover;
        }

        .hero-dock .chip-add .btn {
            border-radius: 999px;
            padding: .2rem .55rem;
            font-weight: 700;
        }

        /* Specials carousel */
        .specials .carousel-item {
            padding: .25rem
        }

        .specials .card-soft {
            overflow: hidden
        }

        /* Drink Configurator */
        .config {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-1);
            padding: 1.25rem
        }

        .config .opt {
            border-radius: 999px;
            border: 1px solid var(--border);
            padding: .45rem .75rem;
            cursor: pointer;
            user-select: none
        }

        .config .opt.active {
            border-color: var(--accent);
            background: rgba(196, 110, 58, .10)
        }

        .config .total {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .35rem .7rem;
            border-radius: 999px;
            border: 1px dashed var(--border);
            background: var(--surface-2)
        }

        /* Subscriptions */
        .plan {
            padding: 1.25rem;
            height: 100%
        }

        .plan .badge {
            background: rgba(196, 110, 58, .12);
            color: var(--accent);
            border: 1px solid var(--border)
        }

        /* Workshops */
        .workshop .date-badge {
            font-weight: 700;
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: .35rem .6rem;
            background: var(--surface-2)
        }

        /* Press band */
        .press {
            background: var(--surface-2);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border)
        }

        .press img {
            height: 44px;
            border-radius: 10px;
            border: 1px solid var(--border);
            box-shadow: 0 .35rem .9rem rgba(0, 0, 0, .06);
            background: #fff;
            object-fit: cover
        }

        /* FAQ */
        .faq .accordion-button:not(.collapsed) {
            color: var(--accent-700);
            background: rgba(196, 110, 58, .08)
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

        /* Mobile sticky order bar */
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

        /* Offcanvas Cart */
        .cart-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            padding: .35rem 0;
            border-bottom: 1px dashed var(--border)
        }

        .cart-line:last-child {
            border-bottom: 0
        }

        /* Gallery lightbox nav */
        #galleryModal .gallery-prev,
        #galleryModal .gallery-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            border-radius: 999px;
            box-shadow: var(--shadow-1)
        }

        #galleryModal .gallery-prev {
            left: .5rem
        }

        #galleryModal .gallery-next {
            right: .5rem
        }

        /* Filmstrip thumbs */
        #lightboxThumbs img {
            height: 62px;
            width: 92px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid var(--border);
            opacity: .75;
            transition: opacity .12s ease, transform .12s ease
        }

        #lightboxThumbs button {
            padding: 0;
            border: 0;
            background: transparent
        }

        #lightboxThumbs img.active {
            opacity: 1;
            outline: 3px solid var(--ring);
            transform: scale(1.02)
        }

        /* ============================================================
           PATCH: Mobile hero, light-mode overlay, and lightbox fixes
        ============================================================ */

        /* Fluid, safe H1 on all screens */
        .hero-title {
            font-size: clamp(1.9rem, 6.2vw + .2rem, 3.25rem);
            line-height: 1.1;
            word-break: break-word;
            margin-top: .5rem;
            margin-bottom: .25rem;
        }

        /* Tighter CTAs on phones so they don't wrap oddly */
        @media (max-width: 575.98px) {
            .hero-kicker {
                padding: .35rem .6rem;
                font-size: .92rem
            }

            .hero-cta .btn {
                padding: .55rem .85rem;
                font-size: 1rem;
            }

            .hero-meta {
                gap: .6rem
            }

            .hero-dock {
                padding: .6rem
            }

            .hero-v3 .container {
                padding-top: clamp(28px, 7vh, 56px);
            }
        }

        /* Ensure quick-add chips wrap without horizontal scroll */
        .hero-dock .d-flex.flex-wrap.gap-2 {
            row-gap: .5rem
        }

        @media (max-width: 575.98px) {
            .hero-dock .chip-add {
                width: 100%;
                justify-content: space-between
            }
        }

        /* Readability scrim behind the left (text) side */
        .content-scrim {
            position: absolute;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, .88) 0%,
                    rgba(255, 255, 255, .72) 28%,
                    rgba(255, 255, 255, .38) 52%,
                    rgba(255, 255, 255, 0) 72%);
        }

        [data-bs-theme="dark"] .content-scrim {
            background: linear-gradient(90deg,
                    rgba(14, 17, 20, .88) 0%,
                    rgba(14, 17, 20, .75) 28%,
                    rgba(14, 17, 20, .42) 52%,
                    rgba(14, 17, 20, 0) 72%);
        }

        /* Light-mode: avoid wash-out by disabling blend; keep multiply only in dark */
        .hero-v3 .media-overlay {
            mix-blend-mode: normal;
        }

        [data-bs-theme="dark"] .hero-v3 .media-overlay {
            mix-blend-mode: multiply;
        }

        /* Respect reduced motion preferences */
        @media (prefers-reduced-motion: reduce) {
            .hero-v3 .hero-media::before {
                animation: none
            }

            .hero-ticker .rowline {
                animation: none
            }
        }

        /* Lightbox: contain image and prevent overflow on mobile */
        #galleryModal .modal-body {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--surface);
        }

        #galleryFull {
            width: 100%;
            height: auto;
            display: block;
            max-height: calc(100dvh - 180px);
            max-height: calc(100vh - 180px);
            object-fit: contain;
            background: var(--surface);
        }

        #galleryModal .gallery-prev,
        #galleryModal .gallery-next {
            background: var(--surface);
            opacity: .9;
        }

        @media (max-width: 575.98px) {
            #lightboxThumbs img {
                width: 72px;
                height: 48px
            }
        }

        /* Safety net */
        html,
        body {
            overflow-x: hidden;
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
                <a href="#workshops" class="link-utility">Workshops</a>
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

            <div class="d-none d-lg-flex align-items-center ms-auto">
                <ul class="navbar-nav align-items-lg-center gap-1">
                    <!-- Mega: Explore -->
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link dropdown-toggle" href="#menu" id="menuMega" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-expanded="false">Explore</a>
                        <div class="dropdown-menu mega" aria-labelledby="menuMega">
                            <div class="row g-4 px-2 px-lg-3">
                                <div class="col-6 col-xl-3">
                                    <h6 class="fw-bold mb-2">Coffee</h6>
                                    <ul class="list-unstyled small m-0">
                                        <li class="mb-2"><a class="mega-link" href="#builder"><i
                                                    class="bi bi-cup-hot"></i> Build your drink</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#specials"><i
                                                    class="bi bi-cup-straw"></i> Weekly specials</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#subs"><i
                                                    class="bi bi-box-seam"></i> Subscriptions</a></li>
                                    </ul>
                                </div>
                                <div class="col-6 col-xl-3">
                                    <h6 class="fw-bold mb-2">Bakery</h6>
                                    <ul class="list-unstyled small m-0">
                                        <li class="mb-2"><a class="mega-link" href="#quick"><i
                                                    class="bi bi-bag-heart"></i> Quick order picks</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#gallery"><i
                                                    class="bi bi-images"></i> Gallery</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#faq"><i
                                                    class="bi bi-patch-question"></i> FAQ & Allergens</a></li>
                                    </ul>
                                </div>
                                <div class="col-6 col-xl-3">
                                    <h6 class="fw-bold mb-2">Events</h6>
                                    <ul class="list-unstyled small m-0">
                                        <li class="mb-2"><a class="mega-link" href="#workshops"><i
                                                    class="bi bi-calendar-event"></i> Workshops</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#contact"><i
                                                    class="bi bi-geo-alt"></i> Visit & hours</a></li>
                                        <li class="mb-2"><a class="mega-link" href="#press"><i
                                                    class="bi bi-megaphone"></i> Press</a></li>
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
                                        <a href="#quick" class="btn btn-primary btn-sm w-100 mt-3">Order a box</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="#builder">Drink Builder</a></li>
                    <li class="nav-item"><a class="nav-link" href="#subs">Subscriptions</a></li>
                    <li class="nav-item"><a class="nav-link" href="#workshops">Workshops</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Visit</a></li>

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

                    <!-- Cart -->
                    <li class="nav-item ms-1"><button class="btn btn-primary" data-bs-toggle="offcanvas"
                            data-bs-target="#cartCanvas"><i class="bi bi-bag"></i> Cart <span
                                class="badge text-bg-light ms-1" id="cartCount">0</span></button></li>
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
                <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas"><i
                        class="bi bi-bag"></i> View cart</button>
                <a href="#builder" class="btn btn-outline-primary" data-close><i class="bi bi-cup-hot"></i> Build a
                    drink</a>
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item" href="#quick" data-close>Quick order</a>
                <a class="list-group-item" href="#specials" data-close>Weekly specials</a>
                <a class="list-group-item" href="#subs" data-close>Subscriptions</a>
                <a class="list-group-item" href="#workshops" data-close>Workshops</a>
                <a class="list-group-item" href="#gallery" data-close>Gallery</a>
                <a class="list-group-item" href="#contact" data-close>Visit us</a>
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

    <!-- ===== HERO v3 ===== -->
    <header class="hero hero-v3" id="overview" aria-label="Crustella hero section">
        <div class="hero-media" aria-hidden="true"></div>
        <div class="media-overlay" aria-hidden="true"></div>
        <!-- NEW content scrim for readability -->
        <div class="content-scrim" aria-hidden="true"></div>

        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <span class="hero-kicker" id="openState"><i class="bi bi-dot"></i> Loading hours…</span>
                    <h1 class="display-4 hero-title">Breakfast, <span class="grad">elevated</span>.</h1>
                    <p class="lead text-muted">Small-batch viennoiseries & single-origin espresso — fast, cozy, and
                        dangerously
                        good.</p>

                    <div class="hero-cta">
                        <a href="#quick" class="btn btn-primary btn-lg"><i class="bi bi-bag-plus"></i> Start an
                            order</a>
                        <a href="#builder" class="btn btn-outline-primary btn-lg"><i class="bi bi-cup-hot"></i> Build
                            a drink</a>
                        <span class="pill" title="Next batch time"><i class="bi bi-alarm"></i> Next sticky roll in
                            <strong id="bakeEta">—</strong></span>
                    </div>

                    <!-- Ticker -->
                    <div class="hero-ticker" aria-label="Now baking">
                        <div class="rowline" aria-hidden="true">
                            <span>Now baking:</span>
                            <span>Butter Croissant 🥐</span>
                            <span>Sticky Cinnamon Roll ✨</span>
                            <span>Sourdough Boule 🍞</span>
                            <span>Blueberry Muffin 🫐</span>
                            <span>Almond Financier 🌰</span>
                            <span>—</span>
                            <!-- repeat for seamless loop -->
                            <span>Now baking:</span>
                            <span>Butter Croissant 🥐</span>
                            <span>Sticky Cinnamon Roll ✨</span>
                            <span>Sourdough Boule 🍞</span>
                            <span>Blueberry Muffin 🫐</span>
                            <span>Almond Financier 🌰</span>
                        </div>
                    </div>

                    <!-- Quick-add dock -->
                    <div class="hero-dock mt-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="small text-muted">Quick add:</span>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="chip-add">
                                        <img src="{{ asset('assets/img/dishes/item_4.png') }}" alt="Butter Croissant">
                                        <span class="small">Croissant</span>
                                        <button class="btn btn-light btn-sm add-to-cart" data-name="Butter Croissant"
                                            data-price="3.2">+$3.2</button>
                                    </span>
                                    <span class="chip-add">
                                        <img src="{{ asset('assets/img/dishes/item_1.png') }}" alt="Vanilla Latte">
                                        <span class="small">Vanilla Latte</span>
                                        <button class="btn btn-light btn-sm add-to-cart" data-name="Vanilla Latte"
                                            data-price="4.9">+$4.9</button>
                                    </span>
                                    <span class="chip-add">
                                        <img src="{{ asset('assets/img/dishes/item_9.png') }}" alt="Cold Brew">
                                        <span class="small">Cold Brew</span>
                                        <button class="btn btn-light btn-sm add-to-cart" data-name="Cold Brew"
                                            data-price="4.2">+$4.2</button>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 small text-muted">
                                <img src="{{ asset('assets/img/gallery/google_review.png') }}" alt="Google 4.9 rating"
                                    height="28"
                                    style="border-radius:8px;border:1px solid var(--border);background:#fff">
                                <span>4.9★ • Loved by locals</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right column visual stack -->
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="skel" style="border-radius:22px;">
                                <img src="{{ asset('assets/img/gallery/bakery.png') }}" alt="Fresh pastry trays"
                                    class="w-100 h-100" style="object-fit:cover; display:block" loading="eager"
                                    fetchpriority="high" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="skel" style="border-radius:16px;">
                                <img src="{{ asset('assets/img/gallery/latte_art.png') }}" alt="Latte art"
                                    class="w-100 h-100" style="object-fit:cover" loading="lazy">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="skel" style="border-radius:16px;">
                                <img src="{{ asset('assets/img/gallery/pastry_detail.png') }}" alt="Pastry detail"
                                    class="w-100 h-100" style="object-fit:cover" loading="lazy">
                            </div>
                        </div>
                    </div>
                    <p class="small text-muted mt-2 text-center">All photos are placeholders—replace with your licensed
                        images.</p>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== QUICK ORDER PICKS ===== -->
    <section id="quick" class="py-5">
        <div class="container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-3">
                <div>
                    <h2 class="m-0">Quick order picks</h2>
                    <p class="text-muted m-0">Tap add — it goes to your cart.</p>
                </div>
                <a class="btn btn-outline-primary" href="#cart" data-bs-toggle="offcanvas"
                    data-bs-target="#cartCanvas"><i class="bi bi-bag"></i> View cart</a>
            </div>

            <div class="row g-4 quick-picks">
                <!-- Pick -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card-soft p-2 pick h-100">
                        <div class="skel"><img src="{{ asset('assets/img/dishes/item_1.png') }}"
                                alt="Vanilla Latte" class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-2">
                            <h6 class="mb-0">Vanilla Latte</h6><span class="price-badge">$4.9</span>
                        </div>
                        <p class="text-muted small mb-2">Velvety milk + double shot.</p>
                        <button class="btn btn-primary btn-sm add-to-cart" data-name="Vanilla Latte"
                            data-price="4.9"><i class="bi bi-bag-plus"></i> Add</button>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card-soft p-2 pick h-100">
                        <div class="skel"><img src="{{ asset('assets/img/dishes/item_4.png') }}"
                                alt="Butter Croissant" class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-2">
                            <h6 class="mb-0">Butter Croissant</h6><span class="price-badge">$3.2</span>
                        </div>
                        <p class="text-muted small mb-2">Flaky, AOP butter.</p>
                        <button class="btn btn-primary btn-sm add-to-cart" data-name="Butter Croissant"
                            data-price="3.2"><i class="bi bi-bag-plus"></i> Add</button>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card-soft p-2 pick h-100">
                        <div class="skel"><img src="{{ asset('assets/img/dishes/item_9.png') }}" alt="Cold Brew"
                                class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-2">
                            <h6 class="mb-0">Cold Brew</h6><span class="price-badge">$4.2</span>
                        </div>
                        <p class="text-muted small mb-2">12-hour steep, smooth.</p>
                        <button class="btn btn-primary btn-sm add-to-cart" data-name="Cold Brew" data-price="4.2"><i
                                class="bi bi-bag-plus"></i> Add</button>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card-soft p-2 pick h-100">
                        <div class="skel"><img src="{{ asset('assets/img/dishes/item_10.png') }}"
                                alt="Cinnamon Roll" class="w-100" loading="lazy"></div>
                        <div class="d-flex justify-content-between align-items-start mt-2">
                            <h6 class="mb-0">Cinnamon Roll</h6><span class="price-badge">$3.8</span>
                        </div>
                        <p class="text-muted small mb-2">Sticky glaze, warm spices.</p>
                        <button class="btn btn-primary btn-sm add-to-cart" data-name="Cinnamon Roll"
                            data-price="3.8"><i class="bi bi-bag-plus"></i> Add</button>
                    </div>
                </div>
            </div>

            <!-- Seasonal strip -->
            <div class="card-soft d-flex align-items-center gap-3 p-3 mt-4">
                <div class="skel" style="width:64px;height:64px;border-radius:12px;flex:0 0 auto;">
                    <img src="{{ asset('assets/img/gallery/sticky-cinnamon-roll.png') }}" alt="Cinnamon roll"
                        width="64" height="64" style="object-fit:cover" loading="lazy">
                </div>
                <div class="flex-grow-1">
                    <strong>Seasonal box:</strong> 6× Sticky Cinnamon Roll — limited batches daily.
                    <div class="text-muted small">Baked at 9am, noon & 4pm. Pre-order recommended.</div>
                </div>
                <button class="btn btn-outline-primary add-to-cart" data-name="Seasonal Roll Box (6)"
                    data-price="21.0">Pre-order $21</button>
            </div>
        </div>
    </section>

    <!-- ===== WEEKLY SPECIALS (Carousel) ===== -->
    <section id="specials" class="py-5 specials" style="background:var(--surface)">
        <div class="container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-3">
                <div>
                    <h2 class="m-0">Weekly specials</h2>
                    <p class="text-muted m-0">Rotating bakes & limited coffee drops.</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light btn-sm" type="button" data-bs-target="#specCarousel"
                        data-bs-slide="prev" aria-label="Prev"><i class="bi bi-chevron-left"></i></button>
                    <button class="btn btn-primary btn-sm" type="button" data-bs-target="#specCarousel"
                        data-bs-slide="next" aria-label="Next"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>

            <div id="specCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="card-soft h-100 p-2">
                                    <div class="skel"><img src="{{ asset('assets/img/dishes/item_7.png') }}"
                                            alt="Brioche French Toast" class="w-100" loading="lazy"></div>
                                    <div class="p-2">
                                        <h6 class="mb-1">Brioche French Toast</h6>
                                        <p class="text-muted small mb-2">Maple, berries, mascarpone.</p>
                                        <button class="btn btn-outline-primary btn-sm add-to-cart"
                                            data-name="Brioche French Toast" data-price="9.9"><i
                                                class="bi bi-bag-plus"></i> Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-soft h-100 p-2">
                                    <div class="skel"><img src="{{ asset('assets/img/dishes/item_5.png') }}"
                                            alt="Sourdough Avo Toast" class="w-100" loading="lazy"></div>
                                    <div class="p-2">
                                        <h6 class="mb-1">Sourdough Avo Toast</h6>
                                        <p class="text-muted small mb-2">Heirloom tomatoes, feta.</p>
                                        <button class="btn btn-outline-primary btn-sm add-to-cart"
                                            data-name="Sourdough Avo Toast" data-price="8.9"><i
                                                class="bi bi-bag-plus"></i> Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-soft h-100 p-2">
                                    <div class="skel"><img src="{{ asset('assets/img/dishes/item_2.png') }}"
                                            alt="Blueberry Muffin" class="w-100" loading="lazy"></div>
                                    <div class="p-2">
                                        <h6 class="mb-1">Blueberry Muffin</h6>
                                        <p class="text-muted small mb-2">Moist crumb, bursting berries.</p>
                                        <button class="btn btn-outline-primary btn-sm add-to-cart"
                                            data-name="Blueberry Muffin" data-price="3.1"><i
                                                class="bi bi-bag-plus"></i> Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="card-soft h-100 p-2">
                                    <div class="skel"><img src="{{ asset('assets/img/dishes/item_6.png') }}"
                                            alt="Americano" class="w-100" loading="lazy"></div>
                                    <div class="p-2">
                                        <h6 class="mb-1">Americano</h6>
                                        <p class="text-muted small mb-2">Bold espresso, hot water finish.</p>
                                        <button class="btn btn-outline-primary btn-sm add-to-cart"
                                            data-name="Americano" data-price="3.5"><i class="bi bi-bag-plus"></i>
                                            Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-soft h-100 p-2">
                                    <div class="skel"><img src="{{ asset('assets/img/dishes/item_8.png') }}"
                                            alt="Herb Omelette" class="w-100" loading="lazy"></div>
                                    <div class="p-2">
                                        <h6 class="mb-1">Herb Omelette</h6>
                                        <p class="text-muted small mb-2">Chives, gruyère, side salad.</p>
                                        <button class="btn btn-outline-primary btn-sm add-to-cart"
                                            data-name="Herb Omelette" data-price="7.9"><i class="bi bi-bag-plus"></i>
                                            Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-soft h-100 p-2">
                                    <div class="skel"><img src="{{ asset('assets/img/dishes/item_10.png') }}"
                                            alt="Cinnamon Roll" class="w-100" loading="lazy"></div>
                                    <div class="p-2">
                                        <h6 class="mb-1">Cinnamon Roll</h6>
                                        <p class="text-muted small mb-2">Sticky glaze, warm spices.</p>
                                        <button class="btn btn-outline-primary btn-sm add-to-cart"
                                            data-name="Cinnamon Roll" data-price="3.8"><i class="bi bi-bag-plus"></i>
                                            Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- /carousel-inner -->
            </div>
        </div>
    </section>

    <!-- ===== DRINK CONFIGURATOR ===== -->
    <section id="builder" class="py-5">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-5">
                    <div class="skel" style="border-radius:22px; height:100%;">
                        <img src="{{ asset('assets/img/gallery/latte_art.png') }}" alt="Build your drink"
                            class="w-100 h-100" style="object-fit:cover" loading="lazy">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="d-flex align-items-end justify-content-between gap-3 mb-2">
                        <div>
                            <h2 class="m-0">Build your drink</h2>
                            <p class="text-muted m-0">Pick size, milk, shots & flavors — price updates instantly.</p>
                        </div>
                        <span class="total"><i class="bi bi-cash-coin"></i> Total <strong
                                id="builderTotal">$3.50</strong></span>
                    </div>

                    <div class="config">
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Base (choose one)</div>
                            <div class="d-flex flex-wrap gap-2" id="baseOpts">
                                <span class="opt active" data-price="3.5" data-name="Americano">Americano</span>
                                <span class="opt" data-price="4.2" data-name="Latte">Latte</span>
                                <span class="opt" data-price="4.8" data-name="Cappuccino">Cappuccino</span>
                                <span class="opt" data-price="4.9" data-name="Mocha">Mocha</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">Size</div>
                            <div class="d-flex flex-wrap gap-2" id="sizeOpts">
                                <span class="opt active" data-mult="1.00" data-name="S">S</span>
                                <span class="opt" data-mult="1.15" data-name="M">M</span>
                                <span class="opt" data-mult="1.30" data-name="L">L</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">Milk</div>
                            <div class="d-flex flex-wrap gap-2" id="milkOpts">
                                <span class="opt active" data-extra="0" data-name="Whole">Whole</span>
                                <span class="opt" data-extra="0.3" data-name="Oat">Oat +$0.3</span>
                                <span class="opt" data-extra="0.2" data-name="Almond">Almond +$0.2</span>
                                <span class="opt" data-extra="0.4" data-name="Lactose-free">Lactose-free
                                    +$0.4</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">Extras</div>
                            <div class="d-flex flex-wrap gap-2" id="extraOpts">
                                <label class="opt"><input type="checkbox" class="form-check-input me-1"
                                        value="0.8" data-name="Extra shot"> Extra shot +$0.8</label>
                                <label class="opt"><input type="checkbox" class="form-check-input me-1"
                                        value="0.4" data-name="Vanilla"> Vanilla +$0.4</label>
                                <label class="opt"><input type="checkbox" class="form-check-input me-1"
                                        value="0.4" data-name="Caramel"> Caramel +$0.4</label>
                                <label class="opt"><input type="checkbox" class="form-check-input me-1"
                                        value="0.4" data-name="Hazelnut"> Hazelnut +$0.4</label>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <button class="btn btn-primary" id="addBuilt"><i class="bi bi-bag-plus"></i> Add to
                                cart</button>
                            <button class="btn btn-light" type="button" id="resetBuilder">Reset</button>
                            <span class="small text-muted" id="builderMsg" aria-live="polite"></span>
                        </div>
                    </div>

                    <p class="small text-muted mt-2">Alt milks add a small surcharge. Nutritional info in FAQ.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SUBSCRIPTIONS & GIFTS ===== -->
    <section id="subs" class="py-5" style="background:var(--surface)">
        <div class="container">
            <div class="text-center">
                <h2 class="mb-1">Subscriptions & gifts</h2>
                <p class="text-muted">Fresh roasts and bakes — set & forget.</p>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft plan h-100">
                        <span class="badge rounded-pill mb-2"><i class="bi bi-box-seam"></i> Coffee</span>
                        <h6 class="fw-bold">Bean Box — Weekly</h6>
                        <p class="text-muted small">250g single-origin, roasted Tuesday. Pickup Friday.</p>
                        <button class="btn btn-outline-primary btn-sm add-to-cart" data-name="Bean Box (Weekly)"
                            data-price="12">Subscribe $12/wk</button>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft plan h-100">
                        <span class="badge rounded-pill mb-2"><i class="bi bi-bag-heart"></i> Pastry</span>
                        <h6 class="fw-bold">Weekend Pastry Pack</h6>
                        <p class="text-muted small">6 assorted viennoiseries — perfect for brunch.</p>
                        <button class="btn btn-outline-primary btn-sm add-to-cart" data-name="Weekend Pastry Pack"
                            data-price="18">Add $18</button>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft plan h-100">
                        <span class="badge rounded-pill mb-2"><i class="bi bi-gift"></i> Gifts</span>
                        <h6 class="fw-bold">Digital Gift Card</h6>
                        <p class="text-muted small">Delivered instantly. Redeem in-store.</p>
                        <button class="btn btn-outline-primary btn-sm add-to-cart" data-name="Gift Card $25"
                            data-price="25">$25</button>
                        <button class="btn btn-light btn-sm add-to-cart" data-name="Gift Card $50"
                            data-price="50">$50</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== WORKSHOPS & EVENTS ===== -->
    <section id="workshops" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="mb-1">Workshops</h2>
                <p class="text-muted">Learn with our bakers — small groups, hands-on.</p>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-md-6">
                    <div class="card-soft workshop h-100 p-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-5">
                                <div class="skel" style="border-radius:16px;">
                                    <img src="{{ asset('assets/img/gallery/fresh_bread.png') }}" alt="Sourdough 101"
                                        class="w-100 h-100" style="object-fit:cover" loading="lazy">
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="fw-bold m-0">Sourdough 101</h6>
                                    <span class="date-badge">Sat 10:00</span>
                                </div>
                                <p class="text-muted small mb-2">Starter care, shaping & baking.</p>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#workshopModal">Save seat — $39</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-soft workshop h-100 p-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-5">
                                <div class="skel" style="border-radius:16px;">
                                    <img src="{{ asset('assets/img/gallery/workshop_1.png') }}"
                                        alt="Latte Art Basics" class="w-100 h-100" style="object-fit:cover"
                                        loading="lazy">
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="fw-bold m-0">Latte Art Basics</h6>
                                    <span class="date-badge">Sun 15:00</span>
                                </div>
                                <p class="text-muted small mb-2">Milk texture & pours.</p>
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#workshopModal">Save seat — $29</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Signup Modal -->
            <div class="modal fade" id="workshopModal" tabindex="-1" aria-hidden="true"
                aria-labelledby="workshopLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="workshopLabel">Reserve your spot</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="wsForm" class="needs-validation" novalidate>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" required>
                                    <div class="invalid-feedback">Enter your name.</div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" required>
                                    <div class="invalid-feedback">Valid email required.</div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Workshop</label>
                                    <select class="form-select" id="wsSelect" required>
                                        <option value="Sourdough 101 (Sat 10:00)">Sourdough 101 (Sat 10:00)</option>
                                        <option value="Latte Art Basics (Sun 15:00)">Latte Art Basics (Sun 15:00)
                                        </option>
                                    </select>
                                </div>
                                <div class="form-text">You’ll receive a confirmation email with details.</div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Reserve</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ===== BEHIND THE SCENES (improved) ===== -->
    <section id="gallery" class="py-5" style="background:var(--surface)">
        <div class="container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-3">
                <h2 class="m-0">Behind the scenes</h2>
                <p class="text-muted m-0">Click any photo • use ← → keys</p>
            </div>

            <div class="row g-3">
                <!-- 1 -->
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-item" data-index="0"
                        data-full="{{ asset('assets/img/gallery/pastry_detail.png') }}" data-caption="Pastry detail">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/pastry_detail.png') }}"
                                alt="Pastry detail" class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <!-- 2 -->
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-item" data-index="1"
                        data-full="{{ asset('assets/img/gallery/cakes.png') }}" data-caption="Cakes">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/cakes.png') }}" alt="Cakes"
                                class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <!-- 3 -->
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-item" data-index="2"
                        data-full="{{ asset('assets/img/gallery/fresh_bread.png') }}" data-caption="Fresh bread">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/fresh_bread.png') }}"
                                alt="Fresh bread" class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <!-- 4 -->
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-item" data-index="3"
                        data-full="{{ asset('assets/img/gallery/latte_art.png') }}" data-caption="Latte art">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/latte_art.png') }}"
                                alt="Latte art" class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <!-- 5 -->
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-item" data-index="4"
                        data-full="{{ asset('assets/img/gallery/brunch_table.png') }}" data-caption="Brunch table">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/brunch_table.png') }}"
                                alt="Brunch table" class="w-100" loading="lazy"></div>
                    </a>
                </div>
                <!-- 6 -->
                <div class="col-6 col-md-4">
                    <a href="#" class="d-block gallery-item" data-index="5"
                        data-full="{{ asset('assets/img/gallery/outdoor_setting.png') }}"
                        data-caption="Outdoor seating">
                        <div class="skel"><img src="{{ asset('assets/img/gallery/outdoor_setting.png') }}"
                                alt="Outdoor seating" class="w-100" loading="lazy"></div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true" aria-labelledby="galleryLabel">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="galleryLabel">Behind the scenes</h6>
                        <div class="ms-auto small text-muted" id="galleryCounter" aria-live="polite"></div>
                        <button type="button" class="btn-close ms-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 position-relative">
                        <button class="btn btn-light btn-sm gallery-prev" type="button" aria-label="Previous"><i
                                class="bi bi-chevron-left"></i></button>
                        <button class="btn btn-light btn-sm gallery-next" type="button" aria-label="Next"><i
                                class="bi bi-chevron-right"></i></button>

                        <figure class="m-0">
                            <img id="galleryFull" src="" alt="" class="w-100" style="display:block">
                            <figcaption id="galleryCap" class="small text-muted p-2"></figcaption>
                        </figure>
                    </div>
                    <div class="p-2 border-top" style="border-color:var(--border)!important;">
                        <div id="lightboxThumbs" class="d-flex gap-2 overflow-auto pb-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ===== PRESS & PARTNERS ===== -->
    <section id="press" class="press py-4">
        <div class="container">
            <div class="text-center text-muted mb-2">As seen in & loved by</div>
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                <img src="{{ asset('assets/img/gallery/google_review.png') }}" alt="Google rating 4.9 out of 5"
                    height="44" loading="lazy">
                <img src="assets/img/clients/tripadvisor-choice.png" alt="Tripadvisor Travelers’ Choice"
                    height="44" loading="lazy">
                <img src="assets/img/clients/yelp-love.png" alt="Yelp — People Love Us" height="44"
                    loading="lazy">
                <img src="assets/img/clients/oldtown-weekly.png" alt="Featured in Oldtown Weekly" height="44"
                    loading="lazy">
                <img src="assets/img/clients/hotel-oasis.png" alt="Catering partner — Hotel Oasis" height="44"
                    loading="lazy">
            </div>
        </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section id="faq" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="mb-1">FAQ & allergens</h2>
                <p class="text-muted">Straight answers — more on request.</p>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-lg-7">
                    <div class="accordion faq" id="faqAcc">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#f1">Do you have gluten-free options?</button>
                            </h2>
                            <div id="f1" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body">Yes — selected cakes & an herb omelette are gluten-free.
                                    Cross-contact may occur in a shared kitchen.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#f2">Which milks do you carry?</button>
                            </h2>
                            <div id="f2" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body">Whole, Oat (+$0.3), Almond (+$0.2), Lactose-free (+$0.4).
                                    Charges help us keep alt-milk stocked & chilled.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#f3">Do you take large pre-orders?</button>
                            </h2>
                            <div id="f3" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body">Absolutely — see Subscriptions for boxes or email us for
                                    custom assortments.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card-soft p-3 h-100">
                        <h6 class="fw-bold">Allergen key</h6>
                        <ul class="small text-muted mb-3">
                            <li>🌾 Contains gluten</li>
                            <li>🥛 Contains dairy</li>
                            <li>🥜 Contains nuts</li>
                            <li>🌱 Plant-based</li>
                        </ul>
                        <p class="small text-muted mb-0">Ask our team about ingredients. We’ll do our best to
                            accommodate.</p>
                    </div>
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
                        <ul class="list-unstyled text-muted small mb-3">
                            <li>Mon–Fri: 7:00 – 22:00</li>
                            <li>Sat–Sun: 8:00 – 23:00</li>
                        </ul>
                        <a class="btn btn-outline-primary btn-sm" href="#map"><i class="bi bi-geo"></i> Get
                            directions</a>
                    </div>
                </div>
                <div class="col-lg-7" id="map">
                    <div class="skel" style="border-radius:22px; height:100%;">
                        <img src="{{ asset('assets/img/gallery/map.png') }}" alt="Map and directions"
                            class="w-100 h-100" style="object-fit:cover" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta text-center">
        <div class="container">
            <h2 class="fw-bold mb-2">Order in a minute</h2>
            <p class="mb-4 text-muted">Add your favorites & checkout at the counter.</p>
            <div class="d-flex gap-2 justify-content-center">
                <button class="btn btn-light btn-lg" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas"><i
                        class="bi bi-bag"></i> View cart</button>
                <a href="#quick" class="btn btn-outline-primary btn-lg">Add items</a>
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
                        <li class="mb-2"><a class="link-body-emphasis" href="#quick">Quick order</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#builder">Drink Builder</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#subs">Subscriptions</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#workshops">Workshops</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-3">
                    <h6 class="fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled small m-0">
                        <li class="mb-2"><a class="link-body-emphasis" href="#">Gift cards</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#faq">Allergens</a></li>
                        <li class="mb-2"><a class="link-body-emphasis" href="#press">Press</a></li>
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
            <span class="small">Build your drink</span>
        </div>
        <div class="d-flex gap-2">
            <a href="#builder" class="btn btn-primary btn-sm">Start</a>
            <button class="btn btn-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas">Cart
                <span class="badge text-bg-secondary" id="cartCountMobile">0</span></button>
        </div>
    </div>

    <!-- Offcanvas Cart -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartCanvas" aria-labelledby="cartLabel"
        style="background:var(--surface); border-left:1px solid var(--border)">
        <div class="offcanvas-header">
            <h5 id="cartLabel" class="m-0">Your cart</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="cartEmpty" class="text-muted small">Your cart is empty.</div>
            <div id="cartLines" class="d-grid gap-1"></div>
        </div>
        <div class="offcanvas-footer p-3 border-top" style="border-color:var(--border)!important;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <strong>Total</strong> <strong id="cartTotal">$0.00</strong>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" id="checkoutBtn" disabled>Checkout at counter</button>
                <button class="btn btn-light" id="clearCart" disabled>Clear cart</button>
            </div>
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

            // Theme toggle (desktop + mobile)
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

            // HERO v3 — open/closed state + next bake countdown
            const openState = document.getElementById('openState');
            const bakeEta = document.getElementById('bakeEta');

            function isOpen(now = new Date()) {
                const h = now.getHours(),
                    m = now.getMinutes();
                const mins = h * 60 + m;
                const open = 7 * 60,
                    close = 22 * 60; // 7:00–22:00
                return mins >= open && mins < close;
            }

            function fmt(mm) {
                const h = Math.floor(mm / 60);
                const m = Math.floor(mm % 60);
                if (h <= 0) return `${m}m`;
                return `${h}h ${m}m`;
            }

            function minsToNextBake(now = new Date()) {
                // Bakes at 09:00, 12:00, 16:00 local time
                const slots = [9 * 60, 12 * 60, 16 * 60];
                const cur = now.getHours() * 60 + now.getMinutes();
                let next = slots.find(s => s > cur);
                let target = new Date(now);
                if (next == null) {
                    // next is tomorrow 09:00
                    target.setDate(now.getDate() + 1);
                    next = 9 * 60;
                }
                const tH = Math.floor(next / 60),
                    tM = next % 60;
                target.setHours(tH, tM, 0, 0);
                const diffMs = target - now;
                return Math.max(0, Math.round(diffMs / 60000));
            }

            function updateHeroStatus() {
                const now = new Date();
                openState.innerHTML = (isOpen(now) ?
                    '<i class="bi bi-circle-fill text-success"></i> Open now • 7:00–22:00' :
                    '<i class="bi bi-circle-fill text-danger"></i> Closed • Opens 7:00');
                const mm = minsToNextBake(now);
                bakeEta.textContent = fmt(mm);
            }
            updateHeroStatus();
            setInterval(updateHeroStatus, 30 * 1000); // refresh every 30s

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

            // Workshops form demo
            const wsForm = document.getElementById('wsForm');
            wsForm?.addEventListener('submit', (e) => {
                e.preventDefault();
                if (!wsForm.checkValidity()) {
                    wsForm.classList.add('was-validated');
                    return;
                }
                const sel = document.getElementById('wsSelect');
                alert('Seat reserved for ' + (sel?.value || 'workshop') + ' ✅');
                bootstrap.Modal.getInstance(document.getElementById('workshopModal'))?.hide();
                wsForm.reset();
                wsForm.classList.remove('was-validated');
            });

            // ===== CART LOGIC =====
            const cart = [];
            const cartLines = document.getElementById('cartLines');
            const cartEmpty = document.getElementById('cartEmpty');
            const cartTotal = document.getElementById('cartTotal');
            const cartCount = document.getElementById('cartCount');
            const cartCountMobile = document.getElementById('cartCountMobile');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const clearCart = document.getElementById('clearCart');

            function money(n) {
                return '$' + (Math.round(n * 100) / 100).toFixed(2);
            }

            function renderCart() {
                cartLines.innerHTML = '';
                let total = 0;
                cart.forEach((line, i) => {
                    total += line.price * line.qty;
                    const row = document.createElement('div');
                    row.className = 'cart-line';
                    row.innerHTML = `
            <div class="small">
              <strong>${line.name}</strong>
              ${line.meta ? `<div class="text-muted">${line.meta}</div>` : ''}
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="text-muted small">x${line.qty}</span>
              <strong>${money(line.price * line.qty)}</strong>
              <button class="btn btn-light btn-sm" aria-label="Remove"><i class="bi bi-x"></i></button>
            </div>`;
                    row.querySelector('button')?.addEventListener('click', () => {
                        cart.splice(i, 1);
                        updateCart();
                    });
                    cartLines.appendChild(row);
                });
                cartEmpty.style.display = cart.length ? 'none' : 'block';
                cartTotal.textContent = money(total);
                cartCount.textContent = String(cart.length);
                cartCountMobile.textContent = String(cart.length);
                checkoutBtn.disabled = cart.length === 0;
                clearCart.disabled = cart.length === 0;
            }

            function updateCart() {
                renderCart();
            }

            // Add to cart buttons
            document.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.addEventListener('click', () => {
                    const name = btn.dataset.name || 'Item';
                    const price = parseFloat(btn.dataset.price || '0');
                    cart.push({
                        name,
                        price,
                        qty: 1
                    });
                    updateCart();
                });
            });
            clearCart?.addEventListener('click', () => {
                cart.length = 0;
                updateCart();
            });
            checkoutBtn?.addEventListener('click', () => {
                alert('Order saved. Pay at counter.');
                cart.length = 0;
                updateCart();
            });

            // ===== DRINK BUILDER =====
            const totalEl = document.getElementById('builderTotal');
            const base = document.getElementById('baseOpts');
            const size = document.getElementById('sizeOpts');
            const milk = document.getElementById('milkOpts');
            const extras = document.getElementById('extraOpts');
            const addBuilt = document.getElementById('addBuilt');
            const resetBuilder = document.getElementById('resetBuilder');
            const builderMsg = document.getElementById('builderMsg');

            function pick(container, el) {
                container.querySelectorAll('.opt').forEach(o => o.classList.remove('active'));
                el.classList.add('active');
                calc();
            }
            base?.addEventListener('click', (e) => {
                const el = e.target.closest('.opt');
                if (el) pick(base, el);
            });
            size?.addEventListener('click', (e) => {
                const el = e.target.closest('.opt');
                if (el) pick(size, el);
            });
            milk?.addEventListener('click', (e) => {
                const el = e.target.closest('.opt');
                if (el && el.tagName === 'SPAN') pick(milk, el);
            });
            extras?.addEventListener('change', calc);

            function calc() {
                const baseEl = base?.querySelector('.opt.active') || {
                    dataset: {
                        price: '3.5',
                        name: 'Americano'
                    }
                };
                const sizeEl = size?.querySelector('.opt.active') || {
                    dataset: {
                        mult: '1.00',
                        name: 'S'
                    }
                };
                const milkEl = milk?.querySelector('.opt.active') || {
                    dataset: {
                        extra: '0',
                        name: 'Whole'
                    }
                };
                const extraVals = Array.from(extras?.querySelectorAll('input:checked') || []).map(i => parseFloat(i
                    .value));
                const sumExtras = extraVals.reduce((a, b) => a + b, 0);
                let basePrice = parseFloat(baseEl.dataset.price || '3.5');
                const mult = parseFloat(sizeEl.dataset.mult || '1.00');
                const milkExtra = parseFloat(milkEl.dataset.extra || '0');
                const total = (basePrice * mult) + milkExtra + sumExtras;
                totalEl.textContent = money(total);
                return {
                    total,
                    base: baseEl.dataset.name,
                    size: sizeEl.dataset.name,
                    milk: milkEl.dataset.name,
                    extras: Array.from(extras?.querySelectorAll('input:checked') || []).map(i => i.dataset.name)
                };
            }
            calc();

            addBuilt?.addEventListener('click', () => {
                const c = calc();
                cart.push({
                    name: `${c.base} (${c.size})`,
                    price: parseFloat(c.total.toFixed(2)),
                    qty: 1,
                    meta: `${c.milk}${c.extras.length ? ' • ' + c.extras.join(', ') : ''}`
                });
                updateCart();
                builderMsg.textContent = 'Added to cart.';
                builderMsg.className = 'small text-success';
                setTimeout(() => {
                    builderMsg.textContent = '';
                    builderMsg.className = 'small text-muted';
                }, 2500);
            });
            resetBuilder?.addEventListener('click', () => {
                base?.querySelectorAll('.opt').forEach((o, i) => o.classList.toggle('active', i === 0));
                size?.querySelectorAll('.opt').forEach((o, i) => o.classList.toggle('active', i === 0));
                milk?.querySelectorAll('.opt').forEach((o, i) => o.classList.toggle('active', i === 0));
                extras?.querySelectorAll('input').forEach(i => i.checked = false);
                calc();
            });

            // Gallery (improved lightbox with prev/next, keyboard, thumbnails)
            (function() {
                const items = Array.from(document.querySelectorAll('#gallery .gallery-item'));
                if (!items.length) return;

                const modalEl = document.getElementById('galleryModal');
                const modal = new bootstrap.Modal(modalEl);
                const full = document.getElementById('galleryFull');
                const cap = document.getElementById('galleryCap');
                const counter = document.getElementById('galleryCounter');
                const thumbsWrap = document.getElementById('lightboxThumbs');
                const prevBtn = modalEl.querySelector('.gallery-prev');
                const nextBtn = modalEl.querySelector('.gallery-next');

                const data = items.map(a => ({
                    src: a.dataset.full,
                    alt: a.querySelector('img')?.alt || '',
                    cap: a.dataset.caption || ''
                }));

                // Build thumbs once
                let current = 0;
                thumbsWrap.innerHTML = '';
                data.forEach((d, i) => {
                    const btn = document.createElement('button');
                    btn.setAttribute('type', 'button');
                    btn.setAttribute('aria-label', `Open image ${i + 1}`);
                    const img = document.createElement('img');
                    img.src = d.src;
                    img.alt = d.alt || `Image ${i + 1}`;
                    btn.appendChild(img);
                    btn.addEventListener('click', () => show(i));
                    thumbsWrap.appendChild(btn);
                });

                function preload(i) {
                    const n = new Image();
                    n.src = data[i]?.src || '';
                }

                function show(i) {
                    current = (i + data.length) % data.length;
                    const d = data[current];
                    full.src = d.src;
                    full.alt = d.alt || '';
                    // Optional: keep image centered in viewport on small screens
                    full.scrollIntoView({ block: 'center', inline: 'nearest' });
                    cap.textContent = d.cap || d.alt || '';
                    counter.textContent = `${current + 1} / ${data.length}`;
                    // Active thumb
                    thumbsWrap.querySelectorAll('img').forEach((t, idx) => t.classList.toggle('active', idx ===
                        current));
                    // Keep active thumb in view
                    thumbsWrap.querySelectorAll('button')[current]?.scrollIntoView({
                        inline: 'center',
                        block: 'nearest',
                        behavior: 'smooth'
                    });
                    // Preload neighbors
                    preload((current + 1) % data.length);
                    preload((current - 1 + data.length) % data.length);
                }

                // Open from grid
                document.getElementById('gallery')?.addEventListener('click', (e) => {
                    const a = e.target.closest('.gallery-item');
                    if (!a) return;
                    e.preventDefault();
                    const idx = parseInt(a.dataset.index || '0', 10) || 0;
                    modal.show();
                    setTimeout(() => show(idx), 30);
                });

                // Prev/Next
                prevBtn?.addEventListener('click', () => show(current - 1));
                nextBtn?.addEventListener('click', () => show(current + 1));

                // Keyboard nav while modal open
                modalEl.addEventListener('shown.bs.modal', () => {
                    const onKey = (ev) => {
                        if (ev.key === 'ArrowLeft') show(current - 1);
                        if (ev.key === 'ArrowRight') show(current + 1);
                    };
                    document.addEventListener('keydown', onKey);
                    modalEl.addEventListener('hidden.bs.modal', () => document.removeEventListener(
                        'keydown', onKey), {
                        once: true
                    });
                });

                // Basic swipe (mobile)
                let startX = 0;
                full.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                }, {
                    passive: true
                });
                full.addEventListener('touchend', (e) => {
                    const dx = e.changedTouches[0].clientX - startX;
                    if (Math.abs(dx) > 40) dx > 0 ? show(current - 1) : show(current + 1);
                }, {
                    passive: true
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
        });
    </script>
</body>

</html>
