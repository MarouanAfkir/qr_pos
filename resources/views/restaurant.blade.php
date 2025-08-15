{{-- resources/views/restaurant-orders.blade.php --}}
@php
  $restaurantName = $restaurant['name'] ?? 'Restaurant';
  $logo           = $restaurant['logo'] ?? null;
  $currency       = ' DH';
  $restaurantId   = $restaurant['id'] ?? null;
  $restaurantKey  = $restaurantId !== null ? ('r' . $restaurantId) : \Illuminate\Support\Str::slug($restaurantName);
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>{{ $restaurantName }} — Orders (MVP)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Fonts & UI -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700;800&display=swap" rel="stylesheet" />
  <!-- QR Scanner -->
  <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.10/html5-qrcode.min.js"></script>

  <style>
    :root{
      --brand:#6F4E37;      /* coffee brand */
      --brand-2:#C49A6C;
      --cream:#FBF7F2;
      --ink:#1f2937;
      --muted:#667085;
      --good:#16a34a;
      --warn:#f59e0b;
      --bad:#ef4444;
      --ring:rgba(196,154,108,.25);
      --border:#efe6db;
      --radius:16px;
    }
    html{scroll-behavior:smooth}
    body{font-family:'Inter',system-ui,Segoe UI,Roboto,Helvetica,Arial;background:var(--cream);color:var(--ink)}
    .topbar{
      position:sticky;top:0;z-index:20;background:#fff;border-bottom:1px solid var(--border);
      display:flex;gap:.8rem;align-items:center;justify-content:space-between;padding:.6rem .9rem
    }
    .brand{display:flex;align-items:center;gap:.6rem;font-weight:800}
    .brand img{height:36px;width:auto;border-radius:8px;border:1px solid var(--border)}
    .stat-pill{display:inline-flex;align-items:center;gap:.45rem;background:#fff;border:1px solid var(--border);border-radius:999px;padding:.25rem .6rem;font-weight:700}
    .stat-pill .dot{width:8px;height:8px;border-radius:50%}
    .dot-new{background:var(--warn)} .dot-prog{background:var(--brand)} .dot-ready{background:var(--good)}

    .wrap{padding:14px}
    @media(min-width:992px){
      .wrap{padding:18px}
      .layout{display:grid;grid-template-columns: 410px 1fr;gap:14px;align-items:start}
    }

    /* Left: Scan & Intake */
    .card-soft{
      background:#fff;border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 10px 24px rgba(0,0,0,.06)
    }
    .card-soft .card-header{padding:.8rem .9rem;border-bottom:1px solid var(--border);background:#fff9f2;border-top-left-radius:var(--radius);border-top-right-radius:var(--radius)}
    .card-soft .card-body{padding:.9rem}
    .help{font-size:.85rem;color:var(--muted)}
    #reader{border:1px dashed #e5e7eb;border-radius:12px;overflow:hidden}
    .btn-outline{
      border:1px solid var(--brand-2);color:#6b4b2f;background:#fff;border-radius:10px;
      padding:.45rem .8rem;font-weight:700
    }
    .btn-outline:hover{background:#fff7ea}
    .btn-primary{background:var(--brand);border-color:var(--brand)}
    .btn-success{background:var(--good);border-color:var(--good)}
    .btn-warning{background:var(--warn);border-color:var(--warn)}
    .btn-danger{background:var(--bad);border-color:var(--bad)}

    /* Right: Orders board */
    .toolbar{display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;justify-content:space-between;margin-bottom:.6rem}
    .tabs .btn{border-radius:999px}
    .order{
      background:#fff;border:1px solid var(--border);border-radius:14px;padding:.75rem .8rem;margin-bottom:.7rem;
      display:flex;gap:.75rem;align-items:flex-start
    }
    .badge-soft{border:1px solid var(--border);background:#fff;border-radius:999px;padding:.1rem .45rem;font-weight:700}
    .itemline{display:flex;align-items:center;justify-content:space-between;gap:.5rem}
    .itemline small{color:var(--muted)}
    .actions .btn{border-radius:10px}
    .status-tag{font-weight:800}
    .status-new{color:#92400e}
    .status-progress{color:#065f46}
    .status-ready{color:#1f2937}
    .status-picked{color:#1f2937;opacity:.7}
    .status-canceled{color:#991b1b}

    /* Modal */
    .modal-header{background:#fff9f2;border-bottom:1px solid var(--border)}
    .ticket{
      border:1px dashed #d1d5db;border-radius:10px;padding:.75rem;background:#fff
    }
    .ticket h6{font-weight:800;margin:0 0 .35rem}
    .ticket .line{display:flex;justify-content:space-between;gap:.5rem}
    .ticket .muted{color:#6b7280}
    @media print{
      body *{visibility:hidden}
      #printArea, #printArea *{visibility:visible}
      #printArea{position:absolute;left:0;top:0;width:100%}
    }
  </style>
</head>
<body>

  <!-- Topbar -->
  <div class="topbar">
    <div class="brand">
      <img src="{{ $logo ? asset($logo) : asset('assets/img/logo/logo.svg') }}" alt="">
      <div>{{ $restaurantName }} — <span class="text-muted">Orders</span></div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="stat-pill"><span class="dot dot-new"></span> <span id="countNew">0</span> New</span>
      <span class="stat-pill"><span class="dot dot-prog"></span> <span id="countProg">0</span> In progress</span>
      <span class="stat-pill"><span class="dot dot-ready"></span> <span id="countReady">0</span> Ready</span>
    </div>
  </div>

  <div class="wrap">
    <div class="layout">
      <!-- LEFT: Scanner / Intake -->
      <div class="card-soft">
        <div class="card-header d-flex align-items-center justify-content-between">
          <strong><i class="fa-solid fa-qrcode me-1"></i> Scanner</strong>
          <div class="d-flex gap-2">
            <button class="btn btn-outline btn-sm" id="btnStart"><i class="fa-solid fa-play me-1"></i>Start</button>
            <button class="btn btn-outline btn-sm" id="btnStop"><i class="fa-solid fa-stop me-1"></i>Stop</button>
          </div>
        </div>
        <div class="card-body">
          <div id="reader" style="width:100%;max-width:100%"></div>
          <div class="row g-2 mt-2">
            <div class="col-7">
              <input type="file" id="filePicker" accept="image/*" class="form-control form-control-sm">
              <div class="help mt-1">Upload a QR image if the camera isn’t available.</div>
            </div>
            <div class="col-5 d-grid">
              <button class="btn btn-outline btn-sm" id="btnPasteJson"><i class="fa-solid fa-code me-1"></i>Paste JSON</button>
            </div>
          </div>

          <!-- Paste JSON modal -->
          <div class="modal fade" id="pasteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title"><i class="fa-solid fa-code me-1"></i> Paste order JSON</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <textarea id="jsonText" class="form-control" rows="8" placeholder='{"v":1,"type":"delivery_partner",...}'></textarea>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-primary" id="btnInjectJson">Add order</button>
                </div>
              </div>
            </div>
          </div>

          <hr class="my-3">
          <div class="help">
            When a courier arrives, scan their QR (from agent mode). We’ll create the order instantly — no phone call needed.
          </div>
        </div>
      </div>

      <!-- RIGHT: Orders board -->
      <div>
        <div class="toolbar">
          <div class="tabs btn-group" role="group" aria-label="Filters">
            <button class="btn btn-outline btn-sm active" data-filter="new">New</button>
            <button class="btn btn-outline btn-sm" data-filter="progress">In progress</button>
            <button class="btn btn-outline btn-sm" data-filter="ready">Ready</button>
            <button class="btn btn-outline btn-sm" data-filter="picked">Picked up</button>
            <button class="btn btn-outline btn-sm" data-filter="canceled">Canceled</button>
            <button class="btn btn-outline btn-sm" data-filter="all">All</button>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-outline btn-sm" id="btnKitchen"><i class="fa-solid fa-display me-1"></i>Kitchen view</button>
            <button class="btn btn-outline btn-sm" id="btnClearDone"><i class="fa-solid fa-broom me-1"></i>Clear old</button>
          </div>
        </div>

        <div id="orders"></div>
        <div id="empty" class="text-center text-muted py-5" style="display:none;">
          <i class="fa-regular fa-rectangle-list mb-2" style="font-size:2rem;"></i><br>
          No orders yet. Scan a QR to get started.
        </div>
      </div>
    </div>
  </div>

  <!-- Order Modal -->
  <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <span id="omCode">#</span> • <span id="omStatus" class="status-tag"></span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-lg-7">
              <div class="ticket" id="printArea">
                <h6>{{ $restaurantName }}</h6>
                <div class="muted mb-2" id="omWhen"></div>
                <div class="line"><div><strong>Pickup in</strong></div><div id="omEta"></div></div>
                <div class="line"><div><strong>Payment</strong></div><div id="omPay"></div></div>
                <hr>
                <div id="omItems"></div>
                <hr>
                <div class="line"><div><strong>Total</strong></div><div id="omTotal"></div></div>
                <div id="omNotes" class="mt-2"></div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="card-soft">
                <div class="card-body">
                  <div class="mb-2"><strong>Agent</strong><div id="omAgent" class="help"></div></div>
                  <div class="mb-2"><strong>Customer</strong><div id="omCustomer" class="help"></div></div>
                  <div class="mb-2"><strong>History</strong><div id="omHistory" class="help"></div></div>
                  <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-success" id="actAccept"><i class="fa-solid fa-check me-1"></i>Accept / Start</button>
                    <button class="btn btn-warning" id="actReady"><i class="fa-solid fa-bell me-1"></i>Mark Ready</button>
                    <button class="btn btn-primary" id="actPicked"><i class="fa-solid fa-handshake me-1"></i>Picked up</button>
                    <button class="btn btn-danger" id="actCancel"><i class="fa-solid fa-xmark me-1"></i>Cancel</button>
                    <button class="btn btn-outline" id="actPrint"><i class="fa-solid fa-print me-1"></i>Print ticket</button>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- row -->
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    const CURRENCY = @json($currency);
    const STORAGE  = 'rOrders:{{ $restaurantKey }}';
    let FILTER = 'new';
    let ORDERS = [];

    function nowISO(){ return new Date().toISOString(); }
    function fmtTime(ts){ try{ return new Date(ts).toLocaleString(); }catch(e){ return ts; } }
    function load(){ try{ ORDERS = JSON.parse(localStorage.getItem(STORAGE)||'[]'); }catch(e){ ORDERS=[]; } }
    function save(){ localStorage.setItem(STORAGE, JSON.stringify(ORDERS)); }

    function upsertOrder(payload){
      // Basic schema check
      if(!payload || !payload.items || typeof payload.sum !== 'number' || !payload.code){
        alert('Invalid order QR'); return;
      }
      const id = payload.code + '_' + (payload.t || Date.now());
      let found = ORDERS.find(o => o.id === id);
      if(found){ found.payload = payload; } else {
        found = { id, status:'new', createdAt: Date.now(), history:[{at:nowISO(), action:'new'}], payload };
        ORDERS.unshift(found);
      }
      save(); render();
      toastNew(found);
    }

    function toastNew(o){
      // lightweight toast via title blink
      const title = document.title;
      document.title = '🔔 New order — ' + title;
      setTimeout(()=> document.title = title, 1500);
    }

    function setStatus(id, status){
      const o = ORDERS.find(x=>x.id===id); if(!o) return;
      o.status = status;
      o.history.push({at: nowISO(), action: status});
      save(); render();
    }

    function clearOld(){
      ORDERS = ORDERS.filter(o => !['picked','canceled'].includes(o.status));
      save(); render();
    }

    function asMoney(n){ return (Number(n).toFixed(2) + CURRENCY); }

    function render(){
      const el = document.getElementById('orders');
      const empty = document.getElementById('empty');
      el.innerHTML = '';

      // counters
      const cNew = ORDERS.filter(o=>o.status==='new').length;
      const cProg= ORDERS.filter(o=>o.status==='progress').length;
      const cReady=ORDERS.filter(o=>o.status==='ready').length;
      document.getElementById('countNew').textContent = cNew;
      document.getElementById('countProg').textContent = cProg;
      document.getElementById('countReady').textContent = cReady;

      let list = ORDERS.slice();
      if(FILTER!=='all') list = list.filter(o=>o.status===FILTER);

      if(!list.length){ empty.style.display='block'; return; }
      empty.style.display='none';

      list.forEach(o=>{
        const p = o.payload;
        const statusClass = {
          new:'status-new', progress:'status-progress', ready:'status-ready', picked:'', canceled:'status-canceled'
        }[o.status] || '';
        const agent = p.agent || {}, cust = p.customer || {};
        const itemsHTML = p.items.map(it=>`
          <div class="itemline">
            <div><strong>${it.name}</strong> <span class="badge-soft">×${it.qty}</span></div>
            <div class="small">${asMoney(it.total)}</div>
          </div>
        `).join('');

        const card = document.createElement('div');
        card.className = 'order';
        card.innerHTML = `
          <div class="flex-grow-1">
            <div class="d-flex justify-content-between">
              <div>
                <div class="small text-muted">#${p.code} • ${fmtTime(p.t || o.createdAt)}</div>
                <div class="${statusClass} status-tag text-uppercase small">${o.status}</div>
              </div>
              <div class="fw-bold">${asMoney(p.sum)}</div>
            </div>
            <div class="mt-2">${itemsHTML}</div>
            <div class="small text-muted mt-1">
              Agent: ${[agent.company, agent.name, agent.phone].filter(Boolean).join(' • ') || '-'}
              &nbsp;—&nbsp;
              Client: ${[cust.name, cust.phone].filter(Boolean).join(' • ')}
            </div>
          </div>
          <div class="actions d-flex flex-column gap-2">
            <button class="btn btn-outline btn-sm" data-open="${o.id}"><i class="fa-regular fa-eye"></i></button>
            ${o.status==='new' ? `<button class="btn btn-success btn-sm" data-accept="${o.id}">Accept</button>`:''}
            ${o.status==='progress' ? `<button class="btn btn-warning btn-sm" data-ready="${o.id}">Ready</button>`:''}
            ${o.status==='ready' ? `<button class="btn btn-primary btn-sm" data-picked="${o.id}">Picked</button>`:''}
            ${!['picked','canceled'].includes(o.status) ? `<button class="btn btn-danger btn-sm" data-cancel="${o.id}">Cancel</button>`:''}
          </div>
        `;
        el.appendChild(card);
      });

      // wire actions
      el.querySelectorAll('[data-accept]').forEach(b=> b.onclick=()=> setStatus(b.dataset.accept,'progress'));
      el.querySelectorAll('[data-ready]').forEach(b=> b.onclick=()=> setStatus(b.dataset.ready,'ready'));
      el.querySelectorAll('[data-picked]').forEach(b=> b.onclick=()=> setStatus(b.dataset.picked,'picked'));
      el.querySelectorAll('[data-cancel]').forEach(b=> b.onclick=()=> setStatus(b.dataset.cancel,'canceled'));
      el.querySelectorAll('[data-open]').forEach(b=> b.onclick=()=> openModal(b.dataset.open));
    }

    // Modal rendering
    let CURRENT_ID = null;
    function openModal(id){
      const o = ORDERS.find(x=>x.id===id); if(!o) return;
      CURRENT_ID = id;
      const p = o.payload;
      document.getElementById('omCode').textContent = '#' + p.code;
      document.getElementById('omStatus').textContent = o.status.toUpperCase();
      document.getElementById('omStatus').className = 'status-tag ' + ({
        new:'status-new', progress:'status-progress', ready:'status-ready', picked:'', canceled:'status-canceled'
      }[o.status] || '');
      document.getElementById('omWhen').textContent = fmtTime(p.t || o.createdAt);
      document.getElementById('omEta').textContent = (p.pickup_in_min || 15) + ' min';
      document.getElementById('omPay').textContent = p.payment || '-';

      document.getElementById('omItems').innerHTML = p.items.map(i=>`
        <div class="line"><div>${i.name} × ${i.qty}</div><div>${asMoney(i.total)}</div></div>
        ${i.sel && i.sel.length ? `<div class="muted" style="margin-left:.5rem">${i.sel.map(v=>`${v.name}: ${v.options.map(o=>o.n||o.name).join(', ')}`).join(' • ')}</div>`:''}
      `).join('');
      document.getElementById('omTotal').textContent = asMoney(p.sum);
      document.getElementById('omNotes').innerHTML = p.notes ? `<div><strong>Notes:</strong> ${p.notes}</div>` : '';

      const a = p.agent || {}, c = p.customer || {};
      document.getElementById('omAgent').textContent = [a.company,a.name,a.phone].filter(Boolean).join(' • ') || '-';
      document.getElementById('omCustomer').innerHTML = [c.name,c.phone].filter(Boolean).join(' • ') + (c.address? `<div class="muted">${(c.address+'').replace(/\n/g,'<br>')}</div>` : '');

      document.getElementById('omHistory').innerHTML = o.history.map(h=>`${h.action} — ${fmtTime(h.at)}`).join('<br>');

      // enable/disable actions
      const S = o.status;
      document.getElementById('actAccept').disabled = (S!=='new');
      document.getElementById('actReady').disabled  = (S!=='progress');
      document.getElementById('actPicked').disabled = (S!=='ready');
      document.getElementById('actCancel').disabled = (S==='picked' || S==='canceled');

      const m = new bootstrap.Modal(document.getElementById('orderModal'));
      m.show();
    }

    document.getElementById('actAccept').onclick = ()=> { if(CURRENT_ID) setStatus(CURRENT_ID,'progress'); };
    document.getElementById('actReady').onclick  = ()=> { if(CURRENT_ID) setStatus(CURRENT_ID,'ready'); };
    document.getElementById('actPicked').onclick = ()=> { if(CURRENT_ID) setStatus(CURRENT_ID,'picked'); };
    document.getElementById('actCancel').onclick = ()=> { if(CURRENT_ID) setStatus(CURRENT_ID,'canceled'); };
    document.getElementById('actPrint').onclick  = ()=> { window.print(); };

    // Filters
    document.querySelectorAll('[data-filter]').forEach(b=>{
      b.addEventListener('click', ()=>{
        document.querySelectorAll('[data-filter]').forEach(x=>x.classList.remove('active'));
        b.classList.add('active');
        FILTER = b.getAttribute('data-filter');
        render();
      });
    });
    document.getElementById('btnClearDone').onclick = clearOld;
    document.getElementById('btnKitchen').onclick = ()=>{
      // simple “kitchen view”: filter to progress+ready and zoom in a bit
      FILTER = 'progress';
      document.querySelector('[data-filter="progress"]').click();
      document.body.style.zoom = 1.15;
      setTimeout(()=> document.body.style.zoom = 1, 600000); // reset after 10min
    };

    // Scanner setup
    let html5Qr = null;
    async function startScanner(){
      try{
        if(html5Qr){ await html5Qr.start({ facingMode: "environment" }, { fps: 10, qrbox: {width: 260, height: 260} }, onScan); return; }
        html5Qr = new Html5Qrcode("reader");
        await html5Qr.start({ facingMode: "environment" }, { fps: 10, qrbox: {width: 260, height: 260} }, onScan);
      }catch(e){
        console.warn(e);
        // fallback: show file picker hint
      }
    }
    async function stopScanner(){ try{ await html5Qr?.stop(); }catch(e){} }

    function onScan(text){
      try{
        const payload = JSON.parse(text);
        upsertOrder(payload);
      }catch(e){
        // ignore non-JSON scans
      }
    }

    document.getElementById('btnStart').onclick = startScanner;
    document.getElementById('btnStop').onclick  = stopScanner;

    // Image file scan
    document.getElementById('filePicker').addEventListener('change', async (e)=>{
      const f = e.target.files?.[0]; if(!f || !html5Qr) return;
      try{
        const result = await html5Qr.scanFile(f, true);
        onScan(result);
      }catch(err){
        alert('Could not read QR from image.');
      }finally{
        e.target.value = '';
      }
    });

    // Paste JSON
    const pasteModal = new bootstrap.Modal(document.getElementById('pasteModal'));
    document.getElementById('btnPasteJson').onclick = ()=> pasteModal.show();
    document.getElementById('btnInjectJson').onclick = ()=>{
      const t = document.getElementById('jsonText').value.trim();
      try{
        const p = JSON.parse(t);
        upsertOrder(p);
        pasteModal.hide();
        document.getElementById('jsonText').value = '';
      }catch(e){ alert('Invalid JSON'); }
    };

    // Init
    load(); render();
    // optional: auto-start camera if HTTPS + permissions tend to work
    // startScanner();
  </script>
</body>
</html>
