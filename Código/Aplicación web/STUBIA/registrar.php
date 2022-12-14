<?php
require_once "includes/config.php";
require_once "includes/funciones_db.php";
 
$name = $surnames = $username = $email = $password = $confirm_password = "";
$name_err = $surnames_err = $username_err = $email_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    //Validacion nombre de usuario
    if(empty(trim($_POST["username"]))){
        $username_err = "Tu nombre de usuario no puede estar vacío. ";
    } 
    if(empty(trim($_POST["name"]))){
        $name_err = "Tu nombre no puede estar vacío. ";
    }
    if(empty(trim($_POST["surnames"]))){
        $surnames_err = "Tus apellidos no pueden estar vacíos. ";
    }
    if(empty(trim($_POST["email"]))){
        $email_err = "Tu dirección de correo electrónico no puede estar vacía. ";
    }
    if(!preg_match('/^[a-zA-Z0-9_.]+$/', trim($_POST["username"]))){
        $username_err = "Tu nombre de usuario solo puede contener letras, números, guión bajo, y puntos.";
    }
    if(!preg_match('/^[a-zA-Z0-9_.]+@[a-zA-Z0-9_.]+$/', trim($_POST["email"]))){
        $email_err = "Tu dirección de correo electrónico no es válida.";
    } 
    else{

        //abrimos la BD
        $sql_connect = conectar_bd();
        //Comprobamos que nadie haya elegido ese nombre de usuario
        $query = "SELECT username FROM master_usuarios WHERE username = ?";
        $param_username = trim($_POST["username"]);
    
        if($stmt = mysqli_prepare($sql_connect, $query)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "El nombre ".$param_username." ya está en uso. ";
                } 
                else{
                    $username = trim($_POST["username"]);
                }
            } 
            else{
                echo "Ha ocurrido un error inesperado, inténtelo más tarde de nuevo por favor. "; 
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    //Validacion contraseña
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, introduce una contraseña. ";     
    } 
    elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Tu contraseña debe tener al menos 6 caracteres. ";
    } 
    else{
        $password = trim($_POST["password"]);
    }
    
    //Validacion contraseña correcta
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor, escribe tu contraseña de nuevo. ";     
    } 
    else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }
    
    //Verificamos que no haya errores antes de pasar a la BD
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err) && empty($surnames_err) && empty($email_err)){
        $query = "INSERT INTO master_usuarios (nombre, apellidos, username, password, email, au_fec_alta, au_proc_alta) VALUES (?, ?, ?, ?, ?, now(), 'Web')";
        if($stmt = mysqli_prepare($sql_connect, $query)){

            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_surnames, $param_username, $param_password, $param_email);
            $param_name = $_POST["name"]; 
            $param_surnames = $_POST["surnames"]; 
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            echo $param_password; 
            $param_email = $_POST["email"]; 
            
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } 
            else{
                echo "Ha ocurrido un error inesperado, inténtelo más tarde de nuevo por favor. "; 
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($sql_connect);
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>STUBIA - Registro</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.cdnfonts.com/css/dinpro-medium');
        html, body {
            font-family: 'DINPro-Medium', sans-serif;
            font-style: normal;
            font-weight: 500;
        }

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
        <h2>Regístrate en STUBIA</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nombre de usuario</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Apellidos</label>
                <input type="text" name="surnames" class="form-control <?php echo (!empty($surnames_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $surnames; ?>">
                <span class="invalid-feedback"><?php echo $surnames_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Regístrame">
                <input type="reset" class="btn btn-secondary ml-2" value="Borrar">
            </div>
            <br>
            <p>¿Ya estás registrado? <a href="login.php">Inicia sesión</a>.</p>
        </form>
    </div>    
</body>
</html>