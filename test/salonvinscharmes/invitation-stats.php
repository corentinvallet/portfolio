<?php
/* invitation-stats.php — lit ou réinitialise le compteur de téléchargements de l'invitation */
header('Content-Type: application/json; charset=utf-8');

$statsFile = __DIR__ . '/data/invitation-downloads.json';

function read_count($file){
  if (!file_exists($file)) return 0;
  $data = json_decode(@file_get_contents($file), true);
  return (int)($data['count'] ?? 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $body = json_decode(file_get_contents('php://input'), true) ?: [];
  if (($body['action'] ?? '') === 'reset') {
    if (!is_dir(__DIR__ . '/data')) mkdir(__DIR__ . '/data', 0755, true);
    file_put_contents($statsFile, json_encode(['count' => 0]), LOCK_EX);
    echo json_encode(['ok' => true, 'count' => 0]);
    exit;
  }
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Action inconnue.']);
  exit;
}

echo json_encode(['count' => read_count($statsFile)]);