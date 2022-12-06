<?php
//Iniciamos la sesion
session_start();
 
//Verificar que el usuario se ha logueado. Si es así, lo llevamos a la pagina principal:
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]){
    header("location: index.php");
    exit;
}
 
//Configuracion
require_once "includes/config.php";
require_once "includes/funciones.php";

 
//Definicion de variables vacias
$username = $password = $nombre = $apellidos = "";
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
        $user_query = "SELECT mu.id, mu.id_perfil, mp.perfil, mu.nombre, mu.apellidos, mu.username, mu.password FROM master_usuarios mu ";
        $user_query.= "INNER JOIN master_perfil mp ON mu.id_perfil=mp.id AND mp.activo=1 ";
        $user_query.= "WHERE mu.username = ? and mu.activo=1";
    }
    else{
        $error_ocurred = true; 
    }
    writeLog($user_query);
    //abrimos la BD
    $sql_connect = conectar_bd();
    //Preparamos la consulta
    if(!$error_ocurred && $stmt = mysqli_prepare($sql_connect, $user_query)){
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
        mysqli_stmt_bind_result($stmt, $id, $id_perfil, $perfil ,$nombre, $apellidos, $username, $hashed_password);
    }

    if(!$error_ocurred && mysqli_stmt_fetch($stmt)){
        //Verificamos que la contraseña obtenida de la BD coincida al descifrarla con la escrita
        if(password_verify($password, $hashed_password)){
            $_SESSION["loggedin"] = true;
            $_SESSION["stubia_userid"] = $id;
            $_SESSION["stubia_useridperfil"] = $id_perfil;
            $_SESSION["stubia_userperfil"] = $perfil;
            $_SESSION["stubia_username"] = $username;
            $_SESSION["stubia_nombre"] =$nombre;
            $_SESSION["stubia_apellidos"] =$apellidos;  
            $_SESSION["stubia_mostrarVideo"] = true;
            writeLog("Login correcto de usuario ". $username." (id ".$id.")");
            registrar_acceso_app($id, $id_perfil);
            header("location: index.php");
        } 
        else{
            $login_err = "Nombre de usuario o contraseña no válidos.";
        }
    }
    else{
        $error_ocurred = true; 
    }

    if($error_ocurred){
        writeLog("Login erróneo de usuario ". $id);
        echo "Ha ocurrido un error inesperado, inténtelo más tarde de nuevo por favor. "; 
    }

    mysqli_stmt_close($stmt);

    mysqli_close($sql_connect);
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PL2 de la asignatura Computación Ubícua para el GII de la UAH curso 2022-23">
    <meta name="author" content="Guillermo González, Pablo García, Robert Petrisor, Carlos García">    
    <title><?=_APP_NAME?></title>
      
    <!-- Bootstrap 5: -->    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>
        
        .wrapper{
            width: 360px; padding: 20px;
        }

    </style>
</head>
<body class="m-0 vh-100 row justify-content-center align-items-center">
    <div class="wrapper col-auto p-5 opacity-50">
        <img src="img/stubia-logo.png" height=270px>
    </div>
    <div class="wrapper col-auto p-5">
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
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Iniciar sesión">
            </div>
            <br>
            <p>¿No tienes cuenta aún? <a href="registrar.php">¡Regístrate ya!</a></p>
        </form>
    </div>
</body>
</html>