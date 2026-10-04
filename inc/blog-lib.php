<?php
/* Fonctions partagées du blog (blog.php, blog-post.php) */

function blog_e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function blog_normalize(array $p): array {
    return [
        'id'        => (string)($p['id'] ?? ''),
        'title'     => (string)($p['title'] ?? ''),
        'slug'      => (string)($p['slug'] ?? ''),
        'date'      => (string)($p['date'] ?? ''),
        'excerpt'   => (string)($p['excerpt'] ?? ''),
        'content'   => (string)($p['content'] ?? ''),
        'image'     => (string)($p['image'] ?? ''),
        'published' => !empty($p['published']),
    ];
}

/* Articles publiés, du plus récent au plus ancien */
function blog_published_posts(): array {
    $file = __DIR__ . '/../blog-posts.json';
    if (!is_file($file)) return [];
    $data = json_decode((string)file_get_contents($file), true);
    if (!is_array($data)) return [];

    $posts = [];
    foreach ($data as $p) {
        if (!is_array($p)) continue;
        $p = blog_normalize($p);
        if ($p['published'] && $p['slug'] !== '') $posts[] = $p;
    }
    usort($posts, fn($a, $b) => strcmp($b['date'], $a['date']));
    return $posts;
}

function blog_find_post(string $slug): ?array {
    foreach (blog_published_posts() as $p) {
        if ($p['slug'] === $slug) return $p;
    }
    return null;
}

function blog_date_fr(string $date): string {
    $mois = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
    $t = strtotime($date);
    if (!$t) return '';
    return (int)date('j', $t) . ' ' . $mois[(int)date('n', $t) - 1] . ' ' . date('Y', $t);
}

/* Nettoie le HTML de l'article : balises autorisées uniquement, pas d'attributs dangereux */
function blog_clean_html(string $html): string {
    $allowed = '<p><h2><h3><h4><ul><ol><li><strong><b><em><i><a><br><blockquote><img>';
    $html = strip_tags($html, $allowed);
    if (trim($html) === '') return '';

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8"?><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $keep  = ['href', 'src', 'alt', 'title', 'width', 'height'];
    foreach (iterator_to_array($xpath->query('//@*')) as $attr) {
        $name  = strtolower($attr->nodeName);
        $value = preg_replace('/[\x00-\x20]+/', '', (string)$attr->nodeValue);
        $bad = !in_array($name, $keep, true)
            || (($name === 'href' || $name === 'src') && preg_match('/^(javascript|vbscript|data):/i', $value));
        if ($bad) $attr->ownerElement->removeAttributeNode($attr);
    }

    $root = $dom->getElementsByTagName('div')->item(0);
    $out  = '';
    foreach ($root->childNodes as $child) $out .= $dom->saveHTML($child);
    return $out;
}