
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
        <?php
        if ($_SESSION["stubia_mostrarVideo"]) {
            echo ("document.getElementById('video').style.display='block';
                /*document.getElementById('intro').style.display='none';
                document.getElementById('opciones').style.display='none';*/");
            $_SESSION["stubia_mostrarVideo"]=false;
        } else {
            echo ("document.getElementById('video').style.display='none';
                $('#opciones').fadeIn(2000);
                $('#intro').fadeIn(2000);");
        }
        ?>
    });
    /*
    $('.carousel').carousel({
        interval: 2000
    })*/
    setTimeout(function() {
		// Declaramos la capa mediante una clase para ocultarlo
        $("#video").fadeOut(4000);
        $("#opciones").fadeIn(4000);
        $("#intro").fadeIn(4000);
    },26000);
</script>

        <div class="container" style="width:66vw">
            
            <br>

            <div class="row" name="video" id="video">
                <video width="720px" height="480px" autoplay muted>
                    <source src="img/stubia.mp4" type="video/mp4">                
                    Your browser does not support the video tag.
                </video> 
            </div>

            <div class="row" name="intro" id="intro">
                <div class="col-md text-justify">
                    <br>    
                    Bienvenido a STUBIA, la aplicación en fase de prototipo que pretende explicar cómo se podría digitalizar
                    la ocupación de los puestos de estudio de la Universidad de Alcalá situados en aulas, zonas comunes y biblioteca. El objeto de este prototipo es ejemplarizar un posible 
                    despliegue de computación ubicua en esta universidad.
                </div>                
            </div>
            
            <br>
            
            <!--
            <div class="row">
                <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
                    
                    <ol class="carousel-indicators">
                        <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>
                        <li data-bs-target="#myCarousel" data-bs-slide-to="1"></li>
                        <li data-bs-target="#myCarousel" data-bs-slide-to="2"></li>
                    </ol>
                    
                    
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="img/arduino.jpg" class="d-block w-50" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img src="img/montaje.jpg" class="d-block w-50" alt="Slide 2">
                        </div>
                        <div class="carousel-item">
                            <img src="img/uah-logo.png" class="d-block w-50" alt="Slide 3">
                        </div>
                    </div>
                    
                    <a class="carousel-control-prev" href="#myCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
            -->
            
            <div class="row" name="opciones" id="opciones">

                <div class="col-md">
                    <img src="img/montaje.jpg" width="100%">
                </div>
            
                <div class="col-md text-justify-content-center">
                    Tu perfil te permite hacer las siguientes opciones:<br>
                    <?php
                    switch ($_SESSION["stubia_useridperfil"]) {
                        case "1":
                    ?> 
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar el estado de un aulas y/o puestos de estudio" onclick="location.href = 'aula.php'"><br>
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar estadísticas globales" onclick="location.href = 'estadisticas.php'"><br>
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar y hacer reservas en la biblioteca" onclick="location.href = 'reserva.php'"><br>
                            <br>
                            <br>
                            <br>
                            <input type="button" class="btn btn-danger" value="Generar accesos aleatorios para la hora actual" onclick="location.href = 'scripts/insertar_estados_aleatorios.php'"><br>
                            <br>
                            <input type="button" class="btn btn-danger" value="Generar reservas aleatorias para el día actual" onclick="location.href = 'scripts/insertar_reservas_aleatorias.php'"><br>
                            
                    <?php
                            break;
                        case "2";
                    ?>                    
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar el estado de las mesas de estudio" onclick="location.href = 'aula.php'"><br>
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar y hacer reservas en la biblioteca" onclick="location.href = 'reserva.php'"><br>
                    <?php
                            break;
                        case "3";
                            break;
                        case "4";
                    ?>
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar el estado de un aulas y/o puestos de estudio" onclick="location.href = 'aula.php'"><br>
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar estadísticas globales" onclick="location.href = 'estadisticas.php'"><br>
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar reservas en la biblioteca" onclick="location.href = 'reserva.php'"><br>
                    <?php   break;                     
                    }
                    ?>
                </div>
            </div>
            <br>
        </div>
<?php
require_once($dir_raiz."includes/pie.php");
?>
