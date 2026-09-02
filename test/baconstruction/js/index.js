/* ── Aperçu "Réalisations" → page galerie ──
   Les 3 vignettes de l'accueil et la bannière mènent vers galerie.php.
   Si la vignette a une catégorie, on ouvre la galerie pré-filtrée dessus. */
function goToGallery(category) {
  const first = (category || '').trim().split(/\s+/)[0] || '';
  window.location.href = 'galerie.php' + (first ? '?cat=' + encodeURIComponent(first) : '');
}

(function(){
  const previews = document.querySelectorAll('.gallery-preview .gallery-item');

  previews.forEach(item => {
    const cta = item.querySelector('.preview-cta');
    let touched = false;   // un tap tactile vient d'avoir lieu sur cette vignette

    // Le bouton navigue toujours (souris et tactile).
    if (cta) {
      cta.addEventListener('click', e => {
        e.stopPropagation();
        goToGallery(item.dataset.category);
      });
    }

    // ── Souris / stylet : survol simulé en JS (pas de :hover CSS). ──
    item.addEventListener('pointerenter', e => {
      if (e.pointerType !== 'touch') item.classList.add('is-hover');
    });
    item.addEventListener('pointerleave', () => item.classList.remove('is-hover'));
    item.addEventListener('click', e => {
      if (touched) return;                            // tap tactile déjà traité
      if (e.target.closest('.preview-cta')) return;   // géré par le bouton
      goToGallery(item.dataset.category);             // souris : clic vignette → galerie
    });

    // ── Tactile : tap révèle / re-tap referme / tap sur le bouton navigue. ──
    let sx = 0, sy = 0, moved = false;
    item.addEventListener('touchstart', e => {
      const t = e.touches[0]; sx = t.clientX; sy = t.clientY; moved = false;
    }, {passive:true});
    item.addEventListener('touchmove', e => {
      const t = e.touches[0];
      if (Math.abs(t.clientX - sx) > 8 || Math.abs(t.clientY - sy) > 8) moved = true;
    }, {passive:true});
    item.addEventListener('touchend', e => {
      if (moved) return;                              // c'était un défilement
      touched = true; setTimeout(() => { touched = false; }, 700);
      e.preventDefault();                             // tue le ghost-click + le survol fantôme
      item.classList.remove('is-hover');
      if (e.target.closest('.preview-cta')) { goToGallery(item.dataset.category); return; }
      const open = item.classList.contains('is-revealed');
      previews.forEach(p => p.classList.remove('is-revealed'));
      if (!open) item.classList.add('is-revealed');
    }, {passive:false});
  });

  // Un tap/clic en dehors d'une vignette referme l'overlay tactile.
  document.addEventListener('click', e => {
    if (!e.target.closest('.gallery-preview .gallery-item')) {
      previews.forEach(p => p.classList.remove('is-revealed'));
    }
  });
})();
(function(){
  const cards = document.querySelectorAll('.service-card.is-link');

  cards.forEach(card => {
    const cat = card.dataset.cat;
    let touched = false;   // un tap tactile vient d'avoir lieu

    // ── Souris : survol simulé + clic = lien direct ──
    card.addEventListener('pointerenter', e => {
      if (e.pointerType !== 'touch') card.classList.add('is-hover');
    });
    card.addEventListener('pointerleave', () => card.classList.remove('is-hover'));
    card.addEventListener('click', () => {
      if (touched) return;        // tap tactile déjà traité
      goToGallery(cat);           // souris : 1 clic suffit
    });

    // ── Tactile : 1er tap révèle, 2e tap navigue ──
    let sx = 0, sy = 0, moved = false;
    card.addEventListener('touchstart', e => {
      const t = e.touches[0]; sx = t.clientX; sy = t.clientY; moved = false;
    }, {passive:true});
    card.addEventListener('touchmove', e => {
      const t = e.touches[0];
      if (Math.abs(t.clientX - sx) > 8 || Math.abs(t.clientY - sy) > 8) moved = true;
    }, {passive:true});
    card.addEventListener('touchend', e => {
      if (moved) return;                          // c'était un défilement
      touched = true; setTimeout(() => { touched = false; }, 700);
      e.preventDefault();                         // tue le ghost-click + le survol fantôme
      const open = card.classList.contains('is-revealed');
      cards.forEach(c => c.classList.remove('is-revealed'));
      if (open) goToGallery(cat);                 // 2e tap → lien
      else      card.classList.add('is-revealed');// 1er tap → révèle
    }, {passive:false});
  });

  // Un tap en dehors d'une carte referme la révélation tactile.
  document.addEventListener('click', e => {
    if (!e.target.closest('.service-card.is-link')) {
      cards.forEach(c => c.classList.remove('is-revealed'));
    }
  });
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
  (function(){
  const form = document.getElementById('contactForm');
  if (!form) return;
  const msg = document.getElementById('formMessage');
  const btn = form.querySelector('button[type="submit"]');

  form.addEventListener('submit', async e => {
    e.preventDefault();
    btn.disabled = true;
    btn.textContent = 'Envoi en cours…';

    try {
      const res = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'Accept': 'application/json' }
      });

      if (res.ok) {
        msg.textContent = 'Merci, votre demande a bien été envoyée. Nous vous répondons rapidement.';
        msg.className = 'form-message is-visible is-success';
        form.reset();
        btn.textContent = 'Demande envoyée ✓';
      } else {
        throw new Error('Erreur serveur');
      }
    } catch (err) {
      msg.textContent = "Une erreur est survenue. Vous pouvez aussi nous appeler directement.";
      msg.className = 'form-message is-visible is-error';
      btn.disabled = false;
      btn.textContent = 'Envoyer ma demande →';
    }
  });
})();
})();