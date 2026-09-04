<?php
/* =====================================================================
   change-password.php — Permet à chaque personne ayant un compte dans
   .htpasswd (Francis, et toi séparément) de changer elle-même son propre
   mot de passe de connexion à /admin/.
   --------------------------------------------------------------------
   Réécrit directement le fichier .htpasswd (utilisé par Apache pour la
   protection "Basic Auth" définie dans .htaccess).

   Le compte à modifier est indiqué par le champ "user" envoyé par le
   formulaire. Ce n'est PAS un contrôle d'accès à lui seul : ce qui
   protège chaque compte, c'est qu'il faut fournir SON mot de passe actuel
   pour le changer. Impossible de changer le mot de passe d'un compte
   dont on ne connaît pas déjà le mot de passe actuel.

   Ce script ne touche QUE la ligne du compte demandé — les autres
   comptes présents dans .htpasswd ne sont jamais modifiés, quel que
   soit leur ordre dans le fichier.

   Aucune installation nécessaire : ce fichier doit simplement se trouver
   dans le même dossier que .htpasswd (le dossier admin/).
   ===================================================================== */

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
$user    = isset($data['user'])    ? (string)$data['user']    : 'admin';
$current = isset($data['current']) ? (string)$data['current'] : '';
$new     = isset($data['new'])     ? (string)$data['new']     : '';

if (!preg_match('/^[a-zA-Z0-9_.-]{1,64}$/', $user)) {
    http_response_code(400);
    echo json_encode(['error' => 'Identifiant invalide.']);
    exit;
}
if ($current === '' || $new === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Mot de passe actuel et nouveau mot de passe requis.']);
    exit;
}
if (strlen($new) < 10) {
    http_response_code(400);
    echo json_encode(['error' => 'Le nouveau mot de passe doit contenir au moins 10 caractères.']);
    exit;
}

$htpasswdPath = __DIR__ . '/.htpasswd';
$lines = @file($htpasswdPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (!$lines) {
    http_response_code(500);
    echo json_encode(['error' => 'Fichier .htpasswd introuvable ou invalide.']);
    exit;
}

// Cherche la ligne du compte demandé, quelle que soit sa position.
$targetIndex = null;
$hash = null;
foreach ($lines as $i => $line) {
    if (strpos($line, $user . ':') === 0) {
        $targetIndex = $i;
        $hash = substr($line, strlen($user) + 1);
        break;
    }
}
if ($targetIndex === null) {
    http_response_code(404);
    echo json_encode(['error' => "Compte '$user' introuvable dans .htpasswd."]);
    exit;
}

// Vérifie le mot de passe actuel contre le hash stocké (compatible $6$, $2y$, etc.)
if (!hash_equals($hash, crypt($current, $hash))) {
    http_response_code(401);
    echo json_encode(['error' => 'Mot de passe actuel incorrect.']);
    exit;
}

// Petite sauvegarde de l'ancien fichier, au cas où.
@copy($htpasswdPath, __DIR__ . '/.htpasswd.backup');

// Nouveau hash au même format (SHA-512 crypt) que celui déjà utilisé.
$salt    = bin2hex(random_bytes(8)); // 16 caractères hexadécimaux
$newHash = crypt($new, '$6$' . $salt . '$');

$lines[$targetIndex] = $user . ':' . $newHash;

if (file_put_contents($htpasswdPath, implode("\n", $lines) . "\n", LOCK_EX) === false) {
    http_response_code(500);
    echo json_encode(['error' => "Écriture impossible — vérifiez les droits du fichier .htpasswd (664)."]);
    exit;
}

echo json_encode(['ok' => true]);
