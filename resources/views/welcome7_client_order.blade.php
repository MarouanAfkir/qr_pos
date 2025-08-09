{{-- resources/views/client.blade.php --}}
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
    <title>{{ $restaurantName }} – {{ __('Client Order') }}</title>

    <!-- Assets -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- QR Code library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

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

            /* Header palette (restaurant-friendly, NOT brown): peach → mint */
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

        /* Logo & meta */
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
            margin-bottom:1.2rem;
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

        /* ===== CLIENT CART (no tables) ===== */
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

        /* ===== CONFIRMATION / QR MODAL ===== */
        #confirmModal .modal-content{border:0;border-radius:1rem}
        #confirmModal .modal-header{background:#eaf7ea;border:0}
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

    {{-- ===== Client Cart Panel ===== --}}
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
        <div class="cart-footer" >
            <div class="fw-bold">{{ __('Total') }}: <span id="cartTotal">0{{ $currency }}</span></div>
            {{-- <button class="btn-confirm" id="confirmOrder"><i class="fa-solid fa-check me-1"></i>{{ __('Confirm Order') }}</button> --}}
        </div>
    </div>

    {{-- ===== Confirm / QR Modal ===== --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Your Order Summary & QR Code') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <h6 class="fw-bold mb-2">{{ __('Order Details') }}</h6>
                            <div id="confirmSummary" class="small"></div>

                            <hr class="my-3">

                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label small fw-bold">{{ __('Your Name (optional)') }}</label>
                                    <input type="text" id="clientName" class="form-control form-control-sm" placeholder="{{ __('e.g., Sarah') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">{{ __('Phone (optional)') }}</label>
                                    <input type="tel" id="clientPhone" class="form-control form-control-sm" placeholder="{{ __('e.g., 06 12 34 56 78') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">{{ __('Notes (optional)') }}</label>
                                    <textarea id="clientNotes" rows="2" class="form-control form-control-sm" placeholder="{{ __('No onions, extra spicy…') }}"></textarea>
                                </div>
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
                            <div class="text-muted small mt-2">{{ __('Keep this QR handy. Staff can scan it to retrieve your order.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <small class="text-muted me-auto">{{ __('Privacy: the QR only contains your order info, and optional name/phone if provided.') }}</small>
                    <button class="btn btn-primary" data-bs-dismiss="modal">{{ __('Done') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS assets -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        /* ===== Helpers ===== */
        function formatMoney(val){ return (parseFloat(val).toFixed(2)) + '{{ $currency }}'; }
        function escapeRegExp(s){ return s.replace(/[.*+?^${}()|[\]\\]/g,'\\$&'); }
        function highlight(text, q){ if(!q) return text; const re = new RegExp(`(${escapeRegExp(q)})`,'ig'); return text.replace(re,'<mark>$1</mark>'); }

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
        window.addEventListener('scroll', () => { toTop.style.display = window.scrollY > 500 ? 'flex' : 'none'; });
        toTop.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));

        /* Quick tags fill search */
        document.querySelectorAll('.qtag').forEach(tag=>{
            tag.addEventListener('click', ()=> {
                const text = tag.textContent.replace(/^[^\w\u0600-\u06FF]+/,'').trim();
                const input = document.getElementById('menuSearch');
                input.value = text;
                input.dispatchEvent(new Event('input'));
                input.focus();
            });
        });

        /* Live search (with highlight) */
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
            document.getElementById('addToCart').disabled = !ok;
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

        /* ===== Client Cart (localStorage) ===== */
        const cartKey   = 'clientCart';
        const cart      = document.getElementById('cart');
        const cartToggle= document.getElementById('cartToggle');
        const cartBody  = document.getElementById('cartBody');
        const cartTotal = document.getElementById('cartTotal');
        const cartCount = document.getElementById('cartCount');
        const clearCart = document.getElementById('clearCart');

        function getCart(){ try { return JSON.parse(localStorage.getItem(cartKey)||'[]'); } catch(e){ return []; } }
        function setCart(arr){ localStorage.setItem(cartKey, JSON.stringify(arr)); renderCart(); }

        function addToCart(line){
            const arr = getCart();
            arr.push(line);
            setCart(arr);
            cart.classList.add('open');
            cartToggle.querySelector('.badge').classList.add('animate__animated','animate__heartBeat');
            setTimeout(()=> cartToggle.querySelector('.badge').classList.remove('animate__animated','animate__heartBeat'), 900);
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
                    if(act==='inc'){
                        ln.qty += 1;
                    }else if(act==='dec'){
                        ln.qty = Math.max(1, ln.qty-1);
                    }else if(act==='rm'){
                        arr.splice(idx,1);
                    }
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
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        const qrcodeBox = document.getElementById('qrcode');
        let qrInstance = null;

        function buildOrderPayload(){
            const items = getCart().map(l => ({
                name: l.name,
                qty:  l.qty,
                unit: +l.unit.toFixed(2),
                total:+l.total.toFixed(2),
                sel:  (l.selections||[]).map(v => ({
                    name: v.name,
                    options: v.options.map(o => ({n:o.name, a:+o.adj.toFixed(2)}))
                }))
            }));
            const payload = {
                v: 1,                                // version
                rid: '{{ hash('crc32b', $restaurantName) }}', // simple restaurant id hash
                r: '{{ $restaurantName }}',
                t: Date.now(),
                cur: '{{ trim($currency) }}',
                items,
                sum: +items.reduce((s,i)=>s+i.total,0).toFixed(2)
            };
            const name  = (document.getElementById('clientName').value||'').trim();
            const phone = (document.getElementById('clientPhone').value||'').trim();
            const notes = (document.getElementById('clientNotes').value||'').trim();
            if(name)  payload.cname = name;
            if(phone) payload.cphone = phone;
            if(notes) payload.notes = notes;
            return payload;
        }

        function renderConfirmSummary(){
            const arr = getCart();
            const box = document.getElementById('confirmSummary');
            if(!arr.length){ box.innerHTML = `<div class="text-muted">{{ __('Your cart is empty.') }}</div>`; return; }
            box.innerHTML = arr.map(l=>{
                const opts = (l.selections||[]).map(v=>{
                    const os = v.options.map(o=> o.name + (o.adj?` (+${o.adj.toFixed(2)}{{ $currency }})`:``)).join(', ');
                    return `<div class="text-muted">${v.name}: ${os}</div>`;
                }).join('');
                return `<div class="mb-2">
                            <div class="d-flex justify-content-between">
                                <div><strong>${l.name}</strong> × ${l.qty}</div>
                                <div class="fw-bold">${l.total.toFixed(2)}{{ $currency }}</div>
                            </div>
                            ${opts}
                        </div>`;
            }).join('') + `<hr class="my-2"><div class="d-flex justify-content-between"><div class="fw-bold">{{ __('Total') }}</div><div class="fw-bold">${arr.reduce((s,i)=>s+i.total,0).toFixed(2)}{{ $currency }}</div></div>`;
        }

        function generateQR(){
            const data = buildOrderPayload();
            const json = JSON.stringify(data);
            // compress a little by base64 (optional – here plain JSON is okay for typical orders)
            const text = json;
            qrcodeBox.innerHTML = '';
            qrInstance = new QRCode(qrcodeBox, {
                text,
                width: 220,
                height: 220,
                correctLevel: QRCode.CorrectLevel.M
            });
        }

        function downloadQR(){
            const canvas = qrcodeBox.querySelector('canvas');
            if(!canvas) return;
            const link = document.getElementById('downloadQR');
            link.download = `order-qr-{{ Str::slug($restaurantName) }}.png`;
            link.href = canvas.toDataURL('image/png');
        }

        document.getElementById('confirmOrder').addEventListener('click', ()=>{
            if(!getCart().length){
                cart.classList.add('open');
                return;
            }
            renderConfirmSummary();
            // generate first QR
            setTimeout(()=> { generateQR(); downloadQR(); }, 10);
            confirmModal.show();
        });

        document.getElementById('regenQR').addEventListener('click', ()=>{
            generateQR(); downloadQR();
        });
        document.getElementById('downloadQR').addEventListener('click', (e)=>{
            // href is set on generate; ensure present
            if(!e.currentTarget.href) { e.preventDefault(); generateQR(); downloadQR(); }
        });
        document.getElementById('printQR').addEventListener('click', ()=>{
            const canvas = qrcodeBox.querySelector('canvas');
            if(!canvas) return;
            const dataUrl = canvas.toDataURL('image/png');
            const w = window.open('', 'PRINT', 'height=400,width=400');
            w.document.write(`<img src="${dataUrl}" style="width:100%;height:auto;"/>`);
            w.document.close(); w.focus(); w.print(); w.close();
        });
    </script>
</body>
</html>
