<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//librerias
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

 
//Create a new PHPMailer instance
$mail = new PHPMailer(true);

$mail->SMTPDebug=SMTP::DEBUG_SERVER;
$mail->IsSMTP();
 
//Configuracion servidor mail
$mail->From = "guille.willy.1975@gmail.com"; //remitente
$mail->SMTPAuth = true;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //seguridad
$mail->Host = "smtp.gmail.com"; // servidor smtp
$mail->Port = 465; //587; //puerto
$mail->Username ='guille.willy.1975@gmail.com'; //nombre usuario
$mail->Password = 'bszdbmecrfysdhaa'; //contraseña
 
//Agregar destinatario
$mail->AddAddress($_POST['email']);
$mail->Subject = $_POST['subject'];
$mail->Body = $_POST['message'];
 
//Avisar si fue enviado o no y dirigir al index
if ($mail->Send()) {
    echo'<script type="text/javascript">
           alert("Enviado Correctamente");
        </script>';
} else {
    echo'<script type="text/javascript">
           alert("NO ENVIADO, intentar de nuevo");
        </script>';
}
?>