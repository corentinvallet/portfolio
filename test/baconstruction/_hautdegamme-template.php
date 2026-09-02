<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title><?= e(strip_tags($PAGE_TITLE)) ?> — B&amp;A Construction</title>
  <meta name="description" content="<?= e($PAGE_DESCRIPTION ?? '') ?>"/>
  <link rel="stylesheet" href="css/base.css"/>
  <link rel="stylesheet" href="css/hautdegamme.css"/>    
  <link rel="stylesheet" href="css/lightbox.css"/>
</head>
<body>
<?php include __DIR__ . '/_nav.php'; ?>
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
    <div class="gallery-item" data-src="<?= e($g['full'] ?? '') ?>">
      <img src="<?= e($g['thumb'] ?? ($g['full'] ?? '')) ?>" alt="<?= e($g['caption'] ?? '') ?>" loading="lazy">
      <div class="gallery-caption"><span><?= e($g['caption'] ?? '') ?></span><?php if (!empty($g['sub'])): ?><em><?= e($g['sub']) ?></em><?php endif; ?></div>
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
<!-- ═══════════════════════════════════════════
     LIGHTBOX
═══════════════════════════════════════════ -->
<div id="lightbox" role="dialog" aria-modal="true" aria-label="Image agrandie">
  <div class="lb-stage" id="lb-stage"></div>
  <button id="lb-close" title="Fermer (Échap)">✕</button>
  <button class="lb-btn" id="lb-prev" title="Précédent (←)">&#8592;</button>
  <button class="lb-btn" id="lb-next" title="Suivant (→)">&#8594;</button>
  <div id="lb-counter"></div>
  <div class="lb-zoom-hint" id="lb-zoom-hint">🔍 Clic pour zoomer · Molette pour zoomer · Glisser pour naviguer</div>
  <div class="lb-bar">
    <div class="lb-caption" id="lb-caption"></div>
    <div class="lb-hint">Échap pour fermer</div>
  </div>
</div>

<script src="js/lightbox.js"></script>
<script src="js/hautdegamme.js"></script>
<script src="https://www.corentinvallet.fr/common/widgets/signature.js?v=1" defer></script>
</body>
</html>
