<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#ff4b00">
  <title>Le Gourmet • Digital Menu</title>

  <!-- Core theme assets (Fresheat) -->
  <link rel="shortcut icon" href="assets/img/favicon.png">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/all.min.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
  <link rel="stylesheet" href="assets/css/main.css">

  <!-- ===== Custom one-pager styles ===== -->
  <style>
    :root {
      --primary: #ff4b00;
      --dark: #0c0b09;
      --light: #ffffff;
      --body-bg: #faf7f4;
    }

    body {
      background: var(--body-bg);
      scroll-behavior: smooth;
    }

    /* ---------- HERO ---------- */
    .restaurant-header {
      position: relative;
      min-height: 60vh;
      color: var(--light);
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      overflow: hidden;
    }

    .restaurant-hero {
      position: absolute;
      inset: 0;
      overflow: hidden;
    }

    .restaurant-hero img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform .7s ease;
    }

    .restaurant-header:hover .restaurant-hero img {
      transform: scale(1.05);
    }

    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(0, 0, 0, .2) 0%, rgba(0, 0, 0, .75) 100%);
    }

    .restaurant-logo {
      width: 120px;
      height: auto;
    }

    /* ---------- CATEGORY BAR ---------- */
    .category-nav {
      background: var(--dark);
      position: sticky;
      top: 0;
      z-index: 1030;
      display: flex;
      gap: .75rem;
      overflow-x: auto;
      padding: .75rem 1rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, .25);
      scrollbar-width: none;
    }

    .category-nav::-webkit-scrollbar {
      display: none;
    }

    .category-link {
      color: var(--light);
      white-space: nowrap;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: .4rem;
      padding: .35rem .75rem;
      border-radius: 2rem;
      transition: background .2s;
    }

    .category-link img {
      width: 26px;
      height: 26px;
    }

    .category-link.active,
    .category-link:hover {
      background: var(--primary);
      color: var(--light);
    }

    /* ---------- SEARCH ---------- */
    .menu-search {
      max-width: 480px;
      margin: 2rem auto 0;
    }

    /* ---------- MENU SECTION ---------- */
    section.menu-section {
      scroll-margin-top: 4.5rem;
      padding: 3rem 0;
    }

    .menu-section .section-title {
      margin-bottom: 2rem;
    }

    .menu-card {
      display: flex;
      gap: 1rem;
      align-items: flex-start;
      padding: 1rem;
      background: var(--light);
      border-radius: 1rem;
      box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
      transition: transform .2s;
    }

    .menu-card:hover {
      transform: translateY(-4px);
    }

    .menu-card img {
      width: 96px;
      height: 96px;
      object-fit: cover;
      border-radius: .75rem;
      flex-shrink: 0;
    }

    .menu-card h5 {
      margin-bottom: .25rem;
      font-weight: 600;
    }

    .menu-card p {
      margin-bottom: .25rem;
      font-size: .9rem;
      color: #555;
    }

    .menu-price {
      color: var(--primary);
      font-weight: 700;
      font-size: 1rem;
    }

    /* ---------- FOOTER ---------- */
    footer.footer-section {
      margin-top: 4rem;
    }

    /* ---------- UTILS ---------- */
    .d-none {
      display: none !important;
    }
  </style>
</head>

<body>

  <!-- ===== HERO ===== -->
  <header class="restaurant-header">
    <div class="restaurant-hero">
      <img src="assets/img/custom/hero1.png" alt="Restaurant cover image" loading="eager">
      <span class="hero-overlay"></span>
    </div>

    <div class="container position-relative z-index-2">
      <img src="assets/img/logo/logo.svg" class="restaurant-logo mb-3" alt="Le Gourmet logo">
      <h1 class="display-5 fw-bold mb-1">Le Gourmet</h1>
      <p class="lead fst-italic text-light">Fresh • Local • Delicious</p>

      <div class="header-meta d-flex flex-wrap justify-content-center gap-3">
        <span><i class="fa-solid fa-location-dot me-1"></i>123 Main St, Casablanca</span>
        <span><i class="fa-regular fa-clock me-1"></i>09:00 – 23:00</span>
        <span><i class="fa-solid fa-phone-volume me-1"></i>+212 6 00 00 00 00</span>
      </div>
    </div>
  </header>

  <!-- ===== CATEGORY BAR ===== -->
  <nav class="category-nav" id="categoryBar" role="navigation" aria-label="Categories">
    <a class="category-link active" href="#fastfood"><img src="assets/img/menu/menuIcon1_1.png" alt="">Fast&nbsp;Food</a>
    <a class="category-link" href="#drink"><img src="assets/img/menu/menuIcon1_2.png" alt="">Drinks&nbsp;&&nbsp;Juice</a>
    <a class="category-link" href="#pizza"><img src="assets/img/menu/menuIcon1_3.png" alt="">Pizza</a>
    <a class="category-link" href="#pasta"><img src="assets/img/menu/menuIcon1_4.png" alt="">Pasta</a>
  </nav>

  <!-- ===== SEARCH ===== -->
  <div class="menu-search px-3">
    <input type="search" id="menuSearch" class="form-control rounded-pill shadow-sm"
      placeholder="Search dishes (e.g. burger, vegan…)" aria-label="Search menu">
  </div>

  <!-- ===== MENU SECTIONS ===== -->

  <!-- Fast Food -->
  <section class="menu-section" id="fastfood" aria-labelledby="title-fastfood">
    <div class="container">
      <h2 class="section-title text-center" id="title-fastfood">Fast&nbsp;Food</h2>

      <div class="row gy-4" data-category="fastfood">
        <!-- card -->
        <div class="col-md-6 menu-item" data-name="chicken burger">
          <div class="menu-card">
            <img src="assets/img/menu/menuThumb1_5.png" alt="Grilled Chicken Burger" loading="lazy">
            <div>
              <h5>Grilled Chicken Burger</h5>
              <p>Juicy grilled chicken, lettuce &amp; herb mayo</p>
              <data class="menu-price" value="55.99">$55.99</data>
            </div>
          </div>
        </div>
        <!-- card -->
        <div class="col-md-6 menu-item" data-name="vegetable burger vegan">
          <div class="menu-card">
            <img src="assets/img/menu/menuThumb1_9.png" alt="Vegetable Burger" loading="lazy">
            <div>
              <h5>Vegetable Burger <span class="badge bg-success ms-1">Vegan</span></h5>
              <p>Crispy veggies, avocado &amp; spicy tomato relish</p>
              <data class="menu-price" value="75.99">$75.99</data>
            </div>
          </div>
        </div>
        <!-- … add more dishes as needed -->
      </div>
    </div>
  </section>

  <!-- Drinks & Juice -->
  <section class="menu-section bg-light" id="drink" aria-labelledby="title-drink">
    <div class="container">
      <h2 class="section-title text-center" id="title-drink">Drinks&nbsp;&&nbsp;Juice</h2>

      <div class="row gy-4" data-category="drink">
        <div class="col-md-6 menu-item" data-name="fresh orange juice">
          <div class="menu-card">
            <img src="assets/img/menu/drink1.png" alt="Fresh Orange Juice" loading="lazy">
            <div>
              <h5>Fresh Orange Juice</h5>
              <p>100% pure squeezed oranges</p>
              <data class="menu-price" value="15.99">$15.99</data>
            </div>
          </div>
        </div>
        <!-- more drinks -->
      </div>
    </div>
  </section>

  <!-- Pizza -->
  <section class="menu-section" id="pizza" aria-labelledby="title-pizza">
    <div class="container">
      <h2 class="section-title text-center" id="title-pizza">Pizza</h2>

      <div class="row gy-4" data-category="pizza">
        <div class="col-md-6 menu-item" data-name="margherita pizza vegetarian">
          <div class="menu-card">
            <img src="assets/img/menu/pizza1.png" alt="Margherita Pizza" loading="lazy">
            <div>
              <h5>Margherita Pizza <span class="badge bg-warning text-dark ms-1">Vegetarian</span></h5>
              <p>Classic tomato, mozzarella &amp; basil</p>
              <data class="menu-price" value="95.99">$95.99</data>
            </div>
          </div>
        </div>
        <!-- more pizzas -->
      </div>
    </div>
  </section>

  <!-- Pasta -->
  <section class="menu-section bg-light" id="pasta" aria-labelledby="title-pasta">
    <div class="container">
      <h2 class="section-title text-center" id="title-pasta">Pasta</h2>

      <div class="row gy-4" data-category="pasta">
        <div class="col-md-6 menu-item" data-name="carbonara pasta">
          <div class="menu-card">
            <img src="assets/img/menu/pasta1.png" alt="Carbonara Pasta" loading="lazy">
            <div>
              <h5>Carbonara Pasta</h5>
              <p>Creamy egg sauce, pancetta &amp; parmesan</p>
              <data class="menu-price" value="65.99">$65.99</data>
            </div>
          </div>
        </div>
        <!-- more pasta -->
      </div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer class="footer-section bg-title fix">
    <!-- (kept identical to your original footer for brand consistency) -->
    <!-- … footer content unchanged … -->
  </footer>

  <!-- ===== Scripts ===== -->
  <script src="assets/js/jquery-3.7.1.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/wow.min.js"></script>

  <!-- ===== Lightweight search & nav highlighting ===== -->
  <script>
    // Search / filter
    document.getElementById('menuSearch').addEventListener('input', function (e) {
      const q = e.target.value.toLowerCase().trim();
      document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.toggle('d-none', !item.dataset.name.includes(q));
      });
    });

    // Category link highlight on scroll
    const links = document.querySelectorAll('.category-link');
    const sections = [...document.querySelectorAll('.menu-section')];

    const activateLink = id => {
      links.forEach(l => l.classList.toggle('active', l.getAttribute('href') === `#${id}`));
    };

    window.addEventListener('scroll', () => {
      const fromTop = window.scrollY + 130; // offset
      const current = sections.find(s => s.offsetTop <= fromTop && s.offsetTop + s.offsetHeight > fromTop);
      if (current) activateLink(current.id);
    });

    // Click → smooth scroll highlight
    links.forEach(l => l.addEventListener('click', () => {
      activateLink(l.getAttribute('href').substring(1));
    }));

    // Init wow.js
    new WOW().init();
  </script>
</body>

</html>
