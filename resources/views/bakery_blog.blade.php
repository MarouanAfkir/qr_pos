<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">
<head>
  <!-- ===== META ===== -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Crustella — Brews & Bakes Journal: recipes, behind-the-bar tips, bakery notes, and café news." />
  <meta name="theme-color" content="#C46E3A" />
  <title>Crustella — Brews & Bakes Journal (Blog)</title>
  <link rel="icon" href="assets/img/favicon.png" />

  <!-- Early theme init -->
  <script>
    (()=>{try{const t=localStorage.getItem('theme'); if(t) document.documentElement.setAttribute('data-bs-theme',t);}catch(e){}})();
  </script>

  <!-- ===== FONTS & CSS ===== -->
  <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

  <style>
    /* ============================================================
       Warm café palette + creamy UI (shared)
    ============================================================ */
    :root{
      --accent:#C46E3A; --accent-600:#A75B2F; --accent-700:#8F4E29;
      --cocoa:#5A3E2B; --bg:#FFF7EF; --muted:#6B7280;
      --surface:#FFFFFF; --surface-2:#FFF2E5; --border:#EADFD5;
      --ring:rgba(196,110,58,.25); --radius:18px;
      --shadow-1:0 6px 20px rgba(2,6,23,.06); --shadow-2:0 16px 40px rgba(2,6,23,.10);
      --pad:clamp(14px,1.6vw,22px);
    }
    [data-bs-theme="dark"]{
      --bg:#0E1114; --surface:#12161B; --surface-2:#10141A; --border:#222A35; --muted:#9AA3AF; --cocoa:#E6E6E6;
      --shadow-1:0 6px 20px rgba(0,0,0,.35); --shadow-2:0 16px 40px rgba(0,0,0,.45);
    }

    /* Base + safety */
    html{scroll-behavior:smooth}
    body{
      font-family:'Manrope', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      color:var(--cocoa);
      background:radial-gradient(900px 480px at 80% -10%, rgba(196,110,58,.08), transparent 60%), var(--bg);
      overflow-x:hidden;
    }
    h1,h2,h3,h4,h5,h6{ font-family:'Inter',sans-serif; letter-spacing:-.015em; font-weight:800 }
    .text-muted{ color:var(--muted)!important }
    section{ scroll-margin-top:96px }
    *{ min-width:0 } /* FIX: prevent flex overflow on long words */
    img{ display:block; max-width:100%; height:auto }
    .object-fit-cover{ object-fit:cover }

    /* Clamp utilities to normalize card heights */
    .clamp-2{ display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden }
    .clamp-3{ display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden }
    .nowrap{ white-space:nowrap }

    /* Skeleton shimmer */
    .skel{ position:relative; overflow:hidden; border-radius:14px; background:#eee }
    [data-bs-theme="dark"] .skel{ background:#1a1f26 }
    .skel::before{ content:""; position:absolute; inset:0; background:linear-gradient(90deg,transparent,rgba(255,255,255,.25),transparent); animation:shimmer 1.35s linear infinite }
    .skel.loaded::before{ opacity:0; visibility:hidden }
    @keyframes shimmer{ 0%{transform:translateX(-100%)} 100%{transform:translateX(100%)} }
    /* Ensure any ratio images are contained */
    .ratio > img, .ratio > picture > img{ width:100%; height:100%; object-fit:cover }

    /* Buttons */
    .btn-primary{
      --bs-btn-bg:var(--accent); --bs-btn-border-color:var(--accent);
      --bs-btn-hover-bg:var(--accent-600); --bs-btn-hover-border-color:var(--accent-600);
      border-radius:12px; font-weight:700; box-shadow:0 10px 20px rgba(196,110,58,.22);
    }
    .btn-outline-primary{
      --bs-btn-color:var(--accent); --bs-btn-border-color:var(--accent);
      --bs-btn-hover-color:#fff; --bs-btn-hover-bg:var(--accent); --bs-btn-hover-border-color:var(--accent);
      border-radius:12px; font-weight:700;
    }
    .btn-light{ border-radius:12px; font-weight:700 }

    /* Utility bar */
    .nav-utility{ border-bottom:1px solid var(--border); background:linear-gradient(90deg,#FFF1E6,#FFEADB) }
    [data-bs-theme="dark"] .nav-utility{ background:linear-gradient(90deg,#171c22,#12171e) }
    .nav-utility .link-utility{ color:var(--cocoa); text-decoration:none }
    .nav-utility .link-utility:hover{ text-decoration:underline }

    /* Navbar */
    .nav-elevated{
      position:sticky; top:0; z-index:1040; background:rgba(255,255,255,.86);
      backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px);
      border-bottom:1px solid var(--border);
      transition:background .25s ease, box-shadow .25s ease, padding .2s ease;
      padding:.7rem 0;
    }
    [data-bs-theme="dark"] .nav-elevated{ background:rgba(16,19,24,.85) }
    .nav-elevated.scrolled{ background:var(--surface); box-shadow:0 10px 28px rgba(0,0,0,.06); padding:.45rem 0 }
    #scrollProgress{ position:absolute; top:0; left:0; height:3px; width:0%; background:linear-gradient(90deg,var(--accent),#FFB680); border-bottom-right-radius:3px; border-top-right-radius:3px; transition:width .15s }
    .navbar .nav-link{ font-weight:600; padding:.45rem .8rem; border-radius:999px; color:var(--cocoa) }
    .navbar .nav-link:hover,.navbar .nav-link:focus{ background:rgba(196,110,58,.10) }
    .navbar .nav-link:focus-visible{ outline:0; box-shadow:0 0 0 4px var(--ring) }
    .navbar-toggler{ border-color:var(--border) }
    .navbar-toggler:focus{ box-shadow:0 0 0 .25rem var(--ring) }
    .navbar-toggler-icon{ background-size:100% 100% }
    .nav-elevated .navbar-toggler-icon{
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='%235A3E2B' stroke-linecap='round' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
    [data-bs-theme="dark"] .nav-elevated .navbar-toggler-icon{
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='%23E6E6E6' stroke-linecap='round' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    /* Mega dropdown */
    .dropdown.position-static .dropdown-menu.mega{
      display:block; visibility:hidden; opacity:0; pointer-events:none; transform:translate(-50%,8px);
      left:50%!important; top:100%!important; transition:opacity .15s ease;
    }
    .dropdown.position-static.show .dropdown-menu.mega{ visibility:visible; opacity:1; pointer-events:auto }
    .dropdown-menu.mega{
      min-width:760px; max-width:980px; border:1px solid var(--border); border-radius:16px; background:var(--surface); box-shadow:var(--shadow-2); padding:1rem;
    }
    .mega .mega-link{ color:var(--cocoa); text-decoration:none; display:inline-flex; align-items:center; gap:.5rem }
    .mega .mega-link:hover{ text-decoration:underline }
    .mega .seasonal-card{ display:flex; align-items:center; gap:.75rem }
    .mega .seasonal-card img{ width:72px; height:72px; object-fit:cover; border-radius:12px }

    /* Search under nav */
    .nav-search{ border-top:1px solid var(--border); background:rgba(255,255,255,.86); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px) }
    [data-bs-theme="dark"] .nav-search{ background:rgba(16,19,24,.85) }
    .nav-search-form{ display:flex; align-items:center; gap:.6rem; padding:.75rem 0 }
    .nav-search-input{ border-radius:12px; border:1px solid var(--border) }

    /* ============================================================
       BLOG — Hero + grid + sidebar
    ============================================================ */
    .blog-hero{ position:relative; isolation:isolate; border-bottom:1px solid var(--border); background:var(--bg); min-height:clamp(360px,52vh,520px); display:grid; place-items:stretch }
    .blog-hero .hero-media{ position:absolute; inset:0; z-index:-2; overflow:hidden }
    .blog-hero .hero-media::before{
      content:""; position:absolute; inset:-6%;
      background-image:url('{{ asset('assets/img/gallery/hero.png') }}'); background-size:cover; background-position:center;
      filter:contrast(1.02) saturate(1.05); animation:kenburns 22s ease-in-out infinite alternate; transform-origin:70% 30%;
    }
    @keyframes kenburns{ 0%{transform:scale(1) translate3d(0,0,0)} 100%{transform:scale(1.12) translate3d(-1%,-1%,0)} }
    .blog-hero .media-overlay{
      position:absolute; inset:0; z-index:-1;
      background:
        radial-gradient(60rem 35rem at 85% -5%, rgba(196,110,58,.18), transparent 60%),
        linear-gradient(180deg, rgba(0,0,0,.0), rgba(0,0,0,.06) 60%, rgba(0,0,0,.14)),
        linear-gradient(120deg, rgba(255,250,245,.90), rgba(255,250,245,.65) 40%, rgba(255,250,245,.22) 62%, rgba(255,250,245,.05));
    }
    [data-bs-theme="dark"] .blog-hero .media-overlay{
      background:
        radial-gradient(60rem 35rem at 85% -5%, rgba(196,110,58,.14), transparent 60%),
        linear-gradient(180deg, rgba(0,0,0,.0), rgba(0,0,0,.35) 60%, rgba(0,0,0,.6)),
        linear-gradient(120deg, rgba(14,17,20,.86), rgba(14,17,20,.72) 38%, rgba(14,17,20,.5) 60%, rgba(14,17,20,.35));
    }
    .content-scrim{
      position:absolute; inset:0; z-index:-1; pointer-events:none;
      background:linear-gradient(90deg, rgba(255,255,255,.9) 0%, rgba(255,255,255,.75) 30%, rgba(255,255,255,.38) 55%, rgba(255,255,255,0) 72%);
    }
    [data-bs-theme="dark"] .content-scrim{
      background:linear-gradient(90deg, rgba(14,17,20,.88) 0%, rgba(14,17,20,.75) 28%, rgba(14,17,20,.42) 52%, rgba(14,17,20,0) 72%);
    }
    .crumbs a{ color:inherit; text-decoration:none } .crumbs a:hover{ text-decoration:underline }

    .blog-controls{ display:flex; align-items:center; gap:1rem; flex-wrap:wrap }
    .chip-cat{
      display:inline-flex; align-items:center; gap:.45rem; border:1px solid var(--border);
      border-radius:999px; padding:.4rem .75rem; background:var(--surface);
      cursor:pointer; user-select:none; font-weight:700; white-space:nowrap;
    }
    .chip-cat.active{ border-color:var(--accent); background:rgba(196,110,58,.10) }

    .post-card{
      background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden;
      transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
      height:100%; display:flex; flex-direction:column;
    }
    .post-card:hover{ transform:translateY(-2px); box-shadow:var(--shadow-1); border-color:rgba(196,110,58,.35) }
    .post-card > .skel{ border-radius:0 }
    .post-card .pad{ padding:var(--pad) }
    .post-card .meta{ display:flex; gap:.75rem; flex-wrap:wrap; align-items:center; color:var(--muted) }
    .post-card .badge-cat{ background:rgba(196,110,58,.12); color:var(--accent); border:1px solid var(--border) }
    .post-wrap{ display:flex } /* ensures equal heights in row */

    /* Sidebar */
    .sidebar .widget{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:var(--pad) }
    .sidebar .mini-post{ display:flex; gap:.75rem; align-items:center }
    .sidebar .mini-post img{ width:64px; height:48px; object-fit:cover; border-radius:10px; border:1px solid var(--border) }
    .tag{ display:inline-flex; align-items:center; border:1px solid var(--border); border-radius:999px; padding:.25rem .6rem; gap:.35rem; background:var(--surface-2); font-weight:600; }

    /* Pagination */
    .pagination .page-link{ border-radius:10px; border:1px solid var(--border); color:var(--cocoa) }
    .pagination .page-item.active .page-link{ background:var(--accent); border-color:var(--accent) }

    /* Footer */
    .site-footer{ background:var(--surface); border-top:1px solid var(--border) }

    @media (prefers-reduced-motion:reduce){ .blog-hero .hero-media::before{ animation:none } }
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
        <a href="/#contact" class="link-utility">Contact</a>
        <a href="/#workshops" class="link-utility">Workshops</a>
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
          <li class="nav-item dropdown position-static">
            <a class="nav-link dropdown-toggle" href="#menu" id="menuMega" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">Explore</a>
            <div class="dropdown-menu mega" aria-labelledby="menuMega">
              <div class="row g-4 px-2 px-lg-3">
                <div class="col-6 col-xl-3">
                  <h6 class="fw-bold mb-2">Coffee</h6>
                  <ul class="list-unstyled small m-0">
                    <li class="mb-2"><a class="mega-link" href="/#builder"><i class="bi bi-cup-hot"></i> Build your drink</a></li>
                    <li class="mb-2"><a class="mega-link" href="/#specials"><i class="bi bi-cup-straw"></i> Weekly specials</a></li>
                    <li class="mb-2"><a class="mega-link" href="/#subs"><i class="bi bi-box-seam"></i> Subscriptions</a></li>
                  </ul>
                </div>
                <div class="col-6 col-xl-3">
                  <h6 class="fw-bold mb-2">Bakery</h6>
                  <ul class="list-unstyled small m-0">
                    <li class="mb-2"><a class="mega-link" href="/#quick"><i class="bi bi-bag-heart"></i> Quick order picks</a></li>
                    <li class="mb-2"><a class="mega-link" href="/#gallery"><i class="bi bi-images"></i> Gallery</a></li>
                    <li class="mb-2"><a class="mega-link" href="/#faq"><i class="bi bi-patch-question"></i> FAQ & Allergens</a></li>
                  </ul>
                </div>
                <div class="col-6 col-xl-3">
                  <h6 class="fw-bold mb-2">Events</h6>
                  <ul class="list-unstyled small m-0">
                    <li class="mb-2"><a class="mega-link" href="/#workshops"><i class="bi bi-calendar-event"></i> Workshops</a></li>
                    <li class="mb-2"><a class="mega-link" href="/#contact"><i class="bi bi-geo-alt"></i> Visit & hours</a></li>
                    <li class="mb-2"><a class="mega-link" href="/#press"><i class="bi bi-megaphone"></i> Press</a></li>
                  </ul>
                </div>
                <div class="col-6 col-xl-3">
                  <div class="p-3 rounded-3 border" style="border-color:var(--border)!important;background:var(--surface-2)">
                    <div class="small text-muted mb-2">Seasonal pick</div>
                    <div class="seasonal-card">
                      <img src="{{ asset('assets/img/gallery/sticky-cinnamon-roll.png') }}" alt="Cinnamon roll">
                      <div>
                        <div class="fw-bold">Sticky Cinnamon Roll</div>
                        <div class="small text-muted">Limited batch • Pre-order</div>
                      </div>
                    </div>
                    <a href="/#quick" class="btn btn-primary btn-sm w-100 mt-3">Order a box</a>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <li class="nav-item"><a class="nav-link" href="/#builder">Drink Builder</a></li>
          <li class="nav-item"><a class="nav-link" href="/#subs">Subscriptions</a></li>
          <li class="nav-item"><a class="nav-link" href="/#workshops">Workshops</a></li>
          <li class="nav-item"><a class="nav-link" href="/#contact">Visit</a></li>
          <li class="nav-item"><a class="nav-link active" aria-current="page" href="/blog"><i class="bi bi-journal-text me-1"></i>Blog</a></li>

          <li class="nav-item">
            <button class="btn btn-outline-primary" id="searchBtn" aria-expanded="false" aria-controls="navSearchWrap" aria-label="Open search">
              <i class="bi bi-search"></i>
            </button>
          </li>
          <li class="nav-item">
            <button id="themeBtn" class="btn btn-outline-primary" aria-label="Toggle dark mode"><i class="bi bi-moon-stars"></i></button>
          </li>

          <li class="nav-item ms-1">
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas"><i class="bi bi-bag"></i> Cart
              <span class="badge text-bg-light ms-1" id="cartCount">0</span>
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
          <input class="form-control nav-search-input" type="search" placeholder="Search site…" aria-label="Search">
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
        <a href="/#builder" class="btn btn-outline-primary" data-close><i class="bi bi-cup-hot"></i> Build a drink</a>
        <a href="/blog" class="btn btn-light" data-close><i class="bi bi-journal-text"></i> Blog</a>
      </div>
      <div class="list-group list-group-flush">
        <a class="list-group-item" href="/#quick" data-close>Quick order</a>
        <a class="list-group-item" href="/#specials" data-close>Weekly specials</a>
        <a class="list-group-item" href="/#subs" data-close>Subscriptions</a>
        <a class="list-group-item" href="/#workshops" data-close>Workshops</a>
        <a class="list-group-item" href="/#gallery" data-close>Gallery</a>
        <a class="list-group-item" href="/#contact" data-close>Visit us</a>
      </div>
      <div class="border-top mt-3 pt-3" style="border-color:var(--border)!important;">
        <div class="d-flex gap-2">
          <button id="themeBtnMobile" class="btn btn-light w-100" type="button"><i class="bi bi-moon-stars"></i> Theme</button>
          <button class="btn btn-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#navSearchWrap"><i class="bi bi-search"></i> Search</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== BLOG HERO ===== -->
  <header class="blog-hero">
    <div class="hero-media" aria-hidden="true"></div>
    <div class="media-overlay" aria-hidden="true"></div>
    <div class="content-scrim" aria-hidden="true"></div>

    <div class="container py-5">
      <nav class="crumbs small text-muted" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Blog</li>
        </ol>
      </nav>

      <div class="row g-4 align-items-center mt-1">
        <div class="col-lg-7">
          <h1 class="display-5 m-0">Brews & <span style="background:linear-gradient(90deg,var(--accent),#FFB680);-webkit-background-clip:text;background-clip:text;color:transparent">Bakes</span> Journal</h1>
          <p class="lead text-muted mt-2">Recipes, behind-the-bar tips, bakery notes, and stories from the neighborhood.</p>

          <div class="d-flex flex-wrap align-items-center gap-2 mt-3" role="tablist" aria-label="Filter posts by category">
            <button class="chip-cat active" type="button" data-filter="all" aria-pressed="true"><i class="bi bi-stars"></i> All</button>
            <button class="chip-cat" type="button" data-filter="recipes"><i class="bi bi-egg-fried"></i> Recipes</button>
            <button class="chip-cat" type="button" data-filter="coffee"><i class="bi bi-cup-hot"></i> Coffee</button>
            <button class="chip-cat" type="button" data-filter="bakery"><i class="bi bi-bag-heart"></i> Bakery Tips</button>
            <button class="chip-cat" type="button" data-filter="news"><i class="bi bi-megaphone"></i> News</button>
          </div>

          <div class="blog-controls mt-3">
            <div class="input-group" style="max-width:520px;">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="search" id="blogSearch" class="form-control" placeholder="Search articles (title, snippet, tags)…" aria-label="Search blog">
            </div>
            <div class="small text-muted" id="resultCount" aria-live="polite"></div>
          </div>
        </div>
        <div class="col-lg-5 d-none d-lg-block">
          <div class="skel" style="border-radius:22px;">
            <div class="ratio ratio-16x9">
              <img src="{{ asset('assets/img/gallery/latte_art.png') }}" alt="Pouring latte art" loading="eager" fetchpriority="high">
            </div>
          </div>
          <p class="small text-muted mt-2">All photos are placeholders—replace with your licensed images.</p>
        </div>
      </div>
    </div>
  </header>

  <!-- ===== BLOG GRID ===== -->
  <main class="py-5">
    <div class="container">
      <div class="row g-4 align-items-start">
        <!-- Content -->
        <div class="col-lg-8">
          <!-- Featured -->
          <article id="featuredPost" class="post-card mb-4" data-category="recipes" data-tags="brioche,brunch,sweet">
            <div class="skel"><div class="ratio ratio-16x9">
              <img src="{{ asset('assets/img/gallery/brunch_table.png') }}" alt="Crispy French toast on a brunch table" loading="lazy">
            </div></div>
            <div class="pad">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="badge rounded-pill badge-cat"><i class="bi bi-egg-fried"></i> Recipe</span>
                <span class="badge text-bg-warning-subtle border"><i class="bi bi-bookmark-star"></i> Featured</span>
              </div>
              <h2 class="h3 mb-2 clamp-2" data-title>Our Brioche French Toast, Café-Style</h2>
              <div class="meta small mb-3">
                <span><i class="bi bi-calendar2"></i> Apr 2, 2025</span><span>•</span>
                <span><i class="bi bi-hourglass-split"></i> 6 min read</span><span>•</span>
                <span><i class="bi bi-person-circle"></i> Team Crustella</span>
              </div>
              <p class="text-muted clamp-3 mb-3" data-snippet>Thick-cut brioche, orange zest, and a touch of mascarpone whip. Here’s the tested brunch formula we use on busy weekends — scaling tips included.</p>
              <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <span class="tag"><i class="bi bi-tag"></i> brioche</span>
                <span class="tag"><i class="bi bi-tag"></i> brunch</span>
                <span class="tag"><i class="bi bi-tag"></i> sweet</span>
              </div>
              <a href="/blog/brioche-french-toast" class="btn btn-primary">Read the recipe</a>
            </div>
          </article>

          <!-- Grid -->
          <div class="row row-cols-1 row-cols-md-2 g-4" id="postGrid">
            <div class="col post-wrap" data-category="coffee" data-tags="espresso,technique,crema">
              <article class="post-card w-100">
                <div class="skel"><div class="ratio ratio-16x9">
                  <img src="{{ asset('assets/img/gallery/latte_art.png') }}" alt="Close-up of latte art" loading="lazy">
                </div></div>
                <div class="pad d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge rounded-pill badge-cat"><i class="bi bi-cup-hot"></i> Coffee</span>
                  </div>
                  <h3 class="h5 mb-2 clamp-2" data-title>Dialing In Espresso: A 5-Step Morning Ritual</h3>
                  <div class="meta small mb-3"><span><i class="bi bi-calendar2"></i> Mar 24, 2025</span><span>•</span><span><i class="bi bi-hourglass-split"></i> 5 min</span></div>
                  <p class="text-muted clamp-3 mb-3" data-snippet>Grind size, dose, yield, and the tiny tweaks that unlock consistent shots — even when beans change.</p>
                  <div class="mt-auto"><a class="btn btn-light btn-sm" href="/blog/dialing-in-espresso">Read more</a></div>
                </div>
              </article>
            </div>

            <div class="col post-wrap" data-category="bakery" data-tags="sourdough,starter,hydration">
              <article class="post-card w-100">
                <div class="skel"><div class="ratio ratio-16x9">
                  <img src="{{ asset('assets/img/gallery/fresh_bread.png') }}" alt="Freshly baked sourdough loaves" loading="lazy">
                </div></div>
                <div class="pad d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge rounded-pill badge-cat"><i class="bi bi-bag-heart"></i> Bakery Tips</span>
                  </div>
                  <h3 class="h5 mb-2 clamp-2" data-title>Sourdough 101: Feeding Schedules That Actually Work</h3>
                  <div class="meta small mb-3"><span><i class="bi bi-calendar2"></i> Mar 17, 2025</span><span>•</span><span><i class="bi bi-hourglass-split"></i> 7 min</span></div>
                  <p class="text-muted clamp-3 mb-3" data-snippet>From 50% to 100% hydration: how we keep starters lively without wasting flour.</p>
                  <div class="mt-auto"><a class="btn btn-light btn-sm" href="/blog/sourdough-101">Read more</a></div>
                </div>
              </article>
            </div>

            <div class="col post-wrap" data-category="recipes" data-tags="cold brew,summer,brew">
              <article class="post-card w-100">
                <div class="skel"><div class="ratio ratio-16x9">
                  <img src="{{ asset('assets/img/dishes/item_9.png') }}" alt="Cold brew in a glass with ice" loading="lazy">
                </div></div>
                <div class="pad d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge rounded-pill badge-cat"><i class="bi bi-egg-fried"></i> Recipe</span>
                  </div>
                  <h3 class="h5 mb-2 clamp-2" data-title>12-Hour Cold Brew, Café-Smooth</h3>
                  <div class="meta small mb-3"><span><i class="bi bi-calendar2"></i> Mar 8, 2025</span><span>•</span><span><i class="bi bi-hourglass-split"></i> 4 min</span></div>
                  <p class="text-muted clamp-3 mb-3" data-snippet>Ratio, grind, and steep time for a chocolatey, low-acid brew at home.</p>
                  <div class="mt-auto"><a class="btn btn-light btn-sm" href="/blog/cold-brew-recipe">Read more</a></div>
                </div>
              </article>
            </div>

            <div class="col post-wrap" data-category="news" data-tags="awards,press,community">
              <article class="post-card w-100">
                <div class="skel"><div class="ratio ratio-16x9">
                  <img src="{{ asset('assets/img/gallery/outdoor_setting.png') }}" alt="Café outdoor seating" loading="lazy">
                </div></div>
                <div class="pad d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge rounded-pill badge-cat"><i class="bi bi-megaphone"></i> News</span>
                  </div>
                  <h3 class="h5 mb-2 clamp-2" data-title>We Won “People’s Choice” — Thank You, Old Town!</h3>
                  <div class="meta small mb-3"><span><i class="bi bi-calendar2"></i> Feb 28, 2025</span><span>•</span><span><i class="bi bi-hourglass-split"></i> 3 min</span></div>
                  <p class="text-muted clamp-3 mb-3" data-snippet>Your votes lifted us — here’s how we’re giving back this spring.</p>
                  <div class="mt-auto"><a class="btn btn-light btn-sm" href="/blog/peoples-choice">Read more</a></div>
                </div>
              </article>
            </div>

            <!-- Hidden demo posts (for Load more) -->
            <div class="col post-wrap d-none" data-category="coffee" data-tags="latte art,milk,training">
              <article class="post-card w-100">
                <div class="skel"><div class="ratio ratio-16x9">
                  <img src="{{ asset('assets/img/gallery/cakes.png') }}" alt="Milk pitcher and latte" loading="lazy">
                </div></div>
                <div class="pad d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge rounded-pill badge-cat"><i class="bi bi-cup-hot"></i> Coffee</span>
                  </div>
                  <h3 class="h5 mb-2 clamp-2" data-title>Latte Art Basics: Heart → Tulip → Rosetta</h3>
                  <div class="meta small mb-3"><span><i class="bi bi-calendar2"></i> Feb 19, 2025</span><span>•</span><span><i class="bi bi-hourglass-split"></i> 6 min</span></div>
                  <p class="text-muted clamp-3 mb-3" data-snippet>Milk texture checkpoints and pitcher angles for reliable pours.</p>
                  <div class="mt-auto"><a class="btn btn-light btn-sm" href="/blog/latte-art-basics">Read more</a></div>
                </div>
              </article>
            </div>

            <div class="col post-wrap d-none" data-category="bakery" data-tags="lamination,croissant,butter">
              <article class="post-card w-100">
                <div class="skel"><div class="ratio ratio-16x9">
                  <img src="{{ asset('assets/img/dishes/item_4.png') }}" alt="Butter croissant stack" loading="lazy">
                </div></div>
                <div class="pad d-flex flex-column">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge rounded-pill badge-cat"><i class="bi bi-bag-heart"></i> Bakery Tips</span>
                  </div>
                  <h3 class="h5 mb-2 clamp-2" data-title>Lamination 101: The Windowpane Test</h3>
                  <div class="meta small mb-3"><span><i class="bi bi-calendar2"></i> Feb 10, 2025</span><span>•</span><span><i class="bi bi-hourglass-split"></i> 8 min</span></div>
                  <p class="text-muted clamp-3 mb-3" data-snippet>Butter temp, dough temp, and how to rescue an over-warm fold.</p>
                  <div class="mt-auto"><a class="btn btn-light btn-sm" href="/blog/lamination-101">Read more</a></div>
                </div>
              </article>
            </div>
          </div>

          <div class="text-center mt-3">
            <button id="loadMore" class="btn btn-outline-primary" type="button"><i class="bi bi-plus-circle"></i> Load more posts</button>
          </div>

          <nav class="mt-4" aria-label="Blog pagination">
            <ul class="pagination justify-content-center gap-1">
              <li class="page-item disabled"><span class="page-link">Prev</span></li>
              <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
              <li class="page-item"><a class="page-link" href="/blog?page=2">2</a></li>
              <li class="page-item"><a class="page-link" href="/blog?page=3">3</a></li>
              <li class="page-item"><a class="page-link" href="/blog?page=2">Next</a></li>
            </ul>
          </nav>
        </div>

        <!-- Sidebar -->
        <aside class="col-lg-4 sidebar">
          <div class="widget mb-3">
            <h6 class="fw-bold mb-2">Search</h6>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="search" class="form-control" placeholder="Search blog…" aria-label="Search blog duplicate" oninput="document.getElementById('blogSearch').value=this.value; document.getElementById('blogSearch').dispatchEvent(new Event('input'));">
            </div>
          </div>

          <div class="widget mb-3">
            <h6 class="fw-bold mb-2">About the Journal</h6>
            <p class="text-muted small mb-0">Notes from our bar and bakery. We share what works (and what doesn’t) so your home bakes & brews shine.</p>
          </div>

          <div class="widget mb-3">
            <h6 class="fw-bold mb-2">Popular</h6>
            <div class="d-grid gap-2">
              <a class="mini-post link-underline link-underline-opacity-0" href="/blog/dialing-in-espresso">
                <img src="{{ asset('assets/img/gallery/latte_art.png') }}" alt="Latte art">
                <div><div class="fw-semibold small clamp-2">Dialing In Espresso</div><div class="small text-muted">5 min • Coffee</div></div>
              </a>
              <a class="mini-post link-underline link-underline-opacity-0" href="/blog/sourdough-101">
                <img src="{{ asset('assets/img/gallery/fresh_bread.png') }}" alt="Sourdough">
                <div><div class="fw-semibold small clamp-2">Sourdough 101</div><div class="small text-muted">7 min • Bakery</div></div>
              </a>
              <a class="mini-post link-underline link-underline-opacity-0" href="/blog/cold-brew-recipe">
                <img src="{{ asset('assets/img/dishes/item_9.png') }}" alt="Cold brew">
                <div><div class="fw-semibold small clamp-2">Cold Brew Recipe</div><div class="small text-muted">4 min • Recipe</div></div>
              </a>
            </div>
          </div>

          <div class="widget mb-3">
            <h6 class="fw-bold mb-2">Tags</h6>
            <div class="d-flex flex-wrap gap-2">
              <a class="tag" href="#" data-jumptag="espresso"><i class="bi bi-hash"></i> espresso</a>
              <a class="tag" href="#" data-jumptag="sourdough"><i class="bi bi-hash"></i> sourdough</a>
              <a class="tag" href="#" data-jumptag="lamination"><i class="bi bi-hash"></i> lamination</a>
              <a class="tag" href="#" data-jumptag="brunch"><i class="bi bi-hash"></i> brunch</a>
              <a class="tag" href="#" data-jumptag="cold brew"><i class="bi bi-hash"></i> cold brew</a>
            </div>
          </div>

          <div class="widget">
            <h6 class="fw-bold mb-2"><i class="bi bi-envelope-paper-heart"></i> Subscribe</h6>
            <p class="small text-muted mb-2">New posts, once a week. No spam.</p>
            <form id="blogNewsletter" class="d-flex gap-2">
              <input type="email" class="form-control" required placeholder="your@email.com">
              <button class="btn btn-primary" type="submit">Join</button>
            </form>
            <div id="blogNewsletterMsg" class="small mt-2" aria-live="polite"></div>
          </div>
        </aside>
      </div>
    </div>
  </main>

  <!-- ===== CTA ===== -->
  <section class="py-5" style="background:linear-gradient(135deg,#FFEBDD,#FFF6EE); border-top:1px solid var(--border); border-bottom:1px solid var(--border)">
    <div class="container text-center">
      <h2 class="fw-bold mb-2">Love café stories?</h2>
      <p class="mb-4 text-muted">Get weekly blog posts plus specials and early drops.</p>
      <div class="d-flex gap-2 justify-content-center">
        <a href="#blogNewsletter" class="btn btn-outline-primary btn-lg">Subscribe to the Journal</a>
        <a href="/#quick" class="btn btn-light btn-lg"><i class="bi bi-bag-heart"></i> Grab a pastry</a>
      </div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer class="site-footer pt-5">
    <div class="container pb-4">
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="p-3 h-100" style="background:var(--surface-2); border:1px solid var(--border); border-radius:16px;">
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
            <li class="mb-2"><a class="link-body-emphasis" href="/#quick">Quick order</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/#builder">Drink Builder</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/#subs">Subscriptions</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/#workshops">Workshops</a></li>
          </ul>
        </div>

        <div class="col-6 col-lg-3">
          <h6 class="fw-bold mb-3">Support</h6>
          <ul class="list-unstyled small m-0">
            <li class="mb-2"><a class="link-body-emphasis" href="#">Gift cards</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/#faq">Allergens</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/#press">Press</a></li>
            <li class="mb-2"><a class="link-body-emphasis" href="/#contact">Contact</a></li>
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
        <button class="btn btn-primary" id="checkoutBtn" disabled type="button">Checkout at counter</button>
        <button class="btn btn-light" id="clearCart" disabled type="button">Clear cart</button>
      </div>
    </div>
  </div>

  <!-- ===== SCRIPTS ===== -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      // Skeleton: mark loaded
      document.querySelectorAll('.skel img').forEach(img=>{
        const done=()=>img.parentElement.classList.add('loaded');
        if(img.complete) done(); else { img.addEventListener('load',done); img.addEventListener('error',done); }
      });

      // Navbar progress + year
      const nav=document.getElementById('siteNav');
      const progress=document.getElementById('scrollProgress');
      const setProgress=()=>{
        const st=document.documentElement.scrollTop||document.body.scrollTop;
        const h=document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const pct=Math.max(0, Math.min(1, st/h));
        progress.style.width=(pct*100).toFixed(2)+'%';
        nav?.classList.toggle('scrolled', window.scrollY>8);
      };
      setProgress(); window.addEventListener('scroll',setProgress);
      document.getElementById('year').textContent=new Date().getFullYear();

      // Search (nav)
      const searchBtn=document.getElementById('searchBtn');
      const searchWrap=document.getElementById('navSearchWrap');
      const searchClose=document.getElementById('searchClose');
      const bsCollapse=searchWrap ? new bootstrap.Collapse(searchWrap,{toggle:false}) : null;
      const openSearch=()=>{ bsCollapse?.show(); searchBtn?.setAttribute('aria-expanded','true'); setTimeout(()=>searchWrap?.querySelector('input')?.focus(),120); }
      const closeSearch=()=>{ bsCollapse?.hide(); searchBtn?.setAttribute('aria-expanded','false'); }
      searchBtn?.addEventListener('click',()=> searchWrap?.classList.contains('show') ? closeSearch() : openSearch());
      searchClose?.addEventListener('click', closeSearch);
      document.addEventListener('click',(e)=>{ if(!searchWrap?.classList.contains('show')) return; if(!searchWrap.contains(e.target)&&e.target!==searchBtn) closeSearch(); });

      // Offcanvas close on link
      const offcanvasEl=document.getElementById('offcanvasNav');
      offcanvasEl?.querySelectorAll('[data-close]').forEach(a=>a.addEventListener('click',()=> bootstrap.Offcanvas.getInstance(offcanvasEl)?.hide()));

      // Theme toggle (desktop + mobile)
      const themeBtn=document.getElementById('themeBtn'); const themeBtnMobile=document.getElementById('themeBtnMobile');
      const syncIcon=(el)=>{ if(!el) return; el.innerHTML=document.documentElement.getAttribute('data-bs-theme')==='dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon-stars"></i>'; };
      const toggleTheme=()=>{ const next=document.documentElement.getAttribute('data-bs-theme')==='dark'?'light':'dark'; document.documentElement.setAttribute('data-bs-theme',next); try{localStorage.setItem('theme',next);}catch(e){} syncIcon(themeBtn); syncIcon(themeBtnMobile); };
      syncIcon(themeBtn); syncIcon(themeBtnMobile); themeBtn?.addEventListener('click',toggleTheme); themeBtnMobile?.addEventListener('click',toggleTheme);

      // Blog filtering & search
      const chips=[...document.querySelectorAll('.chip-cat')];
      const gridPosts=[...document.querySelectorAll('#postGrid .post-wrap')];
      const featured=document.getElementById('featuredPost');
      const searchInput=document.getElementById('blogSearch');
      const resultCount=document.getElementById('resultCount');

      let activeCat='all';
      const norm=t=> (t||'').toLowerCase().trim();
      const matches=(el,q)=>{
        if(!q) return true;
        const title=el.querySelector('[data-title]')?.textContent||'';
        const snip = el.querySelector('[data-snippet]')?.textContent||'';
        const tags = el.dataset.tags || '';
        return (title+' '+snip+' '+tags).toLowerCase().includes(q);
      };
      const matchesCat=(el,cat)=> cat==='all' ? true : (el.dataset.category||'').toLowerCase()===cat;
      const show=(el,ok)=> el.classList.toggle('d-none', !ok);

      function applyFilters(){
        const q=norm(searchInput?.value);
        let shown=0;

        gridPosts.forEach(w=>{
          const ok = matchesCat(w, activeCat) && matches(w,q);
          show(w, ok);
          if(ok) shown++;
        });

        if(featured){
          const okF = matchesCat(featured, activeCat) && matches(featured,q);
          show(featured, okF);
          if(okF) shown++;
        }

        resultCount.textContent = shown ? shown + ' post' + (shown>1?'s':'') + ' shown' : 'No posts found';
      }

      chips.forEach(ch=>{
        ch.addEventListener('click', ()=>{
          chips.forEach(c=>{ c.classList.remove('active'); c.setAttribute('aria-pressed','false'); });
          ch.classList.add('active'); ch.setAttribute('aria-pressed','true');
          activeCat=(ch.dataset.filter||'all').toLowerCase();
          applyFilters();
        });
      });
      searchInput?.addEventListener('input', applyFilters);
      applyFilters();

      // Tag shortcuts (sidebar)
      document.querySelectorAll('[data-jumptag]').forEach(t=>{
        t.addEventListener('click',(e)=>{
          e.preventDefault();
          const val=t.dataset.jumptag||'';
          searchInput.value=val;
          searchInput.dispatchEvent(new Event('input'));
          window.scrollTo({ top: document.querySelector('main').offsetTop-80, behavior:'smooth' });
        });
      });

      // Load more (unhide a few each click)
      const loadBtn=document.getElementById('loadMore');
      loadBtn?.addEventListener('click', ()=>{
        const hidden=[...document.querySelectorAll('#postGrid .post-wrap.d-none')].slice(0,4);
        if(hidden.length===0){ loadBtn.disabled=true; loadBtn.textContent='No more posts'; return; }
        hidden.forEach(el=> el.classList.remove('d-none'));
        applyFilters();
      });

      // Blog newsletter demo
      const bForm=document.getElementById('blogNewsletter'); const bMsg=document.getElementById('blogNewsletterMsg');
      bForm?.addEventListener('submit',(e)=>{ e.preventDefault(); bMsg.textContent='Thanks! You‘re on the list.'; bMsg.className='small mt-2 text-success'; bForm.reset(); setTimeout(()=>{ bMsg.textContent=''; bMsg.className='small mt-2'; }, 3500); });

      // Footer newsletter demo
      const nForm=document.getElementById('newsletterForm'); const nMsg=document.getElementById('newsletterMsg');
      nForm?.addEventListener('submit',(e)=>{ e.preventDefault(); nMsg.textContent='Thanks! You’re subscribed.'; nMsg.className='small mt-2 text-success'; nForm.reset(); setTimeout(()=>{ nMsg.textContent=''; nMsg.className='small mt-2'; }, 3500); });

      // Back to top
      document.getElementById('toTopBtn')?.addEventListener('click',(e)=>{ e.preventDefault(); window.scrollTo({ top:0, behavior:'smooth' }); });

      // Minimal cart demo (kept to avoid broken references)
      const cart=[]; const cartLines=document.getElementById('cartLines'); const cartEmpty=document.getElementById('cartEmpty'); const cartTotal=document.getElementById('cartTotal'); const cartCount=document.getElementById('cartCount'); const checkoutBtn=document.getElementById('checkoutBtn'); const clearCart=document.getElementById('clearCart');
      const money=n=>'$'+(Math.round(n*100)/100).toFixed(2);
      function renderCart(){
        cartLines.innerHTML=''; let total=0;
        cart.forEach((line,i)=>{ total += line.price*line.qty;
          const row=document.createElement('div'); row.className='d-flex align-items-center justify-content-between gap-2 py-2 border-bottom'; row.style.borderColor='var(--border)';
          row.innerHTML=`<div class="small"><strong>${line.name}</strong></div><div class="d-flex align-items-center gap-2"><span class="text-muted small">x${line.qty}</span><strong>${money(line.price*line.qty)}</strong><button class="btn btn-light btn-sm" aria-label="Remove"><i class="bi bi-x"></i></button></div>`;
          row.querySelector('button')?.addEventListener('click',()=>{ cart.splice(i,1); updateCart(); });
          cartLines.appendChild(row);
        });
        cartEmpty.style.display=cart.length?'none':'block';
        cartTotal.textContent=money(total); cartCount.textContent=String(cart.length);
        checkoutBtn.disabled=cart.length===0; clearCart.disabled=cart.length===0;
      }
      const updateCart=()=>renderCart();
      clearCart?.addEventListener('click',()=>{ cart.length=0; updateCart(); });
      checkoutBtn?.addEventListener('click',()=>{ alert('Order saved. Pay at counter.'); cart.length=0; updateCart(); });
    });
  </script>
</body>
</html>
