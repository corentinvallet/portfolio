<?php
/* Menu principal — inclus sur toutes les pages (index + démos).
   Attend en entrée (optionnel) :
   $home = true sur index.php (ancres directes vers #approche etc.)
           false / absent ailleurs (les ancres sont alors préfixées par index.php)
*/
$home   = $home ?? false;
$prefix = $home ? '' : 'index.php';
?>
<nav>
  <a href="index.php" class="nav-logo"><img src="Photos/Logo sans texte.png" alt="Corentin Vallet" class="nav-logo-img"> Corentin <span>Vallet</span></a>
  <ul class="nav-links" id="nav-links">
    <li><a href="<?= $prefix ?>#approche">Approche</a></li>
    <li><a href="<?= $prefix ?>#services">Services</a></li>
    <li class="nav-dropdown">
      <a href="<?= $prefix ?>#projetsclients" class="nav-dropdown-trigger" aria-expanded="false">Projets clients</a>
      <ul class="nav-dropdown-menu">
        <li><a href="realisation-francisferret.php">Artiste</a></li>
      </ul>
    </li>
    <li class="nav-dropdown">
      <a href="<?= $prefix ?>#realisations" class="nav-dropdown-trigger" aria-expanded="false">Démonstrations</a>
      <ul class="nav-dropdown-menu">
        <li><a href="demo-zinc.php">Restaurant</a></li>
        <li><a href="demo-pierrard.php">Artisan</a></li>
        <li><a href="demo-terraloc.php">Commerce</a></li>
      </ul>
    </li>
    <li><a href="<?= $prefix ?>#profil">Profil</a></li>
    <!--<li><a href="blog.php">Blog</a></li>-->
    <li><a href="<?= $prefix ?>#contact">Contact</a></li>
  </ul>
  <div class="toggle-wrap">
    <span class="sun-icon">☀︎</span>
    <button class="toggle-btn" id="themeToggle" aria-label="Basculer le thème"></button>
    <span class="moon-icon">☽</span>
  </div>
  <button class="nav-burger" id="nav-burger" aria-label="Ouvrir le menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>
