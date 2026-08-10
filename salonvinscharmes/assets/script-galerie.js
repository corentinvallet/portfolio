/* ============================================================
   Page « Galerie » — filtres par album + visionneuse
   Attend une variable globale `galPhotos` injectée par le PHP.
   ============================================================ */
(function () {
  'use strict';

  var grid = document.getElementById('galGrid');
  var lb   = document.getElementById('galLightbox');
  if (!grid || !lb || typeof galPhotos === 'undefined') return;

  var items    = Array.prototype.slice.call(grid.querySelectorAll('.gal-item'));
  var filters  = document.getElementById('galFilters');
  var countEl  = document.getElementById('galCount');
  var emptyEl  = document.getElementById('galEmpty');

  var lbImg     = document.getElementById('galLbImg');
  var lbAlbum   = document.getElementById('galLbAlbum');
  var lbLegende = document.getElementById('galLbLegende');
  var lbCounter = document.getElementById('galLbCounter');
  var btnClose  = document.getElementById('galClose');
  var btnPrev   = document.getElementById('galPrev');
  var btnNext   = document.getElementById('galNext');

  var visible    = items.slice();  // ordre de navigation dans la visionneuse
  var position   = 0;              // position courante dans `visible`
  var lastFocus  = null;

  /* ── Filtres ─────────────────────────────────────────── */
  function applyFilter(album) {
    visible = [];
    items.forEach(function (it) {
      var ok = (album === '' || it.dataset.album === album);
      it.hidden = !ok;
      if (ok) visible.push(it);
    });
    if (countEl) {
      countEl.textContent = visible.length + (visible.length > 1 ? ' photos' : ' photo');
    }
    if (emptyEl) emptyEl.hidden = visible.length > 0;
  }

  if (filters) {
    filters.addEventListener('click', function (ev) {
      var btn = ev.target.closest('.gal-chip');
      if (!btn) return;
      filters.querySelectorAll('.gal-chip').forEach(function (b) {
        b.classList.toggle('is-active', b === btn);
      });
      applyFilter(btn.dataset.album);
    });
  }

  /* ── Visionneuse ─────────────────────────────────────── */
  function preload(url) {
    if (!url) return;
    var img = new Image();
    img.src = url;
  }

  function show(pos) {
    if (pos < 0 || pos >= visible.length) return;
    position = pos;

    var photo = galPhotos[Number(visible[pos].dataset.index)];
    if (!photo) return;

    lbImg.src = photo.full;
    lbImg.alt = photo.legende || 'Photo du salon';
    lbAlbum.textContent   = photo.album || '';
    lbLegende.textContent = photo.legende || '';
    lbCounter.textContent = (pos + 1) + ' / ' + visible.length;

    var single = visible.length < 2;
    btnPrev.disabled = single;
    btnNext.disabled = single;
    btnPrev.hidden = single;
    btnNext.hidden = single;

    // pré-charge les voisines pour une navigation fluide
    if (visible.length > 1) {
      var nxt = galPhotos[Number(visible[(pos + 1) % visible.length].dataset.index)];
      var prv = galPhotos[Number(visible[(pos - 1 + visible.length) % visible.length].dataset.index)];
      preload(nxt && nxt.full);
      preload(prv && prv.full);
    }
  }

  function open(pos) {
    lastFocus = document.activeElement;
    lb.hidden = false;
    document.body.style.overflow = 'hidden';
    show(pos);
    btnClose.focus();
  }

  function close() {
    lb.hidden = true;
    document.body.style.overflow = '';
    lbImg.src = '';
    if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
  }

  function step(delta) {
    if (visible.length < 2) return;
    show((position + delta + visible.length) % visible.length);
  }

  grid.addEventListener('click', function (ev) {
    var it = ev.target.closest('.gal-item');
    if (!it) return;
    var pos = visible.indexOf(it);
    if (pos !== -1) open(pos);
  });

  btnClose.addEventListener('click', close);
  btnPrev.addEventListener('click', function () { step(-1); });
  btnNext.addEventListener('click', function () { step(1); });

  lb.addEventListener('click', function (ev) {
    if (ev.target === lb) close();
  });

  document.addEventListener('keydown', function (ev) {
    if (lb.hidden) return;
    if (ev.key === 'Escape')     { ev.preventDefault(); close(); }
    if (ev.key === 'ArrowLeft')  { ev.preventDefault(); step(-1); }
    if (ev.key === 'ArrowRight') { ev.preventDefault(); step(1); }
    if (ev.key === 'Tab') {
      // piège le focus dans la visionneuse
      var focusables = [btnClose, btnPrev, btnNext].filter(function (b) { return !b.hidden && !b.disabled; });
      if (!focusables.length) return;
      var i = focusables.indexOf(document.activeElement);
      ev.preventDefault();
      var next = ev.shiftKey
        ? (i <= 0 ? focusables.length - 1 : i - 1)
        : (i === focusables.length - 1 ? 0 : i + 1);
      focusables[next].focus();
    }
  });

  /* ── Balayage tactile ────────────────────────────────── */
  var touchX = null, touchY = null;
  lb.addEventListener('touchstart', function (ev) {
    if (ev.touches.length !== 1) return;
    touchX = ev.touches[0].clientX;
    touchY = ev.touches[0].clientY;
  }, { passive: true });

  lb.addEventListener('touchend', function (ev) {
    if (touchX === null) return;
    var dx = ev.changedTouches[0].clientX - touchX;
    var dy = ev.changedTouches[0].clientY - touchY;
    touchX = touchY = null;
    if (Math.abs(dx) > 55 && Math.abs(dx) > Math.abs(dy) * 1.4) {
      step(dx < 0 ? 1 : -1);
    }
  }, { passive: true });

  applyFilter('');
})();
