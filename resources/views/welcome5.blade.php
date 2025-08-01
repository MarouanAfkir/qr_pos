{{-- resources/views/welcome.blade.php --}}
@php
    use Illuminate\Support\Str;

    /* -------------------- Helpers -------------------- */
    $restaurantName    = $restaurant['name']            ?? 'Restaurant';
    $restaurantAddress = $restaurant['address']         ?? '';
    $phone1            = $restaurant['phone_number_1']  ?? '';
    $phone2            = $restaurant['phone_number_2']  ?? '';
    $tagline           = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';
    $currencySuffix    = ' DH';

    // tiny formatter (so we don’t repeat)
    $fmt = fn($n) => number_format($n, 2) . $currencySuffix;
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="QResto">
    <meta name="description" content="{{ $menu['description'] ?? 'Digital restaurant menu' }}">
    <title>{{ $restaurantName }} – Digital Menu</title>

    <!-- theme & vendor -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <!-- custom palette & tweaks -->
    <style>
        :root{
            --brand:#d92332;             /* primary accent (can match restaurant colour) */
            --gray-100:#f8f9fa;
            --gray-800:#1f2937;
        }
        body{font-family:Inter,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;background:var(--gray-100);}
        a{color:var(--brand);}
        a:hover{color:darken(var(--brand),6%);}
        /* ---------- HERO ---------- */
        .hero{
            background:url('{{ asset('assets/img/shape/hero-bg.jpg') }}') center/cover no-repeat;
            padding:6rem 0 4rem;
            position:relative;
            text-align:center;
            color:#fff;
        }
        .hero::after{content:'';position:absolute;inset:0;background:rgba(0,0,0,.55);}
        .hero>*{position:relative;}
        .hero .restaurant-logo{width:105px;height:auto;filter:drop-shadow(0 3px 3px rgba(0,0,0,.25));}

        /* ---------- LANGUAGE SWITCHER ---------- */
        .lang-switcher .btn{
            backdrop-filter:blur(8px);
            background:rgba(255,255,255,.15);
            border-color:transparent;
            color:#fff;
            font-weight:600;
        }
        .lang-switcher .btn:focus{box-shadow:0 0 0 .25rem rgba(255,255,255,.25);}
        .lang-switcher .dropdown-menu{min-width:9rem;font-size:.875rem;}

        /* ---------- LAYOUT ---------- */
        .menu-layout{display:grid;grid-template-columns:260px 1fr;gap:2rem;}
        @media(max-width:991px){.menu-layout{grid-template-columns:1fr;}}
        /* sidebar */
        .category-sidebar{
            position:sticky;top:100px;
            background:#fff;border-radius:.75rem;padding:1.5rem 1rem;
            box-shadow:0 1px 4px rgba(0,0,0,.05);
        }
        .category-sidebar a{
            display:block;padding:.45rem 1rem;border-radius:.5rem;font-weight:500;
            color:var(--gray-800);text-decoration:none;transition:.15s;
            white-space:nowrap;
        }
        .category-sidebar a.active,
        .category-sidebar a:hover{background:var(--brand);color:#fff;}
        /* horizontal pills on mobile */
        @media(max-width:991px){
            .category-sidebar{display:flex;overflow:auto;white-space:nowrap;padding:.75rem;background:transparent;box-shadow:none;}
            .category-sidebar a{margin-right:.5rem;border:1px solid var(--brand);color:var(--brand);}
            .category-sidebar a.active,
            .category-sidebar a:hover{background:var(--brand);color:#fff;}
        }

        /* ---------- MENU CARDS ---------- */
        .menu-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.75rem;}
        .menu-card{
            background:#fff;border-radius:1rem;overflow:hidden;display:flex;flex-direction:column;
            box-shadow:0 4px 8px rgba(0,0,0,.05);transition:.2s;
        }
        .menu-card:hover{transform:translateY(-3px);box-shadow:0 6px 14px rgba(0,0,0,.08);}
        .menu-card img{width:100%;height:170px;object-fit:cover;}
        .menu-card .card-body{padding:1rem 1.25rem;flex:1;}
        .menu-card h5{font-size:1.05rem;margin-bottom:.35rem;font-weight:600;}
        .menu-card p{font-size:.9rem;color:#666;margin-bottom:.75rem;max-height:3.6em;overflow:hidden;}
        .price{font-weight:700;font-size:1rem;color:var(--brand);}
        .price del{color:#888;margin-right:.35rem;}

        /* featured ribbon */
        .ribbon{
            position:absolute;top:12px;left:-40px;
            background:var(--brand);color:#fff;padding:.25rem 3.25rem;
            transform:rotate(-45deg);font-size:.75rem;font-weight:600;box-shadow:0 2px 4px rgba(0,0,0,.25);
        }

        /* search */
        .search-bar input{
            border-radius:2rem;padding-left:2.5rem;
        }
        .search-bar i{
            position:absolute;left:1rem;top:50%;transform:translateY(-50%);
            color:#888;
        }

        /* ---------- FOOTER ---------- */
        footer{background:#ffffff;text-align:center;padding:2rem 0;color:#888;font-size:.9rem;}

    </style>
</head>
<body>

{{-- ========== HERO ========== --}}
<header class="hero">
    <div class="position-absolute top-0 end-0 p-4 lang-switcher">
        <div class="dropdown">
            <button class="btn btn-sm rounded-pill d-flex align-items-center gap-1" data-bs-toggle="dropdown">
                <i class="fa-solid fa-globe"></i>{{ strtoupper($default_language ?? 'EN') }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                @foreach($languages as $lang)
                    <li>
                        <a class="dropdown-item {{ $lang['code']==($default_language??'en') ? 'active fw-bold' : '' }}"
                           href="{{ request()->fullUrlWithQuery(['lang'=>$lang['code']]) }}">
                            {{ strtoupper($lang['code']) }} – {{ $lang['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <img class="restaurant-logo mb-3" src="{{ asset('assets/img/logo/logo.svg') }}" alt="logo">
    <h1 class="display-5 fw-bold">{{ $restaurantName }}</h1>
    <p class="lead fst-italic">{{ $tagline }}</p>
    <div class="d-flex justify-content-center gap-3 small">
        @if($restaurantAddress)<span><i class="fa-solid fa-location-dot me-1"></i>{{ $restaurantAddress }}</span>@endif
        @if($phone1)<span><i class="fa-solid fa-phone me-1"></i>{{ $phone1 }}</span>@endif
        @if($phone2)<span><i class="fa-solid fa-phone-flip me-1"></i>{{ $phone2 }}</span>@endif
    </div>
</header>

{{-- ========== SEARCH BAR ========== --}}
<section class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="position-relative search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="menuSearch" class="form-control form-control-lg"
                       placeholder="{{ __('Search menu ...') }}">
            </div>
        </div>
    </div>
</section>

{{-- ========== MAIN LAYOUT ========== --}}
<section class="container pb-5">
    <div class="menu-layout">

        {{-- ---------- Sidebar Categories ---------- --}}
        <nav class="category-sidebar" id="categorySidebar">
            @foreach($categories as $cat)
                @php $slug = Str::slug($cat['name']) @endphp
                <a href="#cat-{{ $slug }}" class="{{ $loop->first ? 'active' : '' }}">
                    {{ $cat['name'] }}
                </a>
            @endforeach
        </nav>

        {{-- ---------- Menu Content ---------- --}}
        <div>
            @foreach($categories as $cat)
                @php
                    $slug = Str::slug($cat['name']);
                    $items = $cat['items'];
                @endphp
                <h2 id="cat-{{ $slug }}" class="mt-5 mb-3 fw-bold">{{ $cat['name'] }}</h2>

                <div class="menu-grid" data-category="{{ $slug }}">
                    @foreach($items as $item)
                        @php
                            $price     = $fmt($item['price']);
                            $salePrice = $item['sale_price'] ? $fmt($item['sale_price']) : null;
                            $imageUrl  = $item['image'] ?? asset('assets/img/menu/menuThumb1_1.png');
                        @endphp
                        <article class="menu-card" data-name="{{ Str::lower($item['name']) }}">
                            @if($item['is_featured'] ?? false)
                                <span class="ribbon">{{ __('Featured') }}</span>
                            @endif
                            <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}">
                            <div class="card-body">
                                <h5>{{ $item['name'] }}</h5>
                                @if(!empty($item['description'])) <p>{{ $item['description'] }}</p> @endif
                                <div class="price">
                                    @if($salePrice)
                                        <del>{{ $price }}</del>{{ $salePrice }}
                                    @else
                                        {{ $price }}
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== FOOTER ========== --}}
<footer>
    &copy; {{ now()->year }} {{ $restaurantName }} — {{ __('All rights reserved.') }}
</footer>

<!-- vendor -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- tiny interactivity -->
<script>
    /* ---------- live search filter ---------- */
    $('#menuSearch').on('input', function (){
        const q = $(this).val().toLowerCase();
        $('.menu-card').each(function(){
            $(this).toggle($(this).data('name').includes(q));
        });
    });

    /* ---------- sidebar active state (scroll spy-ish) ---------- */
    const observer = new IntersectionObserver(entries=>{
        entries.forEach(e=>{
            if(e.isIntersecting){
                const id = e.target.id.replace('cat-','');
                $('.category-sidebar a').removeClass('active')
                    .filter(`[href="#cat-${id}"]`).addClass('active');
            }
        });
    },{rootMargin:'-60% 0px -35% 0px'});
    $('[id^="cat-"]').each((_,el)=>observer.observe(el));
</script>
</body>
</html>
