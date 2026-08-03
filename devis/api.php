<?php
/* ---------------------------------------------------------------------------
   api.php — mini-stockage clé-valeur pour le générateur de devis
   Source de vérité : data/store.json
   À placer dans le même dossier que index.html (ex. /devis/).
   La protection par mot de passe du dossier sécurise aussi cet endpoint.
--------------------------------------------------------------------------- */

header('Content-Type: application/json; charset=utf-8');

$dataDir = __DIR__ . '/data';
$file    = $dataDir . '/store.json';

if (!is_dir($dataDir)) {
    @mkdir($dataDir, 0755, true);
}

function load_store($file) {
    if (!file_exists($file)) return array();
    $raw  = file_get_contents($file);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : array();
}

$method = $_SERVER['REQUEST_METHOD'];

/* --- Lecture --- */
if ($method === 'GET') {
    $key   = isset($_GET['key']) ? $_GET['key'] : '';
    $store = load_store($file);

    if ($key === '') {
        // Sans clé : renvoie la liste des clés (utile pour déboguer)
        echo json_encode(array('ok' => true, 'keys' => array_keys($store)));
        exit;
    }

    if (array_key_exists($key, $store)) {
        echo json_encode(array('ok' => true, 'found' => true, 'value' => $store[$key]));
    } else {
        echo json_encode(array('ok' => true, 'found' => false));
    }
    exit;
}

/* --- Écriture --- */
if ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);

    if (!is_array($body) || !isset($body['key'])) {
        http_response_code(400);
        echo json_encode(array('ok' => false, 'error' => 'Requête invalide'));
        exit;
    }

    $store = load_store($file);
    $store[$body['key']] = isset($body['value']) ? $body['value'] : '';

    // Écriture atomique : fichier temporaire + renommage
    $tmp  = $file . '.tmp';
    $json = json_encode($store, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    if (file_put_contents($tmp, $json, LOCK_EX) === false || !rename($tmp, $file)) {
        http_response_code(500);
        echo json_encode(array('ok' => false, 'error' => 'Écriture impossible (droits du dossier data/ ?)'));
        exit;
    }

    echo json_encode(array('ok' => true));
    exit;
}

http_response_code(405);
echo json_encode(array('ok' => false, 'error' => 'Méthode non autorisée'));
