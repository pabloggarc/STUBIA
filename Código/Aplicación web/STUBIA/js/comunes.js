const _APP_NAME					= "STUBIA";
const _URL_RAIZ					= "http://localhost/proyectos/stubia";
const _MONTH_NAMES				= new Array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
const _MONTH_DAYS				= new Array(0, 31, 28, 31, 30, 31, 30, 31, 31,30, 31, 30, 31);
const _CURRENT_YEAR				= new Date().getFullYear();
const _ES_BISIESTO				= _CURRENT_YEAR % 4 == 0 && (_CURRENT_YEAR % 100 != 0 || _CURRENT_YEAR % 400 == 0);

var my_ready = null, postReady = null, capar_recarga = false;

var accentMap = {
  "Á": "A",
  "É": "E",
  "Í": "I",
  "Ó": "O",
  "Ö": "O",
  "Ú": "U",
  "Ü": "U"
};

var normalize = function( term ) {
	var ret = "";
	for ( var i = 0; i < term.length; i++ ) {
		ret += accentMap[ term.charAt(i) ] || term.charAt(i);
	}
	return ret;
};

window.addEventListener('error', function(e){
	var msg = "ERROR de javascript:\n" + e.message;
	console.log(msg);
	alert(msg);
});

document.addEventListener('DOMContentLoaded', function() {
	if (my_ready !== null) {
		my_ready();
	}
	mostrar_contenido();
	if (postReady !== null) {
		postReady();
	}
	if (capar_recarga === true) {
		document.addEventListener('keydown', function(e) {
			if (e.keyCode === 116 || e.which === 116) {
				e.preventDefault();
			}
		}, false);
	}
}, false);

function mostrar_contenido() {
	if (document.getElementById("cargando")) {document.getElementById("cargando").style.display = "none";}

	if (document.getElementById("capa_errores_producidos") || document.getElementById("capa_avisos_producidos")) {
                if(document.getElementById("capa_errores_producidos")){
                    document.getElementById("capa_errores_producidos").style.display = "block";
                }else{
                    document.getElementById("capa_avisos_producidos").style.display = "block";
                }
	} else {
		if (document.getElementById("contenido_variable")) {document.getElementById("contenido_variable").style.display = "block";}

		/*if (document.getElementById("info_accion")) {
			document.getElementById("info_accion").onclick = function() {eliminar_info();}
			setTimeout(eliminar_info, 10000);
		}
		if (document.getElementById("info_info")) {
			document.getElementById("info_info").onclick = function() {eliminar_info();}
			setTimeout(eliminar_info, 10000);
		}*/
	}
}

function ocultar_contenido() {
	if (document.getElementById("cargando")) {document.getElementById("cargando").style.display = "block";}

	if (document.getElementById("capa_errores_producidos")) {
		document.getElementById("capa_errores_producidos").style.display = "block";
	} else {
		if (document.getElementById("contenido_variable")) {document.getElementById("contenido_variable").style.display = "none";}
	}
}

function lanzar_error(err){
	var contenido = document.getElementById("contenido");
	if (contenido) {
		var capa_err = document.getElementById("capa_errores_producidos");
		if (!capa_err) {
			capa_err	= document.createElement("div");
			capa_err.id	= "capa_errores_producidos";
			var h2		= document.createElement("h2");
			h2.classList.add("error");
			h2.innerHTMl = "ERROR";
			contenido.appendChild(capa_err);
		}
		capa_err.innerHTML += "<p>"+err+"</p>";
	}
}

function toggle_notificaciones() {
	var origen	= document.getElementById("info_notif");
	var capa	= document.getElementById("capa_notif");
	if (capa && origen) {
		if (capa_notif.classList.contains("oculto")) {
			capa_notif.classList.remove("oculto");
			origen.style.backgroundColor = "#000";
		} else {
			capa_notif.classList.add("oculto");
			origen.style.backgroundColor = "#fff";
		}
	}
}
function eliminarNotificacion(elem) {
	if (elem) {
		var capa = elem.parentNode;
		capa.parentNode.removeChild(capa);
		var padre = document.getElementById("capa_notif");
		if (padre) {
			var total	= padre.getElementsByTagName("div");
			var destino	= document.getElementById("info_notif");
			if (destino) {destino.innerHTML = total.length + " NOTIFICACIONES";}
			if (total.length < 1) {
				padre.parentNode.removeChild(padre);
				destino.parentNode.removeChild(destino);
			}
		}
	}
}

function eliminar_info() {
	if (document.getElementById("info_accion")) {
		document.getElementById("info_accion").parentElement.removeChild(document.getElementById("info_accion"));
	}
	if (document.getElementById("info_info")) {
		document.getElementById("info_info").parentElement.removeChild(document.getElementById("info_info"));
	}
}

function goPage(url) {
	mostrarCapaEspera();
	location.href = url;
}
function goByForm(url, keys, values) {
	if (Object.prototype.toString.call(url) !== "[object String]" || url.length < 3) {
		return alert("url no válida");
	}
	mostrarCapaEspera();	
	var form						= document.createElement("form");
	form.name						= "frm_envio_page";
	form.method						= "POST";
	form.action						= url;
	form.style.display				= "none";
	document.body.appendChild(form);
	if (Object.prototype.toString.call(keys) === "[object Array]" && Object.prototype.toString.call(values) === "[object Array]" && keys.length === values.length) {
		for (var n = 0; n < keys.length; n++) {
			var hid		= document.createElement("input");
			hid.name	= keys[n];
			hid.type	= "hidden";
			hid.value	= values[n];
			form.appendChild(hid);
		}
	}
	form.submit();
}
function formSubmit(name) {
	if (Object.prototype.toString.call(name) !== "[object String]" || name.length < 1) {return alert("formulario no válido");}
	var form = document.forms[name];
	if (!form) {return alert("No se encuentra el formulario");}
	mostrarCapaEspera();
	form.submit();
}



// Accede a la BBDD a través de una url pasándole la sentencia sql por post y devuelve el resultado:
function doDBaccion(sql, tipo, returnFunction) {
	if (Object.prototype.toString.call(sql)!== "[object String]" || sql.trim().length < 5) {return false;}
	tipo	= Object.prototype.toString.call(tipo)!== "[object Number]" || tipo < 0 || tipo > 1	? 0						: tipo;
	var url = _URL_RAIZ + "includes/";
	url	   += tipo === 0																		? "get_sql_request.php"	: "do_sql_sentence.php";
	url	   += "?sql=" + sql;
	var dat	= new FormData();
	var req	= new XMLHttpRequest();
	dat.append("sql", sql);
	req.open('POST', url, true);
	req.onload = function () {
		if (req.readyState == 4) {
			if(req.status == 200 && Object.prototype.toString.call(returnFunction) === "[object Function]") {
				returnFunction(req.responseText.indexOf("ERROR") === 0 ? false : (tipo === 0 ? JSON.parse(req.responseText) : parseInt(req.responseText, 10)));
			} else {
				returnFunction(false);
			}
		}
	}
	req.send(dat);
}

//---------------- Habilita o desabilita todos los controles de un elemento sin que sea un formulario: ---------------
// Primer parámetro es el contenedor DOM de los controles
// Segundo parámetro opcional, true si no se especifica expresamente que es false;
// Devuelve el número de elementos que han sido cambiados
function habilitaControles(contenedor, hab) {
	if (typeof(contenedor) !== 'object') {alert("ERROR: El contenedor a deshabilitar no es correcto"); return 0;}
	hab			= typeof(hab) === 'undefined' || hab !== false;
	var tipos	= new Array("input", "select", "button");
	var hechos	= 0;
	for (var n = 0; n < tipos.length; n++) {
		var elementos	= contenedor.getElementsByTagName(tipos[n]);
		for (var i = 0; i < elementos.length; i++) {
			elementos[i].disabled = hab ? false : true;
			hechos++;
		}
	}
	return hechos;
}


//------------------------------ Crea un libro de excel desde un JSON: -----------------------------------------------
//Se necesita tener cargado ExcelPlus
function jsonToExcel(cabecera, datos) {
	if (typeof(ExcelPlus) === 'undefined') {
		alert("No se encuentra el objeto ExcelPlus");
		return false;
	}
	var ep = new ExcelPlus();
	if (typeof(ep) === "object") {
		ep.createFile("Libro1");
		if (typeof(cabecera) !== "undefined" && Object.prototype.toString.call(cabecera) === "[object Array]") {
			ep.write({"content":[cabecera]});
		}
		if (Object.prototype.toString.call(datos) === "[object Array]") {
			for (var n in datos) {
				var fila = [];
				for (var i in datos[n]) {
					fila[fila.length] = datos[n][i];
				}
				ep.writeNextRow(fila);
			}
		}
		ep.saveAs(_APP_NAME.toLowerCase() + ".xlsx");
		return true;
	} else {
		alert("No se ha podido crear el objeto ExcelPlus");
		return false;
	}
}
//-------------------------------------------------------------------------------------------------------------------------------------

//devuelve la cadena pasada sin comillas simples, dobles ni barras invertidas:
function sin_comillas(str) {
	str = str.replace(/\"|\'|\\/g, '');
	return str;
}

//Encuentra el índice de un array multidimensional donde se encuentra el valor pasado en la dimension pasada
function findInArray(arr, dim, valor) {
	var devuelve = -1;
	for (var n in arr) {
		if (arr[n][dim] === valor) {
			devuelve = n;
			break;
		}
	}
	return devuelve;
}
/*******************************************************	FUNCIONES DE VALIDACIÓN DE CAMPOS	*******************************************************/

function esNumerico(num){
	if(num==="" || num===undefined || num===null){return false;}
	var pattern=/^[-]?\d+([,.]\d+)?$/;
	return pattern.test(num);
}

function isDNI(dni) {
	var numero, let, letra;
	var expresion_regular_dni = /^[XYZ]?\d{5,8}[A-Z]$/;
 
	dni = dni.toUpperCase();
 
	if(expresion_regular_dni.test(dni) === true){
		numero = dni.substr(0,dni.length-1);
		numero = numero.replace('X', 0);
		numero = numero.replace('Y', 1);
		numero = numero.replace('Z', 2);
		let = dni.substr(dni.length-1, 1);
		numero = numero % 23;
		letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
		letra = letra.substring(numero, numero+1);
		if (letra != let) {
			//alert('Dni erroneo, la letra del NIF no se corresponde');
			return false;
		}else{
			//alert('Dni correcto');
			return true;
		}
	}else{
		//alert('Dni erroneo, formato no válido');
		return false;
	}
}

function CP_valido(valor){
	var exp=/^\d{5}$/;
	return exp.test(valor);
}

function telefono_valido(valor){
	var exp=/^(6|9)[0-9]{8}$/;
	return exp.test(valor);
}

function mail_valido(valor){
	var exp=/^(.+\@.+\..+)$/;
	return exp.test(valor);
}

function esFechaValida(fecha) {
	var formato	= new RegExp(/^\d{2}\/\d{2}\/\d{4}$/);
	fecha		= fecha.trim();
	if (fecha.match(formato)) {
		arr_fecha	= fecha.split("/",3);
		str_fecha	= arr_fecha[2] + "-" + arr_fecha[1] + "-" + arr_fecha[0];
		if (new Date(str_fecha) == "Invalid Date") {return "Fecha no admitida."}
		return true;
	} else {
		return "Formato de fecha incorrecto.";
	}
}
function esFechaValidaMySQL(fecha) {
	var formato	= new RegExp(/^\d{4}\-\d{2}\-\d{2}$/);
	fecha		= fecha.trim();
	if (fecha.match(formato)) {
		if (new Date(fecha) == "Invalid Date") {return "Fecha no admitida."}
		return true;
	} else {
		return "Formato de fecha incorrecto.";
	}
}

function fechaMayor(fecha1,fecha2) {
	var formato	= new RegExp(/^\d{2}\/\d{2}\/\d{4}$/);
	fecha1		= fecha1.trim();
	fecha2		= fecha2.trim();
	if (fecha1.match(formato) && fecha2.match(formato)) {
		arr_fecha1	= fecha1.split("/",3);
		str_fecha1	= arr_fecha1[2] + "-" + arr_fecha1[1] + "-" + arr_fecha1[0];
		arr_fecha2	= fecha2.split("/",3);
		str_fecha2	= arr_fecha2[2] + "-" + arr_fecha2[1] + "-" + arr_fecha2[0];
		if (new Date(str_fecha1) == "Invalid Date" || new Date(str_fecha2) == "Invalid Date") {return null;}
		else if (new Date(str_fecha1) > new Date(str_fecha2)){return true;}
		else {return false;}
	} else {
		return null;
	}
}
function fechaMayorMySQL(fecha1,fecha2) {
	var formato	= new RegExp(/^\d{4}\-\d{2}\-\d{2}$/);
	fecha1		= fecha1.trim();
	fecha2		= fecha2.trim();
	if (fecha1.match(formato) && fecha2.match(formato)) {
		if (new Date(fecha1) == "Invalid Date" || new Date(fecha2) == "Invalid Date") {return null;}
		else if (new Date(fecha1) > new Date(fecha2)) {return true;}
		else {return false;}
	} else {
		return null;
	}
}

function fehaHTMLtoMySQL(fecha) {
	var arr_fecha	= fecha.trim().split("/",3);
	return arr_fecha[2] + "-" + arr_fecha[1] + "-" + arr_fecha[0];
}

//Convierte un formato decimal con coma en uno con punto:
function decimalIngles(num){
	return num.replace(",",".");
}

//Devuelve el número pasado en formato string con un cero delante si es menor de 10
function DosDigitos(num) {
	num = num === undefined || !esNumerico(num) ? 0 : parseInt(num);
	return num < 10 ? "0" + num : num;
}
//Devuelve el tiempo transcurrido desde una hora determinada hasta el momento actual:
function getTimeRemaining(endtime){
  var t			= Date.parse(new Date()) - Date.parse(endtime);
  var seconds	= Math.floor( (t / 1000) % 60 );
  var minutes	= Math.floor( (t / 1000 / 60) % 60 );
  var hours		= Math.floor( (t / (1000 * 60 * 60)) % 24 );
  var days		= Math.floor(t / (1000 * 60 * 60 * 24) );
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

//Comprueba que una variable, objeto o elmento del DOM existe o está definida y no es nula:
function definidoNoNulo(elem) {
	if (typeof(elem) === 'undefined' || elem === null) {
		return false;
	} else {
		return true;
	}
}

// Devuelve la altura del documento con scroll si lo tiene:
function getWholeDocumentHeight() {
	var body = document.body;
	var html = document.documentElement; 
	var bodyH = Math.max(body.scrollHeight, body.offsetHeight, body.getBoundingClientRect().height, html.clientHeight, html.scrollHeight, html.offsetHeight);
	return bodyH;
}
