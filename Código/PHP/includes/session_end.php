<?php
//Guillermo 28/jul/22: no es necesario cargar aquí el config.php para cerrar sessión. Con poner la ruta correcta debajo en el header es suficiente:
//require_once("config.php");
session_start();
session_destroy();
session_unset();

header('Location: '.'../index.php');

?>