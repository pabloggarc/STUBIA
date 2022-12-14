<?php

$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");
require_once($dir_raiz."includes/encabezado.php");

$sql_connect = conectar_bd();
$sql = "select * from master_aulas"; // Consulta SQL
writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error al recuperar las encuestas de base de datos (getRelacionesCalculadas).");
} //else {
            
//}
//$consulta->free_result();
desconectar_bd($sql_connect);

require_once($dir_raiz."includes/cabecera.php");

?>

<script type="text/javascript">
$(document).ready(function() {  
 
 // code to get all records from table via select box
    $("#combo_aulas").change(function() {    
        var id = $(this).find(":selected").val();
        if (id>0){
            //var dataString = 'aula='+ id;
            var dataString = {aula: id, fecha:''};
            $.ajax ({
                url: 'getpuestos.php',
                data: dataString,
                cache: false,
                success: function(r) {
                    $("#display").html(r);
                } 
            });
        }
    })

    var timeout = setInterval(refrescaAula, <?=_TIEMPO_REFRESCO?>);    
    function refrescaAula () {
        var id = $("#combo_aulas").find(":selected").val();
        if (id>0){
            //var dataString = 'aula='+ id;
            var dataString = {aula: id, fecha:''};
            $.ajax ({
                url: 'getpuestos.php',
                data: dataString,
                cache: false,
                success: function(r) {
                    $("#display").html(r);
                }
            });
        }
    }
    // code to get all records from table via select box
});

</script>
    
<div class="container" style="width:66vw">
    <form class="row" action="" method="post">
        <div class="form-group col-lg-3">
            <br>
            Selecccione el aula a consultar:
            <select name="combo_aulas" id="combo_aulas" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option value=0>Seleccione ubicación:</option>";
                <?php
                    while ($aulas = $consulta->fetch_array()) {
                        $aula[]=$aulas;
                        //Gestión
                        if ($_SESSION["stubia_userperfil"] !== "Alumno" || ($_SESSION["stubia_userperfil"] == "Alumno" && $aulas["tipo"]>=3 ))  {
                            echo "<option value=".$aulas["id"].">".$aulas["aula"]."</option>";
                        }                        
                    } 
                ?>
            </select>
        </div>
        <br>        
        <div class="centrado" id="display">
        <!-- aqui cargamos la respuesta de Ajax -->        
        </div>
    </form>    
</div>

<?php
require_once($dir_raiz."includes/pie.php");
?>
