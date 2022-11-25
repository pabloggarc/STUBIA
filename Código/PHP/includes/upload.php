<?php
session_start();
$dir_raiz		= "../";
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");


$phpFileUploadErrors = array(
    0 => 'Archivo subido correctamente',
    1 => 'El fichero subido excede la directiva upload_max_filesize de php.ini.',
    2 => 'El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTML',
    3 => 'El fichero fue sólo parcialmente subido',
    4 => 'No se subió ningún fichero',
    6 => 'Falta la carpeta temporal',
    7 => 'No se pudo escribir el fichero en el disco',
    8 => 'Una extensión de PHP detuvo la subida de ficheros',
);

$message = ''; 
if (isset($_POST['btn_upload']) && $_POST['btn_upload'] == 'Adjuntar'){
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK){
    // Guardamos los datos del archivo subido
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    

    // Listado de extensiones permitidas
    $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'pdf', 'txt', 'xlsx', 'docx');

    if (in_array($fileExtension, $allowedfileExtensions)){
        // Guardamos los datos del indicador y del cm
        $id	= isset($_POST["id"]) ? intval($_POST["id"]) : -1;
        $id_cm = isset($_POST["id_cm"]) ? intval($_POST["id_cm"]) : -1;
    
        // Calculamos la ruta en la que se guardara el archivo
        if($id < 1 || $id_cm < 1){
            $message = 'Error en la subida. No se ha podido calcular la ubicacion del fichero';
        }else{
            $uploadFileDir = $dir_raiz . 'data/cmo/' . $id_cm . '/' . $id . '/';
            // Comprobamos si el directorio ya existe, si no lo creamos
            if(!file_exists($uploadFileDir)){
                if(!mkdir($uploadFileDir, 0777, true)){
                    $message ='Error en la subida. No se ha podido crear la ubicacion del fichero';
                }
            }
                       
            $dest_path = $uploadFileDir . $fileName;
            if(move_uploaded_file($fileTmpPath, $dest_path)){
                $message ='Archivo subido correctamente';
                
                // Insertar en base de datos el registro del documento subido
                saveDocBBDD($fileName, $fileExtension, $id_cm, $id, $_SESSION["user"]["id"], trim($dest_path, $dir_raiz));
            }else{
                $message = 'Se produjo un error moviendo el archivo al directorio.';
            }
        }
    }
    else{
      $message = 'Error en la subida. Los tipos de archivo soportados son: ' . implode(',', $allowedfileExtensions);
    }
  }
  else{
    $message = 'Se produjo un error en la subida.Por favor, compruebe el siguiente error:<br>';
    $message .= 'Error:' . $phpFileUploadErrors[$_FILES['uploadedFile']['error']];
  }
}
$_SESSION['message'] = $message;
$_SESSION['post_data'] = $_POST;
header("Location: " .$dir_raiz . "indicadores/indicador.php");