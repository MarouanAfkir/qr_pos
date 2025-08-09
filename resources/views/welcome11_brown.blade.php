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
    $phone2    = $restaurant['phone_number_2'] ?? '';
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
      /* Coffee-forward palette (Mocha / Latte / Cream / Espresso) */
      --primary: #6F4E37; /* espresso brown */
      --accent:  #C49A6C; /* latte caramel */
      --light:   #FBF7F2; /* cream background */
      --dark:    #2D1E16; /* dark roast text */
      --ring:    rgba(196,154,108,.25);
      --chip:    rgba(196,154,108,.12);
    }
    * { box-sizing: border-box; }
    body { font-family: 'Montserrat', sans-serif; background: var(--light); color: var(--dark); margin:0; }

    /* Hero – compact header */
    .hero {
      position: relative;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: #fff;
      text-align: center;
      padding: 1.25rem 1rem 1rem;
      box-shadow: 0 2px 12px rgba(0,0,0,.15);
    }

    /* Language switcher (top-right) — custom themed dropdown */
    .hero .lang-switcher { position:absolute; top:.6rem; right:.6rem; }
    .hero .lang-switcher .btn {
      background: rgba(255,255,255,.18);
      border: 1px solid #fff; color:#fff;
      padding:.25rem .6rem; border-radius:50px; font-size:.9rem;
      transition: background .2s, border-color .2s;
    }
    .hero .lang-switcher .btn:hover { background: rgba(255,255,255,.35); border-color:#fff; }

    /* Better dropdown design (neutral white, soft shadow) */
    .hero .lang-switcher .dropdown-menu {
      border: none;
      border-radius:.75rem;
      background: #fff;
      box-shadow: 0 12px 30px rgba(0,0,0,.15);
      padding:.4rem;
      min-width: 12rem;
    }
    .hero .lang-switcher .dropdown-item {
      color: var(--dark);
      border-radius:.5rem;
      padding:.5rem .75rem;
      transition: background .15s, color .15s;
    }
    .hero .lang-switcher .dropdown-item:hover {
      background: var(--chip);
      color: var(--dark);
    }
    .hero .lang-switcher .dropdown-item.active,
    .hero .lang-switcher .dropdown-item:active {
      background: rgba(111,78,55,.18); /* primary tint */
      color: var(--dark);
      font-weight: 600;
    }

    /* Logo inspired by restaurant-logo-wrapper (bigger, centered, with border) */
    .restaurant-logo-wrapper{
      width:128px;height:128px;margin:0 auto .75rem;border-radius:50%;
      background:#fff;display:flex;align-items:center;justify-content:center;
      box-shadow:0 6px 18px rgba(0,0,0,.1);transition:.2s;
      border:3px solid rgba(255,255,255,.95); overflow:hidden;
    }
    .restaurant-logo-wrapper:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.12)}
    .restaurant-logo-wrapper img{
      width:86%;height:86%;object-fit:contain;border-radius:50%;
      display:block;
    }

    .hero h1 { font-family:'Playfair Display', serif; font-size:1.85rem; margin:.2rem 0 .15rem; }
    .hero p.lead { font-size:.98rem; opacity:.95; margin:0 0 .5rem; }

    .hero-meta {
      display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;
      font-size:.9rem; opacity:.95;
    }
    .hero-meta i { margin-right:.35rem; }

    /* Top Search */
    .top-search {
      padding: .75rem 1rem; text-align:center;
      background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.05);
    }
    .top-search input {
      width:100%; max-width:420px;
      padding:.55rem 1rem;
      border:2px solid var(--primary);
      border-radius:50px;
      font-size:1rem;
      outline:none;
      transition: box-shadow .2s, border-color .2s;
      background:#fff;
      color: var(--dark);
    }
    .top-search input::placeholder{ color:#8a7b73; }
    .top-search input:focus { box-shadow:0 0 0 6px var(--ring); border-color: var(--primary); }

    /* Categories strip */
    .cats {
      display:flex; overflow-x:auto; gap:.75rem; padding:.5rem 1rem 1rem; background:#fff;
    }
    .cats button {
      flex:0 0 auto; padding:.5rem 1rem; background:#fff;
      border:2px solid var(--primary); border-radius:50px; color:var(--primary);
      transition:.2s; white-space:nowrap;
    }
    .cats button.active, .cats button:hover { background:var(--primary); color:#fff; }

    /* Category sections (default view when nothing selected) */
    .sections-container { padding: 0 .75rem 1.25rem; }
    .cat-section { margin: 1.25rem 0; }
    .cat-header {
      display:flex; align-items:center; justify-content:space-between;
      padding: .35rem .5rem .35rem .75rem;
      margin: .25rem .25rem .5rem;
      background: #fff;
      border-left: 4px solid var(--primary);
      border-radius: .5rem;
      box-shadow: 0 2px 10px rgba(0,0,0,.06);
    }
    .cat-title {
      font-family:'Playfair Display', serif;
      font-size:1.2rem; margin:0; color: var(--dark);
    }
    .cat-count {
      background: var(--chip);
      color: var(--primary);
      border-radius: 999px;
      padding: .15rem .5rem;
      font-size:.8rem;
      font-weight: 600;
    }

    /* Menu grid */
    .menu-grid { display:grid; grid-template-columns: repeat(auto-fit,minmax(240px,1fr)); gap:1.1rem; padding:.35rem; }
    .card-menu {
      background:#fff; border:none; border-radius:.75rem; overflow:hidden;
      box-shadow:0 6px 18px rgba(0,0,0,.1); transition:transform .2s;
      display:flex; flex-direction:column;
    }
    .card-menu:hover { transform: translateY(-5px); }
    .card-menu img { height:160px; object-fit:cover; }
    .card-body { flex:1; padding:1rem; }
    .card-body h5 { font-family:'Playfair Display', serif; margin-bottom:.5rem; color:var(--dark); font-size:1.1rem; }
    .card-body p { font-size:.85rem; color:#6f625a; height:2.5em; overflow:hidden; margin:0; }
    .card-footer { background: #FFFDF9; padding:1rem; display:flex; justify-content:space-between; align-items:center; border-top:1px solid #f0e8df; }
    .price { font-weight:600; color:var(--primary); }
    .btn-order {
      background:var(--primary); color:#fff; border:none; padding:.5rem 1rem; border-radius:50px; font-size:.85rem; transition:.2s;
    }
    .btn-order:hover { background:#5C3F2E; }

    /* Modal – smaller, elegant image */
    .modal-header { background: var(--primary); color:#fff; border-bottom:none; }
    .modal-title { font-family:'Playfair Display', serif; font-size:1.5rem; }
    .modal-body { display:flex; align-items:flex-start; gap:1rem; padding:1.5rem; }
    .modal-body img {
      width:100px; height:100px; object-fit:cover; border-radius:.5rem; flex-shrink:0; box-shadow:0 4px 12px rgba(0,0,0,.1);
    }
    /* Make modal price coffee-brown like cards */
    #modalPrice { color: var(--primary); }

    .detail-item { margin-bottom:1rem; font-size:.95rem; color:#4b3f39; }
    .detail-item strong { color:var(--dark); }

    /* No results text */
    #noResults { display:none; text-align:center; color:#776a62; padding: 1rem 0 2rem; }

    footer { text-align:center; padding:1rem; font-size:.875rem; color:#6f625a; background:#fff; box-shadow: 0 -2px 8px rgba(0,0,0,.05); }
  </style>
</head>
<body>

  {{-- Hero --}}
  <section class="hero">
    {{-- Language Switcher --}}
    <div class="lang-switcher">
      <div class="dropdown">
        <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
          <i class="fa-solid fa-globe me-1"></i>{{ strtoupper($lang) }}
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

    {{-- Logo --}}
    <div class="restaurant-logo-wrapper">
      <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/logo.svg') }}" alt="Logo">
    </div>

    {{-- Title + tagline --}}
    <h1>{{ $name }}</h1>
    <p class="lead fst-italic">{{ $tagline }}</p>

    {{-- Address / phones --}}
    @if($address || $phone1 || $phone2)
      <div class="hero-meta mt-1">
        @if($address)
          <span><i class="fa-solid fa-location-dot"></i>{{ $address }}</span>
        @endif
        @if($phone1)
          <span><i class="fa-solid fa-phone"></i>{{ $phone1 }}</span>
        @endif
        @if($phone2)
          <span><i class="fa-solid fa-phone"></i>{{ $phone2 }}</span>
        @endif
      </div>
    @endif
  </section>

  {{-- Top Search --}}
  <div class="top-search">
    <input id="mainSearch" type="text" placeholder="{{ __('Search the menu…') }}">
  </div>

  {{-- Categories --}}
  <div class="cats">
    @foreach($categories as $cat)
      {{-- No preselected category (no 'active' class) --}}
      <button data-filter="{{ Str::slug($cat['name']) }}">
        {{ $cat['name'] }}
      </button>
    @endforeach
  </div>

  {{-- Category Sections (default view) --}}
  <div class="sections-container" id="menuSections">
    @foreach($categories as $cat)
      @php
        $slug = Str::slug($cat['name']);
        $items = $cat['items'] ?? [];
      @endphp
      @if(count($items))
      <section class="cat-section" data-cat="{{ $slug }}">
        <div class="cat-header">
          <h3 class="cat-title">{{ $cat['name'] }}</h3>
          <span class="cat-count">{{ count($items) }}</span>
        </div>
        <div class="menu-grid">
          @foreach($items as $item)
            @php
              $price = number_format($item['price'],2).$currency;
              $sale  = $item['sale_price'] ? number_format($item['sale_price'],2).$currency : null;
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
                    <del class="text-muted me-1">{{ $price }}</del> <span>{{ $sale }}</span>
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
        </div>
      </section>
      @endif
    @endforeach
  </div>

  <div id="noResults">{{ __('No items match your search.') }}</div>

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
            <h4 id="modalPrice" class="mb-4"></h4>
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
    const sections = Array.from(document.querySelectorAll('.cat-section'));
    const catButtons = Array.from(document.querySelectorAll('.cats button'));
    const searchInput = document.getElementById('mainSearch');
    const noResultsEl = document.getElementById('noResults');

    function showAllSections() {
      sections.forEach(s => s.style.display = '');
      noResultsEl.style.display = 'none';
    }

    function filterByCategory(slug) {
      sections.forEach(s => {
        s.style.display = (s.dataset.cat === slug) ? '' : 'none';
      });
      noResultsEl.style.display = 'none';
    }

    function filterBySearch(query) {
      let anyVisible = false;
      const q = query.trim().toLowerCase();

      sections.forEach(section => {
        const cards = Array.from(section.querySelectorAll('.card-menu'));
        let visibleInSection = 0;

        cards.forEach(card => {
          const name = card.querySelector('h5')?.innerText.toLowerCase() || '';
          const desc = card.querySelector('p')?.innerText.toLowerCase() || '';
          const match = name.includes(q) || desc.includes(q);
          card.style.display = match ? 'flex' : 'none';
          if (match) visibleInSection++;
        });

        section.style.display = visibleInSection ? '' : 'none';
        anyVisible = anyVisible || visibleInSection > 0;
      });

      noResultsEl.style.display = anyVisible ? 'none' : 'block';
    }

    // Category filter (toggle selection)
    catButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const isActive = btn.classList.contains('active');
        catButtons.forEach(b => b.classList.remove('active'));

        if (isActive) { // already active -> clear selection
          showAllSections();
          return;
        }

        btn.classList.add('active');
        searchInput.value = ''; // clear search when picking a category
        filterByCategory(btn.dataset.filter);
      });
    });

    // Main search (clears category selection while typing)
    searchInput.addEventListener('input', e => {
      const q = e.target.value;
      if (q.length) catButtons.forEach(b => b.classList.remove('active'));
      if (!q.length) {
        const activeBtn = catButtons.find(b => b.classList.contains('active'));
        if (activeBtn) filterByCategory(activeBtn.dataset.filter);
        else showAllSections();
        return;
      }
      filterBySearch(q);
    });

    // Modal logic (Composition + only extra-priced options)
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
          if (!v.options) return;
          const extra = v.options.find(o => parseFloat(o.price_adjustment) > 0);
          if (extra) {
            html += `<div class="detail-item"><strong>${v.name}:</strong> <strong>+${parseFloat(extra.price_adjustment).toFixed(2)}{{ $currency }}</strong></div>`;
          }
        });
        document.getElementById('modalExtras').innerHTML = html;

        modal.show();
      });
    });

    // Initial state: show all sections (no category selected)
    showAllSections();
  </script>
</body>
</html>
