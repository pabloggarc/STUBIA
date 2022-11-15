<?php
//Librerias

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';

 
//Instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    //Inicializamos los atributos del PHPMailer con nuestros datos
    $mail->SMTPDebug=SMTP::DEBUG_CONNECTION;
    $mail->IsSMTP();
    $mail->Host = "smtp.gmail.com"; 
    $mail->SMTPAuth = true;
    $mail->Username ='ubicua.uah.2022@gmail.com'; 
    $mail->Password = 'wcrdoafrquztizrx'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;  /*Tambien 465*/
    
    //$mail->addAttachment("Sweave.pdf","Manual de Sweave"); /* Para adjuntar archivos */

    //Envio del correo
    $mail->CharSet = 'UTF-8'; 
    $mail->setFrom("ubicua.uah.2022@gmail.com", "STUBIA"); 
    $mail->AddAddress("pablo.ggarcia@edu.uah.es"); 
    $mail->addBCC("ubicua.uah.2022@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = "Confirmación de reserva en STUBIA";
    $mail->Body = "Has solicitado una reserva en el servicio STUBIA. Por favor, confírmala!";
    $mail->send();
    echo "Correo enviado";
} 
catch (Exception $e) {
    echo "Error al enviar el mensaje: ".$mail->ErrorInfo;
}
?>