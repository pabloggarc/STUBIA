<html>
    <body>
        OK
</body>
<?php

// Include config file
require_once "config.php";
$aula = $puesto = $estado =0;


$stmt = mysqli_prepare($link, "INSERT INTO estados (aula, puesto, estado, au_fec_alta) VALUES (?, ?, ?, NOW())");
mysqli_stmt_bind_param($stmt, 'sss', $aula, $puesto, $estado);

if(isset($_GET["aula"]) && isset($_GET["puesto"]) && isset($_GET["estado"])){
    $aula=$_GET["aula"];
    $puesto=$_GET["puesto"];
    $estado=$_GET["estado"];    
    
    //$sql = "INSERT INTO estados (aula, puesto, estado) VALUES (".$aula.",".$puesto.",".$estado.")";
    
    /* ejecuta la sentencia preparada*/
    if(mysqli_stmt_execute($stmt)){
        /* store result */
        mysqli_stmt_store_result($stmt);
        //printf("%d Fila insertada.\n", $stmt->affected_rows);
        //if(mysqli_stmt_num_rows($stmt) == 1){
        if($stmt->affected_rows == 1){        
            echo "OK";
        } else{
            echo "Error1";
        }
    } else{
        echo "Error2";
    }
    // Close statement
    mysqli_stmt_close($stmt);
    
} else {
    echo "Error3";
}
?>
</body>