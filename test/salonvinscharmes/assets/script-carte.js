(function () {
  const carte = document.querySelector('.carte-hero');
  if (!carte) return;
  const svg = carte.querySelector('.svc-carte');
  if (!svg) return;

  const zones = svg.querySelectorAll('.svc-zone');
  const counts = window.svcRegionCounts || {};
  const hasHover = window.matchMedia('(hover: hover)').matches;

  // libellés lisibles, alignés sur le texte affiché dans la carte
  const labels = {
    champagne:'Champagne', bourgogne:'Bourgogne', alsace:'Alsace',
    jura:'Jura', beaujolais:'Beaujolais', savoie:'Savoie',
    bordelais:'Bordeaux', 'sud-ouest':'Sud-Ouest', languedoc:'Languedoc-Roussillon',
    rhone:'Rhône', provence:'Provence', corse:'Corse',
    loire:'Vallée de la Loire', poitou:'Poitou-Charentes'
  };

  const chip = document.createElement('div');
  chip.className = 'svc-chip' + (hasHover ? '' : ' is-tactile');
  chip.innerHTML = '<span class="svc-chip-label"></span><span class="svc-chip-count"></span><a class="svc-chip-cta" href="#">Voir →</a>';
  carte.appendChild(chip);
  const chipLabel = chip.querySelector('.svc-chip-label');
  const chipCount = chip.querySelector('.svc-chip-count');
  const chipCta = chip.querySelector('.svc-chip-cta');

  let selected = null;

  function urlFor(slug){ return 'exposants-club-oenologie.php?region=' + encodeURIComponent(slug); }

  function showChip(zone, slug){
    const label = labels[slug] || slug;
    const n = counts[slug] || 0;
    chipLabel.textContent = label;
    chipCount.textContent = n > 0 ? (n + (n > 1 ? ' vignerons' : ' vigneron')) : 'Bientôt annoncé';
    chipCta.href = urlFor(slug);

    const zoneBox = zone.getBoundingClientRect();
    const carteBox = carte.getBoundingClientRect();
    chip.style.left = (zoneBox.left + zoneBox.width / 2 - carteBox.left) + 'px';
    chip.style.top = (zoneBox.top + zoneBox.height / 2 - carteBox.top) + 'px';
    chip.classList.add('is-visible');
  }

  function hideChip(){
    chip.classList.remove('is-visible');
    if (selected) selected.classList.remove('is-selected');
    selected = null;
  }

  zones.forEach(zone => {
    const slug = zone.dataset.region;
    zone.setAttribute('tabindex', '0');
    zone.setAttribute('role', 'link');
    zone.setAttribute('aria-label', 'Voir les vignerons de ' + (labels[slug] || slug));

    if (hasHover) {
      // desktop : survol = infobulle, clic direct = navigation
      zone.addEventListener('mouseenter', () => showChip(zone, slug));
      zone.addEventListener('mouseleave', hideChip);
      zone.addEventListener('click', e => { e.preventDefault(); window.location.href = urlFor(slug); });
    } else {
      // tactile : 1er tap = sélection + pastille, 2e tap (même région) = navigation
      zone.addEventListener('click', e => {
        e.preventDefault();
        if (selected === zone) { window.location.href = urlFor(slug); return; }
        if (selected) selected.classList.remove('is-selected');
        selected = zone;
        zone.classList.add('is-selected');
        showChip(zone, slug);
      });
    }

    zone.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); window.location.href = urlFor(slug); }
    });
  });

  if (!hasHover) {
    document.addEventListener('click', e => { if (!carte.contains(e.target)) hideChip(); });
  }
})();