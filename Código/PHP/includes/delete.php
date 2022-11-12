<?php

session_start();
$dir_raiz = "../";
require_once($dir_raiz . "includes/config.php");
require_once($dir_raiz . "includes/funciones.php");


$message = '';
if (isset($_POST['id_doc']) && !is_null($_POST['id_doc'])) {

    $id_doc = $_POST["id_doc"];

    // Buscar documento en bbdd
    $sql_connect = conectar_bd();

    $sql = "SELECT * FROM doc_adjuntos da WHERE da.id=" . $id_doc . " AND da.deleted = 0 AND da.activo = 1;";
    //var_dump($sql);
    //die();
    writeLog($sql);
    $consulta = db_query($sql, $sql_connect);
    if (!$consulta) {
        exit('No se ha podido encontrar el documento en la base de datos');
    } else {
        $doc = $consulta->fetch_array();
    }

    if (isset($doc) && !is_null($doc)) {
        if ($doc["id_user"] == $_SESSION["user"]["id"] || isAdmin($_SESSION["user"]["id"])) {

            //Eliminamos el documento de BBDD
            $sql = "UPDATE doc_adjuntos SET deleted = 1, activo = 0, au_fec_modif = SYSDATE(), au_usu_modif = " . $_SESSION["user"]["id"] . ", au_proc_modif = '" . php_actual() . "', au_lock = au_lock + 1 WHERE id = " . $id_doc . " AND activo = 1;";
            writeLog($sql);
            $modif = db_query($sql, $sql_connect);
            if (!$modif) {
                exit("Se ha producido un error al eliminar el documento en base de datos");
            } else {
                $newname = "data/recycle_bin/" . $doc["filename"] . "-" . date('Ymdhis');
                //Movemos el documento a la papelera
                if (rename($dir_raiz . $doc["path"], $dir_raiz . $newname)) {
                    //Actualizamos la ruta del archivo en BBDD
                    $sql = "UPDATE doc_adjuntos SET path = '" . $newname . "', au_fec_modif = SYSDATE(), au_usu_modif = " . $_SESSION["user"]["id"] . ", au_proc_modif = '" . php_actual() . "' WHERE id = " . $id_doc . ";";
                    writeLog($sql);
                    $modif = db_query($sql, $sql_connect);
                    if (!$modif) {
                        exit("Se ha producido un error al mover el documento en BBDD");
                    } else {
                        $message = 'Su archivo se ha eliminado correctamente';
                    }
                } else {
                    $message = 'Hubo un problema al mover el archivo a la papelera';
                }
            }
        } else {
            $message = 'Su usuario no tiene permisos para eliminar este documento';
        }
    } else {
        $message = 'No existe ningún documento con ese ID';
    }
    desconectar_bd($sql_connect);
} else {
    $message = 'No se ha indicado ningún ID de documento';
}
$_SESSION['message'] = $message;
$_SESSION['post_data'] = $_POST;
header("Location: " . $dir_raiz . "indicadores/indicador.php");
