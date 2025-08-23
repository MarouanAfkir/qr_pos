<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Crustella — Café & Bakery Template • Documentation" />
  <meta name="theme-color" content="#C46E3A" />
  <title>Crustella Docs</title>
  <link rel="icon" href="assets/img/favicon.png" />
  <!-- Early theme init -->
  <script>
    (function(){try{var saved=localStorage.getItem('theme'); if(saved) document.documentElement.setAttribute('data-bs-theme', saved);}catch(e){}})();
  </script>

  <!-- Fonts & CSS -->
  <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"/>

  <style>
    :root{
      --accent:#C46E3A; --accent-600:#A75B2F; --border:#EADFD5; --surface:#fff; --surface-2:#FFF2E5;
      --bg:#FFF7EF; --muted:#6B7280; --ring:rgba(196,110,58,.25); --radius:18px; --cocoa:#5A3E2B;
    }
    [data-bs-theme="dark"]{
      --bg:#0E1114; --surface:#12161B; --surface-2:#10141A; --border:#222A35; --muted:#9AA3AF; --cocoa:#E6E6E6;
    }
    html{scroll-behavior:smooth}
    body{font-family:'Manrope',system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; color:var(--cocoa); background:var(--bg)}
    h1,h2,h3,h4,h5,h6{font-family:'Inter',sans-serif; letter-spacing:-.015em; font-weight:800}
    .text-muted{color:var(--muted)!important}
    .btn-primary{--bs-btn-bg:var(--accent); --bs-btn-border-color:var(--accent); --bs-btn-hover-bg:var(--accent-600); --bs-btn-hover-border-color:var(--accent-600); border-radius:12px; font-weight:700}
    .btn-outline-primary{--bs-btn-color:var(--accent); --bs-btn-border-color:var(--accent); --bs-btn-hover-bg:var(--accent); --bs-btn-hover-border-color:var(--accent); --bs-btn-hover-color:#fff; border-radius:12px; font-weight:700}
    .code{background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:1rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; font-size:.925rem; overflow:auto}
    .kbd{border:1px solid var(--border); background:var(--surface); padding:.1rem .4rem; border-radius:6px; font-family: ui-monospace, monospace}
    .docs-topbar{position:sticky; top:0; z-index:1030; background:rgba(255,255,255,.86); backdrop-filter:blur(10px); border-bottom:1px solid var(--border)}
    [data-bs-theme="dark"] .docs-topbar{background:rgba(16,19,24,.86)}
    .hero-docs{background:linear-gradient(135deg,#FFEBDD,#FFF6EE); border-bottom:1px solid var(--border)}
    [data-bs-theme="dark"] .hero-docs{background:linear-gradient(135deg,#141b23,#0f141c)}
    .toc{position:sticky; top:84px; max-height:calc(100vh - 96px); overflow:auto; padding-right:.5rem}
    .toc .list-group-item{border:0; border-left:2px solid transparent; border-radius:0}
    .toc .list-group-item.active{background:transparent; border-left-color:var(--accent); color:inherit; font-weight:700}
    .callout{border-left:4px solid var(--accent); background:var(--surface-2); border:1px solid var(--border); border-left-color:var(--accent); border-radius:12px; padding:1rem}
    .badge-soft{background:rgba(196,110,58,.12); color:var(--accent); border:1px solid var(--border)}
    .table-files td, .table-files th{border-color:var(--border)!important}
    section{scroll-margin-top:90px}
    .footer{border-top:1px solid var(--border)}
  </style>
</head>
<body>

  <!-- Top bar -->
  <div class="docs-topbar py-2">
    <div class="container d-flex align-items-center justify-content-between small">
      <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('assets/img/gallery/logo.png') }}" alt="Crustella" height="24" width="24" style="border-radius:6px;object-fit:cover">
        <strong>Crustella</strong>
        <span class="badge badge-soft rounded-pill">Docs</span>
      </div>
      <div class="d-flex align-items-center gap-2">
        <button id="themeBtn" class="btn btn-outline-primary btn-sm"><i class="bi bi-moon-stars"></i> Theme</button>
        <a href="index.html" class="btn btn-primary btn-sm"><i class="bi bi-box-arrow-up-right"></i> Preview site</a>
      </div>
    </div>
  </div>

  <!-- Hero -->
  <header class="hero-docs py-5">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-8">
          <h1 class="display-5 m-0">Crustella — Documentation</h1>
          <p class="lead text-muted mt-2">Café & bakery template with quick order picks, specials carousel, drink configurator, workshops, improved gallery lightbox, and a brand-new <strong>Hero v3</strong>.</p>
          <div class="d-flex flex-wrap gap-2">
            <span class="badge badge-soft rounded-pill"><i class="bi bi-bootstrap"></i> Bootstrap 5.3.3</span>
            <span class="badge badge-soft rounded-pill"><i class="bi bi-type"></i> Inter + Manrope</span>
            <span class="badge badge-soft rounded-pill"><i class="bi bi-moon-stars"></i> Light/Dark</span>
            <span class="badge badge-soft rounded-pill"><i class="bi bi-images"></i> Gallery v2</span>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="callout small">
            <div class="fw-bold mb-1">What’s new</div>
            <ul class="m-0 ps-3">
              <li>Hero v3 — Cinematic split + quick-add dock + live countdown</li>
              <li>“Behind the scenes” gallery: modal, filmstrip, keyboard & swipe</li>
              <li>Workshop image guidance (square “Latte Art Basics” thumbnail)</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main -->
  <main class="py-4">
    <div class="container">
      <div class="row g-4">
        <!-- TOC -->
        <aside class="col-lg-3">
          <nav class="toc">
            <div class="list-group small">
              <a class="list-group-item active" href="#overview">Overview</a>
              <a class="list-group-item" href="#quick-start">Quick start</a>
              <a class="list-group-item" href="#file-structure">File structure</a>
              <a class="list-group-item" href="#assets">Assets & images</a>
              <a class="list-group-item" href="#theming">Theming</a>
              <a class="list-group-item" href="#components">Components</a>
              <a class="list-group-item" href="#gallery">Gallery v2</a>
              <a class="list-group-item" href="#hero">Hero variants</a>
              <a class="list-group-item" href="#scripts">Scripts & hooks</a>
              <a class="list-group-item" href="#accessibility">Accessibility</a>
              <a class="list-group-item" href="#performance">Performance</a>
              <a class="list-group-item" href="#faq">FAQ</a>
              <a class="list-group-item" href="#changelog">Changelog</a>
              <a class="list-group-item" href="#license">Credits & license</a>
            </div>
          </nav>
        </aside>

        <!-- Content -->
        <div class="col-lg-9">
          <!-- Overview -->
          <section id="overview" class="pb-4">
            <h2>Overview</h2>
            <p>Crustella is a single-page café & bakery template built with Bootstrap 5. It ships with:</p>
            <ul>
              <li>Responsive navbar, mega dropdown, search under nav, and persistent theme toggle (localStorage).</li>
              <li>Three hero styles (v1, v2, <strong>v3</strong>), quick order picks, specials carousel, drink configurator, subscriptions & gifts.</li>
              <li>Workshops with signup modal, improved <em>Behind the scenes</em> gallery lightbox, FAQ, press band, contact with map, and offcanvas cart.</li>
            </ul>
            <div class="alert alert-info small mb-0">
              Using Blade/Laravel? Paths are written as <span class="kbd">test</span>. For plain HTML, replace with relative URLs.
            </div>
          </section>

          <!-- Quick start -->
          <section id="quick-start" class="pb-4">
            <h2>Quick start</h2>
            <ol>
              <li>Copy the template files into your project (or drop <span class="kbd">index.html</span> and this <span class="kbd">docs.html</span> alongside your <span class="kbd">assets/</span>).</li>
              <li>Update image paths in <span class="kbd">assets/img</span> or keep Blade’s <span class="kbd">asset()</span> helper if you’re on Laravel.</li>
              <li>Open <span class="kbd">index.html</span> in a browser. Use the theme button to check light/dark.</li>
              <li>Swap hero variant if desired (see <a href="#hero">Hero variants</a>).</li>
            </ol>
            <div class="code" aria-label="CDN includes">
<pre><code>&lt;link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"&gt;
&lt;link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"&gt;
&lt;script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer&gt;&lt;/script&gt;
</code></pre>
            </div>
          </section>

          <!-- File structure -->
          <section id="file-structure" class="pb-4">
            <h2>File structure</h2>
            <table class="table table-sm table-files">
              <thead><tr><th>Path</th><th>Description</th></tr></thead>
              <tbody>
                <tr><td><span class="kbd">index.html</span></td><td>Main demo page (Demo 2 with Hero v3 & updated gallery)</td></tr>
                <tr><td><span class="kbd">docs.html</span></td><td>This documentation page</td></tr>
                <tr><td><span class="kbd">assets/img/</span></td><td>Logos, gallery, dishes, map, workshop images</td></tr>
                <tr><td><span class="kbd">assets/img/dishes/</span></td><td>Menu thumbnails (used in Quick picks & chips)</td></tr>
                <tr><td><span class="kbd">assets/img/gallery/</span></td><td>Hero/section photos, gallery items, workshop images</td></tr>
              </tbody>
            </table>
          </section>

          <!-- Assets -->
          <section id="assets" class="pb-4">
            <h2>Assets & images</h2>
            <ul>
              <li><strong>Workshop thumbnails:</strong> Recommended square 1:1, min 900×900. Example: <span class="kbd">assets/img/gallery/workshop_1.png</span> for <em>Latte Art Basics</em>.</li>
              <li><strong>Gallery:</strong> Use mid-to-large images (e.g. 1600px wide). Add items in the grid with <span class="kbd">.gallery-item</span> and <span class="kbd">data-full</span> + <span class="kbd">data-caption</span>.</li>
              <li><strong>Hero background:</strong> Replace <span class="kbd">assets/img/gallery/hero.png</span>.</li>
              <li><strong>Note:</strong> All bundled photos are placeholders—replace with your licensed images.</li>
            </ul>
          </section>

          <!-- Theming -->
          <section id="theming" class="pb-4">
            <h2>Theming</h2>
            <p>Core look & feel is controlled by CSS variables in <span class="kbd">:root</span> and a dark theme override:</p>
            <div class="code">
<pre><code>:root{
  --accent:#C46E3A; --accent-600:#A75B2F; --cocoa:#5A3E2B;
  --bg:#FFF7EF; --surface:#FFFFFF; --surface-2:#FFF2E5;
  --border:#EADFD5; --muted:#6B7280; --ring:rgba(196,110,58,.25);
  --radius:18px;
}
/* Dark override */
[data-bs-theme="dark"]{
  --bg:#0E1114; --surface:#12161B; --surface-2:#10141A;
  --border:#222A35; --muted:#9AA3AF; --cocoa:#E6E6E6;
}
</code></pre>
            </div>
            <p>Theme is toggled with the “Theme” button and persisted in <span class="kbd">localStorage('theme')</span>.</p>
          </section>

          <!-- Components -->
          <section id="components" class="pb-4">
            <h2>Components (high level)</h2>

            <h5 class="mt-3">Navbar & Search</h5>
            <ul>
              <li><span class="kbd">.nav-elevated</span> sticky with scroll progress bar (<span class="kbd">#scrollProgress</span>).</li>
              <li>Mega dropdown built with a centered <span class="kbd">.dropdown-menu.mega</span>.</li>
              <li>Expandable search lives in <span class="kbd">#navSearchWrap</span> (Bootstrap Collapse).</li>
            </ul>

            <h5 class="mt-3">Quick order picks</h5>
            <p>Grid of cards. Each “Add” is a button with <span class="kbd">.add-to-cart</span> and data attributes:</p>
            <div class="code">
<pre><code>&lt;button class="btn btn-primary btn-sm add-to-cart"
  data-name="Vanilla Latte" data-price="4.9"&gt;Add&lt;/button&gt;
</code></pre>
            </div>

            <h5 class="mt-3">Weekly specials (Carousel)</h5>
            <p>Standard Bootstrap carousel with <span class="kbd">data-bs-ride="carousel"</span>.</p>

            <h5 class="mt-3">Drink configurator</h5>
            <ul>
              <li>Options grouped by <span class="kbd">#baseOpts</span>, <span class="kbd">#sizeOpts</span>, <span class="kbd">#milkOpts</span>, <span class="kbd">#extraOpts</span>.</li>
              <li>Totals update via <span class="kbd">calc()</span>; result can be pushed to cart with <span class="kbd">#addBuilt</span>.</li>
            </ul>

            <h5 class="mt-3">Subscriptions & gifts</h5>
            <p>Simple cards with buttons using the same <span class="kbd">.add-to-cart</span> hook.</p>

            <h5 class="mt-3">Workshops & modal</h5>
            <ul>
              <li>Two preview cards; the “Save seat” button opens <span class="kbd">#workshopModal</span>.</li>
              <li>Form uses Bootstrap validation; on submit, shows a demo alert and resets.</li>
            </ul>

            <h5 class="mt-3">Offcanvas cart</h5>
            <ul>
              <li>Cart state is an array in memory; lines render into <span class="kbd">#cartLines</span>.</li>
              <li>Totals and counts sync to <span class="kbd">#cartTotal</span>, <span class="kbd">#cartCount</span>, <span class="kbd">#cartCountMobile</span>.</li>
            </ul>
          </section>

          <!-- Gallery v2 -->
          <section id="gallery" class="pb-4">
            <h2>Behind the scenes — Gallery v2</h2>
            <p>The updated gallery adds a lightbox modal with prev/next buttons, keyboard navigation, swipe on mobile, and a filmstrip of thumbnails.</p>
            <ol>
              <li>Each grid item is an anchor with <span class="kbd">.gallery-item</span>, <span class="kbd">data-index</span>, <span class="kbd">data-full</span>, and optional <span class="kbd">data-caption</span>.</li>
              <li>The modal (<span class="kbd">#galleryModal</span>) is built once; JS reads items to populate thumbs.</li>
              <li>Use left/right arrow keys or swipe to navigate.</li>
            </ol>
            <div class="code">
<pre><code>&lt;a class="gallery-item" data-index="0"
   data-full="{{ asset('assets/img/gallery/pastry_detail.png') }}"
   data-caption="Pastry detail"&gt;
  &lt;img src="{{ asset('assets/img/gallery/pastry_detail.png') }}" alt="Pastry detail"&gt;
&lt;/a&gt;
</code></pre>
            </div>
          </section>

          <!-- Hero variants -->
          <section id="hero" class="pb-4">
            <h2>Hero variants</h2>
            <p>Crustella ships with multiple hero styles. Demo 2 currently uses <strong>Hero v3</strong> (cinematic background + quick-add dock + live countdown to next bake).</p>

            <h5 class="mt-3">Switching heroes</h5>
            <ol>
              <li>Locate the <span class="kbd">&lt;header class="hero …" id="overview"&gt;</span> block in <span class="kbd">index.html</span>.</li>
              <li>Replace it with your preferred variant’s block (v1/v2/v3 snippets).</li>
            </ol>

            <h6 class="mt-3">Example: Minimal Hero v2 (from earlier demo)</h6>
            <div class="code">
<pre><code>&lt;header class="hero" id="overview"&gt;
  &lt;div class="bg-img" style="background-image:url('{{ asset('assets/img/gallery/hero.png') }}');"&gt;&lt;/div&gt;
  &lt;!-- content … --&gt;
&lt;/header&gt;
</code></pre>
            </div>

            <h6 class="mt-3">Hero v3 extras</h6>
            <ul>
              <li>Ken Burns background animation (CSS <span class="kbd">@keyframes kenburns</span>).</li>
              <li>Quick-add chips feeding the cart via <span class="kbd">.add-to-cart</span> buttons.</li>
              <li>Live “Open now” badge + next bake ETA computed in JS (9:00, 12:00, 16:00 schedule).</li>
            </ul>
          </section>

          <!-- Scripts -->
          <section id="scripts" class="pb-4">
            <h2>Scripts & hooks</h2>
            <p>The main inline script (at the end of <span class="kbd">index.html</span>) wires up all interactions. Key hooks:</p>
            <ul>
              <li><span class="kbd">#themeBtn</span>, <span class="kbd">#themeBtnMobile</span> — toggle theme; persists to <span class="kbd">localStorage('theme')</span>.</li>
              <li><span class="kbd">#navSearchWrap</span> — Bootstrap Collapse for search; opened via <span class="kbd">#searchBtn</span>.</li>
              <li><span class="kbd">.add-to-cart</span> — read <span class="kbd">data-name</span>, <span class="kbd">data-price</span> and push a line into the cart.</li>
              <li><span class="kbd">Drink builder</span> — containers <span class="kbd">#baseOpts</span>, <span class="kbd">#sizeOpts</span>, <span class="kbd">#milkOpts</span>, <span class="kbd">#extraOpts</span>; total in <span class="kbd">#builderTotal</span>.</li>
              <li><span class="kbd">Gallery</span> — items under <span class="kbd">#gallery .gallery-item</span>, modal <span class="kbd">#galleryModal</span>, dynamic thumbs in <span class="kbd">#lightboxThumbs</span>.</li>
            </ul>
            <div class="alert alert-secondary small mb-0">
              If you move IDs or class names, update selectors inside the inline script accordingly.
            </div>
          </section>

          <!-- Accessibility -->
          <section id="accessibility" class="pb-4">
            <h2>Accessibility</h2>
            <ul>
              <li>All interactive controls include <span class="kbd">aria-label</span> where icons are used.</li>
              <li>Modal/lightbox supports keyboard: <span class="kbd">←</span> / <span class="kbd">→</span> arrows, close button is focusable.</li>
              <li>Contrast: warm palette tested against typical backgrounds; verify with your own images.</li>
              <li>Focus styles: buttons and nav links get a ring via <span class="kbd">box-shadow</span>.</li>
            </ul>
          </section>

          <!-- Performance -->
          <section id="performance" class="pb-4">
            <h2>Performance</h2>
            <ul>
              <li>Add <span class="kbd">loading="lazy"</span> to non-critical images; use <span class="kbd">fetchpriority="high"</span> on the first hero image.</li>
              <li>Keep hero background optimized (e.g., 1800–2200px wide, modern format if possible).</li>
              <li>Minify/inline critical CSS if you split files; defer non-critical JS (already using <span class="kbd">defer</span>).</li>
              <li>Use the provided skeleton shimmer (<span class="kbd">.skel</span>) to avoid layout shifts while images load.</li>
            </ul>
          </section>

          <!-- FAQ -->
          <section id="faq" class="pb-4">
            <h2>FAQ</h2>
            <div class="mb-3">
              <strong>How do I replace the Blade <span class="kbd">asset()</span> helper?</strong>
              <div class="text-muted">Search for <span class="kbd">{{'{{ asset('}}</span> and replace with relative paths like <span class="kbd">assets/img/…</span>.</div>
            </div>
            <div class="mb-3">
              <strong>Can I disable the cart?</strong>
              <div class="text-muted">Remove the offcanvas block and the inline cart logic. Also remove <span class="kbd">.add-to-cart</span> buttons or swap them to simple links.</div>
            </div>
            <div class="mb-3">
              <strong>How do I add more gallery images?</strong>
              <div class="text-muted">Duplicate a grid column, increment <span class="kbd">data-index</span>, and set <span class="kbd">data-full</span> + thumbnail <span class="kbd">src</span>. The lightbox builds thumbs automatically.</div>
            </div>
          </section>

          <!-- Changelog -->
          <section id="changelog" class="pb-4">
            <h2>Changelog (highlights)</h2>
            <ul>
              <li><strong>Demo 2 — Hero v3:</strong> Cinematic background, quick-add dock, live open status & next bake ETA.</li>
              <li><strong>Gallery v2:</strong> Modal with prev/next, filmstrip thumbnails, keyboard & swipe support.</li>
              <li><strong>Workshops:</strong> Added guidance and square Latte Art Basics thumbnail support.</li>
            </ul>
          </section>

          <!-- License -->
          <section id="license" class="pb-4">
            <h2>Credits & license</h2>
            <ul>
              <li>Framework: Bootstrap 5.3.3, Bootstrap Icons 1.11.3.</li>
              <li>Fonts: Inter & Manrope (Google Fonts).</li>
              <li>Images: placeholders only — replace with your licensed assets.</li>
            </ul>
            <p class="small text-muted">Code is provided as a template for your project; ensure you comply with the licenses of any third-party assets you add.</p>
          </section>

          <hr class="my-4" />
          <div class="d-flex align-items-center justify-content-between">
            <div class="small text-muted">© <span id="year"></span> Crustella — Docs</div>
            <a href="#overview" class="btn btn-outline-primary btn-sm"><i class="bi bi-arrow-up"></i> Back to top</a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer py-4">
    <div class="container small text-muted d-flex align-items-center justify-content-between">
      <div>Need help? Skim the <a href="#components">Components</a> & <a href="#scripts">Scripts</a> sections.</div>
      <div>
        <a class="btn btn-light btn-sm" href="index.html"><i class="bi bi-box-arrow-up-right"></i> Open Demo 2</a>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      // year
      document.getElementById('year').textContent = new Date().getFullYear();

      // theme toggle
      const themeBtn = document.getElementById('themeBtn');
      const syncIcon = () => themeBtn.innerHTML =
        (document.documentElement.getAttribute('data-bs-theme') === 'dark'
          ? '<i class="bi bi-sun"></i> Light' : '<i class="bi bi-moon-stars"></i> Dark');
      syncIcon();
      themeBtn.addEventListener('click', () => {
        const next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-bs-theme', next);
        try{ localStorage.setItem('theme', next);}catch(e){}
        syncIcon();
      });

      // Simple TOC active state on scroll
      const links = document.querySelectorAll('.toc .list-group-item');
      const sections = Array.from(links).map(a => document.querySelector(a.getAttribute('href'))).filter(Boolean);
      const onScroll = () => {
        let idx = 0;
        sections.forEach((sec, i) => {
          const top = sec.getBoundingClientRect().top;
          if (top <= 100) idx = i;
        });
        links.forEach(l => l.classList.remove('active'));
        links[idx]?.classList.add('active');
      };
      window.addEventListener('scroll', onScroll, {passive:true});
      onScroll();
    });
  </script>
</body>
</html>
