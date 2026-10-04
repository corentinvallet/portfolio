<?php
/* post-facebook.php — publie un lien d'article sur la Page Facebook (appelé par l'admin) */
header('Content-Type: application/json; charset=utf-8');

// >>> Même valeur que SAVE_TOKEN dans admin/index.html <<<
$ADMIN_TOKEN = 'pigzefi86123!:;AZE';

function out($code, $arr) {
    http_response_code($code);
    echo json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') out(405, ['error' => 'Méthode non autorisée']);
if ($ADMIN_TOKEN === '') out(500, ['error' => 'Token non configuré dans post-facebook.php']);
if (!hash_equals($ADMIN_TOKEN, $_SERVER['HTTP_X_ADMIN_TOKEN'] ?? '')) out(401, ['error' => 'Non autorisé']);

$cfgFile = __DIR__ . '/inc/facebook-config.php';
if (!is_file($cfgFile)) out(500, ['error' => 'inc/facebook-config.php manquant']);
$cfg = require $cfgFile;

$data    = json_decode(file_get_contents('php://input'), true);
$message = trim((string)($data['message'] ?? ''));
$link    = trim((string)($data['link'] ?? ''));
$force   = !empty($data['force']);

// On n'accepte que des liens vers les articles du blog
if ($message === '' || mb_strlen($message) > 2000) out(400, ['error' => 'Message vide ou trop long']);
if (!preg_match('#^https://corentinvallet\.fr/blog-post\.php\?slug=[a-z0-9-]+$#', $link)) {
    out(400, ['error' => 'Lien invalide']);
}

// Simulation
if (!empty($cfg['dry_run'])) {
    out(200, ['ok' => true, 'dry_run' => true, 'would_post' => ['message' => $message, 'link' => $link]]);
}

if (empty($cfg['page_id']) || empty($cfg['page_token'])) {
    out(500, ['error' => 'page_id ou page_token manquant dans inc/facebook-config.php']);
}

// Anti-doublon : un même article n'est republié que sur demande explicite
$logFile = __DIR__ . '/facebook-posted.json';
$log = is_file($logFile) ? (json_decode((string)file_get_contents($logFile), true) ?: []) : [];
if (isset($log[$link]) && !$force) {
    out(409, ['error' => 'Déjà publié sur Facebook', 'code' => 'already_posted']);
}

$fields = ['message' => $message, 'link' => $link, 'access_token' => $cfg['page_token']];
if (!empty($cfg['unpublished'])) $fields['published'] = 'false';

$ch = curl_init('https://graph.facebook.com/' . $cfg['graph_version'] . '/' . $cfg['page_id'] . '/feed');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query($fields),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 20,
]);
$res  = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$cerr = curl_error($ch);
curl_close($ch);

if ($res === false) out(502, ['error' => 'Connexion à Facebook impossible : ' . $cerr]);

$json = json_decode($res, true);
if ($http >= 400 || !is_array($json) || empty($json['id'])) {
    $msg = is_array($json) && isset($json['error']['message']) ? $json['error']['message'] : ('HTTP ' . $http);
    out(502, ['error' => $msg]);
}

$log[$link] = ['id' => $json['id'], 'date' => date('c')];
@file_put_contents($logFile, json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);

out(200, ['ok' => true, 'id' => $json['id']]);