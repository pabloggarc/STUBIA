<?php

setlocale(LC_ALL,'es_ES.utf8');

setlocale(LC_CTYPE, 'es');
setlocale(LC_TIME, 'es_ES','es_ES.UTF-8');

date_default_timezone_set('Europe/Madrid');

header('Content-Type: text/html; charset=utf-8'); 
header('Expires: Sat, 26 Jul 1950 00:00:00 GMT');
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

define('_ENTORNO_', strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],"www.uah.es")===false ? (strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],"preproduccion")===false?'LOCAL':'TEST'):'PRODUCCION');

// ********************** BBDD *********************
define('BBDD_HOST',	_ENTORNO_ === "PRODUCCION"	? ''    : (_ENTORNO_ === "TEST" ? ''        : 'localhost'));
define('BBDD_USER',	_ENTORNO_ === "PRODUCCION"	? ''    : (_ENTORNO_ === "TEST" ? ''        : 'ws'));
define('BBDD_PWD',	_ENTORNO_ === "PRODUCCION"	? ''    : (_ENTORNO_ === "TEST" ? ''        : ''));
define('BBDD_SQUEMA', 'STUBIA');

?>
