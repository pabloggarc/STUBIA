<?php

setlocale(LC_ALL,'es_ES.utf8'); 
setlocale(LC_CTYPE, 'es');

date_default_timezone_set('Europe/Madrid');

header('Content-Type: text/html; charset=utf-8'); 
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

// ***************** GENERAL *********************************
define('_APP_NAME', 'Dato Único ADIF y ADIF AV');
define('_ENTORNO_', strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],"cmo.adif")===false ? (strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],"srvdesarrollo")===false?'LOCAL':'DESARROLLO'):'PRODUCCION');

//Guillermo 28/jul/22: hacemos que la app, en modo local, lea n fichero config.ini la url raiz local del proyecto:
if (_ENTORNO_==="LOCAL") {
    $fp = fopen($dir_raiz."config.ini", "r");    
     while(!feof($fp)) {
        $linea = fgets($fp);
        if (strpos($linea, "URL local")!==false) {
            $url_local= substr($linea, strpos($linea, "=")+1);
        }
     }    
    fclose($fp);
}

define('_APP_URL', _ENTORNO_ === "PRODUCCION" ? "http://cmo.adif/cm_adif/" : (_ENTORNO_ === "DESARROLLO" ? "http://srvdesarrollo.senasa.es/cm_adif/" : $url_local));
define('_URL_WEB_ADIF', 'https://www.adif.es/');

// ***************** AUTENTICACION *********************************
define('_PREFIJO_LDAP', _ENTORNO_ === "PRODUCCION" ? ""                 : (_ENTORNO_ === "DESARROLLO" ? "SENASA\\"  : "SENASA\\"));
define('_URL_LDAP',     _ENTORNO_ === "PRODUCCION" ? "slapd.dcsi.adif"  : (_ENTORNO_ === "DESARROLLO" ? ""          : ""));
define('_PUERTO_LDAP',  _ENTORNO_ === "PRODUCCION" ? 389                : (_ENTORNO_ === "DESARROLLO" ? ""          : ""));
define('_LOGIN_AUTOFIRMA', false);
define('_LOGIN_BY_GET', true);

// ********************** BBDD *********************
define('BBDD_HOST',	_ENTORNO_ === "PRODUCCION"	? 'localhost'   : (_ENTORNO_ === "DESARROLLO" ? 'srvdesarrollo' : 'localhost'));
define('BBDD_USER',	_ENTORNO_ === "PRODUCCION"	? 'root'        : (_ENTORNO_ === "DESARROLLO" ? 'root'          : 'root'));
define('BBDD_PWD',	_ENTORNO_ === "PRODUCCION"	? 'Euldlm'	: (_ENTORNO_ === "DESARROLLO" ? 'root'          : ''));
define('BBDD_SQUEMA', 'cuadro_mando_adif');
// *************************************************

// ************ BBDD MANTENIMIENTO *****************
define('BBDD_HOST_MANTEN',     _ENTORNO_ === "PRODUCCION"      ? 'iblsd006.dcsi.adif'   : (_ENTORNO_ === "DESARROLLO" ? 'srvdesarrollo' : 'localhost'));
define('BBDD_USER_MANTEN',     _ENTORNO_ === "PRODUCCION"      ? 'DATA_USR'        : (_ENTORNO_ === "DESARROLLO" ? 'root'          : 'root'));
define('BBDD_PWD_MANTEN',      _ENTORNO_ === "PRODUCCION"      ? '4701443589'      : (_ENTORNO_ === "DESARROLLO" ? 'root'          : ''));
define('BBDD_SQUEMA_MANTEN', 'DW');
define('BBDD_PORT_MANTEN', 1533);
// *************************************************

// ***************** MAIL *********************************
define('MAIL_HELO',         _ENTORNO_ === "PRODUCCION"	? 'www.adif.es'                 : (_ENTORNO_ === "DESARROLLO" ? 'www.senasa.es'     : ''));
define('MAIL_HOST',         _ENTORNO_ === "PRODUCCION"	? 'smtp.adif.es'                : (_ENTORNO_ === "DESARROLLO" ? 'mail.senasa.es'    : ''));
define('MAIL_ADMIN_FROM',   _ENTORNO_ === "PRODUCCION"	? 'notificaciones.cmo@adif.es'  : (_ENTORNO_ === "DESARROLLO" ? 'noreply@senasa.es' : ''));
define('MAIL_ADMIN_ADRESS', _ENTORNO_ === "PRODUCCION"	? 'pgomez@senasa.es'            : (_ENTORNO_ === "DESARROLLO" ? 'pgomez@senasa.es'  : ''));

// ************** PERFILES ***************************
define('_USER_EJECUTIVO', 5);
define('_USER_RESPONSABLE_DATO', 10);
define('_USER_SUPERVISOR', 15);
define('_USER_ADMIN', 25);
define('_USER_SUPER_ADMIN', 30);
// ***************************************************

//include('error_handler.php');


$GLOBALS['_MASTER_ORG_GRUPO']			= Array("ADIF", "ADIF AV");
$GLOBALS['_MASTER_ORG_PILAR_PALANCA']	= Array("Pilar", "Palanca", "Motor");
$GLOBALS['_MASTER_ORG_ALMACENAMIENTO']	= Array("Manual", "Automático");
$GLOBALS['_MASTER_ORG_ACUMULADO']	= Array("No acumulado", "Acumulado");
$GLOBALS['_MASTER_ORG_CUMPLIMIENTO_META']	= Array("Meta (El valor debe ser mayor o igual que la meta)", "Límite (El valor debe ser menor o igual que la meta)");
$GLOBALS['_MASTER_ORG_COMPARACION']	= Array(1 => ">", 2 => "<", 3 => ">=", 4 => "<=");
$GLOBALS['_MASTER_DPO_PANEL']	= Array(1 => "Panel Adif", 2 => "Panel Adif AV");
$GLOBALS['cadena_errores']				= Array();
$GLOBALS['cadena_avisos']				= Array();
$GLOBALS['info_accion']					= "";
$GLOBALS['info_info']					= "";
$GLOBALS['_USER_PRUEBA']				= Array(
											"responsable"	=> array("id" => "5", "perfil_id" => "10", "nombre" => "Anónimo", "apellidos" => "para Pruebas", "direccion" => "1", "user_ldap" => "prueba", "perfil" => "Responsable del dato"),
											"supervisor"	=> array("id" => "300000", "perfil_id" => "15", "nombre" => "Anónimo", "apellidos" => "para Pruebas", "direccion" => "1", "user_ldap" => "prueba", "perfil" => "Supervisor de datos"),
											"ejecutivo"		=> array("id" => "300000", "perfil_id" =>  "5", "nombre" => "Anónimo", "apellidos" => "para Pruebas", "direccion" => "1", "user_ldap" => "prueba", "perfil" => "Ejecutivo"),
                                                                                        "administrador"		=> array("id" => "300000", "perfil_id" =>  "25", "nombre" => "Anónimo", "apellidos" => "para Pruebas", "direccion" => "1", "user_ldap" => "prueba", "perfil" => "Administrador")
										  );
$GLOBALS['_PRIME_MASTER_ACCURACY'] = Array( 1 => "Normal",
                                            2 => "Estimated",
                                            3 => "Deviated from definition",
                                            4 => "Preliminary");

// ********************** Configuracion formato numerico *********************
$formatter = new NumberFormatter("en_US", NumberFormatter::DECIMAL);
$formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 4);
$formatter->setSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL, ".");
$formatter->setSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL, ",");
// ***************************************************************************
?>
