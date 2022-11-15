<?php

$con = new mysqli("localhost","root","","stubia"); // Conectar a la BD
$sql = "select * from venta"; // Consulta SQL
$query = $con->query($sql); // Ejecutar la consulta SQL
$data1 = array(); // Array donde vamos a guardar los datos
while($r = $query->fetch_object()){ // Recorrer los resultados de Ejecutar la consulta SQL
    $data1[]=$r; // Guardar los resultados en la variable $data
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafica de Barra y Lineas con PHP y MySQL</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    
</head>
<body>
<h1>Grafica de Barra y Lineas con PHP y MySQL</h1>
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
</body>
</html>