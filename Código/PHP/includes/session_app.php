<?php 
session_start();

writeLog("Entorno "._ENTORNO_);
                
registrar_acceso_db($_SESSION["stubia_userid"], $_SESSION["stubia_useridperfil"]);

?>
