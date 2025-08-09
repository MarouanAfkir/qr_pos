{{-- resources/views/welcome.blade.php --}}
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
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurantName }} – Digital Menu</title>

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

    <style>
        :root{
            --gold:#facc15;
            --gold-2:#fde047;
            --ink:#111827;
            --muted:#6b7280;
            --chip:#fff8db;
            --chip-border:#f4e487;
            --soft:#fefce8;
        }

        html { scroll-behavior:smooth }

        /* ----- HEADER (compact + refined) ----- */
        .restaurant-header { padding:2.25rem 0 1.25rem; text-align:center; position:relative }
        .restaurant-logo-wrapper{
            width:132px;height:132px;margin:0 auto 1rem;border-radius:50%;
            background:#fff;display:flex;align-items:center;justify-content:center;
            box-shadow:0 6px 18px rgba(0,0,0,.1);transition:.2s;border:3px solid #fff;overflow:hidden
        }
        .restaurant-logo-wrapper:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.12)}
        .restaurant-logo-wrapper img{width:86%;height:86%;object-fit:contain;border-radius:50%}
        .restaurant-name{font-size:2.05rem;font-weight:800;letter-spacing:.3px;color:var(--ink)}
        .header-meta span{color:#5b5f67;font-size:.92rem}
        .header-divider{width:72px;height:2px;background:var(--gold);margin:1.1rem auto 0;border-radius:1px;opacity:.9}

        /* ----- LANGUAGE SWITCHER (elevated dropdown) ----- */
        .lang-switcher .btn{
            background:#1f2937;border-color:#1f2937;color:#fff;font-weight:700;transition:.15s;
            padding:.35rem .7rem;border-radius:999px
        }
        .lang-switcher .btn:hover{background:#374151}
        .lang-switcher .dropdown-menu{
            min-width:12.5rem;font-size:.92rem;border:none;border-radius:.8rem;padding:.4rem;
            background:#fff;box-shadow:0 16px 36px rgba(17,24,39,.18)
        }
        .lang-switcher .dropdown-item{
            border-radius:.55rem;padding:.55rem .8rem;color:#111;display:flex;justify-content:space-between;
            transition:background .15s, transform .08s
        }
        .lang-switcher .dropdown-item:hover{background:rgba(250,204,21,.16);transform:translateX(2px)}
        .lang-switcher .dropdown-item.active,
        .lang-switcher .dropdown-item:active{background:linear-gradient(135deg,var(--gold),var(--gold-2));color:#111;font-weight:800}

        /* ----- MENU AREA ----- */
        .food-menu-section.section-padding{padding-top:0!important}
        .food-menu-tab-wrapper{position:relative}
        .title-area .sub-title{
            font-weight:800;color:#7a5200;letter-spacing:.4px
        }

        /* Sticky tools (search + cats) */
        .sticky-tools{
            position:sticky;top:0;z-index:40;background:linear-gradient(0deg,#fff, #fff9);
            backdrop-filter:saturate(1.2) blur(6px);padding:.75rem .5rem;margin-bottom:.35rem;border-bottom:1px solid #f1f1f1
        }
        #menuSearch{
            border-radius:999px;padding:.65rem 1.25rem;font-size:1rem;border:2px solid #f2e88b;
            transition:.15s; background:#fffef7
        }
        #menuSearch:focus{border-color:var(--gold); box-shadow:0 0 0 6px rgba(250,204,21,.18)}

        /* Categories strip & arrows */
        .categories-wrapper{position:relative}
        .cat-nav{
            position:absolute;top:50%;transform:translateY(-50%);width:34px;height:34px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;background:#fff;border:1px solid var(--gold);
            box-shadow:0 2px 6px rgba(0,0,0,.12);color:#7a5200;font-size:.85rem;z-index:5
        }
        .cat-nav.disabled{display:none}
        .cat-prev{left:.25rem}
        .cat-next{right:.25rem}
        .categories-scroll{
            display:flex;flex-wrap:nowrap;gap:.55rem;margin:.25rem 0 .55rem;padding:0 1.6rem;overflow-x:auto;overflow-y:hidden;
            touch-action:pan-x;-webkit-overflow-scrolling:touch;scroll-snap-type:x mandatory;scrollbar-width:none;-ms-overflow-style:none
        }
        .categories-scroll::-webkit-scrollbar{display:none}
        .categories-scroll .nav-item{flex:0 0 auto;scroll-snap-align:start}
        .categories-scroll .nav-link{
            padding:.6rem 1.05rem;font-size:.94rem;font-weight:700;color:#7a5200;
            background:linear-gradient(145deg,#fffbe8 0%,#fef6c9 100%);border:1px solid rgba(250,204,21,.45);
            border-radius:14px 14px 0 14px;transition:.18s box-shadow,.18s transform;line-height:1.1;
        }
        .categories-scroll .nav-link:hover,.categories-scroll .nav-link:focus{transform:translateY(-2px);box-shadow:0 4px 10px rgba(0,0,0,.08)}
        .categories-scroll .nav-link.active{color:#000;background:linear-gradient(135deg,var(--gold) 0%,var(--gold-2) 100%);border-color:transparent;box-shadow:0 4px 12px rgba(0,0,0,.1)}
        @media(min-width:576px){
            .cat-nav{display:none}
            .categories-scroll{overflow:visible;scroll-snap-type:none;flex-wrap:wrap;justify-content:center;gap:.75rem;padding:0}
            .categories-scroll .nav-link{padding:.55rem 1.2rem;font-size:.9rem}
        }

        /* Items (cardify the list) */
        .single-menu-items{
            cursor:pointer;display:flex;gap:.85rem;padding:.9rem 1rem;margin-bottom:.9rem;background:#fff;
            border-radius:1rem;box-shadow:0 1px 4px rgba(0,0,0,.04);transition:.18s; border:1px solid #f7f4d7
        }
        .single-menu-items:hover{box-shadow:0 6px 16px rgba(0,0,0,.08); transform:translateY(-1px)}
        .menu-item-thumb{width:86px;aspect-ratio:1/1;border-radius:12px;overflow:hidden;flex-shrink:0;background:#f9fafb}
        .menu-item-thumb img{width:100%;height:100%;object-fit:cover;filter:saturate(1.05)}
        .menu-content h3{font-size:1.04rem}
        .menu-content .chips{margin-top:.25rem}
        .chip{
            display:inline-block;background:var(--chip);border:1px solid var(--chip-border);color:#6b4b00;
            font-size:.72rem;padding:.15rem .45rem;border-radius:999px;margin-right:.25rem;margin-bottom:.25rem
        }
        .price-wrap del{color:#9ca3af;margin-right:.35rem}
        .save-badge{background:#dcfce7;color:#065f46;border-radius:6px;font-size:.72rem;padding:.1rem .35rem;margin-left:.35rem}

        /* Search results container */
        #searchResults .single-menu-items{margin-bottom:.85rem}

        /* ----- FOOTER ----- */
        .simple-footer{background:#0b0b0b;color:#bdbdbd;font-size:.875rem;padding:1.25rem 0}
        .simple-footer a{color:#fff;text-decoration:none;font-weight:700}

        /* ----- MODAL (info-first, clean) ----- */
        #itemModal .modal-content{border:0;border-radius:1rem;box-shadow:0 6px 30px rgba(0,0,0,.25);animation:pop .35s cubic-bezier(.34,1.56,.64,1)}
        #itemModal .modal-header{background:linear-gradient(135deg,#fff7c2 0%,#fde68a 100%);border-bottom:none;border-top-left-radius:1rem;border-top-right-radius:1rem;padding:1rem 1.5rem}
        #itemModal .modal-title{font-weight:800;font-size:1.35rem;color:#633c00}
        #itemModal .btn-close{filter:none;opacity:.7;transition:.15s}
        #itemModal .btn-close:hover{opacity:1}
        #itemModal .modal-body{padding:1.35rem 1.35rem 1.6rem}
        #itemModal img{width:150px;height:150px;object-fit:cover;border-radius:.8rem;flex-shrink:0;box-shadow:0 4px 16px rgba(0,0,0,.1)}
        #itemModal .lead-price{font-weight:800;color:#7a5200}
        #modalExtras .detail-item{font-size:.95rem;color:#374151;margin-bottom:.65rem}
        #modalExtras .vname{font-weight:700;color:#1f2937}
        #modalExtras .opt{padding-left:1rem}
        #modalExtras .opt .up{font-weight:700;color:#7a5200}
        @keyframes pop{0%{transform:scale(.85);opacity:0}100%{transform:scale(1);opacity:1}}
        @media(max-width:575.98px){#itemModal img{width:120px;height:120px}}

        /* Back to top button */
        #toTop{position:fixed;right:12px;bottom:12px;width:42px;height:42px;border-radius:50%;background:var(--gold);color:#111;border:none;box-shadow:0 8px 22px rgba(0,0,0,.18);display:none;align-items:center;justify-content:center}
        #toTop:hover{background:#ffd84c}
    </style>
</head>

<body class="bg-color2">

    {{-- ===== Header ===== --}}
    <header class="restaurant-header food-menu-section fix position-relative">
        <div class="burger-shape"><img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt=""></div>
        <div class="fry-shape"><img src="{{ asset('assets/img/shape/fry-shape.png') }}" alt=""></div>

        <!-- language switcher -->
        <div class="position-absolute top-0 end-0 pe-4 pt-4 lang-switcher">
            <div class="dropdown">
                <button class="btn btn-sm rounded-pill d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('Change language') }}">
                    <i class="fa-solid fa-globe"></i><span>{{ strtoupper($default_language) }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    @foreach ($languages ?? [] as $lang)
                        <li>
                            <a class="dropdown-item {{ $lang['code'] == $default_language ? 'active' : '' }}"
                               href="{{ request()->fullUrlWithQuery(['lang' => $lang['code']]) }}">
                                <span>{{ strtoupper($lang['code']) }}</span>
                                <small class="text-muted">{{ $lang['name'] }}</small>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="food-menu-wrapper style1">
            <div class="container text-center">
                <div class="restaurant-logo-wrapper">
                    <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/logo.svg') }}" alt="Logo">
                </div>
                <h1 class="restaurant-name">{{ $restaurantName }}</h1>
                <p class="restaurant-tagline fs-6 fst-italic text-theme-color2 mb-2">{{ $tagline }}</p>
                <div class="header-meta d-flex flex-wrap justify-content-center gap-3 mt-1">
                    @isset($restaurantAddress)
                        <span><i class="fa-solid fa-location-dot me-1"></i>{{ $restaurantAddress }}</span>
                    @endisset
                    @isset($phone1)
                        <span><i class="fa-solid fa-phone-volume me-1"></i>{{ $phone1 }}</span>
                    @endisset
                    @isset($phone2)
                        <span><i class="fa-solid fa-phone-volume me-1"></i>{{ $phone2 }}</span>
                    @endisset
                </div>
                <div class="header-divider"></div>
            </div>
        </div>
    </header>

    {{-- ===== Menu ===== --}}
    <section class="food-menu-section fix section-padding">
        <div class="burger-shape"><img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt=""></div>
        <div class="fry-shape"><img src="{{ asset('assets/img/shape/fry-shape.png') }}" alt=""></div>

        <div class="food-menu-wrapper style1">
            <div class="container ">

                {{-- sticky tools --}}
                <div class="sticky-tools">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-6 mx-auto">
                            <input id="menuSearch" type="search" class="form-control"
                                   placeholder="{{ __('Search menu…') }}" aria-label="{{ __('Search menu…') }}">
                        </div>
                        <div class="col-12">
                            <!-- category strip with arrows -->
                            <div class="categories-wrapper">
                                <button type="button" class="cat-nav cat-prev" aria-label="{{ __('Scroll left categories') }}"><i
                                        class="fa-solid fa-chevron-left"></i></button>

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

                                <button type="button" class="cat-nav cat-next" aria-label="{{ __('Scroll right categories') }}"><i
                                        class="fa-solid fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="food-menu-tab-wrapper style-bg pt-4 px-1 px-md-5">

                    <!-- title -->
                    <div class="title-area mb-2">
                        <div class="sub-title text-center">
                            <img class="me-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="">
                            {{ $menuTitle }}
                            <img class="ms-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="">
                        </div>
                    </div>

                    <div class="food-menu-tab">

                        <!-- tab panes -->
                        <div class="tab-content" id="pills-tabContent">
                            @foreach ($categories as $cat)
                                @php
                                    $slug    = Str::slug($cat['name']);
                                    $columns = array_chunk($cat['items'], ceil(max(count($cat['items']), 1) / 2));
                                @endphp
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                     id="pills-{{ $slug }}" role="tabpanel" aria-labelledby="pills-{{ $slug }}-tab">
                                    <div class="row gx-40">
                                        @foreach ($columns as $colItems)
                                            <div class="col-lg-6 col-md-6">
                                                @foreach ($colItems as $item)
                                                    @php
                                                        $price      = number_format($item['price'], 2);
                                                        $salePrice  = $item['sale_price'];
                                                        $img        = $item['image'] ?? asset('assets/img/menu/menuThumb1_1.png');
                                                        $priceHtml  = $salePrice
                                                            ? '<del>' . $price . $currency . '</del> ' .
                                                              '<span class=&quot;text-theme-color2 fw-semibold&quot;>' . number_format($salePrice, 2) . $currency . '</span>'
                                                            : $price . $currency;

                                                        $ingredients = $item['ingredients'] ?? '';
                                                        $chips = array_filter(array_map('trim', explode(',', (string)$ingredients)));
                                                        $savings = $salePrice ? max(0, $item['price'] - $salePrice) : 0;
                                                    @endphp
                                                    <div class="single-menu-items"
                                                         role="button" tabindex="0"
                                                         data-name="{{ e($item['name']) }}"
                                                         data-desc="{{ e($item['description'] ?? '') }}"
                                                         data-img="{{ $img }}"
                                                         data-price="{!! $priceHtml !!}"
                                                         data-ingredients="{{ e($ingredients) }}"
                                                         data-variations='@json($item["variations"] ?? [])'>
                                                        <div class="menu-item-thumb">
                                                            <img src="{{ $img }}" alt="{{ $item['name'] }}" loading="lazy">
                                                        </div>
                                                        <div class="menu-content flex-grow-1">
                                                            <div class="d-flex align-items-start justify-content-between">
                                                                <h3 class="mb-1 fw-semibold">{{ $item['name'] }}</h3>
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

                        <div id="searchResults" class="row gx-40 d-none"></div>
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
            <p class="mb-0 small">{{ __('Made with') }} <i class="fa-solid fa-heart text-theme-color2"></i>
                {{ __('in Nador') }}</p>
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
                        <div class="flex-grow-1 text-center text-sm-start">
                            <p id="modalDesc" class="mb-2"></p>
                            <h5 id="modalPrice" class="lead-price fw-bold mb-3"></h5>
                            <div id="modalExtras" class="text-start"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS assets -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/tilt.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        /* ===== arrows on cats ===== */
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

        /* scroll active pill into view */
        document.querySelectorAll('#pills-tab button[data-bs-toggle="pill"]').forEach(btn => {
            btn.addEventListener('shown.bs.tab', e => {
                e.target.scrollIntoView({ behavior:'smooth', inline:'center', block:'nearest' });
            });
        });

        /* back to top */
        const toTop = document.getElementById('toTop');
        window.addEventListener('scroll', () => {
            toTop.style.display = window.scrollY > 500 ? 'flex' : 'none';
        });
        toTop.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));

        /* ===== Item modal (Composition & variations rules) =====
           - If a variation has ONLY ONE option: show "Name: Option (+X DH if any)"
           - If a variation has MULTIPLE options: list each option on its own line under the variation name
        */
        const currency = '{{ trim($currency) }}';
        const itemModal = new bootstrap.Modal(document.getElementById('itemModal'));

        function buildExtras($el){
            let html = '';
            const comp = $el.data('ingredients');
            if (comp) {
                html += `<div class="detail-item">
                            <strong>{{ __("Composition") }}:</strong> ${comp}
                         </div>`;
            }
            const variations = JSON.parse($el.attr('data-variations') || '[]');
            if (variations && variations.length) {
                html += `<div class="detail-item"><strong>{{ __('Options') }}:</strong></div>`;
                variations.forEach(v => {
                    const opts = Array.isArray(v.options) ? v.options : [];
                    if (!opts.length) return;

                    if (opts.length === 1) {
                        const o = opts[0];
                        const adj = parseFloat(o.price_adjustment || 0);
                        const priceTxt = adj ? ` <span class="up">(+${adj.toFixed(2)}${currency})</span>` : '';
                        html += `<div class="ps-2 mb-2">
                                    <span class="vname">${v.name}:</span> <strong>${o.name}</strong>${priceTxt}
                                 </div>`;
                    } else {
                        html += `<div class="ps-1"><span class="vname">${v.name}</span></div>`;
                        opts.forEach(opt => {
                            const adj = parseFloat(opt.price_adjustment || 0);
                            const priceTxt = adj ? ` <span class="up">(+${adj.toFixed(2)}${currency})</span>` : '';
                            html += `<div class="opt">– ${opt.name}${priceTxt}</div>`;
                        });
                        html += `<div class="mb-1"></div>`;
                    }
                });
            }
            return html;
        }

        $(document).on('click keydown', '.single-menu-items', function (e) {
            if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;

            const $el = $(this);
            $('#itemModal .modal-title').text($el.data('name'));
            $('#modalImg').attr('src', $el.data('img'));
            $('#modalDesc').text($el.data('desc') || '{{ __("No description available.") }}');
            $('#modalPrice').html($el.data('price'));
            $('#modalExtras').html(buildExtras($el));
            itemModal.show();
        });

        /* ===== Live search (with highlight) ===== */
        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }
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
                const $it = $(this),
                      n   = ($it.data('name') || ''),
                      d   = ($it.data('desc') || '');
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
                // auto focus first result for accessibility
                $res.find('.single-menu-items').first().attr('tabindex','0').focus();
            }
        });
    </script>
</body>
</html>
