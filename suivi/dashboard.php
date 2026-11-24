<?php
require __DIR__ . '/../../suivi/lib/auth.php';
$client = require_login();

$st = db()->prepare('SELECT id, domain FROM sites WHERE client_id = ? AND active = 1 ORDER BY domain');
$st->execute([$client['id']]);
$sites = $st->fetchAll();
?>
<!doctype html>
<html lang="fr" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Suivi de votre site – Corentin Vallet</title>
<script>try{var t=localStorage.getItem('cv-theme');if(t)document.documentElement.setAttribute('data-theme',t)}catch(e){}</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=DM+Mono:wght@300;400&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/suivi.css?v=1">
</head>
<body>
<header class="nav">
  <a class="brand" href="https://www.corentinvallet.fr">
    <img src="https://www.corentinvallet.fr/Photos/Logo%20sans%20texte.png" alt="">
    <span>Corentin <em>Vallet</em></span>
  </a>
  <div class="nav-right">
    <?php if (count($sites) > 1): ?>
      <select id="site" aria-label="Site à afficher">
        <?php foreach ($sites as $s): ?>
          <option value="<?= (int)$s['id'] ?>"><?= h($s['domain']) ?></option>
        <?php endforeach; ?>
      </select>
    <?php elseif ($sites): ?>
      <input type="hidden" id="site" value="<?= (int)$sites[0]['id'] ?>">
    <?php endif; ?>
    <button class="icon-btn" id="theme" type="button" aria-label="Basculer entre thème clair et sombre"></button>
    <?php if (!empty($client['is_admin'])): ?><a class="nav-link" href="/admin.php">Clients</a><?php endif; ?>
    <a class="nav-link" href="/logout.php">Déconnexion</a>
  </div>
</header>

<main class="wrap">
<?php if (!$sites): ?>
  <div class="eyebrow">Suivi de votre site</div>
  <h1>Bienvenue, <em><?= h($client['name']) ?></em>.</h1>
  <p class="lede">Aucun site n'est encore rattaché à votre compte. Écrivez-moi à
    <a href="mailto:contact@corentinvallet.fr">contact@corentinvallet.fr</a> et je m'en occupe.</p>
<?php else: ?>
  <section>
    <div class="eyebrow" id="domain">Suivi de votre site</div>
    <h1 id="headline">Chargement des chiffres…</h1>
    <p class="lede" id="lede"></p>
  </section>

  <div class="controls">
    <div class="presets" id="presets">
      <button type="button" class="btn btn-ghost" data-days="7" aria-pressed="false">7 jours</button>
      <button type="button" class="btn btn-ghost" data-days="30" aria-pressed="false">30 jours</button>
      <button type="button" class="btn btn-ghost" data-days="90" aria-pressed="false">3 mois</button>
      <button type="button" class="btn btn-ghost" data-days="365" aria-pressed="false">12 mois</button>
    </div>
    <div class="dates">
      <label>Du <input type="date" id="from"></label>
      <label>au <input type="date" id="to"></label>
      <button type="button" class="btn btn-primary" id="apply">Afficher</button>
    </div>
  </div>
  <p class="error" id="error" role="alert"></p>

  <div class="cards">
    <div class="card">
      <div class="label">Visites depuis Google</div>
      <div class="value" id="v-clicks">–</div>
      <div class="delta" id="d-clicks"></div>
      <p class="hint">Clics sur votre site depuis les résultats de recherche.</p>
    </div>
    <div class="card">
      <div class="label">Apparitions dans Google</div>
      <div class="value" id="v-impressions">–</div>
      <div class="delta" id="d-impressions"></div>
      <p class="hint">Nombre de fois où votre site s'est affiché dans une recherche.</p>
    </div>
    <div class="card">
      <div class="label">Taux de clic</div>
      <div class="value" id="v-ctr">–</div>
      <div class="delta" id="d-ctr"></div>
      <p class="hint">Part des apparitions qui ont donné lieu à une visite.</p>
    </div>
    <div class="card">
      <div class="label">Position moyenne</div>
      <div class="value" id="v-position">–</div>
      <div class="delta" id="d-position"></div>
      <p class="hint">1 correspond au tout premier résultat.</p>
    </div>
  </div>

  <section class="panel">
    <h2>Évolution</h2>
    <div class="chart"><canvas id="chart" role="img" aria-label="Courbe des visites et des apparitions dans Google"></canvas></div>
    <p class="note" id="chartNote"></p>
  </section>

  <section class="panel">
    <h2>Ce que les internautes ont tapé pour vous trouver</h2>
    <table>
      <thead><tr><th>Recherche</th><th>Visites</th><th>Apparitions</th><th>Position</th></tr></thead>
      <tbody id="queries"></tbody>
    </table>
  </section>

  <h2 class="section-title">Santé du site</h2>
  <div class="cards cards-3">
    <div class="card">
      <div class="label">Site en ligne</div>
      <div class="value" id="h-up">–</div>
      <div class="delta" id="h-up-d"></div>
      <p class="hint" id="h-up-h"></p>
    </div>
    <div class="card">
      <div class="label">Vitesse sur mobile</div>
      <div class="value" id="h-sp">–</div>
      <div class="delta" id="h-sp-d"></div>
      <p class="hint" id="h-sp-h"></p>
    </div>
    <div class="card">
      <div class="label">Certificat HTTPS</div>
      <div class="value" id="h-ssl">–</div>
      <div class="delta" id="h-ssl-d"></div>
      <p class="hint" id="h-ssl-h"></p>
    </div>
  </div>

  <p class="foot">Chiffres issus de la Search Console de Google, mis à jour chaque matin.
    Les 3 derniers jours ne sont pas encore disponibles.</p>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
  <script>
  const $ = id => document.getElementById(id);
  const root = document.documentElement;
  const nf = new Intl.NumberFormat('fr-FR');
  let chart = null, maxTo = null, last = null;

  const css = n => getComputedStyle(root).getPropertyValue(n).trim();
  const addDays = (s, n) => {
    const d = new Date(s + 'T00:00:00Z');
    d.setUTCDate(d.getUTCDate() + n);
    return d.toISOString().slice(0, 10);
  };
  const dayLong = (s, withYear) => new Date(s + 'T00:00:00Z').toLocaleDateString('fr-FR',
    { day: 'numeric', month: 'long', year: withYear ? 'numeric' : undefined, timeZone: 'UTC' });
  const dayShort = (s, long) => s.slice(8) + '/' + s.slice(5, 7) + (long ? '/' + s.slice(2, 4) : '');
  const fmtPos = v => v === null ? '–' : String(v).replace('.', ',');

  /* Thème clair / sombre */
  const icon = () => { $('theme').textContent = root.getAttribute('data-theme') === 'dark' ? '☀︎' : '☽'; };
  $('theme').addEventListener('click', () => {
    const t = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    root.setAttribute('data-theme', t);
    try { localStorage.setItem('cv-theme', t); } catch (e) {}
    icon();
    if (last) drawChart(last);
  });
  icon();

  /* Variations par rapport à la période précédente */
  function setDelta(id, text, cls) {
    const e = $(id);
    e.textContent = text;
    e.className = 'delta ' + cls;
  }
  function pctDelta(id, cur, prev) {
    if (!prev) return setDelta(id, 'vs période précédente : –', '');
    const p = (cur - prev) / prev * 100;
    setDelta(id, (p > 0 ? '+' : '') + Math.round(p) + ' % vs période précédente', p > 0 ? 'up' : p < 0 ? 'down' : '');
  }
  function compareSentence(c, p) {
    if (!p.clicks && !p.impressions) return 'Pas de comparaison possible : la période précédente ne contient pas encore de données.';
    const diff = c.clicks - p.clicks;
    if (diff === 0) return `C'est autant que sur la période précédente (${p.clicks}).`;
    const abs = Math.abs(diff);
    return `C'est ${abs} visite${abs > 1 ? 's' : ''} de ${diff > 0 ? 'plus' : 'moins'} que sur la période précédente (${p.clicks}).`;
  }

  function drawChart(d) {
    const long = d.range.days > 92;
    const labels = d.series.map(r => dayShort(r.date, long));
    const c1 = css('--accent'), c2 = css('--moss'), txt = css('--text2'), grid = css('--border');
    const pr = labels.length > 45 ? 0 : 3;
    Chart.defaults.font.family = 'Syne, sans-serif';
    Chart.defaults.color = txt;
    if (chart) chart.destroy();
    chart = new Chart($('chart'), {
      type: 'line',
      data: {
        labels,
        datasets: [
          { label: 'Visites depuis Google', data: d.series.map(r => r.clicks), yAxisID: 'y',
            borderColor: c1, backgroundColor: c1, borderWidth: 2, tension: .3, pointRadius: pr, pointHoverRadius: 4 },
          { label: 'Apparitions dans Google', data: d.series.map(r => r.impressions), yAxisID: 'y1',
            borderColor: c2, backgroundColor: c2, borderWidth: 2, borderDash: [5, 4], tension: .3, pointRadius: pr, pointHoverRadius: 4 }
        ]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { position: 'top', align: 'start', labels: { usePointStyle: true, boxWidth: 8, color: txt } },
          tooltip: { backgroundColor: css('--surface'), titleColor: css('--text'), bodyColor: txt,
                     borderColor: grid, borderWidth: 1, cornerRadius: 2, padding: 12 }
        },
        scales: {
          x:  { grid: { display: false }, ticks: { color: txt, maxTicksLimit: 8, maxRotation: 0 } },
          y:  { beginAtZero: true, position: 'left',  grid: { color: grid }, border: { display: false }, ticks: { precision: 0, color: c1 } },
          y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, border: { display: false }, ticks: { precision: 0, color: c2 } }
        }
      }
    });
    $('chartNote').textContent = d.range.group === 'week' ? 'Chaque point représente une semaine.' : '';
  }

  function render(d) {
    last = d;
    maxTo = d.range.max_to;
    const c = d.current, p = d.previous;

    $('domain').textContent = 'Suivi de ' + d.site.domain;
    $('from').value = d.range.from;
    $('to').value = d.range.to;
    $('from').max = $('to').max = maxTo;

    document.querySelectorAll('#presets button').forEach(b => {
      const on = d.range.to === maxTo && d.range.days === +b.dataset.days;
      b.classList.toggle('is-active', on);
      b.setAttribute('aria-pressed', on ? 'true' : 'false');
    });

    const sameYear = d.range.from.slice(0, 4) === d.range.to.slice(0, 4);
    const what = c.clicks === 0 ? 'aucune visite' : c.clicks === 1 ? '1 visite' : nf.format(c.clicks) + ' visites';
    const h = $('headline');
    h.textContent = 'Depuis Google, votre site a reçu ';
    const em = document.createElement('em');
    em.textContent = what;
    h.append(em, ` du ${dayLong(d.range.from, !sameYear)} au ${dayLong(d.range.to, true)}.`);
    $('lede').textContent = compareSentence(c, p);

    $('v-clicks').textContent = nf.format(c.clicks);
    $('v-impressions').textContent = nf.format(c.impressions);
    $('v-ctr').textContent = (c.ctr * 100).toFixed(1).replace('.', ',') + ' %';
    $('v-position').textContent = fmtPos(c.position);

    pctDelta('d-clicks', c.clicks, p.clicks);
    pctDelta('d-impressions', c.impressions, p.impressions);
    if (p.impressions) {
      const pts = (c.ctr - p.ctr) * 100;
      setDelta('d-ctr', (pts > 0 ? '+' : '') + pts.toFixed(1).replace('.', ',') + ' pt vs période précédente', pts > 0 ? 'up' : pts < 0 ? 'down' : '');
    } else setDelta('d-ctr', 'vs période précédente : –', '');
    if (c.position !== null && p.position !== null) {
      const gain = p.position - c.position;   // une position plus basse est meilleure
      setDelta('d-position', (gain > 0 ? '+' : '') + gain.toFixed(1).replace('.', ',') + ' place(s) vs période précédente', gain > 0 ? 'up' : gain < 0 ? 'down' : '');
    } else setDelta('d-position', 'vs période précédente : –', '');

    drawChart(d);

    const tb = $('queries');
    tb.replaceChildren();
    if (!d.queries.length) {
      const tr = document.createElement('tr'), td = document.createElement('td');
      td.colSpan = 4; td.className = 'empty';
      td.textContent = 'Aucune recherche enregistrée sur cette période. Google publie les chiffres avec 2 à 3 jours de retard.';
      tr.appendChild(td); tb.appendChild(tr);
    }
    d.queries.forEach(q => {
      const tr = document.createElement('tr');
      [q.query, nf.format(q.clicks), nf.format(q.impressions), fmtPos(q.position)].forEach(v => {
        const td = document.createElement('td');
        td.textContent = v;          // textContent : jamais de HTML venant de Google
        tr.appendChild(td);
      });
      tb.appendChild(tr);
    });
  }

  /* Santé du site */
  const fmtDateFr = s => new Date(s.replace(' ', 'T')).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' });
  const periodTxt = first => {
    const days = (Date.now() - new Date(first.replace(' ', 'T')).getTime()) / 864e5;
    return days < 29 ? 'depuis le ' + fmtDateFr(first) : 'sur 30 jours';
  };

  function renderHealth(h) {
    // Site en ligne
    const u = h.uptime, vu = $('h-up');
    if (!u) {
      vu.textContent = '–'; vu.className = 'value';
      setDelta('h-up-d', '', '');
      $('h-up-h').textContent = 'Le suivi vient de démarrer : les premiers résultats arrivent dans quelques minutes.';
    } else {
      const period = u.first_at ? periodTxt(u.first_at) : 'sur 30 jours';
      vu.textContent = u.ok ? 'En ligne' : 'Hors ligne';
      vu.className = 'value' + (u.ok ? '' : ' down');
      if (u.pct !== null) {
        setDelta('h-up-d', u.pct.toFixed(2).replace('.', ',') + ' % de disponibilité ' + period,
                 u.pct >= 99.5 ? 'up' : u.pct >= 98 ? '' : 'down');
      } else setDelta('h-up-d', '', '');
      let hint = u.avg_ms !== null ? 'Temps de réponse moyen : ' + nf.format(u.avg_ms) + ' ms. ' : '';
      hint += u.last_down ? 'Dernière interruption : le ' + fmtDateFr(u.last_down) + '.' : 'Aucune interruption ' + period + '.';
      $('h-up-h').textContent = hint;
    }

    // Vitesse sur mobile
    const s = h.speed, vs = $('h-sp');
    if (!s) {
      vs.textContent = '–';
      setDelta('h-sp-d', '', '');
      $('h-sp-h').textContent = 'Première mesure demain matin.';
    } else {
      vs.textContent = s.score;
      const label = s.score >= 90 ? 'Très rapide' : s.score >= 50 ? 'À améliorer' : 'Lent';
      const diff = s.previous_score === null ? 0 : s.score - s.previous_score;
      setDelta('h-sp-d', label + (diff ? ` (${diff > 0 ? '+' : ''}${diff} depuis la dernière mesure)` : ''),
               s.score >= 90 ? 'up' : s.score >= 50 ? '' : 'down');
      $('h-sp-h').textContent = 'Note sur 100 de Google PageSpeed. Contenu principal affiché en '
        + String(s.lcp).replace('.', ',') + ' s sur mobile (mesure du ' + fmtDateFr(s.checked_at) + ').';
    }

    // Certificat HTTPS
    const c = h.ssl, vc = $('h-ssl');
    if (!c) {
      vc.textContent = '–'; vc.className = 'value';
      setDelta('h-ssl-d', '', '');
      $('h-ssl-h').textContent = 'Certificat non lisible pour le moment.';
    } else {
      vc.textContent = c.days < 0 ? 'Expiré' : c.days + (c.days > 1 ? ' jours' : ' jour');
      vc.className = 'value' + (c.days < 0 ? ' down' : '');
      setDelta('h-ssl-d',
               c.days <= 14 ? 'À renouveler au plus vite' : 'Valide jusqu\'au ' + dayLong(c.expires, true),
               c.days <= 14 ? 'down' : c.days <= 30 ? '' : 'up');
      $('h-ssl-h').textContent = 'Garantit la connexion sécurisée (le cadenas) de votre site.';
    }
  }

  async function loadHealth() {
    try {
      const r = await fetch('/api/health.php?site=' + encodeURIComponent($('site').value), { credentials: 'same-origin' });
      if (!r.ok) return;
      renderHealth(await r.json());
    } catch (e) { /* la section reste vide, le reste du tableau de bord fonctionne */ }
  }

  async function load(params = {}) {    
    $('error').textContent = '';
    const q = new URLSearchParams({ site: $('site').value, ...params });
    try {
      const r = await fetch('/api/stats.php?' + q, { credentials: 'same-origin' });
      if (r.status === 401) { location.href = '/login.php'; return; }
      const d = await r.json();
      if (!r.ok) throw new Error(d.error || 'Erreur');
      render(d);
    } catch (e) {
      $('error').textContent = 'Les chiffres ne se chargent pas. Rechargez la page, ou écrivez-moi si le problème continue.';
    }
  }

  document.querySelectorAll('#presets button').forEach(b => b.addEventListener('click', () => {
    if (!maxTo) return;
    load({ from: addDays(maxTo, -(+b.dataset.days - 1)), to: maxTo });
  }));
  $('apply').addEventListener('click', () => {
    if ($('from').value && $('to').value) load({ from: $('from').value, to: $('to').value });
  });
  $('site').addEventListener('change', () => { load(); loadHealth(); });
  load();
  loadHealth();
  </script>
<?php endif; ?>
</main>
</body>
</html>