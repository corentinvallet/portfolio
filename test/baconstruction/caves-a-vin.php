<?php
/* ═══════════════════════════════════════════════════════════
   B&A Construction — page "Haut de gamme" : Caves à vin
   Rendu serveur depuis content.json (clé "caveavin")
═══════════════════════════════════════════════════════════ */
$c = json_decode(@file_get_contents(__DIR__ . '/content.json'), true) ?: [];

function e($s) { return htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8'); }
function ml($s) { return nl2br(htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8')); }

$d       = $c['caveavin'] ?? [];
$contact = $c['contact']  ?? [];
$logo    = $c['logo']     ?? 'Photos/Logo simplifié.webp';
$gallery = array_values(array_filter($c['gallery'] ?? [], fn($g) => in_array('cave-a-vin', $g['categories'] ?? ($g['category'] ? [$g['category']] : []), true)));

$PAGE_LABEL = 'Haut de gamme';
$PAGE_TITLE = 'Caves à <em>vin</em>';
$PAGE_INTRO = "Une cave à vin souterraine, créée sur mesure sous votre habitation.";
$PAGE_DESCRIPTION = "Cave à vin souterraine sur mesure en Drôme-Ardèche : B&A Construction creuse et aménage votre cave enterrée, fraîcheur naturelle garantie. Devis gratuit.";
$CTA_TYPE   = 'Cave à vin';
$GALLERY_CAT = 'cave-a-vin';
$GALLERY_TITLE = 'Nos caves à vins en images';
$SELF = 'caves-a-vin.php';
include __DIR__ . '/_hautdegamme-template.php';
