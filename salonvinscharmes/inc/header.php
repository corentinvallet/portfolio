<?php
/* Attend en entrée :
   $active = '' | 'exposants' | 'equipe' | 'presse' | 'galerie' | 'faq'
             | 'voyages' | 'cours'                    (page courante, pour la classe .current)
   $home   = true sur index.php (ancres directes), false ailleurs (préfixées par index.php)
   $c      = tableau content.json (issu de load_content())
*/
$home  = $home  ?? false;
$active = $active ?? '';
$prefix = $home ? '' : 'index.php';
$logo = $c['logo'] ?? 'assets/photod/logos/salon-vins-charmes-logo-256.png';
$activiteOn = in_array($active, ['voyages', 'cours'], true);
?>
<header>
  <div class="wrap nav-row">
    <a href="<?= $home ? '#salon' : 'index.php' ?>" style="display:flex;"><img src="<?= e($logo) ?>" alt="Club Œnologie Découvertes" class="logo-img"></a>
    <nav>
      <ul>
      <li><a href="<?= $prefix ?>#salon">Le Salon</a></li>
      <li><a href="exposants-club-oenologie.php"<?= $active==='exposants' ? ' class="current"' : '' ?>>Exposants</a></li>
      <li class="has-sub">
        <button type="button" class="nav-sub-toggle<?= $activiteOn ? ' current' : '' ?>"
                aria-expanded="false" aria-controls="sub-activites">
          Activités
          <svg class="nav-caret" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <ul class="subnav" id="sub-activites">
          <li><a href="voyages-club-oenologie.php"<?= $active==='voyages' ? ' class="current"' : '' ?>>Voyages</a></li>
          <li><a href="cours-degustation-club-oenologie.php"<?= $active==='cours' ? ' class="current"' : '' ?>>Cours dégustation</a></li>
        </ul>
      </li>
      <li><a href="equipe-club-oenologie.php"<?= $active==='equipe' ? ' class="current"' : '' ?>>L'équipe</a></li>
      <li><a href="presse-club-oenologie.php"<?= $active==='presse' ? ' class="current"' : '' ?>>Presse</a></li>
      <li><a href="galerie-club-oenologie.php"<?= $active==='galerie' ? ' class="current"' : '' ?>>Galerie</a></li>
      <li><a href="faq-club-oenologie.php"<?= $active==='faq' ? ' class="current"' : '' ?>>FAQ</a></li>
    </ul></nav>
    <div class="nav-cta">
      <a href="<?= $prefix ?>#contact" class="btn-icon" aria-label="Nous contacter">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      </a>
      <button class="nav-toggle" aria-label="Ouvrir le menu" aria-expanded="false"><span></span></button>
    </div>
  </div>
</header>
