<?php
require_once "config.php";
session_start();  
 
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

}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>STUBIA - Registro</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        @font-face {
            font-family: din_regular;
            src: url(fuentes/DINPro-Medium.otf);
        }

        body{ 
            font: 14px din_regular; 
        }

        .wrapper{ 
            width: 360px; padding: 20px; 
        }

    </style>
</head>
<body class="m-0 vh-100 row justify-content-center align-items-center">
    <?php
        $zones = mysqli_query($link, "SELECT id, aula FROM master_aulas WHERE tipo != 1 AND tipo != 2"); 
        $times = mysqli_query($link, "SELECT id, time_format(hora, '%H:%i') FROM (SELECT id, TIME(substring_index(franja, '-', 1)) AS hora FROM (SELECT id, franja FROM stubia.master_franjas_horarias) AS t) AS t2 where hora>=now()"); 
    ?>
    <div class="wrapper col-auto p-5 opacity-50">
        <img src="img/stubia-logo.png" height=270px>
    </div>
    <div class="wrapper col-auto p-5">
        <h2>Reserva un puesto</h2>
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Zona</label>
                <select name="zones" class="form-control">
                    <?php
                        while($zones_values = mysqli_fetch_array($zones)){
                            echo '<option value="'.$zones_values["id"].'">'.$zones_values["aula"].'</option>'; 
                        }
                    ?>
                </select>
            </div>
            <br>   
            <div class="form-group">
                <label>Puesto</label>
                <input type="text" name="place" class="form-control">
            </div>
            <br>
            <div class="form-group">
                <label>Franja horaria</label>
                <select name="times" class="form-control">
                    <?php
                        while($times_values = mysqli_fetch_array($times)){
                            echo '<option value="'.$times_values["id"].'">'.$times_values["franja"].'</option>'; 
                        }
                    ?>
                </select>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Solicitar reserva">
                <input type="reset" class="btn btn-secondary ml-2" value="Borrar">
            </div>
            <br>
        </form>
    </div>    
</body>
</html>