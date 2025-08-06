<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <!-- ========= META ========= -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="QRivo est la solution de menu digital la plus rapide pour moderniser votre restaurant, augmenter vos ventes et simplifier vos mises à jour — sans impression.">
    <title>QRivo — Menu Digital Intelligent</title>

    <!-- ========= FONTS ========= -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- ========= CSS & ICONS ========= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ---------- Color system ---------- */
        :root{
            --qr-primary:#ff6b35;
            --qr-secondary:#1e1e28;
            --qr-light-bg:#f8f9fc;
            --qr-success:#3cb371;
        }

        /* ---------- Base ---------- */
        body{
            font-family:'Manrope', sans-serif;
            color:#343a40;
            scroll-behavior:smooth;
            background:#fff;
        }
        h1,h2,h3,h4,h5,h6{
            font-family:'Inter', sans-serif;
            font-weight:700;
        }
        .btn-primary{background:var(--qr-primary);border:none;}
        .btn-primary:hover{background:#ff8659;}
        .btn-outline-primary{border-color:var(--qr-primary);color:var(--qr-primary);}
        .btn-outline-primary:hover{background:var(--qr-primary);color:#fff;}
        .btn-outline-light{border-color:#fff;color:#fff;}
        .btn-outline-light:hover{background:#ffffff33;}

        /* ---------- Navbar ---------- */
        .navbar-brand{font-weight:800;font-size:1.35rem;}
        .nav-link{font-weight:500;}
        .sticky-nav{transition:all .3s;}
        .sticky-nav.scrolled{background:#fff!important;box-shadow:0 2px 6px rgba(0,0,0,.06);}
        .sticky-nav.scrolled .nav-link,
        .sticky-nav.scrolled .navbar-brand{color:#000!important;}

        /* ---------- Hero ---------- */
        .hero{
            background:linear-gradient(135deg,var(--qr-primary) 0%,#ffa94d 100%);
            color:#fff;
            padding:7rem 0 6rem;
        }
        .hero img{max-width:100%;filter:drop-shadow(0 1rem 2rem rgba(0,0,0,.2));}

        /* ---------- Feature cards ---------- */
        .feature-card{
            border:0;border-radius:1rem;padding:2.5rem 1.8rem;text-align:center;background:#fff;
            box-shadow:0 .5rem 1.25rem rgba(16,24,40,.05);transition:transform .3s, box-shadow .3s;
        }
        .feature-card:hover{transform:translateY(-6px);box-shadow:0 .75rem 1.5rem rgba(16,24,40,.08);}
        .feature-icon{
            width:64px;height:64px;background:var(--qr-light-bg);border-radius:50%;
            display:flex;align-items:center;justify-content:center;font-size:1.75rem;
            color:var(--qr-primary);margin:0 auto 1.25rem;
        }

        /* ---------- Steps ---------- */
        .step-icon{font-size:2.4rem;color:var(--qr-primary);}

        /* ---------- Pricing ---------- */
        .price-toggle .form-check-input{
            cursor:pointer;width:3rem;height:1.5rem;margin-right:.5rem;appearance:none;
            background:#adb5bd;border-radius:25px;position:relative;transition:background .3s;
        }
        .price-toggle .form-check-input:checked{background:var(--qr-primary);}
        .price-toggle .form-check-input::before{
            content:'';position:absolute;height:1.2rem;width:1.2rem;top:3px;left:3px;
            background:#fff;border-radius:50%;transition:transform .3s;
        }
        .price-toggle .form-check-input:checked::before{transform:translateX(1.5rem);}
        .price-card{border-radius:1rem;overflow:hidden;transition:transform .3s;}
        .price-card:hover{transform:translateY(-4px);}
        .price-card.featured{box-shadow:0 .75rem 1.75rem rgba(16,24,40,.09);border:2px solid var(--qr-primary);}
        .price-badge{background:var(--qr-primary);color:#fff;font-size:.75rem;padding:.2rem .6rem;border-radius:.5rem;}

        /* ---------- Testimonials ---------- */
        .testimonial-card{
            background:#fff;border:0;border-radius:1rem;padding:2rem;
            box-shadow:0 .5rem 1.25rem rgba(16,24,40,.05);
        }
        .testimonial-avatar{
            width:60px;height:60px;border-radius:50%;object-fit:cover;margin-right:1rem;
        }

        /* ---------- FAQ ---------- */
        .accordion-button:not(.collapsed){background:var(--qr-light-bg);color:#000;}

        /* ---------- CTA Banner & Footer ---------- */
        .cta-banner{background:var(--qr-secondary);color:#fff;padding:5rem 0;}
        footer{background:#13131a;color:#adb5bd;padding:3rem 0;}
        footer a{color:#fff;text-decoration:none;}
        footer a:hover{text-decoration:underline;}

        /* ---------- Animations ---------- */
        @keyframes float{
            0%{transform:translateY(0);}
            50%{transform:translateY(-10px);}
            100%{transform:translateY(0);}
        }
        .floating{animation:float 6s ease-in-out infinite;}
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100 sticky-nav">
    <div class="container">
        <a class="navbar-brand text-white" href="#">
            <img src="{{asset('assets/img/logo/accountLogo.png')}}" alt="QRivo Logo" class="d-inline-block align-text-top" width="110" >
        </a>
        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link text-white" href="#features">Fonctionnalités</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#pricing">Tarifs</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#testimonials">Avis</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/login">Se connecter</a></li>
                <!-- Language Switcher -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">FR</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                        <li><a class="dropdown-item" href="/?lang=fr">Français (FR)</a></li>
                        <li><a class="dropdown-item" href="/?lang=ar">العربية (AR)</a></li>
                    </ul>
                </li>
            </ul>
            <a href="#cta" class="btn btn-outline-light ms-lg-3">Tester gratuitement</a>
        </div>
    </div>
</nav>

<!-- ===== HERO ===== -->
<header class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-5 fw-bold mb-3">Votre menu QR<br>prêt en <span class="text-decoration-underline">2&nbsp;minutes</span></h1>
                <p class="lead mb-4">Mettez à jour vos plats, photos et prix en temps réel. Aucun développement, aucune impression — juste un QR code élégant pour vos clients.</p>
                <a href="#cta" class="btn btn-primary btn-lg me-2">Démarrer l’essai gratuit</a>
                <a href="#features" class="btn btn-outline-light btn-lg">Découvrir</a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{asset('assets/img/saas/hero3.png')}}" alt="Aperçu menu QR" class="floating">
            </div>
        </div>
    </div>
</header>

<!-- ===== FEATURES ===== -->
<section id="features" class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Pensé pour vos clients et votre équipe</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="bi bi-pencil-square"></i></div>
                    <h5 class="fw-semibold mb-2">Mises à jour instantanées</h5>
                    <p class="small mb-0">Ajoutez ou modifiez vos plats à tout moment depuis votre tableau de bord intuitif.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="bi bi-translate"></i></div>
                    <h5 class="fw-semibold mb-2">Multilingue &amp; devises</h5>
                    <p class="small mb-0">Proposez le même menu en plusieurs langues et devises, accueillez chaque client comme un local.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="bi bi-images"></i></div>
                    <h5 class="fw-semibold mb-2">Photos &amp; allergènes</h5>
                    <p class="small mb-0">Mettez l’eau à la bouche avec des visuels haute résolution et indiquez clairement les allergènes.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <h5 class="fw-semibold mb-2">Statistiques en temps réel</h5>
                    <p class="small mb-0">Suivez les plats les plus consultés et ajustez votre offre pour augmenter vos ventes.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="bi bi-whatsapp"></i></div>
                    <h5 class="fw-semibold mb-2">Partage WhatsApp</h5>
                    <p class="small mb-0">Permettez aux clients d’envoyer le menu à leurs amis en un clic.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h5 class="fw-semibold mb-2">Sécurisé &amp; conforme</h5>
                    <p class="small mb-0">Hébergement sur serveurs certifiés, sauvegardes quotidiennes &amp; conformité RGPD.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== HOW IT WORKS ===== -->
<section class="py-5" style="background:var(--qr-light-bg);">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Comment ça marche&nbsp;?</h2>
        <div class="row text-center g-4">
            <div class="col-md-3">
                <i class="bi bi-grid-1x2-fill step-icon mb-3"></i>
                <h6 class="fw-semibold mb-2">1. Créez</h6>
                <p class="small">Ajoutez vos catégories, plats & descriptions en ligne.</p>
            </div>
            <div class="col-md-3">
                <i class="bi bi-upc-scan step-icon mb-3"></i>
                <h6 class="fw-semibold mb-2">2. Générez</h6>
                <p class="small">Téléchargez votre QR code avec votre logo et vos couleurs.</p>
            </div>
            <div class="col-md-3">
                <i class="bi bi-display step-icon mb-3"></i>
                <h6 class="fw-semibold mb-2">3. Affichez</h6>
                <p class="small">Imprimez-le sur vos tables, stickers ou chevalets.</p>
            </div>
            <div class="col-md-3">
                <i class="bi bi-arrow-repeat step-icon mb-3"></i>
                <h6 class="fw-semibold mb-2">4. Mettez à jour</h6>
                <p class="small">Modifiez vos plats à volonté — le QR reste le même.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== PRICING ===== -->
<section id="pricing" class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Tarification simple et flexible</h2>
        <!-- Toggle -->
        <div class="d-flex justify-content-center align-items-center mb-5 price-toggle">
            <span class="me-2 fw-semibold">Mensuel</span>
            <input class="form-check-input" type="checkbox" id="billingToggle" aria-label="Toggle billing period">
            <span class="ms-2 fw-semibold">Annuel <span class="text-success">(–15%)</span></span>
        </div>

        <div class="row justify-content-center g-4">
            <!-- Free -->
            <div class="col-md-4">
                <div class="card price-card h-100">
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold">Gratuit</h5>
                        <p class="display-6 fw-bold my-3"><span class="price" data-monthly="0" data-yearly="0">0</span> DH</p>
                        <p class="small mb-2">Parfait si vous avez une petite carte ou un seul menu</p>
                        <ul class="list-unstyled mb-4 small text-start">
                            <li>Jusqu’à <strong>10 plats</strong> gratuits</li>
                            <li>QR code noir & blanc</li>
                            <li>Statistiques basiques</li>
                            <li>Branding QRivo visible</li>
                        </ul>
                        <a href="#cta" class="btn btn-outline-primary w-100">Commencer</a>
                    </div>
                </div>
            </div>
            <!-- Starter -->
            <div class="col-md-4">
                <div class="card price-card featured h-100">
                    <div class="card-body text-center p-4 position-relative">
                        <span class="price-badge position-absolute top-0 end-0 mt-3 me-3">Populaire</span>
                        <h5 class="fw-bold">Starter</h5>
                        <p class="display-6 fw-bold my-3">
                            <span class="price" data-monthly="69" data-yearly="59">69</span> DH
                            <span class="fs-6 fw-normal">/mois</span>
                        </p>
                        <p class="small mb-2">1 menu complet, items illimités</p>
                        <ul class="list-unstyled mb-4 small text-start">
                            <li>1 menu avec items illimités</li>
                            <li>QR codes couleurs</li>
                            <li>Multilingue &amp; devises</li>
                            <li>Statistiques détaillées</li>
                            <li>Sans branding QRivo</li>
                        </ul>
                        <a href="#cta" class="btn btn-primary w-100">Essai gratuit 14 j</a>
                    </div>
                </div>
            </div>
            <!-- Pro -->
            <div class="col-md-4">
                <div class="card price-card h-100">
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold">Pro</h5>
                        <p class="display-6 fw-bold my-3">
                            <span class="price" data-monthly="149" data-yearly="127">149</span> DH
                            <span class="fs-6 fw-normal">/mois</span>
                        </p>
                        <p class="small mb-2">Pour plusieurs menus et usage professionnel</p>
                        <ul class="list-unstyled mb-4 small text-start">
                            <li>Menus illimités</li>
                            <li>QR codes personnalisés</li>
                            <li>Intégrations WhatsApp &amp; Instagram</li>
                            <li>Accès API / export</li>
                            <li>Assistance prioritaire</li>
                        </ul>
                        <a href="#cta" class="btn btn-outline-primary w-100">Essai gratuit 14 j</a>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center mt-3 small text-muted">Réduction automatique appliquée pour l'abonnement annuel. Aucun engagement caché.</p>
    </div>
</section>


<!-- ===== TESTIMONIALS ===== -->
<section id="testimonials" class="py-5" style="background:var(--qr-light-bg);">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Ils nous font confiance</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card h-100 d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{asset('assets/img/avatars/avatar1.jpg')}}" alt="Avatar" class="testimonial-avatar">
                        <div>
                            <h6 class="mb-0 fw-semibold">Amine B.</h6>
                            <small class="text-muted">Propriétaire — Café Atlas</small>
                        </div>
                    </div>
                    <p class="mb-0 small">« Depuis que nous avons adopté QRivo, nos clients trouvent immédiatement les informations qu’ils cherchent et nous avons diminué nos coûts d’impression de 90&nbsp;%. »</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card h-100 d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{asset('assets/img/avatars/avatar2.jpg')}}" alt="Avatar" class="testimonial-avatar">
                        <div>
                            <h6 class="mb-0 fw-semibold">Salma R.</h6>
                            <small class="text-muted">Manager — Pizzeria Napoli</small>
                        </div>
                    </div>
                    <p class="mb-0 small">« Le multilingue a été un game-changer pour nos touristes. Les ventes de desserts ont augmenté grâce aux photos alléchantes&nbsp;! »</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card h-100 d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{asset('assets/img/avatars/avatar3.jpg')}}" alt="Avatar" class="testimonial-avatar">
                        <div>
                            <h6 class="mb-0 fw-semibold">Youssef K.</h6>
                            <small class="text-muted">Directeur — Hotel Oasis</small>
                        </div>
                    </div>
                    <p class="mb-0 small">« Grâce aux statistiques, nous savons quels plats retirer et lesquels mettre en avant. La mise à jour est instantanée, même pour nos trois restaurants. »</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section id="faq" class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Questions fréquentes</h2>
        <div class="accordion accordion-flush" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1">
                        Comment fonctionne la période d’essai&nbsp;?
                    </button>
                </h2>
                <div id="faqCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body small">
                        Vous profitez de toutes les fonctionnalités Starter pendant 14 jours, sans carte bancaire. Si vous ne passez pas à une formule payante, votre compte basculera automatiquement sur l’offre gratuite.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2">
                        Puis-je changer de formule à tout moment&nbsp;?
                    </button>
                </h2>
                <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body small">
                        Oui. Vous pouvez passer d’une formule à l’autre en un clic depuis votre tableau de bord. Le prorata est calculé automatiquement.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3">
                        Dois-je réimprimer mon QR code si je change un plat&nbsp;?
                    </button>
                </h2>
                <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body small">
                        Non. Le QR code pointe vers un lien dynamique. Toute modification dans votre tableau de bord est reflétée instantanément pour vos clients.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CTA BANNER ===== -->
<section id="cta" class="cta-banner text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">Prêt à moderniser votre carte&nbsp;?</h2>
        <p class="mb-4">Créez gratuitement votre premier menu QR et impressionnez vos clients dès aujourd’hui.</p>
        <a href="/register" class="btn btn-light btn-lg">Créer mon compte</a>
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

<!-- ===== SCRIPTS ===== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    /* Sticky navbar on scroll */
    const nav = document.querySelector('.sticky-nav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 30);
    });

    /* Pricing toggle */
    const toggle = document.getElementById('billingToggle');
    const priceEls = document.querySelectorAll('.price');
    const updatePrices = () => {
        priceEls.forEach(el=>{
            const monthly = el.dataset.monthly;
            const yearly  = el.dataset.yearly;
            el.textContent = toggle.checked ? yearly : monthly;
        });
    };
    toggle.addEventListener('change', updatePrices);
    updatePrices();
</script>
</body>
</html>
