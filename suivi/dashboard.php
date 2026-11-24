<?php
require __DIR__ . '/../../suivi/lib/auth.php';
$client = require_login();

$st = db()->prepare('SELECT id, domain FROM sites WHERE client_id = ? AND active = 1 ORDER BY domain');
$st->execute([$client['id']]);
$sites = $st->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Suivi de mon site</title>
<style>
  :root{--bg:#f4f4f2;--card:#fff;--ink:#1d1d1b;--mute:#6b6b66;--line:#e4e4df;--up:#1a7f4b;--down:#b3261e}
  *{box-sizing:border-box}
  body{margin:0;font-family:system-ui,sans-serif;background:var(--bg);color:var(--ink)}
  header{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.2rem}
  header a{color:var(--mute);font-size:.9rem}
  main{max-width:960px;margin:0 auto;padding:0 1rem 3rem}
  .bar{display:flex;flex-wrap:wrap;gap:.5rem;align-items:center;margin-bottom:.8rem}
  button,select,input{font:inherit;padding:.45rem .7rem;border:1px solid var(--line);border-radius:8px;background:#fff}
  button{cursor:pointer}
  button.primary{background:var(--ink);color:#fff;border-color:var(--ink)}
  .cards{display:grid;grid-template-columns:repeat(2,1fr);gap:.7rem;margin-bottom:1rem}
  @media(min-width:700px){.cards{grid-template-columns:repeat(4,1fr)}}
  .card{background:var(--card);border-radius:12px;padding:.9rem 1rem}
  .card small{color:var(--mute);display:block}
  .card strong{font-size:1.6rem;display:block;margin:.2rem 0}
  .delta{font-size:.8rem;color:var(--mute)}
  .delta.up{color:var(--up)} .delta.down{color:var(--down)}
  .panel{background:var(--card);border-radius:12px;padding:1rem;margin-bottom:1rem}
  .panel h2{font-size:1rem;margin:0 0 .8rem}
  .chart{position:relative;height:280px}
  table{width:100%;border-collapse:collapse;font-size:.92rem}
  th,td{text-align:right;padding:.5rem .3rem;border-bottom:1px solid var(--line)}
  th:first-child,td:first-child{text-align:left;word-break:break-word}
  .note{color:var(--mute);font-size:.85rem;margin:.5rem 0 0}
  .err{color:var(--down)}
</style>
</head>
<body>
<header>
  <strong>Suivi de mon site</strong>
  <span><?= h($client['name']) ?> · <a href="/logout.php">Déconnexion</a></span>
</header>
<main>
<?php if (!$sites): ?>
  <p>Aucun site n'est rattaché à votre compte pour le moment.</p>
<?php else: ?>
  <div class="bar">
    <select id="site" aria-label="Site">
      <?php foreach ($sites as $s): ?>
        <option value="<?= (int)$s['id'] ?>"><?= h($s['domain']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="bar" id="presets">
    <button data-days="7">7 jours</button>
    <button data-days="30">30 jours</button>
    <button data-days="90">3 mois</button>
    <button data-days="365">12 mois</button>
  </div>
  <div class="bar">
    <label>Du <input type="date" id="from"></label>
    <label>au <input type="date" id="to"></label>
    <button class="primary" id="apply">Appliquer</button>
  </div>
  <p class="err" id="error"></p>

  <div class="cards">
    <div class="card"><small>Clics depuis Google</small><strong id="v-clicks">–</strong><span class="delta" id="d-clicks"></span></div>
    <div class="card"><small>Affichages dans Google</small><strong id="v-impressions">–</strong><span class="delta" id="d-impressions"></span></div>
    <div class="card"><small>Taux de clic</small><strong id="v-ctr">–</strong><span class="delta" id="d-ctr"></span></div>
    <div class="card"><small>Position moyenne</small><strong id="v-position">–</strong><span class="delta" id="d-position"></span></div>
  </div>

  <div class="panel">
    <h2>Évolution</h2>
    <div class="chart"><canvas id="chart"></canvas></div>
    <p class="note" id="chartNote"></p>
  </div>

  <div class="panel">
    <h2>Ce que les internautes ont tapé pour vous trouver</h2>
    <table>
      <thead><tr><th>Recherche</th><th>Clics</th><th>Affichages</th><th>Position</th></tr></thead>
      <tbody id="queries"></tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
  <script>
  const $ = id => document.getElementById(id);
  const nf = new Intl.NumberFormat('fr-FR');
  let chart = null, maxTo = null;

  const addDays = (s, n) => {
    const d = new Date(s + 'T00:00:00Z');
    d.setUTCDate(d.getUTCDate() + n);
    return d.toISOString().slice(0, 10);
  };
  const fmtDate = (s, long) => s.slice(8) + '/' + s.slice(5, 7) + (long ? '/' + s.slice(2, 4) : '');
  const fmtPos = v => v === null ? '–' : String(v).replace('.', ',');

  function setDelta(id, text, cls) {
    const e = $(id);
    e.textContent = text;
    e.className = 'delta ' + cls;
  }
  function pctDelta(id, cur, prev) {
    if (!prev) return setDelta(id, 'vs période précédente : —', '');
    const p = (cur - prev) / prev * 100;
    setDelta(id, (p > 0 ? '+' : '') + Math.round(p) + ' % vs période précédente', p > 0 ? 'up' : p < 0 ? 'down' : '');
  }

  function render(d) {
    maxTo = d.range.max_to;
    $('from').value = d.range.from;
    $('to').value = d.range.to;
    $('from').max = $('to').max = maxTo;

    const c = d.current, p = d.previous;
    $('v-clicks').textContent = nf.format(c.clicks);
    $('v-impressions').textContent = nf.format(c.impressions);
    $('v-ctr').textContent = (c.ctr * 100).toFixed(1).replace('.', ',') + ' %';
    $('v-position').textContent = fmtPos(c.position);

    pctDelta('d-clicks', c.clicks, p.clicks);
    pctDelta('d-impressions', c.impressions, p.impressions);

    if (p.impressions) {
      const pts = (c.ctr - p.ctr) * 100;
      setDelta('d-ctr', (pts > 0 ? '+' : '') + pts.toFixed(1).replace('.', ',') + ' pt vs période précédente', pts > 0 ? 'up' : pts < 0 ? 'down' : '');
    } else setDelta('d-ctr', 'vs période précédente : —', '');

    if (c.position !== null && p.position !== null) {
      const gain = p.position - c.position;   // une position plus basse est meilleure
      setDelta('d-position', (gain > 0 ? '+' : '') + gain.toFixed(1).replace('.', ',') + ' place(s) vs période précédente', gain > 0 ? 'up' : gain < 0 ? 'down' : '');
    } else setDelta('d-position', 'vs période précédente : —', '');

    const long = d.range.days > 92;
    const labels = d.series.map(r => fmtDate(r.date, long));
    const pr = labels.length > 45 ? 0 : 3;
    if (chart) chart.destroy();
    chart = new Chart($('chart'), {
      type: 'line',
      data: {
        labels,
        datasets: [
          { label: 'Clics', data: d.series.map(r => r.clicks), borderColor: '#2f6f4f', backgroundColor: '#2f6f4f', yAxisID: 'y', tension: .3, pointRadius: pr },
          { label: 'Affichages', data: d.series.map(r => r.impressions), borderColor: '#c2570c', backgroundColor: '#c2570c', yAxisID: 'y1', tension: .3, pointRadius: pr }
        ]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        scales: {
          y:  { beginAtZero: true, position: 'left',  ticks: { precision: 0 }, title: { display: true, text: 'Clics' } },
          y1: { beginAtZero: true, position: 'right', ticks: { precision: 0 }, grid: { drawOnChartArea: false }, title: { display: true, text: 'Affichages' } }
        }
      }
    });
    $('chartNote').textContent = d.range.group === 'week' ? 'Chaque point représente une semaine.' : '';

    const tb = $('queries');
    tb.replaceChildren();
    if (!d.queries.length) {
      const tr = document.createElement('tr'), td = document.createElement('td');
      td.colSpan = 4; td.textContent = 'Aucune donnée sur cette période.';
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
      $('error').textContent = 'Impossible de charger les données.';
    }
  }

  document.querySelectorAll('#presets button').forEach(b => b.addEventListener('click', () => {
    if (!maxTo) return;
    const n = +b.dataset.days;
    load({ from: addDays(maxTo, -(n - 1)), to: maxTo });
  }));
  $('apply').addEventListener('click', () => load({ from: $('from').value, to: $('to').value }));
  $('site').addEventListener('change', () => load());
  load();
  </script>
<?php endif; ?>
</main>
</body>
</html>