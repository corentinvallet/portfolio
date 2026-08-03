<?php
/* ═══════════════════════════════════════════════════════════
   B&A Construction — Galerie complète (page dédiée)
   Rendu serveur depuis content.json : Google voit toutes les
   réalisations dans le HTML. Page distincte = URL propre + SEO.
═══════════════════════════════════════════════════════════ */
$c = json_decode(@file_get_contents(__DIR__ . '/content.json'), true) ?: [];

function e($s) { return htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8'); }

$gallery    = $c['gallery'] ?? [];
$logo       = $c['logo']    ?? 'Photos/Logo simplifié.webp';
$categories = $c['categories'] ?? [
  ['value'=>'cave-a-vin','label'=>'Caves à vins'],
  ['value'=>'beton-cire','label'=>'Béton ciré'],
  ['value'=>'beton-desactive','label'=>'Béton désactivé'],
  ['value'=>'piscine','label'=>'Piscine'],
  ['value'=>'beton-imprime','label'=>'Béton imprimé'],
  ['value'=>'escalier-beton','label'=>'Escalier béton'],
];
$siteUrl = 'https://corentinvallet.fr/baconstruction';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Nos réalisations — B&amp;A Construction | Béton & caves à vin en Drôme-Ardèche</title>
  <meta name="description" content="Découvrez toutes les réalisations de B&amp;A Construction : terrasses en béton imprimé, béton ciré, béton désactivé, plages de piscine et caves à vin enterrées en Drôme et Ardèche."/>
  <link rel="canonical" href="<?= e($siteUrl) ?>/galerie.php"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet"/>
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
    .nav-logo-img{width:46px;height:46px;border-radius:50%;object-fit:cover;background:var(--accent);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:900;color:#fff;font-size:1rem;flex-shrink:0}

    /* Main nav links (home page) */
    .nav-links{display:flex;gap:28px;list-style:none}
    .nav-links a{text-decoration:none;color:var(--sand);font-size:.78rem;font-weight:500;letter-spacing:.12em;text-transform:uppercase;transition:color .25s;cursor:pointer}
    .nav-links a:hover{color:var(--accent)}

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

    /* ── GALLERY PREVIEW ── */
    #realisations{background:var(--cream)}
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
    #process{background:var(--sand)}
    .process-steps{margin-top:52px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr))}
    .process-step{padding:38px 28px;border-left:1px solid rgba(122,92,62,.25);position:relative}
    .step-num{font-family:'Playfair Display',serif;font-size:3.8rem;font-weight:900;line-height:1;color:rgba(122,92,62,.1);position:absolute;top:22px;right:18px}
    .process-step h3{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--dark-brown);margin-bottom:10px}
    .process-step p{font-size:.85rem;line-height:1.78;color:var(--brown)}

    /* ── CAVE A VIN ── */
    #caveavin{background:var(--sand);display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
    .caveavin-img-wrap{position:relative}
    .caveavin-img-wrap img{width:100%;display:block;filter:sepia(15%) contrast(1.05)}
    .caveavin-img-placeholder{width:100%;aspect-ratio:4/3;background:linear-gradient(135deg,rgba(61,43,26,.8) 0%,rgba(122,92,62,.6) 100%);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1.2rem;color:rgba(232,220,200,.3);letter-spacing:.1em;border:1px solid rgba(196,148,74,.15)}
    .caveavin-badge{position:absolute;bottom:-22px;right:-22px;width:108px;height:108px;background:var(--accent);border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center}
    .caveavin-badge strong{font-size:1rem;font-weight:500;color:#fff;line-height:1}
    .caveavin-badge span{font-size:.58rem;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.82)}
    .caveavin-text .section-title{color:var(--dark-brown)}
    .caveavin-names{margin-top:30px;display:flex;gap:28px}
    .caveavin-name-card{border-left:3px solid var(--accent);padding-left:15px}
    .caveavin-name-card strong{display:block;font-size:.98rem;color:var(--brown);font-family:'Playfair Display',serif}
    .caveavin-name-card span{font-size:.76rem;color:var(--accent);letter-spacing:.1em}

    /* ── ABOUT ── */
    #about{background:var(--dark-brown);display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
    .about-img-wrap{position:relative}
    .about-img-wrap img{width:100%;display:block;filter:sepia(15%) contrast(1.05)}
    .about-img-placeholder{width:100%;aspect-ratio:4/3;background:linear-gradient(135deg,rgba(61,43,26,.8) 0%,rgba(122,92,62,.6) 100%);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1.2rem;color:rgba(232,220,200,.3);letter-spacing:.1em;border:1px solid rgba(196,148,74,.15)}
    .about-badge{position:absolute;bottom:-22px;right:-22px;width:108px;height:108px;background:var(--accent);border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center}
    .about-badge strong{font-size:2rem;font-weight:900;color:#fff;line-height:1}
    .about-badge span{font-size:.58rem;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.82)}
    .about-text .section-title{color:var(--sand)}
    .about-names{margin-top:30px;display:flex;gap:28px}
    .about-name-card{border-left:3px solid var(--accent);padding-left:15px}
    .about-name-card strong{display:block;font-size:.98rem;color:var(--sand);font-family:'Playfair Display',serif}
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
      #caveavin{grid-template-columns:1fr;gap:50px}
      .caveavin-badge{right:0}
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
     NAVIGATION
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
    <li><a href="index.php#services">Services</a></li>
    <li class="has-dropdown">
      <a href="index.php#hautdegamme">Haut de gamme</a>
      <ul class="dropdown">
        <li><a href="caves-a-vin.php">Caves à vin</a></li>
        <li><a href="escalier-beton.php">Escalier béton</a></li>
        <li><a href="beton-imprime.php">Finitions de qualité</a></li>
      </ul>
    </li>
    <li><a href="index.php#realisations">Réalisations</a></li>
    <li><a href="galerie.php">Galerie</a></li>
    <li><a href="index.php#process">Méthode</a></li>
    <li><a href="index.php#about">À propos</a></li>
    <li><a href="index.php#contact">Contact</a></li>
  </ul>
</nav>

<!-- ═══════════════════════════════════════════
     EN-TÊTE GALERIE
═══════════════════════════════════════════ -->
<div class="page-header">
  <p class="section-label">Portfolio complet</p>
  <h1>Nos <em>réalisations</em></h1>
  <p>Parcourez l'ensemble de nos projets. Filtrez par type de prestation pour trouver l'inspiration pour votre chantier.</p>
</div>

<!-- ═══════════════════════════════════════════
     GALERIE FILTRABLE
═══════════════════════════════════════════ -->
<div class="gallery-section">
  <div class="gallery-filters">
    <button class="filter-btn active" data-filter="all">Tous</button>
    <?php foreach ($categories as $cat): ?>
    <button class="filter-btn" data-filter="<?= e($cat['value'] ?? '') ?>"><?= e($cat['label'] ?? '') ?></button>
    <?php endforeach; ?>
  </div>

  <p class="gallery-count" id="gallery-count"><?= count($gallery) ?> réalisations</p>

  <div class="gallery-full-grid" id="gallery-grid">
    <?php foreach ($gallery as $g): ?>
    <div class="gallery-item" data-src="<?= e($g['full'] ?? '') ?>" data-category="<?= e($g['category'] ?? '') ?>">
      <img src="<?= e($g['thumb'] ?? ($g['full'] ?? '')) ?>" alt="<?= e($g['caption'] ?? '') ?>" loading="lazy" width="600" height="450">
      <div class="gallery-caption"><span><?= e($g['caption'] ?? '') ?></span><?php if (!empty($g['sub'])): ?><em><?= e($g['sub']) ?></em><?php endif; ?></div>
    </div>
    <?php endforeach; ?>
    <div class="gallery-empty" id="gallery-empty">Aucune réalisation dans cette catégorie pour le moment.</div>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer-brand">
    <div class="footer-logo-circle">B&amp;A</div>
    <div><strong>B&amp;A Construction</strong><p>Bruno Salgado · Alex Freitas</p></div>
  </div>
  <p class="footer-copy">© <?= date('Y') ?> B&amp;A Construction — Tous droits réservés</p>
</footer>

<!-- ═══════════════════════════════════════════
     LIGHTBOX
═══════════════════════════════════════════ -->
<div id="lightbox" role="dialog" aria-modal="true" aria-label="Image agrandie">
  <div class="lb-stage" id="lb-stage"></div>
  <button id="lb-close" title="Fermer (Échap)">✕</button>
  <button class="lb-btn" id="lb-prev" title="Précédent (←)">&#8592;</button>
  <button class="lb-btn" id="lb-next" title="Suivant (→)">&#8594;</button>
  <div id="lb-counter"></div>
  <div class="lb-zoom-hint" id="lb-zoom-hint">🔍 Clic pour zoomer · Molette pour zoomer · Glisser pour naviguer</div>
  <div class="lb-bar">
    <div class="lb-caption" id="lb-caption"></div>
    <div class="lb-hint">Échap pour fermer</div>
  </div>
</div>
<script>
/* ── Filtre galerie (+ pré-filtrage via ?cat= dans l'URL) ── */
(function(){
  const btns  = document.querySelectorAll('.filter-btn');
  const items = document.querySelectorAll('#gallery-grid .gallery-item[data-category]');
  const count = document.getElementById('gallery-count');
  const empty = document.getElementById('gallery-empty');

  const labels = {
    'all':'réalisations',
    'cave-a-vin':'réalisation(s) – caves à vins',
    'beton-cire':'réalisation(s) en béton ciré',
    'beton-desactive':'réalisation(s) en béton désactivé',
    'piscine':'réalisation(s) piscine',
    'beton-imprime':'réalisation(s) en béton imprimé'
  };

  function updateCount(filter) {
    const n = filter === 'all'
      ? items.length
      : Array.from(items).filter(el => el.dataset.category === filter).length;
    count.textContent = n + ' ' + (labels[filter] || 'réalisations');
    empty.style.display = n === 0 ? 'block' : 'none';
  }

  function applyFilter(filter) {
    btns.forEach(b => b.classList.toggle('active', b.dataset.filter === filter));
    items.forEach(item => {
      item.classList.toggle('hidden', filter !== 'all' && item.dataset.category !== filter);
    });
    updateCount(filter);
  }

  btns.forEach(btn => {
    btn.addEventListener('click', function() { applyFilter(this.dataset.filter); });
  });

  // Catégorie passée par l'URL (clic sur une vignette de l'accueil) -> on filtre d'emblee.
  const wanted = new URLSearchParams(location.search).get('cat');
  const valid  = wanted && Array.from(btns).some(b => b.dataset.filter === wanted);
  applyFilter(valid ? wanted : 'all');
})();

/* ===========================================
   LIGHTBOX - zoom + navigation + glisser
=========================================== */
(function(){
  const lb       = document.getElementById('lightbox');
  const stage    = document.getElementById('lb-stage');
  const caption  = document.getElementById('lb-caption');
  const counter  = document.getElementById('lb-counter');
  const closeBtn = document.getElementById('lb-close');
  const prevBtn  = document.getElementById('lb-prev');
  const nextBtn  = document.getElementById('lb-next');

  let items = [];
  let idx   = 0;
  let scale = 1;
  let tx = 0, ty = 0;
  let dragging = false, startX = 0, startY = 0, lastTx = 0, lastTy = 0;

  function collectItems() {
    return Array.from(document.querySelectorAll('.gallery-item:not(.hidden)'));
  }

  function openLightbox(item, list) {
    items = list;
    idx   = items.indexOf(item);
    render();
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    lb.classList.remove('open');
    document.body.style.overflow = '';
    resetZoom();
  }

  function render() {
    resetZoom();
    const item = items[idx];
    if (!item) return;

    const captSpan = item.querySelector('.gallery-caption span');
    const captEm   = item.querySelector('.gallery-caption em');
    caption.innerHTML = (captSpan ? `<span>${captSpan.textContent}</span>` : '') +
                        (captEm   ? `<em>${captEm.textContent}</em>`       : '');
    counter.textContent = (idx + 1) + ' / ' + items.length;

    const fullSrc = item.dataset.src;
    const img     = item.querySelector('img');
    const src     = fullSrc || (img ? img.src : null);
    const alt     = img ? (img.alt || '') : '';
    if (src) {
      stage.innerHTML = `<img class="lb-img" src="${src}" alt="${alt}" draggable="false" style="opacity:0;transition:opacity .3s ease"/>`;
      const lbImg = stage.querySelector('.lb-img');
      lbImg.onload = () => { lbImg.style.opacity = '1'; };
    } else {
      stage.innerHTML = `
        <div class="lb-placeholder">
          <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <span>Photo à venir</span>
        </div>`;
    }
    prevBtn.style.opacity = idx === 0 ? '0.2' : '1';
    nextBtn.style.opacity = idx === items.length - 1 ? '0.2' : '1';

    bindZoom();
  }

  function prev() { if (idx > 0) { idx--; render(); } }
  function next() { if (idx < items.length - 1) { idx++; render(); } }

  function resetZoom() {
    scale = 1; tx = 0; ty = 0;
    stage.classList.remove('zoomed');
    applyTransform();
  }

  function applyTransform() {
    const el = stage.querySelector('.lb-img');
    if (!el) return;
    el.style.transform = `scale(${scale}) translate(${tx/scale}px, ${ty/scale}px)`;
  }

  function bindZoom() {
    const el = stage.querySelector('.lb-img');
    if (!el) return;

    stage.addEventListener('dblclick', function(e) {
      e.stopPropagation();
      if (scale > 1) { resetZoom(); }
      else           { zoomAt(e.clientX, e.clientY, 2.5); }
    });

    stage.addEventListener('click', function(e) {
      if (!stage.classList.contains('zoomed') && !dragging) {
        zoomAt(e.clientX, e.clientY, 2.5);
      }
    });
  }

  function zoomAt(cx, cy, targetScale) {
    const rect = stage.getBoundingClientRect();
    const ox = cx - rect.left - rect.width / 2;
    const oy = cy - rect.top  - rect.height / 2;
    scale = targetScale;
    tx = -ox * (scale - 1);
    ty = -oy * (scale - 1);
    stage.classList.add('zoomed');
    applyTransform();
  }

  stage.addEventListener('wheel', function(e) {
    e.preventDefault();
    const delta = e.deltaY > 0 ? -0.3 : 0.3;
    const newScale = Math.max(1, Math.min(5, scale + delta));
    if (newScale === 1) { resetZoom(); return; }
    const rect  = stage.getBoundingClientRect();
    const ox    = e.clientX - rect.left - rect.width  / 2;
    const oy    = e.clientY - rect.top  - rect.height / 2;
    const ratio = newScale / scale;
    tx = tx * ratio + ox * (1 - ratio);
    ty = ty * ratio + oy * (1 - ratio);
    scale = newScale;
    stage.classList.toggle('zoomed', scale > 1);
    applyTransform();
  }, {passive: false});

  stage.addEventListener('mousedown', function(e) {
    if (scale <= 1) return;
    dragging = true;
    startX = e.clientX - tx;
    startY = e.clientY - ty;
    lastTx = tx; lastTy = ty;
    e.preventDefault();
  });
  window.addEventListener('mousemove', function(e) {
    if (!dragging) return;
    tx = e.clientX - startX;
    ty = e.clientY - startY;
    applyTransform();
  });
  window.addEventListener('mouseup', function() { dragging = false; });

  let lastDist    = 0;
  let pinching    = false;
  let lastTapTime = 0;
  let touchStartX = 0, touchStartY = 0;
  let touchMoved  = false;

  stage.addEventListener('touchstart', function(e) {
    const ts = e.touches;
    if (ts.length === 2) {
      pinching = true;
      dragging = false;
      lastDist = Math.hypot(ts[1].clientX - ts[0].clientX, ts[1].clientY - ts[0].clientY);
    } else if (ts.length === 1) {
      pinching    = false;
      touchMoved  = false;
      touchStartX = ts[0].clientX;
      touchStartY = ts[0].clientY;
      if (scale > 1) {
        dragging = true;
        startX = ts[0].clientX - tx;
        startY = ts[0].clientY - ty;
      } else {
        dragging = false;
      }
    }
    e.preventDefault();
  }, {passive: false});

  stage.addEventListener('touchmove', function(e) {
    const ts = e.touches;
    e.preventDefault();

    if (ts.length === 2) {
      const dist     = Math.hypot(ts[1].clientX - ts[0].clientX, ts[1].clientY - ts[0].clientY);
      const ratio    = dist / lastDist;
      const newScale = Math.max(1, Math.min(5, scale * ratio));
      const cx = (ts[0].clientX + ts[1].clientX) / 2;
      const cy = (ts[0].clientY + ts[1].clientY) / 2;
      const rect = stage.getBoundingClientRect();
      const ox   = cx - rect.left - rect.width  / 2;
      const oy   = cy - rect.top  - rect.height / 2;
      const sr   = newScale / scale;
      tx = tx * sr + ox * (1 - sr);
      ty = ty * sr + oy * (1 - sr);
      scale = newScale;
      lastDist = dist;
      stage.classList.toggle('zoomed', scale > 1);
      applyTransform();
      touchMoved = true;
    } else if (ts.length === 1) {
      const dx = ts[0].clientX - touchStartX;
      const dy = ts[0].clientY - touchStartY;
      if (Math.abs(dx) > 5 || Math.abs(dy) > 5) touchMoved = true;
      if (dragging && scale > 1) {
        tx = ts[0].clientX - startX;
        ty = ts[0].clientY - startY;
        applyTransform();
      }
    }
  }, {passive: false});

  stage.addEventListener('touchend', function(e) {
    const ts = e.changedTouches;
    pinching = false;
    dragging = false;

    if (!touchMoved && ts.length === 1) {
      const now = Date.now();
      if (now - lastTapTime < 300) {
        lastTapTime = 0;
        if (scale > 1) { resetZoom(); }
        else           { zoomAt(ts[0].clientX, ts[0].clientY, 2.5); }
        return;
      }
      lastTapTime = now;
    }

    if (scale <= 1 && touchMoved && ts.length === 1) {
      const dx = ts[0].clientX - touchStartX;
      const dy = ts[0].clientY - touchStartY;
      if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy) * 1.5) {
        dx < 0 ? next() : prev();
      }
    }

    if (scale <= 1) resetZoom();
  }, {passive: false});

  document.addEventListener('keydown', function(e) {
    if (!lb.classList.contains('open')) return;
    if (e.key === 'Escape')           closeLightbox();
    else if (e.key === 'ArrowLeft')   prev();
    else if (e.key === 'ArrowRight')  next();
    else if (e.key === '+' || e.key === '=') { scale = Math.min(5, scale + 0.5); stage.classList.add('zoomed'); applyTransform(); }
    else if (e.key === '-')           { scale = Math.max(1, scale - 0.5); if (scale === 1) resetZoom(); else applyTransform(); }
  });

  lb.addEventListener('click', function(e) {
    if (e.target === lb) closeLightbox();
  });
  closeBtn.addEventListener('click', closeLightbox);
  prevBtn.addEventListener('click', function(e){ e.stopPropagation(); prev(); });
  nextBtn.addEventListener('click', function(e){ e.stopPropagation(); next(); });

  document.addEventListener('click', function(e) {
    const item = e.target.closest('.gallery-item');
    if (!item || lb.classList.contains('open')) return;
    if (e.target.closest('#lightbox')) return;
    const list = collectItems();
    openLightbox(item, list);
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
