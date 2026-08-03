<?php
require __DIR__ . '/inc/functions.php';
$c = load_content();
$p = $c['exposantsPage'] ?? [];
$list = $p['list'] ?? [];

$home = false; $active = 'exposants';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Exposants — <?= e($c['meta']['title'] ?? 'Club Œnologie Découvertes') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
<style>
  .pagehead{padding-bottom:34px;}
  .pagehead p{max-width:60ch;}

  /* filter bar */
  .filterbar{
    position:sticky;top:78px;z-index:40;background:var(--paper);
    border-bottom:1px solid var(--line);padding:16px 0;margin-bottom:34px;
  }
  .filter-row{display:flex;gap:12px;flex-wrap:wrap;align-items:center;}
  .search-input{
    display:flex;align-items:center;gap:8px;background:#fff;border:1px solid var(--line);
    border-radius:10px;padding:10px 14px;min-width:220px;flex:1;color:var(--ink-soft);font-size:0.9rem;
  }
  .search-input input{border:none;outline:none;background:none;font:inherit;flex:1;min-width:0;color:var(--ink);}
  select.filter{
    padding:10px 14px;border:1px solid var(--line);border-radius:10px;background:#fff;
    font:inherit;font-size:0.9rem;color:var(--ink);
  }
  .type-toggle{display:flex;background:#fff;border:1px solid var(--line);border-radius:10px;padding:3px;}
  .type-toggle button{
    border:none;background:none;padding:8px 16px;border-radius:8px;font:inherit;font-size:0.86rem;font-weight:600;color:var(--ink-soft);
  }
  .type-toggle button.active{background:var(--ink);color:var(--paper);}
  .reset-link{font-size:0.86rem;font-weight:600;color:var(--bordeaux);text-decoration:none;white-space:nowrap;}
  .reset-link:hover{text-decoration:underline;}
  .result-count{font-size:0.86rem;color:var(--ink-soft);margin-top:12px;}
/* filter bar — compact sur mobile */
  @media (max-width:640px){
    .filterbar{padding:12px 0}
    .filter-row{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:10px;
      align-items:stretch;
    }
    .type-toggle{
      grid-column:1 / -1;
      display:grid;
      grid-template-columns:repeat(3,1fr);
    }
    .type-toggle button{padding:8px 4px;font-size:0.78rem;}
    select.filter{width:100%;font-size:0.85rem;padding:9px 10px;}
    .search-input{
      grid-column:1 / span 1;
      min-width:0;
    }
    .reset-link{
      grid-column:2 / span 1;
      text-align:right;
      align-self:center;
    }
    .result-count{margin-top:6px;}
  }
  /* grid */
  .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;padding-bottom:90px;}
  @media (max-width:920px){.grid{grid-template-columns:repeat(2,1fr);}}
  @media (max-width:620px){.grid{grid-template-columns:1fr;}}

  .exp-card{
    background:#fff;border:1px solid var(--line);border-radius:18px;padding:26px;
    transition:transform .18s ease, box-shadow .18s ease;
  }
  .exp-card:hover{transform:translateY(-5px);box-shadow:0 24px 40px -26px rgba(27,20,64,0.3);}
  .badge{display:inline-block;padding:4px 11px;border-radius:100px;font-size:0.72rem;font-weight:700;letter-spacing:0.02em;margin-bottom:14px;}
  .badge.vign{background:#efe4f7;color:var(--grape);}
  .badge.prod{background:#fbe9d6;color:var(--amber);}
  .exp-card h3{font-size:1.12rem;margin-bottom:6px;}
  .exp-card .region{font-size:0.86rem;color:var(--bordeaux);font-weight:600;margin-bottom:2px;}
  .exp-card .appellations{font-size:0.8rem;color:var(--ink-soft);font-weight:500;margin-bottom:10px;}
  .exp-card p{font-size:0.88rem;color:var(--ink-soft);line-height:1.55;margin:0;}

  .exp-card{cursor:pointer;}
  .exp-card .photo-thumb{
    width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:12px;margin-bottom:14px;background:var(--paper-2,#f0ebe0);
  }

  .empty{
    text-align:center;padding:70px 20px;color:var(--ink-soft);
  }
  .empty .swirl{width:2.2rem;height:2.2rem;margin-bottom:14px;}

  /* modale fiche exposant */
  .modal-backdrop{
    display:none;position:fixed;inset:0;background:rgba(27,20,64,0.55);z-index:100;
    align-items:center;justify-content:center;padding:20px;
  }
  .modal-backdrop.open{display:flex;}
  .modal-box{
    background:#fff;border-radius:18px;max-width:480px;width:100%;max-height:88vh;overflow-y:auto;
    padding:30px;position:relative;
  }
  .modal-close{
    position:absolute;top:14px;right:14px;width:34px;height:34px;border-radius:50%;border:1px solid var(--line);
    background:#fff;font-size:1.1rem;line-height:1;color:var(--ink-soft);cursor:pointer;
  }
  .modal-close:hover{background:var(--paper-2,#f0ebe0);}
  .modal-photo{width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:14px;margin-bottom:18px;}
  .modal-box h2{font-size:1.3rem;margin-bottom:4px;}
  .modal-box .region{font-size:0.9rem;color:var(--bordeaux);font-weight:600;margin-bottom:4px;}
  .modal-box .appellations{font-size:0.84rem;color:var(--ink-soft);margin-bottom:14px;}
  .modal-box .modal-info{margin-top:14px;display:flex;flex-direction:column;gap:8px;}
  .modal-box .modal-info div{font-size:0.9rem;color:var(--ink-soft);display:flex;align-items:flex-start;gap:9px;}
  .modal-box .modal-info div strong{color:var(--ink);font-weight:600;}
  .modal-box .modal-info a{color:var(--bordeaux);text-decoration:none;font-weight:600;}
  .modal-box .modal-info a:hover{text-decoration:underline;}
  .modal-box .modal-info .info-icon{width:17px;height:17px;flex:none;margin-top:2px;color:var(--bordeaux);}
  .modal-box p.desc{margin-top:14px;font-size:0.9rem;color:var(--ink-soft);line-height:1.55;}
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
      <div class="type-toggle" id="typeToggle">
        <button data-type="" class="active">Tous</button>
        <button data-type="Vigneron">Vignerons</button>
        <button data-type="Producteur">Producteurs</button>
      </div>
      <select class="filter" id="regionFilter">
        <option value="">Toutes les régions</option>
      </select>
      <select class="filter" id="appellationFilter">
        <option value="">Toutes les appellations</option>
      </select>
      <div class="search-input">🔍 <input id="searchInput" placeholder="Rechercher..."></div>
      <a href="#" class="reset-link" id="resetLink">Réinitialiser</a>
    </div>
    <div class="result-count" id="resultCount"></div>
  </div>
</div>

<div class="wrap">
  <div class="grid" id="grid"></div>
  <div class="empty" id="empty" style="display:none;">
    <svg class="swirl" viewBox="0 0 24 24"><path d="M3 15c4-8 10-8 13-3s-2 8-6 6 1-9 8-6"/></svg>
    <div>Aucun exposant ne correspond à votre recherche.</div>
  </div>
</div>

<div class="modal-backdrop" id="modalBackdrop">
  <div class="modal-box" id="modalBox"></div>
</div>

<?php include __DIR__ . '/inc/footer-simple.php'; ?>

<script>
  const exposants = <?= json_encode($list, JSON_UNESCAPED_UNICODE) ?>;

  const params = new URLSearchParams(location.search);
  let state = { type: params.get('type') || "", region:"", appellation:"", q:"" };

  // peupler la liste des régions dynamiquement
  const regionSelect = document.getElementById('regionFilter');
  const regions = [...new Set(exposants.map(e=>e.region).filter(Boolean))].sort();
  regions.forEach(r=>{
    const opt = document.createElement('option');
    opt.value = r; opt.textContent = r;
    regionSelect.appendChild(opt);
  });

  // peupler la liste des appellations dynamiquement (champ multivalué)
  const appSelect = document.getElementById('appellationFilter');
  const appellations = [...new Set(exposants.flatMap(e=>e.appellations || []).filter(Boolean))].sort();
  appellations.forEach(a=>{
    const opt = document.createElement('option');
    opt.value = a; opt.textContent = a;
    appSelect.appendChild(opt);
  });

  function matches(e){
    if(state.type && e.type !== state.type) return false;
    if(state.region && e.region !== state.region) return false;
    if(state.appellation && !(e.appellations || []).includes(state.appellation)) return false;
    if(state.q){
      const q = state.q.toLowerCase();
      if(!e.nom.toLowerCase().includes(q) && !e.desc.toLowerCase().includes(q)) return false;
    }
    return true;
  }

  function render(){
    const list = exposants.filter(matches);
    const grid = document.getElementById('grid');
    const empty = document.getElementById('empty');
    document.getElementById('resultCount').textContent =
      list.length + (list.length > 1 ? " exposants trouvés" : " exposant trouvé");

    if(list.length === 0){
      grid.style.display = 'none'; empty.style.display = 'block';
      return;
    }
    grid.style.display = 'grid'; empty.style.display = 'none';

    grid.innerHTML = list.map(e => `
      <div class="exp-card" data-index="${exposants.indexOf(e)}">
        ${e.photo ? `<img class="photo-thumb" src="${e.photo}" alt="">` : ''}
        <span class="badge ${e.type==='Vigneron'?'vign':'prod'}">${e.type === 'Vigneron' ? 'Vigneron' : 'Producteur régional'}</span>
        <h3>${e.nom}</h3>
        ${e.region ? `<div class="region">${e.region}</div>` : ''}
        ${(e.appellations && e.appellations.length) ? `<div class="appellations">${e.appellations.join(', ')}</div>` : ''}
        <p>${e.desc}</p>
      </div>
    `).join('');
  }

  /* ── Modale fiche exposant ── */
  const modalBackdrop = document.getElementById('modalBackdrop');
  const modalBox = document.getElementById('modalBox');

  function openModal(e){
    let html = '<button class="modal-close" id="modalCloseBtn" aria-label="Fermer">✕</button>';
    if(e.photo) html += `<img class="modal-photo" src="${e.photo}" alt="">`;
    html += `<h2>${e.nomComplet || e.nom}</h2>`;
    if(e.region) html += `<div class="region">${e.region}</div>`;
    if(e.appellations && e.appellations.length) html += `<div class="appellations">${e.appellations.join(', ')}</div>`;

    let infos = '';
    if(e.adresse) infos += `<div><svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg><span>${e.adresse}</span></div>`;
    if(e.telephone) infos += `<div><svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg><a href="tel:${e.telephone.replace(/\s+/g,'')}">${e.telephone}</a></div>`;
    if(e.email) infos += `<div><svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z" fill="none"/><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/></svg><a href="mailto:${e.email}">${e.email}</a></div>`;
    if(e.siteWeb) infos += `<div><svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg><a href="${e.siteWeb}" target="_blank" rel="noopener">${e.siteWeb}</a></div>`;
    if(infos) html += `<div class="modal-info">${infos}</div>`;

    if(e.desc) html += `<p class="desc">${e.desc}</p>`;

    modalBox.innerHTML = html;
    modalBackdrop.classList.add('open');
    document.getElementById('modalCloseBtn').addEventListener('click', closeModal);
  }
  function closeModal(){ modalBackdrop.classList.remove('open'); }

  document.getElementById('grid').addEventListener('click', e=>{
    const card = e.target.closest('.exp-card');
    if(!card) return;
    const item = exposants[Number(card.dataset.index)];
    if(item) openModal(item);
  });
  modalBackdrop.addEventListener('click', e=>{ if(e.target === modalBackdrop) closeModal(); });
  document.addEventListener('keydown', e=>{ if(e.key === 'Escape') closeModal(); });

  document.getElementById('typeToggle').addEventListener('click', e=>{
    const btn = e.target.closest('button');
    if(!btn) return;
    document.querySelectorAll('#typeToggle button').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    state.type = btn.dataset.type;
    render();
  });
  regionSelect.addEventListener('change', ()=>{ state.region = regionSelect.value; render(); });
  appSelect.addEventListener('change', ()=>{ state.appellation = appSelect.value; render(); });
  document.getElementById('searchInput').addEventListener('input', e=>{ state.q = e.target.value; render(); });
  document.getElementById('resetLink').addEventListener('click', e=>{
    e.preventDefault();
    state = {type:"", region:"", appellation:"", q:""};
    document.querySelectorAll('#typeToggle button').forEach(b=>b.classList.remove('active'));
    document.querySelector('#typeToggle button[data-type=""]').classList.add('active');
    regionSelect.value = ""; appSelect.value = ""; document.getElementById('searchInput').value = "";
    render();
  });

  document.querySelectorAll('#typeToggle button').forEach(b=>{
    b.classList.toggle('active', b.dataset.type === state.type);
  });
  render();
</script>
<?php include __DIR__ . '/inc/mobile-menu.php'; ?>
</body>
</html>
