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

  /* bénévoles pills */
  .benevole-row{display:flex;gap:14px;flex-wrap:wrap;}
  .benevole-chip{
    display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--line);
    border-radius:100px;padding:8px 18px 8px 8px;
  }
  .benevole-chip .dot{
    width:38px;height:38px;border-radius:50%;background:var(--amber);color:var(--ink);
    display:flex;align-items:center;justify-content:center;font-family:'Fraunces',serif;font-weight:700;font-size:0.92rem;
  }
  .benevole-chip .name{font-weight:600;font-size:0.9rem;}
  .benevole-chip .since{font-size:0.75rem;color:var(--ink-soft);}

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
    <div class="member">
      <div class="avatar" style="background:<?= e($m['color'] ?? 'var(--ink)') ?>;"><?= e($m['initials'] ?? '') ?></div>
      <h3><?= e($m['name'] ?? '') ?></h3>
      <div class="role"><?= e($m['role'] ?? '') ?></div>
      <p><?= ml($m['text'] ?? '') ?></p>
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
    <div class="guest-card">
      <span class="tagline"><?= e($g['tagline'] ?? '') ?></span>
      <h3><?= e($g['name'] ?? '') ?></h3>
      <div class="role"><?= e($g['role'] ?? '') ?></div>
      <p><?= ml($g['text'] ?? '') ?></p>
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
  <div class="benevole-row">
    <?php foreach (($benevoles['items'] ?? []) as $b): ?>
    <div class="benevole-chip"><div class="dot"><?= e($b['initials'] ?? '') ?></div><div><div class="name"><?= e($b['name'] ?? '') ?></div><div class="since"><?= e($b['since'] ?? '') ?></div></div></div>
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
