/* ── LIGHTBOX (partagé entre toutes les pages demo-*.php) ── */
(function () {
  const lightbox = document.getElementById('lightbox');
  if (!lightbox) return; // page sans lightbox : on ne fait rien

  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxCaption = document.getElementById('lightboxCaption');
  const galleryImgs = Array.from(document.querySelectorAll('.feature-icon img'));
  let currentIndex = 0;

  /* ── ZOOM / PAN TACTILE (pincement à 2 doigts, glisser à 1 doigt une fois zoomé) ── */
  let scale = 1, translateX = 0, translateY = 0;
  let startDist = 0, startScale = 1;
  let startX = 0, startY = 0, startTranslateX = 0, startTranslateY = 0;
  let panning = false;
  const MIN_SCALE = 1, MAX_SCALE = 4;

  function applyTransform(withTransition) {
    lightboxImg.style.transition = withTransition ? 'transform 0.25s ease' : 'none';
    lightboxImg.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scale})`;
  }

  function resetZoom(withTransition) {
    scale = 1; translateX = 0; translateY = 0;
    applyTransform(withTransition);
    // on efface le style inline après l'animation pour laisser l'ouverture (scale 0.96→1) reprendre la main
    if (withTransition) {
      setTimeout(() => { if (scale === 1) lightboxImg.style.transform = ''; }, 260);
    } else {
      lightboxImg.style.transform = '';
    }
  }

  function touchDistance(touches) {
    const dx = touches[0].clientX - touches[1].clientX;
    const dy = touches[0].clientY - touches[1].clientY;
    return Math.sqrt(dx * dx + dy * dy);
  }

  lightboxImg.addEventListener('touchstart', (e) => {
    if (e.touches.length === 2) {
      startDist = touchDistance(e.touches);
      startScale = scale;
      panning = false;
    } else if (e.touches.length === 1 && scale > 1) {
      panning = true;
      startX = e.touches[0].clientX;
      startY = e.touches[0].clientY;
      startTranslateX = translateX;
      startTranslateY = translateY;
    }
  }, { passive: true });

  lightboxImg.addEventListener('touchmove', (e) => {
    if (e.touches.length === 2) {
      e.preventDefault();
      const dist = touchDistance(e.touches);
      scale = Math.min(MAX_SCALE, Math.max(MIN_SCALE, startScale * (dist / startDist)));
      applyTransform(false);
    } else if (e.touches.length === 1 && panning) {
      e.preventDefault();
      translateX = startTranslateX + (e.touches[0].clientX - startX);
      translateY = startTranslateY + (e.touches[0].clientY - startY);
      applyTransform(false);
    }
  }, { passive: false });

  lightboxImg.addEventListener('touchend', (e) => {
    panning = false;
    if (e.touches.length === 0 && scale <= 1) {
      resetZoom(true);
    }
  });

  // double-tap pour zoomer / dézoomer rapidement
  let lastTap = 0;
  lightboxImg.addEventListener('touchend', (e) => {
    if (e.changedTouches.length !== 1) return;
    const now = Date.now();
    if (now - lastTap < 300) {
      if (scale > 1) {
        resetZoom(true);
      } else {
        scale = 2.2;
        applyTransform(true);
      }
    }
    lastTap = now;
  });

  function openLightbox(index) {
    currentIndex = index;
    const img = galleryImgs[currentIndex];
    lightboxImg.src = img.src;
    lightboxImg.alt = img.alt;
    lightboxCaption.textContent = img.alt;
    resetZoom(false);
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
    resetZoom(false);
  }

  function showImage(delta) {
    currentIndex = (currentIndex + delta + galleryImgs.length) % galleryImgs.length;
    const img = galleryImgs[currentIndex];
    lightboxImg.src = img.src;
    lightboxImg.alt = img.alt;
    lightboxCaption.textContent = img.alt;
    resetZoom(false);
  }

  galleryImgs.forEach((img, index) => {
    img.addEventListener('click', () => openLightbox(index));
  });

  document.getElementById('lightboxClose').addEventListener('click', closeLightbox);
  document.getElementById('lightboxPrev').addEventListener('click', () => showImage(-1));
  document.getElementById('lightboxNext').addEventListener('click', () => showImage(1));

  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) closeLightbox();
  });

  document.addEventListener('keydown', (e) => {
    if (!lightbox.classList.contains('open')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') showImage(-1);
    if (e.key === 'ArrowRight') showImage(1);
  });
})();