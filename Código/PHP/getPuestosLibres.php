<?php

$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");

$id_aula = $_REQUEST['aula'];
$fecha= $_REQUEST['fecha'];

$sql_connect = conectar_bd();

//Recupero los puestos libres del aula en esa hora (los puestos que estén dados de alta, ojo):
$sql =  "SELECT id, puesto FROM master_puestos m WHERE id_aula=".$id_aula." AND id NOT IN ("
            . "SELECT p.id from master_puestos p INNER JOIN reservas r ON p.id=r.id_puesto "
            . " AND YEAR(r.fecha)=YEAR('".$fecha."') AND MONTH(r.fecha)=MONTH('".$fecha."') AND DAY(r.fecha)=DAY('".$fecha."') AND r.id_franja_horaria=HOUR('".$fecha."')"
        . ")";
writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error al recuperar las encuestas de base de datos (getPuestos1).");
}elseif($consulta->num_rows > 0){
    writeLog($consulta->num_rows);
    while ($fila = $consulta->fetch_array()) {
        $puestos[] = $fila;        
    }  
}
$consulta->free_result();

?>

<div class="form-group">
    Seleccciona el puesto de estudio que quieres reservar:
    <select name="combo_puestos" id="combo_puestos" class="form-control-lg">
        <option value=0>Seleccione puesto libre:</option>"
        <?php
            foreach ($puestos as $puesto) {                 
                echo "<option value=".$puesto["id"].">".$puesto["puesto"]."</option>";
            } 
        ?>
    </select>              
</div>

<script>
    $("#combo_puestos").change(function() {            
        var id = $(this).find(":selected").val();
        if (id>0){
            document.getElementById("capa_reservar").style.display="block";
            document.forms["frm_reservar"].hid_puesto.value = id;
        } else {
            document.getElementById("capa_reservar").style.display="none";
        }
    })
</script>