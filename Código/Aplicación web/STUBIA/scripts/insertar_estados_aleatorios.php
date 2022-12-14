<?php

$dir_raiz = "";

require_once($dir_raiz."../includes/session_app.php");
require_once($dir_raiz."../includes/config.php");
require_once($dir_raiz."../includes/funciones.php");

if ($_SESSION["stubia_userperfil"] !=="Admin") {
    exit("No tiene permisos para lanzar este script");
}

$debug=false;
$uno_de_cada=40;

$sql_connect = conectar_bd();

echo "Modo debug=".$debug. "<br><br>";
echo "Generando estados aleatoriamente uno de cada " . ($uno_de_cada) . "<br><br><hr>";


$sql = "DELETE FROM master_puestos WHERE YEAR(au_fec_alta)=YEAR(SYSDATE()) and MONTH(au_fec_alta)=MONTH(SYSDATE()) and DAY(au_fec_alta)=DAY(SYSDATE()) "
    . " AND HOUR(au_fec_alta)=HOUR(SYSDATE()) AND au_proc_alta LIKE '%script%';";
echo($sql."<br>");
echo("<br><hr><br>");
if (!$debug) {    
    writeLog($sql);
    $delete = db_query($sql, $sql_connect);
}

//Vamos a insertar 
$sql = "SELECT * FROM master_puestos WHERE activo=1;";
writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error en la base de datos (".php_actual().")1.");
} else {    
    while ($puesto = $consulta->fetch_array()) {
        //$estados_aleat=rand()&30; //Escogemos aleatorimente el nº de accesos que vamos a guardar por puesto 
        for ($i=0;$i<=59;$i++) {
            $fecha=date("Y-m-d H:$i");
            $puesto_aleat=rand()&($uno_de_cada-1); //escogemos al azar si el puesto tiene acceso en ese minuto
            if ($puesto_aleat===0) {
                $estado=(rand()&1)+1; //sumo uno porque los estados que tenemos son 1 (ocupado) y 2 (libre)
                $sql = "INSERT INTO estados (aula, puesto, estado, au_fec_alta, au_proc_alta) "
                    . "VALUES (".$puesto["id_aula"].",".$puesto["puesto"].",".$estado.",'".$fecha."','".php_actual()."')";
                echo($sql."<br>");
                if (!$debug) {    
                    writeLog($sql);
                    $insercion = db_query($sql, $sql_connect);
                }    
            }        
        } 
        
        echo("<br><hr><br>");
    }            
}

if (!$debug) {echo "Todos los INSERT guardados en BD!";}

desconectar_bd($sql_connect);

?>


