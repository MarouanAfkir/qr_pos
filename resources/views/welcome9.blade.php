{{-- resources/views/welcome.blade.php --}}
@php
    use Illuminate\Support\Str;
    $default_language = request('lang', app()->getLocale() ?: 'en');
    app()->setLocale($default_language);

    $cafeName   = $restaurant['name']    ?? 'Café';
    $logo       = $restaurant['logo']    ?? null;
    $address    = $restaurant['address'] ?? '';
    $phone1     = $restaurant['phone_number_1'] ?? '';
    $phone2     = $restaurant['phone_number_2'] ?? '';
    $tagline    = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';
    $menuTitle  = trim($menu['name'] ?? '') ?: __('Our Menu');
    $currency   = ' DH';
@endphp

<!DOCTYPE html>
<html lang="{{ $default_language }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{ $cafeName }} – Digital Café Menu</title>

  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
  <style>
    :root {
      --clr-primary: #6f4e37;
      --clr-accent: #c49a6c;
      --clr-bg: #fdfdfd;
      --clr-card-bg: rgba(255,255,255,0.7);
      --clr-text: #333;
      --transition: 0.3s ease;
    }
    * { box-sizing: border-box; margin:0; padding:0; }
    body { font-family:'Inter',sans-serif; background:var(--clr-bg); color:var(--clr-text); overflow-x:hidden; }
    h1,h2,h3 { font-family:'Playfair Display',serif; }
    a { text-decoration:none; color:inherit; }

    /* Sticky Header */
    header { position:sticky; top:0; backdrop-filter:blur(10px); background:rgba(255,255,255,0.75); z-index:1000; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
    .header-inner { display:flex; align-items:center; justify-content:space-between; padding:1rem 2rem; }
    .logo img { height:64px; width:64px; border-radius:50%; object-fit:cover; transition:transform var(--transition); }
    .logo img:hover { transform:scale(1.05); }
    .header-info h1 { font-size:1.5rem; color:var(--clr-primary); }
    .header-info p { font-size:.9rem; color:var(--clr-accent); margin:.25rem 0; }
    .header-meta { font-size:.85rem; color:var(--clr-text); display:flex; gap:1rem; align-items:center; }
    .header-meta i { color:var(--clr-primary); margin-right:.25rem; }

    /* Language Button */
    .lang-switcher .btn { font-size:.85rem; padding:.4rem .8rem; background:var(--clr-primary); color:#fff; border:none; border-radius:50px; transition:background var(--transition); }
    .lang-switcher .btn:hover { background:var(--clr-accent); }

    /* Floating Filter */
    .filter-fab { position:fixed; bottom:2rem; right:2rem; width:56px; height:56px; border-radius:50%; background:var(--clr-primary); color:#fff; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(0,0,0,0.2); cursor:pointer; z-index:900; transition:transform var(--transition); }
    .filter-fab:hover { transform:scale(1.1); }
    .filter-panel { position:fixed; bottom:6rem; right:2rem; background:#fff; border-radius:.5rem; box-shadow:0 4px 20px rgba(0,0,0,0.15); padding:1rem; display:none; flex-direction:column; gap:.5rem; z-index:900; max-height:60vh; overflow-y:auto; }
    .filter-panel button { padding:.5rem 1rem; border:none; border-radius:1rem; background:var(--clr-card-bg); backdrop-filter:blur(8px); transition:background var(--transition); }
    .filter-panel button.active, .filter-panel button:hover { background:var(--clr-accent); color:#fff; }

    /* Search Bar */
    .search-bar { position:sticky; top:88px; backdrop-filter:blur(8px); background:rgba(255,255,255,0.8); padding:2rem 0; display:flex; justify-content:center; z-index:900; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
    .search-container { position:relative; width:100%; max-width:500px; }
    .search-container input { width:100%; padding:.75rem 1rem .75rem 3rem; border-radius:50px; border:1px solid #ddd; font-size:1rem; transition:border var(--transition), box-shadow var(--transition); box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    .search-container input:focus { border-color:var(--clr-primary); box-shadow:0 4px 12px rgba(0,0,0,0.15); outline:none; }
    .search-icon { position:absolute; top:50%; left:1rem; transform:translateY(-50%); font-size:1.2rem; color:var(--clr-primary); pointer-events:none; }
    .search-suggestions { position:absolute; top:110%; left:0; right:0; background:#fff; border-radius:.5rem; box-shadow:0 4px 12px rgba(0,0,0,0.1); max-height:200px; overflow-y:auto; display:none; }
    .search-suggestions li { padding:.5rem 1rem; cursor:pointer; }
    .search-suggestions li:hover { background:var(--clr-bg); }

    /* Menu Grid */
    .menu-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1.5rem; padding:1.5rem 2rem 4rem; }
    .menu-card { background:var(--clr-card-bg); backdrop-filter:blur(8px); border-radius:.85rem; overflow:hidden; display:flex; flex-direction:column; transition:transform var(--transition), box-shadow var(--transition); }
    .menu-card:hover { transform:translateY(-4px); box-shadow:0 8px 24px rgba(0,0,0,0.12); }
    .menu-card img { width:100%; height:140px; object-fit:cover; filter:brightness(0.9); transition:filter var(--transition); }
    .menu-card:hover img { filter:brightness(1); }
    .menu-body { flex:1; padding:1rem; }
    .menu-body h3 { margin-bottom:.5rem; font-size:1.05rem; color:var(--clr-primary); }
    .menu-body p { font-size:.85rem; color:var(--clr-text); height:36px; overflow:hidden; }
    .menu-footer { padding:.75rem 1rem; display:flex; justify-content:space-between; align-items:center; border-top:1px solid #eee; }
    .price { font-weight:500; color:var(--clr-primary); }
    .view-btn { font-size:.85rem; padding:.4rem .8rem; border:1px solid var(--clr-primary); border-radius:50px; background:transparent; transition:all var(--transition); }
    .view-btn:hover { background:var(--clr-primary); color:#fff; }

    /* Modal */
    .modal-content { border:none; border-radius:1rem; overflow:hidden; }
    .modal-header { background:var(--clr-primary); color:#fff; border-bottom:none; padding:1rem 1.5rem; }
    .modal-body { padding:1.5rem; text-align:center; }
    .modal-body img { width:100%; border-radius:.5rem; margin-bottom:1rem; }

    /* Social Bar */
    .social-bar { position:fixed; bottom:0; left:0; width:100%; background:var(--clr-primary); color:#fff; display:flex; justify-content:center; gap:1.5rem; padding:.75rem 0; font-size:.9rem; }
    .social-bar a { color:#fff; transition:opacity var(--transition); }
    .social-bar a:hover { opacity:.7; }

    /* Mobile header tweaks */
    @media (max-width: 575.98px) {
      .header-inner {
        flex-direction: column;
        align-items: center;
        padding: 1rem;
        gap: 0.75rem;
      }
      .logo img {
        height: 56px;
        width: 56px;
      }
      .header-info {
        text-align: center;
      }
      .header-meta {
        flex-wrap: wrap;
        font-size: 0.8rem;
      }
      .header-meta .phone-second {
        display: none;
      }
    }
  </style>
</head>
<body>

  {{-- Header --}}
  <header>
    <div class="header-inner container">
      <div class="logo">
        <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/logo.svg') }}" alt="Logo">
      </div>

      <div class="header-info">
        <h1>{{ $cafeName }}</h1>
        <p class="fst-italic">{{ $tagline }}</p>
      </div>

      <div class="lang-switcher">
        <div class="dropdown">
          <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-globe"></i> {{ strtoupper($default_language) }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            @foreach($languages ?? [] as $lang)
              <li>
                <a class="dropdown-item {{ $lang['code']==$default_language?'active':'' }}"
                   href="{{ request()->fullUrlWithQuery(['lang'=>$lang['code']]) }}">
                  {{ strtoupper($lang['code']) }} — {{ $lang['name'] }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <div class="header-meta">
        @if($address)
          <span><i class="fas fa-location-dot"></i>{{ $address }}</span>
        @endif
        @if($phone1)
          <span><i class="fas fa-phone"></i>{{ $phone1 }}</span>
        @endif
        @if($phone2)
          <span class="phone-second"><i class="fas fa-phone"></i>{{ $phone2 }}</span>
        @endif
      </div>
    </div>
  </header>

  {{-- Search Bar --}}
  <div class="search-bar">
    <div class="search-container">
      <input id="menuSearch" type="search" placeholder="{{ __('Search café menu…') }}">
      <i class="fas fa-search search-icon"></i>
      <ul class="search-suggestions">
        <li>{{ __('Espresso') }}</li>
        <li>{{ __('Cappuccino') }}</li>
        <li>{{ __('Latte') }}</li>
      </ul>
    </div>
  </div>

  {{-- Floating Filter FAB --}}
  <div class="filter-fab" id="fab"><i class="fas fa-filter"></i></div>
  <div class="filter-panel" id="filterPanel">
    @foreach($categories as $cat)
      <button data-filter="{{ Str::slug($cat['name']) }}" class="{{ $loop->first?'active':'' }}">
        {{ $cat['name'] }}
      </button>
    @endforeach
  </div>

  {{-- Menu Grid --}}
  <section class="menu-grid container">
    @foreach($categories as $cat)
      @foreach($cat['items'] as $item)
        @php
          $slug = Str::slug($cat['name']);
          $price = number_format($item['price'],2).$currency;
          $sale  = $item['sale_price'] ? number_format($item['sale_price'],2).$currency : null;
          $img   = $item['image'] ?? asset('assets/img/menu/menuThumb1_1.png');
        @endphp
        <div class="menu-card" data-cat="{{ $slug }}">
          <img loading="lazy" src="{{ $img }}" alt="{{ $item['name'] }}">
          <div class="menu-body">
            <h3>{{ $item['name'] }}</h3>
            @if($item['description'])
              <p>{{ Str::limit($item['description'], 60) }}</p>
            @endif
          </div>
          <div class="menu-footer">
            <span class="price">
              @if($sale)
                <del>{{ $price }}</del> {{ $sale }}
              @else
                {{ $price }}
              @endif
            </span>
            <button class="view-btn"
                    data-name="{{ e($item['name']) }}"
                    data-img="{{ $img }}"
                    data-desc="{{ e($item['description'] ?? '') }}"
                    data-price="{!! $sale ? '<del>'.$price.'</del> '.$sale : $price !!}">
              {{ __('View') }}
            </button>
          </div>
        </div>
      @endforeach
    @endforeach
  </section>

  {{-- Item Modal --}}
  <div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <img id="modalImg" src="" alt="" class="mb-3">
          <p id="modalDesc"></p>
          <h4 id="modalPrice" class="mt-2"></h4>
        </div>
      </div>
    </div>
  </div>

  {{-- Social Bar --}}
  <div class="social-bar">
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-instagram"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
  </div>

  {{-- Footer --}}
  <footer class="text-center py-3 mt-5">
    &copy; {{ now()->year }} {{ $cafeName }} • {{ __('All rights reserved.') }}
  </footer>

  {{-- Scripts --}}
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    const modal = new bootstrap.Modal('#itemModal');
    // FAB toggle
    document.getElementById('fab').onclick = () => {
      const panel = document.getElementById('filterPanel');
      panel.style.display = panel.style.display === 'flex' ? 'none' : 'flex';
    };
    // Filter buttons
    document.querySelectorAll('.filter-panel button').forEach(btn => {
      btn.onclick = () => {
        document.querySelectorAll('.filter-panel button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const f = btn.dataset.filter;
        document.querySelectorAll('.menu-card').forEach(card => {
          card.style.display = card.dataset.cat === f ? 'flex' : 'none';
        });
      };
    });
    // Live search
    document.getElementById('menuSearch').oninput = e => {
      const q = e.target.value.toLowerCase();  
      document.querySelectorAll('.menu-card').forEach(c => {
        const text = (c.querySelector('h3').innerText + ' ' + (c.querySelector('p')?.innerText||'')).toLowerCase();
        c.style.display = text.includes(q) ? 'flex' : 'none';
      });
    };
    // View modal
    document.querySelectorAll('.view-btn').forEach(btn => {
      btn.onclick = () => {
        document.querySelector('#itemModal .modal-title').innerText = btn.dataset.name;
        document.getElementById('modalImg').src = btn.dataset.img;
        document.getElementById('modalDesc').innerText = btn.dataset.desc || '{{ __("No description available.") }}';
        document.getElementById('modalPrice').innerHTML = btn.dataset.price;
        modal.show();
      };
    });
  </script>
</body>
</html>
