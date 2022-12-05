<?php

$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");

$debug=true;

$sql_connect = conectar_bd();

echo "Modo debug=".$debug. "<br><br>";

$sql = "DELETE FROM master_puestos;";
echo($sql."<br>");
echo("<br><hr><br>");
if (!$debug) {    
    writeLog($sql);
    $delete = db_query($sql, $sql_connect);
}

//Insertamos todos los puestos del todas las aulas:
$sql = "SELECT * FROM master_aulas WHERE activo=1;";
writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error al recuperar las encuestas de base de datos (script_insertarpuestos_1).");
} else {    
    while ($aula = $consulta->fetch_array()) {
        echo($aula['aula']."<br><br>");
        for ($i=1;$i<=$aula["aforo"];$i++) {
            $sql = "INSERT master_puestos (id_aula, puesto, id_tipo, au_usu_alta, au_proc_alta) "
                    . "VALUES (".$aula["id"]." , ".$i." , ".$aula["tipo"]." , ".$_SESSION["stubia_userid"]." , '".php_actual()."');";            
            echo($sql."<br>");
            if (!$debug) {                
                writeLog($sql);            
                $insertar = db_query($sql, $sql_connect);
            }
        }
        echo("<br><hr><br>");
    }            
}

if (!$debug) {echo "Todos los INSERT guardados en BD!";}

desconectar_bd($sql_connect);

?>


