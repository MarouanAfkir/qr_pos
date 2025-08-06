<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- ========= META ========= -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="QRivo هو أسرع حل للقائمة الرقمية الذكية لزيادة مبيعات مطعمك وتبسيط التحديثات دون الحاجة إلى طباعة.">
    <title>QRivo — القائمة الرقمية الذكية</title>

    <!-- ========= FONTS ========= -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Cairo لكل النصوص (عناوين ونصوص) مع Inter كاحتياطي للاتينية -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@600;700;800&display=swap"
        rel="stylesheet">

    <!-- ========= CSS & ICONS ========= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ---------- Color system ---------- */
        :root {
            --qr-primary: #ff6b35;
            --qr-secondary: #1e1e28;
            --qr-light-bg: #f8f9fc;
            --qr-success: #3cb371;
        }

        /* ---------- Base ---------- */
        body {
            font-family: 'Cairo', sans-serif;
            color: #343a40;
            scroll-behavior: smooth;
            background: #fff;
            direction: rtl;
            text-align: right;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Cairo', 'Inter', sans-serif;
            font-weight: 700;
        }

        .btn-primary {
            background: var(--qr-primary);
            border: none;
        }

        .btn-primary:hover {
            background: #ff8659;
        }

        .btn-outline-primary {
            border-color: var(--qr-primary);
            color: var(--qr-primary);
        }

        .btn-outline-primary:hover {
            background: var(--qr-primary);
            color: #fff;
        }

        .btn-outline-light {
            border-color: #fff;
            color: #fff;
        }

        .btn-outline-light:hover {
            background: #ffffff33;
        }

        /* ---------- Navbar ---------- */
        .navbar-brand {
            font-weight: 800;
            font-size: 1.35rem;
        }

        .nav-link {
            font-weight: 500;
        }

        .sticky-nav {
            transition: all .3s;
        }

        .sticky-nav.scrolled {
            background: #fff !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        }

        .sticky-nav.scrolled .nav-link,
        .sticky-nav.scrolled .navbar-brand {
            color: #000 !important;
        }

        /* ---------- Hero ---------- */
        .hero {
            background: linear-gradient(135deg, var(--qr-primary) 0%, #ffa94d 100%);
            color: #fff;
            padding: 7rem 0 6rem;
        }

        .hero img {
            max-width: 100%;
            filter: drop-shadow(0 1rem 2rem rgba(0, 0, 0, .2));
        }

        /* ---------- Feature cards ---------- */
        .feature-card {
            border: 0;
            border-radius: 1rem;
            padding: 2.5rem 1.8rem;
            text-align: center;
            background: #fff;
            box-shadow: 0 .5rem 1.25rem rgba(16, 24, 40, .05);
            transition: transform .3s, box-shadow .3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 .75rem 1.5rem rgba(16, 24, 40, .08);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            background: var(--qr-light-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: var(--qr-primary);
            margin: 0 auto 1.25rem;
        }

        /* ---------- Steps ---------- */
        .step-icon {
            font-size: 2.4rem;
            color: var(--qr-primary);
        }

        /* ---------- Pricing ---------- */
        .price-toggle .form-check-input {
            cursor: pointer;
            width: 3rem;
            height: 1.5rem;
            margin-left: .5rem;
            appearance: none;
            background: #adb5bd;
            border-radius: 25px;
            position: relative;
            transition: background .3s;
        }

        .price-toggle .form-check-input:checked {
            background: var(--qr-primary);
        }

        .price-toggle .form-check-input::before {
            content: '';
            position: absolute;
            height: 1.2rem;
            width: 1.2rem;
            top: 3px;
            right: 3px;
            background: #fff;
            border-radius: 50%;
            transition: transform .3s;
        }

        .price-toggle .form-check-input:checked::before {
            transform: translateX(-1.5rem);
        }

        .price-card {
            border-radius: 1rem;
            overflow: hidden;
            transition: transform .3s;
        }

        .price-card:hover {
            transform: translateY(-4px);
        }

        .price-card.featured {
            box-shadow: 0 .75rem 1.75rem rgba(16, 24, 40, .09);
            border: 2px solid var(--qr-primary);
        }

        .price-badge {
            background: var(--qr-primary);
            color: #fff;
            font-size: .75rem;
            padding: .2rem .6rem;
            border-radius: .5rem;
        }

        /* ---------- Testimonials ---------- */
        .testimonial-card {
            background: #fff;
            border: 0;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 .5rem 1.25rem rgba(16, 24, 40, .05);
        }

        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 1rem;
        }

        /* ---------- FAQ ---------- */
        .accordion-button:not(.collapsed) {
            background: var(--qr-light-bg);
            color: #000;
        }

        /* ---------- CTA Banner & Footer ---------- */
        .cta-banner {
            background: var(--qr-secondary);
            color: #fff;
            padding: 5rem 0;
        }

        footer {
            background: #13131a;
            color: #adb5bd;
            padding: 3rem 0;
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* ---------- Animations ---------- */
        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>

<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100 sticky-nav">
        <div class="container">
            <a class="navbar-brand text-white" href="#">
                <img src="{{ asset('assets/img/logo/accountLogo.png') }}" alt="QRivo Logo"
                    class="d-inline-block align-text-top" width="110">
            </a> <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link text-white" href="#features">الميزات</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#pricing">الأسعار</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#testimonials">آراء العملاء</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#faq">الأسئلة الشائعة</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/login">تسجيل الدخول</a></li>
                    <!-- Language Switcher -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="langDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">AR</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                            <li><a class="dropdown-item" href="/?lang=ar">العربية (AR)</a></li>
                            <li><a class="dropdown-item" href="/?lang=fr">Français (FR)</a></li>
                        </ul>
                    </li>
                </ul>
                <a href="#cta" class="btn btn-outline-light me-lg-3">جرّب مجانًا</a>
            </div>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <header class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-end">
                    <h1 class="display-5 fw-bold mb-3">قائمتك QR جاهزة خلال <span
                            class="text-decoration-underline">دقيقتين</span></h1>
                    <p class="lead mb-4">حدّث أطباقك، صورك وأسعارك في الوقت الحقيقي. لا طباعة ولا تطوير — فقط رمز QR
                        أنيق يليق بعملائك.</p>
                    <a href="#cta" class="btn btn-primary btn-lg ms-2">ابدأ التجربة المجانية</a>
                    <a href="#features" class="btn btn-outline-light btn-lg">استكشف</a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/img/saas/hero3.png') }}" alt="معاينة القائمة الرقمية" class="floating">
                </div>
            </div>
        </div>
    </header>

    <!-- ===== FEATURES ===== -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">مصمم لراحة عملائك وفريقك</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon"><i class="bi bi-pencil-square"></i></div>
                        <h5 class="fw-semibold mb-2">تحديثات فورية</h5>
                        <p class="small mb-0">أضف أو عدّل أطباقك في أي وقت عبر لوحة تحكم سهلة الاستخدام.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon"><i class="bi bi-translate"></i></div>
                        <h5 class="fw-semibold mb-2">متعدد اللغات والعملات</h5>
                        <p class="small mb-0">قدّم نفس القائمة بلغات وعملات مختلفة وارحب بكل زبون كأنه محلي.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon"><i class="bi bi-images"></i></div>
                        <h5 class="fw-semibold mb-2">صور وحساسية</h5>
                        <p class="small mb-0">شدّ شهية زبائنك بصور عالية الجودة وحدد مسببات الحساسية بوضوح.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <h5 class="fw-semibold mb-2">إحصاءات لحظية</h5>
                        <p class="small mb-0">تابع الأطباق الأكثر مشاهدة وغيّر قائمتك لزيادة المبيعات.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon"><i class="bi bi-whatsapp"></i></div>
                        <h5 class="fw-semibold mb-2">مشاركة عبر واتساب</h5>
                        <p class="small mb-0">اسمح لزبائنك بإرسال القائمة لأصدقائهم بنقرة واحدة.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                        <h5 class="fw-semibold mb-2">آمن ومتوافق</h5>
                        <p class="small mb-0">استضافة على خوادم موثوقة، نسخ احتياطي يومي، والامتثال الكامل للـ RGPD.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== HOW IT WORKS ===== -->
    <section class="py-5" style="background:var(--qr-light-bg);">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">كيفية العمل؟</h2>
            <div class="row text-center g-4">
                <div class="col-md-3">
                    <i class="bi bi-grid-1x2-fill step-icon mb-3"></i>
                    <h6 class="fw-semibold mb-2">١. أنشئ</h6>
                    <p class="small">أضف الفئات، الأطباق والوصف عبر الإنترنت.</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-upc-scan step-icon mb-3"></i>
                    <h6 class="fw-semibold mb-2">٢. أنشئ QR</h6>
                    <p class="small">حمّل رمز QR بشعارك وألوانك.</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-display step-icon mb-3"></i>
                    <h6 class="fw-semibold mb-2">٣. اعرض</h6>
                    <p class="small">اطبعه على الطاولات أو الملصقات أو الحوامل.</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-arrow-repeat step-icon mb-3"></i>
                    <h6 class="fw-semibold mb-2">٤. حدّث</h6>
                    <p class="small">عدّل الأطباق متى شئت — رمز QR يبقى كما هو.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRICING ===== -->
    <section id="pricing" class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-4">تسعير بسيط ومرن</h2>
            <!-- Toggle -->
            <div class="d-flex justify-content-center align-items-center mb-5 price-toggle">
                <span class="ms-2 fw-semibold">شهري</span>
                <input class="form-check-input" type="checkbox" id="billingToggle" aria-label="تبديل فترة الفوترة">
                <span class="fw-semibold me-2">سنوي <span class="text-success">(خصم 15%)</span></span>
            </div>

            <div class="row justify-content-center g-4">
                <!-- Free -->
                <div class="col-md-4">
                    <div class="card price-card h-100">
                        <div class="card-body text-center p-4">
                            <h5 class="fw-bold">مجاني</h5>
                            <p class="display-6 fw-bold my-3"><span class="price" data-monthly="0"
                                    data-yearly="0">0</span> درهم</p>
                            <p class="small mb-2">مثالي إذا كانت قائمتك صغيرة أو لديك قائمة واحدة</p>
                            <ul class="list-unstyled mb-4 small text-start">
                                <li>حتى <strong>10 أطباق</strong> مجانية</li>
                                <li>رمز QR أبيض وأسود</li>
                                <li>إحصاءات أساسية</li>
                                <li>وجود علامة QRivo</li>
                            </ul>
                            <a href="#cta" class="btn btn-outline-primary w-100">ابدأ الآن</a>
                        </div>
                    </div>
                </div>
                <!-- Starter -->
                <div class="col-md-4">
                    <div class="card price-card featured h-100">
                        <div class="card-body text-center p-4 position-relative">
                            <span class="price-badge position-absolute top-0 start-0 mt-3 ms-3">الأكثر شيوعًا</span>
                            <h5 class="fw-bold">Starter</h5>
                            <p class="display-6 fw-bold my-3">
                                <span class="price" data-monthly="69" data-yearly="59">69</span> درهم
                                <span class="fs-6 fw-normal">/شهر</span>
                            </p>
                            <p class="small mb-2">قائمة واحدة كاملة، عناصر غير محدودة</p>
                            <ul class="list-unstyled mb-4 small text-start">
                                <li>قائمة واحدة بعناصر غير محدودة</li>
                                <li>أكواد QR ملونة</li>
                                <li>متعدد اللغات والعملات</li>
                                <li>إحصاءات مفصلة</li>
                                <li>بدون علامة QRivo</li>
                            </ul>
                            <a href="#cta" class="btn btn-primary w-100">تجربة مجانية 14 يوم</a>
                        </div>
                    </div>
                </div>
                <!-- Pro -->
                <div class="col-md-4">
                    <div class="card price-card h-100">
                        <div class="card-body text-center p-4">
                            <h5 class="fw-bold">Pro</h5>
                            <p class="display-6 fw-bold my-3">
                                <span class="price" data-monthly="149" data-yearly="127">149</span> درهم
                                <span class="fs-6 fw-normal">/شهر</span>
                            </p>
                            <p class="small mb-2">لعدة قوائم واستخدام احترافي</p>
                            <ul class="list-unstyled mb-4 small text-start">
                                <li>قوائم غير محدودة</li>
                                <li>أكواد QR مخصصة</li>
                                <li>تكامل واتساب وإنستغرام</li>
                                <li>وصول لـ API / تصدير</li>
                                <li>دعم أولوية</li>
                            </ul>
                            <a href="#cta" class="btn btn-outline-primary w-100">تجربة مجانية 14 يوم</a>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center mt-3 small text-muted">يُطبَّق الخصم تلقائيًا على الاشتراك السنوي. لا توجد التزامات
                مخفية.</p>
        </div>
    </section>


    <!-- ===== TESTIMONIALS ===== -->
    <section id="testimonials" class="py-5" style="background:var(--qr-light-bg);">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">شركاؤنا يثقون بنا</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card h-100 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <img src="" alt="Avatar" class="testimonial-avatar">
                            <div>
                                <h6 class="mb-0 fw-semibold">أمين ب.</h6>
                                <small class="text-muted">صاحب مقهى أطلس</small>
                            </div>
                        </div>
                        <p class="mb-0 small">« منذ اعتماد QRivo لاحظ زبائننا سهولة الوصول للمعلومات، وقللنا تكاليف
                            الطباعة بنسبة ‎90%‎. »</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card h-100 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/img/avatars/avatar2.jpg') }}" alt="Avatar"
                                class="testimonial-avatar">
                            <div>
                                <h6 class="mb-0 fw-semibold">سلمى ر.</h6>
                                <small class="text-muted">مديرة — بيتزا نابولي</small>
                            </div>
                        </div>
                        <p class="mb-0 small">« دعم اللغات المتعددة أحدث فرقًا مع السياح. مبيعات الحلويات ارتفعت بفضل
                            الصور الشهية! »</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card h-100 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/img/avatars/avatar3.jpg') }}" alt="Avatar"
                                class="testimonial-avatar">
                            <div>
                                <h6 class="mb-0 fw-semibold">يوسف ك.</h6>
                                <small class="text-muted">مدير — فندق الواحة</small>
                            </div>
                        </div>
                        <p class="mb-0 small">« بفضل الإحصاءات نعرف الأطباق التي يجب إزالتها والأخرى التي يجب إبرازها.
                            التحديث فوري حتى لفروعنا الثلاثة. »</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section id="faq" class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">الأسئلة الشائعة</h2>
            <div class="accordion accordion-flush" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapse1">
                            كيف تعمل فترة التجربة؟
                        </button>
                    </h2>
                    <div id="faqCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">
                            ستحصل على جميع ميزات خطة Starter لمدة 14 يومًا دون الحاجة إلى بطاقة ائتمان. بعد انتهاء
                            الفترة، إذا لم تشترك في خطة مدفوعة، سيتحول حسابك تلقائيًا إلى الخطة المجانية.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapse2">
                            هل يمكنني تغيير خطتي في أي وقت؟
                        </button>
                    </h2>
                    <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">
                            نعم، يمكنك الترقية أو التخفيض بضغطة واحدة من لوحة التحكم، وسيتم حساب الفروقات تلقائيًا.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapse3">
                            هل أحتاج إلى إعادة طباعة رمز QR عند تغيير طبق؟
                        </button>
                    </h2>
                    <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">
                            لا، رمز QR يشير إلى رابط ديناميكي، وأي تحديث في لوحة التحكم يظهر مباشرةً لزبائنك.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA BANNER ===== -->
    <section id="cta" class="cta-banner text-center">
        <div class="container">
            <h2 class="fw-bold mb-3">مستعد للارتقاء بقائمتك؟</h2>
            <p class="mb-4">أنشئ قائمتك الرقمية الأولى مجانًا وأذهل زبائنك اليوم.</p>
            <a href="/register" class="btn btn-light btn-lg">أنشئ حسابي</a>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer>
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-md-6 text-md-end text-center">
                    <span class="fw-semibold text-white fs-5">QRivo</span>
                    <p class="small mb-0 mt-2">&copy; 2025&nbsp;QRivo Inc. جميع الحقوق محفوظة.</p>
                </div>
                <div class="col-md-6">
                    <ul class="list-inline mb-0 text-md-start text-center small">
                        <li class="list-inline-item"><a href="#features">الميزات</a></li>
                        <li class="list-inline-item"><a href="#pricing">الأسعار</a></li>
                        <li class="list-inline-item"><a href="#testimonials">آراء العملاء</a></li>
                        <li class="list-inline-item"><a href="#faq">الأسئلة الشائعة</a></li>
                        <li class="list-inline-item"><a href="/terms">الشروط والأحكام</a></li>
                        <li class="list-inline-item"><a href="/contact">اتصل بنا</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        /* Sticky navbar on scroll */
        const nav = document.querySelector('.sticky-nav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 30);
        });

        /* Pricing toggle */
        const toggle = document.getElementById('billingToggle');
        const priceEls = document.querySelectorAll('.price');
        const updatePrices = () => {
            priceEls.forEach(el => {
                const monthly = el.dataset.monthly;
                const yearly = el.dataset.yearly;
                el.textContent = toggle.checked ? yearly : monthly;
            });
        };
        toggle.addEventListener('change', updatePrices);
        updatePrices();
    </script>
</body>

</html>
