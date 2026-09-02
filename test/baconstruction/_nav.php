<?php
/* ═══════════════════════════════════════════════════════════
   B&A Construction — Navigation partagée
   Requiert avant l'include : $logo, $SELF (nom du fichier courant,
   ex. 'index.php', 'galerie.php', 'caves-a-vin.php'...)
   et la fonction e() déjà définie dans le fichier appelant.
═══════════════════════════════════════════════════════════ */
$home = $SELF === 'index.php' ? '' : 'index.php';
?>
<nav id="main-nav">
  <a class="nav-logo" href="index.php">
    <img src="<?= e($logo) ?>" style="width:50px;height:50px" alt="Logo B&amp;A Construction">
    <div class="nav-brand">B<em>&amp;</em>A Construction</div>
  </a>
  <button class="nav-toggle" id="navToggle" aria-label="Ouvrir le menu"
          aria-expanded="false" aria-controls="navLinks">
    <span></span><span></span><span></span>
  </button>
  <ul class="nav-links" id="navLinks">
    <li><a href="<?= $home ?>#services">Services</a></li>
    <li class="has-dropdown">
      <a href="<?= $home ?>#hautdegamme">Haut de gamme</a>
      <button class="nav-sub-toggle" type="button" aria-expanded="false" aria-label="Afficher le sous-menu Haut de gamme">
        <svg class="nav-caret" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
      </button>
      <ul class="dropdown">
        <li><a href="caves-a-vin.php" class="<?= $SELF === 'caves-a-vin.php' ? 'current' : '' ?>">Caves à vin</a></li>
        <li><a href="escalier-beton.php" class="<?= $SELF === 'escalier-beton.php' ? 'current' : '' ?>">Escalier béton</a></li>
        <li><a href="beton-imprime.php" class="<?= $SELF === 'beton-imprime.php' ? 'current' : '' ?>">Finitions de qualité</a></li>
      </ul>
    </li>
    <li><a href="<?= $home ?>#realisations">Réalisations</a></li>
    <li><a href="galerie.php">Galerie</a></li>
    <li><a href="<?= $home ?>#process">Méthode</a></li>
    <li><a href="<?= $home ?>#about">À propos</a></li>
    <li><a href="<?= $home ?>#contact">Contact</a></li>
  </ul>
</nav>