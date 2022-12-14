<?php	

function conectar_bd(){
	$sql_connect=false;
	
	try{
		$sql_connect = mysqli_connect(BBDD_HOST, BBDD_USER, BBDD_PWD, BBDD_SQUEMA);
		$sql_connect->set_charset("utf8");
	}catch (Exception $ex){
		
	}
	return $sql_connect;
}


function desconectar_bd($sql_connect) {

	if ($sql_connect){$sql_connect->close();}

}

function db_query($sql,$sql_connect) {
	$devuelve = false;
	if ($sql_connect and $sql) {
		try {
			$devuelve = $sql_connect->query($sql);
		} catch (Exception $ex) {
			
		}
	}
	return $devuelve;
}
