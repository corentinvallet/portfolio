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
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
  <title>Connexion – Suivi de mon site</title>
  <style>
    body{font-family:system-ui,sans-serif;background:#f4f4f2;display:flex;min-height:100vh;align-items:center;justify-content:center;margin:0}
    form{background:#fff;padding:2rem;border-radius:12px;width:min(92vw,340px);box-shadow:0 2px 12px rgba(0,0,0,.08)}
    h1{font-size:1.3rem;margin:0 0 1.2rem}
    label{display:block;font-size:.9rem;margin:.8rem 0 .3rem}
    input{width:100%;padding:.6rem;border:1px solid #ccc;border-radius:8px;box-sizing:border-box;font-size:1rem}
    button{margin-top:1.2rem;width:100%;padding:.7rem;border:0;border-radius:8px;background:#222;color:#fff;font-size:1rem;cursor:pointer}
    .err{color:#b00020;font-size:.9rem;margin-top:.8rem}
  </style>
</head>
<body>
  <form method="post">
    <h1>Suivi de mon site</h1>
    <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
    <label for="email">E-mail</label>
    <input id="email" name="email" type="email" required autofocus>
    <label for="password">Mot de passe</label>
    <input id="password" name="password" type="password" required>
    <button type="submit">Se connecter</button>
    <?php if ($error): ?><p class="err"><?= h($error) ?></p><?php endif; ?>
  </form>
</body>
</html>