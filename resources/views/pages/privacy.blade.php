<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <!-- ========= META ========= -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Politique de confidentialité — QRevo, menu digital moderne (RGPD, sécurité, hébergement européen)." />
  <meta name="theme-color" content="#FF8A3D" />
  <title>QRevo — Politique de confidentialité</title>
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

  <!-- ========= FONTS & CSS ========= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" fetchpriority="low" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    /* ===== Reuse site palette ===== */
    :root{
      --brand:#FF8A3D; --brand-600:#F56A1E; --brand-700:#E85C0D;
      --peach:#FFE9D1; --apricot:#FFF1E6; --bg:#FFF8F2;
      --ink:#1f2937; --muted:#667085; --surface:#ffffff; --surface-2:#FFF6EE;
      --border:#F2E7DC; --ring:rgba(255,138,61,.25);
      --radius:18px; --shadow-1:0 6px 20px rgba(2,6,23,.06); --shadow-2:0 16px 40px rgba(2,6,23,.10);
    }
    html{scroll-behavior:smooth}
    body{
      font-family:'Manrope',system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
      color:var(--ink);
      background: radial-gradient(900px 480px at 80% -10%, rgba(255,138,61,.10), transparent 60%), var(--bg);
      overflow-x:hidden;
    }
    h1,h2,h3,h4,h5,h6{font-family:'Inter',sans-serif;letter-spacing:-.015em;font-weight:800}
    .text-muted{color:var(--muted)!important}

    /* ===== NAVBAR (same as site) ===== */
    .navbar{position:sticky;top:0;z-index:1040;background:rgba(255,255,255,.86);backdrop-filter:blur(12px);
      -webkit-backdrop-filter:blur(12px);border-bottom:1px solid var(--border);transition:box-shadow .25s ease,padding .2s ease,background .25s ease;padding:.7rem 0;}
    .navbar::after{content:"";position:absolute;left:0;right:0;bottom:-1px;height:2px;
      background:linear-gradient(90deg,var(--peach),var(--apricot));opacity:.55;pointer-events:none;}
    .navbar.scrolled{background:#fff;box-shadow:0 10px 28px rgba(0,0,0,.06);padding:.45rem 0;}
    .navbar .nav-link{font-weight:600;padding:.45rem .8rem;border-radius:999px;color:var(--ink)}
    .navbar .nav-link:hover,.navbar .nav-link:focus{background:rgba(255,138,61,.10);color:var(--ink)}
    .btn-primary{--bs-btn-bg:var(--brand);--bs-btn-border-color:var(--brand);--bs-btn-hover-bg:var(--brand-600);
      --bs-btn-hover-border-color:var(--brand-600);box-shadow:0 10px 20px rgba(255,138,61,.22);border-radius:12px;font-weight:700}
    .btn-outline-primary{--bs-btn-color:var(--brand);--bs-btn-border-color:var(--brand);
      --bs-btn-hover-color:#fff;--bs-btn-hover-bg:var(--brand);--bs-btn-hover-border-color:var(--brand);
      border-radius:12px;font-weight:700;background:transparent}

    /* ===== Hero ===== */
    .hero{padding:64px 0 56px;background:linear-gradient(135deg,var(--peach) 0%, var(--apricot) 100%);
      border-bottom:1px solid var(--border);position:relative;isolation:isolate;}
    .badge-soft{background:#fff;color:var(--brand);border:1px solid var(--border);border-radius:999px;padding:.4rem .7rem;font-weight:700;box-shadow:0 6px 16px rgba(0,0,0,.06);}
    .spark{background:linear-gradient(90deg,var(--brand) 0%, #FFC078 100%);-webkit-background-clip:text;background-clip:text;color:transparent;}

    /* ===== Policy layout ===== */
    .policy-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-1);}
    .toc{position:sticky;top:88px}
    .toc .list-group-item{border:0;border-radius:10px;font-weight:700;color:var(--muted);padding:.55rem .75rem}
    .toc .list-group-item:hover,.toc .list-group-item.active{background:rgba(255,138,61,.10);color:var(--ink);border:1px solid rgba(255,138,61,.25)}
    .policy h3{font-weight:800;margin-top:1.25rem}
    .policy p,.policy li{color:var(--ink);line-height:1.7}
    .policy code{background:#fff;border:1px solid var(--border);border-radius:6px;padding:.1rem .35rem}
    .callout{background:var(--surface-2);border:1px dashed var(--border);border-radius:12px;padding:.8rem}
    .section-divider{height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent)}
    /* Footer */
    .site-footer{background:var(--surface);border-top:1px solid var(--border);position:relative;overflow:hidden}
    .site-footer::before{content:"";position:absolute;left:0;right:0;top:0;height:2px;background:linear-gradient(90deg,var(--apricot),var(--peach));opacity:.6}
  </style>
</head>

<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-expand-lg" id="siteNav" aria-label="Navigation principale">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="/" aria-label="QRevo accueil">
        <img src="{{ asset('assets/img/saas/qrevo_under.png') }}" alt="QRevo" height="52">
      </a>
      <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-label="Ouvrir le menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse d-none d-lg-block">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
          <li class="nav-item"><a class="nav-link" href="/#features">Fonctionnalités</a></li>
          <li class="nav-item"><a class="nav-link" href="/#pricing">Tarifs</a></li>
          <li class="nav-item"><a class="nav-link" href="/#faq">FAQ</a></li>
          <!-- Confidentialité intentionally not in navbar -->
          <li class="nav-item ms-1"><a href="/login" class="btn btn-outline-primary">Se connecter</a></li>
          <li class="nav-item ms-1"><a href="/register" class="btn btn-primary">Essai gratuit</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Offcanvas mobile menu -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel">
    <div class="offcanvas-header" style="border-bottom:1px solid var(--border);background:linear-gradient(90deg,var(--apricot),var(--peach))">
      <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('assets/img/saas/qrevo_under.png') }}" alt="QRevo" height="28">
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
    </div>
    <div class="offcanvas-body">
      <div class="list-group list-group-flush">
        <a class="list-group-item" href="/#features" data-close>Fonctionnalités</a>
        <a class="list-group-item" href="/#pricing" data-close>Tarifs</a>
        <a class="list-group-item" href="/#faq" data-close>FAQ</a>
        <!-- Confidentialité intentionally not in offcanvas -->
      </div>
      <div class="d-grid gap-2 mt-3">
        <a href="/login" class="btn btn-outline-primary">Se connecter</a>
        <a href="/register" class="btn btn-primary">Essai gratuit</a>
      </div>
    </div>
  </div>

  <!-- ===== HERO ===== -->
  <header class="hero">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <span class="badge-soft d-inline-flex align-items-center gap-2 mb-3"><i class="bi bi-shield-lock"></i> Transparence & contrôle</span>
          <h1 class="display-5 mb-2">Politique de <span class="spark">confidentialité</span></h1>
          <p class="lead text-muted mb-0">Comment QRevo collecte, utilise et protège vos données. Document conforme RGPD — clair, concis et actionnable.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <div class="small text-muted">Dernière mise à jour&nbsp;: <strong>24/08/2025</strong></div>
          <a href="mailto:info@qrevo.app" class="btn btn-outline-primary btn-sm mt-2"><i class="bi bi-envelope"></i> Contacter le DPO</a>
        </div>
      </div>
    </div>
  </header>

  <!-- ===== POLICY BODY ===== -->
  <main class="py-5">
    <div class="container">
      <div class="row g-4">
        <!-- TOC -->
        <aside class="col-lg-4">
          <div class="policy-card p-3 toc">
            <h6 class="fw-bold mb-2">Sommaire</h6>
            <div class="list-group list-group-flush">
              <a class="list-group-item" href="#intro">1. Qui sommes-nous</a>
              <a class="list-group-item" href="#data">2. Données que nous collectons</a>
              <a class="list-group-item" href="#uses">3. Finalités & bases légales</a>
              <a class="list-group-item" href="#sharing">4. Partage & sous-traitants</a>
              <a class="list-group-item" href="#xfer">5. Transferts hors UE</a>
              <a class="list-group-item" href="#retention">6. Durées de conservation</a>
              <a class="list-group-item" href="#security">7. Sécurité</a>
              <a class="list-group-item" href="#rights">8. Vos droits</a>
              <a class="list-group-item" href="#cookies">9. Cookies</a>
              <a class="list-group-item" href="#product">10. Spécificités produit</a>
              <a class="list-group-item" href="#changes">11. Modifications</a>
              <a class="list-group-item" href="#contact">12. Contact</a>
            </div>
          </div>
        </aside>

        <!-- Content -->
        <section class="col-lg-8 policy">
          <div id="intro" class="policy-card p-4">
            <h3>1) Qui sommes-nous</h3>
            <p><strong>QRevo Inc.</strong> («&nbsp;<strong>QRevo</strong>&nbsp;», «&nbsp;nous&nbsp;») édite une solution de menu digital et de commande en salle à destination des établissements de restauration.</p>
            <p>Responsable du traitement&nbsp;: <strong>QRevo Inc.</strong>, Maroc. E-mail délégué à la protection des données (DPO)&nbsp;: <a href="mailto:info@qrevo.app">info@qrevo.app</a>.</p>
            <div class="callout mt-2"><strong>Portée</strong> — Cette politique s’applique aux sites, apps et services QRevo, ainsi qu’aux intégrations officielles.</div>
          </div>

          <div class="section-divider my-4"></div>

          <div id="data" class="policy-card p-4">
            <h3>2) Données que nous collectons</h3>
            <ul>
              <li><strong>Compte administrateur</strong> (obligatoire)&nbsp;: nom, e-mail, mot de passe haché, langue, préférences.</li>
              <li><strong>Données établissement</strong>&nbsp;: nom commercial, logo, adresse, numéros de téléphone, horaires, devises, langues.</li>
              <li><strong>Contenus de menu</strong>&nbsp;: catégories, plats, prix, images, allergènes, variantes.</li>
              <li><strong>Journal technique</strong>&nbsp;: logs applicatifs, adresses IP, identifiants d’appareil/navigateur, évènements (connexion, édition, erreurs).</li>
              <li><strong>Commandes en salle (optionnelles)</strong>&nbsp;: contenus du panier, total, table/zone, horodatage et, si l’utilisateur saisit ces champs, <em>nom</em> et <em>téléphone</em>.</li>
              <li><strong>Support & facturation</strong>&nbsp;: échanges e-mail, tickets, factures (données de facturation légales).</li>
            </ul>
            <p>Nous ne collectons pas de catégories particulières de données (dites «&nbsp;sensibles&nbsp;» au sens du RGPD).</p>
          </div>

          <div class="section-divider my-4"></div>

          <div id="uses" class="policy-card p-4">
            <h3>3) Finalités & bases légales</h3>
            <ul>
              <li><strong>Fourniture du service</strong>&nbsp;(exécution du contrat)&nbsp;: création/gestion de compte, hébergement de vos menus, QR, prise de commande en salle.</li>
              <li><strong>Sécurité & prévention de la fraude</strong>&nbsp;(intérêt légitime)&nbsp;: protection des comptes, audit des accès, diagnostics.</li>
              <li><strong>Amélioration produit</strong>&nbsp;(intérêt légitime)&nbsp;: statistiques agrégées et anonymisées d’usage.</li>
              <li><strong>Facturation & obligations légales</strong>&nbsp;(obligation légale)&nbsp;: conservation des documents comptables.</li>
              <li><strong>Communication</strong>&nbsp;(consentement ou intérêt légitime selon le canal)&nbsp;: e-mails de service, newsletters (opt-in), messages de support.</li>
            </ul>
          </div>

          <div class="section-divider my-4"></div>

          <div id="sharing" class="policy-card p-4">
            <h3>4) Partage & sous-traitants</h3>
            <p>Nous partageons des données uniquement avec des prestataires nécessaires à l’exécution du service, liés par des engagements contractuels (DPA) conformes au RGPD&nbsp;:</p>
            <ul>
              <li><strong>Hébergement</strong> (situé dans l’Union européenne).</li>
              <li><strong>Stockage d’images</strong> (infrastructure située dans l’UE).</li>
              <li><strong>Envoi d’e-mails</strong> transactionnels.</li>
              <li><strong>Analytique</strong> respectueuse de la vie privée (désactivable).</li>
              <li><strong>Paiement</strong> (si activé) pour le traitement sécurisé des transactions.</li>
            </ul>
            <p>Nous ne revendons pas vos données. Accès des autorités publiques uniquement sur obligation légale valable.</p>
          </div>

          <div class="section-divider my-4"></div>

          <div id="xfer" class="policy-card p-4">
            <h3>5) Transferts hors UE</h3>
            <p>Lorsque cela s’avère nécessaire (par exemple, e-mailing ou monitoring), tout transfert hors UE/EEE s’appuie sur un mécanisme valide&nbsp;: décision d’adéquation, <em>clauses contractuelles types</em> (CCT) et mesures complémentaires au besoin.</p>
          </div>

          <div class="section-divider my-4"></div>

          <div id="retention" class="policy-card p-4">
            <h3>6) Durées de conservation</h3>
            <ul>
              <li>Compte & contenus: pendant la durée d’utilisation + <strong>24&nbsp;mois</strong> après la résiliation (sauf suppression anticipée).</li>
              <li>Logs techniques: <strong>12&nbsp;mois</strong> max.</li>
              <li>Commandes en salle: <strong>12&nbsp;mois</strong> (ou moins si vous purgeez plus tôt).</li>
              <li>Facturation/comptabilité: jusqu’à <strong>10&nbsp;ans</strong> (obligation légale).</li>
            </ul>
            <p>Au terme des durées, les données sont supprimées ou anonymisées de manière irréversible.</p>
          </div>

          <div class="section-divider my-4"></div>

          <div id="security" class="policy-card p-4">
            <h3>7) Sécurité</h3>
            <ul>
              <li>Chiffrement en transit (TLS) et au repos pour les données critiques.</li>
              <li>Hachage des mots de passe via algorithme robuste.</li>
              <li>Segmentation des environnements, sauvegardes réplicas, supervision 24/7.</li>
              <li>Gestion des accès selon le principe du moindre privilège.</li>
            </ul>
            <div class="callout"><strong>Incident</strong> — En cas d’atteinte avérée à vos données, nous vous informerons <em>dans les meilleurs délais</em> conformément au RGPD.</div>
          </div>

          <div class="section-divider my-4"></div>

          <div id="rights" class="policy-card p-4">
            <h3>8) Vos droits (RGPD)</h3>
            <p>Vous disposez des droits d’<strong>accès</strong>, <strong>rectification</strong>, <strong>effacement</strong>, <strong>limitation</strong>, <strong>opposition</strong> et <strong>portabilité</strong>. Vous pouvez retirer votre consentement à tout moment (ex.&nbsp;: marketing).</p>
            <p>Pour exercer&nbsp;: écrivez-nous à <a href="mailto:info@qrevo.app">info@qrevo.app</a> en précisant votre e-mail de compte. Une preuve d’identité peut être demandée. Vous pouvez introduire une réclamation auprès de votre autorité de contrôle (ex.&nbsp;: CNDP/Maroc, CNIL/France).</p>
          </div>

          <div class="section-divider my-4"></div>

          <div id="cookies" class="policy-card p-4">
            <h3>9) Cookies</h3>
            <p>Nous utilisons des cookies et technologies similaires pour&nbsp;:</p>
            <ul>
              <li><strong>Essentiels</strong>: authentification, sécurité, anti-abus.</li>
              <li><strong>Mesure d’audience</strong>: agrégée et respectueuse de la vie privée.</li>
              <li><strong>Fonctionnels</strong>: préférences de langue, interface.</li>
            </ul>
            <p>Lorsqu’exigé, votre consentement est recueilli via une bannière et peut être retiré à tout moment depuis le lien «&nbsp;Préférences cookies&nbsp;» en pied de page.</p>
          </div>

          <div class="section-divider my-4"></div>

          <div id="product" class="policy-card p-4">
            <h3>10) Spécificités produit</h3>
            <ul>
              <li><strong>QR & menus publics</strong>: les liens QR ouvrent une page publique de consultation du menu. Aucune donnée personnelle n’est requise pour consulter.</li>
              <li><strong>Commande en salle</strong>: le client peut (optionnellement) indiquer son nom/téléphone pour faciliter le service; ces champs sont facultatifs et visibles par le personnel de l’établissement.</li>
              <li><strong>Agents de livraison</strong>: lorsqu’activés, seules les informations nécessaires à la préparation/livraison sont partagées avec l’établissement.</li>
              <li><strong>Export & portabilité</strong>: les administrateurs peuvent exporter leurs menus/données sur demande.</li>
            </ul>
          </div>

          <div class="section-divider my-4"></div>

          <div id="changes" class="policy-card p-4">
            <h3>11) Modifications</h3>
            <p>Nous pourrons mettre à jour cette politique pour refléter des évolutions légales ou produit. La date «&nbsp;Dernière mise à jour&nbsp;» est ajustée en conséquence et, en cas de changement significatif, une notification est envoyée dans l’application ou par e-mail.</p>
          </div>

          <div class="section-divider my-4"></div>

          <div id="contact" class="policy-card p-4">
            <h3>12) Contact</h3>
            <p>
              <strong>QRevo Inc.</strong><br>
              Maroc<br>
              E-mail&nbsp;: <a href="mailto:info@qrevo.app">info@qrevo.app</a>
            </p>
          </div>
        </section>
      </div>
    </div>
  </main>

  <!-- ===== FOOTER ===== -->
  <footer class="site-footer pt-5">
    <div class="container pb-4">
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="p-3" style="background:var(--surface-2);border:1px solid var(--border);border-radius:14px">
            <div class="d-flex align-items-center gap-2 mb-2">
              <img src="{{ asset('assets/img/saas/qrevo_under.png') }}" alt="QRevo" height="36">
            </div>
            <p class="small text-muted mb-2">Le menu digital moderne pour restaurants, cafés et hôtels. QR personnalisés, multilingue, statistiques en temps réel.</p>
            <div class="d-flex gap-2">
              <a class="btn btn-outline-primary btn-sm" href="/terms">CGU</a>
              <a class="btn btn-outline-primary btn-sm" href="/privacy">Confidentialité</a>
              <a class="btn btn-outline-primary btn-sm" href="/contact">Contact</a>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <h6 class="fw-bold mb-3">Produit</h6>
          <ul class="list-unstyled small m-0">
            <li class="mb-2"><a class="text-decoration-none" style="color:var(--ink)" href="/#features">Fonctionnalités</a></li>
            <li class="mb-2"><a class="text-decoration-none" style="color:var(--ink)" href="/#pricing">Tarifs</a></li>
            <li class="mb-2"><a class="text-decoration-none" style="color:var(--ink)" href="/#faq">FAQ</a></li>
          </ul>
        </div>
        <div class="col-6 col-lg-3">
          <h6 class="fw-bold mb-3">Ressources</h6>
          <ul class="list-unstyled small m-0">
            <li class="mb-2"><a class="text-decoration-none" style="color:var(--ink)" href="/security">Sécurité</a></li>
            <li class="mb-2"><a class="text-decoration-none" style="color:var(--ink)" href="/dpa">Accord de traitement (DPA)</a></li>
            <li class="mb-2"><a class="text-decoration-none" style="color:var(--ink)" href="/contact">Support</a></li>
          </ul>
        </div>
        <div class="col-lg-2">
          <h6 class="fw-bold mb-3">Compte</h6>
          <div class="d-grid gap-2">
            <a href="/login" class="btn btn-outline-primary btn-sm">Se connecter</a>
            <a href="/register" class="btn btn-primary btn-sm">Essai gratuit</a>
          </div>
        </div>
      </div>
      <hr class="my-4" style="border-color:var(--border)">
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between pb-4">
        <p class="small text-muted mb-2 mb-md-0">&copy; 2025 QRevo Inc. Tous droits réservés.</p>
        <a href="#" class="btn btn-outline-primary btn-sm" id="toTopBtn" aria-label="Retour en haut"><i class="bi bi-arrow-up"></i> Haut de page</a>
      </div>
    </div>
  </footer>

  <!-- ========= SCRIPTS ========= -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    // Navbar shrink
    window.addEventListener('scroll', ()=> {
      const nav=document.getElementById('siteNav');
      if(!nav) return;
      if (window.scrollY>8) nav.classList.add('scrolled'); else nav.classList.remove('scrolled');
    });

    // Offcanvas: close on link
    const offcanvasEl=document.getElementById('offcanvasNav');
    offcanvasEl?.querySelectorAll('[data-close]').forEach(a=>{
      a.addEventListener('click', ()=>{
        const oc=bootstrap.Offcanvas.getInstance(offcanvasEl); oc?.hide();
      });
    });

    // Back to top
    document.getElementById('toTopBtn')?.addEventListener('click', (e)=>{
      e.preventDefault(); window.scrollTo({top:0, behavior:'smooth'});
    });
  </script>
</body>
</html>
