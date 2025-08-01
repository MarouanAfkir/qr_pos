{{-- resources/views/welcome.blade.php --}}
@php
    use Illuminate\Support\Str;

    /* ---------- Locale ---------- */
    $default_language = request('lang', app()->getLocale() ?: 'en');
    app()->setLocale($default_language);

    /* ---------- Café data ---------- */
    $currency         = ' DH';
    $restaurantName   = $restaurant['name']    ?? 'Caffè Nuovo';
    $logo             = $restaurant['logo']    ?? null;
    $tagline          = $restaurant['settings']['tagline'] ?? 'Artisan Coffee & Bakes';

    $rawMenuName      = $menu['name'] ?? '';
    $menuTitle        = trim($rawMenuName) && $rawMenuName !== $restaurantName
                        ? $rawMenuName
                        : __('Our Menu');
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{{ $restaurantName }} – Menu</title>

<!-- core libs -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<style>
:root{
    --ink:#1f1f1f;          /* charcoal text  */
    --paper:#fdfdfb;        /* off-white bg   */
    --accent:#14b57f;       /* emerald green  */
    --accent-soft:#e5faf2;
}
html{scroll-behavior:smooth}
body{
    font-family:Inter,system-ui,sans-serif;
    background:var(--paper);
    color:var(--ink);
    font-size:1.0625rem;    /* 17 px */
    line-height:1.55;
}
h1,h2,h3{font-weight:600;letter-spacing:.3px}

/* ---------- header ---------- */
.hero{
    text-align:center;padding:3rem 0 2rem;
}
.logo-circle{
    width:120px;height:120px;margin:0 auto 1rem;
    border-radius:50%;background:var(--paper);
    box-shadow:0 3px 12px rgba(0,0,0,.12);
    display:flex;align-items:center;justify-content:center;
}
.logo-circle img{width:78%;border-radius:50%}
.hero h1{font-size:1.9rem;margin-bottom:.25rem}
.hero .tag{color:var(--accent);font-size:1rem;margin-bottom:.25rem}
.meta{font-size:.85rem;opacity:.8}

/* ---------- language button ---------- */
.lang-btn{
    position:absolute;top:.9rem;right:1rem;z-index:100;
}
.lang-btn .btn{
    background:var(--accent);color:#fff;border:0;
    padding:.4rem .8rem;font-weight:600;font-size:.9rem;
}
.lang-btn .btn:hover{background:#0f8b63}

/* ---------- category pills ---------- */
#catRail{
    display:flex;gap:.5rem;overflow-x:auto;scroll-snap-type:x mandatory;
    padding:.8rem 1rem;border-top:1px solid rgba(0,0,0,.05);border-bottom:1px solid rgba(0,0,0,.05);
}
#catRail::-webkit-scrollbar{display:none}
#catRail .nav-link{
    flex:0 0 auto;scroll-snap-align:center;
    border:1px solid var(--accent);color:var(--ink);background:none;
    padding:.45rem 1.1rem;border-radius:999rem;font-size:.9rem;transition:.15s;
}
#catRail .nav-link.active{background:var(--accent);color:#fff}
#catRail .nav-link:focus-visible{outline:3px solid var(--accent-soft)}

/* ---------- menu cards ---------- */
.card-item{
    display:flex;gap:.9rem;padding:1rem;margin-bottom:1rem;
    background:#fff;border-radius:.9rem;box-shadow:0 1px 5px rgba(0,0,0,.06);
    transition:.2s transform;
}
.card-item:hover{transform:translateY(-4px)}
.card-thumb{
    width:90px;aspect-ratio:1/1;border-radius:.6rem;overflow:hidden;flex-shrink:0;
}
.card-thumb img{width:100%;height:100%;object-fit:cover}
.card-body{flex-grow:1}
.card-body h3{font-size:1rem;margin-bottom:.15rem}
.card-body p{font-size:.8rem;opacity:.75;margin-bottom:.2rem}
.card-price{font-weight:600;white-space:nowrap;margin-left:auto;font-size:.92rem}
.card-price del{opacity:.55;font-size:.8rem;margin-right:.25rem}

/* ---------- modal ---------- */
.modal-content{border:0;border-radius:1rem}
.modal-header{background:var(--accent);color:#fff;border:0;border-top-left-radius:1rem;border-top-right-radius:1rem}
.modal-title{font-size:1.3rem}
.modal-body{padding:1.4rem}
.modal-body img{width:140px;height:140px;border-radius:.7rem;object-fit:cover;margin-right:1rem}
@media(max-width:576px){.modal-body img{width:110px;height:110px;margin-right:0;margin-bottom:.8rem}}
.price-badge{
    background:var(--accent);color:#fff;padding:.25rem .7rem;border-radius:.45rem;font-weight:600
}

/* ---------- footer ---------- */
footer{background:#111;color:#ccc;font-size:.8rem;text-align:center;padding:1.4rem 0}
footer a{color:var(--accent);text-decoration:none}

[data-hide=true]{display:none!important}
</style>
</head>

<body>

<!-- language dropdown -->
<div class="lang-btn">
    <div class="dropdown">
        <button class="btn btn-sm rounded-pill d-flex align-items-center gap-1" data-bs-toggle="dropdown">
            <i class="fa-solid fa-globe"></i>{{ strtoupper($default_language) }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow fade">
            @foreach($languages ?? [] as $lang)
                <li><a class="dropdown-item {{ $lang['code']==$default_language?'active fw-bold':'' }}"
                       href="{{ request()->fullUrlWithQuery(['lang'=>$lang['code']]) }}">
                        {{ strtoupper($lang['code']) }} — {{ $lang['name'] }}
                    </a></li>
            @endforeach
        </ul>
    </div>
</div>

<!-- hero -->
<header class="hero position-relative">
    <div class="logo-circle">
        <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/coffee.svg') }}" alt="Logo">
    </div>
    <h1>{{ $restaurantName }}</h1>
    <p class="tag">{{ $tagline }}</p>
    <p class="meta mb-0">
        @if($restaurant['address'] ?? '')<span class="me-3"><i class="fa-solid fa-location-dot me-1"></i>{{ $restaurant['address'] }}</span>@endif
        @if($restaurant['phone_number_1'] ?? '')<span class="me-3"><i class="fa-solid fa-phone me-1"></i>{{ $restaurant['phone_number_1'] }}</span>@endif
        @if($restaurant['phone_number_2'] ?? '')<span><i class="fa-solid fa-phone me-1"></i>{{ $restaurant['phone_number_2'] }}</span>@endif
    </p>
</header>

<!-- category rail -->
<ul class="nav nav-pills justify-content-center" id="catRail" role="tablist">
    @foreach($categories as $cat)
        @php $slug = Str::slug($cat['name']); @endphp
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->first?'active':'' }}" id="pill-{{ $slug }}"
                    data-bs-toggle="pill" data-bs-target="#pane-{{ $slug }}" type="button">
                {{ $cat['name'] }}
            </button>
        </li>
    @endforeach
</ul>

<!-- menu panes -->
<div class="tab-content container pb-4">
    @foreach($categories as $cat)
        @php
            $slug = Str::slug($cat['name']);
            $columns = array_chunk($cat['items'], ceil(max(count($cat['items']),1)/2));
        @endphp
        <div class="tab-pane fade {{ $loop->first?'show active':'' }}" id="pane-{{ $slug }}">
            <div class="row gx-4">
                @foreach($columns as $colItems)
                    <div class="col-lg-6">
                        @foreach($colItems as $item)
                            @php
                                $price     = number_format($item['price'],2);
                                $sale      = $item['sale_price'];
                                $img       = $item['image'] ?? asset('assets/img/menu/placeholder_coffee.png');
                                $priceHTML = $sale
                                              ? '<del>'.$price.$currency.'</del> <span class="text-danger fw-semibold">'.number_format($sale,2).$currency.'</span>'
                                              : $price.$currency;
                                $modalData = [
                                    'name'  => $item['name'],
                                    'desc'  => $item['description'] ?? '',
                                    'img'   => $img,
                                    'price' => $priceHTML,
                                ];
                            @endphp
                            <div class="card-item"
                                 data-name="{{ Str::lower($item['name']) }}"
                                 data-modal='@json($modalData)'>
                                <div class="card-thumb"><img src="{{ $img }}" alt=""></div>
                                <div class="card-body">
                                    <h3>{{ $item['name'] }}</h3>
                                    @if(!empty($item['description']))<p>{{ $item['description'] }}</p>@endif
                                </div>
                                <div class="card-price">{!! $priceHTML !!}</div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<!-- footer -->
<footer>
    &copy; {{ now()->year }} {{ $restaurantName }} · {{ __('All rights reserved.') }}
</footer>

<!-- modal -->
<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title fs-5" id="itemTitle"></h2>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
        </div>
        <div class="modal-body d-flex flex-column flex-sm-row align-items-sm-start">
            <img id="mImg" src="" alt="">
            <div class="ms-sm-3">
                <p id="mDesc" class="mb-3"></p>
                <span id="mPrice" class="price-badge"></span>
            </div>
        </div>
    </div></div>
</div>

<!-- scripts -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script>
/* Modal open */
const mod=new bootstrap.Modal('#itemModal');
$(document).on('click','.card-item',function(){
    const d=$(this).data('modal');
    $('#itemTitle').text(d.name);$('#mImg').attr('src',d.img);
    $('#mDesc').text(d.desc||'{{ __('No description available.') }}');
    $('#mPrice').html(d.price);mod.show();
});

/* Simple search */
$('#filterInput').on('input',e=>{
    const q=e.target.value.toLowerCase();
    $('.card-item').each(function(){
        $(this).attr('data-hide', q && !$(this).data('name').includes(q));
    });
});
</script>
</body>
</html>
