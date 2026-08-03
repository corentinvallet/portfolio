<?php
/* ═══════════════════════════════════════════════════════════
   save.php — enregistre content.json depuis l'admin
   ───────────────────────────────────────────────────────────
   Pas de mot de passe (même logique que B&A Construction).
   Pour ajouter une protection plus tard : décommentez le bloc
   TOKEN ci-dessous et ajoutez le même token dans admin.html
   (en-tête X-Edit-Token).
═══════════════════════════════════════════════════════════ */

header('Content-Type: application/json; charset=utf-8');

// --- CORS / méthode -------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit(json_encode(['ok' => false, 'error' => 'Méthode non autorisée. Utilisez POST.']));
}

/* --- Protection optionnelle par token (désactivée) -----------------
$TOKEN = 'change-moi';
$sent  = $_SERVER['HTTP_X_EDIT_TOKEN'] ?? '';
if (!hash_equals($TOKEN, $sent)) {
  http_response_code(403);
  exit(json_encode(['ok' => false, 'error' => 'Token invalide.']));
}
-------------------------------------------------------------------- */

// --- Lecture du corps ----------------------------------------------
$raw = file_get_contents('php://input');
if ($raw === false || $raw === '') {
  http_response_code(400);
  exit(json_encode(['ok' => false, 'error' => 'Corps de requête vide.']));
}

// --- Validation JSON -----------------------------------------------
$data = json_decode($raw, true);
if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
  http_response_code(400);
  exit(json_encode(['ok' => false, 'error' => 'JSON invalide : ' . json_last_error_msg()]));
}

$target = __DIR__ . '/content.json';

// --- Sauvegarde de la version précédente ---------------------------
if (is_file($target)) {
  @copy($target, __DIR__ . '/content.backup.json');
}

// --- Écriture atomique ---------------------------------------------
$pretty = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$tmp    = $target . '.tmp';

if (file_put_contents($tmp, $pretty, LOCK_EX) === false || !@rename($tmp, $target)) {
  @unlink($tmp);
  http_response_code(500);
  exit(json_encode(['ok' => false, 'error' => "Impossible d'écrire content.json. Vérifiez les droits du dossier (755) et du fichier (644)."]));
}

echo json_encode(['ok' => true, 'savedAt' => date('c')]);
