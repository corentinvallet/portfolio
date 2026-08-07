(function () {
  const search   = document.getElementById('faqSearch');
  const toggle   = document.getElementById('faqToggleAll');
  const countEl  = document.getElementById('faqCount');
  const emptyEl  = document.getElementById('faqEmpty');
  const items    = Array.from(document.querySelectorAll('[data-item]'));
  const cats     = Array.from(document.querySelectorAll('[data-cat]'));

  // Normalise : minuscules + suppression des accents
  const norm = (s) => s.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

  // Index du texte de chaque question/réponse
  items.forEach((it) => {
    it.dataset.search = norm(it.textContent);
  });

  function filtrer() {
    const q = norm(search.value.trim());
    let visibles = 0;

    items.forEach((it) => {
      const match = q === '' || it.dataset.search.includes(q);
      it.hidden = !match;
      if (match) visibles++;
      // Ouvre automatiquement les résultats pendant une recherche
      if (q !== '' && match) it.open = true;
      if (q === '') it.open = false;
    });

    // Masque les catégories devenues vides
    cats.forEach((cat) => {
      const reste = cat.querySelectorAll('[data-item]:not([hidden])').length;
      cat.hidden = reste === 0;
    });

    emptyEl.hidden = visibles > 0;

    if (q === '') {
      countEl.hidden = true;
    } else {
      countEl.hidden = false;
      countEl.textContent = visibles === 0
        ? 'Aucun résultat'
        : visibles + (visibles > 1 ? ' questions trouvées' : ' question trouvée')
          + ' sur ' + faqTotal;
    }

    majBouton();
  }

  function majBouton() {
    const visibles = items.filter((it) => !it.hidden);
    const toutOuvert = visibles.length > 0 && visibles.every((it) => it.open);
    toggle.textContent = toutOuvert ? 'Tout replier' : 'Tout déplier';
  }

  toggle.addEventListener('click', () => {
    const visibles = items.filter((it) => !it.hidden);
    const toutOuvert = visibles.length > 0 && visibles.every((it) => it.open);
    visibles.forEach((it) => { it.open = !toutOuvert; });
    majBouton();
  });

  items.forEach((it) => it.addEventListener('toggle', majBouton));

  let t;
  search.addEventListener('input', () => {
    clearTimeout(t);
    t = setTimeout(filtrer, 150);
  });
})();