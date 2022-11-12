<?php
require_once("config.php");
require_once("funciones.php");

if (!isset($_POST["sql"]) && !isset($_GET["sql"])) {writeLog("ERROR: No se ha especificado la consulta"); exit("ERROR: No se ha especificado la consulta");}
$sql			= isset($_POST["sql"]) ? $_POST["sql"] : $_GET["sql"];
$arr_salida		= array();
$sql_connect	= conectar_bd();

writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
	echo "ERROR: ".$consulta;
} else {
	while($con = $consulta->fetch_array()) {$arr_salida[] = $con;}
	echo json_encode($arr_salida);
	$consulta->free_result();
}

desconectar_bd($sql_connect);
?>