<?php
require_once("config.php");
require_once("funciones.php");

if (!isset($_POST["sql"]) && !isset($_GET["sql"])) {writeLog("ERROR: No se ha especificado la consulta"); exit("ERROR: No se ha especificado la consulta");}
$sql			= isset($_POST["sql"]) ? $_POST["sql"] : $_GET["sql"];
$sql_connect	= conectar_bd();

writeLog($sql);
$accion = db_query($sql, $sql_connect);
if (!$accion) {
	echo "ERROR: ".$accion;
} else {
	echo $sql_connect->affected_rows;;
}

desconectar_bd($sql_connect);
?>