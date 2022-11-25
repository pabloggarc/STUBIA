<?php

require_once "../includes/config.php";
require_once "../includes/funciones.php";
require_once "../includes/funciones_db.php";
$aula = $puesto = $estado =0;

if(isset($_GET["aula"]) && isset($_GET["puesto"]) && isset($_GET["estado"])){
    $aula=$_GET["aula"];
    $puesto=$_GET["puesto"];
    $estado=$_GET["estado"];
    writeLog("Entro");

    
    $sql_connect = conectar_bd();
    $sql = "INSERT INTO estados (aula, puesto, estado, au_fec_alta) VALUES (".$aula.",".$puesto.",".$estado.",SYSDATE())";
    writeLog($sql);
    $insercion = db_query($sql, $sql_connect);
    if (!$insercion) {
        exit("No se ha podido acceder a la base de datos (getEStadoPuesto).");
    }

    $sql = "SELECT r.id FROM reservas r "
    . "INNER JOIN master_puestos p ON r.id_puesto=p.id AND p.activo=1 "
    . "INNER JOIN master_franjas_horarias f ON r.id_franja_horaria=f.id "
    . "WHERE p.id_aula=3 AND p.puesto=".$puesto." AND r.activo=1 "
    . "AND f.inicio=HOUR(sysdate())";

    writeLog($sql);
    $consultar = db_query($sql, $sql_connect);
    if (!$consultar) {
        exit("No se ha podido acceder a la base de datos (getEStadoPuesto).");
    } elseif($consultar->num_rows>0){
        echo "SI"; 
    }
    else{
        echo "NO"; 
    }
}
?>