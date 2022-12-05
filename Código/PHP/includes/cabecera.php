</head>
<body>
<div class="row">
    <div class="col-md-12">
        <div id="contenedor_stubia">
            <div id="capa_cabecera">
                <img src="<?= $dir_raiz ?>img/stubia-logo2.png" alt="Logo del proyecto" height="100vh"/>
                <span class="my-5" style="font-weight:bold; font-size:40px; color:#337ab7">STUBIA</span>
                <span class="my-5" style="font-weight:bold; font-size:16px; color:#337ab7">Prototipo de Computación Ubicua 2022</span>
            
                <?php
                                        
                    /* Nuestras variables de sesión son las siguientes:
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
                    
                    <img src="<?= $dir_raiz ?>img/UAH-logo.png" alt="UAH" height="75" />
                    <?php } else {}
                    ?>
                </div>
            </div>
            
            <div id="capa_borde_superior">            
                <a href="javascript: window.location.href='http://<?=_APP_URL?>'">
                        <?php
                        $migas="<span style='color:#ffffff'>STUBIA HOME";
                        echo ($migas);
                        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                            $url = "https://"; 
                        }else{
                            $url = "http://"; 
                        }
                        $miPagina=$url . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        if (strpos($miPagina,"aula.php")!=false)
                            {echo $migas."&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Consulta del estado de un aula";
                        }
                        else {
                                if (    strpos($miPagina,"reserva.php")!=false ) {
                                    echo "&nbsp;&nbsp;&nbsp;🡆&nbsp;&nbsp;&nbsp;Reservas";}
                                else {	
                                      
                                }
                        }
                        $migas.="</span>";
                        ?>
                </a>
                        
            </div>
            <div id="capa_cuerpo ">
                <div id="contenido_variable">