/* ── Filtre galerie multi-catégories (+ pré-filtrage via ?cat= dans l'URL) ── */
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
    'beton-imprime':'réalisation(s) en béton imprimé',
    'escalier-beton':'réalisation(s) escalier béton'
  };

  let selected = new Set(); // catégories actuellement cochées ('all' = rien de coché)

  function hasCategory(item, cat) {
    return item.dataset.category.split(' ').includes(cat);
  }

  function matches(item) {
    if (selected.size === 0) return true;
    return Array.from(selected).some(cat => hasCategory(item, cat));
  }

  function updateCount() {
    const visible = Array.from(items).filter(matches);
    const n = visible.length;
    let label;
    if (selected.size === 0) {
      label = labels['all'];
    } else if (selected.size === 1) {
      label = labels[Array.from(selected)[0]] || 'réalisations';
    } else {
      label = 'réalisations (' + Array.from(selected).map(c => labels[c]?.split('– ')[1] || labels[c]?.split('en ')[1] || c).join(', ') + ')';
    }
    count.textContent = n + ' ' + label;
    empty.style.display = n === 0 ? 'block' : 'none';
  }

  function render() {
    btns.forEach(b => {
      const f = b.dataset.filter;
      b.classList.toggle('active', f === 'all' ? selected.size === 0 : selected.has(f));
    });
    items.forEach(item => item.classList.toggle('hidden', !matches(item)));
    updateCount();
  }

  btns.forEach(btn => {
    btn.addEventListener('click', function() {
      const f = this.dataset.filter;
      if (f === 'all') {
        selected.clear();
      } else if (selected.has(f)) {
        selected.delete(f);
      } else {
        selected.add(f);
      }
      render();
    });
  });

  // Catégorie passée par l'URL (clic sur une vignette de l'accueil) -> on pré-sélectionne.
  const wanted = new URLSearchParams(location.search).get('cat');
  const valid  = wanted && Array.from(btns).some(b => b.dataset.filter === wanted);
  if (valid) selected.add(wanted);
  render();
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
  nav.querySelectorAll('.nav-sub-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const li = btn.closest('.has-dropdown');
      if (!li) return;
      const open = li.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });
})();