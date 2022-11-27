<?php 
session_start();

//Verificar que el usuario se ha logueado y lo llevamos a la pagina principal
if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]){
    header("location: login.php");
    exit;
}

?>
