<?php
$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");
require_once($dir_raiz."includes/encabezado.php");


//Si venimos del botón reservar, reservamos:
if(isset($_POST['reservar']) && !empty($_POST['puesto']) && !empty($_POST['fecha'])){
    $puesto=$_POST['puesto'];
    $fecha=$_POST['fecha'];
    $sql_connect = conectar_bd();

    $sql = "INSERT INTO reservas VALUES (id_usuario, id_franja_horaria, fecha, id_puesto, au_fec_alta, au_usu_alta, au_proc_alta) "
         . "VALUES (".$_SESSION["stubia_userid"].", 12, HOUR(".$fecha."), '".$fecha."', ".$puesto.", SYSDATE(), ".$_SESSION["stubia_userid"].", '".$php_actual."');";
    writeLog($sql);
    $insertar = db_query($sql, $sql_connect);
    if (!$insertar) {
        exit ("Se ha producido un error al recuperar las encuestas de base de datos (getRelacionesCalculadas).");
    } 
    //$consulta->free_result();
    desconectar_bd($sql_connect);
    
    //Insert datetime into the database
    /*$name = $db->real_escape_string($_POST['event_name']);
    $datetime = $db->real_escape_string($_POST['event_datetime']);
    $insert = $db->query("INSERT INTO events (name,datetime) VALUES ('".$name."', '".$datetime."')");*/
    
    //Insert status
    if($insertar){
        echo 'Event data inserted successfully. Event ID: '.$sql_connect->insert_id;
    }else{
        echo 'Failed to insert event data.';
    }
}



/*
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $time_res = $_POST["times"];
    $place_res = $_POST["place"]; 
    $zone_res = $_POST["zones"]; 
 
    $previous_res = mysqli_query($link, "SELECT id FROM reservas where id_franja_horaria = ".$time_res." AND id_puesto = ".$place_res." AND fecha = curdate()"); 
    $n_res = 0; 

    while(mysqli_fetch_array($previous_res)){
        $n_res++; 
    }

    if($n_res){
        echo "<script>alert('Error en la reserva. Puesto ocupado en esta franja horaria.');</script>";
    }
    else{
        $user_res = $_SESSION["stubia_useridperfil"]; 

        mysqli_query($link, "INSERT INTO reservas (id_usuario, id_franja_horaria, fecha, id_puesto, au_fec_alta, au_usu_alta, au_proc_alta, au_lock, activo)
        VALUES (".$user_res.", ".$time_res.", curdate(),".$place_res.", now(), ".$user_res.", 'Web', 0, 1)"); 

        echo "<script>alert('Reserva realizada con éxito.');</script>"; 
    }

}*/

require_once($dir_raiz."includes/cabecera.php");
?>

<script type="text/javascript">

<link href="<?=$dir_raiz?>css/datetimepicker.css" rel="stylesheet">
<script src="<?=$dir_raiz?>js/bootstrap-datetimepicker.js"></script>

$(document).ready(function() {  
 
    var timeout = setInterval(refrescaAula, 10000);    
    function refrescaAula () {
        
            var dataString = 'aula=3';
            $.ajax ({
                url: 'getpuestos.php',
                data: dataString,
                cache: false,
                success: function(r) {
                    $("#display").html(r);
                }
            });
    }
    
    $(function () {
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes();
        var dateTime = date+' '+time;
        $("#form_datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
            todayBtn: true,
            startDate: dateTime
        });
    });
});



<script type="text/javascript">

</script>

</script>

<div class="container ">
    <form class="row" action="" method="post">                
        <div>
            <br>
            El estado de los puestos de la biblioteca es la siguiente:
            <br> 
        </div>
        <div class="" id="display">
        <!-- Records will be displayed here -->
        </div>
    </form>    
</div>

<form method="post" action="">
    Puesto: <input type="text" name="puesto" class="form-control">
    Fecha y Hora: <input size="16" type="text" name="fecha" class="form-control" id="form_datetime" readonly>
    <input type="submit" name="btn_reservar" id="btn_reservar" class="btn button btn-success" value="Reservar" />
</form>

<?php
require_once($dir_raiz."includes/pie.php");
?>