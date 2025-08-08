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
        html { scroll-behavior:smooth }

        /* ----- HEADER (unchanged) ----- */
        .restaurant-header { padding:3rem 0 1.75rem; text-align:center }
        .restaurant-logo-wrapper{width:128px;height:128px;margin:0 auto 1.25rem;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 18px rgba(0,0,0,.1);transition:.2s}
        .restaurant-logo-wrapper:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.12)}
        .restaurant-logo-wrapper img{width:80%;height:80%;object-fit:contain;border-radius:50%}
        .restaurant-name{font-size:2.35rem;font-weight:700;letter-spacing:.5px}
        .header-meta span{color:#666;font-size:.9rem}
        .header-divider{width:72px;height:2px;background:#facc15;margin:1.5rem auto 0;border-radius:1px;opacity:.8}

        /* ----- LANGUAGE SWITCHER ----- */
        .lang-switcher .btn{background:#1f2937;border-color:#1f2937;color:#fff;font-weight:600;transition:.15s}
        .lang-switcher .btn:hover{background:#374151}
        .lang-switcher .dropdown-menu{min-width:10rem;font-size:.875rem}

        /* ----- MENU ITEMS ----- */
        .food-menu-section.section-padding{padding-top:0rem!important}
        .single-menu-items{cursor:pointer;display:flex;gap:.75rem;padding:.75rem 1rem;margin-bottom:.85rem;background:#fff;border-radius:.85rem;box-shadow:0 1px 4px rgba(0,0,0,.04);transition:.2s}
        .single-menu-items:hover{box-shadow:0 5px 16px rgba(0,0,0,.08)}
        .menu-item-thumb{width:80px;aspect-ratio:1/1;border-radius:10px;overflow:hidden;flex-shrink:0;background:#f3f4f6}
        .menu-item-thumb img{width:100%;height:100%;object-fit:cover}
        .row.gx-40{--bs-gutter-x:1.5rem}
        @media(min-width:992px){.row.gx-40{--bs-gutter-x:2.5rem}}

        /* ----- SEARCH ----- */
        #menuSearch{border-radius:50px;padding:.65rem 1.25rem;font-size:1rem}
        #searchResults .single-menu-items{margin-bottom:.85rem}

        /* ----- FOOTER ----- */
        .simple-footer{background:#000;color:#aaa;font-size:.875rem;padding:1.5rem 0}
        .simple-footer a{color:#fff;text-decoration:none;font-weight:600}

        /* ----- MODAL ----- */
        #itemModal .modal-content{border:0;border-radius:1rem;box-shadow:0 6px 30px rgba(0,0,0,.25);animation:pop .35s cubic-bezier(.34,1.56,.64,1)}
        #itemModal .modal-header{background:linear-gradient(135deg,#fef9c3 0%,#fde68a 100%);border-bottom:none;border-top-left-radius:1rem;border-top-right-radius:1rem;padding:1rem 1.5rem}
        #itemModal .modal-title{font-weight:600;font-size:1.45rem}
        #itemModal .btn-close{filter:none;opacity:.6;transition:.15s}
        #itemModal .btn-close:hover{opacity:1}
        #itemModal .modal-body{padding:1.75rem}
        #itemModal img{width:170px;height:170px;object-fit:cover;border-radius:.75rem;flex-shrink:0}
        #itemModal .detail-block{font-size:.95rem;color:#374151}
        #itemModal .detail-block:not(:last-child){margin-bottom:.65rem}
        #itemModal .opts-title{font-weight:600;margin-bottom:.25rem}
        @keyframes pop{0%{transform:scale(.85);opacity:0}100%{transform:scale(1);opacity:1}}
        @media(max-width:575.98px){#itemModal img{width:130px;height:130px}}

        /* ----- CATEGORY STRIP & ARROWS ----- */
        .categories-wrapper{position:relative}
        .cat-nav{position:absolute;top:50%;transform:translateY(-50%);width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#fff;border:1px solid #facc15;box-shadow:0 2px 6px rgba(0,0,0,.12);color:#7a5200;font-size:.85rem;z-index:5;transition:opacity .15s;}
        .cat-nav.disabled{display:none}
        .cat-prev{left:.25rem}
        .cat-next{right:.25rem}
        .categories-scroll{display:flex;flex-wrap:nowrap;gap:.5rem;margin-bottom:.55rem;padding:0 1.6rem;overflow-x:auto;overflow-y:hidden;touch-action:pan-x;-webkit-overflow-scrolling:touch;scroll-snap-type:x mandatory;scrollbar-width:none;-ms-overflow-style:none;}
        .categories-scroll::-webkit-scrollbar{display:none}
        .categories-scroll .nav-item{flex:0 0 auto;scroll-snap-align:start}
        .categories-scroll .nav-link{padding:.65rem 1.15rem;font-size:.95rem;font-weight:600;color:#7a5200;background:linear-gradient(145deg,#fffbe8 0%,#fef6c9 100%);border:1px solid rgba(250,204,21,.45);border-radius:14px 14px 0 14px;transition:.2s box-shadow,.2s transform;line-height:1.1;}
        .categories-scroll .nav-link:hover,.categories-scroll .nav-link:focus{transform:translateY(-2px);box-shadow:0 4px 10px rgba(0,0,0,.08)}
        .categories-scroll .nav-link.active{color:#000;background:linear-gradient(135deg,#facc15 0%,#fde047 100%);border-color:transparent;box-shadow:0 4px 12px rgba(0,0,0,.1)}
        @media(min-width:576px){.cat-nav{display:none}.categories-scroll{overflow:visible;scroll-snap-type:none;flex-wrap:wrap;justify-content:center;gap:.75rem;padding:0}.categories-scroll .nav-link{padding:.55rem 1.2rem;font-size:.9rem}}
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
                <button class="btn btn-sm rounded-pill d-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-globe"></i>{{ strtoupper($default_language) }}</button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm fade">
                    @foreach ($languages ?? [] as $lang)
                        <li>
                            <a class="dropdown-item {{ $lang['code'] == $default_language ? 'active fw-bold' : '' }}"
                               href="{{ request()->fullUrlWithQuery(['lang' => $lang['code']]) }}">
                                {{ strtoupper($lang['code']) }} — {{ $lang['name'] }}
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
                <p class="restaurant-tagline fs-5 fst-italic text-theme-color2">{{ $tagline }}</p>
                <div class="header-meta d-flex flex-wrap justify-content-center gap-3 mt-3">
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
                <div class="food-menu-tab-wrapper style-bg pt-5 px-1 px-md-5">

                    <!-- title -->
                    <div class="title-area ">
                        <div class="sub-title text-center">
                            <img class="me-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="">
                            {{ $menuTitle }}
                            <img class="ms-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="">
                        </div>
                    </div>

                    <!-- search -->
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-6">
                            <input id="menuSearch" type="search" class="form-control shadow-sm"
                                   placeholder="{{ __('Search menu…') }}">
                        </div>
                    </div>

                    <div class="food-menu-tab">

                        <!-- category strip with arrows -->
                        <div class="categories-wrapper">
                            <button type="button" class="cat-nav cat-prev"><i
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

                            <button type="button" class="cat-nav cat-next"><i
                                    class="fa-solid fa-chevron-right"></i></button>
                        </div>

                        <!-- tab panes -->
                        <div class="tab-content" id="pills-tabContent">
                            @foreach ($categories as $cat)
                                @php
                                    $slug    = Str::slug($cat['name']);
                                    $columns = array_chunk($cat['items'], ceil(max(count($cat['items']), 1) / 2));
                                @endphp
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                     id="pills-{{ $slug }}" role="tabpanel">
                                    <div class="row gx-40">
                                        @foreach ($columns as $colItems)
                                            <div class="col-lg-6 col-md-6">
                                                @foreach ($colItems as $item)
                                                    @php
                                                        $price      = number_format($item['price'], 2);
                                                        $salePrice  = $item['sale_price'];
                                                        $img        = $item['image'] ?? asset('assets/img/menu/menuThumb1_1.png');
                                                        $priceHtml  = $salePrice
                                                            ? '<del class=&quot;text-muted me-1&quot;>' . $price . $currency . '</del> ' .
                                                              '<span class=&quot;text-theme-color2 fw-semibold&quot;>' . number_format($salePrice, 2) . $currency . '</span>'
                                                            : $price . $currency;

                                                        $ingredients = $item['ingredients'] ?? '';
                                                        $calories    = $item['calories'] ?? '';
                                                        $allergens   = $item['allergens'] ?? '';
                                                    @endphp
                                                    <div class="single-menu-items"
                                                         data-name="{{ e($item['name']) }}"
                                                         data-desc="{{ e($item['description'] ?? '') }}"
                                                         data-img="{{ $img }}"
                                                         data-price="{!! $priceHtml !!}"
                                                         data-ingredients="{{ e($ingredients) }}"
                                                         data-calories="{{ $calories }}"
                                                         data-allergens="{{ e($allergens) }}"
                                                         data-variations='@json($item["variations"] ?? [])'>
                                                        <div class="menu-item-thumb">
                                                            <img src="{{ $img }}" alt="{{ $item['name'] }}" loading="lazy">
                                                        </div>
                                                        <div class="menu-content flex-grow-1">
                                                            <h3 class="mb-1 fw-semibold">{{ $item['name'] }}</h3>
                                                            @if ($item['description'])
                                                                <p class="mb-1 small text-muted">
                                                                    {{ $item['description'] }}</p>
                                                            @endif
                                                        </div>
                                                        <h6 class="mb-0 ms-3 text-nowrap">{!! $priceHtml !!}</h6>
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

    {{-- ===== Item Modal ===== --}}
    <div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-semibold"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column flex-sm-row align-items-sm-start gap-3">
                        <img id="modalImg" src="" alt="">
                        <div class="flex-grow-1">
                            <p id="modalDesc" class="mb-3"></p>
                            <h5 id="modalPrice" class="fw-semibold"></h5>

                            <!-- extra details go here -->
                            <div id="modalExtraDetails" class="mt-3"></div>
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
        /* ===== arrow scroll helpers ===== */
        const catStrip = document.querySelector('.categories-scroll');
        const prevBtn  = document.querySelector('.cat-prev');
        const nextBtn  = document.querySelector('.cat-next');

        function updateArrows() {
            const max = catStrip.scrollWidth - catStrip.clientWidth - 1;
            prevBtn.classList.toggle('disabled', catStrip.scrollLeft <= 0);
            nextBtn.classList.toggle('disabled', catStrip.scrollLeft >= max);
        }
        prevBtn.addEventListener('click', () => catStrip.scrollBy({ left: -200, behavior: 'smooth' }));
        nextBtn.addEventListener('click', () => catStrip.scrollBy({ left:  200, behavior: 'smooth' }));
        catStrip.addEventListener('scroll', updateArrows);
        window.addEventListener('resize', updateArrows);
        updateArrows();

        /* scroll active pill into view */
        document.querySelectorAll('#pills-tab button[data-bs-toggle="pill"]').forEach(btn => {
            btn.addEventListener('shown.bs.tab', e => {
                e.target.scrollIntoView({ behavior:'smooth', inline:'center', block:'nearest' });
            });
        });

        /* ===== Item modal ===== */
        const currency = '{{ trim($currency) }}';
        const itemModal = new bootstrap.Modal(document.getElementById('itemModal'));

        $(document).on('click', '.single-menu-items', function () {
            const $i = $(this);

            $('#itemModal .modal-title').text($i.data('name'));
            $('#modalImg').attr('src', $i.data('img'));
            $('#modalDesc').text($i.data('desc') || '{{ __('No description available.') }}');
            $('#modalPrice').html($i.data('price'));

            // build extra details
            let html = '';
            const ingredients = $i.data('ingredients');
            const calories    = $i.data('calories');
            const allergens   = $i.data('allergens');
            const variations  = $i.attr('data-variations') ? JSON.parse($i.attr('data-variations')) : [];

            if (ingredients) {
                html += `<div class="detail-block"><strong>{{ __('Ingredients') }}:</strong> ${ingredients}</div>`;
            }
            if (calories) {
                html += `<div class="detail-block"><strong>{{ __('Calories') }}:</strong> ${calories} kcal</div>`;
            }
            if (allergens) {
                html += `<div class="detail-block"><strong>{{ __('Allergens') }}:</strong> ${allergens}</div>`;
            }
            if (variations && variations.length) {
                html += `<div class="detail-block">
                            <div class="opts-title">{{ __('Options') }}:</div>`;
                variations.forEach(v => {
                    html += `<div><em>${v.name}</em>`;
                    html += '</div>';
                    if (v.options && v.options.length) {
                        v.options.forEach(opt => {
                            const adj = parseFloat(opt.price_adjustment);
                            const priceTxt = adj !== 0 ? ` (+${adj.toFixed(2)}${currency})` : '';
                            html += `<div class="ps-3">– ${opt.name}${priceTxt}</div>`;
                        });
                    }
                });
                html += `</div>`;
            }
            $('#modalExtraDetails').html(html);

            itemModal.show();
        });

        /* ===== Live search ===== */
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
                      n   = ($it.data('name') || '').toLowerCase(),
                      d   = ($it.data('desc') || '').toLowerCase();
                if (n.includes(q) || d.includes(q)) {
                    $('<div class="col-lg-6 col-md-6"></div>').append($it.clone()).appendTo($res);
                }
            });
            if (!$res.children().length) {
                $res.html('<p class="text-center py-4 text-muted">{{ __('No items match your search.') }}</p>');
            }
        });
    </script>
</body>
</html>
