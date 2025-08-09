{{-- resources/views/welcome.blade.php (Waiter mode with Client Code import) --}}
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
    $menuTitle   = $rawMenuName && $rawMenuName !== $restaurantName ? $rawMenuName : __('Our Menu');
    $currency    = ' DH';

    $isRTL = in_array(strtolower($default_language), ['ar','he','fa','ur']);
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language }}" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurantName }} – Digital Menu (Waiter)</title>

    <!-- Assets -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <!-- QR Scanner (for importing client QR) -->
    <script src="https://unpkg.com/html5-qrcode" defer></script>

    <style>
        :root{
            --brand:#6F4E37;      /* Espresso (used for prices & CTAs) */
            --brand-2:#C49A6C;    /* Latte */
            --cream:#FBF7F2;      /* Cream bg */
            --ink:#1f2937;        /* Text */
            --muted:#6b7280;
            --chip:#fff7ea;
            --chip-b:#f2e4d3;
            --ring:rgba(196,154,108,.25);
            --accent:#facc15;     /* Gold accent */
            --danger:#ef4444;
            --success:#16a34a;

            /* Header palette (restaurant-friendly, NOT brown): fresh peach → mint */
            --header-top:#FFE9D1;  /* peach */
            --header-btm:#E8F5E9;  /* mint */
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

        /* Lang switcher */
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

        /* Logo */
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

        /* ===== STICKY TOOLS ===== */
        .sticky-tools{
            position:sticky; top:0; z-index:60;
            background:rgba(255,255,255,.92);
            backdrop-filter: blur(6px);
            border-bottom:1px solid #efe6db;
            padding:.45rem 0;
            margin-bottom:1.4rem;
        }
        #menuSearch{
            border-radius:999px; padding:.6rem 1rem; font-size:.98rem;
            border:2px solid var(--chip-b); background:#fff; transition:.2s; color:var(--ink);
        }
        #menuSearch::placeholder{color:#9b8f89}
        #menuSearch:focus{border-color:var(--brand-2); box-shadow:0 0 0 5px var(--ring); outline:0}
        .quick-tags{display:flex; gap:.4rem; flex-wrap:wrap; justify-content:center; padding:.35rem 1rem .35rem}
        .quick-tags .qtag{
            border:1px solid var(--chip-b); background:var(--chip); color:#6b4b2f;
            padding:.2rem .55rem; font-size:.78rem; border-radius:999px; cursor:pointer; transition:.15s
        }
        .quick-tags .qtag:hover{transform:translateY(-1px)}

        /* Categories */
        .categories-wrapper{position:relative}
        .cat-nav{
            position:absolute; top:50%; transform:translateY(-50%); width:32px; height:32px; border-radius:50%;
            display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid var(--brand-2);
            box-shadow:0 2px 10px rgba(0,0,0,.08); color:#7a5200; font-size:.8rem; z-index:5
        }
        .cat-nav.disabled{display:none}
        .cat-prev{{ $isRTL ? ':right' : ':left' }}:.25rem;
        .cat-next{{ $isRTL ? ':left' : ':right' }}:.25rem;

        .categories-scroll{
            display:flex; flex-wrap:nowrap; gap:.5rem; margin:.1rem 0 .3rem; padding:0 1.2rem; overflow-x:auto;
            -webkit-overflow-scrolling:touch; scroll-snap-type:x mandatory; scrollbar-width:none;
        }
        .categories-scroll::-webkit-scrollbar{display:none}
        .categories-scroll .nav-item{flex:0 0 auto; scroll-snap-align:start}
        .categories-scroll .nav-link{
            padding:.5rem .95rem; font-size:.9rem; font-weight:800; color:#5a3d1b;
            background:#fff7ee; border:1px solid rgba(196,154,108,.45);
            border-radius:14px; transition:.16s;
        }
        .categories-scroll .nav-link:hover{transform:translateY(-1px); box-shadow:0 4px 10px rgba(0,0,0,.06)}
        .categories-scroll .nav-link.active{color:#000; background:#f6e3cf; border-color:transparent; box-shadow:0 3px 10px rgba(0,0,0,.08)}
        @media(min-width:576px){ .cat-nav{display:none} .categories-scroll{overflow:visible; flex-wrap:wrap; justify-content:center; gap:.6rem; padding:0} }

        /* ===== ITEMS ===== */
        .food-menu-section.section-padding{padding-top:0!important}
        .food-menu-tab-wrapper { padding-top:.2rem !important; }
        .title-area{margin:.3rem 0 .5rem;}
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

        /* ===== MODAL ===== */
        #itemModal .modal-content{border:0; border-radius:1rem; box-shadow:0 10px 36px rgba(0,0,0,.18)}
        #itemModal .modal-header{
            background:#fff3cf;
            border-bottom:none; border-top-left-radius:1rem; border-top-right-radius:1rem;
            padding:.7rem 1rem;
        }
        #itemModal .modal-title{font-weight:800; color:#5f3b0e; font-size:1.25rem}
        #itemModal .modal-body{padding:1rem 1rem 1.15rem}
        #itemModal img{width:120px; height:120px; object-fit:cover; border-radius:.8rem; box-shadow:0 6px 16px rgba(0,0,0,.1)}
        .lead-price{font-weight:800; color:var(--brand)}
        .v-group{margin:.55rem 0}
        .v-title{font-weight:800; margin-bottom:.3rem}
        .opt-chip{
            display:inline-flex; align-items:center; gap:.35rem; padding:.3rem .55rem; margin:.2rem .3rem .2rem 0;
            border:1px solid var(--chip-b); background:var(--chip); border-radius:999px; cursor:pointer; user-select:none; transition:.15s
        }
        .opt-chip.disabled{opacity:.45; cursor:not-allowed}
        .opt-chip.active{border-color:var(--brand-2); box-shadow:0 0 0 4px var(--ring)}
        .qty-wrap{display:flex; align-items:center; gap:.45rem}
        .qty-btn{width:32px; height:32px; display:flex; align-items:center; justify-content:center; border-radius:8px; border:1px solid var(--chip-b); background:var(--chip)}
        .qty-input{width:54px; text-align:center; border:1px solid var(--chip-b); background:#fff; border-radius:8px; padding:.3rem 0}
        .cta-row{display:flex; flex-wrap:wrap; align-items:center; gap:.6rem; justify-content:space-between; margin-top:.6rem}
        .btn-primary-cta{
            background:var(--brand); border:none; color:#fff; font-weight:800; padding:.55rem .95rem; border-radius:.7rem;
            box-shadow:0 10px 22px rgba(111,78,55,.22); transition:.15s
        }
        .btn-primary-cta:hover{background:#5c3f2e}
        .req-hint{font-size:.85rem; color:#b45309; display:none}

        /* ===== TABLE-BASED TRAY (mini-cart) ===== */
        .tray-toggle{
            position:fixed; {{ $isRTL ? 'left' : 'right' }}:16px; bottom:16px; width:56px; height:56px; border-radius:50%;
            background:var(--brand); color:#fff; border:none; display:flex; align-items:center; justify-content:center;
            box-shadow:0 12px 28px rgba(0,0,0,.22); z-index:71;
        }
        .tray-toggle .badge{
            position:absolute; top:-6px; {{ $isRTL ? 'left' : 'right' }}:-6px; background:#ef4444; color:#fff; border-radius:999px; padding:.15rem .45rem; font-size:.7rem; font-weight:800
        }
        .tray-toggle .tbl-label{
            position:absolute; bottom:-6px; {{ $isRTL ? 'right' : 'left' }}:-6px; background:#111827; color:#fff; border-radius:6px; padding:.05rem .35rem; font-size:.7rem; font-weight:800
        }
        .tray{
            position:fixed; {{ $isRTL ? 'left' : 'right' }}:16px; bottom:16px; width:min(480px,94vw);
            background:#fff; border:1px solid #efe6db; box-shadow:0 14px 40px rgba(0,0,0,.18);
            border-radius:1rem; overflow:hidden; z-index:70; transform: translateY(110%); transition:.25s;
        }
        .tray.open{ transform: translateY(0) }
        .tray-header{display:flex; align-items:center; justify-content:space-between; gap:.6rem; padding:.6rem .9rem; background:#fff9f1; border-bottom:1px solid #f0e6da; flex-wrap:wrap}
        .tray-header .table-ctrls{display:flex; align-items:center; gap:.4rem; flex-wrap:wrap}
        .tray-header select, .tray-header input{height:32px;font-size:.9rem}
        .tray-header .import-wrap{display:flex; align-items:center; gap:.35rem; flex-wrap:wrap}
        .tray-body{max-height:46vh; overflow:auto; padding:.6rem .9rem}
        .tray-line{display:flex; gap:.7rem; padding:.55rem 0; border-bottom:1px dashed #e9e1d9}
        .tray-line:last-child{border-bottom:none}
        .tray-line img{width:48px;height:48px;border-radius:.5rem;object-fit:cover}
        .tray-line h6{margin:0; font-weight:800}
        .tray-line small{color:var(--muted)}
        .tray-qty{display:flex; align-items:center; gap:.35rem}
        .tray-qty button{width:26px;height:26px;border:1px solid var(--chip-b); background:var(--chip); border-radius:6px}
        .tray-footer{display:flex; align-items:center; justify-content:space-between; padding:.65rem .9rem; background:#fffaf3; border-top:1px solid #eee2d4}

        .client-meta{background:#f7fbff;border:1px solid #e0eefb;border-radius:.5rem;padding:.35rem .5rem;margin-bottom:.4rem}
        .client-meta .badge{background:#e2e8f0;color:#111;border-radius:.35rem}

        /* Back to top */
        #toTop{position:fixed; {{ $isRTL ? 'left' : 'right' }}:90px; bottom:18px; width:42px;height:42px;border-radius:50%;background:var(--accent);color:#222;border:none;box-shadow:0 8px 22px rgba(0,0,0,.18);display:none;align-items:center;justify-content:center;z-index:60}
        #toTop:hover{background:#ffe16a}

        /* Scanner modal */
        #qrReader { width: 100%; }
        .scanner-help{font-size:.9rem;color:#6b7280}
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
        </div>
    </section>

    {{-- ===== Sticky tools (search + categories) ===== --}}
    <div class="sticky-tools">
        <div class="container">
            <div class="row g-2 align-items-center justify-content-center">
                <div class="col-12 col-md-7">
                    <input id="menuSearch" type="search" class="form-control" placeholder="{{ __('Search menu…') }}" aria-label="{{ __('Search menu…') }}">
                </div>
                <div class="col-12">
                    <div class="categories-wrapper">
                        <button type="button" class="cat-nav cat-prev" aria-label="{{ __('Scroll categories') }}"><i class="fa-solid fa-chevron-{{ $isRTL ? 'right' : 'left' }}"></i></button>
                        <ul class="nav categories-scroll" id="pills-tab" role="tablist">
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
                    </div>
                </div>
            </div>

            {{-- Quick suggestion tags --}}
            <div class="quick-tags">
                <span class="qtag">🍔 {{ __('Burger') }}</span>
                <span class="qtag">🍕 {{ __('Pizza') }}</span>
                <span class="qtag">🥗 {{ __('Salad') }}</span>
                <span class="qtag">☕ {{ __('Coffee') }}</span>
                <span class="qtag">🍟 {{ __('Fries') }}</span>
            </div>
        </div>
    </div>

    {{-- ===== Menu ===== --}}
    <section class="food-menu-section fix section-padding">
        <div class="food-menu-wrapper style1">
            <div class="container ">
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

                        <div id="searchResults" class="row gx-4 d-none"></div>
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
                {{ __('for food lovers') }}</p>
        </div>
    </footer>

    {{-- Back to top --}}
    <button id="toTop" aria-label="{{ __('Back to top') }}"><i class="fa-solid fa-arrow-up"></i></button>

    {{-- ===== Item Modal (Interactive) ===== --}}
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
                                <button id="addToTray" class="btn-primary-cta">
                                    <i class="fa-solid fa-clipboard-check me-1"></i> {{ __('Add to Table Order') }}
                                </button>
                                <div class="small text-muted" id="perUnitNote">{{ __('Price per unit incl. selected options') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Tray (Waiter) with Client Code Import ===== --}}
    <button class="tray-toggle" id="trayToggle" title="{{ __('Open table orders') }}">
        <i class="fa-solid fa-clipboard-list"></i>
        <span class="badge" id="trayCount">0</span>
        <span class="tbl-label" id="currentTableBadge">T1</span>
    </button>
    <div class="tray" id="tray">
        <div class="tray-header">
            <div class="table-ctrls">
                <i class="fa-solid fa-chair me-1"></i>
                <label for="tableSelect" class="me-1 fw-bold">{{ __('Table') }}</label>
                <select id="tableSelect" class="form-select form-select-sm w-auto">
                    @for($i=1;$i<=20;$i++)
                        <option value="{{ $i }}">#{{ $i }}</option>
                    @endfor
                </select>
            </div>

            {{-- Client code import --}}
            <div class="import-wrap">
                <input id="clientCode" class="form-control form-control-sm" style="min-width:220px" placeholder="{{ __('Paste client code / JSON / URL…') }}">
                <button class="btn btn-sm btn-outline-primary" id="importCode"><i class="fa-solid fa-download me-1"></i>{{ __('Import') }}</button>
                <button class="btn btn-sm btn-outline-dark" id="scanCode" data-bs-toggle="modal" data-bs-target="#scanModal"><i class="fa-solid fa-qrcode me-1"></i>{{ __('Scan') }}</button>
                <button class="btn btn-sm btn-outline-secondary" id="clearTray"><i class="fa-solid fa-trash-can"></i> {{ __('Clear This Table') }}</button>
            </div>
        </div>

        <div class="tray-body" id="trayBody"></div>

        <div class="tray-footer">
            <div>
                <div class="fw-bold">{{ __('Total') }}: <span id="trayTotal">0{{ $currency }}</span></div>
                <small class="text-muted">{{ __('Give this to cashier / kitchen') }}</small>
            </div>
            <button class="btn btn-success fw-bold"><i class="fa-solid fa-check me-1"></i>{{ __('Mark as Sent') }}</button>
        </div>
    </div>

    {{-- Scanner Modal --}}
    <div class="modal fade" id="scanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-qrcode me-2"></i>{{ __('Scan Client QR Code') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="scanner-help mb-2">
                        {{ __('Point your camera at the customer QR. When detected, the order is imported automatically.') }}
                    </div>
                    <div id="qrReader"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS assets -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        /* ===== Category arrows ===== */
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

        /* Scroll active pill into view */
        document.querySelectorAll('#pills-tab button[data-bs-toggle="pill"]').forEach(btn => {
            btn.addEventListener('shown.bs.tab', e => {
                e.target.scrollIntoView({ behavior:'smooth', inline:'center', block:'nearest' });
            });
        });

        /* Back to top */
        const toTop = document.getElementById('toTop');
        window.addEventListener('scroll', () => {
            toTop.style.display = window.scrollY > 500 ? 'flex' : 'none';
        });
        toTop.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));

        /* ===== Quick tags -> search ===== */
        document.querySelectorAll('.qtag').forEach(tag=>{
            tag.addEventListener('click', ()=> {
                const text = tag.textContent.replace(/^[^\w\u0600-\u06FF]+/,'').trim();
                const input = document.getElementById('menuSearch');
                input.value = text;
                input.dispatchEvent(new Event('input'));
                input.focus();
            });
        });

        /* ===== Live search (with highlight) ===== */
        function escapeRegExp(s){ return s.replace(/[.*+?^${}()|[\]\\]/g,'\\$&'); }
        function highlight(text, q){
            if(!q) return text;
            const re = new RegExp(`(${escapeRegExp(q)})`,'ig');
            return text.replace(re,'<mark>$1</mark>');
        }
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
            } else {
                $res.find('.single-menu-items').first().attr('tabindex','0').focus();
            }
        });

        /* ===== Modal logic: interactive variations ===== */
        const itemModal = new bootstrap.Modal(document.getElementById('itemModal'));
        let currentItem = null;

        function formatMoney(val){ return (parseFloat(val).toFixed(2)) + '{{ $currency }}'; }

        function renderVariations(variations){
            if (!variations || !variations.length) return '';
            let html = '';
            variations.forEach((v, vIdx) => {
                const isSingle = (parseInt(v.max_selections||1,10) === 1);
                const maxSel   = parseInt(v.max_selections||1,10);
                const minSel   = parseInt(v.min_selections|| (v.is_required ? 1 : 0),10);

                html += `<div class="v-group" data-vid="${v.id||('v'+vIdx)}" data-single="${isSingle?1:0}" data-min="${minSel}" data-max="${maxSel}">
                            <div class="v-title">${v.name}${v.is_required ? ' <span class="text-danger">*</span>' : ''}</div>`;
                (v.options||[]).forEach((o, oIdx) => {
                    const disabled = String(o.is_available)==='0' ? 'disabled' : '';
                    const def = String(o.is_default)==='1' ? ' data-default="1"' : '';
                    const adj = parseFloat(o.price_adjustment||0) || 0;
                    html += `<span class="opt-chip ${disabled}" data-oid="${o.id||('o'+oIdx)}" data-adj="${adj}" ${def} ${disabled? 'aria-disabled="true"':''}>
                                <i class="fa-solid ${isSingle?'fa-circle-dot':'fa-square'}"></i>
                                <span>${o.name}</span>${adj ? ` <small>+${parseFloat(adj).toFixed(2)}{{ $currency }}</small>`:''}
                             </span>`;
                });
                html += `</div>`;
            });
            return html;
        }

        function recalcPrice(){
            if(!currentItem) return;
            const base = parseFloat(currentItem.base);
            let adj = 0;
            document.querySelectorAll('#modalOptions .opt-chip.active').forEach(chip=>{
                adj += parseFloat(chip.getAttribute('data-adj')||0);
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
                    const sel = group.querySelectorAll('.opt-chip.active').length;
                    if(sel < min){ ok = false; }
                }
            });
            document.getElementById('addToTray').disabled = !ok;
            document.getElementById('reqHint').style.display = ok ? 'none' : 'block';
            return ok;
        }

        function enforceMax(groupEl, clickedChip){
            const single = groupEl.getAttribute('data-single') === '1';
            const max = parseInt(groupEl.getAttribute('data-max')|| (single?1:99),10);
            let actives = groupEl.querySelectorAll('.opt-chip.active');

            if(single){
                actives.forEach(ch=> ch.classList.remove('active'));
                clickedChip.classList.add('active');
            } else {
                if(clickedChip.classList.contains('active')){
                    clickedChip.classList.remove('active');
                } else {
                    if(actives.length >= max){ groupEl.style.transform='scale(1.01)'; setTimeout(()=>groupEl.style.transform='',120); return; }
                    clickedChip.classList.add('active');
                }
            }
        }

        function applyDefaults(){
            document.querySelectorAll('#modalOptions .v-group').forEach(group=>{
                const single = group.getAttribute('data-single') === '1';
                const defaults = group.querySelectorAll('.opt-chip[data-default="1"]:not(.disabled)');
                if(defaults.length){
                    if(single){
                        defaults.forEach((c,i)=> c.classList.toggle('active', i===0));
                    }else{
                        defaults.forEach(c=> c.classList.add('active'));
                    }
                }else{
                    const min = parseInt(group.getAttribute('data-min')||0,10);
                    const chips = group.querySelectorAll('.opt-chip:not(.disabled)');
                    if(min>0 && chips.length===1){
                        chips[0].classList.add('active');
                    }
                }
            });
        }

        function gatherSelections(){
            const selections = [];
            document.querySelectorAll('#modalOptions .v-group').forEach(group=>{
                const vId = group.getAttribute('data-vid');
                const vName = group.querySelector('.v-title').textContent.replace('*','').trim();
                const opts = [];
                group.querySelectorAll('.opt-chip.active').forEach(ch=>{
                    const name = ch.querySelector('span')?.textContent || '';
                    const adj = parseFloat(ch.getAttribute('data-adj')||0);
                    const oid = ch.getAttribute('data-oid');
                    opts.push({id:oid, name, adj});
                });
                if(opts.length) selections.push({variation_id:vId, name:vName, options:opts});
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

            // qty init
            $('#qtyInput').attr({min:minqty}).val(minqty);
            if(maxqty){ $('#qtyInput').attr({max:maxqty}); } else { $('#qtyInput').removeAttr('max'); }

            currentItem = {
                name: $el.data('name'),
                img:  $el.data('img'),
                base: base,
                minqty, maxqty,
                currency: '{{ $currency }}'
            };

            // hook chips
            $('#modalOptions .opt-chip:not(.disabled)').on('click', function(){
                const group = this.closest('.v-group');
                enforceMax(group, this);
                validateRequired(); recalcPrice();
            });

            // defaults & first calc
            applyDefaults();
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

        /* ===== Build menu index for lookups (image etc.) ===== */
        const menuIndex = {};
        document.querySelectorAll('.single-menu-items').forEach(el=>{
            const name = el.getAttribute('data-name');
            if(name && !menuIndex[name]){
                menuIndex[name] = {
                    img: el.getAttribute('data-img') || '',
                    base: parseFloat(el.getAttribute('data-base') || '0')
                };
            }
        });

        /* ===== Table-based orders (localStorage) ===== */
        const tray       = document.getElementById('tray');
        const trayToggle = document.getElementById('trayToggle');
        const trayBody   = document.getElementById('trayBody');
        const trayTotalEl= document.getElementById('trayTotal');
        const trayCount  = document.getElementById('trayCount');
        const clearTray  = document.getElementById('clearTray');
        const tableSelect= document.getElementById('tableSelect');
        const tableBadge = document.getElementById('currentTableBadge');

        const ORDERS_KEY = 'ordersByTable';
        const META_KEY   = 'tableMeta';

        function getAllOrders(){ try { return JSON.parse(localStorage.getItem(ORDERS_KEY)||'{}'); } catch(e){ return {}; } }
        function setAllOrders(obj){ localStorage.setItem(ORDERS_KEY, JSON.stringify(obj)); }

        function getMeta(){ try { return JSON.parse(localStorage.getItem(META_KEY)||'{}'); } catch(e){ return {}; } }
        function setMeta(obj){ localStorage.setItem(META_KEY, JSON.stringify(obj)); }

        function getCurrentTable(){ return localStorage.getItem('currentTable') || '1'; }
        function setCurrentTable(t){ localStorage.setItem('currentTable', String(t)); tableBadge.textContent = 'T'+t; }

        function getTrayFor(tableId){ const all = getAllOrders(); return all[tableId] || []; }
        function setTrayFor(tableId, arr){ const all = getAllOrders(); all[tableId] = arr; setAllOrders(all); renderTray(); }

        function getMetaFor(tableId){ const m = getMeta(); return m[tableId] || null; }
        function setMetaFor(tableId, meta){ const m = getMeta(); m[tableId] = meta; setMeta(m); renderTray(); }

        function addToTray(line){
            const t = getCurrentTable();
            const arr = getTrayFor(t);

            // merge if same name and same selections
            const key = JSON.stringify({n:line.name, s:(line.selections||[])});
            let merged = false;
            for (let i=0;i<arr.length;i++){
                const k2 = JSON.stringify({n:arr[i].name, s:(arr[i].selections||[])});
                if (k2 === key){
                    arr[i].qty += line.qty;
                    arr[i].total = arr[i].unit * arr[i].qty;
                    merged = true; break;
                }
            }
            if(!merged) arr.push(line);

            setTrayFor(t, arr);
            tray.classList.add('open');
            trayToggle.querySelector('.badge').classList.add('animate__animated','animate__heartBeat');
            setTimeout(()=> trayToggle.querySelector('.badge').classList.remove('animate__animated','animate__heartBeat'), 900);
        }

        function renderTray(){
            const t = getCurrentTable();
            tableSelect.value = t;
            tableBadge.textContent = 'T'+t;

            const arr = getTrayFor(t);
            const meta = getMetaFor(t);

            trayBody.innerHTML = '';

            // client meta block if present
            if(meta && (meta.cname || meta.cphone || meta.notes)){
                const info = document.createElement('div');
                info.className = 'client-meta';
                info.innerHTML = `
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        ${meta.cname ? `<span class="badge"><i class="fa-solid fa-user me-1"></i>${meta.cname}</span>`:''}
                        ${meta.cphone ? `<span class="badge"><i class="fa-solid fa-phone me-1"></i>${meta.cphone}</span>`:''}
                        ${meta.notes ? `<span class="badge"><i class="fa-solid fa-note-sticky me-1"></i>{{ __('Notes') }}</span>`:''}
                    </div>
                    ${meta.notes ? `<div class="small mt-1">${meta.notes}</div>`:''}
                `;
                trayBody.appendChild(info);
            }

            let total = 0; let count = 0;
            arr.forEach((ln, idx) => {
                total += ln.total;
                count += ln.qty;

                const selHtml = (ln.selections||[]).map(v => {
                    const opts = v.options.map(o=>o.name + (o.adj?` (+${o.adj.toFixed(2)}{{ $currency }})`:``)).join(', ');
                    return `<div><small>${v.name}: ${opts}</small></div>`;
                }).join('');

                const el = document.createElement('div');
                el.className = 'tray-line';
                el.innerHTML = `
                    <img src="${ln.img || '{{ asset('assets/img/menu/menuThumb1_1.png') }}'}" alt="">
                    <div class="flex-grow-1">
                        <h6>${ln.name}</h6>
                        ${selHtml}
                        <small class="text-muted">{{ __('Unit') }}: ${ln.unit.toFixed(2)}{{ $currency }}</small>
                    </div>
                    <div class="text-end">
                        <div class="tray-qty mb-1">
                            <button data-act="dec" data-idx="${idx}"><i class="fa-solid fa-minus"></i></button>
                            <span>${ln.qty}</span>
                            <button data-act="inc" data-idx="${idx}"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <div class="fw-bold">${ln.total.toFixed(2)}{{ $currency }}</div>
                        <button class="btn btn-sm btn-link text-danger p-0 mt-1" data-act="rm" data-idx="${idx}">{{ __('Remove') }}</button>
                    </div>
                `;
                trayBody.appendChild(el);
            });
            trayTotalEl.textContent = total.toFixed(2) + '{{ $currency }}';
            trayCount.textContent = count;

            trayBody.querySelectorAll('button[data-act]').forEach(b=>{
                b.addEventListener('click', ()=>{
                    const idx = parseInt(b.getAttribute('data-idx'),10);
                    const act = b.getAttribute('data-act');
                    const t   = getCurrentTable();
                    const arr = getTrayFor(t);
                    const ln  = arr[idx]; if(!ln) return;
                    if(act==='inc'){
                        ln.qty += 1;
                    }else if(act==='dec'){
                        ln.qty = Math.max(1, ln.qty-1);
                    }else if(act==='rm'){
                        arr.splice(idx,1);
                    }
                    if (arr[idx]) arr[idx].total = arr[idx].unit * arr[idx].qty;
                    setTrayFor(t, arr);
                });
            });
        }

        // init table
        (function initTable(){
            const saved = getCurrentTable();
            tableSelect.value = saved;
            setCurrentTable(saved);
            renderTray();
        })();

        tableSelect.addEventListener('change', ()=>{
            setCurrentTable(tableSelect.value);
            renderTray();
        });

        trayToggle.addEventListener('click', ()=> tray.classList.toggle('open'));
        clearTray.addEventListener('click', ()=>{
            const t = getCurrentTable();
            setTrayFor(t, []);
            setMetaFor(t, null);
        });

        // Add to tray from modal
        document.getElementById('addToTray').addEventListener('click', ()=>{
            if(!validateRequired()) return;
            const qty = parseInt(document.getElementById('qtyInput').value,10) || 1;
            const {unit, total} = recalcPrice();
            const selections = gatherSelections();
            addToTray({
                name: currentItem.name,
                img:  currentItem.img,
                unit, qty, total,
                selections
            });
            itemModal.hide();
        });

        /* ===== CLIENT CODE IMPORT ===== */
        function tryParsePayload(raw){
            if(!raw) return null;

            // If it's a URL with ?data=... param
            try {
                if(/^https?:\/\//i.test(raw)){
                    const u = new URL(raw);
                    const p = u.searchParams.get('data');
                    if(p){ raw = p; }
                }
            } catch(e){}

            // Try JSON direct
            try { return JSON.parse(raw); } catch(e){}

            // Try base64 -> JSON
            try {
                const txt = atob(raw);
                return JSON.parse(txt);
            } catch(e){}

            return null;
        }

        function importClientOrderToCurrentTable(payload){
            if(!payload || !Array.isArray(payload.items)){
                alert('{{ __("Invalid client code.") }}');
                return false;
            }
            const t = getCurrentTable();
            const arr = getTrayFor(t);

            // save client meta (optional)
            const meta = {
                cname: payload.cname || '',
                cphone: payload.cphone || '',
                notes: payload.notes || ''
            };
            setMetaFor(t, meta);

            payload.items.forEach(it=>{
                const qty  = parseInt(it.qty||1,10) || 1;
                const unit = parseFloat(it.unit||0) || 0;
                const total= parseFloat(it.total || (unit*qty));

                // map selections
                const selections = (it.sel||[]).map(v=>({
                    name: v.name,
                    options: (v.options||[]).map(o=>({ name: o.n || o.name || '', adj: parseFloat(o.a ?? o.adj ?? 0) || 0 }))
                }));

                // try to find image from menu by name
                const mi = menuIndex[it.name] || {};
                const img = mi.img || '';

                addToTray({
                    name: it.name,
                    img,
                    unit, qty, total,
                    selections
                });
            });

            return true;
        }

        document.getElementById('importCode').addEventListener('click', ()=>{
            const raw = (document.getElementById('clientCode').value||'').trim();
            const payload = tryParsePayload(raw);
            if(importClientOrderToCurrentTable(payload)){
                document.getElementById('clientCode').value = '';
                tray.classList.add('open');
            }
        });

        /* ===== QR SCAN (html5-qrcode) ===== */
        let qrScanner = null;
        const scanModalEl = document.getElementById('scanModal');
        scanModalEl.addEventListener('shown.bs.modal', ()=>{
            // html5-qrcode is loaded as a global when script finishes
            if(window.Html5QrcodeScanner){
                qrScanner = new Html5QrcodeScanner("qrReader", { fps: 10, qrbox: 250 });
                qrScanner.render((decodedText)=>{
                    // Success
                    const payload = tryParsePayload(decodedText);
                    if(importClientOrderToCurrentTable(payload)){
                        const m = bootstrap.Modal.getInstance(scanModalEl);
                        m?.hide();
                        qrScanner.clear();
                        qrScanner = null;
                        tray.classList.add('open');
                    }
                }, (error)=>{/* ignore scan errors */});
            } else {
                document.getElementById('qrReader').innerHTML = '<div class="text-danger">{{ __("Scanner failed to load.") }}</div>';
            }
        });
        scanModalEl.addEventListener('hidden.bs.modal', ()=>{
            if(qrScanner && qrScanner.clear){ qrScanner.clear(); qrScanner = null; }
            document.getElementById('qrReader').innerHTML = '';
        });
    </script>
</body>
</html>
