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

function conectar_bd_manten(){
	$sql_connect=false;
	
	try{
		$sql_connect = mysqli_connect("iblsd006.dcsi.adif", "DATA_USR", "4701443589", "DW", 1533);
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

function db_getInsertId($sql_connect) {
	$devuelve=0;
	if($sql_connect){
		try{
			$devuelve=$sql_connect->insert_id;
		}catch (Exception $ex){
			
		}
	}
	return $devuelve;
}

function db_escape($sql_connect,$cadena){
	$devuelve="";
	if($sql_connect and $cadena){
		try{
			$devuelve=$sql_connect->real_escape_string($cadena);
		}catch (Exception $ex){
			$devuelve=$cadena;
		}
	}else{
		$devuelve=$cadena;
	}
	return $devuelve;
}
?>