# Site L'Abri des Libellules — Admin & contenu dynamique

Le site est devenu **pilotable depuis un panneau d'administration** (`admin/index.html`).
Tous les textes, le tarif, la galerie et le mot de passe d'accès au site sont stockés dans
un seul fichier : **`content.json`**. La page publique (`index.html`) lit ce fichier au chargement.

## Fichiers à mettre en ligne

À déposer dans le dossier `public_html` de Hostinger (Gestionnaire de fichiers ou FTP), en conservant la structure de dossiers :

```
public_html/
├── index.html          ← page publique
├── content.json         ← source unique : tous les textes + le tarif + la galerie
├── config.js             ← LE seul fichier à éditer à la main (une fois) : Cloudinary, etc.
├── site-core.js
├── images/               ← photos actuelles (peuvent rester telles quelles)
│   └── ...
└── admin/
    ├── index.html         ← panneau d'administration (mobile-first)
    └── save.php           ← optionnel : enregistrement automatique de content.json
```

## 1. Configurer Cloudinary (pour ajouter des photos depuis le téléphone)

Ce n'est utile que si vous voulez pouvoir **ajouter de nouvelles photos** directement
depuis l'admin (sans passer par le Gestionnaire de fichiers Hostinger). Vos photos
actuelles dans `images/` continuent de fonctionner sans rien configurer.

1. Créez un compte gratuit sur cloudinary.com.
2. Dans **Settings → Upload → Upload presets**, créez un preset **Unsigned** (Signing Mode : *Unsigned*). Notez son nom.
3. Ouvrez `config.js` et renseignez :
   - `cloudName` : votre Cloud name (visible dans le dashboard).
   - `uploadPreset` : le nom du preset unsigned créé ci-dessus.
   - `folder` : laissez `"abri-des-libellules"` (ou changez).

Tant que Cloudinary n'est pas configuré, vous pouvez toujours **coller une URL ou un
chemin d'image** (ex: `images/nouvelle-photo.jpg`) directement dans les champs de
l'admin — il suffit d'avoir déposé la photo dans le dossier `images/` au préalable.

## 2. Le mot de passe du site (écran d'accueil visiteurs)

Le mot de passe demandé aux visiteurs à l'arrivée sur le site se modifie directement
depuis l'admin : onglet **Réglages → Protection du site**. Vous pouvez aussi désactiver
complètement cette protection depuis le même écran.

> Note : c'est une protection « de surface » côté navigateur (comme un mot de passe de
> chantier), pas un vrai contrôle d'accès serveur.

## 3. Enregistrer les modifications — deux modes

### Mode manuel (par défaut, zéro installation)
Quand vous cliquez **Enregistrer**, l'admin télécharge un nouveau `content.json`.
Il suffit de **remplacer l'ancien `content.json`** dans `public_html` (Gestionnaire de fichiers) par celui téléchargé. La page publique affiche aussitôt les nouveautés.

### Mode automatique (PHP) — recommandé sur Hostinger
Hostinger gère **PHP** : le script `admin/save.php` réécrit `content.json` directement sur le serveur, sans téléchargement.
1. Déposez `admin/save.php` dans le dossier `admin/` (à côté de `admin/index.html`).
2. Ouvrez `admin/save.php` et changez `$ADMIN_TOKEN` (un mot de passe libre).
3. Dans `config.js` :
   - `signEndpoint` : `"save.php"`
   - `saveToken` : la même valeur que `$ADMIN_TOKEN`
4. Vérifiez que `content.json` est inscriptible (droits 644/664 sur le fichier, 755 sur le dossier — en général déjà le cas).

Désormais, le bouton **Enregistrer** publie en ligne instantanément (c'est déjà activé par défaut dans le `config.js` fourni — pensez juste à changer le token).

## 4. Mise en ligne

Déposez dans `public_html` : `index.html`, `config.js`, `content.json`, `site-core.js`, le dossier `images/`, et le dossier `admin/` (avec `index.html` et `save.php`).

Accédez à l'admin via `votre-site.com/admin/index.html`.

> ⚠️ Pensez à changer le token dans `config.js` **et** dans `admin/save.php` avant la mise
> en ligne définitive — la valeur fournie par défaut n'est qu'un exemple.
