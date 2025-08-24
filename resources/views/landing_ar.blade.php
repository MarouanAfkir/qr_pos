<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- ========= META ========= -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description"
        content="QRevo — قائمة رقمية حديثة: رموز QR مخصّصة، تعدد اللغات، إحصاءات فورية وخيار الطلب على الطاولة." />
    <meta name="theme-color" content="#FF8A3D" />
    <title>QRevo — القائمة الرقمية الحديثة</title>
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

    <!-- ========= FONTS & CSS ========= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- Arabic-friendly display fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        /* ============================================================
       Soft orange palette + calm, creamy UI
    ============================================================ */
        :root {
            --brand: #FF8A3D;
            --brand-600: #F56A1E;
            --brand-700: #E85C0D;

            --peach: #FFE9D1;
            --apricot: #FFF1E6;
            --bg: #FFF8F2;

            --ink: #1f2937;
            --muted: #667085;
            --surface: #ffffff;
            --surface-2: #FFF6EE;
            --border: #F2E7DC;
            --ring: rgba(255, 138, 61, .25);

            --success: #16a34a;
            --danger: #ef4444;

            --radius: 18px;
            --shadow-1: 0 6px 20px rgba(2, 6, 23, .06);
            --shadow-2: 0 16px 40px rgba(2, 6, 23, .10);
        }

        html { scroll-behavior: smooth }

        body {
            font-family: 'Cairo', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 480px at 80% -10%, rgba(255, 138, 61, .10), transparent 60%),
                var(--bg);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            letter-spacing: -.015em;
            font-weight: 800
        }

        .text-muted { color: var(--muted) !important }

        /* ===== NAVBAR ===== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1040;
            background: rgba(255, 255, 255, .86);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            transition: box-shadow .25s ease, padding .2s ease, background .25s ease;
            padding: .7rem 0;
        }

        .navbar::after {
            content: "";
            position: absolute;
            inset-inline: 0;
            bottom: -1px;
            height: 2px;
            background: linear-gradient(90deg, var(--peach), var(--apricot));
            opacity: .55;
            pointer-events: none;
        }

        .navbar.scrolled {
            background: #fff;
            box-shadow: 0 10px 28px rgba(0, 0, 0, .06);
            padding: .45rem 0;
        }

        #scrollProgress {
            position: absolute;
            top: 0;
            inset-inline-start: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, var(--brand), #FFC078);
            border-end-end-radius: 3px;
            border-start-end-radius: 3px;
            transition: width .15s ease;
        }

        .navbar .nav-link {
            font-weight: 700;
            padding: .45rem .8rem;
            border-radius: 999px;
            position: relative;
            color: var(--ink);
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            background: rgba(255, 138, 61, .10);
            color: var(--ink);
        }

        .navbar .nav-link:focus-visible {
            outline: 0;
            box-shadow: 0 0 0 4px var(--ring);
        }

        .nav-group { position: relative }

        .nav-indicator {
            position: absolute;
            height: 2px;
            bottom: -6px;
            inset-inline-start: 0;
            width: 0;
            background: linear-gradient(90deg, var(--brand), #FFC078);
            border-radius: 2px;
            opacity: 0;
            transition: transform .25s ease, width .25s ease, opacity .2s ease;
            pointer-events: none;
        }
        /* Hide indicator in RTL to avoid offset issues */
        [dir="rtl"] .nav-indicator { display: none; }

        .btn-primary {
            --bs-btn-bg: var(--brand);
            --bs-btn-border-color: var(--brand);
            --bs-btn-hover-bg: var(--brand-600);
            --bs-btn-hover-border-color: var(--brand-600);
            box-shadow: 0 10px 20px rgba(255, 138, 61, .22);
            border-radius: 12px;
            font-weight: 800;
        }

        .btn-outline-primary {
            --bs-btn-color: var(--brand);
            --bs-btn-border-color: var(--brand);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: var(--brand);
            --bs-btn-hover-border-color: var(--brand);
            border-radius: 12px;
            font-weight: 800;
            background: transparent;
        }

        .btn-light { border-radius: 12px; font-weight: 800 }

        .offcanvas-nav { background: #fff; border-inline-start: 1px solid var(--border); }
        .offcanvas-nav .list-group-item { border: 0; padding: .9rem 0; font-weight: 800; }
        .offcanvas-nav .list-group { border: 0; border-radius: 0; }
        .offcanvas-header {
            border-bottom: 1px solid var(--border);
            background: linear-gradient(90deg, var(--apricot), var(--peach));
        }

        /* ===== Hero ===== */
        .hero {
            padding: 64px 0 56px;
            background: linear-gradient(135deg, var(--peach) 0%, var(--apricot) 100%);
            border-bottom: 1px solid var(--border);
            position: relative;
            isolation: isolate;
        }

        .hero .badge-soft {
            background: #fff;
            color: var(--brand);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .4rem .7rem;
            font-weight: 800;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .06);
        }

        .hero h1 .spark {
            background: linear-gradient(90deg, var(--brand) 0%, #FFC078 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .phone {
            width: 320px;
            max-width: 90%;
            aspect-ratio: 9/19.5;
            border: 10px solid #0d1117;
            border-radius: 38px;
            background: #000;
            box-shadow: var(--shadow-2);
            position: relative;
            margin: 0 auto;
            overflow: hidden;
        }

        .phone .screen { position: absolute; inset: 0; background: #111827; display: grid; place-items: center }
        .phone .screen img { width: 100%; height: 100%; object-fit: cover }

        /* ===== Sections / cards ===== */
        .section-title { margin-bottom: .5rem }
        .section-sub { color: var(--muted); margin-bottom: 2rem }

        .feature {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            height: 100%;
            box-shadow: var(--shadow-1);
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .feature:hover { transform: translateY(-4px); box-shadow: var(--shadow-2) }

        .feature .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: var(--brand);
            background: rgba(255, 138, 61, .10);
            margin-bottom: .75rem;
            border: 1px solid var(--border);
            font-size: 1.25rem;
        }

        .showcase {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem;
            box-shadow: var(--shadow-1);
        }
        .showcase .nav-link { border-radius: 10px; font-weight: 800; color: var(--muted) }
        .showcase .nav-link.active {
            color: var(--ink);
            background: rgba(255, 138, 61, .10);
            border: 1px solid rgba(255, 138, 61, .3);
        }
        .showcase .tab-pane {
            border-radius: 12px;
            background: var(--surface-2);
            border: 1px dashed var(--border);
            padding: 1rem;
            min-height: 280px;
        }

        /* ===== Comparison ===== */
        .compare {
            background: var(--surface-2);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 56px 0;
        }

        .compare-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-1);
            height: 100%;
            padding: 1.25rem;
        }
        .compare-card h5 { font-weight: 800; }

        .compare-list { list-style: none; padding: 0; margin: 0; }
        .compare-list li {
            display: flex;
            align-items: flex-start;
            gap: .6rem;
            padding: .5rem 0;
            border-bottom: 1px dashed var(--border);
            font-size: .95rem;
        }
        .compare-list li:last-child { border-bottom: 0; }

        .compare-list .icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: inline-grid;
            place-items: center;
            flex-shrink: 0;
        }
        .icon-yes { background: #F0FBF4; color: #0f7a3a; border: 1px solid #D7F3E1; }
        .icon-no  { background: #FFF1F1; color: #c02626; border: 1px solid #FFE0E0; }

        .price-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-1);
            height: 100%;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }
        .price-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-2) }
        .price-card.featured { border: 2px solid var(--brand) }

        .price-badge {
            background: linear-gradient(90deg, var(--brand), #FFC078);
            color: #fff;
            font-size: .75rem;
            padding: .25rem .6rem;
            border-radius: .5rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .08)
        }

        .toggle {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .3rem;
            box-shadow: var(--shadow-1);
        }
        .toggle .seg {
            border-radius: 999px;
            padding: .35rem .8rem;
            font-weight: 800;
            cursor: pointer;
            color: var(--muted);
        }
        .toggle .seg.active {
            background: rgba(255, 138, 61, .12);
            color: var(--ink);
            border: 1px solid rgba(255, 138, 61, .28)
        }

        .testimonial {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem;
            height: 100%;
            box-shadow: var(--shadow-1);
        }

        .cta {
            background:
                radial-gradient(900px 480px at 10% -10%, rgba(255, 192, 120, .25), transparent 60%),
                linear-gradient(135deg, var(--apricot), #FFEBD8);
            padding: 64px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        /* ===== Footer ===== */
        .site-footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }
        .site-footer::before {
            content: "";
            position: absolute;
            inset-inline: 0;
            top: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--apricot), var(--peach));
            opacity: .6;
        }

        .footer-brand { display: flex; align-items: center; gap: .6rem }
        .footer-brand img { height: 36px; width: auto }

        .footer-card { background: var(--surface-2); border: 1px solid var(--border); border-radius: 14px; padding: 1rem }
        .footer-link { color: var(--ink); text-decoration: none }
        .footer-link:hover { text-decoration: underline }

        .social a {
            width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;
            border-radius: 10px; border: 1px solid var(--border); background: #fff; margin-inline-start: .35rem;
            color: var(--ink); transition: transform .12s ease, box-shadow .12s ease;
        }
        .social a:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(0, 0, 0, .08) }

        .section-divider { height: 1px; background: linear-gradient(90deg, transparent, var(--border), transparent) }

        .mobile-cta {
            position: fixed; inset-inline: 0; bottom: 0; z-index: 1050; display: none; gap: .7rem;
            align-items: center; justify-content: space-between; padding: .7rem .9rem; background: var(--surface);
            border-top: 1px solid var(--border); box-shadow: 0 -8px 24px rgba(0, 0, 0, .08);
        }
        @media (max-width: 991.98px) { .mobile-cta { display: flex } }

        /* ===== HERO CARD STYLING ===== */
        .hero .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-1);
            overflow: hidden;
            transition: transform .18s ease, box-shadow .18s ease;
            background: #fff;
        }
        .hero .card:hover { transform: translateY(-4px); box-shadow: var(--shadow-2); }
        .hero .card img { display: block; width: 100%; height: 100%; object-fit: cover; }

        .card-tall { min-height: 460px; }
        .card-half { min-height: 220px; }
        @media (max-width: 575.98px) {
            .card-tall { min-height: 360px; }
            .card-half { min-height: 200px; }
        }

        /* ===== Product Tour (new showcase) ===== */
        .tour-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem;
            height: 100%;
            box-shadow: var(--shadow-1);
        }
        .tour-thumb {
            border: 1px solid var(--border);
            background: #fff;
            border-radius: 12px;
            padding: .35rem;
            cursor: pointer;
            transition: box-shadow .15s ease, border-color .15s ease, transform .1s ease;
        }
        .tour-thumb:hover { transform: translateY(-2px); box-shadow: var(--shadow-1); }
        .tour-thumb.active { border-color: var(--brand); box-shadow: 0 0 0 3px var(--ring); }

        /* ===== Small helpers for RTL spacing on pills in navbar ===== */
        .ms-1-rtl { margin-inline-start: .25rem; }
        .ms-2-rtl { margin-inline-start: .5rem; }
    </style>
</head>

<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg" id="siteNav" aria-label="شريط التصفح الرئيسي">
        <div id="scrollProgress" aria-hidden="true"></div>
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#" aria-label="QRevo الصفحة الرئيسية">
                <img src="{{ asset('assets/img/saas/qrevo_under.png') }}" alt="QRevo" height="52">
            </a>

            <!-- Desktop links -->
            <div class="nav-group d-none d-lg-flex align-items-center me-auto">
                <ul class="navbar-nav align-items-lg-center gap-1">
                    <li class="nav-item"><a class="nav-link" href="#features">المزايا</a></li>
                    <li class="nav-item"><a class="nav-link" href="#compare">المقارنة</a></li>
                    <li class="nav-item"><a class="nav-link" href="#showcase">المنتج</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">الأسعار</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">الأسئلة الشائعة</a></li>
                    <li class="nav-item ms-1-rtl"><a href="/login" class="btn btn-outline-primary">تسجيل الدخول</a></li>
                    <li class="nav-item ms-1-rtl"><a href="/register" class="btn btn-primary">تجربة مجانية</a></li>
                    <!-- Lang switcher -->
                    <li class="nav-item ms-2-rtl"><a href="?lang=fr" class="btn btn-light" title="Français">FR</a></li>
                </ul>
                <div class="nav-indicator" id="navIndicator"></div>
            </div>

            <!-- Mobile toggler -->
            <button class="navbar-toggler d-lg-none me-auto" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNav" aria-label="فتح القائمة">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Offcanvas mobile menu -->
    <div class="offcanvas offcanvas-end offcanvas-nav" tabindex="-1" id="offcanvasNav"
        aria-labelledby="offcanvasNavLabel">
        <div class="offcanvas-header">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/img/saas/qrevo_under.png') }}" alt="QRevo" height="28">
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="إغلاق"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group list-group-flush">
                <a class="list-group-item" href="#features" data-close>المزايا</a>
                <a class="list-group-item" href="#compare" data-close>المقارنة</a>
                <a class="list-group-item" href="#showcase" data-close>المنتج</a>
                <a class="list-group-item" href="#pricing" data-close>الأسعار</a>
                <a class="list-group-item" href="#faq" data-close>الأسئلة الشائعة</a>
                <a class="list-group-item" href="?lang=fr" data-close>Français</a>
            </div>
            <div class="d-grid gap-2 mt-3">
                <a href="/login" class="btn btn-outline-primary">تسجيل الدخول</a>
                <a href="/register" class="btn btn-primary">تجربة مجانية</a>
            </div>
        </div>
    </div>

    <!-- ===== HERO ===== -->
    <header id="overview" class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge-soft d-inline-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-lightning-charge-fill"></i> قائمة QR جاهزة خلال دقيقتين
                    </span>
                    <h1 class="display-5 mb-3">القائمة <span class="spark">الرقمية</span> التي تزيد من تحويل الزبائن</h1>
                    <p class="lead text-muted mb-4">حدّث الصور والأسعار فورًا، أنشئ رموز QR بهويتك، ترجمات بنقرة واحدة وتتبع الأداء في الوقت الحقيقي.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="/register" class="btn btn-primary btn-lg">ابدأ التجربة</a>
                        <a href="#showcase" class="btn btn-outline-primary btn-lg">شاهد المنتج</a>
                    </div>
                    <div class="d-flex gap-4 mt-4 flex-wrap text-muted small">
                        <div><strong>14</strong> يومًا تجربة • بدون بطاقة</div>
                        <div><i class="bi bi-shield-check"></i> نسخ احتياطي يومي</div>
                    </div>
                </div>

                <!-- HERO MOSAIC -->
                <div class="col-lg-6">
                    <div class="row g-3 align-items-stretch">
                        <!-- Big left image -->
                        <div class="col-12 col-sm-7">
                            <div class="card h-100 card-tall">
                                <img src="{{ asset('assets/img/saas/hero1.png') }}" alt="نظرة عامة: قائمة رقمية">
                                <div class="card-body text-center">
                                    <p class="small text-muted mb-0 fw-bolder">تجربة عميل سلسة</p>
                                </div>
                            </div>
                        </div>
                        <!-- Right column: two stacked -->
                        <div class="col-12 col-sm-5 d-flex flex-column gap-3">
                            <div class="card card-half">
                                <img src="{{ asset('assets/img/saas/hero2.png') }}" alt="رموز QR مخصّصة">
                                <div class="card-body text-center">
                                    <p class="small text-muted mb-0 fw-bolder">تجربة لا تُنسى</p>
                                </div>
                            </div>
                            <div class="card card-half">
                                <img src="{{ asset('assets/img/saas/hero3.png') }}" alt="إحصاءات مباشرة">
                                <div class="card-body text-center">
                                    <p class="small text-muted mb-0 fw-bolder">إحصاءات مباشرة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center small text-muted mt-2">عرض للقائمة الرقمية</div>
                </div>
            </div>

            <!-- Trust bar -->
            <div class="mt-5 pt-3">
                <div class="text-center text-muted mb-2">موثوق به من قِبل مقاهٍ ومطاعم وفنادق</div>
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                    <img src="{{ asset('assets/img/saas/clients/moca.png') }}" alt="كافيه موكا"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                    <img src="{{ asset('assets/img/saas/clients/safran.png') }}" alt="سافرَن & سِل"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                    <img src="{{ asset('assets/img/saas/clients/horizon.png') }}" alt="كافيه هورايزن"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                    <img src="{{ asset('assets/img/saas/clients/mariem.png') }}" alt="بولنجرية مريم"
                        style="height:44px;border-radius:10px;border:1px solid var(--border);box-shadow:0 .35rem .9rem rgba(0,0,0,.06);background:#fff"
                        loading="lazy">
                </div>
            </div>
        </div>
    </header>

    <!-- ===== METRICS ===== -->
    <section class="py-4" style="background:var(--surface)">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">+120</div>
                    <div class="text-muted small">منشأة</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">&lt;1s</div>
                    <div class="text-muted small">متوسط وقت التحميل</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">+18%</div>
                    <div class="text-muted small">زيادة مبيعات الحلويات*</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="h2 mb-1">90%</div>
                    <div class="text-muted small">تخفيض في تكاليف الطباعة</div>
                </div>
            </div>
            <div class="section-divider my-4"></div>
        </div>
    </section>

    <!-- ===== FEATURES ===== -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">مصمّم لعملائك وفريقك</h2>
                <p class="section-sub">قائمة واضحة، جميلة ودائمًا محدَّثة.</p>
            </div>

            <!-- Row 1 -->
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-pencil-square"></i></div>
                        <h6 class="fw-bold">محرر شديد السهولة</h6>
                        <p class="small text-muted mb-0">أضِف الأطباق والأسعار والصور والحساسيّات خلال ثوانٍ.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-qr-code"></i></div>
                        <h6 class="fw-bold">رموز QR مخصّصة</h6>
                        <p class="small text-muted mb-0">شعارك وألوانك، تنسيقات متعدّدة وتصدير SVG/PNG.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-translate"></i></div>
                        <h6 class="fw-bold">تعدد اللغات والعملات</h6>
                        <p class="small text-muted mb-0">العربية/الفرنسية/الإنجليزية + دعم RTL وأسعار بحسب العملة.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <h6 class="fw-bold">إحصاءات مباشرة</h6>
                        <p class="small text-muted mb-0">اكتشف الأطباق الأكثر أداءً وحسّن الهوامش.</p>
                    </div>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="row g-4 mt-1">
                <div class="col-md-6 col-lg-4">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-whatsapp"></i></div>
                        <h6 class="fw-bold">مشاركة اجتماعية</h6>
                        <p class="small text-muted mb-0">واتساب/إنستغرام بنقرة واحدة لزيادة الظهور.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-shield-check"></i></div>
                        <h6 class="fw-bold">أمان وامتثال</h6>
                        <p class="small text-muted mb-0">نسخ احتياطي يومي، استضافة أوروبية، متوافق مع RGPD.</p>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-bag-check"></i></div>
                        <h6 class="fw-bold">الطلب على الطاولة</h6>
                        <p class="small text-muted mb-0">
                            يطلب العملاء من الطاولة مع طباعة مباشرة للمطبخ أو الكاشير.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Row 3 -->
            <div class="row g-4 mt-1">
                <div class="col-12">
                    <div class="feature">
                        <div class="icon"><i class="bi bi-scooter"></i></div>
                        <h6 class="fw-bold">وكلاء التوصيل</h6>
                        <p class="small text-muted mb-0">
                            يمكن للوكلاء إدخال طلباتهم مباشرةً لمعالجة أسرع.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ===== COMPARISON ===== -->
    <section id="compare" class="compare">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">لماذا التحوّل إلى الرقمي؟</h2>
                <p class="section-sub">قارن بين القائمة الورقية والقائمة الرقمية من QRevo.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="compare-card h-100">
                        <h5 class="mb-3"><i class="bi bi-qr-code-scan me-2 text-success"></i> القائمة الرقمية (QRevo)</h5>
                        <ul class="compare-list">
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> تحديثات فورية (أسعار، صور، نفاد)</li>
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> تعدد اللغات والعملات + دعم RTL</li>
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> إحصاءات الاستخدام والاتجاهات</li>
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> رموز QR مخصّصة (علامة وهوية)</li>
                            <li><span class="icon icon-yes"><i class="bi bi-check"></i></span> تكاليف مُتحكَّم بها بلا إعادة طباعة</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="compare-card h-100">
                        <h5 class="mb-3"><i class="bi bi-file-earmark-text me-2 text-danger"></i> القائمة الورقية</h5>
                        <ul class="compare-list">
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> إعادة طباعة مع كل تغيير</li>
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> لا ترجمة أصلية ولا عملات</li>
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> دون إحصاءات استخدام</li>
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> دون صور تفاعلية أو حساسيّات واضحة</li>
                            <li><span class="icon icon-no"><i class="bi bi-x"></i></span> تكلفة متكررة مرتفعة</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/register" class="btn btn-primary btn-lg">جرّب مجانًا</a>
            </div>
        </div>
    </section>

    <!-- ===== PRODUCT TOUR ===== -->
    <section id="showcase" class="py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">اكتشف QRevo بنظرة سريعة</h2>
                <p class="section-sub">أداة متكاملة، مصمّمة لسهولة البدء وكفاءة العمل اليومي.</p>
            </div>

            <div class="row g-4 align-items-center">
                <!-- Left: big image with thumbs -->
                <div class="col-lg-6">
                    <div class="ratio ratio-16x9 rounded border shadow-sm overflow-hidden">
                        <img id="tourMain" src="{{ asset('assets/img/saas/editor.png') }}" alt="نظرة عامة على QRevo"
                            class="w-100 h-100" style="object-fit: cover;">
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button class="tour-thumb active" type="button"
                            data-src="{{ asset('assets/img/saas/editor.png') }}" aria-label="المحرر">
                            <img src="{{ asset('assets/img/saas/editor.png') }}" width="96" height="60"
                                style="object-fit: cover;border-radius:8px;">
                        </button>
                        <button class="tour-thumb" type="button"
                            data-src="{{ asset('assets/img/saas/qr-builder.png') }}" aria-label="مصمم QR">
                            <img src="{{ asset('assets/img/saas/qr-builder.png') }}" width="96" height="60"
                                style="object-fit: cover;border-radius:8px;">
                        </button>
                        <button class="tour-thumb" type="button"
                            data-src="{{ asset('assets/img/saas/analytics.png') }}" aria-label="التحليلات">
                            <img src="{{ asset('assets/img/saas/analytics.png') }}" width="96" height="60"
                                style="object-fit: cover;border-radius:8px;">
                        </button>
                    </div>
                    <div class="small text-muted mt-2">تصفّح الواجهات: المحرر، مصمم QR، والتحليلات.</div>
                </div>

                <!-- Right: benefit cards -->
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="tour-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="icon"><i class="bi bi-magic"></i></span>
                                    <h6 class="m-0 fw-bold">تحديث فوري</h6>
                                </div>
                                <p class="small text-muted mb-2">عدّل الأطباق والأسعار والصور والحساسيّات — وتظهر التغييرات فورًا للعميل.</p>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li>تحرير عبر المتصفح</li>
                                    <li>إدارة اللغات</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="tour-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="icon"><i class="bi bi-qr-code-scan"></i></span>
                                    <h6 class="m-0 fw-bold">رموز QR بهويتك</h6>
                                </div>
                                <p class="small text-muted mb-2">ألوان وشعار وتصدير عالي الدقة.</p>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li>شعار وألوان</li>
                                    <li>تصدير SVG/PNG</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="tour-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="icon"><i class="bi bi-bag-check"></i></span>
                                    <h6 class="m-0 fw-bold">الطلب على الطاولة</h6>
                                </div>
                                <p class="small text-muted mb-2">العميل يمسح، يطلب، وتصل الأوامر للمطبخ/الكاشير مباشرة.</p>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li>طباعة المطبخ</li>
                                    <li>تكامل مع الكاشير</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="tour-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="icon"><i class="bi bi-graph-up-arrow"></i></span>
                                    <h6 class="m-0 fw-bold">تحليلات مفيدة</h6>
                                </div>
                                <p class="small text-muted mb-2">افهم ما يراه عملاؤك وحسّن هوامشك.</p>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li>المشاهدات والاتجاهات</li>
                                    <li>الأطباق الأكثر أداءً</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <a href="/register" class="btn btn-primary">أنشئ حسابي</a>
                        <a href="/contact" class="btn btn-outline-primary">اطلب عرضًا توضيحيًا</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRICING ===== -->
    <section id="pricing" class="py-5">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">تسعير بسيط ومرن</h2>
                <p class="section-sub">تجربة مجانية 14 يومًا، ثم اختر الخطة المناسبة.</p>
                <div class="toggle mt-1" aria-live="polite">
                    <span class="seg" id="billMonthly">شهري</span>
                    <span class="seg active" id="billYearly">سنوي <span class="text-success">(−15%)</span></span>
                </div>
            </div>

            <div class="row g-4 justify-content-center mt-1">
                <!-- Menu Digital -->
                <div class="col-md-6 col-lg-4">
                    <div class="price-card p-4 h-100">
                        <h6 class="fw-bold">القائمة الرقمية</h6>
                        <div class="display-6 fw-extrabold my-2">
                            <span class="price" data-monthly="59" data-yearly="39">39</span> MAD
                            <span class="fs-6 fw-normal billing-label">/الشهر (فوترة سنوية)</span>
                        </div>
                        <p class="text-muted small">أفضل ما في قوائم QR الحديثة.</p>
                        <ul class="list-unstyled small mb-4">
                            <li><i class="bi bi-check2 text-success"></i> قائمة واحدة غير محدودة</li>
                            <li><i class="bi bi-check2 text-success"></i> رموز QR بالألوان والهوية</li>
                            <li><i class="bi bi-check2 text-success"></i> لغات وعملات متعددة</li>
                            <li><i class="bi bi-check2 text-success"></i> إحصاءات مفصلة</li>
                            <li><i class="bi bi-check2 text-success"></i> دعم قياسي</li>
                        </ul>
                        <a href="/register" class="btn btn-outline-primary w-100">تجربة مجانية 14 يومًا</a>
                    </div>
                </div>

                <!-- Commande & Agents -->
                <div class="col-md-6 col-lg-4">
                    <div class="price-card p-4 h-100 featured position-relative">
                        <span class="price-badge position-absolute top-0 start-0 mt-3 ms-3">الأكثر شيوعًا</span>
                        <h6 class="fw-bold">الطلبات والوكلاء</h6>
                        <div class="display-6 fw-extrabold my-2">
                            <span class="price" data-monthly="79" data-yearly="59">59</span> MAD
                            <span class="fs-6 fw-normal billing-label">/الشهر (فوترة سنوية)</span>
                        </div>
                        <p class="text-muted small">أضف الطلب على الطاولة ووكلاء التوصيل.</p>
                        <ul class="list-unstyled small mb-4">
                            <li><i class="bi bi-check2 text-success"></i> كل ميزات <strong>القائمة الرقمية</strong></li>
                            <li><i class="bi bi-check2 text-success"></i> الطلب على الطاولة (مسح وادفع*)</li>
                            <li><i class="bi bi-check2 text-success"></i> وكلاء توصيل مدمجون</li>
                            <li><i class="bi bi-check2 text-success"></i> طباعة للمطبخ/الكاشير</li>
                            <li><i class="bi bi-check2 text-success"></i> دعم أولوية</li>
                        </ul>
                        <a href="/register" class="btn btn-primary w-100">تجربة مجانية 14 يومًا</a>
                    </div>
                </div>

                <!-- POS Complet -->
                <div class="col-md-6 col-lg-4">
                    <div class="price-card p-4 h-100">
                        <h6 class="fw-bold">نظام نقاط بيع كامل</h6>
                        <div class="display-6 fw-extrabold my-2">
                            <span class="price" data-monthly="179" data-yearly="149">149</span> MAD
                            <span class="fs-6 fw-normal billing-label">/الشهر (فوترة سنوية)</span>
                        </div>
                        <p class="text-muted small">إدارة الكاشير وتقارير متقدمة.</p>
                        <ul class="list-unstyled small mb-4">
                            <li><i class="bi bi-check2 text-success"></i> كل ميزات <strong>الطلبات والوكلاء</strong></li>
                            <li><i class="bi bi-check2 text-success"></i> نظام نقاط بيع (POS)</li>
                            <li><i class="bi bi-check2 text-success"></i> جرد وتتبع أساسي</li>
                            <li><i class="bi bi-check2 text-success"></i> تقارير مبيعات متقدمة</li>
                            <li><i class="bi bi-check2 text-success"></i> دعم مخصّص</li>
                        </ul>
                    </div>
                </div>
            </div>

            <p class="text-center small text-muted mt-3">
                يُطبّق الخصم على الفوترة السنوية. الأسعار ملائمة للسوق المغربي.
            </p>
            <p class="text-center small mt-1">
                تحتاج موقعًا تعريفيًا؟ باقة ثابتة <strong>1449 MAD</strong> (بدون اسم نطاق).
            </p>
        </div>
    </section>



    <!-- ===== FAQ ===== -->
    <section id="faq" class="py-5" style="background:var(--surface)">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">الأسئلة الشائعة</h2>
                <p class="section-sub">كل ما تحتاج معرفته قبل البدء.</p>
            </div>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="fq1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#fq1c">كيف تعمل التجربة؟</button>
                    </h2>
                    <div id="fq1c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">تجربة لمدة 14 يومًا على جميع الخطط المدفوعة. ما لم تلغِ، يستمر الاشتراك بالسعر المختار.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="fq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#fq2c">هل يمكنني تغيير الخطة؟</button>
                    </h2>
                    <div id="fq2c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">نعم، في أي وقت من لوحة التحكم. يتم احتساب الفرق تلقائيًا.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="fq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#fq3c">هل أحتاج لإعادة الطباعة عند تعديل طبق؟</button>
                    </h2>
                    <div id="fq3c" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">لا، رمز QR يشير إلى رابط ديناميكي. تظهر تعديلاتك فورًا لدى العميل.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta text-center">
        <div class="container">
            <h2 class="fw-bold mb-2">جاهز لتحديث قائمتك؟</h2>
            <p class="mb-4">أنشئ أول قائمة QR خلال دقائق.</p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="/register" class="btn btn-light btn-lg">أنشئ حسابي</a>
                <a href="/contact" class="btn btn-outline-primary btn-lg">تحدث إلى خبير</a>
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
                            <img src="{{ asset('assets/img/saas/qrevo_under.png') }}" alt="QRevo">
                        </div>
                        <p class="small text-muted mb-3">
                            القائمة الرقمية الحديثة للمطاعم والمقاهي والفنادق. رموز QR مخصّصة، تعدد اللغات، وإحصاءات فورية.
                        </p>
                        <div class="social">
                            <a href="https://instagram.com" aria-label="إنستغرام"><i class="bi bi-instagram"></i></a>
                            <a href="https://facebook.com" aria-label="فيسبوك"><i class="bi bi-facebook"></i></a>
                            <a href="https://wa.me/" aria-label="واتساب"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Product links -->
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-3">المنتج</h6>
                    <ul class="list-unstyled small m-0">
                        <li class="mb-2"><a class="footer-link" href="#features">المزايا</a></li>
                        <li class="mb-2"><a class="footer-link" href="#compare">المقارنة</a></li>
                        <li class="mb-2"><a class="footer-link" href="#showcase">نظرة عامة</a></li>
                        <li class="mb-2"><a class="footer-link" href="#pricing">الأسعار</a></li>
                        <li class="mb-2"><a class="footer-link" href="#faq">الأسئلة الشائعة</a></li>
                    </ul>
                </div>

                <!-- Resources links -->
                <div class="col-6 col-lg-3">
                    <h6 class="fw-bold mb-3">الموارد</h6>
                    <ul class="list-unstyled small m-0">
                        <li class="mb-2"><a class="footer-link" href="/contact">اتصل بنا</a></li>
                        <li class="mb-2"><a class="footer-link" href="/privacy">سياسة الخصوصية</a></li>
                        <li class="mb-2"><a class="footer-link" href="/login">تسجيل الدخول</a></li>
                        <li class="mb-2"><a class="footer-link" href="/register">إنشاء حساب</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">النشرة البريدية</h6>
                    <p class="small text-muted mb-2">استلم نصائح لتحسين قائمتك الرقمية.</p>
                    <form id="newsletterForm" class="d-flex gap-2">
                        <input type="email" required class="form-control" placeholder="بريدك الإلكتروني">
                        <button class="btn btn-primary" type="submit">اشترك</button>
                    </form>
                    <div id="newsletterMsg" class="small mt-2" aria-live="polite"></div>
                </div>
            </div>

            <hr class="my-4" style="border-color:var(--border)">

            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between pb-4">
                <p class="small text-muted mb-2 mb-md-0">
                    &copy; 2025 QRevo Inc. جميع الحقوق محفوظة.
                </p>
                <div class="d-flex align-items-center gap-3">
                    <a href="?lang=fr" class="btn btn-outline-primary btn-sm" aria-label="التحويل إلى الفرنسية">FR</a>
                    <a href="#overview" class="btn btn-outline-primary btn-sm" id="toTopBtn" aria-label="العودة إلى الأعلى">
                        <i class="bi bi-arrow-up"></i> للأعلى
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile sticky CTA -->
    <div class="mobile-cta">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-qr-code-scan"></i>
            <span class="small">جرّب QRevo مجانًا</span>
        </div>
        <a href="/register" class="btn btn-primary btn-sm">أنشئ حسابك</a>
    </div>

    <!-- ========= SCRIPTS ========= -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        // Pricing toggle
        const billMonthly = document.getElementById('billMonthly');
        const billYearly = document.getElementById('billYearly');
        const priceEls = document.querySelectorAll('.price');
        const billingLabels = document.querySelectorAll('.billing-label');

        function setBilling(yearly) {
            billMonthly.classList.toggle('active', !yearly);
            billYearly.classList.toggle('active', yearly);
            priceEls.forEach(el => el.textContent = yearly ? el.dataset.yearly : el.dataset.monthly);
            billingLabels.forEach(l => l && (l.textContent = yearly ? '/الشهر (فوترة سنوية)' : '/الشهر'));
        }
        billMonthly?.addEventListener('click', () => setBilling(false));
        billYearly?.addEventListener('click', () => setBilling(true));
        // Default to ANNUAL
        setBilling(true);

        // Navbar behavior + progress
        const nav = document.getElementById('siteNav');
        const progress = document.getElementById('scrollProgress');
        const linkNodes = [...document.querySelectorAll('.navbar .nav-link[href^="#"]')];
        const sections = linkNodes.map(a => document.querySelector(a.getAttribute('href'))).filter(Boolean);

        function setProgress() {
            const st = document.documentElement.scrollTop || document.body.scrollTop;
            const h = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const pct = Math.max(0, Math.min(1, st / h));
            progress.style.width = (pct * 100).toFixed(2) + '%';
        }

        function setActiveOnScroll() {
            if (window.scrollY > 8) nav?.classList.add('scrolled');
            else nav?.classList.remove('scrolled');
            setProgress();

            let idx = -1;
            const fromTop = window.scrollY + 120;
            sections.forEach((sec, i) => {
                if (sec.offsetTop <= fromTop) idx = i;
            });
            linkNodes.forEach(l => l.classList.remove('active'));
            const active = idx >= 0 ? linkNodes[idx] : null;
            active?.classList.add('active');
        }

        linkNodes.forEach(l => {
            l.addEventListener('click', () => setTimeout(() => {}, 50));
        });

        window.addEventListener('scroll', setActiveOnScroll);
        window.addEventListener('load', setActiveOnScroll);

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
        const msg = document.getElementById('newsletterMsg');
        form?.addEventListener('submit', (e) => {
            e.preventDefault();
            msg.textContent = 'شكرًا! ستصلك نصائحنا قريبًا.';
            msg.className = 'small mt-2 text-success';
            form.reset();
            setTimeout(() => {
                msg.textContent = '';
                msg.className = 'small mt-2';
            }, 4000);
        });

        // Footer: back to top
        document.getElementById('toTopBtn')?.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Product tour thumbs
        const tourMain = document.getElementById('tourMain');
        document.querySelectorAll('.tour-thumb').forEach(btn => {
            btn.addEventListener('click', () => {
                const src = btn.getAttribute('data-src');
                if (tourMain && src) tourMain.src = src;
                document.querySelectorAll('.tour-thumb').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>
</body>

</html>
