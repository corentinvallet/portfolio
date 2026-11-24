<?php
require __DIR__ . '/../../../suivi/lib/auth.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function out(int $code, array $data): void {
  http_response_code($code);
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
  exit;
}

$client = current_client();
if (!$client) out(401, ['error' => 'Non connecté']);

$siteId = (int)($_GET['site'] ?? 0);
$st = db()->prepare('SELECT id, ssl_expires FROM sites WHERE id = ? AND client_id = ? AND active = 1');
$st->execute([$siteId, $client['id']]);
$site = $st->fetch();
if (!$site) out(404, ['error' => 'Site introuvable']);

date_default_timezone_set('Europe/Paris');
$since = date('Y-m-d H:i:s', strtotime('-30 days'));

// --- Disponibilité ---
$st = db()->prepare('SELECT ok, status_code, checked_at FROM uptime_checks WHERE site_id = ? ORDER BY id DESC LIMIT 1');
$st->execute([$siteId]);
$lastCheck = $st->fetch();

$uptime = null;
if ($lastCheck) {
  $st = db()->prepare(
    'SELECT COUNT(*) AS n, SUM(ok) AS up,
            AVG(CASE WHEN ok = 1 THEN response_ms END) AS avg_ms,
            MIN(checked_at) AS first_at
     FROM uptime_checks WHERE site_id = ? AND checked_at >= ?'
  );
  $st->execute([$siteId, $since]);
  $a = $st->fetch();

  $st = db()->prepare('SELECT MAX(checked_at) FROM uptime_checks WHERE site_id = ? AND ok = 0 AND checked_at >= ?');
  $st->execute([$siteId, $since]);
  $lastDown = $st->fetchColumn() ?: null;

  $n = (int)$a['n'];
  $uptime = [
    'ok'         => (bool)$lastCheck['ok'],
    'status'     => $lastCheck['status_code'] !== null ? (int)$lastCheck['status_code'] : null,
    'checked_at' => $lastCheck['checked_at'],
    'pct'        => $n ? round((int)$a['up'] / $n * 100, 2) : null,
    'avg_ms'     => $a['avg_ms'] !== null ? (int)round((float)$a['avg_ms']) : null,
    'first_at'   => $a['first_at'],
    'last_down'  => $lastDown,
  ];
}

// --- Vitesse (PageSpeed mobile) ---
$st = db()->prepare(
  "SELECT checked_at, score, lcp, cls FROM pagespeed
   WHERE site_id = ? AND strategy = 'mobile' AND score IS NOT NULL
   ORDER BY id DESC LIMIT 2"
);
$st->execute([$siteId]);
$ps = $st->fetchAll();
$speed = $ps ? [
  'checked_at'     => $ps[0]['checked_at'],
  'score'          => (int)$ps[0]['score'],
  'lcp'            => (float)$ps[0]['lcp'],
  'cls'            => (float)$ps[0]['cls'],
  'previous_score' => isset($ps[1]) ? (int)$ps[1]['score'] : null,
] : null;

// --- Certificat HTTPS ---
$ssl = null;
if (!empty($site['ssl_expires'])) {
  $ssl = [
    'expires' => $site['ssl_expires'],
    'days'    => (int)floor((strtotime($site['ssl_expires']) - time()) / 86400),
  ];
}

out(200, ['uptime' => $uptime, 'speed' => $speed, 'ssl' => $ssl]);