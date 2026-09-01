<?php
/* ═══════════════════════════════════════════════════════════
   B&A Construction — page "Haut de gamme" : Escalier béton
   Rendu serveur depuis content.json (clé "escalierbeton")
═══════════════════════════════════════════════════════════ */
$c = json_decode(@file_get_contents(__DIR__ . '/content.json'), true) ?: [];

function e($s) { return htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8'); }
function ml($s) { return nl2br(htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8')); }

$d       = $c['escalierbeton'] ?? [];
$contact = $c['contact']       ?? [];
$logo    = $c['logo']          ?? 'Photos/Logo simplifié.webp';
$gallery = array_values(array_filter($c['gallery'] ?? [], fn($g) => in_array('escalier-beton', $g['categories'] ?? ($g['category'] ? [$g['category']] : []), true)));

$PAGE_LABEL = 'Haut de gamme';
$PAGE_TITLE = 'Escalier <em>béton</em>';
$PAGE_INTRO = "Un escalier en béton coulé sur mesure, structure et finitions soignées.";
$PAGE_DESCRIPTION = "Escaliers en béton coulé sur mesure par B&A Construction : ligne droite, quart tournant ou suspendu, en Drôme et Ardèche. Devis gratuit.";
$CTA_TYPE   = 'Escalier béton';
$GALLERY_CAT = 'escalier-beton';
$GALLERY_TITLE = 'Nos escaliers béton en images';
$SELF = 'escalier-beton.php';
include __DIR__ . '/_hautdegamme-template.php';
