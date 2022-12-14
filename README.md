# STUBIA
## Sistema inteligente de gestión de puestos de estudio
### Resumen
Es un proyecto para la segunda práctica de laboratorio de la asignatura de Computación Ubicua. Específicamente, presenta un sistema ubicuo sobre la gestión de puestos de estudio de la Universidad de Alcalá (UAH), utilizando los conocimientos de esta asignatura.
### Vídeo demostrativo
[![Vídeo demostrativo](https://i9.ytimg.com/vi_webp/x8gsrvX6LyI/mqdefault.webp?v=639653c8&sqp=COiG6JwG&rs=AOn4CLAl6JgYmQbYaxJYM8Q6ZJQg3bl_fg)](https://www.youtube.com/watch?v=x8gsrvX6LyI&ab_channel=PabloGarc%C3%ADa)
### Hardware necesario
..* PC compatible con XAMPP
..* ESP-32 con sensores ultrasonidos y de inclinación
### Puesta en marcha
1. Instalar XAMPP con PHP y MySQL
2. Instalar MySQL Tools
3. Instlar Arduino IDE
4. Instalar drivers para ESP-32
5. Crear en `htdocs` una carpeta llamada `stubia` con el contenido de la carpeta `Aplicación web`
6. Mediante MySQL Administrator restaurar la base de datos ubicada en `Base de datos/stubia.sql`
7. Desde XAMPP activar Apache y MySQL
8. Conectar correctamente el circuito y editar los parámetros de configuración de WiFi y servidor en `ESP-32/constantes.h`
9. Compilar y cargar en el ESP-32 el archivo `stubia.ino`
