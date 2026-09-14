/* ═══════════════════════════════════════════════════════════
   Page Sponsors — filtres par catégorie
═══════════════════════════════════════════════════════════ */
(function () {
  var filters = document.getElementById('spoFilters');
  var grid    = document.getElementById('spoGrid');
  var count   = document.getElementById('spoCount');
  var empty   = document.getElementById('spoEmpty');
  if (!filters || !grid) return;

  var cards = [].slice.call(grid.querySelectorAll('.spo-card'));
  var chips = [].slice.call(filters.querySelectorAll('.spo-chip'));

  function apply(cat) {
    var n = 0;
    cards.forEach(function (card) {
      var ok = (cat === '' || card.getAttribute('data-cat') === cat);
      card.hidden = !ok;
      if (ok) n++;
    });
    if (count) count.textContent = n + ' partenaire' + (n > 1 ? 's' : '');
    if (empty) empty.hidden = (n > 0);
  }

  chips.forEach(function (chip) {
    chip.addEventListener('click', function () {
      chips.forEach(function (c) { c.classList.toggle('is-active', c === chip); });
      apply(chip.getAttribute('data-cat') || '');
    });
  });
})();
