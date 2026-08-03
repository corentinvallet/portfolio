# corentinvallet.fr — passage de Firebase à un serveur PHP

Même principe que le site Francis Ferret : tout le contenu vit dans **un seul fichier `content.json`**.
Les pages publiques le lisent ; l'admin le réécrit via **`save.php`**. Plus aucune dépendance Firebase.

## Fichiers à mettre en ligne (dans `public_html`)

| Fichier | Rôle |
|---|---|
| `index.html` | Page publique. Lit `./content.json` au chargement (+ cache local pour un affichage instantané). |
| `content.json` | Source unique de tout le contenu texte. |
| `save.php` | Reçoit le contenu de l'admin et réécrit `content.json` (protégé par un jeton). |
| `admin/index.html` | Panneau d'administration. Publie en ligne via `save.php`. |

## La seule chose à régler : le jeton (en 2 endroits identiques)

1. Dans **`save.php`** → `$ADMIN_TOKEN = '...'`
2. Dans **`admin/index.html`** → `const SAVE_TOKEN = '...'`

Mettez la **même valeur** des deux côtés (un mot de passe libre, par ex. `mon-Jeton-2026!`).

## Accès / sécurité

- Connexion à l'admin : identifiant `cva`, mot de passe `cva` (inchangé). Modifiable dans `admin/index.html` (`doLogin`).
- Le jeton dans `admin/index.html` est visible côté navigateur (comme dans le modèle Francis Ferret).
  Pour une vraie protection, **protégez aussi le dossier `/admin/` par mot de passe** dans hPanel Hostinger
  (« Protéger des répertoires par mot de passe »).

## Vérification après mise en ligne

1. Ouvrez `votre-site.com/admin/`, modifiez un texte, cliquez **Enregistrer** → toast « ✓ Publié en ligne ».
2. Rechargez `votre-site.com` → la modification doit apparaître.
3. En cas d'erreur d'écriture : vérifiez les droits de `content.json` (644/664) et du dossier (755).

> Note : le gestionnaire de photos de l'admin enregistre les images en base64 dans `content.json`
> (comportement identique à l'ancienne version Firestore). Pour de meilleures performances,
> on pourra plus tard basculer ces images sur Cloudinary, comme sur le site Francis Ferret.
