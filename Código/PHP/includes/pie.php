			</div> <!-- capa contenido_variable -->
			<div id="capa_notif" class="oculto">
					<div><p>Se ha dado de alta un nuevo Cuadro de mando</p><img src="<?= $dir_raiz ?>img/close.png" onclick="eliminarNotificacion(this);" /></div>
					<div><p>Quedan 5 indicadores por rellenar</p><img src="<?= $dir_raiz ?>img/close.png" onclick="eliminarNotificacion(this);" /></div>
					<div><p>Tiene una tarea pendiente</p><img src="<?= $dir_raiz ?>img/close.png" onclick="eliminarNotificacion(this);" /></div>
				</div>
		</div> <!-- capa_cuerpo -->
		<div id="capa_borde_inferior" <?=_ENTORNO_ !== "PRODUCCION" ? " style='background-color:#702c6c;'" : ""?> >&nbsp;</div>
		<div id="capa_copyright">&copy; ADIF D.G. Planificación, Estrategia y Proyectos <?=date("Y")?></div>
                
	</div> <!-- contenedor principal -->
</body>
</html>