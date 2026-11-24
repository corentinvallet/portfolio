<?php
// Mesure d'audience sans cookie : aucune adresse IP n'est enregistrée.
require __DIR__ . '/../../suivi/lib/db.php';
date_default_timezone_set('Europe/Paris');
header('Cache-Control: no-store');

function done(): void { http_response_code(204); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') done();

$in = json_decode((string)file_get_contents('php://input', false, null, 0, 2048), true);
if (!is_array($in)) done();

$key = (string)($in['k'] ?? '');
if (!preg_match('/^[a-f0-9]{16}$/', $key)) done();

// Robots, tests de performance, outils de supervision
$ua = (string)($_SERVER['HTTP_USER_AGENT'] ?? '');
if ($ua === '' || preg_match('/bot|crawl|spider|slurp|headless|lighthouse|pagespeed|preview|monitor|uptime|curl|wget|python|scrapy/i', $ua)) done();

try {
  $cfg = require __DIR__ . '/../../suivi/config/config.php';
  if (empty($cfg['tracker_secret'])) done();

  $st = db()->prepare('SELECT id, domain FROM sites WHERE track_key = ? AND active = 1');
  $st->execute([$key]);
  $site = $st->fetch();
  if (!$site) done();

  // L'appel doit venir du site concerné
  $from     = $_SERVER['HTTP_ORIGIN'] ?? ($_SERVER['HTTP_REFERER'] ?? '');
  $fromHost = preg_replace('/^www\./', '', strtolower((string)parse_url($from, PHP_URL_HOST)));
  $siteHost = preg_replace('/^www\./', '', strtolower($site['domain']));
  if ($fromHost !== $siteHost) done();

  // Page vue (sans paramètres d'adresse)
  $path = (string)parse_url((string)($in['p'] ?? '/'), PHP_URL_PATH);
  if ($path === '' || $path[0] !== '/') $path = '/';
  $path = mb_strcut($path, 0, 190);

  // Origine
  $refHost = preg_replace('/^www\./', '', strtolower((string)parse_url((string)($in['r'] ?? ''), PHP_URL_HOST)));
  if ($refHost === $siteHost) $refHost = '';
  if ($refHost === '') {
    $source = 'direct'; $refHost = null;
  } else {
    if (preg_match('/(^|\.)(google|bing|duckduckgo|ecosia|qwant|yahoo|brave|startpage)\./', $refHost)) $source = 'search';
    elseif (preg_match('/^(t\.co|x\.com|twitter\.com|lnkd\.in)$|(^|\.)(facebook|instagram|linkedin|pinterest|youtube|tiktok|reddit|threads)\./', $refHost)) $source = 'social';
    else $source = 'other';
    $refHost = mb_strcut($refHost, 0, 120);
  }

  // Appareil
  $device = preg_match('/iPad|Tablet/i', $ua) ? 'tablet' : (preg_match('/Mobi|Android|iPhone/i', $ua) ? 'mobile' : 'desktop');

  // Visiteur : empreinte qui change chaque jour, rien d'identifiant n'est conservé
  $ip   = $_SERVER['REMOTE_ADDR'] ?? '';
  $salt = hash_hmac('sha256', date('Y-m-d'), $cfg['tracker_secret']);
  $vid  = substr(hash_hmac('sha256', $ip . '|' . $ua . '|' . $site['id'], $salt), 0, 16);

  db()->prepare('INSERT INTO hits (site_id, ts, day, vid, path, source, ref_host, device) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')
      ->execute([$site['id'], date('Y-m-d H:i:s'), date('Y-m-d'), $vid, $path, $source, $refHost, $device]);
} catch (Throwable $e) {
  error_log($e->getMessage());
}
done();