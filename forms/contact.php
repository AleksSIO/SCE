<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$destinataire = 'gestion@scegroupe.com';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $alert = '';

  $email = isset($_POST['email']) ? $_POST['email'] : NULL;
  $name = isset($_POST['name']) ? $_POST['name'] : NULL;
  $subject = isset($_POST['subject']) ? $_POST['subject'] : NULL;
  $message = isset($_POST['message']) ? $_POST['message'] : NULL;

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->CharSet = 'UTF-8';
    $mail->Username = 'noreply.groupesce@gmail.com';
    $mail->Password = 'pukijzsiicdjqpsi';
    $mail->setFrom(trim($email), trim($name));
    $mail->addAddress(trim($destinataire));
    $mail->Subject = $subject;
    $mail->Body = "Message de : ".$email. "<br><br>" .$message;
    $mail->AltBody = $message;

    $mail->send();
    $alert = 'OK';
  } catch (Exception $e) {
    $alert = "Une erreur s'est produite lors de l'envoi du message : " . $e->getMessage();
  }

  echo $alert;
} 
else {
  echo 'Méthode non autorisée';
}

?>