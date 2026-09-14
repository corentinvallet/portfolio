<?php
/* ═══════════════════════════════════════════════════════════
   Fonctions partagées — Club Œnologie Découvertes
═══════════════════════════════════════════════════════════ */

// échappe le texte simple
function e($s) { return htmlspecialchars((string)($s ?? ''), ENT_QUOTES, 'UTF-8'); }

// échappe + conserve les retours à la ligne (saut de ligne -> <br>)
function ml($s) { return nl2br(e($s)); }

// échappe + convertit *mot* en <em>mot</em> (emphase légère, éditable depuis l'admin)
function emph($s) {
  $out = e($s);
  return preg_replace('/\*(.+?)\*/', '<em>$1</em>', $out);
}

// charge content.json une seule fois
function load_content() {
  static $c = null;
  if ($c === null) {
    $c = json_decode(@file_get_contents(__DIR__ . '/../content.json'), true) ?: [];
  }
  return $c;
}
/* Applique des transformations Cloudinary à une URL.
   Si l'URL n'est pas Cloudinary (fichier local), la renvoie inchangée. */
function cl_tr($url, $tr) {
  $url = (string)($url ?? '');
  if ($url === '') return '';
  if (strpos($url, 'res.cloudinary.com') === false) return $url;
  return preg_replace('#/upload/#', '/upload/' . $tr . '/', $url, 1);
}

// normalise une chaîne pour comparaison (minuscule, sans accents, sans ponctuation)
function svc_norm($s) {
  $s = mb_strtolower((string)($s ?? ''), 'UTF-8');
  $s = strtr($s, [
    'à'=>'a','â'=>'a','ä'=>'a',
    'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
    'î'=>'i','ï'=>'i',
    'ô'=>'o','ö'=>'o',
    'ù'=>'u','û'=>'u','ü'=>'u',
    'ç'=>'c',
  ]);
  return preg_replace('/[^a-z0-9]/', '', $s);
}

// compte, pour chaque slug de la carte des vignobles, le nombre d'exposants
// dont le champ "region" correspond (comparaison normalisée, en "contient")
function svc_region_counts($exposants, $slugs) {
  $normRegions = [];
  foreach ($exposants as $ex) {
    if (!empty($ex['region'])) $normRegions[] = svc_norm($ex['region']);
  }
  $counts = [];
  foreach ($slugs as $slug) {
    $slugNorm = svc_norm($slug);
    $n = 0;
    foreach ($normRegions as $r) {
      if ($slugNorm !== '' && strpos($r, $slugNorm) !== false) $n++;
    }
    $counts[$slug] = $n;
  }
  return $counts;
}