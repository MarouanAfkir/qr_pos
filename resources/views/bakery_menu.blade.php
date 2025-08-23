<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">
<head>
  <!-- ===== META ===== -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Crustella Menu — coffee, pastries, breakfast, and seasonal specials. Filter by category or dietary preferences and order in a tap." />
  <meta name="theme-color" content="#C46E3A" />
  <title>Menu — Crustella Café & Bakery</title>
  <link rel="icon" href="assets/img/favicon.png" />

  <!-- Early theme init -->
  <script>
    (function () {
      try {
        var saved = localStorage.getItem('theme');
        if (saved) document.documentElement.setAttribute('data-bs-theme', saved);
      } catch (e) {}
    })();
  </script>

  <!-- ===== FONTS & CSS ===== -->
  <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

  <style>
    /* ============================================================
       Warm café palette + creamy UI (matches your site)
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
    html { scroll-behavior: smooth }
    body {
      font-family: 'Manrope', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      color: var(--cocoa);
      background: radial-gradient(900px 480px at 80% -10%, rgba(196,110,58,.08), transparent 60%), var(--bg);
      overflow-x: hidden;
    }
    h1,h2,h3,h4,h5,h6 { font-family: 'Inter', sans-serif; letter-spacing: -.015em; font-weight: 800 }
    .text-muted { color: var(--muted) !important }
    section { scroll-margin-top: 96px }

    /* Skeleton shimmer */
    .skel { position: relative; overflow: hidden; border-radius: 14px; background: #eee }
    [data-bs-theme="dark"] .skel { background: #1a1f26 }
    .skel::before {
      content: ""; position: absolute; inset: 0;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,.25), transparent);
      animation: shimmer 1.35s linear infinite;
    }
    .skel.loaded::before { opacity: 0; visibility: hidden }
    @keyframes shimmer { 0%{ transform: translateX(-100%)} 100%{transform: translateX(100%)} }

    /* Buttons */
    .btn-primary{
      --bs-btn-bg: var(--accent); --bs-btn-border-color: var(--accent);
      --bs-btn-hover-bg: var(--accent-600); --bs-btn-hover-border-color: var(--accent-600);
      border-radius: 12px; font-weight: 700; box-shadow: 0 10px 20px rgba(196,110,58,.22)
    }
    .btn-outline-primary{
      --bs-btn-color: var(--accent); --bs-btn-border-color: var(--accent);
      --bs-btn-hover-color: #fff; --bs-btn-hover-bg: var(--accent); --bs-btn-hover-border-color: var(--accent);
      border-radius: 12px; font-weight: 700
    }
    .btn-light{ border-radius: 12px; font-weight: 700 }

    /* Utility bar & Navbar (from your site) */
    .nav-utility{ border-bottom:1px solid var(--border); background:linear-gradient(90deg,#FFF1E6,#FFEADB) }
    [data-bs-theme="dark"] .nav-utility{ background:linear-gradient(90deg,#171c22,#12171e) }
    .nav-utility .link-utility{ color:var(--cocoa); text-decoration:none }
    .nav-utility .link-utility:hover{ text-decoration:underline }

    .nav-elevated{
      position: sticky; top:0; z-index:1040; background: rgba(255,255,255,.86);
      backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
      border-bottom:1px solid var(--border); transition: background .25s ease, box-shadow .25s ease, padding .2s ease; padding:.7rem 0;
    }
    [data-bs-theme="dark"] .nav-elevated{ background: rgba(16,19,24,.85) }
    .nav-elevated.scrolled{ background: var(--surface); box-shadow: 0 10px 28px rgba(0,0,0,.06); padding:.45rem 0; }
    #scrollProgress{ position:absolute; top:0; left:0; height:3px; width:0%; background:linear-gradient(90deg,var(--accent),#FFB680); border-bottom-right-radius:3px; border-top-right-radius:3px; transition:width .15s ease }
    .navbar .nav-link{ font-weight:600; padding:.45rem .8rem; border-radius:999px; color:var(--cocoa) }
    .navbar .nav-link:hover,.navbar .nav-link:focus{ background: rgba(196,110,58,.10) }
    .navbar .nav-link:focus-visible{ outline:0; box-shadow:0 0 0 4px var(--ring) }

    /* Search under nav */
    .nav-search{ border-top:1px solid var(--border); background: rgba(255,255,255,.86); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px) }
    [data-bs-theme="dark"] .nav-search{ background: rgba(16,19,24,.85) }
    .nav-search-form{ display:flex; align-items:center; gap:.6rem; padding:.75rem 0 }
    .nav-search-input{ border-radius:12px; border:1px solid var(--border) }

    /* ============================================================
       Page Hero (Menu)
    ============================================================ */
    .page-hero {
      position: relative;
      border-bottom: 1px solid var(--border);
      background:
        radial-gradient(60rem 35rem at 85% -5%, rgba(196,110,58,.12), transparent 60%),
        linear-gradient(120deg, rgba(255, 250, 245, .85), rgba(255, 250, 245, .55) 38%, rgba(255, 250, 245, .15));
    }
    [data-bs-theme="dark"] .page-hero{
      background:
        radial-gradient(60rem 35rem at 85% -5%, rgba(196,110,58,.12), transparent 60%),
        linear-gradient(120deg, rgba(14,17,20,.86), rgba(14,17,20,.6));
    }
    .page-hero .container{ padding-top: clamp(36px, 6vh, 72px); padding-bottom: clamp(22px, 4vh, 56px); }
    .page-hero h1{ font-size: clamp(2rem, 4.3vw, 3rem); margin: 0 0 .25rem }
    .page-hero p{ margin:0 }

    /* ============================================================
       Filters bar
    ============================================================ */
    .filters-wrap{
      position: sticky; top: 64px; z-index: 1030;
      background: var(--surface); border-bottom: 1px solid var(--border);
    }
    @media (max-width: 991.98px){ .filters-wrap{ top:56px } }

    .cat-tabs{
      display:flex; gap:.5rem; overflow:auto; padding:.5rem .25rem; scroll-snap-type:x mandatory;
      mask-image: linear-gradient(90deg, transparent, #000 12px, #000 calc(100% - 12px), transparent);
    }
    .cat-tabs .btn{
      scroll-snap-align:center; white-space:nowrap; border-radius:999px; font-weight:700;
    }
    .diet-chips{
      display:flex; flex-wrap:wrap; gap:.5rem;
    }
    .diet-chips .chip{
      display:inline-flex; align-items:center; gap:.4rem; border:1px solid var(--border);
      border-radius:999px; padding:.35rem .6rem; background:var(--surface-2); font-weight:600; cursor:pointer;
    }
    .diet-chips .chip[aria-pressed="true"]{
      background: rgba(196,110,58,.12); border-color: var(--accent); box-shadow: inset 0 0 0 2px rgba(196,110,58,.08);
    }

    .toolbar{
      display:flex; align-items:center; gap:.6rem; flex-wrap:wrap;
    }
    .toolbar .form-select, .toolbar .form-control{ border-radius:12px; border:1px solid var(--border) }

    /* ============================================================
       Menu grid & cards (overflow-proof)
    ============================================================ */
    .menu-grid .card-soft{
      display:flex; flex-direction:column; height:100%; border:1px solid var(--border);
      background: var(--surface); border-radius:16px; overflow:hidden; box-shadow: var(--shadow-1);
    }
    .ratio img{ object-fit: cover; display:block; width:100%; height:100% }
    .card-body-tight{ padding:.75rem .9rem }
    .price-badge{
      display:inline-flex; align-items:center; gap:.25rem; font-weight:700;
      border:1px solid var(--border); border-radius:999px; padding:.2rem .5rem; background:var(--surface-2);
    }
    .diet-icons{ display:flex; gap:.35rem; align-items:center; flex-wrap:wrap }
    .diet-icons .ico{
      display:inline-flex; align-items:center; justify-content:center; width:22px; height:22px; border-radius:6px;
      border:1px solid var(--border); background:var(--surface-2); font-size:.85rem; line-height:1;
    }
    .card-soft .btn-add{ margin-top:auto }

    /* Prevent flex children from overflowing in Bootstrap rows */
    .row > [class*="col"]{ min-width:0 }

    /* Hover */
    .menu-grid .card-soft .img-wrap{ transition: transform .25s ease }
    .menu-grid .card-soft:hover .img-wrap{ transform: scale(1.02) }

    /* Empty state */
    .empty-state{
      border:1px dashed var(--border); border-radius:16px; padding:1rem; background:var(--surface-2);
    }

    /* Footer & misc */
    .press{ background: var(--surface-2); border-top:1px solid var(--border); border-bottom:1px solid var(--border) }
    .press img{ height:44px; border-radius:10px; border:1px solid var(--border); box-shadow:0 .35rem .9rem rgba(0,0,0,.06); background:#fff; object-fit:cover }

    /* Mobile sticky action */
    .mobile-cta{
      position: fixed; left:0; right:0; bottom:0; z-index:1050; display:none;
      gap:.7rem; align-items:center; justify-content:space-between; padding:.7rem .9rem;
      background: var(--surface); border-top:1px solid var(--border); box-shadow: 0 -8px 24px rgba(0,0,0,.08)
    }
    @media (max-width: 991.98px){ .mobile-cta{ display:flex } }
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
      <a class="navbar-brand d-flex align-items-center gap-2" href="/">
        <img src="{{ asset('assets/img/gallery/logo.png') }}" alt="Crustella" height="40" width="40" style="border-radius:10px; object-fit:cover">
        <strong>Crustella</strong>
      </a>

      <div class="d-none d-lg-flex align-items-center ms-auto">
        <ul class="navbar-nav align-items-lg-center gap-1">
          <li class="nav-item"><a class="nav-link" href="/menu">Menu</a></li>
          <li class="nav-item"><a class="nav-link" href="/order">Order</a></li>
          <li class="nav-item"><a class="nav-link" href="/workshops">Workshops</a></li>
          <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
          <li class="nav-item"><a class="nav-link" href="/contact">Visit</a></li>
          <li class="nav-item">
            <button class="btn btn-outline-primary" id="searchBtn" aria-expanded="false" aria-controls="navSearchWrap" aria-label="Open search">
              <i class="bi bi-search"></i>
            </button>
          </li>
          <li class="nav-item">
            <button id="themeBtn" class="btn btn-outline-primary" aria-label="Toggle dark mode"><i class="bi bi-moon-stars"></i></button>
          </li>
          <li class="nav-item ms-1">
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas">
              <i class="bi bi-bag"></i> Cart <span class="badge text-bg-light ms-1" id="cartCount">0</span>
            </button>
          </li>
        </ul>
      </div>

      <!-- Mobile toggler -->
      <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-label="Open menu">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <!-- Expandable Search -->
    <div id="navSearchWrap" class="nav-search collapse">
      <div class="container">
        <form class="nav-search-form" role="search" aria-label="Site search" onsubmit="event.preventDefault();document.getElementById('searchClose').click();">
          <i class="bi bi-search"></i>
          <input class="form-control nav-search-input" type="search" placeholder="Search menu, pastries, coffee…" aria-label="Search site">
          <button class="btn btn-light" type="button" id="searchClose" aria-label="Close search"><i class="bi bi-x-lg"></i></button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Offcanvas mobile menu -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel" style="background:var(--surface); border-left:1px solid var(--border)">
    <div class="offcanvas-header" style="border-bottom:1px solid var(--border); background:linear-gradient(90deg,#FFF1E6,#FFE2CC)">
      <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('assets/img/gallery/logo.png') }}" alt="Crustella" height="28" width="28" style="border-radius:6px; object-fit:cover">
        <strong id="offcanvasNavLabel">Crustella</strong>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="d-grid gap-2 mb-3">
        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas"><i class="bi bi-bag"></i> View cart</button>
        <a href="/order" class="btn btn-outline-primary" data-close><i class="bi bi-cash-coin"></i> Order ahead</a>
      </div>
      <div class="list-group list-group-flush">
        <a class="list-group-item" href="/menu" data-close>Menu</a>
        <a class="list-group-item" href="/workshops" data-close>Workshops</a>
        <a class="list-group-item" href="/blog" data-close>Blog</a>
        <a class="list-group-item" href="/contact" data-close>Visit us</a>
      </div>
      <div class="border-top mt-3 pt-3" style="border-color:var(--border)!important;">
        <div class="d-flex gap-2">
          <button id="themeBtnMobile" class="btn btn-light w-100" type="button"><i class="bi bi-moon-stars"></i> Theme</button>
          <button class="btn btn-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#navSearchWrap"><i class="bi bi-search"></i> Search</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== PAGE HERO ===== -->
  <header class="page-hero">
    <div class="container">
      <div class="row g-4 align-items-end">
        <div class="col-lg-8">
          <h1>Our <span style="background:linear-gradient(90deg,var(--accent),#FFB680);-webkit-background-clip:text;background-clip:text;color:transparent">Menu</span></h1>
          <p class="text-muted">Freshly baked, carefully brewed. Filter by category or dietary preference and add to cart.</p>
        </div>
        <div class="col-lg-4">
          <form class="d-flex gap-2" id="menuSearchForm" role="search" aria-label="Search menu" onsubmit="event.preventDefault();">
            <input id="menuSearch" class="form-control" placeholder="Search: croissant, latte…" aria-label="Search menu items">
            <button class="btn btn-outline-primary" type="button" id="clearSearch"><i class="bi bi-x-lg"></i></button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- ===== FILTERS ===== -->
  <div class="filters-wrap" aria-label="Menu filters">
    <div class="container py-2">
      <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-2">
        <!-- Categories -->
        <div class="cat-tabs" id="catTabs" role="tablist" aria-label="Categories">
          <!-- populated by JS -->
        </div>
        <!-- Toolbar -->
        <div class="toolbar">
          <div class="diet-chips" id="dietChips" aria-label="Dietary filters">
            <!-- chips populated by JS -->
          </div>
          <select class="form-select form-select-sm" style="min-width: 180px" id="sortSel" aria-label="Sort menu">
            <option value="popular">Sort: Popular</option>
            <option value="price_asc">Price: Low → High</option>
            <option value="price_desc">Price: High → Low</option>
            <option value="name_asc">Name: A → Z</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== MENU GRID ===== -->
  <main class="py-4">
    <div class="container">
      <div id="resultsCount" class="small text-muted mb-2" aria-live="polite"></div>

      <div class="row g-3 menu-grid" id="menuGrid">
        <!-- cards injected by JS -->
      </div>

      <div id="emptyState" class="empty-state mt-3 d-none">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-emoji-frown"></i>
          <strong>No items match your filters.</strong>
        </div>
        <div class="small text-muted mt-1">Try clearing dietary chips or resetting the search.</div>
      </div>

      <!-- Diet legend -->
      <div class="card-soft p-3 mt-4" style="border:1px solid var(--border); border-radius:16px;">
        <div class="d-flex align-items-center gap-3 flex-wrap">
          <div class="fw-bold">Dietary legend</div>
          <div class="diet-icons">
            <span class="ico" title="Gluten-free">GF</span> <span class="small text-muted">Gluten-free</span>
          </div>
          <div class="diet-icons">
            <span class="ico" title="Dairy-free">DF</span> <span class="small text-muted">Dairy-free</span>
          </div>
          <div class="diet-icons">
            <span class="ico" title="Nut-free">NF</span> <span class="small text-muted">Nut-free</span>
          </div>
          <div class="diet-icons">
            <span class="ico" title="Plant-based">🌱</span> <span class="small text-muted">Plant-based</span>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- ===== CTA ===== -->
  <section class="press py-4">
    <div class="container">
      <div class="text-center text-muted mb-2">As seen in & loved by</div>
      <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
        <img src="{{ asset('assets/img/gallery/google_review.png') }}" alt="Google rating 4.9 out of 5" height="44" loading="lazy">
        <img src="assets/img/clients/tripadvisor-choice.png" alt="Tripadvisor Travelers’ Choice" height="44" loading="lazy">
        <img src="assets/img/clients/yelp-love.png" alt="Yelp — People Love Us" height="44" loading="lazy">
        <img src="assets/img/clients/oldtown-weekly.png" alt="Featured in Oldtown Weekly" height="44" loading="lazy">
        <img src="assets/img/clients/hotel-oasis.png" alt="Catering partner — Hotel Oasis" height="44" loading="lazy">
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
              <img src="{{ asset('assets/img/gallery/logo.png') }}" alt="Crustella" height="36" width="36" style="border-radius:8px; object-fit:cover">
              <strong>Crustella</strong>
            </div>
            <p class="small text-muted mb-3">A neighborhood café & bakery serving honest pastries and specialty coffee.</p>
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
            <li class="mb-2"><a class="link-body-emphasis" href="/menu">Menu</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/order">Order</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/workshops">Workshops</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/blog">Blog</a></li>
          </ul>
        </div>
        <div class="col-6 col-lg-3">
          <h6 class="fw-bold mb-3">Support</h6>
          <ul class="list-unstyled small m-0">
            <li class="mb-2"><a class="link-body-emphasis" href="/gift-cards">Gift cards</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/nutrition">Allergens</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/press">Press</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/contact">Contact</a></li>
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
        <p class="small text-muted mb-2 mb-md-0">&copy; <span id="year"></span> Crustella. All rights reserved.</p>
        <div class="d-flex align-items-center gap-3">
          <a href="#" class="btn btn-outline-primary btn-sm" id="toTopBtn"><i class="bi bi-arrow-up"></i> Top</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Mobile sticky CTA -->
  <div class="mobile-cta">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-bag"></i>
      <span class="small">Items in cart</span>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas">Cart
        <span class="badge text-bg-secondary" id="cartCountMobile">0</span>
      </button>
      <a href="/order" class="btn btn-primary btn-sm">Checkout</a>
    </div>
  </div>

  <!-- Offcanvas Cart -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="cartCanvas" aria-labelledby="cartLabel" style="background:var(--surface); border-left:1px solid var(--border)">
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
        <a class="btn btn-primary" href="/order" id="checkoutBtn" aria-disabled="true">Checkout at counter</a>
        <button class="btn btn-light" id="clearCart" disabled>Clear cart</button>
      </div>
    </div>
  </div>

  <!-- ===== ITEM DETAIL MODAL ===== -->
  <div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true" aria-labelledby="itemModalLabel">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="ratio ratio-4x3 skel" style="border-top-left-radius:16px;border-top-right-radius:16px;">
            <img id="itemModalImg" alt="" loading="lazy">
          </div>
          <div class="p-3">
            <div class="d-flex align-items-start justify-content-between">
              <div>
                <h5 class="m-0" id="itemModalLabel"></h5>
                <div class="small text-muted" id="itemModalCat"></div>
              </div>
              <span class="price-badge" id="itemModalPrice">$0.00</span>
            </div>
            <p class="mt-2 mb-2" id="itemModalDesc"></p>
            <div class="diet-icons mb-2" id="itemModalDiet"></div>
            <div class="small text-muted mb-2" id="itemPairs"></div>
            <div class="d-grid gap-2">
              <button class="btn btn-primary" id="itemAddBtn"><i class="bi bi-bag-plus"></i> Add to cart</button>
              <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== SCRIPTS ===== -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // ===== Helpers =====
      const $ = (s, r=document) => r.querySelector(s);
      const $$ = (s, r=document) => Array.from(r.querySelectorAll(s));
      const money = (n) => '$' + (Math.round(n * 100) / 100).toFixed(2);
      const setYear = () => { $('#year').textContent = new Date().getFullYear() };

      // Remove skeleton when images load
      $$('.skel img').forEach(img => {
        const done = () => img.parentElement.classList.add('loaded');
        if (img.complete) done(); else { img.addEventListener('load', done); img.addEventListener('error', done); }
      });

      // Navbar progress
      const nav = $('#siteNav'), progress = $('#scrollProgress');
      const setProgress = () => {
        const st = document.documentElement.scrollTop || document.body.scrollTop;
        const h = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const pct = Math.max(0, Math.min(1, h ? st / h : 0));
        progress.style.width = (pct * 100).toFixed(2) + '%';
        nav?.classList.toggle('scrolled', window.scrollY > 8);
      };
      setProgress(); window.addEventListener('scroll', setProgress); setYear();

      // Theme toggle
      const themeBtn = $('#themeBtn'), themeBtnMobile = $('#themeBtnMobile');
      const syncIcon = (el) => { if(!el) return; el.innerHTML = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon-stars"></i>'; };
      const toggleTheme = () => {
        const next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-bs-theme', next);
        try { localStorage.setItem('theme', next) } catch(e){}
        syncIcon(themeBtn); syncIcon(themeBtnMobile);
      };
      syncIcon(themeBtn); syncIcon(themeBtnMobile);
      themeBtn?.addEventListener('click', toggleTheme);
      themeBtnMobile?.addEventListener('click', toggleTheme);

      // Offcanvas close on link
      const offcanvasEl = $('#offcanvasNav');
      offcanvasEl?.querySelectorAll('[data-close]').forEach(a => a.addEventListener('click', () => bootstrap.Offcanvas.getInstance(offcanvasEl)?.hide()));

      // Top button
      $('#toTopBtn')?.addEventListener('click', (e)=>{ e.preventDefault(); window.scrollTo({top:0, behavior:'smooth'}) });

      // Newsletter demo
      const nForm = $('#newsletterForm'), nMsg = $('#newsletterMsg');
      nForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        nMsg.textContent = 'Thanks! You’re subscribed.';
        nMsg.className = 'small mt-2 text-success';
        nForm.reset();
        setTimeout(()=>{ nMsg.textContent=''; nMsg.className='small mt-2'}, 3500);
      });

      // ===== CART =====
      const cart = [];
      const cartLines = $('#cartLines'), cartEmpty = $('#cartEmpty'), cartTotal = $('#cartTotal');
      const cartCount = $('#cartCount'), cartCountMobile = $('#cartCountMobile');
      const checkoutBtn = $('#checkoutBtn'), clearCart = $('#clearCart');

      function renderCart(){
        cartLines.innerHTML = '';
        let total = 0;
        cart.forEach((line,i)=>{
          total += line.price * line.qty;
          const row = document.createElement('div');
          row.className = 'cart-line d-flex align-items-center justify-content-between gap-2';
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
          row.querySelector('button')?.addEventListener('click', ()=>{ cart.splice(i,1); updateCart(); });
          cartLines.appendChild(row);
        });
        cartEmpty.style.display = cart.length ? 'none':'block';
        cartTotal.textContent = money(total);
        cartCount.textContent = String(cart.length);
        cartCountMobile.textContent = String(cart.length);
        checkoutBtn.setAttribute('aria-disabled', cart.length === 0 ? 'true':'false');
        clearCart.disabled = cart.length === 0;
      }
      function updateCart(){ renderCart() }
      clearCart?.addEventListener('click', ()=>{ cart.length = 0; updateCart() });

      // ===== MENU DATA =====
      const MENU = [
        // Coffee
        {id:'latte', name:'Vanilla Latte', price:4.9, img:'assets/img/dishes/item_1.png', cat:'Coffee', tags:['df_optional'], diet:['🌱'], desc:'Velvety milk with a double shot and vanilla syrup. Oat milk available.', pairs:['croissant']},
        {id:'americano', name:'Americano', price:3.5, img:'assets/img/dishes/item_6.png', cat:'Coffee', tags:['df','gf','nf'], diet:['GF','DF','NF'], desc:'Bold espresso topped with hot water.', pairs:['almond-financier']},
        {id:'cold-brew', name:'Cold Brew', price:4.2, img:'assets/img/dishes/item_9.png', cat:'Coffee', tags:['df','gf','nf'], diet:['GF','DF','NF'], desc:'12-hour steep. Smooth and refreshing.', pairs:['cinnamon-roll']},

        // Tea
        {id:'matcha', name:'Iced Matcha', price:4.6, img:'assets/img/dishes/item_3.png', cat:'Tea', tags:['gf','nf'], diet:['GF','NF'], desc:'Ceremonial matcha, light sweetness.', pairs:['almond-financier']},
        {id:'earlgrey', name:'Earl Grey', price:3.1, img:'assets/img/dishes/item_6.png', cat:'Tea', tags:['df','gf','nf'], diet:['GF','DF','NF'], desc:'Classic bergamot aroma.', pairs:['blueberry-muffin']},

        // Pastries
        {id:'croissant', name:'Butter Croissant', price:3.2, img:'assets/img/dishes/item_4.png', cat:'Pastries', tags:['nf'], diet:['NF'], desc:'Flaky layers, AOP butter.', pairs:['latte']},
        {id:'cinnamon-roll', name:'Sticky Cinnamon Roll', price:3.8, img:'assets/img/dishes/item_10.png', cat:'Pastries', tags:['nf'], diet:['NF'], desc:'Sticky glaze, warm spices. Limited batches daily.', pairs:['americano']},
        {id:'blueberry-muffin', name:'Blueberry Muffin', price:3.1, img:'assets/img/dishes/item_2.png', cat:'Pastries', tags:['nf'], diet:['NF'], desc:'Moist crumb, bursting berries.', pairs:['earlgrey']},
        {id:'almond-financier', name:'Almond Financier', price:2.9, img:'assets/img/dishes/item_12.png', cat:'Pastries', tags:['gf'], diet:['GF'], desc:'Brown butter, almond flour. Naturally gluten-free.', pairs:['espresso']},

        // Breakfast
        {id:'brioche-toast', name:'Brioche French Toast', price:9.9, img:'assets/img/dishes/item_7.png', cat:'Breakfast', tags:[], diet:[], desc:'Maple, berries, mascarpone.', pairs:['americano']},
        {id:'avo-toast', name:'Sourdough Avo Toast', price:8.9, img:'assets/img/dishes/item_5.png', cat:'Breakfast', tags:['nf'], diet:['NF'], desc:'Heirloom tomatoes, feta crumble.', pairs:['earlgrey']},
        {id:'herb-omelette', name:'Herb Omelette', price:7.9, img:'assets/img/dishes/item_8.png', cat:'Breakfast', tags:['gf','nf'], diet:['GF','NF'], desc:'Chives, gruyère, side salad.', pairs:['latte']},

        // Seasonal
        {id:'roll-box', name:'Seasonal Roll Box (6)', price:21.0, img:'assets/img/gallery/sticky-cinnamon-roll.png', cat:'Seasonal', tags:['nf'], diet:['NF'], desc:'Six sticky rolls — pre-order recommended.', pairs:['cold-brew']},
      ];

      const CATEGORIES = ['All','Coffee','Tea','Pastries','Breakfast','Seasonal'];
      const DIET_CHIPS = [
        {key:'gf', label:'Gluten-free', ico:'GF'},
        {key:'df', label:'Dairy-free', ico:'DF'},
        {key:'nf', label:'Nut-free', ico:'NF'},
        {key:'plant', label:'Plant-based', ico:'🌱'}
      ];

      // ===== STATE =====
      let selectedCat = 'All';
      const activeDiets = new Set(); // gf, df, nf, plant
      let searchTerm = '';
      let sortBy = 'popular';

      // ===== RENDER FILTERS =====
      const catTabs = $('#catTabs');
      CATEGORIES.forEach(cat=>{
        const btn = document.createElement('button');
        btn.type='button';
        btn.className = 'btn btn-light btn-sm';
        btn.textContent = cat;
        btn.setAttribute('aria-pressed', cat===selectedCat ? 'true':'false');
        btn.addEventListener('click', ()=>{
          selectedCat = cat;
          $$('#catTabs .btn').forEach(b=>b.setAttribute('aria-pressed','false'));
          btn.setAttribute('aria-pressed','true');
          render();
        });
        catTabs.appendChild(btn);
      });

      const chipsWrap = $('#dietChips');
      DIET_CHIPS.forEach(ch=>{
        const chip = document.createElement('button');
        chip.type='button';
        chip.className='chip';
        chip.innerHTML = `<span class="ico" aria-hidden="true">${ch.ico}</span><span class="small">${ch.label}</span>`;
        chip.setAttribute('aria-pressed','false');
        chip.addEventListener('click', ()=>{
          const on = chip.getAttribute('aria-pressed') === 'true';
          chip.setAttribute('aria-pressed', on ? 'false':'true');
          if(on) activeDiets.delete(ch.key); else activeDiets.add(ch.key);
          render();
        });
        chipsWrap.appendChild(chip);
      });

      // Search + sort
      const searchInput = $('#menuSearch'), clearSearch = $('#clearSearch'), sortSel = $('#sortSel');
      searchInput?.addEventListener('input', ()=>{ searchTerm = searchInput.value.trim().toLowerCase(); render(); });
      clearSearch?.addEventListener('click', ()=>{ searchTerm = ''; searchInput.value=''; render(); });
      sortSel?.addEventListener('change', ()=>{ sortBy = sortSel.value; render(); });

      // ===== RENDER GRID =====
      const grid = $('#menuGrid'), resultsCount = $('#resultsCount'), emptyState = $('#emptyState');

      function matchesDiet(item){
        // Plant-based heuristic: tag 'plant' OR diet includes 🌱
        const needPlant = activeDiets.has('plant');
        if(activeDiets.size === 0) return true;
        const tags = new Set(item.tags || []);
        let ok = true;
        if(activeDiets.has('gf')) ok = ok && (tags.has('gf') || (item.diet||[]).includes('GF'));
        if(activeDiets.has('df')) ok = ok && (tags.has('df') || tags.has('df_optional') || (item.diet||[]).includes('DF'));
        if(activeDiets.has('nf')) ok = ok && (tags.has('nf') || (item.diet||[]).includes('NF'));
        if(needPlant) ok = ok && (tags.has('plant') || (item.diet||[]).includes('🌱'));
        return ok;
      }
      function matchesCat(item){ return selectedCat==='All' ? true : item.cat===selectedCat }
      function matchesSearch(item){
        if(!searchTerm) return true;
        return (item.name.toLowerCase().includes(searchTerm) || (item.desc||'').toLowerCase().includes(searchTerm) || (item.cat||'').toLowerCase().includes(searchTerm));
      }
      function sortItems(list){
        if(sortBy==='price_asc') return list.sort((a,b)=>a.price-b.price);
        if(sortBy==='price_desc') return list.sort((a,b)=>b.price-a.price);
        if(sortBy==='name_asc') return list.sort((a,b)=>a.name.localeCompare(b.name));
        // popular: simple stable grouping by category priority & price desc
        const catOrder = new Map(CATEGORIES.map((c,i)=>[c,i]));
        return list.sort((a,b)=>{
          const ao=(catOrder.get(a.cat)||99), bo=(catOrder.get(b.cat)||99);
          if(ao!==bo) return ao-bo;
          return b.price-a.price;
        });
      }

      function cardHTML(item){
        const dietIcons = (item.diet||[]).map(d=>`<span class="ico">${d}</span>`).join('');
        const tagBadge = item.cat==='Seasonal' ? `<span class="badge text-bg-warning position-absolute m-2" style="right:.25rem; top:.25rem; border-radius:999px;">Seasonal</span>` : '';
        return `
          <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card-soft h-100">
              <div class="ratio ratio-4x3 img-wrap skel">
                ${tagBadge}
                <img src="{{ asset('${item.img}') }}" alt="${item.name}" loading="lazy">
              </div>
              <div class="card-body-tight">
                <div class="d-flex align-items-start justify-content-between">
                  <div class="pe-2" style="min-width:0">
                    <h6 class="mb-0 text-truncate">${item.name}</h6>
                    <div class="small text-muted text-truncate">${item.cat}</div>
                  </div>
                  <span class="price-badge">${money(item.price)}</span>
                </div>
                <p class="small text-muted mt-2 mb-2" style="min-height: 2.4em">${item.desc}</p>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="diet-icons">${dietIcons}</div>
                  <div class="d-flex gap-2">
                    <button class="btn btn-light btn-sm" data-view="${item.id}" aria-label="View ${item.name}"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-primary btn-sm add-to-cart" data-id="${item.id}" data-name="${item.name}" data-price="${item.price}"><i class="bi bi-bag-plus"></i> Add</button>
                  </div>
                </div>
              </div>
            </div>
          </div>`;
      }

      function render(){
        const filtered = MENU.filter(i => matchesCat(i) && matchesDiet(i) && matchesSearch(i));
        sortItems(filtered);
        grid.innerHTML = filtered.map(cardHTML).join('');
        resultsCount.textContent = `${filtered.length} item${filtered.length===1?'':'s'} • ${selectedCat}`;
        emptyState.classList.toggle('d-none', filtered.length !== 0);

        // Wire buttons
        $$('.add-to-cart', grid).forEach(btn=>{
          btn.addEventListener('click', ()=>{
            const name = btn.dataset.name || 'Item';
            const price = parseFloat(btn.dataset.price || '0');
            cart.push({ name, price, qty:1 });
            updateCart();
          });
        });
        $$('button[data-view]', grid).forEach(btn=>{
          btn.addEventListener('click', ()=>openItem(btn.getAttribute('data-view')));
        });

        // Re-bind skeleton for new images
        $$('.skel img', grid).forEach(img=>{
          const done = () => img.parentElement.classList.add('loaded');
          if(img.complete) done(); else { img.addEventListener('load',done); img.addEventListener('error',done); }
        });
      }

      // ===== ITEM MODAL =====
      const itemModal = new bootstrap.Modal($('#itemModal'));
      function openItem(id){
        const item = MENU.find(m=>m.id===id);
        if(!item) return;
        $('#itemModalImg').src = "{{ asset('"+item.img+"') }}";
        $('#itemModalImg').alt = item.name;
        $('#itemModalLabel').textContent = item.name;
        $('#itemModalCat').textContent = item.cat;
        $('#itemModalPrice').textContent = money(item.price);
        $('#itemModalDesc').textContent = item.desc || '';
        const diet = $('#itemModalDiet');
        diet.innerHTML = (item.diet||[]).map(d=>`<span class="ico">${d}</span>`).join('') || '<span class="small text-muted">—</span>';
        const pairs = (item.pairs||[]).map(pid => MENU.find(m=>m.id===pid)?.name).filter(Boolean);
        $('#itemPairs').innerHTML = pairs.length ? `Pairs well with: <em>${pairs.join(', ')}</em>` : '';
        $('#itemAddBtn').onclick = ()=>{
          cart.push({ name: item.name, price: item.price, qty:1 });
          updateCart();
          itemModal.hide();
        };
        itemModal.show();
      }

      // ===== INITIALIZE =====
      render();
      updateCart();

      // Menu-hero search connects to filters too
      $('#menuSearchForm')?.addEventListener('submit', (e)=>{ e.preventDefault(); render() });

      // Search open/close (from navbar)
      const searchBtn = $('#searchBtn'), searchWrap = $('#navSearchWrap'), searchClose = $('#searchClose');
      const bsCollapse = searchWrap ? new bootstrap.Collapse(searchWrap, {toggle:false}) : null;
      const openSearch = () => { bsCollapse?.show(); searchBtn?.setAttribute('aria-expanded','true'); setTimeout(()=>searchWrap?.querySelector('input')?.focus(),120) }
      const closeSearch = () => { bsCollapse?.hide(); searchBtn?.setAttribute('aria-expanded','false') }
      searchBtn?.addEventListener('click', ()=> searchWrap?.classList.contains('show') ? closeSearch():openSearch());
      searchClose?.addEventListener('click', closeSearch);
      document.addEventListener('click', (e)=>{
        if(!searchWrap?.classList.contains('show')) return;
        if(!searchWrap.contains(e.target) && e.target !== searchBtn) closeSearch();
      });
    });
  </script>
</body>
</html>
