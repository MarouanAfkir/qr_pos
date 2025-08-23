{{-- resources/views/tables.blade.php --}}
@php
    use Illuminate\Support\Str;

    /* ---------- Locale & helpers ---------- */
    $default_language = request('lang', app()->getLocale() ?: 'en');
    app()->setLocale($default_language);

    $restaurantName    = $restaurant['name'] ?? 'Restaurant';
    $logo              = $restaurant['logo'] ?? null;
    $tagline           = $restaurant['settings']['tagline'] ?? 'Fresh • Local • Delicious';
    $isRTL             = in_array(strtolower($default_language), ['ar','he','fa','ur']);

    /* Per-restaurant scoping (matches waiter/client) */
    $restaurantId  = $restaurant['id'] ?? null;
    $restaurantKey = $restaurantId !== null ? ('r' . $restaurantId) : Str::slug($restaurantName);

    /* Where your waiter page lives (adjust if needed) */
    $waiterUrl = url('/'); // e.g. route('waiter.index') if you have a named route
@endphp
<!DOCTYPE html>
<html lang="{{ $default_language }}" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurantName }} – {{ __('Table Layout') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --brand:#6F4E37;
            --brand-2:#C49A6C;
            --cream:#FBF7F2;
            --ink:#1f2937;
            --muted:#6b7280;
            --ring:rgba(196,154,108,.25);
            --chip:#fff7ea;
            --chip-b:#f2e4d3;
            --accent:#facc15;
            --danger:#ef4444;
            --success:#16a34a;
        }

        body{font-family:'Inter',system-ui,ui-sans-serif; background:var(--cream); color:var(--ink);}

        /* Hero */
        .hero{
            background:linear-gradient(135deg,#FFE9D1 0%, #E8F5E9 100%);
            border-bottom:1px solid #e3eee5;
            text-align:center; padding:.9rem 1rem;
        }
        .hero-inner{max-width:1100px;margin:0 auto;position:relative}
        .hero-tools{position:absolute; top:.6rem; {{ $isRTL ? 'left' : 'right' }}:.6rem;}
        .restaurant-logo-wrapper{
            width:94px;height:94px;margin:.15rem auto .35rem;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;
            box-shadow:0 4px 14px rgba(0,0,0,.12);border:3px solid #f6efe6;overflow:hidden
        }
        .restaurant-logo-wrapper img{width:82%;height:82%;object-fit:contain;border-radius:50%}
        .restaurant-name{font-family:'Playfair Display',serif;font-weight:800;margin:0;font-size:1.6rem}
        .tagline{color:#4f6c4f; font-style:italic; margin:.1rem 0 0; font-size:.95rem}

        /* Toolbar */
        .toolbar{position:sticky; top:0; z-index:40; background:rgba(255,255,255,.9); backdrop-filter:blur(6px); border-bottom:1px solid #efe6db}
        .toolbar .container{padding:.55rem 0}
        .toolbar .btn{border-radius:.65rem}
        .toolbar .form-range{max-width:260px}
        .mode-pill{border-radius:999px; padding:.25rem}

        /* Layout grid */
        .layout-wrap{max-width:1100px;margin:1rem auto;padding:0 1rem}
        .layout-grid{
            --tile: 110px; /* base size (updated by slider) */
            display:grid; grid-template-columns: repeat(auto-fill, minmax(var(--tile), 1fr));
            gap:.7rem;
            min-height:40vh;
        }

        .tile{
            background:#fff; border:2px solid var(--chip-b); border-radius:16px;
            box-shadow:0 2px 8px rgba(0,0,0,.04);
            padding:.6rem; display:flex; flex-direction:column; gap:.45rem;
            cursor:grab; user-select:none; position:relative;
        }
        .tile:active{cursor:grabbing}
        .tile.dragging{opacity:.6; transform:scale(.98)}
        .tile .head{display:flex; align-items:center; justify-content:space-between; gap:.4rem}
        .tile .label{
            font-weight:800; font-size:1rem; padding:.2rem .45rem; border-radius:.5rem; background:#fff7ee; border:1px solid var(--chip-b);
            min-width:2.8ch; text-align:center;
        }
        .tile .label[contenteditable="true"]{outline:0; box-shadow:0 0 0 4px var(--ring)}
        .tile .meta{font-size:.8rem; color:var(--muted)}
        .tile .actions{display:flex; gap:.35rem}
        .tile .actions .btn{padding:.2rem .45rem}

        .drop-indicator{
            outline:2px dashed var(--brand-2);
            outline-offset: -6px;
        }

        .footer-helper{max-width:1100px;margin:1rem auto 2rem; color:#6b7280; font-size:.92rem; padding:0 1rem}
        .kbd{border:1px solid #e5e7eb;border-bottom-width:2px;border-radius:.35rem;padding:.05rem .35rem;background:#fff;font-weight:700}
    </style>
</head>
<body>

    {{-- ===== HERO ===== --}}
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-tools">
                <a class="btn btn-sm btn-outline-dark" href="{{ $waiterUrl }}?lang={{ $default_language }}">
                    <i class="fa-solid fa-arrow-left me-1"></i>{{ __('Back to Waiter') }}
                </a>
            </div>

            <div class="restaurant-logo-wrapper">
                <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/logo.svg') }}" alt="Logo">
            </div>
            <h1 class="restaurant-name">{{ $restaurantName }}</h1>
            <p class="tagline">{{ $tagline }}</p>
        </div>
    </section>

    {{-- ===== TOOLBAR ===== --}}
    <div class="toolbar">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2">
                <div class="btn-group mode-pill" role="group" aria-label="{{ __('Mode') }}">
                    <input type="radio" class="btn-check" name="mode" id="modeSelect" autocomplete="off" checked>
                    <label class="btn btn-outline-success" for="modeSelect"><i class="fa-solid fa-hand-pointer me-1"></i>{{ __('Select') }}</label>

                    <input type="radio" class="btn-check" name="mode" id="modeReorder" autocomplete="off">
                    <label class="btn btn-outline-primary" for="modeReorder"><i class="fa-solid fa-up-down-left-right me-1"></i>{{ __('Reorder') }}</label>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <label class="form-label mb-0"><i class="fa-solid fa-table-cells-large me-1"></i>{{ __('Tile size') }}</label>
                    <input id="sizeSlider" type="range" min="90" max="180" value="110" class="form-range">
                </div>

                <div class="input-group input-group-sm" style="width: 200px;">
                    <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                    <input id="tableCount" type="number" min="1" max="200" step="1" class="form-control" placeholder="{{ __('Count') }}">
                    <button id="applyCount" class="btn btn-outline-secondary">{{ __('Apply') }}</button>
                </div>

                <button id="addTable" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-plus me-1"></i>{{ __('Add Table') }}</button>
                <button id="resetLayout" class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-rotate me-1"></i>{{ __('Reset Order') }}</button>

                <div class="ms-auto"></div>

                <button id="saveLayout" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-floppy-disk me-1"></i>{{ __('Save Layout') }}
                </button>
                <button id="exportLayout" class="btn btn-sm btn-outline-dark">
                    <i class="fa-solid fa-code me-1"></i>{{ __('Export JSON') }}
                </button>
            </div>
        </div>
    </div>

    {{-- ===== LAYOUT GRID ===== --}}
    <div class="layout-wrap">
        <div id="grid" class="layout-grid" aria-label="{{ __('Tables') }}"></div>
    </div>

    <div class="footer-helper">
        <p class="mb-1">
            <strong>{{ __('How it works') }}:</strong>
            <span class="ms-1">{{ __('Use') }} <span class="kbd">Select</span> {{ __('to open a table in waiter mode. Switch to') }} <span class="kbd">Reorder</span> {{ __('to drag & drop and change the layout.') }}</span>
        </p>
        <p class="mb-0">
            <i class="fa-regular fa-lightbulb me-1"></i>
            {{ __('Everything is saved per restaurant, locally. Later we can plug the Save action into your SaaS API.') }}
        </p>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        const RESTAURANT_KEY = @json($restaurantKey);
        const LANG           = @json($default_language);
        const WAITER_URL     = @json($waiterUrl); // adjust if needed

        // Namespaced keys (no leakage across restaurants)
        const LAYOUT_KEY  = 'tableLayout:'  + RESTAURANT_KEY;  // [{id,label}, ...] in current order
        const TILESIZE_KEY= 'tableTileSize:'+ RESTAURANT_KEY;  // number
        const CURRENT_TABLE_KEY = 'currentTable:' + RESTAURANT_KEY;

        // DOM
        const grid       = document.getElementById('grid');
        const sizeSlider = document.getElementById('sizeSlider');
        const tableCount = document.getElementById('tableCount');
        const applyCount = document.getElementById('applyCount');
        const addTable   = document.getElementById('addTable');
        const resetBtn   = document.getElementById('resetLayout');
        const saveBtn    = document.getElementById('saveLayout');
        const exportBtn  = document.getElementById('exportLayout');
        const modeSelect = document.getElementById('modeSelect');
        const modeReorder= document.getElementById('modeReorder');

        /* ===== Storage helpers ===== */
        function loadLayout(){
            try { return JSON.parse(localStorage.getItem(LAYOUT_KEY) || 'null'); } catch(e){ return null; }
        }
        function saveLayout(arr){
            localStorage.setItem(LAYOUT_KEY, JSON.stringify(arr));
        }
        function setTileSize(v){
            grid.style.setProperty('--tile', v+'px');
            sizeSlider.value = v;
            localStorage.setItem(TILESIZE_KEY, String(v));
        }
        function getTileSize(){
            const v = parseInt(localStorage.getItem(TILESIZE_KEY)||'110',10);
            return Math.min(240, Math.max(70, v || 110));
        }

        /* ===== Layout model ===== */
        let layout = loadLayout();
        if(!Array.isArray(layout) || !layout.length){
            // default to 20 tables
            layout = Array.from({length:20}, (_,i)=>({ id: String(i+1), label: 'T'+(i+1) }));
            saveLayout(layout);
        }

        // initial tile size
        setTileSize(getTileSize());

        // Count input reflects current number
        tableCount.value = String(layout.length);

        /* ===== Render ===== */
        function render(){
            grid.innerHTML = '';
            layout.forEach((t, idx) => {
                const div = document.createElement('div');
                div.className = 'tile';
                div.setAttribute('draggable', modeReorder.checked ? 'true' : 'false');
                div.dataset.id = t.id;

                div.innerHTML = `
                    <div class="head">
                        <div class="label" role="textbox" aria-label="{{ __('Table label') }}" contenteditable="false">${t.label}</div>
                        <div class="actions">
                            <button class="btn btn-sm btn-outline-secondary rename" title="{{ __('Rename') }}"><i class="fa-solid fa-i-cursor"></i></button>
                            <button class="btn btn-sm btn-outline-danger remove" title="{{ __('Remove') }}"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                    <div class="meta"><i class="fa-solid fa-hashtag me-1"></i>${t.id}</div>
                `;

                // Select mode: click to open waiter with this table pre-selected
                div.addEventListener('click', (e) => {
                    if(modeReorder.checked) return; // ignore in reorder mode
                    const target = e.target;
                    if(target.closest('.actions')) return; // ignore clicks on buttons
                    localStorage.setItem(CURRENT_TABLE_KEY, String(t.id));
                    // Navigate to waiter page carrying lang as well
                    window.location.href = WAITER_URL + '?lang=' + encodeURIComponent(LANG);
                });

                // Rename
                const renameBtn = div.querySelector('.rename');
                const labelEl   = div.querySelector('.label');
                renameBtn.addEventListener('click', () => {
                    const active = labelEl.getAttribute('contenteditable') === 'true';
                    if(active){
                        // turn off & save
                        labelEl.setAttribute('contenteditable', 'false');
                        labelEl.blur();
                    } else {
                        labelEl.setAttribute('contenteditable', 'true');
                        // place caret at end
                        const range = document.createRange();
                        range.selectNodeContents(labelEl);
                        range.collapse(false);
                        const sel = window.getSelection();
                        sel.removeAllRanges(); sel.addRange(range);
                        labelEl.focus();
                    }
                });
                labelEl.addEventListener('blur', ()=> {
                    labelEl.setAttribute('contenteditable','false');
                    const txt = (labelEl.textContent || '').trim();
                    const newLabel = txt || ('T'+t.id);
                    labelEl.textContent = newLabel;
                    const i = layout.findIndex(x=>x.id===t.id);
                    if(i>-1){ layout[i].label = newLabel; saveLayout(layout); }
                });
                labelEl.addEventListener('keydown', (ev)=>{
                    if(ev.key==='Enter'){ ev.preventDefault(); labelEl.blur(); }
                });

                // Remove
                div.querySelector('.remove').addEventListener('click', (ev)=>{
                    ev.stopPropagation();
                    if(!confirm(`{{ __('Remove table') }} ${t.label}?`)) return;
                    layout = layout.filter(x => x.id !== t.id);
                    // Re-sequence IDs? keep IDs stable; only count changes.
                    saveLayout(layout);
                    tableCount.value = String(layout.length);
                    render();
                });

                // Drag & drop (Reorder mode)
                div.addEventListener('dragstart', (e)=>{
                    if(!modeReorder.checked) { e.preventDefault(); return; }
                    div.classList.add('dragging');
                    e.dataTransfer.setData('text/plain', t.id);
                    e.dataTransfer.effectAllowed = 'move';
                });
                div.addEventListener('dragend', ()=> div.classList.remove('dragging'));
                div.addEventListener('dragover', (e)=>{
                    if(!modeReorder.checked) return;
                    e.preventDefault();
                    const dragging = grid.querySelector('.tile.dragging');
                    if(!dragging) return;
                    const after = getDragAfterElement(grid, e.clientX, e.clientY);
                    grid.classList.add('drop-indicator');
                    if(after == null) {
                        grid.appendChild(dragging);
                    } else {
                        grid.insertBefore(dragging, after);
                    }
                });
                div.addEventListener('dragleave', ()=> grid.classList.remove('drop-indicator'));
                div.addEventListener('drop', (e)=>{
                    if(!modeReorder.checked) return;
                    e.preventDefault();
                    grid.classList.remove('drop-indicator');
                    persistOrderFromDOM();
                });

                grid.appendChild(div);
            });
        }

        function getDragAfterElement(container, x, y){
            const elements = [...container.querySelectorAll('.tile:not(.dragging)')];
            let closest = null;
            let closestOffset = Number.NEGATIVE_INFINITY;
            for(const child of elements){
                const box = child.getBoundingClientRect();
                // Compute offset so we know where to insert relative to centers
                const offset = (y - (box.top + box.height/2)) + (x - (box.left + box.width/2)) * 0.001; // mostly vertical feel
                if(offset < 0 && offset > closestOffset){
                    closestOffset = offset;
                    closest = child;
                }
            }
            return closest;
        }

        function persistOrderFromDOM(){
            const ids = [...grid.querySelectorAll('.tile')].map(el => el.dataset.id);
            const byId = Object.fromEntries(layout.map(t => [t.id, t]));
            layout = ids.map(id => byId[id]).filter(Boolean);
            saveLayout(layout);
        }

        // Initial render
        render();

        /* ===== Controls ===== */

        // Mode toggle => enable/disable draggable
        function syncMode(){
            const draggable = modeReorder.checked ? 'true' : 'false';
            grid.querySelectorAll('.tile').forEach(el => el.setAttribute('draggable', draggable));
        }
        modeSelect.addEventListener('change', syncMode);
        modeReorder.addEventListener('change', syncMode);

        // Tile size
        sizeSlider.addEventListener('input', ()=> setTileSize(+sizeSlider.value));

        // Apply count (adds or trims tables at the end)
        applyCount.addEventListener('click', ()=>{
            let target = parseInt(tableCount.value || '0', 10);
            if(isNaN(target) || target < 1) target = 1;
            const current = layout.length;

            if(target === current) return;

            if(target > current){
                const maxId = layout.reduce((m,t)=> Math.max(m, +t.id), 0);
                const toAdd = target - current;
                for(let i=1;i<=toAdd;i++){
                    const id = String(maxId + i);
                    layout.push({ id, label: 'T'+id });
                }
            } else {
                // Trim from the end (safe if they changed their mind)
                layout = layout.slice(0, target);
            }
            saveLayout(layout);
            render();
        });

        // Add one
        addTable.addEventListener('click', ()=>{
            const maxId = layout.reduce((m,t)=> Math.max(m, +t.id), 0);
            const id = String(maxId + 1);
            layout.push({ id, label: 'T'+id });
            tableCount.value = String(layout.length);
            saveLayout(layout);
            render();
        });

        // Reset to natural order (by numeric id)
        resetBtn.addEventListener('click', ()=>{
            layout.sort((a,b)=> (+a.id) - (+b.id));
            saveLayout(layout);
            render();
        });

        // Save (for now: local only; plug your API later)
        saveBtn.addEventListener('click', ()=>{
            saveLayout(layout);
            // Visual feedback
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fa-solid fa-check me-1"></i>{{ __('Saved') }}';
            setTimeout(()=>{
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i>{{ __('Save Layout') }}';
            }, 1200);
        });

        // Export JSON (copy to clipboard)
        exportBtn.addEventListener('click', async ()=>{
            const payload = {
                restaurant_key: RESTAURANT_KEY,
                tilesize: getTileSize(),
                layout
            };
            const text = JSON.stringify(payload, null, 2);
            try {
                await navigator.clipboard.writeText(text);
                exportBtn.innerHTML = '<i class="fa-solid fa-clipboard-check me-1"></i>{{ __('Copied') }}';
                setTimeout(()=> exportBtn.innerHTML = '<i class="fa-solid fa-code me-1"></i>{{ __('Export JSON') }}', 1200);
            } catch(e){
                // Fallback: open a prompt
                window.prompt('{{ __('Copy the JSON') }}:', text);
            }
        });

        // Keyboard: Enter on focused tile label (when not editing) => open waiter
        grid.addEventListener('keydown', (e)=>{
            if(e.key === 'Enter' && !modeReorder.checked){
                const tile = e.target.closest('.tile');
                if(tile){
                    const id = tile.dataset.id;
                    localStorage.setItem(CURRENT_TABLE_KEY, String(id));
                    window.location.href = WAITER_URL + '?lang=' + encodeURIComponent(LANG);
                }
            }
        });
    </script>
</body>
</html>
