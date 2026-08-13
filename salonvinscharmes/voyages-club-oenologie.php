<?php
require __DIR__ . '/inc/functions.php';
$c = load_content();
$p = $c['voyagesPage'] ?? [];
$voyages  = $p['list']     ?? [];
$prochain = $p['prochain'] ?? [];
$cta      = $p['cta']      ?? [];

// Découpe un texte multiligne en liste d'étapes
function voy_lignes($s) {
  return preg_split('/\r\n|\r|\n/', (string)($s ?? ''), -1, PREG_SPLIT_NO_EMPTY);
}

// Types réellement présents (Journée / Week-end…), pour les boutons de filtre
$types = [];
foreach ($voyages as $v) {
  $t = trim((string)($v['type'] ?? ''));
  if ($t !== '' && !isset($types[$t])) $types[$t] = 0;
  if ($t !== '') $types[$t]++;
}
$total = count($voyages);

$showProchain = trim((string)($prochain['titre'] ?? '')) !== ''
             && ($prochain['actif'] ?? 'oui') !== 'non';

$home = false; $active = 'voyages';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Voyages du club — <?= e($c['meta']['title'] ?? 'Club Œnologie Découvertes') ?></title>
<meta name="description" content="Journées et week-ends œnologiques du Club Œnologie Découvertes de Charmes-sur-Rhône : vignobles, domaines et découvertes du patrimoine, depuis 2004.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" type="image/x-icon" href="assets/photos/Logo.png" />
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css?v=<?= @filemtime(__DIR__ . '/assets/style.css') ?: time() ?>">
<link rel="stylesheet" href="assets/page-voyages.css">
</head>
<body>

<?php include __DIR__ . '/inc/header.php'; ?>

<div class="pagehead">
  <div class="wrap">
    <span class="eyebrow">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($p['eyebrow'] ?? 'Activités du club') ?>
    </span>
    <h1><?= e($p['title'] ?? 'Les voyages') ?></h1>
    <p><?= ml($p['intro'] ?? '') ?></p>
  </div>
</div>

<div class="wrap">

<?php if ($showProchain): ?>
  <section class="voy-next" aria-labelledby="voy-next-title">
    <?php $np = cl_tr($prochain['photo'] ?? '', 'c_fill,ar_16:9,g_auto,w_1200,q_auto,f_auto'); ?>
    <?php if ($np !== ''): ?>
    <div class="voy-next-media">
      <img src="<?= e($np) ?>" alt="" loading="lazy" decoding="async">
    </div>
    <?php endif; ?>
    <div class="voy-next-body">
      <span class="accent-hand"><?= e($prochain['tagline'] ?? 'à venir') ?></span>
      <h2 id="voy-next-title"><?= e($prochain['titre'] ?? '') ?></h2>
      <?php if (!empty($prochain['date']) || !empty($prochain['lieu'])): ?>
      <p class="voy-next-meta">
        <?php if (!empty($prochain['date'])): ?><span><?= e($prochain['date']) ?></span><?php endif; ?>
        <?php if (!empty($prochain['lieu'])): ?><span><?= e($prochain['lieu']) ?></span><?php endif; ?>
      </p>
      <?php endif; ?>
      <p><?= ml($prochain['texte'] ?? '') ?></p>
      <?php if (!empty($prochain['cta'])): ?>
      <a href="<?= e($prochain['href'] ?? 'index.php#contact') ?>" class="btn btn-solid"><?= e($prochain['cta']) ?></a>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<?php if ($total === 0): ?>

  <div class="voy-nothing">
    <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
    <p>Le récit des prochains voyages arrive bientôt.</p>
  </div>

<?php else: ?>

  <div class="voy-head">
    <h2 class="voy-head-title"><?= e($p['archivesTitle'] ?? 'Là où nous sommes déjà allés') ?></h2>
    <?php if (!empty($p['archivesIntro'])): ?>
    <p class="voy-head-intro"><?= ml($p['archivesIntro']) ?></p>
    <?php endif; ?>
  </div>

  <?php if (count($types) > 1): ?>
  <div class="voy-filters" id="voyFilters" role="group" aria-label="Filtrer les voyages">
    <button type="button" class="voy-chip is-active" data-type="">Tous<span class="voy-chip-n"><?= $total ?></span></button>
    <?php foreach ($types as $nom => $n): ?>
    <button type="button" class="voy-chip" data-type="<?= e($nom) ?>"><?= e($nom) ?><span class="voy-chip-n"><?= (int)$n ?></span></button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <p class="voy-count" id="voyCount" aria-live="polite"><?= $total ?> voyage<?= $total > 1 ? 's' : '' ?></p>

  <div class="voy-grid" id="voyGrid">
    <?php foreach ($voyages as $v):
      $photo  = cl_tr($v['photo'] ?? '', 'c_fill,ar_4:3,g_auto,w_760,q_auto,f_auto');
      $etapes = voy_lignes($v['programme'] ?? '');
      $type   = trim((string)($v['type'] ?? ''));
    ?>
    <article class="voy-card" data-type="<?= e($type) ?>">
      <div class="voy-media">
        <?php if ($photo !== ''): ?>
        <img src="<?= e($photo) ?>" alt="<?= e($v['titre'] ?? 'Voyage du club') ?>" loading="lazy" decoding="async">
        <?php else: ?>
        <div class="voy-media-ph" aria-hidden="true">
          <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
        </div>
        <?php endif; ?>
        <?php if (!empty($v['annee'])): ?>
        <span class="voy-year"><?= e($v['annee']) ?></span>
        <?php endif; ?>
      </div>
      <div class="voy-body">
        <?php if ($type !== ''): ?><span class="voy-type"><?= e($type) ?></span><?php endif; ?>
        <h3><?= e($v['titre'] ?? '') ?></h3>
        <?php if (!empty($v['date'])): ?>
        <p class="voy-date"><?= e($v['date']) ?></p>
        <?php endif; ?>
        <?php if (!empty($v['texte'])): ?>
        <p class="voy-text"><?= ml($v['texte']) ?></p>
        <?php endif; ?>
        <?php if ($etapes): ?>
        <ul class="voy-steps">
          <?php foreach ($etapes as $et): ?>
          <li><?= e(trim($et)) ?></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </article>
    <?php endforeach; ?>
  </div>

  <p class="voy-empty" id="voyEmpty" hidden>Aucun voyage ne correspond à ce filtre.</p>

<?php endif; ?>

</div>

<div class="wrap">
  <div class="join voy-cta">
    <div>
      <h3><?= e($cta['title'] ?? 'Envie de partir avec nous ?') ?></h3>
      <p><?= ml($cta['text'] ?? 'Les voyages sont ouverts aux adhérents du club. Écrivez-nous, nous vous préviendrons du prochain départ.') ?></p>
    </div>
    <a href="index.php#contact" class="btn btn-solid"><?= e($cta['btn'] ?? 'Nous contacter') ?></a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer-simple.php'; ?>
<?php include __DIR__ . '/inc/mobile-menu.php'; ?>
<?php if ($total > 0 && count($types) > 1): ?>
<script src="assets/script-voyages.js"></script>
<?php endif; ?>
</body>
</html>
