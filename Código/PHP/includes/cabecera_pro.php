</head>
<body>
	<div id="contenedorappcmadif">
		<div id="capa_cabecera">
			<img src="<?= $dir_raiz ?>img/cabecera_fomento.gif" alt="Ministerio de Transportes, Movilidad y Agenda Urbana" />
			<img src="<?= $dir_raiz ?>img/logo_adif.gif" alt="Logo de Adif" />
			
			<div class="login">
                            <img src="<?= $dir_raiz ?>img/2030.png" alt="Logo de Agenda 2030" height="60" />
                            <?php
                            if (isset($_SESSION["user"]) && $_SESSION["user"]	!== false) {
                            ?>
                                <?= $_SESSION["user"]["nombre"]." ".$_SESSION["user"]["apellidos"]." (".$_SESSION["user"]["perfil"].")" ?>&nbsp;[<a href="<?= $dir_raiz ?>includes/session_end.php">desconectar</a>]
                            <?php }elseif(php_actual() === "select_perfil.php"){ ?>
                                <?php //echo reset($_SESSION["user_perfiles"])["nombre"]." ".reset($_SESSION["user_perfiles"])["apellidos"]." ()" ?>
                            <?php }?>
			</div>
		</div>
		<div id="capa_borde_superior">
                    <a href="javascript:goPage('<?= _APP_URL ?>')"><?= php_actual() == "index.php" ? "ADIF" : "CUADRO DE MANDO OPERACIONAL DE ADIF" ?></a>
                    <?php
                        if (isset($_SESSION["user"]) && $_SESSION["user"]	!== false) {
                    ?>
                        <!-- <a id="info_notif" href="javascript:toggle_notificaciones();">3 NOTIFICACIONES</a> -->
                        <?php
                        if(php_actual() != "select_perfil.php" && $perfil === _USER_ADMIN){
                        ?>
                                <a id="enlace_admin" href="<?= $dir_raiz ?>administracion.php">Panel de administración</a>
                        <?php } ?>
                    <?php } ?>
                    <?php if(php_actual() != "select_perfil.php"){?>
                    <a id="enlace_manual" target="_blank" href="<?=$link_manual?>">Manual de usuario</a>
                    <?php } ?>
                    <?php if(php_actual() != "select_perfil.php" && strpos($_SERVER['REQUEST_URI'], "/prime") != 0){?>
                    <a id="enlace_catalogo_prime" target="_blank" href="<?=$dir_raiz."docs/catalogo_PRIME_3.3.pdf"?>">Catálogo PRIME</a>
                    <?php } ?>
		</div>
		<div id="capa_cuerpo">
<?php
if(count($GLOBALS['cadena_errores'])){
?>
			<div id="capa_errores_producidos">
				<h2 class="error">ERROR</h2>
<?php
	foreach($GLOBALS['cadena_errores'] as $clave => $error) {echo  "<p>".($clave + 1)." - ".mb_strtoupper($error, 'UTF-8')."</p>";}
?>
				<a href="#" onclick="javascript:goPage(_URL_RAIZ)">[x] Cerrar</a>
			</div>
<?php
}
?>
<?php
if(count($GLOBALS['cadena_avisos'])){
?>
			<div id="capa_avisos_producidos">
				<h2 class="error">AVISO</h2>
<?php
	foreach($GLOBALS['cadena_avisos'] as $clave => $error) {echo  "<p>".($clave + 1)." - ".mb_strtoupper($error, 'UTF-8')."</p>";}
?>
				<a href="#" onclick="javascript:goPage(_URL_RAIZ)">[x] Cerrar</a>
			</div>
<?php
}
?>
			<div id="contenido_variable">
