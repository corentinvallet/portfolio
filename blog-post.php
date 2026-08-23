<?php
/* =====================================================================
   blog-post.php — Affiche un article de blog (?slug=...)
   Chaque article a son propre <title>, meta description, Open Graph
   et JSON-LD Article — c'est ça qui aide au référencement, contrairement
   à une page unique où tout le contenu serait injecté en JS.
   ===================================================================== */

$postsPath = __DIR__ . '/blog-posts.json';
$allPosts  = [];
if (file_exists($postsPath)) {
    $raw = file_get_contents($postsPath);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $allPosts = $decoded;
}

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$post = null;
foreach ($allPosts as $p) {
    if (($p['slug'] ?? '') === $slug && !empty($p['published'])) {
        $post = $p;
        break;
    }
}

function h($s) { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }

if (!$post) {
    http_response_code(404);
}

$title = $post ? $post['title'] . ' | Blog Corentin Vallet' : 'Article introuvable | Corentin Vallet';
$desc  = $post ? ($post['excerpt'] ?? '') : "Cet article n'existe pas ou plus.";
$url   = 'https://corentinvallet.fr/blog-post.php?slug=' . urlencode($slug);
$image = $post && !empty($post['image']) ? $post['image'] : 'https://corentinvallet.fr/Photos/og-image.png';
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title><?= h($title) ?></title>
  <meta name="description" content="<?= h($desc) ?>" />
  <meta name="robots" content="<?= $post ? 'index, follow' : 'noindex, follow' ?>" />
  <?php if ($post): ?><link rel="canonical" href="<?= h($url) ?>" /><?php endif; ?>
  <link rel="icon" type="image/ico" href="Photos/Favicon_transp48.png">

  <meta property="og:type" content="article" />
  <meta property="og:locale" content="fr_FR" />
  <meta property="og:title" content="<?= h($title) ?>" />
  <meta property="og:description" content="<?= h($desc) ?>" />
  <meta property="og:url" content="<?= h($url) ?>" />
  <meta property="og:image" content="<?= h($image) ?>" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=DM+Mono:wght@300;400&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <?php if ($post): ?>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": <?= json_encode($post['title'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
    "description": <?= json_encode($post['excerpt'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
    "datePublished": <?= json_encode($post['date'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
    "author": { "@type": "Person", "name": "Corentin Vallet" },
    "publisher": { "@type": "Person", "name": "Corentin Vallet" },
    "mainEntityOfPage": <?= json_encode($url, JSON_UNESCAPED_UNICODE) ?>,
    "image": <?= json_encode($image, JSON_UNESCAPED_UNICODE) ?>
  }
  </script>
  <?php endif; ?>

  <style>
    :root {
      --bg:#f5f2ec; --bg2:#eee9df; --surface:#ffffff; --border:rgba(0,0,0,0.10);
      --text:#1a1714; --text2:#5a5046; --accent:#c45c2a; --accent2:#e8a97e;
      --card-shadow:0 2px 24px rgba(0,0,0,0.07); --transition:0.35s cubic-bezier(.4,0,.2,1);
    }
    [data-theme="dark"] {
      --bg:#141210; --bg2:#1e1b17; --surface:#272320; --border:rgba(255,255,255,0.09);
      --text:#f0ebe3; --text2:#9e9080; --accent:#e07848; --accent2:#c45c2a;
      --card-shadow:0 2px 24px rgba(0,0,0,0.4);
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Syne',sans-serif;background:var(--bg);color:var(--text);}
    a{color:inherit;text-decoration:none;}
    .wrap{max-width:760px;margin:0 auto;padding:0 24px;}
    header.site{padding:28px 0;border-bottom:1px solid var(--border);}
    header.site .wrap{display:flex;align-items:center;justify-content:space-between;}
    .brand{font-family:'Fraunces',serif;font-weight:600;font-size:1.3rem;}
    .back-link{font-family:'DM Mono',monospace;font-size:0.78rem;color:var(--text2);}
    .back-link:hover{color:var(--accent);}
    article{padding:56px 0 80px;}
    .post-date{font-family:'DM Mono',monospace;font-size:0.72rem;letter-spacing:.05em;color:var(--accent);text-transform:uppercase;margin-bottom:16px;display:block;}
    h1{font-family:'Fraunces',serif;font-weight:600;font-size:2.2rem;line-height:1.2;margin-bottom:26px;}
    .post-image{width:100%;border-radius:14px;margin-bottom:32px;box-shadow:var(--card-shadow);}
    .post-body{font-size:1.05rem;line-height:1.8;color:var(--text);}
    .post-body p{margin-bottom:1.2em;}
    .post-body h2{font-family:'Fraunces',serif;font-size:1.4rem;margin:1.6em 0 .6em;}
    .not-found{padding:80px 0;text-align:center;}
    footer.site{border-top:1px solid var(--border);padding:28px 0;text-align:center;color:var(--text2);font-size:0.85rem;}
  </style>
</head>
<body>

<header class="site">
  <div class="wrap">
    <a class="brand" href="/">Corentin Vallet</a>
    <a class="back-link" href="/blog.php">← Tous les articles</a>
  </div>
</header>

<?php if ($post): ?>
<article>
  <div class="wrap">
    <span class="post-date"><?= h(date('d M Y', strtotime($post['date'] ?? 'now'))) ?></span>
    <h1><?= h($post['title'] ?? '') ?></h1>
    <?php if (!empty($post['image'])): ?>
      <img class="post-image" src="<?= h($post['image']) ?>" alt="<?= h($post['title'] ?? '') ?>" />
    <?php endif; ?>
    <div class="post-body"><?= $post['content'] ?? '' /* HTML de confiance : saisi par l'admin, non par un visiteur */ ?></div>
  </div>
</article>
<?php else: ?>
<div class="wrap not-found">
  <h1>Article introuvable</h1>
  <p style="margin-top:14px;color:var(--text2);">Cet article n'existe pas ou a été dépublié.</p>
  <p style="margin-top:24px;"><a class="back-link" href="/blog.php">← Retour au blog</a></p>
</div>
<?php endif; ?>

<footer class="site">
  <div class="wrap">© <?= date('Y') ?> Corentin Vallet — Création de sites web à Valence</div>
</footer>

</body>
</html>
