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

    // Charge le contenu : contentUrl (Cloudinary ou local). Renvoie null si échec.
    window.loadContent = async function () {
        try {
            const url = (CFG.contentUrl || "./content.json") + "?t=" + Date.now();
            const res = await fetch(url, { cache: "no-store" });
            if (!res.ok) throw new Error("HTTP " + res.status);
            return await res.json();
        } catch (e) {
            console.warn("content.json introuvable, on tente le fichier local.", e);
            try {
                const res = await fetch("./content.json?t=" + Date.now(), { cache: "no-store" });
                if (res.ok) return await res.json();
            } catch (_) {}
            return null;
        }
    };
})();
