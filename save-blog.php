<?php
/* save-blog.php — enregistre blog-posts.json et stocke les images dans Photos/Blog/ */
header('Content-Type: application/json; charset=utf-8');

// >>> Même valeur que SAVE_TOKEN dans admin/index.html <<<
$ADMIN_TOKEN = 'pigzefi86123!:;AZE';

const BLOG_IMG_DIR    = 'Photos/Blog';
const BLOG_MAX_IMAGES = 12;

function fail($code, $msg) {
    http_response_code($code);
    echo json_encode(['error' => $msg]);
    exit;
}

/* Transforme une image data: en fichier et renvoie son chemin relatif.
   Accepte aussi un chemin Photos/Blog/... déjà enregistré ou une URL http(s). */
function blog_store_image(string $src): string {
    $src = trim($src);
    if ($src === '') return '';

    if (preg_match('#^data:image/(?:jpeg|png|webp);base64,#i', substr($src, 0, 40), $m)) {
        $bin = base64_decode(substr($src, strlen($m[0])), true);
        if ($bin === false || $bin === '') return '';

        $info = @getimagesizefromstring($bin);
        if (!$info) return '';
        $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
        if (!isset($types[$info[2]])) return '';

        $dir = __DIR__ . '/' . BLOG_IMG_DIR;
        if (!is_dir($dir) && !@mkdir($dir, 0755, true)) fail(500, 'Impossible de créer le dossier ' . BLOG_IMG_DIR);

        $name = substr(sha1($bin), 0, 16) . '.' . $types[$info[2]];
        $dest = $dir . '/' . $name;
        if (!file_exists($dest) && file_put_contents($dest, $bin, LOCK_EX) === false) {
            fail(500, "Impossible d'écrire l'image — vérifiez les droits de " . BLOG_IMG_DIR);
        }
        return BLOG_IMG_DIR . '/' . $name;
    }

    if (preg_match('#^https?://#i', $src)) return $src;
    if (preg_match('#^' . preg_quote(BLOG_IMG_DIR, '#') . '/[A-Za-z0-9._-]+$#', $src)) return $src;
    return '';
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

    $date = (string)($p['date'] ?? '');

    // Liste d'images (compatible avec l'ancien champ "image" unique)
    $rawImages = (isset($p['images']) && is_array($p['images'])) ? $p['images'] : [];
    if (!$rawImages && !empty($p['image'])) $rawImages = [$p['image']];

    $images = [];
    foreach ($rawImages as $src) {
        if (!is_string($src)) continue;
        $path = blog_store_image($src);
        if ($path !== '') $images[] = $path;
        if (count($images) >= BLOG_MAX_IMAGES) break;
    }

    $clean[] = [
        'id'        => (string)($p['id'] ?? uniqid()),
        'title'     => trim((string)($p['title'] ?? '')),
        'slug'      => $slug,
        'date'      => preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) ? $date : date('Y-m-d'),
        'excerpt'   => trim((string)($p['excerpt'] ?? '')),
        'content'   => (string)($p['content'] ?? ''),
        'image'     => $images[0] ?? '',
        'images'    => $images,
        'published' => !empty($p['published']),
    ];
}

$json = json_encode($clean, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$path = __DIR__ . '/blog-posts.json';
if (file_exists($path)) @copy($path, __DIR__ . '/blog-posts.backup.json');

if (file_put_contents($path, $json, LOCK_EX) === false) {
    fail(500, 'Écriture impossible — vérifiez les droits du dossier.');
}
echo json_encode(['ok' => true]);