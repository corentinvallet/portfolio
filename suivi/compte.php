<?php
require __DIR__ . '/../../suivi/lib/auth.php';
$client = require_login();
header('Cache-Control: no-store');

$first = !empty($client['must_change']);
$error = '';
$done  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_check($_POST['csrf'] ?? null)) {
    $error = 'Session expirée, réessayez.';
  } else {
    $cur  = $_POST['current'] ?? '';
    $new  = $_POST['new'] ?? '';
    $conf = $_POST['confirm'] ?? '';

    $st = db()->prepare('SELECT password_hash FROM clients WHERE id = ?');
    $st->execute([$client['id']]);
    $hash = (string)$st->fetchColumn();

    if (!password_verify($cur, $hash)) {
      $error = 'Le mot de passe actuel est incorrect.';
    } elseif (mb_strlen($new) < 10) {
      $error = 'Le nouveau mot de passe doit contenir au moins 10 caractères.';
    } elseif (strlen($new) > 72) {
      $error = 'Le nouveau mot de passe est trop long (72 caractères maximum).';
    } elseif ($new !== $conf) {
      $error = 'Les deux nouveaux mots de passe ne correspondent pas.';
    } elseif ($new === $cur) {
      $error = 'Choisissez un mot de passe différent de l\'actuel.';
    } else {
      db()->prepare('UPDATE clients SET password_hash = ?, must_change = 0 WHERE id = ?')
          ->execute([password_hash($new, PASSWORD_DEFAULT), $client['id']]);
      session_regenerate_id(true);
      $done = true;
      $first = false;
    }
  }
}
?>
<!doctype html>
<html lang="fr" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Mon compte – Suivi de votre site</title>
<script>try{var t=localStorage.getItem('cv-theme');if(t)document.documentElement.setAttribute('data-theme',t)}catch(e){}</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=DM+Mono:wght@300;400&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/suivi.css?v=1">
</head>
<body>
<main class="auth">
  <form class="auth-card" method="post">
    <a class="brand" href="https://www.corentinvallet.fr">
      <img src="https://www.corentinvallet.fr/Photos/Logo%20sans%20texte.png" alt="">
      <span>Corentin <em>Vallet</em></span>
    </a>

    <div class="eyebrow" style="margin-top:32px"><?= $first ? 'Première connexion' : 'Mon compte' ?></div>
    <?php if ($first): ?>
      <h1 class="auth-title">Choisissez <em>votre mot de passe</em></h1>
      <p class="note">Celui que je vous ai transmis est provisoire. Choisissez-en un que vous seul connaissez.</p>
    <?php else: ?>
      <h1 class="auth-title">Changer <em>mon mot de passe</em></h1>
    <?php endif; ?>

    <?php if ($done): ?>
      <p class="note" role="status" style="color:var(--up);font-weight:600">Mot de passe modifié.</p>
      <a class="btn btn-primary btn-block" style="display:block;text-align:center;text-decoration:none" href="/dashboard.php">Voir mon tableau de bord</a>
    <?php else: ?>
      <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
      <div class="field">
        <label for="current"><?= $first ? 'Mot de passe provisoire' : 'Mot de passe actuel' ?></label>
        <input id="current" name="current" type="password" autocomplete="current-password" required autofocus>
      </div>
      <div class="field">
        <label for="new">Nouveau mot de passe (10 caractères minimum)</label>
        <input id="new" name="new" type="password" autocomplete="new-password" minlength="10" maxlength="72" required>
      </div>
      <div class="field">
        <label for="confirm">Confirmer le nouveau mot de passe</label>
        <input id="confirm" name="confirm" type="password" autocomplete="new-password" minlength="10" maxlength="72" required>
      </div>
      <?php if ($error): ?><p class="error" role="alert"><?= h($error) ?></p><?php endif; ?>
      <button class="btn btn-primary btn-block" type="submit">Enregistrer</button>
      <?php if (!$first): ?><a class="nav-link back" href="/dashboard.php">Retour au tableau de bord</a><?php endif; ?>
    <?php endif; ?>
  </form>
</main>
</body>
</html>