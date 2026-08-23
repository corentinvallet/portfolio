<?php
/* =====================================================================
   blog.php — Liste des articles du blog
   Rendu 100% côté serveur (contrairement à index.php) pour que Google
   voie le texte directement, sans dépendre de l'exécution JS.
   ===================================================================== */

$postsPath = __DIR__ . '/blog-posts.json';
$allPosts  = [];
if (file_exists($postsPath)) {
    $raw = file_get_contents($postsPath);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $allPosts = $decoded;
}

// Seuls les articles publiés, du plus récent au plus ancien
$posts = array_values(array_filter($allPosts, fn($p) => !empty($p['published'])));
usort($posts, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));

function h($s) { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Blog — Conseils sites web pour artisans à Valence | Corentin Vallet</title>
  <meta name="description" content="Conseils et retours d'expérience sur la création de sites web pour artisans et indépendants à Valence, Bourg-lès-Valence, Portes-lès-Valence et Romans-sur-Isère." />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="https://corentinvallet.fr/blog.php" />
  <link rel="stylesheet" href="nav.css">
  <link rel="icon" type="image/ico" href="Photos/Favicon_transp48.png">

  <meta property="og:type" content="website" />
  <meta property="og:locale" content="fr_FR" />
  <meta property="og:title" content="Blog — Corentin Vallet" />
  <meta property="og:description" content="Conseils sur la création de sites web pour artisans et indépendants à Valence et dans la Drôme." />
  <meta property="og:url" content="https://corentinvallet.fr/blog.php" />
  <meta property="og:image" content="https://corentinvallet.fr/Photos/og-image.png" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=DM+Mono:wght@300;400&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    :root {
      --bg:#f5f2ec; --bg2:#eee9df; --surface:#ffffff; --border:rgba(0,0,0,0.10);
      --text:#1a1714; --text2:#5a5046; --accent:#c45c2a; --accent2:#e8a97e;
      --tag-bg:#ecdfd3; --tag-text:#7a3d1e; --card-shadow:0 2px 24px rgba(0,0,0,0.07);
      --transition:0.35s cubic-bezier(.4,0,.2,1);
    }
    [data-theme="dark"] {
      --bg:#141210; --bg2:#1e1b17; --surface:#272320; --border:rgba(255,255,255,0.09);
      --text:#f0ebe3; --text2:#9e9080; --accent:#e07848; --accent2:#c45c2a;
      --tag-bg:#2e2319; --tag-text:#e0a070; --card-shadow:0 2px 24px rgba(0,0,0,0.4);
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    html{scroll-behavior:smooth;font-size:16px;}
    body{font-family:'Syne',sans-serif;background:var(--bg);color:var(--text);transition:background var(--transition),color var(--transition);padding-top:72px;}
    a{color:inherit;text-decoration:none;}
    .wrap{max-width:900px;margin:0 auto;padding:0 24px;}
    .hero{padding:64px 0 40px;}
    .eyebrow{font-family:'DM Mono',monospace;font-size:0.75rem;letter-spacing:.1em;text-transform:uppercase;color:var(--accent);margin-bottom:14px;display:block;}
    h1{font-family:'Fraunces',serif;font-weight:600;font-size:2.4rem;line-height:1.15;margin-bottom:14px;}
    .lead{color:var(--text2);font-size:1.05rem;max-width:620px;line-height:1.6;}
    .posts{padding:20px 0 80px;display:flex;flex-direction:column;gap:22px;}
    .post-card{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:28px;display:flex;flex-direction:column;gap:10px;box-shadow:var(--card-shadow);transition:transform var(--transition),border-color var(--transition);}
    .post-card:hover{transform:translateY(-2px);border-color:var(--accent2);}
    .post-date{font-family:'DM Mono',monospace;font-size:0.72rem;letter-spacing:.05em;color:var(--text2);text-transform:uppercase;}
    .post-title{font-family:'Fraunces',serif;font-weight:600;font-size:1.5rem;line-height:1.25;}
    .post-title a{transition:color var(--transition);}
    .post-title a:hover{color:var(--accent);}
    .post-excerpt{color:var(--text2);line-height:1.6;font-size:0.98rem;}
    .post-more{font-family:'DM Mono',monospace;font-size:0.78rem;color:var(--accent);align-self:flex-start;margin-top:4px;}
    .empty{padding:60px 0;text-align:center;color:var(--text2);}
    footer.site{border-top:1px solid var(--border);padding:28px 0;text-align:center;color:var(--text2);font-size:0.85rem;}
  </style>
</head>
<body>

<?php include __DIR__ . '/inc/nav.php'; ?>

<section class="hero">
  <div class="wrap">
    <span class="eyebrow">Blog</span>
    <h1>Conseils &amp; retours d'expérience</h1>
    <p class="lead">Création de sites web, référencement local et bonnes pratiques pour les artisans et indépendants de Valence et de la Drôme.</p>
  </div>
</section>

<section class="posts">
  <div class="wrap">
    <?php if (empty($posts)): ?>
      <div class="empty">Aucun article publié pour le moment — revenez bientôt.</div>
    <?php else: ?>
      <?php foreach ($posts as $p): ?>
        <article class="post-card">
          <span class="post-date"><?= h(date('d M Y', strtotime($p['date'] ?? 'now'))) ?></span>
          <h2 class="post-title"><a href="/blog-post.php?slug=<?= urlencode($p['slug'] ?? '') ?>"><?= h($p['title'] ?? '') ?></a></h2>
          <p class="post-excerpt"><?= h($p['excerpt'] ?? '') ?></p>
          <a class="post-more" href="/blog-post.php?slug=<?= urlencode($p['slug'] ?? '') ?>">Lire l'article →</a>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>

<footer class="site">
  <div class="wrap">© <?= date('Y') ?> Corentin Vallet — Création de sites web à Valence</div>
</footer>

<script src="nav.js"></script>
<script>
  const html = document.documentElement;
  const btn = document.getElementById('themeToggle');
  btn.addEventListener('click', () => {
    html.dataset.theme = html.dataset.theme === 'dark' ? 'light' : 'dark';
    localStorage.setItem('theme', html.dataset.theme);
  });
  const saved = localStorage.getItem('theme');
  if (saved) html.dataset.theme = saved;
</script>
</body>
</html>
