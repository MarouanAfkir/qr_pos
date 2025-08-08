{{-- resources/views/welcome.blade.php --}}
@php
    use Illuminate\Support\Str;

    /* ---------- Locale & helpers ---------- */
    $lang = request('lang', app()->getLocale() ?: 'en');
    app()->setLocale($lang);

    $name      = $restaurant['name']    ?? 'Restaurant';
    $logo      = $restaurant['logo']    ?? null;
    $address   = $restaurant['address'] ?? '';
    $phone1    = $restaurant['phone_number_1'] ?? '';
    $tagline   = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';
    $menuTitle = trim($menu['name'] ?? '') ?: __('Our Menu');
    $currency  = ' DH';
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{ $name }} | Digital Menu</title>

  <!-- Google Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

  <style>
    :root {
      --primary: #D35400;
      --accent:  #F39C12;
      --light:   #FFF8F1;
      --dark:    #2C3E50;
    }
    * { box-sizing: border-box; }
    body { font-family: 'Montserrat', sans-serif; background: var(--light); color: var(--dark); margin:0; }

    /* Hero – reduced height */
    .hero {
      position: relative;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: #fff; text-align: center; padding: 1.5rem 1rem;
    }
    .hero-logo {
      width: 90px; height: 90px;
      border: 3px solid #fff;
      border-radius: 50%; background: #fff;
      display: inline-flex; align-items:center; justify-content:center;
      overflow:hidden; margin-bottom:.5rem;
    }
    .hero-logo img {
      max-height: 75px; object-fit:contain;
    }
    .hero h1 {
      font-family:'Playfair Display', serif;
      font-size: 1.75rem; margin: .25rem 0;
    }
    .hero p.lead {
      font-size: .95rem; opacity: .9; margin:0;
    }

    /* Language switcher */
    .hero .lang-switcher {
      position: absolute; top: .75rem; right: .75rem;
    }
    .hero .lang-switcher .btn {
      background: rgba(255,255,255,.2);
      border: 1px solid #fff;
      color: #fff;
      padding: .25rem .6rem;
      border-radius: 50px;
      font-size: .9rem;
      transition: background .2s;
    }
    .hero .lang-switcher .btn:hover {
      background: rgba(255,255,255,.4);
    }

    /* Top Search */
    .top-search {
      padding: .75rem 1rem; text-align:center;
      background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.05);
    }
    .top-search input {
      width:100%; max-width:360px;
      padding:.5rem 1rem;
      border:2px solid var(--primary);
      border-radius:50px;
      font-size:1rem;
      outline:none;
      transition: box-shadow .2s;
    }
    .top-search input:focus {
      box-shadow:0 0 8px rgba(211,84,0,.5);
    }

    /* Categories */
    .cats {
      display: flex; overflow-x:auto;
      gap: .75rem; padding: .5rem 1rem 1rem;
      background: #fff;
    }
    .cats button {
      flex: 0 0 auto;
      padding: .5rem 1rem;
      background: #fff;
      border: 2px solid var(--primary);
      border-radius: 50px;
      color: var(--primary);
      transition: .2s;
      white-space: nowrap;
    }
    .cats button.active,
    .cats button:hover {
      background: var(--primary);
      color: #fff;
    }

    /* Menu grid */
    .menu-grid {
      display:grid;
      grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
      gap:1.5rem;
      padding:1rem;
    }
    .card-menu {
      background:#fff;
      border:none;
      border-radius: .75rem;
      overflow:hidden;
      box-shadow: 0 6px 18px rgba(0,0,0,.1);
      transition: transform .2s;
      display:flex; flex-direction:column;
    }
    .card-menu:hover { transform: translateY(-5px); }
    .card-menu img { height:160px; object-fit:cover; }
    .card-body { flex:1; padding:1rem; }
    .card-body h5 {
      font-family:'Playfair Display', serif;
      margin-bottom:.5rem;
      color:var(--dark);
      font-size:1.1rem;
    }
    .card-body p {
      font-size:.85rem;
      color:#666;
      height:2.5em;
      overflow:hidden;
      margin:0;
    }
    .card-footer {
      background: var(--light);
      padding:1rem;
      display:flex;
      justify-content:space-between;
      align-items:center;
    }
    .price {
      font-weight:600;
      color:var(--primary);
    }
    .btn-order {
      background: var(--primary);
      color:#fff;
      border:none;
      padding:.5rem 1rem;
      border-radius:50px;
      font-size:.85rem;
      transition:.2s;
    }
    .btn-order:hover { background: var(--accent); }

    /* Modal – smaller, elegant image */
    .modal-header {
      background: var(--primary);
      color:#fff;
      border-bottom:none;
    }
    .modal-title {
      font-family:'Playfair Display', serif;
      font-size:1.5rem;
    }
    .modal-body {
      display:flex;
      align-items:flex-start;
      gap:1rem;
      padding:1.5rem;
    }
    .modal-body img {
      width:100px;
      height:100px;
      object-fit:cover;
      border-radius:.5rem;
      flex-shrink:0;
      box-shadow:0 4px 12px rgba(0,0,0,.1);
    }
    .detail-item {
      margin-bottom:1rem;
      font-size:.95rem;
    }
    .detail-item strong { color:var(--dark); }

    footer {
      text-align:center;
      padding:1rem;
      font-size:.875rem;
      color:#555;
      background:#fff;
      box-shadow: 0 -2px 8px rgba(0,0,0,.05);
    }
  </style>
</head>
<body>

  {{-- Hero --}}
  <section class="hero">
    <div class="lang-switcher">
      <div class="dropdown">
        <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
          {{ strtoupper($lang) }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          @foreach($languages ?? [] as $l)
            <li>
              <a class="dropdown-item {{ $l['code']==$lang?'active':'' }}"
                 href="{{ request()->fullUrlWithQuery(['lang'=>$l['code']]) }}">
                {{ strtoupper($l['code']) }} — {{ $l['name'] }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="hero-logo">
      <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/logo.svg') }}" alt="Logo">
    </div>
    <h1>{{ $name }}</h1>
    <p class="lead fst-italic">{{ $tagline }}</p>
  </section>

  {{-- Top Search --}}
  <div class="top-search">
    <input id="mainSearch" type="text" placeholder="{{ __('Search the menu…') }}">
  </div>

  {{-- Categories --}}
  <div class="cats">
    @foreach($categories as $cat)
      <button class="{{ $loop->first?'active':'' }}"
              data-filter="{{ Str::slug($cat['name']) }}">
        {{ $cat['name'] }}
      </button>
    @endforeach
  </div>

  {{-- Grid --}}
  <div class="menu-grid">
    @foreach($categories as $cat)
      @foreach($cat['items'] as $item)
        @php
          $slug  = Str::slug($cat['name']);
          $price = number_format($item['price'],2).$currency;
          $sale  = $item['sale_price']
                   ? number_format($item['sale_price'],2).$currency
                   : null;
          $img   = $item['image'] ?? asset('assets/img/menu/menuThumb1_1.png');
        @endphp
        <div class="card-menu" data-cat="{{ $slug }}">
          <img src="{{ $img }}" alt="{{ $item['name'] }}">
          <div class="card-body">
            <h5>{{ $item['name'] }}</h5>
            @if($item['description'])
              <p>{{ Str::limit($item['description'], 80) }}</p>
            @endif
          </div>
          <div class="card-footer">
            <div class="price">
              @if($sale)
                <del class="text-muted me-1">{{ $price }}</del>
                <span>{{ $sale }}</span>
              @else
                {{ $price }}
              @endif
            </div>
            <button class="btn-order"
                    data-name="{{ e($item['name']) }}"
                    data-img="{{ $img }}"
                    data-desc="{{ e($item['description']??'') }}"
                    data-price="{!! $sale?'<del>'.$price.'</del> '.$sale:$price !!}"
                    data-ingredients="{{ e($item['ingredients'] ?? '') }}"
                    data-variations='@json($item["variations"] ?? [])'>
              {{ __('Details') }}
            </button>
          </div>
        </div>
      @endforeach
    @endforeach
  </div>

  {{-- Details Modal --}}
  <div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <img id="modalImg" src="" alt="">
          <div>
            <p id="modalDesc" class="mb-3"></p>
            <h4 id="modalPrice" class="mb-4 text-primary"></h4>
            <div id="modalExtras"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Footer --}}
  <footer>
    &copy; {{ now()->year }} {{ $name }} • {{ __('All rights reserved.') }}
  </footer>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    // Category filter
    document.querySelectorAll('.cats button').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.cats button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const f = btn.dataset.filter;
        document.querySelectorAll('.card-menu').forEach(c => {
          c.style.display = c.dataset.cat === f ? 'flex' : 'none';
        });
      });
    });

    // Main search
    document.getElementById('mainSearch').addEventListener('input', e => {
      const q = e.target.value.toLowerCase();
      document.querySelectorAll('.card-menu').forEach(c => {
        const name = c.querySelector('h5').innerText.toLowerCase();
        c.style.display = name.includes(q) ? 'flex' : 'none';
      });
    });

    // Modal logic
    const modal = new bootstrap.Modal('#itemModal');
    document.querySelectorAll('.btn-order').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelector('#itemModal .modal-title').textContent = btn.dataset.name;
        document.getElementById('modalImg').src = btn.dataset.img;
        document.getElementById('modalDesc').textContent = btn.dataset.desc || '{{ __("No description available.") }}';
        document.getElementById('modalPrice').innerHTML = btn.dataset.price;

        let html = '';
        const comp = btn.dataset.ingredients;
        if (comp) {
          html += `<div class="detail-item"><strong>{{ __("Composition") }}:</strong> ${comp}</div>`;
        }
        const vars = JSON.parse(btn.dataset.variations||'[]');
        vars.forEach(v => {
          const extra = v.options.find(o => parseFloat(o.price_adjustment) > 0);
          if (extra) {
            html += `<div class="detail-item"><strong>${v.name}:</strong> <strong>+${parseFloat(extra.price_adjustment).toFixed(2)}${'{{ $currency }}'}</strong></div>`;
          }
        });
        document.getElementById('modalExtras').innerHTML = html;

        modal.show();
      });
    });
  </script>
</body>
</html>
