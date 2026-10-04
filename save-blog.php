<?php
/* save-blog.php — enregistre blog-posts.json (appelé par l'admin) */
header('Content-Type: application/json; charset=utf-8');

// >>> Même valeur que $ADMIN_TOKEN dans save.php <<<
$ADMIN_TOKEN = 'pigzefi86123!:;AZE';

function fail($code, $msg) {
    http_response_code($code);
    echo json_encode(['error' => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') fail(405, 'Méthode non autorisée');
if ($ADMIN_TOKEN === '') fail(500, 'Token non configuré dans save-blog.php');

$tok = $_SERVER['HTTP_X_ADMIN_TOKEN'] ?? '';
if (!hash_equals($ADMIN_TOKEN, $tok)) fail(401, 'Non autorisé');

$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data) || !isset($data['posts']) || !is_array($data['posts'])) {
    fail(400, 'JSON invalide');
}

$clean = [];
$slugs = [];
foreach ($data['posts'] as $p) {
    if (!is_array($p)) continue;

    $slug = (string)($p['slug'] ?? '');
    if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)) fail(400, 'Slug invalide : ' . $slug);
    if (isset($slugs[$slug])) fail(400, 'Slug en double : ' . $slug);
    $slugs[$slug] = true;

    $date  = (string)($p['date'] ?? '');
    $image = (string)($p['image'] ?? '');
    if (!preg_match('#^(https?://|data:image/(jpeg|png|webp|gif);base64,|[\w./-]+$)#i', $image)) $image = '';

    $clean[] = [
        'id'        => (string)($p['id'] ?? uniqid()),
        'title'     => trim((string)($p['title'] ?? '')),
        'slug'      => $slug,
        'date'      => preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) ? $date : date('Y-m-d'),
        'excerpt'   => trim((string)($p['excerpt'] ?? '')),
        'content'   => (string)($p['content'] ?? ''),
        'image'     => $image,
        'published' => !empty($p['published']),
    ];
}

$json = json_encode($clean, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if (strlen($json) > 8 * 1024 * 1024) fail(413, 'Fichier trop volumineux (images trop lourdes ?)');

$path = __DIR__ . '/blog-posts.json';
if (file_exists($path)) @copy($path, __DIR__ . '/blog-posts.backup.json');

if (file_put_contents($path, $json, LOCK_EX) === false) {
    fail(500, 'Écriture impossible — vérifiez les droits du dossier.');
}
echo json_encode(['ok' => true]);