<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">
<head>
  <!-- ===== META ===== -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Crustella — Article: Our Brioche French Toast, Café-Style." />
  <meta name="theme-color" content="#C46E3A" />
  <title>Our Brioche French Toast, Café-Style — Crustella Journal</title>
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
       Post Hero
    ============================================================ */
    .post-hero{ position:relative; isolation:isolate; border-bottom:1px solid var(--border); background:var(--bg) }
    .post-hero .media-wrap{ border-radius:22px; overflow:hidden; box-shadow:var(--shadow-2) }
    .post-meta{ display:flex; gap:.8rem; flex-wrap:wrap; color:var(--muted) }
    .badge-cat{ background:rgba(196,110,58,.12); color:var(--accent); border:1px solid var(--border) }

    /* ============================================================
       Prose (article body)
    ============================================================ */
    .prose{ font-size:1.05rem; line-height:1.75 }
    .prose h2{ margin-top:2rem; margin-bottom:.75rem; font-size:1.6rem }
    .prose h3{ margin-top:1.5rem; margin-bottom:.5rem; font-size:1.25rem }
    .prose p{ margin:.5rem 0 }
    .prose hr{ border-color:var(--border); margin:1.5rem 0 }
    .prose blockquote{
      border-left:4px solid var(--accent); padding:.6rem 1rem; background:var(--surface-2);
      border-radius:12px; margin:1rem 0;
    }
    .prose pre{ padding:1rem; background:var(--surface-2); border:1px solid var(--border); border-radius:12px; overflow:auto }
    .prose code{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; font-size:.95em }
    .prose figure{ margin:1.25rem 0 }
    .prose figcaption{ color:var(--muted); font-size:.9rem; margin-top:.4rem }
    .callout{
      border:1px solid var(--border); background:var(--surface); border-radius:16px; padding:var(--pad);
    }
    .ingredients{
      background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:var(--pad);
    }

    /* TOC */
    .toc{
      position:sticky; top:92px; /* under sticky nav */
      background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:var(--pad);
    }
    .toc .toc-list{ list-style:none; padding-left:0; margin:0 }
    .toc a{ text-decoration:none; color:inherit; display:block; padding:.25rem 0; border-radius:8px }
    .toc a.active{ color:var(--accent-700); background:rgba(196,110,58,.10) }
    .toc .lvl-2{ padding-left:.25rem }
    .toc .lvl-3{ padding-left:1rem; font-size:.95em }

    /* Share bar */
    .share .btn{ border-radius:12px }

    /* Author box */
    .author{
      background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:var(--pad);
    }
    .author img{ width:56px; height:56px; border-radius:50%; object-fit:cover; border:1px solid var(--border) }

    /* Related posts */
    .post-card{
      background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden;
      transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
      height:100%; display:flex; flex-direction:column;
    }
    .post-card:hover{ transform:translateY(-2px); box-shadow:var(--shadow-1); border-color:rgba(196,110,58,.35) }
    .post-card .pad{ padding:var(--pad) }

    /* Footer */
    .site-footer{ background:var(--surface); border-top:1px solid var(--border) }

    @media (max-width: 991.98px){
      .toc{ position:static }
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

  <!-- ===== POST HERO ===== -->
  <header class="post-hero py-4">
    <div class="container">
      <nav class="small text-muted" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a class="text-reset text-decoration-none" href="/">Home</a></li>
          <li class="breadcrumb-item"><a class="text-reset text-decoration-none" href="/blog">Blog</a></li>
          <li class="breadcrumb-item active" aria-current="page">Our Brioche French Toast, Café-Style</li>
        </ol>
      </nav>

      <div class="row g-4 align-items-stretch mt-1">
        <div class="col-lg-7">
          <span class="badge rounded-pill badge-cat"><i class="bi bi-egg-fried"></i> Recipe</span>
          <h1 class="display-5 mt-2 mb-2">Our Brioche French Toast, Café-Style</h1>
          <div class="post-meta">
            <span><i class="bi bi-person-circle"></i> Team Crustella</span>
            <span>•</span>
            <span><i class="bi bi-calendar2"></i> Apr 2, 2025</span>
            <span>•</span>
            <span><i class="bi bi-stopwatch"></i> <span id="readTime">6</span> min read</span>
            <span>•</span>
            <span><i class="bi bi-chat"></i> 3 comments</span>
          </div>

          <div class="d-flex flex-wrap gap-2 mt-3 share">
            <button class="btn btn-light btn-sm" id="copyLink"><i class="bi bi-link-45deg"></i> Copy link</button>
            <a class="btn btn-outline-primary btn-sm" id="twShare" target="_blank" rel="noopener"><i class="bi bi-twitter-x"></i> Share</a>
            <a class="btn btn-outline-primary btn-sm" id="fbShare" target="_blank" rel="noopener"><i class="bi bi-facebook"></i> Share</a>
            <button class="btn btn-light btn-sm" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="skel media-wrap">
            <div class="ratio ratio-16x9">
              <img src="{{ asset('assets/img/gallery/brunch_table.png') }}" alt="Brioche French toast with berries and mascarpone" loading="eager" fetchpriority="high">
            </div>
          </div>
          <p class="small text-muted mt-2">All photos are placeholders—replace with your licensed images.</p>
        </div>
      </div>
    </div>
  </header>

  <!-- ===== CONTENT + TOC ===== -->
  <main class="py-5">
    <div class="container">
      <div class="row g-4">
        <!-- Article -->
        <article id="article" class="col-lg-8 prose">
          <p class="lead">Thick-cut brioche, orange zest, and a mascarpone whip — this is our café version of weekend French toast. It’s fast enough for service and lush enough for a slow brunch at home.</p>

          <figure id="mise">
            <div class="skel"><div class="ratio ratio-21x9">
              <img src="{{ asset('assets/img/gallery/pastry_detail.png') }}" alt="Mise en place for brioche French toast" loading="lazy">
            </div></div>
            <figcaption>Mise en place — brioche, eggs, cream, zest, and maple.</figcaption>
          </figure>

          <div class="ingredients" id="ingredients">
            <h2>Ingredients (serves 4)</h2>
            <div class="row g-3">
              <div class="col-sm-6">
                <ul class="mb-0">
                  <li>8 slices brioche (thick-cut)</li>
                  <li>4 large eggs</li>
                  <li>250 ml whole milk</li>
                  <li>60 ml heavy cream</li>
                  <li>2 tbsp sugar</li>
                </ul>
              </div>
              <div class="col-sm-6">
                <ul class="mb-0">
                  <li>1 tsp vanilla extract</li>
                  <li>Zest of 1 orange</li>
                  <li>Butter, for the pan</li>
                  <li>Maple syrup, berries</li>
                  <li>Mascarpone (optional)</li>
                </ul>
              </div>
            </div>
          </div>

          <h2 id="method">Method</h2>
          <ol>
            <li>Whisk eggs, milk, cream, sugar, vanilla, and zest in a shallow tray.</li>
            <li>Heat a non-stick pan on medium; add a knob of butter.</li>
            <li>Soak brioche 10–15 seconds per side; it should feel heavy but not falling apart.</li>
            <li>Cook 2–3 minutes per side until deeply golden. Keep warm in a 90°C oven.</li>
            <li>Serve with mascarpone, berries, and warm maple.</li>
          </ol>

          <div class="callout" id="scaling">
            <h3>Scaling for a crowd</h3>
            <p>Use a griddle and keep a <em>holding rack</em> in a low oven. Mix custard in batches (it thickens as it sits). For service, we cut slices diagonally and stack.</p>
          </div>

          <h2 id="tips">Tips & troubleshooting</h2>
          <ul>
            <li><strong>Soggy centers?</strong> Shorten the soak or dry brioche in a low oven for 5–8 minutes first.</li>
            <li><strong>Pale color?</strong> Pan too cool — listen for a gentle sizzle and use butter + a touch of oil.</li>
            <li><strong>Flavor pop:</strong> A micro-grate of zest right before serving wakes up the plate.</li>
          </ul>

          <figure id="plating">
            <div class="skel"><div class="ratio ratio-16x9">
              <img src="{{ asset('assets/img/dishes/item_7.png') }}" alt="Plated French toast with berries" loading="lazy">
            </div></div>
            <figcaption>Finish with a dusting of sugar and a ribbon of maple.</figcaption>
          </figure>

          <hr>

          <h2 id="faq">FAQ</h2>
          <p><strong>Can I make it dairy-free?</strong> Yes — use oat milk, skip the cream, and cook with neutral oil. Texture will be slightly lighter.</p>
          <p><strong>Best bread?</strong> Rich, tight-crumb brioche or challah. Day-old loaves are perfect.</p>

          <div class="d-flex flex-wrap align-items-center gap-2 mt-4">
            <span class="badge rounded-pill text-bg-warning-subtle border"><i class="bi bi-bookmark-star"></i> Featured recipe</span>
            <span class="badge rounded-pill bg-body-tertiary border"><i class="bi bi-tag"></i> brioche</span>
            <span class="badge rounded-pill bg-body-tertiary border"><i class="bi bi-tag"></i> brunch</span>
            <span class="badge rounded-pill bg-body-tertiary border"><i class="bi bi-tag"></i> sweet</span>
          </div>

          <hr>

          <!-- Author -->
          <section class="author" aria-label="About the author">
            <div class="d-flex align-items-center gap-3">
              <img src="{{ asset('assets/img/gallery/latte_art.png') }}" alt="Team Crustella avatar">
              <div>
                <div class="fw-bold">Team Crustella</div>
                <div class="small text-muted">Bakers by dawn, baristas by day. We share techniques that survive the morning rush.</div>
              </div>
            </div>
          </section>

          <!-- Comments (demo) -->
          <section class="mt-4" aria-label="Comments">
            <h2 class="h4">Comments (3)</h2>
            <div class="d-grid gap-3">
              <div class="p-3 border rounded-3" style="border-color:var(--border)">
                <div class="d-flex justify-content-between small">
                  <strong>Alex</strong><span class="text-muted">Apr 3, 2025</span>
                </div>
                <p class="mb-0">Orange zest was a game-changer. Kids devoured it.</p>
              </div>
              <div class="p-3 border rounded-3" style="border-color:var(--border)">
                <div class="d-flex justify-content-between small">
                  <strong>Morgan</strong><span class="text-muted">Apr 3, 2025</span>
                </div>
                <p class="mb-0">Used challah — still great. Thanks!</p>
              </div>
              <div class="p-3 border rounded-3" style="border-color:var(--border)">
                <div class="d-flex justify-content-between small">
                  <strong>Kim</strong><span class="text-muted">Apr 2, 2025</span>
                </div>
                <p class="mb-0">Any substitute for mascarpone? Greek yogurt worked in a pinch.</p>
              </div>
            </div>

            <form id="commentForm" class="mt-3 needs-validation" novalidate>
              <div class="row g-2">
                <div class="col-sm-6">
                  <label class="form-label small">Name</label>
                  <input class="form-control" required>
                  <div class="invalid-feedback">Please enter your name.</div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label small">Email</label>
                  <input type="email" class="form-control" required>
                  <div class="invalid-feedback">Enter a valid email.</div>
                </div>
                <div class="col-12">
                  <label class="form-label small">Comment</label>
                  <textarea class="form-control" rows="3" required></textarea>
                  <div class="invalid-feedback">Write a comment.</div>
                </div>
              </div>
              <div class="mt-2">
                <button class="btn btn-primary" type="submit">Post comment</button>
              </div>
              <div id="commentMsg" class="small mt-2" aria-live="polite"></div>
            </form>
          </section>
        </article>

        <!-- TOC -->
        <aside class="col-lg-4">
          <div class="toc" id="toc" aria-label="Table of contents">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h6 class="fw-bold m-0"><i class="bi bi-list-check"></i> Contents</h6>
              <a href="#article" class="small text-decoration-none">Top</a>
            </div>
            <ul class="toc-list" id="tocList"></ul>
          </div>

          <!-- Subscribe widget -->
          <div class="mt-3 p-3 border rounded-3" style="border-color:var(--border); background:var(--surface)">
            <h6 class="fw-bold">Get new recipes</h6>
            <p class="small text-muted mb-2">One email per week. No spam.</p>
            <form id="blogNewsletter" class="d-flex gap-2">
              <input type="email" class="form-control" required placeholder="your@email.com">
              <button class="btn btn-primary" type="submit">Join</button>
            </form>
            <div id="blogNewsletterMsg" class="small mt-2" aria-live="polite"></div>
          </div>
        </aside>
      </div>

      <!-- Related posts -->
      <section class="mt-5" aria-label="Related posts">
        <div class="d-flex align-items-end justify-content-between gap-3 mb-2">
          <h2 class="h4 m-0">You may also like</h2>
          <a class="btn btn-light btn-sm" href="/blog"><i class="bi bi-grid"></i> All posts</a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col d-flex">
            <article class="post-card w-100">
              <div class="skel"><div class="ratio ratio-16x9">
                <img src="{{ asset('assets/img/dishes/item_9.png') }}" alt="Cold brew glass" loading="lazy">
              </div></div>
              <div class="pad">
                <div class="small text-muted mb-1">Recipe</div>
                <h3 class="h6 mb-2">12-Hour Cold Brew, Café-Smooth</h3>
                <a href="/blog/cold-brew-recipe" class="btn btn-light btn-sm">Read more</a>
              </div>
            </article>
          </div>
          <div class="col d-flex">
            <article class="post-card w-100">
              <div class="skel"><div class="ratio ratio-16x9">
                <img src="{{ asset('assets/img/gallery/fresh_bread.png') }}" alt="Sourdough loaves" loading="lazy">
              </div></div>
              <div class="pad">
                <div class="small text-muted mb-1">Bakery Tips</div>
                <h3 class="h6 mb-2">Sourdough 101: Feeding Schedules</h3>
                <a href="/blog/sourdough-101" class="btn btn-light btn-sm">Read more</a>
              </div>
            </article>
          </div>
          <div class="col d-flex">
            <article class="post-card w-100">
              <div class="skel"><div class="ratio ratio-16x9">
                <img src="{{ asset('assets/img/gallery/latte_art.png') }}" alt="Latte art pour" loading="lazy">
              </div></div>
              <div class="pad">
                <div class="small text-muted mb-1">Coffee</div>
                <h3 class="h6 mb-2">Dialing In Espresso: 5 Steps</h3>
                <a href="/blog/dialing-in-espresso" class="btn btn-light btn-sm">Read more</a>
              </div>
            </article>
          </div>
        </div>
      </section>
    </div>
  </main>

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

      // Copy/share
      const url=location.href;
      document.getElementById('copyLink')?.addEventListener('click', async ()=>{
        try{ await navigator.clipboard.writeText(url); const b=event.currentTarget; b.innerHTML='<i class="bi bi-check2"></i> Copied'; setTimeout(()=>b.innerHTML='<i class="bi bi-link-45deg"></i> Copy link',1600); }catch(e){ alert('Copy failed'); }
      });
      document.getElementById('twShare').href = 'https://twitter.com/intent/tweet?text='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(url);
      document.getElementById('fbShare').href = 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(url);

      // Build TOC from h2/h3 in #article
      const tocList=document.getElementById('tocList');
      const headings=[...document.querySelectorAll('#article h2, #article h3')];
      headings.forEach((h,i)=>{
        if(!h.id){ h.id = 'h-'+i }
        const li=document.createElement('li'); li.className = h.tagName==='H2' ? 'lvl-2' : 'lvl-3';
        const a=document.createElement('a'); a.href='#'+h.id; a.textContent=h.textContent;
        li.appendChild(a); tocList.appendChild(li);
      });

      // Highlight active heading
      const links=[...tocList.querySelectorAll('a')];
      const observeTargets=headings.map(h=>({id:h.id, top:0}));
      const io = new IntersectionObserver((entries)=>{
        entries.forEach(en=>{
          const link=links.find(a=>a.getAttribute('href').slice(1)===en.target.id);
          if(!link) return;
          if(en.isIntersecting){ links.forEach(l=>l.classList.remove('active')); link.classList.add('active'); }
        });
      }, { rootMargin: '-25% 0px -65% 0px', threshold: 0 });
      headings.forEach(h=> io.observe(h));

      // Smooth-scroll offset fix
      document.querySelectorAll('a[href^="#"]').forEach(a=>{
        a.addEventListener('click', (e)=>{
          const id=a.getAttribute('href').slice(1);
          const el=document.getElementById(id);
          if(!el) return;
          e.preventDefault();
          window.scrollTo({ top: el.getBoundingClientRect().top + window.scrollY - 80, behavior:'smooth' });
          history.replaceState(null,'','#'+id);
        });
      });

      // Compute reading time from article text
      const text=document.getElementById('article').innerText || '';
      const words=text.trim().split(/\s+/).length;
      const min=Math.max(1, Math.round(words/220)); // ~220 wpm
      document.getElementById('readTime').textContent = String(min);

      // Newsletter demo
      const bForm=document.getElementById('blogNewsletter'); const bMsg=document.getElementById('blogNewsletterMsg');
      bForm?.addEventListener('submit',(e)=>{ e.preventDefault(); bMsg.textContent='Thanks! You‘re on the list.'; bMsg.className='small mt-2 text-success'; bForm.reset(); setTimeout(()=>{ bMsg.textContent=''; bMsg.className='small mt-2'; }, 3500); });

      const nForm=document.getElementById('newsletterForm'); const nMsg=document.getElementById('newsletterMsg');
      nForm?.addEventListener('submit',(e)=>{ e.preventDefault(); nMsg.textContent='Thanks! You’re subscribed.'; nMsg.className='small mt-2 text-success'; nForm.reset(); setTimeout(()=>{ nMsg.textContent=''; nMsg.className='small mt-2'; }, 3500); });

      // Comments demo
      const cForm=document.getElementById('commentForm'); const cMsg=document.getElementById('commentMsg');
      cForm?.addEventListener('submit',(e)=>{
        e.preventDefault();
        if(!cForm.checkValidity()){ cForm.classList.add('was-validated'); return; }
        cMsg.textContent='Thanks! Your comment is pending moderation.'; cMsg.className='small mt-2 text-success';
        cForm.reset(); cForm.classList.remove('was-validated');
        setTimeout(()=>{ cMsg.textContent=''; cMsg.className='small mt-2'; }, 3500);
      });

      // Back to top
      document.getElementById('toTopBtn')?.addEventListener('click',(e)=>{ e.preventDefault(); window.scrollTo({ top:0, behavior:'smooth' }); });
    });
  </script>
</body>
</html>
