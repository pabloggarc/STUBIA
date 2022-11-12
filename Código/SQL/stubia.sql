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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para guardar los accesos de los usuarios a la app';

--
-- Dumping data for table `accesos_usuarios`
--

/*!40000 ALTER TABLE `accesos_usuarios` DISABLE KEYS */;
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
  `au_lock` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='Tabla para guardar los estados de los puestos';

--
-- Dumping data for table `estados`
--

/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` (`id`,`aula`,`puesto`,`estado`,`au_fec_alta`,`au_lock`,`activo`) VALUES 
 (1,1,1,1,'2022-10-08 00:00:00',0,1),
 (2,1,1,1,'2022-10-08 00:00:00',0,1),
 (3,1,1,1,'2022-11-10 17:41:01',0,1),
 (4,1,1,1,'2022-11-10 17:42:01',0,1),
 (5,1,1,1,'2022-11-10 17:42:18',0,1),
 (6,1,1,1,'2022-11-10 17:42:19',0,1),
 (7,1,1,1,'2022-11-10 17:43:18',0,1),
 (8,1,2,2,'2022-11-10 17:43:25',0,1),
 (9,1,1,2,'2022-11-10 17:44:04',0,1),
 (10,3,1,2,'2022-11-10 23:19:27',0,1),
 (11,1,1,1,'2022-11-11 12:54:20',0,1);
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;


--
-- Definition of table `master_aulas`
--

DROP TABLE IF EXISTS `master_aulas`;
CREATE TABLE `master_aulas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_aulas`
--

/*!40000 ALTER TABLE `master_aulas` DISABLE KEYS */;
INSERT INTO `master_aulas` (`id`,`nombre`,`aforo`,`id_tipo_puestos`,`lado_puerta`,`id_bloque`,`planta`,`divisiones_aula`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,'SA6',60,1,'Derecha',4,1,2,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,'NL11',30,2,'Derecha',2,2,1,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (3,'Biblioteca',50,2,'Derecha',4,2,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (4,'Zona común',6,2,'Izquierda',2,2,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_estados`
--

/*!40000 ALTER TABLE `master_estados` DISABLE KEYS */;
INSERT INTO `master_estados` (`id`,`estado`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,'Ocupado','2022-10-14 16:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,'Libre','2022-10-14 16:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_estados` ENABLE KEYS */;


--
-- Definition of table `master_franjas_horarias`
--

DROP TABLE IF EXISTS `master_franjas_horarias`;
CREATE TABLE `master_franjas_horarias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `franja` varchar(50) NOT NULL,
  `au_fec_alta` datetime NOT NULL DEFAULT '2022-11-06 00:00:00',
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
-- Dumping data for table `master_franjas_horarias`
--

/*!40000 ALTER TABLE `master_franjas_horarias` DISABLE KEYS */;
INSERT INTO `master_franjas_horarias` (`id`,`franja`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,'8:00-9:00','2022-11-06 00:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,'9:00-10:00','2022-11-06 00:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (3,'10:00-11:00','2022-11-06 00:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_franjas_horarias` ENABLE KEYS */;


--
-- Definition of table `master_puestos`
--

DROP TABLE IF EXISTS `master_puestos`;
CREATE TABLE `master_puestos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_puestos`
--

/*!40000 ALTER TABLE `master_puestos` DISABLE KEYS */;
INSERT INTO `master_puestos` (`id`,`id_aula`,`ìd_tipo`,`fila`,`columna`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,2,2,1,1,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (2,2,2,1,2,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (3,2,2,1,3,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (4,2,2,1,4,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (5,3,2,1,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (6,1,1,1,1,'2022-11-06 14:00:00','BBDD','A mano',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_puestos` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_usuarios`
--

/*!40000 ALTER TABLE `master_usuarios` DISABLE KEYS */;
INSERT INTO `master_usuarios` (`id`,`id_perfil`,`nombre`,`apellidos`,`dni`,`username`,`password`,`username_ldap`,`email`,`direccion`,`au_fec_alta`,`au_usu_alta`,`au_proc_alta`,`au_fec_modif`,`au_usu_modif`,`au_proc_modif`,`au_lock`,`activo`) VALUES 
 (1,1,'Guillermo','González Martínez','03114191Z','guillermo.gonzalezm','guille75','guillermo.gonzalezm','guillermo.gonzalezm@edu.uah.es',0,'2022-10-09 10:00:00','BBDD','A mano',NULL,NULL,NULL,0,1),
 (6,1,'Pablo','García García',NULL,'pablo.ggarcia','$2y$10$qu2g1WqEN45PMw/iX6BGPuh5UZa4/Q0NScGCqGraXsDgZdD0hSNke',NULL,'pablo.ggarcia@edu.uah.es',0,'2022-11-11 20:16:47','BBDD','Web',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `master_usuarios` ENABLE KEYS */;


--
-- Definition of table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `id_franja_horaria` int(10) unsigned NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservas`
--

/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
