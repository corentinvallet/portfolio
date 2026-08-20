/* ═══════════════════════════════════════════════════════════
   Dépôt de photos — widget Cloudinary + envoi vers depot.php
═══════════════════════════════════════════════════════════ */
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