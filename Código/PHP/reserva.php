
<?php
$dir_raiz = "";

require_once($dir_raiz."includes/session_app.php");
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");
require_once($dir_raiz."includes/encabezado.php");

$horas_habilitadas = getFranjasHorarias();
$resultado="";
$reservas = array();
$hay_reservas=false;

$sql_connect = conectar_bd();

//Si venimos del botón reservar, comprobamos si todo es OK. Si es OK, reservamos:
if(isset($_POST['btn_reservar']) && !empty($_POST['hid_puesto']) && !empty($_POST['hid_fecha'])){    
    $puesto=$_POST['hid_puesto']; //Es el puesto absoluto de la tabla master_puestos (id_puesto). No es el puesto relativo del aula. 
    $fecha=$_POST['hid_fecha'];
    $localizador=getLocalizador();
    writeLog("Puesto: ".$puesto.", fecha: ".$fecha.".");

    //Primero comprobamos que el alumno no haya reservado ya algún puesto ese mismo día y hora:
    $sql = "SELECT r.id FROM reservas r "
        . "INNER JOIN master_puestos p ON r.id_puesto=p.id AND p.activo=1 "
        . "INNER JOIN master_franjas_horarias f ON r.id_franja_horaria=f.id AND f.activo=1 "    
        . "WHERE p.id_aula=3 AND r.id_usuario=".$_SESSION["stubia_userid"]." AND r.activo=1 "
            . "AND YEAR(r.fecha)=YEAR('".$fecha."') AND MONTH(r.fecha)=MONTH('".$fecha."') AND DAY(r.fecha)=DAY('".$fecha."') "
            . "AND f.inicio=HOUR('".$fecha."')";    
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    writeLog($consulta->num_rows);    
    if (!$consulta) { 
        $resultado="Tu reserva no ha podido ser realizada, por favor inténtalo de nuevo. Disculpa la molestia";
        $color_res="red";
    } elseif($consulta->num_rows>0){        
        //$consulta->free_result();
        $resultado="Lo sentimos, no se puede reservar más de un puesto en la misma fecha y hora (".date_format(date_create($fecha),'d/m/Y H:i').").";
        $color_res="red";
    } else {    //El alumno no tiene alguna otra reserva a esa hora, ahora vamos a ver si tiene más del máximo permitido por día:
        $sql = "SELECT r.id FROM reservas r "
        . "INNER JOIN master_puestos p ON r.id_puesto=p.id AND p.activo=1 "
        . "INNER JOIN master_franjas_horarias f ON r.id_franja_horaria=f.id AND f.activo=1 "    
        . "WHERE p.id_aula=3 AND r.id_usuario=".$_SESSION["stubia_userid"]." AND r.activo=1 "
            . "AND YEAR(r.fecha)=YEAR('".$fecha."') AND MONTH(r.fecha)=MONTH('".$fecha."') AND DAY(r.fecha)=DAY('".$fecha."') ";
        writeLog($sql);
        $consulta = db_query($sql, $sql_connect);
        writeLog($consulta->num_rows);    
        if (!$consulta) { 
            $resultado="Tu reserva no ha podido ser realizada, por favor inténtalo de nuevo. Disculpa la molestia.";
            $color_res="red";
        } else {
            if ($consulta->num_rows>=MAX_RESERVAS_DIA) {
                $resultado="Lo sentimos, no se pueden reservar más de 4 horas por día en la biblioteca un puesto en la misma fecha y hora (".date_format(date_create($fecha),'d/m/Y H:i').").";
                $color_res="red";
            } else { // Ahora sí: el alumno cumple para reservar: no tiene reservas hechas en ese mismo día y hora, y está por debajo del cupo máximo dirario. Procedemos:
                $sql = "INSERT INTO reservas (id_usuario, id_franja_horaria, fecha, id_puesto, localizador, au_usu_alta, au_proc_alta) "
                    . "VALUES (".$_SESSION["stubia_userid"].", HOUR('".$fecha."'), '".$fecha."', ".$puesto.", '".$localizador."', ".$_SESSION["stubia_userid"].", '".php_actual()."');";
                writeLog($sql);
                $insertar = db_query($sql, $sql_connect);                    
                if($insertar){
                    //Recupero el puesto relativo del aula mediante el id_puesto pasado por POST:
                    $sql = "SELECT puesto FROM master_puestos WHERE id=".$puesto.";";
                    $consulta = db_query($sql, $sql_connect);
                    $fila = $consulta->fetch_array();
                    if ($consulta) {
                        $puesto= $fila["puesto"];
                    }
                    //Recupero el nombre y email del alumno:
                    $sql = "SELECT nombre, email FROM master_usuarios WHERE id=".$_SESSION["stubia_userid"].";";
                    writeLog($sql);
                    $consulta = db_query($sql, $sql_connect);
                    if ($consulta) { //Hemos guardado la reserva en BD, enviamos el email:
                        $fila = $consulta->fetch_array();
                        $asunto= "Reserva biblioteca UAH";
                        $mensaje= "<html style='background-color: #fff; color: #000;font-family:arial,verdana,calibri;font-size:12px;'><body>";
                        $mensaje.= "Buenos d&iacute;as, ".$fila['nombre']."<br><br>";
                        $mensaje.= "Te informamos que el proceso de reserva de tu puesto de estudio ha finalizado con &eacute;xito. Los datos de tu reserva son los siguientes:<br>";
                        $mensaje.= "<ul><li>Fecha y hora: ".date_format(date_create($fecha),'d/m/Y H:i')." (1 hora de duraci&oacute;n).</li>";        
                        $mensaje.= "<li>Puesto: ".$puesto."</li>"; 
                        $mensaje.= "<li>Localizador: ".$localizador."</li></ul><br>"; 
                        $mensaje.= "Si finalmente no fueras a ocupar el puesto, te rogamos que anules tu reserva lo antes posible.<br><br>";
                        $mensaje.= "Atentamente,<br><br>";
                        $mensaje.= "<img src='http://"._APP_URL."/img/stubia-logo2.png' height='80'>";
                        $mensaje.= "</body></html>";                        
                        if (enviar_mail($fila["email"], $asunto, $mensaje)){
                            $resultado="Tu reserva ha sido realizada con éxito, en breve recibiras un correo con el localizador de la reserva.";
                            $color_res="green";
                        }else{
                            $resultado="Tu reserva ha sido realizada con éxito, pero hubo un problema al enviarte el correo con el localizador de la reserva.<br>"
                                        ."Tu localizador de reserva es el ".$localizador;
                            $color_res="yellow";
                        }
                    } else {
                        $resultado="Tu reserva ha sido realizada con éxito, pero no se puedo encontrar tu dirección de correo en el sistema.<br>"
                                        ."Tu localizador de reserva es el ".$localizador;
                        $color_res="yellow";
                    }
                    //$consulta->free_result();
                } else {
                    $resultado="Tu reserva no ha podido ser realizada, por favor inténtalo de nuevo. Disculpa la molestia";
                    $color_res="red";
                }
            }
        }
        //$consulta->free_result();
    }
    $consulta->free_result();
}



//Siempre al cargar comprobamos las próximas reservas activas de alumno:
$sql = "SELECT r.id, r.fecha, f.inicio, p.puesto FROM reservas r "
        . "INNER JOIN master_puestos p ON r.id_puesto=p.id AND p.activo=1 "
        . "INNER JOIN master_franjas_horarias f ON r.id_franja_horaria=f.id and f.activo =1 "    
        . "WHERE p.id_aula=3 AND r.id_usuario=".$_SESSION["stubia_userid"]." AND r.activo=1 "
        . "AND YEAR(r.fecha)>=YEAR(SYSDATE()) AND MONTH(r.fecha)>=MONTH(SYSDATE()) AND DAY(r.fecha)>=DAY(SYSDATE()) "
        . "ORDER BY r.fecha, f.inicio";

writeLog($sql);
$consulta = db_query($sql, $sql_connect);
if (!$consulta) { 
    $resultado="Tu reserva no ha podido ser realizada, por favor inténtalo de nuevo. Disculpa la molestia";
    $color_res="red";    
} elseif($consulta->num_rows>0){
    $hay_reservas=true;
    while ($fila = $consulta->fetch_array()) {
        $reservas[] = $fila;        
    }    
}
$consulta->free_result();

desconectar_bd($sql_connect);

require_once($dir_raiz."includes/cabecera.php");

?>

<script type="text/javascript">

$(document).ready(function() {  
    
    document.getElementById("display").style.display="none";
    document.getElementById("capa_sel_puestos").style.display="none";
    document.getElementById("capa_reservar").style.display="none";
    document.getElementById("input_fecha").value="";
   
    //Para hacer que la capa que informa del resultado de la reserva desaparaezca a ls pocos segundos:
    setTimeout(function() {
		// Declaramos la capa mediante una clase para ocultarlo
        $(".mensaje").fadeOut(2000);        
    },5000);

});

</script>

<div class="container">
    
    <div class="mensaje row <?=$resultado!=''?'oculto':''?>" id="mensaje" name="mensaje">
        <div class="col-md-8 center-block">
            <span style="@font-face {
                    font-family: din_regular;
                    src: url(fuentes/DINPro-Medium.otf);
                }font-weight:bold; color:<?=$color_res?>"><?=$resultado?>
            </span>
        </div>
    </div>

    <script type="text/javascript">

        $(function () {
            /*
            var ahora = new Date();
            var fecha = ahora.getFullYear()+'-'+(ahora.getMonth()+1)+'-'+ahora.getDate();
            var hora = ahora.getHours() + ":" + ahora.getMinutes();
            var dateTime = fecha+' '+hora;
            */
            $('#sel_fecha').datetimepicker({                    
                format: 'YYYY-MM-DD HH:00',  //ponemos el 00 para que no salgan los minutos
                //language: 'es',
                enabledHours: [<?=$horas_habilitadas?>] //cargamos dinámicamente la lista de horas activas en BD: 8, 9, 10, 11, 12, 13, etc                
            }).on('dp.change', function(d){
                document.getElementById("display").style.display="block";
                document.getElementById("capa_sel_puestos").style.display="block";
                document.forms["frm_reservar"].hid_fecha.value = d.date.format(d.date._f);            
                var dataString = {aula: '3', fecha:d.date.format(d.date._f)};
                $.ajax ({
                    url: 'getpuestos.php',
                    data: dataString,
                    cache: false,
                    success: function(r) {
                        $("#display").html(r);
                    }
                });
                
                var dataString2 = {aula: '3', fecha:d.date.format(d.date._f)};
                $.ajax ({
                    url: 'getPuestosLibres.php',    //en este php es donde pongo el evento change del select para que se muestre el botón Reservar
                    data: dataString2,
                    cache: false,
                    success: function(r) {
                        $("#capa_sel_puestos").html(r);
                    }
                });                

            });            
        });

    </script>    

    <label id="input_dia"></label>
    <label id="input_hora"></label> 
    
    <div class="row">
        <?php
        if (count($reservas)>0) {
        ?>    
        <div class='col-md-4'>
            <button type="button" class="list-group-item list-group-item-action disabled ">
                Tus próximas <?=count($reservas)>5?'5 ':''?>reservas en la biblioteca:
            </button>
            <ul class="list-group">         
                <?php
                $contador=0;
                foreach ($reservas as $res) {
                    $contador++;
                    if ($contador<=5) {
                        echo ("<li class='list-group-item d-flex justify-content-between align-items-center'>&nbsp;&nbsp;&nbsp;"
                            . date_format(date_create($res['fecha']),'d/m/Y')." ".$res['inicio'].":00 horas."
                            . "<span class='badge badge-warning badge-pill'>Puesto ".$res['puesto']."</span></li>");
                    } elseif ($contador==6) {
                        echo ("<li class='list-group-item d-flex justify-content-between align-items-center'>&nbsp;&nbsp;&nbsp;Tienes ". (count($reservas)-5) ." más...</li>");
                    }
                }
                ?>
            </ul>          
        </div>
        <?php 
        }
        ?>
        
        <div class='col-md-4'>
            Selecciona fecha y hora para consultar la disponibilidad de los puestos:
            <div class='input-group date' id='sel_fecha'>
                <input type='text' class="form-control" id="input_fecha" value=""/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <br>                       
        </div>        

        <div class='col-md-3' id='capa_sel_puestos'>
            <!-- el contenido lo carga getPuestosLibres.php -->
        </div>

        <div class="form-group col-sm-1" id="capa_reservar">
            <br><br>                        
            <form method='post' action='' id='frm_reservar'>    
                <input  type='submit' name='btn_reservar' id='btn_reservar' class='btn button btn-warning' value='Reservar' 
                        onclick="return confirm('¿Confirmas que desea RESERVAR el puesto de estudio?')"/>
                <input  type='hidden' name='hid_fecha' id='hid_fecha'>
                <input  type='hidden' name='hid_puesto' id='hid_puesto'>                
            </form>
        </div>
        
    </div>

    <div class="row" id="display">
        <!-- el contenido lo carga getPuestos.php -->
    </div>   
    
</div>

<?php
    require_once($dir_raiz."includes/pie.php");
?>