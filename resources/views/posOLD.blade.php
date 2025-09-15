{{-- resources/views/pos.blade.php --}}
@php
    use Illuminate\Support\Str;

    /* ---------- Locale & helpers ---------- */
    $default_language = request('lang', app()->getLocale() ?: 'en');
    app()->setLocale($default_language);

    /* ---------- Random restaurant fallback (if none passed) ---------- */
    if (empty($restaurant) || !is_array($restaurant)) {
        $randNames = ['Atlas Grill', 'Kasbah Kitchen', 'Cedar & Spice', 'Marrakshi Bites', 'Café Fig'];
        $randTaglines = ['Fresh • Local • Delicious', 'Eat Well • Live Well', 'Good Food • Good Mood', 'Savor the Moment'];
        $restaurant = [
            'name' => $randNames[array_rand($randNames)],
            'logo' => null,
            'address' => '123 Souk Street, Medina',
            'phone_number_1' => '+212 6 12 34 56 78',
            'phone_number_2' => '+212 5 22 11 22 33',
            'settings' => [
                'tagline' => $randTaglines[array_rand($randTaglines)],
                'tax_rate' => 0,      // removed from UI/Calc
                'service_rate' => 0,  // removed from UI/Calc
            ],
        ];
    }

    $restaurantName = $restaurant['name'] ?? 'Restaurant';
    $logo = $restaurant['logo'] ?? null;
    $restaurantAddress = $restaurant['address'] ?? '';
    $phone1 = $restaurant['phone_number_1'] ?? '';
    $phone2 = $restaurant['phone_number_2'] ?? '';
    $tagline = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';

    $currency = ' DH';

    // Force Tax/Service OFF entirely (removed from UI and calculations)
    $taxRate = 0;
    $serviceRate = 0;

    $isRTL = in_array(strtolower($default_language), ['ar', 'he', 'fa', 'ur']);

    /* ---------- Data from new structure ---------- */
    // Expecting $articles as an array of items (with embedded `current_translation`, `category`, `variations`, etc.)
    $articles = $articles ?? [];

    // Build a unique list of categories from articles
    $categoriesMap = []; // [id => name]
    foreach ($articles as $it) {
        if (!empty($it['category']) && isset($it['category']['id'], $it['category']['name'])) {
            $categoriesMap[$it['category']['id']] = $it['category']['name'];
        }
    }

    // Placeholder path (as requested)
    $placeholder = '/assets/img/gallery/placeholder.png';
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language }}" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurantName }} – POS</title>

    <!-- Assets -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Playfair+Display:wght@700;800&display=swap"
        rel="stylesheet">

    <!-- QR Scanner (for importing client QR) -->
    <script src="https://unpkg.com/html5-qrcode" defer></script>

    <style>
        :root {
            /* ===== Fresh café/restaurant green palette ===== */
            --brand: #0F8B4C;          /* primary green */
            --brand-600: #0b6b3e;      /* darker */
            --brand2: #cfeedd;         /* soft green border fill */
            --brand2-strong: #a9e0c2;  /* stronger soft */
            --ink: #1f2937;
            --muted: #6b7280;
            --soft: #F4FBF6;           /* background */
            --card: #ffffff;
            --line: #DCEFE2;           /* soft green divider */
            --ring: rgba(15, 139, 76, .22);
            --success: #16a34a;
            --danger: #ef4444;
            --warning: #f59e0b;
            --accent: #22c55e;
            --mint: #E9F8EF;
            --pearl: #F7FDF9;
        }

        * { box-sizing: border-box }
        html { scroll-behavior: smooth }
        body {
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            color: var(--ink);
            background: var(--soft);
        }

        /* ===== Header ===== */
        .pos-header {
            position: sticky; top: 0; z-index: 70;
            background: linear-gradient(135deg, var(--pearl) 0%, var(--mint) 100%);
            border-bottom: 1px solid #e6f3ea; padding: .6rem 0;
        }
        .brand-wrap { display:flex; align-items:center; gap:.75rem }
        .logo-ring {
            width:56px; height:56px; border-radius:50%; background:#fff; border:3px solid #eef8f1;
            display:flex; align-items:center; justify-content:center; overflow:hidden;
            box-shadow:0 6px 14px rgba(0,0,0,.1);
        }
        .logo-ring img { width:86%; height:86%; object-fit:contain; border-radius:50% }
        .brand-title { display:flex; flex-direction:column }
        .brand-title h1 { font-family:'Playfair Display', serif; font-size:1.25rem; font-weight:800; line-height:1; margin:0 }
        .brand-title small { color:#4b5563 }
        .header-tools { display:flex; gap:.5rem; align-items:center; justify-content:flex-end }

        /* Language switcher */
        .btn-pill {
            background:#fff; border:1px solid #dbeee3; color:var(--ink);
            padding:.35rem .7rem; border-radius:999px; font-weight:700; font-size:.9rem; transition:.2s;
            box-shadow:0 2px 6px rgba(0,0,0,.05);
        }
        .btn-pill:hover { background:#f5fbf7; }
        .pos-header .dropdown-menu {
            border:none; border-radius:.75rem; padding:.35rem; min-width:12rem; background:#fff;
            box-shadow:0 16px 36px rgba(0,0,0,.12);
        }
        .pos-header .dropdown-item { border-radius:.5rem; padding:.5rem .75rem; color:#111; }
        .pos-header .dropdown-item:hover { background: rgba(15, 139, 76, .08) }
        .pos-header .dropdown-item.active { background: linear-gradient(135deg, #e8f7ee, #fff); font-weight:800 }

        /* Header table toggle */
        .btn-circle {
            width:40px; height:40px; border-radius:50%; border:1px solid #dbeee3; background:#fff;
            display:inline-flex; align-items:center; justify-content:center;
        }
        .table-badge { background:#111827; color:#fff; border-radius:6px; padding:.1rem .4rem; font-size:.7rem; font-weight:800 }

        /* ===== Shell layout ===== */
        .pos-shell { display:grid; gap:1rem; grid-template-columns:1fr 390px; padding:.9rem .9rem 1.2rem; }
        @media (max-width: 1100px) { .pos-shell { grid-template-columns: 1fr } }

        /* ===== Panels ===== */
        .panel { background:var(--card); border:1px solid var(--line); border-radius:1rem; box-shadow:0 4px 16px rgba(0,0,0,.06); }
        .panel-head { padding:.6rem .9rem; border-bottom:1px solid var(--line) }
        .panel-body { padding:.8rem }

        /* ===== Order type CARDS (always visible) ===== */
        .choice-cards { display:grid; gap:.5rem; grid-template-columns:repeat(3,minmax(0,1fr)); margin-bottom:.6rem; }
        @media (max-width:576px){ .choice-cards { grid-template-columns: 1fr 1fr 1fr } }
        .choice-card {
            border:2px solid #e4f4ea; background:#fff; border-radius:.9rem; padding:.6rem .7rem;
            display:flex; gap:.6rem; align-items:center; cursor:pointer; user-select:none; transition:.15s;
        }
        .choice-card:hover { box-shadow:0 6px 16px rgba(0,0,0,.06); transform:translateY(-1px) }
        .choice-card.active { box-shadow:0 0 0 4px var(--ring); border-color:var(--brand2) }
        .choice-ico {
            width:36px; height:36px; border-radius:10px; background:#f2fbf5; border:1px solid #d8efe0;
            display:flex; align-items:center; justify-content:center; color:var(--brand-600); font-size:1rem; flex-shrink:0
        }
        .choice-label { font-weight:800 }

        /* ===== Search & actions row ===== */
        .search-row { display:flex; gap:.5rem; align-items:center; flex-wrap:wrap; justify-content:space-between }
        .pos-search {
            border:2px solid #e4f4ea; border-radius:999px; padding:.55rem .9rem; min-width:280px; flex:1;
        }
        .pos-search:focus { border-color:var(--brand2); box-shadow:0 0 0 6px var(--ring); outline:0 }
        .import-wrap { display:flex; gap:.35rem; align-items:center }
        .import-wrap .form-control { border-radius:.6rem; border:1px solid #e0f1e7; height:40px; font-size:.92rem; min-width:230px }
        .btn-sub { border:1px solid #e4f4ea; background:#fff; border-radius:.7rem; font-weight:700; padding:.45rem .7rem }

        /* ===== Categories ===== */
        .categories-scroll { display:flex; gap:.5rem; flex-wrap:nowrap; overflow:auto; scrollbar-width:none; -ms-overflow-style:none; padding:.5rem .2rem 0; }
        .categories-scroll::-webkit-scrollbar { display:none }
        .categories-scroll .btn {
            border-radius:999px; border:1px solid #e4f4ea; background:#fff; color:#124b2d; font-weight:700; padding:.35rem .85rem;
        }
        .categories-scroll .btn.active { background:#eaf7f0; border-color:#cdebdc; color:#1f2937; box-shadow:0 4px 10px rgba(0,0,0,.08) }

        /* ===== Items grid ===== */
        .items-grid { display:grid; gap:.7rem; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); margin-top:.6rem; }
        .item-card {
            background:#fff; border:1px solid var(--line); border-radius:.9rem; overflow:hidden; cursor:pointer;
            transition:.18s; display:flex; flex-direction:column;
        }
        .item-card:hover { transform:translateY(-2px); box-shadow:0 10px 22px rgba(0,0,0,.08) }

        .item-thumb {
            height:110px; background:#fff; display:flex; align-items:center; justify-content:center; overflow:hidden;
        }
        .item-thumb img { width:100%; height:100%; object-fit:contain; object-position:center; }

        .item-meta { padding:.6rem .65rem .7rem }
        .item-meta h5 { font-size:.98rem; font-weight:800; margin:0 0 .25rem }
        .price-tag { font-weight:800; color:var(--brand) }

        /* ===== Cart ===== */
        .cart { position:sticky; top:78px; max-height:calc(100vh - 96px); overflow:auto; }
        .cart-head { padding:.75rem .9rem; border-bottom:1px solid var(--line); display:flex; align-items:center; justify-content:space-between }
        .cart-body { padding:.65rem .9rem }
        .cart-line { display:grid; grid-template-columns:1fr auto; gap:.4rem; border-bottom:1px dashed #e4f4ea; padding:.55rem 0; }
        .cart-line:last-child { border-bottom:none }
        .cart-line h6 { margin:0; font-weight:800 }
        .opts small { color:var(--muted) }
        .qty-ctrl { display:flex; align-items:center; gap:.35rem }
        .qty-ctrl button { width:26px; height:26px; border:1px solid #e4f4ea; background:#f2fbf5; border-radius:6px }
        .line-total { font-weight:800 }
        .cart-foot { padding:.75rem .9rem; border-top:1px solid var(--line); background:#f7fcf9 }
        .tot-row { display:flex; align-items:center; justify-content:space-between; margin:.2rem 0 }
        .grand { font-size:1.15rem; font-weight:800 }
        .btn-main {
            background:var(--brand); color:#fff; border:none; border-radius:.7rem; font-weight:800; padding:.6rem .9rem;
            box-shadow:0 10px 22px rgba(15,139,76,.22);
        }
        .btn-main:hover { background:var(--brand-600) }
        .btn-danger-soft { border:1px solid #fde2e2; background:#fff5f5; color:#991b1b }
        .parked { border-top:1px dashed #e4f4ea; margin-top:.6rem; padding-top:.6rem }
        .order-chip {
            display:flex; align-items:center; justify-content:space-between; gap:.5rem; border:1px dashed #e4f4ea;
            border-radius:.65rem; padding:.35rem .5rem; background:#fff; margin-bottom:.45rem;
        }
        .badge-pill { border-radius:999px; padding:.15rem .55rem }

        /* ===== Modal: Item config (option CARDS) ===== */
        .modal-content { border:0; border-radius:1rem; box-shadow:0 10px 36px rgba(0,0,0,.18) }
        .modal-header { background:#eefaf3; border-bottom:none }
        .modal-title { font-weight:800; color:#0d5d37 }
        #cfgImg { width:120px; height:120px; object-fit:cover; border-radius:.8rem; box-shadow:0 6px 16px rgba(0,0,0,.1) }
        .cfg-price { font-weight:800; color:var(--brand) }
        .v-group { margin:.9rem 0 }
        .v-title { font-weight:800; margin-bottom:.5rem }
        .options-grid { display:grid; gap:.55rem; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); }

        /* Improved selection styling */
        .option-card {
            position:relative; display:block; user-select:none; cursor:pointer; background:#fff;
            border:1.5px solid #d8efe0; border-radius:.85rem; padding:.6rem .65rem; transition:.15s; height:100%;
        }
        .option-card:hover { box-shadow:0 6px 14px rgba(0,0,0,.06) }
        .option-card.disabled { opacity:.45; cursor:not-allowed }
        .option-input { position:absolute; opacity:0; pointer-events:none; width:0; height:0 }
        .option-inner { display:flex; align-items:center; justify-content:space-between; gap:.75rem }
        .option-name { font-weight:700; color:#1f2937 }
        .option-badge { background:#f2fbf5; border:1px solid #d8efe0; color:#0d5d37; border-radius:.65rem; padding:.15rem .45rem; font-size:.8rem; white-space:nowrap }

        /* Visual "selected" state (supports modern :has and JS class fallback) */
        .option-card.selected,
        .option-card:has(.option-input:checked) {
            background: linear-gradient(0deg, #ffffff 0%, #f0fbf6 100%);
            border-color: #bfe7d2;
            box-shadow: 0 8px 18px rgba(15,139,76,.12);
        }
        .option-card.selected::after,
        .option-card:has(.option-input:checked)::after {
            content:""; position:absolute; top:10px; right:10px; width:18px; height:18px; border-radius:50%;
            border:2px solid var(--brand); background:#fff;
            box-shadow: inset 0 0 0 6px var(--brand);
        }
        .option-card:focus-within { outline:3px solid var(--ring); outline-offset:2px }

        .option-hint { font-size:.85rem; color:#6b7280; margin-top:.15rem }
        .qty-wrap { display:flex; align-items:center; gap:.45rem }
        .qty-btn { width:32px; height:32px; display:flex; align-items:center; justify-content:center; border-radius:8px; border:1px solid #d8efe0; background:#f2fbf5 }
        .qty-input { width:58px; text-align:center; border:1px solid #d8efe0; background:#fff; border-radius:8px; padding:.32rem 0 }
        .req-hint { font-size:.9rem; color:#b45309; display:none }

        /* ===== Payment & Scanner ===== */
        .pay-methods .btn { border:1px solid #e4f4ea; background:#fff; padding:.5rem .75rem; border-radius:.7rem; font-weight:700 }
        .pay-methods .btn.active { background:#eaf6ef; border-color:#cde8d5; color:#065f46 }
        .change-box { background:#ecfdf5; border:1px solid #bbf7d0; color:#064e3b; border-radius:.6rem; padding:.45rem .65rem; font-weight:800 }

        /* ===== Offcanvas: Tables ===== */
        .table-grid { display:grid; gap:.6rem; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)) }
        .table-card { border:2px solid #e4f4ea; background:#fff; border-radius:.9rem; padding:.7rem .6rem; text-align:center; cursor:pointer; user-select:none; transition:.15s; }
        .table-card:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(0,0,0,.06) }
        .table-card.active { box-shadow:0 0 0 4px var(--ring); border-color:var(--brand2) }
        .table-ico { width:38px; height:38px; border-radius:10px; background:#f2fbf5; border:1px solid #d8efe0; display:flex; align-items:center; justify-content:center; color:var(--brand-600); margin:0 auto .35rem }
        .offcanvas-header { border-bottom:1px solid var(--line) }
        .offcanvas-footer { border-top:1px solid var(--line); padding:.75rem .9rem }

        /* Print minimalism */
        @media print {
            .pos-header, .panel-head, .categories-scroll, .cart-foot .btn, .parked { display:none !important; }
            .pos-shell { grid-template-columns:1fr !important; padding:0 }
            .panel, .cart { border:none; box-shadow:none }
        }
    </style>
</head>

<body>

    {{-- ===== Header ===== --}}
    <div class="pos-header">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="brand-wrap">
                    <div class="logo-ring">
                        <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/logo.svg') }}" alt="Logo"
                             onerror="this.onerror=null;this.src='{{ asset('assets/img/logo/logo.svg') }}';">
                    </div>
                    <div class="brand-title">
                        <h1>{{ $restaurantName }} <span class="badge-pill ms-1"
                                style="background:#fff; border:1px solid #e4f4ea; font-size:.7rem;">POS</span></h1>
                        <small>{{ $tagline }}</small>
                    </div>
                </div>

                <div class="header-tools">
                    @if ($restaurantAddress)
                        <div class="text-muted d-none d-md-block me-2">
                            <i class="fa-solid fa-location-dot"></i> {{ $restaurantAddress }}
                        </div>
                    @endif

                    {{-- Lang switcher --}}
                    <div class="dropdown">
                        <button class="btn-pill d-flex align-items-center gap-2" data-bs-toggle="dropdown"
                            aria-expanded="false">
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

                    {{-- Table toggle --}}
                    <button class="btn-circle" id="openTables" title="{{ __('Choose Table') }}"
                        data-bs-toggle="offcanvas" data-bs-target="#tablesCanvas" aria-controls="tablesCanvas">
                        <i class="fa-solid fa-chair"></i>
                    </button>
                    <span class="table-badge ms-1" id="tableBadge">—</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== POS shell ===== --}}
    <div class="container-fluid pos-shell">

        {{-- ===== Left: Catalog ===== --}}
        <section class="panel">
            <div class="panel-head">

                {{-- 1) Order Type: big cards (always visible) --}}
                <div class="choice-cards" id="orderTypeCards">
                    <div class="choice-card active" data-type="dinein" tabindex="0" role="button" aria-pressed="true">
                        <div class="choice-ico"><i class="fa-solid fa-utensils"></i></div>
                        <div>
                            <div class="choice-label">{{ __('Dine-in') }}</div>
                            <small class="text-muted">{{ __('Assign to a table') }}</small>
                        </div>
                    </div>
                    <div class="choice-card" data-type="takeaway" tabindex="0" role="button" aria-pressed="false">
                        <div class="choice-ico"><i class="fa-solid fa-bag-shopping"></i></div>
                        <div>
                            <div class="choice-label">{{ __('Takeaway') }}</div>
                            <small class="text-muted">{{ __('Pack & go') }}</small>
                        </div>
                    </div>
                    <div class="choice-card" data-type="delivery" tabindex="0" role="button" aria-pressed="false">
                        <div class="choice-ico"><i class="fa-solid fa-truck"></i></div>
                        <div>
                            <div class="choice-label">{{ __('Delivery') }}</div>
                            <small class="text-muted">{{ __('Send to address') }}</small>
                        </div>
                    </div>
                </div>

                {{-- 2) Search + QR scanner (input/import removed) --}}
                <div class="search-row">
                    <input id="posSearch" type="search" class="pos-search" placeholder="{{ __('Search items…') }}"
                        aria-label="{{ __('Search items…') }}">
                    <div class="import-wrap">
                        {{-- Client code input & import button removed as requested --}}
                        <button class="btn btn-sub" id="scanCode" data-bs-toggle="modal" data-bs-target="#scanModal"
                            title="{{ __('Scan QR') }}"><i class="fa-solid fa-qrcode"></i></button>
                    </div>
                </div>

                {{-- 3) Categories (derived from $articles) --}}
                <div class="categories-scroll" id="catPills">
                    <button class="btn active" data-cat="__all">{{ __('All') }}</button>
                    @foreach ($categoriesMap as $catId => $catName)
                        @php $slug = Str::slug($catName); @endphp
                        <button class="btn" data-cat="{{ $slug }}">{{ $catName }}</button>
                    @endforeach
                </div>
            </div>

            <div class="panel-body">
                {{-- Items grid --}}
                <div class="items-grid" id="itemsGrid">
                    @foreach ($articles as $item)
                        @php
                            $catName = $item['category']['name'] ?? 'Uncategorized';
                            $slug = Str::slug($catName);

                            $name = trim($item['current_translation']['name'] ?? ($item['name'] ?? 'Item'));
                            $desc = trim($item['current_translation']['description'] ?? '');

                            // Choose price: sale_price > current_price > price
                            $baseVal = (float) ($item['sale_price'] ?? $item['current_price'] ?? $item['price'] ?? 0);

                            // Placeholder if no image
                            $img = !empty($item['image']) ? $item['image'] : $placeholder;

                            $minQty = $item['min_qty'] ?? 1;
                            $maxQty = $item['max_qty'] ?? null;

                            $variations = $item['variations'] ?? [];
                        @endphp
                        <div class="item-card"
                             data-cat="{{ $slug }}"
                             data-name="{{ e($name) }}"
                             data-desc="{{ e($desc) }}"
                             data-img="{{ $img }}"
                             data-base="{{ number_format($baseVal, 2, '.', '') }}"
                             data-minqty="{{ (int) $minQty }}"
                             data-maxqty="{{ $maxQty ? (int) $maxQty : '' }}"
                             data-variations='@json($variations)'>
                            <div class="item-thumb">
                                <img src="{{ $img }}" alt="{{ $name }}"
                                     onerror="this.onerror=null;this.src='{{ $placeholder }}';">
                            </div>
                            <div class="item-meta">
                                <h5 class="text-truncate" title="{{ $name }}">{{ $name }}</h5>
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class="price-tag">{{ number_format($baseVal, 2) . $currency }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ===== Right: Cart / Totals ===== --}}
        <aside class="panel cart">
            <div class="cart-head">
                <div class="fw-bold">
                    <i class="fa-solid fa-basket-shopping me-1" style="color:var(--brand)"></i>{{ __('Current Order') }}
                    <span class="badge-pill ms-1" style="background:#fff; border:1px solid #e4f4ea">{{ __('Type') }}:
                        <span id="orderTypeBadge">DINE-IN</span></span>
                    <span class="badge-pill ms-1" style="background:#fff; border:1px solid #e4f4ea">{{ __('Table') }}:
                        <span id="cartTableBadge">—</span></span>
                </div>
                <div class="d-flex gap-1">
                    <button class="btn btn-sub btn-sm" id="holdOrder"><i
                            class="fa-solid fa-box-archive me-1"></i>{{ __('Hold') }}</button>
                    <button class="btn btn-danger-soft btn-sm" id="clearCart"><i
                            class="fa-solid fa-trash-can me-1"></i>{{ __('Clear') }}</button>
                </div>
            </div>

            <div class="cart-body" id="cartLines"></div>

            <div class="cart-foot">
                <div class="tot-row"><span>{{ __('Subtotal') }}</span><strong id="t_sub">0{{ $currency }}</strong></div>

                <div class="tot-row align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span>{{ __('Discount') }}</span>
                        <div class="btn-group btn-group-sm" role="group">
                            <input type="radio" class="btn-check" name="discType" id="discAmt" autocomplete="off" checked>
                            <label class="btn btn-outline-secondary" for="discAmt">{{ __('Amount') }}</label>
                            <input type="radio" class="btn-check" name="discType" id="discPct" autocomplete="off">
                            <label class="btn btn-outline-secondary" for="discPct">%</label>
                        </div>
                    </div>
                    <div>
                        <input id="discVal" type="number" class="form-control form-control-sm" step="0.01" value="0" style="width:110px; text-align:right">
                    </div>
                </div>

                {{-- Service & Tax rows removed by request --}}

                <div class="tot-row grand"><span>{{ __('Grand Total') }}</span><span id="t_grand">0{{ $currency }}</span></div>

                <div class="d-grid gap-2 mt-3">
                    <button class="btn-main" id="checkoutBtn"><i class="fa-solid fa-cash-register me-1"></i>{{ __('Charge Payment') }}</button>
                    <small class="text-muted">{{ __('All prices in') }} {{ trim($currency) }}</small>
                </div>

                {{-- Parked orders --}}
                <div class="parked">
                    <div class="fw-bold mb-2"><i class="fa-solid fa-clock-rotate-left me-1"></i>{{ __('Held Orders') }}</div>
                    <div id="parkedList"></div>
                </div>
            </div>
        </aside>
    </div>

    {{-- ===== Item Config Modal ===== --}}
    <div class="modal fade" id="cfgModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column flex-sm-row align-items-sm-start gap-3">
                        <img id="cfgImg" src="" alt=""
                             onerror="this.onerror=null;this.src='{{ $placeholder }}';">
                        <div class="flex-grow-1">
                            <p id="cfgDesc" class="mb-2"></p>
                            <h5 id="cfgPrice" class="cfg-price mb-3"></h5>

                            <div id="cfgOptions"></div>

                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <div class="qty-wrap">
                                    <button class="qty-btn" id="cfgMinus"><i class="fa-solid fa-minus"></i></button>
                                    <input id="cfgQty" class="qty-input" type="number" value="1" min="1" step="1">
                                    <button class="qty-btn" id="cfgPlus"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                <div class="req-hint" id="cfgReq">{{ __('Please complete required selections.') }}</div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <button id="cfgAdd" class="btn-main"><i class="fa-solid fa-cart-plus me-1"></i>{{ __('Add to Order') }}</button>
                                <small class="text-muted">{{ __('Unit price reflects selected options') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Payment Modal ===== --}}
    <div class="modal fade" id="payModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-cash-register me-2"></i>{{ __('Take Payment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">{{ __('Grand Total') }}: <strong id="payTotal">0{{ $currency }}</strong></div>
                    <div class="pay-methods d-flex gap-2 mb-2">
                        <button class="btn btn-sm active" data-pay="cash"><i class="fa-solid fa-money-bill-wave me-1"></i>{{ __('Cash') }}</button>
                        <button class="btn btn-sm" data-pay="card"><i class="fa-solid fa-credit-card me-1"></i>{{ __('Card') }}</button>
                        <button class="btn btn-sm" data-pay="other"><i class="fa-solid fa-wallet me-1"></i>{{ __('Other') }}</button>
                    </div>
                    <div class="row g-2 align-items-end">
                        <div class="col-6">
                            <label class="form-label small">{{ __('Amount Tendered') }}</label>
                            <input id="payGiven" type="number" step="0.01" class="form-control" value="0">
                        </div>
                        <div class="col-6">
                            <div class="change-box"><i class="fa-solid fa-coins me-1"></i>{{ __('Change') }}:
                                <span id="payChange">0{{ $currency }}</span></div>
                        </div>
                    </div>
                    <div class="mt-3 d-grid gap-2">
                        <button id="finalizePayment" class="btn-main"><i class="fa-solid fa-check me-1"></i>{{ __('Finalize & Print') }}</button>
                        <button id="finalizeNoPrint" class="btn-sub"><i class="fa-solid fa-check me-1"></i>{{ __('Finalize (No Print)') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Scanner Modal (import client QR) ===== --}}
    <div class="modal fade" id="scanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-qrcode me-2"></i>{{ __('Scan Client QR') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="text-muted small mb-2">
                        {{ __('When detected, items will be added to the current order automatically.') }}</div>
                    <div id="qrReader"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Offcanvas: Tables (card selector) ===== --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="tablesCanvas" aria-labelledby="tablesCanvasLabel">
        <div class="offcanvas-header">
            <h5 id="tablesCanvasLabel"><i class="fa-solid fa-chair me-2"></i>{{ __('Select Table') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="{{ __('Close') }}"></button>
        </div>
        <div class="offcanvas-body">
            <div id="tablesNotice" class="alert alert-warning py-2 px-3 d-none">
                <i class="fa-solid fa-circle-info me-1"></i>
                {{ __('Tables can be assigned for Dine-in orders only.') }}
            </div>
            <div class="table-grid" id="tablesGrid">
                @for ($i = 1; $i <= 40; $i++)
                    <div class="table-card" data-table="{{ $i }}" role="button" tabindex="0" aria-label="{{ __('Table') }} {{ $i }}">
                        <div class="table-ico"><i class="fa-solid fa-chair"></i></div>
                        <div class="fw-bold">{{ __('Table') }} #{{ $i }}</div>
                        <small class="text-muted">{{ __('Available') }}</small>
                    </div>
                @endfor
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="d-flex justify-content-between">
                <button class="btn btn-danger-soft" id="clearTable"><i class="fa-solid fa-xmark me-1"></i>{{ __('Clear Table') }}</button>
                <button class="btn btn-main" data-bs-dismiss="offcanvas">{{ __('Done') }}</button>
            </div>
        </div>
    </div>

    <!-- JS assets -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        /* ========= Globals ========= */
        const CURR = '{{ $currency }}';
        const TAX = 0; // removed
        const SRV = 0; // removed
        const isRTL = {{ $isRTL ? 'true' : 'false' }};
        const PLACEHOLDER = '{{ $placeholder }}';

        const cfgModal = new bootstrap.Modal(document.getElementById('cfgModal'));
        const payModal = new bootstrap.Modal(document.getElementById('payModal'));

        function money(n) { return (parseFloat(n || 0).toFixed(2)) + CURR; }
        function uid() { return 'id' + Math.random().toString(36).slice(2, 9); }

        /* ========= Order Type state ========= */
        let orderType = 'dinein'; // default
        let currentTable = null;

        const orderTypeBadge = document.getElementById('orderTypeBadge');
        const tableBadge = document.getElementById('tableBadge');
        const cartTableBadge = document.getElementById('cartTableBadge');

        function setOrderType(type) {
            orderType = type;
            document.querySelectorAll('#orderTypeCards .choice-card').forEach(c => {
                const active = c.getAttribute('data-type') === type;
                c.classList.toggle('active', active);
                c.setAttribute('aria-pressed', active ? 'true' : 'false');
            });
            orderTypeBadge.textContent = type.toUpperCase();
            if (type !== 'dinein') {
                currentTable = null;
                updateTableBadges();
            }
        }

        function updateTableBadges() {
            const v = currentTable ? ('#' + currentTable) : '—';
            tableBadge.textContent = currentTable ? ('T' + currentTable) : '—';
            cartTableBadge.textContent = v;
            document.querySelectorAll('.table-card').forEach(card => {
                card.classList.toggle('active', String(card.getAttribute('data-table')) === String(currentTable || ''));
            });
        }

        document.querySelectorAll('#orderTypeCards .choice-card').forEach(card => {
            card.addEventListener('click', () => setOrderType(card.getAttribute('data-type')));
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setOrderType(card.getAttribute('data-type')); }
            });
        });
        setOrderType('dinein');

        /* ========= Build menu index (for importing) ========= */
        const menuIndex = {};
        document.querySelectorAll('.item-card').forEach(el => {
            const name = el.getAttribute('data-name');
            menuIndex[name] = {
                base: parseFloat(el.getAttribute('data-base') || '0'),
                img: el.getAttribute('data-img') || '',
                desc: el.getAttribute('data-desc') || '',
                variations: JSON.parse(el.getAttribute('data-variations') || '[]'),
                minqty: parseInt(el.getAttribute('data-minqty') || 1, 10),
                maxqty: parseInt(el.getAttribute('data-maxqty') || 0, 10) || null,
            };
        });

        /* ========= Catalog filters ========= */
        const catBtns = document.querySelectorAll('#catPills .btn');
        const grid = document.getElementById('itemsGrid');
        let activeCat = '__all';

        catBtns.forEach(b => {
            b.addEventListener('click', () => {
                catBtns.forEach(x => x.classList.remove('active'));
                b.classList.add('active');
                activeCat = b.getAttribute('data-cat');
                filterRender();
            });
        });

        const searchInput = document.getElementById('posSearch');
        searchInput.addEventListener('input', filterRender);

        function filterRender() {
            const q = (searchInput.value || '').trim().toLowerCase();
            grid.querySelectorAll('.item-card').forEach(card => {
                const cat = card.getAttribute('data-cat');
                const name = (card.getAttribute('data-name') || '').toLowerCase();
                const desc = (card.getAttribute('data-desc') || '').toLowerCase();
                const matchCat = activeCat === '__all' || cat === activeCat;
                const matchQ = !q || name.includes(q) || desc.includes(q);
                card.style.display = (matchCat && matchQ) ? 'flex' : 'none';
            });
        }

        /* ========= Item Config Modal (option CARDS) ========= */
        let currentCfg = null;

        function renderVariations(variations) {
            if (!variations || !variations.length) return '';
            let html = '';
            variations.forEach((v, i) => {
                const single = (parseInt(v.max_selections || 1, 10) === 1);
                const minSel = parseInt(v.min_selections || (v.is_required ? 1 : 0), 10);
                const maxSel = parseInt(v.max_selections || 99, 10);
                const vid = v.id || ('v' + i);

                html += `<div class="v-group" data-vid="${vid}" data-single="${single?1:0}" data-min="${minSel}" data-max="${maxSel}">
                           <div class="v-title">${v.name}${v.is_required ? ' <span class="text-danger">*</span>' : ''}</div>
                           <div class="options-grid">`;

                (v.options || []).forEach((o, j) => {
                    const def = String(o.is_default) === '1' ? ' data-default="1"' : '';
                    const dis = String(o.is_available) === '0' ? ' disabled' : '';
                    const adj = parseFloat(o.price_adjustment || 0) || 0;
                    const inputType = single ? 'radio' : 'checkbox';
                    const nameAttr = single ? `name="var_${vid}"` : '';
                    const oid = o.id || ('o' + j);

                    html += `
                        <label class="option-card ${dis?'disabled':''}">
                            <input class="option-input" type="${inputType}" ${nameAttr} value="${oid}" data-adj="${adj}" ${def} ${dis}>
                            <div class="option-inner">
                                <div class="option-name">${o.name}</div>
                                <div class="option-badge">${adj ? ('+'+adj.toFixed(2)+CURR) : '&nbsp;'}</div>
                            </div>
                        </label>
                    `;
                });

                html += `</div>`;
                if (!single) { html += `<div class="option-hint">{{ __('You can select up to') }} ${maxSel} {{ __('option(s)') }}</div>`; }
                html += `</div>`;
            });
            return html;
        }

        function applyDefaults() {
            document.querySelectorAll('#cfgOptions .v-group').forEach(g => {
                const single = g.getAttribute('data-single') === '1';
                const inputs = g.querySelectorAll('.option-input:not([disabled])');
                const defs = g.querySelectorAll('.option-input[data-default="1"]:not([disabled])');
                if (defs.length) {
                    if (single) { defs[0].checked = true; } else { defs.forEach(d => d.checked = true); }
                } else {
                    const min = parseInt(g.getAttribute('data-min') || 0, 10);
                    if (min > 0 && inputs.length === 1) { inputs[0].checked = true; }
                }
            });
            syncOptionCardStates();
        }

        function enforceMax(group, changedInput) {
            const single = group.getAttribute('data-single') === '1';
            const max = parseInt(group.getAttribute('data-max') || (single ? 1 : 99), 10);
            if (single) return;
            const checked = group.querySelectorAll('.option-input:checked');
            if (checked.length > max) {
                changedInput.checked = false;
                group.style.transform = 'scale(1.01)';
                setTimeout(() => group.style.transform = '', 120);
            }
        }

        function validateRequired() {
            let ok = true;
            document.querySelectorAll('#cfgOptions .v-group').forEach(g => {
                const min = parseInt(g.getAttribute('data-min') || 0, 10);
                if (min > 0) {
                    const sel = g.querySelectorAll('.option-input:checked').length;
                    if (sel < min) ok = false;
                }
            });
            document.getElementById('cfgAdd').disabled = !ok;
            document.getElementById('cfgReq').style.display = ok ? 'none' : 'block';
            return ok;
        }

        function cfgUnitPrice() {
            if (!currentCfg) return 0;
            let unit = currentCfg.base;
            document.querySelectorAll('#cfgOptions .option-input:checked').forEach(inp => {
                unit += parseFloat(inp.getAttribute('data-adj') || 0);
            });
            document.getElementById('cfgPrice').innerText = money(unit);
            return unit;
        }

        function gatherSelections() {
            const selections = [];
            document.querySelectorAll('#cfgOptions .v-group').forEach(g => {
                const vName = g.querySelector('.v-title').textContent.replace('*', '').trim();
                const opts = [];
                g.querySelectorAll('.option-input:checked').forEach(inp => {
                    const name = inp.closest('.option-card').querySelector('.option-name')?.textContent || '';
                    const adj = parseFloat(inp.getAttribute('data-adj') || 0);
                    opts.push({ name, adj });
                });
                if (opts.length) selections.push({ name: vName, options: opts });
            });
            return selections;
        }

        function syncOptionCardStates() {
            document.querySelectorAll('#cfgOptions .option-card').forEach(card => {
                const inp = card.querySelector('.option-input');
                card.classList.toggle('selected', !!(inp && inp.checked));
            });
        }

        // Open config on item click
        $(document).on('click', '.item-card', function() {
            const el = this;
            const name = el.getAttribute('data-name');
            const desc = el.getAttribute('data-desc') || '';
            let img = el.getAttribute('data-img') || '';
            if (!img) img = PLACEHOLDER;
            const base = parseFloat(el.getAttribute('data-base') || 0);
            const minq = parseInt(el.getAttribute('data-minqty') || 1, 10);
            const maxq = parseInt(el.getAttribute('data-maxqty') || 0, 10) || null;
            const variations = JSON.parse(el.getAttribute('data-variations') || '[]');

            currentCfg = { name, desc, img, base, minq, maxq };
            $('#cfgModal .modal-title').text(name);
            $('#cfgImg').attr('src', img);
            $('#cfgDesc').text(desc);
            $('#cfgQty').attr({ min: minq }).val(minq);
            if (maxq) $('#cfgQty').attr({ max: maxq }); else $('#cfgQty').removeAttr('max');
            $('#cfgOptions').html(renderVariations(variations));

            // bind option inputs (change)
            $('#cfgOptions').off('change').on('change', '.option-input', function() {
                enforceMax(this.closest('.v-group'), this);
                syncOptionCardStates();
                validateRequired();
                cfgUnitPrice();
            });

            applyDefaults();
            validateRequired();
            cfgUnitPrice();
            cfgModal.show();
        });

        // qty controls
        $('#cfgMinus').on('click', () => {
            const inp = document.getElementById('cfgQty');
            const min = parseInt(inp.min || 1, 10);
            let v = parseInt(inp.value || min, 10);
            v = Math.max(min, v - 1);
            inp.value = v;
        });
        $('#cfgPlus').on('click', () => {
            const inp = document.getElementById('cfgQty');
            const max = parseInt(inp.max || 0, 10) || Infinity;
            let v = parseInt(inp.value || 1, 10);
            v = Math.min(max, v + 1);
            inp.value = v;
        });

        /* ========= Cart ========= */
        const cartLines = [];
        const cartEl = document.getElementById('cartLines');

        function renderCart() {
            cartEl.innerHTML = '';
            let sub = 0, count = 0;
            cartLines.forEach((ln, idx) => {
                sub += ln.unit * ln.qty;
                count += ln.qty;
                const selHTML = (ln.selections || []).map(v => {
                    const opts = v.options.map(o => o.name + (o.adj ? ` (+${o.adj.toFixed(2)}${CURR})` : ``)).join(', ');
                    return `<div class="opts"><small>${v.name}: ${opts}</small></div>`;
                }).join('');
                const row = document.createElement('div');
                row.className = 'cart-line';
                row.innerHTML = `
                    <div>
                        <h6>${ln.name}</h6>
                        ${selHTML}
                        <div class="text-muted small">{{ __('Unit') }}: ${ln.unit.toFixed(2)}{{ $currency }}</div>
                    </div>
                    <div class="text-end">
                        <div class="qty-ctrl mb-1">
                            <button data-act="dec" data-idx="${idx}"><i class="fa-solid fa-minus"></i></button>
                            <span>${ln.qty}</span>
                            <button data-act="inc" data-idx="${idx}"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <div class="line-total">${(ln.unit*ln.qty).toFixed(2)}{{ $currency }}</div>
                        <button class="btn btn-link text-danger p-0 small" data-act="rm" data-idx="${idx}">{{ __('Remove') }}</button>
                    </div>
                `;
                cartEl.appendChild(row);
            });

            // totals (Service & Tax removed)
            const discTypePct = document.getElementById('discPct').checked;
            const discVal = parseFloat(document.getElementById('discVal').value || 0);
            let discount = discTypePct ? sub * (discVal / 100) : discVal;
            discount = Math.max(0, Math.min(discount, sub));

            let grand = sub - discount;

            document.getElementById('t_sub').innerText = money(sub);
            document.getElementById('t_grand').innerText = money(grand);

            document.getElementById('checkoutBtn').disabled = cartLines.length === 0;

            // bind line actions
            cartEl.querySelectorAll('button[data-act]').forEach(b => {
                b.addEventListener('click', () => {
                    const idx = parseInt(b.getAttribute('data-idx'), 10);
                    const act = b.getAttribute('data-act');
                    const ln = cartLines[idx];
                    if (!ln) return;
                    if (act === 'inc') { ln.qty += 1; }
                    else if (act === 'dec') { ln.qty = Math.max(1, ln.qty - 1); }
                    else if (act === 'rm') { cartLines.splice(idx, 1); }
                    renderCart();
                });
            });
        }

        document.getElementById('discVal').addEventListener('input', renderCart);
        document.querySelectorAll('input[name="discType"]').forEach(r => r.addEventListener('change', renderCart));

        // add to cart
        document.getElementById('cfgAdd').addEventListener('click', () => {
            if (!validateRequired()) return;
            const qty = parseInt(document.getElementById('cfgQty').value || 1, 10);
            const unit = cfgUnitPrice();
            const selections = gatherSelections();

            const key = JSON.stringify({ n: currentCfg.name, s: selections });
            let merged = false;
            for (let i = 0; i < cartLines.length; i++) {
                const k2 = JSON.stringify({ n: cartLines[i].name, s: cartLines[i].selections });
                if (k2 === key) { cartLines[i].qty += qty; merged = true; break; }
            }
            if (!merged) {
                cartLines.push({ id: uid(), name: currentCfg.name, unit, qty, selections });
            }
            renderCart();
            cfgModal.hide();
        });

        /* ========= Hold / Park orders ========= */
        const PARK_KEY = 'pos_parked_orders';
        function getParked(){ try { return JSON.parse(localStorage.getItem(PARK_KEY) || '[]') } catch(e){ return [] } }
        function setParked(a){ localStorage.setItem(PARK_KEY, JSON.stringify(a)); }

        function renderParked() {
            const list = document.getElementById('parkedList');
            const arr = getParked();
            list.innerHTML = '';
            arr.forEach((o, i) => {
                const el = document.createElement('div');
                el.className = 'order-chip';
                el.innerHTML = `
                    <div>
                        <div class="fw-bold">#${o.id} • ${o.type.toUpperCase()} ${o.table? '• T'+o.table:''}</div>
                        <div class="small text-muted">${new Date(o.time).toLocaleString()}</div>
                    </div>
                    <div class="d-flex gap-1">
                        <span class="fw-bold me-2">${money(o.total)}</span>
                        <button class="btn btn-sm btn-sub" data-act="resume" data-idx="${i}">{{ __('Resume') }}</button>
                        <button class="btn btn-sm btn-danger-soft" data-act="del" data-idx="${i}">{{ __('Delete') }}</button>
                    </div>
                `;
                list.appendChild(el);
            });
            list.querySelectorAll('button[data-act]').forEach(b => {
                b.addEventListener('click', () => {
                    const idx = parseInt(b.getAttribute('data-idx'), 10);
                    const arr = getParked();
                    const ord = arr[idx];
                    if (!ord) return;
                    if (b.getAttribute('data-act') === 'resume') {
                        cartLines.splice(0, cartLines.length, ...ord.lines);
                        setOrderType(ord.type || 'dinein');
                        currentTable = ord.table || null;
                        updateTableBadges();
                        arr.splice(idx, 1);
                        setParked(arr);
                        renderParked();
                        renderCart();
                    } else {
                        arr.splice(idx, 1);
                        setParked(arr);
                        renderParked();
                    }
                });
            });
        }
        renderParked();

        document.getElementById('holdOrder').addEventListener('click', () => {
            if (!cartLines.length) return;
            const sub = cartLines.reduce((a, c) => a + c.unit * c.qty, 0);
            const discountVal = parseFloat($('#discVal').val() || 0);
            const discPct = $('#discPct').is(':checked');
            const discAmt = discPct ? sub * (discountVal / 100) : discountVal;

            const total = sub - discAmt; // Service & Tax removed

            const ord = {
                id: (getParked().length + 1),
                time: Date.now(),
                type: orderType,
                table: currentTable,
                lines: JSON.parse(JSON.stringify(cartLines)),
                total
            };
            const arr = getParked();
            arr.unshift(ord);
            setParked(arr);
            renderParked();

            cartLines.splice(0, cartLines.length);
            renderCart();
        });

        document.getElementById('clearCart').addEventListener('click', () => {
            cartLines.splice(0, cartLines.length);
            renderCart();
        });

        /* ========= Payment ========= */
        $('#checkoutBtn').on('click', () => {
            const totalTxt = document.getElementById('t_grand').innerText;
            $('#payTotal').text(totalTxt);
            $('#payGiven').val('0');
            $('#payChange').text(money(0));
            payModal.show();
        });

        document.querySelectorAll('.pay-methods .btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.pay-methods .btn').forEach(x => x.classList.remove('active'));
                btn.classList.add('active');
            });
        });

        $('#payGiven').on('input', () => {
            const grand = parseFloat(document.getElementById('t_grand').innerText.replace(CURR, ''));
            const given = parseFloat($('#payGiven').val() || 0);
            const change = Math.max(0, given - grand);
            $('#payChange').text(money(change));
        });

        function finalize(printIt) {
            const summary = {
                id: 'ORD-' + Date.now(),
                time: new Date().toISOString(),
                type: orderType,
                table: currentTable,
                lines: JSON.parse(JSON.stringify(cartLines)),
                totals: {
                    sub: document.getElementById('t_sub').innerText,
                    grand: document.getElementById('t_grand').innerText,
                },
                pay: {
                    method: document.querySelector('.pay-methods .btn.active')?.getAttribute('data-pay') || 'cash',
                    given: $('#payGiven').val(),
                    change: $('#payChange').text()
                }
            };
            try {
                const key = 'pos_completed_orders';
                const arr = JSON.parse(localStorage.getItem(key) || '[]');
                arr.unshift(summary);
                localStorage.setItem(key, JSON.stringify(arr));
            } catch (e) {}

            payModal.hide();

            if (printIt) {
                const w = window.open('', 'PRINT', 'height=600,width=380');
                w.document.write(`<html><head><title>Receipt</title><style>
                    body{font-family:monospace; padding:8px}
                    h2,h3{margin:4px 0}
                    .line{display:flex;justify-content:space-between}
                    .small{font-size:12px;color:#555}
                    hr{border:none;border-top:1px dashed #999;margin:6px 0}
                </style></head><body>`);
                w.document.write(`<h2>{{ $restaurantName }}</h2><div class="small">{{ $restaurantAddress }}</div><hr>`);
                w.document.write(
                    `<div>Order: ${summary.id}</div><div class="small">${new Date(summary.time).toLocaleString()}</div><div class="small">Type: ${summary.type.toUpperCase()}${summary.table? ' • Table '+summary.table:''}</div><hr>`
                );
                summary.lines.forEach(l => {
                    w.document.write(`<div><strong>${l.name}</strong> x${l.qty}</div>`);
                    (l.selections || []).forEach(v => {
                        const opts = v.options.map(o => o.name + (o.adj ? ` (+${o.adj.toFixed(2)}{{ $currency }})` : ``)).join(', ');
                        w.document.write(`<div class="small"> - ${v.name}: ${opts}</div>`);
                    });
                    w.document.write(`<div class="line"><span class="small">{{ __('Unit') }}:</span><span>${l.unit.toFixed(2)}{{ $currency }}</span></div>`);
                    w.document.write(`<div class="line"><span class="small">{{ __('Line') }}:</span><span>${(l.unit*l.qty).toFixed(2)}{{ $currency }}</span></div><hr>`);
                });
                w.document.write(`<div class="line"><strong>{{ __('Subtotal') }}</strong><strong>${summary.totals.sub}</strong></div>`);
                w.document.write(`<div class="line"><strong>{{ __('Grand Total') }}</strong><strong>${summary.totals.grand}</strong></div><hr>`);
                w.document.write(`<div class="small">{{ __('Paid by') }}: ${summary.pay.method.toUpperCase()} • {{ __('Given') }}: ${summary.pay.given} • {{ __('Change') }}: ${summary.pay.change}</div>`);
                w.document.write(`<p class="small" style="text-align:center;margin-top:10px">*** {{ __('Thank you!') }} ***</p>`);
                w.document.write(`</body></html>`);
                w.document.close();
                w.focus();
                w.print();
                w.close();
            }

            cartLines.splice(0, cartLines.length);
            renderCart();
        }

        $('#finalizePayment').on('click', () => finalize(true));
        $('#finalizeNoPrint').on('click', () => finalize(false));

        /* ========= Import via QR (input/import removed) ========= */
        function tryParsePayload(raw) {
            if (!raw) return null;
            try {
                if (/^https?:\/\//i.test(raw)) {
                    const u = new URL(raw);
                    const p = u.searchParams.get('data');
                    if (p) raw = p;
                }
            } catch (e) {}
            try { return JSON.parse(raw); } catch (e) {}
            try { const txt = atob(raw); return JSON.parse(txt); } catch (e) {}
            return null;
        }

        function importClientOrder(payload) {
            if (!payload || !Array.isArray(payload.items)) {
                alert('{{ __('Invalid client code') }}');
                return false;
            }
            payload.items.forEach(it => {
                const name = it.name;
                const qty = parseInt(it.qty || 1, 10);
                const unit = parseFloat(it.unit || (menuIndex[name]?.base || 0));
                const selections = (it.sel || []).map(v => ({
                    name: v.name,
                    options: (v.options || []).map(o => ({
                        name: o.n || o.name || '',
                        adj: parseFloat(o.a ?? o.adj ?? 0) || 0
                    }))
                }));
                const key = JSON.stringify({ n: name, s: selections });
                let merged = false;
                for (let i = 0; i < cartLines.length; i++) {
                    const k2 = JSON.stringify({ n: cartLines[i].name, s: cartLines[i].selections });
                    if (k2 === key) { cartLines[i].qty += qty; merged = true; break; }
                }
                if (!merged) { cartLines.push({ id: uid(), name, unit, qty, selections }); }
            });
            renderCart();
            return true;
        }

        // Scanner
        let qrScanner = null;
        const scanModalEl = document.getElementById('scanModal');
        scanModalEl.addEventListener('shown.bs.modal', () => {
            if (window.Html5QrcodeScanner) {
                qrScanner = new Html5QrcodeScanner("qrReader", { fps: 10, qrbox: 250 });
                qrScanner.render((decodedText) => {
                    const payload = tryParsePayload(decodedText);
                    if (importClientOrder(payload)) {
                        const m = bootstrap.Modal.getInstance(scanModalEl);
                        m?.hide();
                        qrScanner.clear();
                        qrScanner = null;
                    }
                }, () => {});
            } else {
                document.getElementById('qrReader').innerHTML =
                    '<div class="text-danger">{{ __('Scanner failed to load.') }}</div>';
            }
        });
        scanModalEl.addEventListener('hidden.bs.modal', () => {
            if (qrScanner && qrScanner.clear) { qrScanner.clear(); qrScanner = null; }
            document.getElementById('qrReader').innerHTML = '';
        });

        /* ========= Tables Offcanvas ========= */
        const tablesCanvasEl = document.getElementById('tablesCanvas');
        tablesCanvasEl.addEventListener('shown.bs.offcanvas', () => {
            const notice = document.getElementById('tablesNotice');
            const disable = orderType !== 'dinein';
            notice.classList.toggle('d-none', !disable);
            document.querySelectorAll('.table-card').forEach(card => {
                card.tabIndex = disable ? -1 : 0;
                card.style.opacity = disable ? .5 : 1;
                card.style.pointerEvents = disable ? 'none' : 'auto';
            });
            updateTableBadges();
        });

        document.getElementById('clearTable').addEventListener('click', () => {
            currentTable = null;
            updateTableBadges();
        });

        document.querySelectorAll('.table-card').forEach(card => {
            card.addEventListener('click', () => {
                const t = card.getAttribute('data-table');
                currentTable = t;
                updateTableBadges();
            });
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); card.click(); }
            });
        });

        /* ========= Payment change calc (dup guard) ========= */
        $('#payGiven').on('input', () => {
            const grand = parseFloat(document.getElementById('t_grand').innerText.replace(CURR, ''));
            const given = parseFloat($('#payGiven').val() || 0);
            const change = Math.max(0, given - grand);
            $('#payChange').text(money(change));
        });

        /* ========= Init ========= */
        function updateBadgesOnLoad() { updateTableBadges(); }
        updateBadgesOnLoad();
        renderCart();
        filterRender();
    </script>
</body>

</html>
