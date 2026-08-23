<?php
/* =====================================================================
   save-blog.php — Enregistrement de blog-posts.json
   --------------------------------------------------------------------
   Même principe que save.php, mais pour les articles de blog.
   L'admin (/admin/) envoie ici la liste complète des articles, et ce
   script réécrit blog-posts.json à la racine du site.

   INSTALLATION
   1. Déposez ce fichier à la racine du site (public_html), à côté de
      index.php, content.json et save.php.
   2. Le token ci-dessous DOIT être identique à SAVE_TOKEN dans
      /admin/index.html (même valeur que pour save.php).
   3. Vérifiez que blog-posts.json est inscriptible (droits 644/664 sur
      le fichier, 755 sur le dossier).
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
if (!is_array($data) || !isset($data['posts']) || !is_array($data['posts'])) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON invalide — attendu { "posts": [...] }']);
    exit;
}

$posts = $data['posts'];

$json = json_encode(
    $posts,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);

$path = __DIR__ . '/blog-posts.json';

// Petite sauvegarde de l'ancienne version, au cas où.
if (file_exists($path)) {
    @copy($path, __DIR__ . '/blog-posts.backup.json');
}

if (file_put_contents($path, $json, LOCK_EX) === false) {
    http_response_code(500);
    echo json_encode(['error' => "Écriture impossible — vérifiez les droits du dossier."]);
    exit;
}

echo json_encode(['ok' => true]);
