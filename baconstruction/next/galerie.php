<?php
/* ═══════════════════════════════════════════════════════════
   B&A Construction — Galerie complète (page dédiée)
   Rendu serveur depuis content.json : Google voit toutes les
   réalisations dans le HTML. Page distincte = URL propre + SEO.
═══════════════════════════════════════════════════════════ */
$c = json_decode(@file_get_contents(__DIR__ . '/content.json'), true) ?: [];

function e($s) { return htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8'); }

$gallery    = $c['gallery'] ?? [];
$logo       = $c['logo']    ?? 'Photos/Logo simplifié.webp';
$categories = $c['categories'] ?? [
  ['value'=>'cave-a-vin','label'=>'Caves à vins'],
  ['value'=>'beton-cire','label'=>'Béton ciré'],
  ['value'=>'beton-desactive','label'=>'Béton désactivé'],
  ['value'=>'piscine','label'=>'Piscine'],
  ['value'=>'beton-imprime','label'=>'Béton imprimé'],
  ['value'=>'escalier-beton','label'=>'Escalier béton'],
];
$siteUrl = 'https://corentinvallet.fr/baconstruction';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Nos réalisations — B&amp;A Construction | Béton & caves à vin en Drôme-Ardèche</title>
  <meta name="description" content="Découvrez toutes les réalisations de B&amp;A Construction : terrasses en béton imprimé, béton ciré, béton désactivé, plages de piscine et caves à vin enterrées en Drôme et Ardèche."/>
  <link rel="canonical" href="<?= e($siteUrl) ?>/galerie.php"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="css/galerie.css"/>
  <link rel="stylesheet" href="css/lightbox.css"/>
  <link rel="stylesheet" href="css/base.css"/>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVIGATION
═══════════════════════════════════════════ -->
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
        <li><a href="caves-a-vin.php">Caves à vin</a></li>
        <li><a href="escalier-beton.php">Escalier béton</a></li>
        <li><a href="beton-imprime.php">Finitions de qualité</a></li>
      </ul>
    </li>
    <li><a href="index.php#realisations">Réalisations</a></li>
    <li><a href="galerie.php">Galerie</a></li>
    <li><a href="index.php#process">Méthode</a></li>
    <li><a href="index.php#about">À propos</a></li>
    <li><a href="index.php#contact">Contact</a></li>
  </ul>
</nav>

<!-- ═══════════════════════════════════════════
     EN-TÊTE GALERIE
═══════════════════════════════════════════ -->
<div class="page-header">
  <p class="section-label">Portfolio complet</p>
  <h1>Nos <em>réalisations</em></h1>
  <p>Parcourez l'ensemble de nos projets. Filtrez par type de prestation pour trouver l'inspiration pour votre chantier.</p>
</div>

<!-- ═══════════════════════════════════════════
     GALERIE FILTRABLE
═══════════════════════════════════════════ -->
<div class="gallery-section">
  <div class="gallery-filters">
    <button class="filter-btn active" data-filter="all">Tous</button>
    <?php foreach ($categories as $cat): ?>
    <button class="filter-btn" data-filter="<?= e($cat['value'] ?? '') ?>"><?= e($cat['label'] ?? '') ?></button>
    <?php endforeach; ?>
  </div>

  <p class="gallery-count" id="gallery-count"><?= count($gallery) ?> réalisations</p>

  <div class="gallery-full-grid" id="gallery-grid">
    <?php foreach ($gallery as $g): ?>
    <div class="gallery-item" data-src="<?= e($g['full'] ?? '') ?>" data-category="<?= e(implode(' ', $g['categories'] ?? ($g['category'] ? [$g['category']] : []))) ?>">
      <img src="<?= e($g['thumb'] ?? ($g['full'] ?? '')) ?>" alt="<?= e($g['caption'] ?? '') ?>" loading="lazy" width="600" height="450">
      <div class="gallery-caption"><span><?= e($g['caption'] ?? '') ?></span><?php if (!empty($g['sub'])): ?><em><?= e($g['sub']) ?></em><?php endif; ?></div>
    </div>
    <?php endforeach; ?>
    <div class="gallery-empty" id="gallery-empty">Aucune réalisation dans cette catégorie pour le moment.</div>
  </div>
</div>

<!-- FOOTER -->
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
<script src="js/galerie.js"></script>
<script src="js/lightbox.js"></script>
<script src="https://www.corentinvallet.fr/common/widgets/signature.js?v=1" defer></script>
</body>
</html>
