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