/* Helpers partagés par la page publique et l'admin */
(function () {
    const CFG = window.SITE_CONFIG || {};

    // *texte* -> <em>texte</em>  (échappe le reste du HTML)
    window.fmtEm = function (str) {
        if (str == null) return "";
        const esc = String(str)
            .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
        return esc.replace(/\*([^*]+)\*/g, "<em>$1</em>");
    };

    // Charge le contenu (content.json). Renvoie null si échec.
    window.loadContent = async function () {
        try {
            const url = (CFG.contentUrl || "./content.json") + "?t=" + Date.now();
            const res = await fetch(url, { cache: "no-store" });
            if (!res.ok) throw new Error("HTTP " + res.status);
            return await res.json();
        } catch (e) {
            console.warn("content.json introuvable.", e);
            return null;
        }
    };
})();
