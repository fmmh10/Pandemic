<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("PHPMailer/src/SMTP.php");
require_once("PHPMailer/src/PHPMailer.php");
require_once("PHPMailer/src/Exception.php");

$to = $_POST['email'];

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.gmail.com";
$mail->Port = "465";
$mail->isHTML();
$mail->Username = "aswgrupo024@gmail.com";
$mail->Password = "amadubalde";
$mail->SetFrom("no-reply@pandemic.com");
$mail->Subject = "Recuperacao da password";
$mail->Body = "Siga este link para proceguir à recuperação da password: <br>
              <a href='http://localhost/Projeto/ASW/password_rec.php'>Mudar password</a>";
$mail->AddAddress($to);

$mail->Send();
echo 'E-mail de recuperação enviado com sucesso!';

?>
