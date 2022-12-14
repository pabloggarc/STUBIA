<?php

//require('funciones_db.php');
//require('funciones_fecha.php');


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

//Devuelve el nombre de la página actual:
function php_actual() {
    return str_replace("/", "", strrchr($_SERVER['SCRIPT_NAME'], "/"));
}



?>


