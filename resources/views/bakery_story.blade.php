<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">
<head>
  <!-- ===== META ===== -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Crustella — Our Story: from a tiny oven to a neighborhood ritual." />
  <meta name="theme-color" content="#C46E3A" />
  <title>Our Story — Crustella</title>
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
       Warm café palette + creamy UI
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
    *{min-width:0} /* prevent flex overflow */
    img{display:block;max-width:100%;height:auto}
    .ratio>img,.ratio>picture>img{width:100%;height:100%;object-fit:cover}
    h1,h2,h3,h4,h5,h6{ font-family:'Inter',sans-serif; letter-spacing:-.015em; font-weight:800 }
    .text-muted{ color:var(--muted)!important }

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

    /* Skeleton shimmer */
    .skel{ position:relative; overflow:hidden; border-radius:14px; background:#eee }
    [data-bs-theme="dark"] .skel{ background:#1a1f26 }
    .skel::before{ content:""; position:absolute; inset:0; background:linear-gradient(90deg,transparent,rgba(255,255,255,.25),transparent); animation:shimmer 1.35s linear infinite }
    .skel.loaded::before{ opacity:0; visibility:hidden }
    @keyframes shimmer{ 0%{transform:translateX(-100%)} 100%{transform:translateX(100%)} }

    /* Nav utility + navbar */
    .nav-utility{ border-bottom:1px solid var(--border); background:linear-gradient(90deg,#FFF1E6,#FFEADB) }
    [data-bs-theme="dark"] .nav-utility{ background:linear-gradient(90deg,#171c22,#12171e) }
    .nav-utility .link-utility{ color:var(--cocoa); text-decoration:none }
    .nav-utility .link-utility:hover{ text-decoration:underline }

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
    .nav-elevated .navbar-toggler-icon{
      background-size:100% 100%;
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='%235A3E2B' stroke-linecap='round' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
    [data-bs-theme="dark"] .nav-elevated .navbar-toggler-icon{
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='%23E6E6E6' stroke-linecap='round' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    /* Search under nav */
    .nav-search{ border-top:1px solid var(--border); background:rgba(255,255,255,.86); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px) }
    [data-bs-theme="dark"] .nav-search{ background:rgba(16,19,24,.85) }
    .nav-search-form{ display:flex; align-items:center; gap:.6rem; padding:.75rem 0 }
    .nav-search-input{ border-radius:12px; border:1px solid var(--border) }

    /* ============================================================
       HERO
    ============================================================ */
    .story-hero{ position:relative; isolation:isolate; border-bottom:1px solid var(--border); background:var(--bg) }
    .story-hero .media-wrap{ border-radius:22px; overflow:hidden; box-shadow:var(--shadow-2) }
    .story-kicker{ display:inline-flex; gap:.5rem; align-items:center; background:#fff; border:1px solid var(--border); border-radius:999px; padding:.4rem .7rem; font-weight:700 }
    [data-bs-theme="dark"] .story-kicker{ background:#0f141c }

    /* Sections */
    .section-card{
      background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:var(--pad);
    }
    .value-card,.team-card,.stat-card{ background:var(--surface); border:1px solid var(--border); border-radius:16px }
    .value-card .icon, .stat-card .icon{ width:42px; height:42px; display:grid; place-items:center; border-radius:10px; background:var(--surface-2); border:1px solid var(--border) }
    .team-card .photo{ border-bottom:1px solid var(--border) }
    .team-card .photo .ratio{ border-top-left-radius:16px; border-top-right-radius:16px; overflow:hidden }
    .team-card .pad{ padding:var(--pad) }
    .team-card:hover{ box-shadow:var(--shadow-1); transform:translateY(-2px); transition:.18s; border-color:rgba(196,110,58,.35) }

    /* Timeline */
    .timeline{ position:relative; padding-left:28px }
    .timeline::before{ content:""; position:absolute; left:12px; top:.2rem; bottom:.2rem; width:2px; background:var(--border) }
    .tl-item{ position:relative; margin-bottom:16px }
    .tl-dot{ position:absolute; left:5px; top:.35rem; width:14px; height:14px; border-radius:50%; background:var(--accent); box-shadow:0 0 0 3px rgba(196,110,58,.18) }
    .tl-card{ background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:12px 14px }
    .tl-year{ font-weight:800; font-family:'Inter',sans-serif }

    /* Testimonials */
    .quote{ background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:var(--pad) }
    .quote i{ opacity:.9 }

    /* Press band */
    .press{ background:var(--surface-2); border-top:1px solid var(--border); border-bottom:1px solid var(--border) }
    .press img{ height:44px; border-radius:10px; border:1px solid var(--border); box-shadow:0 .35rem .9rem rgba(0,0,0,.06); background:#fff; object-fit:cover }

    /* CTA / Footer */
    .cta{
      background:linear-gradient(135deg,#FFEBDD,#FFF6EE);
      border-top:1px solid var(--border); border-bottom:1px solid var(--border); padding:64px 0
    }
    [data-bs-theme="dark"] .cta{ background:linear-gradient(135deg,#141b23,#0f141c) }
    .site-footer{ background:var(--surface); border-top:1px solid var(--border) }

    @media (prefers-reduced-motion: reduce){
      .team-card:hover{ transform:none }
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
          <li class="nav-item"><a class="nav-link" href="/#builder">Drink Builder</a></li>
          <li class="nav-item"><a class="nav-link" href="/#subs">Subscriptions</a></li>
          <li class="nav-item"><a class="nav-link" href="/#workshops">Workshops</a></li>
          <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
          <li class="nav-item"><a class="nav-link active" aria-current="page" href="/story">Our Story</a></li>

          <li class="nav-item">
            <button class="btn btn-outline-primary" id="searchBtn" aria-expanded="false" aria-controls="navSearchWrap" aria-label="Open search">
              <i class="bi bi-search"></i>
            </button>
          </li>
          <li class="nav-item">
            <button id="themeBtn" class="btn btn-outline-primary" aria-label="Toggle dark mode"><i class="bi bi-moon-stars"></i></button>
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
        <a href="/blog" class="btn btn-light" data-close><i class="bi bi-journal-text"></i> Blog</a>
        <a href="/story" class="btn btn-light" data-close><i class="bi bi-heart"></i> Our Story</a>
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

  <!-- ===== HERO ===== -->
  <header class="story-hero py-4">
    <div class="container">
      <nav class="small text-muted" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a class="text-reset text-decoration-none" href="/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Our Story</li>
        </ol>
      </nav>

      <div class="row g-4 align-items-stretch mt-1">
        <div class="col-lg-6">
          <span class="story-kicker"><i class="bi bi-heart-fill text-danger"></i> From a tiny oven to a neighborhood ritual</span>
          <h1 class="display-5 mt-2 mb-2">Our Story</h1>
          <p class="lead text-muted">Crustella began with 3 trays, a borrowed mixer, and a promise: warm bakes and honest coffee that make your day a little lighter.</p>
          <div class="d-flex flex-wrap gap-2 mt-2">
            <a href="/#contact" class="btn btn-primary btn-lg"><i class="bi bi-geo-alt"></i> Visit us</a>
            <a href="/blog" class="btn btn-outline-primary btn-lg"><i class="bi bi-journal-text"></i> Read the journal</a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="skel media-wrap">
            <div class="ratio ratio-21x9">
              <img src="{{ asset('assets/img/gallery/bakery.png') }}" alt="Crustella bakehouse early morning" loading="eager" fetchpriority="high">
            </div>
          </div>
          <p class="small text-muted mt-2">All photos are placeholders—replace with your licensed images.</p>
        </div>
      </div>
    </div>
  </header>

  <!-- ===== ORIGIN + TIMELINE ===== -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="section-card h-100">
            <h2 class="mb-2">How it started</h2>
            <p>Before sunrise, we proofed dough in a rented commissary and hauled trays to a pop-up window on Baker Street. Neighbors waited with thermoses; we learned names, allergies, and favorite orders.</p>
            <p>We still bake like a small team: a little obsessive, a lot heart. Every croissant is hand-laminated; every espresso shot is dialed for the day’s humidity.</p>
            <div class="ratio ratio-16x9 mt-3">
              <img src="{{ asset('assets/img/gallery/fresh_bread.png') }}" alt="Shaping loaves at the bakehouse" loading="lazy">
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="section-card h-100">
            <h2 class="mb-2">Milestones</h2>
            <div class="timeline">
              <div class="tl-item">
                <span class="tl-dot"></span>
                <div class="tl-card">
                  <div class="tl-year">2019</div>
                  First pop-up window sells out in 90 minutes.
                </div>
              </div>
              <div class="tl-item">
                <span class="tl-dot"></span>
                <div class="tl-card">
                  <div class="tl-year">2020</div>
                  Opened our Old Town café; started “pay-it-forward” coffees.
                </div>
              </div>
              <div class="tl-item">
                <span class="tl-dot"></span>
                <div class="tl-card">
                  <div class="tl-year">2022</div>
                  Launched workshops & subscriptions for beans and pastry boxes.
                </div>
              </div>
              <div class="tl-item">
                <span class="tl-dot"></span>
                <div class="tl-card">
                  <div class="tl-year">2024</div>
                  Solar-assisted ovens; 30% energy reduction.
                </div>
              </div>
              <div class="tl-item">
                <span class="tl-dot"></span>
                <div class="tl-card">
                  <div class="tl-year">Today</div>
                  A neighborhood ritual — and still learning, daily.
                </div>
              </div>
            </div>
            <div class="small text-muted mt-2">We’re proudly independent and community-funded.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== VALUES ===== -->
  <section class="py-5" style="background:var(--surface)">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="mb-1">What we value</h2>
        <p class="text-muted m-0">The decisions behind every cup and crumb.</p>
      </div>

      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
        <div class="col d-flex">
          <div class="value-card p-3 w-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="icon"><i class="bi bi-magic"></i></span>
              <strong>Craft</strong>
            </div>
            <p class="small text-muted mb-0">Hand-laminated pastries, small-batch roasts, details that matter.</p>
          </div>
        </div>
        <div class="col d-flex">
          <div class="value-card p-3 w-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="icon"><i class="bi bi-recycle"></i></span>
              <strong>Sourcing</strong>
            </div>
            <p class="small text-muted mb-0">Transparent suppliers and seasonal menus. We pay farmers fairly.</p>
          </div>
        </div>
        <div class="col d-flex">
          <div class="value-card p-3 w-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="icon"><i class="bi bi-people"></i></span>
              <strong>Hospitality</strong>
            </div>
            <p class="small text-muted mb-0">Everyone’s welcome. Allergens noted, pronouns respected.</p>
          </div>
        </div>
        <div class="col d-flex">
          <div class="value-card p-3 w-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="icon"><i class="bi bi-sun"></i></span>
              <strong>Sustainability</strong>
            </div>
            <p class="small text-muted mb-0">Compostables, energy-light ovens, and zero-waste pastries.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== TEAM ===== -->
  <section class="py-5">
    <div class="container">
      <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-3">
        <div>
          <h2 class="m-0">Meet the team</h2>
          <p class="text-muted m-0">Small team, big care.</p>
        </div>
        <a href="/#workshops" class="btn btn-light btn-sm"><i class="bi bi-calendar-event"></i> Join a workshop</a>
      </div>

      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <div class="col d-flex">
          <div class="team-card w-100">
            <div class="photo">
              <div class="ratio ratio-1x1">
                <img src="{{ asset('assets/img/gallery/latte_art.png') }}" alt="Ava — Head Barista" loading="lazy">
              </div>
            </div>
            <div class="pad">
              <div class="fw-bold">Ava</div>
              <div class="small text-muted mb-2">Head Barista</div>
              <p class="small mb-0">Dial-in whisperer. When the queue’s long, she’s faster than gravity.</p>
            </div>
          </div>
        </div>
        <div class="col d-flex">
          <div class="team-card w-100">
            <div class="photo">
              <div class="ratio ratio-1x1">
                <img src="{{ asset('assets/img/gallery/pastry_detail.png') }}" alt="Milo — Pastry Lead" loading="lazy">
              </div>
            </div>
            <div class="pad">
              <div class="fw-bold">Milo</div>
              <div class="small text-muted mb-2">Pastry Lead</div>
              <p class="small mb-0">Lamination geek. The croissant layers? 27 sheets of joy.</p>
            </div>
          </div>
        </div>
        <div class="col d-flex">
          <div class="team-card w-100">
            <div class="photo">
              <div class="ratio ratio-1x1">
                <img src="{{ asset('assets/img/gallery/brunch_table.png') }}" alt="Rey — Operations" loading="lazy">
              </div>
            </div>
            <div class="pad">
              <div class="fw-bold">Rey</div>
              <div class="small text-muted mb-2">Operations</div>
              <p class="small mb-0">Keeps the line humming and the ovens honest.</p>
            </div>
          </div>
        </div>
        <div class="col d-flex">
          <div class="team-card w-100">
            <div class="photo">
              <div class="ratio ratio-1x1">
                <img src="{{ asset('assets/img/gallery/outdoor_setting.png') }}" alt="Jules — Community" loading="lazy">
              </div>
            </div>
            <div class="pad">
              <div class="fw-bold">Jules</div>
              <div class="small text-muted mb-2">Community</div>
              <p class="small mb-0">Runs pay-it-forward and our school bake days.</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ===== STATS ===== -->
  <section class="py-5" style="background:var(--surface)">
    <div class="container">
      <div class="row row-cols-1 row-cols-md-3 g-3">
        <div class="col d-flex">
          <div class="stat-card p-3 w-100">
            <div class="d-flex align-items-center gap-2">
              <span class="icon"><i class="bi bi-cup-hot"></i></span>
              <div>
                <div class="h4 m-0"><span class="count" data-target="250000">0</span>+</div>
                <div class="small text-muted">Cups poured</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col d-flex">
          <div class="stat-card p-3 w-100">
            <div class="d-flex align-items-center gap-2">
              <span class="icon"><i class="bi bi-emoji-smile"></i></span>
              <div>
                <div class="h4 m-0"><span class="count" data-target="120000">0</span>+</div>
                <div class="small text-muted">Pastries folded</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col d-flex">
          <div class="stat-card p-3 w-100">
            <div class="d-flex align-items-center gap-2">
              <span class="icon"><i class="bi bi-lightning-charge"></i></span>
              <div>
                <div class="h4 m-0">-<span class="count" data-target="30">0</span>%</div>
                <div class="small text-muted">Energy per bake (since 2024)</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== TESTIMONIALS ===== -->
  <section class="py-5">
    <div class="container">
      <div class="text-center mb-3">
        <h2 class="mb-1">What neighbors say</h2>
        <p class="text-muted m-0">Thank you for keeping us honest (and busy).</p>
      </div>

      <div id="quotes" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6500">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row g-3">
              <div class="col-md-4"><div class="quote h-100"><i class="bi bi-chat-right-quote"></i> “The croissants taste like vacation.” <div class="small text-muted mt-1">— Lila</div></div></div>
              <div class="col-md-4"><div class="quote h-100"><i class="bi bi-chat-right-quote"></i> “Espresso is dialed in, every time.” <div class="small text-muted mt-1">— Noor</div></div></div>
              <div class="col-md-4"><div class="quote h-100"><i class="bi bi-chat-right-quote"></i> “Workshops were the best date night.” <div class="small text-muted mt-1">— Tom</div></div></div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row g-3">
              <div class="col-md-4"><div class="quote h-100"><i class="bi bi-chat-right-quote"></i> “Pay-it-forward coffee changed my week.” <div class="small text-muted mt-1">— Ren</div></div></div>
              <div class="col-md-4"><div class="quote h-100"><i class="bi bi-chat-right-quote"></i> “Try the French toast. Life choice.” <div class="small text-muted mt-1">— Alex</div></div></div>
              <div class="col-md-4"><div class="quote h-100"><i class="bi bi-chat-right-quote"></i> “Cozy vibes, quick service.” <div class="small text-muted mt-1">— Mei</div></div></div>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-center gap-2 mt-3">
          <button class="btn btn-light btn-sm" type="button" data-bs-target="#quotes" data-bs-slide="prev" aria-label="Prev"><i class="bi bi-chevron-left"></i></button>
          <button class="btn btn-primary btn-sm" type="button" data-bs-target="#quotes" data-bs-slide="next" aria-label="Next"><i class="bi bi-chevron-right"></i></button>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== PRESS & PARTNERS ===== -->
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

  <!-- ===== CTA ===== -->
  <section class="cta text-center">
    <div class="container">
      <h2 class="fw-bold mb-2">Come by for a warm bake</h2>
      <p class="mb-4 text-muted">We’re on Baker St, Old Town • Open 7:00–22:00</p>
      <div class="d-flex gap-2 justify-content-center">
        <a href="/#contact" class="btn btn-outline-primary btn-lg"><i class="bi bi-geo"></i> Get directions</a>
        <a href="/blog" class="btn btn-light btn-lg"><i class="bi bi-journal-text"></i> Read the journal</a>
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

  <!-- ===== SCRIPTS ===== -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      // Image skeleton remove
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

      // Search open/close
      const searchBtn=document.getElementById('searchBtn');
      const searchWrap=document.getElementById('navSearchWrap');
      const searchClose=document.getElementById('searchClose');
      const bsCollapse=searchWrap ? new bootstrap.Collapse(searchWrap,{toggle:false}) : null;
      const openSearch=()=>{ bsCollapse?.show(); searchBtn?.setAttribute('aria-expanded','true'); setTimeout(()=>searchWrap?.querySelector('input')?.focus(),120); }
      const closeSearch=()=>{ bsCollapse?.hide(); searchBtn?.setAttribute('aria-expanded','false'); }
      searchBtn?.addEventListener('click',()=> searchWrap?.classList.contains('show') ? closeSearch() : openSearch());
      searchClose?.addEventListener('click', closeSearch);
      document.addEventListener('click',(e)=>{ if(!searchWrap?.classList.contains('show')) return; if(!searchWrap.contains(e.target) && e.target!==searchBtn) closeSearch(); });

      // Offcanvas close on link
      const offcanvasEl=document.getElementById('offcanvasNav');
      offcanvasEl?.querySelectorAll('[data-close]').forEach(a=>a.addEventListener('click',()=> bootstrap.Offcanvas.getInstance(offcanvasEl)?.hide()));

      // Theme toggle (desktop + mobile)
      const themeBtn=document.getElementById('themeBtn'); const themeBtnMobile=document.getElementById('themeBtnMobile');
      const syncIcon=(el)=>{ if(!el) return; el.innerHTML=document.documentElement.getAttribute('data-bs-theme')==='dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon-stars"></i>'; };
      const toggleTheme=()=>{ const next=document.documentElement.getAttribute('data-bs-theme')==='dark'?'light':'dark'; document.documentElement.setAttribute('data-bs-theme',next); try{localStorage.setItem('theme',next);}catch(e){} syncIcon(themeBtn); syncIcon(themeBtnMobile); };
      syncIcon(themeBtn); syncIcon(themeBtnMobile); themeBtn?.addEventListener('click',toggleTheme); themeBtnMobile?.addEventListener('click',toggleTheme);

      // Count-up stats (respect reduced motion)
      const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      const counters=[...document.querySelectorAll('.count')];
      if(counters.length && !prefersReduced){
        const io=new IntersectionObserver((entries)=>{
          entries.forEach(en=>{
            if(!en.isIntersecting) return;
            const el=en.target; const target=parseInt(el.dataset.target||'0',10)||0;
            let cur=0; const steps=48; const inc=target/steps; const dur=900/steps;
            const tick=()=>{ cur+=inc; if(cur>=target){ el.textContent=target.toLocaleString(); return; }
              el.textContent=Math.round(cur).toLocaleString(); setTimeout(tick, dur); };
            tick(); io.unobserve(el);
          });
        },{threshold:.3});
        counters.forEach(c=>io.observe(c));
      }else{
        counters.forEach(c=>{ c.textContent = (parseInt(c.dataset.target||'0',10)||0).toLocaleString(); });
      }

      // Back to top
      document.getElementById('toTopBtn')?.addEventListener('click',(e)=>{ e.preventDefault(); window.scrollTo({ top:0, behavior:'smooth' }); });

      // Newsletter demo
      const nForm=document.getElementById('newsletterForm'); const nMsg=document.getElementById('newsletterMsg');
      nForm?.addEventListener('submit',(e)=>{ e.preventDefault(); nMsg.textContent='Thanks! You’re subscribed.'; nMsg.className='small mt-2 text-success'; nForm.reset(); setTimeout(()=>{ nMsg.textContent=''; nMsg.className='small mt-2'; }, 3500); });
    });
  </script>
</body>
</html>
