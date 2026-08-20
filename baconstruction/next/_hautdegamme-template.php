<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title><?= e(strip_tags($PAGE_TITLE)) ?> — B&amp;A Construction</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="css/hautdegamme.css"/>    
  <link rel="stylesheet" href="css/base.css"/>
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
