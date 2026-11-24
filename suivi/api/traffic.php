<?php
require __DIR__ . '/../../../suivi/lib/auth.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function out(int $code, array $data): void {
  http_response_code($code);
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
  exit;
}

function parse_day($s, DateTimeZone $tz): ?DateTimeImmutable {
  if (!is_string($s)) return null;
  $d = DateTimeImmutable::createFromFormat('!Y-m-d', $s, $tz);
  return ($d && $d->format('Y-m-d') === $s) ? $d : null;
}

function daily(int $siteId, string $a, string $b): array {
  $st = db()->prepare(
    'SELECT day, COUNT(DISTINCT vid) AS v, COUNT(*) AS pv
     FROM hits WHERE site_id = ? AND day BETWEEN ? AND ? GROUP BY day'
  );
  $st->execute([$siteId, $a, $b]);
  $m = [];
  foreach ($st->fetchAll() as $r) {
    $m[$r['day']] = ['visits' => (int)$r['v'], 'views' => (int)$r['pv']];
  }
  return $m;
}

function totals(array $m): array {
  $t = ['visits' => 0, 'views' => 0];
  foreach ($m as $r) { $t['visits'] += $r['visits']; $t['views'] += $r['views']; }
  return $t;
}

// --- Authentification et propriété du site ---
$client = current_client();
if (!$client) out(401, ['error' => 'Non connecté']);

$siteId = (int)($_GET['site'] ?? 0);
if (!empty($client['is_admin'])) {
  $st = db()->prepare('SELECT id FROM sites WHERE id = ? AND active = 1');
  $st->execute([$siteId]);
} else {
  $st = db()->prepare('SELECT id FROM sites WHERE id = ? AND client_id = ? AND active = 1');
  $st->execute([$siteId, $client['id']]);
}
if (!$st->fetch()) out(404, ['error' => 'Site introuvable']);

// --- Le suivi est-il installé ? ---
$st = db()->prepare('SELECT MIN(day) FROM hits WHERE site_id = ?');
$st->execute([$siteId]);
$firstDay = $st->fetchColumn();
if (!$firstDay) out(200, ['installed' => false]);

// --- Dates ---
$tz    = new DateTimeZone('Europe/Paris');
$today = new DateTimeImmutable('today', $tz);

$to = parse_day($_GET['to'] ?? null, $tz) ?? $today;
if ($to > $today) $to = $today;
$from = parse_day($_GET['from'] ?? null, $tz) ?? $to->modify('-29 days');
if ($from > $to) $from = $to;

$days = $from->diff($to)->days + 1;
if ($days > 487) { $from = $to->modify('-486 days'); $days = 487; }

$prevTo   = $from->modify('-1 day');
$prevFrom = $prevTo->modify('-' . ($days - 1) . ' days');

$f = $from->format('Y-m-d');
$t = $to->format('Y-m-d');

$cur  = daily($siteId, $f, $t);
$prev = daily($siteId, $prevFrom->format('Y-m-d'), $prevTo->format('Y-m-d'));

// --- Courbe : par jour, ou par semaine au-delà de 92 jours ---
$series = [];
if ($days <= 92) {
  for ($d = $from; $d <= $to; $d = $d->modify('+1 day')) {
    $k = $d->format('Y-m-d');
    $series[] = ['date' => $k, 'visits' => $cur[$k]['visits'] ?? 0, 'views' => $cur[$k]['views'] ?? 0];
  }
} else {
  $weeks = [];
  for ($d = $from; $d <= $to; $d = $d->modify('+1 day')) {
    $day = $d->format('Y-m-d');
    $k   = $d->format('o-W');
    if (!isset($weeks[$k])) $weeks[$k] = ['date' => $day, 'visits' => 0, 'views' => 0];
    $weeks[$k]['visits'] += $cur[$day]['visits'] ?? 0;
    $weeks[$k]['views']  += $cur[$day]['views'] ?? 0;
  }
  $series = array_values($weeks);
}

// --- Origine des visites : première page vue de chaque visite ---
$st = db()->prepare(
  "SELECT source, COUNT(*) AS v FROM (
     SELECT day, vid, SUBSTRING_INDEX(GROUP_CONCAT(source ORDER BY id), ',', 1) AS source
     FROM hits WHERE site_id = ? AND day BETWEEN ? AND ? GROUP BY day, vid
   ) x GROUP BY source ORDER BY v DESC"
);
$st->execute([$siteId, $f, $t]);
$sources = array_map(fn($r) => ['source' => $r['source'], 'visits' => (int)$r['v']], $st->fetchAll());

// --- Pages les plus consultées ---
$st = db()->prepare(
  'SELECT path, COUNT(*) AS views FROM hits
   WHERE site_id = ? AND day BETWEEN ? AND ?
   GROUP BY path ORDER BY views DESC LIMIT 10'
);
$st->execute([$siteId, $f, $t]);
$pages = array_map(fn($r) => ['path' => $r['path'], 'views' => (int)$r['views']], $st->fetchAll());

out(200, [
  'installed'         => true,
  'first_day'         => $firstDay,
  'from'              => $f,
  'to'                => $t,
  'days'              => $days,
  'group'             => $days > 92 ? 'week' : 'day',
  'current'           => totals($cur),
  'previous'          => totals($prev),
  'previous_complete' => $prevFrom->format('Y-m-d') >= $firstDay,
  'series'            => $series,
  'sources'           => $sources,
  'pages'             => $pages,
]);