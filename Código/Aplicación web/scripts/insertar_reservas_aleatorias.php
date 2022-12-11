<?php

$dir_raiz = "";

require_once($dir_raiz."../includes/session_app.php");
require_once($dir_raiz."../includes/config.php");
require_once($dir_raiz."../includes/funciones.php");

if ($_SESSION["stubia_userperfil"] !=="Admin") {
    exit("No tiene permisos para lanzar este script");
}

$debug=false;

$sql_connect = conectar_bd();

echo "Modo debug=".$debug. "<br><br>";
echo "Generando aleatoriamente reservas: <br><br><hr>";

$sql = "DELETE FROM reservas WHERE fecha=CURDATE() "
    . "AND au_proc_alta LIKE '%insertar%';";
echo($sql."<br>");
echo("<br><hr><br>");
if (!$debug) {    
    writeLog($sql);
    $delete = db_query($sql, $sql_connect);
}


for ($i=0;$i<=100;$i++) {
    //$fecha=date("Y-m-d H:$i");
    $hora_aleat=random_int(8,20); //escogemos al azar si el puesto tiene acceso en ese minuto
    $usuario_aleat=random_int(6,12); //escogemos al azar entre varios usuarios, el id 6 y 7 somos Pablo y Guille:
    if ($usuario_aleat==8) $usuario_aleat=12; //Carlos
    if ($usuario_aleat==9) $usuario_aleat=13; //Robert
    if ($usuario_aleat==10) $usuario_aleat=14; //Alumno
    if ($usuario_aleat==11) $usuario_aleat=15; //Alumno
    if ($usuario_aleat==12) $usuario_aleat=16; //Alumno

    $puesto_aleat= random_int(1,100);
    //Recupero el id del puesto en el maestro:
    $sql = "SELECT id FROM master_puestos WHERE id_aula=3 AND puesto=".$puesto_aleat." AND activo=1;";
    $consulta = db_query($sql, $sql_connect);
    $puesto = $consulta->fetch_array();
    $puesto_aleat = $puesto["id"];

    $sql = "SELECT * FROM reservas WHERE id_usuario=".$usuario_aleat." AND id_franja_horaria=".$hora_aleat
        . " AND fecha=CURDATE() AND activo=1;";
    $consulta = db_query($sql, $sql_connect);
    $puesto = $consulta->fetch_array();
    if ($consulta->num_rows == 0) {
        $localizador = getLocalizador();
        $sql = "INSERT INTO reservas (id_usuario, id_franja_horaria, fecha, id_puesto, localizador, au_usu_alta, au_proc_alta) "
            . "VALUES (" . $usuario_aleat . ", " . $hora_aleat . ", CURDATE(), " . $puesto_aleat . ", '" . $localizador . "', " . $_SESSION["stubia_userid"] . ", '" . php_actual() . "');";
        if (!$debug) {
            $insertar = db_query($sql, $sql_connect);
            writeLog($sql);
        }
        echo ($sql . "<br>");
    }
}            


if (!$debug) {echo "Todos los INSERT guardados en BD!";}

desconectar_bd($sql_connect);

?>


