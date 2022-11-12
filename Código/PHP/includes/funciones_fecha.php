<?php

function fechaHTMLToMySQL($fecha)
{
	$fecha=trim($fecha);

	if(strlen($fecha)<10){return "0000-00-00";}

	$dia = substr($fecha, 0, 10);

	$arrDia = explode("/", $dia);

	return $arrDia[2]."-".$arrDia[1]."-".$arrDia[0];
}

function fechaHTMLToMySQLLarge($fecha)
{
	if (trim($fecha) == '') return "";

	$dia = substr($fecha, 0, 16);

	//Ejemplo: 01/06/2010 17:35

	$arrDia = explode("/", $dia);

	$anyoConHora = $arrDia[2];
	$mes = $arrDia[1];
	$dia = $arrDia[0];

	$arrAnyoHora = explode(" ", $anyoConHora);
	$anyo = $arrAnyoHora[0];
	$hora = $arrAnyoHora[1];

	return $anyo."-".$mes."-".$dia." ".$hora.":00";
}

function fechaMySQLToHTMLLetrasSinAnyo($fecha)
{
	if (trim($fecha) == '') return "";

	$dia = substr($fecha, 0, 10);

	if ($dia == '0000-00-00') return "";

	$arrDia = explode("-", $dia);

	global $nombre_mes;

	return $arrDia[2]."/".$nombre_mes[$arrDia[1]]; //."/".$arrDia[0];
}

function fechaMySQLToHTMLLargeLetrasSinAnyo($fecha)
{
	if (trim($fecha) == '') return "";

	$dia = substr($fecha, 0, 16);

	if ($dia == '0000-00-00 00:00') return "";

	$arrDia = explode("-", $dia);

	$anyo = $arrDia[0];
	$mes = $arrDia[1];
	$diaConHora = $arrDia[2];

	$arrDiaHora = explode(" ", $diaConHora);
	$dia = $arrDiaHora[0];
	$hora = $arrDiaHora[1];

	global $nombre_mes;

	//return $dia."/".$mes."/".$anyo." ".$hora;
	return $dia."/".$nombre_mes[$mes]." ".$hora;
}

function fechaMySQLToHTML($fecha)
{
	if (trim($fecha) == '') return "";

	$dia = substr($fecha, 0, 10);

	if ($dia == '0000-00-00') return "";

	$arrDia = explode("-", $dia);

	return $arrDia[2]."/".$arrDia[1]."/".$arrDia[0];
}

function fechaMySQLToHTMLLarge($fecha)
{
	if (trim($fecha) == '') return "";

	$dia = substr($fecha, 0, 16);

	if ($dia == '0000-00-00 00:00') return "";

	$arrDia = explode("-", $dia);

	$anyo = $arrDia[0];
	$mes = $arrDia[1];
	$diaConHora = $arrDia[2];

	$arrDiaHora = explode(" ", $diaConHora);
	$dia = $arrDiaHora[0];
	$hora = $arrDiaHora[1];

	return $dia."/".$mes."/".$anyo." ".$hora;
}

function horaMySQLToHTML($fecha)
{	

	if (trim($fecha) == '') return "";

	$dia = substr($fecha, 0, 19);

	if ($dia == '0000-00-00 00:00:00') return "";

	$arrDiaHora = explode(" ", $dia);	

	$arrHora = explode(":", $arrDiaHora[1]);

	$hor = $arrHora[0];
	$min = $arrHora[1];
	$seg = $arrHora[2];

	return (int)$hor.":".$min;
	
}

function compareFechasHTML($fecha1, $fecha2)
{
	$dtFecha1 = strtotime(date('Y-m-d', strtotime(fechaHTMLToMySQL($fecha1))));
	$dtFecha2 = strtotime(date('Y-m-d', strtotime(fechaHTMLToMySQL($fecha2))));

	if ($dtFecha1 < $dtFecha2)
	{
		return -1;
	}

	if ($dtFecha2 < $dtFecha1)
	{
		return 1;
	}

	return 0;
}

//extrae el año de fechas formato dd-mm-yyyy
function getAnioSQLtoHTML($fecha){
	if (trim($fecha) == '') return "";
	$dia = substr($fecha, 0, 10);
	if ($dia == '0000-00-00') return "";

	$arrDia = explode("-", $dia);

	return $arrDia[0];
}

function mes_cristiano($mes){
	if(!isset($mes) or $mes>12){return false;}
	$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	return $meses[intval($mes)];
}

function fecha_cristiana($fecha){
	if(!isset($fecha)){return false;}
	$fecha_crist=date("j",strtotime($fecha));
	$fecha_crist.=" de ";
	$fecha_crist.=mes_cristiano(date("n",strtotime($fecha)));
	$fecha_crist.=" de ";
	$fecha_crist.=date("Y",strtotime($fecha));
	return $fecha_crist;
}

// Valida fecha con formato dd/mm/aaaa
function valida_fecha_espanola($fecha){
	if(!isset($fecha)){return false;}
	$patron="/^\d{2}\/\d{2}\/\d{4}$/";
	if(!preg_match($patron, $fecha)){return false;}
	$ahora=getdate();
	$partes=explode("/",$fecha);
	$max_dias=31;
	$max_dias=$partes[1]==4 || $partes[1]==6 || $partes[1]==9 || $partes[1]==11?30:$max_dias;
	$max_dias=$partes[1]==2 && esBisiesto($partes[2])?29:($partes[1]==2 && !esBisiesto($partes[2])?28:$max_dias);
	if(intval($partes[0])>$max_dias){return false;}
	if(intval($partes[1])>12){return false;}
	if(intval($partes[2])<1900){return false;}
	return true;
}

function esBisiesto($year){
   return date('L',mktime(0,0,0,1,1,$year));
}

//Devuelve la hora o minuto de una hora con formato "hh:mm"
function dato_horario($hora,$dato){
	if(!$hora || strlen($hora)<5 || strpos($hora,":")===false){return "00";}
	$arr=explode(":",$hora);
	$indice=($dato==1 || strtolower($dato)=="hora" || strtolower($dato)=="hour" || strtolower($dato)=="h")?0:1;
	return $arr[$indice];
}

//Devuelve el número de minutos de un dato horario pasado con formato "hh:mm" o "h:m" o "h:mm"
function minutos($hora){
	if(!$hora || strlen($hora)<3 || strpos($hora,":")===false){return 0;}
	$arr=explode(":",$hora);
	return (intval($arr[0])*60)+intval($arr[1]);
}

//Devuelve la suma de dos datos horarios pasados como "hh:mm" o "h:m" o "h:mm"
function suma_horas($hora,$hora2){
	if(!$hora || strlen($hora)<3 || strpos($hora,":")===false){return "00:00";}
	if(!$hora2 || strlen($hora2)<3 || strpos($hora2,":")===false){return $hora;}
	$arr=explode(":",$hora);
	$arr2=explode(":",$hora2);
	$horas=intval($arr[0])+intval($arr2[0]);
	$minutos=intval($arr[1])+intval($arr2[1]);
	while($minutos>59){
		$horas++;
		$minutos-=60;
	}
	$salida = $horas<10?"0".$horas:$horas;
	$salida.= ":";
	$salida.= $minutos<10?"0".$minutos:$minutos;
	return $salida;
}

?>