
<?php


date_default_timezone_set('Europa/Madrid');
//setlocale(LC_TIME, 'es_ES.UTF-8'); //Linux
setlocale(LC_TIME, 'spanish.UTF-8'); //Windows
$fecha=time();
$fecha_es= strtotime($fecha);
$fecha_es=strftime("%A, %d de %B de %Y, %H:%M:%S", $fecha);


$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");

/*$id_aula = $_REQUEST['aula'];
$fecha= $_REQUEST['fecha'];
//echo ($fecha);*/
$aforo=$aulas=$tipos_puesto=$tipos_aula=$libres=$ocupados=$reservas=0;

$sql_connect = conectar_bd();

//Recupero datos generales de los puestos:
$sql = "SELECT count(mp.id) as aforo, count(distinct(mp.id_aula)) as numaulas, count(distinct(mta.id)) as tipos_aula, count(distinct(mp.id_tipo)) as tipos_puesto FROM master_puestos mp "
        . "INNER JOIN master_aulas ma ON mp.id_aula=ma.id AND ma.activo=1 "
        . "INNER JOIN master_tipo_aula mta ON ma.tipo=mta.id AND mta.activo=1 "
        . "WHERE mp.activo=1;";
writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error al recuperar datos de base de datos (".php_actual().")1.");
}elseif($consulta->num_rows > 0){
    $fila=$consulta->fetch_array();
    $aforo=$fila["aforo"];
    $aulas=$fila["numaulas"];
    $tipos_aula=$fila["tipos_aula"];
    $tipos_puesto=$fila["tipos_puesto"];
}
$consulta->free_result();

//Puestos libres y ocupados
$sql = "SELECT count(IF(estado=1,1,null)) as ocupados, count(IF(estado=2,1,null)) as libres FROM estados "
        ."WHERE YEAR(au_fec_alta)=YEAR(SYSDATE()) AND MONTH(au_fec_alta)=MONTH(SYSDATE()) AND DAY(au_fec_alta)=DAY(SYSDATE()) AND HOUR(au_fec_alta)=HOUR(SYSDATE()) AND MINUTE(au_fec_alta)=MINUTE(SYSDATE());";
writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error al recuperar datos de base de datos (".php_actual().")2.");
}elseif($consulta->num_rows > 0){
    $fila=$consulta->fetch_array();
    $libres=$fila["libres"];
    $ocupados=$fila["ocupados"];    
}
$consulta->free_result();

//Puestos reservas
$sql = "SELECT count(r.id) as numreservas FROM reservas r "
    . "INNER JOIN master_puestos p ON r.id_puesto=p.id AND p.activo=1 "
    . "INNER JOIN master_franjas_horarias f ON r.id_franja_horaria=f.id AND f.activo=1 "
    . "INNER JOIN master_usuarios u ON r.id_usuario=u.id AND u.activo=1 "
    . "WHERE p.id_aula=3 AND r.activo=1 "
    . "AND YEAR(r.fecha)=YEAR(SYSDATE()) AND MONTH(r.fecha)=MONTH(SYSDATE()) AND DAY(r.fecha)=DAY(SYSDATE()) "
    . "AND f.inicio=HOUR(SYSDATE())";
writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) {
    exit ("Se ha producido un error al recuperar datos de base de datos (".php_actual().")3.");
}elseif($consulta->num_rows > 0){
    $fila=$consulta->fetch_array();
    $reservas=$fila["numreservas"];    
}
$consulta->free_result();


?>

<div class="row d-flex align-items-center text-center">
    <BR>
    <label><?php echo $fecha_es ?></label>
    <BR>
</div>
<div class="row d-flex align-items-center">
    <div class='col-md-5'>

        <div class="row border-bottom">
            <div class='col-md-9 d-flex align-items-center'>
                Aforo (puestos de estudio ubicuos) del centro:
            </div>
            <div class='col-md-3 d-flex align-items-center'>
                <span style='font-size:3em'><?=$aforo?></span>
            </div>
        </div>
        
        <div class="row border-bottom">
            <div class='col-md-9 d-flex align-items-center'>
            Número de aulas del centro con puestos de estudio ubicuos:
            </div>
            <div class='col-md-3 d-flex align-items-center'>
                <span style='font-size:3em'><?=$aulas?></span>
            </div>
        </div>

        <div class="row border-bottom">
            <div class='col-md-9 d-flex align-items-center'>
            Tipos de aula con sensores de ocupación:
            </div>
            <div class='col-md-3 d-flex align-items-center'>
                <span style='font-size:3em'><?=$tipos_aula?></span>
            </div>
        </div>

        <div class="row">
            <div class='col-md-9 d-flex align-items-center'>
            Tipos de puesto con sensores de ocupación:
            </div>
            <div class='col-md-3 d-flex align-items-center'>
                <span style='font-size:3em'><?=$tipos_puesto?></span>
            </div>
        </div>       

    </div>

    <div class='col-md-2'>
    </div>

    <div class='col-md-5'>

        <div class="row text-danger">
            <div class='col-md-9 d-flex align-items-center'>
            Puestos ocupados (minuto actual):
            </div>
            <div class='col-md-3 d-flex align-items-center'>
                <span style='font-size:3em'><?=$ocupados?></span>
            </div>
        </div>

        <div class="row text-success">
            <div class='col-md-9 d-flex align-items-center' >
            Puestos libres (minuto actual):
            </div>
            <div class='col-md-3 d-flex align-items-center'>
                <span style='font-size:3em'><?=$libres?></span>
            </div>
        </div>
              
        <div class="row text-secondary">
            <div class='col-md-9 d-flex align-items-center' >
            Puestos sin respuesta del sensor (minuto actual):
            </div>
            <div class='col-md-3 d-flex align-items-center'>
                <span style='font-size:3em'><?=$aforo-($libres+$ocupados)?></span>
            </div>
        </div>

        <div class="row text-warning">
            <div class='col-md-9 d-flex align-items-center' >
            Puestos reservados en biblioteca (hora actual):
            </div>
            <div class='col-md-3 d-flex align-items-center'>
                <span style='font-size:3em'><?=$reservas?></span>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div id="grafica" class="row d-flex align-items-center" style="width:100%; max-width:100%; height:100vh;">
    <BR>
    
    <BR>
</div>

<script>
    //Google Charts:
    
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Estado', '%'],            
            ['Ocupados',<?=$ocupados?>],
            ['Libres',<?=$libres?>],
            ['Sin respuesta',<?=$aforo-($libres+$ocupados)?>]
        ]);

        var options = {
            title:'Ocupación de los puestos de estudio ubicuos',
            is3D:true,
            colors: ['#dc3545','#28a745','#6c757d']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafica'));
        chart.draw(data, options);
    }
    
</script>


