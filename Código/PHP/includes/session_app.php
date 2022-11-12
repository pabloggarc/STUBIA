<?php 
session_start();

//Guillermo 28/jul/22: hacemos que la app, en modo local, lea en el fichero config.ini el usuario local:
$usuario_local="";
if (_ENTORNO_==="LOCAL") {
    $fp = fopen($dir_raiz."config.ini", "r");    
     while(!feof($fp)) {        
        $linea = fgets($fp);        
        if (strpos($linea, "Usuario local")!==false) {
            $usuario_local= trim(substr($linea, strpos($linea, "=")+1));
        }
     }
     
    fclose($fp);
}

//$usuario_local="2814333";
//$usuario_local="8881914"; //usuario pruebas CMO->DPO
//$usuario_local="8010142"; //usuario pruebas CMO->CMO y CMO->DPOs ID=18        //DEMO1
//$usuario_local="2840718"; //usuario pruebas CMO->DPO ID=64
//$usuario_local="8980336"; //usuario pruebas CMO->DPO y DPO->DPO id=31
//$usuario_local="2817658"; //usuario pruebas DPO->DPO id=7                       //DEMO2
//$usuario_local="9705609"; //usuario pruebas CMO->CMO
//$usuario_local="2847911";
//$usuario_local="8983678"; //usuario pruebas calculadas CMO -> CMO
//$usuario_local="8842189"; //usuario pruebas calculadas CMO -> CMO
//$usuario_local="8884777"; //usuario pruebas calculadas DPO -> DPO
//$usuario_local="2888006";

if (!isset($_SESSION["user"]) || $_SESSION["user"]	=== false) {
	if (_LOGIN_BY_GET && isset($_GET["user"]) && isset($_USER_PRUEBA[$_GET["user"]])) {
		$_SESSION["user"] = $_USER_PRUEBA[$_GET["user"]];
                // Guardar registro de acceso
                registrar_acceso_db($_SESSION["user"]["id"], $_SESSION["user"]["perfil_id"]);
	} else if (_LOGIN_AUTOFIRMA) {
		if (php_actual() !== "login.php") {header('Location: login.php');}
	} else {
		// Validamos el usuario LDAP:
		$_SESSION["user"]	= false;
                //Guillermo 28/jul/22: parametrizo el login LDAP en función de si tengo Apache (PRO y LOCAL) o IIS (servidor de DESARROLLO):
                $login = str_replace(_PREFIJO_LDAP, "", (_ENTORNO_)!=="DESARROLLO"?$_SERVER['PHP_AUTH_USER']:$_SERVER['AUTH_USER']);
                if ($login==="") {                    
                    $login = $usuario_local;                    
                }
		
                $sql_connect	= conectar_bd();
                $sql = "SELECT u.id, up.perfil_id, u.nombre, u.apellidos, u.user_ldap, u.direccion, p.nombre AS perfil FROM users u JOIN user_perfil up on u.id=up.user_id JOIN master_users_perfiles p ON p.id = up.perfil_id AND p.activo = 1 WHERE ";
                if (_ENTORNO_==="PRODUCCION") {
                    $sql.=" u.user_ldap ";
                }else {
                    $sql.=" u.user_ldap_desarrollo ";
                }
                $sql.= "='".$login."' AND u.activo = 1;";
                writeLog($sql);
                $consulta = db_query($sql, $sql_connect);
                if (!$consulta) {
                        lanzar_aviso("SE HA PRODUCIDO UN ERROR EN LA CONEXIÓN CON LA BASE DE DATOS Y NO SE HA PODIDO IDENTIFICAR SU USUARIO.");
                } else if ($consulta->num_rows < 1) {
                        lanzar_aviso("SU USUARIO  '".$login."' NO TIENE PERMISOS PARA ACCEDER A LA HERRAMIENTA");
                } else if ($consulta->num_rows == 1){
                        $_SESSION["user"] = $consulta->fetch_array();
                        $consulta->free_result();
                        // Guardar registro de acceso
                        registrar_acceso_db($_SESSION["user"]["id"], $_SESSION["user"]["perfil_id"]);
                }else{
                        //exit("El usuario tiene varios perfiles");
                        while ($fila = $consulta->fetch_array()) {
                                $_SESSION["user_perfiles"][$fila['perfil_id']] = $fila;
                        }
                        $consulta->free_result();

                        // Redireccion a selec_perfil.php
                        header("Location: ".$dir_raiz."select_perfil.php");     
                }
                desconectar_bd($sql_connect);		
	}
}

?>
