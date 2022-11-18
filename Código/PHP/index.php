<?php

$dir_raiz = "";

require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");
require_once($dir_raiz."includes/encabezado.php");

$sql_connect = conectar_bd();
$sql = "select * from venta"; // Consulta SQL
$query = $sql_connect->query($sql); // Ejecutar la consulta SQL
$data1 = array(); // Array donde vamos a guardar los datos
while($r = $query->fetch_object()){ // Recorrer los resultados de Ejecutar la consulta SQL
    $data1[]=$r; // Guardar los resultados en la variable $data
}
desconectar_bd($sql_connect);
writeLog($sql);

require_once($dir_raiz."includes/cabecera.php");

?>

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
                label: '$ Ventas',
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
<div class="container ">
    <?php
    echo getAforoTipoAula(1);
    echo "<br>";
    $valor= getEstadoPuesto(1,1,'2022-11-11',12);
    echo $valor[1];
    echo "<br>";
    echo $valor[2];
    echo "<br>";
    echo date("H");
    echo "<br>";
    switch ($_SESSION["stubia_useridperfil"]) {
        case "1":
            echo ("<br>");
            echo ("<a class='btn btn-primary href=' role='button'>Cosultar el  estado de un aula</a><br>");
            echo ("<br>");
            echo ("<a class='btn btn-primary href=' role='button'>Cosultar las estadísticas globales</a><br>");
            echo ("<br>");
            echo ("<a class='btn btn-primary href=' role='button'>Cosultar las reservas de biblioteca</a>");
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
<?php
require_once($dir_raiz."includes/pie.php");
?>
