<?php
//Definimos constantes para las conexiones a la BD

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'stubia');
 
//Conectamos con la BD
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
//Comprobamos si nos hemos conectado correctamente
if($link === false){
    die("ERROR al conectarse a MySQL: ".mysqli_connect_error());
}
?>