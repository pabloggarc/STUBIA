<?php

require('funciones_db.php');
require('funciones_fecha.php');
require('mail/class.phpmailer.php');


function writeLog($strCadena) {
    $strDate = date('Y-m-d');
    $hora = date('H');

    if (_ENTORNO_==="PRODUCCION") {$barra="//";}
    else {$barra="\\";}

    $strNombreLog = dirname(__FILE__) . $barra . '..' . $barra . 'logs' . $barra . $strDate . '_' . $hora . '.log';

    $log = @fopen($strNombreLog, 'a');

    if ($log) {
        fputs($log, print_r(date('Y-m-d H:i:s') . "(" . microtime() . ") - " . $strCadena, true) . "\n---\n");
        fclose($log);
    } else {
        //alternativo
        $strNombreLogAlt = dirname(__FILE__) . $barra . '..' . $barra . 'logs' . $barra . $strDate . '_' . $hora . '_alt.log';
        $log_alt = @fopen($strNombreLogAlt, 'a');

        if ($log_alt) {
            fputs($log_alt, print_r(date('Y-m-d H:i:s') . " - " . $strCadena, true) . "\n---\n");
            fclose($log_alt);
        }
    }

    //$_SESSION["last_action"]=time();
}

function writeAct($strCadena) {
    $strDate = date('Y-m-d');

    if (_ENTORNO_==="PRODUCCION") {$barra="//";}
    else {$barra="\\";}

    $strNombreLog = dirname(__FILE__) . $barra . '..' . $barra . 'actions' . $barra . $strDate . '.log';

    $log = @fopen($strNombreLog, 'a');

    if ($log) {
        fputs($log, print_r(date('Y-m-d H:i:s') . " - " . str_replace("SENASA\\", "", $_SERVER['AUTH_USER']) . " - " . $strCadena, true) . "\n");
        fclose($log);
    } else {
        //alternativo
        $strNombreLogAlt = dirname(__FILE__) . $barra . '..' . $barra . 'actions' . $barra . $strDate . '_alt.log';
        $log_alt = @fopen($strNombreLogAlt, 'a');

        if ($log_alt) {
            fputs($log_alt, print_r(date('Y-m-d H:i:s') . " - " . str_replace("SENASA\\", "", $_SERVER['AUTH_USER']) . " - " . $strCadena, true) . "\n---\n");
            fclose($log_alt);
        }
    }
}

function enviar_mail($from, $email, $asunto, $mensaje, $dir_adjunto = '', $adjunto = '') {
    $strAdjuntos = $dir_adjunto . $adjunto;
    //$estilo			= " style='font-family:arial,verdana,calibri;font-size:12px;background-color:#F2F2FF;color:#330066'";
    //$cabecera		= "<html".$estilo."><body>";
    //$pie			= "</body></html>";

    if ($from == '') {
        writeLog("No se ha podido enviar el correo ya que no se ha especificado dirección de origen");
        return false;
    } else if ($email == '') {
        writeLog("No se ha podido enviar el correo ya que no se ha especificado dirección de destino");
        return false;
    } else {
        $mail = new PHPMailer();
        $mail->SetLanguage('en');
        $mail->Helo = MAIL_HELO;
        $mail->From = $from;
        $mail->FromName = $from;
        $mail->Host = MAIL_HOST;
        $mail->Mailer = "smtp";
        //$mail->Body		= $cabecera.utf8_decode($mensaje).$pie;
        $mail->Body = utf8_decode($mensaje);
        $mail->Subject = utf8_decode($asunto);
        $mail->IsHTML(true);
        if ($strAdjuntos !== "") {
            $mail->addAttachment($strAdjuntos);
        }

        //comprobamos si es múltiple
        $arr_emails = explode(';', $email);

        if (count($arr_emails > 0)) {
            for ($cont = 0; $cont < count($arr_emails); $cont++) {
                $mail->AddAddress($arr_emails[$cont]);
            }
        }

        if (!$mail->Send()) {
            writeLog("*** ERROR: El envío del correo ha fallado");
            return false;
        } else {
            return true;
        }
    }
    return false;
}

/*
  Esta función devuelve una réplica del array multidimensional pasado en el primer parámetro
  pero ordenado por el campo y criterio especificado en el segundo parámetro. Ejemplo:
  $nuevo_array=array_msort($miarray, array('apellidos'=>SORT_ASC, 'edad'=>SORT_DESC));
 */

function array_msort($array, $cols) {
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) {
            $colarr[$col]['_' . $k] = strtolower($row[$col]);
        }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\'' . $col . '\'],' . $order . ',';
    }
    $eval = substr($eval, 0, -1) . ');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k, 1);
            if (!isset($ret[$k]))
                $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;
}

//Devuelve el nombre de la página actual:
function php_actual() {
    return str_replace("/", "", strrchr($_SERVER['SCRIPT_NAME'], "/"));
}

//Rellena el mensaje de error en caso de que haya ocurrido algo durante la carga de una página:
function lanzar_error($causa, $writeLog = false) {
    if ($writeLog) {
        writeLog("*** ERROR: " . $causa);
    }
    $GLOBALS['cadena_errores'][] = $causa;
}

//Rellena el mensaje de error en caso de que haya ocurrido algo durante la carga de una página:
function lanzar_aviso($msg, $writeLog = false) {
    if ($writeLog) {
        writeLog("*** WARNING: " . $msg);
    }
    $GLOBALS['cadena_avisos'][] = $msg;
}

//Devuelve una cadena sin acentos:
function ignoraTildes($cadena) {
    $sustituciones = array("a" => "á à ä â",
        "e" => "é è ë ê",
        "i" => "í ì ï î",
        "o" => "ó ò ö ô",
        "u" => "ú ù ü û",
        "A" => "Á À Ä Â",
        "E" => "É È Ë Ê",
        "I" => "Í Ì Ï Î",
        "O" => "Ó Ò Ö Ô",
        "U" => "Ú Ù Ü Û"
    );
    foreach ($sustituciones as $key => $val) {
        $cadena = str_replace(explode(" ", $val), $key, $cadena);
    }
    return $cadena;
}

// Compara 2 fechas en formato timestamp
function date_compare($a, $b) {
    return $a['fecha'] - $b['fecha'];
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
// Devuelve los posibles estados de un CM (la primera vez los guarda un una var de sesión):
function dameEstadosCM() {
    if (isset($_SESSION["cm"]) && isset($_SESSION["cm"]["estados"])) {
        return $_SESSION["cm"]["estados"];
    } else {
        $devuelve = array();
        $conexion = conectar_bd();
        $sql = "SELECT id, nombre FROM master_cuadro_mando_estados WHERE activo = 1;";
        $consulta = db_query($sql, $conexion);
        writeLog($sql);
        if ($consulta) {
            while ($fila = $consulta->fetch_array()) {
                $devuelve[intval($fila["id"])] = $fila["nombre"];
            }
            $consulta->free_result();
            $_SESSION["cm"]["estados"] = $devuelve;
        }
        desconectar_bd($conexion);
        return $devuelve;
    }
}


////////////////////////////////////////////////////////////////////////////////////////////////////////

function getNombreEncuesta($tipo) {
    
    $conexion = conectar_bd();
    $sql = "SELECT nombre FROM master_encuestas WHERE id=".$tipo." AND activo = 1;";
    $consulta = db_query($sql, $conexion);
    writeLog($sql);
    $nombre_enc="";
    if ($consulta) {
        if ($consulta->num_rows>0){
            $fila = $consulta->fetch_array();
            $nombre_enc=$fila["nombre"];
        }
        $consulta->free_result();
    }
    desconectar_bd($conexion);
    return $nombre_enc;
    
}


/*
 * Funcion que devuelve los indicadores relacionados respecto a otro dado
 * 
 * @param int $id_indicador: El indicador origen sobre el que buscar otros indicadores relacionados
 * @param int $id_tipo_encuesta: El tipo de encuesta del indicador origen
 * @param int $anyo: El año sobre el que buscar la encuesta del indicador origen
 * @param int $es_anual: Debemos saber si la encuesta origen es anual porque si no es anual solo hemos de tener en cuenta las relaciones CMO->CMO o CMO-> MITMA.
 * @param int $id_tipo_encuesta_a_buscar: Por si quiero buscar relaciones solo de un tipo de encuesta.
 * @param int $$id_tipo_encuesta_a_NO_buscar: Por si quiero buscar relaciones de todos los tipos excepto de un tipo de encuesta.
 * 
 * @return array Devuelve un array con las relaciones del indicador
 */
function getRelaciones($id_indicador, $id_tipo_encuesta, $anyo, $es_anual=NULL, $id_tipo_encuesta_a_buscar=NULL, $id_tipo_encuesta_a_NO_buscar=NULL) {

    $sql_connect = conectar_bd();
    $relaciones = array();
    
    $sql = "SELECT r.*, e.nombre FROM master_relaciones r LEFT JOIN master_encuestas e ON r.id_encuesta_relacionada = e.id AND e.activo = 1 WHERE r.id_origen=".$id_indicador." AND r.id_encuesta_origen=".$id_tipo_encuesta." AND r.id_anyo=".$anyo." AND r.activo=1";
    if (!is_null($id_tipo_encuesta_a_buscar)){
        $sql.=" AND id_encuesta_relacionada=".$id_tipo_encuesta_a_buscar;
    }if (!is_null($id_tipo_encuesta_a_NO_buscar)){
        $sql.=" AND id_encuesta_relacionada<>".$id_tipo_encuesta_a_NO_buscar;
    }
    $sql.=";";
    
    //writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit ("Se ha producido un error al recuperar las encuestas de base de datos (getRelaciones).");
    } else {
        while ($fila = $consulta->fetch_array()) {            
            if ($es_anual || $fila["id_encuesta_relacionada"]==1 || $fila["id_encuesta_relacionada"]==2){
                $relaciones[] = $fila;
            }
        }        
    }
    
    $consulta->free_result();
    
    return $relaciones;
}

function getRelacionesCalculadas($id_indicador, $id_tipo_encuesta, $anyo, $es_anual=NULL) {

    $sql_connect = conectar_bd();
    $relacionesCalculadas = array();
    
    //echo($id_indicador.",".$id_encuesta.",".$anyo.",".$es_anual);
    
    $sql = "SELECT rc.* FROM master_relaciones_calculadas rc ";
    $sql.= "WHERE ((rc.id_origen1=".$id_indicador." AND rc.id_tipo_encuesta_origen1=".$id_tipo_encuesta.") OR (rc.id_origen2=".$id_indicador." AND rc.id_tipo_encuesta_origen2=".$id_tipo_encuesta.") OR (rc.id_destino=".$id_indicador." AND rc.id_tipo_encuesta_destino=".$id_tipo_encuesta.")) ";
    $sql.= "AND rc.id_anyo=".$anyo." AND rc.activo=1;";
    
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit ("Se ha producido un error al recuperar las encuestas de base de datos (getRelacionesCalculadas).");
    } else {
        while ($fila = $consulta->fetch_array()) {            
            $relacionesCalculadas[] = $fila;
        }        
    }
    
    $consulta->free_result();
    
    return $relacionesCalculadas;
}


/*
 * Funcion que devuelve el estado (abierto, cerrado) de una encuesta anual en un año dado
 * 
 * @param int $id_tipo_encuesta: El tipo de encuesta 
 * @param int $anyo: El año sobre el que buscar la encuesta del indicador origen
 * 
 * @return array Devuelve un array con las relaciones del indicador
 */
function getEstadoEncuesta($id_tipo_encuesta, $anyo) {

    $sql_connect = conectar_bd();
    $estado=false;
    
    $sql = "SELECT * FROM ";
    switch ($id_tipo_encuesta) {
        case 1:
            $sql.= "master_cuadro_mando WHERE ";
            break;
        case 2:
            $sql.= "master_cuadro_mando WHERE ";
            break;
        case 3:
            $sql.= "";
            break;
        case 4:
            $sql.= "dpo_master_grupo WHERE ";
            break;
    }
    $sql.="id_anyo=".$anyo." AND activo=1;";    
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit ("Se ha producido un error al recuperar las encuestas de base de datos (getEstadoEncuesta):".$sql);
    } else if ($consulta->num_rows < 1) {
        echo ("La encuesta ".$id_encuesta." del indicador relacionado actualmente no está creada.");
    } else { //La encuesta existe
               
        $fila = $consulta->fetch_array();
        $consulta->free_result();
        
        if ($fila['estado']==1) {$estado=true;} //La encuesta está abierta
        else {$estado=false;} //Está cerrada
    }
    writeLog("Estado encuesta".$fila["id_anyo"].": ".$estado);
    return $estado;
}


/*
 * Funcion que comprueba si el indicador relacionado existe (activo=1) y si tiene valor
 * 
 * @param int $id_tipo_encuesta: La encuesta 
 * @param int $id_encuesta: El id de la encuesta sobre el que buscar la encuesta del indicador origen
 * 
 * @return array Devuelve un array con las relaciones del indicador
 */
function getValorRelacionado($id_indicador, $id_tipo_encuesta, $id_encuesta) {// $anyo) {

    writeLog("id_encuesta:".$id_encuesta.".");
    $sql_connect = conectar_bd();
    $valor_real=null;
    
    $sql = "SELECT * FROM ";
    switch ($id_tipo_encuesta) {
        case 1:            
            $sql.= "master_cuadro_mando WHERE id=";
            break;
        case 2:   
            $sql.= "master_cuadro_mando WHERE id=";
            break;
        case 3:
            $sql.= "";
            break;
        case 4:
            //recupero el id del dpo_grupo según el año
            $sql.= "dpo_master_grupo WHERE id_anyo=";
            break;
    }    
    $sql.=$id_encuesta." AND activo=1 ORDER BY au_fec_alta DESC;";    
    writeLog($sql);
    
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit ("Se ha producido un error al recuperar la encuesta de base de datos (getValorRelacionado):".$sql);
    } else if ($consulta->num_rows < 1) {
        exit("No hay ninguna encuesta ".$id_tipo_encuesta." activa con id ".$id_encuesta."(1)");
    } else {
        $fila = $consulta->fetch_array();
                
        //Una vez tenemos el id del grupo, buscamos el valor:
        $sql="";
        switch ($id_tipo_encuesta) {
            case 1: //CMO
                $sql.= "SELECT * FROM ".$fila['tabla']." WHERE id_indicador=".$id_indicador." AND activo=1;";
                 writeLog($sql);
                $consulta = db_query($sql, $sql_connect);
                 if (!$consulta) {
                    exit ("Se ha producido un error al recuperar el valor del indicador CMO de base de datos (getValorRelacionado):".$sql);
                } else if ($consulta->num_rows >= 1) {
                    $indicador = $consulta->fetch_array();                                
                    $consulta->free_result();
                    $valor_real=$indicador["valor"];
                }
                break;
            case 2: //MITMA
                $sql= "SELECT * FROM ".$fila['tabla']." WHERE id_indicador=".$id_indicador." AND activo=1";
                 writeLog($sql);
                $consulta = db_query($sql, $sql_connect);
                 if (!$consulta) {
                    exit ("Se ha producido un error al recuperar el valor del indicador CMO de base de datos (getValorRelacionado):".$sql);
                } else if ($consulta->num_rows >= 1) {
                    $indicador = $consulta->fetch_array();                                
                    $consulta->free_result();
                    $valor_real=$indicador["valor"];
                }
                break;
            case 3: //PRIME
                $sql= "";
                break;
            case 4: //DPO
                //recupero el id del dpo_grupo según el año                
                $sql= "SELECT v.*, i.tipo_input FROM dpo_master_valores v LEFT JOIN dpo_master_indicadores i ON v.id_indicador = i.id WHERE id_grupo_dpo=".$fila["id"]." AND id_indicador=".$id_indicador." AND v.activo=1 ORDER BY v.au_fec_alta DESC";
                writeLog("consulta getValorRelacionado: ".$sql);
                $consulta = db_query($sql, $sql_connect);
                if (!$consulta) {
                    exit ("Se ha producido un error al recuperar el valor del indicador CMO de base de datos (getValorRelacionado):".$sql);
                } else if ($consulta->num_rows >= 1) {

                    $indicador = $consulta->fetch_array();            
                    
                    $consulta->free_result();

                    if (intval($indicador["tipo_input"]) == 1) {
                        //$valor_real = !isset($indicador["real_decimal"]) ? "" : $formatter->format($indicador["real_decimal"]);
                        $valor_real = $indicador["real_decimal"];
                        writeLog("tipo decimal: '".$valor_real."'");
                    } else {
                        $valor_real = $indicador["real_fecha"];
                        writeLog("tipo fecha: '".$valor_real."'");
                    }                
                }                  
                break;
        }
        
    }
        
    return $valor_real;
}

function setValorRelacionado($id_indicador_origen, $id_indicador_relacionado, $id_tipo_encuesta_origen, $id_tipo_encuesta_relacionada, $id_encuesta, $valor, $nuevo=NULL) {
    
    $sql_connect = conectar_bd();
        
    //Recupero el nombre de la encuesta del indicador original:    
    $sql= "SELECT nombre FROM master_encuestas WHERE id=".$id_tipo_encuesta_origen." AND activo=1";
    writeLog("setValorRelacionado0: ".$sql);
    $consulta = db_query($sql, $sql_connect);
    $encuesta = $consulta->fetch_array();
        
    $consulta->free_result();
    
    $sql = "SELECT * FROM ";
    switch ($id_tipo_encuesta_relacionada) {
        case 1:
            //$sql.= "master_cuadro_mando WHERE es_anual=1 AND ";
            $sql.= "master_cuadro_mando WHERE id=";
            break;
        case 2:            
            break;
        case 3:
            $sql.= "";
            break;
        case 4:
            //recupero el id del dpo_grupo según el año
            $sql.= "dpo_master_grupo WHERE id_anyo=";
            break;
    }    
    $sql.=$id_encuesta." AND activo=1 ORDER BY au_fec_alta DESC;";
    writeLog("setValorRelacionado1:".$sql);
    $consulta = db_query($sql, $sql_connect);
    $grupo = $consulta->fetch_array();
    $id_anyo=$grupo['id_anyo'];
    writeLog("id del año (setValorRelacionado2):".$id_anyo);
    
    $consulta->free_result();
    
    
    $sql="";
    switch ($id_tipo_encuesta_relacionada) {
        case 1:
            if (!$nuevo) {
                                
                $sql= "SELECT valor FROM ".$grupo['tabla']." WHERE id_indicador=".$id_indicador_relacionado." AND activo=1;";
                writeLog($sql);
                $consulta = db_query($sql, $sql_connect);
                 if (!$consulta) {
                    exit ("Se ha producido un error al recuperar el valor del indicador CMO de base de datos (setValorRelacionado4):".$sql);
                } else if ($consulta->num_rows >= 1) {
                    $indicador = $consulta->fetch_array();                    
                    $valor_ant_relacionado=$indicador["valor"];
                    $consulta->free_result();                    

                    $sql ="UPDATE ".$grupo['tabla']." SET valor=".$valor;
                    $sql.=", au_fec_modif = SYSDATE(), au_usu_modif = " . $_SESSION["user"]["id"] . ", au_proc_modif = 'Valor automático por relación con indicador ".$id_indicador_origen." de la encuesta ".$encuesta['nombre']."', au_lock = au_lock + 1";
                    $sql.=" WHERE id_indicador=".$id_indicador_relacionado." AND activo=1;";                    
                    writeLog($sql);                     
                    $accion = db_query($sql, $sql_connect);                    
                                                           
                    //Añadimos el historial del cambio en la tabla CM_LOG para el indicador relacionado
                    $sql ="INSERT INTO cm_log_".substr($grupo['tabla'],-3,3)." (tipo_cambio, id_indicador, valor_antiguo, valor_nuevo, au_fec_cambio, au_usu_cambio, au_proc_cambio)";
                    $sql.=" VALUES (7, ".$id_indicador_relacionado.", ".$valor_ant_relacionado.", ".$valor.", SYSDATE(), ". $_SESSION["user"]["id"] . ", 'Valor automático por relación con indicador ".$id_indicador_origen." de la encuesta ".$encuesta['nombre']."');";
                    writeLog($sql);
                    $accion = db_query($sql, $sql_connect);
                    
                }
                
            } else {
                
                $sql= "SELECT responsable FROM ".$grupo['tabla']." WHERE id_indicador=".$id_indicador_origen." AND activo=1;";
                writeLog($sql);
                $consulta = db_query($sql, $sql_connect);

                if (!$consulta) {
                    exit ("Se ha producido un error al recuperar el indicador CMO para crear un valor nuevo (setValorRelacionado5):".$sql);
                } else {
                    $indicador = $consulta->fetch_array();                    
                    $consulta->free_result();       
               
                    $sql ="INSERT INTO ".$grupo['tabla']." (id_indicador, responsable, valor, au_fec_alta, au_usu_alta, au_proc_alta) ";
                    $sql.=" VALUES (".$id_indicador_relacionado.", ".$indicador["responsable"].", ".$valor.", SYSDATE(), ". $_SESSION["user"]["id"] .",'Valor automático por relación con indicador ".$id_indicador_origen." de la encuesta ".$encuesta['nombre']."');";                    
                    writeLog($sql);                     
                    $accion = db_query($sql, $sql_connect);                    
                                        
                    //Añadimos el historial del cambio en la tabla CM_LOG para el indicador relacionado
                    $sql ="INSERT INTO cm_log_".substr($grupo['tabla'],-3,3)." (tipo_cambio, id_indicador, valor_nuevo, au_fec_cambio, au_usu_cambio, au_proc_cambio)";
                    $sql.=" VALUES (7, ".$id_indicador_relacionado.", ".$valor.", SYSDATE(), ". $_SESSION["user"]["id"] . ", 'Valor automático por relación con indicador ".$id_indicador_origen." de la encuesta ".$encuesta['nombre']."');";
                    writeLog($sql);                    
                    $accion = db_query($sql, $sql_connect);
                }
            }            
            //$consulta->free_result();
            break;
        case 2:
            $sql.= "";
            break;
        case 3:
            $sql.= "";
            break;
        case 4:
            
            //$sql="";
            if (!$nuevo) {
                //recupero el id del dpo_grupo según el año
            
                $sql= "SELECT v.*, i.tipo_input FROM dpo_master_valores v LEFT JOIN dpo_master_indicadores i ON v.id_indicador = i.id WHERE id_grupo_dpo=".$grupo["id"]." AND id_indicador=".$id_indicador_relacionado." AND v.activo=1 ORDER BY v.au_fec_alta DESC";
                writeLog($sql);
                $consulta = db_query($sql, $sql_connect);
                
                if (!$consulta) {
                    exit ("Se ha producido un error al recuperar el valor del indicador DPO para actualizar el valor (setValorRerlacionado):".$sql);
                } else if ($consulta->num_rows >= 1) {

                    $indicador = $consulta->fetch_array();
                    //$consulta->free_result();
                    writeLog("id: ".$indicador["id"]." con tipo input:".$indicador["tipo_input"]);

                    $sql ="UPDATE dpo_master_valores v SET real_".((intval($indicador["tipo_input"]) == 1)? "decimal=":"fecha='").$valor.((intval($indicador["tipo_input"]) == 1)? "":"'");
                    $sql.=", au_fec_modif = SYSDATE(), au_usu_modif = " . $_SESSION["user"]["id"] . ", au_proc_modif = 'Valor automático por relación con indicador ".$id_indicador_origen." de la encuesta ".$encuesta['nombre']."', au_lock = au_lock + 1";
                    $sql.=" WHERE id_grupo_dpo=".$grupo["id"]." AND id_indicador=".$id_indicador_relacionado." AND id=".$indicador["id"].";";
                    
                    $consulta->free_result();
                }
                
            } else {
                //Si es nuevo tengo que recuperar el tipo input del indicador par saber si lo guardo en el camp real_decimal o real_fecha:
                $sql= "SELECT i.* FROM dpo_master_indicadores i WHERE id=".$id_indicador_relacionado." AND activo=1";
                writeLog($sql);
                $consulta = db_query($sql, $sql_connect);

                if (!$consulta) {
                    exit ("Se ha producido un error al recuperar el indicador DPO para crear un valor nuevo (guardaValorRerlacionado):".$sql);
                } else if ($consulta->num_rows >= 1) {
                    $indicador = $consulta->fetch_array();                
                    writeLog("id: ".$indicador["id"]." con tipo input:".$indicador["tipo_input"]);

                    $sql = "INSERT INTO dpo_master_valores (id_grupo_dpo, id_indicador, real_".((intval($indicador["tipo_input"]) == 1)? "decimal":"fecha").", au_fec_alta, au_usu_alta, au_proc_alta)";
                    $sql.= " VALUES (".$grupo["id"].",".$id_indicador_relacionado.",".((intval($indicador["tipo_input"]) == 1)? "":"'").$valor.((intval($indicador["tipo_input"]) == 1)? "":"'")." , SYSDATE(), " . $_SESSION["user"]["id"] . ", 'Valor automático por relación con indicador ".$id_indicador_origen." de la encuesta ".$encuesta['nombre']."');";
                    
                    $consulta->free_result();
                }
            }
            
            writeLog($sql);
            $accion = db_query($sql, $sql_connect);
            //$accion->free_result();
            //$consulta->free_result();
            break;
    }
    
}


function gestionarRelacionesDirectas_desdeCMO($id,$cm,$valor,$encuesta_origen=NULL, $es_anual=false){

    $relaciones=getRelaciones($id,$encuesta_origen,$cm["id_anyo"],$cm["es_anual"]); //Estamos en CMO por lo tanto le paso como id de la encuesta un 1, y el id del año de las relaciones
    if (count($relaciones)>0) {
        //Recorremos uno por una las relaciones para actualizar el nuevo valor. MITMA lo ignoro porque es CMO
        foreach ($relaciones as $rel) {
            switch ($rel['id_encuesta_relacionada']) {
                case 1: //CMO 
                    writeLog("El indicador ".$rel['id_origen']." tiene relación con el indicador ".$rel['id_relacionado']." de CMO");
                    $valor_real=getValorRelacionado(intval($rel['id_relacionado']),intval($rel['id_encuesta_relacionada']),$cm["id"]);
                    writeLog("Nuevo valor: ".$valor." y valor del indicador relacionado: ".$valor_real);
                    if (!is_null($valor_real)){
                        //El indicador ya tiene un valor guardado en la encuesta, ahora hay que comprobar si es diferente al nuevo:
                        if ($valor!=$valor_real) {
                            writeLog("Actualizamos el valor relacionado de CMO");
                            setValorRelacionado(intval($id),intval($rel['id_relacionado']),intval($rel['id_encuesta_origen']),intval($rel['id_encuesta_relacionada']),$cm["id"],floatval($valor),false);//$cm["id_anyo"],floatval($valor),false);
                        } else {                                            
                            //No hacemos nada, los valores coinciden
                            writeLog("No hacemos nada, los valores coinciden");
                        }
                    } else {
                        //la encuesta aún no tiene valor para ese indicadorm por lo tanto creamos el registro nuevo con el valor del indicador de CMO:
                        writeLog("Creamos el valor relacionado de CMO");
                        setValorRelacionado(intval($id),intval($rel['id_relacionado']),intval($rel['id_encuesta_origen']),intval($rel['id_encuesta_relacionada']),$cm["id"],floatval($valor),true);//$cm["id_anyo"],floatval($valor),true);
                    }
                    break;

                case 2: //MITMA
                    writeLog("El indicador ".$rel['id_origen']." tiene relación con el indicador ".$rel['id_relacionado']." de MITMA");
                    //NO PROCEDE PORQUE MITMA ES UNA VISTA DE CMO
                    break;

                case 3: //PRIME
                    writeLog("El indicador ".$rel['id_origen']." tiene relación con el indicador ".$rel['id_relacionado']." de PRIME");
                    //PARECE QUE NO HAY RELACIONES, NO SABEN SI HABRÁ EN EL FUTURO
                    break;

                case 4: //DPO
                    writeLog("El indicador ".$rel['id_origen']." tiene relación con el indicador ".$rel['id_relacionado']." de DPO");
                    //Comprobar el estado en la que se encuentra la encuesta
                    $estado_encuesta=getEstadoEncuesta($rel['id_encuesta_relacionada'],$cm["id_anyo"]);
                    writeLog("Estado de la encuesta: ".$estado_encuesta);
                    //Si la encuesta del indicador relacionado está abierta, entonces procedemos a actualizar el valor del indicador. Si no, el valor del relacionado no se toca (caso raro...)
                    if ($estado_encuesta) {
                        // Si la encuesta existe y está abierta:
                        $valor_real=getValorRelacionado(intval($rel['id_relacionado']),intval($rel['id_encuesta_relacionada']),$cm["id_anyo"]);
                        writeLog("Nuevo valor: ".$valor." y valor del indicador relacionado: ".$valor_real);
                        if (!is_null($valor_real)){
                            //El indicador ya tiene un valor guardado en la encuesta, ahora hay que comprobar si es diferente al nuevo:
                            if ($valor!=$valor_real) {
                                writeLog("Actualizamos el valor relacionado de DPO");
                                setValorRelacionado(intval($id),intval($rel['id_relacionado']),intval($rel['id_encuesta_origen']),intval($rel['id_encuesta_relacionada']),$cm["id_anyo"],floatval($valor),false);
                            } else {                                            
                                //No hacemos nada, los valores coinciden
                                writeLog("No hacemos nada, los valores coinciden");
                            }
                        } else {
                            //la encuesta aún no tiene valor para ese indicadorm por lo tanto creamos el registro nuevo con el valor del indicador de CMO:
                            writeLog("Creamos el valor relacionado de DPO");
                            setValorRelacionado(intval($id),intval($rel['id_relacionado']),intval($rel['id_encuesta_origen']),intval($rel['id_encuesta_relacionada']),$cm["id_anyo"],floatval($valor),true);
                        }
                    } else {
                         //No hacemos nada, la encuesta no existe
                         writeLog("No hacemos nada, la encuesta de DPO no existe");
                    }
                    break;
            }
        }        
    }
    
    return $relaciones;
    
}


function gestionarRelacionesDirectas_desdeDPO ($id,$id_anyo,$valor_real,$encuesta_origen=NULL){
    
    $relaciones=getRelaciones($id,$encuesta_origen,$id_anyo,true); //Estamos en DPO por lo tanto le paso como id de la encuesta un 4, y un true porque es anual
    if (!empty($relaciones)) {
        //Recorremos uno por una las relaciones para actualizar el nuevo valor. MITMA lo ignoro porque es CMO
        foreach ($relaciones as $rel) {

            switch ($rel['id_encuesta_relacionada']) {

                case 1: //CMO 
                    writeLog("El indicador ".$rel['id_origen']." tiene relación con el indicador ".$rel['id_relacionado']." de CMO");                          
                    break;

                case 2: //MITMA
                    writeLog("El indicador ".$rel['id_origen']." tiene relación con el indicador ".$rel['id_relacionado']." de MITMA");
                    //NO PROCEDE PORQUE MITMA ES UNA VISTA DE CMO
                    break;

                case 3: //PRIME
                    writeLog("El indicador ".$rel['id_origen']." tiene relación con el indicador ".$rel['id_relacionado']." de PRIME");
                    break;

                case 4: //DPO
                    writeLog("El indicador ".$rel['id_origen']." tiene relación con el indicador ".$rel['id_relacionado']." de DPO");
                    //Comprobar el estado en la que se encuentra la encuesta
                    $estado_encuesta=getEstadoEncuesta($rel['id_encuesta_relacionada'],$id_anyo);                            
                    //Si la encuesta del indicador relacionado está abierta, entonces procedemos a actualizar el valor del indicador. Si no, el valor del relacionado no se toca (caso raro...)
                    if ($estado_encuesta) {
                        // Si la encuesta existe y está abierta:
                        $valor=getValorRelacionado(intval($rel['id_relacionado']),intval($rel['id_encuesta_relacionada']),$id_anyo);
                        writeLog("Nuevo valor: ".$valor." y valor del indicador relacionado: ".$valor_real);
                        if (!is_null($valor)){
                            //El indicador ya tiene un valor guardado en la encuesta, ahora hay que comprobar si es diferente al nuevo:
                            if ($valor!=$valor_real) {
                                writeLog("Actualizamos el valor relacionado de DPO:".$valor_real);
                                setValorRelacionado(intval($id),intval($rel['id_relacionado']),intval($rel['id_encuesta_origen']),intval($rel['id_encuesta_relacionada']),$id_anyo,$valor_real,false);
                            } else {                                            
                                //No hacemos nada, los valores coinciden
                                writeLog("No hacemos nada, los valores coinciden");
                            }
                        } else {
                            //la encuesta aún no tiene valor para ese indicadorm por lo tanto creamos el registro nuevo con el valor del indicador de CMO:
                            writeLog("Creamos el valor relacionado de DPO:".$valor_real);
                            setValorRelacionado(intval($id),intval($rel['id_relacionado']),intval($rel['id_encuesta_origen']),intval($rel['id_encuesta_relacionada']),$id_anyo,$valor_real,true);
                        }
                    } else {
                         //No hacemos nada, la encuesta no existe
                         writeLog("No hacemos nada, la encuesta de DPO no existe");
                    }
                    break;
            }
        }
     } else {
        writeLog("El indicador no tiene relaciones directas con ningún otro indicador.");
     }
}

function gestionarRelacionesCalculadas($id, $indicador, $cm, $valor, $encuesta_origen=NULL, $id_anyo=NULL){
    //writeLog("cm[id_anyo]=".$cm["id_anyo"]. " - id_anyo=".$id_anyo);
    //if ($encuesta_origen==1) {
    //    $relacionesCalculadas=getRelacionesCalculadas($id,$encuesta_origen, $cm["id_anyo"]); //Estamos en CMO por lo tanto le paso como id de la encuesta un 1, y el id del año de las relaciones
    //} elseif ($encuesta_origen==4) {
        $relacionesCalculadas=getRelacionesCalculadas($id,$encuesta_origen, $id_anyo); //Estamos en CMO por lo tanto le paso como id de la encuesta un 1, y el id del año de las relaciones
    //}
    $numRelsCalculadas=count($relacionesCalculadas);
    writeLog("Num rels calculadas: ".$numRelsCalculadas);
    if ($numRelsCalculadas>0) {
        foreach ($relacionesCalculadas as $rel) { //De momento lel requisito es que un indicador solo participará en no más de 1 relación calculada, pro por si acaso meto el bucle:
            if ($rel["id_destino"]!=$indicador["id"]){ //&& $rel["id_tipo_escuesta_destino"]!=1) {
                //El indicador actual es un sumando, por lo que el cambio de su valor conlleva el recálculo del indicador destino (suma):
                //Para ello necesito saber si el valor del indicador destino existe, para llamar al método setvalorRelacionado diciéndole que lo cree o que lo actualice:
                writeLog("Tipo1:".$rel["id_tipo_encuesta_origen1"].", Tipo2:".$rel["id_tipo_encuesta_origen2"].", Tipo D:".$rel["id_tipo_encuesta_destino"]);

                if ($rel["id_tipo_encuesta_origen1"]==1) {                                
                    $valor_Origen1=getValorRelacionado($rel["id_origen1"], $rel["id_tipo_encuesta_origen1"], $cm["id"]);
                } elseif ($rel["id_tipo_encuesta_origen1"]==4) {                                
                    //$valor_Origen1=getValorRelacionado($rel["id_origen1"], $rel["id_tipo_encuesta_origen1"], $cm["id_anyo"]);
                    $valor_Origen1=getValorRelacionado($rel["id_origen1"], $rel["id_tipo_encuesta_origen1"], $id_anyo);
                } else {                                
                    $valor_Origen1=NULL;                                
                }  
                writeLog("valor Origen1:".$valor_Origen1);                                                 

                if ($rel["id_tipo_encuesta_origen2"]==1) {                                
                    $valor_Origen2=getValorRelacionado($rel["id_origen2"], $rel["id_tipo_encuesta_origen2"], $cm["id"]);
                } elseif ($rel["id_tipo_encuesta_origen2"]==4) {                                
                    $valor_Origen2=getValorRelacionado($rel["id_origen2"], $rel["id_tipo_encuesta_origen2"], $id_anyo);
                } else {                                
                    $valor_Origen2=NULL;                                
                }                            
                writeLog("valor Origen2:".$valor_Origen2);

                //Comprobamos si existe o no el valor en el indicador destino:
                if (!is_null($valor_Origen1) && !is_null($valor_Origen2)) {
                    if ($rel["id_tipo_encuesta_destino"]==1) {                                    
                        $valor_destino=getValorRelacionado($rel["id_destino"], $rel["id_tipo_encuesta_destino"], $cm["id"]);
                    } elseif ($rel["id_tipo_encuesta_destino"]==4) {                                    
                        $valor_destino=getValorRelacionado($rel["id_destino"], $rel["id_tipo_encuesta_destino"], $id_anyo);
                    } else {                                    
                        $valor_destino=NULL;                                
                    }     

                    $nuevovalorcalculado= $valor_Origen1 + $valor_Origen2;
                    writeLog("Nuevo valor:".$nuevovalorcalculado);
                    writeLog("valor destino:".$valor_destino);                                
                    writeLog("¿Destino nuevo?:".!is_null($valor_destino));
                    if ($rel["id_tipo_encuesta_destino"]==1) {                                    
                        setValorRelacionado($id, $rel["id_destino"], $encuesta_origen, intval($rel["id_tipo_encuesta_destino"]), intval($cm["id"]), $nuevovalorcalculado,is_null($valor_destino));
                    } elseif ($rel["id_tipo_encuesta_destino"]==4) {                                    
                        //setValorRelacionado($id, $rel["id_destino"], $encuesta_origen, intval($rel["id_tipo_encuesta_destino"]), intval($cm["id_anyo"]), $nuevovalorcalculado,is_null($valor_destino));
                        setValorRelacionado($id, $rel["id_destino"], $encuesta_origen, intval($rel["id_tipo_encuesta_destino"]), intval($id_anyo), $nuevovalorcalculado,is_null($valor_destino));
                    }                                      
                }
            }
        }
    }
    return $relacionesCalculadas;
}

function check_AmbosGrupos($tipo_encuesta,$id,$id_anyo,$es_anual,$grupo_orig) {
    
    $relaciones=getRelaciones($id,$tipo_encuesta,$id_anyo,$es_anual);
    $numRels=count($relaciones); 
    
    $ambos_grupos=false;
    if ($numRels>0) {                        
        $sql_connect = conectar_bd();
        foreach ($relaciones as $rel): 
            $sql = "SELECT i.grupo FROM ";
            switch (intval($rel['id_encuesta_relacionada'])) {                                
                case 3:                                    
                    $sql.= "prime_";
                    break;
                case 4:                                    
                    $sql.= "dpo_";
                    break;                                    
            }
            $sql.= "master_indicadores i WHERE i.id=".$rel['id_relacionado']." AND i.activo = 1;";
            writeLog($sql);
            $consulta = db_query($sql, $sql_connect);
            if (!$consulta) {
                exit("No se han podido recuperar los documentos adjuntos de la base de datos.");
            } else {
                $grupo=$consulta->fetch_array();
                if ($grupo_orig!=$grupo['grupo']) {
                    $ambos_grupos=true;
                }
                $consulta->free_result();
            }
        endforeach;
        desconectar_bd($sql_connect);
    }
    return $ambos_grupos;
}

                        
function getPaneles($id_tipo_encuesta,$id_ind,$id_anyo,$es_anual,$id_panel_orig) {
     
    $relaciones=getRelaciones($id_ind,$id_tipo_encuesta,$id_anyo,$es_anual,$id_tipo_encuesta,NULL);
    $numRels=count($relaciones); 
        
    $paneles=strval($id_panel_orig);
    $sql_connect = conectar_bd();             
    
    if ($numRels>0) {
        foreach ($relaciones as $rel):             
            $sql = "SELECT panel FROM dpo_master_indicadores WHERE id=".$rel['id_relacionado']." AND activo = 1;";        
            writeLog($sql);
            $consulta = db_query($sql, $sql_connect);
            if (!$consulta) {
                exit("No se han podido recuperar los documentos adjuntos de la base de datos z.");
            } else {
                $panel=$consulta->fetch_array();
                $paneles.=",".strval($panel["panel"]);                
                $consulta->free_result();
            }            
        endforeach;
    }        
        
    $sql = "SELECT DISTINCT i.panel as panel,p.nombre as nombre FROM dpo_master_indicadores i INNER JOIN dpo_master_panel p ON i.panel=p.id AND p.activo=1 WHERE i.panel IN (".$paneles.") AND i.activo = 1;";        
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    $nombres="";
    if (!$consulta) {
        exit("No se han podido recuperar los documentos adjuntos de la base de datoszz.");
    } else {            
        while ($panel = $consulta->fetch_array()) {
            $nombres.=$panel["nombre"]."<br>";
        }        
        $consulta->free_result();
    }

    desconectar_bd($sql_connect);
    
    return $nombres;
}


/*
 * Funcion que comprueba si un indicador forma parte de un cuadro de mando 
 * 
 * @param array $indicador El indicador que queremos comprobar
 * @param array $cm El cuadro de mando en el que buscaremos el indicador
 * 
 * @return boolean Devuelve true si el indicador pertenece al cuadro de mando
 */

function contieneIndicador($indicador, $cm) {

    $fecha_alta_cm = !is_null($cm['au_fec_alta']) ? strtotime($cm['au_fec_alta']) : null;
    $fecha_alta_indicador = !is_null($indicador['au_fec_alta']) ? strtotime($indicador['au_fec_alta']) : null;
    $fecha_baja_indicador = !is_null($indicador['au_fec_baja']) ? strtotime($indicador['au_fec_baja']) : null;
    if ($fecha_alta_cm > $fecha_alta_indicador) {
        if (is_null($fecha_baja_indicador)) {
            return true;
        } elseif ($fecha_alta_cm < $fecha_baja_indicador) {
            return true;
        }
    }

    return false;
}

/*
 * Funcion que devuelve los indicadores que forman parte de un cuadro de mando
 * 
 * @param array $cm El cuadro de mando del que buscaremos los indicadores
 * 
 * @return array Devuelve un array con los indicadores que pertenecen al cuadro 
 *               de mando
 */

function getIndicadores($cm) {

    $sql_connect = conectar_bd();
    $indicadores_todos = array();
    $indicadores_cm = array();

    $fecha_alta_cm = !is_null($cm['au_fec_alta']) ? strtotime($cm['au_fec_alta']) : null;

    $sql = "SELECT * FROM master_indicadores;";
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("Se ha producido un error al recuperar los cms de base de datos.");
    } else if ($consulta->num_rows < 1) {
        exit("No hay ningún indicador en base de datos.");
    } else {
        while ($fila = $consulta->fetch_array()) {
            $indicadores_todos[] = $fila;
        }
        $consulta->free_result();
        foreach ($indicadores_todos as $ind) {
            $fecha_alta_indicador = !is_null($ind['au_fec_alta']) ? strtotime($ind['au_fec_alta']) : null;
            $fecha_baja_indicador = !is_null($ind['au_fec_baja']) ? strtotime($ind['au_fec_baja']) : null;
            if ($fecha_alta_cm > $fecha_alta_indicador) {
                if (is_null($fecha_baja_indicador)) {
                    array_push($indicadores_cm, $ind);
                } elseif ($fecha_alta_cm < $fecha_baja_indicador) {
                    array_push($indicadores_cm, $ind);
                }
            }
        }
    }

    return $indicadores_cm;
}

/*
 * Funcion que devuelve los indicadores que forman parte de un cuadro de mando,
 * junto con el valor que tienen actualmente
 * 
 * @param array $cm El cuadro de mando del que buscaremos los indicadores
 * 
 * @return array Devuelve un array con los indicadores que pertenecen al cuadro 
 *               de mando y su valor asociado
 */

function getIndicadoresConValor($cm) {

    $indicadores_cm = array();
    $sql_connect = conectar_bd();

    $sql = "SELECT cat.nombre AS nombre_categoria, ";
    $sql .= "per.nombre AS nombre_periodicidad, u.nombre AS nombre_unidad, ";
    $sql .= is_null($cm["tabla"]) ? "null AS valor, null AS observaciones, " : "val.valor, val.observaciones, ";
    $sql .= "m.valor AS meta, ";
    $sql .= "i.* FROM master_indicadores i ";
    $sql .= "LEFT JOIN master_org_categorias cat ON cat.id = i.categoria AND cat.activo = 1 ";
    $sql .= "LEFT JOIN master_indicador_periodicidad per ON per.id = i.periodicidad AND per.activo = 1 ";
    $sql .= "LEFT JOIN master_indicador_unidades u ON u.id = i.unidad AND u.activo = 1 ";
    $sql .= is_null($cm["tabla"]) ? "" : "LEFT JOIN " . $cm["tabla"] . " val ON val.id_indicador = i.id AND val.activo = 1 ";
    $sql .= "LEFT JOIN master_meta_valores m ON m.id_grupo_meta = " . $cm["grupo_metas"] . " AND m.id_indicador = i.id AND m.activo = 1 ";
    $sql .= "WHERE i.en_servicio = 1 ";
    $sql .= "AND i.au_fec_alta <= '" . $cm['au_fec_alta'] . "' ";
    $sql .= "AND (('" . $cm['au_fec_alta'] . "' <= i.au_fec_baja) OR isnull(i.au_fec_baja)) ";
    //$sql .= "GROUP BY i.id "; 
    $sql .= "GROUP BY i.nombre "; //Guillermo 12/oct/22: quito las duplicidades de indicadores por nombre (tal cual lo he cambiado en el listado de indics)
    $sql .= "ORDER BY i.categoria;";
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        lanzar_error("La consulta a la base de datos ha fallado.", true);
    } else {
        while ($fila = $consulta->fetch_array()) {
            $indicadores_cm[] = $fila;
        }
    }

    return $indicadores_cm;
}

/*
 * Funcion que devuelve los indicadores separados en un array de arrays cuyo
 * indice es el responsable
 * 
 * @param array $indicadores El listado de indicadores que queremos separar
 * 
 * @return array Devuelve un array con los indicadores separados por responsable
 */

function separarIndicadoresByResponsable($indicadores) {
    $resultado = array();
    foreach ($indicadores as $ind) {
        $resultado[$ind['responsable']][] = $ind;
    }

    return $resultado;
}

/*
 * Funcion que devuelve los indicadores separados en un array de arrays cuyo
 * indice es el suplente
 * 
 * @param array $indicadores El listado de indicadores que queremos separar
 * 
 * @return array Devuelve un array con los indicadores separados por suplente
 */

function separarIndicadoresBySuplente($indicadores) {
    $resultado = array();
    foreach ($indicadores as $ind) {
        $resultado[$ind['suplente']][] = $ind;
    }

    return $resultado;
}

/*
 * Funcion que devuelve los indicadores separados en un array de arrays cuyo
 * indice es la direccion
 * 
 * @param array $indicadores El listado de indicadores que queremos separar
 * 
 * @return array Devuelve un array con los indicadores separados por direccion
 */

function separarIndicadoresByDireccion($indicadores) {
    $resultado = array();
    foreach ($indicadores as $ind) {
        $resultado[$ind['direccion']][] = $ind;
    }

    return $resultado;
}

/*
 * Funcion que devuelve los indicadores separados en un array de arrays cuyo
 * indice es el nivel (SOLO PARA DPO)
 * 
 * @param array $indicadores El listado de indicadores que queremos separar
 * 
 * @return array Devuelve un array con los indicadores separados por nivel
 */

function separarIndicadoresByNivel($indicadores) {
    $resultado = array();
    foreach ($indicadores as $ind) {
        $resultado[$ind['nivel']][] = $ind;
    }

    return $resultado;
}

/*
 * Funcion que devuelve los indicadores separados en un array de arrays cuyo
 * indice es la categoria (SOLO PARA DPO)
 * 
 * @param array $indicadores El listado de indicadores que queremos separar
 * 
 * @return array Devuelve un array con los indicadores separados por categoria
 */

function separarIndicadoresByCat($indicadores) {
    $resultado = array();
    foreach ($indicadores as $ind) {
        $resultado[$ind['categoria']][] = $ind;
    }

    return $resultado;
}

/*
 * Funcion que devuelve los indicadores separados en un array de arrays cuyo
 * indice es el panel (SOLO PARA DPO)
 * 
 * @param array $indicadores El listado de indicadores que queremos separar
 * 
 * @return array Devuelve un array con los indicadores separados por panel
 */

function separarIndicadoresByPanel($indicadores) {
    $resultado = array();
    foreach ($indicadores as $ind) {
        $resultado[$ind['panel']][] = $ind;
    }

    return $resultado;
}

/*
 * Funcion que devuelve los indicadores separados en un array de arrays cuyo
 * indice es el objetivo estrategico (SOLO PARA DPO)
 * 
 * @param array $indicadores El listado de indicadores que queremos separar
 * 
 * @return array Devuelve un array con los indicadores separados por objetivo estrategico
 */

function separarIndicadoresByObjEstrategico($indicadores) {
    $resultado = array();
    foreach ($indicadores as $ind) {
        $resultado[$ind['id_objetivo_estrategico']][] = $ind;
    }

    return $resultado;
}

/*
 * Funcion que devuelve los indicadores separados en un array de arrays cuyo
 * indice es el objetivo tactico (SOLO PARA DPO)
 * 
 * @param array $indicadores El listado de indicadores que queremos separar
 * 
 * @return array Devuelve un array con los indicadores separados por objetivo tactico
 */

function separarIndicadoresByObjTactico($indicadores) {
    $resultado = array();
    foreach ($indicadores as $ind) {
        $resultado[$ind['id_objetivo_tactico']][] = $ind;
    }

    return $resultado;
}

/*
 * Funcion que comprueba si se ha cumplido la meta de un indicador
 * 
 * @param array $indicador El indicador que queremos comprobar
 * @param float $valor El valor del indicador
 * @param float $meta La meta para comparar
 * 
 * @return boolean Devuelve true si se cumple la meta, false en otro caso
 */

function metaCumplida($indicador, $valor, $meta) {
    $grado_cumplimiento = -1;

    if (isset($valor) && isset($meta)) {

        $relacion = $indicador['cumplimiento_meta'];

        if ($relacion == 0) {
            if ($valor >= $meta) {
                $grado_cumplimiento = 1;
            } else {
                $grado_cumplimiento = 0;
            }
//            if(($valor < 0) && ($meta < 0)){
//                $grado_cumplimiento = $meta / $valor;
//            }else{
//                if($meta == 0){
//                    if($valor < 0){
//                        $grado_cumplimiento = 0; 
//                    }else{
//                        $grado_cumplimiento = 1; 
//                    }
//                    
//                }else{
//                    $grado_cumplimiento = $valor / $meta;
//                }
//
//            }
        } else {
            if ($meta >= $valor) {
                $grado_cumplimiento = 1;
            } else {
                $grado_cumplimiento = 0;
            }
//            if(($valor < 0) && ($meta < 0)){
//                $grado_cumplimiento = $valor / $meta;
//            }else{
//                if($valor == 0){
//                    if($meta < 0){
//                        $grado_cumplimiento = 0; 
//                    }else{
//                        $grado_cumplimiento = 1; 
//                    }
//                }else{
//                    $grado_cumplimiento = $meta / $valor;
//                }
//
//            }
        }
    }
    return ($grado_cumplimiento >= 1) ? true : false;
}

/*
 * Funcion que comprueba si un dni ya existe en la base de datos 
 * 
 * @param string $dni El dni a buscar
 * 
 * @return int Devuelve el id del usuario si el dni se ha encontrado, null en otro caso
 */

function checkDniDb($dni) {

    $encontrado = null;
    if (!empty($dni)) {
        $usuarios = array();
        $i = 0;
        $conexion = conectar_bd();
        $sql = "SELECT * FROM users u WHERE u.id_perfil<30 AND u.activo = 1;";
        $consulta = db_query($sql, $conexion);

        writeLog($sql);
        if ($consulta) {
            while ($fila = $consulta->fetch_array()) {
                $usuarios[] = $fila;
            }
            $consulta->free_result();
        }

        while (($i < count($usuarios)) && is_null($encontrado)) {
            if ($dni == $usuarios[$i]['dni']) {
                $encontrado = $usuarios[$i]['id'];
            }
            $i++;
        }
        desconectar_bd($conexion);
    }

    return $encontrado;
}

/*
 * Funcion que comprueba si un login ya existe en la base de datos 
 * 
 * @param string $login El login a buscar
 * 
 * @return int Devuelve el id del usuario si el login se ha encontrado, null en otro caso
 */

function checkLoginDb($login) {

    $encontrado = null;
    if (!empty($login)) {
        $usuarios = array();
        $i = 0;
        $conexion = conectar_bd();
        $sql = "SELECT * FROM users u WHERE u.id_perfil<30 AND u.activo = 1;";
        $consulta = db_query($sql, $conexion);

        writeLog($sql);
        if ($consulta) {
            while ($fila = $consulta->fetch_array()) {
                $usuarios[] = $fila;
            }
            $consulta->free_result();
        }

        while (($i < count($usuarios)) && is_null($encontrado)) {
            if ($login == $usuarios[$i]['user_ldap']) {
                $encontrado = $usuarios[$i]['id'];
            }
            $i++;
        }
        desconectar_bd($conexion);
    }

    return $encontrado;
}

/*
 * Funcion que comprueba si existe la tabla de registro de un cm
 * Si no existe la crea y actualiza el campo tabla_log en la tabla
 * master_cuadro_mando
 * 
 * @param array $cm El cm para el que comprobaremos si existe su tabla de log
 * 
 * @return string Devuelve el nombre de la tabla
 */

function checktablaLogDb($cm, $proceso_user = null) {
    $sql_connect = conectar_bd();

    $_tablas_log = "cm_log_";
    $tabla = "";

    if (is_null($cm['tabla_log'])) {
        //Si no está creada la tabla, hay que crearla primero:
        $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '" . BBDD_SQUEMA . "' AND table_name LIKE '%" . $_tablas_log . "%';";
        writeLog($sql);
        $consulta = db_query($sql, $sql_connect);
        if (!$consulta) {
            exit("La creación en base de datos de la tabla de log ha fallado.");
        } else {
            $tablas = $consulta->num_rows;
            writeLog($tablas . " tablas de log de cuadros de mando encontradas");
            $consulta->free_result();
            $tablas++;
            $sufijo = $tablas < 10 ? "00" : ($tablas < 100 ? "0" : "");
            $sql = "CREATE TABLE " . $_tablas_log . $sufijo . $tablas . " LIKE master_cuadro_mando_log;";
            writeLog($sql);
            $creacion = db_query($sql, $sql_connect);
            if (!$creacion) {
                exit("ERROR: No se ha podido crear la tabla de log.");
            } else {
                $cm["tabla_log"] = $_tablas_log . $sufijo . $tablas;
                $tabla = $_tablas_log . $sufijo . $tablas;
                //Guardamos el nombre de la tabla creada en el CM:
                if (is_null($proceso_user)) {
                    $proceso_user = $_SESSION["user"]["id"];
                }
                $sql = "UPDATE master_cuadro_mando SET tabla_log = '" . $tabla . "', au_fec_modif = SYSDATE(), au_usu_modif = " . $proceso_user . ", au_proc_modif = '" . php_actual() . "', au_lock = au_lock + 1 WHERE id = " . $cm['id'] . " AND activo = 1;";
                writeLog($sql);
                $modif = db_query($sql, $sql_connect);
                if (!$modif) {
                    exit("Se ha producido un error al actualizar la tabla del Cuadro de Mandos.");
                }
            }
        }
    } else {
        $tabla = $cm['tabla_log'];
    }
    desconectar_bd($sql_connect);
    return $tabla;
}

/*
 * Funcion que comprueba si existe la tabla de datos de un cm
 * Si no existe la crea y actualiza el campo tabla en la tabla
 * master_cuadro_mando
 * 
 * @param array $cm El cm para el que comprobaremos si existe su tabla de datos
 * 
 * @return string Devuelve el nombre de la tabla
 */

function checktablaDatosDb($cm, $proceso_user = null) {
    $sql_connect = conectar_bd();

    $_tablas_datos = "cm_datos_";
    $tabla = "";

    if (is_null($cm['tabla'])) {
        //Si no está creada la tabla, hay que crearla primero:
        $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '" . BBDD_SQUEMA . "' AND table_name LIKE '%" . $_tablas_datos . "%';";
        writeLog($sql);
        $consulta = db_query($sql, $sql_connect);
        if (!$consulta) {
            exit("La creacion en base de datos de la tabla de datos ha fallado.");
        } else {
            $tablas = $consulta->num_rows;
            writeLog($tablas . " tablas de datos de cuadros de mando encontradas");
            $consulta->free_result();
            $tablas++;
            $sufijo = $tablas < 10 ? "00" : ($tablas < 100 ? "0" : "");
            $sql = "CREATE TABLE " . $_tablas_datos . $sufijo . $tablas . " LIKE master_cuadro_mando_datos;";
            writeLog($sql);
            $creacion = db_query($sql, $sql_connect);
            if (!$creacion) {
                exit("ERROR: No se ha podido crear la tabla de datos.");
            } else {
                $cm["tabla"] = $_tablas_datos . $sufijo . $tablas;
                $tabla = $_tablas_datos . $sufijo . $tablas;
                //Guardamos el nombre de la tabla creada en el CM:
                if (is_null($proceso_user)) {
                    $proceso_user = $_SESSION["user"]["id"];
                }
                $sql = "UPDATE master_cuadro_mando SET tabla = '" . $tabla . "', au_fec_modif = SYSDATE(), au_usu_modif = " . $proceso_user . ", au_proc_modif = '" . php_actual() . "', au_lock = au_lock + 1 WHERE id = " . $cm['id'] . " AND activo = 1;";
                //echo $sql;
                $modif = db_query($sql, $sql_connect);
                if (!$modif) {
                    exit("Se ha producido un error al actualizar la tabla del Cuadro de Mandos.");
                }
            }
        }
    } else {
        $tabla = $cm['tabla'];
    }
    desconectar_bd($sql_connect);
    return $tabla;
}

/*
 * Funcion que guarda un nuevo registro de log en la tabla del cm 
 * 
 * @param string $tabla Tabla en la que se insertara el registro
 * @param int $tipo_cambio Tipo de cambio que se ha hecho
 * @param int $id_indicador ID del indicador modificado
 * @param float $valor_antiguo Valor previo que tenia el indicador
 * @param float $valor_nuevo Nuevo valor que se ha introducido para el indicador
 * @param string $doc_generado Nombre del documento generado
 * @param int $proceso_user ID del proceso que llama a la funcion, si se llama
 *                          automaticamente
 * 
 * @return 
 */

function guardarLogCM($tabla, $tipo_cambio, $id_indicador = null, $valor_antiguo = null, $valor_nuevo = null, $doc_generado = "", $proceso_user = null) {
    $sql_connect = conectar_bd();


    if (is_null($proceso_user)) {
        $au_proc_cambio = php_actual();
        $proceso_user = $_SESSION["user"]["id"];
    } else {
        $au_proc_cambio = "import_data_manten.php";
    }
    $sql = "INSERT INTO " . $tabla . " (tipo_cambio, ";
    $sql .= isset($id_indicador) ? "id_indicador, " : "";
    $sql .= "valor_antiguo, ";
    $sql .= "valor_nuevo, ";
    $sql .= "doc_generado, au_fec_cambio, au_usu_cambio, au_proc_cambio) VALUES (";
    $sql .= $tipo_cambio . ", ";
    $sql .= isset($id_indicador) ? $id_indicador . ", " : "";
    $sql .= isset($valor_antiguo) && is_numeric($valor_antiguo) ? $valor_antiguo . ", " : "NULL, ";
    $sql .= isset($valor_nuevo) && is_numeric($valor_nuevo) ? $valor_nuevo . ", " : "NULL, ";
    $sql .= "'" . $doc_generado . "', ";
    $sql .= "SYSDATE(), " . $proceso_user . ", '" . $au_proc_cambio . "');";
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        echo($sql_connect->error);

        exit("La creación del log en base de datos ha fallado.");
        die();
    }
    desconectar_bd($sql_connect);
}

/*
 * Funcion que inserta en la tabla de log de los CM el cambio al actualizar
 * las metas asociadas
 * 
 * @param int $id_gm ID del grupo de metas que se ha modificado
 * @param int $id_indicador ID del indicador modificado
 * @param float $valor_antiguo Valor previo que tenia la meta
 * @param float $valor_nuevo Nuevo valor que se ha introducido para la meta
 * 
 * @return 
 */

function guardarLogMetas($id_gm, $id_indicador, $valor_antiguo, $valor_nuevo) {
    $sql_connect = conectar_bd();

    $sql = "SELECT * FROM master_cuadro_mando cm WHERE cm.grupo_metas = " . $id_gm . " AND cm.activo = 1;";
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se han podido recuperar de BBDD los CMOs con el grupo de metas asignado.");
    } else {
        while ($fila = $consulta->fetch_array()) {
            $cms[] = $fila;
        }
        
        foreach($cms as $cm){
            guardarLogCM(checktablaLogDb($cm), 8, $id_indicador, $valor_antiguo, $valor_nuevo);
        }
    }
    
    desconectar_bd($sql_connect);
}

/*
 * Funcion que devuelve los valores historicos para la grafica anual
 * de un indicador en cuadros de mando anteriores que ya esten 
 * cerrados o presentados
 * 
 * @param array $indicador El indicador del que buscaremos sus datos historicos
 * @param array $cm Informacion del cm para el que buscamos los datos historicos
 * 
 * @return array Devuelve un array con los valores historicos del indicador
 * y las metas
 */

function getDatosAnuales($indicador, $cm) {

    $meses = array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");

    $data = array();
    $sql_connect = conectar_bd();

    $sql = "SELECT MONTH(fec_fin) AS mes, YEAR(fec_fin) AS ano, tabla FROM master_cuadro_mando WHERE activo = 1 AND MONTH(fec_fin) = 12 AND fec_fin <= '" . $cm['fec_fin'] . "' ORDER BY ano, mes ASC;";
    $consulta = db_query($sql, $sql_connect);
    writeLog($sql);
    if (!$consulta) {
        lanzar_error("La consulta a la base de datos ha fallado.", true);
    } else {
        while ($fila = $consulta->fetch_array()) {
            $cuadros[] = $fila;
        }
        $consulta->free_result();
        $sql = "";
        foreach ($cuadros as $key => $cua) {
            $sql .= $key === 0 ? "" : " UNION ";
            $sql .= "SELECT '" . $cua["mes"] . "' AS mes, '" . $cua["ano"] . "' AS ano, valor FROM " . $cua["tabla"] . " WHERE id_indicador = " . $indicador['id'] . " AND activo = 1 ";
        }

        $consulta = db_query($sql, $sql_connect);
        writeLog($sql);
        if (!$consulta) {
            lanzar_error("La consulta a la base de datos ha fallado.", true);
        } else {
            while ($fila = $consulta->fetch_array()) {
                $row[0] = $fila['mes'] == 12 ? $fila['ano'] : $meses[$fila['mes'] - 1] . "-" . $fila['ano'];
                $row[1] = $fila['valor'];

                //array_push($data, $row);
                $data[$fila['ano']] = $row;
            }
            $consulta->free_result();
        }
        $sql = "SELECT g.nombre, MONTH(fecha_grupo_metas) AS mes, YEAR(fecha_grupo_metas) AS ano, v.valor FROM master_meta_valores v JOIN master_meta_grupo g ON v.id_grupo_meta = g.id WHERE id_indicador = " . $indicador['id'] . " AND v.activo = 1 AND MONTH(g.fecha_grupo_metas) = 12 ORDER BY g.fecha_grupo_metas ASC;";
        $consulta = db_query($sql, $sql_connect);
        writeLog($sql);
        if (!$consulta) {
            lanzar_error("La consulta a la base de datos ha fallado.", true);
        } else {
            while ($fila = $consulta->fetch_array()) {
                if (!is_null($fila["valor"]) && strval($fila["valor"]) != "") {
//                    $row[0] = $fila['mes'] == 12 ? $fila['ano'] . " META" : $meses[$fila['mes'] - 1] . "-" . $fila['ano'] . " META";
//                    $row[1] = "";
//                    $row[2] = $fila['valor'];
//
//                    array_push($data, $row);
                    if (isset($data[$fila['ano']])) {
                        $data[$fila['ano']][] = $fila['valor'];
                    } else {
                        $row[0] = $fila['mes'] == 12 ? $fila['ano'] : $meses[$fila['mes'] - 1] . "-" . $fila['ano'];
                        $row[1] = "";
                        $row[2] = $fila['valor'];

                        //array_push($data, $row);
                        $data[$fila['ano']] = $row;
                    }
                }
            }
            $consulta->free_result();
        }
    }
    desconectar_bd($sql_connect);

    $data = array_values($data);
    return $data;
}

/*
 * Funcion que devuelve los valores historicos para la grafica anual
 * de un indicador en cuadros de mando anteriores que ya esten 
 * cerrados o presentados
 * 
 * @param array $indicador El indicador del que buscaremos sus datos historicos
 * @param array $cm Informacion del cm para el que buscamos los datos historicos
 * 
 * @return array Devuelve un array con los valores historicos del indicador
 * y las metas
 */

function getDatosMensuales($indicador, $cm) {

    $meses = array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");

    $data = array();
    $cuadros = array();
    $sql_connect = conectar_bd();
    
    //saca los cuadros de mando de este año    
    $sql = "SELECT MONTH(fec_fin) AS mes, YEAR(fec_fin) AS ano, tabla, grupo_metas FROM master_cuadro_mando WHERE activo = 1 AND YEAR(fec_fin) = " . date('Y', strtotime($cm['fec_fin'])) . " ORDER BY ano, mes ASC;";
    $consulta = db_query($sql, $sql_connect);
    writeLog($sql);
    if (!$consulta) {
        lanzar_error("La consulta a la base de datos ha fallado.", true);
    } else {
        while ($fila = $consulta->fetch_array()) {
            $cuadros_g2[] = $fila;
        }
        $consulta->free_result();
        $sql = "";        
        
        //jlgr jgramiro M 17/05/2022: Para saber si existe los cuadros de mando de mes 6 y 9. Si no existen se sacaran las metas posteriormente.
        $bCuadroMandoMes6Existe = false;
        $bCuadroMandoMes9Existe = false;
        //jlgr jgramiro M 13/06/2022: Para saber si existe los cuadros de mando de mes 12. Si no existen se sacaran las metas posteriormente.
        $bCuadroMandoMes12Existe = false;
        
        foreach ($cuadros_g2 as $key => $cua) {
            
            //jlgr jgramiro M 17/05/2022: Para saber si existe los cuadros de mando de mes 6 y 9. Si no existen se sacaran las metas posteriormente.
            if ($cua["mes"] == 6) 
            {
                $bCuadroMandoMes6Existe = true;
            }                
            if ($cua["mes"] == 9)
            {
                $bCuadroMandoMes9Existe = true;
            }
            //jlgr jgramiro M 13/06/2022: Para saber si existe los cuadros de mando de mes 12. Si no existen se sacaran las metas posteriormente.
            if ($cua["mes"] == 12)
            {
                $bCuadroMandoMes12Existe = true;
            }
            
            $sql .= $key === 0 ? "" : " UNION ";
            /*jlgr jgramiro V 01/07/2022: Hay que cambiar el i.activo por cm.activo, con esto se consigue que indicadores que han sido desactivados se muestren*/
            $sql .= "(SELECT '" . $cua["mes"] . "' AS mes, '" . $cua["ano"] . "' AS ano, cm.valor, i.unidad, mv.valor as 'meta' FROM master_indicadores i LEFT JOIN " . $cua["tabla"] . " cm ON cm.id_indicador=i.id LEFT JOIN master_meta_valores mv ON mv.id_grupo_meta = " . $cua["grupo_metas"] . " AND mv.id_indicador = " . $indicador['id'] . " AND mv.activo = 1 WHERE i.id = " . $indicador['id'] . " AND cm.activo = 1)";
        }
        $consulta = db_query($sql, $sql_connect);
        writeLog($sql);
        if (!$consulta) {
            lanzar_error("La consulta a la base de datos ha fallado8.", true);
        } else {
            // jlgr jgramiro V 01/07/2022: Se crean variables para guardar los valores anteriores por ver si son los mismos para DIC y CIERRE que no se incorporen al array $data, porque el UNION de la SELECT no funciona con valores con decimales.
                $mes_ant = 0;
                $ano_ant = 0;
                $valor_ant = 0;
                $unidad_ant = 0;
                $meta_ant = 0;
            while ($fila = $consulta->fetch_array()) {
                $row[0] = $meses[$fila['mes'] - 1] . "-" . $fila['ano'];
                $row[1] = $fila["valor"];
                $row[2] = $fila['meta'];
                
                // jlgr jgramiro V 01/07/2022: Se crean variables para guardar los valores anteriores por ver si son los mismos para DIC y CIERRE que no se incorporen al array $data, porque el UNION de la SELECT no funciona con valores con decimales.
                // jlgr jgramiro L 04/07/2022: Tras conversación con Ángela, en el gráfico mensual no tiene que salir el acumulado, sólo los trimestrales. El anual de cierre ya sale en el gráfico de anuales a la izquierda.
                if  ($mes_ant !=  $fila['mes'] - 1 || $ano_ant != $fila['ano'])// || $valor_ant != $fila["valor"] || $unidad_ant != $fila["unidad"] || $meta_ant != $fila['meta'])
                {    
                    array_push($data, $row);

                    // jlgr jgramiro V 01/07/2022: Se crean variables para guardar los valores anteriores por ver si son los mismos para DIC y CIERRE que no se incorporen al array $data, porque el UNION de la SELECT no funciona con valores con decimales.
                    $mes_ant = $fila['mes'] - 1;
                    $ano_ant = $fila['ano'];
                    $valor_ant = $fila["valor"];
                    $unidad_ant = $fila["unidad"];
                    $meta_ant = $fila['meta'];
                }
            }
        }
        
        // Codigo para mostrar la meta de CIERRE de AÑO en la grafica mensual
        //jlgr jgramiro M 17/05/2022: Se incluye AND g.activo = 1 porque si hay grupos inactivos se repite en la gráfica los valores si es que existian en ese grupo (cuadro de mando) y luego se dio de baja
        //jlgr jgramiro M 17/05/2022: Si no existen los cuadros de mando de mes 6 y 9 y 12 se sacan las metas.// X 18/05/2022: Tambien estaba puesto el año en curso y se cambia a la fecha del cuadro de mando (Se pone date('Y', strtotime($cm['fec_fin'])) en vez de date('Y') 
        //jlgr jgramiro M 13/06/2022: se cambia el 12 a pelo por un 0 que nunca existirá pero SI los OR de los meses de abajo, y así tengo un AND y los OR que se necesitan.
        $sql = "SELECT g.nombre, MONTH(g.fecha_grupo_metas) AS 'mes', YEAR(g.fecha_grupo_metas) AS 'ano', v.valor as 'meta' FROM master_meta_valores v JOIN master_meta_grupo g ON v.id_grupo_meta = g.id WHERE id_indicador = " . $indicador['id'] . " AND v.activo = 1 AND g.activo = 1 AND YEAR(g.fecha_grupo_metas) = " . date('Y', strtotime($cm['fec_fin'])). " AND (MONTH(g.fecha_grupo_metas) = 0 ";
        $sql .= $bCuadroMandoMes6Existe == true ? "" : " OR MONTH(g.fecha_grupo_metas) = 6 ";
        $sql .= $bCuadroMandoMes9Existe == true ? "" : " OR MONTH(g.fecha_grupo_metas) = 9 ";
        //jlgr jgramiro M 13/06/2022: se quita el 12 a pelo
        $sql .= $bCuadroMandoMes12Existe == true ? "" : " OR MONTH(g.fecha_grupo_metas) = 12 ";
        $sql .= ") ORDER BY g.fecha_grupo_metas ASC;";
        $consulta = db_query($sql, $sql_connect);
        writeLog($sql);
        if (!$consulta) {
            lanzar_error("La consulta a la base de datos ha fallado.", true);
        } else {
            while ($fila = $consulta->fetch_array()) {
                $row[0] = $meses[$fila['mes'] - 1] . "-" . $fila['ano'];
                $row[1] = $fila["valor"];
                $row[2] = $fila['meta'];

                array_push($data, $row);
            }
            $consulta->free_result();
        }
//    $sql = "SELECT MONTH(fec_fin) AS mes, YEAR(fec_fin) AS ano, tabla FROM master_cuadro_mando WHERE activo = 1 AND YEAR(fec_fin) = " . date('Y', strtotime($cm['fec_fin'])) . " AND fec_fin <= '" . $cm['fec_fin'] . "' ORDER BY ano, mes ASC;";
//    $consulta = db_query($sql, $sql_connect);
//    writeLog($sql);
//    if (!$consulta) {
//        lanzar_error("La consulta a la base de datos ha fallado.", true);
//    } else {
//        while ($fila = $consulta->fetch_array()) {
//            $cuadros[] = $fila;
//        }
//        $consulta->free_result();
//        $sql = "";
//        foreach ($cuadros as $key => $cua) {
//            $sql .= $key === 0 ? "" : " UNION ";
//            $sql .= "SELECT '" . $cua["mes"] . "' AS mes, '" . $cua["ano"] . "' AS ano, valor FROM " . $cua["tabla"] . " WHERE id_indicador = " . $indicador['id'] . " AND activo = 1";
//        }
//
//        $consulta = db_query($sql, $sql_connect);
//        writeLog($sql);
//        if (!$consulta) {
//            lanzar_error("La consulta a la base de datos ha fallado.", true);
//        } else {
//            while ($fila = $consulta->fetch_array()) {
//                //if (!is_null($fila["valor"]) && strval($fila["valor"]) != "") {
//                    $row[0] = $meses[$fila['mes'] - 1] . "-" . $fila['ano'];
//                    $row[1] = $fila['valor'];
//
//                    //array_push($data, $row);
//                    $data[$fila['mes']] = $row;
//                //}
//            }
//            $consulta->free_result();
//        }
//        $sql = "SELECT g.nombre, MONTH(g.fecha_grupo_metas) AS 'mes', YEAR(g.fecha_grupo_metas) AS 'ano', v.valor FROM master_meta_valores v JOIN master_meta_grupo g ON v.id_grupo_meta = g.id WHERE id_indicador = " . $indicador['id'] . " AND v.activo = 1 AND YEAR(g.fecha_grupo_metas) = " . date('Y', strtotime($cm['fec_fin'])) . " AND MONTH(g.fecha_grupo_metas) <= " . date('n', strtotime($cm['fec_fin'])) . " ORDER BY g.fecha_grupo_metas ASC;";
//        $consulta = db_query($sql, $sql_connect);
//        writeLog($sql);
//        if (!$consulta) {
//            lanzar_error("La consulta a la base de datos ha fallado.", true);
//        } else {
//            while ($fila = $consulta->fetch_array()) {
//                if (!is_null($fila["valor"]) && strval($fila["valor"]) != "") {
//                    //$row[0] = $fila['nombre']. " META";
//                    //$row[1] = "";
//                    //$row[2] = $fila['valor'];
//                    //array_push($data, $row);    
//                    if (isset($data[$fila['mes']])) {
//                        $data[$fila['mes']][] = $fila['valor'];
//                    } else {
//                        $row[0] = $meses[$fila['mes'] - 1] . "-" . $fila['ano'];
//                        $row[1] = "";
//                        $row[2] = $fila['valor'];
//
//                        //array_push($data, $row);
//                        $data[$fila['mes']] = $row;
//                    }
//                }
//            }
//            $consulta->free_result();
//        }
    }
    desconectar_bd($sql_connect);

    //$data = array_values($data);
    return $data;
}

function getDatosMensualesJP($indicador, $cm) {

    $meses = array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");

    $data = array();
    $cuadros = array();
    $labels = array();
    $reales = array();
    $metas = array();
    $sql_connect = conectar_bd();
    
    $sql = "SELECT MONTH(fec_fin) AS mes, YEAR(fec_fin) AS ano, tabla, grupo_metas FROM master_cuadro_mando WHERE activo = 1 AND YEAR(fec_fin) = " . date('Y', strtotime($cm['fec_fin'])) . " ORDER BY ano, mes ASC;";
    $consulta = db_query($sql, $sql_connect);
    writeLog($sql);
    if (!$consulta) {
        lanzar_error("La consulta a la base de datos ha fallado7.", true);
    } else {
        while ($fila = $consulta->fetch_array()) {
            $cuadros_g2[] = $fila;
        }
        $consulta->free_result();
        $sql = "";
        foreach ($cuadros_g2 as $key => $cua) {
            $sql .= $key === 0 ? "" : " UNION ";
            $sql .= "(SELECT '" . $cua["mes"] . "' AS mes, '" . $cua["ano"] . "' AS ano, cm.valor, i.unidad, mv.valor as 'meta' FROM master_indicadores i LEFT JOIN " . $cua["tabla"] . " cm ON cm.id_indicador=i.id LEFT JOIN master_meta_valores mv ON mv.id_grupo_meta = " . $cua["grupo_metas"] . " AND mv.id_indicador = " . $indicador['id'] . " AND mv.activo = 1 WHERE i.id = " . $indicador['id'] . " AND i.activo = 1)";
        }
        $consulta = db_query($sql, $sql_connect);
        writeLog($sql);
        if (!$consulta) {
            lanzar_error("La consulta a la base de datos ha fallado8.", true);
        } else {
            while ($fila = $consulta->fetch_array()) {
                $row[0] = $meses[$fila['mes'] - 1] . "-" . $fila['ano'];
                $row[1] = is_null($fila["valor"]) ? "-" : $fila["valor"];
                $row[2] = is_null($fila["meta"]) ? "-" : $fila["meta"];

                array_push($labels, $row[0]);
                array_push($reales, $row[1]);
                array_push($metas, $row[2]);
            }
        }
        
        // Codigo para mostrar la meta de 2021 en la grafica mensual
//        $sql = "SELECT g.nombre, MONTH(g.fecha_grupo_metas) AS 'mes', YEAR(g.fecha_grupo_metas) AS 'ano', v.valor as 'meta' FROM master_meta_valores v JOIN master_meta_grupo g ON v.id_grupo_meta = g.id WHERE id_indicador = " . $indicador['id'] . " AND v.activo = 1 AND YEAR(g.fecha_grupo_metas) = " . date('Y') . " AND MONTH(g.fecha_grupo_metas) = 12 ORDER BY g.fecha_grupo_metas ASC;";
//        $consulta = db_query($sql, $sql_connect);
//        writeLog($sql);
//        if (!$consulta) {
//            lanzar_error("La consulta a la base de datos ha fallado.", true);
//        } else {
//            while ($fila = $consulta->fetch_array()) {
//                $row[0] = $meses[$fila['mes'] - 1] . "-" . $fila['ano'];
//                $row[1] = $fila["valor"];
//                $row[2] = $fila['meta'];
//
//                array_push($data, $row);
//            }
//            $consulta->free_result();
//        }
    }
    desconectar_bd($sql_connect);

    //$data = array_values($data);
    array_push($data, $labels);
    array_push($data, $reales);
    array_push($data, $metas);
    return $data;
}

/*
 * Funcion que actualiza los perfiles al crear o actualizar un  usuario
 * 
 * @param int $id El identificador del usuario en base de datos
 * @param array $perfiles array de perfiles que se le asignan al usuario
 * 
 * @return 
 */

function actualizar_perfiles_user($id, $perfiles) {
    $sql_connect = conectar_bd();

    $sql = "DELETE FROM user_perfil WHERE user_id = " . $id . ";";
    writeLog($sql);
    $accion = db_query($sql, $sql_connect);
    if (!$accion) {
        exit("No se han podido actualizar los perfiles del usuario.");
    } else {
        foreach ($perfiles as $perfil) {
            $sql = "INSERT INTO user_perfil VALUES (" . $id . ", " . $perfil . ");";

            writeLog($sql);
            $insert = db_query($sql, $sql_connect);
            if (!$insert) {
                exit("La creación del perfil en base de datos ha fallado.");
            }
        }
    }
    desconectar_bd($sql_connect);
}

function cambiar_color_imagen($filename) {
    $im = imagecreatefrompng($filename);
    $out = imagecreatetruecolor(imagesx($im), imagesy($im));
    $transColor = imagecolorallocatealpha($out, 254, 254, 254, 127);
    imagefill($out, 0, 0, $transColor);

    for ($x = 0; $x < imagesx($im); $x++) {
        for ($y = 0; $y < imagesy($im); $y++) {
            $pixel = imagecolorat($im, $x, $y);

            $red = ($pixel >> 16) & 0xFF;
            $green = ($pixel >> 8) & 0xFF;
            $blue = $pixel & 0xFF;
            $alpha = ($pixel & 0x7F000000) >> 24;

            if ($red == 54 && $green == 108 && $blue == 0) {
                $red = 0;
                $green = 83;
                $blue = 86;
            }

            if ($alpha == 127) {
                imagesetpixel($out, $x, $y, $transColor);
            } else {
                imagesetpixel($out, $x, $y, imagecolorallocatealpha($out, $red, $green, $blue, $alpha));
            }
        }
    }
    imagecolortransparent($out, $transColor);
    imagesavealpha($out, TRUE);
    imagepng($out, $filename);

    $im = imagecreatefrompng($filename);
    $out = imagecreatetruecolor(imagesx($im), imagesy($im));
    $transColor = imagecolorallocatealpha($out, 254, 254, 254, 127);
    imagefill($out, 0, 0, $transColor);
    for ($x = 0; $x < imagesx($im); $x++) {
        for ($y = 0; $y < imagesy($im); $y++) {
            $pixel = imagecolorat($im, $x, $y);

            $red = ($pixel >> 16) & 0xFF;
            $green = ($pixel >> 8) & 0xFF;
            $blue = $pixel & 0xFF;
            $alpha = ($pixel & 0x7F000000) >> 24;

            if ($red == 91 && $green == 183 && $blue == 0) {
                $red = 82;
                $green = 145;
                $blue = 147;
            }

            if ($alpha == 127) {
                imagesetpixel($out, $x, $y, $transColor);
            } else {
                imagesetpixel($out, $x, $y, imagecolorallocatealpha($out, $red, $green, $blue, $alpha));
            }
        }
    }
    imagecolortransparent($out, $transColor);
    imagesavealpha($out, TRUE);
    imagepng($out, $filename);
    //var_dump($out);
    //header('Content-type: image/png');
    //imagepng($out);
}

/*
 * Funcion que devuelve un cm a partir del anio y el mes
 * 
 * @param int $year anio del cm que queremos recuperar
 * @param int $mes Mes del cm que queremos recuperar
 * 
 * @return Array Devuelve el cm que corresponde con el anio y el mes dados,
 *               devuelve null si no existe un cm para el mes y anio indicados
 */

function getCMbyDate($year, $mes) {

    $sql_connect = conectar_bd();
    $cm = null;

    $sql = "SELECT * FROM master_cuadro_mando cm WHERE YEAR(cm.fec_fin) = " . $year . " AND MONTH(cm.fec_fin) = " . $mes . " ORDER BY au_fec_alta DESC LIMIT 1;";
    //echo $sql;
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("Error al recuperar el cuadro de mando de base de datos.");
    } else {
        $cm = $consulta->fetch_array();
        $consulta->free_result();
    }

    desconectar_bd($sql_connect);
    return $cm;
}

/*
 * Funcion que devuelve quien es el responsable de un indicador
 * 
 * @param string $indicador Identificador del indicador
 * 
 * @return int Devuelve el responsable del indicador
 */

function getResponsableIndicador($indicador) {

    $sql_connect = conectar_bd();
    $responsable = null;

    $sql = "SELECT responsable FROM master_indicadores i WHERE i.id = $indicador;";
    //echo $sql;
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("Error al recuperar el responsable del indicador.");
    } else {
        $responsable = $consulta->fetch_array();
        $consulta->free_result();
    }

    desconectar_bd($sql_connect);

    return $responsable["responsable"];
}

/*
 * Funcion que devuelve registra el acceso de un usuario en la base de datos
 * 
 * @param string $user_id Identificador del usuario que ha accedido al sistema
 * 
 * @return void
 */

function registrar_acceso_db($user_id, $perfil_id) {

    $sql_connect = conectar_bd();

    $sql = "INSERT INTO access_log(user_id, perfil_id, login_date, au_fec_alta, au_usu_alta, au_proc_alta) VALUES (" . $user_id . ", " . $perfil_id . ", SYSDATE(), SYSDATE(), 100000, '" . php_actual() . "');";

    writeLog($sql);
    $insert = db_query($sql, $sql_connect);
    if (!$insert) {
        exit("No se ha podido guardar el acceso del usuario en base de datos.");
    }

    desconectar_bd($sql_connect);
}

/*
 * Funcion que envia un aviso a los responsables y supervisores cuando se
 * crea un nuevo CMO
 * 
 * @return void
 */

function enviar_aviso_nuevoCM($cm) {

    $sql_connect = conectar_bd();
    $correos = array();
    $correos_string = "";
    $sql = "SELECT email FROM users WHERE id_perfil = 10 OR id_perfil = 15 AND activo = 1;";
    //$sql = "SELECT CONCAT(u.nombre, ' ', u.apellidos) AS 'nombre', u.email FROM users u WHERE u.id_perfil = 10 OR u.id_perfil = 15 AND activo = 1;";
    writeLog($sql);

    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se han podido recuperar los correos de los usuarios para enviarles el aviso.");
    } else {
        while ($fila = $consulta->fetch_array()) {
            $correos[] = $fila;
        }
    }
    foreach ($correos as $value) {
        if (!is_null($value["email"])) {
            $correos_string .= $value["email"] . ";";
        }
    }
    $correos_string = substr($correos_string, 0, -1);

    //enviamos el mail
    $asunto = "CUADRO DE MANDO OPERACIONAL DE ADIF - aviso de creacion de un nuevo CMO";
    $cuerpo = "<html style='background-color: #fff; color: #000;font-family:arial,verdana,calibri;font-size:12px;'><body>";
    $cuerpo .= "<p>Estimado " . $responsable["nombre"] . " " . $responsable["apellidos"] . ":</p>";
    $cuerpo .= "<p>Nos ponemos en contacto con usted para informarle de que ha sido generado un nuevo Cuadro de Mando Operacional.</p>";
    //$cuerpo.= "<p>El nuevo Cuadro de Mando Operacional corresponde al periodo 6 de 2021, y su fecha de finalización es ".fecha_cristiana($cm["fec_fin"]).".</p>";
    $cuerpo .= "<p>Los datos del nuevo Cuadro de Mando Operacional son: </p><ul> ";
    $cuerpo .= "<li>Nombre: " . $cm["nombre"] . "</li>";
    $cuerpo .= "<li>Inicio del periodo: " . fecha_cristiana($cm["fec_ini"]) . "</li>";
    $cuerpo .= "<li>Fihn del periodo: " . fecha_cristiana($cm["fec_fin"]) . "</li></ul>";
    $cuerpo .= "<p>La fecha de finalización, antes de la que deben estar completos todos los indicadores es: " . fecha_cristiana($cm["fec_limite"]) . ".</p>";
    $cuerpo .= "<p>Esto es un mail generado automáticamente por eso le informamos de que no debe responder a esta dirección.</p>";
    $cuerpo .= "<p>correo para: $correos_string</p>";
    $cuerpo .= "</body></html>";
    $mail = "ggonzalez@senasa.es";
    writeLog("Enviando el mail...");
    $envio = enviar_mail(MAIL_ADMIN_FROM, $mail, $asunto, $cuerpo);
    if ($envio === true) {
        writeLog("MAIL ENVIADO CON ÉXITO");
    } else {
        writeLog("EEROR AL ENVIAR EL MAIL");
    }

    desconectar_bd($sql_connect);
}

/*
 * Funcion que envia un aviso a los responsables cuando se crea un nuevo
 * grupo de metas
 * 
 * @param int Id del nuevo grupo de metas
 * 
 * @return void
 */

function enviar_aviso_nuevasMetas($id_gm) {

    $sql_connect = conectar_bd();
    $correos = array();
    $grupo_metas = array();

    $sql = "SELECT * from master_meta_grupo WHERE id = " . $id_gm . " AND activo = 1;";
    writeLog($sql);

    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se han podido recuperar los datos del grupo de metas.");
    } else {
        $grupo_metas = $consulta->fetch_array();
    }
    $consulta->free_result();

    $sql = "(SELECT DISTINCT i.responsable AS id, CONCAT(u.nombre, ' ', u.apellidos) AS 'nombre', u.email FROM master_indicadores i JOIN users u ON i.responsable = u.id WHERE i.activo = 1) UNION (SELECT distinct i.supervisor, CONCAT(u.nombre, ' ', u.apellidos) AS 'nombre', u.email FROM master_indicadores i JOIN users u ON i.supervisor = u.id WHERE i.activo = 1);";
    writeLog($sql);

    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se han podido recuperar los correos de los usuarios para enviarles el aviso.");
    } else {
        while ($fila = $consulta->fetch_array()) {
            $usuarios[] = $fila;
        }
    }
    foreach ($usuarios as $usu) {
        if (!is_null($usu["email"])) {
            if(!in_array($usu["email"], $correos)){
                //enviamos el mail
                $asunto = "CUADRO DE MANDO OPERACIONAL DE ADIF - aviso de creacion de un nuevo grupo de metas";
                $cuerpo = "<html style='background-color: #fff; color: #000;font-family:arial,verdana,calibri;font-size:12px;'><body>";
                $cuerpo .= "<p>Estimado " . $usu["nombre"].":</p>";
                $cuerpo .= "<p>Nos ponemos en contacto con usted para informarle de que ha sido generado un nuevo grupo de metas.</p>";
                $cuerpo .= "<p>Los datos del nuevo grupo de metas son: </p><ul> ";
                $cuerpo .= "<li>Nombre: " . $grupo_metas["nombre"] . "</li>";
                $cuerpo .= "<li>Fecha del grupo de metas: " . fecha_cristiana($grupo_metas["fecha_grupo_metas"]) . "</li></ul>";
                $cuerpo .= "<p>La fecha de finalización, antes de la que deben estar completos los valores de las metas es: " . fecha_cristiana($grupo_metas["fecha_limite_grupo_metas"]) . ".</p>";
                $cuerpo .= "<p>Esto es un mail generado automáticamente por eso le informamos de que no debe responder a esta dirección.</p>";
                $cuerpo .= "<p>correo para: ".$usu["email"]."</p>";
                $cuerpo .= "</body></html>";
                $mail = "franciscom.villar@senasa.es";
                writeLog("Enviando el mail...");
                $envio = enviar_mail(MAIL_ADMIN_FROM, $mail, $asunto, $cuerpo);
                if ($envio === true) {
                    writeLog("MAIL ENVIADO CON ÉXITO");
                    //Guardamos la información del mail en la BBDD:
                    $sql = "INSERT INTO mails (user_from, user_to, `to`, asunto, cuerpo, au_fec_alta, au_usu_alta, au_proc_alta) VALUES (";
                    $sql.= "200000, ".$usu["id"].", '".$usu["email"]."', '".mysqli_real_escape_string($sql_connect, $asunto)."', '".mysqli_real_escape_string($sql_connect, $cuerpo)."', SYSDATE(), 200000, '".php_actual()."');";
                    writeLog($sql);
                    $accion = db_query($sql, $sql_connect);
                    if (!$accion) {
                        exit("Se ha producido un error al guardar el mail en BBDD");
                    }
                } else {
                    writeLog("EEROR AL ENVIAR EL MAIL");
                }
            }
            array_push($correos, $usu["email"]);
        }
    }

    desconectar_bd($sql_connect);
}

/*
 * Funcion que comprueba si un usuario es responsable o suplente 
 * de un indicador
 * 
 * @param array $indicador El indicador que queremos comprobar
 * @param array $usuario El usuario que queremos comprobar
 * 
 * @return boolean Devuelve true si el usuario es responsable o suplente
 */

function checkEdit($indicador, $usuario) {

    if (($usuario["id"] == $indicador["responsable"]) || ($usuario["id"] == $indicador["suplente"])) {
        return true;
    } else {
        return false;
    }
}

/*
 * Funcion que guarda la informacion de un documento adjunto en BBDD 
 * 
 * @param string $fileName Nombre del archivo
 * @param string $fileExtension Extension del archivo
 * @param int $id_cm ID del cm al que pertenece el archivo
 * @param int $id_indicador ID del indicador al que pertenece el archivo
 * @param int $id_user ID del usuario que ha subido el documento
 * @param string $dest_path Ruta en la que se ha guardado el documento
 * @param int $just_meta Indica si el documento es un justificante de 
 *                       incumplimiento de meta
 * 
 * @return boolean Devuelve true si el usuario es responsable o suplente
 */

function saveDocBBDD($fileName, $fileExtension, $id_cm, $id_indicador, $id_user, $dest_path, $just_meta = 0) {

    $sql_connect = conectar_bd();

    $sql = "INSERT INTO doc_adjuntos(filename, ext, id_cm, id_indicador, id_user, path, just_meta, au_fec_alta, au_usu_alta, au_proc_alta) VALUES ('" . $fileName . "', '" . $fileExtension . "', " . $id_cm . ", " . $id_indicador . ", " . $id_user . ", '" . $dest_path ."', " . $just_meta . ", SYSDATE()," . $id_user . ", '" . php_actual() . "');";
    //var_dump($sql);
    //die();
    writeLog($sql);
    $insert = db_query($sql, $sql_connect);
    if (!$insert) {
        exit("No se ha podido guardar el documento en base de datos.");
    }

    desconectar_bd($sql_connect);
}

/*
 * Funcion que guarda la informacion de un documento adjunto en BBDD 
 * 
 * @param string $fileName Nombre del archivo
 * @param string $fileExtension Extension del archivo
 * @param int $id_cm ID del cm al que pertenece el archivo
 * @param int $id_indicador ID del indicador al que pertenece el archivo
 * @param int $id_user ID del usuario que ha subido el documento
 * @param string $dest_path Ruta en la que se ha guardado el documento
 * @param int $just_meta Indica si el documento es un justificante de 
 *                       incumplimiento de meta
 * 
 * @return boolean Devuelve true si el usuario es responsable o suplente
 */

function saveDocDpoBBDD($fileName, $fileExtension, $id_grupo_dpo, $id_indicador, $id_user, $dest_path) {

    $sql_connect = conectar_bd();

    $sql = "INSERT INTO doc_adjuntos_dpo(filename, ext, id_grupo_dpo, id_indicador, id_user, path, au_fec_alta, au_usu_alta, au_proc_alta) VALUES ('" . $fileName . "', '" . $fileExtension . "', " . $id_grupo_dpo . ", " . $id_indicador . ", " . $id_user . ", '" . $dest_path ."', SYSDATE()," . $id_user . ", '" . php_actual() . "');";
    //var_dump($sql);
    //die();
    writeLog($sql);
    $insert = db_query($sql, $sql_connect);
    if (!$insert) {
        exit("No se ha podido guardar el documento en base de datos.");
    }

    desconectar_bd($sql_connect);
}

/*
 * Funcion que comprueba si un indicador es acumulado
 * 
 * @param $id_indicador ID del indicador a comprobar
 * 
 * @return boolean Devuelve true si el indicador es acumulado
 */

function acumulado($id_indicador) {
    $sql_connect = conectar_bd();
    $acumulado = false;

    $sql = "SELECT acumulado from master_indicadores i WHERE id = " . $id_indicador . " AND activo = 1;";
    writeLog($sql);

    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se han podido recuperar la informacion para saber si el indicador es acumulado.");
    } else {
        $acumulado = $consulta->fetch_array();
    }
    $consulta->free_result();
    
    return $acumulado[0];
}

function generarPDFMeta($id_indicador, $id_cm, $cm, $valor, $observaciones){
    $dir_raiz = "../";
    require_once("informe_meta_PDF.php");
    
    $sql_connect = conectar_bd();

    $sql = "SELECT CONCAT(dg.denominacion, \" \", dg.nombre) AS nombre_direccion, meta.valor as meta, ";
    $sql.= "i.* FROM master_indicadores i ";
    $sql.= "LEFT JOIN master_org_direcciones_generales dg ON dg.id = i.direccion AND dg.activo = 1 ";
    $sql.= "LEFT JOIN master_meta_valores meta ON meta.id_grupo_meta = ". $cm["grupo_metas"] ." AND meta.id_indicador = i.id ";
    $sql.= "WHERE i.id = " . $id_indicador . " AND i.activo = 1;";
    writeLog($sql);

    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se ha podido recuperar la informacion del indicador.");
    } else {
        $indicador = $consulta->fetch_array();
    }
    $consulta->free_result();
    
    $direccion = $indicador["nombre_direccion"];
    $nombre_cm = $cm["nombre"];
    $nombre_indicador = $indicador["nombre"];
    $meta = $indicador["meta"];


    $pdf = new PDF('L','mm','A4');
    $pdf->SetLeftMargin(30);
    $pdf->SetRightMargin(30);
    $pdf->SetTopMargin(30);
    $pdf->setDg_footer($direccion);

    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,utf8_decode('JUSTIFICACIÓN DEL INCUMPLIMIENTO META'),0,1,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,10,utf8_decode('INDICADOR: '.$nombre_indicador),0,1,'L');
    $pdf->Cell(0,10,utf8_decode('PERIODO: '.$nombre_cm),0,1,'L');
    $pdf->Cell($pdf->GetStringWidth("VALOR: ". $valor) + 10,10,utf8_decode('VALOR: '. $valor),0,0,'L');
    $pdf->Cell(0,10,utf8_decode('META: '. $meta),0,1,'L');
    $pdf->Cell(0,10,utf8_decode('OBSERVACIONES:'),0,1,'L');

    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(0, 6, utf8_decode($observaciones));
    //$pdf->WriteHTML($observaciones);
    
    /***************************************************************************
    *                           FINAL DEL DOCUMENTO                            *
    ***************************************************************************/
    
    // Eliminamos los posibles informes que ya tuviera el indicador
    $sql = "SELECT * FROM doc_adjuntos doc WHERE id_cm = ".$id_cm." AND id_indicador = ". $id_indicador ." AND just_meta = 1 AND deleted = 0 AND activo = 1;";
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se ha podido recuperar los documentos adjuntos previos del indicador " . $id_indicador);
    } else {
        while ($fila = $consulta->fetch_array()) {
            $sql = "UPDATE doc_adjuntos SET deleted = 1, activo = 0, au_fec_modif = SYSDATE(), au_usu_modif = " . $_SESSION["user"]["id"] . ", au_proc_modif = '" . php_actual() . "', au_lock = au_lock + 1 WHERE id = " . $fila['id'] . ";";
            writeLog($sql);
            $modif = db_query($sql, $sql_connect);
            if (!$modif) {
                exit("Se ha producido un error al eliminar el documento". $fila['id']." en base de datos");
            } else {
                $newname = "data/recycle_bin/" . $fila["filename"] . "-" . $id_indicador . "-" . date('Ymdhis');
                //Movemos el documento a la papelera
                if(file_exists($dir_raiz . $fila["path"])){
                    if (rename($dir_raiz . $fila["path"], $dir_raiz . $newname)) {
                        //Actualizamos la ruta del archivo en BBDD
                        $sql = "UPDATE doc_adjuntos SET path = '" . $newname . "', au_fec_modif = SYSDATE(), au_usu_modif = " . $_SESSION["user"]["id"] . ", au_proc_modif = '" . php_actual() . "' WHERE id = " . $fila['id'] . ";";
                        writeLog($sql);
                        $modif = db_query($sql, $sql_connect);
                        if (!$modif) {
                            exit("Se ha producido un error al mover el documento ". $fila['id']." en BBDD");
                        }
                    } else {
                        exit('Hubo un problema al mover el archivo a la papelera');
                    }
                }
            }
            
        }
        
    }
       
    //Calculamos la ruta donde se va a guardar el documento
    $uploadFileDir = "../data/cmo/" . $id_cm . "/" . $id_indicador . "/";

    if(!file_exists($uploadFileDir)){
        if(!mkdir($uploadFileDir, 0777, true)){
            lanzar_error('No se ha podido crear la ubicacion del fichero', true);
        }
    }
    $filename = "Justificante incumplimiento meta.pdf"; 
    
    $dest_path = $uploadFileDir . $filename;
    
    $pdf->Output('F', $dest_path);
    
    // Insertar en base de datos el registro del documento subido
    saveDocBBDD($filename, "pdf", $id_cm, $id_indicador, $_SESSION["user"]["id"], trim($dest_path, "../"), 1);
    
}

function isAdmin($id_user){
    
    $sql_connect = conectar_bd();
    $perfiles = array();

    $sql = "SELECT perfil_id from user_perfil up WHERE up.user_id = " . $id_user . ";";
    writeLog($sql);

    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit("No se han podido recuperar los perfiles del usuario para comprobar si es administrador.");
    } else {
        while ($fila = $consulta->fetch_array()) {
            $perfiles[] = $fila["perfil_id"];
        }
    }
    $consulta->free_result();
    
    return in_array(_USER_ADMIN, $perfiles);
    
}

function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}

?>
