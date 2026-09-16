<?php
/* ═══════════════════════════════════════════════════════════
   contact.php — traite le formulaire de contact du footer
   ───────────────────────────────────────────────────────────
   Route le message vers une adresse différente selon la
   catégorie choisie (Salon / Exposants / Bénévoles / Communication),
   via PHPMailer en SMTP (compte mail Hostinger du client).
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

/* ─── Configuration SMTP (compte mail Hostinger du client) ───────────
   À renseigner depuis hPanel > Emails > [adresse] > Configurer le client de messagerie.
   Hostinger fournit en général : host = smtp.hostinger.com, port 465 en SSL. */
const SMTP_HOST   = 'smtp.hostinger.com';
const SMTP_PORT   = 465;
const SMTP_USER   = 'contact@corentinvallet.fr';   // adresse mail Hostinger du client
const SMTP_PASS   = 'w^&D#7Q3NMUjWHnh1^v&';
const SMTP_FROM   = SMTP_USER;                    // l'expéditeur doit être la boîte mail elle-même
const SMTP_FROM_NAME = 'Club Œnologie Découvertes';

/* ─── Routage par catégorie ───────────────────────────────────────── */
const RECIPIENTS = [
  'Salon'         => 'contact@corentinvallet.fr',
  'Exposants'     => 'corentin.vallet234@gmail.com',
  'Bénévoles'     => 'contact@corentinvallet.fr',
  'Communication' => 'corentin.vallet234@gmail.com',
];
const DEFAULT_RECIPIENT = 'Communication'; // utilisé si le type est absent/invalide

/* ─── Lecture et validation des champs ────────────────────────────── */
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$type    = trim($_POST['type'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');
$gotcha  = trim($_POST['_gotcha'] ?? '');

// honeypot : un bot a rempli le champ invisible -> on fait "comme si" ça avait marché
if ($gotcha !== '') {
  echo json_encode(['ok' => true]);
  exit;
}

$errors = [];
if ($name === '')                                   $errors[] = "Le nom est requis.";
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "L'adresse email est invalide.";
if ($message === '')                                 $errors[] = "Le message est requis.";
if (!array_key_exists($type, RECIPIENTS))            $errors[] = "Le type de demande est invalide.";

if ($errors) {
  http_response_code(400);
  exit(json_encode(['ok' => false, 'error' => implode(' ', $errors)]));
}

$to = RECIPIENTS[$type] ?? RECIPIENTS[DEFAULT_RECIPIENT];

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
  $mail->addReplyTo($email, $name);

  $mail->Subject = "[$type] " . ($subject !== '' ? $subject : "Message depuis le site — Club Œnologie Découvertes");
  $mail->Body    = "Nouveau message ($type)\n\n"
                  . "Nom : $name\n"
                  . "Email : $email\n\n"
                  . "Message :\n$message";

  $mail->send();
  echo json_encode(['ok' => true]);

} catch (Exception $e) {
  error_log('Erreur envoi contact.php : ' . $mail->ErrorInfo);
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => "Une erreur est survenue lors de l'envoi. Merci de réessayer plus tard."]);
}
