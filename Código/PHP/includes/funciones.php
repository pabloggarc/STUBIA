<?php

require('funciones_db.php');
require('funciones_fecha.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';

 
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

function writeAct($strCadena) {
    $strDate = date('Y-m-d');

    if (_ENTORNO_==="PRODUCCION") {$barra="//";}
    else {$barra="\\";}

    $strNombreLog = dirname(__FILE__) . $barra . '..' . $barra . 'actions' . $barra . $strDate . '.log';

    $log = @fopen($strNombreLog, 'a');

    if ($log) {
        fputs($log, print_r(date('Y-m-d H:i:s') . " - " . str_replace("SENASA\\", "", $_SERVER['AUTH_USER']) . " - " . $strCadena, true) . "\n");
        fclose($log);
    } else {
        //alternativo
        $strNombreLogAlt = dirname(__FILE__) . $barra . '..' . $barra . 'actions' . $barra . $strDate . '_alt.log';
        $log_alt = @fopen($strNombreLogAlt, 'a');

        if ($log_alt) {
            fputs($log_alt, print_r(date('Y-m-d H:i:s') . " - " . str_replace("SENASA\\", "", $_SERVER['AUTH_USER']) . " - " . $strCadena, true) . "\n---\n");
            fclose($log_alt);
        }
    }
}

function enviar_mail($to, $asunto, $mensaje, $dir_adjunto = '', $adjunto = '', $to_cc='', $to_bcc='') {
    $strAdjuntos = $dir_adjunto . $adjunto;

    if ($to == '') {
        writeLog("No se ha podido enviar el correo ya que no se ha especificado dirección a quien enviar.");
        return false;
    } elseif ($asunto='') {
        writeLog("No se ha podido enviar el correo ya que no se ha especificado el asunto del mensaje.");
        return false;
    } elseif ($mensaje='') {
        writeLog("No se ha podido enviar el correo ya que no se ha especificado el cuerpo del mensaje.");
        return false;
    } else {
        //Instancia de PHPMailer
        $mail = new PHPMailer(true);

        //Inicializamos los atributos del PHPMailer con nuestros datos
        $mail->SMTPDebug=SMTP::DEBUG_CONNECTION;
        $mail->SetLanguage('es');
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com"; 
        $mail->SMTPAuth = true;
        $mail->Username ='ubicua.uah.2022@gmail.com'; 
        $mail->Password = 'wcrdoafrquztizrx'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  /*Tambien 465*/
        $mail->CharSet = 'UTF-8';
        $mail->Body = utf8_decode($mensaje);
        $mail->Subject = utf8_decode($asunto); 
        $mail->setFrom("", "STUBIA"); 
        //$mail->addBCC("ubicua.uah.2022@gmail.com");
        $mail->isHTML(true);
        //$mail->Subject = "Confirmación de reserva en STUBIA";
        $mail->Body = "Has solicitado una reserva en el servicio STUBIA. Por favor, confírmala!";
        
        $mail->Helo = MAIL_HELO;
        
        
        $mail->Host = MAIL_HOST;
        
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

/*
  Esta función devuelve una réplica del array multidimensional pasado en el primer parámetro
  pero ordenado por el campo y criterio especificado en el segundo parámetro. Ejemplo:
  $nuevo_array=array_msort($miarray, array('apellidos'=>SORT_ASC, 'edad'=>SORT_DESC));
 */

function array_msort($array, $cols) {
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) {
            $colarr[$col]['_' . $k] = strtolower($row[$col]);
        }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\'' . $col . '\'],' . $order . ',';
    }
    $eval = substr($eval, 0, -1) . ');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k, 1);
            if (!isset($ret[$k]))
                $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;
}

//Devuelve el nombre de la página actual:
function php_actual() {
    return str_replace("/", "", strrchr($_SERVER['SCRIPT_NAME'], "/"));
}

//Rellena el mensaje de error en caso de que haya ocurrido algo durante la carga de una página:
function lanzar_error($causa, $writeLog = false) {
    if ($writeLog) {
        writeLog("*** ERROR: " . $causa);
    }
    $GLOBALS['cadena_errores'][] = $causa;
}

//Rellena el mensaje de error en caso de que haya ocurrido algo durante la carga de una página:
function lanzar_aviso($msg, $writeLog = false) {
    if ($writeLog) {
        writeLog("*** WARNING: " . $msg);
    }
    $GLOBALS['cadena_avisos'][] = $msg;
}

//Devuelve una cadena sin acentos:
function ignoraTildes($cadena) {
    $sustituciones = array("a" => "á à ä â",
        "e" => "é è ë ê",
        "i" => "í ì ï î",
        "o" => "ó ò ö ô",
        "u" => "ú ù ü û",
        "A" => "Á À Ä Â",
        "E" => "É È Ë Ê",
        "I" => "Í Ì Ï Î",
        "O" => "Ó Ò Ö Ô",
        "U" => "Ú Ù Ü Û"
    );
    foreach ($sustituciones as $key => $val) {
        $cadena = str_replace(explode(" ", $val), $key, $cadena);
    }
    return $cadena;
}

// Compara 2 fechas en formato timestamp
function date_compare($a, $b) {
    return $a['fecha'] - $b['fecha'];
}


function isAdmin($id_user){
    
    $sql_connect = conectar_bd();
    $perfiles = array();

    $sql = "SELECT perfil_id from master_usuarios WHERE up.user_id = " . $id_user . ";";
    writeLog($sql);

    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se han podido recuperar los perfiles del usuario para comprobar si es administrador.");
    } else {
        while ($fila = $consulta->fetch_array()) {
            $perfiles[] = $fila["perfil_id"];
        }
    }
    $consulta->free_result();
    
    return in_array(_USER_ADMIN, $perfiles);
    
}

function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}

/*
 * Funcion que devuelve registra el acceso de un usuario en la base de datos
 * 
 * @param string $user_id Identificador del usuario que ha accedido al sistema
 * 
 * @return void
 */

function registrar_acceso_db($user_id, $perfil_id) {

    $sql_connect = conectar_bd();

    $sql = "INSERT INTO accesos_usuarios(user_id, perfil_id, login_date, au_fec_alta, au_usu_alta, au_proc_alta) VALUES (" . $user_id . ", " . $perfil_id . ", SYSDATE(), SYSDATE(), 100000, '" . php_actual() . "');";

    writeLog($sql);
    $insert = db_query($sql, $sql_connect);
    if (!$insert) {
        exit("No se ha podido guardar el acceso del usuario en base de datos.");
    }

    desconectar_bd($sql_connect);
}

function getAforoTipoAula($tipoAula) {
    $total=0;
    $sql_connect = conectar_bd();
    $sql = "SELECT sum(aforo) as suma FROM master_aulas WHERE tipo=".$tipoAula;
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se ha podido acceder a la base de datos (getAforoTipoAula).");
    } else {
        $fila = $consulta->fetch_array();
        $total=$fila["suma"];
    }
    $consulta->free_result();

    desconectar_bd($sql_connect);
    return ($total);
}

function getEstadoPuesto($idAula, $idPuesto, $fecha='', $hora='') {
    $estado="";
    $sql_connect = conectar_bd();
    $sql = "SELECT * FROM estados WHERE aula=".$idAula." AND puesto=".$idPuesto." ORDER BY au_fec_alta DESC";
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se ha podido acceder a la base de datos (getEStadoPuesto).");
    } elseif($consulta->num_rows>0){
        $fila = $consulta->fetch_array();
        //if $fila->num
        $estado=$fila["estado"];
        $fecha=$fila["au_fec_alta"];
    } 
    
    $consulta->free_result();

    desconectar_bd($sql_connect);
    $devolver=array();
    $devolver[1]=$estado;
    $devolver[2]=$fecha;
    return ($devolver);
}



?>


