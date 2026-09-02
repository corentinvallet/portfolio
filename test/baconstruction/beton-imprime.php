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
$gallery = array_values(array_filter($c['gallery'] ?? [], fn($g) => in_array('beton-imprime', $g['categories'] ?? ($g['category'] ? [$g['category']] : []), true)));

$PAGE_LABEL = 'Haut de gamme';
$PAGE_TITLE = 'Finitions de <em>qualité</em>';
$PAGE_INTRO = "Terrasses, allées, murets et plages avec textures bois, pierre ou ardoise.";
$PAGE_DESCRIPTION = "Finitions haut de gamme en Drôme-Ardèche : béton imprimé, enduit de finition, béton ciré, terrasses, allées et plages de piscine texturées bois, pierre ou ardoise par B&A Construction. Devis gratuit.";
$CTA_TYPE   = 'Béton imprimé';
$GALLERY_CAT = 'beton-cire,beton-imprime,beton-desactive,enduit-décoratif';
$GALLERY_TITLE = 'Nos finitions en images';
$SELF = 'beton-imprime.php';
include __DIR__ . '/_hautdegamme-template.php';
