<?php

require('funciones_db.php');
require('funciones_fecha.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

 
//Instancia de PHPMailer
$mail = new PHPMailer(true);


function writeLog($strCadena) {
    $strDate = date('Y-m-d');
    $hora = date('H');

    if (_ENTORNO_==="PRODUCCION") {$barra="//";}
    else {$barra="\\";}

    $strNombreLog = dirname(__FILE__) . $barra . '..' . $barra . 'logs' . $barra . $strDate . '_' . $hora . '.log';

    $log = @fopen($strNombreLog, 'a');

    if ($log) {
        fputs($log, print_r(date('Y-m-d H:i:s') . "(" . microtime() . ") - " . $strCadena, true) . "\n---\n");
        fclose($log);
    } else {
        //alternativo
        $strNombreLogAlt = dirname(__FILE__) . $barra . '..' . $barra . 'logs' . $barra . $strDate . '_' . $hora . '_alt.log';
        $log_alt = @fopen($strNombreLogAlt, 'a');

        if ($log_alt) {
            fputs($log_alt, print_r(date('Y-m-d H:i:s') . " - " . $strCadena, true) . "\n---\n");
            fclose($log_alt);
        }
    }

    //$_SESSION["last_action"]=time();
}

function enviar_mail($to, $asunto, $mensaje, $dir_adjunto = '', $adjunto = '', $to_cc='', $to_bcc='') {
    $strAdjuntos = $dir_adjunto . $adjunto;

    if ($to == '') {
        writeLog("No se ha podido enviar el correo ya que no se ha especificado dirección a quien enviar.");
        return false;
    } elseif ($asunto=='') {
        writeLog("No se ha podido enviar el correo ya que no se ha especificado el asunto del mensaje.");
        return false;
    } elseif ($mensaje=='') {
        writeLog("No se ha podido enviar el correo ya que no se ha especificado el cuerpo del mensaje.");
        return false;
    } else {
        //Instancia de PHPMailer
        $mail = new PHPMailer(true);
        writeLog('mensaje:' .$mensaje);

        //Inicializamos los atributos del PHPMailer con nuestros datos
        //$mail->SMTPDebug=SMTP::DEBUG_CONNECTION;
        $mail->SMTPDebug=SMTP::DEBUG_OFF;
        $mail->SetLanguage('es');
        $mail->IsSMTP();
        $mail->isHTML(true);
        $mail->Helo = MAIL_HELO;
        $mail->Host = MAIL_HOST;
        //$mail->Host = "smtp.gmail.com"; 
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_ADMIN_FROM; 
        $mail->Password = MAIL_ADMIN_PASSWORD; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  /*Tambien 465*/

        $mail->CharSet = 'UTF-8';
        $asunto_decode = utf8_decode($asunto); //"=?UTF-8?B?".base64_encode($asunto)."=?="; 
        $mail->Subject = $asunto_decode; 
        $mensaje_decode = utf8_decode($mensaje); //"=?UTF-8?B?".base64_encode($mensaje)."=?=";
        $mail->Body = $mensaje_decode;
        
        $mail->setFrom(MAIL_ADMIN_FROM, _APP_NAME);
        //$mail->addBCC("ubicua.uah.2022@gmail.com");
        
        
        
        //$mail->IsHTML(true);
        if ($strAdjuntos !== "") {
            $mail->addAttachment($strAdjuntos);
        }

        //comprobamos si es múltiple
        $arr_to = explode(';', $to);

        if (count($arr_to) > 0) {
            for ($cont = 0; $cont < count($arr_to); $cont++) {
                $mail->AddAddress($arr_to[$cont]);
            }
        }

        if (!$mail->Send()) {
            writeLog("*** ERROR: El envío del correo ha fallado");
            return false;
        } else {
            return true;
        }
    }
}

//Devuelve el nombre de la página actual:
function php_actual() {
    return str_replace("/", "", strrchr($_SERVER['SCRIPT_NAME'], "/"));
}



function registrar_acceso_app($user_id, $perfil_id) {

    $sql_connect = conectar_bd();

    $sql = "INSERT INTO accesos_usuarios(user_id, perfil_id, login_date, au_fec_alta, au_usu_alta, au_proc_alta) VALUES (" . $user_id . ", " . $perfil_id . ", SYSDATE(), SYSDATE(), 100000, '" . php_actual() . "');";
    writeLog($sql);
    $insert = db_query($sql, $sql_connect);
    if (!$insert) {
        exit("No se ha podido guardar el acceso del usuario en base de datos.");
    }

    desconectar_bd($sql_connect);
}


function getFranjasHorarias () {
    $sql_connect = conectar_bd();

    $sql = "SELECT inicio FROM master_franjas_horarias WHERE activo=1";
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit ("Se ha producido un error al recuperar las encuestas de base de datos (getFranjasHorarias).");
    } else {
        while ($fila = $consulta->fetch_array()) {
            $horas[] = $fila["inicio"];        
        }        
    }

    $consulta->free_result();
    desconectar_bd($sql_connect);

    return(implode(",",$horas));    

}

function getLocalizador(){
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // Output: 54esmdr0qf
    return substr(str_shuffle($permitted_chars), 0, 6);
}

?>


