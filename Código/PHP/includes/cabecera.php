</head>
<body>
	<div id="contenedorappcmadif">
		<div id="capa_cabecera">
			
                        <img src="<?= $dir_raiz ?>img/logo-ministerio.svg" alt="Ministerio de Transportes, Movilidad y Agenda Urbana" type="image/svg+xml" height="52"/>
                        <img src="<?= $dir_raiz ?>img/logo-adif.svg" alt="Logo de ADIF" type="image/svg+xml" height="40"/>
                        <img src="<?= $dir_raiz ?>img/logo-EU.png" alt="Logo de la Unión Europea" type="image/svg+xml" height="40"/>
                        
                        
                        <style>
                            #blink {
                                font-size: 1em;
                                font-weight: bold;
                                transition: 0.5s;
                            }
                        </style>
                        
                        
                        <?php
                            writeLog("Entorno de "._ENTORNO_);
                        ?>
                        <pre style='display:inline'>&#09;&#09;&#09;&#09;</pre>
                        <span>
                            <?php
                                switch (_ENTORNO_) {
                                    case "DESARROLLO":
                                        echo ("ENTORNO DE PRUEBAS");
                                        break;
                                    case "LOCAL":
                                        echo ("ENTORNO DE DESARROLLO");
                                        break;    
                                }

                                switch (_ENTORNO_) {
                                    case "DESARROLLO":
                                        echo ("<img src=".$dir_raiz."img/testing.png alt='Entorno de "._ENTORNO_."' height='80'");
                                        break;
                                    case "LOCAL":
                                        echo ("<img src=".$dir_raiz."img/development.png alt='Entorno de "._ENTORNO_."' height='80'");
                                        break;    
                                }
                            ?>
                        </span>
                        
                        <!--
                        <script type="text/javascript">
                                var blink = document.getElementById('blink');
                                setInterval(function() {
                                    blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
                                }, 1500);
                        </script>
                        -->
                                                
                        <div class="login">
                            <?php
                            if (isset($_SESSION["user"]) && $_SESSION["user"]	!== false) {
                            ?>
                            
                            <a href="<?= $dir_raiz ?>includes/session_end.php"><img src="<?= $dir_raiz ?>img/desconectar.svg" alt="Desconectar" type="image/svg+xml" height="25"/></a>
                            <?= $_SESSION["user"]["nombre"]." ".$_SESSION["user"]["apellidos"]." (<span style='font-weight: bold'>".$_SESSION["user"]["perfil"]."</span>)" ?>
                            
                            <?php }elseif(php_actual() === "select_perfil.php"){ ?>
                                <?php //echo reset($_SESSION["user_perfiles"])["nombre"]." ".reset($_SESSION["user_perfiles"])["apellidos"]." ()" ?>
                            <?php }?>
                            
                            <img src="<?= $dir_raiz ?>img/2030.png" alt="Logo de Agenda 2030" height="60" />
                            
			</div>
		</div>
            
		<div id="capa_borde_superior" <?=_ENTORNO_ !== "PRODUCCION" ? "style='background-color:#702c6c;'" : ""?> >
                    <a href="javascript:goPage('<?= _APP_URL ?>')">
                            <?php	
                            //Guillermo 4/julio/2022:
                            echo ("Proyecto Dato Único ADIF y ADIF AV");
                            $miPagina=$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                            if (strpos($miPagina,"adif/index.php")!=false)
                                {//echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Listado de encuestas Dato Único ADIF y ADIF AV";
                            }
                            else {
                                    if (    strpos($miPagina,"indicadores/listado.php")!=false || 
                                            strpos($miPagina,"cm/")!=false || 
                                            strpos($miPagina,"metas_resp")!=false) {
                                        echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Cuadro de Mando Operacional de ADIF y ADIF AV";}
                                    else {	
                                            if (strpos($miPagina,"prime")!=false) {echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Informes PRIME de ADIF y ADIF AV";}
                                            else {
                                                    if (strpos($miPagina,"convenio")!=false) {echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Informes del convenio MITMA de ADIF y ADIF AV";}
                                                    else {
                                                            if (strpos($miPagina,"dpo")!=false) {echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Encuesta DPO de ADIF y ADIF AV";}
                                                            else {                                                                    
                                                                    if (    strpos($miPagina,"administracion")!=false || 
                                                                            strpos($miPagina,"usuarios")!=false || 
                                                                            strpos($miPagina,"indicadores")!=false || 
                                                                            strpos($miPagina,"access_log")!=false || 
                                                                            strpos($miPagina,"avisos")!=false || 
                                                                            strpos($miPagina,"metas")!=false) {
                                                                                echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Aadministración de elementos Dato Único ADIF y ADIF AV";}
                                                                    //else {      echo "Proyecto Dato Único ADIF y ADIF AV";}                                                          
                                                            }										
                                                    }
                                            }
                                    }
                            }
                            ?>
                    </a>
                    
                     
                    <?php
                    if      (strpos($miPagina,"indicadores/listado.php")!=false || 
                            strpos($miPagina,"metas_resp")!=false ||
                            strpos($miPagina,"prime/listado.php")!=false || 
                            strpos($miPagina,"convenio/listado_indicadores.php")!=false || 
                            strpos($miPagina,"dpo/listado.php")!=false)  {
                                echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;";
                    ?>
                    <a href="javascript:history.go(-1)">Índice</a>
                    <?php          
                            //echo "&nbsp;&nbsp;&nbsp;🡆";//🡇⤵↴
                            }
                                                                
                    if (isset($_SESSION["user"]) && $_SESSION["user"]	!== false) {
                    
                        //<a id="info_notif" href="javascript:toggle_notificaciones();">3 NOTIFICACIONES</a> -->
                        
                        if(php_actual() != "select_perfil.php" && $perfil === _USER_ADMIN){
                        ?>
                                <a id="enlace_admin" href="<?= $dir_raiz ?>administracion.php">Panel de administración</a>
                        <?php }
                    }
                    if(php_actual() != "select_perfil.php"){?>
                        <a id="enlace_manual" target="_blank" href="<?=$link_manual?>">Manual de usuario</a>
                    <?php }
                    if(php_actual() != "select_perfil.php" && strpos($_SERVER['REQUEST_URI'], "/prime") != 0){?>
                        <a id="enlace_catalogo_prime" target="_blank" href="<?=$dir_raiz."docs/PRIME_KPI_Catalogue_3.4.pdf"?>">Catálogo PRIME</a>
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