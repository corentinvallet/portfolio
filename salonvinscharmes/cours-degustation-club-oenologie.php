<?php
require __DIR__ . '/inc/functions.php';
$c = load_content();
$p = $c['coursPage'] ?? [];
$infos    = $p['infos']    ?? [];
$formules = $p['formules'] ?? [];
$insc     = $p['inscription'] ?? [];
$archives = $p['archives'] ?? [];
$cta      = $p['cta']      ?? [];

// Découpe un texte multiligne en liste de points
function cours_lignes($s) {
  return preg_split('/\r\n|\r|\n/', (string)($s ?? ''), -1, PREG_SPLIT_NO_EMPTY);
}

$home = false; $active = 'cours';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cours de dégustation — <?= e($c['meta']['title'] ?? 'Club Œnologie Découvertes') ?></title>
<meta name="description" content="Séances d'initiation et de perfectionnement à la dégustation du Club Œnologie Découvertes de Charmes-sur-Rhône : programme, dates, tarifs et inscriptions.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css?v=<?= @filemtime(__DIR__ . '/assets/style.css') ?: time() ?>">
<link rel="stylesheet" href="assets/page-cours.css">
</head>
<body>

<?php include __DIR__ . '/inc/header.php'; ?>

<div class="pagehead">
  <div class="wrap">
    <span class="eyebrow">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($p['eyebrow'] ?? 'Activités du club') ?>
    </span>
    <h1><?= e($p['title'] ?? 'Les cours de dégustation') ?></h1>
    <?php if (!empty($p['saison'])): ?>
    <p class="cours-saison"><?= e($p['saison']) ?></p>
    <?php endif; ?>
    <p><?= ml($p['intro'] ?? '') ?></p>
  </div>
</div>

<div class="wrap">

  <?php if (!empty($p['animateurs'])): ?>
  <div class="cours-anim">
    <?php foreach ($p['animateurs'] as $a): ?>
    <div class="cours-anim-chip">
      <span class="cours-anim-dot"><?= e($a['initials'] ?? '') ?></span>
      <span>
        <span class="cours-anim-nom"><?= e($a['nom'] ?? '') ?></span>
        <span class="cours-anim-role"><?= e($a['role'] ?? '') ?></span>
      </span>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ($infos): ?>
  <div class="cours-infos">
    <?php foreach ($infos as $i): ?>
    <div class="cours-info">
      <span class="cours-info-icon" aria-hidden="true"><?= e($i['icon'] ?? '•') ?></span>
      <span class="cours-info-label"><?= e($i['label'] ?? '') ?></span>
      <span class="cours-info-value"><?= ml($i['value'] ?? '') ?></span>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if (!empty($p['note'])): ?>
  <p class="cours-note"><?= ml($p['note']) ?></p>
  <?php endif; ?>

  <?php if (!empty($insc['nom']) || !empty($insc['text'])): ?>
  <section class="cours-insc" aria-labelledby="cours-insc-title">
    <div>
      <h2 id="cours-insc-title"><?= e($insc['title'] ?? 'Renseignements et inscriptions') ?></h2>
      <?php if (!empty($insc['text'])): ?>
      <p><?= ml($insc['text']) ?></p>
      <?php endif; ?>
      <ul class="cours-insc-list">
        <?php if (!empty($insc['nom'])): ?>
        <li><span aria-hidden="true">👤</span> <?= e($insc['nom']) ?></li>
        <?php endif; ?>
        <?php if (!empty($insc['tel'])): ?>
        <li><span aria-hidden="true">📞</span>
          <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $insc['tel'])) ?>"><?= e($insc['tel']) ?></a>
        </li>
        <?php endif; ?>
        <?php if (!empty($insc['email'])): ?>
        <li><span aria-hidden="true">✉️</span>
          <a href="mailto:<?= e($insc['email']) ?>"><?= e($insc['email']) ?></a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
    <a href="index.php#contact" class="btn btn-solid"><?= e($insc['btn'] ?? 'Nous écrire') ?></a>
  </section>
  <?php endif; ?>

  <?php foreach ($formules as $fi => $f):
    $seances = $f['seances'] ?? [];
    $variant = ($fi % 2 === 0) ? 'a' : 'b';
  ?>
  <section class="cours-formule cours-formule--<?= $variant ?>" id="formule-<?= (int)$fi + 1 ?>">
    <div class="cours-formule-head">
      <span class="accent-hand"><?= e($f['tagline'] ?? '') ?></span>
      <h2><?= e($f['nom'] ?? '') ?></h2>
      <?php if (!empty($f['intro'])): ?>
      <p><?= ml($f['intro']) ?></p>
      <?php endif; ?>
    </div>

    <?php if ($seances): ?>
    <ol class="cours-seances">
      <?php foreach ($seances as $si => $s):
        $points = cours_lignes($s['programme'] ?? '');
        $dates  = array_filter(array_map('trim', (array)($s['dates'] ?? [])), 'strlen');
      ?>
      <li class="cours-seance">
        <div class="cours-seance-num" aria-hidden="true"><?= str_pad((string)($si + 1), 2, '0', STR_PAD_LEFT) ?></div>
        <div class="cours-seance-body">
          <h3><?= e($s['theme'] ?? '') ?></h3>
          <?php if (!empty($s['sousTitre'])): ?>
          <p class="cours-seance-sub"><?= e($s['sousTitre']) ?></p>
          <?php endif; ?>

          <?php if (!empty($s['animateur']) || !empty($s['vins'])): ?>
          <p class="cours-seance-meta">
            <?php if (!empty($s['animateur'])): ?><span>Animée par <?= e($s['animateur']) ?></span><?php endif; ?>
            <?php if (!empty($s['vins'])): ?><span><?= e($s['vins']) ?></span><?php endif; ?>
          </p>
          <?php endif; ?>

          <?php if ($dates): ?>
          <ul class="cours-dates">
            <?php foreach ($dates as $d): ?>
            <li><?= e($d) ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>

          <?php if ($points): ?>
          <ul class="cours-points">
            <?php foreach ($points as $pt): ?>
            <li><?= e(trim($pt)) ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>
      </li>
      <?php endforeach; ?>
    </ol>
    <?php endif; ?>
  </section>
  <?php endforeach; ?>

  <?php if (!empty($archives['items'])): ?>
  <section class="cours-archives" aria-labelledby="cours-archives-title">
    <h2 id="cours-archives-title"><?= e($archives['title'] ?? 'Les saisons précédentes') ?></h2>
    <?php if (!empty($archives['intro'])): ?>
    <p><?= ml($archives['intro']) ?></p>
    <?php endif; ?>
    <ul class="cours-archives-list">
      <?php foreach ($archives['items'] as $it): ?>
      <?php if (empty($it['label'])) continue; ?>
      <li>
        <?php if (!empty($it['url'])): ?>
        <a href="<?= e($it['url']) ?>" target="_blank" rel="noopener noreferrer"><?= e($it['label']) ?></a>
        <?php else: ?>
        <span><?= e($it['label']) ?></span>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </section>
  <?php endif; ?>

  <div class="join cours-cta">
    <div>
      <h3><?= e($cta['title'] ?? 'Une place vous attend peut-être') ?></h3>
      <p><?= ml($cta['text'] ?? 'Les groupes sont volontairement réduits. Contactez-nous pour connaître les disponibilités de la prochaine saison.') ?></p>
    </div>
    <a href="index.php#contact" class="btn btn-solid"><?= e($cta['btn'] ?? 'Nous contacter') ?></a>
  </div>

</div>

<?php include __DIR__ . '/inc/footer-simple.php'; ?>
<?php include __DIR__ . '/inc/mobile-menu.php'; ?>
</body>
</html>
