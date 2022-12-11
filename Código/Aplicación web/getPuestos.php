<?php

$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");

$id_aula = $_REQUEST['aula'];
$fecha= $_REQUEST['fecha'];

//echo ($fecha);
 
$sql_connect = conectar_bd();

//Recupero todos los datos del aula:
$sql = "SELECT ma.*,mta.tipo as 'tipo_aula', mb.* FROM master_aulas ma "
        ." INNER JOIN master_tipo_aula mta ON ma.tipo=mta.id AND mta.activo=1 "
        ." INNER JOIN master_bloques mb ON ma.id_bloque=mb.id AND mb.activo=1 "
        ." WHERE ma.id=".$id_aula; // Consulta SQL
//writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error al recuperar las encuestas de base de datos (getPuestos1).");
}elseif($consulta->num_rows > 0){
    $aula=$consulta->fetch_array();
}
$consulta->free_result();

$pasillo=0;
$columnas=$aula["aforo"]/$aula["filas"];
if ($aula["divisiones_aula"]>1) {
    $columnas+=($aula["divisiones_aula"]-1);
    if ($aula["divisiones_aula"]==2) {
        $pasillo=(($columnas-1)/$aula["divisiones_aula"])+1;
    }
}

?>
<div class="col-md">
<label>El estado de los puestos es el siguiente:</label>
<br>
<table class="table" name="tabla_puestos" id="tabla_puestos" style="border='0' cellspacing='0' cellpadding='0'">
    <?php if ($aula["tipo_aula"]=="Teoría" || $aula["tipo_aula"]=="Biblioteca"){ ?>
    <thead>
        <tr>            
            <th colspan="<?=$columnas+2?>" class="table-active text-<?=$aula["tipo_aula"]=="Biblioteca"?'center':($aula["lado_puerta"]=="Izquierda"?'end':'start')?>" style="border:0px; color:<?=$aula["color"]?>">MESA DEL <?=$aula['tipo_aula']=='Teoría'?'PROFESORADO':'BIBLIOTECARIO/A'?></th>
        </tr>
    </thead>
    <?php } //fin de pintar la fila de la mesa del profesor/vigilancia ?>
    <tbody>
        <tr>
            <td colspan="<?=$columnas+2?>" class="table-active" style="border:0px">&nbsp;</td>
        </tr>
<?php
        $numpuesto=0;
        writeLog("Pinto el estado de los puestos del aula ".$aula["aula"]);
        for( $fil=1; $fil<=$aula["filas"]; $fil++) {
        ?>
        <tr>
            <?php
            if ($aula['tipo_aula']!='Laboratorio') {
            ?>
            <td class='table-active' style="border:0px">&nbsp;</td> <!--columna pasillo izquierdo-->
            <?php } ?>
        <?php
            for( $col=1; $col<=$columnas; $col++) {
                $estado=0;
                if ($col!=$pasillo) {
                    $numpuesto++;

                    $sql = "SELECT * FROM estados WHERE aula=".$id_aula." AND puesto=".$numpuesto
                        . " AND YEAR(au_fec_alta)=YEAR(SYSDATE()) AND MONTH(au_fec_alta)=MONTH(SYSDATE()) AND DAY(au_fec_alta)=DAY(SYSDATE())"
                        . " AND HOUR(au_fec_alta)=HOUR(SYSDATE()) AND MINUTE(au_fec_alta)=MINUTE(SYSDATE())";
                    //writeLog($sql);
                    $consulta = db_query($sql, $sql_connect);
                    if (!$consulta) {
                        exit ("Se ha producido un error al recuperar las encuestas de base de datos (getPuestos3).");
                    } elseif ($consulta->num_rows>0) {
                        $fila=$consulta->fetch_array();
                        $estado=$fila["estado"];
                    }
                    $consulta->free_result();
                    if ($id_aula==3){                        
                        $sql = "SELECT r.id, u.nombre, u.apellidos FROM reservas r "
                            . "INNER JOIN master_puestos p ON r.id_puesto=p.id AND p.activo=1 "
                            . "INNER JOIN master_franjas_horarias f ON r.id_franja_horaria=f.id AND f.activo=1 "
                            . "INNER JOIN master_usuarios u ON r.id_usuario=u.id AND u.activo=1 ";
                        if ($fecha=='') {
                            $sql.= "WHERE p.id_aula=3 AND p.puesto=".$numpuesto." AND r.activo=1 "
                                . "AND YEAR(r.fecha)=YEAR(SYSDATE()) AND MONTH(r.fecha)=MONTH(SYSDATE()) AND DAY(r.fecha)=DAY(SYSDATE()) "
                                . "AND f.inicio=HOUR(SYSDATE())";
                        } else {
                            $sql.= "WHERE p.id_aula=3 AND p.puesto=".$numpuesto." AND r.activo=1 "
                                . "AND YEAR(r.fecha)=YEAR('".$fecha."') AND MONTH(r.fecha)=MONTH('".$fecha."') AND DAY(r.fecha)=DAY('".$fecha."') "
                                . "AND f.inicio=HOUR('".$fecha."')";
                        }
                        //writeLog($sql);
                        $consulta = db_query($sql, $sql_connect);
                        if (!$consulta) {
                            exit("No se ha podido acceder a la base de datos (getPuestos4).");
                        } elseif($consulta->num_rows>0){
                            $reserva = $consulta->fetch_array();
                            if ($estado>0) {$estado+=2;}
                            else {
                                //El puesto está reservado pero no hay registro de su estado en ese minuto:
                                $estado=5;
                            }
                            
                            $usuario="";
                            if ($_SESSION["stubia_userperfil"]!=="Alumno" && $_SESSION["stubia_userperfil"]!=="Profesor") {
                                $usuario= " por ".$reserva["nombre"]." ".$reserva["apellidos"];
                            }
                        }
                    }
                }else {$estado=-1;}

                ?>
                <td align="center" class='table-<?php
                    switch ($estado) {
                        case -1:
                            echo "active' style='border:0px'> <div data-tip='estado desconocido'>";
                            break;
                        case 1:
                            if ($fecha=='') {
                                echo "danger'> <div data-tip='ocupado'>";
                            } else {
                                echo "default'> <div data-tip='ocupado'>";
                            }
                            break;
                        case 2:
                            if ($fecha=='') {
                                echo "success'> <div data-tip='libre'>";
                            } else {
                                echo "default'> <div data-tip='libre'>";
                            }                            
                            break;
                        case 3:
                            echo "warning'> <div data-tip='reservado (y ocupado)" .$usuario."'>";
                            break;
                        case 4:
                            echo "warning'> <div data-tip='reservado (sin ocupar)".$usuario."'>";
                            break;
                        case 5:
                            echo "warning'> <div data-tip='reservado".$usuario."'>";
                            break;
                        default:
                            if ($fecha=='') {                                                                
                                echo "default'> <div data-tip='estado desconocido'>";
                            } else {
                                echo "default'>";
                            }
                    }                
                if ($col!=$pasillo) {
                    echo $numpuesto;
                } else echo "&nbsp";                
                ?>
                </div>
                </td>
                <?php
            }?>
            <td class="table-active strong" style="border:0px; color:<?=$aula["color"]?>"><?=($aula['tipo_aula']=='Laboratorio' && $fil==(intval($aula["filas"]/2)+1))?'Mesa profe':'&nbsp;'?></td> <!--columna pasillo derecho-->
            <?php
            if ($aula['tipo_aula']=='Laboratorio' && $fil<$aula["filas"]){
                echo ("<tr><td colspan='".($columnas+1)."' class='table-active' style='border:0px'>&nbsp;</td></tr>");
            }
            if ($aula['tipo_aula']=='Biblioteca' && (($fil % 2) == 0) && $fil<$aula["filas"]){
                echo ("<tr><td colspan='".($columnas+2)."' class='table-active style='border:0px''>&nbsp;</td></tr>");
            }
        }?>
        </tr>         
        <tr>            
            <td colspan="<?=$columnas+2?>" class="table-active" style="border:0px">&nbsp;</td>
        </tr>
    </tbody>
</table>

</div>

 <?php
    desconectar_bd($sql_connect);
?>