<?php
require __DIR__ . '/../../suivi/lib/auth.php';
$admin = require_admin();
header('Cache-Control: no-store');

const LOGIN_URL = 'https://suivi.corentinvallet.fr/login.php';

function flash(string $type, string $msg, ?array $secret = null): void {
  $_SESSION['flash'] = ['type' => $type, 'msg' => $msg, 'secret' => $secret];
  header('Location: /admin.php');
  exit;
}

function gen_password(int $len = 14): string {
  $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';   // sans caractères ambigus
  $out = '';
  for ($i = 0; $i < $len; $i++) $out .= $chars[random_int(0, strlen($chars) - 1)];
  return $out;
}

function clean_domain(string $d): string {
  $d = strtolower(trim($d));
  $d = preg_replace('#^https?://#', '', $d);
  return preg_replace('#[/?\#].*$#', '', $d);
}

/* ---------- Actions ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_check($_POST['csrf'] ?? null)) flash('error', 'Session expirée, réessayez.');
  $pdo = db();

  try {
    switch ($_POST['action'] ?? '') {

      case 'create_client':
        $name  = trim($_POST['name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        if ($name === '' || mb_strlen($name) > 120) flash('error', 'Indiquez le nom du client (120 caractères maximum).');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) flash('error', 'Adresse e-mail invalide.');
        $st = $pdo->prepare('SELECT 1 FROM clients WHERE email = ?');
        $st->execute([$email]);
        if ($st->fetchColumn()) flash('error', 'Cette adresse e-mail a déjà un compte.');
        $pwd = gen_password();
        $pdo->prepare('INSERT INTO clients (name, email, password_hash, must_change) VALUES (?, ?, ?, 1)')
            ->execute([$name, $email, password_hash($pwd, PASSWORD_DEFAULT)]);
        flash('ok', "Compte créé pour « $name ». Ajoutez maintenant son site ci-dessous.",
              ['email' => $email, 'password' => $pwd]);
        break;

      case 'add_site':
        $cid = (int)($_POST['client_id'] ?? 0);
        $st = $pdo->prepare('SELECT 1 FROM clients WHERE id = ?');
        $st->execute([$cid]);
        if (!$st->fetchColumn()) flash('error', 'Client introuvable.');

        $domain = clean_domain($_POST['domain'] ?? '');
        if (!preg_match('/^(?=.{4,190}$)([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+[a-z]{2,}$/', $domain)) {
          flash('error', 'Nom de domaine invalide (exemple : monsite.fr).');
        }
        $gsc = trim($_POST['gsc_property'] ?? '');
        if ($gsc === '') $gsc = 'sc-domain:' . $domain;
        if (strlen($gsc) > 190 || !preg_match('#^(sc-domain:[a-z0-9.-]+|https?://\S+)$#i', $gsc)) {
          flash('error', 'Propriété Search Console invalide (sc-domain:monsite.fr ou https://monsite.fr/).');
        }
        $st = $pdo->prepare('SELECT 1 FROM sites WHERE client_id = ? AND domain = ?');
        $st->execute([$cid, $domain]);
        if ($st->fetchColumn()) flash('error', 'Ce site existe déjà pour ce client.');

        $pdo->prepare('INSERT INTO sites (client_id, domain, gsc_property) VALUES (?, ?, ?)')
            ->execute([$cid, $domain, $gsc]);
        $id = (int)$pdo->lastInsertId();
        flash('ok', "Site $domain ajouté (n° $id). Suite : ajouter l'adresse du compte de service dans sa Search Console, puis lancer « backfill_gsc.php $id » pour récupérer l'historique.");
        break;

      case 'toggle_site':
        $pdo->prepare('UPDATE sites SET active = 1 - active WHERE id = ?')
            ->execute([(int)($_POST['site_id'] ?? 0)]);
        flash('ok', 'Site mis à jour.');
        break;

      case 'reset_password':
        $st = $pdo->prepare('SELECT id, name, email FROM clients WHERE id = ?');
        $st->execute([(int)($_POST['client_id'] ?? 0)]);
        $c = $st->fetch();
        if (!$c) flash('error', 'Client introuvable.');
        $pwd = gen_password();
        $pdo->prepare('UPDATE clients SET password_hash = ?, must_change = 1 WHERE id = ?')
            ->execute([password_hash($pwd, PASSWORD_DEFAULT), $c['id']]);
        flash('ok', "Nouveau mot de passe généré pour « {$c['name']} ».",
              ['email' => $c['email'], 'password' => $pwd]);
        break;

      default:
        flash('error', 'Action inconnue.');
    }
  } catch (Throwable $e) {
    error_log($e->getMessage());
    flash('error', 'Une erreur est survenue, réessayez.');
  }
}

/* ---------- Données de la page ---------- */
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$clients = db()->query('SELECT id, name, email, is_admin FROM clients ORDER BY name')->fetchAll();
$sitesBy = [];
foreach (db()->query('SELECT id, client_id, domain, gsc_property, active FROM sites ORDER BY domain') as $s) {
  $sitesBy[$s['client_id']][] = $s;
}

$cfg  = require __DIR__ . '/../../suivi/config/config.php';
$key  = @json_decode((string)@file_get_contents($cfg['google_key_file']), true);
$saEmail = $key['client_email'] ?? '';
$token = csrf_token();
?>
<!doctype html>
<html lang="fr" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Clients – Administration</title>
<script>try{var t=localStorage.getItem('cv-theme');if(t)document.documentElement.setAttribute('data-theme',t)}catch(e){}</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=DM+Mono:wght@300;400&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/suivi.css?v=1">
</head>
<body>
<header class="nav">
  <a class="brand" href="https://www.corentinvallet.fr">
    <img src="https://www.corentinvallet.fr/Photos/Logo%20sans%20texte.png" alt="">
    <span>Corentin <em>Vallet</em></span>
  </a>
  <div class="nav-right">
    <a class="nav-link" href="/dashboard.php">Tableau de bord</a>
    <button class="icon-btn" id="theme" type="button" aria-label="Basculer entre thème clair et sombre"></button>
    <a class="nav-link" href="/logout.php">Déconnexion</a>
  </div>
</header>

<main class="wrap">
  <div class="eyebrow">Administration</div>
  <h1>Vos <em>clients</em></h1>

  <?php if ($flash): ?>
    <section class="panel flash <?= $flash['type'] === 'ok' ? '' : 'flash-err' ?>" role="status">
      <p><?= h($flash['msg']) ?></p>
      <?php if (!empty($flash['secret'])):
        $access = "Adresse : " . LOGIN_URL . "\nE-mail : " . $flash['secret']['email'] . "\nMot de passe : " . $flash['secret']['password']; ?>
        <p class="note">À transmettre maintenant au client : ce mot de passe ne sera plus affiché. Il devra en choisir un nouveau dès sa première connexion.</p>
        <div class="secret">
          <div><span>Adresse</span><?= h(LOGIN_URL) ?></div>
          <div><span>E-mail</span><?= h($flash['secret']['email']) ?></div>
          <div><span>Mot de passe</span><code><?= h($flash['secret']['password']) ?></code></div>
        </div>
        <button type="button" class="btn btn-ghost btn-sm" id="copy-access" data-text="<?= h($access) ?>">Copier les accès</button>
      <?php endif; ?>
    </section>
  <?php endif; ?>

  <section class="panel">
    <h2>Nouveau client</h2>
    <form method="post" class="inline-form">
      <input type="hidden" name="csrf" value="<?= h($token) ?>">
      <input type="hidden" name="action" value="create_client">
      <input name="name" placeholder="Nom du client ou de l'entreprise" aria-label="Nom du client" required maxlength="120">
      <input name="email" type="email" placeholder="Adresse e-mail de connexion" aria-label="Adresse e-mail" required maxlength="190">
      <button class="btn btn-primary" type="submit">Créer le compte</button>
    </form>
  </section>

  <?php if ($saEmail): ?>
  <section class="panel">
    <h2>Rappel : accès Search Console</h2>
    <p class="note" style="margin-bottom:12px">Pour chaque site, ajoutez cette adresse dans la Search Console (Paramètres, Utilisateurs et propriétaires, autorisation « Restreinte ») :</p>
    <p class="sa"><?= h($saEmail) ?></p>
    <p style="margin:12px 0 0"><button type="button" class="btn btn-ghost btn-sm" id="copy-sa" data-text="<?= h($saEmail) ?>">Copier l'adresse</button></p>
  </section>
  <?php endif; ?>

  <?php foreach ($clients as $c): $mine = $sitesBy[$c['id']] ?? []; ?>
  <section class="panel">
    <div class="client-head">
      <div>
        <h2><?= h($c['name']) ?></h2>
        <p class="note"><?= h($c['email']) ?><?= $c['is_admin'] ? ' (administrateur)' : '' ?></p>
      </div>
      <form method="post" onsubmit="return confirm('Générer un nouveau mot de passe ? L\'ancien ne fonctionnera plus.')">
        <input type="hidden" name="csrf" value="<?= h($token) ?>">
        <input type="hidden" name="action" value="reset_password">
        <input type="hidden" name="client_id" value="<?= (int)$c['id'] ?>">
        <button class="btn btn-ghost btn-sm" type="submit">Nouveau mot de passe</button>
      </form>
    </div>

    <?php if ($mine): ?>
    <table>
      <thead><tr><th>Site</th><th class="left">Propriété Search Console</th><th>État</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($mine as $s): ?>
        <tr>
          <td><?= h($s['domain']) ?> <small>(n° <?= (int)$s['id'] ?>)</small></td>
          <td class="left sa"><?= h($s['gsc_property'] ?? '') ?></td>
          <td class="<?= $s['active'] ? 'status-on' : 'status-off' ?>"><?= $s['active'] ? 'Actif' : 'Désactivé' ?></td>
          <td>
            <form method="post">
              <input type="hidden" name="csrf" value="<?= h($token) ?>">
              <input type="hidden" name="action" value="toggle_site">
              <input type="hidden" name="site_id" value="<?= (int)$s['id'] ?>">
              <button class="btn btn-ghost btn-sm" type="submit"><?= $s['active'] ? 'Désactiver' : 'Réactiver' ?></button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <p class="note">Aucun site pour le moment.</p>
    <?php endif; ?>

    <form method="post" class="inline-form">
      <input type="hidden" name="csrf" value="<?= h($token) ?>">
      <input type="hidden" name="action" value="add_site">
      <input type="hidden" name="client_id" value="<?= (int)$c['id'] ?>">
      <input name="domain" placeholder="Domaine : monsite.fr" aria-label="Domaine du site" required maxlength="190">
      <input name="gsc_property" placeholder="Search Console (facultatif) : sc-domain:monsite.fr" aria-label="Propriété Search Console" maxlength="190">
      <button class="btn btn-primary btn-sm" type="submit">Ajouter le site</button>
    </form>
  </section>
  <?php endforeach; ?>
</main>

<script>
  const root = document.documentElement, tb = document.getElementById('theme');
  const icon = () => { tb.textContent = root.getAttribute('data-theme') === 'dark' ? '☀︎' : '☽'; };
  tb.addEventListener('click', () => {
    const t = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    root.setAttribute('data-theme', t);
    try { localStorage.setItem('cv-theme', t); } catch (e) {}
    icon();
  });
  icon();

  ['copy-access', 'copy-sa'].forEach(id => {
    const b = document.getElementById(id);
    if (!b) return;
    b.addEventListener('click', () => {
      navigator.clipboard.writeText(b.dataset.text).then(() => { b.textContent = 'Copié'; });
    });
  });
</script>
</body>
</html>