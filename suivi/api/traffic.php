<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
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

// Visites (une personne par jour) et pages vues, jour par jour
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

$siteId =