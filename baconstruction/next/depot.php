<?php
/* ═══════════════════════════════════════════════════════════
   depot.php — Espace de dépôt photos (B&A Construction)
   ───────────────────────────────────────────────────────────
   Page privée, hors menu. Le client envoie ses photos depuis
   son téléphone ; elles partent chez Cloudinary et la liste
   est consignée dans depot.json.

   Pour consulter les dépôts :  depot.php?liste=1
═══════════════════════════════════════════════════════════ */

/* ══ RÉGLAGES — à personnaliser ══════════════════════════ */
$ACCESS_CODE  = 'CHANTIER';        // code remis au client ('' = accès libre)
$ADMIN_CODE   = 'change-moi';      // votre code pour ?liste=1
$NOTIFY_EMAIL = '';                // ex. 'contact@exemple.fr' ('' = pas d'e-mail)
$FOLDER       = 'depot-client';    // dossier Cloudinary de destination
/* ════════════════════════════════════════════════════════ */

session_start();
$STORE = __DIR__ . '/depot.json';

function e($s) { return htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8'); }

$c     = json_decode(@file_get_contents(__DIR__ . '/content.json'), true) ?: [];
$cloud = $c['cloudinary'] ?? [];
$logo  = $c['logo'] ?? 'Photos/Logo simplifié.webp';

/* ═══════════════════════════════════════════════════════════
   1. ENDPOINT — réception d'un dépôt (POST JSON)
═══════════════════════════════════════════════════════════ */
if (isset($_GET['envoi'])) {
  header('Content-Type: application/json; charset=utf-8');

  if ($ACCESS_CODE !== '' && empty($_SESSION['depot_ok'])) {
    http_response_code(403);
    exit(json_encode(['ok' => false, 'error' => 'Session expirée. Rechargez la page.']));
  }

  $in = json_decode(file_get_contents('php://input'), true);
  if (!is_array($in) || empty($in['photos']) || !is_array($in['photos'])) {
    http_response_code(400);
    exit(json_encode(['ok' => false, 'error' => 'Aucune photo reçue.']));
  }

  $entry = [
    'date'        => date('c'),
    'auteur'      => mb_substr(trim((string)($in['auteur'] ?? '')), 0, 80),
    'commentaire' => mb_substr(trim((string)($in['commentaire'] ?? '')), 0, 2000),
    'photos'      => [],
  ];

  foreach ($in['photos'] as $p) {
    if (!is_array($p) || empty($p['full'])) continue;
    // on n'accepte que des URLs Cloudinary
    if (!preg_match('#^https://res\.cloudinary\.com/#', $p['full'])) continue;
    $entry['photos'][] = [
      'full'  => $p['full'],
      'thumb' => $p['thumb'] ?? $p['full'],
      'note'  => mb_substr(trim((string)($p['note'] ?? '')), 0, 200),
    ];
  }

  if (!$entry['photos']) {
    http_response_code(400);
    exit(json_encode(['ok' => false, 'error' => 'Aucune photo valide reçue.']));
  }

  $all = is_file($STORE) ? (json_decode(@file_get_contents($STORE), true) ?: []) : [];
  array_unshift($all, $entry);

  $tmp  = $STORE . '.tmp';
  $json = json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  if (file_put_contents($tmp, $json, LOCK_EX) === false || !@rename($tmp, $STORE)) {
    @unlink($tmp);
    http_response_code(500);
    exit(json_encode(['ok' => false, 'error' => "Impossible d'enregistrer le dépôt. Vérifiez les droits du dossier (755)."]));
  }

  if ($NOTIFY_EMAIL !== '') {
    $n    = count($entry['photos']);
    $body = "Nouveau dépôt de photos sur le site.\n\n"
          . "De : "        . ($entry['auteur'] ?: 'non précisé') . "\n"
          . "Photos : $n\n"
          . "Message : "   . ($entry['commentaire'] ?: '—') . "\n\n"
          . implode("\n", array_column($entry['photos'], 'full'));
    @mail($NOTIFY_EMAIL, "[B&A] $n photo(s) déposée(s)", $body,
          "Content-Type: text/plain; charset=UTF-8");
  }

  echo json_encode(['ok' => true, 'count' => count($entry['photos'])]);
  exit;
}

/* ═══════════════════════════════════════════════════════════
   2. CONTRÔLE D'ACCÈS
═══════════════════════════════════════════════════════════ */
$isList    = isset($_GET['liste']);
$needed    = $isList ? $ADMIN_CODE : $ACCESS_CODE;
$sessKey   = $isList ? 'depot_admin' : 'depot_ok';
$codeError = '';

if (isset($_POST['deconnexion'])) {
  unset($_SESSION[$sessKey]);
}
if ($needed !== '' && isset($_POST['code'])) {
  if (hash_equals(mb_strtoupper($needed), mb_strtoupper(trim((string)$_POST['code'])))) {
    $_SESSION[$sessKey] = true;
  } else {
    $codeError = 'Ce code ne correspond pas. Réessayez.';
  }
}
$locked = $needed !== '' && empty($_SESSION[$sessKey]);

/* Données pour la vue liste */
$deposits = (!$locked && $isList && is_file($STORE))
  ? (json_decode(@file_get_contents($STORE), true) ?: [])
  : [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="robots" content="noindex,nofollow"/>
<title><?= $isList ? 'Dépôts reçus' : 'Envoyer vos photos' ?> · B&amp;A Construction</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<?php if (!$locked && !$isList): ?>
<script src="https://upload-widget.cloudinary.com/global/all.js"></script>
<?php endif; ?>
<link rel="stylesheet" href="css/depot.css"/>

</head>
<body>

<nav>
  <a class="nav-logo" href="index.php">
    <img src="<?= e($logo) ?>" alt="Logo B&amp;A Construction">
    <span class="nav-brand">B<em>&amp;</em>A Construction</span>
  </a>
  <a class="nav-back" href="index.php">← Le site</a>
</nav>

<?php if ($locked): ?>
<!-- ════════ ÉCRAN DE CODE ════════ -->
<div class="page-header">
  <p class="section-label">Espace privé</p>
  <h1>Accès <em>protégé</em></h1>
</div>
<main>
  <form class="gate" method="post">
    <h2>Votre code</h2>
    <p>Saisissez le code qui vous a été communiqué.</p>
    <input type="text" name="code" autocomplete="off" autocapitalize="characters"
           autofocus aria-label="Code d'accès">
    <button class="btn btn-accent" type="submit">Entrer</button>
    <?php if ($codeError): ?><p class="err"><?= e($codeError) ?></p><?php endif; ?>
  </form>
</main>

<?php elseif ($isList): ?>
<!-- ════════ VUE LISTE (ADMIN) ════════ -->
<div class="page-header">
  <p class="section-label">Administration</p>
  <h1>Photos <em>reçues</em></h1>
  <p><?= count($deposits) ?> dépôt<?= count($deposits) > 1 ? 's' : '' ?> enregistré<?= count($deposits) > 1 ? 's' : '' ?>. Les fichiers sont hébergés sur Cloudinary.</p>
</div>
<main>
  <?php if (!$deposits): ?>
    <div class="empty">Aucun dépôt pour le moment. Partagez le lien <strong>depot.php</strong> et le code d'accès à votre client.</div>
  <?php else: foreach ($deposits as $d): ?>
    <article class="batch">
      <header>
        <p class="when"><?= e(date('d/m/Y · H\hi', strtotime($d['date'] ?? 'now'))) ?> — <?= count($d['photos'] ?? []) ?> photo<?= count($d['photos'] ?? []) > 1 ? 's' : '' ?></p>
        <p class="who"><?= e(($d['auteur'] ?? '') ?: 'Sans nom') ?></p>
      </header>
      <?php if (!empty($d['commentaire'])): ?>
        <p class="msg"><?= e($d['commentaire']) ?></p>
      <?php endif; ?>
      <div class="grid">
        <?php foreach ($d['photos'] ?? [] as $p): ?>
          <figure>
            <a href="<?= e($p['full'] ?? '') ?>" target="_blank" rel="noopener">
              <img src="<?= e($p['thumb'] ?? $p['full'] ?? '') ?>" alt="" loading="lazy">
            </a>
            <figcaption><?= e(($p['note'] ?? '') ?: 'Sans légende') ?></figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    </article>
  <?php endforeach; endif; ?>
  <form method="post" style="margin-top:24px">
    <button class="btn btn-ghost" type="submit" name="deconnexion" value="1">Se déconnecter</button>
  </form>
</main>

<?php else: ?>
<!-- ════════ PAGE DE DÉPÔT ════════ -->
<div class="page-header">
  <p class="section-label">Espace privé</p>
  <h1>Vos photos de <em>chantier</em></h1>
  <p>Envoyez vos photos directement depuis votre téléphone. Nous nous occupons du recadrage, des retouches et de la mise en ligne.</p>
</div>

<main>
  <div id="form-zone">

    <button type="button" class="dropzone" id="pick">
      <span class="lens" aria-hidden="true">
        <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
      </span>
      <strong>Choisir mes photos</strong>
      <span>Depuis la galerie ou l'appareil photo · 30 photos maximum</span>
    </button>

    <div id="tally" class="tally" hidden></div>
    <div id="shots" class="shots"></div>

    <div class="field">
      <label for="auteur">Votre nom</label>
      <input type="text" id="auteur" placeholder="Bruno" autocomplete="name">
    </div>

    <div class="field">
      <label for="commentaire">Un mot sur ces photos (facultatif)</label>
      <textarea id="commentaire" placeholder="Le chantier, la commune, ce que vous aimeriez mettre en avant…"></textarea>
    </div>

    <button class="btn btn-accent btn-full" id="send" disabled>Envoyer mes photos</button>
    <p class="status" id="status" role="status"></p>

    <div class="note">
      Les photos prises au téléphone conviennent parfaitement : inutile de les réduire
      ou de les retoucher avant l'envoi.
    </div>
  </div>

  <div class="done" id="done" hidden>
    <div class="seal" aria-hidden="true">✓</div>
    <h2>C'est bien reçu</h2>
    <p id="done-msg"></p>
    <button class="btn btn-ghost" id="again">Envoyer d'autres photos</button>
  </div>
</main>
<?php endif; ?>

<footer>
  <p>B&amp;A CONSTRUCTION · <?= date('Y') ?></p>
</footer>

<?php if (!$locked && !$isList): ?>
<script>
/* ═══════════════════════════════════════════════════════════
   Dépôt de photos — widget Cloudinary + envoi vers depot.php
═══════════════════════════════════════════════════════════ */
const CLOUD  = <?= json_encode($cloud['cloudName'] ?? '', JSON_UNESCAPED_SLASHES) ?>;
const PRESET = <?= json_encode($cloud['uploadPreset'] ?? '', JSON_UNESCAPED_SLASHES) ?>;
const FOLDER = <?= json_encode($FOLDER, JSON_UNESCAPED_SLASHES) ?>;

const $pick   = document.getElementById('pick');
const $shots  = document.getElementById('shots');
const $tally  = document.getElementById('tally');
const $send   = document.getElementById('send');
const $status = document.getElementById('status');
const $form   = document.getElementById('form-zone');
const $done   = document.getElementById('done');

let photos = [];

/* Transformations Cloudinary (même logique que l'admin) */
function optimize(url, t) {
  return url.replace('/upload/', '/upload/f_auto,q_auto,' + t + '/');
}

function say(msg, kind) {
  $status.textContent = msg || '';
  $status.className = 'status' + (kind ? ' ' + kind : '');
}

function refresh() {
  const n = photos.length;
  $tally.hidden = n === 0;
  $tally.textContent = n + (n > 1 ? ' photos prêtes' : ' photo prête');
  $send.disabled = n === 0;

  $shots.innerHTML = '';
  photos.forEach((p, i) => {
    const row = document.createElement('div');
    row.className = 'shot';

    const img = document.createElement('img');
    img.src = p.thumb; img.alt = ''; img.loading = 'lazy';

    const fields = document.createElement('div');
    fields.className = 'fields';

    const input = document.createElement('input');
    input.type = 'text';
    input.placeholder = 'Ce que c\'est (facultatif)';
    input.value = p.note || '';
    input.setAttribute('aria-label', 'Légende de la photo ' + (i + 1));
    input.addEventListener('input', e => { p.note = e.target.value; });

    const del = document.createElement('button');
    del.type = 'button'; del.className = 'drop'; del.textContent = 'Retirer';
    del.addEventListener('click', () => { photos.splice(i, 1); refresh(); });

    fields.append(input, del);
    row.append(img, fields);
    $shots.appendChild(row);
  });
}

/* ── Widget Cloudinary ── */
let widget = null;
function openWidget() {
  if (!CLOUD || !PRESET) {
    say('La configuration des photos est incomplète. Prévenez votre webmaster.', 'err');
    return;
  }
  if (typeof cloudinary === 'undefined') {
    say('Le module d\'envoi n\'a pas pu se charger. Vérifiez votre connexion.', 'err');
    return;
  }
  if (!widget) {
    widget = cloudinary.createUploadWidget({
      cloudName: CLOUD,
      uploadPreset: PRESET,
      folder: FOLDER,
      tags: ['depot-client'],
      multiple: true,
      maxFiles: 30,
      maxFileSize: 25000000,
      sources: ['local', 'camera'],
      clientAllowedFormats: ['png', 'jpg', 'jpeg', 'webp', 'heic', 'heif'],
      language: 'fr',
      text: { fr: { menu: { files: 'Mes photos', camera: 'Appareil photo' } } },
      styles: { palette: {
        window: '#3d2b1a', sourceBg: '#f5f0e8', windowBorder: '#c4944a',
        tabIcon: '#c4944a', inactiveTabIcon: '#7a5c3e', menuIcons: '#c4944a',
        link: '#c4944a', action: '#c4944a', inProgress: '#c4944a',
        complete: '#3f7d4f', error: '#9c4a3c',
        textDark: '#2a1f14', textLight: '#f5f0e8'
      } }
    }, (err, info) => {
      if (err) { say("L'envoi d'une photo a échoué. Réessayez.", 'err'); return; }
      if (!info) return;
      if (info.event === 'success') {
        const url = info.info.secure_url;
        photos.push({
          full:  optimize(url, 'w_2000,c_limit'),
          thumb: optimize(url, 'w_400,h_320,c_fill'),
          note:  ''
        });
        say('');
        refresh();
      }
      if (info.event === 'queues-end') widget.close();
    });
  }
  widget.open();
}
$pick.addEventListener('click', openWidget);

/* ── Envoi ── */
$send.addEventListener('click', async () => {
  if (!photos.length) return;
  $send.disabled = true;
  say('Envoi en cours…');
  try {
    const res = await fetch('depot.php?envoi=1', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        auteur: document.getElementById('auteur').value,
        commentaire: document.getElementById('commentaire').value,
        photos: photos
      })
    });
    const out = await res.json();
    if (!res.ok || !out.ok) throw new Error(out.error || 'Erreur ' + res.status);

    document.getElementById('done-msg').textContent =
      out.count + (out.count > 1 ? ' photos nous sont bien parvenues.' : ' photo nous est bien parvenue.')
      + ' Nous revenons vers vous rapidement.';
    $form.hidden = true;
    $done.hidden = false;
    window.scrollTo({ top: 0, behavior: 'smooth' });
  } catch (e) {
    say(e.message, 'err');
    $send.disabled = false;
  }
});

/* ── Nouveau dépôt ── */
document.getElementById('again').addEventListener('click', () => {
  photos = [];
  document.getElementById('commentaire').value = '';
  refresh();
  say('');
  $done.hidden = true;
  $form.hidden = false;
  $send.disabled = true;
});

/* ── Garde-fou : quitter avec des photos non envoyées ── */
window.addEventListener('beforeunload', e => {
  if (photos.length && $form.hidden === false) { e.preventDefault(); e.returnValue = ''; }
});
</script>
<?php endif; ?>
</body>
</html>
