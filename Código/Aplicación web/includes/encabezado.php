<?php

include('session_app.php');
$idperfil = intval($_SESSION["stubia_useridperfil"]);

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title><?=_APP_NAME?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta charset="utf-8" />
    <meta name="author" content="UAH" />        
    <link rel="shortcut icon" type="image/x-icon" href="<?= $dir_raiz ?>https://www.uah.es/favicon.ico" />    
	<link rel="stylesheet" type="text/css" href="<?= $dir_raiz ?>css/estilos.css?v=<?= time(); ?>" />
	<script src="<?= $dir_raiz ?>js/comunes.js?v=<?= time(); ?>"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>

	<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
	<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

	<style>
        @import url('https://fonts.cdnfonts.com/css/din-regular');
	</style>