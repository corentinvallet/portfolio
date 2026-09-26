<?php
/* dl-invitation.php — redirige vers le PDF d'invitation et compte le clic */
require __DIR__ . '/inc/functions.php';
$c = load_content();
$url = $c['hero']['invitationPdf'] ?? '';

if ($url === '') {
  http_response_code(404);
  exit('Invitation introuvable.');
}

$statsFile = __DIR__ . '/data/invitation-downloads.json';
if (!is_dir(__DIR__ . '/data')) {
  mkdir(__DIR__ . '/data', 0755, true);
}

$fp = fopen($statsFile, 'c+');
if ($fp) {
  flock($fp, LOCK_EX);
  $raw = stream_get_contents($fp);
  $data = json_decode($raw, true) ?: ['count' => 0];
  $data['count'] = (int)($data['count'] ?? 0) + 1;
  ftruncate($fp, 0);
  rewind($fp);
  fwrite($fp, json_encode($data));
  fflush($fp);
  flock($fp, LOCK_UN);
  fclose($fp);
}

header('Location: ' . $url, true, 302);
exit;