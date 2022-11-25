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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='Tabla para guardar los accesos de los usuarios a la app';

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
 (17,7,1,'2022-11-17 21:41:14','2022-11-17 21:41:14','100000','index.php',NULL,NULL,NULL,0,1);
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
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-10-08 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3805 DEFAULT CHARSET=utf8 COMMENT='Tabla para guardar los estados de los puestos';

--
-- Dumping data for table `estados`
--

/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` (`id`,`aula`,`puesto`,`estado`,`au_fec_alta`) VALUES 
 (1,1,1,1,'2022-10-08 00:00:00');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;


--
-- Definition of table `master_aulas`
--

DROP TABLE IF EXISTS `master_aulas`;
CREATE TABLE `master_aulas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `puesto` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `aula` varchar(50) NOT NULL,
  `tipo` tinyint(1) unsigned NOT NULL,
  `aforo` int(4) unsigned NOT NULL DEFAULT 0,
  `id_tipo_puestos` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `lado_puerta` varchar(25) NOT NULL DEFAULT 'Izquierda',
  `id_bloque` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `planta` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `divisiones_aula` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-10-08 00:00:00',
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_aulas`
--

/*!40000 ALTER TABLE `master_aulas` DISABLE KEYS */;
INSERT INTO `master_aulas` (`id`,`puesto`,`aula`,`tipo`,`aforo`,`id_tipo_puestos`,`lado_puerta`,`id_bloque`,`planta`,`divisiones_aula`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,0,'SA6',1,60,1,'Derecha',4,1,2,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,0,'NL11',2,30,2,'Derecha',2,2,1,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (3,0,'Biblioteca',3,80,2,'Derecha',4,2,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (4,0,'Mesa estudio 1',4,6,2,'Izquierda',2,2,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (5,0,'Mesa estudio 2',5,6,2,'Izquierda',0,0,1,'2022-10-08 00:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_aulas` ENABLE KEYS */;


--
-- Definition of table `master_bloques`
--

DROP TABLE IF EXISTS `master_bloques`;
CREATE TABLE `master_bloques` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_bloques`
--

/*!40000 ALTER TABLE `master_bloques` DISABLE KEYS */;
INSERT INTO `master_bloques` (`id`,`nombre`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,'Este','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,'Norte','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (3,'Oeste','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (4,'Sur','2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_franjas_horarias`
--

/*!40000 ALTER TABLE `master_franjas_horarias` DISABLE KEYS */;
INSERT INTO `master_franjas_horarias` (`id`,`inicio`,`fin`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,8,9,'2022-11-06 00:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (2,9,10,'2022-11-06 00:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (3,10,11,'2022-11-06 00:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (4,11,12,'2022-11-15 21:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (5,12,13,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (6,13,14,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (7,14,15,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (8,15,16,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (9,16,17,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (10,17,18,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (11,18,19,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (12,19,20,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1),
 (13,20,21,'2022-11-17 19:00:00','2','A mano',NULL,NULL,NULL,0,1);
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
  `ìd_tipo` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `fila` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `columna` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-10-08 00:00:00',
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
-- Dumping data for table `master_puestos`
--

/*!40000 ALTER TABLE `master_puestos` DISABLE KEYS */;
INSERT INTO `master_puestos` (`id`,`puesto`,`id_aula`,`ìd_tipo`,`fila`,`columna`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,1,2,2,1,1,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,2,2,2,1,2,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (3,3,2,2,1,3,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (4,4,2,2,1,4,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (5,1,3,2,1,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (6,2,3,1,1,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (7,3,3,1,1,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_puestos` ENABLE KEYS */;


--
-- Definition of table `master_tipo_aula`
--

DROP TABLE IF EXISTS `master_tipo_aula`;
CREATE TABLE `master_tipo_aula` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aula` varchar(50) NOT NULL,
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
INSERT INTO `master_tipo_aula` (`id`,`aula`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
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
  `id_perfil` tinyint(1) NOT NULL DEFAULT 1,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `username_ldap` varchar(45) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `direccion` int(10) unsigned NOT NULL DEFAULT 0,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-10-08 00:00:00',
  `au_usu_alta` varchar(50) NOT NULL DEFAULT 'BBDD',
  `au_proc_alta` varchar(50) NOT NULL DEFAULT 'A mano',
  `au_fec_modif` datetime DEFAULT NULL,
  `au_usu_modif` varchar(50) DEFAULT NULL,
  `au_proc_modif` varchar(50) DEFAULT NULL,
  `au_lock` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_usuarios`
--

/*!40000 ALTER TABLE `master_usuarios` DISABLE KEYS */;
INSERT INTO `master_usuarios` (`id`,`id_perfil`,`nombre`,`apellidos`,`dni`,`username`,`password`,`username_ldap`,`email`,`direccion`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,1,'Guillermo','González Martínez','03114191Z','guillermo.gonzalezm','guille75','guillermo.gonzalezm','guillermo.gonzalezm@edu.uah.es',0,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,0),
 (6,1,'Pablo','García García',NULL,'pablo.ggarcia','$2y$10$qu2g1WqEN45PMw/iX6BGPuh5UZa4/Q0NScGCqGraXsDgZdD0hSNke',NULL,'pablo.ggarcia@edu.uah.es',0,'2022-11-11 20:16:47','BBDD','Web',NULL,NULL,NULL,0,1),
 (7,1,'Guillermo','González Martínez',NULL,'guille','$2y$10$CTWpSbVvLa.P9c8/RAWVg.mqAczwwvT1oIKfmzwZ57CuVJz5HimEW',NULL,'guillermo.gonzalezm@edu.uah.es',0,'2022-11-12 12:42:29','BBDD','Web',NULL,NULL,NULL,0,1),
 (8,1,'Periko','de los palotes',NULL,'Periko','$2y$10$QFz/BvcK7dKUTSHDydcIuOs0jadi025NDOPAPm2AfuzXJtskVgFxC',NULL,'guille.willy.1975@gmail.com',0,'2022-11-12 13:12:51','BBDD','Web',NULL,NULL,NULL,0,1);
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
  `id_usuario` int(10) unsigned NOT NULL,
  `id_franja_horaria` int(10) unsigned NOT NULL,
  `fecha` datetime NOT NULL DEFAULT '2022-10-12 00:00:00',
  `id_puesto` int(10) unsigned NOT NULL,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-10-08 00:00:00',
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservas`
--

/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
INSERT INTO `reservas` (`id`,`id_usuario`,`id_franja_horaria`,`fecha`,`id_puesto`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,7,11,'2022-11-12 00:00:00',5,'2022-11-12 16:00:00','7','A mano',NULL,NULL,NULL,0,1),
 (2,7,11,'2022-11-12 00:00:00',6,'2022-11-12 16:00:00','7','A mano',NULL,NULL,NULL,0,1),
 (3,7,11,'2022-11-12 00:00:00',7,'2022-11-12 16:00:00','7','A mano',NULL,NULL,NULL,0,1);
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
