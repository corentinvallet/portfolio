/* ===========================================
   LIGHTBOX - zoom + navigation + glisser
   Partagé entre galerie.php et les pages haut de gamme
   Nécessite : #lightbox + éléments .gallery-item sur la page
=========================================== */
(function(){
  const lb       = document.getElementById('lightbox');
  const stage    = document.getElementById('lb-stage');
  const caption  = document.getElementById('lb-caption');
  const counter  = document.getElementById('lb-counter');
  const closeBtn = document.getElementById('lb-close');
  const prevBtn  = document.getElementById('lb-prev');
  const nextBtn  = document.getElementById('lb-next');
  if (!lb || !stage) return;

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