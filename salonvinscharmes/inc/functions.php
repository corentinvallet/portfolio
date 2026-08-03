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
