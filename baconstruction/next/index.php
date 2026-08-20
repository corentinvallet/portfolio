<?php
/* ═══════════════════════════════════════════════════════════
   B&A Construction — rendu serveur depuis content.json
   Le texte est injecté côté serveur : les robots (Google) voient
   le contenu complet dans le HTML, pas après exécution du JS.
═══════════════════════════════════════════════════════════ */
$c = json_decode(@file_get_contents(__DIR__ . '/content.json'), true) ?: [];

// échappe le texte simple
function e($s) { return htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8'); }
// échappe + conserve les retours à la ligne (saut de ligne -> <br>)
function ml($s) { return nl2br(htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8')); }

$hero    = $c['hero']         ?? [];
$serv    = $c['services']     ?? [];
$cave    = $c['caveavin']     ?? [];
$hdg     = $c['hautdegamme']  ?? [];
$real    = $c['realisations'] ?? [];
$proc    = $c['process']      ?? [];
$about   = $c['about']        ?? [];
$stats   = $c['stats']        ?? [];
$contact = $c['contact']      ?? [];
$gallery = $c['gallery']      ?? [];
$logo    = $c['logo']         ?? 'Photos/Logo simplifié.webp';

// les 3 premières réalisations alimentent l'aperçu de la page d'accueil
$preview = array_slice($gallery, 0, 3);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title><?= e($c['meta']['title'] ?? 'B&A Construction') ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="preload" as="image" href="<?= e($hero['image'] ?? '') ?>">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
      --sand:#e8dcc8;--brown:#7a5c3e;--dark-brown:#3d2b1a;
      --cream:#f5f0e8;--accent:#c4944a;--text:#2a1f14;
    }
    html{scroll-behavior:smooth}
    body{font-family:'Raleway',sans-serif;color:var(--text);background:var(--cream);overflow-x:hidden}

    /* ── PAGE VIEWS ── */
    .page{display:none}
    .page.active{display:block}
    section[id]{scroll-margin-top:80px}

    /* ── NAV ── */
    nav{
      position:fixed;top:0;left:0;right:0;z-index:100;
      display:flex;align-items:center;justify-content:space-between;
      padding:16px 5%;
      background:rgba(26,18,10,0.88);
      backdrop-filter:blur(14px);
      border-bottom:1px solid rgba(196,148,74,0.25);
    }
    .nav-logo{display:flex;align-items:center;gap:13px;text-decoration:none;cursor:pointer}
    .nav-brand{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--sand);letter-spacing:.04em;line-height:1.2}
    .nav-brand em{font-style:normal;color:var(--accent)}
    .nav-logo-img{width:46px;height:46px;border-radius:50%;object-fit:cover;background:var(--accent);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:900;color:#fff;font-size:1rem;flex-shrink:0}

    /* Main nav links (home page) */
    .nav-links{display:flex;gap:28px;list-style:none}
    .nav-links a{text-decoration:none;color:var(--sand);font-size:.78rem;font-weight:500;letter-spacing:.12em;text-transform:uppercase;transition:color .25s;cursor:pointer}
    .nav-links a:hover{color:var(--accent)}
    .nav-toggle{display:none;flex-direction:column;gap:5px;
      width:42px;height:42px;padding:0;background:none;border:0;cursor:pointer}
    .nav-toggle span{display:block;width:24px;height:2px;margin:0 auto;
      background:var(--sand);transition:transform .3s,opacity .3s}
    #main-nav.open .nav-toggle span:nth-child(1){transform:translateY(7px) rotate(45deg)}
    #main-nav.open .nav-toggle span:nth-child(2){opacity:0}
    #main-nav.open .nav-toggle span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}

    /* ── DROPDOWN "Haut de gamme" ── */
    .nav-links li{position:relative;list-style:none}
    .has-dropdown > a::after{content:"";display:inline-block;width:6px;height:6px;margin-left:6px;border-right:1.5px solid currentColor;border-bottom:1.5px solid currentColor;transform:translateY(-2px) rotate(45deg)}
    .dropdown{
      list-style:none;position:absolute;top:calc(100% + 14px);left:50%;transform:translateX(-50%) translateY(-6px);
      min-width:210px;background:rgba(20,14,8,0.98);border:1px solid rgba(196,148,74,.25);
      padding:8px 0;opacity:0;visibility:hidden;transition:opacity .22s ease,transform .22s ease,visibility .22s;
      box-shadow:0 18px 40px rgba(0,0,0,.4);
    }
    .has-dropdown:hover .dropdown,.has-dropdown:focus-within .dropdown{opacity:1;visibility:visible;transform:translateX(-50%) translateY(0)}
    .dropdown a{display:block;padding:11px 22px;font-size:.74rem;letter-spacing:.1em;white-space:nowrap}
    .dropdown a::after{display:none}
    @media(max-width:900px){
      .has-dropdown > a::after{display:none}
      .dropdown{
        position:static;transform:none;opacity:1;visibility:visible;box-shadow:none;
        background:rgba(196,148,74,.1);
        border-left:2px solid var(--accent);
        margin-left:4px;
        padding:4px 0 10px;
      }
      .dropdown a{
        position:relative;
        padding:11px 0 11px 26px;
        border-bottom:1px solid rgba(196,148,74,.1);
        font-size:.8rem;
        color:rgba(232,220,200,.75);
      }
    }

    /* Gallery back link */
    .nav-back{
      display:flex;align-items:center;gap:8px;
      text-decoration:none;color:var(--sand);
      font-size:.76rem;font-weight:500;letter-spacing:.12em;text-transform:uppercase;
      transition:color .25s;cursor:pointer;background:none;border:none;
    }
    .nav-back:hover{color:var(--accent)}
    .nav-back svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

    /* ── HERO ── */
    .hero{position:relative;height:100vh;min-height:600px;display:flex;align-items:center;justify-content:center;text-align:center;overflow:hidden}
    .hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;animation:hZoom 16s ease-in-out infinite alternate;background-color:var(--dark-brown)}
    @keyframes hZoom{from{transform:scale(1.03)}to{transform:scale(1.1)}}
    .hero-overlay{position:absolute;inset:0;background:linear-gradient(180deg,rgba(26,18,10,.5) 0%,rgba(26,18,10,.35) 40%,rgba(26,18,10,.78) 100%)}
    .hero-content{position:relative;z-index:2;display:flex;flex-direction:column;align-items:center;gap:18px;animation:fadeUp 1.2s ease both}
    @keyframes fadeUp{from{opacity:0;transform:translateY(34px)}to{opacity:1;transform:none}}
    .hero-logo-circle{width:96px;height:96px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:900;color:#fff;font-size:2rem;box-shadow:0 0 40px rgba(196,148,74,.45)}
    .hero-logo{width:96px;height:96px;border-radius:50%;border:none solid var(--accent);box-shadow:0 0 40px rgba(196,148,74,.45);object-fit:cover}
    .hero-eyebrow{font-size:.75rem;letter-spacing:.26em;text-transform:uppercase;color:var(--sand);font-weight:600}
    .hero h1{font-family:'Playfair Display',serif;font-size:clamp(2.8rem,6.5vw,5.5rem);font-weight:900;line-height:1.05;color:var(--sand);text-shadow:0 4px 30px rgba(0,0,0,.55)}
    .hero h1 em{font-style:normal;color:var(--accent)}
    .hero-sub{font-size:clamp(.9rem,1.8vw,1.1rem);color:var(--sand);font-weight:300;letter-spacing:.05em;max-width:520px}
    .hero-names{font-size:.75rem;letter-spacing:.2em;text-transform:uppercase;color:rgba(232,220,200,.65)}
    .hero-cta{margin-top:6px;display:flex;gap:14px;flex-wrap:wrap;justify-content:center}
    .btn-primary{padding:13px 36px;background:var(--accent);color:#fff;border:none;cursor:pointer;font-family:'Raleway',sans-serif;font-size:.8rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;text-decoration:none;transition:background .25s,transform .2s;display:inline-block}
    .btn-primary:hover{background:#a87836;transform:translateY(-2px)}
    .btn-outline{padding:13px 36px;background:transparent;color:#fff;border:2px solid rgba(255,255,255,.5);cursor:pointer;font-family:'Raleway',sans-serif;font-size:.8rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;text-decoration:none;transition:border-color .25s,color .25s,transform .2s;display:inline-block}
    .btn-outline:hover{border-color:var(--accent);color:var(--accent);transform:translateY(-2px)}
    .scroll-hint{position:absolute;bottom:28px;left:50%;transform:translateX(-50%);z-index:2;display:flex;flex-direction:column;align-items:center;gap:6px;opacity:.6}
    .scroll-hint span{font-size:.62rem;letter-spacing:.2em;text-transform:uppercase;color:var(--sand)}
    .scroll-line{width:1px;height:44px;background:var(--accent);animation:sLine 2s ease-in-out infinite}
    @keyframes sLine{0%,100%{opacity:.3;transform:scaleY(.4)}50%{opacity:1;transform:scaleY(1)}}

    /* ── SECTIONS ── */
    section{padding:90px 5%}
    .section-label{font-size:.7rem;letter-spacing:.28em;text-transform:uppercase;color:var(--accent);font-weight:600;margin-bottom:12px}
    .section-title{font-family:'Playfair Display',serif;font-size:clamp(1.9rem,4vw,2.9rem);font-weight:700;line-height:1.15;color:var(--dark-brown);margin-bottom:18px}
    .section-desc{font-size:.97rem;line-height:1.85;color:#5a4535;max-width:560px}

    /* ── SERVICES ── */
    #services{background:var(--dark-brown)}
    #services .section-title{color:var(--sand)}
    .services-intro{color:rgba(232,220,200,.65);font-size:.97rem;line-height:1.85;max-width:540px;margin-bottom:52px}
    .services-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:2px}
    .service-card{background:rgba(255,255,255,.04);border:1px solid rgba(196,148,74,.18);padding:38px 30px;transition:background .3s,transform .3s}
    .service-card:hover{background:rgba(196,148,74,.1);transform:translateY(-4px)}
    .service-icon{font-size:1.9rem;margin-bottom:16px}
    .service-card h3{font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;color:var(--sand);margin-bottom:10px}
    .service-card p{font-size:.86rem;line-height:1.78;color:rgba(232,220,200,.6)}

    .service-card.is-link{cursor:pointer;position:relative}

    /* Le libellé devient un vrai "bouton" qui apparaît */
    .service-card.is-link::after{
      content:"Voir les réalisations";
      display:inline-block;margin-top:16px;
      padding:8px 18px;border:1px solid var(--accent);
      font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
      color:var(--accent);
      opacity:0;transform:translateY(8px);
      transition:opacity .3s ease,transform .3s ease,background .25s,color .25s;
    }
    .service-card.is-link.is-hover::after,
    .service-card.is-link.is-revealed::after{
      opacity:1;transform:none;
      background:var(--accent);color:#fff;   /* pastille pleine = appel à l'action */
    }

    /* Mise en évidence de la carte sélectionnée au 1er tap (mobile) */
    .service-card.is-link.is-revealed{
      background:rgba(196,148,74,.12);
      border-color:var(--accent);
      transform:translateY(-4px);
      animation:cardPulse .6s ease-out;
    }
    @keyframes cardPulse{
      0%  {box-shadow:0 0 0 0   rgba(196,148,74,.45)}
      100%{box-shadow:0 0 0 16px rgba(196,148,74,0)}
    }

    @media(prefers-reduced-motion:reduce){
      .service-card.is-link.is-revealed{animation:none}
      .service-card.is-link::after{transition:opacity .2s}
    }

    /* ── HAUT DE GAMME (teaser accueil) ── */
    #hautdegamme{background:var(--cream)}
    .hdg-intro{color:var(--dark-brown);font-size:.97rem;line-height:1.85;max-width:540px;margin-bottom:48px}
    .hdg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .hdg-card{display:block;text-decoration:none;position:relative;aspect-ratio:3/4;overflow:hidden;border:1px solid rgba(196,148,74,.2)}
    .hdg-card img{width:100%;height:100%;object-fit:cover;display:block;filter:sepia(10%) contrast(1.05);transition:transform .55s cubic-bezier(.25,.46,.45,.94)}
    .hdg-card:hover img{transform:scale(1.08)}
    .hdg-overlay{position:absolute;inset:0;background:linear-gradient(180deg,rgba(26,18,10,0) 30%,rgba(26,18,10,.92) 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:26px 22px}
    .hdg-card h3{font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:700;color:var(--sand);margin-bottom:8px}
    .hdg-card p{font-size:.82rem;line-height:1.6;color:rgba(232,220,200,.7);margin-bottom:14px}
    .hdg-cta{font-size:.7rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--accent);display:inline-flex;align-items:center;gap:8px}
    .hdg-card:hover .hdg-cta{color:#e0ac5f}
    @media(max-width:900px){.hdg-grid{grid-template-columns:1fr;gap:16px}.hdg-card{aspect-ratio:16/10}}

    /* ── GALLERY PREVIEW ── */
    #realisations{background:var(--sand)}
    .gallery-link-banner{
      display:flex;flex-direction:column;align-items:flex-start;gap:4px;
      margin-top:36px;margin-bottom:20px;padding:18px 28px;
      border:1px solid rgba(196,148,74,.4);background:var(--accent);
      text-decoration:none;transition:background .25s,border-color .25s,transform .2s;
      max-width:420px;cursor:pointer;
    }
    .gallery-link-banner:hover{background:#a87836;border-color:var(--accent);transform:translateX(4px)}
    .gallery-link-text{font-family:'Raleway',sans-serif;font-size:.82rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--cream)}
    .gallery-link-sub{font-size:.75rem;color:var(--cream);letter-spacing:.06em}

    .gallery-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
    .gallery-preview .gallery-item{aspect-ratio:4/3}
    .gallery-item{overflow:hidden;position:relative;cursor:pointer}
    .gallery-item img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .55s cubic-bezier(.25,.46,.45,.94)}
    .gallery-item:hover img{transform:scale(1.07)}
    .gallery-caption{position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(26,18,10,.78) 100%);opacity:0;transition:opacity .3s;display:flex;flex-direction:column;align-items:flex-start;justify-content:flex-end;padding:18px;gap:4px}
    .gallery-item:hover .gallery-caption{opacity:1}
    .gallery-caption span{font-size:.75rem;letter-spacing:.14em;text-transform:uppercase;color:var(--sand);font-weight:500}
    .gallery-caption em{font-style:normal;font-size:.65rem;letter-spacing:.08em;color:var(--accent);text-transform:uppercase}

    /* ── VIGNETTE → GALERIE (overlay + bouton dédié) ──
       PC  : le bouton apparaît au survol (CSS :hover).
       Mobile : le bouton apparaît au 1er tap (classe .is-revealed posée en JS).
       L'overlay reste pointer-events:none (purement visuel) ; seul le BOUTON
       est cliquable une fois visible → un tap "à côté" ne déclenche rien. */
    .gallery-preview .gallery-item{position:relative}
    .preview-overlay{
      position:absolute;inset:0;z-index:3;pointer-events:none;
      display:flex;align-items:center;justify-content:center;padding:16px;
      background:linear-gradient(180deg,rgba(26,18,10,.30) 0%,rgba(26,18,10,.62) 100%);
      opacity:0;transition:opacity .35s ease;
    }
    .preview-cta{
      pointer-events:none;appearance:none;cursor:pointer;
      font-family:'Raleway',sans-serif;font-size:.78rem;font-weight:600;
      letter-spacing:.14em;text-transform:uppercase;
      display:inline-flex;align-items:center;gap:9px;
      padding:13px 28px;border:none;background:var(--accent);color:#fff;
      box-shadow:0 12px 32px rgba(0,0,0,.42);
      transform:translateY(12px);
      transition:transform .35s cubic-bezier(.16,.84,.44,1),background .25s;
    }
    .preview-cta .arrow{transition:transform .25s cubic-bezier(.16,.84,.44,1)}
    .preview-cta:hover{background:#a87836}
    .preview-cta:hover .arrow{transform:translateX(4px)}

    /* Révélation pilotée en JS pour être fiable partout :
       .is-hover    → survol souris (pointerenter, hors tactile)
       .is-revealed → tap tactile (touchend)
       On n'utilise PAS le :hover CSS ici : sur mobile il déclenche le
       « 1er tap = survol » qui avale le clic. */
    .gallery-preview .gallery-item.is-hover    .preview-overlay,
    .gallery-preview .gallery-item.is-revealed .preview-overlay{opacity:1}
    .gallery-preview .gallery-item.is-hover    .preview-cta,
    .gallery-preview .gallery-item.is-revealed .preview-cta{transform:none;pointer-events:auto}
    .gallery-preview .gallery-item.is-hover    img,
    .gallery-preview .gallery-item.is-revealed img{transform:scale(1.07)}
    .gallery-preview .gallery-item.is-hover    .gallery-caption,
    .gallery-preview .gallery-item.is-revealed .gallery-caption{opacity:1}

    @media(prefers-reduced-motion:reduce){
      .preview-overlay,.preview-cta,.preview-cta .arrow{transition:none}
      .preview-cta{transform:none}
    }

    /* Photo placeholder (quand pas d'image réelle) */
    .photo-placeholder{width:100%;height:100%;background:linear-gradient(135deg,var(--dark-brown) 0%,var(--brown) 100%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;color:rgba(232,220,200,.4);font-size:.7rem;letter-spacing:.12em;text-transform:uppercase}
    .photo-placeholder svg{width:36px;height:36px;opacity:.4;stroke:currentColor;fill:none;stroke-width:1.5}

    /* ── PROCESS ── */
    #process{background:var(--dark-brown)}
    .process-steps{margin-top:52px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr))}
    .process-step{padding:38px 28px;border-left:1px solid var(--brown);position:relative}
    #process .section-title{color:var(--sand)}
    .step-num{font-family:'Playfair Display',serif;font-size:3.8rem;font-weight:900;line-height:1;color:rgba(122,92,62,.5);position:absolute;top:22px;right:18px}
    .process-step h3{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--sand);margin-bottom:10px}
    .process-step p{font-size:.85rem;line-height:1.78;color:var(--sand)}

    /* ── ABOUT ── */
    #about{background:var(--cream);display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
    .about-img-wrap{position:relative}
    .about-img-wrap img{width:100%;display:block;filter:sepia(15%) contrast(1.05)}
    .about-img-placeholder{width:100%;aspect-ratio:4/3;background:linear-gradient(135deg,rgba(61,43,26,.8) 0%,rgba(122,92,62,.6) 100%);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1.2rem;color:rgba(232,220,200,.3);letter-spacing:.1em;border:1px solid rgba(196,148,74,.15)}
    .about-badge{position:absolute;bottom:-22px;right:-22px;width:108px;height:108px;background:var(--accent);border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center}
    .about-badge strong{font-size:2rem;font-weight:900;color:#fff;line-height:1}
    .about-badge span{font-size:.58rem;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.82)}
    .about-names{margin-top:30px;display:flex;gap:28px}
    .about-name-card{border-left:3px solid var(--brown);padding-left:15px}
    .about-name-card strong{display:block;font-size:.98rem;color:var(--brown);font-family:'Playfair Display',serif}
    .about-name-card span{font-size:.76rem;color:var(--accent);letter-spacing:.1em}

    /* ── STATS ── */
    #stats{background:var(--accent);padding:65px 5%;display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));text-align:center}
    .stat{padding:18px;border-right:1px solid rgba(255,255,255,.25)}
    .stat:last-child{border-right:none}
    .stat-num{font-family:'Playfair Display',serif;font-size:3rem;font-weight:900;color:#fff;line-height:1}
    .stat-label{font-size:.72rem;letter-spacing:.18em;text-transform:uppercase;color:rgba(255,255,255,.82);margin-top:7px}

    /* ── CONTACT ── */
    #contact{background:var(--cream)}
    .contact-wrap{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start}
    .contact-info{display:flex;flex-direction:column;gap:26px;margin-top:38px}
    .contact-item{display:flex;gap:16px;align-items:flex-start}
    .contact-icon{font-size:1.3rem;margin-top:2px}
    .contact-item strong{display:block;font-size:.7rem;letter-spacing:.18em;text-transform:uppercase;color:var(--accent);margin-bottom:4px}
    .contact-item p{font-size:.93rem;color:var(--brown);line-height:1.65}
    .contact-form{display:flex;flex-direction:column;gap:14px;margin-top:38px}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .contact-form input,.contact-form textarea,.contact-form select{width:100%;padding:13px 17px;border:1px solid rgba(122,92,62,.28);background:#fff;font-family:'Raleway',sans-serif;font-size:.88rem;color:var(--text);outline:none;transition:border-color .25s;appearance:none}
    .contact-form input:focus,.contact-form textarea:focus,.contact-form select:focus{border-color:var(--accent)}
    .contact-form textarea{resize:vertical;min-height:120px}

    /* ── FOOTER ── */
    footer{background:var(--dark-brown);padding:36px 5%;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:18px;border-top:1px solid rgba(196,148,74,.2)}
    .footer-brand{display:flex;align-items:center;gap:14px}
    .footer-logo-circle{width:42px;height:42px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:900;color:#fff;font-size:.9rem;flex-shrink:0;opacity:.9}
    .footer-brand strong{display:block;color:var(--sand);font-family:'Playfair Display',serif;font-size:.92rem}
    .footer-brand p{font-size:.76rem;color:rgba(232,220,200,.45)}
    .footer-copy{font-size:.72rem;color:rgba(232,220,200,.32);letter-spacing:.08em}

    /* ── GALERIE PAGE ── */
    .page-header{
      padding:130px 5% 60px;
      background:var(--dark-brown);
      border-bottom:1px solid rgba(196,148,74,.2);
    }
    .page-header .section-label{font-size:.7rem;letter-spacing:.28em;text-transform:uppercase;color:var(--accent);font-weight:600;margin-bottom:12px}
    .page-header h1{font-family:'Playfair Display',serif;font-size:clamp(2.2rem,5vw,3.8rem);font-weight:900;color:var(--sand);line-height:1.1;margin-bottom:14px}
    .page-header h1 em{font-style:normal;color:var(--accent)}
    .page-header p{font-size:.97rem;line-height:1.85;color:rgba(232,220,200,.6);max-width:520px}

    .gallery-section{padding:60px 5% 90px}

    .gallery-filters{
      display:flex;gap:10px;flex-wrap:wrap;
      margin-bottom:36px;padding-bottom:28px;
      border-bottom:1px solid rgba(122,92,62,.18);
    }
    .filter-btn{
      padding:10px 26px;background:transparent;color:var(--brown);
      border:1px solid rgba(122,92,62,.35);cursor:pointer;
      font-family:'Raleway',sans-serif;font-size:.74rem;font-weight:600;
      letter-spacing:.14em;text-transform:uppercase;
      transition:background .22s,color .22s,border-color .22s,transform .18s;
    }
    .filter-btn:hover{border-color:var(--accent);color:var(--accent);transform:translateY(-1px)}
    .filter-btn.active{background:var(--accent);color:#fff;border-color:var(--accent)}

    .gallery-count{font-size:.74rem;letter-spacing:.12em;text-transform:uppercase;color:var(--brown);opacity:.6;margin-bottom:18px}

    .gallery-full-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
    .gallery-full-grid .gallery-item{aspect-ratio:4/3;transition:opacity .35s}
    .gallery-full-grid .gallery-item.hidden{display:none}

    .gallery-empty{display:none;grid-column:1/-1;padding:60px 0;text-align:center;color:var(--brown);font-size:.92rem;opacity:.6}

    /* ── LIGHTBOX MODAL ── */
    #lightbox{
      position:fixed;inset:0;z-index:999;
      background:rgba(10,6,3,.92);
      backdrop-filter:blur(10px);
      display:flex;align-items:center;justify-content:center;
      opacity:0;pointer-events:none;
      transition:opacity .3s ease;
    }
    #lightbox.open{opacity:1;pointer-events:all}

    .lb-stage{
      position:relative;width:100%;height:100%;
      display:flex;align-items:center;justify-content:center;
      overflow:hidden;
      cursor:zoom-in;
      touch-action:none;
    }
    .lb-stage.zoomed{cursor:grab}
    .lb-stage.zoomed:active{cursor:grabbing}

    .lb-img{
      max-width:90vw;max-height:85vh;
      object-fit:contain;
      transform-origin:center center;
      transform:scale(1) translate(0,0);
      transition:transform .35s cubic-bezier(.25,.46,.45,.94);
      user-select:none;
      border:1px solid rgba(196,148,74,.15);
      box-shadow:0 30px 80px rgba(0,0,0,.7);
      display:block;
    }
    .lb-stage.zoomed .lb-img{transition:none}

    .lb-placeholder{
      width:min(80vw,700px);height:min(70vh,500px);
      background:linear-gradient(135deg,var(--dark-brown),var(--brown));
      display:flex;flex-direction:column;align-items:center;justify-content:center;
      gap:14px;color:rgba(232,220,200,.35);font-size:.8rem;letter-spacing:.14em;text-transform:uppercase;
      border:1px solid rgba(196,148,74,.15);box-shadow:0 30px 80px rgba(0,0,0,.7);
    }
    .lb-placeholder svg{width:52px;height:52px;opacity:.35;stroke:currentColor;fill:none;stroke-width:1.2}

    .lb-bar{
      position:fixed;bottom:0;left:0;right:0;
      padding:16px 5%;
      background:linear-gradient(0deg,rgba(10,6,3,.85) 0%,transparent 100%);
      display:flex;align-items:center;justify-content:space-between;
      z-index:1001;pointer-events:none;opacity:0;
      transition:opacity .3s;
    }
    #lightbox.open .lb-bar{opacity:1;pointer-events:all}
    .lb-caption{display:flex;flex-direction:column;gap:3px}
    .lb-caption span{font-size:.8rem;letter-spacing:.14em;text-transform:uppercase;color:var(--sand);font-weight:500}
    .lb-caption em{font-style:normal;font-size:.68rem;letter-spacing:.1em;color:var(--accent);text-transform:uppercase}
    .lb-hint{font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;color:rgba(232,220,200,.3)}

    .lb-btn{
      position:fixed;top:50%;transform:translateY(-50%);
      z-index:1001;background:rgba(196,148,74,.12);border:1px solid rgba(196,148,74,.3);
      color:var(--sand);width:48px;height:48px;
      display:flex;align-items:center;justify-content:center;
      cursor:pointer;transition:background .2s,border-color .2s,transform .2s;
      font-size:1.2rem;
    }
    .lb-btn:hover{background:rgba(196,148,74,.3);border-color:var(--accent);transform:translateY(-50%) scale(1.05)}
    #lb-prev{left:18px}
    #lb-next{right:18px}

    #lb-close{
      position:fixed;top:18px;right:22px;z-index:1001;
      background:rgba(196,148,74,.12);border:1px solid rgba(196,148,74,.3);
      color:var(--sand);width:42px;height:42px;
      display:flex;align-items:center;justify-content:center;
      cursor:pointer;font-size:1.1rem;transition:background .2s,border-color .2s;
    }
    #lb-close:hover{background:rgba(196,148,74,.3);border-color:var(--accent)}

    #lb-counter{
      position:fixed;top:24px;left:50%;transform:translateX(-50%);
      z-index:1001;font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;
      color:rgba(232,220,200,.4);
    }

    .lb-zoom-hint{
      position:fixed;top:22px;left:22px;z-index:1001;
      font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;
      color:rgba(232,220,200,.28);pointer-events:none;
      display:flex;align-items:center;gap:6px;
    }
    @media(hover:none),(pointer:coarse){
      .lb-zoom-hint{display:none}
      .lb-hint{display:none}
    }

    /* ── RESPONSIVE ── */
    @media(max-width:900px){
      #about{grid-template-columns:1fr;gap:50px}
      .about-badge{right:0}
      #caveavin,.detail-section{grid-template-columns:1fr;gap:50px}
      .caveavin-badge,.detail-badge{right:0}
      .contact-wrap{grid-template-columns:1fr;gap:40px}
      .form-row{grid-template-columns:1fr}
      .gallery-grid,.gallery-full-grid{grid-template-columns:1fr 1fr}
      .gallery-preview .gallery-item{aspect-ratio:4/3}
      .nav-toggle{display:flex}
      .nav-links{
        position:absolute;top:100%;left:0;right:0;
        flex-direction:column;gap:0;
        background:rgba(26,18,10,0.97);backdrop-filter:blur(14px);
        border-bottom:1px solid rgba(196,148,74,0.25);
        max-height:0;overflow:hidden;
        transition:max-height .35s ease,padding .35s ease;padding:0 5%;
      }
      #main-nav.open .nav-links{max-height:calc(100vh - 70px);overflow-y:auto;padding:8px 5% 20px}
      .nav-links li{width:100%}
      .nav-links a{display:block;padding:15px 0;font-size:.9rem;
        border-bottom:1px solid rgba(196,148,74,0.12)}
    }
    @media(max-width:560px){
      .gallery-grid,.gallery-full-grid{grid-template-columns:1fr}
      .gallery-preview .gallery-item{aspect-ratio:16/9}
      .gallery-filters{gap:8px}
      .filter-btn{padding:9px 18px;font-size:.7rem}
    }
  </style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVIGATION (commune aux deux pages)
═══════════════════════════════════════════ -->
<nav id="main-nav">
  <a class="nav-logo" href="index.php">
    <img src="<?= e($logo) ?>" style="width:50px;height:50px" alt="Logo B&amp;A Construction">
    <div class="nav-brand">B<em>&amp;</em>A Construction</div>
  </a>
  <button class="nav-toggle" id="navToggle" aria-label="Ouvrir le menu"
          aria-expanded="false" aria-controls="navLinks">
    <span></span><span></span><span></span>
  </button>
  <ul class="nav-links" id="navLinks">
    <li><a href="#services">Services</a></li>
    <li class="has-dropdown">
      <a href="#hautdegamme">Haut de gamme</a>
      <ul class="dropdown">
        <li><a href="caves-a-vin.php">Caves à vin</a></li>
        <li><a href="escalier-beton.php">Escalier béton</a></li>
        <li><a href="beton-imprime.php">Finitions de qualité</a></li>
      </ul>
    </li>
    <li><a href="#realisations">Réalisations</a></li>
    <li><a href="galerie.php">Galerie</a></li>
    <li><a href="#process">Méthode</a></li>
    <li><a href="#about">À propos</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
</nav>


<!-- ═══════════════════════════════════════════
     PAGE ACCUEIL
═══════════════════════════════════════════ -->
<div id="page-home" class="page active">

  <!-- HERO -->
  <section class="hero">
    <div class="hero-bg" style="background-image:url('<?= e($hero['image'] ?? '') ?>')"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <img class="hero-logo" src="<?= e($logo) ?>" alt="Logo B&amp;A Construction"/>
      <p class="hero-eyebrow"><?= e($hero['eyebrow'] ?? '') ?></p>
      <h1>B<em>&amp;</em>A<br>Construction</h1>
      <p class="hero-names"><?= e($hero['names'] ?? '') ?></p>
      <p class="hero-sub"><?= e($hero['sub'] ?? '') ?></p>
      <div class="hero-cta">
        <a href="#realisations" class="btn-primary"><?= e($hero['ctaPrimary'] ?? '') ?></a>
        <a href="#contact" class="btn-outline"><?= e($hero['ctaSecondary'] ?? '') ?></a>
      </div>
    </div>
    <div class="scroll-hint"><span>Découvrir</span><div class="scroll-line"></div></div>
  </section>

  <!-- SERVICES -->
  <section id="services">
    <p class="section-label"><?= e($serv['label'] ?? '') ?></p>
    <h2 class="section-title"><?= ml($serv['title'] ?? '') ?></h2>
    <p class="services-intro"><?= e($serv['intro'] ?? '') ?></p>
    <div class="services-grid">
      <?php foreach (($serv['items'] ?? []) as $it): ?>
        <?php $f = $it['filter'] ?? ''; ?>
      <div class="service-card<?= $f ? ' is-link' : '' ?>"
           <?php if ($f): ?>data-cat="<?= e($f) ?>"<?php endif; ?>>
        <img src="<?= e($it['icon'] ?? '') ?>" style="width:50px;height:50px" loading="lazy" alt="<?= e($it['title'] ?? '') ?>">
        <h3><?= e($it['title'] ?? '') ?></h3>
        <p><?= e($it['text'] ?? '') ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- HAUT DE GAMME -->
  <section id="hautdegamme">
    <p class="section-label"><?= e($hdg['label'] ?? '') ?></p>
    <h2 class="section-title"><?= ml($hdg['title'] ?? '') ?></h2>
    <p class="hdg-intro"><?= e($hdg['intro'] ?? '') ?></p>
    <div class="hdg-grid">
      <?php foreach (($hdg['items'] ?? []) as $it): ?>
      <a class="hdg-card" href="<?= e($it['link'] ?? '#') ?>">
        <img src="<?= e($it['image'] ?? '') ?>" loading="lazy" alt="<?= e($it['title'] ?? '') ?>">
        <div class="hdg-overlay">
          <h3><?= e($it['title'] ?? '') ?></h3>
          <p><?= e($it['text'] ?? '') ?></p>
          <span class="hdg-cta">Découvrir <span aria-hidden="true">&rarr;</span></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- RÉALISATIONS (preview) -->
  <section id="realisations">
    <p class="section-label"><?= e($real['label'] ?? '') ?></p>
    <h2 class="section-title"><?= ml($real['title'] ?? '') ?></h2>
    <p class="section-desc"><?= e($real['desc'] ?? '') ?></p>
    <a class="gallery-link-banner" href="galerie.php">
      <span class="gallery-link-text"><?= e($real['bannerText'] ?? '') ?></span>
      <span class="gallery-link-sub"><?= e($real['bannerSub'] ?? '') ?></span>
    </a>
    <div class="gallery-grid gallery-preview">
      <?php foreach ($preview as $g): ?>
      <div class="gallery-item" data-src="<?= e($g['full'] ?? '') ?>" data-category="<?= e(implode(' ', $g['categories'] ?? ($g['category'] ? [$g['category']] : []))) ?>">
        <img src="<?= e($g['thumb'] ?? ($g['full'] ?? '')) ?>" alt="<?= e($g['caption'] ?? '') ?>" loading="lazy" width="600" height="450">
        <div class="gallery-caption"><span><?= e($g['caption'] ?? '') ?></span></div>
        <div class="preview-overlay">
          <button type="button" class="preview-cta">Voir la galerie <span class="arrow" aria-hidden="true">&rarr;</span></button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- PROCESS -->
  <section id="process">
    <p class="section-label"><?= e($proc['label'] ?? '') ?></p>
    <h2 class="section-title"><?= ml($proc['title'] ?? '') ?></h2>
    <div class="process-steps">
      <?php foreach (($proc['steps'] ?? []) as $st): ?>
      <div class="process-step"><div class="step-num"><?= e($st['num'] ?? '') ?></div><h3><?= e($st['title'] ?? '') ?></h3><p><?= e($st['text'] ?? '') ?></p></div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ABOUT -->
  <section id="about">
    <div class="about-img-wrap">
      <img src="<?= e($about['image'] ?? '') ?>" loading="lazy" alt="Équipe B&amp;A Construction au travail">
      <div class="about-badge"><strong><?= e($about['badgeNum'] ?? '') ?></strong><span><?= e($about['badgeLabel'] ?? '') ?></span></div>
    </div>
    <div class="about-text">
      <p class="section-label"><?= e($about['label'] ?? '') ?></p>
      <h2 class="section-title"><?= ml($about['title'] ?? '') ?></h2>
      <p class="section-desc" style="color:var(--brown);max-width:470px"><?= e($about['p1'] ?? '') ?></p>
      <p class="section-desc" style="color:var(--brown);max-width:470px;margin-top:14px;font-size:.9rem"><?= e($about['p2'] ?? '') ?></p>
      <div class="about-names">
        <?php foreach (($about['people'] ?? []) as $p): ?>
        <div class="about-name-card"><strong><?= e($p['name'] ?? '') ?></strong><span><?= e($p['role'] ?? '') ?></span></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <div id="stats">
    <?php foreach ($stats as $s): ?>
    <div class="stat"><div class="stat-num"><?= e($s['num'] ?? '') ?></div><div class="stat-label"><?= e($s['label'] ?? '') ?></div></div>
    <?php endforeach; ?>
  </div>

  <!-- CONTACT -->
  <section id="contact">
    <div class="contact-wrap">
      <div>
        <p class="section-label"><?= e($contact['label'] ?? '') ?></p>
        <h2 class="section-title"><?= ml($contact['title'] ?? '') ?></h2>
        <p class="section-desc"><?= e($contact['desc'] ?? '') ?></p>
        <div class="contact-info">
          <div class="contact-item"><span class="contact-icon">📞</span><div><strong>Téléphone</strong><p><?= e($contact['phone1'] ?? '') ?><br><?= e($contact['phone2'] ?? '') ?></p></div></div>
          <div class="contact-item"><span class="contact-icon">📧</span><div><strong>E-mail</strong><p><?= e($contact['email'] ?? '') ?></p></div></div>
          <div class="contact-item"><span class="contact-icon">📍</span><div><strong>Zone d'intervention</strong><p><?= ml($contact['zone'] ?? '') ?></p></div></div>
        </div>
      </div>
      <form class="contact-form" onsubmit="return false">
        <div class="form-row">
          <input type="text" placeholder="Prénom"/>
          <input type="text" placeholder="Nom"/>
        </div>
        <input type="email" placeholder="Adresse e-mail"/>
        <input type="tel" placeholder="Téléphone"/>
        <select><option value="" disabled selected>Type de projet</option><option>Terrasse béton imprimé</option><option>Plage de piscine</option><option>Allée béton désactivé</option><option>Béton ciré</option><option>Gros œuvre / Dalle</option><option>Autre</option></select>
        <textarea placeholder="Décrivez votre projet (surface, délais, contraintes…)"></textarea>
        <button type="submit" class="btn-primary">Envoyer ma demande →</button>
      </form>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-brand">
      <div class="footer-logo-circle">B&amp;A</div>
      <div><strong>B&amp;A Construction</strong><p>Bruno Salgado · Alex Freitas</p></div>
    </div>
    <p class="footer-copy">© <?= date('Y') ?> B&amp;A Construction — Tous droits réservés</p>
  </footer>

</div><!-- /page-home -->


<!-- La galerie complète est désormais une page distincte : galerie.php -->

</div>

<script>
/* ── Aperçu "Réalisations" → page galerie ──
   Les 3 vignettes de l'accueil et la bannière mènent vers galerie.php.
   Si la vignette a une catégorie, on ouvre la galerie pré-filtrée dessus. */
function goToGallery(category) {
  const first = (category || '').trim().split(/\s+/)[0] || '';
  window.location.href = 'galerie.php' + (first ? '?cat=' + encodeURIComponent(first) : '');
}

(function(){
  const previews = document.querySelectorAll('.gallery-preview .gallery-item');

  previews.forEach(item => {
    const cta = item.querySelector('.preview-cta');
    let touched = false;   // un tap tactile vient d'avoir lieu sur cette vignette

    // Le bouton navigue toujours (souris et tactile).
    if (cta) {
      cta.addEventListener('click', e => {
        e.stopPropagation();
        goToGallery(item.dataset.category);
      });
    }

    // ── Souris / stylet : survol simulé en JS (pas de :hover CSS). ──
    item.addEventListener('pointerenter', e => {
      if (e.pointerType !== 'touch') item.classList.add('is-hover');
    });
    item.addEventListener('pointerleave', () => item.classList.remove('is-hover'));
    item.addEventListener('click', e => {
      if (touched) return;                            // tap tactile déjà traité
      if (e.target.closest('.preview-cta')) return;   // géré par le bouton
      goToGallery(item.dataset.category);             // souris : clic vignette → galerie
    });

    // ── Tactile : tap révèle / re-tap referme / tap sur le bouton navigue. ──
    let sx = 0, sy = 0, moved = false;
    item.addEventListener('touchstart', e => {
      const t = e.touches[0]; sx = t.clientX; sy = t.clientY; moved = false;
    }, {passive:true});
    item.addEventListener('touchmove', e => {
      const t = e.touches[0];
      if (Math.abs(t.clientX - sx) > 8 || Math.abs(t.clientY - sy) > 8) moved = true;
    }, {passive:true});
    item.addEventListener('touchend', e => {
      if (moved) return;                              // c'était un défilement
      touched = true; setTimeout(() => { touched = false; }, 700);
      e.preventDefault();                             // tue le ghost-click + le survol fantôme
      item.classList.remove('is-hover');
      if (e.target.closest('.preview-cta')) { goToGallery(item.dataset.category); return; }
      const open = item.classList.contains('is-revealed');
      previews.forEach(p => p.classList.remove('is-revealed'));
      if (!open) item.classList.add('is-revealed');
    }, {passive:false});
  });

  // Un tap/clic en dehors d'une vignette referme l'overlay tactile.
  document.addEventListener('click', e => {
    if (!e.target.closest('.gallery-preview .gallery-item')) {
      previews.forEach(p => p.classList.remove('is-revealed'));
    }
  });
})();
(function(){
  const cards = document.querySelectorAll('.service-card.is-link');

  cards.forEach(card => {
    const cat = card.dataset.cat;
    let touched = false;   // un tap tactile vient d'avoir lieu

    // ── Souris : survol simulé + clic = lien direct ──
    card.addEventListener('pointerenter', e => {
      if (e.pointerType !== 'touch') card.classList.add('is-hover');
    });
    card.addEventListener('pointerleave', () => card.classList.remove('is-hover'));
    card.addEventListener('click', () => {
      if (touched) return;        // tap tactile déjà traité
      goToGallery(cat);           // souris : 1 clic suffit
    });

    // ── Tactile : 1er tap révèle, 2e tap navigue ──
    let sx = 0, sy = 0, moved = false;
    card.addEventListener('touchstart', e => {
      const t = e.touches[0]; sx = t.clientX; sy = t.clientY; moved = false;
    }, {passive:true});
    card.addEventListener('touchmove', e => {
      const t = e.touches[0];
      if (Math.abs(t.clientX - sx) > 8 || Math.abs(t.clientY - sy) > 8) moved = true;
    }, {passive:true});
    card.addEventListener('touchend', e => {
      if (moved) return;                          // c'était un défilement
      touched = true; setTimeout(() => { touched = false; }, 700);
      e.preventDefault();                         // tue le ghost-click + le survol fantôme
      const open = card.classList.contains('is-revealed');
      cards.forEach(c => c.classList.remove('is-revealed'));
      if (open) goToGallery(cat);                 // 2e tap → lien
      else      card.classList.add('is-revealed');// 1er tap → révèle
    }, {passive:false});
  });

  // Un tap en dehors d'une carte referme la révélation tactile.
  document.addEventListener('click', e => {
    if (!e.target.closest('.service-card.is-link')) {
      cards.forEach(c => c.classList.remove('is-revealed'));
    }
  });
})();
(function(){
  const nav = document.getElementById('main-nav');
  const toggle = document.getElementById('navToggle');
  if (!nav || !toggle) return;
  toggle.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
  });
  nav.querySelectorAll('.nav-links a').forEach(a =>
    a.addEventListener('click', () => {
      nav.classList.remove('open');
      toggle.setAttribute('aria-expanded','false');
    }));
})();
</script>
</body>
</html>
