<?php
/* ═══════════════════════════════════════════════════════════
   envoi-contact.php — traite le formulaire de contact
   ───────────────────────────────────────────────────────────
   Envoi direct par PHPMailer en SMTP (compte mail Hostinger
   corentinvallet.fr), sans application tierce. Le destinataire
   est modifiable depuis l'admin (content.json > contact.emailDestinataire).
═══════════════════════════════════════════════════════════ */

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit(json_encode(['ok' => false, 'error' => 'Méthode non autorisée. Utilisez POST.']));
}

require __DIR__ . '/inc/phpmailer/Exception.php';
require __DIR__ . '/inc/phpmailer/PHPMailer.php';
require __DIR__ . '/inc/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* ─── Configuration SMTP (compte mail Hostinger corentinvallet.fr) ─── */
const SMTP_HOST      = 'smtp.hostinger.com';
const SMTP_PORT      = 465;
const SMTP_USER      = 'contact@corentinvallet.fr';
const SMTP_PASS      = 'w^&D#7Q3NMUjWHnh1^v&';
const SMTP_FROM      = SMTP_USER;
const SMTP_FROM_NAME = 'B&A Construction — Site web';

/* ─── Destinataire (géré depuis l'admin) ──────────────────────────── */
$content = json_decode(@file_get_contents(__DIR__ . '/content.json'), true) ?: [];
$to = trim($content['contact']['emailDestinataire'] ?? '');
if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit(json_encode(['ok' => false, 'error' => "Aucune adresse de destination n'est configurée. Contactez l'administrateur du site."]));
}

/* ─── Lecture et validation des champs ────────────────────────────── */
$prenom  = trim($_POST['prenom'] ?? '');
$nom     = trim($_POST['nom'] ?? '');
$email   = trim($_POST['email'] ?? '');
$tel     = trim($_POST['telephone'] ?? '');
$type    = trim($_POST['type_projet'] ?? '');
$message = trim($_POST['message'] ?? '');
$gotcha  = trim($_POST['_gotcha'] ?? '');

// honeypot : un bot a rempli le champ invisible -> on fait "comme si" ça avait marché
if ($gotcha !== '') {
  echo json_encode(['ok' => true]);
  exit;
}

$errors = [];
if ($prenom === '')                                               $errors[] = "Le prénom est requis.";
if ($nom === '')                                                   $errors[] = "Le nom est requis.";
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL))  $errors[] = "L'adresse email est invalide.";

if ($errors) {
  http_response_code(400);
  exit(json_encode(['ok' => false, 'error' => implode(' ', $errors)]));
}

/* ─── Envoi via PHPMailer ──────────────────────────────────────────── */
$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host       = SMTP_HOST;
  $mail->SMTPAuth   = true;
  $mail->Username   = SMTP_USER;
  $mail->Password   = SMTP_PASS;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL, port 465
  $mail->Port       = SMTP_PORT;
  $mail->CharSet    = 'UTF-8';

  $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
  $mail->addAddress($to);
  $mail->addReplyTo($email, trim("$prenom $nom"));

  $mail->Subject = "Nouvelle demande de devis — B&A Construction";
  $mail->Body    = "Nouvelle demande de contact\n\n"
                  . "Nom : $prenom $nom\n"
                  . "Email : $email\n"
                  . "Téléphone : " . ($tel !== '' ? $tel : '—') . "\n"
                  . "Type de projet : " . ($type !== '' ? $type : '—') . "\n\n"
                  . "Message :\n" . ($message !== '' ? $message : '—');

  $mail->send();
  echo json_encode(['ok' => true]);

} catch (Exception $e) {
  error_log('Erreur envoi envoi-contact.php : ' . $mail->ErrorInfo);
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => "Une erreur est survenue lors de l'envoi. Merci de réessayer plus tard."]);
}