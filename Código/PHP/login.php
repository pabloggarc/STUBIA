<?php
//Iniciamos la sesion
session_start();
 
//Verificar que el usuario se ha logeado y lo llevamos a la pagina principal
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]){
    header("location: principal.php");
    exit;
}
 
//Configuracion
require_once "config.php";
 
//Definicion de variables vacias
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
//Procesamiento del formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //Validacion de datos introducidos por formulario
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor, introduzca un nombre de usuario válido";
    } 
    else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, introduzca su contraseña";
    } 
    else{
        $password = trim($_POST["password"]);
    }

    //Comenzamos a hablar con la BD
    $error_ocurred = false; 
    
    //Si el formato del usuario y contraseña es correcto, buscamos el nombre de usuario
    if(empty($username_err) && empty($password_err)){
        $user_query = "SELECT id, nombre, username, password FROM master_usuarios WHERE username = ?";
    }
    else{
        $error_ocurred = true; 
    }

    //Preparamos la consulta
    if(!$error_ocurred && $stmt = mysqli_prepare($link, $user_query)){
        mysqli_stmt_bind_param($stmt, 's', $username);
    }
    else{
        $error_ocurred = true; 
    }

    //Ejecutamos la consulta y en caso de que no haya errores almacenamos los datos
    if(!$error_ocurred && mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
    } 
    else{
        $error_ocurred = true; 
    }

    //Comprobamos que haya una sola persona con ese nombre de usuario
    if($error_ocurred || mysqli_stmt_num_rows($stmt) != 1){
        $error_ocurred = true; 
        $login_err = "Nombre de usuario o contraseña no válidos.";
    }

    if(!$error_ocurred){
        mysqli_stmt_bind_result($stmt, $id, $firstname, $username, $hashed_password);
    }

    if(!$error_ocurred && mysqli_stmt_fetch($stmt)){
        //Verificamos que la contraseña obtenida de la BD coincida al descifrarla con la escrita

        if(password_verify($password, $hashed_password)){
            $_SESSION["loggedin"] = true;
            $_SESSION["stubia_userid"] = $id;
            $_SESSION["stubia_username"] = $username;
            header("location: principal.php");
        } 
        else{
            $login_err = "Nombre de usuario o contraseña no válidos.";
        }
    }
    else{
        $error_ocurred = true; 
    }

    if($error_ocurred){
        echo "Ha ocurrido un error inesperado, inténtelo más tarde de nuevo por favor. "; 
    }

    mysqli_stmt_close($stmt);

    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Por favor, introduce tus credenciales para acceder a STUBIA:</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nombre de usuario</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Iniciar sesión">
            </div>
            <p>¿No tienes cuenta aún? <a href="register.php">¡Regístrate ya!</a></p>
        </form>
    </div>
</body>
</html>