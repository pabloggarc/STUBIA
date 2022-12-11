
<?php


$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");

$array_reservas = array();
$array_franjas = array();

$fecha= $_REQUEST['fecha'];
$aforo=0;

$sql_connect = conectar_bd();

//Recupero el aforo:
$sql = "SELECT * FROM master_aulas WHERE aula='Biblioteca';";
writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error al recuperar datos de base de datos (".php_actual().")1.");
} elseif ($consulta->num_rows > 0) {
    $fila = $consulta->fetch_array();
    $aforo = $fila["aforo"];
}
$consulta->free_result();

//Puestos libres y ocupados
$sql = "SELECT * FROM master_franjas_horarias WHERE activo=1;";
writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error al recuperar datos de base de datos (".php_actual().")2.");
} elseif ($consulta->num_rows > 0) {
    while ($fila = $consulta->fetch_array()) {
        $array_franjas[] = $fila;
    }
}
$consulta->free_result();

foreach ($array_franjas as $franja) {
    
    $sql = "SELECT count(r.id) as numreservas FROM reservas r "
        . "INNER JOIN master_puestos p ON r.id_puesto=p.id AND p.activo=1 "
        . "INNER JOIN master_franjas_horarias f ON r.id_franja_horaria=f.id AND f.activo=1 AND r.id_franja_horaria=" . $franja["inicio"]
        . " INNER JOIN master_usuarios u ON r.id_usuario=u.id AND u.activo=1 "
        . "WHERE p.id_aula=3 AND r.activo=1 "
        . "AND YEAR(r.fecha)=YEAR('".$fecha."') AND MONTH(r.fecha)=MONTH('".$fecha."') AND DAY(r.fecha)=DAY('".$fecha."') ";
    writeLog($sql);
    
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("Se ha producido un error al recuperar datos de base de datos (" . php_actual() . ")3.");
    } elseif ($consulta->num_rows > 0) {
        $fila = $consulta->fetch_array();
        $array_reservas[] = $fila;
    } 
    writeLog($fila["numreservas"]);

    
    
}
$consulta->free_result();
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="row d-flex align-items-center text-center">
    <label>El aforo máximo de la biblioteca es de <?=$aforo?> personas simultáneamente</label>
</div>

<div id="grafica" class="row d-flex align-items-center" style="width:100%; max-width:100%; height:auto;">
</div>


<?php
$i = 0;
$valores="";
//Vamos a rellenar el array de valores para los datos de la gráfica:
foreach ($array_franjas as $franja) {    
    $valores.="['";
    $valores.=$franja["inicio"];
    $valores.="h',";
    $valores .= $array_reservas[$i]["numreservas"];
    $valores .= ",'#ffc107']";
    if (count($array_franjas) > $i + 1) {
        $valores .= ",";
    }
    $i++;
}

?>

<script>

    //Google Charts:
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Hora', 'Número de reservas', { role: 'style' } ],
        <?=$valores?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                        { calc: "stringify",
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation" },
                        2]);

        var options = {
        title: "Reservas para este día en la biblioteca:",
        width: 900,
        height: 600,
        bar: {groupWidth: "90%"},
        legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("grafica"));
        chart.draw(view, options);
    }


    
    

 
</script>


