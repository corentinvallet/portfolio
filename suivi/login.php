<?php
require __DIR__ . '/../../suivi/lib/auth.php';
start_session();

if (current_client()) { header('Location: /dashboard.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass  = $_POST['password'] ?? '';

  if (!csrf_check($_POST['csrf'] ?? null)) {
    $error = 'Session expirée, réessayez.';
  } else {
    $st = db()->prepare('SELECT id, password_hash FROM clients WHERE email = ?');
    $st->execute([$email]);
    $c = $st->fetch();
    if ($c && password_verify($pass, $c['password_hash'])) {
      session_regenerate_id(true);
      $_SESSION['client_id'] = (int)$c['id'];
      header('Location: /dashboard.php');
      exit;
    }
    $error = 'Identifiants incorrects.';
  }
}
?>
<!doctype html>
<html lang="fr" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Connexion – Suivi de votre site</title>
<script>try{var t=localStorage.getItem('cv-theme');if(t)document.documentElement.setAttribute('data-theme',t)}catch(e){}</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=DM+Mono:wght@300;400&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/suivi.css?v=1">
</head>
<body>
<button class="icon-btn auth-top" id="theme" type="button" aria-label="Basculer entre thème clair et sombre"></button>
<main class="auth">
  <form class="auth-card" method="post">
    <a class="brand" href="https://www.corentinvallet.fr">
      <img src="https://www.corentinvallet.fr/Photos/Logo%20sans%20texte.png" alt="">
      <span>Corentin <em>Vallet</em></span>
    </a>
    <div class="eyebrow" style="margin-top:32px">Espace client</div>
    <h1 class="auth-title">Suivi de <em>votre site</em></h1>

    <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
    <div class="field">
      <label for="email">Adresse e-mail</label>
      <input id="email" name="email" type="email" autocomplete="username" required autofocus>
    </div>
    <div class="field">
      <label for="password">Mot de passe</label>
      <input id="password" name="password" type="password" autocomplete="current-password" required>
    </div>
    <?php if ($error): ?><p class="error" role="alert"><?= h($error) ?></p><?php endif; ?>
    <button class="btn btn-primary btn-block" type="submit">Se connecter</button>
    <a class="nav-link back" href="https://www.corentinvallet.fr">Retour au site</a>
  </form>
</main>
<script>
  const r = document.documentElement, b = document.getElementById('theme');
  const icon = () => { b.textContent = r.getAttribute('data-theme') === 'dark' ? '☀︎' : '☽'; };
  b.addEventListener('click', () => {
    const t = r.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    r.setAttribute('data-theme', t);
    try { localStorage.setItem('cv-theme', t); } catch (e) {}
    icon();
  });
  icon();
</script>
</body>
</html>