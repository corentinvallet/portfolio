<?php
require __DIR__ . '/inc/blog-lib.php';
$posts = blog_published_posts();
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Blog — Sites web pour artisans et indépendants à Valence | Corentin Vallet</title>
  <meta name="description" content="Conseils et retours d'expérience sur la création de site web pour artisans, commerçants et indépendants à Valence, en Drôme et en Ardèche." />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="https://corentinvallet.fr/blog.php" />
  <link rel="icon" type="image/ico" href="Photos/Favicon_transp48.png">

  <meta property="og:type" content="website" />
  <meta property="og:locale" content="fr_FR" />
  <meta property="og:title" content="Blog — Sites web pour artisans et indépendants à Valence" />
  <meta property="og:description" content="Conseils et retours d'expérience sur la création de site web pour artisans et indépendants en Drôme et Ardèche." />
  <meta property="og:url" content="https://corentinvallet.fr/blog.php" />
  <meta property="og:image" content="https://corentinvallet.fr/Photos/og-image.png" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=DM+Mono:wght@300;400&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="blog.css?v=1">
</head>
<body>
<?php include __DIR__ . '/inc/nav.php'; ?>

<main class="blog-main">
  <div class="blog-eyebrow">Le blog</div>
  <h1 class="blog-title">Conseils web pour <em>artisans</em><br>et indépendants.</h1>
  <p class="blog-intro">Retours d'expérience, bonnes pratiques et conseils concrets pour réussir votre présence en ligne à Valence, en Drôme et en Ardèche.</p>

  <?php if (!$posts): ?>
    <p class="blog-empty">Les premiers articles arrivent bientôt.</p>
  <?php else: ?>
    <div class="blog-grid">
      <?php foreach ($posts as $p): ?>
        <article class="blog-card">
          <a class="blog-card-link" href="blog-post.php?slug=<?= rawurlencode($p['slug']) ?>">
            <div class="blog-card-cover">
              <?php if ($p['image'] !== ''): ?>
                <img src="<?= blog_e($p['image']) ?>" alt="" width="640" height="360" loading="lazy">
              <?php endif; ?>
            </div>
            <div class="blog-card-body">
              <time class="blog-card-date" datetime="<?= blog_e($p['date']) ?>"><?= blog_e(blog_date_fr($p['date'])) ?></time>
              <h2 class="blog-card-title"><?= blog_e($p['title']) ?></h2>
              <?php if ($p['excerpt'] !== ''): ?>
                <p class="blog-card-excerpt"><?= blog_e($p['excerpt']) ?></p>
              <?php endif; ?>
              <span class="blog-card-more">Lire l'article →</span>
            </div>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/inc/blog-footer.php'; ?>
</body>
</html>