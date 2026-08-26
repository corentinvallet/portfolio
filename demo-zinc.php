<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Étude de cas — Le Zinc, site pour restaurateur | Corentin Vallet</title>
  <meta name="description" content="Découvrez en détail la démo Le Zinc : un site vitrine pour bistrot avec réservation en ligne, et un espace admin pour tout gérer sans compétence technique." />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="https://corentinvallet.fr/demo-zinc.php" />

  <link rel="icon" type="image/ico" href="Photos/Favicon_transp48.png">

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=DM+Mono:wght@300;400&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="nav.css">
  <style>
    :root {
      --bg:       #f5f2ec;
      --bg2:      #eee9df;
      --surface:  #ffffff;
      --border:   rgba(0,0,0,0.10);
      --text:     #1a1714;
      --text2:    #5a5046;
      --accent:   #c45c2a;
      --accent2:  #e8a97e;
      --tag-bg:   #ecdfd3;
      --tag-text: #7a3d1e;
      --nav-bg:   rgba(245,242,236,0.85);
      --card-shadow: 0 2px 24px rgba(0,0,0,0.07);
      --transition: 0.35s cubic-bezier(.4,0,.2,1);
    }
    [data-theme="dark"] {
      --bg:       #141210;
      --bg2:      #1e1b17;
      --surface:  #272320;
      --border:   rgba(255,255,255,0.09);
      --text:     #f0ebe3;
      --text2:    #9e9080;
      --accent:   #e07848;
      --accent2:  #c45c2a;
      --tag-bg:   #2e2319;
      --tag-text: #e0a070;
      --nav-bg:   rgba(20,18,16,0.88);
      --card-shadow: 0 2px 24px rgba(0,0,0,0.4);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; font-size: 16px; }

    body {
      font-family: 'Syne', sans-serif;
      background: var(--bg);
      color: var(--text);
      overflow-x: hidden;
      transition: background var(--transition), color var(--transition);
    }

    /* ── HERO ── */
    .hero {
      padding: 160px 40px 80px;
      max-width: 900px;
      margin: 0 auto;
      text-align: center;
    }
    .hero-eyebrow {
      font-family: 'DM Mono', monospace;
      font-size: 0.72rem;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    .hero-title {
      font-family: 'Fraunces', serif;
      font-size: clamp(2.4rem, 5vw, 4rem);
      font-weight: 300;
      line-height: 1.1;
      letter-spacing: -0.03em;
      color: var(--text);
      margin-bottom: 24px;
    }
    .hero-title em { font-style: italic; color: var(--accent); }
    .hero-desc {
      font-size: 1.05rem;
      line-height: 1.75;
      color: var(--text2);
      max-width: 620px;
      margin: 0 auto 40px;
    }
    .hero-ctas {
      display: flex;
      gap: 16px;
      justify-content: center;
      flex-wrap: wrap;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 14px 28px;
      border-radius: 2px;
      font-size: 0.82rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      text-decoration: none;
      transition: background 0.2s, transform 0.2s, border-color 0.2s, color 0.2s;
    }
    .btn-primary { background: var(--accent); color: #fff; }
    .btn-primary:hover { background: var(--accent2); transform: translateY(-2px); }
    .btn-outline {
      background: transparent;
      color: var(--text);
      border: 1px solid var(--border);
    }
    .btn-outline:hover { border-color: var(--accent); color: var(--accent); transform: translateY(-2px); }
    .btn svg { width: 15px; height: 15px; }

    /* ── SECTION BASE ── */
    section { padding: 90px 40px; }
    .section-inner { max-width: 1100px; margin: 0 auto; }
    .section-label {
      font-family: 'DM Mono', monospace;
      font-size: 0.7rem;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .section-label::before { content: ''; display: block; width: 24px; height: 1px; background: var(--accent); }
    .section-title {
      font-family: 'Fraunces', serif;
      font-size: clamp(1.8rem, 3vw, 2.6rem);
      font-weight: 300;
      letter-spacing: -0.03em;
      line-height: 1.15;
      color: var(--text);
      margin-bottom: 18px;
    }
    .section-title em { font-style: italic; color: var(--accent); }
    .section-intro {
      font-size: 1rem;
      color: var(--text2);
      line-height: 1.75;
      max-width: 620px;
      margin-bottom: 20px;
    }

    .cote-client { background: var(--bg2); }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-top: 48px;
    }
        .feature-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 4px;
      padding: 0;
      position: relative;
      overflow: hidden;
      transition: background var(--transition), border var(--transition), transform 0.2s;
    }
    .feature-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 3px; height: 0;
      background: var(--accent);
      transition: height 0.4s cubic-bezier(.4,0,.2,1);
      z-index: 2;
    }
    .feature-card:hover::before { height: 100%; }
    .feature-card:hover { transform: translateY(-3px); }
    .feature-icon {
      display: block;
      width: 100%;
      aspect-ratio: 16 / 10;
      overflow: hidden;
      background: var(--bg2);
      border-bottom: 1px solid var(--border);
    }
    .feature-icon img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: top;
      display: block;
      transition: transform 0.4s cubic-bezier(.4,0,.2,1);
    }
    .feature-card:hover .feature-icon img { transform: scale(1.04); }
    .feature-body { padding: 24px 32px 32px; }
    .feature-name {
      font-family: 'Fraunces', serif;
      font-size: 1.2rem;
      font-weight: 400;
      color: var(--text);
      margin-bottom: 8px;
      letter-spacing: -0.02em;
    }
    .feature-desc { font-size: 0.88rem; color: var(--text2); line-height: 1.7; }

    .divider {
      border: none;
      border-top: 1px solid var(--border);
      max-width: 1100px;
      margin: 0 auto;
    }

    .cta-section { text-align: center; }
    .cta-section .section-title { max-width: 640px; margin-left: auto; margin-right: auto; }
    .cta-section .section-intro { margin-left: auto; margin-right: auto; }
    .cta-section .hero-ctas { margin-top: 32px; }

    /* ── FOOTER ── */
    footer {
      padding: 40px;
      border-top: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      flex-wrap: wrap;
      gap: 16px;
    }
    .footer-logo { font-family: 'Fraunces', serif; font-size: 1rem; font-weight: 400; color: var(--text2); }
    .footer-logo span { color: var(--accent); font-style: italic; }
    .footer-copy { font-family: 'DM Mono', monospace; font-size: 0.68rem; color: var(--text2); letter-spacing: 0.04em; }

    /* ── ANIMATIONS ── */
    .fade-up { opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .fade-up.visible { opacity: 1; transform: translateY(0); }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      .feature-grid { grid-template-columns: 1fr; }
      section { padding: 64px 24px; }
      .hero { padding: 120px 24px 60px; }
      nav { padding: 14px 20px; }
      footer { padding: 32px 24px; }
      .nav-back span.nav-back-text { display: none; }
    }
  </style>
</head>
<body>
<?php include __DIR__ . '/inc/nav.php'; ?>
<!-- HERO -->
<div class="hero">
  <p class="hero-eyebrow">✦ Étude de cas · Restaurateurs ✦</p>
  <h1 class="hero-title">Le <em>Zinc</em>, un site pensé<br>pour un bistrot parisien</h1>
  <p class="hero-desc">Cette démo montre ce que je conçois pour un restaurateur : un site vitrine qui donne envie de pousser la porte, et un espace d'administration qui permet de tout gérer soi-même, sans aucune compétence technique.</p>
  <div class="hero-ctas">
    <a href="restaurant/index.html" target="_blank" rel="noopener" class="btn btn-primary">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="1" width="14" height="14" rx="1"/><path d="M5 8h6M8 5l3 3-3 3"/></svg>
      Voir le site vitrine
    </a>
    <a href="restaurant/admin.html" target="_blank" rel="noopener" class="btn btn-outline">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="1" width="14" height="14" rx="1"/><path d="M5 8h6M8 5l3 3-3 3"/></svg>
      Voir l'espace admin
    </a>
  </div>
</div>

<!-- CÔTÉ CLIENT -->
<section class="cote-client">
  <div class="section-inner">
    <div class="section-label fade-up">Ce que voit votre client</div>
    <h2 class="section-title fade-up">Une <em>vitrine</em> qui donne envie<br>de réserver une table</h2>
    <p class="section-intro fade-up">Le site public met en avant l'identité du restaurant : ambiance, carte, avis clients. Chaque élément est pensé pour transformer un visiteur en réservation.</p>

    <div class="feature-grid">
            <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-identite.png" alt="Identité visuelle du site"></span>
        <div class="feature-body">
          <div class="feature-name">Identité visuelle sur mesure</div>
          <p class="feature-desc">Palette, typographies et ambiance visuelle propres au bistrot — noir, or et cuivre pour évoquer un lieu chaleureux et authentique.</p>
        </div>
      </div>
      <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-menu.png" alt="Carte du restaurant"></span>
        <div class="feature-body">
          <div class="feature-name">Carte mise en avant</div>
          <p class="feature-desc">Entrées, plats, desserts organisés en onglets clairs, avec descriptions et prix — la carte se met à jour automatiquement dès que le restaurateur la modifie.</p>
        </div>
      </div>
      <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-reservation.png" alt="Formulaire de réservation"></span>
        <div class="feature-body">
          <div class="feature-name">Réservation en ligne intégrée</div>
          <p class="feature-desc">Un formulaire directement sur le site, avec créneaux et jours d'ouverture qui se ferment automatiquement une fois complets.</p>
        </div>
      </div>
      <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-avis.png" alt="Avis clients"></span>
        <div class="feature-body">
          <div class="feature-name">Avis clients mis en scène</div>
          <p class="feature-desc">Les retours clients sont affichés avec soin pour rassurer un visiteur qui découvre l'établissement pour la première fois.</p>
        </div>
      </div>
      <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-galerie.png" alt="Galerie photo"></span>
        <div class="feature-body">
          <div class="feature-name">Galerie immersive</div>
          <p class="feature-desc">Photos de la salle, des plats et de l'ambiance pour donner un aperçu concret du lieu avant même d'y avoir mis les pieds.</p>
        </div>
      </div>
      <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-mobile.png" alt="Version mobile du site"></span>
        <div class="feature-body">
          <div class="feature-name">Pensé mobile</div>
          <p class="feature-desc">La grande majorité des visiteurs consultent un restaurant depuis leur téléphone — le site est entièrement adapté à tous les écrans.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<hr class="divider" />

<!-- CÔTÉ ADMIN -->
<section>
  <div class="section-inner">
    <div class="section-label fade-up">Ce que vous gérez vous-même</div>
    <h2 class="section-title fade-up">Un espace admin <em>simple</em>,<br>sans jamais toucher au code</h2>
    <p class="section-intro fade-up">Derrière le site, un tableau de bord privé permet au restaurateur de garder la main sur son activité au quotidien — comme dans les grandes plateformes, mais sur son propre site.</p>

    <div class="feature-grid">
            <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-admin-reservations.png" alt="Suivi des réservations dans l'admin"></span>
        <div class="feature-body">
          <div class="feature-name">Suivi des réservations en un coup d'œil</div>
          <p class="feature-desc">Total, réservations du jour, en attente de confirmation, nombre de couverts — les chiffres essentiels affichés dès l'ouverture de l'espace admin.</p>
        </div>
      </div>
      <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-admin-carte.png" alt="Édition de la carte dans l'admin"></span>
        <div class="feature-body">
          <div class="feature-name">Édition de la carte en temps réel</div>
          <p class="feature-desc">Ajouter, modifier ou réorganiser plats et catégories — les changements apparaissent instantanément sur le site public.</p>
        </div>
      </div>
      <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-admin-galerie.png" alt="Galerie drag & drop dans l'admin"></span>
        <div class="feature-body">
          <div class="feature-name">Galerie par glisser-déposer</div>
          <p class="feature-desc">Ajouter de nouvelles photos ou réorganiser la galerie sans aucune manipulation technique.</p>
        </div>
      </div>
      <div class="feature-card fade-up">
        <span class="feature-icon"><img src="Photos/capture-admin-reglages.png" alt="Réglages horaires dans l'admin"></span>
        <div class="feature-body">
          <div class="feature-name">Réglages horaires & capacité</div>
          <p class="feature-desc">Définir les jours d'ouverture et le nombre de couverts disponibles par service — le formulaire de réservation s'adapte automatiquement.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="cote-client cta-section">
  <div class="section-inner">
    <div class="section-label fade-up" style="justify-content:center;">Et pour votre activité ?</div>
    <h2 class="section-title fade-up">Restaurant, commerce, artisanat —<br>chaque secteur a <em>sa propre démo</em></h2>
    <p class="section-intro fade-up">Ce principe (site vitrine + espace admin sur mesure) s'adapte à votre activité. Découvrez les autres exemples ou échangeons directement sur votre projet.</p>
    <div class="hero-ctas fade-up">
      <a href="index.php#realisations" class="btn btn-outline">Voir les autres réalisations</a>
      <a href="index.php#contact" class="btn btn-primary">
        Discuter de mon projet
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-logo">Corentin <span>Vallet</span></div>
  <div class="footer-copy">© 2026 — Corentin Vallet</div>
</footer>

<script>
  /* ── THEME TOGGLE ── */
  const html = document.documentElement;
  const themeBtn = document.getElementById('themeToggle');
  themeBtn.addEventListener('click', () => {
    html.dataset.theme = html.dataset.theme === 'dark' ? 'light' : 'dark';
    localStorage.setItem('theme', html.dataset.theme);
  });
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme) html.dataset.theme = savedTheme;

  /* ── FADE UP ON SCROLL ── */
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.12 });
  document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
</script>

<script src="nav.js"></script>
</body>
</html>
