<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title><?= e(strip_tags($PAGE_TITLE)) ?> — B&amp;A Construction</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
      --sand:#e8dcc8;--brown:#7a5c3e;--dark-brown:#3d2b1a;
      --cream:#f5f0e8;--accent:#c4944a;--text:#2a1f14;
    }
    html{scroll-behavior:smooth}
    body{font-family:'Raleway',sans-serif;color:var(--text);background:var(--cream);overflow-x:hidden}
    section[id]{scroll-margin-top:80px}

    /* ── NAV ── */
    nav{
      position:fixed;top:0;left:0;right:0;z-index:100;
      display:flex;align-items:center;justify-content:space-between;
      padding:16px 5%;
      background:rgba(26,18,10,0.88);
      backdrop-filter:blur(14px);
      border-bottom:1px solid rgba(196,148,74,0.25);
    }
    .nav-logo{display:flex;align-items:center;gap:13px;text-decoration:none;cursor:pointer}
    .nav-brand{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--sand);letter-spacing:.04em;line-height:1.2}
    .nav-brand em{font-style:normal;color:var(--accent)}
    .nav-links{display:flex;gap:28px;list-style:none}
    .nav-links li{position:relative}
    .nav-links a{text-decoration:none;color:var(--sand);font-size:.78rem;font-weight:500;letter-spacing:.12em;text-transform:uppercase;transition:color .25s;cursor:pointer}
    .nav-links a:hover{color:var(--accent)}
    .nav-toggle{display:none;flex-direction:column;gap:5px;
      width:42px;height:42px;padding:0;background:none;border:0;cursor:pointer}
    .nav-toggle span{display:block;width:24px;height:2px;margin:0 auto;
      background:var(--sand);transition:transform .3s,opacity .3s}
    #main-nav.open .nav-toggle span:nth-child(1){transform:translateY(7px) rotate(45deg)}
    #main-nav.open .nav-toggle span:nth-child(2){opacity:0}
    #main-nav.open .nav-toggle span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}

    .has-dropdown > a::after{content:"";display:inline-block;width:6px;height:6px;margin-left:6px;border-right:1.5px solid currentColor;border-bottom:1.5px solid currentColor;transform:translateY(-2px) rotate(45deg)}
    .dropdown{
      list-style:none;position:absolute;top:calc(100% + 14px);left:50%;transform:translateX(-50%) translateY(-6px);
      min-width:210px;background:rgba(20,14,8,0.98);border:1px solid rgba(196,148,74,.25);
      padding:8px 0;opacity:0;visibility:hidden;transition:opacity .22s ease,transform .22s ease,visibility .22s;
      box-shadow:0 18px 40px rgba(0,0,0,.4);
    }
    .has-dropdown:hover .dropdown,.has-dropdown:focus-within .dropdown{opacity:1;visibility:visible;transform:translateX(-50%) translateY(0)}
    .dropdown a{display:block;padding:11px 22px;font-size:.74rem;letter-spacing:.1em;white-space:nowrap}
    .dropdown a::after{display:none}
    .dropdown a.current{color:var(--accent)}

    /* ── PAGE HEADER ── */
    .page-header{padding:130px 5% 60px;background:var(--dark-brown);border-bottom:1px solid rgba(196,148,74,.2)}
    .page-header .section-label{font-size:.7rem;letter-spacing:.28em;text-transform:uppercase;color:var(--accent);font-weight:600;margin-bottom:12px}
    .page-header h1{font-family:'Playfair Display',serif;font-size:clamp(2.2rem,5vw,3.8rem);font-weight:900;color:var(--sand);line-height:1.1;margin-bottom:14px}
    .page-header h1 em{font-style:normal;color:var(--accent)}
    .page-header p{font-size:.97rem;line-height:1.85;color:rgba(232,220,200,.6);max-width:520px}

    section{padding:90px 5%}
    .section-label{font-size:.7rem;letter-spacing:.28em;text-transform:uppercase;color:var(--accent);font-weight:600;margin-bottom:12px}
    .section-title{font-family:'Playfair Display',serif;font-size:clamp(1.9rem,4vw,2.9rem);font-weight:700;line-height:1.15;color:var(--dark-brown);margin-bottom:18px}
    .section-desc{font-size:.97rem;line-height:1.85;color:#5a4535;max-width:560px}

    /* ── DETAIL (image + texte) ── */
    .detail-section{background:var(--sand);display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:stretch}
    .detail-img-wrap{position:relative;height:100%}
    .detail-img-frame{position:absolute;inset:0;overflow:hidden}
    .detail-img-frame img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block;filter:sepia(15%) contrast(1.05)}
    .detail-badge{position:absolute;bottom:-22px;right:-22px;width:108px;height:108px;background:var(--accent);border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center}
    .detail-badge strong{font-size:1rem;font-weight:500;color:#fff;line-height:1}
    .detail-badge span{font-size:.58rem;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.82)}
    .detail-text .section-title{color:var(--dark-brown)}
    .detail-tags{margin-top:30px;display:flex;gap:28px;flex-wrap:wrap}
    .detail-tag{border-left:3px solid var(--accent);padding-left:15px}
    .detail-tag strong{display:block;font-size:.98rem;color:var(--brown);font-family:'Playfair Display',serif}

    /* ── GALERIE LIÉE ── */
    #related{background:var(--cream)}
    .gallery-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
    .gallery-item{overflow:hidden;position:relative;aspect-ratio:4/3}
    .gallery-item img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .55s cubic-bezier(.25,.46,.45,.94)}
    .gallery-item:hover img{transform:scale(1.07)}
    .gallery-caption{position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(26,18,10,.78) 100%);opacity:0;transition:opacity .3s;display:flex;flex-direction:column;align-items:flex-start;justify-content:flex-end;padding:18px;gap:4px}
    .gallery-item:hover .gallery-caption{opacity:1}
    .gallery-caption span{font-size:.75rem;letter-spacing:.14em;text-transform:uppercase;color:var(--sand);font-weight:500}
    .gallery-empty{padding:20px 0;color:var(--brown);opacity:.7;font-size:.9rem}
    .gallery-link-banner{
      display:inline-flex;flex-direction:column;align-items:flex-start;gap:4px;
      margin-top:36px;padding:18px 28px;
      border:1px solid rgba(196,148,74,.4);background:var(--accent);
      text-decoration:none;transition:background .25s,transform .2s;
      cursor:pointer;
    }
    .gallery-link-banner:hover{background:#a87836;transform:translateX(4px)}
    .gallery-link-text{font-family:'Raleway',sans-serif;font-size:.82rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--cream)}
    .gallery-link-sub{font-size:.75rem;color:var(--cream);letter-spacing:.06em}

    /* ── CTA CONTACT ── */
    #cta{background:var(--dark-brown);text-align:center}
    #cta .section-title{color:var(--sand)}
    #cta .section-desc{color:rgba(232,220,200,.65);margin:0 auto 30px;max-width:480px}
    .btn-primary{padding:13px 36px;background:var(--accent);color:#fff;border:none;cursor:pointer;font-family:'Raleway',sans-serif;font-size:.8rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;text-decoration:none;transition:background .25s,transform .2s;display:inline-block}
    .btn-primary:hover{background:#a87836;transform:translateY(-2px)}

    /* ── FOOTER ── */
    footer{background:var(--dark-brown);padding:36px 5%;display:flex;flex-direction:column;align-items:center;gap:14px;text-align:center;border-top:1px solid rgba(196,148,74,.2)}
    .footer-brand{display:flex;align-items:center;gap:14px}
    .footer-logo-circle{width:42px;height:42px;border-radius:50%;object-fit:cover;flex-shrink:0;opacity:.9}
    .footer-brand strong{display:block;color:var(--sand);font-family:'Playfair Display',serif;font-size:.92rem}
    .footer-brand p{font-size:.76rem;color:rgba(232,220,200,.45)}
    .footer-copy{font-size:.72rem;color:rgba(232,220,200,.32);letter-spacing:.08em}

    /* ── RESPONSIVE ── */
    @media(max-width:900px){
      .detail-section{grid-template-columns:1fr;gap:50px}
      .detail-img-wrap{height:340px}
      .detail-badge{right:0}
      .gallery-grid{grid-template-columns:1fr 1fr}
      .nav-toggle{display:flex}
      .has-dropdown > a::after{display:none}
      .dropdown{
        position:static;transform:none;opacity:1;visibility:visible;box-shadow:none;
        background:rgba(196,148,74,.1);
        border-left:2px solid var(--accent);
        margin-left:4px;
        padding:4px 0 10px;
      }
      .dropdown a{
        position:relative;
        padding:11px 0 11px 26px;
        border-bottom:1px solid rgba(196,148,74,.1);
        font-size:.8rem;
        color:rgba(232,220,200,.75);
      }
      .nav-links{
        position:absolute;top:100%;left:0;right:0;
        flex-direction:column;gap:0;
        background:rgba(26,18,10,0.97);backdrop-filter:blur(14px);
        border-bottom:1px solid rgba(196,148,74,0.25);
        max-height:0;overflow:hidden;
        transition:max-height .35s ease,padding .35s ease;padding:0 5%;
      }
      #main-nav.open .nav-links{max-height:calc(100vh - 70px);overflow-y:auto;padding:8px 5% 20px}
      .nav-links li{width:100%}
      .nav-links a{display:block;padding:15px 0;font-size:.9rem;
        border-bottom:1px solid rgba(196,148,74,0.12)}
    }
    @media(max-width:560px){
      .gallery-grid{grid-template-columns:1fr}
    }
  </style>
</head>
<body>

<nav id="main-nav">
  <a class="nav-logo" href="index.php">
    <img src="<?= e($logo) ?>" style="width:50px;height:50px" alt="Logo B&amp;A Construction">
    <div class="nav-brand">B<em>&amp;</em>A Construction</div>
  </a>
  <button class="nav-toggle" id="navToggle" aria-label="Ouvrir le menu"
          aria-expanded="false" aria-controls="navLinks">
    <span></span><span></span><span></span>
  </button>
  <ul class="nav-links" id="navLinks">
    <li><a href="index.php#services">Services</a></li>
    <li class="has-dropdown">
      <a href="index.php#hautdegamme">Haut de gamme</a>
      <ul class="dropdown">
        <li><a href="caves-a-vin.php" class="<?= $SELF === 'caves-a-vin.php' ? 'current' : '' ?>">Caves à vin</a></li>
        <li><a href="escalier-beton.php" class="<?= $SELF === 'escalier-beton.php' ? 'current' : '' ?>">Escalier béton</a></li>
        <li><a href="beton-imprime.php" class="<?= $SELF === 'beton-imprime.php' ? 'current' : '' ?>">Finitions de qualité</a></li>
      </ul>
    </li>
    <li><a href="index.php#realisations">Réalisations</a></li>
    <li><a href="galerie.php">Galerie</a></li>
    <li><a href="index.php#process">Méthode</a></li>
    <li><a href="index.php#about">À propos</a></li>
    <li><a href="index.php#contact">Contact</a></li>
  </ul>
</nav>

<div class="page-header">
  <p class="section-label"><?= e($PAGE_LABEL) ?></p>
  <h1><?= $PAGE_TITLE /* contient volontairement une balise <em> */ ?></h1>
  <p><?= e($PAGE_INTRO) ?></p>
</div>

<section class="detail-section">
  <div class="detail-text">
    <p class="section-label"><?= e($d['label'] ?? '') ?></p>
    <h2 class="section-title"><?= ml($d['title'] ?? '') ?></h2>
    <p class="section-desc" style="max-width:470px"><?= e($d['p1'] ?? '') ?></p>
    <p class="section-desc" style="max-width:470px;margin-top:14px"><?= e($d['p2'] ?? '') ?></p>
    <?php if (!empty($d['p3'])): ?>
      <p class="section-desc" style="max-width:470px;margin-top:14px"><?= e($d['p3']) ?></p>
    <?php endif; ?>
    <div class="detail-tags">
      <?php foreach (($d['tags'] ?? []) as $tag): ?>
      <div class="detail-tag"><strong><?= e($tag) ?></strong></div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="detail-img-wrap">
    <div class="detail-img-frame">
      <img src="<?= e($d['image'] ?? '') ?>" loading="lazy" alt="<?= e($CTA_TYPE) ?>">
    </div>
    <?php $b = $d['badge'] ?? ''; $bp = explode(' ', $b, 2); ?>
    <div class="detail-badge"><?= e($bp[0] ?? '') ?><br/><strong><?= e($bp[1] ?? '') ?></strong></div>
  </div>
</section>

<section id="related">
  <p class="section-label">Quelques réalisations</p>
  <h2 class="section-title"><?= e($GALLERY_TITLE ?? ('Nos ' . mb_strtolower($CTA_TYPE) . 's en images')) ?></h2>
  <?php if ($gallery): ?>
  <div class="gallery-grid">
    <?php foreach ($gallery as $g): ?>
    <div class="gallery-item">
      <img src="<?= e($g['thumb'] ?? ($g['full'] ?? '')) ?>" alt="<?= e($g['caption'] ?? '') ?>" loading="lazy">
      <div class="gallery-caption"><span><?= e($g['caption'] ?? '') ?></span></div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
  <p class="gallery-empty">Photos à venir.</p>
  <?php endif; ?>
  <a class="gallery-link-banner" href="galerie.php?cat=<?= e($GALLERY_CAT) ?>">
    <span class="gallery-link-text">Voir toute la galerie →</span>
    <span class="gallery-link-sub">Filtré sur « <?= e($CTA_TYPE) ?> »</span>
  </a>
</section>

<section id="cta">
  <p class="section-label">Un projet en tête ?</p>
  <h2 class="section-title">Parlons de votre <?= e(mb_strtolower($CTA_TYPE)) ?></h2>
  <p class="section-desc">Devis gratuit et détaillé sous 48h. <?= e($contact['phone1'] ?? '') ?> · <?= e($contact['phone2'] ?? '') ?></p>
  <a href="index.php#contact" class="btn-primary">Demander un devis →</a>
</section>

<footer>
  <div class="footer-brand">
    <img class="footer-logo-circle" src="<?= e($logo) ?>" alt="Logo B&amp;A Construction">
    <div><strong>B&amp;A Construction</strong><p>Bruno Salgado · Alex Freitas</p></div>
  </div>
  <p class="footer-copy">© <?= date('Y') ?> B&amp;A Construction — Tous droits réservés</p>
  <div id="cv-signature"></div>
</footer>

<script>
(function(){
  const nav = document.getElementById('main-nav');
  const toggle = document.getElementById('navToggle');
  if (!nav || !toggle) return;
  toggle.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
  });
  nav.querySelectorAll('.nav-links a').forEach(a =>
    a.addEventListener('click', () => {
      nav.classList.remove('open');
      toggle.setAttribute('aria-expanded','false');
    }));
})();
</script>
<script src="https://www.corentinvallet.fr/common/widgets/signature.js?v=1" defer></script>
</body>
</html>
