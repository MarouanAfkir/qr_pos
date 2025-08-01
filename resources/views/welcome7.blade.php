{{-- resources/views/welcome.blade.php --}}
@php
    use Illuminate\Support\Str;

    /* ---------- Locale ---------- */
    $default_language = request('lang', app()->getLocale() ?: 'en');
    app()->setLocale($default_language);

    /* ---------- Restaurant helpers ---------- */
    $restaurantName    = $restaurant['name'] ?? 'Restaurant';
    $logo              = $restaurant['logo'] ?? null;
    $restaurantAddress = $restaurant['address'] ?? '';
    $phone1            = $restaurant['phone_number_1'] ?? '';
    $phone2            = $restaurant['phone_number_2'] ?? '';
    $tagline           = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';

    /* ---------- Menu title logic ---------- */
    $rawMenuName = trim($menu['name'] ?? '');
    $menuTitle   = ($rawMenuName && $rawMenuName !== $restaurantName)
                     ? $rawMenuName
                     : __('Our Menu');

    /* ---------- Currency ---------- */
    $currency = ' DH';
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="gramentheme">
    <meta name="description" content="{{ $menu['description'] ?? 'Digital restaurant menu' }}">

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
        html{scroll-behavior:smooth}

        /* ----- HEADER ----- */
        .restaurant-header{padding:3rem 0 1.75rem;text-align:center}
        .restaurant-logo-wrapper{
            width:128px;height:128px;margin:0 auto 1.25rem;
            border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;
            box-shadow:0 6px 18px rgba(0,0,0,.1);transition:.2s transform,.2s box-shadow;
        }
        .restaurant-logo-wrapper:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.12)}
        .restaurant-logo-wrapper img{width:80%;height:80%;object-fit:contain;border-radius:50%}
        .restaurant-name{font-size:2.35rem;font-weight:700;letter-spacing:.5px}
        .header-meta span{color:#666;font-size:.9rem}
        .header-divider{width:72px;height:2px;background:#facc15;margin:2.5rem auto 0;border-radius:1px;opacity:.8}

        /* ----- LANGUAGE SWITCHER ----- */
        .lang-switcher .btn{background:#1f2937;border-color:#1f2937;color:#fff;font-weight:600;transition:.15s}
        .lang-switcher .btn:hover{background:#374151}
        .lang-switcher .dropdown-menu{min-width:10rem;font-size:.875rem}

        /* ----- MENU LIST ----- */
        .food-menu-section.section-padding{padding-top:2.5rem !important}
        .single-menu-items{cursor:pointer;display:flex;gap:.75rem;padding:.75rem 1rem;margin-bottom:.85rem;
                           background:#fff;border-radius:.85rem;box-shadow:0 1px 4px rgba(0,0,0,.04);
                           transition:.2s box-shadow}
        .single-menu-items:hover{box-shadow:0 5px 16px rgba(0,0,0,.08)}
        .menu-item-thumb{width:80px;aspect-ratio:1/1;border-radius:10px;overflow:hidden;flex-shrink:0;background:#f3f4f6}
        .menu-item-thumb img{width:100%;height:100%;object-fit:cover}

        /* Reduce horizontal gaps between columns */
        .row.gx-40{--bs-gutter-x:1.5rem}
        @media(min-width:992px){
            .row.gx-40{--bs-gutter-x:2.5rem}
        }

        /* ----- SEARCH ----- */
        #menuSearch{border-radius:50px;padding:.65rem 1.25rem;font-size:1rem}
        #searchResults .single-menu-items{margin-bottom:.85rem}

        /* ----- FOOTER ----- */
        .simple-footer{background:#000;color:#aaa;font-size:.875rem;padding:1.5rem 0}
        .simple-footer a{color:#fff;text-decoration:none;font-weight:600}

        /* ----- MODAL ----- */
        #itemModal .modal-content{
            border:0;border-radius:1rem;box-shadow:0 6px 30px rgba(0,0,0,.25);
            animation:pop .35s cubic-bezier(.34,1.56,.64,1);
        }
        #itemModal .modal-header{
            background:linear-gradient(135deg,#fef9c3 0%,#fde68a 100%);
            border-bottom:none;border-top-left-radius:1rem;border-top-right-radius:1rem;
            padding:1rem 1.5rem;
        }
        #itemModal .modal-title{font-weight:600;font-size:1.45rem}
        #itemModal .btn-close{filter:none;opacity:.6;transition:.15s}
        #itemModal .btn-close:hover{opacity:1}
        #itemModal .modal-body{padding:1.75rem}
        #itemModal img{width:170px;height:170px;object-fit:cover;border-radius:.75rem;flex-shrink:0}
        @keyframes pop{0%{transform:scale(.85);opacity:0}100%{transform:scale(1);opacity:1}}
        @media(max-width:575.98px){#itemModal img{width:130px;height:130px}}
    </style>
</head>

<body class="bg-color2">

<!-- ===== Header ===== -->
<header class="restaurant-header food-menu-section fix position-relative">
    <div class="burger-shape"><img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt=""></div>
    <div class="fry-shape"><img src="{{ asset('assets/img/shape/fry-shape.png') }}" alt=""></div>

    <!-- Language switcher -->
    <div class="position-absolute top-0 end-0 pe-4 pt-4 lang-switcher">
        <div class="dropdown">
            <button class="btn btn-sm rounded-pill d-flex align-items-center gap-1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-globe"></i>{{ strtoupper($default_language) }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm fade">
                @foreach($languages ?? [] as $lang)
                    <li>
                        <a class="dropdown-item {{ $lang['code']==$default_language ? 'active fw-bold' : '' }}"
                           href="{{ request()->fullUrlWithQuery(['lang'=>$lang['code']]) }}">
                            {{ strtoupper($lang['code']) }} — {{ $lang['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="food-menu-wrapper style1">
        <div class="container">
            <div class="restaurant-logo-wrapper wow fadeInDown" data-wow-delay=".2s">
                <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/logo.svg') }}" alt="Logo">
            </div>
            <h1 class="restaurant-name wow fadeInUp" data-wow-delay=".3s">{{ $restaurantName }}</h1>
            <p class="restaurant-tagline fs-5 fst-italic text-theme-color2 wow fadeInUp" data-wow-delay=".4s">{{ $tagline }}</p>

            <div class="header-meta d-flex flex-wrap justify-content-center gap-3 mt-3 wow fadeInUp" data-wow-delay=".5s">
                @if($restaurantAddress)<span><i class="fa-solid fa-location-dot me-1"></i>{{ $restaurantAddress }}</span>@endif
                @if($phone1)<span><i class="fa-solid fa-phone-volume me-1"></i>{{ $phone1 }}</span>@endif
                @if($phone2)<span><i class="fa-solid fa-phone-volume me-1"></i>{{ $phone2 }}</span>@endif
            </div>
            <div class="header-divider wow fadeIn" data-wow-delay=".6s"></div>
        </div>
    </div>
</header>

<!-- ===== Menu ===== -->
<section class="food-menu-section fix section-padding">
    <div class="burger-shape"><img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt=""></div>
    <div class="fry-shape"><img src="{{ asset('assets/img/shape/fry-shape.png') }}" alt=""></div>

    <div class="food-menu-wrapper style1">
        <div class="container">
            <div class="food-menu-tab-wrapper style-bg">

                <!-- Section title -->
                <div class="title-area">
                    <div class="sub-title text-center wow fadeInUp" data-wow-delay=".5s">
                        <img class="me-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="">
                        {{ $menuTitle }}
                        <img class="ms-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="">
                    </div>
                </div>

                <!-- Search input -->
                <div class="row justify-content-center mb-4">
                    <div class="col-md-6">
                        <input id="menuSearch" type="search" class="form-control shadow-sm" placeholder="{{ __('Search menu…') }}">
                    </div>
                </div>

                <div class="food-menu-tab">

                    <!-- Nav pills -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        @foreach($categories as $cat)
                            @php $slug = Str::slug($cat['name']); @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="pills-{{ $slug }}-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#pills-{{ $slug }}"
                                        type="button" role="tab"
                                        aria-controls="pills-{{ $slug }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $cat['name'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="pills-tabContent">
                        @foreach($categories as $cat)
                            @php
                                $slug    = Str::slug($cat['name']);
                                /* -------- Two columns layout (default) -------- */
                                $columns = array_chunk($cat['items'], ceil(max(count($cat['items']),1)/2));
                            @endphp
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                 id="pills-{{ $slug }}" role="tabpanel" aria-labelledby="pills-{{ $slug }}-tab">
                                <div class="row gx-40">
                                    @foreach($columns as $colItems)
                                        <div class="col-lg-6 col-md-6">
                                            @foreach($colItems as $item)
                                                @php
                                                    $price     = number_format($item['price'],2);
                                                    $salePrice = $item['sale_price'];
                                                    $imageUrl  = $item['image'] ?? asset('assets/img/menu/menuThumb1_1.png');
                                                    $priceHtml = $salePrice
                                                        ? '<del class=&quot;text-muted me-1&quot;>'.$price.$currency.'</del> <span class=&quot;text-theme-color2 fw-semibold&quot;>'.number_format($salePrice,2).$currency.'</span>'
                                                        : $price.$currency;
                                                @endphp
                                                <div class="single-menu-items"
                                                     data-name="{{ e($item['name']) }}"
                                                     data-desc="{{ e($item['description'] ?? '') }}"
                                                     data-img="{{ $imageUrl }}"
                                                     data-price="{!! $priceHtml !!}">
                                                    <div class="menu-item-thumb"><img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" loading="lazy" decoding="async"></div>
                                                    <div class="menu-content flex-grow-1">
                                                        <h3 class="mb-1 fw-semibold">{{ $item['name'] }}</h3>
                                                        @if(!empty($item['description']))<p class="mb-1 small text-muted">{{ $item['description'] }}</p>@endif
                                                    </div>
                                                    <h6 class="mb-0 ms-3 text-nowrap">{!! $priceHtml !!}</h6>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div><!-- /tab-content -->

                    <!-- Search results container -->
                    <div id="searchResults" class="row gx-40 d-none"></div>

                </div><!-- /food-menu-tab -->
            </div>
        </div>
    </div>
</section>

<!-- ===== Footer ===== -->
<footer class="simple-footer text-center">
    <div class="container">
        <p class="mb-2">&copy; {{ now()->year }} <a href="#">{{ $restaurantName }}</a>. {{ __('All rights reserved.') }}</p>
        <p class="mb-0 small">{{ __('Made with') }} <i class="fa-solid fa-heart text-theme-color2"></i> {{ __('in Nador') }}</p>
    </div>
</footer>

<!-- ===== Item Modal ===== -->
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
                        <p id="modalDesc" class="mb-3"></p>
                        <h5 id="modalPrice" class="fw-semibold"></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
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
    /* ---------- Item modal handler ---------- */
    const itemModal = new bootstrap.Modal(document.getElementById('itemModal'));
    $(document).on('click', '.single-menu-items', function () {
        const $i   = $(this);
        $('#itemModal .modal-title').text($i.data('name'));
        $('#modalImg').attr('src', $i.data('img'));
        $('#modalDesc').text($i.data('desc') || '{{ __('No description available.') }}');
        $('#modalPrice').html($i.data('price'));
        itemModal.show();
    });

    /* ---------- Live search across ALL items ---------- */
    $('#menuSearch').on('input', function () {
        const query = $(this).val().trim().toLowerCase();
        const $pillsTab = $('#pills-tab');
        const $tabContent = $('#pills-tabContent');
        const $results = $('#searchResults').empty();

        if (query.length === 0) {
            $results.addClass('d-none');
            $pillsTab.removeClass('d-none');
            $tabContent.removeClass('d-none');
            return;
        }

        /* Hide tabs & panes while searching */
        $pillsTab.addClass('d-none');
        $tabContent.addClass('d-none');
        $results.removeClass('d-none');

        $('.single-menu-items').each(function () {
            const $item = $(this);
            const name  = ($item.data('name') || '').toLowerCase();
            const desc  = ($item.data('desc') || '').toLowerCase();
            if (name.includes(query) || desc.includes(query)) {
                /* Wrap each clone in a column to keep 2-per-row layout */
                $('<div class="col-lg-6 col-md-6"></div>')
                    .append($item.clone())
                    .appendTo($results);
            }
        });

        /* No matches fallback */
        if ($results.children().length === 0) {
            $results.html('<p class="text-center py-4 text-muted">{{ __("No items match your search.") }}</p>');
        }
    });
</script>
</body>
</html>
