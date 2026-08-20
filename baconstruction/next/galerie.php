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
<script>
/* ── Filtre galerie (+ pré-filtrage via ?cat= dans l'URL) ── */
(function(){
  const btns  = document.querySelectorAll('.filter-btn');
  const items = document.querySelectorAll('#gallery-grid .gallery-item[data-category]');
  const count = document.getElementById('gallery-count');
  const empty = document.getElementById('gallery-empty');

  const labels = {
    'all':'réalisations',
    'cave-a-vin':'réalisation(s) – caves à vins',
    'beton-cire':'réalisation(s) en béton ciré',
    'beton-desactive':'réalisation(s) en béton désactivé',
    'piscine':'réalisation(s) piscine',
    'beton-imprime':'réalisation(s) en béton imprimé'
  };

  function hasCategory(item, cat) {
    return item.dataset.category.split(' ').includes(cat);
  }

  function updateCount(filter) {
    const n = filter === 'all'
      ? items.length
      : Array.from(items).filter(el => hasCategory(el, filter)).length;
    count.textContent = n + ' ' + (labels[filter] || 'réalisations');
    empty.style.display = n === 0 ? 'block' : 'none';
  }

  function applyFilter(filter) {
    btns.forEach(b => b.classList.toggle('active', b.dataset.filter === filter));
    items.forEach(item => {
      item.classList.toggle('hidden', filter !== 'all' && !hasCategory(item, filter));
    });
    updateCount(filter);
  }

  btns.forEach(btn => {
    btn.addEventListener('click', function() { applyFilter(this.dataset.filter); });
  });

  // Catégorie passée par l'URL (clic sur une vignette de l'accueil) -> on filtre d'emblee.
  const wanted = new URLSearchParams(location.search).get('cat');
  const valid  = wanted && Array.from(btns).some(b => b.dataset.filter === wanted);
  applyFilter(valid ? wanted : 'all');
})();

/* ===========================================
   LIGHTBOX - zoom + navigation + glisser
=========================================== */
(function(){
  const lb       = document.getElementById('lightbox');
  const stage    = document.getElementById('lb-stage');
  const caption  = document.getElementById('lb-caption');
  const counter  = document.getElementById('lb-counter');
  const closeBtn = document.getElementById('lb-close');
  const prevBtn  = document.getElementById('lb-prev');
  const nextBtn  = document.getElementById('lb-next');

  let items = [];
  let idx   = 0;
  let scale = 1;
  let tx = 0, ty = 0;
  let dragging = false, startX = 0, startY = 0, lastTx = 0, lastTy = 0;

  function collectItems() {
    return Array.from(document.querySelectorAll('.gallery-item:not(.hidden)'));
  }

  function openLightbox(item, list) {
    items = list;
    idx   = items.indexOf(item);
    render();
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    lb.classList.remove('open');
    document.body.style.overflow = '';
    resetZoom();
  }

  function render() {
    resetZoom();
    const item = items[idx];
    if (!item) return;

    const captSpan = item.querySelector('.gallery-caption span');
    const captEm   = item.querySelector('.gallery-caption em');
    caption.innerHTML = (captSpan ? `<span>${captSpan.textContent}</span>` : '') +
                        (captEm   ? `<em>${captEm.textContent}</em>`       : '');
    counter.textContent = (idx + 1) + ' / ' + items.length;

    const fullSrc = item.dataset.src;
    const img     = item.querySelector('img');
    const src     = fullSrc || (img ? img.src : null);
    const alt     = img ? (img.alt || '') : '';
    if (src) {
      stage.innerHTML = `<img class="lb-img" src="${src}" alt="${alt}" draggable="false" style="opacity:0;transition:opacity .3s ease"/>`;
      const lbImg = stage.querySelector('.lb-img');
      lbImg.onload = () => { lbImg.style.opacity = '1'; };
    } else {
      stage.innerHTML = `
        <div class="lb-placeholder">
          <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <span>Photo à venir</span>
        </div>`;
    }
    prevBtn.style.opacity = idx === 0 ? '0.2' : '1';
    nextBtn.style.opacity = idx === items.length - 1 ? '0.2' : '1';

    bindZoom();
  }

  function prev() { if (idx > 0) { idx--; render(); } }
  function next() { if (idx < items.length - 1) { idx++; render(); } }

  function resetZoom() {
    scale = 1; tx = 0; ty = 0;
    stage.classList.remove('zoomed');
    applyTransform();
  }

  function applyTransform() {
    const el = stage.querySelector('.lb-img');
    if (!el) return;
    el.style.transform = `scale(${scale}) translate(${tx/scale}px, ${ty/scale}px)`;
  }

  function bindZoom() {
    const el = stage.querySelector('.lb-img');
    if (!el) return;

    stage.addEventListener('dblclick', function(e) {
      e.stopPropagation();
      if (scale > 1) { resetZoom(); }
      else           { zoomAt(e.clientX, e.clientY, 2.5); }
    });

    stage.addEventListener('click', function(e) {
      if (!stage.classList.contains('zoomed') && !dragging) {
        zoomAt(e.clientX, e.clientY, 2.5);
      }
    });
  }

  function zoomAt(cx, cy, targetScale) {
    const rect = stage.getBoundingClientRect();
    const ox = cx - rect.left - rect.width / 2;
    const oy = cy - rect.top  - rect.height / 2;
    scale = targetScale;
    tx = -ox * (scale - 1);
    ty = -oy * (scale - 1);
    stage.classList.add('zoomed');
    applyTransform();
  }

  stage.addEventListener('wheel', function(e) {
    e.preventDefault();
    const delta = e.deltaY > 0 ? -0.3 : 0.3;
    const newScale = Math.max(1, Math.min(5, scale + delta));
    if (newScale === 1) { resetZoom(); return; }
    const rect  = stage.getBoundingClientRect();
    const ox    = e.clientX - rect.left - rect.width  / 2;
    const oy    = e.clientY - rect.top  - rect.height / 2;
    const ratio = newScale / scale;
    tx = tx * ratio + ox * (1 - ratio);
    ty = ty * ratio + oy * (1 - ratio);
    scale = newScale;
    stage.classList.toggle('zoomed', scale > 1);
    applyTransform();
  }, {passive: false});

  stage.addEventListener('mousedown', function(e) {
    if (scale <= 1) return;
    dragging = true;
    startX = e.clientX - tx;
    startY = e.clientY - ty;
    lastTx = tx; lastTy = ty;
    e.preventDefault();
  });
  window.addEventListener('mousemove', function(e) {
    if (!dragging) return;
    tx = e.clientX - startX;
    ty = e.clientY - startY;
    applyTransform();
  });
  window.addEventListener('mouseup', function() { dragging = false; });

  let lastDist    = 0;
  let pinching    = false;
  let lastTapTime = 0;
  let touchStartX = 0, touchStartY = 0;
  let touchMoved  = false;

  stage.addEventListener('touchstart', function(e) {
    const ts = e.touches;
    if (ts.length === 2) {
      pinching = true;
      dragging = false;
      lastDist = Math.hypot(ts[1].clientX - ts[0].clientX, ts[1].clientY - ts[0].clientY);
    } else if (ts.length === 1) {
      pinching    = false;
      touchMoved  = false;
      touchStartX = ts[0].clientX;
      touchStartY = ts[0].clientY;
      if (scale > 1) {
        dragging = true;
        startX = ts[0].clientX - tx;
        startY = ts[0].clientY - ty;
      } else {
        dragging = false;
      }
    }
    e.preventDefault();
  }, {passive: false});

  stage.addEventListener('touchmove', function(e) {
    const ts = e.touches;
    e.preventDefault();

    if (ts.length === 2) {
      const dist     = Math.hypot(ts[1].clientX - ts[0].clientX, ts[1].clientY - ts[0].clientY);
      const ratio    = dist / lastDist;
      const newScale = Math.max(1, Math.min(5, scale * ratio));
      const cx = (ts[0].clientX + ts[1].clientX) / 2;
      const cy = (ts[0].clientY + ts[1].clientY) / 2;
      const rect = stage.getBoundingClientRect();
      const ox   = cx - rect.left - rect.width  / 2;
      const oy   = cy - rect.top  - rect.height / 2;
      const sr   = newScale / scale;
      tx = tx * sr + ox * (1 - sr);
      ty = ty * sr + oy * (1 - sr);
      scale = newScale;
      lastDist = dist;
      stage.classList.toggle('zoomed', scale > 1);
      applyTransform();
      touchMoved = true;
    } else if (ts.length === 1) {
      const dx = ts[0].clientX - touchStartX;
      const dy = ts[0].clientY - touchStartY;
      if (Math.abs(dx) > 5 || Math.abs(dy) > 5) touchMoved = true;
      if (dragging && scale > 1) {
        tx = ts[0].clientX - startX;
        ty = ts[0].clientY - startY;
        applyTransform();
      }
    }
  }, {passive: false});

  stage.addEventListener('touchend', function(e) {
    const ts = e.changedTouches;
    pinching = false;
    dragging = false;

    if (!touchMoved && ts.length === 1) {
      const now = Date.now();
      if (now - lastTapTime < 300) {
        lastTapTime = 0;
        if (scale > 1) { resetZoom(); }
        else           { zoomAt(ts[0].clientX, ts[0].clientY, 2.5); }
        return;
      }
      lastTapTime = now;
    }

    if (scale <= 1 && touchMoved && ts.length === 1) {
      const dx = ts[0].clientX - touchStartX;
      const dy = ts[0].clientY - touchStartY;
      if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy) * 1.5) {
        dx < 0 ? next() : prev();
      }
    }

    if (scale <= 1) resetZoom();
  }, {passive: false});

  document.addEventListener('keydown', function(e) {
    if (!lb.classList.contains('open')) return;
    if (e.key === 'Escape')           closeLightbox();
    else if (e.key === 'ArrowLeft')   prev();
    else if (e.key === 'ArrowRight')  next();
    else if (e.key === '+' || e.key === '=') { scale = Math.min(5, scale + 0.5); stage.classList.add('zoomed'); applyTransform(); }
    else if (e.key === '-')           { scale = Math.max(1, scale - 0.5); if (scale === 1) resetZoom(); else applyTransform(); }
  });

  lb.addEventListener('click', function(e) {
    if (e.target === lb) closeLightbox();
  });
  closeBtn.addEventListener('click', closeLightbox);
  prevBtn.addEventListener('click', function(e){ e.stopPropagation(); prev(); });
  nextBtn.addEventListener('click', function(e){ e.stopPropagation(); next(); });

  document.addEventListener('click', function(e) {
    const item = e.target.closest('.gallery-item');
    if (!item || lb.classList.contains('open')) return;
    if (e.target.closest('#lightbox')) return;
    const list = collectItems();
    openLightbox(item, list);
  });

})();

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
