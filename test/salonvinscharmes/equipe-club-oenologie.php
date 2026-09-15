<?php
require __DIR__ . '/inc/functions.php';
$c = load_content();
$p = $c['equipePage'] ?? [];
$bureau = $p['bureau'] ?? [];
$guests = $p['guests'] ?? [];
$benevoles = $p['benevoles'] ?? [];
$join = $p['join'] ?? [];

$home = false; $active = 'equipe';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>L'équipe — <?= e($c['meta']['title'] ?? 'Club Œnologie Découvertes') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" type="image/x-icon" href="assets/photos/Logo.png" />
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css?v=<?= @filemtime(__DIR__ . '/assets/style.css') ?: time() ?>">
<style>
  /* --- bureau grid --- */
  .bureau-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;}
  @media (max-width:920px){.bureau-grid{grid-template-columns:repeat(2,1fr);}}
  @media (max-width:560px){.bureau-grid{grid-template-columns:1fr;}}
  .member{background:#fff;border:1px solid var(--line);border-radius:18px;padding:26px 22px;text-align:center;transition:transform .18s ease, box-shadow .18s ease;}
  .member:hover{transform:translateY(-5px);box-shadow:0 22px 38px -26px rgba(27,20,64,0.3);}
  .avatar{
    width:78px;height:78px;border-radius:50%;margin:0 auto 16px;
    display:flex;align-items:center;justify-content:center;
    font-family:'Fraunces',serif;font-weight:700;font-size:1.3rem;color:#fff;
  }
  .member h3{font-size:1.02rem;margin-bottom:4px;}
  .member .role{font-size:0.82rem;color:var(--bordeaux);font-weight:600;margin-bottom:10px;}
  .member p{font-size:0.85rem;color:var(--ink-soft);line-height:1.5;margin:0;}
  .avatar-photo{width:78px;height:78px;border-radius:50%;margin:0 auto 16px;object-fit:cover;display:block;}
  .contact{margin-top:12px;display:flex;flex-direction:column;gap:4px;font-size:0.82rem;}
  .contact a{color:var(--bordeaux);text-decoration:none;word-break:break-all;}
  .contact a:hover{text-decoration:underline;}

  /* invités carousel-like row */
  .guest-row{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
  @media (max-width:900px){.guest-row{grid-template-columns:repeat(2,1fr);}}
  @media (max-width:600px){.guest-row{grid-template-columns:1fr;}}
  .guest-card{
    background:var(--ink);color:var(--paper);border-radius:18px;padding:28px 24px;position:relative;overflow:hidden;
  }
  .guest-card .tagline{font-family:'Caveat',cursive;font-weight:700;color:var(--amber);font-size:1.3rem;display:block;margin-bottom:6px;}
  .guest-card h3{color:var(--paper);font-size:1.15rem;margin-bottom:6px;}
  .guest-card .role{font-size:0.82rem;color:rgba(247,242,231,0.7);margin-bottom:14px;}
  .guest-card p{font-size:0.86rem;color:rgba(247,242,231,0.85);line-height:1.55;margin:0;}
  .guest-avatar{width:56px;height:56px;border-radius:50%;object-fit:cover;margin-bottom:14px;border:2px solid rgba(247,242,231,0.25);display:block;}
  .guest-card .contact a{color:var(--amber);}

  /* bénévoles */
  .benevole-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
  @media (max-width:920px){.benevole-grid{grid-template-columns:repeat(2,1fr);}}
  @media (max-width:560px){.benevole-grid{grid-template-columns:1fr;}}
  .benevole-card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:20px 18px;text-align:center;}
  .benevole-card .avatar-photo,.benevole-card .avatar{width:64px;height:64px;margin:0 auto 12px;}
  .benevole-card .avatar{border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Fraunces',serif;font-weight:700;font-size:1.05rem;color:#fff;}
  .benevole-card h3{font-size:0.94rem;margin-bottom:2px;}
  .benevole-card .role{font-size:0.78rem;color:var(--bordeaux);font-weight:600;margin-bottom:4px;}
  .benevole-card .since{font-size:0.75rem;color:var(--ink-soft);margin-bottom:8px;}
  .benevole-card .contact{font-size:0.78rem;}

  /* join cta */
  .join{
    background:linear-gradient(140deg,var(--grape),#4d1428 130%);color:var(--paper);
    border-radius:22px;padding:48px 40px;display:flex;justify-content:space-between;align-items:center;gap:24px;flex-wrap:wrap;
    margin-bottom:80px;
  }
  .join h3{color:var(--paper);font-size:1.5rem;margin-bottom:10px;}
  .join p{margin:0;max-width:48ch;color:rgba(247,242,231,0.85);font-size:0.94rem;line-height:1.6;}
  .join .btn-solid{background:var(--amber);border-color:var(--amber);color:var(--ink);}
  .join .btn-solid:hover{background:var(--paper);border-color:var(--paper);}
</style>
</head>
<body>

<?php include __DIR__ . '/inc/header.php'; ?>

<div class="pagehead">
  <div class="wrap">
    <span class="eyebrow">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($p['eyebrow'] ?? '') ?>
    </span>
    <h1><?= e($p['title'] ?? '') ?></h1>
    <p><?= ml($p['intro'] ?? '') ?></p>
  </div>
</div>

<section class="wrap block tight">
  <div class="section-head">
    <span class="tag">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($bureau['tag'] ?? '') ?>
    </span>
    <h2><?= e($bureau['title'] ?? '') ?></h2>
    <p><?= ml($bureau['intro'] ?? '') ?></p>
  </div>
  <div class="bureau-grid">
    <?php foreach (($bureau['members'] ?? []) as $m): ?>
    <?php $mphoto = cl_tr($m['photo'] ?? '', 'w_160,h_160,c_fill,g_auto,q_auto,f_auto'); ?>
    <div class="member">
      <?php if ($mphoto !== ''): ?>
      <img class="avatar-photo" src="<?= e($mphoto) ?>" alt="<?= e($m['name'] ?? '') ?>" loading="lazy" decoding="async">
      <?php else: ?>
      <div class="avatar" style="background:<?= e($m['color'] ?? 'var(--ink)') ?>;"><?= e($m['initials'] ?? '') ?></div>
      <?php endif; ?>
      <h3><?= e($m['name'] ?? '') ?></h3>
      <div class="role"><?= e($m['role'] ?? '') ?></div>
      <p><?= ml($m['text'] ?? '') ?></p>
      <?php if (!empty($m['email']) || !empty($m['telephone'])): ?>
      <div class="contact">
        <?php if (!empty($m['email'])): ?><a href="mailto:<?= e($m['email']) ?>"><?= e($m['email']) ?></a><?php endif; ?>
        <?php if (!empty($m['telephone'])): ?><a href="tel:<?= e(preg_replace('/\s+/','',$m['telephone'])) ?>"><?= e($m['telephone']) ?></a><?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="wrap block">
  <div class="section-head">
    <span class="tag">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($guests['tag'] ?? '') ?>
    </span>
    <h2><?= e($guests['title'] ?? '') ?></h2>
    <p><?= ml($guests['intro'] ?? '') ?></p>
  </div>
  <div class="guest-row">
    <?php foreach (($guests['items'] ?? []) as $g): ?>
    <?php $gphoto = cl_tr($g['photo'] ?? '', 'w_160,h_160,c_fill,g_auto,q_auto,f_auto'); ?>
    <div class="guest-card">
      <?php if ($gphoto !== ''): ?>
      <img class="guest-avatar" src="<?= e($gphoto) ?>" alt="<?= e($g['name'] ?? '') ?>" loading="lazy" decoding="async">
      <?php endif; ?>
      <span class="tagline"><?= e($g['tagline'] ?? '') ?></span>
      <h3><?= e($g['name'] ?? '') ?></h3>
      <div class="role"><?= e($g['role'] ?? '') ?></div>
      <p><?= ml($g['text'] ?? '') ?></p>
      <?php if (!empty($g['email']) || !empty($g['telephone'])): ?>
      <div class="contact">
        <?php if (!empty($g['email'])): ?><a href="mailto:<?= e($g['email']) ?>"><?= e($g['email']) ?></a><?php endif; ?>
        <?php if (!empty($g['telephone'])): ?><a href="tel:<?= e(preg_replace('/\s+/','',$g['telephone'])) ?>"><?= e($g['telephone']) ?></a><?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="wrap block tight">
  <div class="section-head">
    <span class="tag">
      <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
      <?= e($benevoles['tag'] ?? '') ?>
    </span>
    <h2><?= e($benevoles['title'] ?? '') ?></h2>
    <p><?= ml($benevoles['intro'] ?? '') ?></p>
  </div>
  <div class="benevole-grid">
    <?php foreach (($benevoles['items'] ?? []) as $b): ?>
    <?php $bphoto = cl_tr($b['photo'] ?? '', 'w_140,h_140,c_fill,g_auto,q_auto,f_auto'); ?>
    <div class="benevole-card">
      <?php if ($bphoto !== ''): ?>
      <img class="avatar-photo" src="<?= e($bphoto) ?>" alt="<?= e($b['name'] ?? '') ?>" loading="lazy" decoding="async">
      <?php else: ?>
      <div class="avatar" style="background:var(--amber);color:var(--ink);"><?= e($b['initials'] ?? '') ?></div>
      <?php endif; ?>
      <h3><?= e($b['name'] ?? '') ?></h3>
      <?php if (!empty($b['role'])): ?><div class="role"><?= e($b['role']) ?></div><?php endif; ?>
      <?php if (!empty($b['since'])): ?><div class="since"><?= e($b['since']) ?></div><?php endif; ?>
      <?php if (!empty($b['email']) || !empty($b['telephone'])): ?>
      <div class="contact">
        <?php if (!empty($b['email'])): ?><a href="mailto:<?= e($b['email']) ?>"><?= e($b['email']) ?></a><?php endif; ?>
        <?php if (!empty($b['telephone'])): ?><a href="tel:<?= e(preg_replace('/\s+/','',$b['telephone'])) ?>"><?= e($b['telephone']) ?></a><?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<div class="wrap">
  <div class="join">
    <div>
      <h3><?= e($join['title'] ?? '') ?></h3>
      <p><?= ml($join['text'] ?? '') ?></p>
    </div>
    <a href="index.php#contact" class="btn btn-solid"><?= e($join['cta'] ?? '') ?></a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer-simple.php'; ?>
<?php include __DIR__ . '/inc/mobile-menu.php'; ?>
</body>
</html>
