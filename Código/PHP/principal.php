<?php
//Iniciar la sesion
session_start();
 
//Si el usuario que intenta entrar no ha iniciado sesion se le envia a hacerlo
if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>STUBIA</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @font-face {
            font-family: din_regular;
            src: url(fuentes/DINPro-Medium.otf);
        }

        body{ 
            font: 14px din_regular; 
            text-align: center; 
        }
    </style>
</head>
<body>
    <h1 class="my-5">¡Hola <b><?php echo htmlspecialchars($_SESSION["stubia_username"]); ?></b>, bienvenido a STUBIA!</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Cambiar contraseña</a>
        <a href="logout.php" class="btn btn-danger ml-3">Iniciar sesión como otro usuario</a>
    </p>
</body>
</html>