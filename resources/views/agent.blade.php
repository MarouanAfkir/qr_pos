{{-- resources/views/agent.blade.php --}}
@php
    use Illuminate\Support\Str;

    /* ---------- Locale & helpers ---------- */
    $default_language = request('lang', app()->getLocale() ?: 'en');
    app()->setLocale($default_language);

    $restaurantName    = $restaurant['name'] ?? 'Restaurant';
    $logo              = $restaurant['logo'] ?? null;
    $restaurantAddress = $restaurant['address'] ?? '';
    $phone1            = $restaurant['phone_number_1'] ?? '';
    $phone2            = $restaurant['phone_number_2'] ?? '';
    $tagline           = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';

    $rawMenuName = trim($menu['name'] ?? '');
    $menuTitle   = $rawMenuName && $rawMenuName !== $restaurantName ? $rawMenuName : __('Partner Ordering');
    $currency    = ' DH';

    $isRTL = in_array(strtolower($default_language), ['ar','he','fa','ur']);

    /* Cart scoping per restaurant (prevents cart leaking between restaurants) */
    $restaurantId  = $restaurant['id'] ?? null;
    $restaurantKey = $restaurantId !== null ? ('r' . $restaurantId) : Str::slug($restaurantName);

    /* Category popup mode via query ?category=popup */
    $categoryPopup = strtolower((string)request('category')) === 'popup';
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language }}" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurantName }} – {{ __('Delivery Partner Mode') }}</title>

    <!-- Assets -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- QR Code -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --brand:#6F4E37;
            --brand-2:#C49A6C;
            --cream:#FBF7F2;
            --ink:#1f2937;
            --muted:#6b7280;
            --chip:#fff7ea;
            --chip-b:#f2e4d3;
            --ring:rgba(196,154,108,.25);
            --accent:#facc15;
            --danger:#ef4444;
            --success:#16a34a;

            --header-top:#FFE9D1;
            --header-btm:#E8F5E9;
            --header-border:#e3eee5;
        }

        html { scroll-behavior:smooth }
        body {
            font-family:'Inter',system-ui,ui-sans-serif,Segoe UI,Roboto,Helvetica,Arial;
            background:var(--cream);
            color:var(--ink);
        }

        /* ===== HERO ===== */
        .hero {
            position:relative;
            background:linear-gradient(135deg,var(--header-top) 0%, var(--header-btm) 100%);
            color:var(--ink);
            text-align:center;
            padding:.85rem 1rem .85rem;
            border-bottom:1px solid var(--header-border);
        }
        .hero-inner { max-width:1100px; margin:0 auto; position:relative; }

        .hero-tools { position:absolute; top:.6rem; {{ $isRTL ? 'left' : 'right' }}:.6rem; display:flex; gap:.5rem; }
        .btn-pill {
            background:#fff;
            border:1px solid #e7d9c8;
            color:var(--ink);
            padding:.35rem .7rem; border-radius:999px; font-weight:700; font-size:.9rem;
            transition:.2s; box-shadow:0 2px 6px rgba(0,0,0,.05);
        }
        .btn-pill:hover { background:#fff9f2; }
        .hero .dropdown-menu {
            border:none; border-radius:.75rem; padding:.35rem; min-width:12rem;
            background:#fff; box-shadow:0 16px 36px rgba(0,0,0,.12);
        }
        .hero .dropdown-item { border-radius:.5rem; padding:.5rem .75rem; color:#111; }
        .hero .dropdown-item:hover { background:rgba(196,154,108,.12) }
        .hero .dropdown-item.active { background:linear-gradient(135deg,#fde7c7,#fff); font-weight:800 }

        .restaurant-logo-wrapper{
            width:124px;height:124px;margin:0 auto .55rem;border-radius:50%;
            background:#fff;display:flex;align-items:center;justify-content:center;
            box-shadow:0 4px 14px rgba(0,0,0,.14);transition:.2s;border:3px solid #f6efe6;overflow:hidden
        }
        .restaurant-logo-wrapper:hover{transform:translateY(-1px)}
        .restaurant-logo-wrapper img{width:86%;height:86%;object-fit:contain;border-radius:50%}
        .restaurant-name{font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:800;letter-spacing:.2px;margin:0}
        .hero-meta{display:flex;gap:.7rem;justify-content:center;flex-wrap:wrap;font-size:.9rem;margin-top:.3rem}
        .hero-meta i{margin-inline-end:.35rem}
        .tagline{color:#4f6c4f; font-style:italic; margin:.2rem 0 0}

        /* ===== AGENT MODE BANNER ===== */
        .agent-banner{
            display:grid; grid-template-columns: 48px 1fr; gap:.8rem; align-items:center;
            background:#fff1e6; border:1px solid #fed7aa; color:#7a3416; border-radius:14px;
            padding:.8rem .9rem; margin:.9rem auto 0; max-width:980px; box-shadow:0 8px 28px rgba(124,45,18,.06);
        }
        .agent-banner .icon-bubble{
            width:48px;height:48px;border-radius:12px;display:grid;place-items:center;
            background:#fff; border:1px solid #fed7aa; box-shadow:0 6px 16px rgba(0,0,0,.06);
            font-size:1.15rem;
        }
        .agent-banner .eyebrow{
            display:inline-flex; align-items:center; gap:.4rem;
            background:#fff; border:1px solid #fed7aa; color:#7a3416;
            border-radius:999px; padding:.15rem .55rem; font-weight:800; font-size:.75rem;
        }
        .agent-banner .headline{ font-weight:800; line-height:1.25; margin:.2rem 0 .2rem; font-size:1.05rem; }
        .agent-banner .grad{ background:linear-gradient(90deg,#a3512a,#e67e22 60%,#f59e0b); -webkit-background-clip:text; background-clip:text; color:transparent; }
        .agent-banner .sub{ font-size:.88rem; color:#8a4b1c; opacity:.9 }

        /* ===== STICKY TOOLS ===== */
        .sticky-tools{
            position:sticky; top:0; z-index:60;
            background:rgba(255,255,255,.92);
            backdrop-filter: blur(6px);
            border-bottom:1px solid #efe6db;
            padding:.45rem 0;
            margin-bottom:1.2rem;
        }
        .search-row{ display:flex; gap:.5rem; align-items:center; }
        #menuSearch{
            border-radius:999px; padding:.6rem 1rem; font-size:.98rem;
            border:2px solid var(--chip-b); background:#fff; transition:.2s; color:var(--ink); flex:1 1 auto;
        }
        #menuSearch::placeholder{color:#9b8f89}
        #menuSearch:focus{border-color:var(--brand-2); box-shadow:0 0 0 5px var(--ring); outline:0}

        /* Inline Categories button (popup mode) */
        .btn-cat-inline{
            border:2px solid var(--chip-b);
            background:var(--chip);
            color:#6b4b2f;
            border-radius:999px;
            padding:.55rem .9rem;
            font-weight:800;
            display:inline-flex; align-items:center; gap:.45rem;
            white-space:nowrap;
            box-shadow:0 2px 8px rgba(0,0,0,.04);
            transition:.15s;
        }
        .btn-cat-inline:hover{ transform:translateY(-1px); background:#fff7e6; box-shadow:0 6px 16px rgba(0,0,0,.08); }
        .btn-cat-inline i{ font-size:.95rem; }

        /* ===== CATEGORIES ===== */
        .categories-wrapper{position:relative}
        .categories-scroll{
            display:flex !important; flex-wrap:nowrap !important; gap:.5rem;
            margin:.1rem 0 .3rem; padding:0 1.2rem .4rem;
            overflow-x:auto; overflow-y:hidden; -webkit-overflow-scrolling:touch;
            scroll-snap-type:x mandatory; touch-action:pan-x;
            -ms-overflow-style:none; scrollbar-width:none;
        }
        .categories-scroll::-webkit-scrollbar{display:none}
        .categories-scroll .nav-item{flex:0 0 auto; scroll-snap-align:start}
        .categories-scroll .nav-link{
            padding:.5rem .95rem; font-size:.9rem; font-weight:800; color:#5a3d1b; white-space:nowrap;
            background:#fff7ee; border:1px solid rgba(196,154,108,.45);
            border-radius:14px; transition:.16s;
        }
        .categories-scroll .nav-link:hover{transform:translateY(-1px); box-shadow:0 4px 10px rgba(0,0,0,.06)}
        .categories-scroll .nav-link.active{color:#000; background:#f6e3cf; border-color:transparent; box-shadow:0 3px 10px rgba(0,0,0,.08)}
        .cat-nav{
            position:absolute; top:50%; transform:translateY(-50%); width:32px; height:32px; border-radius:50%;
            display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid var(--brand-2);
            box-shadow:0 2px 10px rgba(0,0,0,.08); color:#7a5200; font-size:.8rem; z-index:5
        }
        .cat-nav.disabled{opacity:0; pointer-events:none}
        .cat-prev{{ $isRTL ? ':right' : ':left' }}:.25rem;
        .cat-next{{ $isRTL ? ':left' : ':right' }}:.25rem;

        @media(min-width:576px){
            .categories-scroll{
                overflow:visible;
                display:grid !important;
                grid-template-columns: repeat(auto-fit, minmax(135px, max-content));
                justify-content:center; gap:.6rem; padding:0;
                margin-left:auto; margin-right:auto; max-width:1100px;
            }
            .cat-nav{display:none}
        }

        /* ===== CATEGORY SHEET (popup mode with improved drag) ===== */
        .category-sheet{
            height: var(--sheet-h, min(70vh, 520px));
            max-height: 100vh;
            border-top-left-radius:16px; border-top-right-radius:16px;
            box-shadow:0 -18px 40px rgba(0,0,0,.18);
            will-change: height;
            transition: height .18s ease;
        }
        .category-sheet.is-full{
            height: 100vh;
            height: 100dvh;
            border-top-left-radius:0; border-top-right-radius:0;
        }
        .category-sheet.is-dragging{
            transition: none;
            user-select: none;
        }

        /* BIGGER, CENTERED, DRAGGABLE HEADER */
        .category-sheet .offcanvas-header{
            position: relative;
            display:block; /* let us center content */
            text-align:center;
            padding: .6rem 3rem .4rem; /* wide side padding for the close button */
            cursor: grab;               /* entire header is a drag surface */
            -webkit-user-select: none;
            user-select: none;
        }
        .category-sheet.is-dragging .offcanvas-header{ cursor: grabbing; }
        .category-sheet .offcanvas-title{
            margin:0; font-weight:800; display:inline-flex; align-items:center; gap:.4rem;
        }
        .category-sheet .btn-close{
            position:absolute; top:.6rem; right:.75rem;
        }
        html[dir="rtl"] .category-sheet .btn-close{
            right:auto; left:.75rem;
        }

        /* Larger handle (also draggable) */
        .category-sheet .handle{
            width:56px; height:10px; border-radius:999px;
            background:#cfcfcf; margin:.3rem auto .25rem;
            cursor:inherit; /* inherits grab/grabbing from header state */
            touch-action:none;
        }

        .category-sheet .offcanvas-body{ overflow:auto }

        .cat-grid{
            display:grid; grid-template-columns: repeat(auto-fill, minmax(150px,1fr));
            gap:.6rem;
        }
        .cat-tile{
            display:flex; align-items:center; justify-content:space-between; gap:.6rem;
            background:#fff; border:1px solid var(--chip-b); border-radius:.9rem; padding:.7rem .8rem;
            font-weight:700; color:#5a3d1b; transition:.15s; cursor:pointer;
        }
        .cat-tile:hover{transform:translateY(-2px); box-shadow:0 8px 18px rgba(0,0,0,.08)}
        .cat-tile .qty{
            background:#fff7ee; border:1px solid var(--chip-b); color:#6b4b2f;
            font-size:.78rem; border-radius:999px; padding:.1rem .45rem;
        }

        /* ===== ITEMS ===== */
        .food-menu-section.section-padding{padding-top:0!important}
        .food-menu-tab-wrapper { padding-top:.2rem !important; }
        .title-area{padding-top:1rem; margin:.1rem 0 .5rem;}
        .sub-title{font-weight:800;color:#7a5200;letter-spacing:.2px}

        .single-menu-items{
            cursor:pointer; display:flex; gap:.9rem; padding:.85rem 1rem; margin-bottom:.85rem; background:#fff;
            border-radius:1rem; border:1px solid #efe6db; box-shadow:0 1px 3px rgba(0,0,0,.03); transition:.18s
        }
        .single-menu-items:hover{box-shadow:0 10px 22px rgba(0,0,0,.08); transform:translateY(-1px)}
        .menu-item-thumb{width:90px; aspect-ratio:1/1; border-radius:12px; overflow:hidden; flex-shrink:0; background:#f3f4f6}
        .menu-item-thumb img{width:100%; height:100%; object-fit:cover}
        .menu-content h3{font-weight:800; font-size:1.02rem; margin-bottom:.15rem}
        .chips{margin-top:.3rem}
        .chip{display:inline-block; background:var(--chip); border:1px solid var(--chip-b); color:#6b4b2f; font-size:.72rem; padding:.12rem .42rem; border-radius:999px; margin:0 .22rem .22rem 0}
        .price-wrap del{color:#9ca3af; margin-inline-end:.35rem}
        .save-badge{background:#dcfce7; color:#065f46; border-radius:6px; font-size:.72rem; padding:.1rem .35rem; margin-inline-start:.35rem; font-weight:700}

        /* ===== MODAL (options UI) ===== */
        #itemModal .modal-content{border:0; border-radius:1rem; box-shadow:0 10px 36px rgba(0,0,0,.18)}
        #itemModal .modal-header{
            background:#fff3cf; border-bottom:none; border-top-left-radius:1rem; border-top-right-radius:1rem; padding:.7rem 1rem;
        }
        #itemModal .modal-title{font-weight:800; color:#5f3b0e; font-size:1.25rem}
        #itemModal .modal-body{padding:1rem 1rem 1.15rem}
        @media (max-width:575.98px){
            #itemModal .modal-body{ text-align:center; }
            #itemModal img{ margin:0 auto; }
            #itemModal .qty-wrap{ justify-content:center; }
            #itemModal .cta-row{ justify-content:center; gap:.8rem; }
        }
        #itemModal img{width:120px; height:120px; object-fit:cover; border-radius:.8rem; box-shadow:0 6px 16px rgba(0,0,0,.1)}
        .lead-price{font-weight:800; color:var(--brand)}
        .v-group{margin:.85rem 0}
        .v-title{font-weight:800; margin-bottom:.5rem; text-transform:uppercase; letter-spacing:.4px;}
        .options-grid{ display:grid; gap:.55rem; grid-template-columns: repeat(auto-fill,minmax(140px,1fr)); }
        .option-card{ display:block; user-select:none; cursor:pointer; background:#fff; border:2px solid #f2e4d3; border-radius:.85rem; padding:.6rem .65rem; transition:.15s; height:100%; position:relative; }
        .option-card.disabled{opacity:.45; cursor:not-allowed}
        .option-input{position:absolute; opacity:0; pointer-events:none; width:0; height:0}
        .option-inner{display:flex; align-items:center; justify-content:space-between; gap:.75rem; position:relative;}
        .option-name{font-weight:800; color:#1f2937; text-transform:uppercase; letter-spacing:.3px;}
        .option-badge{background:#fff7ea; border:1px solid #f2e4d3; color:#6b4b2f; border-radius:.65rem; padding:.15rem .45rem; font-size:.8rem; white-space:nowrap}
        .option-card.is-selected{border-color: var(--brand-2); background:#fff9f2; box-shadow:0 0 0 4px var(--ring);}
        .option-card:focus-within{box-shadow:0 0 0 4px var(--ring);}
        .option-check{position:absolute; top:6px; {{ $isRTL ? 'left' : 'right' }}:6px; width:20px; height:20px; border-radius:50%; background:var(--brand); color:#fff; display:flex; align-items:center; justify-content:center; font-size:.7rem; opacity:0; transform:scale(.8); transition:.15s;}
        .option-card.is-selected .option-check{ opacity:1; transform:scale(1); }
        .option-input:checked + .option-inner{border-radius:.6rem}
        .option-hint{font-size:.85rem; color:#6b7280; margin-top:.15rem}

        .qty-wrap{display:flex; align-items:center; gap:.45rem}
        .qty-btn{width:32px; height:32px; display:flex; align-items:center; justify-content:center; border-radius:8px; border:1px solid var(--chip-b); background:var(--chip)}
        .qty-input{width:54px; text-align:center; border:1px solid var(--chip-b); background:#fff; border-radius:8px; padding:.3rem 0}
        .cta-row{display:flex; flex-wrap:wrap; align-items:center; gap:.6rem; justify-content:space-between; margin-top:.6rem}
        .btn-primary-cta{background:var(--brand); border:none; color:#fff; font-weight:800; padding:.55rem .95rem; border-radius:.7rem; box-shadow:0 10px 22px rgba(111,78,55,.22); transition:.15s}
        .btn-primary-cta:hover{background:#5c3f2e}
        .req-hint{font-size:.85rem; color:#b45309; display:none}

        /* ===== CART ===== */
        .cart-toggle{
            position:fixed; {{ $isRTL ? 'left' : 'right' }}:16px; bottom:16px; width:56px; height:56px; border-radius:50%;
            background:var(--brand); color:#fff; border:none; display:flex; align-items:center; justify-content:center;
            box-shadow:0 12px 28px rgba(0,0,0,.22); z-index:71;
        }
        .cart-toggle .badge{
            position:absolute; top:-6px; {{ $isRTL ? 'left' : 'right' }}:-6px; background:#ef4444; color:#fff; border-radius:999px; padding:.15rem .45rem; font-size:.7rem; font-weight:800
        }
        .cart{
            position:fixed; {{ $isRTL ? 'left' : 'right' }}:16px; bottom:16px; width:min(460px,94vw);
            background:#fff; border:1px solid #efe6db; box-shadow:0 14px 40px rgba(0,0,0,.18);
            border-radius:1rem; overflow:hidden; z-index:70; transform: translateY(110%); transition:.25s;
        }
        .cart.open{ transform: translateY(0) }
        .cart-header{display:flex; align-items:center; justify-content:space-between; gap:.5rem; padding:.6rem .9rem; background:#fff9f1; border-bottom:1px solid #f0e6da}
        .cart-body{max-height:46vh; overflow:auto; padding:.6rem .9rem}
        .cart-line{display:flex; gap:.7rem; padding:.55rem 0; border-bottom:1px dashed #e9e1d9}
        .cart-line:last-child{border-bottom:none}
        .cart-line img{width:48px;height:48px;border-radius:.5rem;object-fit:cover}
        .cart-line h6{margin:0; font-weight:800}
        .cart-line small{color:var(--muted)}
        .cart-qty{display:flex; align-items:center; gap:.35rem}
        .cart-qty button{width:26px;height:26px;border:1px solid var(--chip-b); background:var(--chip); border-radius:6px}
        .cart-footer{display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:.5rem; padding:.65rem .9rem; background:#fffaf3; border-top:1px solid #eee2d4}
        .btn-confirm{background:var(--success); color:#fff; border:none; padding:.5rem .9rem; border-radius:.6rem; font-weight:800}

        /* ===== CONFIRM / QR ===== */
        #confirmModal .modal-content{border:0;border-radius:1rem}
        #confirmModal .modal-header{background:#fff1e6;border:0}
        #qrBox{display:flex; align-items:center; justify-content:center; background:#fff; border:1px dashed #d1d5db; border-radius:.75rem; padding:1rem; min-height:220px}
        #qrActions .btn{border-radius:.6rem}

        /* Back to top */
        #toTop{position:fixed; {{ $isRTL ? 'left' : 'right' }}:90px; bottom:18px; width:42px;height:42px;border-radius:50%;background:var(--accent);color:#222;border:none;box-shadow:0 8px 22px rgba(0,0,0,.18);display:none;align-items:center;justify-content:center;z-index:60}
        #toTop:hover{background:#ffe16a}
    </style>
</head>

<body>

    {{-- ===== HERO ===== --}}
    <section class="hero">
        <div class="hero-inner">
            {{-- Lang switcher --}}
            <div class="hero-tools">
                <div class="dropdown">
                    <button class="btn-pill d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-globe"></i><span>{{ strtoupper($default_language) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($languages ?? [] as $lang)
                            <li>
                                <a class="dropdown-item d-flex justify-content-between {{ $lang['code'] == $default_language ? 'active' : '' }}"
                                   href="{{ request()->fullUrlWithQuery(['lang' => $lang['code']]) }}">
                                    <span>{{ strtoupper($lang['code']) }}</span>
                                    <small class="text-muted">{{ $lang['name'] }}</small>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Logo / title --}}
            <div class="restaurant-logo-wrapper">
                <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/logo.svg') }}" alt="Logo">
            </div>
            <h1 class="restaurant-name">{{ $restaurantName }}</h1>
            <p class="tagline">{{ $tagline }}</p>

            {{-- meta --}}
            <div class="hero-meta">
                @if($restaurantAddress)
                    <span><i class="fa-solid fa-location-dot"></i>{{ $restaurantAddress }}</span>
                @endif
                @if($phone1)
                    <span><i class="fa-solid fa-phone"></i>{{ $phone1 }}</span>
                @endif
                @if($phone2)
                    <span><i class="fa-solid fa-phone"></i>{{ $phone2 }}</span>
                @endif
            </div>

            {{-- Agent banner --}}
            <div class="agent-banner" role="status" aria-live="polite">
                <div class="icon-bubble"><i class="fa-solid fa-truck-fast"></i></div>
                <div class="copy text-start">
                    <span class="eyebrow"><i class="fa-solid fa-shield-check"></i> {{ __('Partner Mode') }}</span>
                    <div class="headline">{{ __('Build the cart and') }} <span class="grad">{{ __('send via WhatsApp') }}</span> {{ __('(QR optional)') }}</div>
                    <div class="sub">{{ __('No extra form — restaurants will recognize you on WhatsApp.') }}</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Sticky tools (search + categories) ===== --}}
    <div class="sticky-tools">
        <div class="container">
            <div class="row g-2 align-items-center justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="search-row">
                        <input id="menuSearch" type="search" class="form-control" placeholder="{{ __('Search menu…') }}" aria-label="{{ __('Search menu…') }}">
                        @if($categoryPopup)
                            <button type="button" id="openCategories" class="btn-cat-inline" title="{{ __('Categories') }}" aria-label="{{ __('Open categories') }}" aria-haspopup="dialog" aria-controls="categoriesSheet">
                                <i class="fa-solid fa-list-ul"></i>
                                <span class="d-none d-sm-inline">{{ __('Categories') }}</span>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <div class="categories-wrapper">
                        @if(!$categoryPopup)
                            <button type="button" class="cat-nav cat-prev" aria-label="{{ __('Scroll categories') }}"><i class="fa-solid fa-chevron-{{ $isRTL ? 'right' : 'left' }}"></i></button>
                            <ul class="nav categories-scroll justify-content-center" id="pills-tab" role="tablist" aria-label="{{ __('Categories') }}">
                                @foreach ($categories as $cat)
                                    @php $slug = Str::slug($cat['name']); @endphp
                                    <li class="nav-item">
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                id="pills-{{ $slug }}-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-{{ $slug }}" type="button" role="tab"
                                                aria-controls="pills-{{ $slug }}"
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                            {{ $cat['name'] }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <button type="button" class="cat-nav cat-next" aria-label="{{ __('Scroll categories') }}"><i class="fa-solid fa-chevron-{{ $isRTL ? 'left' : 'right' }}"></i></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Menu (container) ===== --}}
    <section class="food-menu-section fix section-padding">
        <div class="food-menu-wrapper style1">
            <div class="container">
                <div class="food-menu-tab-wrapper style-bg px-1 px-md-5">

                    <!-- title -->
                    <div class="title-area">
                        <div class="sub-title text-center">
                            <img class="me-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="">
                            {{ $menuTitle }}
                            <img class="ms-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="">
                        </div>
                    </div>

                    <div class="food-menu-tab">
                        <div class="tab-content" id="pills-tabContent">
                            @foreach ($categories as $cat)
                                @php
                                    $slug    = Str::slug($cat['name']);
                                    $columns = array_chunk($cat['items'], ceil(max(count($cat['items']), 1) / 2));
                                @endphp
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                     id="pills-{{ $slug }}" role="tabpanel" aria-labelledby="pills-{{ $slug }}-tab">
                                    <div class="row gx-4">
                                        @foreach ($columns as $colItems)
                                            <div class="col-lg-6 col-md-6">
                                                @foreach ($colItems as $item)
                                                    @php
                                                        $price      = number_format($item['price'], 2);
                                                        $salePrice  = $item['sale_price'];
                                                        $img        = $item['image'] ?? asset('assets/img/menu/menuThumb1_1.png');
                                                        $priceHtml  = $salePrice
                                                            ? '<del>' . $price . $currency . '</del> ' .
                                                              '<span class=&quot;fw-semibold&quot; style=&quot;color:var(--brand)&quot;>' . number_format($salePrice, 2) . $currency . '</span>'
                                                            : '<span class=&quot;fw-semibold&quot; style=&quot;color:var(--brand)&quot;>' . $price . $currency . '</span>';

                                                        $base       = $salePrice ?: $item['price'];
                                                        $ingredients = $item['ingredients'] ?? '';
                                                        $chips = array_filter(array_map('trim', explode(',', (string)$ingredients)));
                                                        $savings = $salePrice ? max(0, $item['price'] - $salePrice) : 0;

                                                        $minQty = $item['min_qty'] ?? 1;
                                                        $maxQty = $item['max_qty'] ?? null;
                                                    @endphp
                                                    <div class="single-menu-items"
                                                         role="button" tabindex="0"
                                                         data-name="{{ e($item['name']) }}"
                                                         data-desc="{{ e($item['description'] ?? '') }}"
                                                         data-img="{{ $img }}"
                                                         data-price="{!! $priceHtml !!}"
                                                         data-base="{{ number_format($base,2,'.','') }}"
                                                         data-minqty="{{ (int)$minQty }}"
                                                         data-maxqty="{{ $maxQty ? (int)$maxQty : '' }}"
                                                         data-ingredients="{{ e($ingredients) }}"
                                                         data-variations='@json($item["variations"] ?? [])'>
                                                        <div class="menu-item-thumb">
                                                            <img src="{{ $img }}" alt="{{ $item['name'] }}" loading="lazy">
                                                        </div>
                                                        <div class="menu-content flex-grow-1">
                                                            <div class="d-flex align-items-start justify-content-between">
                                                                <h3 class="fw-semibold">{{ $item['name'] }}</h3>
                                                                <div class="price-wrap text-nowrap ms-2">
                                                                    {!! $priceHtml !!}
                                                                    @if($savings>0)
                                                                        <span class="save-badge">{{ __('Save') }} {{ number_format($savings,2).$currency }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if ($item['description'])
                                                                <p class="mb-1 small text-muted">{{ $item['description'] }}</p>
                                                            @endif
                                                            @if(count($chips))
                                                                <div class="chips">
                                                                    @foreach($chips as $c)
                                                                        <span class="chip">{{ $c }}</span>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="searchResults" class="row gx-4 d-none" aria-live="polite"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Footer ===== --}}
    <footer class="simple-footer text-center">
        <div class="container">
            <p class="mb-2">&copy; {{ now()->year }} <a href="#">{{ $restaurantName }}</a>.
                {{ __('All rights reserved.') }}</p>
            <p class="mb-0 small">{{ __('Crafted with') }} <i class="fa-solid fa-heart" style="color:var(--brand)"></i>
                {{ __('for couriers & restaurants') }}</p>
        </div>
    </footer>

    {{-- Back to top --}}
    <button id="toTop" aria-label="{{ __('Back to top') }}"><i class="fa-solid fa-arrow-up"></i></button>

    {{-- ===== Item Modal ===== --}}
    <div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-semibold"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column flex-sm-row align-items-sm-start gap-3">
                        <img id="modalImg" src="" alt="">
                        <div class="flex-grow-1">
                            <p id="modalDesc" class="mb-2"></p>
                            <h5 id="modalPrice" class="lead-price mb-3"></h5>

                            <div id="modalOptions"></div>

                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <div class="qty-wrap">
                                    <button class="qty-btn" id="qtyMinus" aria-label="{{ __('Decrease quantity') }}"><i class="fa-solid fa-minus"></i></button>
                                    <input id="qtyInput" class="qty-input" type="number" value="1" min="1" step="1">
                                    <button class="qty-btn" id="qtyPlus" aria-label="{{ __('Increase quantity') }}"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                <div class="req-hint" id="reqHint">{{ __('Please complete the required selections.') }}</div>
                            </div>

                            <div class="cta-row">
                                <button id="addToCart" class="btn-primary-cta">
                                    <i class="fa-solid fa-cart-plus me-1"></i> {{ __('Add to Cart') }}
                                </button>
                                <div class="small text-muted" id="perUnitNote">{{ __('Price per unit incl. selected options') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Floating Cart ===== --}}
    <button class="cart-toggle" id="cartToggle" title="{{ __('Open cart') }}">
        <i class="fa-solid fa-bag-shopping"></i>
        <span class="badge" id="cartCount">0</span>
    </button>
    <div class="cart" id="cart">
        <div class="cart-header">
            <div class="fw-bold"><i class="fa-solid fa-receipt me-1"></i>{{ __('Your Order') }}</div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary" id="clearCart"><i class="fa-solid fa-trash-can"></i> {{ __('Clear') }}</button>
            </div>
        </div>
        <div class="cart-body" id="cartBody"></div>
        <div class="cart-footer">
            <div class="fw-bold">{{ __('Total') }}: <span id="cartTotal">0{{ $currency }}</span></div>
            <button class="btn-confirm" id="confirmBtn"><i class="fa-brands fa-whatsapp me-1"></i>{{ __('Confirm & Send via WhatsApp') }}</button>
        </div>
    </div>

    {{-- ===== Confirm / QR Modal ===== --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-truck me-1"></i> {{ __('Order Summary & QR') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <h6 class="fw-bold mb-2">{{ __('Order Details') }}</h6>
                            <div id="confirmSummary" class="small"></div>

                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <a class="btn btn-success btn-sm" id="whShare" target="_blank" rel="noopener">
                                    <i class="fa-brands fa-whatsapp"></i> {{ __('Send via WhatsApp') }}
                                </a>
                                <button class="btn btn-outline-success btn-sm" id="whShareQR">
                                    <i class="fa-brands fa-whatsapp"></i> {{ __('Share QR (image)') }}
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="copySummary">
                                    <i class="fa-regular fa-copy"></i> {{ __('Copy summary') }}
                                </button>
                            </div>
                            <div class="text-muted small mt-2" id="shareHint" style="display:none;">
                                {{ __('Your device/browser does not support sharing images directly. Use WhatsApp text share or download the QR below.') }}
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6 class="fw-bold mb-2">{{ __('Scan at Counter') }}</h6>
                            <div id="qrBox"><div id="qrcode"></div></div>
                            <div id="qrActions" class="d-flex gap-2 mt-3">
                                <button class="btn btn-outline-secondary btn-sm" id="regenQR"><i class="fa-solid fa-rotate"></i> {{ __('Regenerate') }}</button>
                                <a class="btn btn-outline-primary btn-sm" id="downloadQR"><i class="fa-solid fa-download"></i> {{ __('Download') }}</a>
                                <button class="btn btn-outline-success btn-sm" id="printQR"><i class="fa-solid fa-print"></i> {{ __('Print') }}</button>
                            </div>
                            <div class="text-muted small mt-2">{{ __('Keep this QR handy. Staff can scan it to retrieve your order instantly.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <small class="text-muted me-auto">{{ __('Privacy: the QR only contains order data.') }}</small>
                    <button class="btn btn-primary" data-bs-dismiss="modal">{{ __('Done') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Category Sheet (popup mode only) ===== --}}
    @if($categoryPopup)
    <div class="offcanvas offcanvas-bottom category-sheet" tabindex="-1" id="categoriesSheet" aria-labelledby="categoriesLabel">
        <div class="handle" aria-hidden="true"></div>
        <div class="offcanvas-header pb-2">
            <h6 class="offcanvas-title fw-bold" id="categoriesLabel"><i class="fa-solid fa-list pe-1"></i> {{ __('Browse Categories') }}</h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="{{ __('Close') }}"></button>
        </div>
        <div class="offcanvas-body pt-0">
            <div class="mb-3">
                <input id="catFilter" type="search" class="form-control form-control-sm" placeholder="{{ __('Filter categories…') }}" aria-label="{{ __('Filter categories…') }}">
            </div>
            <div class="cat-grid" role="listbox" aria-label="{{ __('Categories') }}">
                @foreach($categories as $cat)
                    @php
                        $slug = Str::slug($cat['name']);
                        $count = is_countable($cat['items'] ?? null) ? count($cat['items']) : 0;
                    @endphp
                    <button class="cat-tile" type="button" data-slug="{{ $slug }}" data-name="{{ Str::lower($cat['name']) }}" role="option" aria-selected="false">
                        <span class="name text-truncate">{{ $cat['name'] }}</span>
                        <span class="qty">{{ $count }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- JS assets -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        const IS_CAT_POPUP = @json($categoryPopup);

        /* ===== WhatsApp target (test) ===== */
        const WA_NUMBER = '212643714062';

        /* ===== Helpers ===== */
        function formatMoney(val){ return (parseFloat(val).toFixed(2)) + '{{ $currency }}'; }
        function escapeRegExp(s){ return s.replace(/[.*+?^${}()|[\]\\]/g,'\\$&'); }
        function highlight(text, q){ if(!q) return text; const re = new RegExp(`(${escapeRegExp(q)})`,'ig'); return text.replace(re,'<mark>$1</mark>'); }
        function shortHash(str){
            let h = 2166136261 >>> 0;
            for (let i=0;i<str.length;i++){ h ^= str.charCodeAt(i); h = Math.imul(h, 16777619); }
            return (h >>> 0).toString(36).slice(0,6).toUpperCase();
        }

        /* ===== Category arrows (normal mode) ===== */
        const catStrip = document.querySelector('.categories-scroll');
        const prevBtn  = document.querySelector('.cat-prev');
        const nextBtn  = document.querySelector('.cat-next');
        function updateArrows() {
            if (!catStrip) return;
            const max = catStrip.scrollWidth - catStrip.clientWidth - 1;
            prevBtn?.classList.toggle('disabled', catStrip.scrollLeft <= 0);
            nextBtn?.classList.toggle('disabled', catStrip.scrollLeft >= max);
        }
        prevBtn?.addEventListener('click', () => catStrip.scrollBy({ left: -260, behavior: 'smooth' }));
        nextBtn?.addEventListener('click', () => catStrip.scrollBy({ left:  260, behavior: 'smooth' }));
        catStrip?.addEventListener('scroll', updateArrows);
        window.addEventListener('resize', updateArrows);
        updateArrows();

        /* Scroll active pill into view (normal mode) */
        document.querySelectorAll('#pills-tab button[data-bs-toggle="pill"]').forEach(btn => {
            btn.addEventListener('shown.bs.tab', e => {
                e.target.scrollIntoView({ behavior:'smooth', inline:'center', block:'nearest' });
            });
        });

        /* Back to top */
        const toTop = document.getElementById('toTop');
        window.addEventListener('scroll', () => { toTop.style.display = window.scrollY > 500 ? 'flex' : 'none'; });
        toTop.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));

        /* Live search with highlight */
        $('#menuSearch').on('input', function () {
            const q = $(this).val().trim().toLowerCase();
            const $pills = $('#pills-tab'),
                  $panes = $('#pills-tabContent'),
                  $res   = $('#searchResults').empty();

            if (!q) {
                $res.addClass('d-none');
                $pills.removeClass('d-none');
                $panes.removeClass('d-none');
                return;
            }
            $pills.addClass('d-none');
            $panes.addClass('d-none');
            $res.removeClass('d-none');

            $('.single-menu-items').each(function () {
                const $it = $(this);
                const n   = ($it.data('name') || '');
                const d   = ($it.data('desc') || '');
                if (n.toLowerCase().includes(q) || d.toLowerCase().includes(q)) {
                    const $clone = $it.clone();
                    $clone.find('h3').html(highlight(n, q));
                    if (d) $clone.find('p.small').html(highlight(d, q));
                    $('<div class="col-lg-6 col-md-6"></div>').append($clone).appendTo($res);
                }
            });
            if (!$res.children().length) {
                $res.html('<p class="text-center py-4 text-muted">{{ __('No items match your search.') }}</p>');
            }
        });

        /* ===== Modal logic (options) ===== */
        const itemModal = new bootstrap.Modal(document.getElementById('itemModal'));
        let currentItem = null;

        function renderVariations(variations){
            if (!variations || !variations.length) return '';
            let html = '';
            variations.forEach((v, vIdx) => {
                const isSingle = (parseInt(v.max_selections||1,10) === 1);
                const maxSel   = parseInt(v.max_selections||1,10);
                const minSel   = parseInt(v.min_selections|| (v.is_required ? 1 : 0),10);
                const vid = v.id || ('v'+vIdx);

                html += `<div class="v-group" data-vid="${vid}" data-single="${isSingle?1:0}" data-min="${minSel}" data-max="${maxSel}">
                            <div class="v-title">${(v.name||'').toString().toUpperCase()}${v.is_required ? ' <span class="text-danger">*</span>' : ''}</div>
                            <div class="options-grid">`;

                (v.options||[]).forEach((o, oIdx) => {
                    const disabled = String(o.is_available)==='0';
                    const def = String(o.is_default)==='1';
                    const adj = parseFloat(o.price_adjustment||0) || 0;
                    const inputType = isSingle ? 'radio' : 'checkbox';
                    const nameAttr  = isSingle ? `name="var_${vid}"` : '';
                    const oid = o.id || ('o'+oIdx);
                    const badge = adj ? `<div class="option-badge">+${adj.toFixed(2)}{{ $currency }}</div>` : '';

                    html += `
                        <label class="option-card ${disabled?'disabled':''}" ${isSingle ? 'role="radio"' : 'role="checkbox"'} aria-checked="false">
                            <input class="option-input" type="${inputType}" ${nameAttr} value="${oid}" data-adj="${adj}" ${def?'data-default="1"':''} ${disabled?'disabled':''}>
                            <div class="option-inner">
                                <div class="option-name">${(o.name||'').toString().toUpperCase()}</div>
                                ${badge}
                                <span class="option-check" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                            </div>
                        </label>
                    `;
                });

                html += `</div>`;
                if(!isSingle){
                    html += `<div class="option-hint">{{ __('You can select up to') }} ${maxSel} {{ __('option(s)') }}</div>`;
                }
                html += `</div>`;
            });
            return html;
        }

        function recalcPrice(){
            if(!currentItem) return;
            const base = parseFloat(currentItem.base);
            let adj = 0;
            document.querySelectorAll('#modalOptions .option-input:checked').forEach(inp=>{
                adj += parseFloat(inp.getAttribute('data-adj')||0);
            });
            const unit = base + adj;
            const qty  = parseInt(document.getElementById('qtyInput').value,10) || 1;
            document.getElementById('modalPrice').innerHTML = formatMoney(unit);
            return {unit, total: unit*qty};
        }

        function validateRequired(){
            let ok = true;
            document.querySelectorAll('#modalOptions .v-group').forEach(group=>{
                const min = parseInt(group.getAttribute('data-min')||0,10);
                if(min>0){
                    const sel = group.querySelectorAll('.option-input:checked').length;
                    if(sel < min){ ok = false; }
                }
            });
            document.getElementById('addToCart').disabled = !ok;
            document.getElementById('reqHint').style.display = ok ? 'none' : 'block';
            return ok;
        }

        function enforceMax(groupEl, changedInput){
            const single = groupEl.getAttribute('data-single') === '1';
            const max = parseInt(groupEl.getAttribute('data-max')|| (single?1:99),10);
            if(single){ return; }
            const checked = groupEl.querySelectorAll('.option-input:checked');
            if(checked.length > max){
                changedInput.checked = false;
                groupEl.style.transform='scale(1.01)'; setTimeout(()=>groupEl.style.transform='',120);
            }
        }

        function applyDefaults(){
            document.querySelectorAll('#modalOptions .v-group').forEach(group=>{
                const single = group.getAttribute('data-single') === '1';
                const inputs = group.querySelectorAll('.option-input:not([disabled])');
                const defs   = group.querySelectorAll('.option-input[data-default="1"]:not([disabled])');
                if(defs.length){
                    if(single){ defs[0].checked = true; } else { defs.forEach(d=> d.checked = true); }
                }else{
                    const min = parseInt(group.getAttribute('data-min')||0,10);
                    if(min>0 && inputs.length===1){ inputs[0].checked = true; }
                }
            });
        }

        function refreshSelectionStyles(){
            $('#modalOptions .option-card').each(function(){
                const input = $(this).find('.option-input')[0];
                const on = !!(input && input.checked);
                $(this).toggleClass('is-selected', on).attr('aria-checked', on ? 'true' : 'false');
            });
        }

        function gatherSelections(){
            const selections = [];
            document.querySelectorAll('#modalOptions .v-group').forEach(group=>{
                const raw = group.querySelector('.v-title').textContent.replace('*','').trim();
                const vName = raw; // already uppercase
                const opts = [];
                group.querySelectorAll('.option-input:checked').forEach(inp=>{
                    const name = (inp.closest('.option-card').querySelector('.option-name')?.textContent || '').toUpperCase();
                    const adj  = parseFloat(inp.getAttribute('data-adj')||0);
                    opts.push({name, adj});
                });
                if(opts.length) selections.push({name:vName, options:opts});
            });
            return selections;
        }

        $(document).on('click keydown', '.single-menu-items', function (e) {
            if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;

            const $el = $(this);
            const base = parseFloat($el.data('base'));
            const minqty = parseInt($el.data('minqty')||1,10);
            const maxqty = parseInt($el.data('maxqty')||0,10) || null;

            $('#itemModal .modal-title').text($el.data('name'));
            $('#modalImg').attr('src', $el.data('img'));
            $('#modalDesc').text($el.data('desc') || '{{ __("No description available.") }}');
            $('#modalPrice').html($el.data('price'));

            const variations = JSON.parse($el.attr('data-variations') || '[]');
            const optsHtml = renderVariations(variations);
            $('#modalOptions').html(optsHtml);

            $('#qtyInput').attr({min:minqty}).val(minqty);
            if(maxqty){ $('#qtyInput').attr({max:maxqty}); } else { $('#qtyInput').removeAttr('max'); }

            currentItem = {
                name: $el.data('name'),
                img:  $el.data('img'),
                base: base,
                minqty, maxqty,
                currency: '{{ $currency }}'
            };

            $('#modalOptions').off('change').on('change', '.option-input', function(){
                enforceMax(this.closest('.v-group'), this);
                refreshSelectionStyles();
                validateRequired(); recalcPrice();
            });

            applyDefaults();
            refreshSelectionStyles();
            validateRequired(); recalcPrice();

            itemModal.show();
        });

        // qty controls
        $('#qtyMinus').on('click', function(){
            const inp = $('#qtyInput')[0];
            const min = parseInt(inp.min||1,10);
            inp.value = Math.max(min, (parseInt(inp.value||min,10)-1));
            recalcPrice();
        });
        $('#qtyPlus').on('click', function(){
            const inp = $('#qtyInput')[0];
            const max = parseInt(inp.max||0,10) || Infinity;
            inp.value = Math.min(max, (parseInt(inp.value||1,10)+1));
            recalcPrice();
        });
        $('#qtyInput').on('input', function(){
            const min = parseInt(this.min||1,10);
            const max = parseInt(this.max||0,10) || Infinity;
            let v = parseInt(this.value||min,10);
            if(isNaN(v)) v=min;
            v = Math.max(min, Math.min(max, v));
            this.value = v;
            recalcPrice();
        });

        /* ===== Agent Cart (localStorage) ===== */
        const RESTAURANT_KEY = @json($restaurantKey);
        const cartKey   = 'agentCart:' + RESTAURANT_KEY;
        const lastKey   = 'agentLastOrder:' + RESTAURANT_KEY;

        const cart      = document.getElementById('cart');
        const cartToggle= document.getElementById('cartToggle');
        const cartBody  = document.getElementById('cartBody');
        const cartTotal = document.getElementById('cartTotal');
        const cartCount = document.getElementById('cartCount');
        const clearCart = document.getElementById('clearCart');

        function getCart(){ try { return JSON.parse(localStorage.getItem(cartKey)||'[]'); } catch(e){ return []; } }
        function setCart(arr){ localStorage.setItem(cartKey, JSON.stringify(arr)); renderCart(); }

        function addToCart(line){
            const arr = getCart(); arr.push(line); setCart(arr); cart.classList.add('open');
        }

        function renderCart(){
            const arr = getCart();
            cartBody.innerHTML = '';
            let total = 0; let count = 0;

            arr.forEach((ln, idx) => {
                total += ln.total;
                count += ln.qty;

                const selHtml = (ln.selections||[]).map(v => {
                    const opts = v.options.map(o=>o.name + (o.adj?` (+${o.adj.toFixed(2)}{{ $currency }})`:``)).join(', ');
                    return `<div><small>${v.name}: ${opts}</small></div>`;
                }).join('');

                const el = document.createElement('div');
                el.className = 'cart-line';
                el.innerHTML = `
                    <img src="${ln.img}" alt="">
                    <div class="flex-grow-1">
                        <h6>${ln.name}</h6>
                        ${selHtml}
                        <small class="text-muted">{{ __('Unit') }}: ${ln.unit.toFixed(2)}{{ $currency }}</small>
                    </div>
                    <div class="text-end">
                        <div class="cart-qty mb-1">
                            <button data-act="dec" data-idx="${idx}"><i class="fa-solid fa-minus"></i></button>
                            <span>${ln.qty}</span>
                            <button data-act="inc" data-idx="${idx}"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <div class="fw-bold">${ln.total.toFixed(2)}{{ $currency }}</div>
                        <button class="btn btn-sm btn-link text-danger p-0 mt-1" data-act="rm" data-idx="${idx}">{{ __('Remove') }}</button>
                    </div>
                `;
                cartBody.appendChild(el);
            });
            cartTotal.textContent = total.toFixed(2) + '{{ $currency }}';
            cartCount.textContent = count;

            cartBody.querySelectorAll('button[data-act]').forEach(b=>{
                b.addEventListener('click', ()=>{
                    const idx = parseInt(b.getAttribute('data-idx'),10);
                    const act = b.getAttribute('data-act');
                    const arr = getCart();
                    const ln  = arr[idx]; if(!ln) return;
                    if(act==='inc'){ ln.qty += 1; }
                    else if(act==='dec'){ ln.qty = Math.max(1, ln.qty-1); }
                    else if(act==='rm'){ arr.splice(idx,1); }
                    ln.total = ln.unit * ln.qty;
                    setCart(arr);
                });
            });
        }

        // init
        renderCart();

        cartToggle.addEventListener('click', ()=> cart.classList.toggle('open'));
        clearCart.addEventListener('click', ()=> setCart([]));

        // Add to cart from modal
        document.getElementById('addToCart').addEventListener('click', ()=>{
            if(!validateRequired()) return;
            const qty = parseInt(document.getElementById('qtyInput').value,10) || 1;
            const {unit, total} = recalcPrice();
            const selections = gatherSelections();
            addToCart({
                name: currentItem.name,
                img:  currentItem.img,
                unit, qty, total,
                selections
            });
            itemModal.hide();
        });

        /* ===== Confirm & QR ===== */
        const confirmModalEl = document.getElementById('confirmModal');
        const confirmModal = new bootstrap.Modal(confirmModalEl);
        const qrcodeBox = document.getElementById('qrcode');
        let lastPayload = null;

        function buildOrderPayload(){
            const items = getCart().map(l => ([
                l.name, l.qty, +l.unit.toFixed(2), +l.total.toFixed(2),
                (l.selections||[]).map(v => [v.name, (v.options||[]).map(o => [o.name, +o.adj.toFixed(2)])])
            ]));
            const sum = +getCart().reduce((s,i)=>s+i.total,0).toFixed(2);
            const payload = {
                v: 1,
                type: 'delivery_partner',
                rid: '{{ hash('crc32b', $restaurantName) }}',
                r: '{{ $restaurantName }}',
                t: Date.now(),
                cur: '{{ trim($currency) }}',
                items,
                sum
            };
            payload.code = shortHash(JSON.stringify(payload).slice(0,256));
            lastPayload = payload;
            return payload;
        }

        function renderConfirmSummary(payload){
            const arr = payload.items || [];
            const box = document.getElementById('confirmSummary');
            if(!arr.length){ box.innerHTML = `<div class="text-muted">{{ __('Your cart is empty.') }}</div>`; return; }
            box.innerHTML = arr.map(([name, qty, unit, total, sel])=>{
                const opts = (sel||[]).map(([vname, options])=>{
                    const os = (options||[]).map(([n,a])=> n + (a?` (+${a.toFixed(2)}{{ $currency }})`:``)).join(', ');
                    return `<div class="text-muted">${vname}: ${os}</div>`;
                }).join('');
                return `<div class="mb-2">
                            <div class="d-flex justify-content-between">
                                <div><strong>${name}</strong> × ${qty}</div>
                                <div class="fw-bold">${total.toFixed(2)}{{ $currency }}</div>
                            </div>
                            ${opts}
                        </div>`;
            }).join('') + `<hr class="my-2"><div class="d-flex justify-content-between"><div class="fw-bold">{{ __('Total') }}</div><div class="fw-bold">${payload.sum.toFixed(2)}{{ $currency }}</div></div>`;
        }

        function generateQR(payload){
            if(typeof QRCode === 'undefined'){ console.warn('QRCode lib not loaded'); return; }
            qrcodeBox.innerHTML = '';
            new QRCode(qrcodeBox, {
                text: JSON.stringify(payload),
                width: 220,
                height: 220,
                correctLevel: QRCode.CorrectLevel.M
            });
        }

        function downloadQR(){
            const canvas = qrcodeBox.querySelector('canvas');
            if(!canvas) return;
            const link = document.getElementById('downloadQR');
            link.download = `agent-order-{{ Str::slug($restaurantName) }}.png`;
            link.href = canvas.toDataURL('image/png');
        }

        function buildShareText(payload){
            const cur = '{{ $currency }}';
            const S   = '------------------------------';
            const lines = [];
            lines.push(`*{{ $restaurantName }}* — *Agent Order*`);
            lines.push(`*Code:* ${payload.code}`);
            lines.push(S);
            lines.push(`*Items*`);
            (payload.items || []).forEach(([name, qty, unit, total, sel])=>{
                lines.push(`- *${name}* ×${qty}`);
                (sel||[]).forEach(([vname, options])=>{
                    (options||[]).forEach(([n,a])=>{
                        const adj = a ? ` (+${a.toFixed(2)}${cur})` : '';
                        lines.push(`   • ${vname}: ${n}${adj}`);
                    });
                });
                lines.push(`   — Line total: ${total.toFixed(2)}${cur}`);
                lines.push('----------------');
            });
            lines.push(S);
            lines.push(`*Grand total:* ${payload.sum.toFixed(2)}${cur}`);
            return encodeURIComponent(lines.join('\n'));
        }
        function waUrlFor(payload){
            return `https://wa.me/${WA_NUMBER}?text=${buildShareText(payload)}`;
        }

        function openPreview(payload){
            renderConfirmSummary(payload);
            setTimeout(()=> { generateQR(payload); downloadQR(); }, 10);
            document.getElementById('whShare').href = waUrlFor(payload);
            confirmModal.show();
        }

        document.getElementById('confirmBtn').addEventListener('click', ()=>{
            const cartNow = getCart();
            if(!cartNow.length){ cart.classList.add('open'); return; }
            const payload = buildOrderPayload();
            window.open(waUrlFor(payload), '_blank', 'noopener');
            openPreview(payload);
            localStorage.setItem(lastKey, JSON.stringify({ when: Date.now(), cart: cartNow }));
            setCart([]);
        });

        document.getElementById('confirmModal').addEventListener('shown.bs.modal', ()=>{
            const payload = lastPayload || buildOrderPayload();
            renderConfirmSummary(payload);
            setTimeout(()=> { generateQR(payload); downloadQR(); }, 10);
            document.getElementById('whShare').href = waUrlFor(payload);
        });
        document.getElementById('regenQR').addEventListener('click', ()=>{
            const payload = lastPayload || buildOrderPayload();
            generateQR(payload); downloadQR();
        });
        document.getElementById('downloadQR').addEventListener('click', (e)=>{
            if(!e.currentTarget.href) { e.preventDefault(); const p = lastPayload || buildOrderPayload(); generateQR(p); downloadQR(); }
        });
        document.getElementById('printQR').addEventListener('click', ()=>{
            const canvas = qrcodeBox.querySelector('canvas');
            if(!canvas) return;
            const dataUrl = canvas.toDataURL('image/png');
            const w = window.open('', 'PRINT', 'height=420,width=420');
            w.document.write(`<img src="${dataUrl}" style="width:100%;height:auto;"/>`);
            w.document.close(); w.focus(); w.print(); w.close();
        });
        document.getElementById('whShareQR').addEventListener('click', async ()=>{
            const canvas = qrcodeBox.querySelector('canvas');
            const hint = document.getElementById('shareHint');
            hint.style.display = 'none';
            if(!canvas){
                const p = lastPayload || buildOrderPayload();
                generateQR(p);
                setTimeout(()=>document.getElementById('whShareQR').click(), 40);
                return;
            }
            canvas.toBlob(async (blob)=>{
                if(!blob) return;
                const file = new File([blob], 'order-qr.png', { type: 'image/png' });
                const payload = lastPayload || buildOrderPayload();
                const text = decodeURIComponent(buildShareText(payload));
                if (navigator.canShare && navigator.canShare({ files: [file] })) {
                    try{ await navigator.share({ files: [file], title: 'QR Order', text }); }
                    catch(e){}
                } else {
                    hint.style.display = 'block';
                }
            });
        });
        document.getElementById('copySummary').addEventListener('click', async ()=>{
            const payload = lastPayload || buildOrderPayload();
            const text = decodeURIComponent(buildShareText(payload));
            try{
                await navigator.clipboard.writeText(text.replace(/\u00A0/g,' '));
                const btn = document.getElementById('copySummary');
                const old = btn.innerHTML;
                btn.innerHTML = '<i class="fa-regular fa-circle-check"></i> {{ __('Copied!') }}';
                setTimeout(()=> btn.innerHTML = old, 1200);
            }catch(e){}
        });

        /* ===== Category Popup: DRAG anywhere on header to expand/full/close ===== */
        if (IS_CAT_POPUP) {
            const openBtn   = document.getElementById('openCategories');
            const sheetEl   = document.getElementById('categoriesSheet');
            const headerEl  = sheetEl?.querySelector('.offcanvas-header'); // NEW: whole header as drag surface
            const handle    = sheetEl?.querySelector('.handle');
            const catFilter = document.getElementById('catFilter');
            const catOffcanvas = sheetEl ? new bootstrap.Offcanvas(sheetEl) : null;

            function defaultSheetHeight(){
                const h = Math.round(window.innerHeight * 0.7);
                return Math.min(h, 520);
            }
            function setSheetHeight(px){
                sheetEl.style.setProperty('--sheet-h', px + 'px');
            }

            openBtn?.addEventListener('click', () => {
                setSheetHeight(defaultSheetHeight());
                sheetEl.classList.remove('is-full');
                catOffcanvas?.show();
                setTimeout(()=>catFilter?.focus(), 150);
            });

            function showCategoryBySlug(slug){
                const input = document.getElementById('menuSearch');
                if (input) input.value = '';
                $('#searchResults').addClass('d-none');
                $('#pills-tabContent').removeClass('d-none');

                document.querySelectorAll('#pills-tabContent .tab-pane').forEach(p=>{
                    p.classList.remove('show','active');
                });
                const target = document.getElementById('pills-' + slug);
                if (target) target.classList.add('show','active');

                const y = document.querySelector('.food-menu-section')?.getBoundingClientRect().top + window.scrollY - 60;
                if (!isNaN(y)) window.scrollTo({ top: y, behavior: 'smooth' });
            }
            sheetEl?.querySelectorAll('.cat-tile').forEach(btn=>{
                btn.addEventListener('click', ()=>{
                    const slug = btn.getAttribute('data-slug');
                    showCategoryBySlug(slug);
                    catOffcanvas?.hide();
                });
            });

            // Filter inside sheet
            catFilter?.addEventListener('input', (e)=>{
                const q = (e.target.value || '').trim().toLowerCase();
                sheetEl.querySelectorAll('.cat-tile').forEach(tile=>{
                    const name = tile.getAttribute('data-name') || '';
                    tile.style.display = (!q || name.includes(q)) ? '' : 'none';
                });
            });

            // Drag logic on HEADER and HANDLE (mouse + touch)
            let startY = 0, startH = 0, dragging = false;
            function sheetMin(){ return Math.max(320, Math.round(window.innerHeight * 0.4)); }
            function sheetMax(){ return window.innerHeight; }

            function onDragStart(e){
                // Do not start drag from close button
                if (e.target.closest('.btn-close')) return;

                dragging = true;
                sheetEl.classList.add('is-dragging');
                startY = (e.touches ? e.touches[0].clientY : e.clientY);
                startH = sheetEl.getBoundingClientRect().height;

                document.addEventListener('mousemove', onDragMove);
                document.addEventListener('mouseup', onDragEnd);
                document.addEventListener('touchmove', onDragMove, {passive:false});
                document.addEventListener('touchend', onDragEnd);

                // prevent text selection / scroll
                if (e.cancelable) e.preventDefault();
            }
            function onDragMove(e){
                if(!dragging) return;
                const y = (e.touches ? e.touches[0].clientY : e.clientY);
                const delta = startY - y; // drag up => positive
                let next = startH + delta;
                next = Math.max(sheetMin(), Math.min(sheetMax(), next));
                setSheetHeight(next);
                sheetEl.classList.toggle('is-full', next > sheetMax() - 16);
                if(e.cancelable) e.preventDefault();
            }
            function onDragEnd(){
                if(!dragging) return;
                dragging = false;
                sheetEl.classList.remove('is-dragging');

                const current = sheetEl.getBoundingClientRect().height;
                if(current > sheetMax() * 0.85){
                    sheetEl.classList.add('is-full');
                    setSheetHeight(sheetMax());
                }else if(current < sheetMin() * 0.85){
                    catOffcanvas?.hide();
                }else{
                    sheetEl.classList.remove('is-full');
                    setSheetHeight(defaultSheetHeight());
                }
                document.removeEventListener('mousemove', onDragMove);
                document.removeEventListener('mouseup', onDragEnd);
                document.removeEventListener('touchmove', onDragMove);
                document.removeEventListener('touchend', onDragEnd);
            }

            // Bind both header and handle
            headerEl?.addEventListener('mousedown', onDragStart);
            headerEl?.addEventListener('touchstart', onDragStart, {passive:false});
            handle?.addEventListener('mousedown', onDragStart);
            handle?.addEventListener('touchstart', onDragStart, {passive:false});

            // Cleanup on hide
            sheetEl?.addEventListener('hidden.bs.offcanvas', ()=>{
                sheetEl.classList.remove('is-full','is-dragging');
                sheetEl.style.removeProperty('--sheet-h');
            });

            // Quick keyboard open
            window.addEventListener('keydown', (e)=>{
                if ((e.key==='c' || e.key==='C') && !e.target.closest('input,textarea')) {
                    setSheetHeight(defaultSheetHeight());
                    sheetEl.classList.remove('is-full');
                    catOffcanvas?.show();
                }
            });
        }
    </script>
</body>
</html>
