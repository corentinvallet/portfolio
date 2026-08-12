/* =====================================================================
   CONFIGURATION DU SITE — Francis Ferret
   Un seul fichier à modifier pour brancher Cloudinary et l'admin.
   ===================================================================== */
window.SITE_CONFIG = {
    /* --- Cloudinary --- */
    // Nom de votre "cloud" (Dashboard Cloudinary, en haut à gauche)
    cloudName: "de5u1njxn",

    // Nom d'un "Upload preset" en mode UNSIGNED (Settings ▸ Upload ▸ Add upload preset)
    // C'est ce qui permet d'envoyer des photos depuis le navigateur sans clé secrète.
    uploadPreset: "francis-ferret",

    // Dossier Cloudinary où ranger les photos (optionnel)
    folder: "francis-ferret",

    /* --- Contenu du site (textes + structure de la galerie) --- */
    // Où le site public lit son contenu.
    //  • Mode manuel  : "./content.json"  (vous remplacez ce fichier après chaque export)
    //  • Mode auto    : l'URL "raw" Cloudinary du content.json
    //                   ex: https://res.cloudinary.com/VOTRE_CLOUD_NAME/raw/upload/francis-ferret/content.json
    contentUrl: "./content.json",

    // (Optionnel) URL d'une fonction serverless qui SIGNE l'enregistrement du
    // content.json sur Cloudinary. Laissez vide pour le mode manuel (téléchargement).
    // ex: "/.netlify/functions/cloudinary-save"  (Netlify)
    //  ou  "save.php"                             (Hostinger / hébergement PHP)
    signEndpoint: "save.php",

    // (Optionnel) Jeton secret envoyé à la fonction (doit valoir ADMIN_TOKEN côté serveur)
    saveToken: "geouubjq58452!:IG",

};
