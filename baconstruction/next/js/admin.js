/* ═══════════════════════════════════════════════════════════
   ÉTAT
═══════════════════════════════════════════════════════════ */
let state = null;
let dirty = false;
const DEFAULT_CATS = [
  ['cave-a-vin','Caves à vins'],
  ['beton-cire','Béton ciré'],
  ['beton-desactive','Béton désactivé'],
  ['piscine','Piscine'],
  ['beton-imprime','Béton imprimé'],
  ['escalier-beton','Escalier béton']
];
let CATS = DEFAULT_CATS;

const $app    = document.getElementById('app');
const $status = document.getElementById('status');
const $save   = document.getElementById('saveBtn');
const $warn   = document.getElementById('cloud-warn');
const $tabs   = document.getElementById('tabs');

/* ── Onglets PC ── */
const mqDesktop = window.matchMedia('(min-width:920px)');
let activeTab = 0;

/* ── Helpers DOM ── */
function el(tag, attrs={}, ...kids){
  const n = document.createElement(tag);
  for(const k in attrs){
    if(k==='class') n.className = attrs[k];
    else if(k==='html') n.innerHTML = attrs[k];
    else if(k.startsWith('on')) n.addEventListener(k.slice(2), attrs[k]);
    else if(attrs[k]!=null) n.setAttribute(k, attrs[k]);
  }
  kids.flat().forEach(c=>n.appendChild(typeof c==='string'?document.createTextNode(c):c));
  return n;
}
function markDirty(){
  dirty = true;
  $save.disabled = false;
  $status.className = 'status dirty';
  $status.textContent = 'Modifications non enregistrées';
}

/* ── Champ texte lié à une valeur ── */
function textField(labelTxt, value, onChange, {multiline=false, hint='', placeholder=''}={}){
  const input = multiline
    ? el('textarea',{placeholder})
    : el('input',{type:'text',placeholder});
  input.value = value ?? '';
  input.addEventListener('input', ()=>{ onChange(input.value); markDirty(); });
  const f = el('div',{class:'field'}, el('label',{class:'lbl'},labelTxt), input);
  if(hint) f.appendChild(el('div',{class:'hint'},hint));
  return f;
}

/* ── Sélecteur de catégorie ── */
/* ── Sélecteur de catégories (plusieurs choix possibles) ── */
function catField(values, onChange){
  values = Array.isArray(values) ? values : (values ? [values] : []);
  const box = el('div',{class:'catcheck'});
  CATS.forEach(([v,lab])=>{
    const cb = el('input',{type:'checkbox',value:v});
    cb.checked = values.includes(v);
    cb.addEventListener('change', ()=>{
      if(cb.checked){ if(!values.includes(v)) values.push(v); }
      else { const idx=values.indexOf(v); if(idx>-1) values.splice(idx,1); }
      onChange(values);
      markDirty();
    });
    box.appendChild(el('label',{class:'catcheck-item'}, cb, ' '+lab));
  });
  return el('div',{class:'field'}, el('label',{class:'lbl'},'Catégories'), box);
}
/* ── Sélecteur de catégorie avec option "aucun lien" (cartes Services) ── */
function catFieldOptional(labelTxt, value, onChange, hint){
  const sel = el('select');
  const none = el('option',{value:''}, 'Aucun (carte non cliquable)');
  if(!value) none.selected = true;
  sel.appendChild(none);
  CATS.forEach(([v,lab])=>{
    const o = el('option',{value:v}, lab);
    if(v===value) o.selected = true;
    sel.appendChild(o);
  });
  sel.addEventListener('change', ()=>{ onChange(sel.value); markDirty(); });
  const f = el('div',{class:'field'}, el('label',{class:'lbl'},labelTxt), sel);
  if(hint) f.appendChild(el('div',{class:'hint'},hint));
  return f;
}

/* ═══════════════════════════════════════════════════════════
   CLOUDINARY
═══════════════════════════════════════════════════════════ */
function cloudReady(){
  const c = state.cloudinary || {};
  return c.cloudName && c.uploadPreset;
}
/* Applique l'optimisation automatique (format + qualité) à une URL Cloudinary */
function optimize(url, extra){
  if(!url || url.indexOf('/upload/')<0) return url;
  const t = 'f_auto,q_auto' + (extra ? ','+extra : '');
  return url.replace('/upload/', '/upload/'+t+'/');
}
/* Ouvre le widget Cloudinary ; cb reçoit { full, thumb } */
function pickImage(cb){
  if(!cloudReady()){
    alert('Renseignez d’abord votre Cloud name et Upload preset dans la section « Réglages ».');
    return;
  }
  if(typeof cloudinary==='undefined'){
    alert('Le widget Cloudinary n’a pas pu se charger (connexion ?).');
    return;
  }
  const widget = cloudinary.createUploadWidget({
    cloudName: state.cloudinary.cloudName,
    uploadPreset: state.cloudinary.uploadPreset,
    sources: ['local','camera','url'],
    multiple: false,
    language: 'fr',
    text: { fr: { menu:{files:'Mes fichiers',camera:'Appareil photo',url:'Lien web'} } },
    styles: { palette: { window:'#3d2b1a', sourceBg:'#f5f0e8', windowBorder:'#c4944a',
      tabIcon:'#c4944a', inactiveTabIcon:'#7a5c3e', menuIcons:'#c4944a', link:'#c4944a',
      action:'#c4944a', inProgress:'#c4944a', complete:'#3f7d4f', error:'#9c4a3c',
      textDark:'#2a1f14', textLight:'#f5f0e8' } }
  }, (err, info)=>{
    if(!err && info && info.event==='success'){
      const url = info.info.secure_url;
      cb({
        full:  optimize(url, 'w_1600,c_limit'),
        thumb: optimize(url, 'w_600,h_450,c_fill')
      });
    }
  });
  widget.open();
}

/* ── Bloc choix d'image (image unique) ── */
function imagePicker(labelTxt, value, onChange, hint){
  let thumb = value
    ? el('img',{class:'thumb',src:optimize(value,'w_240,h_180,c_fill'),alt:''})
    : el('div',{class:'thumb'},'Aucune image');
  const path = el('div',{class:'path'}, value || '— aucune —');
  const btn = el('button',{class:'btn btn-accent btn-sm',type:'button',
    onclick:()=>pickImage(({full})=>{ onChange(full); path.textContent = full;
      const ni = el('img',{class:'thumb',src:optimize(full,'w_240,h_180,c_fill')});
      thumb.replaceWith(ni); thumb=ni; markDirty(); })
  },'📷 Changer la photo');
  const meta = el('div',{class:'meta'}, path, btn);
  if(hint) meta.appendChild(el('div',{class:'hint'},hint));
  return el('div',{class:'field'},
    el('label',{class:'lbl'},labelTxt),
    el('div',{class:'imgpick'}, thumb, meta));
}

/* ═══════════════════════════════════════════════════════════
   SECTIONS
═══════════════════════════════════════════════════════════ */
function section(title, openFirst, buildBody){
  const det = el('details',{class:'section'});
  if(openFirst) det.open = true;
  det.appendChild(el('summary',{}, el('span',{},title), el('span',{class:'chev'},'›')));
  const body = el('div',{class:'section-body'});
  buildBody(body);
  det.appendChild(body);
  return det;
}

/* ── Construction des onglets (PC) à partir des sections rendues ── */
function setupTabs(){
  const sections = [...$app.querySelectorAll(':scope > .section')];
  $tabs.innerHTML = '';
  sections.forEach((sec, i)=>{
    const title = sec.querySelector(':scope > summary > span')?.textContent || ('Section '+(i+1));
    const btn = el('button',{type:'button',onclick:()=>setActive(i)}, title);
    $tabs.appendChild(btn);
  });
  if(activeTab >= sections.length) activeTab = 0;
  applyMode();
}

/* ── Activer un onglet (mode PC) ── */
function setActive(i){
  activeTab = i;
  const sections = [...$app.querySelectorAll(':scope > .section')];
  const btns = [...$tabs.children];
  sections.forEach((s,idx)=>s.classList.toggle('is-active', idx===i));
  btns.forEach((b,idx)=>b.classList.toggle('active', idx===i));
}

/* ── Adapter selon la largeur d'écran ── */
function applyMode(){
  const sections = [...$app.querySelectorAll(':scope > .section')];
  if(mqDesktop.matches){
    /* PC : tout ouvert (le détail natif est masqué), une section affichée via onglet */
    sections.forEach(s=>s.open = true);
    setActive(activeTab);
  } else {
    /* Mobile : accordéon natif, on retire le pilotage par onglet */
    sections.forEach((s,idx)=>{ s.classList.remove('is-active'); s.open = (idx===0); });
  }
}
mqDesktop.addEventListener('change', applyMode);

function render(){
  $app.innerHTML = '';
  $warn.style.display = cloudReady() ? 'none' : 'block';
  /* recalcule CATS à partir des catégories enregistrées (ou valeurs par défaut) */
  state.categories = (state.categories && state.categories.length)
    ? state.categories
    : DEFAULT_CATS.map(([value,label])=>({value,label}));
  CATS = state.categories.map(c=>[c.value, c.label]);

  /* ── RÉGLAGES ── */
  $app.appendChild(section('Réglages & Cloudinary', !cloudReady(), b=>{
    b.appendChild(el('div',{class:'hint',style:'margin-bottom:14px'},
      'Identifiants Cloudinary (compte gratuit). Le « preset » doit être de type Unsigned.'));
    state.cloudinary = state.cloudinary || {cloudName:'',uploadPreset:''};
    b.appendChild(textField('Cloud name', state.cloudinary.cloudName,
      v=>state.cloudinary.cloudName=v, {hint:'Visible dans votre tableau de bord Cloudinary.'}));
    b.appendChild(textField('Upload preset (unsigned)', state.cloudinary.uploadPreset,
      v=>state.cloudinary.uploadPreset=v));
    b.appendChild(textField('Titre de l’onglet (SEO)', state.meta?.title,
      v=>{ state.meta=state.meta||{}; state.meta.title=v; }));
    b.appendChild(imagePicker('Logo', state.logo, v=>state.logo=v));
  }));

  /* ── HERO ── */
  $app.appendChild(section('Bannière d’accueil', true, b=>{
    const h = state.hero = state.hero || {};
    b.appendChild(imagePicker('Photo de fond', h.image, v=>h.image=v,
      'Grande image plein écran en haut du site.'));
    b.appendChild(textField('Petit titre (au-dessus)', h.eyebrow, v=>h.eyebrow=v));
    b.appendChild(textField('Noms', h.names, v=>h.names=v));
    b.appendChild(textField('Phrase d’accroche', h.sub, v=>h.sub=v, {multiline:true}));
    b.appendChild(el('div',{class:'grid2'},
      textField('Bouton principal', h.ctaPrimary, v=>h.ctaPrimary=v),
      textField('Bouton secondaire', h.ctaSecondary, v=>h.ctaSecondary=v)));
  }));

  /* ── SERVICES ── */
  $app.appendChild(section('Services', false, b=>{
    const s = state.services = state.services || {};
    b.appendChild(textField('Petit titre', s.label, v=>s.label=v));
    b.appendChild(textField('Titre', s.title, v=>s.title=v, {multiline:true,
      hint:'Astuce : appuyez sur Entrée pour forcer un retour à la ligne.'}));
    b.appendChild(textField('Introduction', s.intro, v=>s.intro=v, {multiline:true}));
    s.items = s.items || [];
    const list = el('div');
    function drawItems(){
      list.innerHTML='';
      s.items.forEach((it,i)=>{
        const card = el('div',{class:'repeat'});
        card.appendChild(el('div',{class:'rowtop'},
          el('span',{class:'tag'},'Service '+(i+1)),
          el('div',{class:'reorder'},
            el('button',{class:'btn btn-ghost btn-sm',type:'button',disabled:i===0||null,
              onclick:()=>{ [s.items[i-1],s.items[i]]=[s.items[i],s.items[i-1]]; markDirty(); drawItems(); }},'↑'),
            el('button',{class:'btn btn-ghost btn-sm',type:'button',disabled:i===s.items.length-1||null,
              onclick:()=>{ [s.items[i+1],s.items[i]]=[s.items[i],s.items[i+1]]; markDirty(); drawItems(); }},'↓'),
            el('button',{class:'btn btn-danger btn-sm',type:'button',
              onclick:()=>{ if(confirm('Supprimer ce service ?')){ s.items.splice(i,1); markDirty(); drawItems(); } }},'Supprimer')
          )));
        card.appendChild(imagePicker('Icône / image', it.icon, v=>it.icon=v));
        card.appendChild(textField('Titre', it.title, v=>it.title=v));
        card.appendChild(textField('Description', it.text, v=>it.text=v, {multiline:true}));
        card.appendChild(catFieldOptional('Lien vers la galerie', it.filter, v=>it.filter=v,
          'Si choisi, la carte devient cliquable et ouvre la galerie filtrée sur cette catégorie.'));
        list.appendChild(card);
      });
    }
    drawItems();
    b.appendChild(list);
    b.appendChild(el('button',{class:'btn btn-ghost miniadd',type:'button',
      onclick:()=>{ s.items.push({icon:'',title:'Nouveau service',text:'',filter:''}); markDirty(); drawItems(); }},'+ Ajouter un service'));
  }));

  /* ── HAUT DE GAMME (bloc accueil avec les 3 cartes) ── */
  $app.appendChild(section('Haut de gamme', false, b=>{
    const hg = state.hautdegamme = state.hautdegamme || {};
    b.appendChild(textField('Petit titre', hg.label, v=>hg.label=v));
    b.appendChild(textField('Titre', hg.title, v=>hg.title=v, {multiline:true}));
    b.appendChild(textField('Introduction', hg.intro, v=>hg.intro=v, {multiline:true}));
    hg.items = hg.items || [];
    const HG_LINK_LABELS = {
      'caves-a-vin.php': 'Caves à vin',
      'escalier-beton.php': 'Escalier béton',
      'beton-imprime.php': 'Finition de qualité'
    };
    b.appendChild(el('div',{class:'hint',style:'margin-bottom:12px'},
      'Chaque carte pointe vers une page dédiée (ci-dessous). Le lien n’est pas modifiable ici.'));
    const list = el('div');
    function draw(){
      list.innerHTML='';
      hg.items.forEach((it)=>{
        const card = el('div',{class:'repeat'});
        card.appendChild(el('div',{class:'rowtop'},
          el('span',{class:'tag'}, HG_LINK_LABELS[it.link] || it.link || 'Carte')));
        card.appendChild(imagePicker('Photo', it.image, v=>it.image=v));
        card.appendChild(textField('Titre', it.title, v=>it.title=v));
        card.appendChild(textField('Description', it.text, v=>it.text=v, {multiline:true}));
        list.appendChild(card);
      });
    }
    draw();
    b.appendChild(list);
  }));

  /* ── PAGE « Cave à vin » ── */
  $app.appendChild(section('- Cave à vins', false, b=>{
    const cav = state.caveavin = state.caveavin || {};
    b.appendChild(el('div',{class:'hint',style:'margin-bottom:12px'},
      'Contenu de la page dédiée escalier-beton.php (menu « Haut de gamme »).'));
    b.appendChild(textField('Petit titre', cav.label, v=>eb.label=v));
    b.appendChild(textField('Titre', cav.title, v=>cav.title=v, {multiline:true}));
    b.appendChild(imagePicker('Photo', cav.image, v=>cav.image=v));
    b.appendChild(textField('Paragraphe 1', cav.p1, v=>cav.p1=v, {multiline:true}));
    b.appendChild(textField('Paragraphe 2', cav.p2, v=>cav.p2=v, {multiline:true}));
    b.appendChild(textField('Paragraphe 3', cav.p3, v=>cav.p3=v, {multiline:true}));
    b.appendChild(textField('Texte du médaillon', cav.badge, v=>cav.badge=v,
      {hint:'Le premier mot s’affiche en haut, le reste en gras.'}));
    cav.tags = cav.tags || [];
    b.appendChild(textField('Mots-clés (séparés par une virgule)', cav.tags.join(', '),
      v=>cav.tags = v.split(',').map(x=>x.trim()).filter(Boolean)));
  }));

  /* ── PAGE « ESCALIER BÉTON » ── */
  $app.appendChild(section('- Escalier béton', false, b=>{
    const eb = state.escalierbeton = state.escalierbeton || {};
    b.appendChild(el('div',{class:'hint',style:'margin-bottom:12px'},
      'Contenu de la page dédiée escalier-beton.php (menu « Haut de gamme »).'));
    b.appendChild(textField('Petit titre', eb.label, v=>eb.label=v));
    b.appendChild(textField('Titre', eb.title, v=>eb.title=v, {multiline:true}));
    b.appendChild(imagePicker('Photo', eb.image, v=>eb.image=v));
    b.appendChild(textField('Paragraphe 1', eb.p1, v=>eb.p1=v, {multiline:true}));
    b.appendChild(textField('Paragraphe 2', eb.p2, v=>eb.p2=v, {multiline:true}));
    b.appendChild(textField('Paragraphe 3', eb.p3, v=>eb.p3=v, {multiline:true}));
    b.appendChild(textField('Texte du médaillon', eb.badge, v=>eb.badge=v,
      {hint:'Le premier mot s’affiche en haut, le reste en gras.'}));
    eb.tags = eb.tags || [];
    b.appendChild(textField('Mots-clés (séparés par une virgule)', eb.tags.join(', '),
      v=>eb.tags = v.split(',').map(x=>x.trim()).filter(Boolean)));
  }));

  /* ── PAGE « BÉTON IMPRIMÉ » (haut de gamme) ── */
  $app.appendChild(section('- Finition de qualité', false, b=>{
    const bi = state.betonimprimepremium = state.betonimprimepremium || {};
    b.appendChild(el('div',{class:'hint',style:'margin-bottom:12px'},
      'Contenu de la page dédiée beton-imprime.php (menu « Haut de gamme »).'));
    b.appendChild(textField('Petit titre', bi.label, v=>bi.label=v));
    b.appendChild(textField('Titre', bi.title, v=>bi.title=v, {multiline:true}));
    b.appendChild(imagePicker('Photo', bi.image, v=>bi.image=v));
    b.appendChild(textField('Paragraphe 1', bi.p1, v=>bi.p1=v, {multiline:true}));
    b.appendChild(textField('Paragraphe 2', bi.p2, v=>bi.p2=v, {multiline:true}));
    b.appendChild(textField('Paragraphe 3', bi.p3, v=>bi.p3=v, {multiline:true, hint:'Optionnel — n\u2019apparaît que si rempli.'}));
    b.appendChild(textField('Texte du médaillon', bi.badge, v=>bi.badge=v,
      {hint:'Le premier mot s’affiche en haut, le reste en gras.'}));
    bi.tags = bi.tags || [];
    b.appendChild(textField('Mots-clés (séparés par une virgule)', bi.tags.join(', '),
      v=>bi.tags = v.split(',').map(x=>x.trim()).filter(Boolean)));
  }));

  /* ── RÉALISATIONS (intro) ── */
  $app.appendChild(section('Bloc « Réalisations » (accueil)', false, b=>{
    const r = state.realisations = state.realisations || {};
    b.appendChild(el('div',{class:'hint',style:'margin-bottom:12px'},
      'Les 3 premières photos de la Galerie s’affichent automatiquement ici.'));
    b.appendChild(textField('Petit titre', r.label, v=>r.label=v));
    b.appendChild(textField('Titre', r.title, v=>r.title=v, {multiline:true}));
    b.appendChild(textField('Description', r.desc, v=>r.desc=v, {multiline:true}));
    b.appendChild(textField('Texte du bouton galerie', r.bannerText, v=>r.bannerText=v));
    b.appendChild(textField('Sous-texte du bouton', r.bannerSub, v=>r.bannerSub=v));
  }));

  /* ── PROCESS ── */
  $app.appendChild(section('Méthode (étapes)', false, b=>{
    const p = state.process = state.process || {};
    b.appendChild(textField('Petit titre', p.label, v=>p.label=v));
    b.appendChild(textField('Titre', p.title, v=>p.title=v, {multiline:true}));
    p.steps = p.steps || [];
    const list = el('div');
    function draw(){
      list.innerHTML='';
      p.steps.forEach((st,i)=>{
        const card = el('div',{class:'repeat'});
        card.appendChild(el('div',{class:'rowtop'},
          el('span',{class:'tag'},'Étape '+(i+1)),
          el('button',{class:'btn btn-danger btn-sm',type:'button',
            onclick:()=>{ if(confirm('Supprimer cette étape ?')){ p.steps.splice(i,1); markDirty(); draw(); } }},'Supprimer')));
        card.appendChild(el('div',{class:'grid2'},
          textField('Numéro', st.num, v=>st.num=v),
          textField('Titre', st.title, v=>st.title=v)));
        card.appendChild(textField('Description', st.text, v=>st.text=v, {multiline:true}));
        list.appendChild(card);
      });
    }
    draw();
    b.appendChild(list);
    b.appendChild(el('button',{class:'btn btn-ghost miniadd',type:'button',
      onclick:()=>{ p.steps.push({num:String(p.steps.length+1).padStart(2,'0'),title:'',text:''}); markDirty(); draw(); }},'+ Ajouter une étape'));
  }));

  /* ── À PROPOS ── */
  $app.appendChild(section('À propos', false, b=>{
    const a = state.about = state.about || {};
    b.appendChild(imagePicker('Photo', a.image, v=>a.image=v));
    b.appendChild(el('div',{class:'grid2'},
      textField('Chiffre du médaillon', a.badgeNum, v=>a.badgeNum=v),
      textField('Légende du médaillon', a.badgeLabel, v=>a.badgeLabel=v)));
    b.appendChild(textField('Petit titre', a.label, v=>a.label=v));
    b.appendChild(textField('Titre', a.title, v=>a.title=v, {multiline:true}));
    b.appendChild(textField('Paragraphe 1', a.p1, v=>a.p1=v, {multiline:true}));
    b.appendChild(textField('Paragraphe 2', a.p2, v=>a.p2=v, {multiline:true}));
    a.people = a.people || [];
    const list = el('div');
    function draw(){
      list.innerHTML='';
      a.people.forEach((pe,i)=>{
        const card = el('div',{class:'repeat'});
        card.appendChild(el('div',{class:'rowtop'},
          el('span',{class:'tag'},'Personne '+(i+1)),
          el('button',{class:'btn btn-danger btn-sm',type:'button',
            onclick:()=>{ if(confirm('Supprimer ?')){ a.people.splice(i,1); markDirty(); draw(); } }},'Supprimer')));
        card.appendChild(el('div',{class:'grid2'},
          textField('Nom', pe.name, v=>pe.name=v),
          textField('Rôle', pe.role, v=>pe.role=v)));
        list.appendChild(card);
      });
    }
    draw();
    b.appendChild(list);
    b.appendChild(el('button',{class:'btn btn-ghost miniadd',type:'button',
      onclick:()=>{ a.people.push({name:'',role:''}); markDirty(); draw(); }},'+ Ajouter une personne'));
  }));

  /* ── STATS ── */
  $app.appendChild(section('Chiffres clés', false, b=>{
    state.stats = state.stats || [];
    const list = el('div');
    function draw(){
      list.innerHTML='';
      state.stats.forEach((st,i)=>{
        const card = el('div',{class:'repeat'});
        card.appendChild(el('div',{class:'rowtop'},
          el('span',{class:'tag'},'Chiffre '+(i+1)),
          el('button',{class:'btn btn-danger btn-sm',type:'button',
            onclick:()=>{ if(confirm('Supprimer ?')){ state.stats.splice(i,1); markDirty(); draw(); } }},'Supprimer')));
        card.appendChild(el('div',{class:'grid2'},
          textField('Chiffre', st.num, v=>st.num=v),
          textField('Légende', st.label, v=>st.label=v)));
        list.appendChild(card);
      });
    }
    draw();
    b.appendChild(list);
    b.appendChild(el('button',{class:'btn btn-ghost miniadd',type:'button',
      onclick:()=>{ state.stats.push({num:'',label:''}); markDirty(); draw(); }},'+ Ajouter un chiffre'));
  }));

  /* ── CONTACT ── */
  $app.appendChild(section('Coordonnées', false, b=>{
    const c = state.contact = state.contact || {};
    b.appendChild(textField('Petit titre', c.label, v=>c.label=v));
    b.appendChild(textField('Titre', c.title, v=>c.title=v, {multiline:true}));
    b.appendChild(textField('Description', c.desc, v=>c.desc=v, {multiline:true}));
    b.appendChild(el('div',{class:'grid2'},
      textField('Téléphone 1', c.phone1, v=>c.phone1=v),
      textField('Téléphone 2', c.phone2, v=>c.phone2=v)));
    b.appendChild(textField('E-mail', c.email, v=>c.email=v));
    b.appendChild(textField('Zone d’intervention', c.zone, v=>c.zone=v, {multiline:true}));
  }));

  /* ── GALERIE ── */
  /* ── CATÉGORIES DE LA GALERIE ── */
  $app.appendChild(section('Catégories de la galerie', false, b=>{
    b.appendChild(el('div',{class:'hint',style:'margin-bottom:12px'},
      'Ces catégories servent à filtrer la galerie et à lier les cartes "Services". Attention : si vous changez l\u2019identifiant d\u2019une catégorie déjà utilisée par des photos ou des services, ces liens ne correspondront plus — renommez plutôt le libellé, pas l\u2019identifiant.'));
    const list = el('div');
    function draw(){
      list.innerHTML='';
      state.categories.forEach((cat,i)=>{
        const card = el('div',{class:'repeat'});
        card.appendChild(el('div',{class:'rowtop'},
          el('span',{class:'tag'}, 'Catégorie '+(i+1)),
          el('div',{class:'reorder'},
            el('button',{class:'btn btn-ghost btn-sm',type:'button',disabled:i===0||null,
              onclick:()=>{ [state.categories[i-1],state.categories[i]]=[state.categories[i],state.categories[i-1]]; markDirty(); render(); } },'↑'),
            el('button',{class:'btn btn-ghost btn-sm',type:'button',disabled:i===state.categories.length-1||null,
              onclick:()=>{ [state.categories[i+1],state.categories[i]]=[state.categories[i],state.categories[i+1]]; markDirty(); render(); } },'↓'),
            el('button',{class:'btn btn-danger btn-sm',type:'button',
              onclick:()=>{ if(confirm('Supprimer cette catégorie ?')){ state.categories.splice(i,1); markDirty(); render(); } }},'Supprimer')
          )));
        card.appendChild(textField('Libellé affiché', cat.label, v=>cat.label=v));
        card.appendChild(textField('Identifiant technique (sans espace ni accent)', cat.value, v=>cat.value=v,
          {hint:'Utilisé en interne pour relier photos et services à cette catégorie.'}));
        list.appendChild(card);
      });
    }
    draw();
    b.appendChild(list);
    b.appendChild(el('button',{class:'btn btn-ghost miniadd',type:'button',
      onclick:()=>{ state.categories.push({value:'nouvelle-categorie',label:'Nouvelle catégorie'}); markDirty(); render(); }},'+ Ajouter une catégorie'));
  }));

  $app.appendChild(section('Galerie photos', false, b=>{
        state.gallery = state.gallery || [];
    state.gallery.forEach(g=>{
      if(!Array.isArray(g.categories)){
        g.categories = g.category ? [g.category] : [];
        delete g.category;
      }
    });
    b.appendChild(el('div',{class:'hint',style:'margin-bottom:12px'},
      'Ajoutez vos photos via Cloudinary. La miniature et la version pleine taille sont créées automatiquement.'));
    const list = el('div');
    function draw(){
      list.innerHTML='';
      state.gallery.forEach((g,i)=>{
        const card = el('div',{class:'gal-item'});
        const thumb = g.thumb || g.full
          ? el('img',{class:'gthumb',src:g.thumb||g.full,alt:''})
          : el('div',{class:'gthumb'});
        const fields = el('div',{class:'gal-fields'},
          textField('Légende', g.caption, v=>g.caption=v),
          textField('Sous-titre', g.sub, v=>g.sub=v),
          catField(g.categories, v=>g.categories=v));
        card.appendChild(el('div',{class:'top'}, thumb, fields));
        card.appendChild(el('div',{class:'gal-actions'},
          el('button',{class:'btn btn-accent btn-sm',type:'button',
            onclick:()=>pickImage(({full,thumb:t})=>{ g.full=full; g.thumb=t; markDirty(); draw(); })},'📷 Remplacer la photo'),
          el('button',{class:'btn btn-ghost btn-sm',type:'button',disabled:i===0||null,
            onclick:()=>{ [state.gallery[i-1],state.gallery[i]]=[state.gallery[i],state.gallery[i-1]]; markDirty(); draw(); }},'↑'),
          el('button',{class:'btn btn-ghost btn-sm',type:'button',disabled:i===state.gallery.length-1||null,
            onclick:()=>{ [state.gallery[i+1],state.gallery[i]]=[state.gallery[i],state.gallery[i+1]]; markDirty(); draw(); }},'↓'),
          el('button',{class:'btn btn-danger btn-sm',type:'button',
            onclick:()=>{ if(confirm('Supprimer cette photo ?')){ state.gallery.splice(i,1); markDirty(); draw(); } }},'Supprimer')));
        list.appendChild(card);
      });
    }
    draw();
    b.appendChild(list);
    b.appendChild(el('button',{class:'btn btn-accent miniadd',type:'button',
      onclick:()=>pickImage(({full,thumb})=>{
        state.gallery.push({full,thumb,caption:'Nouvelle réalisation',sub:'',categories:[]});
        markDirty(); draw();
      })},'+ Ajouter une photo'));
  }));

  setupTabs();
}

/* ═══════════════════════════════════════════════════════════
   CHARGEMENT / ENREGISTREMENT
═══════════════════════════════════════════════════════════ */
async function load(){
  try{
    const res = await fetch('content.json?_='+Date.now());
    if(!res.ok) throw new Error('HTTP '+res.status);
    state = await res.json();
    render();
    $status.className = 'status';
    $status.textContent = 'Prêt';
    $save.disabled = true;
  }catch(e){
    $status.className = 'status err';
    $status.textContent = 'Impossible de charger content.json';
    $app.appendChild(el('div',{class:'warn'},
      'Vérifiez que content.json se trouve dans le même dossier que cette page.'));
  }
}

$save.addEventListener('click', async ()=>{
  $save.disabled = true;
  $status.className = 'status';
  $status.textContent = 'Enregistrement…';
  try{
    const res = await fetch('save.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify(state)
    });
    const out = await res.json();
    if(!res.ok || !out.ok) throw new Error(out.error || ('HTTP '+res.status));
    dirty = false;
    $status.className = 'status ok';
    $status.textContent = '✓ Enregistré — le site est à jour';
  }catch(e){
    $status.className = 'status err';
    $status.textContent = 'Échec : '+e.message;
    $save.disabled = false;
  }
});

/* Avertir avant de quitter si modifications non enregistrées */
window.addEventListener('beforeunload', e=>{
  if(dirty){ e.preventDefault(); e.returnValue=''; }
});

load();