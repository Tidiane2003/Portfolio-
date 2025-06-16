<?php
// -----------------------------------------------------------------------------
// contact.php – Traitement AJAX du formulaire « Contact »
// Reçoit email + message et renvoie un JSON {success: bool, message: string}
// -----------------------------------------------------------------------------

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405); // Méthode non autorisée
  echo json_encode([
    'success' => false,
    'message' => 'Méthode non autorisée.'
  ]);
  exit;
}

// --- Nettoyage & validation ---------------------------------------------------
$email   = filter_var($_POST['email']   ?? '', FILTER_SANITIZE_EMAIL);
$message = trim(htmlspecialchars($_POST['message'] ?? ''));

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
  echo json_encode([
    'success' => false,
    'message' => 'Email invalide ou message vide.'
  ]);
  exit;
}

// --- Envoi de l'e‑mail --------------------------------------------------------
$to      = 'mbowtidiane013@gmail.com'; // 👉 Remplace par ton adresse
$subject = 'Message depuis le portfolio';
$headers = 'From: '.$email."\r\n".
           'Reply-To: '.$email."\r\n".
           "Content-Type: text/plain; charset=utf-8";

if (mail($to, $subject, $message, $headers)) {
  echo json_encode([
    'success' => true,
    'message' => 'Message envoyé avec succès !'
  ]);
  exit;
}

// --- Échec --------------------------------------------------------------------
echo json_encode([
  'success' => false,
  'message' => 'Erreur lors de l\'envoi. Merci de réessayer plus tard.'
]);
exit;
?>

