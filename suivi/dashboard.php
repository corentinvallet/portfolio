<?php
require __DIR__ . '/../../suivi/lib/auth.php';
$client = require_login();
?>
<!doctype html>
<html lang="fr">
<head><meta charset="utf-8"><meta name="robots" content="noindex"><title>Tableau de bord</title></head>
<body style="font-family:system-ui,sans-serif;padding:2rem">
  <p>Bonjour <?= h($client['name']) ?> 👋</p>
  <p><a href="/logout.php">Se déconnecter</a></p>
</body>
</html>