const SHIELD = '<svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>';
        const ROW_ICONS = [
            '<svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
            '<svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>',
            '<svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>'
        ];
const $ = (id) => document.getElementById(id);
let previewKeys = [];

function img(c, key) { return (c.images && c.images[key]) || ""; }

function render(c) {
    document.title = c.brand.name + " — Sculpteur sur bois";
    $("navLogo").textContent = c.brand.name;

    // HERO
    $("heroBg").style.backgroundImage = `url("${cldUrl(img(c,"hero"), 1600)}")`;
    $("heroTitle1").textContent = c.hero.title1;
    $("heroTitle2").textContent = c.hero.title2;
    $("heroSub").textContent = c.hero.sub;
    $("heroCta").textContent = c.hero.cta;
    $("heroBadges").innerHTML = (c.hero.badges||[]).map(b =>
        `<span class="badge">${SHIELD}${b.replace(/</g,"&lt;")}</span>`).join("");

    // ABOUT
    $("aboutImg").src = cldUrl(img(c,"portrait"), 800);
    $("aboutLabel").textContent = c.about.label;
    $("aboutTitle").innerHTML = fmtEm(c.about.title);
    $("aboutText").innerHTML = [c.about.p1, c.about.p2].filter(Boolean)
        .map((p,i)=>`<p class="section-text"${i?' style="margin-top:1rem"':''}>${p.replace(/</g,"&lt;")}</p>`).join("");
    $("aboutStats").innerHTML = renderStats(c.about.stats);

    // SAVOIR
    $("savoirLabel").textContent = c.savoir.label;
    $("savoirTitle").innerHTML = fmtEm(c.savoir.title);
    $("savoirGrid").innerHTML = (c.savoir.cards||[]).map(card => `
        <div class="savoir-card reveal">
            <div class="savoir-name">${(card.name||"").replace(/</g,"&lt;")}</div>
            <p class="savoir-desc">${(card.desc||"").replace(/</g,"&lt;")}</p>
        </div>`).join("");

    // GALERIE preview
    $("galLabel").textContent = c.galerie.label;
    $("galTitle").innerHTML = fmtEm(c.galerie.title);
    $("galCtaText").textContent = c.galerie.ctaPreview || "Voir toutes les œuvres";
    const photos = (c.galerie.photos||[]).slice(0,3);
    previewKeys = photos.map(p => p.url);
    $("previewGrid").innerHTML = "";
    photos.forEach((p,i) => {
        const item = document.createElement("div");
        item.className = "preview-item";
        const im = document.createElement("img");
        im.src = cldUrl(p.url, 500); im.alt = p.alt || ""; im.loading = "lazy";
        item.appendChild(im);
        item.addEventListener("click", () => openLightbox(i));
        $("previewGrid").appendChild(item);
    });

    // ÉVÉNEMENTS
    $("evtLabel").textContent = c.evenements.label;
    $("evtTitle").innerHTML = fmtEm(c.evenements.title);
    $("evtList").innerHTML = (c.evenements.items||[]).map(it => `
        <div class="evt-item reveal"><div class="evt-dot"></div><div>
            <div class="evt-name">${(it.name||"").replace(/</g,"&lt;")}</div>
            <p class="evt-detail">${(it.detail||"").replace(/</g,"&lt;")}</p>
            ${it.tag?`<span class="evt-tag">${it.tag.replace(/</g,"&lt;")}</span>`:""}
        </div></div>`).join("");

    // PARCOURS
    $("parLabel").textContent = c.parcours.label;
    $("parTitle").innerHTML = fmtEm(c.parcours.title);
    $("parText").innerHTML = [c.parcours.p1, c.parcours.p2].filter(Boolean)
        .map((p,i)=>`<p class="section-text"${i?' style="margin-top:1rem"':''}>${p.replace(/</g,"&lt;")}</p>`).join("");
    $("parStats").innerHTML = renderStats(c.parcours.stats);

    // CONTACT
    $("contactLabel").textContent = c.contact.label;
    $("contactTitle").innerHTML = fmtEm(c.contact.title);
    $("contactText").textContent = c.contact.text;
    $("contactRows").innerHTML = (c.contact.rows||[]).map((r,i)=>
        `<div class="contact-row">${ROW_ICONS[i]||ROW_ICONS[0]}${r.replace(/</g,"&lt;")}</div>`).join("");
    const sel = $("sujet");
    (c.contact.subjects||[]).forEach(s => { const o=document.createElement("option"); o.textContent=s; sel.appendChild(o); });
    $("formSuccess").textContent = c.contact.successMessage || "Merci pour votre message !";
    window.__formspree = c.contact.formspreeEndpoint || "";

    // FOOTER
    $("footerLogo").textContent = c.footer.logo;
    $("footerSub").textContent = c.footer.sub;
    $("footerCopy").textContent = c.footer.copy;

    initInteractions();
}

function renderStats(stats) {
    return (stats||[]).map(s =>
        `<div class="champ-item"><div class="champ-num">${(s.num||"").replace(/</g,"&lt;")}</div>
            <div class="champ-label">${(s.label||"").replace(/</g,"&lt;")}</div></div>`).join("");
}

// ---- Lightbox ----
let lbIdx = 0;
function openLightbox(i){ lbIdx=i; $("lbImg").src=cldUrl(previewKeys[i], 1600); $("lbCounter").textContent=`${i+1} / ${previewKeys.length}`; $("lightbox").classList.add("open"); document.body.style.overflow="hidden"; }
function closeLightbox(){ $("lightbox").classList.remove("open"); document.body.style.overflow=""; }

function initInteractions() {
    $("lbClose").addEventListener("click", closeLightbox);
    $("lightbox").addEventListener("click", e => { if (e.target === $("lightbox")) closeLightbox(); });
    $("lbPrev").addEventListener("click", e => { e.stopPropagation(); lbIdx=(lbIdx-1+previewKeys.length)%previewKeys.length; $("lbImg").src=cldUrl(previewKeys[lbIdx], 1600); $("lbCounter").textContent=`${lbIdx+1} / ${previewKeys.length}`; });
    $("lbNext").addEventListener("click", e => { e.stopPropagation(); lbIdx=(lbIdx+1)%previewKeys.length; $("lbImg").src=cldUrl(previewKeys[lbIdx], 1600); $("lbCounter").textContent=`${lbIdx+1} / ${previewKeys.length}`; });
    document.addEventListener("keydown", e => {
        if (!$("lightbox").classList.contains("open")) return;
        if (e.key==="Escape") closeLightbox();
        if (e.key==="ArrowLeft") $("lbPrev").click();
        if (e.key==="ArrowRight") $("lbNext").click();
    });

    const nav = $("nav");
    window.addEventListener("scroll", () => nav.classList.toggle("scrolled", window.scrollY > 50));
    $("burger").addEventListener("click", () => $("navLinks").classList.toggle("open"));

    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting){ e.target.classList.add("visible"); observer.unobserve(e.target);} });
    }, { threshold: 0.12 });
    document.querySelectorAll(".reveal").forEach(r => observer.observe(r));

    $("formSubmit").addEventListener("click", async () => {
        const fname=$("fname").value.trim(), email=$("email").value.trim(), message=$("message").value.trim();
        if(!fname||!email||!message){ alert("Merci de remplir au minimum votre prénom, votre e-mail et votre message."); return; }
        const btn=$("formSubmit"); btn.textContent="Envoi en cours…"; btn.disabled=true;
        try {
            const res = await fetch(window.__formspree, { method:"POST", headers:{"Content-Type":"application/json"},
                body: JSON.stringify({ fname, lname:$("lname").value.trim(), email, sujet:$("sujet").value, message }) });
            if(res.ok){ btn.style.display="none"; $("formSuccess").style.display="block"; }
            else throw new Error("Erreur serveur");
        } catch(err){ btn.textContent="Envoyer le message"; btn.disabled=false; alert("Une erreur s'est produite. Merci de réessayer."); }
    });
}

(async () => {
    const c = await loadContent();
    if (c) render(c);
    else document.body.innerHTML = '<p style="padding:4rem;text-align:center;font-family:sans-serif">Impossible de charger le contenu (content.json).</p>';
})();