<?php
require __DIR__ . '/inc/functions.php';
$c = load_content();
$p = $c['pressePage'] ?? [];
$articles = $p['articles'] ?? [];
$kit = $p['kit'] ?? [];

// années disponibles, triées décroissant, pour générer les boutons du filtre
$years = array_values(array_unique(array_filter(array_column($articles, 'annee'))));
rsort($years);

$home = false; $active = 'presse';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Presse — <?= e($c['meta']['title'] ?? 'Club Œnologie Découvertes') ?></title>
<link rel="icon" type="image/x-icon" href="assets/photos/Logo.png" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css?v=<?= @filemtime(__DIR__ . '/assets/style.css') ?: time() ?>">
<style>
  .wrap{max-width:1080px;}
  .pagehead{padding-bottom:34px;}
  .pagehead p{max-width:60ch;}

  /* filter bar */
  .filterbar{
    position:sticky;top:78px;z-index:40;background:var(--paper);
    border-bottom:1px solid var(--line);padding:16px 0;margin-bottom:8px;
  }
  .filter-row{display:flex;gap:12px;flex-wrap:wrap;align-items:center;}
  select.filter{padding:10px 14px;border:1px solid var(--line);border-radius:10px;background:#fff;font:inherit;font-size:0.9rem;color:var(--ink);}
  .year-toggle{display:flex;background:#fff;border:1px solid var(--line);border-radius:10px;padding:3px;}
  .year-toggle button{border:none;background:none;padding:8px 16px;border-radius:8px;font:inherit;font-size:0.86rem;font-weight:600;color:var(--ink-soft);}
  .year-toggle button.active{background:var(--ink);color:var(--paper);}
  .reset-link{font-size:0.86rem;font-weight:600;color:var(--bordeaux);text-decoration:none;white-space:nowrap;}
  .reset-link:hover{text-decoration:underline;}
  .result-count{font-size:0.86rem;color:var(--ink-soft);margin:12px 0 30px;}

  /* timeline list */
  .press-list{list-style:none;margin:0;padding:0 0 90px;}
  .press-item{
    display:grid;grid-template-columns:150px 1fr;gap:26px;
    padding:26px 0;border-bottom:1px solid var(--line);
  }
  .press-item:first-child{padding-top:0;}
  @media (max-width:640px){.press-item{grid-template-columns:1fr;gap:8px;}}
  .press-date{font-family:'Fraunces',serif;font-weight:600;color:var(--ink-soft);font-size:0.95rem;padding-top:2px;}
  .press-body .source{
    display:inline-flex;align-items:center;gap:6px;font-size:0.76rem;font-weight:700;
    letter-spacing:0.04em;text-transform:uppercase;color:var(--amber);margin-bottom:8px;
  }
  .press-body h3{font-size:1.2rem;margin-bottom:8px;}
  .press-body p{font-size:0.92rem;color:var(--ink-soft);line-height:1.6;margin:0 0 12px;max-width:60ch;}
  .press-link{font-size:0.86rem;font-weight:600;color:var(--bordeaux);text-decoration:none;border-bottom:1.5px solid transparent;}
  .press-link:hover{border-color:var(--bordeaux);}

  .empty{text-align:center;padding:70px 20px;color:var(--ink-soft);}
  .empty .swirl{width:2.2rem;height:2.2rem;margin-bottom:14px;}

  /* kit presse */
  .kit{
    background:var(--ink);color:var(--paper);border-radius:20px;padding:40px 36px;
    margin:10px 0 90px;display:flex;justify-content:space-between;align-items:center;gap:24px;flex-wrap:wrap;
  }
  .kit h3{color:var(--paper);font-size:1.3rem;margin-bottom:8px;}
  .kit p{color:rgba(247,242,231,0.78);margin:0;max-width:46ch;font-size:0.92rem;line-height:1.55;}
  .kit .btn-solid{background:var(--amber);border-color:var(--amber);color:var(--ink);}
  .kit .btn-solid:hover{background:var(--paper);border-color:var(--paper);}
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

<div class="filterbar">
  <div class="wrap">
    <div class="filter-row">
      <div class="year-toggle" id="yearToggle">
        <button data-year="" class="active">Toutes les années</button>
        <?php foreach ($years as $y): ?>
        <button data-year="<?= e($y) ?>"><?= e($y) ?></button>
        <?php endforeach; ?>
      </div>
      <select class="filter" id="sourceFilter">
        <option value="">Toutes les sources</option>
      </select>
      <a href="#" class="reset-link" id="resetLink">Réinitialiser</a>
    </div>
  </div>
</div>

<div class="wrap">
  <div class="result-count" id="resultCount"></div>
  <ul class="press-list" id="pressList"></ul>
  <div class="empty" id="empty" style="display:none;">
    <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
    <div>Aucun article ne correspond à ces filtres.</div>
  </div>

  <div class="kit">
    <div>
      <h3><?= e($kit['title'] ?? '') ?></h3>
      <p><?= ml($kit['text'] ?? '') ?></p>
    </div>
    <a href="index.php#contact" class="btn btn-solid"><?= e($kit['cta'] ?? '') ?></a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer-simple.php'; ?>

<script>
  const articles = <?= json_encode($articles, JSON_UNESCAPED_UNICODE) ?>;

  let state = { year:"", source:"" };

  const sourceSelect = document.getElementById('sourceFilter');
  [...new Set(articles.map(a=>a.source))].sort().forEach(s=>{
    const opt = document.createElement('option');
    opt.value = s; opt.textContent = s;
    sourceSelect.appendChild(opt);
  });

  function matches(a){
    if(state.year && a.annee !== state.year) return false;
    if(state.source && a.source !== state.source) return false;
    return true;
  }

  function render(){
    const list = articles.filter(matches).sort((a,b)=> b.date.split('/').reverse().join('').localeCompare(a.date.split('/').reverse().join('')));
    const el = document.getElementById('pressList');
    const empty = document.getElementById('empty');
    document.getElementById('resultCount').textContent =
      list.length + (list.length > 1 ? " articles" : " article");

    if(list.length === 0){ el.style.display='none'; empty.style.display='block'; return; }
    el.style.display='block'; empty.style.display='none';

    el.innerHTML = list.map(a => `
      <li class="press-item">
        <div class="press-date">${a.date}</div>
        <div class="press-body">
          <span class="source">${a.source}</span>
          <h3>${a.titre}</h3>
          <p>${a.resume}</p>
          <a href="#" class="press-link">Lire l'article →</a>
        </div>
      </li>
    `).join('');
  }

  document.getElementById('yearToggle').addEventListener('click', e=>{
    const btn = e.target.closest('button');
    if(!btn) return;
    document.querySelectorAll('#yearToggle button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    state.year = btn.dataset.year;
    render();
  });
  sourceSelect.addEventListener('change', ()=>{ state.source = sourceSelect.value; render(); });
  document.getElementById('resetLink').addEventListener('click', e=>{
    e.preventDefault();
    state = {year:"", source:""};
    document.querySelectorAll('#yearToggle button').forEach(b=>b.classList.remove('active'));
    document.querySelector('#yearToggle button[data-year=""]').classList.add('active');
    sourceSelect.value = "";
    render();
  });

  render();
</script>
<?php include __DIR__ . '/inc/mobile-menu.php'; ?>
</body>
</html>
