/* ── NAV — fichier partagé, inclus sur toutes les pages ── */
document.addEventListener('DOMContentLoaded', () => {
  const burger = document.getElementById('nav-burger');
  const navLinks = document.getElementById('nav-links');
  const dropdownLi = document.querySelector('.nav-dropdown');
  const dropdownTrigger = document.querySelector('.nav-dropdown-trigger');

  if (!burger || !navLinks) return;

  burger.addEventListener('click', () => {
    const isOpen = navLinks.classList.toggle('open');
    burger.setAttribute('aria-expanded', isOpen);
  });

  /* Accordéon "Démonstrations" en mobile */
  if (dropdownLi && dropdownTrigger) {
    dropdownTrigger.addEventListener('click', (e) => {
      if (window.innerWidth <= 900) {
        e.preventDefault();
        const isOpen = dropdownLi.classList.toggle('is-open');
        dropdownTrigger.setAttribute('aria-expanded', isOpen);
      }
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth > 900) {
        dropdownLi.classList.remove('is-open');
        dropdownTrigger.setAttribute('aria-expanded', 'false');
      }
    });
  }

  // Ferme tout quand on clique sur un lien (sauf le trigger "Démonstrations",
  // qui gère lui-même son accordéon en mobile)
  navLinks.querySelectorAll('a').forEach(link => {
    if (link === dropdownTrigger) return;
    link.addEventListener('click', () => {
      navLinks.classList.remove('open');
      burger.setAttribute('aria-expanded', 'false');
      if (dropdownLi) dropdownLi.classList.remove('is-open');
      if (dropdownTrigger) dropdownTrigger.setAttribute('aria-expanded', 'false');
    });
  });
});
