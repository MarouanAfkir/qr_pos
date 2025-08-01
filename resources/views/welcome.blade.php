{{-- resources/views/welcome.blade.php --}}
@php
    use Illuminate\Support\Str;

    /* -------------------- Restaurant helpers -------------------- */
    $restaurantName    = $restaurant['name']            ?? 'Restaurant';
    $restaurantAddress = $restaurant['address']         ?? '';
    $phone1            = $restaurant['phone_number_1']  ?? '';
    $phone2            = $restaurant['phone_number_2']  ?? '';
    $tagline           = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';

    /* -------------------- Currency helpers ---------------------- */
    $currency = ' DH';          // Moroccan Dirham suffix
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language ?? 'en' }}">
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="gramentheme">
    <meta name="description" content="{{ $menu['description'] ?? 'Digital restaurant menu' }}">

    <!-- ======== Page title ============ -->
    <title>{{ $restaurantName }} – Digital Menu</title>

    <!-- ========== Assets CSS ========== -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <!-- ========== Custom Tweaks ========== -->
    <style>
        /* ---------- HEADER ---------- */
        .restaurant-header {
            padding: 4rem 0 3rem;
            background: transparent;
            color: inherit;
            text-align: center;
        }
        .restaurant-logo   {width: 220px; height: auto;}
        .restaurant-name   {font-size: 2.5rem; letter-spacing: .5px;}
        .header-meta span  {color:#666; font-size:.9rem;}

        /* ---------- LANGUAGE SWITCHER ---------- */
        .lang-switcher .btn {
            background:#1f2937;          /* dark slate */
            border-color:#1f2937;
            color:#fff;
            font-weight:600;
            transition:all .15s;
        }
        .lang-switcher .btn:hover {background:#374151;}
        .lang-switcher .dropdown-menu {min-width:10rem; font-size:.875rem;}

        /* ---------- FOOTER ---------- */
        .simple-footer {
            background:#000;
            color:#aaa;
            font-size:.875rem;
            padding:1.5rem 0;
        }
        .simple-footer a {color:#fff; text-decoration:none; font-weight:600;}

        /* Smooth scroll */
        html {scroll-behavior:smooth;}
    </style>
</head>

<body class="bg-color2">

    <!-- ======= Restaurant Header START ======= -->
    <header class="restaurant-header food-menu-section fix section-padding position-relative">
        <!-- Decorative shapes -->
        <div class="burger-shape"><img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt="shape"></div>
        <div class="fry-shape"><img src="{{ asset('assets/img/shape/fry-shape.png') }}" alt="shape"></div>

        <!-- Language switcher -->
        <div class="position-absolute top-0 end-0 pe-4 pt-4 lang-switcher">
            <div class="dropdown">
                <button class="btn btn-sm rounded-pill d-flex align-items-center gap-1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-globe"></i>
                    {{ strtoupper($default_language ?? 'EN') }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm fade">
                    @foreach($languages as $lang)
                        <li>
                            <a class="dropdown-item {{ $lang['code']==($default_language??'en') ? 'active fw-bold' : '' }}"
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
                <img src="{{ asset('assets/img/logo/logo.svg') }}"
                     class="restaurant-logo mb-3 wow fadeInDown" data-wow-delay=".2s" alt="Logo">

                <h1 class="restaurant-name wow fadeInUp" data-wow-delay=".3s">
                    {{ $restaurantName }}
                </h1>

                <p class="restaurant-tagline fs-5 fst-italic text-theme-color2 wow fadeInUp"
                   data-wow-delay=".4s">{{ $tagline }}</p>

                <div class="header-meta d-flex flex-wrap justify-content-center gap-3 mt-3 wow fadeInUp"
                     data-wow-delay=".5s">
                    @if($restaurantAddress)
                        <span><i class="fa-solid fa-location-dot me-1"></i>{{ $restaurantAddress }}</span>
                    @endif
                    @if($phone1)
                        <span><i class="fa-solid fa-phone-volume me-1"></i>{{ $phone1 }}</span>
                    @endif
                    @if($phone2)
                        <span><i class="fa-solid fa-phone-volume me-1"></i>{{ $phone2 }}</span>
                    @endif
                </div>
            </div>
        </div>
    </header>
    <!-- ======= Restaurant Header END ======= -->

    <!-- ======= Food Menu section START ======= -->
    <section class="food-menu-section fix section-padding">
        <div class="burger-shape"><img src="{{ asset('assets/img/shape/burger-shape.png') }}" alt="shape"></div>
        <div class="fry-shape"><img src="{{ asset('assets/img/shape/fry-shape.png') }}" alt="shape"></div>

        <div class="food-menu-wrapper style1">
            <div class="container">
                <div class="food-menu-tab-wrapper style-bg">
                    <!-- Title -->
                    <div class="title-area">
                        <div class="sub-title text-center wow fadeInUp" data-wow-delay=".5s">
                            <img class="me-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="icon">
                            {{ strtoupper(__('Food Menu')) }}
                            <img class="ms-1" src="{{ asset('assets/img/icon/titleIcon.svg') }}" alt="icon">
                        </div>
                        <h2 class="title wow fadeInUp" data-wow-delay=".7s">
                            {{ $menu['name'] ?? 'Menu' }}
                        </h2>
                    </div>

                    <!-- Tabs -->
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
                                            type="button"
                                            role="tab"
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
                                    $columns = array_chunk($cat['items'], ceil(max(count($cat['items']),1)/2));
                                @endphp
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                     id="pills-{{ $slug }}" role="tabpanel"
                                     aria-labelledby="pills-{{ $slug }}-tab" tabindex="0">
                                    <div class="row gx-60">
                                        @foreach($columns as $colItems)
                                            <div class="col-lg-6">
                                                @foreach($colItems as $item)
                                                    @php
                                                        $price     = number_format($item['price'],2);
                                                        $salePrice = $item['sale_price'];
                                                        $imageUrl  = $item['image'] ?? asset('assets/img/menu/menuThumb1_1.png');
                                                    @endphp
                                                    <div class="single-menu-items">
                                                        <div class="details">
                                                            <div class="menu-item-thumb">
                                                                <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" width="81" height="81">
                                                            </div>
                                                            <div class="menu-content">
                                                                <h3>{{ $item['name'] }}</h3>
                                                                @if(!empty($item['description']))
                                                                    <p>{{ $item['description'] }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <h6 class="mb-0">
                                                            @if($salePrice)
                                                                <del class="text-muted me-1">{{ $price . $currency }}</del>
                                                                {{ number_format($salePrice,2) . $currency }}
                                                            @else
                                                                {{ $price . $currency }}
                                                            @endif
                                                        </h6>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div><!-- /tab-content -->
                    </div><!-- /food-menu-tab -->
                </div>
            </div>
        </div>
    </section>
    <!-- ======= Food Menu section END ======= -->

    <!-- ======= Simple Footer ======= -->
    <footer class="simple-footer text-center">
        <div class="container">
            <p class="mb-2">&copy; {{ now()->year }} <a href="#">{{ $restaurantName }}</a>. All rights reserved.</p>
            <p class="mb-0 small">Made with <i class="fa-solid fa-heart text-theme-color2"></i> in Nador</p>
        </div>
    </footer>

    <!-- ========== Assets JS ========== -->
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
</body>
</html>
