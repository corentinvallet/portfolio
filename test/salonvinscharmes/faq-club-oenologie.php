<?php
require __DIR__ . '/inc/functions.php';
$c = load_content();
$p = $c['faqPage'] ?? [];
$cats = $p['categories'] ?? [];
$cta = $p['cta'] ?? [];

// Autorise un HTML léger dans les réponses saisies via l'admin
function faq_html($s) {
    return strip_tags($s, '<a><strong><em><br><ul><ol><li><p>');
}

// Compteur total de questions
$total = 0;
foreach ($cats as $cat) { $total += count($cat['items'] ?? []); }

$home = false; $active = 'faq';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FAQ — <?= e($c['meta']['title'] ?? 'Club Œnologie Découvertes') ?></title>
<meta name="description" content="Horaires, tarifs, parkings, animations, restauration : toutes les réponses aux questions fréquentes sur le Salon des Vins de France de Charmes-sur-Rhône.">
<link rel="stylesheet" href="assets/style.css?v=<?= @filemtime(__DIR__ . '/assets/style.css') ?: time() ?>">
<link rel="icon" type="image/x-icon" href="assets/photos/Logo.png" />
<link rel="stylesheet" href="assets/page-faq.css">
</head>
<body>

<?php include __DIR__ . '/inc/header.php'; ?>

<section class="wrap block">
  <div class="section-head">
    <span class="tag">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($p['tag'] ?? 'Questions fréquentes') ?>
    </span>
    <h1><?= e($p['title'] ?? 'FAQ') ?></h1>
    <p><?= ml($p['intro'] ?? '') ?></p>
  </div>

  <div class="faq-toolbar">
    <input type="search" id="faqSearch" class="faq-search"
           placeholder="<?= e($p['searchPlaceholder'] ?? 'Rechercher une question…') ?>"
           aria-label="Rechercher dans la FAQ">
    <button type="button" id="faqToggleAll" class="faq-toggle-all">Tout déplier</button>
  </div>
  <p class="faq-count" id="faqCount" hidden></p>

  <div class="faq-list" id="faqList">
    <?php foreach ($cats as $ci => $cat): ?>
    <section class="faq-cat" data-cat>
      <h2 class="faq-cat-title">
        <span class="faq-cat-num"><?= str_pad($ci + 1, 2, '0', STR_PAD_LEFT) ?></span>
        <?= e($cat['nom'] ?? '') ?>
      </h2>
      <?php foreach (($cat['items'] ?? []) as $qi => $item): ?>
      <details class="faq-item" data-item>
        <summary>
          <span class="faq-q"><?= e($item['q'] ?? '') ?></span>
          <span class="faq-chevron" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
          </span>
        </summary>
        <div class="faq-a"><?= faq_html($item['r'] ?? '') ?></div>
      </details>
      <?php endforeach; ?>
    </section>
    <?php endforeach; ?>
  </div>

  <p class="faq-empty" id="faqEmpty" hidden>
    Aucune question ne correspond à votre recherche.
    <a href="index.php#contact">Posez-la nous directement</a>.
  </p>
</section>

<div class="wrap">
  <div class="join faq-cta">
    <div>
      <h3><?= e($cta['title'] ?? '') ?></h3>
      <p><?= ml($cta['text'] ?? '') ?></p>
    </div>
    <a href="index.php#contact" class="btn btn-solid"><?= e($cta['btn'] ?? 'Nous contacter') ?></a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer-simple.php'; ?>
<?php include __DIR__ . '/inc/mobile-menu.php'; ?>
<script>const faqTotal = <?= (int) $total ?>;</script>
<script src="assets/script-faq.js"></script>
</body>
</html>