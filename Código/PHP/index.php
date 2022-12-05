
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
        //document.$("#opciones").style.display="none";
        document.getElementById("intro").style.display="none";
        document.getElementById("opciones").style.display="none";
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


        <div class="container">
            
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
                    Bienvenido a STUBIA, la aplicación en fase de prototipo que pretende epxlicar cómo se podría digitalizar
                    la ocupación de los puestos de estudio de la Universidad de Alcalá situados en aulas, zonas comunes y biblioteca. El objeto de este prototipo es ejemplarizar un posible 
                    despliegue de computación ubícua en esta Universidad.
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
                    <?php
                    
                    switch ($_SESSION["stubia_useridperfil"]) {
                        case "1":
                    ?> 
                            Tu perfil te permite hacer las siguientes opciones:<br>
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar el estado de un aula" onclick="location.href = 'aula.php'"><br>
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar estadísticas globales" onclick="location.href = 'aula.php'"><br>
                            <br>
                            <input type="button" class="btn btn-info" value="Consultar/hacer reservas de biblioteca" onclick="location.href = 'reserva.php'"><br>
                    <?php   break;
                        case "2";
                    
                            echo ("<a class='btn btn-primary href='' role='button'>Consultar la ocupación de la biblioteca</a><br>");
                            echo ("<a class='btn btn-primary href='' role='button'>hacer una reserva</a>");

                            break;
                        case "3";
                            break;
                        case "4";
                            break;
                    }
                    ?>
                </div>
            </div>
            <br>
        </div>
<?php
require_once($dir_raiz."includes/pie.php");
?>
