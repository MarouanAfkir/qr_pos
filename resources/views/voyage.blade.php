<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <!-- ========= META ========= -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Rihla Travel — Circuits au Maroc avec packs Essential, Comfort et Premium. Réservation simple, calcul du total et envoi WhatsApp." />
  <meta name="theme-color" content="#0BA5B5" />
  <title>Rihla Travel — Circuits & Réservations</title>
  <link rel="shortcut icon" href="{{ asset('assets/travel/favicon.png') }}">

  <!-- ========= FONTS & CSS ========= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    /* ============================================================
       Teal & Sand palette + airy, travel-centric UI
    ============================================================ */
    :root{
      --brand:#0BA5B5;       /* teal */
      --brand-600:#0A8A99;   /* deeper teal */
      --brand-700:#086E7A;   /* hover accent */

      --sand:#FFF1D6;        /* sand wash */
      --dune:#FDF7E2;        /* very light sand */
      --bg:#F7FBFD;          /* misty sky */

      --ink:#0f172a;
      --muted:#667085;
      --surface:#ffffff;
      --surface-2:#F3FAFC;
      --border:#E6F1F4;
      --ring:rgba(11,165,181,.28);

      --radius:18px;
      --shadow-1:0 6px 18px rgba(2,6,23,.05);
      --shadow-2:0 16px 34px rgba(2,6,23,.10);
    }

    html{scroll-behavior:smooth}
    body{
      font-family:'Manrope',system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
      color:var(--ink);
      background:
        radial-gradient(900px 480px at 80% -10%, rgba(11,165,181,.10), transparent 60%),
        var(--bg);
      overflow-x:hidden;
    }
    h1,h2,h3,h4,h5,h6{font-family:'Inter',sans-serif;letter-spacing:-.015em;font-weight:800}
    .text-muted{color:var(--muted)!important}
    a{color:var(--brand)}
    a:hover{color:var(--brand-700)}

    /* ===== NAVBAR ===== */
    .navbar{
      position:sticky; top:0; z-index:1040;
      background:rgba(255,255,255,.86);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom:1px solid var(--border);
      transition: box-shadow .25s ease, padding .2s ease, background .25s ease;
      padding:.7rem 0;
    }
    .navbar.scrolled{
      background:#fff;
      box-shadow:0 10px 28px rgba(0,0,0,.06);
      padding:.45rem 0;
    }
    .navbar .navbar-brand strong{font-weight:800; letter-spacing:.2px}
    .navbar .nav-link{
      font-weight:600; padding:.45rem .8rem; border-radius:999px; color:var(--ink);
    }
    .navbar .nav-link:hover,.navbar .nav-link:focus{
      background:rgba(11,165,181,.10);
      color:var(--ink);
    }

    /* ===== BUTTONS / FORMS (unified theme) ===== */
    .btn{border-radius:12px;font-weight:700}
    .btn-primary{
      --bs-btn-bg:var(--brand);
      --bs-btn-border-color:var(--brand);
      --bs-btn-hover-bg:var(--brand-600);
      --bs-btn-hover-border-color:var(--brand-600);
      box-shadow:0 12px 20px rgba(11,165,181,.18);
    }
    .btn-outline-primary{
      --bs-btn-color:var(--brand);
      --bs-btn-border-color:var(--brand);
      --bs-btn-hover-color:#fff;
      --bs-btn-hover-bg:var(--brand);
      --bs-btn-hover-border-color:var(--brand);
      background:transparent;
    }
    .btn-soft{
      background:rgba(11,165,181,.10);
      border:1px solid rgba(11,165,181,.28);
      color:var(--brand);
    }
    .btn-soft:hover{background:rgba(11,165,181,.16); color:var(--brand-700)}

    .form-control,.form-select{
      border-radius:12px;
      border-color:var(--border);
      background:var(--surface);
    }
    .form-control:focus,.form-select:focus{
      border-color:var(--brand);
      box-shadow:0 0 0 .25rem var(--ring);
    }
    .form-check-input:checked{
      background-color:var(--brand);
      border-color:var(--brand);
    }
    .form-check-input:focus{
      box-shadow:0 0 0 .25rem var(--ring);
      border-color:var(--brand);
    }

    /* ===== HERO / SEARCH ===== */
    .hero{
      padding:56px 0 36px;
      background: linear-gradient(135deg, var(--dune) 0%, var(--sand) 100%);
      border-bottom:1px solid var(--border);
    }
    .search-panel{
      background:#fff; border:1px solid var(--border); border-radius:16px; padding:1rem 1rem 1.2rem; box-shadow:var(--shadow-1);
    }
    .hero-badges .badge{
      background:#fff; border:1px solid var(--border); color:var(--brand);
      font-weight:700; border-radius:999px;
    }

    /* ===== TOUR TILES (flattened, no nested cards) ===== */
    .tour-tile{
      border:1px solid var(--border);
      border-radius:16px;
      background:#fff;
      height:100%;
      overflow:hidden;
      box-shadow:var(--shadow-1);
      transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease;
      display:flex; flex-direction:column;
    }
    .tour-tile:hover{ transform:translateY(-3px); box-shadow:var(--shadow-2); border-color:#d9eef3; }
    .tile-cover{position:relative; aspect-ratio:16/10; overflow:hidden}
    .tile-cover img{width:100%; height:100%; object-fit:cover; display:block; transform:scale(1.01)}
    .tile-cover::after{
      content:""; position:absolute; inset:0;
      background:linear-gradient(180deg, rgba(0,0,0,.0) 45%, rgba(0,0,0,.28) 100%);
    }
    .tile-pill{
      position:absolute; top:12px; left:12px;
      display:inline-flex; align-items:center; gap:.35rem;
      background:rgba(255,255,255,.95); border:1px solid var(--border);
      color:var(--brand); font-weight:700; padding:.25rem .6rem; border-radius:999px;
    }
    .tile-body{padding:1rem 1rem .75rem}
    .tile-meta{
      color:var(--muted); font-size:.92rem;
      display:flex; align-items:center; gap:.8rem; flex-wrap:wrap;
    }
    .tile-meta i{opacity:.9}
    .tile-highlights{
      display:flex; gap:.6rem; flex-wrap:wrap; margin:.6rem 0 .2rem 0;
    }
    .chip{
      border:1px solid var(--border);
      padding:.15rem .5rem;
      border-radius:999px;
      font-size:.8rem; color:#0b5861; background:rgba(11,165,181,.06);
    }
    .tile-footer{
      margin-top:auto; padding:.75rem 1rem 1rem;
      border-top:1px dashed var(--border);
      display:flex; align-items:center; justify-content:space-between; gap:.8rem; flex-wrap:wrap;
    }
    .price{font-weight:800}

    /* ===== PACKS ===== */
    .pack-card{
      background:#fff; border:1px solid var(--border); border-radius:16px; padding:1rem; height:100%; box-shadow:var(--shadow-1);
    }
    .pack-card h6{font-weight:800}
    .pack-badge{background:linear-gradient(90deg, var(--brand), #6AD6E2); color:#fff; border-radius:8px; padding:.2rem .5rem; font-size:.8rem}

    /* ===== BOOKING MODAL ===== */
    .modal-content{border-radius:18px; border:1px solid var(--border)}
    .summary{
      background:var(--surface-2); border:1px dashed var(--border); border-radius:12px; padding:.9rem;
    }
    .summary .line{display:flex; justify-content:space-between; font-size:.95rem; margin:.2rem 0}
    .summary .total{font-size:1.15rem; font-weight:800}

    /* ===== FOOTER ===== */
    .site-footer{ background:var(--surface); border-top:1px solid var(--border); }

    /* ===== MOBILE CTA ===== */
    .mobile-cta{
      position:fixed; left:0; right:0; bottom:0; z-index:1050;
      display:none; gap:.7rem; align-items:center; justify-content:space-between;
      padding:.7rem .9rem; background:var(--surface); border-top:1px solid var(--border);
      box-shadow:0 -8px 24px rgba(0,0,0,.08);
    }
    @media (max-width: 991.98px){ .mobile-cta{ display:flex } }
  </style>
</head>

<body>
  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-expand-lg" id="siteNav" aria-label="Navigation principale">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <img src="{{ asset('assets/travel/logo.png') }}" alt="Rihla Travel" height="40">
        <strong>Rihla Travel</strong>
      </a>
      <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Ouvrir le menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
          <li class="nav-item"><a class="nav-link" href="#search">Rechercher</a></li>
          <li class="nav-item"><a class="nav-link" href="#tours">Circuits</a></li>
          <li class="nav-item"><a class="nav-link" href="#packs">Nos packs</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item ms-1"><a href="tel:+212612345678" class="btn btn-outline-primary"><i class="bi bi-telephone"></i> +212 6 12 34 56 78</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ===== HERO / SEARCH ===== -->
  <header id="search" class="hero">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <h1 class="display-5 mb-3">Découvrez le Maroc autrement</h1>
          <p class="lead text-muted">Réservez vos circuits avec des packs adaptés à votre budget : <strong>Essential</strong>, <strong>Comfort</strong> ou <strong>Premium</strong>.</p>
          <div class="hero-badges d-flex flex-wrap gap-2">
            <span class="badge"><i class="bi bi-shield-check"></i> Paiement sécurisé (optionnel)</span>
            <span class="badge"><i class="bi bi-translate"></i> FR • AR • EN</span>
            <span class="badge"><i class="bi bi-whatsapp"></i> Devis WhatsApp</span>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="search-panel">
            <form id="searchForm" class="row g-2" action="#tours" method="get">
              <div class="col-12">
                <label class="form-label small fw-bold">Destination</label>
                <input class="form-control" list="destinations" name="q" placeholder="Ex: Merzouga, Chefchaouen, Marrakech" />
                <datalist id="destinations">
                  <option value="Désert de Merzouga"></option>
                  <option value="Chefchaouen"></option>
                  <option value="Villes Impériales"></option>
                  <option value="Essaouira"></option>
                </datalist>
              </div>
              <div class="col-6">
                <label class="form-label small fw-bold">Date</label>
                <input type="date" id="dateSearch" class="form-control" name="d" required>
              </div>
              <div class="col-6">
                <label class="form-label small fw-bold">Voyageurs</label>
                <select class="form-select" name="pax">
                  <option value="2" selected>2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label small fw-bold">Pack</label>
                <select class="form-select" name="pack">
                  <option value="comfort" selected>Comfort</option>
                  <option value="essential">Essential</option>
                  <option value="premium">Premium</option>
                </select>
              </div>
              <div class="col-12 d-grid">
                <button class="btn btn-primary btn-lg" type="submit"><i class="bi bi-search"></i> Rechercher</button>
              </div>
              <div class="col-12 small text-muted text-center">Annulation gratuite J-7*</div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- ===== TOURS LIST (FLAT TILES) ===== -->
  <section id="tours" class="py-5">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="m-0">Circuits populaires</h2>
        <a href="#packs" class="btn btn-soft"><i class="bi bi-card-checklist"></i> Voir les packs</a>
      </div>

      @php
        // ------- Démo catalogue (remplacez par vos données) -------
        $tours = [
          [
            'slug' => 'merzouga-3j',
            'title' => 'Désert de Merzouga — 3 jours',
            'duration' => '3J/2N',
            'from' => 'Marrakech',
            'cover' => asset('assets/travel/merzouga.jpg'),
            'badge' => 'Départs garantis',
            'highlights' => ['Erg Chebbi', 'Bivouac berbère', 'Coucher de soleil'],
            'packs' => ['essential' => 890, 'comfort' => 1290, 'premium' => 1890], // MAD / adulte
          ],
          [
            'slug' => 'chefchaouen-1j',
            'title' => 'Chefchaouen — 1 jour',
            'duration' => '1J',
            'from' => 'Tanger',
            'cover' => asset('assets/travel/chefchaouen.jpg'),
            'badge' => 'Idéal week-end',
            'highlights' => ['Médina bleue', 'Ras El Maa', 'Panoramas Rif'],
            'packs' => ['essential' => 390, 'comfort' => 520, 'premium' => 790],
          ],
          [
            'slug' => 'imperiales-7j',
            'title' => 'Villes impériales — 7 jours',
            'duration' => '7J/6N',
            'from' => 'Casablanca',
            'cover' => asset('assets/travel/imperiales.jpg'),
            'badge' => 'Top familles',
            'highlights' => ['Rabat', 'Fès', 'Marrakech', 'Volubilis'],
            'packs' => ['essential' => 3490, 'comfort' => 4590, 'premium' => 6290],
          ],
          [
            'slug' => 'essaouira-2j',
            'title' => 'Essaouira — 2 jours',
            'duration' => '2J/1N',
            'from' => 'Marrakech',
            'cover' => asset('assets/travel/essaouira.jpg'),
            'badge' => 'Relax & mer',
            'highlights' => ['Skala', 'Port', 'Plage'],
            'packs' => ['essential' => 790, 'comfort' => 1090, 'premium' => 1590],
          ],
        ];
      @endphp

      <div class="row g-4">
        @foreach($tours as $tour)
          <div class="col-md-6 col-lg-4">
            <article class="tour-tile" aria-label="Circuit {{ $tour['title'] }}">
              <div class="tile-cover">
                <img src="{{ $tour['cover'] }}" alt="{{ $tour['title'] }}">
                <span class="tile-pill"><i class="bi bi-stars"></i> {{ $tour['badge'] }}</span>
              </div>

              <div class="tile-body">
                <h5 class="mb-1">{{ $tour['title'] }}</h5>
                <div class="tile-meta mb-2">
                  <span><i class="bi bi-clock"></i> {{ $tour['duration'] }}</span>
                  <span><i class="bi bi-geo-alt"></i> Départ {{ $tour['from'] }}</span>
                </div>
                <div class="tile-highlights">
                  @foreach($tour['highlights'] as $h)
                    <span class="chip">{{ $h }}</span>
                  @endforeach
                </div>
              </div>

              <div class="tile-footer">
                <div>
                  <div class="text-muted small">À partir de</div>
                  <div class="price h5 m-0">{{ number_format($tour['packs']['comfort'], 0, ',', ' ') }} <span class="small">MAD / adulte</span></div>
                </div>
                <div class="d-flex gap-2">
                  <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#bookingModal"
                    data-slug="{{ $tour['slug'] }}"
                    data-title="{{ $tour['title'] }}"
                    data-base-essential="{{ $tour['packs']['essential'] }}"
                    data-base-comfort="{{ $tour['packs']['comfort'] }}"
                    data-base-premium="{{ $tour['packs']['premium'] }}"
                    >
                    <i class="bi bi-calendar-check"></i> Réserver
                  </button>
                  <a href="https://wa.me/212612345678?text=Bonjour%2C%20je%20souhaite%20des%20infos%20sur%20{{ urlencode($tour['title']) }}" target="_blank" class="btn btn-soft" aria-label="WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                  </a>
                </div>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ===== PACKS EXPLAINER ===== -->
  <section id="packs" class="py-5" style="background:var(--surface-2)">
    <div class="container">
      <div class="text-center mb-4">
        <h2>Choisissez votre pack</h2>
        <p class="section-sub text-muted">Trois niveaux pour s’adapter à votre style de voyage.</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="pack-card h-100">
            <div class="d-flex align-items-center justify-content-between">
              <h6 class="mb-0">Essential</h6>
              <span class="pack-badge">Budget malin</span>
            </div>
            <ul class="mt-2 small m-0 ps-3">
              <li>Hébergement 3★ ou maison d’hôtes</li>
              <li>Transport climatisé partagé</li>
              <li>Petits-déjeuners inclus</li>
              <li>Assistance WhatsApp</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <div class="pack-card h-100">
            <div class="d-flex align-items-center justify-content-between">
              <h6 class="mb-0">Comfort</h6>
              <span class="pack-badge">Meilleur choix</span>
            </div>
            <ul class="mt-2 small m-0 ps-3">
              <li>Hébergement 4★ / riads sélectionnés</li>
              <li>Transport climatisé privé</li>
              <li>PDJ + 1 dîner typique</li>
              <li>Guide local FR/AR selon étapes</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <div class="pack-card h-100">
            <div class="d-flex align-items-center justify-content-between">
              <h6 class="mb-0">Premium</h6>
              <span class="pack-badge">Expérience</span>
            </div>
            <ul class="mt-2 small m-0 ps-3">
              <li>Hôtels 5★ / tentes luxe au désert</li>
              <li>Chauffeur privé + accueil aéroport</li>
              <li>Deux dîners & activités incluses</li>
              <li>Assurance & support prioritaire</li>
            </ul>
          </div>
        </div>
      </div>
      <p class="small text-muted mt-3 text-center">Les inclusions peuvent varier selon le circuit. Détail fourni sur le devis.</p>
    </div>
  </section>

  <!-- ===== CONTACT / FOOTER ===== -->
  <footer class="site-footer pt-5" id="contact">
    <div class="container pb-4">
      <div class="row g-4">
        <div class="col-lg-5">
          <h5>Parlons de votre voyage</h5>
          <p class="small text-muted">Besoin d’un circuit sur-mesure ? Écrivez-nous ou contactez-nous sur WhatsApp.</p>
          <div class="d-flex gap-2">
            <a class="btn btn-outline-primary" href="mailto:hello@rihla.travel"><i class="bi bi-envelope"></i> hello@rihla.travel</a>
            <a class="btn btn-primary" target="_blank" href="https://wa.me/212612345678"><i class="bi bi-whatsapp"></i> WhatsApp</a>
          </div>
        </div>
        <div class="col-lg-3">
          <h6 class="fw-bold mb-3">Agence</h6>
          <ul class="list-unstyled small m-0">
            <li class="mb-2"><i class="bi bi-geo-alt"></i> Casablanca, Maroc</li>
            <li class="mb-2"><i class="bi bi-clock"></i> Lun–Sam 9:00–19:00</li>
            <li class="mb-2"><i class="bi bi-telephone"></i> +212 6 12 34 56 78</li>
          </ul>
        </div>
        <div class="col-lg-4">
          <h6 class="fw-bold mb-3">Newsletter</h6>
          <form id="newsletterForm" class="d-flex gap-2">
            <input type="email" required class="form-control" placeholder="Votre email">
            <button class="btn btn-primary" type="submit">S’inscrire</button>
          </form>
          <div id="newsletterMsg" class="small mt-2" aria-live="polite"></div>
        </div>
      </div>
      <hr class="my-4" style="border-color:var(--border)">
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between pb-3">
        <p class="small text-muted mb-2 mb-md-0">© 2025 Rihla Travel. Tous droits réservés.</p>
        <div class="d-flex align-items-center gap-3">
          <a href="#search" class="btn btn-outline-primary btn-sm" id="toTopBtn"><i class="bi bi-arrow-up"></i> Haut de page</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- ===== MOBILE CTA ===== -->
  <div class="mobile-cta">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-geo-alt"></i>
      <span class="small">Prêt à réserver ?</span>
    </div>
    <a href="#tours" class="btn btn-primary btn-sm">Voir les circuits</a>
  </div>

  <!-- ===== BOOKING MODAL ===== -->
  <div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <form id="bookingForm" method="POST" action="/bookings">
          @csrf
          <div class="modal-header">
            <div>
              <h5 class="modal-title" id="bkTitle">Réserver</h5>
              <div class="small text-muted" id="bkSubtitle">Choisissez la date, le pack et les options</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>

          <div class="modal-body">
            <input type="hidden" name="tour_slug" id="tourSlug">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label small fw-bold">Date de départ</label>
                <input type="date" id="bkDate" name="date" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label small fw-bold">Adultes</label>
                <select id="bkAdults" name="adults" class="form-select">
                  @for($i=1;$i<=10;$i++)
                    <option value="{{ $i }}" {{ $i===2?'selected':'' }}>{{ $i }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label small fw-bold">Enfants (&lt;12 ans)</label>
                <select id="bkChildren" name="children" class="form-select">
                  @for($i=0;$i<=6;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>

              <div class="col-12">
                <label class="form-label small fw-bold d-block mb-1">Pack</label>
                <div class="d-flex flex-wrap gap-3">
                  <input type="hidden" id="priceEssential">
                  <input type="hidden" id="priceComfort">
                  <input type="hidden" id="pricePremium">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="pack" id="packEssential" value="essential">
                    <label class="form-check-label" for="packEssential">Essential <span class="text-muted small" id="lblEssential"></span></label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="pack" id="packComfort" value="comfort" checked>
                    <label class="form-check-label" for="packComfort">Comfort <span class="text-muted small" id="lblComfort"></span></label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="pack" id="packPremium" value="premium">
                    <label class="form-check-label" for="packPremium">Premium <span class="text-muted small" id="lblPremium"></span></label>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <label class="form-label small fw-bold d-block mb-1">Options</label>
                <div class="row g-2">
                  <div class="col-md-4">
                    <div class="form-check border rounded p-2">
                      <input class="form-check-input" type="checkbox" value="120" id="optTransfer" name="extras[]" />
                      <label class="form-check-label" for="optTransfer">
                        Transfert aéroport <span class="text-muted small">(MAD 120 / pers.)</span>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-check border rounded p-2">
                      <input class="form-check-input" type="checkbox" value="80" id="optInsurance" name="extras[]" />
                      <label class="form-check-label" for="optInsurance">
                        Assurance voyage <span class="text-muted small">(MAD 80 / pers.)</span>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-check border rounded p-2">
                      <input class="form-check-input" type="checkbox" value="350" id="optGuide" name="extras[]" />
                      <label class="form-check-label" for="optGuide">
                        Guide privé <span class="text-muted small">(MAD 350 / pers.)</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-bold">Nom & prénom</label>
                <input type="text" name="name" class="form-control" required placeholder="Votre nom complet">
              </div>
              <div class="col-md-3">
                <label class="form-label small fw-bold">Téléphone (WhatsApp)</label>
                <input type="tel" name="phone" class="form-control" required placeholder="+212...">
              </div>
              <div class="col-md-3">
                <label class="form-label small fw-bold">Email</label>
                <input type="email" name="email" class="form-control" required placeholder="vous@exemple.com">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold">Ville de prise en charge</label>
                <input type="text" name="pickup_city" class="form-control" placeholder="Ex: Marrakech, Casablanca...">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold">Message (optionnel)</label>
                <input type="text" name="message" class="form-control" placeholder="Précisions, vols, allergies...">
              </div>

              <div class="col-12">
                <div class="summary">
                  <div class="line"><span>Tarif adulte</span><span id="sumAdult">—</span></div>
                  <div class="line"><span>Tarif enfant (&times; 60%)</span><span id="sumChild">—</span></div>
                  <div class="line"><span>Options</span><span id="sumExtras">—</span></div>
                  <div class="line total"><span>Total estimé</span><span id="sumTotal">—</span></div>
                  <input type="hidden" name="total_mad" id="totalMad">
                </div>
                <div class="small text-muted mt-1">Aucun paiement immédiat requis. Confirmation par email/WhatsApp. Paiement en ligne (CMI/Stripe) disponible en offre Pro.</div>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex flex-wrap gap-2 justify-content-between">
            <a id="whatsappDraft" target="_blank" class="btn btn-soft"><i class="bi bi-whatsapp"></i> Demander sur WhatsApp</a>
            <div class="ms-auto d-flex gap-2">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
              <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle"></i> Confirmer la réservation</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ========= SCRIPTS ========= -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    const MAD = new Intl.NumberFormat('fr-MA', { style:'currency', currency:'MAD', maximumFractionDigits:0 });

    // Navbar shrink
    window.addEventListener('scroll', () => {
      const nav = document.getElementById('siteNav');
      if (window.scrollY > 8) nav?.classList.add('scrolled'); else nav?.classList.remove('scrolled');
    });

    // Search date min = today
    function setTodayMin(input){
      const t = new Date();
      const yyyy = t.getFullYear();
      const mm = String(t.getMonth()+1).padStart(2,'0');
      const dd = String(t.getDate()).padStart(2,'0');
      const today = `${yyyy}-${mm}-${dd}`;
      input.min = today;
      if(!input.value) input.value = today;
    }
    window.addEventListener('load', () => {
      setTodayMin(document.getElementById('dateSearch'));
    });

    // ------- Booking modal logic -------
    const bookingModal = document.getElementById('bookingModal');
    const bkTitle = document.getElementById('bkTitle');
    const bkSubtitle = document.getElementById('bkSubtitle');
    const tourSlug = document.getElementById('tourSlug');
    const bkDate = document.getElementById('bkDate');
    const lblEssential = document.getElementById('lblEssential');
    const lblComfort = document.getElementById('lblComfort');
    const lblPremium = document.getElementById('lblPremium');
    const priceEssential = document.getElementById('priceEssential');
    const priceComfort = document.getElementById('priceComfort');
    const pricePremium = document.getElementById('pricePremium');

    const sumAdult = document.getElementById('sumAdult');
    const sumChild = document.getElementById('sumChild');
    const sumExtras = document.getElementById('sumExtras');
    const sumTotal = document.getElementById('sumTotal');
    const totalMad = document.getElementById('totalMad');
    const whatsappDraft = document.getElementById('whatsappDraft');

    function setTodayMinBk(input){
      const t = new Date();
      const yyyy = t.getFullYear();
      const mm = String(t.getMonth()+1).padStart(2,'0');
      const dd = String(t.getDate()).padStart(2,'0');
      const today = `${yyyy}-${mm}-${dd}`;
      input.min = today;
      if(!input.value) input.value = today;
    }

    bookingModal?.addEventListener('show.bs.modal', ev => {
      const btn = ev.relatedTarget;
      const title = btn.getAttribute('data-title');
      const slug = btn.getAttribute('data-slug');

      const pE = Number(btn.getAttribute('data-base-essential'));
      const pC = Number(btn.getAttribute('data-base-comfort'));
      const pP = Number(btn.getAttribute('data-base-premium'));

      bkTitle.textContent = 'Réserver — ' + title;
      bkSubtitle.textContent = 'Choisissez la date, le pack et les options';
      tourSlug.value = slug;

      priceEssential.value = pE;
      priceComfort.value = pC;
      pricePremium.value = pP;

      lblEssential.textContent = `(${MAD.format(pE)} / adulte)`;
      lblComfort.textContent   = `(${MAD.format(pC)} / adulte)`;
      lblPremium.textContent   = `(${MAD.format(pP)} / adulte)`;

      // Default date from search
      const searchDate = document.getElementById('dateSearch');
      setTodayMinBk(bkDate);
      if (searchDate?.value) bkDate.value = searchDate.value;

      // Reset pax & options
      document.getElementById('bkAdults').value = '2';
      document.getElementById('bkChildren').value = '0';
      document.getElementById('packComfort').checked = true;
      document.getElementById('packEssential').checked = false;
      document.getElementById('packPremium').checked = false;
      ['optTransfer','optInsurance','optGuide'].forEach(id => { const el=document.getElementById(id); if(el){el.checked=false;} });

      updateSummary();
    });

    function getSelectedPackPrice(){
      if (document.getElementById('packEssential').checked) return Number(priceEssential.value);
      if (document.getElementById('packPremium').checked) return Number(pricePremium.value);
      return Number(priceComfort.value); // default
    }

    function updateSummary(){
      const adults = Number(document.getElementById('bkAdults').value || 0);
      const children = Number(document.getElementById('bkChildren').value || 0);
      const packPrice = getSelectedPackPrice();

      const childFactor = 0.60; // 60% du tarif adulte
      const adultTotal = adults * packPrice;
      const childTotal = Math.round(children * packPrice * childFactor);

      const extras = Array.from(document.querySelectorAll('#bookingForm input[name="extras[]"]:checked'))
        .map(el => Number(el.value));
      const extrasPerPerson = extras.reduce((a,b)=>a+b,0);
      const extrasTotal = (adults + children) * extrasPerPerson;

      const total = adultTotal + childTotal + extrasTotal;

      sumAdult.textContent = `${adults} × ${MAD.format(packPrice)} = ${MAD.format(adultTotal)}`;
      sumChild.textContent = `${children} × ${MAD.format(Math.round(packPrice*childFactor))} = ${MAD.format(childTotal)}`;
      sumExtras.textContent = extras.length ? MAD.format(extrasTotal) : '—';
      sumTotal.textContent = MAD.format(total);
      totalMad.value = total;

      const title = bkTitle.textContent.replace('Réserver — ','');
      const date = bkDate.value;
      const pack = document.querySelector('input[name="pack"]:checked')?.value || 'comfort';
      const msg =
        `Bonjour, je souhaite réserver:\n`+
        `• Circuit: ${title}\n`+
        `• Date: ${date}\n`+
        `• Pack: ${pack}\n`+
        `• Pax: ${adults} adultes + ${children} enfants\n`+
        `• Total estimé: ${MAD.format(total)}`;
      const url = "https://wa.me/212612345678?text=" + encodeURIComponent(msg);
      whatsappDraft.setAttribute('href', url);
    }

    ['bkAdults','bkChildren','packEssential','packComfort','packPremium','optTransfer','optInsurance','optGuide']
      .forEach(id => { document.getElementById(id)?.addEventListener('change', updateSummary); });
    document.getElementById('bkDate')?.addEventListener('change', updateSummary);

    // Newsletter demo
    document.getElementById('newsletterForm')?.addEventListener('submit', (e)=>{
      e.preventDefault();
      const m = document.getElementById('newsletterMsg');
      m.textContent = 'Merci ! Vous recevrez bientôt nos offres.';
      m.className = 'small mt-2 text-success';
      setTimeout(()=>{ m.textContent=''; m.className='small mt-2'; }, 4000);
      e.target.reset();
    });

    // Back to top
    document.getElementById('toTopBtn')?.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({top:0, behavior:'smooth'});
    });
  </script>
</body>
</html>
