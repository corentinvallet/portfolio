/* =====================================================================
   CONFIGURATION DU SITE — L'Abri des Libellules
   Un seul fichier à modifier pour brancher Cloudinary et l'admin.
   ===================================================================== */
window.SITE_CONFIG = {
    /* --- Cloudinary (upload de photos depuis l'admin) --- */
    // Nom de votre "cloud" (Dashboard Cloudinary, en haut à gauche)
    cloudName: "de5u1njxn",

    // Nom d'un "Upload preset" en mode UNSIGNED (Settings ▸ Upload ▸ Add upload preset)
    // C'est ce qui permet d'envoyer des photos depuis le navigateur sans clé secrète.
    uploadPreset: "libellules",

    // Dossier Cloudinary où ranger les photos (optionnel)
    folder: "abri-des-libellules",

    /* --- Contenu du site (textes + galerie + tarif + mot de passe) --- */
    // Où le site public lit son contenu.
    //  • Mode manuel : "./content.json"  (vous remplacez ce fichier après chaque export)
    //  • Mode auto   : laissez "./content.json" et activez save.php ci-dessous
    contentUrl: "./content.json",

    // (Optionnel) URL du script qui enregistre content.json sur le serveur.
    // Laissez vide pour le mode manuel (téléchargement du fichier).
    //  ex: "save.php"  (Hostinger / hébergement PHP)
    signEndpoint: "save.php",

    // (Optionnel) Jeton secret envoyé au script (doit valoir $ADMIN_TOKEN dans save.php)
    saveToken: "CHANGEZ-MOI-abri-libellules-2026",
};
