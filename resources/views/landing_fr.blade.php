<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <!-- ========= META ========= -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="QRivo est la solution de menu digital la plus rapide pour moderniser votre restaurant, augmenter vos ventes et simplifier vos mises à jour — sans impression.">
    <meta name="theme-color" content="#ff6b35">
    <title>QRivo — Menu Digital Intelligent</title>

    <!-- ========= FONTS ========= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- ========= CSS & ICONS ========= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ---------- Brand tokens ---------- */
        :root {
            --qr-primary: #ff6b35;
            --qr-primary-700: #ff5a1b;
            --qr-secondary: #10131f;

            --bg: #ffffff;
            --text: #11141c;
            --muted: #495166;
            --surface: #ffffff;
            --border: #e8eaf0;
            --section-bg: #f7f8fb;

            --ring: #ffe2d6;
            --success: #28a745;

            --nav-offset: 140px;
            /* will be measured in JS for accuracy */
        }

        /* ---------- Base ---------- */
        html {
            scroll-behavior: smooth
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background: var(--bg);
            overflow-x: hidden
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            letter-spacing: -0.015em
        }

        .lead {
            color: var(--muted)
        }

        .btn-primary {
            background: var(--qr-primary);
            border: none;
            box-shadow: 0 8px 20px rgba(255, 107, 53, .25)
        }

        .btn-primary:hover {
            background: var(--qr-primary-700)
        }

        .btn-outline-primary {
            border-color: var(--qr-primary);
            color: var(--qr-primary)
        }

        .btn-outline-primary:hover {
            background: var(--qr-primary);
            color: #fff
        }

        .badge-soft {
            background: var(--ring);
            color: var(--qr-primary-700);
            border-radius: 999px;
            padding: .35rem .7rem;
            font-weight: 600;
            font-size: .8rem
        }

        /* Highlight for hero keyword (no orange-on-orange) */
        .highlight {
            display: inline-block;
            background: #fff;
            color: #0d1117;
            padding: .05rem .4rem;
            border-radius: .4rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .15)
        }

        /* ---------- Transparent, fixed navbar ---------- */
        .sticky-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1055;
            background: transparent !important;
            /* always transparent */
            border-bottom: transparent;
            box-shadow: none;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.05rem;
        }

        /* Logo: only height 110, no width */
        .navbar-brand img {
            height: 110px;
            width: auto;
            display: block
        }

        /* Nav links */
        .sticky-nav .nav-link {
            position: relative;
            font-weight: 600
        }

        .sticky-nav.navbar-dark .nav-link {
            color: #fff
        }

        .sticky-nav.navbar-light .nav-link {
            color: var(--text)
        }

        .sticky-nav .nav-link:hover {
            opacity: .9
        }

        .sticky-nav .nav-link.active::after,
        .sticky-nav .nav-link:hover::after {
            content: "";
            position: absolute;
            left: .25rem;
            right: .25rem;
            bottom: -6px;
            height: 2px;
            background: linear-gradient(90deg, var(--qr-primary), #ff944d);
            border-radius: 2px
        }

        /* CTA button style depending on context */
        .brand-cta {
            border: 1px solid;
            transition: color .2s, background .2s, border-color .2s
        }

        .brand-cta--dark {
            border-color: #ffffffcc;
            color: #fff
        }

        .brand-cta--dark:hover {
            background: #ffffff22;
            color: #fff
        }

        .brand-cta--light {
            border-color: var(--qr-primary);
            color: var(--qr-primary)
        }

        .brand-cta--light:hover {
            background: var(--qr-primary);
            color: #fff
        }

        /* ---------- Hero ---------- */
        .hero {
            padding-top: calc(var(--nav-offset) + 40px);
            /* room for fixed nav & tall logo */
            background: radial-gradient(1200px 600px at 20% 0%, #ffb37c33 0%, transparent 60%), linear-gradient(135deg, #ff6b35 0%, #ffa94d 100%);
            color: #fff;
            padding-bottom: 5rem;
            position: relative;
            isolation: isolate;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: auto -30% -20% -30%;
            height: 380px;
            background: radial-gradient(50% 60% at 50% 0%, #ffffff1a 0%, transparent 60%);
            z-index: 0;
            filter: blur(40px)
        }

        .hero-img {
            max-width: 100%;
            border-radius: 1.25rem;
            filter: drop-shadow(0 1.25rem 2rem rgba(0, 0, 0, .2))
        }

        /* ---------- Trust logos ---------- */
        .trust-logos {
            gap: 14px
        }

        .trust-logos img {
            height: 44px;
            width: auto;
            border-radius: 10px;
            object-fit: cover;
            opacity: .98;
            box-shadow: 0 .35rem .9rem rgba(0, 0, 0, .15);
            background: #fff
        }

        /* ---------- Sections / cards ---------- */
        .section-title {
            margin-bottom: 1rem
        }

        .section-sub {
            color: var(--muted);
            margin-bottom: 2.3rem
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent)
        }

        .soft-bg {
            background: var(--section-bg)
        }

        .feature-card {
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.75rem;
            background: var(--surface);
            box-shadow: 0 .6rem 1.2rem rgba(16, 24, 40, .06);
            transition: transform .28s, box-shadow .28s;
            height: 100%
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 .9rem 1.7rem rgba(16, 24, 40, .09)
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            background: var(--section-bg);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--qr-primary);
            margin-bottom: 1rem
        }

        .step {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
            height: 100%
        }

        .step .num {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            background: var(--ring);
            color: #a34522;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            margin-bottom: .6rem
        }

        .price-card {
            border-radius: 1rem;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s, border-color .2s;
            border: 1px solid var(--border);
            height: 100%;
            background: var(--surface)
        }

        .price-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 .7rem 1.5rem rgba(16, 24, 40, .08)
        }

        .price-card.featured {
            box-shadow: 0 .9rem 1.9rem rgba(16, 24, 40, .12);
            border: 2px solid var(--qr-primary)
        }

        .price-badge {
            background: var(--qr-primary);
            color: #fff;
            font-size: .75rem;
            padding: .25rem .6rem;
            border-radius: .5rem
        }

        .testimonial-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 .5rem 1.1rem rgba(16, 24, 40, .05);
            height: 100%
        }

        .testimonial-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem
        }

        .check {
            color: var(--success)
        }

        .xmark {
            color: #e03131
        }

        .cta-banner {
            background: var(--qr-secondary);
            color: #fff;
            padding: 4.5rem 0
        }

        footer {
            background: #0b0d12;
            color: #adb5bd;
            padding: 3rem 0
        }

        footer a {
            color: #fff;
            text-decoration: none
        }

        footer a:hover {
            text-decoration: underline
        }

        /* ---------- Reveal Animations ---------- */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .6s ease, transform .6s ease
        }

        .reveal.is-visible {
            opacity: 1;
            transform: none
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal {
                opacity: 1;
                transform: none
            }

            .feature-card,
            .price-card {
                transition: none
            }
        }

        /* ---------- Mobile sticky CTA ---------- */
        .mobile-cta {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: .75rem .9rem;
            display: none;
            gap: .5rem;
            align-items: center;
            justify-content: space-between
        }

        .mobile-cta .btn {
            flex: 1
        }

        @media (max-width: 991.98px) {
            .mobile-cta {
                display: flex
            }
        }
    </style>
</head>

<body data-bs-spy="scroll" data-bs-target="#navMenu" data-bs-smooth-scroll="true" tabindex="0">

    <!-- ===== NAVBAR (fixed, transparent) ===== -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-nav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#" aria-label="QRivo accueil">
                <!-- Height only, no width -->
                <img src="{{ asset('assets/img/logo/accountLogo.png') }}" alt="QRivo Logo" height="110">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
                aria-label="Ouvrir le menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="#features">Fonctionnalités</a></li>
                    <li class="nav-item"><a class="nav-link" href="#how">Comment ça marche</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Tarifs</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Avis</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Se connecter</a></li>

                    <!-- Language Switcher -->
                    <li class="nav-item dropdown ms-lg-2 my-2 my-lg-0">
                        <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" aria-label="Changer de langue">FR</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                            <li><a class="dropdown-item" href="/?lang=fr">Français (FR)</a></li>
                            <li><a class="dropdown-item" href="/?lang=ar">العربية (AR)</a></li>
                        </ul>
                    </li>
                </ul>

                <a href="#cta" class="btn brand-cta brand-cta--dark ms-lg-3">Essai gratuit</a>
            </div>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <header class="hero">
        <div class="container position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <span class="badge-soft mb-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-lightning-charge-fill"></i> Menu QR prêt en 2 minutes
                    </span>
                    <h1 class="display-5 mb-3">
                        Modernisez votre carte <span class="highlight">sans impression</span>
                    </h1>
                    <p class="lead mb-4">Mettez à jour plats, photos et prix en temps réel. Multilingue, QR
                        personnalisés, statistiques — tout pour convertir plus de clients.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="/register" class="btn btn-light btn-lg">Démarrer l’essai gratuit</a>
                        <a href="#features" class="btn btn-outline-light btn-lg">Voir les fonctionnalités</a>
                    </div>
                    <div class="d-flex gap-4 mt-4 flex-wrap">
                        <div><strong>14j</strong> d’essai • <span class="opacity-75">Sans CB</span></div>
                        <div><i class="bi bi-shield-check"></i> <span class="opacity-75">Sauvegardes quotidiennes</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/img/saas/hero3.png') }}" alt="Aperçu du menu QR sur smartphone"
                        class="hero-img" width="680" height="460" fetchpriority="high" decoding="async">
                </div>
            </div>

            <!-- Trust bar -->
            <div class="mt-5 pt-3">
                <div class="text-center text-white-50 mb-2">Utilisé par des cafés, restaurants et hôtels</div>
                <div class="trust-logos d-flex flex-wrap justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/clients/cafe-atlas.jpg') }}" alt="Café Atlas" loading="lazy">
                    <img src="{{ asset('assets/img/clients/pizzeria-napoli.jpg') }}" alt="Pizzeria Napoli"
                        loading="lazy">
                    <img src="{{ asset('assets/img/clients/hotel-oasis.jpg') }}" alt="Hotel Oasis" loading="lazy">
                    <img src="{{ asset('assets/img/clients/bakery-mariem.jpg') }}" alt="Boulangerie Mariem"
                        loading="lazy">
                    <img src="{{ asset('assets/img/clients/restaurant-cedre.jpg') }}" alt="Restaurant Cèdre"
                        loading="lazy">
                    <img src="{{ asset('assets/img/clients/cafe-zen.jpg') }}" alt="Café Zen" loading="lazy">
                </div>
            </div>
        </div>
    </header>

    <!-- Stats -->
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
                <h2 class="section-title fw-bold">Pensé pour vos clients et votre équipe</h2>
                <p class="section-sub">Des outils simples, rapides et élégants pour présenter votre carte comme un pro.
                </p>
            </div>
            <div class="row g-4 reveal">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-pencil-square"></i></div>
                        <h5 class="fw-semibold mb-2">Mises à jour instantanées</h5>
                        <p class="small mb-0">Ajoutez ou modifiez vos plats à tout moment depuis un tableau de bord
                            intuitif.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-translate"></i></div>
                        <h5 class="fw-semibold mb-2">Multilingue &amp; devises</h5>
                        <p class="small mb-0">Proposez le même menu en plusieurs langues et devises pour accueillir
                            chaque client comme un local.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-images"></i></div>
                        <h5 class="fw-semibold mb-2">Photos &amp; allergènes</h5>
                        <p class="small mb-0">Des visuels haute résolution et des allergènes clairs pour une
                            transparence totale.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <h5 class="fw-semibold mb-2">Statistiques en temps réel</h5>
                        <p class="small mb-0">Identifiez les plats les plus consultés pour optimiser votre offre et vos
                            marges.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-whatsapp"></i></div>
                        <h5 class="fw-semibold mb-2">Partage WhatsApp</h5>
                        <p class="small mb-0">Permettez à vos clients de partager votre menu en un clic.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                        <h5 class="fw-semibold mb-2">Sécurisé &amp; conforme</h5>
                        <p class="small mb-0">Hébergement certifié, sauvegardes quotidiennes et conformité RGPD.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== HOW IT WORKS ===== -->
    <section id="how" class="py-5 soft-bg">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title fw-bold">Comment ça marche&nbsp;?</h2>
                <p class="section-sub">De l’inscription à l’impression de votre QR, tout est guidé et rapide.</p>
            </div>
            <div class="row text-center g-4 reveal">
                <div class="col-md-3">
                    <div class="step">
                        <div class="num">1</div>
                        <h6 class="fw-semibold mb-1">Créez</h6>
                        <p class="small mb-0">Ajoutez catégories, plats & descriptions en ligne.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step">
                        <div class="num">2</div>
                        <h6 class="fw-semibold mb-1">Générez</h6>
                        <p class="small mb-0">Téléchargez votre QR avec logo & couleurs.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step">
                        <div class="num">3</div>
                        <h6 class="fw-semibold mb-1">Affichez</h6>
                        <p class="small mb-0">Apposez-le sur tables, stickers ou chevalets.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step">
                        <div class="num">4</div>
                        <h6 class="fw-semibold mb-1">Mettez à jour</h6>
                        <p class="small mb-0">Modifiez vos plats — le QR reste identique.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRICING ===== -->
    <section id="pricing" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title fw-bold">Tarification simple et flexible</h2>
                <p class="section-sub">Commencez gratuitement. Passez à la vitesse supérieure quand vous le souhaitez.
                </p>
            </div>
            <div class="d-flex justify-content-center align-items-center mb-4" aria-live="polite">
                <span class="me-2 fw-semibold">Mensuel</span>
                <input class="form-check-input" type="checkbox" id="billingToggle"
                    aria-label="Basculer la période de facturation">
                <span class="ms-2 fw-semibold">Annuel <span class="text-success">(–15%)</span></span>
            </div>

            <div class="row justify-content-center g-4 reveal">
                <div class="col-md-4">
                    <div class="card price-card h-100">
                        <div class="card-body text-center p-4">
                            <h5 class="fw-bold">Gratuit</h5>
                            <p class="display-6 fw-bold my-3"><span class="price" data-monthly="0"
                                    data-yearly="0">0</span> DH</p>
                            <p class="small mb-2">Parfait si vous avez une petite carte</p>
                            <ul class="list-unstyled mb-4 small d-inline-block text-start">
                                <li><i class="bi bi-check2 text-success"></i> Jusqu’à <strong>10 plats</strong></li>
                                <li><i class="bi bi-check2 text-success"></i> QR noir & blanc</li>
                                <li><i class="bi bi-check2 text-success"></i> Statistiques basiques</li>
                                <li><i class="bi bi-x-lg text-danger"></i> Branding QRivo visible</li>
                            </ul>
                            <a href="#cta" class="btn btn-outline-primary w-100">Commencer</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card price-card featured h-100 position-relative">
                        <div class="card-body text-center p-4">
                            <span class="price-badge position-absolute top-0 end-0 mt-3 me-3">Populaire</span>
                            <h5 class="fw-bold">Starter</h5>
                            <p class="display-6 fw-bold my-3">
                                <span class="price" data-monthly="69" data-yearly="59">69</span> DH
                                <span class="fs-6 fw-normal billing-label">/mois</span>
                            </p>
                            <p class="small mb-2">1 menu complet, items illimités</p>
                            <ul class="list-unstyled mb-4 small d-inline-block text-start">
                                <li><i class="bi bi-check2 text-success"></i> 1 menu (items illimités)</li>
                                <li><i class="bi bi-check2 text-success"></i> QR en couleurs</li>
                                <li><i class="bi bi-check2 text-success"></i> Multilingue & devises</li>
                                <li><i class="bi bi-check2 text-success"></i> Statistiques détaillées</li>
                                <li><i class="bi bi-check2 text-success"></i> Sans branding QRivo</li>
                            </ul>
                            <a href="/register" class="btn btn-primary w-100">Essai gratuit 14 j</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card price-card h-100">
                        <div class="card-body text-center p-4">
                            <h5 class="fw-bold">Pro</h5>
                            <p class="display-6 fw-bold my-3">
                                <span class="price" data-monthly="149" data-yearly="127">149</span> DH
                                <span class="fs-6 fw-normal billing-label">/mois</span>
                            </p>
                            <p class="small mb-2">Pour plusieurs menus et équipes</p>
                            <ul class="list-unstyled mb-4 small d-inline-block text-start">
                                <li><i class="bi bi-check2 text-success"></i> Menus illimités</li>
                                <li><i class="bi bi-check2 text-success"></i> QR personnalisés</li>
                                <li><i class="bi bi-check2 text-success"></i> Intégrations WhatsApp & Instagram</li>
                                <li><i class="bi bi-check2 text-success"></i> Accès API / export</li>
                                <li><i class="bi bi-check2 text-success"></i> Support prioritaire</li>
                            </ul>
                            <a href="/register" class="btn btn-outline-primary w-100">Essai gratuit 14 j</a>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center mt-3 small text-muted">Réduction appliquée en annuel. *Exemple client typique,
                résultats variables.</p>
        </div>
    </section>

    <!-- ===== COMPARISON ===== -->
    <section class="py-5 soft-bg">
        <div class="container reveal">
            <div class="text-center">
                <h2 class="section-title fw-bold">Pourquoi passer au menu digital&nbsp;?</h2>
                <p class="section-sub">Comparez QRivo aux impressions papier traditionnelles.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card h-100 price-card p-3">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3"><i class="bi bi-qr-code-scan me-2 text-success"></i> QRivo</h5>
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-2"><i class="bi bi-check2-circle check me-2"></i>Mises à jour
                                    illimitées & instantanées</li>
                                <li class="mb-2"><i class="bi bi-check2-circle check me-2"></i>Multilingue et photos
                                    HD</li>
                                <li class="mb-2"><i class="bi bi-check2-circle check me-2"></i>Statistiques &
                                    optimisation des ventes</li>
                                <li class="mb-2"><i class="bi bi-check2-circle check me-2"></i>QR personnalisés avec
                                    votre branding</li>
                                <li class="mb-2"><i class="bi bi-check2-circle check me-2"></i>Coûts maîtrisés (sans
                                    réimpressions)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card h-100 price-card p-3">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3"><i class="bi bi-file-earmark-text me-2 text-danger"></i> Menu
                                papier</h5>
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-2"><i class="bi bi-x-circle xmark me-2"></i>Réimpression à chaque
                                    changement</li>
                                <li class="mb-2"><i class="bi bi-x-circle xmark me-2"></i>Pas de statistiques
                                    d’usage</li>
                                <li class="mb-2"><i class="bi bi-x-circle xmark me-2"></i>Traductions coûteuses et
                                    lentes</li>
                                <li class="mb-2"><i class="bi bi-x-circle xmark me-2"></i>Pas d’images interactives
                                </li>
                                <li class="mb-2"><i class="bi bi-x-circle xmark me-2"></i>Coût récurrent élevé</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section id="testimonials" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title fw-bold">Ils nous font confiance</h2>
                <p class="section-sub">Des résultats concrets dès les premières semaines.</p>
            </div>
            <div class="row g-4 reveal">
                <div class="col-md-4">
                    <div class="testimonial-card d-flex flex-column h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/img/avatars/avatar1.jpg') }}" alt="Portrait client Amine"
                                class="testimonial-avatar" width="56" height="56" loading="lazy">
                            <div>
                                <h6 class="mb-0 fw-semibold">Amine B.</h6><small class="text-muted">Propriétaire —
                                    Café Atlas</small>
                            </div>
                        </div>
                        <p class="mb-0 small">« Depuis QRivo, nos clients trouvent tout de suite ce qu’ils veulent et
                            nous avons réduit les impressions de 90&nbsp;%. »</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card d-flex flex-column h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/img/avatars/avatar2.jpg') }}" alt="Portrait client Salma"
                                class="testimonial-avatar" width="56" height="56" loading="lazy">
                            <div>
                                <h6 class="mb-0 fw-semibold">Salma R.</h6><small class="text-muted">Manager — Pizzeria
                                    Napoli</small>
                            </div>
                        </div>
                        <p class="mb-0 small">« Le multilingue a changé la donne avec les touristes. Les desserts se
                            vendent mieux grâce aux photos. »</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card d-flex flex-column h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/img/avatars/avatar3.jpg') }}" alt="Portrait client Youssef"
                                class="testimonial-avatar" width="56" height="56" loading="lazy">
                            <div>
                                <h6 class="mb-0 fw-semibold">Youssef K.</h6><small class="text-muted">Directeur —
                                    Hotel Oasis</small>
                            </div>
                        </div>
                        <p class="mb-0 small">« Les stats nous aident à choisir quoi mettre en avant. La mise à jour
                            est instantanée pour nos trois restaurants. »</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section id="faq" class="py-5 soft-bg">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title fw-bold">Questions fréquentes</h2>
                <p class="section-sub">Tout ce qu’il faut savoir avant de démarrer.</p>
            </div>
            <div class="accordion accordion-flush reveal" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapse1">Comment fonctionne la période d’essai&nbsp;?</button>
                    </h2>
                    <div id="faqCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">Vous profitez de toutes les fonctionnalités Starter pendant
                            14 jours, sans carte bancaire. Si vous ne passez pas à une formule payante, votre compte
                            basculera automatiquement sur l’offre gratuite.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapse2">Puis-je changer de formule à tout moment&nbsp;?</button>
                    </h2>
                    <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">Oui. Vous pouvez passer d’une formule à l’autre en un clic
                            depuis votre tableau de bord. Le prorata est calculé automatiquement.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapse3">Dois-je réimprimer mon QR code si je change un
                            plat&nbsp;?</button>
                    </h2>
                    <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">Non. Le QR code pointe vers un lien dynamique. Toute
                            modification dans votre tableau de bord est reflétée instantanément pour vos clients.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section id="cta" class="cta-banner text-center">
        <div class="container">
            <h2 class="fw-bold mb-3">Prêt à moderniser votre carte&nbsp;?</h2>
            <p class="mb-4">Créez gratuitement votre premier menu QR et impressionnez vos clients dès aujourd’hui.
            </p>
            <a href="/register" class="btn btn-light btn-lg">Créer mon compte</a>
            <div class="mt-3 small text-white-50">Besoin d’une démo guidée&nbsp;? <a href="/contact"
                    class="link-light text-decoration-underline">Contactez-nous</a></div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer>
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-md-6 text-md-start text-center">
                    <span class="fw-semibold text-white fs-5">QRivo</span>
                    <p class="small mb-0 mt-2">&copy; 2025 QRivo Inc. Tous droits réservés.</p>
                </div>
                <div class="col-md-6">
                    <ul class="list-inline mb-0 text-md-end text-center small">
                        <li class="list-inline-item"><a href="#features">Fonctionnalités</a></li>
                        <li class="list-inline-item"><a href="#pricing">Tarifs</a></li>
                        <li class="list-inline-item"><a href="#testimonials">Avis</a></li>
                        <li class="list-inline-item"><a href="#faq">FAQ</a></li>
                        <li class="list-inline-item"><a href="/terms">CGU</a></li>
                        <li class="list-inline-item"><a href="/contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile sticky CTA -->
    <div class="mobile-cta">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-qr-code-scan"></i>
            <span class="small">Essayez QRivo gratuitement</span>
        </div>
        <a href="/register" class="btn btn-primary btn-sm">Créer mon compte</a>
    </div>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        /* Measure nav height -> set hero offset for tall logo */
        const nav = document.querySelector('.sticky-nav');

        function setNavOffset() {
            if (nav) {
                const h = nav.offsetHeight || 140;
                document.documentElement.style.setProperty('--nav-offset', h + 'px');
            }
        }
        window.addEventListener('load', setNavOffset);
        window.addEventListener('resize', setNavOffset);

        /* Switch nav text (dark/light) while staying transparent */
        const heroEl = document.querySelector('.hero');
        const ctaBtn = document.querySelector('.brand-cta');

        function setNavScheme() {
            const swapAt = Math.max(0, (heroEl?.offsetHeight || 300) - (nav?.offsetHeight || 0) - 20);
            const light = window.scrollY >= swapAt; // when we leave hero area
            if (light) {
                nav.classList.remove('navbar-dark');
                nav.classList.add('navbar-light');
                ctaBtn?.classList.remove('brand-cta--dark');
                ctaBtn?.classList.add('brand-cta--light');
            } else {
                nav.classList.add('navbar-dark');
                nav.classList.remove('navbar-light');
                ctaBtn?.classList.add('brand-cta--dark');
                ctaBtn?.classList.remove('brand-cta--light');
            }
        }
        window.addEventListener('scroll', setNavScheme);
        window.addEventListener('load', setNavScheme);

        /* Pricing toggle */
        const toggle = document.getElementById('billingToggle');
        const priceEls = document.querySelectorAll('.price');
        const billingLabels = document.querySelectorAll('.billing-label');

        function updatePrices() {
            priceEls.forEach(el => {
                const monthly = el.dataset.monthly,
                    yearly = el.dataset.yearly;
                el.textContent = (toggle && toggle.checked) ? yearly : monthly;
            });
            billingLabels.forEach(l => l && (l.textContent = (toggle && toggle.checked) ? '/mois (facturé annuellement)' :
                '/mois'));
        }
        toggle && toggle.addEventListener('change', updatePrices);
        updatePrices();

        /* Reveal animations */
        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (!reduce) {
            const revealEls = document.querySelectorAll('.reveal');
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('is-visible');
                        io.unobserve(e.target);
                    }
                });
            }, {
                threshold: 0.12
            });
            revealEls.forEach(el => io.observe(el));
        } else {
            document.querySelectorAll('.reveal').forEach(el => el.classList.add('is-visible'));
        }

        /* Highlight current section in navbar */
        const links = [...document.querySelectorAll('.nav-link[href^="#"]')];
        const sections = links.map(a => document.querySelector(a.getAttribute('href'))).filter(Boolean);

        function setActiveLink() {
            let idx = 0;
            const fromTop = window.scrollY + 140;
            sections.forEach((sec, i) => {
                if (sec.offsetTop <= fromTop) idx = i;
            });
            links.forEach(l => l.classList.remove('active'));
            links[idx]?.classList.add('active');
        }
        window.addEventListener('scroll', setActiveLink);
        window.addEventListener('load', setActiveLink);
    </script>
</body>

</html>
