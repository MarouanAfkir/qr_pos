<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <!-- ========= META ========= -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description"
        content="QRevo — Menu digital moderne : QR personnalisés, multilingue, statistiques en temps réel et (optionnel) commande en salle." />
    <meta name="theme-color" content="#FF8A3D" />
    <title>QRevo — Le menu digital moderne</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- ========= FONTS & CSS ========= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        /* ============================================================
       Soft orange palette + calm, creamy UI
    ============================================================ */
        :root {
            --brand: #FF8A3D;
            /* soft orange */
            --brand-600: #F56A1E;
            /* deeper orange */
            --brand-700: #E85C0D;
            /* accent on hover */

            --peach: #FFE9D1;
            /* creamy peach */
            --apricot: #FFF1E6;
            /* very light apricot (used to replace mint) */
            --bg: #FFF8F2;
            /* page background (cream) */

            --ink: #1f2937;
            --muted: #667085;
            --surface: #ffffff;
            --surface-2: #FFF6EE;
            --border: #F2E7DC;
            --ring: rgba(255, 138, 61, .25);

            --success: #16a34a;
            --danger: #ef4444;

            --radius: 18px;
            --shadow-1: 0 6px 20px rgba(2, 6, 23, .06);
            --shadow-2: 0 16px 40px rgba(2, 6, 23, .10);
        }

        html {
            scroll-behavior: smooth
        }

        body {
            font-family: 'Manrope', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 480px at 80% -10%, rgba(255, 138, 61, .10), transparent 60%),
                var(--bg);
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

        /* ===== NAVBAR ===== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1040;
            background: rgba(255, 255, 255, .86);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            transition: box-shadow .25s ease, padding .2s ease, background .25s ease;
            padding: .7rem 0;
        }

        .navbar::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 2px;
            background: linear-gradient(90deg, var(--peach), var(--apricot));
            opacity: .55;
            pointer-events: none;
        }

        .navbar.scrolled {
            background: #fff;
            box-shadow: 0 10px 28px rgba(0, 0, 0, .06);
            padding: .45rem 0;
        }

        #scrollProgress {
            position: absolute;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, var(--brand), #FFC078);
            border-bottom-right-radius: 3px;
            border-top-right-radius: 3px;
            transition: width .15s ease;
        }

        .navbar .navbar-brand strong {
            font-weight: 800;
            letter-spacing: .2px
        }

        .navbar .nav-link {
            font-weight: 600;
            padding: .45rem .8rem;
            border-radius: 999px;
            position: relative;
            color: var(--ink);
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            background: rgba(255, 138, 61, .10);
            color: var(--ink);
        }

        .navbar .nav-link:focus-visible {
            outline: 0;
            box-shadow: 0 0 0 4px var(--ring);
        }

        .nav-group {
            position: relative
        }

        .nav-indicator {
            position: absolute;
            height: 2px;
            bottom: -6px;
            left: 0;
            width: 0;
            background: linear-gradient(90deg, var(--brand), #FFC078);
            border-radius: 2px;
            opacity: 0;
            transition: transform .25s ease, width .25s ease, opacity .2s ease;
            pointer-events: none;
        }

        .btn-primary {
            --bs-btn-bg: var(--brand);
            --bs-btn-border-color: var(--brand);
            --bs-btn-hover-bg: var(--brand-600);
            --bs-btn-hover-border-color: var(--brand-600);
            box-shadow: 0 10px 20px rgba(255, 138, 61, .22);
            border-radius: 12px;
            font-weight: 700;
        }

        .btn-outline-primary {
            --bs-btn-color: var(--brand);
            --bs-btn-border-color: var(--brand);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: var(--brand);
            --bs-btn-hover-border-color: var(--brand);
            border-radius: 12px;
            font-weight: 700;
            background: transparent;
        }

        .btn-light {
            border-radius: 12px;
            font-weight: 700
        }

        .offcanvas-nav {
            background: #fff;
            border-left: 1px solid var(--border);
        }

        .offcanvas-nav .list-group-item {
            border: 0;
            padding: .9rem 0;
            font-weight: 700;
        }

        .offcanvas-nav .list-group {
            border: 0;
            border-radius: 0;
        }

        .offcanvas-header {
            border-bottom: 1px solid var(--border);
            background: linear-gradient(90deg, var(--apricot), var(--peach));
        }

        /* ===== Hero ===== */
        .hero {
            padding: 64px 0 56px;
            background: linear-gradient(135deg, var(--peach) 0%, var(--apricot) 100%);
            border-bottom: 1px solid var(--border);
            position: relative;
            isolation: isolate;
        }

        .hero .badge-soft {
            background: #fff;
            color: var(--brand);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .4rem .7rem;
            font-weight: 700;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .06);
        }

        .hero h1 .spark {
            background: linear-gradient(90deg, var(--brand) 0%, #FFC078 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .phone {
            width: 320px;
            max-width: 90%;
            aspect-ratio: 9/19.5;
            border: 10px solid #0d1117;
            border-radius: 38px;
            background: #000;
            box-shadow: var(--shadow-2);
            position: relative;
            margin: 0 auto;
            overflow: hidden;
        }

        .phone .screen {
            position: absolute;
            inset: 0;
            background: #111827;
            display: grid;
            place-items: center
        }

        .phone .screen img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        /* ===== Sections / cards ===== */
        .section-title {
            margin-bottom: .5rem
        }

        .section-sub {
            color: var(--muted);
            margin-bottom: 2rem
        }

        .feature {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            height: 100%;
            box-shadow: var(--shadow-1);
            transition: transform .18s ease, box-shadow .18s ease;
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
            color: var(--brand);
            background: rgba(255, 138, 61, .10);
            margin-bottom: .75rem;
            border: 1px solid var(--border);
            font-size: 1.25rem;
        }

        .showcase {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem;
            box-shadow: var(--shadow-1);
        }

        .showcase .nav-link {
            border-radius: 10px;
            font-weight: 700;
            color: var(--muted)
        }

        .showcase .nav-link.active {
            color: var(--ink);
            background: rgba(255, 138, 61, .10);
            border: 1px solid rgba(255, 138, 61, .3);
        }

        .showcase .tab-pane {
            border-radius: 12px;
            background: var(--surface-2);
            border: 1px dashed var(--border);
            padding: 1rem;
            min-height: 280px;
        }

        /* ===== Comparison ===== */
        .compare {
            background: var(--surface-2);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 56px 0;
        }

        .compare-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-1);
            height: 100%;
            padding: 1.25rem;
        }

        .compare-card h5 {
            font-weight: 800;
        }

        .compare-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .compare-list li {
            display: flex;
            align-items: flex-start;
            gap: .6rem;
            padding: .5rem 0;
            border-bottom: 1px dashed var(--border);
            font-size: .95rem;
        }

        .compare-list li:last-child {
            border-bottom: 0;
        }

        .compare-list .icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: inline-grid;
            place-items: center;
            flex-shrink: 0;
        }

        .icon-yes {
            background: #F0FBF4;
            color: #0f7a3a;
            border: 1px solid #D7F3E1;
        }

        .icon-no {
            background: #FFF1F1;
            color: #c02626;
            border: 1px solid #FFE0E0;
        }

        .price-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-1);
            height: 100%;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .price-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-2)
        }

        .price-card.featured {
            border: 2px solid var(--brand)
        }

        .price-badge {
            background: linear-gradient(90deg, var(--brand), #FFC078);
            color: #fff;
            font-size: .75rem;
            padding: .25rem .6rem;
            border-radius: .5rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .08)
        }

        .toggle {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .3rem;
            box-shadow: var(--shadow-1);
        }

        .toggle .seg {
            border-radius: 999px;
            padding: .35rem .8rem;
            font-weight: 700;
            cursor: pointer;
            color: var(--muted);
        }

        .toggle .seg.active {
            background: rgba(255, 138, 61, .12);
            color: var(--ink);
            border: 1px solid rgba(255, 138, 61, .28)
        }

        .testimonial {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem;
            height: 100%;
            box-shadow: var(--shadow-1);
        }

        .cta {
            background:
                radial-gradient(900px 480px at 10% -10%, rgba(255, 192, 120, .25), transparent 60%),
                linear-gradient(135deg, var(--apricot), #FFEBD8);
            padding: 64px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        /* ===== Footer ===== */
        .site-footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .site-footer::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--apricot), var(--peach));
            opacity: .6;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: .6rem
        }

        .footer-brand img {
            height: 36px;
            width: auto
        }

        .footer-card {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem
        }

        .footer-link {
            color: var(--ink);
            text-decoration: none
        }

        .footer-link:hover {
            text-decoration: underline
        }

        .social a {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: #fff;
            margin-right: .35rem;
            color: var(--ink);
            transition: transform .12s ease, box-shadow .12s ease;
        }

        .social a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, .08)
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent)
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
            box-shadow: 0 -8px 24px rgba(0, 0, 0, .08);
        }

        @media (max-width: 991.98px) {
            .mobile-cta {
                display: flex
            }
        }

        /* ===== HERO CARD STYLING ===== */
        .hero .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-1);
            overflow: hidden;
            transition: transform .18s ease, box-shadow .18s ease;
            background: #fff;
        }

        .hero .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-2);
        }

        .hero .card img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Sizing helpers to achieve: big left + two stacked right */
        .card-tall {
            min-height: 460px;
        }

        .card-half {
            min-height: 220px;
        }

        @media (max-width: 575.98px) {
            .card-tall {
                min-height: 360px;
            }

            .card-half {
                min-height: 200px;
            }
        }

        /* ===== Product Tour (new showcase) ===== */
        .tour-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem;
            height: 100%;
            box-shadow: var(--shadow-1);
        }

        .tour-thumb {
            border: 1px solid var(--border);
            background: #fff;
            border-radius: 12px;
            padding: .35rem;
            cursor: pointer;
            transition: box-shadow .15s ease, border-color .15s ease, transform .1s ease;
        }

        .tour-thumb:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-1);
        }

        .tour-thumb.active {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px var(--ring);
        }
    </style>
</head>

<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg" id="siteNav" aria-label="Navigation principale">
        <div id="scrollProgress" aria-hidden="true"></div>
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#" aria-label="QRevo accueil">
                <img src="{{ asset('assets/img/saas/qrevo_under.png') }}" alt="QRevo" height="52">
            </a>

            <!-- Desktop links + indicator -->
            <div class="nav-group d-none d-lg-flex align-items-center ms-auto">
                <ul class="navbar-nav align-items-lg-center gap-1">
                    <li class="nav-item"><a class="nav-link" href="#features">Fonctionnalités</a></li>
                    <li class="nav-item"><a class="nav-link" href="#compare">Comparaison</a></li>
                    <li class="nav-item"><a class="nav-link" href="#showcase">Produit</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Tarifs</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item ms-1"><a href="/login" class="btn btn-outline-primary">Se connecter</a></li>
                    <li class="nav-item ms-1"><a href="/register" class="btn btn-primary">Essai gratuit</a></li>
                </ul>
                <div class="nav-indicator" id="navIndicator"></div>
            </div>

            <!-- Mobile toggler -->
            <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNav" aria-label="Ouvrir le menu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Offcanvas mobile menu -->
    <div class="offcanvas offcanvas-end offcanvas-nav" tabindex="-1" id="offcanvasNav"
        aria-labelledby="offcanvasNavLabel">
        <div class="offcanvas-header">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/img/saas/logo_with_words.png') }}" alt="QRevo" height="28">
                <strong id="offcanvasNavLabel">QRevo</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group list-group-flush">
                <a class="list-group-item" href="#features" data-close>Fonctionnalités</a>
                <a class="list-group-item" href="#compare" data-close>Comparaison</a>
                <a class="list-group-item" href="#showcase" data-close>Produit</a>
                <a class="list-group-item" href="#pricing" data-close>Tarifs</a>
                <a class="list-group-item" href="#faq" data-close>FAQ</a>
            </div>
            <div class="d-grid gap-2 mt-3">
                <a href="/login" class="btn btn-outline-primary">Se connecter</a>
                <a href="/register" class="btn btn-primary">Essai gratuit</a>
            </div>
        </div>
    </div>

    <!-- ===== HERO ===== -->
    <header id="overview" class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge-soft d-inline-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-lightning-charge-fill"></i> Menu QR prêt en 2 minutes
                    </span>
                    <h1 class="display-5 mb-3">Le <span class="spark">menu digital</span> qui convertit plus de
                        clients</h1>
                    <p class="lead text-muted mb-4">Mettez à jour photos et prix en temps réel, créez des QR
                        personnalisés, traduisez en un clic et suivez vos performances.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="/register" class="btn btn-primary btn-lg">Démarrer l’essai</a>
                        <a href="#showcase" class="btn btn-outline-primary btn-lg">Voir le produit</a>
                    </div>
                    <div class="d-flex gap-4 mt-4 flex-wrap text-muted small">
                        <div><strong>14j</strong> d’essai • Sans CB</div>
                        <div><i class="bi bi-shield-check"></i> Sauvegardes quotidiennes</div>
                    </div>
                </div>

                <!-- HERO MOSAIC: one big on left, two stacked on right -->
                <div class="col-lg-6">
                    <div class="row g-3 align-items-stretch">
                        <!-- Big left image -->
                        <div class="col-12 col-sm-7">
                            <div class="card h-100 card-tall">
                                <img src="{{ asset('assets/img/saas/hero1.png') }}" alt="Aperçu grand: menu digital">
                                <div class="card-body text-center">
                                    <p class="small text-muted mb-0 fw-bolder">Parcours client fluide</p>
                                </div>
                            </div>
                        </div>
                        <!-- Right column: two stacked -->
                        <div class="col-12 col-sm-5 d-flex flex-column gap-3">
                            <div class="card card-half">
                                <img src="{{ asset('assets/img/saas/hero2.png') }}" alt="Aperçu: QR personnalisés">
                                <div class="card-body text-center">
                                    <p class="small text-muted mb-0 fw-bolder">Expérience client inoubliable</p>
                                </div>
                            </div>
                            <div class="card card-half">
                                <img src="{{ asset('assets/img/saas/hero3.png') }}" alt="Aperçu: stats en direct">
                                <div class="card-body text-center">
                                    <p class="small text-muted mb-0 fw-bolder">Statistiques en direct</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center small text-muted mt-2">Aperçu du menu digital — mosaïque</div>
                </div>
            </div>

            <!-- Trust bar -->
            <div class="mt-5 pt-3">
                <div class="text-center text-muted mb-2">Utilisé par des cafés, restaurants et hôtels</div>
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                    <img src="{{ asset('assets/img/clients/cafe-atlas.jpg') }}" alt="Café Atlas"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                    <img src="{{ asset('assets/img/clients/pizzeria-napoli.jpg') }}" alt="Pizzeria Napoli"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                    <img src="{{ asset('assets/img/clients/hotel-oasis.jpg') }}" alt="Hotel Oasis"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                    <img src="{{ asset('assets/img/clients/bakery-mariem.jpg') }}" alt="Boulangerie Mariem"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                    <img src="{{ asset('assets/img/clients/restaurant-cedre.jpg') }}" alt="Restaurant Cèdre"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                    <img src="{{ asset('assets/img/clients/cafe-zen.jpg') }}" alt="Café Zen"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                </div>
            </div>
        </div>
    </header>

    <!-- ===== METRICS ===== -->
    <section class="py-4" style="background:var(--surface)">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">+120</div>
                    <div class="text-muted small">établissements</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">&lt;1s</div>
                    <div class="text-muted small">chargement moyen</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">+18%</div>
                    <div class="text-muted small">ventes de desserts*</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">90%</div>
                    <div class="text-muted small">coûts d’impression en moins</div>
                </div>
            </div>
            <div class="section-divider my-4"></div>
        </div>
    </section>

    <!-- ===== FEATURES ===== -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Conçu pour vos clients et votre équipe</h2>
                <p class="section-sub">Une carte claire, belle et toujours à jour.</p>
            </div>

            <!-- Row 1 -->
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-pencil-square"></i></div>
                        <h6 class="fw-bold">Éditeur ultra simple</h6>
                        <p class="small text-muted mb-0">Ajoutez plats, prix, photos, variations et allergènes en
                            quelques clics.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-qr-code"></i></div>
                        <h6 class="fw-bold">QR personnalisés</h6>
                        <p class="small text-muted mb-0">Logo, couleurs, formats table, sticker ou chevalet, export
                            SVG/PNG.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-translate"></i></div>
                        <h6 class="fw-bold">Multilingue & devises</h6>
                        <p class="small text-muted mb-0">FR/AR/EN, gestion RTL et prix par devise.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <h6 class="fw-bold">Statistiques en direct</h6>
                        <p class="small text-muted mb-0">Identifiez les plats clés et optimisez vos marges.</p>
                    </div>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="row g-4 mt-1">
                <div class="col-md-6 col-lg-4">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-whatsapp"></i></div>
                        <h6 class="fw-bold">Partage social</h6>
                        <p class="small text-muted mb-0">WhatsApp/Instagram en un clic pour booster la visibilité.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-shield-check"></i></div>
                        <h6 class="fw-bold">Sécurisé & conforme</h6>
                        <p class="small text-muted mb-0">Sauvegardes quotidiennes, hébergement européen, RGPD.</p>
                    </div>
                </div>
                <!-- Client in-place orders -->
                <div class="col-md-12 col-lg-4">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-bag-check"></i></div>
                        <h6 class="fw-bold">Commande en salle</h6>
                        <p class="small text-muted mb-0">
                            Permettez à vos clients de commander depuis la table, avec impression directe en cuisine ou
                            caisse.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Row 3: Delivery agents -->
            <div class="row g-4 mt-1">
                <div class="col-12">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-scooter"></i></div>
                        <h6 class="fw-bold">Agents de livraison</h6>
                        <p class="small text-muted mb-0">
                            Les agents de livraison peuvent passer directement leurs commandes via la solution pour un
                            traitement rapide.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ===== COMPARISON (Paper vs Digital) ===== -->
    <section id="compare" class="compare">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Pourquoi passer au digital&nbsp;?</h2>
                <p class="section-sub">Comparez le menu papier traditionnel et le menu digital QRevo.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="compare-card h-100">
                        <h5 class="mb-3"><i class="bi bi-qr-code-scan me-2 text-success"></i> Menu digital (QRevo)
                        </h5>
                        <ul class="compare-list">
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> Mises à jour
                                instantanées (prix, photos, sold out)</li>
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> Multilingue, devises &
                                gestion RTL</li>
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> Statistiques de
                                consultation et tendances</li>
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> QR personnalisés
                                (branding, couleurs, formats)</li>
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> Coûts maîtrisés, zéro
                                réimpression</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="compare-card h-100">
                        <h5 class="mb-3"><i class="bi bi-file-earmark-text me-2 text-danger"></i> Menu papier</h5>
                        <ul class="compare-list">
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Réimpression à chaque
                                changement</li>
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Pas de traduction native ni
                                de devise</li>
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Aucune statistique d’usage
                            </li>
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Pas d’images interactives ni
                                d’allergènes clairs</li>
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Coût récurrent élevé
                                (impression, livraison)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/register" class="btn btn-primary btn-lg">Essayer gratuitement</a>
            </div>
        </div>
    </section>

    <!-- ===== PRODUCT TOUR (replaces PRODUCT SHOWCASE) ===== -->
    <section id="showcase" class="py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Découvrez QRevo en un coup d’œil</h2>
                <p class="section-sub">Un outil complet, pensé pour la prise en main rapide et l’efficacité au
                    quotidien.</p>
            </div>

            <div class="row g-4 align-items-center">
                <!-- Left: big image with thumbs -->
                <div class="col-lg-6">
                    <div class="ratio ratio-16x9 rounded border shadow-sm overflow-hidden">
                        <img id="tourMain" src="{{ asset('assets/img/saas/editor.png') }}" alt="Aperçu QRevo"
                            class="w-100 h-100" style="object-fit: cover;">
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button class="tour-thumb active" type="button"
                            data-src="{{ asset('assets/img/saas/editor.png') }}" aria-label="Éditeur">
                            <img src="{{ asset('assets/img/saas/editor.png') }}" width="96" height="60"
                                style="object-fit: cover;border-radius:8px;">
                        </button>
                        <button class="tour-thumb" type="button"
                            data-src="{{ asset('assets/img/saas/qr-builder.png') }}" aria-label="QR Designer">
                            <img src="{{ asset('assets/img/saas/qr-builder.png') }}" width="96" height="60"
                                style="object-fit: cover;border-radius:8px;">
                        </button>
                        <button class="tour-thumb" type="button"
                            data-src="{{ asset('assets/img/saas/analytics.png') }}" aria-label="Analytics">
                            <img src="{{ asset('assets/img/saas/analytics.png') }}" width="96" height="60"
                                style="object-fit: cover;border-radius:8px;">
                        </button>
                    </div>
                    <div class="small text-muted mt-2">Parcourez les vues : Éditeur, QR Designer et Analytics.</div>
                </div>

                <!-- Right: benefit cards -->
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="tour-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="icon"><i class="bi bi-magic"></i></span>
                                    <h6 class="m-0 fw-bold">Mise à jour instantanée</h6>
                                </div>
                                <p class="small text-muted mb-2">Modifiez plats, prix, photos et allergènes — les
                                    changements sont visibles immédiatement côté client.</p>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li>Édition en ligne</li>
                                    <li>Gestion des langues</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="tour-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="icon"><i class="bi bi-qr-code-scan"></i></span>
                                    <h6 class="m-0 fw-bold">QR à votre image</h6>
                                </div>
                                <p class="small text-muted mb-2">Créez des QR en couleurs avec logo et exports
                                    haute-définition.</p>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li>Logo & couleurs</li>
                                    <li>Export SVG/PNG</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="tour-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="icon"><i class="bi bi-bag-check"></i></span>
                                    <h6 class="m-0 fw-bold">Commande à table</h6>
                                </div>
                                <p class="small text-muted mb-2">Les clients scannent, commandent et vous recevez
                                    l’ordre directement en cuisine/caisse.</p>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li>Impression cuisine</li>
                                    <li>Flux caisse intégrés</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="tour-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="icon"><i class="bi bi-graph-up-arrow"></i></span>
                                    <h6 class="m-0 fw-bold">Analytics utiles</h6>
                                </div>
                                <p class="small text-muted mb-2">Comprenez ce que vos clients consultent et optimisez
                                    vos marges.</p>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li>Vues & tendances</li>
                                    <li>Plats performants</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <a href="/register" class="btn btn-primary">Créer mon compte</a>
                        <a href="/contact" class="btn btn-outline-primary">Demander une démo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRICING ===== -->
    <section id="pricing" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Tarification simple et flexible</h2>
                <p class="section-sub">Essai gratuit 14 jours, puis choisissez le plan qui vous convient.</p>
                <div class="toggle mt-1" aria-live="polite">
                    <span class="seg" id="billMonthly">Mensuel</span>
                    <span class="seg active" id="billYearly">Annuel <span class="text-success">(–15%)</span></span>
                </div>
            </div>

            <div class="row g-4 justify-content-center mt-1">
                <!-- Menu Digital -->
                <div class="col-md-6 col-lg-4">
                    <div class="price-card p-4 h-100">
                        <h6 class="fw-bold">Menu Digital</h6>
                        <div class="display-6 fw-extrabold my-2">
                            <span class="price" data-monthly="59" data-yearly="39">39</span> MAD
                            <span class="fs-6 fw-normal billing-label">/mois (facturé annuellement)</span>
                        </div>
                        <p class="text-muted small">Le meilleur du menu QR moderne.</p>
                        <ul class="list-unstyled small mb-4">
                            <li><i class="bi bi-check2 text-success"></i> 1 menu illimité</li>
                            <li><i class="bi bi-check2 text-success"></i> QR en couleurs & branding</li>
                            <li><i class="bi bi-check2 text-success"></i> Multilingue & devises</li>
                            <li><i class="bi bi-check2 text-success"></i> Statistiques détaillées</li>
                            <li><i class="bi bi-check2 text-success"></i> Support standard</li>
                        </ul>
                        <a href="/register" class="btn btn-outline-primary w-100">Essai gratuit 14 j</a>
                    </div>
                </div>

                <!-- Commande & Agents -->
                <div class="col-md-6 col-lg-4">
                    <div class="price-card p-4 h-100 featured position-relative">
                        <span class="price-badge position-absolute top-0 end-0 mt-3 me-3">Populaire</span>
                        <h6 class="fw-bold">Commande & Agents</h6>
                        <div class="display-6 fw-extrabold my-2">
                            <span class="price" data-monthly="79" data-yearly="59">59</span> MAD
                            <span class="fs-6 fw-normal billing-label">/mois (facturé annuellement)</span>
                        </div>
                        <p class="text-muted small">Ajoutez la commande en salle et les agents.</p>
                        <ul class="list-unstyled small mb-4">
                            <li><i class="bi bi-check2 text-success"></i> Tout <strong>Menu Digital</strong></li>
                            <li><i class="bi bi-check2 text-success"></i> Commande à table (scan & pay*)</li>
                            <li><i class="bi bi-check2 text-success"></i> Agents de livraison intégrés</li>
                            <li><i class="bi bi-check2 text-success"></i> Impression cuisine / caisse</li>
                            <li><i class="bi bi-check2 text-success"></i> Support prioritaire</li>
                        </ul>
                        <a href="/register" class="btn btn-primary w-100">Essai gratuit 14 j</a>
                    </div>
                </div>

                <!-- POS Complet -->
                <div class="col-md-6 col-lg-4">
                    <div class="price-card p-4 h-100">
                        <h6 class="fw-bold">POS Complet</h6>
                        <div class="display-6 fw-extrabold my-2">
                            <span class="price" data-monthly="179" data-yearly="149">149</span> MAD
                            <span class="fs-6 fw-normal billing-label">/mois (facturé annuellement)</span>
                        </div>
                        <p class="text-muted small">Gestion de caisse et rapports avancés.</p>
                        <ul class="list-unstyled small mb-4">
                            <li><i class="bi bi-check2 text-success"></i> Tout <strong>Commande & Agents</strong></li>
                            <li><i class="bi bi-check2 text-success"></i> Système de caisse (POS)</li>
                            <li><i class="bi bi-check2 text-success"></i> Inventaire & suivis basiques</li>
                            <li><i class="bi bi-check2 text-success"></i> Rapports de ventes avancés</li>
                            <li><i class="bi bi-check2 text-success"></i> Assistance dédiée</li>
                        </ul>
                        <a href="/register" class="btn btn-outline-primary w-100">Essai gratuit 14 j</a>
                    </div>
                </div>
            </div>

            <p class="text-center small text-muted mt-3">
                Réduction appliquée en annuel. Tarifs pensés pour le marché marocain.
            </p>
            <p class="text-center small mt-1">
                Besoin d’un site web vitrine&nbsp;? Forfait fixe <strong>1449 MAD</strong> (hors nom de domaine).
            </p>
        </div>
    </section>



    <!-- ===== FAQ ===== -->
    <section id="faq" class="py-5" style="background:var(--surface)">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Questions fréquentes</h2>
                <p class="section-sub">Tout ce qu’il faut savoir avant de démarrer.</p>
            </div>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="fq1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#fq1c">Comment fonctionne l’essai&nbsp;?</button>
                    </h2>
                    <div id="fq1c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">Essai de 14 jours sur tous les plans payants. Sans action de
                            votre part, l’abonnement se poursuit au tarif sélectionné.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="fq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#fq2c">Puis-je changer de formule&nbsp;?</button>
                    </h2>
                    <div id="fq2c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">Oui, à tout moment depuis le tableau de bord. Le prorata est
                            calculé automatiquement.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="fq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#fq3c">Dois-je réimprimer si je change un plat&nbsp;?</button>
                    </h2>
                    <div id="fq3c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">Non, le QR pointe vers un lien dynamique. Vos modifications
                            sont instantanées côté client.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta text-center">
        <div class="container">
            <h2 class="fw-bold mb-2">Prêt à moderniser votre carte&nbsp;?</h2>
            <p class="mb-4">Créez votre premier menu QR en quelques minutes.</p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="/register" class="btn btn-light btn-lg">Créer mon compte</a>
                <a href="/contact" class="btn btn-outline-primary btn-lg">Parler à un expert</a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="site-footer pt-5">
        <div class="container pb-4">
            <div class="row g-4">
                <!-- Brand + short -->
                <div class="col-lg-4">
                    <div class="footer-card h-100">
                        <div class="footer-brand mb-2">
                            <img src="{{ asset('assets/img/saas/logo_with_words.png') }}" alt="QRevo">
                            <strong>QRevo</strong>
                        </div>
                        <p class="small text-muted mb-3">
                            Le menu digital moderne pour restaurants, cafés et hôtels. QR personnalisés, multilingue,
                            stats en temps réel.
                        </p>
                        <div class="social">
                            <a href="https://instagram.com" aria-label="Instagram"><i
                                    class="bi bi-instagram"></i></a>
                            <a href="https://facebook.com" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="https://wa.me/" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Product links -->
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-3">Produit</h6>
                    <ul class="list-unstyled small m-0">
                        <li class="mb-2"><a class="footer-link" href="#features">Fonctionnalités</a></li>
                        <li class="mb-2"><a class="footer-link" href="#compare">Comparaison</a></li>
                        <li class="mb-2"><a class="footer-link" href="#showcase">Aperçu</a></li>
                        <li class="mb-2"><a class="footer-link" href="#pricing">Tarifs</a></li>
                        <li class="mb-2"><a class="footer-link" href="#faq">FAQ</a></li>
                    </ul>
                </div>

                <!-- Resources links -->
                <div class="col-6 col-lg-3">
                    <h6 class="fw-bold mb-3">Ressources</h6>
                    <ul class="list-unstyled small m-0">
                        <li class="mb-2"><a class="footer-link" href="/contact">Contact</a></li>
                        <li class="mb-2"><a class="footer-link" href="/terms">CGU</a></li>
                        <li class="mb-2"><a class="footer-link" href="/login">Se connecter</a></li>
                        <li class="mb-2"><a class="footer-link" href="/register">Créer un compte</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Newsletter</h6>
                    <p class="small text-muted mb-2">Recevez des conseils pour optimiser votre menu digital.</p>
                    <form id="newsletterForm" class="d-flex gap-2">
                        <input type="email" required class="form-control" placeholder="Votre email">
                        <button class="btn btn-primary" type="submit">S’inscrire</button>
                    </form>
                    <div id="newsletterMsg" class="small mt-2" aria-live="polite"></div>
                </div>
            </div>

            <hr class="my-4" style="border-color:var(--border)">

            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between pb-4">
                <p class="small text-muted mb-2 mb-md-0">
                    &copy; 2025 QRevo Inc. Tous droits réservés.
                </p>
                <div class="d-flex align-items-center gap-3">
                    <a href="#overview" class="btn btn-outline-primary btn-sm" id="toTopBtn"
                        aria-label="Retour en haut">
                        <i class="bi bi-arrow-up"></i> Haut de page
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile sticky CTA -->
    <div class="mobile-cta">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-qr-code-scan"></i>
            <span class="small">Essayez QRevo gratuitement</span>
        </div>
        <a href="/register" class="btn btn-primary btn-sm">Créer mon compte</a>
    </div>

    <!-- ========= SCRIPTS ========= -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        // Pricing toggle
        const billMonthly = document.getElementById('billMonthly');
        const billYearly = document.getElementById('billYearly');
        const priceEls = document.querySelectorAll('.price');
        const billingLabels = document.querySelectorAll('.billing-label');

        function setBilling(yearly) {
            billMonthly.classList.toggle('active', !yearly);
            billYearly.classList.toggle('active', yearly);
            priceEls.forEach(el => el.textContent = yearly ? el.dataset.yearly : el.dataset.monthly);
            billingLabels.forEach(l => l && (l.textContent = yearly ? '/mois (facturé annuellement)' : '/mois'));
        }
        billMonthly?.addEventListener('click', () => setBilling(false));
        billYearly?.addEventListener('click', () => setBilling(true));
        // Default to ANNUAL
        setBilling(true);

        // Navbar behavior + progress + active link indicator
        const nav = document.getElementById('siteNav');
        const progress = document.getElementById('scrollProgress');
        const indicator = document.getElementById('navIndicator');
        const linkNodes = [...document.querySelectorAll('.navbar .nav-link[href^="#"]')];
        const sections = linkNodes.map(a => document.querySelector(a.getAttribute('href'))).filter(Boolean);

        function setProgress() {
            const st = document.documentElement.scrollTop || document.body.scrollTop;
            const h = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const pct = Math.max(0, Math.min(1, st / h));
            progress.style.width = (pct * 100).toFixed(2) + '%';
        }

        function moveIndicator(el) {
            const group = document.querySelector('.nav-group');
            if (!indicator || !group || !el) {
                if (indicator) indicator.style.opacity = '0';
                return;
            }
            const r = el.getBoundingClientRect();
            const gp = group.getBoundingClientRect();
            indicator.style.width = r.width + 'px';
            indicator.style.transform = `translateX(${r.left - gp.left}px)`;
            indicator.style.opacity = '1';
        }

        function setActiveOnScroll() {
            if (window.scrollY > 8) nav?.classList.add('scrolled');
            else nav?.classList.remove('scrolled');
            setProgress();

            let idx = -1;
            const fromTop = window.scrollY + 120;
            sections.forEach((sec, i) => {
                if (sec.offsetTop <= fromTop) idx = i;
            });
            linkNodes.forEach(l => l.classList.remove('active'));
            const active = idx >= 0 ? linkNodes[idx] : null;
            active?.classList.add('active');
            moveIndicator(active);
        }

        linkNodes.forEach(l => {
            l.addEventListener('mouseenter', () => moveIndicator(l));
            l.addEventListener('mouseleave', () => moveIndicator(document.querySelector(
                '.navbar .nav-link.active')));
            l.addEventListener('click', () => setTimeout(() => moveIndicator(l), 50));
        });

        window.addEventListener('scroll', setActiveOnScroll);
        window.addEventListener('resize', () => moveIndicator(document.querySelector('.navbar .nav-link.active')));
        window.addEventListener('load', () => {
            setActiveOnScroll();
            moveIndicator(document.querySelector('.navbar .nav-link.active') || linkNodes[0] || null);
        });

        // Offcanvas: close when picking a link
        const offcanvasEl = document.getElementById('offcanvasNav');
        offcanvasEl?.querySelectorAll('[data-close]').forEach(a => {
            a.addEventListener('click', () => {
                const oc = bootstrap.Offcanvas.getInstance(offcanvasEl);
                oc?.hide();
            });
        });

        // Footer: newsletter UX (demo)
        const form = document.getElementById('newsletterForm');
        const msg = document.getElementById('newsletterMsg');
        form?.addEventListener('submit', (e) => {
            e.preventDefault();
            msg.textContent = 'Merci ! Vous recevrez bientôt nos conseils.';
            msg.className = 'small mt-2 text-success';
            form.reset();
            setTimeout(() => {
                msg.textContent = '';
                msg.className = 'small mt-2';
            }, 4000);
        });

        // Footer: back to top
        document.getElementById('toTopBtn')?.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Product tour thumbs
        const tourMain = document.getElementById('tourMain');
        document.querySelectorAll('.tour-thumb').forEach(btn => {
            btn.addEventListener('click', () => {
                const src = btn.getAttribute('data-src');
                if (tourMain && src) {
                    tourMain.src = src;
                }
                document.querySelectorAll('.tour-thumb').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>
</body>

</html>
