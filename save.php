<?php
/* =====================================================================
   save.php — Enregistrement de content.json (hébergement PHP, ex. Hostinger)
   --------------------------------------------------------------------
   L'admin (/admin/) envoie ici le contenu complet, et ce script réécrit
   content.json directement sur le serveur. Plus aucune dépendance Firebase.

   INSTALLATION
   1. Déposez ce fichier à la racine du site (public_html), à côté de
      content.json et de index.html.
   2. Changez la valeur de $ADMIN_TOKEN ci-dessous (un mot de passe libre).
   3. Dans /admin/index.html, mettez la même valeur dans SAVE_TOKEN.
   4. Vérifiez que content.json est inscriptible (droits 644/664 sur le
      fichier, 755 sur le dossier — en général déjà le cas chez Hostinger).
   ===================================================================== */

header('Content-Type: application/json; charset=utf-8');

// >>> À PERSONNALISER <<< (doit être identique à SAVE_TOKEN dans /admin/index.html)
$ADMIN_TOKEN = 'pigzefi86123!:;AZE';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

if ($ADMIN_TOKEN !== '') {
    $tok = isset($_SERVER['HTTP_X_ADMIN_TOKEN']) ? $_SERVER['HTTP_X_ADMIN_TOKEN'] : '';
    if (!hash_equals($ADMIN_TOKEN, $tok)) {
        http_response_code(401);
        echo json_encode(['error' => 'Non autorisé']);
        exit;
    }
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON invalide']);
    exit;
}

// L'admin envoie { "content": {...} } ; on accepte aussi le contenu brut.
$content = isset($data['content']) ? $data['content'] : $data;
if (!is_array($content) || empty($content)) {
    http_response_code(400);
    echo json_encode(['error' => 'Contenu vide']);
    exit;
}

$json = json_encode(
    $content,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);

$path = __DIR__ . '/content.json';

// Petite sauvegarde de l'ancienne version, au cas où.
if (file_exists($path)) {
    @copy($path, __DIR__ . '/content.backup.json');
}

if (file_put_contents($path, $json, LOCK_EX) === false) {
    http_response_code(500);
    echo json_encode(['error' => "Écriture impossible — vérifiez les droits du dossier."]);
    exit;
}

echo json_encode(['ok' => true]);
