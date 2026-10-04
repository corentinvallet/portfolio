<?php
require __DIR__ . '/inc/blog-lib.php';

$slug = isset($_GET['slug']) ? (string)$_GET['slug'] : '';
$post = preg_match('/^[a-z0-9-]+$/', $slug) ? blog_find_post($slug) : null;
if (!$post) { http_response_code(404); }

$base = 'https://corentinvallet.fr';
if ($post) {
  $pageTitle = $post['title'] . ' | Corentin Vallet';
  $pageDesc  = $post['excerpt'] !== ''
    ? $post['excerpt']
    : mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($post['content']))), 0, 155);
  $pageUrl   = $base . '/blog-post.php?slug=' . rawurlencode($post['slug']);
  $ogImage   = (strpos($post['image'], 'http') === 0) ? $post['image'] : $base . '/Photos/og-image.png';
} else {
  $pageTitle = 'Article introuvable | Corentin Vallet';
  $pageDesc  = '';
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title><?= blog_e($pageTitle) ?></title>
<?php if ($post): ?>
  <meta name="description" content="<?= blog_e($pageDesc) ?>" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="<?= blog_e($pageUrl) ?>" />

  <meta property="og:type" content="article" />
  <meta property="og:locale" content="fr_FR" />
  <meta property="og:title" content="<?= blog_e($post['title']) ?>" />
  <meta property="og:description" content="<?= blog_e($pageDesc) ?>" />
  <meta property="og:url" content="<?= blog_e($pageUrl) ?>" />
  <meta property="og:image" content="<?= blog_e($ogImage) ?>" />
  <meta name="twitter:card" content="summary_large_image" />

<?php
  $ld = [
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $post['title'],
    'datePublished' => $post['date'],
    'author' => ['@type' => 'Person', 'name' => 'Corentin Vallet'],
    'mainEntityOfPage' => $pageUrl,
    'image' => $ogImage,
  ];
?>
  <script type="application/ld+json"><?= json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
<?php else: ?>
  <meta name="robots" content="noindex" />
<?php endif; ?>
  <link rel="icon" type="image/ico" href="Photos/Favicon_transp48.png">

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=DM+Mono:wght@300;400&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="blog.css?v=4">
  <link rel="stylesheet" href="lightbox.css">
</head>
<body>
<?php include __DIR__ . '/inc/nav.php'; ?>

<main class="post">
<?php if ($post): ?>
  <a href="blog.php" class="post-back">← Tous les articles</a>

  <article>
    <header>
      <time class="post-date" datetime="<?= blog_e($post['date']) ?>"><?= blog_e(blog_date_fr($post['date'])) ?></time>
      <h1 class="post-title"><?= blog_e($post['title']) ?></h1>
      <?php if ($post['excerpt'] !== ''): ?>
        <p class="post-lead"><?= blog_e($post['excerpt']) ?></p>
      <?php endif; ?>
    </header>

    <?php if ($post['images']):
      $nbImg   = count($post['images']);
      $mosaicN = min($nbImg, 5);
    ?>
      <div class="post-gallery post-mosaic n<?= $mosaicN ?>">
        <?php foreach ($post['images'] as $i => $src):
          $alt = $post['title'] . ($nbImg > 1 ? ' — photo ' . ($i + 1) . ' / ' . $nbImg : '');
        ?>
          <?php if ($i < 5): ?>
            <div class="post-mosaic-item">
              <img class="post-mosaic-img" src="<?= blog_e($src) ?>" alt="<?= blog_e($alt) ?>"<?= $i === 0 ? ' width="1200" height="675"' : ' loading="lazy"' ?>>
              <?php if ($i === 4 && $nbImg > 5): ?>
                <span class="post-mosaic-more">+<?= $nbImg - 5 ?></span>
              <?php endif; ?>
            </div>
          <?php else: ?>
            <img src="<?= blog_e($src) ?>" alt="<?= blog_e($alt) ?>" hidden>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="post-content">
      <?= blog_clean_html($post['content']) ?>
    </div>
  </article>

  <aside class="post-cta">
    <div class="post-cta-title">Un projet de site web ?</div>
    <p>Artisan, commerçant ou indépendant à Valence, en Drôme ou en Ardèche : parlons de votre projet, sans engagement.</p>
    <a href="index.php#contact" class="post-cta-btn">Me contacter</a>
  </aside>
<?php else: ?>
  <a href="blog.php" class="post-back">← Tous les articles</a>
  <h1 class="post-title">Article introuvable</h1>
  <p class="post-lead">Cet article n'existe pas ou n'est plus en ligne.</p>
<?php endif; ?>
</main>

<?php if ($post && $post['images']) include __DIR__ . '/inc/lightbox.php'; ?>

<?php include __DIR__ . '/inc/blog-footer.php'; ?>
</body>
</html>