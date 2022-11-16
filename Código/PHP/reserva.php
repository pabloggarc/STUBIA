<?php
require_once "config.php";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $time_res = $_POST["times"];
    $place_res = $_POST["place"]; 
    $zone_res = $_POST["zones"]; 
 
    $previous_res = mysqli_query($link, "SELECT reservas.id FROM reservas 
                        INNER JOIN master_puestos ON reservas.id_puesto = master_puestos.id
                        where id_franja_horaria = ".$time_res." AND master_puestos.id_aula = ".$zone_res." 
                        AND master_puestos.id = ".$place_res); 
    
    $n_res = 0; 

    while(mysqli_fetch_array($previous_res)){
        $n_res++; 
    }

    //Insertar registro en la tabla reservas

    if($n_res){
        echo "Ocupado"; 
    }
    else{
        echo "Reserva realizada"; 
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
        $times = mysqli_query($link, "SELECT id, franja FROM master_franjas_horarias"); 
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