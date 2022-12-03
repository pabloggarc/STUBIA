<?php

setlocale(LC_ALL,'es_ES.utf8'); 
setlocale(LC_CTYPE, 'es');

date_default_timezone_set('Europe/Madrid');

header('Content-Type: text/html; charset=utf-8'); 
header('Expires: Sat, 26 Jul 1950 00:00:00 GMT');
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

// ***************** GENERAL *********************************
define('_APP_NAME', 'STUBIA');
define('_ENTORNO_', strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],"www.uah.es")===false ? (strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],"preproduccion")===false?'LOCAL':'TEST'):'PRODUCCION');
define('_APP_URL', _ENTORNO_ === "PRODUCCION" ? "" : (_ENTORNO_ === "TEST" ? "" : "localhost/proyectos/stubia"));
define('_URL_WEB_UAH', 'https://www.uah.es/');

// ********************** BBDD *********************
define('BBDD_HOST',	_ENTORNO_ === "PRODUCCION"	? ''    : (_ENTORNO_ === "TEST" ? ''        : 'localhost'));
define('BBDD_USER',	_ENTORNO_ === "PRODUCCION"	? ''    : (_ENTORNO_ === "TEST" ? ''        : 'root'));
define('BBDD_PWD',	_ENTORNO_ === "PRODUCCION"	? ''    : (_ENTORNO_ === "TEST" ? ''        : ''));
define('BBDD_SQUEMA', 'STUBIA');

// ***************** MAIL *********************************
define('MAIL_HELO',         _ENTORNO_ === "PRODUCCION"	? ''        : (_ENTORNO_ === "TEST" ? '':   'localhost'));
define('MAIL_HOST',         _ENTORNO_ === "PRODUCCION"	? ''        : (_ENTORNO_ === "TEST" ? '':   'smtp.gmail.com'));
define('MAIL_ADMIN_FROM',   _ENTORNO_ === "PRODUCCION"	? ''        : (_ENTORNO_ === "TEST" ? '':   'ubicua.uah.2022@gmail.com'));
define('MAIL_ADMIN_ADRESS', _ENTORNO_ === "PRODUCCION"	? ''        : (_ENTORNO_ === "TEST" ? '':   'guillermo.gonzalezm@esu.uah.es'));

// ************** PERFILES ***************************
define('_USER_ADMIN', 1);
define('_USER_ALUMNO', 2);
define('_USER_PROFESOR', 3);
define('_USER_CONSERJE', 4);

// ************** COLORES BLOQUES DE LA UAH***************************
define('_BLUE', '#0d6efd');
define('_RED', '#dc3545');
define('_GREEN', '#198754');
define('_YELLOW', '#ffc107');
define('_CYAN', '#0dcaf0'); //este color para cuando seleccionas un puesto en la biblioteca

?>
