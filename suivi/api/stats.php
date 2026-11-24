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

function totals(int $siteId, string $a, string $b): array {
  $st = db()->prepare(
    'SELECT COALESCE(SUM(clicks),0) AS clicks,
            COALESCE(SUM(impressions),0) AS impressions,
            SUM(`position` * impressions) / NULLIF(SUM(impressions),0) AS pos
     FROM gsc_daily WHERE site_id = ? AND day BETWEEN ? AND ?'
  );
  $st->execute([$siteId, $a, $b]);
  $r = $st->fetch();
  $cl  = (int)$r['clicks'];
  $imp = (int)$r['impressions'];
  return [
    'clicks'      => $cl,
    'impressions' => $imp,
    'ctr'         => $imp ? round($cl / $imp, 4) : 0,
    'position'    => $r['pos'] !== null ? round((float)$r['pos'], 1) : null,
  ];
}

// --- Authentification et propriété du site ---
$client = current_client();
if (!$client) out(401, ['error' => 'Non connecté']);

$siteId = (int)($_GET['site'] ?? 0);
$st = db()->prepare('SELECT id, domain FROM sites WHERE id = ? AND client_id = ? AND active = 1');
$st->execute([$siteId, $client['id']]);
$site = $st->fetch();
if (!$site) out(404, ['error' => 'Site introuvable']);

// --- Dates ---
$tz  = new DateTimeZone('Europe/Paris');
$max = (new DateTimeImmutable('today', $tz))->modify('-3 days');   // décalage Search Console

$to = parse_day($_GET['to'] ?? null, $tz) ?? $max;
if ($to > $max) $to = $max;
$from = parse_day($_GET['from'] ?? null, $tz) ?? $to->modify('-29 days');
if ($from > $to) $from = $to;

$days = $from->diff($to)->days + 1;
if ($days > 487) {                       // ~16 mois, limite Search Console
  $from = $to->modify('-486 days');
  $days = 487;
}

$prevTo   = $from->modify('-1 day');
$prevFrom = $prevTo->modify('-' . ($days - 1) . ' days');

$f = $from->format('Y-m-d');
$t = $to->format('Y-m-d');

// --- Courbe : par jour, ou par semaine au-delà de 92 jours ---
$grouped = $days > 92;
$series  = [];

if (!$grouped) {
  $st = db()->prepare(
    'SELECT day, clicks, impressions FROM gsc_daily
     WHERE site_id = ? AND day BETWEEN ? AND ?'
  );
  $st->execute([$siteId, $f, $t]);
  $map = [];
  foreach ($st->fetchAll() as $r) $map[$r['day']] = $r;

  for ($d = $from; $d <= $to; $d = $d->modify('+1 day')) {
    $k = $d->format('Y-m-d');
    $series[] = [
      'date'        => $k,
      'clicks'      => (int)($map[$k]['clicks'] ?? 0),
      'impressions' => (int)($map[$k]['impressions'] ?? 0),
    ];
  }
} else {
  $st = db()->prepare(
    'SELECT MIN(day) AS d, SUM(clicks) AS c, SUM(impressions) AS i
     FROM gsc_daily WHERE site_id = ? AND day BETWEEN ? AND ?
     GROUP BY YEARWEEK(day, 3) ORDER BY d'
  );
  $st->execute([$siteId, $f, $t]);
  foreach ($st->fetchAll() as $r) {
    $series[] = [
      'date'        => $r['d'],
      'clicks'      => (int)$r['c'],
      'impressions' => (int)$r['i'],
    ];
  }
}

// --- Meilleures requêtes ---
$st = db()->prepare(
  'SELECT `query`,
          SUM(clicks) AS clicks,
          SUM(impressions) AS impressions,
          SUM(`position` * impressions) / NULLIF(SUM(impressions),0) AS pos
   FROM gsc_queries
   WHERE site_id = ? AND day BETWEEN ? AND ?
   GROUP BY `query`
   ORDER BY clicks DESC, impressions DESC
   LIMIT 10'
);
$st->execute([$siteId, $f, $t]);
$queries = [];
foreach ($st->fetchAll() as $r) {
  $queries[] = [
    'query'       => $r['query'],
    'clicks'      => (int)$r['clicks'],
    'impressions' => (int)$r['impressions'],
    'position'    => $r['pos'] !== null ? round((float)$r['pos'], 1) : null,
  ];
}

out(200, [
  'site'     => ['id' => (int)$site['id'], 'domain' => $site['domain']],
  'range'    => [
    'from' => $f, 'to' => $t, 'days' => $days,
    'group' => $grouped ? 'week' : 'day',
    'max_to' => $max->format('Y-m-d'),
  ],
  'current'  => totals($siteId, $f, $t),
  'previous' => totals($siteId, $prevFrom->format('Y-m-d'), $prevTo->format('Y-m-d')),
  'series'   => $series,
  'queries'  => $queries,
]);