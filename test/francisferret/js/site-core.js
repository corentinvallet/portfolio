/* Helpers partagés par les pages publiques (index + galerie) */
(function () {
    const CFG = window.SITE_CONFIG || {};

    // *texte* -> <em>texte</em>  (échappe le reste du HTML)
    window.fmtEm = function (str) {
        if (str == null) return "";
        const esc = String(str)
            .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
        return esc.replace(/\*([^*]+)\*/g, "<em>$1</em>");
    };

    // Injecte les paramètres d'optimisation Cloudinary (format auto, qualité auto, largeur)
    // dans une URL Cloudinary /upload/. Renvoie l'URL telle quelle si ce n'est pas Cloudinary.
    window.cldUrl = function (url, width) {
        if (!url || typeof url !== "string") return url;
        if (url.indexOf("res.cloudinary.com") === -1) return url;
        const marker = "/upload/";
        const idx = url.indexOf(marker);
        if (idx === -1) return url;
        const params = "f_auto,q_auto" + (width ? ",w_" + width : "");
        return url.slice(0, idx + marker.length) + params + "/" + url.slice(idx + marker.length);
    };

    // Démarre le téléchargement de l'image hero dès que possible, avant que render() ne l'affiche.
    function preloadHeroImage(data) {
        try {
            const url = window.cldUrl((data.images && data.images.hero) || "", 1600);
            if (!url) return;
            const link = document.createElement("link");
            link.rel = "preload";
            link.as = "image";
            link.href = url;
            document.head.appendChild(link);
        } catch (_) {}
    }

    // Charge le contenu : contentUrl (Cloudinary ou local). Renvoie null si échec.
    window.loadContent = async function () {
        try {
            const url = (CFG.contentUrl || "./content.json") + "?t=" + Date.now();
            const res = await fetch(url, { cache: "no-store" });
            if (!res.ok) throw new Error("HTTP " + res.status);
            const data = await res.json();
            preloadHeroImage(data);
            return data;
        } catch (e) {
            console.warn("content.json introuvable, on tente le fichier local.", e);
            try {
                const res = await fetch("./content.json?t=" + Date.now(), { cache: "no-store" });
                if (res.ok) {
                    const data = await res.json();
                    preloadHeroImage(data);
                    return data;
                }
            } catch (_) {}
            return null;
        }
    };
})();