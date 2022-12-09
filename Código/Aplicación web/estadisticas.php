<?php

$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");
require_once($dir_raiz."includes/encabezado.php");

require_once($dir_raiz."includes/cabecera.php");

?>

<script type="text/javascript">
$(document).ready(function() {  
 
 // code to get all records from table via select box
    $("#combo_grafica").change(function() {    
        var id = $(this).find(":selected").val();
        if (id>0){
            //var dataString = 'aula='+ id;
            var dataString = {aula: id, fecha:''};
            $.ajax ({
                url: 'getGrafica.php',
                data: dataString,
                cache: false,
                success: function(r) {
                    $("#display").html(r);
                } 
            });
        }
    })

    var timeout = setInterval(refrescaGrafica, 10000);
    function refrescaGrafica () {
        var id = $(this).find(":selected").val();
        if (id>0){
            //var dataString = 'aula='+ id;
            var dataString = {aula: id, fecha:''};
            $.ajax ({
                url: 'getGrafica.php',
                data: dataString,
                cache: false,
                success: function(r) {
                    $("#display").html(r);
                } 
            });
        }
    }
});

</script>
    
<div class="container">
    <div class="row">
        <div class="form-group col-lg-3">
            <br>
            <label for="combo_grafica">Selecccione la gráfica a consultar:</label>
            <select name="combo_grafica" id="combo_grafica" class="form-select" aria-label="Default select example">
                <option value=0>Seleccione gráfica:</option>";
                <option value=1>Gráfica 1</option>";
                <option value=2>Gráfica 2</option>";
            </select>
        </div>
        <br>        
        <div>
            <br> 
        </div>
        <div class="" id="display">
        <!-- Records will be displayed here -->        
        </div>
    </div>    
</div>

<?php
require_once($dir_raiz."includes/pie.php");
?>
