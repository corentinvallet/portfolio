/* ═══════════════════════════════════════════════════════════
   Page Voyages — filtres par type (Journée / Week-end…)
═══════════════════════════════════════════════════════════ */
(function () {
  var filters = document.getElementById('voyFilters');
  var grid    = document.getElementById('voyGrid');
  var count   = document.getElementById('voyCount');
  var empty   = document.getElementById('voyEmpty');
  if (!filters || !grid) return;

  var cards = [].slice.call(grid.querySelectorAll('.voy-card'));
  var chips = [].slice.call(filters.querySelectorAll('.voy-chip'));

  function apply(type) {
    var n = 0;
    cards.forEach(function (card) {
      var ok = (type === '' || card.getAttribute('data-type') === type);
      card.hidden = !ok;
      if (ok) n++;
    });
    if (count) count.textContent = n + ' voyage' + (n > 1 ? 's' : '');
    if (empty) empty.hidden = (n > 0);
  }

  chips.forEach(function (chip) {
    chip.addEventListener('click', function () {
      chips.forEach(function (c) { c.classList.toggle('is-active', c === chip); });
      apply(chip.getAttribute('data-type') || '');
    });
  });
})();
