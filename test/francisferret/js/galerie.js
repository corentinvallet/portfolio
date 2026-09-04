const $ = (id) => document.getElementById(id);
let PHOTOS = [], CAT_LABELS = {}, activeFilter = "tous", items = [];

function render(c) {
    document.title = "Galerie — " + c.brand.name + ", Sculpteur sur bois";
    $("navLogo").textContent = c.brand.name;
    $("galLabel").textContent = c.galerie.heroLabel || c.galerie.label;
    $("galTitle").innerHTML = fmtEm(c.galerie.heroTitle || c.galerie.title);
    $("galSub").textContent = c.galerie.heroSub || "";
    $("footerLogo").textContent = c.footer.logo;
    $("footerSub").textContent = c.footer.sub;
    $("footerCopy").textContent = c.footer.copy;

    PHOTOS = c.galerie.photos || [];
    CAT_LABELS = {};
    (c.galerie.categories || []).forEach(cat => CAT_LABELS[cat.key] = cat.label);

    // Filtres
    const fw = $("filtersWrap");
    fw.innerHTML = `<button class="filter-btn active" data-filter="tous"><span>Tous</span></button>` +
        (c.galerie.categories||[]).map(cat =>
            `<button class="filter-btn" data-filter="${cat.key}"><span>${cat.label.replace(/</g,"&lt;")}</span></button>`).join("");

    // Masonry
    const masonry = $("masonry");
    masonry.innerHTML = ""; items = [];
    PHOTOS.forEach((photo, i) => {
        const item = document.createElement("div");
        item.className = "masonry-item";
        item.dataset.cat = photo.cat;
        item.style.animationDelay = `${i * 0.06}s`;
        const im = document.createElement("img");
        im.src = cldUrl(photo.url, 500); im.alt = photo.alt || ""; im.loading = "lazy";
        const overlay = document.createElement("div");
        overlay.className = "item-overlay";
        overlay.innerHTML = `<span class="item-cat">${(CAT_LABELS[photo.cat]||photo.cat||"").replace(/</g,"&lt;")}</span>`;
        item.appendChild(im); item.appendChild(overlay);
        item.addEventListener("click", () => openLightbox(i));
        masonry.appendChild(item); items.push(item);
    });

    document.querySelectorAll(".filter-btn").forEach(btn =>
        btn.addEventListener("click", () => applyFilter(btn.dataset.filter)));
    applyFilter("tous");
    initNav();
}

function applyFilter(filter) {
    activeFilter = filter; let visible = 0;
    items.forEach((item) => {
        const match = filter === "tous" || item.dataset.cat === filter;
        item.classList.toggle("hidden", !match);
        if (match) visible++;
    });
    $("visibleCount").textContent = visible;
    $("noResults").style.display = visible === 0 ? "block" : "none";
    document.querySelectorAll(".filter-btn").forEach(b => b.classList.toggle("active", b.dataset.filter === filter));
}

// Lightbox
let lbIdx = 0;
function getVisibleIndices(){ return PHOTOS.map((_,i)=>i).filter(i => activeFilter==="tous" || PHOTOS[i].cat===activeFilter); }
function openLightbox(photoIdx){ const v=getVisibleIndices(); const pos=v.indexOf(photoIdx); if(pos===-1)return; lbIdx=pos; updateLightbox(v); $("lightbox").classList.add("open"); document.body.style.overflow="hidden"; }
function updateLightbox(v){ const p=PHOTOS[v[lbIdx]]; $("lbImg").src=cldUrl(p.url, 1600); $("lbImg").alt=p.alt||""; $("lbCat").textContent=CAT_LABELS[p.cat]||p.cat||""; $("lbCounter").textContent=`${lbIdx+1} / ${v.length}`; }
function closeLightbox(){ $("lightbox").classList.remove("open"); document.body.style.overflow=""; }

function initNav() {
    $("lbClose").addEventListener("click", closeLightbox);
    $("lightbox").addEventListener("click", e => { if (e.target===$("lightbox")) closeLightbox(); });
    $("lbPrev").addEventListener("click", e => { e.stopPropagation(); const v=getVisibleIndices(); lbIdx=(lbIdx-1+v.length)%v.length; updateLightbox(v); });
    $("lbNext").addEventListener("click", e => { e.stopPropagation(); const v=getVisibleIndices(); lbIdx=(lbIdx+1)%v.length; updateLightbox(v); });
    document.addEventListener("keydown", e => {
        if(!$("lightbox").classList.contains("open")) return;
        if(e.key==="Escape") closeLightbox();
        if(e.key==="ArrowLeft") $("lbPrev").click();
        if(e.key==="ArrowRight") $("lbNext").click();
    });
    const nav = $("nav");
    window.addEventListener("scroll", () => nav.classList.toggle("scrolled", window.scrollY > 50));
    $("burger").addEventListener("click", () => $("navLinks").classList.toggle("open"));
}

(async () => {
    const c = await loadContent();
    if (c) render(c);
    else $("masonry").innerHTML = '<p style="padding:2rem">Impossible de charger le contenu.</p>';
})();