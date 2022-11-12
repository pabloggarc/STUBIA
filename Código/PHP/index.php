<?php

$dir_raiz = "";

require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");
require_once($dir_raiz."includes/encabezado.php");
?>

<style type="text/css">
    
table#secciones {
	width: 100%;
	border-spacing: 15px;
}
table#secciones td {
	border:			solid 1px;
	font-size:		2.5em;
	height:			25vh;
	vertical-align:         top;
	padding:		15px;
}
table#secciones td.navegable {
	background-color:	#fff;
	cursor:			pointer;
}
table#secciones td.navegable:hover {
	font-weight: bold;
}
table tr td img{
    display: block;
    margin-top: 50px;
}

div.navegable {
	background-color:	#fff;
	cursor:			pointer;
        border-radius:          50%;
}
div.navegable:hover {
	font-weight: bold;
}

</style>

<script>
my_ready = function() {
	var urls	= new Array("cm/listado.php", "prime/index.php", "datalake/listado.php" ,"convenio/index.php", "dpo/index.php");
	var navs	= document.getElementsByClassName("navegable");
	for (var n = 0; n < navs.length; n++) {
		navs[n].url = urls[n];
		navs[n].onclick = function() {
			goPage(this.url);
		}
	}
}
</script>
<?php
require_once($dir_raiz."includes/cabecera.php");

if (isset($_GET['aviso'])=="yes") {    
    echo ("<script> window.alert('DATO \\u00DANICO \\n\\nLes anunciamos que se ha incorporado a la aplicaci\\u00F3n la funcionalidad de DATO \\u00DANICO, "
        . "lo que significa que, para cada a\\u00F1o, determinados indicadores est\\u00E1n relacionados independientemente de la encuesta a la que pertenezcan, compartiendo el mismo valor.\\n\\n"
        . "Al cambiar el valor de un indicador relacionado ese valor se actualizar\\u00E1 autom\\u00E1ticamente EN TIEMPO REAL en todos sus indicadores relacionados. Solo ser\\u00E1 necesario introducir un valor compartido una vez. \\n\\n"
        . "En caso de que usted, como responsable del dato o suplente, se disponga a cambiar el valor de un indicador que tenga indicadores relacionados, podr\\u00E1 ver claramente en pantalla los indicadores relacionados.');</script>");

}
?>
<table id="secciones">
	<tr>
            <td class="navegable" width="50%">
                <div >
                    <span>Cuadro de Mando Operacional</span>
                    <img src="img/rail.svg" />
                </div>
            </td>

            <td class="navegable" width="50%">
                <div>
                    <span>PRIME</span>
                </div>
            </td>
	</tr>
        <tr>
            <td colspan="2" style="background-color:#FFFFFF00; color:white; border:0px">
                <div class="navegable" style="width:50%; height:25vh; margin:auto; background-color: #366c00;display: grid; place-items: center;">
                    <span>DATA LAKE</span>
                </div>
            </td>
            
        </tr>
        <tr>
            <td class="navegable" width="50%">
                <div>
                    <span>Informe de seguimiento de indicadores del CONVENIO MITMA - ADIF/ADIF AV</span>
                </div>
            </td>
            <td class="navegable" width="50%">
                DPO
            </td>
        </tr>
        
</table>
<?php
require_once($dir_raiz."includes/pie.php");
?>
