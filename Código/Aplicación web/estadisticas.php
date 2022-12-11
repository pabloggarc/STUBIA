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
        id=$(this).find(":selected").val();
        switch(parseInt(id)){            
            case 1:
                document.getElementById("capa_fecha").style.display="none";
                document.getElementById("display").style.display="block";
                $.ajax ({
                    url: 'getDatosGlobales.php',
                    cache: false,
                    success: function(r) {
                        $("#display").html(r);
                    } 
                });
                break;                
            case 2:
                document.getElementById("capa_fecha").style.display="block";
                document.getElementById("display").style.display="none";       
                break;
                            
        }
    })

    var timeout = setInterval(refrescaGrafica, <?=_TIEMPO_REFRESCO?>);
    function refrescaGrafica () {
        id=$("#combo_grafica").find(":selected").val();
        switch(parseInt(id)){            
            case 1:
                document.getElementById("capa_fecha").style.display="none";
                document.getElementById("display").style.display="block";
                $.ajax ({
                    url: 'getDatosGlobales.php',
                    cache: false,
                    success: function(r) {
                        $("#display").html(r);
                    } 
                });
                
                document.getElementById("capa_fecha").style.display="none";
                break;
            case 2:
                document.getElementById("capa_fecha").style.display="block";       
                break;            
        }
    }

    document.getElementById("capa_fecha").style.display="none";
    
    $('#sel_fecha').datetimepicker({                    
        format: 'YYYY-MM-DD'  
        //language: 'es',                
    }).on('dp.change', function(d){
        if (document.getElementById("display")) {
            document.getElementById("display").style.display="block";            
            var dataString = {fecha:d.date.format(d.date._f)};
            $.ajax ({
                url: 'getGraficaBiblioteca.php',
                data: dataString,
                cache: false,
                success: function(r) {
                    $("#display").html(r);
                }
            });
        }
    });
    
});

</script>
    
<div class="container" style="width:66vw">
    <div class="row">
        <div class="form-group col-lg-4">
            <br>
            <label for="combo_grafica">Selecccione la estadística a consultar:</label>
            <select name="combo_grafica" id="combo_grafica" class="form-select form-select-lg lg-2" aria-label="Default select example">
                <option selected>Seleccione gráfica:</option>
                <option value="1">Estadísticas globales</option>
                <option value="2">Ocupación diaria de la biblioteca</option>
            </select>
        </div>
        
        <div class='col-lg-2'>
                                   
        </div>
        
        <div class='col-lg-4' id="capa_fecha" name="capa_fecha">
            <br>
            <label for="combo_grafica">Selecciona la fecha de la gráfica:</label>            
            <div class='input-group date' id='sel_fecha'>
                <input type='text' class="form-control" id="input_fecha" value=""/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <br>                       
        </div>  
    </div>
    <div id="display">
        <!-- Aquí mostraremos el contenido -->       
        
    </div>    
</div>

<?php
require_once($dir_raiz."includes/pie.php");
?>
