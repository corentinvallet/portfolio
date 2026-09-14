<?php
require __DIR__ . '/inc/functions.php';
$c = load_content();
$sp = $c['sponsors'] ?? [];
$p  = $c['sponsorsPage'] ?? [];
$items = array_values(array_filter($sp['items'] ?? [], fn($s) => !empty($s['nom']) || !empty($s['logo'])));

// Ordre canonique des catégories pour les puces de filtre
$ordreCategories = ['Institutionnel', 'Partenaire financier', 'Partenaire commerçant', 'Partenaire local'];

// Catégories réellement présentes dans les données, avec leur nombre
$categories = [];
foreach ($items as $s) {
  $cat = trim((string)($s['categorie'] ?? ''));
  if ($cat === '') continue;
  if (!isset($categories[$cat])) $categories[$cat] = 0;
  $categories[$cat]++;
}
// Tri selon l'ordre canonique, puis toute catégorie imprévue à la suite
uksort($categories, function ($a, $b) use ($ordreCategories) {
  $ia = array_search($a, $ordreCategories);
  $ib = array_search($b, $ordreCategories);
  if ($ia === false) $ia = 999;
  if ($ib === false) $ib = 999;
  return $ia <=> $ib;
});

$total = count($items);

$home = false; $active = 'sponsors';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sponsors &amp; partenaires — <?= e($c['meta']['title'] ?? 'Club Œnologie Découvertes') ?></title>
<meta name="description" content="Les sponsors et partenaires qui soutiennent le Salon des Vins de Charmes-sur-Rhône et le Club Œnologie Découvertes.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" type="image/x-icon" href="assets/photos/Logo.png" />
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css?v=<?= @filemtime(__DIR__ . '/assets/style.css') ?: time() ?>">
<link rel="stylesheet" href="assets/page-sponsors.css">
</head>
<body>

<?php include __DIR__ . '/inc/header.php'; ?>

<div class="pagehead">
  <div class="wrap">
    <span class="eyebrow">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($p['eyebrow'] ?? 'Ils nous soutiennent') ?>
    </span>
    <h1><?= e($p['title'] ?? 'Sponsors & partenaires') ?></h1>
    <p><?= ml($p['intro'] ?? '') ?></p>
  </div>
</div>

<div class="wrap">

<?php if ($total === 0): ?>

  <div class="spo-nothing">
    <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
    <p>La liste des sponsors arrive bientôt.</p>
  </div>

<?php else: ?>

  <?php if (count($categories) > 1): ?>
  <div class="spo-filters" id="spoFilters" role="group" aria-label="Filtrer les sponsors par catégorie">
    <button type="button" class="spo-chip is-active" data-cat="">Tous<span class="spo-chip-n"><?= $total ?></span></button>
    <?php foreach ($categories as $nom => $n): ?>
    <button type="button" class="spo-chip" data-cat="<?= e($nom) ?>"><?= e($nom) ?><span class="spo-chip-n"><?= (int)$n ?></span></button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <p class="spo-count" id="spoCount" aria-live="polite"><?= $total ?> partenaire<?= $total > 1 ? 's' : '' ?></p>

  <div class="spo-grid" id="spoGrid">
    <?php foreach ($items as $s):
      $logo = cl_tr($s['logo'] ?? '', 'w_400,q_auto,f_auto');
      $cat  = trim((string)($s['categorie'] ?? ''));
      $url  = trim((string)($s['url'] ?? ''));
      $tag  = $url !== '' ? 'a' : 'div';
    ?>
    <<?= $tag ?> class="spo-card" data-cat="<?= e($cat) ?>"<?= $url !== '' ? ' href="' . e($url) . '" target="_blank" rel="noopener noreferrer"' : '' ?>>
      <div class="spo-logo-wrap">
        <?php if ($logo !== ''): ?>
        <img src="<?= e($logo) ?>" alt="<?= e($s['nom'] ?? '') ?>" loading="lazy" decoding="async">
        <?php else: ?>
        <span class="spo-logo-ph"><?= e($s['nom'] ?? '') ?></span>
        <?php endif; ?>
      </div>
      <?php if ($cat !== ''): ?><span class="spo-cat"><?= e($cat) ?></span><?php endif; ?>
      <h3><?= e($s['nom'] ?? '') ?></h3>
    </<?= $tag ?>>
    <?php endforeach; ?>
  </div>

  <p class="spo-empty" id="spoEmpty" hidden>Aucun sponsor ne correspond à ce filtre.</p>

<?php endif; ?>

</div>

<?php include __DIR__ . '/inc/footer-simple.php'; ?>
<?php include __DIR__ . '/inc/mobile-menu.php'; ?>
<?php if ($total > 0 && count($categories) > 1): ?>
<script src="assets/script-sponsors.js"></script>
<?php endif; ?>
</body>
</html>
