<?php
//Iniciar sesion

session_start();
 
//Acabar con la sesion y volver al login

$_SESSION = array();
session_destroy();
header("location: login.php");
exit;
?>