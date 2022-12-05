-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.25-MariaDB


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema stubia
--

CREATE DATABASE IF NOT EXISTS stubia;
USE stubia;

--
-- Definition of table `accesos_usuarios`
--

DROP TABLE IF EXISTS `accesos_usuarios`;
CREATE TABLE `accesos_usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `perfil_id` int(10) unsigned NOT NULL DEFAULT 0,
  `login_date` datetime NOT NULL,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-10-08 00:00:00',
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='Tabla para guardar los accesos de los usuarios a la app';

--
-- Dumping data for table `accesos_usuarios`
--

/*!40000 ALTER TABLE `accesos_usuarios` DISABLE KEYS */;
INSERT INTO `accesos_usuarios` (`id`,`user_id`,`perfil_id`,`login_date`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,7,1,'2022-11-15 20:20:19','2022-11-15 20:20:19','100000','index.php',NULL,NULL,NULL,0,1),
 (2,7,1,'2022-11-15 20:20:40','2022-11-15 20:20:40','100000','index.php',NULL,NULL,NULL,0,1),
 (3,7,1,'2022-11-15 20:23:03','2022-11-15 20:23:03','100000','index.php',NULL,NULL,NULL,0,1),
 (4,7,1,'2022-11-15 20:24:07','2022-11-15 20:24:07','100000','index.php',NULL,NULL,NULL,0,1),
 (5,7,1,'2022-11-15 20:25:11','2022-11-15 20:25:11','100000','index.php',NULL,NULL,NULL,0,1),
 (6,7,1,'2022-11-15 20:25:12','2022-11-15 20:25:12','100000','index.php',NULL,NULL,NULL,0,1),
 (7,7,1,'2022-11-15 20:25:12','2022-11-15 20:25:12','100000','index.php',NULL,NULL,NULL,0,1),
 (8,7,1,'2022-11-15 20:29:20','2022-11-15 20:29:20','100000','login.php',NULL,NULL,NULL,0,1),
 (9,7,1,'2022-11-15 20:29:20','2022-11-15 20:29:20','100000','index.php',NULL,NULL,NULL,0,1),
 (10,7,1,'2022-11-15 20:39:37','2022-11-15 20:39:37','100000','login.php',NULL,NULL,NULL,0,1),
 (11,7,1,'2022-11-15 20:39:37','2022-11-15 20:39:37','100000','index.php',NULL,NULL,NULL,0,1),
 (12,7,1,'2022-11-15 20:41:58','2022-11-15 20:41:58','100000','login.php',NULL,NULL,NULL,0,1),
 (13,7,1,'2022-11-15 20:41:58','2022-11-15 20:41:58','100000','index.php',NULL,NULL,NULL,0,1),
 (14,7,1,'2022-11-17 18:35:12','2022-11-17 18:35:12','100000','login.php',NULL,NULL,NULL,0,1),
 (15,7,1,'2022-11-17 18:35:12','2022-11-17 18:35:12','100000','index.php',NULL,NULL,NULL,0,1),
 (16,7,1,'2022-11-17 21:39:44','2022-11-17 21:39:44','100000','index.php',NULL,NULL,NULL,0,1),
 (17,7,1,'2022-11-17 21:41:14','2022-11-17 21:41:14','100000','index.php',NULL,NULL,NULL,0,1),
 (18,7,1,'2022-11-25 22:48:13','2022-11-25 22:48:13','100000','login.php',NULL,NULL,NULL,0,1),
 (19,7,1,'2022-11-25 22:48:13','2022-11-25 22:48:13','100000','index.php',NULL,NULL,NULL,0,1),
 (20,7,1,'2022-11-26 10:00:43','2022-11-26 10:00:43','100000','login.php',NULL,NULL,NULL,0,1),
 (21,7,1,'2022-11-26 19:14:46','2022-11-26 19:14:46','100000','login.php',NULL,NULL,NULL,0,1),
 (22,9,1,'2022-11-26 19:25:26','2022-11-26 19:25:26','100000','login.php',NULL,NULL,NULL,0,1),
 (23,10,1,'2022-11-26 19:26:34','2022-11-26 19:26:34','100000','login.php',NULL,NULL,NULL,0,1),
 (24,7,1,'2022-11-27 02:22:41','2022-11-27 02:22:41','100000','login.php',NULL,NULL,NULL,0,1),
 (25,7,1,'2022-11-27 16:17:48','2022-11-27 16:17:48','100000','login.php',NULL,NULL,NULL,0,1),
 (26,7,1,'2022-12-02 16:45:37','2022-12-02 16:45:37','100000','login.php',NULL,NULL,NULL,0,1),
 (27,7,1,'2022-12-04 20:01:53','2022-12-04 20:01:53','100000','login.php',NULL,NULL,NULL,0,1),
 (28,7,1,'2022-12-04 20:05:29','2022-12-04 20:05:29','100000','login.php',NULL,NULL,NULL,0,1),
 (29,7,1,'2022-12-04 20:51:23','2022-12-04 20:51:23','100000','login.php',NULL,NULL,NULL,0,1),
 (30,7,1,'2022-12-05 00:30:46','2022-12-05 00:30:46','100000','login.php',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `accesos_usuarios` ENABLE KEYS */;


--
-- Definition of table `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE `estados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aula` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `puesto` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `estado` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `au_fec_alta` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3814 DEFAULT CHARSET=utf8 COMMENT='Tabla para guardar los estados de los puestos';

--
-- Dumping data for table `estados`
--

/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` (`id`,`aula`,`puesto`,`estado`,`au_fec_alta`) VALUES 
 (1,1,1,1,'2022-11-11 12:00:00'),
 (3805,1,1,1,'2022-11-26 19:11:08'),
 (3806,2,1,1,'2022-11-26 19:11:10'),
 (3807,1,1,1,'2022-11-26 19:11:12'),
 (3808,2,2,2,'2022-11-26 19:14:56'),
 (3809,1,2,1,'2022-11-26 19:15:02'),
 (3810,1,1,1,'2022-11-26 19:15:04'),
 (3811,1,48,2,'2022-11-26 02:00:00'),
 (3812,3,55,2,'2022-11-26 02:00:00'),
 (3813,3,7,1,'2022-12-04 13:56:00');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;


--
-- Definition of table `master_aulas`
--

DROP TABLE IF EXISTS `master_aulas`;
CREATE TABLE `master_aulas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filas` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `aula` varchar(50) NOT NULL,
  `tipo` tinyint(1) unsigned NOT NULL,
  `aforo` int(4) unsigned NOT NULL DEFAULT 0,
  `id_tipo_puestos` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `lado_puerta` varchar(25) NOT NULL DEFAULT 'Izquierda',
  `id_bloque` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `planta` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `divisiones_aula` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `au_fec_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_aulas`
--

/*!40000 ALTER TABLE `master_aulas` DISABLE KEYS */;
INSERT INTO `master_aulas` (`id`,`filas`,`aula`,`tipo`,`aforo`,`id_tipo_puestos`,`lado_puerta`,`id_bloque`,`planta`,`divisiones_aula`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,8,'SA6',1,80,1,'Derecha',4,1,2,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,3,'NL11',2,30,2,'Derecha',2,2,1,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (3,10,'Biblioteca',3,100,2,'Derecha',4,2,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (4,2,'Mesa estudio 1',4,6,2,'Izquierda',2,2,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (5,2,'Mesa estudio 2',4,6,2,'Izquierda',3,1,1,'2022-10-08 00:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (6,10,'NA4',1,100,1,'Izquierda',2,1,2,'2022-11-27 13:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (7,10,'EA2',1,100,1,'Derecha',1,1,2,'2022-11-28 02:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_aulas` ENABLE KEYS */;


--
-- Definition of table `master_bloques`
--

DROP TABLE IF EXISTS `master_bloques`;
CREATE TABLE `master_bloques` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `color` varchar(20) NOT NULL,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-10-08 00:00:00',
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_bloques`
--

/*!40000 ALTER TABLE `master_bloques` DISABLE KEYS */;
INSERT INTO `master_bloques` (`id`,`nombre`,`color`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,'Este','#198754;','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,'Norte','#0d6efd;','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (3,'Oeste','#dc3545;','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (4,'Sur','#ffc107;','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_bloques` ENABLE KEYS */;


--
-- Definition of table `master_estados`
--

DROP TABLE IF EXISTS `master_estados`;
CREATE TABLE `master_estados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) NOT NULL,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-10-14 00:00:00',
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_estados`
--

/*!40000 ALTER TABLE `master_estados` DISABLE KEYS */;
INSERT INTO `master_estados` (`id`,`estado`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,'Ocupado','2022-10-14 16:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,'Libre','2022-10-14 16:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (3,'Reservado','2022-11-18 17:00:00','2','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_estados` ENABLE KEYS */;


--
-- Definition of table `master_franjas_horarias`
--

DROP TABLE IF EXISTS `master_franjas_horarias`;
CREATE TABLE `master_franjas_horarias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inicio` tinyint(3) unsigned NOT NULL,
  `fin` tinyint(3) unsigned NOT NULL,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-11-06 00:00:00',
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_franjas_horarias`
--

/*!40000 ALTER TABLE `master_franjas_horarias` DISABLE KEYS */;
INSERT INTO `master_franjas_horarias` (`id`,`inicio`,`fin`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,1,2,'2022-11-06 00:00:00','2','A mano',NULL,NULL,NULL,0,0),
 (2,2,3,'2022-11-06 00:00:00','2','A mano',NULL,NULL,NULL,0,0),
 (3,3,4,'2022-11-06 00:00:00','2','A mano',NULL,NULL,NULL,0,0),
 (4,4,5,'2022-11-15 21:00:00','2','A mano',NULL,NULL,NULL,0,0),
 (5,5,6,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,0),
 (6,6,7,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,0),
 (7,7,8,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,0),
 (8,8,9,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (9,9,10,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (10,10,11,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (11,11,12,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (12,12,13,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (13,13,14,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (14,14,15,'2022-12-02 18:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (15,15,16,'2022-12-02 18:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (16,16,17,'2022-12-02 18:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (17,17,18,'2022-12-02 18:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (18,18,19,'2022-11-06 00:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (19,19,20,'2022-12-02 18:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (20,20,21,'2022-12-02 18:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (21,21,22,'2022-12-02 18:00:00','2','A mano',NULL,NULL,NULL,0,0);
/*!40000 ALTER TABLE `master_franjas_horarias` ENABLE KEYS */;


--
-- Definition of table `master_perfil`
--

DROP TABLE IF EXISTS `master_perfil`;
CREATE TABLE `master_perfil` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perfil` varchar(50) NOT NULL,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-11-11 13:00:00',
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_perfil`
--

/*!40000 ALTER TABLE `master_perfil` DISABLE KEYS */;
INSERT INTO `master_perfil` (`id`,`perfil`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,'Admin','2022-11-12 13:00:00','7','A mano',NULL,NULL,NULL,0,1),
 (2,'Alumno','2022-11-12 13:00:00','7','A mano',NULL,NULL,NULL,0,1),
 (3,'Profesor','2022-11-12 13:00:00','7','A mano',NULL,NULL,NULL,0,1),
 (4,'Conserjería','2022-11-12 13:00:00','7','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_perfil` ENABLE KEYS */;


--
-- Definition of table `master_puestos`
--

DROP TABLE IF EXISTS `master_puestos`;
CREATE TABLE `master_puestos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `puesto` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `id_aula` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `id_tipo` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `au_fec_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=435 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_puestos`
--

/*!40000 ALTER TABLE `master_puestos` DISABLE KEYS */;
INSERT INTO `master_puestos` (`id`,`puesto`,`id_aula`,`id_tipo`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (13,1,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (14,2,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (15,3,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (16,4,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (17,5,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (18,6,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (19,7,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (20,8,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (21,9,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (22,10,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (23,11,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (24,12,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (25,13,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (26,14,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (27,15,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (28,16,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (29,17,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (30,18,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (31,19,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (32,20,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (33,21,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (34,22,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (35,23,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (36,24,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (37,25,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (38,26,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (39,27,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (40,28,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (41,29,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (42,30,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (43,31,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (44,32,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (45,33,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (46,34,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (47,35,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (48,36,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (49,37,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (50,38,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (51,39,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (52,40,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (53,41,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (54,42,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (55,43,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (56,44,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (57,45,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (58,46,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (59,47,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (60,48,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (61,49,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (62,50,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (63,51,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (64,52,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (65,53,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (66,54,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (67,55,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (68,56,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (69,57,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (70,58,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (71,59,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (72,60,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (73,61,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (74,62,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (75,63,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (76,64,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (77,65,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (78,66,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (79,67,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (80,68,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (81,69,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (82,70,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (83,71,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (84,72,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (85,73,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (86,74,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (87,75,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (88,76,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (89,77,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (90,78,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (91,79,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (92,80,1,1,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (93,1,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (94,2,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (95,3,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (96,4,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (97,5,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (98,6,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (99,7,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (100,8,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (101,9,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (102,10,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (103,11,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (104,12,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (105,13,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (106,14,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (107,15,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (108,16,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (109,17,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (110,18,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (111,19,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (112,20,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (113,21,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (114,22,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (115,23,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (116,24,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (117,25,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (118,26,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (119,27,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (120,28,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (121,29,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (122,30,2,2,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (123,1,3,3,'2022-12-04 23:05:47','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (124,2,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (125,3,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (126,4,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (127,5,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (128,6,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (129,7,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (130,8,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (131,9,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (132,10,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (133,11,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (134,12,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (135,13,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (136,14,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (137,15,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (138,16,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (139,17,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (140,18,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (141,19,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (142,20,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (143,21,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (144,22,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (145,23,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (146,24,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (147,25,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (148,26,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (149,27,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (150,28,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (151,29,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (152,30,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (153,31,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (154,32,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (155,33,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (156,34,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (157,35,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (158,36,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (159,37,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (160,38,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (161,39,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (162,40,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (163,41,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (164,42,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (165,43,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (166,44,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (167,45,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (168,46,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (169,47,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (170,48,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (171,49,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (172,50,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (173,51,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (174,52,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (175,53,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (176,54,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (177,55,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (178,56,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (179,57,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (180,58,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (181,59,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (182,60,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (183,61,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (184,62,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (185,63,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (186,64,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (187,65,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (188,66,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (189,67,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (190,68,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (191,69,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (192,70,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (193,71,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (194,72,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (195,73,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (196,74,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (197,75,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (198,76,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (199,77,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (200,78,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (201,79,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (202,80,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (203,81,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (204,82,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (205,83,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (206,84,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (207,85,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (208,86,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (209,87,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (210,88,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (211,89,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (212,90,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (213,91,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (214,92,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (215,93,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (216,94,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (217,95,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (218,96,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (219,97,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (220,98,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (221,99,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (222,100,3,3,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (223,1,4,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (224,2,4,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (225,3,4,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (226,4,4,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (227,5,4,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (228,6,4,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (229,1,5,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (230,2,5,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (231,3,5,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (232,4,5,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (233,5,5,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (234,6,5,4,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (235,1,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (236,2,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (237,3,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (238,4,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (239,5,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (240,6,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (241,7,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (242,8,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (243,9,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (244,10,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (245,11,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (246,12,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (247,13,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (248,14,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (249,15,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (250,16,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (251,17,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (252,18,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (253,19,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (254,20,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (255,21,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (256,22,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (257,23,6,1,'2022-12-04 23:05:48','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (258,24,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (259,25,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (260,26,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (261,27,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (262,28,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (263,29,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (264,30,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (265,31,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (266,32,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (267,33,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (268,34,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (269,35,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (270,36,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (271,37,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (272,38,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (273,39,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (274,40,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (275,41,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (276,42,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (277,43,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (278,44,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (279,45,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (280,46,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (281,47,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (282,48,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (283,49,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (284,50,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (285,51,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (286,52,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (287,53,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (288,54,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (289,55,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (290,56,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (291,57,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (292,58,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (293,59,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (294,60,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (295,61,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (296,62,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (297,63,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (298,64,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (299,65,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (300,66,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (301,67,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (302,68,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (303,69,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (304,70,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (305,71,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (306,72,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (307,73,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (308,74,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (309,75,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (310,76,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (311,77,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (312,78,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (313,79,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (314,80,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (315,81,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (316,82,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (317,83,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (318,84,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (319,85,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (320,86,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (321,87,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (322,88,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (323,89,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (324,90,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (325,91,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (326,92,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (327,93,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (328,94,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (329,95,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (330,96,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (331,97,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (332,98,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (333,99,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (334,100,6,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (335,1,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (336,2,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (337,3,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (338,4,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (339,5,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (340,6,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (341,7,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (342,8,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (343,9,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (344,10,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (345,11,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (346,12,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (347,13,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (348,14,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (349,15,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (350,16,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (351,17,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (352,18,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (353,19,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (354,20,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (355,21,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (356,22,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (357,23,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (358,24,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (359,25,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (360,26,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (361,27,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (362,28,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (363,29,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (364,30,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (365,31,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (366,32,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (367,33,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (368,34,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (369,35,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (370,36,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (371,37,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (372,38,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (373,39,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (374,40,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (375,41,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (376,42,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (377,43,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (378,44,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (379,45,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (380,46,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (381,47,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (382,48,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (383,49,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (384,50,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (385,51,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (386,52,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (387,53,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (388,54,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (389,55,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (390,56,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (391,57,7,1,'2022-12-04 23:05:49','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (392,58,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (393,59,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (394,60,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (395,61,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (396,62,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (397,63,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (398,64,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (399,65,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (400,66,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (401,67,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (402,68,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (403,69,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (404,70,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (405,71,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (406,72,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (407,73,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (408,74,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (409,75,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (410,76,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (411,77,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (412,78,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (413,79,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (414,80,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (415,81,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (416,82,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (417,83,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (418,84,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (419,85,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (420,86,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (421,87,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (422,88,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (423,89,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (424,90,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (425,91,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (426,92,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (427,93,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (428,94,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (429,95,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (430,96,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (431,97,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (432,98,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (433,99,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1),
 (434,100,7,1,'2022-12-04 23:05:50','7','script_insertar.php',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_puestos` ENABLE KEYS */;


--
-- Definition of table `master_tipo_aula`
--

DROP TABLE IF EXISTS `master_tipo_aula`;
CREATE TABLE `master_tipo_aula` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-11-13 00:00:00',
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_tipo_aula`
--

/*!40000 ALTER TABLE `master_tipo_aula` DISABLE KEYS */;
INSERT INTO `master_tipo_aula` (`id`,`tipo`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,'Teoría','2022-11-13 18:00:00','7','A mano',NULL,NULL,NULL,0,1),
 (2,'Laboratorio','2022-11-13 18:00:00','7','A mano',NULL,NULL,NULL,0,1),
 (3,'Biblioteca','2022-11-13 18:00:00','7','A mano',NULL,NULL,NULL,0,1),
 (4,'Mesa común','2022-11-13 18:00:00','7','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_tipo_aula` ENABLE KEYS */;


--
-- Definition of table `master_tipo_puesto`
--

DROP TABLE IF EXISTS `master_tipo_puesto`;
CREATE TABLE `master_tipo_puesto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-10-08 00:00:00',
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_tipo_puesto`
--

/*!40000 ALTER TABLE `master_tipo_puesto` DISABLE KEYS */;
INSERT INTO `master_tipo_puesto` (`id`,`nombre`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,'plegable madera','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,'silla madera','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_tipo_puesto` ENABLE KEYS */;


--
-- Definition of table `master_usuarios`
--

DROP TABLE IF EXISTS `master_usuarios`;
CREATE TABLE `master_usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_perfil` tinyint(1) NOT NULL DEFAULT 2,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `username_ldap` varchar(45) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `direccion` int(10) unsigned NOT NULL DEFAULT 0,
  `au_fec_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_usuarios`
--

/*!40000 ALTER TABLE `master_usuarios` DISABLE KEYS */;
INSERT INTO `master_usuarios` (`id`,`id_perfil`,`nombre`,`apellidos`,`dni`,`username`,`password`,`username_ldap`,`email`,`direccion`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,1,'Guillermo','González Martínez','03114191Z','guillermo.gonzalezm','guillerrrrrrr','guillermo.gonzalezm','guillermo.gonzalezm@edu.uah.es',0,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,0),
 (6,1,'Pablo','García García',NULL,'pablo.ggarcia','$2y$10$qu2g1WqEN45PMw/iX6BGPuh5UZa4/Q0NScGCqGraXsDgZdD0hSNke',NULL,'pablo.ggarcia@edu.uah.es',0,'2022-11-11 20:16:47','BBDD','Web',NULL,NULL,NULL,0,1),
 (7,1,'Guillermo','González Martínez',NULL,'guille','$2y$10$CTWpSbVvLa.P9c8/RAWVg.mqAczwwvT1oIKfmzwZ57CuVJz5HimEW',NULL,'guillermo.gonzalezm@edu.uah.es',0,'2022-11-12 12:42:29','BBDD','Web',NULL,NULL,NULL,0,1),
 (8,3,'Periko','de los palotes',NULL,'Periko','$2y$10$QFz/BvcK7dKUTSHDydcIuOs0jadi025NDOPAPm2AfuzXJtskVgFxC',NULL,'guille.willy.1975@gmail.com',0,'2022-11-12 13:12:51','BBDD','Web',NULL,NULL,NULL,0,1),
 (9,2,'Nicolás','González Cámara',NULL,'nico','$2y$10$VG5Q34b4L81suoM7opLIfep9n8H6gy2ZMvFUL13c6L4M5c5gCORy6',NULL,'guillermo.gonzalezm@edu.uah.es',0,'2022-11-26 19:25:12','BBDD','Web',NULL,NULL,NULL,0,1),
 (10,2,'Chus','Cámara',NULL,'chus','$2y$10$0tBtkOrTQpamCRdtsWdnSO3/v6OW4ArWL3VOCp0ftd5WVqv/DX7cy',NULL,'guillermo.gonzalezm@edu.uah.es',0,'2022-11-26 19:26:19','BBDD','Web',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_usuarios` ENABLE KEYS */;


--
-- Definition of table `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `unidades_vendidas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productos`
--

/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id`,`codigo`,`producto`,`unidades_vendidas`) VALUES 
 (1,'BD','Pantalla LED 32',6),
 (2,'BB','Mouse USB',16),
 (3,'VB','Disco duro 1TB ',14),
 (4,'WS','Teclado USD',8),
 (5,'TN','Monitor LG 21',6),
 (6,'12000','Lector 3nStar',20);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;


--
-- Definition of table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL DEFAULT 0,
  `id_franja_horaria` int(10) unsigned NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `id_puesto` int(10) unsigned NOT NULL DEFAULT 0,
  `localizador` varchar(6) NOT NULL DEFAULT '',
  `au_fec_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_franja_horaria` (`id_franja_horaria`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `master_usuarios` (`id`),
  CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_franja_horaria`) REFERENCES `master_franjas_horarias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservas`
--

/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
INSERT INTO `reservas` (`id`,`id_usuario`,`id_franja_horaria`,`fecha`,`id_puesto`,`localizador`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,7,9,'2022-11-27 10:00:00',5,'','2022-11-12 16:00:00','7','A mano',NULL,NULL,NULL,0,0),
 (2,7,8,'2022-11-27 10:00:00',6,'','2022-11-12 16:00:00','7','A mano',NULL,NULL,NULL,0,0),
 (3,7,16,'2022-11-27 10:00:00',7,'','2022-11-12 16:00:00','7','A mano',NULL,NULL,NULL,0,0),
 (4,7,12,'2022-12-03 20:00:00',7,'','2022-12-02 19:54:48','7','reservas.php',NULL,NULL,NULL,0,0),
 (6,7,1,'2022-12-03 01:00:00',11,'','2022-12-03 20:23:54','7','reserva.php',NULL,NULL,NULL,0,0),
 (7,7,1,'2022-12-03 01:00:00',11,'AQT4BU','2022-12-03 21:38:37','7','reserva.php',NULL,NULL,NULL,0,0),
 (8,7,12,'2022-12-03 12:00:00',10,'PXVJ2Z','2022-12-03 21:41:10','7','reserva.php',NULL,NULL,NULL,0,0),
 (9,7,12,'2022-12-03 12:00:00',11,'H9XNLB','2022-12-03 22:09:35','7','reserva.php',NULL,NULL,NULL,0,0),
 (10,7,12,'2022-12-03 12:00:00',5,'JUCWRX','2022-12-03 22:12:31','7','reserva.php',NULL,NULL,NULL,0,0),
 (11,7,12,'2022-12-03 12:00:00',6,'N791BC','2022-12-03 22:19:59','7','reserva.php',NULL,NULL,NULL,0,0),
 (12,7,9,'2022-12-03 09:00:00',7,'HMZNPT','2022-12-03 22:22:53','7','reserva.php',NULL,NULL,NULL,0,0),
 (13,7,11,'2022-12-03 11:00:00',10,'QBRE8U','2022-12-03 22:25:34','7','reserva.php',NULL,NULL,NULL,0,0),
 (14,7,9,'2022-12-03 09:00:00',10,'JBKME6','2022-12-03 22:27:35','7','reserva.php',NULL,NULL,NULL,0,0),
 (15,7,9,'2022-12-03 09:00:00',6,'9J6YXH','2022-12-03 22:36:08','7','reserva.php',NULL,NULL,NULL,0,0),
 (16,7,9,'2022-12-03 09:00:00',10,'HPJ34L','2022-12-03 22:37:03','7','reserva.php',NULL,NULL,NULL,0,0),
 (17,7,9,'2022-12-03 09:00:00',11,'MD716W','2022-12-03 22:37:32','7','reserva.php',NULL,NULL,NULL,0,0),
 (18,7,9,'2022-12-04 09:00:00',7,'RZWE94','2022-12-03 22:40:40','7','reserva.php',NULL,NULL,NULL,0,0),
 (19,7,9,'2022-12-04 09:00:00',7,'CLPGHA','2022-12-03 22:42:32','7','reserva.php',NULL,NULL,NULL,0,0),
 (20,7,8,'2022-12-19 08:00:00',10,'WBRFI4','2022-12-03 22:42:57','7','reserva.php',NULL,NULL,NULL,0,0),
 (21,7,9,'2022-12-03 09:00:00',5,'3YT1X2','2022-12-03 22:48:04','7','reserva.php',NULL,NULL,NULL,0,0),
 (22,7,8,'2022-12-05 08:00:00',6,'ODVSKI','2022-12-03 22:48:43','7','reserva.php',NULL,NULL,NULL,0,0),
 (23,7,8,'2022-12-07 08:00:00',6,'T73V4X','2022-12-03 22:50:59','7','reserva.php',NULL,NULL,NULL,0,0),
 (24,7,8,'2022-12-09 08:00:00',6,'RUBZJ6','2022-12-03 22:54:43','7','reserva.php',NULL,NULL,NULL,0,0),
 (25,7,8,'2022-12-08 08:00:00',6,'VFBJKY','2022-12-03 22:57:59','7','reserva.php',NULL,NULL,NULL,0,0),
 (26,7,8,'2022-12-23 08:00:00',5,'WZ4982','2022-12-03 23:01:24','7','reserva.php',NULL,NULL,NULL,0,0),
 (27,7,8,'2022-12-23 08:00:00',5,'2I9ZU0','2022-12-03 23:04:45','7','reserva.php',NULL,NULL,NULL,0,0),
 (28,7,8,'2022-12-23 08:00:00',5,'XK6AN3','2022-12-03 23:07:26','7','reserva.php',NULL,NULL,NULL,0,0),
 (29,7,8,'2022-12-23 08:00:00',5,'4IS6VT','2022-12-03 23:10:21','7','reserva.php',NULL,NULL,NULL,0,0),
 (30,7,8,'2022-12-23 08:00:00',5,'GE4N1K','2022-12-03 23:22:47','7','reserva.php',NULL,NULL,NULL,0,0),
 (31,7,8,'2022-12-23 08:00:00',5,'C1YB6Q','2022-12-03 23:24:51','7','reserva.php',NULL,NULL,NULL,0,0),
 (32,7,8,'2022-12-23 08:00:00',5,'W9NYTA','2022-12-03 23:25:15','7','reserva.php',NULL,NULL,NULL,0,0),
 (33,7,8,'2022-12-23 08:00:00',5,'ZVBGS4','2022-12-03 23:26:11','7','reserva.php',NULL,NULL,NULL,0,0),
 (34,7,8,'2022-12-23 08:00:00',5,'2FQ6YS','2022-12-03 23:26:43','7','reserva.php',NULL,NULL,NULL,0,0),
 (35,7,12,'2022-12-05 12:00:00',6,'AFBVUO','2022-12-03 23:35:25','7','reserva.php',NULL,NULL,NULL,0,0),
 (36,7,8,'2022-12-09 08:00:00',10,'0NGK7F','2022-12-03 23:38:35','7','reserva.php',NULL,NULL,NULL,0,0),
 (37,7,8,'2022-12-09 08:00:00',10,'RCHVEX','2022-12-04 00:49:53','7','reserva.php',NULL,NULL,NULL,0,0),
 (38,7,9,'2022-12-05 09:00:00',6,'WCA2QZ','2022-12-04 00:50:47','7','reserva.php',NULL,NULL,NULL,0,0),
 (39,7,8,'2022-12-05 08:00:00',10,'RYC5PN','2022-12-04 01:08:18','7','reserva.php',NULL,NULL,NULL,0,0),
 (40,7,8,'2022-12-20 08:00:00',11,'KIAONZ','2022-12-04 11:09:46','7','reserva.php',NULL,NULL,NULL,0,0),
 (41,7,8,'2022-12-24 08:00:00',10,'WDVSAE','2022-12-04 11:20:55','7','reserva.php',NULL,NULL,NULL,0,0),
 (42,7,8,'2022-12-26 08:00:00',5,'6PSV8B','2022-12-04 12:04:50','7','reserva.php',NULL,NULL,NULL,0,0),
 (43,7,14,'2022-12-04 14:00:00',5,'1PLQD8','2022-12-04 13:20:13','7','reserva.php',NULL,NULL,NULL,0,0),
 (44,7,14,'2022-12-04 16:00:00',7,'A9BFZN','2022-12-04 13:27:50','7','reserva.php',NULL,NULL,NULL,0,0),
 (45,7,8,'2022-12-29 08:00:00',7,'BUTEZD','2022-12-04 13:48:21','7','reserva.php',NULL,NULL,NULL,0,0),
 (46,7,9,'2022-12-31 09:00:00',12,'5OW4BH','2022-12-04 14:02:42','7','reserva.php',NULL,NULL,NULL,0,0),
 (47,7,8,'2022-12-06 08:00:00',6,'2YM60V','2022-12-04 15:29:00','7','reserva.php',NULL,NULL,NULL,0,1),
 (48,7,8,'2022-12-22 08:00:00',12,'8XC0VB','2022-12-04 19:08:55','7','reserva.php',NULL,NULL,NULL,0,1),
 (49,7,10,'2022-12-14 10:00:00',10,'NW75ZP','2022-12-04 20:52:17','7','reserva.php',NULL,NULL,NULL,0,1),
 (50,7,10,'2022-12-14 10:00:00',10,'ZR29UM','2022-12-04 23:11:12','7','reserva.php',NULL,NULL,NULL,0,1),
 (51,7,8,'2022-12-05 08:00:00',179,'VCG7P8','2022-12-05 00:47:09','7','reserva.php',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;


--
-- Definition of table `venta`
--

DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_at` date DEFAULT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `venta`
--

/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
INSERT INTO `venta` (`id`,`date_at`,`val`) VALUES 
 (1,'2019-01-01',100),
 (2,'2019-01-02',80),
 (3,'2019-01-03',205),
 (4,'2019-01-04',323),
 (5,'2019-01-05',110),
 (6,'2019-01-06',40),
 (7,'2019-01-07',80),
 (8,'2019-01-08',220),
 (9,'2019-01-09',95),
 (10,'2019-01-10',120),
 (11,'2019-01-11',249),
 (12,'2019-01-12',157),
 (13,'2019-01-13',199),
 (14,'2019-01-14',30),
 (15,'2019-01-15',290);
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
