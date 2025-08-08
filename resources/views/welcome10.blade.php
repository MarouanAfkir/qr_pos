{{-- resources/views/welcome.blade.php --}}
@php
    use Illuminate\Support\Str;
    $lang        = request('lang', app()->getLocale() ?: 'en');
    app()->setLocale($lang);

    $name        = $restaurant['name'] ?? 'Restaurant';
    $logo        = $restaurant['logo'] ?? null;
    $address     = $restaurant['address'] ?? '';
    $phone1      = $restaurant['phone_number_1'] ?? '';
    $tagline     = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';
    $currency    = ' DH';
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $name }} – Digital Menu</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
  <style>
    :root {
      --clr-primary: #d97706;
      --clr-accent: #fcd34d;
      --clr-bg: #fafaf9;
      --clr-card: #ffffff;
      --transition:.3s;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Inter',sans-serif;background:var(--clr-bg);color:#333;overflow-x:hidden;}
    h1,h2,h3{font-family:'Playfair Display',serif;}
    a{text-decoration:none;color:inherit;}
    /* Hero */
    .hero{position:relative;background:url('{{ asset($logo?:"/assets/img/hero.jpg") }}') center/cover no-repeat;height:60vh;display:flex;align-items:center;justify-content:center;}
    .hero-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.4);}
    .hero-content{position:relative;color:#fff;text-align:center;padding:2rem;}
    .hero-content h1{font-size:3rem;letter-spacing:2px;}
    .hero-content p{font-size:1.25rem;margin:1rem 0;}
    .hero-content .btn-primary{background:var(--clr-primary);border:none;padding:.75rem 1.5rem;font-size:1rem;transition:var(--transition);}
    .hero-content .btn-primary:hover{background:var(--clr-accent);color:#000;}

    /* Layout */
    .container-flex {display:flex;gap:2rem;padding:2rem;}
    .sidebar {flex:0 0 250px;position:sticky;top:80px;}
    .sidebar input, .sidebar select {width:100%;margin-bottom:1rem;padding:.5rem;border:1px solid #ddd;border-radius:6px;}
    .menu-grid {flex:1;display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1.5rem;}
    .card-menu {background:var(--clr-card);border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.05);transition:transform var(--transition);}
    .card-menu:hover{transform:translateY(-4px);}
    .card-img{height:160px;background-size:cover;background-position:center;}
    .card-body{padding:1rem;}
    .card-body h5{font-size:1.1rem;margin-bottom:.5rem;}
    .card-body p{font-size:.85rem;color:#555;height:2.5rem;overflow:hidden;}
    .card-footer{padding:1rem;border-top:1px solid #eee;display:flex;justify-content:space-between;align-items:center;}
    .price{font-weight:600;color:var(--clr-primary);}
    .btn-view{font-size:.85rem;padding:.4rem .8rem;border:1px solid var(--clr-primary);border-radius:6px;transition:var(--transition);}
    .btn-view:hover{background:var(--clr-primary);color:#fff;}

    /* Modal */
    .modal .nav-tabs .nav-link.active {background:var(--clr-primary);color:#fff;}
    .modal-body .composition, .modal-body .variation {margin-bottom:1rem;}
    .bottom-bar {position:fixed;bottom:0;left:0;width:100%;background:var(--clr-primary);padding:.75rem;display:flex;justify-content:space-around;color:#fff;}
    .bottom-bar a{color:#fff;font-size:1.2rem;transition:opacity var(--transition);}
    .bottom-bar a:hover{opacity:.7;}
  </style>
</head>
<body>

  {{-- Hero --}}
  <section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>{{ $name }}</h1>
      <p class="fst-italic">{{ $tagline }}</p>
      <button class="btn btn-primary">{{ __('Explore Menu') }}</button>
    </div>
  </section>

  {{-- Main Content --}}
  <div class="container-flex">
    {{-- Sidebar --}}
    <aside class="sidebar d-none d-lg-block">
      <input id="menuSearch" type="text" placeholder="{{ __('Search…') }}">
      <select id="filterCat">
        <option value="all">{{ __('All Categories') }}</option>
        @foreach($categories as $cat)
          <option value="{{ Str::slug($cat['name']) }}">{{ $cat['name'] }}</option>
        @endforeach
      </select>
    </aside>

    {{-- Menu Grid --}}
    <section class="menu-grid">
      @foreach($categories as $cat)
        @foreach($cat['items'] as $item)
          @php
            $slug      = Str::slug($cat['name']);
            $price     = number_format($item['price'],2).$currency;
            $sale      = $item['sale_price'] ? number_format($item['sale_price'],2).$currency : null;
            $img       = $item['image'] ?? '/assets/img/menu-default.jpg';
          @endphp
          <div class="card-menu" data-cat="{{ $slug }}">
            <div class="card-img" style="background-image:url('{{ $img }}')"></div>
            <div class="card-body">
              <h5>{{ $item['name'] }}</h5>
              <p>{{ Str::limit($item['description'] ?? '', 80) }}</p>
            </div>
            <div class="card-footer">
              <span class="price">
                @if($sale)
                  <del>{{ $price }}</del> {{ $sale }}
                @else
                  {{ $price }}
                @endif
              </span>
              <button class="btn-view btn-sm"
                      data-json='@json($item)'
                      onclick="showModal(this)">
                {{ __('View') }}
              </button>
            </div>
          </div>
        @endforeach
      @endforeach
    </section>
  </div>

  {{-- Item Modal --}}
  <div class="modal fade" id="itemModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"></h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-details">{{ __('Details') }}</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-options">{{ __('Options') }}</a></li>
          </ul>
          <div class="tab-content">
            <div id="tab-details" class="tab-pane fade show active">
              <img id="modalImage" src="" class="img-fluid rounded mb-3">
              <p id="modalDesc"></p>
              <div class="composition">
                <strong>{{ __('What’s inside') }}:</strong>
                <span id="modalComp"></span>
              </div>
            </div>
            <div id="tab-options" class="tab-pane fade">
              <div id="modalOpts"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Bottom Bar --}}
  <div class="bottom-bar d-flex d-lg-none">
    <a href="tel:{{ $phone1 }}"><i class="fas fa-phone"></i></a>
    <a href="https://maps.google.com/?q={{ urlencode($address) }}" target="_blank"><i class="fas fa-map-marker-alt"></i></a>
    <a href="#itemModal" data-bs-toggle="modal"><i class="fas fa-utensils"></i></a>
  </div>

  {{-- Scripts --}}
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    function showModal(btn){
      const data = JSON.parse(btn.getAttribute('data-json'));
      document.querySelector('#itemModal .modal-title').innerText = data.name;
      document.getElementById('modalImage').src   = data.image;
      document.getElementById('modalDesc').innerText = data.description || '{{ __("No description available.") }}';
      document.getElementById('modalComp').innerText = data.ingredients || '{{ __("N/A") }}';

      let optsHtml = '';
      (data.variations||[]).forEach(v=>{
        const extra = v.options.find(o=>parseFloat(o.price_adjustment)>0);
        if(extra){
          optsHtml += `<div class="variation mb-2">
            <strong>${v.name}:</strong> <strong>+${parseFloat(extra.price_adjustment).toFixed(2)}${'{{ $currency }}'}</strong>
          </div>`;
        }
      });
      document.getElementById('modalOpts').innerHTML = optsHtml;
      new bootstrap.Modal(document.getElementById('itemModal')).show();
    }

    // Search & filter
    document.getElementById('menuSearch').addEventListener('input',function(){
      const q = this.value.toLowerCase();
      document.querySelectorAll('.card-menu').forEach(c=>{
        c.style.display = c.querySelector('h5').innerText.toLowerCase().includes(q) ? 'block':'none';
      });
    });
    document.getElementById('filterCat').addEventListener('change',function(){
      const f=this.value;
      document.querySelectorAll('.card-menu').forEach(c=>{
        c.style.display = (f==='all'||c.dataset.cat===f) ? 'block':'none';
      });
    });
  </script>
</body>
</html>
