<?php
/* ═══════════════════════════════════════════════════════════
   Club Œnologie Découvertes — rendu serveur depuis content.json
   Le texte est injecté côté serveur : les robots (Google) voient
   le contenu complet dans le HTML, pas après exécution du JS.
═══════════════════════════════════════════════════════════ */
require __DIR__ . '/inc/functions.php';
$c = load_content();

$hero    = $c['hero']         ?? [];
$stats   = $c['stats']        ?? [];
$expo    = $c['exposantsHome']?? [];
$acti    = $c['activites']    ?? [];
$equipe  = $c['equipeHome']   ?? [];
$presse  = $c['presseHome']   ?? [];
$sponsors = $c['sponsors']    ?? [];
$contact = $c['contact']      ?? [];

$home = true; $active = '';
$heroImg = $hero['image'] ?? '';
$heroDesktop = cl_tr($heroImg, 'f_auto,q_auto,w_1920');
$heroMobile  = cl_tr($heroImg, 'f_auto,q_auto,c_fill,ar_4:5,g_auto,w_900');
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($c['meta']['title'] ?? 'Club Œnologie Découvertes') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
<?php if ($heroDesktop !== ''): ?>
<link rel="preload" as="image" href="<?= e($heroDesktop) ?>" media="(min-width:901px)">
<link rel="preload" as="image" href="<?= e($heroMobile) ?>" media="(max-width:900px)">
<style>
  .hero{ --hero-photo:url('<?= e($heroDesktop) ?>'); }
  @media (max-width:900px){ .hero{ --hero-photo:url('<?= e($heroMobile) ?>'); } }
</style>
<?php endif; ?>
<style>
  /* --- styles propres à la page d'accueil --- */
  .logo-img{height:44px;}
  footer{padding:50px 0 30px;border-top:none;text-align:left;}

  /* --- hero --- */
  .hero{
    position:relative;overflow:hidden;
    background-color:var(--ink);
    background-image:var(--hero-photo, none);
    background-size:cover;
    background-position:center 62%;
    background-repeat:no-repeat;
    color:var(--paper);
    padding:110px 0 90px;
  }
  .hero::before{
    content:"";position:absolute;inset:0;
    background:
      radial-gradient(560px 560px at 88% -8%, rgba(122,75,176,0.55), transparent 60%),
      radial-gradient(420px 420px at 8% 108%, rgba(226,144,63,0.28), transparent 65%),
      linear-gradient(to bottom,
        rgba(27,20,64,0.72) 0%,
        rgba(27,20,64,0.76) 45%,
        rgba(122,31,61,0.80) 100%);
    pointer-events:none;
  }
  .hero-grid{position:relative;display:grid;grid-template-columns:1.1fr 0.9fr;gap:56px;align-items:center;}
  @media (max-width:900px){.hero-grid{grid-template-columns:1fr;}}
  .eyebrow{
    display:inline-flex;align-items:center;gap:8px;
    font-size:0.82rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;
    color:#F2BC7A;;margin-bottom:22px;
  }
  .hero h1{font-size:clamp(2.4rem, 5vw, 3.6rem);line-height:1.04;}
  .hero h1 em{font-style:italic;color:#C9A7EA;font-weight:500;}
  .hero p.lede{
    margin-top:22px;max-width:46ch;font-size:1.08rem;line-height:1.6;
    color:rgba(247,242,231,0.82);
  }
  .hero-actions{margin-top:36px;display:flex;gap:14px;flex-wrap:wrap;}
  .hero-actions .btn-solid{background:var(--amber);border-color:var(--amber);color:var(--ink);}
  .hero-actions .btn-solid:hover{background:var(--paper);border-color:var(--paper);}
  .hero-actions .btn-ghost{border-color:rgba(247,242,231,0.5);color:var(--paper);}
  .hero-actions .btn-ghost:hover{background:var(--paper);color:var(--ink);}

  /* wax-seal / cachet de cire — élément signature */
  .seal-wrap{display:flex;justify-content:center;}
  .seal{
    position:relative;width:280px;height:280px;border-radius:50%;
    background:
      radial-gradient(circle at 32% 28%, rgba(255,255,255,0.18), transparent 45%),
      conic-gradient(from 210deg, var(--bordeaux), var(--grape), var(--amber), var(--bordeaux));
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 30px 60px -20px rgba(0,0,0,0.55);
  }
  .seal::after{
    content:"";position:absolute;inset:14px;border-radius:50%;
    border:2px dashed rgba(247,242,231,0.35);
  }
  .seal-inner{
    text-align:center;font-family:'Fraunces',serif;color:var(--paper);
  }
  .seal-inner .num{font-size:2.6rem;font-weight:700;line-height:1;}
  .seal-inner .lbl{font-size:0.72rem;letter-spacing:0.14em;text-transform:uppercase;margin-top:6px;display:block;}

  /* --- stat band --- */
  .stats{background:var(--paper-2);padding:44px 0;border-bottom:1px solid rgba(27,20,64,0.08);}
  .stats-row{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;text-align:center;}
  @media (max-width:700px){.stats-row{grid-template-columns:1fr;}}
  .stat .num{font-family:'Fraunces',serif;font-size:2.6rem;font-weight:700;color:var(--bordeaux);}
  .stat .lbl{font-size:0.9rem;color:var(--ink-soft);margin-top:4px;}

  /* --- section shell --- */
  section.block{padding:96px 0;}
  .section-head{max-width:640px;margin-bottom:52px;}
  .section-head .tag{
    font-size:0.8rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;
    color:var(--grape);display:flex;align-items:center;gap:8px;margin-bottom:14px;
  }
  .section-head h2{font-size:clamp(1.8rem,3vw,2.4rem);}
  .section-head p{margin-top:14px;color:var(--ink-soft);line-height:1.6;}

  /* --- exposants cards --- */
  .card-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:26px;}
  @media (max-width:900px){.card-grid{grid-template-columns:repeat(2,1fr);}}
  @media (max-width:600px){.card-grid{grid-template-columns:1fr;}}
  .card{
    background:#fff;border-radius:18px;padding:30px 26px;
    border:1px solid rgba(27,20,64,0.08);
    transition:transform .2s ease, box-shadow .2s ease;
  }
  .card:hover{transform:translateY(-6px);box-shadow:0 24px 40px -24px rgba(27,20,64,0.28);}
  .card .icon{
    width:46px;height:46px;border-radius:12px;
    display:flex;align-items:center;justify-content:center;
    background:var(--ink);color:var(--paper);margin-bottom:18px;font-family:'Fraunces',serif;font-weight:700;
  }
  .card h3{font-size:1.15rem;margin-bottom:8px;}
  .card p{color:var(--ink-soft);font-size:0.94rem;line-height:1.55;margin:0;}
  .card .more{
    display:inline-block;margin-top:16px;font-size:0.85rem;font-weight:600;color:var(--bordeaux);
    text-decoration:none;border-bottom:1.5px solid transparent;
  }
  .card .more:hover{border-color:var(--bordeaux);}

  /* --- activités split --- */
  .split{display:grid;grid-template-columns:1fr 1fr;gap:26px;}
  @media (max-width:800px){.split{grid-template-columns:1fr;}}
  .panel{
    border-radius:20px;padding:40px 34px;color:var(--paper);position:relative;overflow:hidden;
  }
  .panel.voyages{background:linear-gradient(140deg,var(--grape),#5a3487);}
  .panel.cours{background:linear-gradient(140deg,var(--bordeaux),#4d1428);}
  .panel .accent-hand{font-size:1.6rem;display:block;margin-bottom:6px;color:var(--amber);}
  .panel h3{font-size:1.5rem;margin-bottom:12px;color:var(--paper);}
  .panel p{color:rgba(247,242,231,0.85);line-height:1.6;margin-bottom:22px;}
  .panel .btn{border-color:rgba(247,242,231,0.6);color:var(--paper);}
  .panel .btn:hover{background:var(--paper);color:var(--ink);}

  /* --- équipe --- */
  .team-row{display:flex;gap:20px;flex-wrap:wrap;}
  .team-chip{
    display:flex;align-items:center;gap:12px;
    background:#fff;border:1px solid rgba(27,20,64,0.08);
    border-radius:100px;padding:8px 18px 8px 8px;
  }
  .team-chip .dot{
    width:38px;height:38px;border-radius:50%;
    background:var(--amber);color:var(--ink);font-family:'Fraunces',serif;font-weight:700;
    display:flex;align-items:center;justify-content:center;font-size:0.95rem;
  }
  .team-chip .role{font-size:0.78rem;color:var(--ink-soft);}
  .team-chip .name{font-weight:600;font-size:0.92rem;}

  /* --- presse --- */
  .presse-band{background:var(--ink);color:var(--paper);padding:70px 0;}
  .presse-band .section-head .tag{color:var(--amber);}
  .presse-band .section-head h2{color:var(--paper);}
  .presse-band .section-head p{color:rgba(247,242,231,0.75);}
  .presse-list{display:flex;gap:16px;flex-wrap:wrap;}
  .presse-pill{
    border:1px solid rgba(247,242,231,0.25);
    border-radius:12px;padding:16px 20px;font-size:0.9rem;min-width:220px;flex:1;
  }
  .presse-pill .src{font-weight:700;color:var(--amber);display:block;margin-bottom:4px;}

  /* --- footer --- */
  .foot-row{display:flex;justify-content:space-between;flex-wrap:wrap;gap:20px;font-size:0.85rem;color:var(--ink-soft);}
  .foot-links{display:flex;gap:20px;list-style:none;padding:0;margin:0;flex-wrap:wrap;}
  .foot-links a{text-decoration:none;}
  .foot-links a:hover{color:var(--grape);}
  .warning{
    margin-top:28px;padding-top:20px;border-top:1px solid rgba(27,20,64,0.1);
    font-size:0.78rem;color:var(--ink-soft);text-align:center;
  }
  /* --- formulaire de contact (Formspree) --- */
  .contact-form-wrap{
    margin-top:36px;padding-top:36px;border-top:1px solid var(--line);
  }
  .contact-form-wrap h3{
    font-size:1.2rem;color:var(--ink);margin:0 0 6px;
  }
  .contact-form-wrap .sub{
    color:var(--ink-soft);font-size:0.9rem;margin:0 0 22px;
  }
  .contact-form{
    display:grid;grid-template-columns:1fr 1fr;gap:16px;max-width:640px;
  }
  .contact-form .field-full{grid-column:1 / -1;}
  .contact-form label{
    display:block;font-size:0.8rem;font-weight:600;color:var(--ink);margin-bottom:6px;
  }
  .contact-form input,
  .contact-form textarea{
    width:100%;padding:12px 14px;border-radius:10px;
    border:1.5px solid var(--line);background:#fff;
    font-family:inherit;font-size:0.92rem;color:var(--ink);
    transition:border-color .2s ease;
  }
  .contact-form input:focus,
  .contact-form textarea:focus{
    outline:none;border-color:var(--grape);
  }
  .contact-form textarea{resize:vertical;min-height:110px;}
  .contact-form .field-full > button{margin-top:4px;}
  .contact-form .form-note{
    grid-column:1 / -1;font-size:0.78rem;color:var(--ink-soft);margin-top:-6px;
  }
  .contact-form .form-status{
    grid-column:1 / -1;font-size:0.88rem;font-weight:600;display:none;
  }
  .contact-form .form-status.is-success{display:block;color:var(--grape);}
  .contact-form .form-status.is-error{display:block;color:var(--bordeaux);}
  @media (max-width:640px){
    .contact-form{grid-template-columns:1fr;}
  }
   /* --- bande sponsors --- */
  .sponsors{
    background:var(--paper-2);
    padding:56px 0 60px;
    border-top:1px solid rgba(27,20,64,0.08);
    border-bottom:1px solid rgba(27,20,64,0.08);
    overflow:hidden;
  }
  .sponsors-title{
    font-family:'Inter',sans-serif;
    font-size:0.8rem;font-weight:700;
    letter-spacing:0.12em;text-transform:uppercase;
    color:var(--grape);
    display:flex;align-items:center;justify-content:center;gap:8px;
    margin:0 0 30px;
  }
  .sponsors-viewport{
    overflow:hidden;
    -webkit-mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent);
            mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent);
  }
  .sponsors-track{
    display:flex;align-items:center;gap:56px;
    list-style:none;margin:0;padding:0;width:max-content;
    animation:sponsors-scroll calc(var(--count) * 4s) linear infinite;
  }
  .sponsors-viewport:hover .sponsors-track{animation-play-state:paused;}
  .sponsors-viewport:has(a:focus-visible) .sponsors-track{animation-play-state:paused;}
  .sponsors-item{flex:0 0 auto;}
  .sponsors-item img{
    display:block;height:60px;width:auto;max-width:180px;object-fit:contain;
    filter:grayscale(1);opacity:.6;
    transition:filter .3s ease, opacity .3s ease, transform .3s ease;
  }
  .sponsors-item a:hover img,
  .sponsors-item a:focus-visible img{filter:grayscale(0);opacity:1;transform:scale(1.05);}
  .sponsors-item a:focus-visible{outline:2px solid var(--grape);outline-offset:6px;border-radius:4px;}
  @keyframes sponsors-scroll{
    from{transform:translateX(0);}
    to{transform:translateX(calc(-100% / var(--repeat)));}
  }
  @media (max-width:700px){
    .sponsors{padding:40px 0 44px;}
    .sponsors-track{gap:34px;}
    .sponsors-item img{height:46px;max-width:140px;}
  }
  @media (prefers-reduced-motion:reduce){
    .sponsors-track{
      animation:none;width:100%;flex-wrap:wrap;justify-content:center;gap:28px 44px;
    }
    .sponsors-item[aria-hidden="true"]{display:none;}
    .sponsors-item img{filter:none;opacity:1;}
  }
</style>
</head>
<body>

<?php include __DIR__ . '/inc/header.php'; ?>

<section class="hero" id="salon">
  <div class="wrap hero-grid">
    <div>
      <span class="eyebrow">
        <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
        <?= e($hero['eyebrow'] ?? '') ?>
      </span>
      <h1><?= emph($hero['title'] ?? '') ?></h1>
      <p class="lede"><?= ml($hero['lede'] ?? '') ?></p>
      <div class="hero-actions">
        <a href="exposants-club-oenologie.php" class="btn btn-solid"><?= e($hero['ctaPrimary'] ?? '') ?></a>
        <a href="#activites" class="btn btn-ghost"><?= e($hero['ctaSecondary'] ?? '') ?></a>
      </div>
    </div>
    <div class="seal-wrap">
      <div class="seal">
        <div class="seal-inner">
          <span class="num"><?= e($hero['sealNum'] ?? '') ?></span>
          <span class="lbl"><?= e($hero['sealLabel'] ?? '') ?></span>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="stats">
  <div class="wrap stats-row">
    <?php foreach ($stats as $s): ?>
    <div class="stat"><div class="num"><?= e($s['num'] ?? '') ?></div><div class="lbl"><?= e($s['label'] ?? '') ?></div></div>
    <?php endforeach; ?>
  </div>
</div>

<section class="block" id="exposants">
  <div class="wrap">
    <div class="section-head">
      <span class="tag">
        <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
        <?= e($expo['tag'] ?? '') ?>
      </span>
      <h2><?= e($expo['title'] ?? '') ?></h2>
      <p><?= ml($expo['intro'] ?? '') ?></p>
    </div>
    <div class="card-grid">
      <?php foreach (($expo['cards'] ?? []) as $card): ?>
      <div class="card">
        <div class="icon"><?= e($card['icon'] ?? '') ?></div>
        <h3><?= e($card['title'] ?? '') ?></h3>
        <p><?= ml($card['text'] ?? '') ?></p>
        <a href="<?= e($card['linkHref'] ?? '#') ?>" class="more"><?= e($card['linkText'] ?? '') ?></a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php
$sponsorItems = array_values(array_filter($sponsors['items'] ?? [], fn($s) => !empty($s['logo'])));
if ($sponsorItems):
    // On répète la liste pour remplir la piste sans trou visible
    $sponsorRepeat = max(2, (int) ceil(10 / count($sponsorItems)));
?>
<div class="sponsors">
  <div class="wrap">
    <h2 class="sponsors-title">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($sponsors['titre'] ?? 'Ils soutiennent le salon') ?>
    </h2>
    <div class="sponsors-viewport">
      <ul class="sponsors-track" style="--repeat:<?= $sponsorRepeat ?>;--count:<?= count($sponsorItems) ?>;">
        <?php for ($r = 0; $r < $sponsorRepeat; $r++): ?>
          <?php foreach ($sponsorItems as $sp): ?>
          <li class="sponsors-item"<?= $r > 0 ? ' aria-hidden="true"' : '' ?>>
            <?php if (!empty($sp['url'])): ?>
            <a href="<?= e($sp['url']) ?>" target="_blank" rel="noopener noreferrer"<?= $r > 0 ? ' tabindex="-1"' : '' ?>>
            <?php endif; ?>
            <img src="<?= e(cl_tr($sp['logo'], 'f_auto,q_auto,h_180')) ?>"
                 alt="<?= e($sp['nom'] ?? '') ?>" loading="lazy" decoding="async">
            <?php if (!empty($sp['url'])): ?></a><?php endif; ?>
          </li>
          <?php endforeach; ?>
        <?php endfor; ?>
      </ul>
    </div>
  </div>
</div>
<?php endif; ?>
<section class="block" id="activites">
  <div class="wrap">
    <div class="section-head">
      <span class="tag">
        <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
        <?= e($acti['tag'] ?? '') ?>
      </span>
      <h2><?= e($acti['title'] ?? '') ?></h2>
      <p><?= ml($acti['intro'] ?? '') ?></p>
    </div>
    <div class="split">
      <?php foreach (($acti['panels'] ?? []) as $p): ?>
      <div class="panel <?= e($p['variant'] ?? '') ?>">
        <span class="accent-hand"><?= e($p['tagline'] ?? '') ?></span>
        <h3><?= e($p['title'] ?? '') ?></h3>
        <p><?= ml($p['text'] ?? '') ?></p>
        <a href="<?= e($p['href'] ?? '#') ?>" class="btn"><?= e($p['cta'] ?? '') ?></a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="block" id="equipe">
  <div class="wrap">
    <div class="section-head">
      <span class="tag">
        <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
        <?= e($equipe['tag'] ?? '') ?>
      </span>
      <h2><?= e($equipe['title'] ?? '') ?></h2>
      <p><?= ml($equipe['intro'] ?? '') ?></p>
    </div>
    <div class="team-row">
      <?php foreach (($equipe['members'] ?? []) as $m): ?>
      <div class="team-chip"><div class="dot"><?= e($m['initials'] ?? '') ?></div><div><div class="name"><?= e($m['name'] ?? '') ?></div><div class="role"><?= e($m['role'] ?? '') ?></div></div></div>
      <?php endforeach; ?>
    </div>
    <a href="equipe-club-oenologie.php" class="more" style="display:inline-block;margin-top:22px;color:var(--bordeaux);text-decoration:none;font-weight:600;font-size:0.9rem;">Voir toute l'équipe →</a>
  </div>
</section>

<div class="presse-band" id="presse">
  <div class="wrap">
    <div class="section-head">
      <span class="tag"><?= e($presse['tag'] ?? '') ?></span>
      <h2><?= e($presse['title'] ?? '') ?></h2>
      <p><?= ml($presse['intro'] ?? '') ?></p>
    </div>
    <div class="presse-list">
      <?php foreach (($presse['items'] ?? []) as $it): ?>
      <div class="presse-pill"><span class="src"><?= e($it['source'] ?? '') ?></span><?= e($it['text'] ?? '') ?> — <?= e($it['date'] ?? '') ?></div>
      <?php endforeach; ?>
    </div>
    <a href="presse-club-oenologie.php" class="more" style="display:inline-block;margin-top:22px;color:var(--amber);text-decoration:none;font-weight:600;font-size:0.9rem;">Voir toute la revue de presse →</a>
  </div>
</div>

<footer id="contact">
  <div class="wrap">
    <div class="foot-row">
      <img src="<?= e($c['logo'] ?? 'assets/logo-cod.png') ?>" alt="Club Œnologie Découvertes" class="logo-img">
      <ul class="foot-links">
        <li><a href="#contact">Nous contacter</a></li>
        <li><a href="#">FAQ</a></li>
        <li><a href="<?= e($contact['facebook'] ?? '#') ?>">Facebook</a></li>
        <li><a href="<?= e($contact['instagram'] ?? '#') ?>">Instagram</a></li>
        <li><a href="<?= e($contact['mentionsLegales'] ?? '#') ?>">Mentions légales</a></li>
      </ul>
    </div>
    <div class="contact-form-wrap">
      <h3>Nous contacter</h3>
      <p class="sub">Une question sur le salon, un partenariat, une suggestion ? Écrivez-nous.</p>

      <form class="contact-form" id="contact-form" action="https://formspree.io/f/VOTRE_FORM_ID" method="POST">
        <div>
          <label for="cf-name">Nom</label>
          <input type="text" id="cf-name" name="name" required autocomplete="name">
        </div>
        <div>
          <label for="cf-email">Email</label>
          <input type="email" id="cf-email" name="_replyto" required autocomplete="email">
        </div>
        <div class="field-full">
          <label for="cf-subject">Sujet</label>
          <input type="text" id="cf-subject" name="_subject" value="Message depuis le site — Club Œnologie Découvertes">
        </div>
        <div class="field-full">
          <label for="cf-message">Message</label>
          <textarea id="cf-message" name="message" required></textarea>
        </div>
        <!-- Piège à robots (honeypot) : champ invisible, doit rester vide -->
        <input type="text" name="_gotcha" style="display:none" tabindex="-1" autocomplete="off">

        <div class="field-full">
          <button type="submit" class="btn btn-solid">Envoyer le message</button>
        </div>
        <p class="form-note">En envoyant ce formulaire, vous acceptez d'être recontacté par le Club Œnologie Découvertes.</p>
        <p class="form-status" id="contact-form-status"></p>
      </form>
    </div>

    <div class="warning"><?= e($contact['warning'] ?? '') ?></div>
  </div>
</footer>

<script>
(function(){
  var form = document.getElementById('contact-form');
  var status = document.getElementById('contact-form-status');
  if(!form) return;
  form.addEventListener('submit', function(e){
    e.preventDefault();
    status.className = 'form-status';
    status.textContent = '';
    fetch(form.action, {
      method: 'POST',
      body: new FormData(form),
      headers: { 'Accept': 'application/json' }
    }).then(function(response){
      if(response.ok){
        status.textContent = 'Merci, votre message a bien été envoyé !';
        status.className = 'form-status is-success';
        form.reset();
      } else {
        response.json().then(function(data){
          status.textContent = (data && data.errors)
            ? data.errors.map(function(err){ return err.message; }).join(', ')
            : 'Une erreur est survenue. Merci de réessayer.';
          status.className = 'form-status is-error';
        }).catch(function(){
          status.textContent = 'Une erreur est survenue. Merci de réessayer.';
          status.className = 'form-status is-error';
        });
      }
    }).catch(function(){
      status.textContent = 'Impossible d\'envoyer le message. Vérifiez votre connexion.';
      status.className = 'form-status is-error';
    });
  });
})();
</script>
  </div>
</footer>

<?php include __DIR__ . '/inc/mobile-menu.php'; ?>
<script>
(function(){
  window.addEventListener('pageshow', function(e){
    var track = document.querySelector('.sponsors-track');
    if(!track) return;
    // relâche un focus resté sur un logo
    if(document.activeElement && track.contains(document.activeElement)){
      document.activeElement.blur();
    }
    // relance l'animation si la page revient du bfcache
    if(e.persisted){
      track.style.animation = 'none';
      void track.offsetHeight;   // force un reflow
      track.style.animation = '';
    }
  });
})();
</script>
</body>
</html>
