<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <!-- ========= META ========= -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Rihla — Site d’agence + CRM & réservations pour agences de voyage au Maroc. Vitrine moderne, itinéraires dynamiques, leads WhatsApp et paiements (optionnels)." />
  <meta name="theme-color" content="#0BA5B5" />
  <title>Rihla — Le site & CRM pour agences de voyage</title>
  <link rel="shortcut icon" href="{{ asset('assets/travel/favicon.png') }}">

  <!-- ========= FONTS & CSS ========= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    /* ============================================================
       Teal & Sand palette + airy, travel-centric UI
    ============================================================ */
    :root{
      --brand:#0BA5B5;       /* teal */
      --brand-600:#0A8A99;   /* deeper teal */
      --brand-700:#086E7A;   /* hover accent */

      --sand:#FFF1D6;        /* sand wash */
      --dune:#FDF7E2;        /* very light sand */
      --bg:#F7FBFD;          /* misty sky */

      --ink:#0f172a;
      --muted:#667085;
      --surface:#ffffff;
      --surface-2:#F3FAFC;
      --border:#E6F1F4;
      --ring:rgba(11,165,181,.25);

      --success:#16a34a;
      --danger:#ef4444;

      --radius:18px;
      --shadow-1:0 6px 20px rgba(2,6,23,.06);
      --shadow-2:0 16px 40px rgba(2,6,23,.10);
    }

    html{scroll-behavior:smooth}
    body{
      font-family:'Manrope',system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
      color:var(--ink);
      background:
        radial-gradient(900px 480px at 80% -10%, rgba(11,165,181,.10), transparent 60%),
        var(--bg);
      overflow-x:hidden;
    }
    h1,h2,h3,h4,h5,h6{font-family:'Inter',sans-serif;letter-spacing:-.015em;font-weight:800}
    .text-muted{color:var(--muted)!important}

    /* ===== NAVBAR ===== */
    .navbar{
      position:sticky; top:0; z-index:1040;
      background:rgba(255,255,255,.86);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom:1px solid var(--border);
      transition: box-shadow .25s ease, padding .2s ease, background .25s ease;
      padding:.7rem 0;
    }
    .navbar::after{
      content:"";
      position:absolute; left:0; right:0; bottom:-1px; height:2px;
      background: linear-gradient(90deg, var(--sand), var(--dune));
      opacity:.55; pointer-events:none;
    }
    .navbar.scrolled{
      background:#fff;
      box-shadow:0 10px 28px rgba(0,0,0,.06);
      padding:.45rem 0;
    }
    #scrollProgress{
      position:absolute; top:0; left:0; height:3px; width:0%;
      background:linear-gradient(90deg, var(--brand), #6AD6E2);
      border-bottom-right-radius:3px; border-top-right-radius:3px;
      transition: width .15s ease;
    }

    .navbar .navbar-brand strong{font-weight:800; letter-spacing:.2px}
    .navbar .nav-link{
      font-weight:600; padding:.45rem .8rem; border-radius:999px; position:relative; color:var(--ink);
    }
    .navbar .nav-link:hover,.navbar .nav-link:focus{
      background:rgba(11,165,181,.10);
      color:var(--ink);
    }
    .navbar .nav-link:focus-visible{
      outline:0; box-shadow:0 0 0 4px var(--ring);
    }
    .nav-group{position:relative}
    .nav-indicator{
      position:absolute; height:2px; bottom:-6px; left:0; width:0;
      background:linear-gradient(90deg, var(--brand), #6AD6E2);
      border-radius:2px; opacity:0;
      transition: transform .25s ease, width .25s ease, opacity .2s ease;
      pointer-events:none;
    }

    .btn-primary{
      --bs-btn-bg:var(--brand);
      --bs-btn-border-color:var(--brand);
      --bs-btn-hover-bg:var(--brand-600);
      --bs-btn-hover-border-color:var(--brand-600);
      box-shadow:0 10px 20px rgba(11,165,181,.22);
      border-radius:12px; font-weight:700;
    }
    .btn-outline-primary{
      --bs-btn-color:var(--brand);
      --bs-btn-border-color:var(--brand);
      --bs-btn-hover-color:#fff;
      --bs-btn-hover-bg:var(--brand);
      --bs-btn-hover-border-color:var(--brand);
      border-radius:12px; font-weight:700;
      background:transparent;
    }
    .btn-light{border-radius:12px;font-weight:700}

    .offcanvas-nav { background:#fff; border-left:1px solid var(--border); }
    .offcanvas-nav .list-group-item{ border:0; padding:.9rem 0; font-weight:700; }
    .offcanvas-nav .list-group{ border:0; border-radius:0; }
    .offcanvas-header{
      border-bottom:1px solid var(--border);
      background:linear-gradient(90deg, var(--dune), var(--sand));
    }

    /* ===== Hero ===== */
    .hero{
      padding:64px 0 56px;
      background: linear-gradient(135deg, var(--dune) 0%, var(--sand) 100%);
      border-bottom:1px solid var(--border);
      position:relative; isolation:isolate;
    }
    .hero .badge-soft{
      background:#fff; color:var(--brand); border:1px solid var(--border);
      border-radius:999px; padding:.4rem .7rem; font-weight:700;
      box-shadow:0 6px 16px rgba(0,0,0,.06);
    }
    .hero h1 .spark{
      background:linear-gradient(90deg, var(--brand) 0%, #6AD6E2 100%);
      -webkit-background-clip:text; background-clip:text; color:transparent;
    }
    .phone{
      width:320px; max-width:90%; aspect-ratio:9/19.5;
      border:10px solid #0d1117; border-radius:38px; background:#000;
      box-shadow:var(--shadow-2); position:relative; margin:0 auto; overflow:hidden;
    }
    .phone .screen{position:absolute; inset:0; background:#0b1f26; display:grid; place-items:center}
    .phone .screen img{width:100%; height:100%; object-fit:cover}

    /* ===== Sections / cards ===== */
    .section-title{margin-bottom:.5rem}
    .section-sub{color:var(--muted); margin-bottom:2rem}

    .feature{
      background:var(--surface); border:1px solid var(--border);
      border-radius:var(--radius); padding:1.5rem; height:100%;
      box-shadow:var(--shadow-1); transition:transform .18s ease, box-shadow .18s ease;
    }
    .feature:hover{transform:translateY(-4px); box-shadow:var(--shadow-2)}
    .feature .icon{
      width:48px;height:48px;border-radius:12px;display:grid;place-items:center;
      color:var(--brand); background:rgba(11,165,181,.10); margin-bottom:.75rem;
      border:1px solid var(--border); font-size:1.25rem;
    }

    .showcase{
      background:var(--surface); border:1px solid var(--border);
      border-radius:var(--radius); padding:1rem; box-shadow:var(--shadow-1);
    }
    .showcase .nav-link{border-radius:10px;font-weight:700;color:var(--muted)}
    .showcase .nav-link.active{
      color:var(--ink); background:rgba(11,165,181,.10);
      border:1px solid rgba(11,165,181,.3);
    }
    .showcase .tab-pane{
      border-radius:12px; background:var(--surface-2);
      border:1px dashed var(--border); padding:1rem; min-height:280px;
    }

    /* ===== Comparison ===== */
    .compare{
      background:var(--surface-2);
      border-top:1px solid var(--border);
      border-bottom:1px solid var(--border);
      padding:56px 0;
    }
    .compare-card{
      background:#fff; border:1px solid var(--border); border-radius:16px;
      box-shadow:var(--shadow-1); height:100%; padding:1.25rem;
    }
    .compare-card h5{ font-weight:800; }
    .compare-list{ list-style:none; padding:0; margin:0; }
    .compare-list li{
      display:flex; align-items:flex-start; gap:.6rem;
      padding:.5rem 0; border-bottom:1px dashed var(--border);
      font-size:.95rem;
    }
    .compare-list li:last-child{ border-bottom:0; }
    .compare-list .icon{
      width:28px; height:28px; border-radius:8px; display:inline-grid; place-items:center;
      flex-shrink:0;
    }
    .icon-yes{ background:#F0FBF4; color:#0f7a3a; border:1px solid #D7F3E1; }
    .icon-no{  background:#FFF1F1; color:#c02626; border:1px solid #FFE0E0; }

    .price-card{
      background:var(--surface); border:1px solid var(--border);
      border-radius:var(--radius); box-shadow:var(--shadow-1);
      height:100%; transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .price-card:hover{transform:translateY(-4px); box-shadow:var(--shadow-2)}
    .price-card.featured{border:2px solid var(--brand)}
    .price-badge{
      background:linear-gradient(90deg, var(--brand), #6AD6E2);
      color:#fff; font-size:.75rem; padding:.25rem .6rem; border-radius:.5rem;
      box-shadow:0 6px 16px rgba(0,0,0,.08)
    }

    .toggle{
      display:inline-flex; align-items:center; gap:.5rem;
      background:var(--surface); border:1px solid var(--border);
      border-radius:999px; padding:.3rem; box-shadow:var(--shadow-1);
    }
    .toggle .seg{
      border-radius:999px; padding:.35rem .8rem; font-weight:700; cursor:pointer;
      color:var(--muted);
    }
    .toggle .seg.active{background:rgba(11,165,181,.12); color:var(--ink); border:1px solid rgba(11,165,181,.28)}

    .testimonial{
      background:var(--surface); border:1px solid var(--border);
      border-radius:var(--radius); padding:1.25rem; height:100%; box-shadow:var(--shadow-1);
    }

    .cta{
      background:
        radial-gradient(900px 480px at 10% -10%, rgba(106,214,226,.25), transparent 60%),
        linear-gradient(135deg, var(--dune), #EFFFFA);
      padding:64px 0; border-top:1px solid var(--border); border-bottom:1px solid var(--border);
    }

    /* ===== Footer ===== */
    .site-footer{
      background:var(--surface);
      border-top:1px solid var(--border);
      position:relative;
      overflow:hidden;
    }
    .site-footer::before{
      content:"";
      position:absolute; left:0; right:0; top:0; height:2px;
      background: linear-gradient(90deg, var(--dune), var(--sand));
      opacity:.6;
    }
    .footer-brand{display:flex; align-items:center; gap:.6rem}
    .footer-brand img{height:36px; width:auto}
    .footer-card{background:var(--surface-2);border:1px solid var(--border);border-radius:14px;padding:1rem}
    .footer-link{color:var(--ink); text-decoration:none}
    .footer-link:hover{text-decoration:underline}
    .social a{
      width:38px; height:38px; display:inline-flex; align-items:center; justify-content:center;
      border-radius:10px; border:1px solid var(--border); background:#fff; margin-right:.35rem; color:var(--ink);
      transition: transform .12s ease, box-shadow .12s ease;
    }
    .social a:hover{ transform: translateY(-2px); box-shadow:0 8px 16px rgba(0,0,0,.08) }

    .section-divider{height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent)}
    .mobile-cta{
      position:fixed; left:0; right:0; bottom:0; z-index:1050;
      display:none; gap:.7rem; align-items:center; justify-content:space-between;
      padding:.7rem .9rem; background:var(--surface); border-top:1px solid var(--border);
      box-shadow:0 -8px 24px rgba(0,0,0,.08);
    }
    @media (max-width: 991.98px){ .mobile-cta{ display:flex } }
  </style>
</head>

<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-expand-lg" id="siteNav" aria-label="Navigation principale">
    <div id="scrollProgress" aria-hidden="true"></div>
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="#" aria-label="Rihla accueil">
        <img src="{{ asset('assets/travel/logo.png') }}" alt="Rihla" height="40">
        <strong>Rihla</strong>
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
      <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-label="Ouvrir le menu">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <!-- Offcanvas mobile menu -->
  <div class="offcanvas offcanvas-end offcanvas-nav" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel">
    <div class="offcanvas-header">
      <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('assets/travel/logo.png') }}" alt="Rihla" height="28">
        <strong id="offcanvasNavLabel">Rihla</strong>
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
            <i class="bi bi-geo-alt-fill"></i> Site d’agence prêt en 1 journée
          </span>
          <h1 class="display-5 mb-3">Le <span class="spark">site & CRM</span> qui convertit plus de voyageurs</h1>
          <p class="lead text-muted mb-4">Présentez vos circuits Maroc & monde, gérez les leads WhatsApp, éditez des devis/itinéraires en 2 minutes et (optionnel) encaissez en ligne.</p>
          <div class="d-flex flex-wrap gap-2">
            <a href="/register" class="btn btn-primary btn-lg">Démarrer l’essai</a>
            <a href="#showcase" class="btn btn-outline-primary btn-lg">Voir le produit</a>
          </div>
          <div class="d-flex gap-4 mt-4 flex-wrap text-muted small">
            <div><strong>14j</strong> d’essai • Sans CB</div>
            <div><i class="bi bi-shield-check"></i> Sauvegardes quotidiennes</div>
            <div><i class="bi bi-translate"></i> FR/AR/EN • MAD/EUR</div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="phone" aria-label="Aperçu de site d’agence sur smartphone">
            <div class="screen">
              <img id="demoScreen" src="{{ asset('assets/travel/hero-1.jpg') }}" alt="Aperçu travel" width="320" height="640" fetchpriority="high" decoding="async">
            </div>
          </div>
          <div class="text-center small text-muted mt-2">Aperçu dynamique (images défilantes)</div>
        </div>
      </div>

      <!-- Trust / Integrations (placeholders) -->
      <div class="mt-5 pt-3">
        <div class="text-center text-muted mb-2">Fonctionne avec vos outils (intégrations possibles)</div>
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
          <img src="{{ asset('assets/travel/integrations/whatsapp.png') }}" alt="WhatsApp Business" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
          <img src="{{ asset('assets/travel/integrations/stripe.png') }}" alt="Stripe" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
          <img src="{{ asset('assets/travel/integrations/cmi.png') }}" alt="CMI Maroc" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
          <img src="{{ asset('assets/travel/integrations/mail.png') }}" alt="Email" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
          <img src="{{ asset('assets/travel/integrations/maps.png') }}" alt="Maps" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
        </div>
      </div>
    </div>
  </header>

  <!-- ===== METRICS ===== -->
  <section class="py-4" style="background:var(--surface)">
    <div class="container">
      <div class="row text-center g-4">
        <div class="col-6 col-md-3"><div class="h2 mb-1">+350</div><div class="text-muted small">leads / mois</div></div>
        <div class="col-6 col-md-3"><div class="h2 mb-1">&lt;2h</div><div class="text-muted small">temps de 1ère réponse</div></div>
        <div class="col-6 col-md-3"><div class="h2 mb-1">+22%</div><div class="text-muted small">taux de conversion</div></div>
        <div class="col-6 col-md-3"><div class="h2 mb-1">4.8★</div><div class="text-muted small">avis moyens</div></div>
      </div>
      <div class="section-divider my-4"></div>
    </div>
  </section>

  <!-- ===== FEATURES ===== -->
  <section id="features" class="py-5">
    <div class="container">
      <div class="text-center">
        <h2 class="section-title">Pensé pour les agences marocaines</h2>
        <p class="section-sub">Site moderne, CRM simple et réservations fluides.</p>
      </div>
      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="feature">
            <div class="icon"><i class="bi bi-layout-text-window-reverse"></i></div>
            <h6 class="fw-bold">Site vitrine rapide</h6>
            <p class="small text-muted mb-0">Pages circuits & séjours, catégories, cartes, FAQ et blog SEO.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="feature">
            <div class="icon"><i class="bi bi-kanban"></i></div>
            <h6 class="fw-bold">CRM pipeline</h6>
            <p class="small text-muted mb-0">Suivez les demandes: nouveau, devis, confirmé, soldé, archivé.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="feature">
            <div class="icon"><i class="bi bi-file-earmark-richtext"></i></div>
            <h6 class="fw-bold">Devis & itinéraires</h6>
            <p class="small text-muted mb-0">Générez des PDF propres (logo, cachet) en FR/AR/EN.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="feature">
            <div class="icon"><i class="bi bi-credit-card"></i></div>
            <h6 class="fw-bold">Paiement en ligne (opt.)</h6>
            <p class="small text-muted mb-0">Lien de paiement CMI/Stripe, acomptes, reçus automatiques.</p>
          </div>
        </div>
      </div>

      <div class="row g-4 mt-1">
        <div class="col-md-6 col-lg-4">
          <div class="feature">
            <div class="icon"><i class="bi bi-whatsapp"></i></div>
            <h6 class="fw-bold">Leads WhatsApp</h6>
            <p class="small text-muted mb-0">Boutons WA intelligents sur les circuits, capture des infos essentielles.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="feature">
            <div class="icon"><i class="bi bi-globe2"></i></div>
            <h6 class="fw-bold">FR/AR/EN & MAD/EUR</h6>
            <p class="small text-muted mb-0">Textes multilingues, devises et taxes locales.</p>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <div class="feature">
            <div class="icon"><i class="bi bi-people"></i></div>
            <h6 class="fw-bold">Multi-agents</h6>
            <p class="small text-muted mb-0">Comptes équipe, permissions, historique et tâches.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== COMPARISON (Excel & WhatsApp vs Rihla) ===== -->
  <section id="compare" class="compare">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="section-title">Pourquoi passer à Rihla&nbsp;?</h2>
        <p class="section-sub">Comparez “Excel + WhatsApp” et une suite cohérente.</p>
      </div>

      <div class="row g-4">
        <div class="col-lg-6">
          <div class="compare-card h-100">
            <h5 class="mb-3"><i class="bi bi-rocket-takeoff-fill me-2 text-success"></i> Rihla (site + CRM)</h5>
            <ul class="compare-list">
              <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> Pages circuits SEO + formulaires leads</li>
              <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> Devis/itinéraires PDF élégants</li>
              <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> Pipeline clair + rappels automatiques</li>
              <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> Paiements en ligne (optionnel)</li>
              <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> Statistiques et sources de leads</li>
            </ul>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="compare-card h-100">
            <h5 class="mb-3"><i class="bi bi-table me-2 text-danger"></i> Excel + WhatsApp</h5>
            <ul class="compare-list">
              <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Perte d’infos entre messages</li>
              <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Aucun suivi des étapes</li>
              <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Présentations non professionnelles</li>
              <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Pas de paiements sécurisés</li>
              <li><span class="icon icon-no"><i class="bi bi-x"></i></span> Zéro analytics fiable</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="text-center mt-4">
        <a href="/register" class="btn btn-primary btn-lg">Essayer gratuitement</a>
      </div>
    </div>
  </section>

  <!-- ===== PRODUCT SHOWCASE ===== -->
  <section id="showcase" class="py-5">
    <div class="container">
      <div class="row g-4 align-items-stretch">
        <div class="col-lg-6">
          <div class="showcase h-100">
            <ul class="nav nav-pills gap-2 mb-3" id="prodTabs" role="tablist">
              <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-site" type="button" role="tab">Site d’agence</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-crm" type="button" role="tab">CRM</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-devis" type="button" role="tab">Devis & Itinéraires</button></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-site" role="tabpanel">
                <img src="{{ asset('assets/travel/site-builder.png') }}" alt="Constructeur de pages circuits" class="img-fluid rounded" loading="lazy">
              </div>
              <div class="tab-pane fade" id="tab-crm" role="tabpanel">
                <img src="{{ asset('assets/travel/crm-pipeline.png') }}" alt="CRM pipeline" class="img-fluid rounded" loading="lazy">
              </div>
              <div class="tab-pane fade" id="tab-devis" role="tabpanel">
                <img src="{{ asset('assets/travel/itinerary.png') }}" alt="Devis & itinéraires PDF" class="img-fluid rounded" loading="lazy">
              </div>
            </div>
            <div class="small text-muted mt-2">Aperçus d’interface (exemples)</div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="showcase h-100">
            <h5 class="mb-2">Le parcours en 3 étapes</h5>
            <ol class="small text-muted mb-3">
              <li>Ajoutez vos circuits & départs garantis</li>
              <li>Recevez des demandes depuis le site & WhatsApp</li>
              <li>Envoyez devis/itinéraire, puis encaissez (optionnel)</li>
            </ol>
            <img src="{{ asset('assets/travel/flow-agency.png') }}" class="img-fluid rounded border" alt="Flux agence" loading="lazy">
            <div class="d-flex gap-2 mt-3">
              <a href="/register" class="btn btn-primary">Créer mon compte</a>
              <a href="/contact" class="btn btn-outline-primary">Demander une démo</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== PRICING ===== -->
  <section id="pricing" class="py-5">
    <div class="container">
      <div class="text-center">
        <h2 class="section-title">Tarification simple et claire</h2>
        <p class="section-sub">Commencez gratuitement. Passez quand vous voulez.</p>
        <div class="toggle mt-1" aria-live="polite">
          <span class="seg active" id="billMonthly">Mensuel</span>
          <span class="seg" id="billYearly">Annuel <span class="text-success">(–15%)</span></span>
        </div>
      </div>

      <div class="row g-4 justify-content-center mt-1">
        <div class="col-md-4">
          <div class="price-card p-4 h-100">
            <h6 class="fw-bold">Gratuit</h6>
            <div class="display-6 fw-extrabold my-2"><span class="price" data-monthly="0" data-yearly="0">0</span> MAD</div>
            <p class="text-muted small">Parfait pour tester le marché</p>
            <ul class="list-unstyled small mb-4">
              <li><i class="bi bi-check2 text-success"></i> Site vitrine basique</li>
              <li><i class="bi bi-check2 text-success"></i> 3 circuits publiés</li>
              <li><i class="bi bi-check2 text-success"></i> Formulaire & WhatsApp</li>
              <li><i class="bi bi-x-lg text-danger"></i> PDF devis/itinéraire</li>
            </ul>
            <a href="/register" class="btn btn-outline-primary w-100">Commencer</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="price-card p-4 h-100 featured position-relative">
            <span class="price-badge position-absolute top-0 end-0 mt-3 me-3">Populaire</span>
            <h6 class="fw-bold">Starter</h6>
            <div class="display-6 fw-extrabold my-2">
              <span class="price" data-monthly="199" data-yearly="169">199</span> MAD
              <span class="fs-6 fw-normal billing-label">/mois</span>
            </div>
            <p class="text-muted small">Site complet + CRM</p>
            <ul class="list-unstyled small mb-4">
              <li><i class="bi bi-check2 text-success"></i> Circuits illimités</li>
              <li><i class="bi bi-check2 text-success"></i> Devis & itinéraires PDF</li>
              <li><i class="bi bi-check2 text-success"></i> Pipeline & rappels</li>
              <li><i class="bi bi-check2 text-success"></i> FR/AR/EN & MAD/EUR</li>
              <li><i class="bi bi-check2 text-success"></i> Sans branding Rihla</li>
            </ul>
            <a href="/register" class="btn btn-primary w-100">Essai gratuit 14 j</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="price-card p-4 h-100">
            <h6 class="fw-bold">Pro</h6>
            <div class="display-6 fw-extrabold my-2">
              <span class="price" data-monthly="399" data-yearly="339">399</span> MAD
              <span class="fs-6 fw-normal billing-label">/mois</span>
            </div>
            <p class="text-muted small">Pour équipes & paiements</p>
            <ul class="list-unstyled small mb-4">
              <li><i class="bi bi-check2 text-success"></i> Multi-agents + permissions</li>
              <li><i class="bi bi-check2 text-success"></i> Paiement en ligne (opt.)</li>
              <li><i class="bi bi-check2 text-success"></i> Intégrations WhatsApp/Email</li>
              <li><i class="bi bi-check2 text-success"></i> Domaines personnalisés</li>
              <li><i class="bi bi-check2 text-success"></i> Support prioritaire</li>
            </ul>
            <a href="/register" class="btn btn-outline-primary w-100">Essai gratuit 14 j</a>
          </div>
        </div>
      </div>
      <p class="text-center small text-muted mt-3">Réduction appliquée en annuel. Exemples indicatifs.</p>
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
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fq1c">Puis-je utiliser mon propre domaine&nbsp;?</button>
          </h2>
          <div id="fq1c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body small">Oui, nous configurons votre domaine (ex: <em>voyages-agence.ma</em>) vers votre site Rihla.</div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="fq2">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fq2c">Acceptez-vous CMI/Stripe&nbsp;?</button>
          </h2>
          <div id="fq2c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body small">Oui, en offre Pro (optionnel). Vous pouvez envoyer des liens d’acompte sécurisés.</div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="fq3">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fq3c">L’essai est-il vraiment sans engagement&nbsp;?</button>
          </h2>
          <div id="fq3c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body small">Oui, 14 jours d’essai. Sans action de votre part, vous passez en offre gratuite.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== CTA ===== -->
  <section class="cta text-center">
    <div class="container">
      <h2 class="fw-bold mb-2">Prêt à booster vos réservations&nbsp;?</h2>
      <p class="mb-4">Mettez en ligne vos circuits et commencez à recevoir des demandes dès aujourd’hui.</p>
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
              <img src="{{ asset('assets/travel/logo.png') }}" alt="Rihla">
              <strong>Rihla</strong>
            </div>
            <p class="small text-muted mb-3">
              Le site & CRM qui simplifie la vente de voyages pour les agences marocaines. Itinéraires élégants, leads WhatsApp, paiements en ligne (optionnels).
            </p>
            <div class="social">
              <a href="https://instagram.com" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
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
          <p class="small text-muted mb-2">Recevez des conseils pour générer plus de demandes qualifiées.</p>
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
          &copy; 2025 Rihla. Tous droits réservés.
        </p>
        <div class="d-flex align-items-center gap-3">
          <a href="#overview" class="btn btn-outline-primary btn-sm" id="toTopBtn" aria-label="Retour en haut">
            <i class="bi bi-arrow-up"></i> Haut de page
          </a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Mobile sticky CTA -->
  <div class="mobile-cta">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-geo-alt"></i>
      <span class="small">Essayez Rihla gratuitement</span>
    </div>
    <a href="/register" class="btn btn-primary btn-sm">Créer mon compte</a>
  </div>

  <!-- ========= SCRIPTS ========= -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    // Phone demo carousel
    const demo = document.getElementById('demoScreen');
    const shots = [
      "{{ asset('assets/travel/hero-1.jpg') }}",
      "{{ asset('assets/travel/hero-2.jpg') }}",
      "{{ asset('assets/travel/hero-3.jpg') }}"
    ];
    let idx = 0;
    setInterval(() => {
      idx = (idx + 1) % shots.length;
      if (demo) demo.src = shots[idx];
    }, 3200);

    // Pricing toggle
    const billMonthly = document.getElementById('billMonthly');
    const billYearly  = document.getElementById('billYearly');
    const priceEls    = document.querySelectorAll('.price');
    const billingLabels = document.querySelectorAll('.billing-label');
    function setBilling(yearly){
      billMonthly.classList.toggle('active', !yearly);
      billYearly.classList.toggle('active', yearly);
      priceEls.forEach(el => el.textContent = yearly ? el.dataset.yearly : el.dataset.monthly);
      billingLabels.forEach(l => l && (l.textContent = yearly ? '/mois (facturé annuellement)' : '/mois'));
    }
    billMonthly?.addEventListener('click', () => setBilling(false));
    billYearly?.addEventListener('click',  () => setBilling(true));
    setBilling(false);

    // Navbar behavior + progress + active link indicator
    const nav = document.getElementById('siteNav');
    const progress = document.getElementById('scrollProgress');
    const indicator = document.getElementById('navIndicator');
    const linkNodes = [...document.querySelectorAll('.navbar .nav-link[href^="#"]')];
    const sections = linkNodes.map(a => document.querySelector(a.getAttribute('href'))).filter(Boolean);

    function setProgress(){
      const st = document.documentElement.scrollTop || document.body.scrollTop;
      const h = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const pct = Math.max(0, Math.min(1, st / h));
      progress.style.width = (pct * 100).toFixed(2) + '%';
    }

    function moveIndicator(el){
      const group = document.querySelector('.nav-group');
      if (!indicator || !group || !el) { if (indicator) indicator.style.opacity = '0'; return; }
      const r = el.getBoundingClientRect();
      const gp = group.getBoundingClientRect();
      indicator.style.width = r.width + 'px';
      indicator.style.transform = `translateX(${r.left - gp.left}px)`;
      indicator.style.opacity = '1';
    }

    function setActiveOnScroll(){
      if (window.scrollY > 8) nav?.classList.add('scrolled'); else nav?.classList.remove('scrolled');
      setProgress();

      let idx = -1;
      const fromTop = window.scrollY + 120;
      sections.forEach((sec, i) => { if (sec.offsetTop <= fromTop) idx = i; });
      linkNodes.forEach(l => l.classList.remove('active'));
      const active = idx >= 0 ? linkNodes[idx] : null;
      active?.classList.add('active');
      moveIndicator(active);
    }

    linkNodes.forEach(l => {
      l.addEventListener('mouseenter', () => moveIndicator(l));
      l.addEventListener('mouseleave', () => moveIndicator(document.querySelector('.navbar .nav-link.active')));
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
    const msg  = document.getElementById('newsletterMsg');
    form?.addEventListener('submit', (e) => {
      e.preventDefault();
      msg.textContent = 'Merci ! Vous recevrez bientôt nos conseils.';
      msg.className = 'small mt-2 text-success';
      form.reset();
      setTimeout(() => { msg.textContent = ''; msg.className = 'small mt-2'; }, 4000);
    });

    // Footer: back to top
    document.getElementById('toTopBtn')?.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({top:0, behavior:'smooth'});
    });
  </script>
</body>
</html>
