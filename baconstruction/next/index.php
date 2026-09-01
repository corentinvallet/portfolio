<?php
/* ═══════════════════════════════════════════════════════════
   B&A Construction — rendu serveur depuis content.json
   Le texte est injecté côté serveur : les robots (Google) voient
   le contenu complet dans le HTML, pas après exécution du JS.
═══════════════════════════════════════════════════════════ */
$c = json_decode(@file_get_contents(__DIR__ . '/content.json'), true) ?: [];

// échappe le texte simple
function e($s) { return htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8'); }
// échappe + conserve les retours à la ligne (saut de ligne -> <br>)
function ml($s) { return nl2br(htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8')); }

$hero    = $c['hero']         ?? [];
$serv    = $c['services']     ?? [];
$cave    = $c['caveavin']     ?? [];
$hdg     = $c['hautdegamme']  ?? [];
$real    = $c['realisations'] ?? [];
$proc    = $c['process']      ?? [];
$about   = $c['about']        ?? [];
$stats   = $c['stats']        ?? [];
$contact = $c['contact']      ?? [];
$gallery = $c['gallery']      ?? [];
$logo    = $c['logo']         ?? 'Photos/Logo simplifié.webp';
$SELF    = 'index.php';

// les 3 premières réalisations alimentent l'aperçu de la page d'accueil
$preview = array_slice($gallery, 0, 3);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title><?= e($c['meta']['title'] ?? 'B&A Construction') ?></title>
  <meta name="description" content="<?= e($c['meta']['description'] ?? '') ?>"/>
  <link rel="preload" as="image" href="<?= e($hero['image'] ?? '') ?>">
  <link rel="stylesheet" href="css/base.css"/>
  <link rel="stylesheet" href="css/index.css"/>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVIGATION (commune aux deux pages)
═══════════════════════════════════════════ -->
<?php include __DIR__ . '/_nav.php'; ?>

<!-- ═══════════════════════════════════════════
     PAGE ACCUEIL
═══════════════════════════════════════════ -->
<div id="page-home" class="page active">

  <!-- HERO -->
  <section class="hero">
    <div class="hero-bg" style="background-image:url('<?= e($hero['image'] ?? '') ?>')"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <img class="hero-logo" src="<?= e($logo) ?>" alt="Logo B&amp;A Construction" fetchpriority="high"/>
      <p class="hero-eyebrow"><?= e($hero['eyebrow'] ?? '') ?></p>
      <h1>B<em>&amp;</em>A<br>Construction</h1>
      <p class="hero-names"><?= e($hero['names'] ?? '') ?></p>
      <p class="hero-sub"><?= e($hero['sub'] ?? '') ?></p>
      <div class="hero-cta">
        <a href="#realisations" class="btn-primary"><?= e($hero['ctaPrimary'] ?? '') ?></a>
        <a href="#contact" class="btn-outline"><?= e($hero['ctaSecondary'] ?? '') ?></a>
      </div>
    </div>
    <div class="scroll-hint"><span>Découvrir</span><div class="scroll-line"></div></div>
  </section>

  <!-- SERVICES -->
  <section id="services">
    <p class="section-label"><?= e($serv['label'] ?? '') ?></p>
    <h2 class="section-title"><?= ml($serv['title'] ?? '') ?></h2>
    <p class="services-intro"><?= e($serv['intro'] ?? '') ?></p>
    <div class="services-grid">
      <?php foreach (($serv['items'] ?? []) as $it): ?>
        <?php $f = $it['filter'] ?? ''; ?>
      <div class="service-card<?= $f ? ' is-link' : '' ?>"
           <?php if ($f): ?>data-cat="<?= e($f) ?>"<?php endif; ?>>
        <img src="<?= e($it['icon'] ?? '') ?>" style="width:50px;height:50px" loading="lazy" alt="<?= e($it['title'] ?? '') ?>">
        <h3><?= e($it['title'] ?? '') ?></h3>
        <p><?= e($it['text'] ?? '') ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- HAUT DE GAMME -->
  <section id="hautdegamme">
    <p class="section-label"><?= e($hdg['label'] ?? '') ?></p>
    <h2 class="section-title"><?= ml($hdg['title'] ?? '') ?></h2>
    <p class="hdg-intro"><?= e($hdg['intro'] ?? '') ?></p>
    <div class="hdg-grid">
      <?php foreach (($hdg['items'] ?? []) as $it): ?>
      <a class="hdg-card" href="<?= e($it['link'] ?? '#') ?>">
        <img src="<?= e($it['image'] ?? '') ?>" loading="lazy" alt="<?= e($it['title'] ?? '') ?>">
        <div class="hdg-overlay">
          <h3><?= e($it['title'] ?? '') ?></h3>
          <p><?= e($it['text'] ?? '') ?></p>
          <span class="hdg-cta">Découvrir <span aria-hidden="true">&rarr;</span></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- RÉALISATIONS (preview) -->
  <section id="realisations">
    <p class="section-label"><?= e($real['label'] ?? '') ?></p>
    <h2 class="section-title"><?= ml($real['title'] ?? '') ?></h2>
    <p class="section-desc"><?= e($real['desc'] ?? '') ?></p>
    <a class="gallery-link-banner" href="galerie.php">
      <span class="gallery-link-text"><?= e($real['bannerText'] ?? '') ?></span>
      <span class="gallery-link-sub"><?= e($real['bannerSub'] ?? '') ?></span>
    </a>
    <div class="gallery-grid gallery-preview">
      <?php foreach ($preview as $g): ?>
      <div class="gallery-item" data-src="<?= e($g['full'] ?? '') ?>" data-category="<?= e(implode(' ', $g['categories'] ?? ($g['category'] ? [$g['category']] : []))) ?>">
        <img src="<?= e($g['thumb'] ?? ($g['full'] ?? '')) ?>" alt="<?= e($g['caption'] ?? '') ?>" loading="lazy" width="600" height="450">
        <div class="gallery-caption"><span><?= e($g['caption'] ?? '') ?></span></div>
        <div class="preview-overlay">
          <button type="button" class="preview-cta">Voir la galerie <span class="arrow" aria-hidden="true">&rarr;</span></button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- PROCESS -->
  <section id="process">
    <p class="section-label"><?= e($proc['label'] ?? '') ?></p>
    <h2 class="section-title"><?= ml($proc['title'] ?? '') ?></h2>
    <div class="process-steps">
      <?php foreach (($proc['steps'] ?? []) as $st): ?>
      <div class="process-step"><div class="step-num"><?= e($st['num'] ?? '') ?></div><h3><?= e($st['title'] ?? '') ?></h3><p><?= e($st['text'] ?? '') ?></p></div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ABOUT -->
  <section id="about">
    <div class="about-img-wrap">
      <img src="<?= e($about['image'] ?? '') ?>" loading="lazy" alt="Équipe B&amp;A Construction au travail">
      <div class="about-badge"><strong><?= e($about['badgeNum'] ?? '') ?></strong><span><?= e($about['badgeLabel'] ?? '') ?></span></div>
    </div>
    <div class="about-text">
      <p class="section-label"><?= e($about['label'] ?? '') ?></p>
      <h2 class="section-title"><?= ml($about['title'] ?? '') ?></h2>
      <p class="section-desc" style="color:var(--brown);max-width:470px"><?= e($about['p1'] ?? '') ?></p>
      <p class="section-desc" style="color:var(--brown);max-width:470px;margin-top:14px;font-size:.9rem"><?= e($about['p2'] ?? '') ?></p>
      <div class="about-names">
        <?php foreach (($about['people'] ?? []) as $p): ?>
        <div class="about-name-card"><strong><?= e($p['name'] ?? '') ?></strong><span><?= e($p['role'] ?? '') ?></span></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <div id="stats">
    <?php foreach ($stats as $s): ?>
    <div class="stat"><div class="stat-num"><?= e($s['num'] ?? '') ?></div><div class="stat-label"><?= e($s['label'] ?? '') ?></div></div>
    <?php endforeach; ?>
  </div>

  <!-- CONTACT -->
  <section id="contact">
    <div class="contact-wrap">
      <div>
        <p class="section-label"><?= e($contact['label'] ?? '') ?></p>
        <h2 class="section-title"><?= ml($contact['title'] ?? '') ?></h2>
        <p class="section-desc"><?= e($contact['desc'] ?? '') ?></p>
        <div class="contact-info">
          <div class="contact-item"><span class="contact-icon">📞</span><div><strong>Téléphone</strong><p><?= e($contact['phone1'] ?? '') ?><br><?= e($contact['phone2'] ?? '') ?></p></div></div>
          <div class="contact-item"><span class="contact-icon">📧</span><div><strong>E-mail</strong><p><?= e($contact['email'] ?? '') ?></p></div></div>
          <div class="contact-item"><span class="contact-icon">📍</span><div><strong>Zone d'intervention</strong><p><?= ml($contact['zone'] ?? '') ?></p></div></div>
        </div>
      </div>      
      <form class="contact-form" action="https://formspree.io/f/mljroqno" method="POST">
        <input type="hidden" name="_subject" value="Nouvelle demande de contact - B&amp;A Construction">
        <input type="text" name="_gotcha" style="display:none">
        <div class="form-row">
          <input type="text" name="prenom" placeholder="Prénom" required/>
          <input type="text" name="nom" placeholder="Nom" required/>
        </div>        
        <input type="email" name="email" placeholder="Adresse e-mail" required/>
        <input type="tel" name="telephone" placeholder="Téléphone"/>
        <select name="type_projet" aria-label="Type de projet"><option value="" disabled selected>Type de projet</option><option>Terrasse béton imprimé</option><option>Plage de piscine</option><option>Allée béton désactivé</option><option>Béton ciré</option><option>Gros œuvre / Dalle</option><option>Autre</option></select>
        <textarea placeholder="Décrivez votre projet (surface, délais, contraintes…)"></textarea>
        <button type="submit" class="btn-primary">Envoyer ma demande →</button>
      </form>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-brand">
    <img class="footer-logo-circle" src="<?= e($logo) ?>" alt="Logo B&amp;A Construction">
      <div><strong>B&amp;A Construction</strong><p>Bruno Salgado · Alex Freitas</p></div>
    </div>
    <p class="footer-copy">© <?= date('Y') ?> B&amp;A Construction — Tous droits réservés</p>
    <div id="cv-signature"></div>
  </footer>

</div><!-- /page-home -->


<!-- La galerie complète est désormais une page distincte : galerie.php -->

</div>

<script src="js/index.js"></script>
<script src="https://www.corentinvallet.fr/common/widgets/signature.js?v=1" defer></script>
</body>
</html>
