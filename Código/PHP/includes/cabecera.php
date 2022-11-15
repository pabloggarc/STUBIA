</head>
<body>
	<div id="contenedor_stubia">
		<div id="capa_cabecera">
            <img src="<?= $dir_raiz ?>img/UAH-logo.png" alt="Logo de la UAH" height="75"/>
            <span class="my-5" style="font-weight:bold; font-size:40px; color:#003da7">STUBIA</span>
            <span class="my-5" style="font-weight:bold; font-size:16px; color:#003da7">Prototipo de Computación Ubícua 2022</span>
        
            <?php
                                    
                /* Nuestras variables de sesión:
                $_SESSION["loggedin"];
                $_SESSION["stubia_userid"];
                $_SESSION["stubia_useridperfil"];
                $_SESSION["stubia_userperfil"];
                $_SESSION["stubia_username"];
                $_SESSION["stubia_nombre"];
                $_SESSION["stubia_apellidos"];
                */
            ?>
                                    
            <div class="login">
                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]	!== false) {
                ?>
                
                <a href="<?= $dir_raiz ?>includes/session_end.php"><img src="<?= $dir_raiz ?>img/desconectar.svg" alt="Desconectar" type="image/svg+xml" height="25"/></a>
                <?= $_SESSION["stubia_nombre"]." ".$_SESSION["stubia_apellidos"]." (<span style='font-weight: bold'>".$_SESSION["stubia_userperfil"]."</span>)" ?>
                
                <img src="<?= $dir_raiz ?>img/CU.png" alt="Cpmputación ubícua" height="75" />
                <?php } else {}
                ?>
            </div>
		</div>
            
		<div id="capa_borde_superior">
            <a href="javascript:goPage('<?= _APP_URL ?>')">
                    <?php	                            
                    echo ("<span style='color:#ffffff'>STUBIA HOME</span>");
                    $miPagina=$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    if (strpos($miPagina,"index.php")!=false)
                        {//echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Opciones disponibles en STUBIA";
                    }
                    else {
                            if (    strpos($miPagina,"reservas.php")!=false ) {
                                echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Consultar Reservas";}
                            else {	
                                    if (strpos($miPagina,"reservar.php")!=false) {echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Hacer una Reserva";}
                                    else {
                                        
                                    }
                            }
                    }
                    ?>
            </a>
                    
		</div>
		<div id="capa_cuerpo ">
		    <div id="contenido_variable">