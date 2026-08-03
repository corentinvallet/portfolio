# Site Francis Ferret — Admin & contenu dynamique

Le site est devenu **pilotable depuis un panneau d'administration** (`admin.html`).
Tous les textes et toutes les photos sont stockés dans un seul fichier : **`content.json`**.
Les pages publiques (`index.html`, `galerie.html`) lisent ce fichier au chargement.

## Fichiers à mettre en ligne

À déposer dans le dossier `public_html` de Hostinger (Gestionnaire de fichiers ou FTP) :

| Fichier | Rôle |
|---|---|
| `admin.html` | Panneau d'administration (mobile-first). C'est ici qu'on modifie tout. |
| `content.json` | Source unique : tous les textes + la galerie. |
| `config.js` | **Le seul fichier à éditer à la main** une fois (clés Cloudinary, etc.). |
| `index.html` / `galerie.html` | Pages publiques, alimentées par `content.json`. |
| `theme.css` | Palette de couleurs commune à tout le site (à modifier pour changer les couleurs). |
| `index.css` / `galerie.css` / `admin.css` | Styles propres à chaque page. |
| `site-core.js` | Code partagé par les pages publiques. |
| `save.php` | Optionnel : enregistrement automatique de `content.json` (voir §3). |

> Le dossier `netlify/` fourni dans l'archive **ne sert pas** sur Hostinger : vous pouvez l'ignorer/supprimer.

## 1. Configurer Cloudinary (pour les photos)

1. Créez un compte gratuit sur cloudinary.com.
2. Dans **Settings → Upload → Upload presets**, créez un preset **Unsigned** (Signing Mode : *Unsigned*). Notez son nom.
3. Ouvrez `config.js` et renseignez :
   - `cloudName` : votre Cloud name (visible dans le dashboard).
   - `uploadPreset` : le nom du preset unsigned créé ci-dessus.
   - `folder` : laissez `"francis-ferret"` (ou changez).

C'est tout pour les photos : l'admin les envoie directement sur Cloudinary depuis le navigateur, sans clé secrète exposée.

## 2. Protéger l'admin (mot de passe)

Le mot de passe par défaut est `admin`. Pour le changer :
1. Ouvrez `admin.html`, onglet **Réglages → Générer l'empreinte**.
2. Tapez le nouveau mot de passe, copiez l'empreinte affichée.
3. Collez-la dans `config.js` → `adminPasswordSha256`.

> Note : c'est une protection « de surface » côté navigateur, suffisante pour empêcher un accès accidentel. Pour une sécurité forte, protégez aussi `admin.html` côté serveur (dossier protégé par mot de passe dans hPanel).

## 3. Enregistrer les modifications — deux modes

### Mode manuel (par défaut, zéro installation)
Quand vous cliquez **Enregistrer**, l'admin télécharge un nouveau `content.json`.
Il suffit de **remplacer l'ancien `content.json`** dans `public_html` (Gestionnaire de fichiers) par celui téléchargé. Les pages publiques affichent aussitôt les nouveautés.

### Mode automatique (PHP) — recommandé sur Hostinger
Hostinger gère **PHP** : le script `save.php` réécrit `content.json` directement sur le serveur, sans téléchargement et sans clé Cloudinary.
1. Déposez `save.php` à la racine du site (`public_html`, à côté de `content.json`).
2. Ouvrez `save.php` et changez `$ADMIN_TOKEN` (un mot de passe libre).
3. Dans `config.js` :
   - `signEndpoint` : `"save.php"`
   - `saveToken` : la même valeur que `$ADMIN_TOKEN`
   - `contentUrl` : `"./content.json"`
4. Vérifiez que `content.json` est inscriptible (droits 644/664 sur le fichier, 755 sur le dossier — en général déjà le cas).

Désormais, le bouton **Enregistrer** publie en ligne instantanément.

> Pour les photos, Cloudinary reste nécessaire dans les deux modes (étape 1) : chaque photo y est envoyée depuis le navigateur.

## 4. Mise en ligne

Déposez dans `public_html` : `index.html`, `galerie.html`, `admin.html`, `theme.css`, `index.css`, `galerie.css`, `admin.css`, `config.js`, `content.json`, `site-core.js` (+ `save.php` si mode automatique).
Les liens internes pointent vers `index.html` et `galerie.html` (renommez vos anciens fichiers `indexFf.html` / `galerieff.html` en conséquence, ou adaptez les liens).

Accédez à l'admin via `votre-site.com/admin.html`.
