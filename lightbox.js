/* ── LIGHTBOX (partagé entre toutes les pages demo-*.php) ── */
(function () {
  const lightbox = document.getElementById('lightbox');
  if (!lightbox) return; // page sans lightbox : on ne fait rien

  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxCaption = document.getElementById('lightboxCaption');
  const galleryImgs = Array.from(document.querySelectorAll('.feature-icon img'));
  let currentIndex = 0;

  function openLightbox(index) {
    currentIndex = index;
    const img = galleryImgs[currentIndex];
    lightboxImg.src = img.src;
    lightboxImg.alt = img.alt;
    lightboxCaption.textContent = img.alt;
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
  }

  function showImage(delta) {
    currentIndex = (currentIndex + delta + galleryImgs.length) % galleryImgs.length;
    const img = galleryImgs[currentIndex];
    lightboxImg.src = img.src;
    lightboxImg.alt = img.alt;
    lightboxCaption.textContent = img.alt;
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
