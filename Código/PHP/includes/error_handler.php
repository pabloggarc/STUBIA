<?php
set_error_handler("myErrorHandler");
set_exception_handler("myExceptionHandler");

// error handler function
function myErrorHandler ($errno, $errstr, $filename, $linenum, $vars) 
{
	$strCadena = "Error nº: ".$errno." - Desc.:".$errstr." - Archivo:".$filename." - Línea:".$linenum;

	writeError($strCadena);
}

function writeError($strCadena)
{
	$strDate = date('Y-m-d');
	$hora = date('H');

	$strNombreLog = dirname(__FILE__).'//..//logs//'.$strDate.'_'.$hora.'_error.log';
	 
	$log = @fopen($strNombreLog, 'a');
	
	if ($log) 
	{
		fputs($log, print_r(date('Y-m-d H:i:s')." - ".$strCadena, true) . "\n---\n");
		fclose($log);
	}
}

function myExceptionHandler(Exception $e) 
{
	writeException($e->getMessage());
}

function writeException($strCadena)
{
	$strDate = date('Y-m-d');
	$hora = date('H');

	$strNombreLog = dirname(__FILE__).'//..//logs//'.$strDate.'_'.$hora.'_exception.log';
	 
	$log = @fopen($strNombreLog, 'a');
	
	if ($log) 
	{
		fputs($log, print_r(date('Y-m-d H:i:s')." - ZONA PRIVADA ".$strCadena, true) . "\n---\n");
		fclose($log);
	}
}
?>
