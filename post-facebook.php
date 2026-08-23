<?php
/* =====================================================================
   post-facebook.php — Publie un article de blog sur la Page Facebook
   --------------------------------------------------------------------
   Appelé par l'admin (uniquement) quand la case "Publier aussi sur
   Facebook" est cochée en enregistrant un article.

   INSTALLATION
   1. Déposez ce fichier à la racine du site, à côté de save-blog.php.
   2. Remplissez FB_PAGE_ID et FB_PAGE_TOKEN ci-dessous (voir le guide
      pour les obtenir : developers.facebook.com > votre app > Graph API
      Explorer > générer un token de Page longue durée).
   3. Le token admin ci-dessous doit être identique à SAVE_TOKEN dans
      /admin/index.html.

   Ce fichier ne fait rien tant que FB_PAGE_ID / FB_PAGE_TOKEN ne sont
   pas renseignés — il renvoie juste une erreur explicite.
   ===================================================================== */

header('Content-Type: application/json; charset=utf-8');

// >>> À PERSONNALISER <<< (même valeur que SAVE_TOKEN dans /admin/index.html)
$ADMIN_TOKEN = 'pigzefi86123!:;AZE';

// >>> À PERSONNALISER <<< (voir instructions ci-dessus)
$FB_PAGE_ID    = '';   // ex: '123456789012345'
$FB_PAGE_TOKEN = '';   // le Page Access Token longue durée

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$tok = isset($_SERVER['HTTP_X_ADMIN_TOKEN']) ? $_SERVER['HTTP_X_ADMIN_TOKEN'] : '';
if (!hash_equals($ADMIN_TOKEN, $tok)) {
    http_response_code(401);
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

if ($FB_PAGE_ID === '' || $FB_PAGE_TOKEN === '') {
    http_response_code(400);
    echo json_encode(['error' => "Publication Facebook non configurée — renseignez FB_PAGE_ID et FB_PAGE_TOKEN dans post-facebook.php."]);
    exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

$message = isset($data['message']) ? trim($data['message']) : '';
$link    = isset($data['link'])    ? trim($data['link'])    : '';

if ($message === '' || $link === '') {
    http_response_code(400);
    echo json_encode(['error' => 'message et link sont requis']);
    exit;
}

$endpoint = "https://graph.facebook.com/v21.0/{$FB_PAGE_ID}/feed";

$ch = curl_init($endpoint);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS     => http_build_query([
        'message'      => $message,
        'link'         => $link,
        'access_token' => $FB_PAGE_TOKEN,
    ]),
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($curlErr) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur cURL : ' . $curlErr]);
    exit;
}

$result = json_decode($response, true);

if ($httpCode >= 200 && $httpCode < 300 && isset($result['id'])) {
    echo json_encode(['ok' => true, 'fb_post_id' => $result['id']]);
} else {
    http_response_code(502);
    $fbError = isset($result['error']['message']) ? $result['error']['message'] : 'Réponse Facebook inattendue';
    echo json_encode(['error' => $fbError, 'raw' => $result]);
}
