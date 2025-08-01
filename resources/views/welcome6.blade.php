{{-- resources/views/welcome.blade.php --}}
@php
    use Illuminate\Support\Str;

    /* ---------- Helpers ---------- */
    $restaurantName    = $restaurant['name']            ?? 'Restaurant';
    $restaurantAddress = $restaurant['address']         ?? '';
    $phone1            = $restaurant['phone_number_1']  ?? '';
    $phone2            = $restaurant['phone_number_2']  ?? '';
    $tagline           = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';
    $currencySuffix    = ($currency ?? 'Dh');           // passed from route

    $fmt = fn($n) => number_format($n, 2) . ' ' . $currencySuffix;   // thin-space before Dh
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurantName }} – Menu</title>

    <!-- Core CSS (Bootstrap 5 & FontAwesome) -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <!-- Minimal custom design system -->
    <style>
        :root{
            --accent:#d92332;          /* brand red — tweak per client */
            --accent-hover:#b71c28;
            --gray-50:#f9fafb;
            --gray-800:#1f2937;
            --radius:.75rem;
        }
        body       {font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:#fff;color:var(--gray-800);}
        h1,h2,h3,h4{font-weight:700;color:var(--gray-800);}
        a          {color:var(--accent);}
        a:hover    {color:var(--accent-hover);}

        /* ---------- TOP BAR ---------- */
        .top-bar      {padding:1.25rem 0;border-bottom:1px solid var(--gray-50);}
        .logo-img     {width:72px;height:auto;}
        .tagline      {color:var(--accent);font-style:italic;font-weight:500;}

        /* ---------- LANGUAGE SWITCHER ---------- */
        .lang-switcher .btn{
            background:var(--gray-50);border:none;color:var(--gray-800);font-weight:600;
        }
        .lang-switcher .btn:hover{background:var(--accent);color:#fff;}

        /* ---------- CATEGORY SCROLLER ---------- */
        .cat-scroll{
            overflow-x:auto;white-space:nowrap;padding:.5rem 0 .75rem;
            border-bottom:1px solid var(--gray-50);scrollbar-width:none;
        }
        .cat-scroll::-webkit-scrollbar{display:none;}
        .cat-link{
            display:inline-block;margin-right:.5rem;padding:.45rem 1rem;border-radius:var(--radius);
            background:var(--gray-50);color:var(--gray-800);font-weight:500;text-decoration:none;transition:.15s;
        }
        .cat-link:hover,
        .cat-link.active{background:var(--accent);color:#fff;}

        /* ---------- SEARCH ---------- */
        .search-wrap{position:relative;margin:1.5rem 0;}
        .search-wrap input{
            border-radius:var(--radius);padding:.8rem 1rem .8rem 2.75rem;border:1px solid var(--gray-50);
        }
        .search-wrap i{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#bbb;}

        /* ---------- MENU GRID ---------- */
        .menu-grid{
            display:grid;gap:1.5rem;
            grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
        }
        .item-card{
            background-color: #fff;
            border:1px solid var(--gray-50);border-radius:var(--radius);overflow:hidden;transition:.2s;display:flex;flex-direction:column;
        }
        .item-card:hover{box-shadow:0 6px 14px rgba(0,0,0,.06);transform:translateY(-2px);}
        .item-img{width:100%;height:170px;object-fit:cover;}
        .item-body{padding:1rem 1.25rem;flex:1;display:flex;flex-direction:column;}
        .item-body h5{font-size:1.05rem;margin-bottom:.35rem;}
        .item-desc{font-size:.9rem;color:#666;flex:1;}
        .price{font-weight:700;color:var(--accent);margin-top:.5rem;}
        .price del{color:#888;margin-right:.35rem;}

        /* ---------- FOOTER ---------- */
        footer{border-top:1px solid var(--gray-50);padding:2rem 0;font-size:.875rem;color:#888;text-align:center;}
        .bg-color2{background:#f3f1eb;} /* light gray background for body */
    </style>
</head>
<body class="bg-color2">

<!-- ======= TOP BAR ======= -->
<header class="top-bar">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('assets/img/logo/logo.svg') }}" class="logo-img" alt="logo">
            <div>
                <h1 class="h4 mb-0">{{ $restaurantName }}</h1>
                <small class="tagline">{{ $tagline }}</small>
            </div>
        </div>

        <!-- Language switcher -->
        <div class="lang-switcher">
            <div class="dropdown">
                <button class="btn btn-sm rounded-pill d-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-globe"></i>{{ strtoupper($default_language ?? 'EN') }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    @foreach($languages as $lang)
                        <li>
                            <a class="dropdown-item {{ $lang['code'] == ($default_language ?? 'en') ? 'active fw-bold' : '' }}"
                               href="{{ request()->fullUrlWithQuery(['lang' => $lang['code']]) }}">
                                {{ strtoupper($lang['code']) }} – {{ $lang['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</header>

<!-- ======= ADDRESS / PHONE ======= -->
<section class="container py-2 small text-muted text-center">
    @if($restaurantAddress)<span class="me-2"><i class="fa-solid fa-location-dot me-1"></i>{{ $restaurantAddress }}</span>@endif
    @if($phone1)<span class="me-2"><i class="fa-solid fa-phone me-1"></i>{{ $phone1 }}</span>@endif
    @if($phone2)<span><i class="fa-solid fa-phone-flip me-1"></i>{{ $phone2 }}</span>@endif
</section>

<!-- ======= CATEGORY SCROLLER ======= -->
<nav class="cat-scroll" id="catScroll">
    <div class="container px-0">
        @foreach($categories as $cat)
            @php $slug = Str::slug($cat['name']) @endphp
            <a class="cat-link {{ $loop->first ? 'active' : '' }}" href="#cat-{{ $slug }}">{{ $cat['name'] }}</a>
        @endforeach
    </div>
</nav>

<!-- ======= SEARCH ======= -->
<div class="container">
    <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="menuSearch" class="form-control" placeholder="{{ __('Search menu …') }}">
    </div>
</div>

<!-- ======= MENU CONTENT ======= -->
<section class="container pb-5" id="menuContent">
    @foreach($categories as $cat)
        @php $slug = Str::slug($cat['name']); @endphp

        <h2 id="cat-{{ $slug }}" class="mb-3 pt-4">{{ $cat['name'] }}</h2>

        <div class="menu-grid" data-category="{{ $slug }}">
            @foreach($cat['items'] as $item)
                @php
                    $price     = $fmt($item['price']);
                    $salePrice = $item['sale_price'] ? $fmt($item['sale_price']) : null;
                    $imageUrl  = $item['image'] ?? asset('assets/img/menu/menuThumb1_1.png');
                @endphp
                <article class="item-card" data-name="{{ Str::lower($item['name']) }}">
                    <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" class="item-img">
                    <div class="item-body">
                        <h5>{{ $item['name'] }}</h5>
                        @if(!empty($item['description']))
                            <p class="item-desc">{{ $item['description'] }}</p>
                        @endif
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
</section>

<!-- ======= FOOTER ======= -->
<footer>
    &copy; {{ now()->year }} {{ $restaurantName }} — {{ __('All rights reserved.') }}
</footer>

<!-- Scripts -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script>
    /* -------- Live search -------- */
    $('#menuSearch').on('input', function (){
        const q = $(this).val().trim().toLowerCase();
        $('.item-card').each(function(){
            $(this).toggle($(this).data('name').includes(q));
        });
    });

    /* -------- ScrollSpy for category highlight -------- */
    const spyOptions = {rootMargin:'-60% 0px -35% 0px'};
    const observer = new IntersectionObserver((entries)=>{
        entries.forEach(e=>{
            if(e.isIntersecting){
                const id = e.target.id.replace('cat-','');
                $('.cat-link').removeClass('active')
                              .filter(`[href="#cat-${id}"]`).addClass('active');
            }
        });
    }, spyOptions);
    $('[id^="cat-"]').each((_,el)=>observer.observe(el));
</script>
</body>
</html>
