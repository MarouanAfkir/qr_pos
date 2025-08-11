<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <!-- ========= META ========= -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="QRivo — Menu digital moderne : QR personnalisés, multilingue, statistiques en temps réel et (optionnel) commande en salle." />
  <meta name="theme-color" content="#34A693" />
  <title>QRivo — Le menu digital moderne</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

  <!-- ========= FONTS & CSS ========= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    /* ============================================================
       Calm, creamy palette (no browns) + simple, reliable UI
    ============================================================ */
    :root{
      --brand:#34A693;        /* soft teal/sage */
      --brand-600:#2c8e7f;
      --brand-700:#257a6d;

      --peach:#FFE9D1;        /* creamy peach */
      --mint:#EAF7F1;         /* soft mint */
      --bg:#FBF7F2;           /* page background (cream) */

      --ink:#1f2937;
      --muted:#667085;
      --surface:#ffffff;
      --surface-2:#F7FAF9;
      --border:#efe6db;
      --ring:rgba(52,166,147,.25);

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
        radial-gradient(900px 480px at 80% -10%, rgba(52,166,147,.10), transparent 60%),
        var(--bg);
      overflow-x:hidden;
    }
    h1,h2,h3,h4,h5,h6{font-family:'Inter',sans-serif;letter-spacing:-.015em;font-weight:800}
    .text-muted{color:var(--muted)!important}

    /* ===== NAVBAR (enhanced UI/UX) ===== */
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
      background: linear-gradient(90deg, var(--peach), var(--mint));
      opacity:.55; pointer-events:none;
    }
    .navbar.scrolled{
      background:#fff;
      box-shadow:0 10px 28px rgba(0,0,0,.06);
      padding:.45rem 0;
    }
    /* scroll progress bar (top, within navbar) */
    #scrollProgress{
      position:absolute; top:0; left:0; height:3px; width:0%;
      background:linear-gradient(90deg, var(--brand), #8ecae6);
      border-bottom-right-radius:3px; border-top-right-radius:3px;
      transition: width .15s ease;
    }

    .navbar .navbar-brand strong{font-weight:800; letter-spacing:.2px}
    .navbar .nav-link{
      font-weight:600; padding:.45rem .8rem; border-radius:999px; position:relative; color:var(--ink);
    }
    .navbar .nav-link:hover,.navbar .nav-link:focus{
      background:rgba(52,166,147,.10);
      color:var(--ink);
    }
    .navbar .nav-link:focus-visible{
      outline:0; box-shadow:0 0 0 4px var(--ring);
    }
    /* Animated underline indicator (desktop) */
    .nav-group{position:relative}
    .nav-indicator{
      position:absolute; height:2px; bottom:-6px; left:0; width:0;
      background:linear-gradient(90deg, var(--brand), #8ecae6);
      border-radius:2px; opacity:0;
      transition: transform .25s ease, width .25s ease, opacity .2s ease;
      will-change: transform, width;
      pointer-events:none;
    }

    .btn-primary{
      --bs-btn-bg:var(--brand);
      --bs-btn-border-color:var(--brand);
      --bs-btn-hover-bg:var(--brand-600);
      --bs-btn-hover-border-color:var(--brand-600);
      box-shadow:0 10px 20px rgba(52,166,147,.22);
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

    /* Offcanvas (mobile menu) */
    .offcanvas-nav {
      background:#fff;
      border-left:1px solid var(--border);
    }
    .offcanvas-nav .list-group-item{
      border:0; padding:.9rem 0; font-weight:700;
    }
    .offcanvas-nav .list-group{
      border:0; border-radius:0;
    }
    .offcanvas-header{
      border-bottom:1px solid var(--border);
      background:linear-gradient(90deg, var(--mint), var(--peach));
    }

    /* ===== Hero ===== */
    .hero{
      padding:64px 0 56px;
      background: linear-gradient(135deg, var(--peach) 0%, var(--mint) 100%);
      border-bottom:1px solid var(--border);
      position:relative; isolation:isolate;
    }
    .hero .badge-soft{
      background:#fff; color:var(--brand); border:1px solid var(--border);
      border-radius:999px; padding:.4rem .7rem; font-weight:700;
      box-shadow:0 6px 16px rgba(0,0,0,.06);
    }
    .hero h1 .spark{
      background:linear-gradient(90deg, var(--brand) 0%, #8ecae6 100%);
      -webkit-background-clip:text; background-clip:text; color:transparent;
    }
    .phone{
      width:320px; max-width:90%; aspect-ratio:9/19.5;
      border:10px solid #0d1117; border-radius:38px; background:#000;
      box-shadow:var(--shadow-2); position:relative; margin:0 auto; overflow:hidden;
    }
    .phone .screen{position:absolute; inset:0; background:#111827; display:grid; place-items:center}
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
      color:var(--brand); background:rgba(52,166,147,.10); margin-bottom:.75rem;
      border:1px solid var(--border); font-size:1.25rem;
    }

    .showcase{
      background:var(--surface); border:1px solid var(--border);
      border-radius:var(--radius); padding:1rem; box-shadow:var(--shadow-1);
    }
    .showcase .nav-link{border-radius:10px;font-weight:700;color:var(--muted)}
    .showcase .nav-link.active{
      color:var(--ink); background:rgba(52,166,147,.10);
      border:1px solid rgba(52,166,147,.3);
    }
    .showcase .tab-pane{
      border-radius:12px; background:var(--surface-2);
      border:1px dashed var(--border); padding:1rem; min-height:280px;
    }

    .price-card{
      background:var(--surface); border:1px solid var(--border);
      border-radius:var(--radius); box-shadow:var(--shadow-1);
      height:100%; transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .price-card:hover{transform:translateY(-4px); box-shadow:var(--shadow-2)}
    .price-card.featured{border:2px solid var(--brand)}
    .price-badge{
      background:linear-gradient(90deg, var(--brand), #8ecae6);
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
    .toggle .seg.active{background:rgba(52,166,147,.12); color:var(--ink); border:1px solid rgba(52,166,147,.28)}

    .testimonial{
      background:var(--surface); border:1px solid var(--border);
      border-radius:var(--radius); padding:1.25rem; height:100%; box-shadow:var(--shadow-1);
    }

    .cta{
      background:
        radial-gradient(900px 480px at 10% -10%, rgba(142,202,230,.25), transparent 60%),
        linear-gradient(135deg, var(--mint), #DDEEFF);
      padding:64px 0; border-top:1px solid var(--border); border-bottom:1px solid var(--border);
    }

    /* ===== Footer (unchanged, enhanced previously) ===== */
    .site-footer{
      background:var(--surface);
      border-top:1px solid var(--border);
      position:relative;
      overflow:hidden;
    }
    .site-footer::before{
      content:"";
      position:absolute; left:0; right:0; top:0; height:2px;
      background: linear-gradient(90deg, var(--mint), var(--peach));
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

    /* Small helper */
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

  <!-- ===== NAVBAR (sticky, animated underline, progress bar, offcanvas mobile) ===== -->
  <nav class="navbar navbar-expand-lg" id="siteNav" aria-label="Navigation principale">
    <div id="scrollProgress" aria-hidden="true"></div>
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="#" aria-label="QRivo accueil">
        <img src="{{ asset('assets/img/logo/accountLogo.png') }}" alt="QRivo" height="40">
        <strong>QRivo</strong>
      </a>

      <!-- Desktop links + animated indicator -->
      <div class="nav-group d-none d-lg-flex align-items-center ms-auto">
        <ul class="navbar-nav align-items-lg-center gap-1">
          <li class="nav-item"><a class="nav-link" href="#features">Fonctionnalités</a></li>
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
        <img src="{{ asset('assets/img/logo/accountLogo.png') }}" alt="QRivo" height="28">
        <strong id="offcanvasNavLabel">QRivo</strong>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
    </div>
    <div class="offcanvas-body">
      <div class="list-group list-group-flush">
        <a class="list-group-item" href="#features" data-close>Fonctionnalités</a>
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
          <h1 class="display-5 mb-3">Le <span class="spark">menu digital</span> qui convertit plus de clients</h1>
          <p class="lead text-muted mb-4">Mettez à jour photos et prix en temps réel, créez des QR personnalisés, traduisez en un clic et suivez vos performances.</p>
          <div class="d-flex flex-wrap gap-2">
            <a href="/register" class="btn btn-primary btn-lg">Démarrer l’essai</a>
            <a href="#showcase" class="btn btn-outline-primary btn-lg">Voir le produit</a>
          </div>
          <div class="d-flex gap-4 mt-4 flex-wrap text-muted small">
            <div><strong>14j</strong> d’essai • Sans CB</div>
            <div><i class="bi bi-shield-check"></i> Sauvegardes quotidiennes</div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="phone" aria-label="Aperçu du menu sur smartphone">
            <div class="screen">
              <img id="demoScreen" src="{{ asset('assets/img/saas/demo-1.jpg') }}" alt="Aperçu du menu" width="320" height="640" fetchpriority="high" decoding="async">
            </div>
          </div>
          <div class="text-center small text-muted mt-2">Aperçu dynamique (images défilantes)</div>
        </div>
      </div>

      <!-- Trust bar -->
      <div class="mt-5 pt-3">
        <div class="text-center text-muted mb-2">Utilisé par des cafés, restaurants et hôtels</div>
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
          <img src="{{ asset('assets/img/clients/cafe-atlas.jpg') }}" alt="Café Atlas" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
          <img src="{{ asset('assets/img/clients/pizzeria-napoli.jpg') }}" alt="Pizzeria Napoli" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
          <img src="{{ asset('assets/img/clients/hotel-oasis.jpg') }}" alt="Hotel Oasis" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
          <img src="{{ asset('assets/img/clients/bakery-mariem.jpg') }}" alt="Boulangerie Mariem" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
          <img src="{{ asset('assets/img/clients/restaurant-cedre.jpg') }}" alt="Restaurant Cèdre" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
          <img src="{{ asset('assets/img/clients/cafe-zen.jpg') }}" alt="Café Zen" style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff" loading="lazy">
        </div>
      </div>
    </div>
  </header>

  <!-- ===== METRICS ===== -->
  <section class="py-4" style="background:var(--surface)">
    <div class="container">
      <div class="row text-center g-4">
        <div class="col-6 col-md-3"><div class="h2 mb-1">+120</div><div class="text-muted small">établissements</div></div>
        <div class="col-6 col-md-3"><div class="h2 mb-1">&lt;1s</div><div class="text-muted small">chargement moyen</div></div>
        <div class="col-6 col-md-3"><div class="h2 mb-1">+18%</div><div class="text-muted small">ventes de desserts*</div></div>
        <div class="col-6 col-md-3"><div class="h2 mb-1">90%</div><div class="text-muted small">coûts d’impression en moins</div></div>
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
      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="feature">
            <div class="icon"><i class="bi bi-pencil-square"></i></div>
            <h6 class="fw-bold">Éditeur ultra simple</h6>
            <p class="small text-muted mb-0">Ajoutez plats, prix, photos, variations et allergènes en quelques clics.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="feature">
            <div class="icon"><i class="bi bi-qr-code"></i></div>
            <h6 class="fw-bold">QR personnalisés</h6>
            <p class="small text-muted mb-0">Logo, couleurs, formats table, sticker ou chevalet, export SVG/PNG.</p>
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
        <div class="col-md-12 col-lg-4">
          <div class="feature">
            <div class="icon"><i class="bi bi-bag-check"></i></div>
            <h6 class="fw-bold">Commande en salle (optionnel)</h6>
            <p class="small text-muted mb-0">Commande depuis la table avec ticket pour la caisse.</p>
          </div>
        </div>
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
              <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-editor" type="button" role="tab">Éditeur</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-qr" type="button" role="tab">QR Designer</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-analytics" type="button" role="tab">Analytics</button></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-editor" role="tabpanel">
                <img src="{{ asset('assets/img/saas/editor.png') }}" alt="Éditeur du menu" class="img-fluid rounded" loading="lazy">
              </div>
              <div class="tab-pane fade" id="tab-qr" role="tabpanel">
                <img src="{{ asset('assets/img/saas/qr-builder.png') }}" alt="Générateur de QR" class="img-fluid rounded" loading="lazy">
              </div>
              <div class="tab-pane fade" id="tab-analytics" role="tabpanel">
                <img src="{{ asset('assets/img/saas/analytics.png') }}" alt="Statistiques" class="img-fluid rounded" loading="lazy">
              </div>
            </div>
            <div class="small text-muted mt-2">Aperçus d’interface (exemples)</div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="showcase h-100">
            <h5 class="mb-2">Le parcours en 3 étapes</h5>
            <ol class="small text-muted mb-3">
              <li>Créez vos catégories et plats</li>
              <li>Personnalisez votre QR et imprimez</li>
              <li>Suivez les performances en temps réel</li>
            </ol>
            <img src="{{ asset('assets/img/saas/flow-owner.png') }}" class="img-fluid rounded border" alt="Flux restaurateur" loading="lazy">
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
        <h2 class="section-title">Tarification simple et flexible</h2>
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
            <div class="display-6 fw-extrabold my-2"><span class="price" data-monthly="0" data-yearly="0">0</span> DH</div>
            <p class="text-muted small">Parfait pour une petite carte</p>
            <ul class="list-unstyled small mb-4">
              <li><i class="bi bi-check2 text-success"></i> 10 plats</li>
              <li><i class="bi bi-check2 text-success"></i> QR noir & blanc</li>
              <li><i class="bi bi-check2 text-success"></i> Stats basiques</li>
              <li><i class="bi bi-x-lg text-danger"></i> Branding QRivo visible</li>
            </ul>
            <a href="/register" class="btn btn-outline-primary w-100">Commencer</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="price-card p-4 h-100 featured position-relative">
            <span class="price-badge position-absolute top-0 end-0 mt-3 me-3">Populaire</span>
            <h6 class="fw-bold">Starter</h6>
            <div class="display-6 fw-extrabold my-2">
              <span class="price" data-monthly="69" data-yearly="59">69</span> DH
              <span class="fs-6 fw-normal billing-label">/mois</span>
            </div>
            <p class="text-muted small">1 menu complet, items illimités</p>
            <ul class="list-unstyled small mb-4">
              <li><i class="bi bi-check2 text-success"></i> 1 menu (illimité)</li>
              <li><i class="bi bi-check2 text-success"></i> QR en couleurs</li>
              <li><i class="bi bi-check2 text-success"></i> Multilingue & devises</li>
              <li><i class="bi bi-check2 text-success"></i> Statistiques détaillées</li>
              <li><i class="bi bi-check2 text-success"></i> Sans branding QRivo</li>
            </ul>
            <a href="/register" class="btn btn-primary w-100">Essai gratuit 14 j</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="price-card p-4 h-100">
            <h6 class="fw-bold">Pro</h6>
            <div class="display-6 fw-extrabold my-2">
              <span class="price" data-monthly="149" data-yearly="127">149</span> DH
              <span class="fs-6 fw-normal billing-label">/mois</span>
            </div>
            <p class="text-muted small">Pour plusieurs menus et équipes</p>
            <ul class="list-unstyled small mb-4">
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
      <p class="text-center small text-muted mt-3">Réduction appliquée en annuel. *Exemple client typique, résultats variables.</p>
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
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fq1c">Comment fonctionne l’essai&nbsp;?</button>
          </h2>
          <div id="fq1c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body small">Essai de 14 jours sur Starter, sans carte bancaire. Sans action de votre part, vous passez en offre gratuite.</div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="fq2">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fq2c">Puis-je changer de formule&nbsp;?</button>
          </h2>
          <div id="fq2c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body small">Oui, à tout moment depuis le tableau de bord. Le prorata est calculé automatiquement.</div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="fq3">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fq3c">Dois-je réimprimer si je change un plat&nbsp;?</button>
          </h2>
          <div id="fq3c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body small">Non, le QR pointe vers un lien dynamique. Vos modifications sont instantanées côté client.</div>
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

  <!-- ===== FOOTER (kept as-is from last version) ===== -->
  <footer class="site-footer pt-5">
    <div class="container pb-4">
      <div class="row g-4">
        <!-- Brand + short -->
        <div class="col-lg-4">
          <div class="footer-card h-100">
            <div class="footer-brand mb-2">
              <img src="{{ asset('assets/img/logo/accountLogo.png') }}" alt="QRivo">
              <strong>QRivo</strong>
            </div>
            <p class="small text-muted mb-3">
              Le menu digital moderne pour restaurants, cafés et hôtels. QR personnalisés, multilingue, stats en temps réel.
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
          &copy; 2025 QRivo Inc. Tous droits réservés.
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
      <i class="bi bi-qr-code-scan"></i>
      <span class="small">Essayez QRivo gratuitement</span>
    </div>
    <a href="/register" class="btn btn-primary btn-sm">Créer mon compte</a>
  </div>

  <!-- ========= SCRIPTS ========= -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    // Phone demo carousel (simple & reliable)
    const demo = document.getElementById('demoScreen');
    const shots = [
      "{{ asset('assets/img/saas/demo-1.jpg') }}",
      "{{ asset('assets/img/saas/demo-2.jpg') }}",
      "{{ asset('assets/img/saas/demo-3.jpg') }}"
    ];
    let idx = 0;
    setInterval(() => {
      idx = (idx + 1) % shots.length;
      if (demo) demo.src = shots[idx];
    }, 3200);

    // Pricing toggle (monthly / yearly)
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

    // Navbar: shadow + shrink on scroll, scroll progress, active link + animated indicator
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

      // Which section is active?
      let idx = -1;
      const fromTop = window.scrollY + 120; // a bit below sticky nav
      sections.forEach((sec, i) => { if (sec.offsetTop <= fromTop) idx = i; });
      linkNodes.forEach(l => l.classList.remove('active'));
      const active = idx >= 0 ? linkNodes[idx] : null;
      active?.classList.add('active');
      moveIndicator(active);
    }

    // Hover: preview indicator under hovered link (desktop)
    linkNodes.forEach(l => {
      l.addEventListener('mouseenter', () => moveIndicator(l));
      l.addEventListener('mouseleave', () => {
        const current = document.querySelector('.navbar .nav-link.active');
        moveIndicator(current);
      });
      l.addEventListener('click', () => {
        // Smooth indicator update on click
        setTimeout(() => moveIndicator(l), 50);
      });
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

    // Footer: newsletter UX (no backend)
    const form = document.getElementById('newsletterForm');
    const msg  = document.getElementById('newsletterMsg');
    form?.addEventListener('submit', (e) => {
      e.preventDefault();
      msg.textContent = 'Merci ! Vous recevrez bientôt nos conseils.';
      msg.className = 'small mt-2 text-success';
      form.reset();
      setTimeout(() => { msg.textContent = ''; msg.className = 'small mt-2'; }, 4000);
    });

    // Footer: back to top button
    document.getElementById('toTopBtn')?.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({top:0, behavior:'smooth'});
    });
  </script>
</body>
</html>
