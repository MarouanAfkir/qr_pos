<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Back-Office · Sign in</title>

  <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

  <!-- Fonts (Inter for UI, Playfair Display for brand title) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Playfair+Display:wght@800&display=swap" rel="stylesheet">

  <style>
    :root{
      --brand:#0f8b4c;
      --brand-600:#0b6b3e;
      --ring:rgba(15,139,76,.22);
      --ink:#1f2937;
      --muted:#6b7280;
      --card:#ffffff;
      --line:#e6f3ea;
      --soft:#f4fbf6;
      --chip:#f7fcf9;
    }

    html,body{height:100%}
    body{
      font-family:"Inter", system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      color:var(--ink);
      background:
        radial-gradient(1200px 300px at 100% -10%, rgba(34,197,94,.08), transparent 60%),
        radial-gradient(800px 220px at -10% 110%, rgba(34,197,94,.05), transparent 60%),
        var(--soft);
    }

    .auth-wrap{
      min-height:100%;
      display:grid;
      place-items:center;
      padding:24px;
    }
    .auth-card{
      width:min(95vw, 940px);
      border:1px solid var(--line);
      border-radius:18px;
      background:var(--card);
      box-shadow:0 24px 60px rgba(0,0,0,.08);
      overflow:hidden;
    }

    .auth-grid{
      display:grid;
      grid-template-columns: 1.1fr .9fr; /* left hero | right form */
    }
    @media (max-width: 900px){
      .auth-grid{ grid-template-columns: 1fr; }
      .hero{ display:none; }
    }

    /* Left: Hero / Brand */
    .hero{
      padding:28px;
      background:linear-gradient(135deg, #eefaf3 0%, #ffffff 100%);
      border-right:1px solid var(--line);
    }
    .brand-row{
      display:flex;align-items:center;gap:12px;
    }
    .logo-ring{
      width:64px;height:64px;border-radius:50%;
      background:#fff;border:3px solid #eef8f1;
      display:grid;place-items:center;overflow:hidden;
      box-shadow:0 6px 14px rgba(0,0,0,.08)
    }
    .logo-ring img{width:86%;height:86%;object-fit:contain;border-radius:50%}
    .brand-title{
      display:flex;flex-direction:column;
    }
    .brand-title h1{
      font-family:"Playfair Display", ui-serif, Georgia, serif;
      font-size:1.4rem;font-weight:800;line-height:1;margin:0
    }
    .brand-chip{
      display:inline-flex;align-items:center;gap:.45rem;
      margin-top:.45rem;
      background:var(--chip);
      border:1px solid var(--line);
      border-radius:999px;padding:.2rem .6rem;
      font-weight:800;font-size:.8rem
    }

    /* KPI chips to hint Orders / Payments / Dashboards */
    .kpis{
      display:grid;gap:.6rem;margin-top:16px;
      grid-template-columns: repeat(3, minmax(0,1fr));
    }
    .kpi{
      border:1px solid var(--line);
      background:#fff;border-radius:12px;
      padding:.6rem .7rem;
    }
    .kpi .label{color:var(--muted);font-size:.8rem}
    .kpi .value{font-weight:800;font-size:1.05rem;margin-top:.15rem}
    .kpi i{opacity:.8;margin-right:.4rem}

    /* Feature bullets */
    .hero-points{
      margin-top:14px;color:var(--muted);font-size:.95rem
    }
    .hero-points li{margin:.35rem 0}

    /* Right: Form */
    .pane{ padding:28px; }
    .pane-head{
      display:flex;align-items:center;justify-content:space-between;margin-bottom:12px
    }
    .pane h3{margin:0;font-weight:900;letter-spacing:.01em}
    .help-mini{font-size:.9rem;color:var(--muted)}

    .input-label{font-weight:700;margin-bottom:.35rem}
    .input-wrap{ position:relative; }
    .input-wrap .fa{
      position:absolute;inset-inline-start:12px;top:50%;transform:translateY(-50%);
      color:#9ca3af;pointer-events:none
    }
    .form-control{
      padding-inline-start:38px;
      border:1.5px solid var(--line);
      background:#fff;border-radius:12px;height:46px;
      font-size:0.98rem;
    }
    .form-control:focus{
      border-color:#cde8d5;
      box-shadow:0 0 0 6px var(--ring);
      outline:0;
    }

    .form-check-input{ border:1.5px solid var(--line) }

    .btn-main{
      background:var(--brand);border:none;color:#fff;
      border-radius:12px;height:48px;font-weight:800;
      box-shadow:0 12px 28px rgba(15,139,76,.22)
    }
    .btn-main:hover{ background:var(--brand-600) }

    .alert-min{
      border:1px solid #fde2e2;background:#fff5f5;color:#991b1b;
      border-radius:10px;padding:.55rem .8rem;font-size:.95rem
    }

    .legal{
      margin-top:14px;color:var(--muted);font-size:.85rem;text-align:center
    }
    .link-muted{ color:var(--muted); text-decoration:none }
    .link-muted:hover{ text-decoration:underline }

    /* Focus for links */
    a:focus-visible{ outline:3px solid var(--ring);outline-offset:3px;border-radius:8px }

    /* Numeric alignment (nice for KPIs) */
    .tabular{ font-variant-numeric: tabular-nums; font-feature-settings: "tnum" 1, "lnum" 1; }
  </style>
</head>
<body>
  <div class="auth-wrap">
    <div class="auth-card">
      <div class="auth-grid">
        <!-- Left: brand / hero -->
        <aside class="hero">
          <div class="brand-row">
            <div class="logo-ring">
              <img src="{{ asset('assets/img/logo/logo.svg') }}" alt="Logo">
            </div>
            <div class="brand-title">
              <h1>{{ config('app.name', 'Restaurant') }}</h1>
              <span class="brand-chip">
                <i class="fa-solid fa-bolt"></i> POS Back-Office
              </span>
            </div>
          </div>

          <!-- mini KPIs to set the tone: Orders, Payments, Dashboards -->
          <div class="kpis tabular">
            <div class="kpi">
              <div class="label"><i class="fa-solid fa-receipt"></i>Orders</div>
              <div class="value">Manage tickets & holds</div>
            </div>
            <div class="kpi">
              <div class="label"><i class="fa-solid fa-credit-card"></i>Payments</div>
              <div class="value">Cash • Card • Other</div>
            </div>
            <div class="kpi">
              <div class="label"><i class="fa-solid fa-chart-line"></i>Dashboards</div>
              <div class="value">Sales & KPIs</div>
            </div>
          </div>

          <ul class="hero-points list-unstyled">
            <li><i class="fa-solid fa-circle-check text-success me-2"></i>Track orders & audit payment history</li>
            <li><i class="fa-solid fa-circle-check text-success me-2"></i>Visual dashboards for sales, items & staff</li>
          </ul>
        </aside>

        <!-- Right: sign-in form -->
        <section class="pane">
          <div class="pane-head">
            <h3>Sign in</h3>
            <span class="help-mini">
              <i class="fa-regular fa-life-ring me-1"></i>
              Need access? Contact your admin
            </span>
          </div>

          @if (session('status'))
            <div class="alert alert-success py-2">{{ session('status') }}</div>
          @endif

          @if ($errors->any())
            <div class="alert-min mb-2">
              {{ $errors->first() }}
            </div>
          @endif

          <form method="POST" action="{{ route('admin.login') }}" novalidate>
            @csrf

            <div class="mb-3">
              <label class="input-label" for="email">Email</label>
              <div class="input-wrap">
                <i class="fa fa-envelope"></i>
                <input id="email" class="form-control" name="email" type="email"
                       value="{{ old('email') }}" required autofocus
                       autocomplete="username" placeholder="you@restaurant.com">
              </div>
            </div>

            <div class="mb-3">
              <label class="input-label" for="password">Password</label>
              <div class="input-wrap">
                <i class="fa fa-lock"></i>
                <input id="password" class="form-control" name="password" type="password"
                       required autocomplete="current-password" placeholder="••••••••">
              </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
              </div>
              @if (Route::has('password.request'))
                <a class="link-muted" href="{{ route('password.request') }}">Forgot password?</a>
              @endif
            </div>

            <button class="btn btn-main w-100" type="submit">
              <i class="fa-solid fa-right-to-bracket me-1"></i> Sign in
            </button>

            <div class="legal">
              <small>Protected area • Staff only</small>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
