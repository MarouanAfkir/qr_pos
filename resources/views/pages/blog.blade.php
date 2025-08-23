<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <!-- ========= META ========= -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="QRevo Blog — Guides, études de cas et bonnes pratiques pour les restaurants : menu digital, QR, commande à table, POS et croissance." />
  <meta name="theme-color" content="#FF8A3D" />
  <title>QRevo — Blog</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

  <!-- ========= FONTS & CSS ========= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    /* ============================================================
       Soft orange palette + calm, creamy UI (same theme)
    ============================================================ */
    :root{
      --brand:#FF8A3D;--brand-600:#F56A1E;--brand-700:#E85C0D;
      --peach:#FFE9D1;--apricot:#FFF1E6;--bg:#FFF8F2;
      --ink:#1f2937;--muted:#667085;--surface:#ffffff;--surface-2:#FFF6EE;
      --border:#F2E7DC;--ring:rgba(255,138,61,.25);
      --success:#16a34a;--danger:#ef4444;
      --radius:18px;--shadow-1:0 6px 20px rgba(2,6,23,.06);--shadow-2:0 16px 40px rgba(2,6,23,.10);
    }
    html{scroll-behavior:smooth}
    body{
      font-family:'Manrope',system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
      color:var(--ink);
      background:
        radial-gradient(900px 480px at 80% -10%, rgba(255,138,61,.10), transparent 60%),
        var(--bg);
      overflow-x:hidden;
    }
    h1,h2,h3,h4,h5,h6{font-family:'Inter',sans-serif;letter-spacing:-.015em;font-weight:800}
    .text-muted{color:var(--muted)!important}

    /* ===== NAVBAR ===== */
    .navbar{position:sticky;top:0;z-index:1040;background:rgba(255,255,255,.86);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-bottom:1px solid var(--border);transition:box-shadow .25s ease,padding .2s ease,background .25s ease;padding:.7rem 0;}
    .navbar::after{content:"";position:absolute;left:0;right:0;bottom:-1px;height:2px;background:linear-gradient(90deg,var(--peach),var(--apricot));opacity:.55;pointer-events:none;}
    .navbar.scrolled{background:#fff;box-shadow:0 10px 28px rgba(0,0,0,.06);padding:.45rem 0;}
    #scrollProgress{position:absolute;top:0;left:0;height:3px;width:0%;background:linear-gradient(90deg,var(--brand),#FFC078);border-bottom-right-radius:3px;border-top-right-radius:3px;transition:width .15s ease;}
    .navbar .nav-link{font-weight:600;padding:.45rem .8rem;border-radius:999px;color:var(--ink)}
    .navbar .nav-link:hover,.navbar .nav-link:focus{background:rgba(255,138,61,.10);color:var(--ink)}
    .navbar .nav-link:focus-visible{outline:0;box-shadow:0 0 0 4px var(--ring)}
    .nav-group{position:relative}
    .nav-indicator{position:absolute;height:2px;bottom:-6px;left:0;width:0;background:linear-gradient(90deg,var(--brand),#FFC078);border-radius:2px;opacity:0;transition:transform .25s ease,width .25s ease,opacity .2s ease;pointer-events:none;}

    .btn-primary{--bs-btn-bg:var(--brand);--bs-btn-border-color:var(--brand);--bs-btn-hover-bg:var(--brand-600);--bs-btn-hover-border-color:var(--brand-600);box-shadow:0 10px 20px rgba(255,138,61,.22);border-radius:12px;font-weight:700;}
    .btn-outline-primary{--bs-btn-color:var(--brand);--bs-btn-border-color:var(--brand);--bs-btn-hover-color:#fff;--bs-btn-hover-bg:var(--brand);--bs-btn-hover-border-color:var(--brand);border-radius:12px;font-weight:700;background:transparent;}
    .badge-soft{background:#fff;color:var(--brand);border:1px solid var(--border);border-radius:999px;padding:.4rem .7rem;font-weight:700;box-shadow:0 6px 16px rgba(0,0,0,.06);}

    /* ===== BLOG HERO ===== */
    .blog-hero{
      padding:64px 0 40px;
      background:linear-gradient(135deg,var(--peach) 0%, var(--apricot) 100%);
      border-bottom:1px solid var(--border);
    }
    .blog-hero h1 .spark{background:linear-gradient(90deg,var(--brand) 0%, #FFC078 100%);-webkit-background-clip:text;background-clip:text;color:transparent;}

    /* ===== FILTER BAR ===== */
    .filter-bar{
      background:var(--surface);
      border:1px solid var(--border);
      border-radius:14px;
      padding:.75rem;
      box-shadow:var(--shadow-1);
    }
    .chip{
      display:inline-flex;align-items:center;gap:.4rem;
      padding:.35rem .75rem;border-radius:999px;font-weight:700;
      border:1px solid var(--border);background:#fff;color:var(--ink);
      cursor:pointer;user-select:none;
    }
    .chip.active{background:rgba(255,138,61,.12);border-color:rgba(255,138,61,.35)}
    .chip .bi{font-size:1rem}

    /* ===== ARTICLE CARDS ===== */
    .blog-card{
      background:var(--surface);
      border:1px solid var(--border);
      border-radius:var(--radius);
      box-shadow:var(--shadow-1);
      height:100%;overflow:hidden;
      transition:transform .18s ease, box-shadow .18s ease;
    }
    .blog-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-2)}
    .blog-card .thumb{
      position:relative;height:200px;overflow:hidden;background:var(--surface-2);
    }
    .blog-card .thumb img{width:100%;height:100%;object-fit:cover}
    .blog-card .meta{
      display:flex;flex-wrap:wrap;gap:.6rem 1rem;color:var(--muted);font-size:.85rem
    }
    .blog-card .title{font-weight:800;letter-spacing:-.01em}
    .badge-topic{
      background:rgba(255,138,61,.12);
      border:1px solid rgba(255,138,61,.35);
      color:var(--ink);font-weight:700;border-radius:999px;padding:.15rem .55rem;font-size:.75rem
    }

    /* ===== FEATURED ===== */
    .featured{
      position:relative;border-radius:20px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-2);
    }
    .featured .cover{height:100%;min-height:360px;object-fit:cover;width:100%}
    .featured .overlay{
      position:absolute;inset:0;background:linear-gradient(to top, rgba(0,0,0,.55), rgba(0,0,0,.15) 60%, rgba(0,0,0,0));
    }
    .featured .content{
      position:absolute;left:0;right:0;bottom:0;color:#fff;padding:1.25rem 1.25rem 1.5rem;
    }

    /* ===== SIDEBAR ===== */
    .side-card{
      background:var(--surface);
      border:1px solid var(--border);
      border-radius:14px;padding:1rem;box-shadow:var(--shadow-1)
    }
    .side-list a{display:flex;gap:.6rem;padding:.45rem 0;color:var(--ink);text-decoration:none;border-bottom:1px dashed var(--border)}
    .side-list a:last-child{border-bottom:0}
    .side-list small{color:var(--muted)}

    /* ===== FOOTER MISC ===== */
    .site-footer{background:var(--surface);border-top:1px solid var(--border);position:relative;overflow:hidden;}
    .site-footer::before{content:"";position:absolute;left:0;right:0;top:0;height:2px;background:linear-gradient(90deg,var(--apricot),var(--peach));opacity:.6}

    /* Small helpers */
    .kicker{font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#fff;background:rgba(0,0,0,.25);padding:.25rem .6rem;border-radius:999px;backdrop-filter:blur(3px)}
  </style>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-expand-lg" id="siteNav" aria-label="Navigation principale">
    <div id="scrollProgress" aria-hidden="true"></div>
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="/" aria-label="QRevo accueil">
        <img src="{{ asset('assets/img/saas/qrevo_under.png') }}" alt="QRevo" height="52">
      </a>

      <div class="nav-group d-none d-lg-flex align-items-center ms-auto">
        <ul class="navbar-nav align-items-lg-center gap-1">
          <li class="nav-item"><a class="nav-link" href="/#features">Fonctionnalités</a></li>
          <li class="nav-item"><a class="nav-link" href="/#compare">Comparaison</a></li>
          <li class="nav-item"><a class="nav-link" href="/#showcase">Produit</a></li>
          <li class="nav-item"><a class="nav-link" href="/#pricing">Tarifs</a></li>
          <li class="nav-item"><a class="nav-link" href="/#faq">FAQ</a></li>
          <li class="nav-item"><a class="nav-link active" href="/blog">Blog</a></li>
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
    <div class="offcanvas-header" style="background:linear-gradient(90deg, var(--apricot), var(--peach));border-bottom:1px solid var(--border)">
      <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('assets/img/saas/logo_with_words.png') }}" alt="QRevo" height="28">
        <strong id="offcanvasNavLabel">QRevo</strong>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
    </div>
    <div class="offcanvas-body">
      <div class="list-group list-group-flush">
        <a class="list-group-item" href="/#features" data-close>Fonctionnalités</a>
        <a class="list-group-item" href="/#compare" data-close>Comparaison</a>
        <a class="list-group-item" href="/#showcase" data-close>Produit</a>
        <a class="list-group-item" href="/#pricing" data-close>Tarifs</a>
        <a class="list-group-item" href="/#faq" data-close>FAQ</a>
        <a class="list-group-item" href="/blog" data-close>Blog</a>
      </div>
      <div class="d-grid gap-2 mt-3">
        <a href="/login" class="btn btn-outline-primary">Se connecter</a>
        <a href="/register" class="btn btn-primary">Essai gratuit</a>
      </div>
    </div>
  </div>

  <!-- ===== BLOG HERO ===== -->
  <header class="blog-hero">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-7">
          <span class="badge-soft d-inline-flex align-items-center gap-2 mb-3"><i class="bi bi-journal-text"></i> Nouvelles ressources chaque semaine</span>
          <h1 class="display-5 mb-2">Le <span class="spark">Blog</span> QRevo</h1>
          <p class="lead text-muted">Guides, études de cas et conseils pratiques pour booster votre restaurant avec le menu digital, la commande à table et le POS.</p>
          <div class="filter-bar mt-3">
            <div class="row g-2 align-items-center">
              <div class="col-12 col-md-6">
                <div class="input-group">
                  <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                  <input id="searchInput" type="search" class="form-control border-0" placeholder="Rechercher un article (ex: QR, photos, commande à table)…" />
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex flex-wrap gap-2 justify-content-md-end">
                <span class="chip active" data-tag="all"><i class="bi bi-stars"></i> Tous</span>
                <span class="chip" data-tag="guide"><i class="bi bi-map"></i> Guides</span>
                <span class="chip" data-tag="comparatif"><i class="bi bi-bar-chart"></i> Comparatifs</span>
                <span class="chip" data-tag="cas"><i class="bi bi-graph-up"></i> Études de cas</span>
                <span class="chip" data-tag="commande"><i class="bi bi-bag-check"></i> Commande à table</span>
              </div>
            </div>
          </div>
          <div class="small text-muted mt-2" id="resultsCount" aria-live="polite">5 articles</div>
        </div>
        <div class="col-lg-5">
          <div class="featured">
            <img class="cover" src="{{ asset('assets/img/blog/blog-featured.jpg') }}" alt="Guide du menu digital 2025">
            <div class="overlay"></div>
            <div class="content">
              <div class="d-flex align-items-center gap-2 mb-2">
                <span class="kicker">Article Pilier</span>
                <span class="badge-topic">Guide</span>
              </div>
              <h3 class="h4 mb-2">Menu QR pour restaurants au Maroc : le guide 2025</h3>
              <div class="meta">
                <span><i class="bi bi-calendar"></i> 12 févr. 2025</span>
                <span><i class="bi bi-clock"></i> 12 min</span>
              </div>
              <div class="mt-2">
                <a href="/blog/menu-qr-guide-2025" class="btn btn-light btn-sm fw-bold">Lire l’article</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- ===== BLOG LIST ===== -->
  <main class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="row g-4" id="articlesGrid">
            <!-- Card 1 -->
            <div class="col-md-6 blog-item" data-tags="guide,qr,menu" data-date="2025-02-12" data-min="12">
              <article class="blog-card h-100">
                <div class="thumb">
                  <img src="{{ asset('assets/img/blog/blog-1.jpg') }}" alt="Menu QR pour restaurants au Maroc : le guide 2025">
                </div>
                <div class="p-3 p-md-4">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge-topic">Guide</span>
                    <span class="meta"><span><i class="bi bi-calendar"></i> 12 févr. 2025</span> <span><i class="bi bi-clock"></i> 12 min</span></span>
                  </div>
                  <h3 class="h5 title mb-2"><a class="stretched-link text-decoration-none text-dark" href="/blog/menu-qr-guide-2025">Menu QR pour restaurants au Maroc : le guide 2025</a></h3>
                  <p class="small text-muted mb-0">Déploiement en 1 jour, QR dynamique vs statique, bonnes pratiques bilingues FR/AR, check-list téléchargeable.</p>
                </div>
              </article>
            </div>
            <!-- Card 2 -->
            <div class="col-md-6 blog-item" data-tags="guide,photo" data-date="2025-02-05" data-min="8">
              <article class="blog-card h-100">
                <div class="thumb">
                  <img src="{{ asset('assets/img/blog/blog-2.jpg') }}" alt="Photographier ses plats au smartphone : 12 astuces">
                </div>
                <div class="p-3 p-md-4">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge-topic">Guide</span>
                    <span class="meta"><span><i class="bi bi-calendar"></i> 5 févr. 2025</span> <span><i class="bi bi-clock"></i> 8 min</span></span>
                  </div>
                  <h3 class="h5 title mb-2"><a class="stretched-link text-decoration-none text-dark" href="/blog/photos-plat-smartphone">Photographier ses plats au smartphone : 12 astuces</a></h3>
                  <p class="small text-muted mb-0">Lumière naturelle, angles efficaces, réglages rapides et retouche express pour des photos qui vendent.</p>
                </div>
              </article>
            </div>
            <!-- Card 3 -->
            <div class="col-md-6 blog-item" data-tags="comparatif,qr,menu" data-date="2025-01-28" data-min="10">
              <article class="blog-card h-100">
                <div class="thumb">
                  <img src="{{ asset('assets/img/blog/blog-3.jpg') }}" alt="Menu papier vs PDF vs digital interactif : comparaison honnête">
                </div>
                <div class="p-3 p-md-4">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge-topic">Comparatif</span>
                    <span class="meta"><span><i class="bi bi-calendar"></i> 28 janv. 2025</span> <span><i class="bi bi-clock"></i> 10 min</span></span>
                  </div>
                  <h3 class="h5 title mb-2"><a class="stretched-link text-decoration-none text-dark" href="/blog/pdf-vs-menu-digital">Menu papier vs PDF vs digital interactif : comparaison honnête</a></h3>
                  <p class="small text-muted mb-0">Coûts, expérience, données et SEO local&nbsp;: le point clair pour choisir le bon format.</p>
                </div>
              </article>
            </div>
            <!-- Card 4 -->
            <div class="col-md-6 blog-item" data-tags="commande,guide" data-date="2025-01-20" data-min="9">
              <article class="blog-card h-100">
                <div class="thumb">
                  <img src="{{ asset('assets/img/saas/blog/1.png') }}" alt="Commande à table : set-up, impression cuisine & flux caisse">
                </div>
                <div class="p-3 p-md-4">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge-topic">Commande à table</span>
                    <span class="meta"><span><i class="bi bi-calendar"></i> 20 janv. 2025</span> <span><i class="bi bi-clock"></i> 9 min</span></span>
                  </div>
                  <h3 class="h5 title mb-2"><a class="stretched-link text-decoration-none text-dark" href="/blog/commande-a-table-setup">Commande à table : set-up, impression cuisine & flux caisse</a></h3>
                  <p class="small text-muted mb-0">De la table au ticket cuisine en quelques secondes, sans friction pour l’équipe.</p>
                </div>
              </article>
            </div>
            <!-- Card 5 -->
            <div class="col-md-6 blog-item" data-tags="cas,menu,analytics" data-date="2025-01-12" data-min="6">
              <article class="blog-card h-100">
                <div class="thumb">
                  <img src="{{ asset('assets/img/blog/blog-5.jpg') }}" alt="Étude de cas : +18% de ventes de desserts en 30 jours">
                </div>
                <div class="p-3 p-md-4">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge-topic">Étude de cas</span>
                    <span class="meta"><span><i class="bi bi-calendar"></i> 12 janv. 2025</span> <span><i class="bi bi-clock"></i> 6 min</span></span>
                  </div>
                  <h3 class="h5 title mb-2"><a class="stretched-link text-decoration-none text-dark" href="/blog/etude-desserts-18">Étude de cas : +18% de ventes de desserts en 30 jours</a></h3>
                  <p class="small text-muted mb-0">Les “reco chef” et la mise en avant photo qui ont fait la différence.</p>
                </div>
              </article>
            </div>
          </div>

          <!-- Pagination (placeholder) -->
          <nav class="mt-3" aria-label="Pagination des articles">
            <ul class="pagination mb-0">
              <li class="page-item disabled"><span class="page-link">Précédent</span></li>
              <li class="page-item active"><span class="page-link">1</span></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">Suivant</a></li>
            </ul>
          </nav>
        </div>

        <!-- Sidebar -->
        <aside class="col-lg-4">
          <div class="side-card mb-3">
            <h6 class="fw-bold mb-2">Populaires</h6>
            <div class="side-list">
              <a href="/blog/menu-qr-guide-2025"><i class="bi bi-chevron-right"></i> Menu QR : le guide 2025 <small>(12 min)</small></a>
              <a href="/blog/pdf-vs-menu-digital"><i class="bi bi-chevron-right"></i> Papier vs PDF vs Digital <small>(10 min)</small></a>
              <a href="/blog/commande-a-table-setup"><i class="bi bi-chevron-right"></i> Commande à table : set-up <small>(9 min)</small></a>
            </div>
          </div>

          <div class="side-card mb-3">
            <h6 class="fw-bold mb-2">Recevoir les nouveaux articles</h6>
            <p class="small text-muted">Des tutoriels pratiques et des modèles à télécharger, 1×/semaine. Pas de spam.</p>
            <form id="blogNewsletter" class="d-flex gap-2">
              <input type="email" required class="form-control" placeholder="Votre email">
              <button class="btn btn-primary" type="submit">S’inscrire</button>
            </form>
            <div id="blogNewsletterMsg" class="small mt-2" aria-live="polite"></div>
          </div>

          <div class="side-card">
            <h6 class="fw-bold mb-2">Téléchargements</h6>
            <a class="btn btn-outline-primary w-100 mb-2" href="/downloads/checklist-ouverture.pdf"><i class="bi bi-file-earmark-check"></i> Check-list d’ouverture (PDF)</a>
            <a class="btn btn-outline-primary w-100" href="/downloads/modele-menu-cafe.qrivo"><i class="bi bi-cloud-arrow-down"></i> Modèle de menu café</a>
          </div>
        </aside>
      </div>
    </div>
  </main>

  <!-- ===== CTA STRIP ===== -->
  <section class="cta text-center" style="background:
      radial-gradient(900px 480px at 10% -10%, rgba(255, 192, 120, .25), transparent 60%),
      linear-gradient(135deg, var(--apricot), #FFEBD8); padding:56px 0; border-top:1px solid var(--border); border-bottom:1px solid var(--border);">
    <div class="container">
      <h2 class="fw-bold mb-2">Passez au menu digital en quelques minutes</h2>
      <p class="mb-3">Essayez QRevo gratuitement pendant 14 jours.</p>
      <a href="/register" class="btn btn-primary btn-lg">Créer mon compte</a>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer class="site-footer pt-5">
    <div class="container pb-4">
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="footer-card h-100" style="background:var(--surface-2);border:1px solid var(--border);border-radius:14px;padding:1rem">
            <div class="d-flex align-items-center gap-2 mb-2">
              <img src="{{ asset('assets/img/saas/logo_with_words.png') }}" alt="QRevo" height="36">
              <strong>QRevo</strong>
            </div>
            <p class="small text-muted mb-3">Le menu digital moderne pour restaurants, cafés et hôtels. QR personnalisés, multilingue, stats en temps réel.</p>
            <div>
              <a href="https://instagram.com" aria-label="Instagram" class="me-1 btn btn-light btn-sm border"><i class="bi bi-instagram"></i></a>
              <a href="https://facebook.com" aria-label="Facebook" class="me-1 btn btn-light btn-sm border"><i class="bi bi-facebook"></i></a>
              <a href="https://wa.me/" aria-label="WhatsApp" class="btn btn-light btn-sm border"><i class="bi bi-whatsapp"></i></a>
            </div>
          </div>
        </div>

        <div class="col-6 col-lg-2">
          <h6 class="fw-bold mb-3">Produit</h6>
          <ul class="list-unstyled small m-0">
            <li class="mb-2"><a class="footer-link" href="/#features">Fonctionnalités</a></li>
            <li class="mb-2"><a class="footer-link" href="/#compare">Comparaison</a></li>
            <li class="mb-2"><a class="footer-link" href="/#showcase">Aperçu</a></li>
            <li class="mb-2"><a class="footer-link" href="/#pricing">Tarifs</a></li>
            <li class="mb-2"><a class="footer-link" href="/#faq">FAQ</a></li>
          </ul>
        </div>

        <div class="col-6 col-lg-3">
          <h6 class="fw-bold mb-3">Ressources</h6>
          <ul class="list-unstyled small m-0">
            <li class="mb-2"><a class="footer-link" href="/blog">Blog</a></li>
            <li class="mb-2"><a class="footer-link" href="/contact">Contact</a></li>
            <li class="mb-2"><a class="footer-link" href="/terms">CGU</a></li>
            <li class="mb-2"><a class="footer-link" href="/login">Se connecter</a></li>
            <li class="mb-2"><a class="footer-link" href="/register">Créer un compte</a></li>
          </ul>
        </div>

        <div class="col-lg-3">
          <h6 class="fw-bold mb-3">Newsletter</h6>
          <p class="small text-muted mb-2">Recevez nos guides et modèles (FR/AR) directement dans votre boîte.</p>
          <form id="newsletterForm" class="d-flex gap-2">
            <input type="email" required class="form-control" placeholder="Votre email">
            <button class="btn btn-primary" type="submit">S’inscrire</button>
          </form>
          <div id="newsletterMsg" class="small mt-2" aria-live="polite"></div>
        </div>
      </div>

      <hr class="my-4" style="border-color:var(--border)">

      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between pb-4">
        <p class="small text-muted mb-2 mb-md-0">&copy; 2025 QRevo Inc. Tous droits réservés.</p>
        <div class="d-flex align-items-center gap-3">
          <a href="#" class="btn btn-outline-primary btn-sm" id="toTopBtn" aria-label="Retour en haut">
            <i class="bi bi-arrow-up"></i> Haut de page
          </a>
        </div>
      </div>
    </div>
  </footer>

  <!-- ========= JSON-LD (SEO) ========= -->
  @verbatim
  <script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"Blog",
    "name":"QRevo Blog",
    "url":"https://example.com/blog",
    "blogPost":[
      {"@type":"BlogPosting","headline":"Menu QR pour restaurants au Maroc : le guide 2025","url":"https://example.com/blog/menu-qr-guide-2025","datePublished":"2025-02-12"},
      {"@type":"BlogPosting","headline":"Photographier ses plats au smartphone : 12 astuces","url":"https://example.com/blog/photos-plat-smartphone","datePublished":"2025-02-05"},
      {"@type":"BlogPosting","headline":"Menu papier vs PDF vs digital interactif : comparaison honnête","url":"https://example.com/blog/pdf-vs-menu-digital","datePublished":"2025-01-28"},
      {"@type":"BlogPosting","headline":"Commande à table : set-up, impression cuisine & flux caisse","url":"https://example.com/blog/commande-a-table-setup","datePublished":"2025-01-20"},
      {"@type":"BlogPosting","headline":"Étude de cas : +18% de ventes de desserts en 30 jours","url":"https://example.com/blog/etude-desserts-18","datePublished":"2025-01-12"}
    ]
  }
  </script>
  @endverbatim

  <!-- ========= SCRIPTS ========= -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    // Navbar behavior + progress + active link indicator
    const nav = document.getElementById('siteNav');
    const progress = document.getElementById('scrollProgress');
    const indicator = document.getElementById('navIndicator');
    const linkNodes = [...document.querySelectorAll('.navbar .nav-link')];

    function setProgress(){
      const st = document.documentElement.scrollTop || document.body.scrollTop;
      const h = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const pct = Math.max(0, Math.min(1, h ? st / h : 0));
      progress.style.width = (pct * 100).toFixed(2) + '%';
      if (window.scrollY > 8) nav?.classList.add('scrolled'); else nav?.classList.remove('scrolled');
    }
    function moveIndicator(el){
      const group = document.querySelector('.nav-group');
      if(!indicator || !group || !el){ if(indicator) indicator.style.opacity='0'; return; }
      const r = el.getBoundingClientRect(), gp = group.getBoundingClientRect();
      indicator.style.width = r.width + 'px';
      indicator.style.transform = `translateX(${r.left - gp.left}px)`;
      indicator.style.opacity = '1';
    }
    linkNodes.forEach(l=>{
      l.addEventListener('mouseenter',()=>moveIndicator(l));
      l.addEventListener('mouseleave',()=>moveIndicator(document.querySelector('.navbar .nav-link.active')));
      l.addEventListener('click',()=>setTimeout(()=>moveIndicator(l),50));
    });
    window.addEventListener('scroll', setProgress);
    window.addEventListener('resize', ()=>moveIndicator(document.querySelector('.navbar .nav-link.active')));
    window.addEventListener('load', ()=>{
      setProgress();
      moveIndicator(document.querySelector('.navbar .nav-link.active') || linkNodes[0] || null);
    });

    // Offcanvas: close when picking a link
    const offcanvasEl = document.getElementById('offcanvasNav');
    offcanvasEl?.querySelectorAll('[data-close]').forEach(a=>{
      a.addEventListener('click', ()=>{
        const oc = bootstrap.Offcanvas.getInstance(offcanvasEl);
        oc?.hide();
      });
    });

    // Newsletter UX (footer)
    const form = document.getElementById('newsletterForm');
    const msg = document.getElementById('newsletterMsg');
    form?.addEventListener('submit', (e)=>{
      e.preventDefault();
      msg.textContent = 'Merci ! Vous recevrez bientôt nos conseils.';
      msg.className = 'small mt-2 text-success';
      form.reset();
      setTimeout(()=>{ msg.textContent=''; msg.className='small mt-2'; }, 4000);
    });

    // Blog newsletter (sidebar)
    const blogForm = document.getElementById('blogNewsletter');
    const blogMsg = document.getElementById('blogNewsletterMsg');
    blogForm?.addEventListener('submit',(e)=>{
      e.preventDefault();
      blogMsg.textContent = 'Inscription confirmée. Bienvenue 👋';
      blogMsg.className = 'small mt-2 text-success';
      blogForm.reset();
      setTimeout(()=>{ blogMsg.textContent=''; blogMsg.className='small mt-2'; }, 4000);
    });

    // ===== BLOG FILTERS & SEARCH =====
    const chips = [...document.querySelectorAll('.chip')];
    const searchInput = document.getElementById('searchInput');
    const grid = document.getElementById('articlesGrid');
    const items = [...grid.querySelectorAll('.blog-item')];
    const resultsCount = document.getElementById('resultsCount');
    let activeTag = 'all';

    function applyFilters(){
      const q = (searchInput?.value || '').trim().toLowerCase();
      let visible = 0;
      items.forEach(card=>{
        const tags = (card.dataset.tags || '');
        const matchTag = activeTag==='all' || tags.includes(activeTag);
        const text = card.textContent.toLowerCase();
        const matchText = !q || text.includes(q);
        const show = matchTag && matchText;
        card.style.display = show ? '' : 'none';
        if(show) visible++;
      });
      resultsCount.textContent = `${visible} article${visible>1?'s':''}`;
    }

    chips.forEach(c=>{
      c.addEventListener('click', ()=>{
        chips.forEach(x=>x.classList.remove('active'));
        c.classList.add('active');
        activeTag = c.dataset.tag || 'all';
        applyFilters();
      });
    });
    searchInput?.addEventListener('input', applyFilters);
    applyFilters();

    // Back to top
    document.getElementById('toTopBtn')?.addEventListener('click',(e)=>{
      e.preventDefault(); window.scrollTo({top:0, behavior:'smooth'});
    });
  </script>
</body>
</html>
