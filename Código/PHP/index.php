<?php

$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");
require_once($dir_raiz."includes/encabezado.php");

/*
$sql_connect = conectar_bd();
$sql = "select * from venta"; // Consulta SQL
$query = $sql_connect->query($sql); // Ejecutar la consulta SQL
$data1 = array(); // Array donde vamos a guardar los datos
while($r = $query->fetch_object()){ // Recorrer los resultados de Ejecutar la consulta SQL
    $data1[]=$r; // Guardar los resultados en la variable $data
}
desconectar_bd($sql_connect);
writeLog($sql);
*/
require_once($dir_raiz."includes/cabecera.php");

?>

<!--
<script src="js/chartjs/chart.js"></script>
<canvas id="grafico1" style="width:100%;" height="300"></canvas>

<script>

    var ctx1 = document.getElementById("grafico1");
    var data1 = {
            labels: [ 
            <?php foreach($data1 as $d):?>
                "<?php echo $d->date_at?>", 
            <?php endforeach; ?>
            ],
            datasets: [{
                label: '$ Ocupación de aulas',
                data: [
            <?php foreach($data1 as $d):?>
                <?php echo $d->val;?>, 
            <?php endforeach; ?>
                ],
                backgroundColor: "#3898db",
                borderColor: "#9b59b6",
                borderWidth: 2
            }]
        };
    var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        };
    var grafico1 = new Chart(ctx1, {
        type: 'bar',
        data: data1,
        options: options
    });
</script>
-->
<div class="container">
    <br>
    <div class="text-justify"><span style="font:1.25vw din_regular;">Bienvenido a STUBIA, la aplicación en fase de prototipo que pretende epxlicar cómo se podría digitalizar
     la ocupación de los puestos de estudio de la Universidad de Alcalá situados en aulas, zonas comunes y biblioteca. El objeto de este prototipo es ejemplarizar un posible 
     despliegue de computación ubícua en esta Universidad.</span></div>
    <div><img src="img/cu.png" width="25%"></div>
    <div class="text-center">
    
    <?php
    /*
    echo getAforoTipoAula(1);
    echo "<br>";
    $valor= getEstadoPuesto(1,1,'2022-11-11',12);
    echo $valor[1];
    echo "<br>";
    echo $valor[2];
    echo "<br>";
    echo date("H");
    echo "<br>";
    */
    switch ($_SESSION["stubia_useridperfil"]) {
        case "1":
            echo ("<br>");
            echo ("<a class='btn btn-primary' href='aula.php' role='button'>Consultar el  estado de un aula</a><br>");
            echo ("<br>");
            echo ("<a class='btn btn-primary href=' role='button'>Consultar las estadísticas globales</a><br>");
            echo ("<br>");
            echo ("<a class='btn btn-primary href=' role='button'>Consultar las reservas de biblioteca</a>");
            break;
        case "2";
            echo ("<a class='btn btn-primary href=' role='button'>Consultar la ocupación de la biblioteca</a><br>");
            echo ("<a class='btn btn-primary href=' role='button'>hacer una reserva</a>");            
            break;
        case "3";
            break;
        case "4";
            break;
    }
    ?>
    </div>
</div>
<?php
require_once($dir_raiz."includes/pie.php");
?>
