<?php
require __DIR__ . '/inc/functions.php';
$c = load_content();
$p = $c['galeriePage'] ?? [];
$albums = $p['albums'] ?? [];

/* Aplatit tous les albums en une seule liste de photos.
   L'index de cette liste sert de référence à la visionneuse. */
$photos = [];
foreach ($albums as $ai => $al) {
  foreach (($al['photos'] ?? []) as $ph) {
    $src = trim((string)($ph['src'] ?? ''));
    if ($src === '') continue;
    $photos[] = [
      'thumb'   => cl_tr($src, 'c_limit,w_760,q_auto,f_auto'),
      'full'    => cl_tr($src, 'c_limit,w_1800,q_auto,f_auto'),
      'legende' => trim((string)($ph['legende'] ?? '')),
      'album'   => (string)($al['nom'] ?? ''),
      'ai'      => $ai,
    ];
  }
}
$total = count($photos);

/* Albums réellement pourvus d'au moins une photo (pour les filtres) */
$albumsActifs = [];
foreach ($albums as $ai => $al) {
  $n = 0;
  foreach (($al['photos'] ?? []) as $ph) { if (trim((string)($ph['src'] ?? '')) !== '') $n++; }
  if ($n > 0) $albumsActifs[] = ['i' => $ai, 'nom' => (string)($al['nom'] ?? ''), 'n' => $n];
}

$home = false; $active = 'galerie';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Galerie — <?= e($c['meta']['title'] ?? 'Club Œnologie Découvertes') ?></title>
<meta name="description" content="Le Salon des Vins de France de Charmes-sur-Rhône en images : ambiance des allées, dégustations, animations et rencontres avec les vignerons.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css?v=<?= @filemtime(__DIR__ . '/assets/style.css') ?: time() ?>">
<link rel="icon" type="image/x-icon" href="assets/photos/Logo.png" />
<link rel="stylesheet" href="assets/page-galerie.css">
</head>
<body>

<?php include __DIR__ . '/inc/header.php'; ?>

<div class="pagehead">
  <div class="wrap">
    <span class="eyebrow">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($p['eyebrow'] ?? 'En images') ?>
    </span>
    <h1><?= e($p['title'] ?? 'La galerie') ?></h1>
    <p><?= ml($p['intro'] ?? '') ?></p>
  </div>
</div>

<div class="wrap">

<?php if ($total === 0): ?>

  <div class="gal-nothing">
    <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
    <p>Les photos de la prochaine édition arrivent bientôt.</p>
  </div>

<?php else: ?>

  <?php if (count($albumsActifs) > 1): ?>
  <div class="gal-toolbar">
    <div class="gal-filters" id="galFilters" role="group" aria-label="Filtrer les photos par album">
      <button type="button" class="gal-chip is-active" data-album="">Toutes<span class="gal-chip-n"><?= $total ?></span></button>
      <?php foreach ($albumsActifs as $al): ?>
      <button type="button" class="gal-chip" data-album="<?= $al['i'] ?>"><?= e($al['nom']) ?><span class="gal-chip-n"><?= $al['n'] ?></span></button>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <p class="gal-count" id="galCount" aria-live="polite"><?= $total ?> photo<?= $total > 1 ? 's' : '' ?></p>

  <div class="gal-grid" id="galGrid">
    <?php foreach ($photos as $i => $ph): ?>
    <button type="button" class="gal-item" data-index="<?= $i ?>" data-album="<?= (int)$ph['ai'] ?>"
            aria-label="Agrandir la photo <?= $i + 1 ?><?= $ph['legende'] !== '' ? ' — ' . e($ph['legende']) : '' ?>">
      <img src="<?= e($ph['thumb']) ?>" alt="<?= e($ph['legende'] !== '' ? $ph['legende'] : 'Photo du salon') ?>"
           loading="lazy" decoding="async">
      <?php if ($ph['legende'] !== ''): ?>
      <span class="gal-cap"><?= e($ph['legende']) ?></span>
      <?php endif; ?>
      <span class="gal-zoom" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3M11 8v6M8 11h6"/></svg>
      </span>
    </button>
    <?php endforeach; ?>
  </div>

  <p class="gal-empty" id="galEmpty" hidden>Aucune photo dans cet album pour l’instant.</p>

<?php endif; ?>

</div>

<?php if ($total > 0): ?>
<!-- Visionneuse -->
<div class="gal-lightbox" id="galLightbox" role="dialog" aria-modal="true" aria-label="Visionneuse de photos" hidden>
  <button type="button" class="gal-lb-close" id="galClose" aria-label="Fermer la visionneuse">✕</button>
  <button type="button" class="gal-lb-nav gal-lb-prev" id="galPrev" aria-label="Photo précédente">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
  </button>
  <button type="button" class="gal-lb-nav gal-lb-next" id="galNext" aria-label="Photo suivante">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
  </button>
  <figure class="gal-lb-figure" id="galFigure">
    <img id="galLbImg" src="" alt="">
    <figcaption>
      <span class="gal-lb-album" id="galLbAlbum"></span>
      <span class="gal-lb-legende" id="galLbLegende"></span>
      <span class="gal-lb-counter" id="galLbCounter" aria-live="polite"></span>
    </figcaption>
  </figure>
</div>
<?php endif; ?>

<div class="wrap">
  <div class="join gal-cta">
    <div>
      <h3><?= e($p['ctaTitle'] ?? 'Vous avez de belles photos du salon ?') ?></h3>
      <p><?= ml($p['ctaText'] ?? 'Partagez-les avec nous, elles rejoindront peut-être cette galerie.') ?></p>
    </div>
    <a href="index.php#contact" class="btn btn-solid"><?= e($p['ctaBtn'] ?? 'Nous les envoyer') ?></a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer-simple.php'; ?>
<?php include __DIR__ . '/inc/mobile-menu.php'; ?>
<?php if ($total > 0): ?>
<script>const galPhotos = <?= json_encode($photos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="assets/script-galerie.js"></script>
<?php endif; ?>
</body>
</html>
