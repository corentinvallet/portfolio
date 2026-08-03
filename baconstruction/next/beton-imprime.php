<?php
/* ═══════════════════════════════════════════════════════════
   B&A Construction — page "Haut de gamme" : Béton imprimé
   Rendu serveur depuis content.json (clé "betonimprimepremium")
═══════════════════════════════════════════════════════════ */
$c = json_decode(@file_get_contents(__DIR__ . '/content.json'), true) ?: [];

function e($s) { return htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8'); }
function ml($s) { return nl2br(htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8')); }

$d       = $c['betonimprimepremium'] ?? [];
$contact = $c['contact']             ?? [];
$logo    = $c['logo']                ?? 'Photos/Logo simplifié.webp';
$gallery = array_values(array_filter($c['gallery'] ?? [], fn($g) => ($g['category'] ?? '') === 'beton-imprime'));

$PAGE_LABEL = 'Haut de gamme';
$PAGE_TITLE = 'Finitions de <em>qualité</em>';
$PAGE_INTRO = "Terrasses, allées, murets et plages avec textures bois, pierre ou ardoise.";
$CTA_TYPE   = 'Béton imprimé';
$GALLERY_CAT = 'beton-imprime';
$GALLERY_TITLE = 'Nos finitions en images';
$SELF = 'beton-imprime.php';
include __DIR__ . '/_hautdegamme-template.php';
