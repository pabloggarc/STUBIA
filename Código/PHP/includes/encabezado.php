<?php

include('session_app.php');
$perfil = intval($_SESSION["user"]["perfil_id"]);
$link_manual = "";
switch ($perfil) {
    case 5:
        $link_manual = _APP_URL."docs/manuales/Manual de usuario (Ejecutivo).pdf";
        break;
    case 10:
        $link_manual = _APP_URL."docs/manuales/Manual de usuario (Responsable del dato).pdf";
        break;
    case 15:
        $link_manual = _APP_URL."docs/manuales/Manual de usuario (Supervisor).pdf";
        break;
    case 25:
        $link_manual = _APP_URL."docs/manuales/Manual de usuario (Administrador).pdf";
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title><?=_APP_NAME?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta charset="utf-8" />
    <meta name="author" content="SENASA" />
        <!-- Guillermo 4/julio/22: Elimino estas 2 líneas y meto una nueva con el icono corporativo de ADIF:
	<link rel="shortcut icon" type="image/x-icon" href="http://www.senasa.es//images/favicon.ico" />
        <link rel="icon" type="image/gif" href="http://www.senasa.es//images/animated_favicon1.gif" />
        -->
        <link rel="shortcut icon" type="image/x-icon" href="<?= $dir_raiz ?>img/adif_icono.ico" />
	<link rel="stylesheet" type="text/css" href="<?= $dir_raiz ?>css/estilos.css?v=<?= time(); ?>" />
	<script src="<?= $dir_raiz ?>js/comunes.js?v=<?= time(); ?>"></script>