-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: MuseoTanques
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `batallas`
--

DROP TABLE IF EXISTS `batallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `batallas` (
  `id_batalla` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `nombre_batalla` varchar(100) DEFAULT NULL,
  `lugar_batalla` varchar(100) DEFAULT NULL,
  `descripcion_batalla` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_batalla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `batallas`
--

LOCK TABLES `batallas` WRITE;
/*!40000 ALTER TABLE `batallas` DISABLE KEYS */;
INSERT INTO `batallas` VALUES (9901,'1991-01-17','Guerra del Golfo','Kuwait','Liberacion de Kuwait'),(9902,'2003-03-20','Invasion de Irak','Bagdad','Operacion militar en Irak'),(9903,'2014-07-08','Conflicto en Gaza','Gaza','Operacion Margen Protector'),(9904,'1973-10-06','Guerra del Yom Kipur','Sinai','Conflicto entre Israel y Egipto'),(9905,'1999-03-24','Conflicto de Kosovo','Kosovo','Intervencion de la OTAN'),(9906,'2008-08-08','Guerra en Georgia','Osetia del Sur','Conflicto ruso-georgiano'),(9907,'1982-06-06','Guerra del Libano','Beirut','Invasion israeli en Libano'),(9908,'1995-07-11','Srebrenica','Bosnia','Masacre en Bosnia'),(9909,'2022-02-24','Conflicto en Ucrania','Donbas','Operacion militar en Ucrania'),(9910,'2006-07-12','Segunda Guerra del Libano','Libano','Conflicto israeli-libanes'),(9911,'1989-12-20','Invasion de Panama','Panama','Operacion Causa Justa'),(9912,'1994-04-06','Genocidio de Ruanda','Ruanda','Conflicto en Ruanda'),(9913,'2020-11-09','Guerra en Nagorno-Karabaj','Nagorno-Karabaj','Conflicto armenio-azerbaiyano'),(9914,'1950-06-25','Guerra de Corea','Peninsula Coreana','Conflicto entre Corea del Norte y del Sur'),(9915,'1979-12-27','Guerra de Afganistan','Afganistan','Intervencion sovietica');
/*!40000 ALTER TABLE `batallas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especificaciones`
--

DROP TABLE IF EXISTS `especificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especificaciones` (
  `id_tanque` int(11) NOT NULL,
  `peso_toneladas` float DEFAULT NULL,
  `longitud_metros` float DEFAULT NULL,
  `blindaje_mm` int(11) DEFAULT NULL,
  `velocidad_kmh` float DEFAULT NULL,
  `armamento_principal` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_tanque`),
  CONSTRAINT `especificaciones_ibfk_1` FOREIGN KEY (`id_tanque`) REFERENCES `tanques` (`id_tanque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especificaciones`
--

LOCK TABLES `especificaciones` WRITE;
/*!40000 ALTER TABLE `especificaciones` DISABLE KEYS */;
INSERT INTO `especificaciones` VALUES (4390,61.4,9.7,300,67.2,'Canon M256 de 120 mm'),(4391,46.5,9.6,250,60,'Canon 2A46M-5 de 125 mm'),(4392,62.3,9.97,350,72,'Canon Rheinmetall L/55 de 120 mm'),(4393,62.5,8.3,400,56,'Canon L30A1 de 120 mm'),(4394,57.4,9.8,400,71,'Canon GIAT CN120-26 de 120 mm'),(4395,44,9.4,300,70,'Canon L/44 de 120 mm'),(4396,54,10.3,350,80,'Canon ZPT-98 de 125 mm'),(4397,58.5,10.2,400,58,'Canon Rheinmetall L/44 de 120 mm'),(4398,65,9.04,420,64,'Canon MG253 de 120 mm'),(4399,46.2,9.54,300,55,'Canon EC-105 de 120 mm'),(4400,54.5,8.2,400,60,'Canon L7A3 de 105 mm'),(4401,15.2,6.57,150,120,'Canon Bushmaster II de 25 mm'),(4402,55.15,9.89,360,65,'Canon L7A3 de 105 mm'),(4403,54,7.6,350,70,'Canon OTO Breda 120 mm'),(4404,60,10.1,400,65,'Canon Rheinmetall L/55 de 120 mm');
/*!40000 ALTER TABLE `especificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `fecha_in` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `nombre_evento` varchar(100) DEFAULT NULL,
  `descripcion_evento` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (6601,'2023-03-12 06:00:00','2023-03-12 09:30:00','Presentacion Abrams','Introduccion del tanque Abrams'),(6602,'2022-11-15 10:30:00','2022-11-15 13:00:00','Demostracion T-90A','Demostracion en vivo del T-90A'),(6603,'2021-07-04 13:30:00','2021-07-04 15:00:00','Historia del Leopard','Charla historica sobre el Leopard 2'),(6604,'2023-05-20 15:30:00','2023-05-20 17:00:00','Tecnologias del Challenger 2','Evento sobre innovaciones britanicas'),(6605,'2020-10-01 17:30:00','2020-10-01 19:30:00','Linea de tiempo AMX-56','Evolucion del tanque Leclerc'),(6606,'2023-01-12 06:00:00','2023-01-12 09:30:00','Futuro del Type 10','Panel sobre vehiculos blindados japoneses'),(6607,'2022-12-25 10:30:00','2022-12-25 15:00:00','Equipos del ZTZ-99','Exhibicion de nuevas capacidades'),(6608,'2021-05-10 15:30:00','2021-05-10 17:00:00','Impacto del Arjun Mk II','Estudio sobre su despliegue'),(6609,'2023-09-17 17:30:00','2023-09-17 19:30:00','Merkava y defensa','Defensa nacional israeli'),(6610,'2021-04-03 06:00:00','2021-04-03 09:30:00','Osorio en Sudamerica','Historia y legado del Osorio'),(6611,'2022-08-29 10:30:00','2022-08-29 13:30:00','Olifant y conflictos','Impacto en conflictos africanos'),(6612,'2023-06-11 13:30:00','2023-06-11 15:00:00','Estrategias ASLAV','Uso tactico del tanque ASLAV'),(6613,'2023-02-14 15:30:00','2023-02-14 17:00:00','Leopard C2 en accion','Historia operativa canadiense'),(6614,'2020-09-05 17:30:00','2020-09-05 19:30:00','Innovaciones del Ariete','Progreso italiano en blindados'),(6615,'2023-03-30 06:00:00','2023-03-30 09:30:00','Altay en la region','Presentacion del Altay en Turquia');
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exhibicion_evento`
--

DROP TABLE IF EXISTS `exhibicion_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exhibicion_evento` (
  `id_EVEX` int(11) NOT NULL,
  `id_exhibicion` int(11) DEFAULT NULL,
  `id_evento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_EVEX`),
  KEY `id_exhibicion` (`id_exhibicion`),
  KEY `id_evento` (`id_evento`),
  CONSTRAINT `exhibicion_evento_ibfk_1` FOREIGN KEY (`id_exhibicion`) REFERENCES `exhibiciones` (`id_exhibicion`),
  CONSTRAINT `exhibicion_evento_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exhibicion_evento`
--

LOCK TABLES `exhibicion_evento` WRITE;
/*!40000 ALTER TABLE `exhibicion_evento` DISABLE KEYS */;
INSERT INTO `exhibicion_evento` VALUES (1,5501,6601),(2,5502,6602),(3,5503,6603),(4,5504,6604),(5,5505,6605),(6,5506,6606),(7,5507,6607),(8,5508,6608),(9,5509,6609),(10,5510,6610),(11,5511,6611),(12,5512,6612),(13,5513,6613),(14,5514,6614),(15,5515,6615);
/*!40000 ALTER TABLE `exhibicion_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exhibiciones`
--

DROP TABLE IF EXISTS `exhibiciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exhibiciones` (
  `id_exhibicion` int(11) NOT NULL,
  `fecha_exhibicion` date DEFAULT NULL,
  `lugar_exhibicion` varchar(100) DEFAULT NULL,
  `descripcion_exhibicion` varchar(255) DEFAULT NULL,
  `id_tanque` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_exhibicion`),
  KEY `id_tanque` (`id_tanque`),
  CONSTRAINT `exhibiciones_ibfk_1` FOREIGN KEY (`id_tanque`) REFERENCES `tanques` (`id_tanque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exhibiciones`
--

LOCK TABLES `exhibiciones` WRITE;
/*!40000 ALTER TABLE `exhibiciones` DISABLE KEYS */;
INSERT INTO `exhibiciones` VALUES (5501,'2023-03-12','Museo Nacional','Exhibicion de tanques modernos',4390),(5502,'2022-11-15','Parque Central','Evento de tecnologia militar',4391),(5503,'2021-07-04','Base Militar Alfa','Exhibicion historica',4392),(5504,'2023-05-20','Expo Militar 2023','Nuevas tecnologias',4393),(5505,'2020-10-01','Museo de Historia','Tanques clasicos',4394),(5506,'2023-01-12','Expo Asia','Vehiculos blindados',4395),(5507,'2022-12-25','Plaza Roja','Equipamiento militar',4396),(5508,'2021-05-10','Expo Defensa','Innovacion militar',4397),(5509,'2023-09-17','Base Delta','Tecnologia israeli',4398),(5510,'2021-04-03','Museo Sudamericano','Historia y guerra',4399),(5511,'2022-08-29','Base Bravo','Evento de vehiculos',4400),(5512,'2023-06-11','Expo Oceanica','Fuerzas especiales',4401),(5513,'2023-02-14','Plaza Militar','Tanques canadienses',4402),(5514,'2020-09-05','Expo Europa','Vehiculos pesados',4403),(5515,'2023-03-30','Expo Turquia','Nuevos desarrollos',4404);
/*!40000 ALTER TABLE `exhibiciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantenimiento_personal`
--

DROP TABLE IF EXISTS `mantenimiento_personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantenimiento_personal` (
  `id_MP` int(11) NOT NULL,
  `id_mantenimiento` int(11) DEFAULT NULL,
  `id_personal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_MP`),
  KEY `id_mantenimiento` (`id_mantenimiento`),
  KEY `id_personal` (`id_personal`),
  CONSTRAINT `mantenimiento_personal_ibfk_1` FOREIGN KEY (`id_mantenimiento`) REFERENCES `mantenimientos` (`id_mantenimiento`),
  CONSTRAINT `mantenimiento_personal_ibfk_2` FOREIGN KEY (`id_personal`) REFERENCES `personal` (`id_personal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimiento_personal`
--

LOCK TABLES `mantenimiento_personal` WRITE;
/*!40000 ALTER TABLE `mantenimiento_personal` DISABLE KEYS */;
INSERT INTO `mantenimiento_personal` VALUES (1,8801,7701),(2,8802,7702),(3,8803,7703),(4,8804,7704),(5,8805,7705),(6,8806,7706),(7,8807,7707),(8,8808,7708),(9,8809,7709),(10,8810,7710),(11,8811,7711),(12,8812,7712),(13,8813,7713),(14,8814,7714),(15,8815,7715);
/*!40000 ALTER TABLE `mantenimiento_personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantenimientos`
--

DROP TABLE IF EXISTS `mantenimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantenimientos` (
  `id_mantenimiento` int(11) NOT NULL,
  `id_tanque` int(11) DEFAULT NULL,
  `fecha_mantenimiento` datetime DEFAULT NULL,
  `tipo_mantenimiento` varchar(100) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mantenimiento`),
  KEY `id_tanque` (`id_tanque`),
  CONSTRAINT `mantenimientos_ibfk_1` FOREIGN KEY (`id_tanque`) REFERENCES `tanques` (`id_tanque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimientos`
--

LOCK TABLES `mantenimientos` WRITE;
/*!40000 ALTER TABLE `mantenimientos` DISABLE KEYS */;
INSERT INTO `mantenimientos` VALUES (8801,4390,'2023-03-01 09:00:00','Preventivo','Revisar sistema de propulsion'),(8802,4391,'2023-01-15 10:00:00','Correctivo','Reparar blindaje lateral'),(8803,4392,'2022-12-20 11:00:00','Preventivo','Actualizar software de disparo'),(8804,4393,'2023-02-05 12:00:00','Correctivo','Ajustar suspension delantera'),(8805,4394,'2023-04-10 13:00:00','Preventivo','Verificar sistema de combustible'),(8806,4395,'2022-11-25 14:00:00','Correctivo','Sustituir visor optico'),(8807,4396,'2023-06-18 15:00:00','Preventivo','Limpiar canon principal'),(8808,4397,'2022-09-14 16:00:00','Correctivo','Reparar oruga izquierda'),(8809,4398,'2023-07-20 17:00:00','Preventivo','Actualizar sensores de tiro'),(8810,4399,'2023-05-03 18:00:00','Correctivo','Reparar sistema hidraulico'),(8811,4400,'2023-03-25 19:00:00','Preventivo','Revisar unidad de mando'),(8812,4401,'2022-08-30 20:00:00','Correctivo','Sustituir bateria principal'),(8813,4402,'2023-01-10 21:00:00','Preventivo','Ajustar frenos'),(8814,4403,'2023-03-17 22:00:00','Correctivo','Cambiar visor nocturno'),(8815,4404,'2023-04-22 23:00:00','Preventivo','Inspeccionar cableado electrico');
/*!40000 ALTER TABLE `mantenimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paises`
--

DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paises` (
  `id_pais` int(11) NOT NULL,
  `nombre_pais` varchar(100) DEFAULT NULL,
  `capital` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paises`
--

LOCK TABLES `paises` WRITE;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` VALUES (1353,'Estados Unidos','Washington DC','America'),(1354,'Rusia','Moscu','Europa'),(1355,'Alemania','Berlin','Europa'),(1356,'Reino Unido','Londres','Europa'),(1357,'Francia','Paris','Europa'),(1358,'Japon','Tokio','Asia'),(1359,'China','Pekin','Asia'),(1360,'India','Nueva Delhi','Asia'),(1361,'Israel','Jerusalen','Asia'),(1362,'Brasil','Brasilia','America'),(1363,'Sudafrica','Pretoria','Africa'),(1364,'Australia','Canberra','Oceania'),(1365,'Canada','Ottawa','America'),(1366,'Italia','Roma','Europa'),(1367,'Turquia','Ankara','Asia');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal` (
  `id_personal` int(11) NOT NULL,
  `nombre_personal` text DEFAULT NULL,
  `puesto` text DEFAULT NULL,
  `num_tel` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_personal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
INSERT INTO `personal` VALUES (7701,'John Carter','Mecanico',123456789),(7702,'Dmitri Ivanov','Ingeniero',987654321),(7703,'Hans Schmidt','Conductor',112233445),(7704,'James Davies','Artillero',556677889),(7705,'Pierre Dupont','Comandante',998877665),(7706,'Hiroshi Tanaka','Tecnico',667788990),(7707,'Wei Zhang','Instructor',334455667),(7708,'Raj Patel','Mecanico',778899001),(7709,'Yossi Cohen','Especialista',445566778),(7710,'Carlos Oliveira','Conductor',223344556),(7711,'Sipho Mbeki','Artillero',667788112),(7712,'Chris Taylor','Tecnico',556677334),(7713,'Justin Trudeau','Comandante',998877001),(7714,'Luigi Rossi','Especialista',334455112),(7715,'Mustafa Kaya','Mecanico',112233990);
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tanques`
--

DROP TABLE IF EXISTS `tanques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tanques` (
  `id_tanque` int(11) NOT NULL,
  `modelo` text DEFAULT NULL,
  `nombre_tanque` text DEFAULT NULL,
  `tipo_tanque` text DEFAULT NULL,
  `anio_fabricacion` int(11) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_tanque`),
  KEY `id_pais` (`id_pais`),
  CONSTRAINT `tanques_ibfk_1` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tanques`
--

LOCK TABLES `tanques` WRITE;
/*!40000 ALTER TABLE `tanques` DISABLE KEYS */;
INSERT INTO `tanques` VALUES (4390,'M1 Abrams','Abrams','Tanque de batalla principal',1980,1353),(4391,'T-90','T-90A','Tanque de batalla principal',1992,1354),(4392,'Leopard 2','Leopard','Tanque de batalla principal',1979,1355),(4393,'Challenger 2','Challenger','Tanque de batalla principal',1994,1356),(4394,'AMX-56','Leclerc','Tanque de batalla principal',1992,1357),(4395,'Type 10','TK-X','Tanque de batalla principal',2012,1358),(4396,'ZTZ-99','Tipo 99','Tanque de batalla principal',2001,1359),(4397,'Arjun Mk II','Arjun','Tanque de batalla principal',2010,1360),(4398,'Merkava','Merkava Mk IV','Tanque de batalla principal',2004,1361),(4399,'EE-T1','Osorio','Tanque de batalla principal',1985,1362),(4400,'Olifant','Olifant Mk1B','Tanque de batalla principal',1991,1363),(4401,'ASLAV','ASLAV-PC','Tanque ligero',1995,1364),(4402,'Leopard C2','Leopard C2','Tanque de batalla principal',1996,1365),(4403,'Ariete','C1 Ariete','Tanque de batalla principal',1995,1366),(4404,'Altay','Altay','Tanque de batalla principal',2018,1367);
/*!40000 ALTER TABLE `tanques` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_insert_tanques
AFTER INSERT
ON tanques FOR EACH ROW
BEGIN
    INSERT INTO mantenimientos (id_mantenimiento, id_tanque, fecha_mantenimiento, tipo_mantenimiento, notas)
    VALUES (NEW.id_tanque * 100, NEW.id_tanque, NOW(), 'Preventivo', 'Mantenimiento inicial');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tanques_batallas`
--

DROP TABLE IF EXISTS `tanques_batallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tanques_batallas` (
  `id_TB` int(11) NOT NULL,
  `id_tanque` int(11) DEFAULT NULL,
  `id_batalla` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_TB`),
  KEY `id_tanque` (`id_tanque`),
  KEY `id_batalla` (`id_batalla`),
  CONSTRAINT `tanques_batallas_ibfk_1` FOREIGN KEY (`id_tanque`) REFERENCES `tanques` (`id_tanque`),
  CONSTRAINT `tanques_batallas_ibfk_2` FOREIGN KEY (`id_batalla`) REFERENCES `batallas` (`id_batalla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tanques_batallas`
--

LOCK TABLES `tanques_batallas` WRITE;
/*!40000 ALTER TABLE `tanques_batallas` DISABLE KEYS */;
INSERT INTO `tanques_batallas` VALUES (1,4390,9901),(2,4391,9902),(3,4392,9903),(4,4393,9904),(5,4394,9905),(6,4395,9906),(7,4396,9907),(8,4397,9908),(9,4398,9909),(10,4399,9910),(11,4400,9911),(12,4401,9912),(13,4402,9913),(14,4403,9914),(15,4404,9915);
/*!40000 ALTER TABLE `tanques_batallas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vistaexhibicionesyeventos`
--

DROP TABLE IF EXISTS `vistaexhibicionesyeventos`;
/*!50001 DROP VIEW IF EXISTS `vistaexhibicionesyeventos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vistaexhibicionesyeventos` AS SELECT
 1 AS `id_exhibicion`,
  1 AS `fecha_exhibicion`,
  1 AS `lugar_exhibicion`,
  1 AS `nombre_evento`,
  1 AS `descripcion_evento` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vistatanquesybatallas`
--

DROP TABLE IF EXISTS `vistatanquesybatallas`;
/*!50001 DROP VIEW IF EXISTS `vistatanquesybatallas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vistatanquesybatallas` AS SELECT
 1 AS `nombre_tanque`,
  1 AS `modelo`,
  1 AS `nombre_batalla`,
  1 AS `lugar_batalla`,
  1 AS `fecha` */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vistaexhibicionesyeventos`
--

/*!50001 DROP VIEW IF EXISTS `vistaexhibicionesyeventos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vistaexhibicionesyeventos` AS select `e`.`id_exhibicion` AS `id_exhibicion`,`e`.`fecha_exhibicion` AS `fecha_exhibicion`,`e`.`lugar_exhibicion` AS `lugar_exhibicion`,`ev`.`nombre_evento` AS `nombre_evento`,`ev`.`descripcion_evento` AS `descripcion_evento` from ((`exhibiciones` `e` join `exhibicion_evento` `ee` on(`e`.`id_exhibicion` = `ee`.`id_exhibicion`)) join `eventos` `ev` on(`ee`.`id_evento` = `ev`.`id_evento`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vistatanquesybatallas`
--

/*!50001 DROP VIEW IF EXISTS `vistatanquesybatallas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vistatanquesybatallas` AS select `t`.`nombre_tanque` AS `nombre_tanque`,`t`.`modelo` AS `modelo`,`b`.`nombre_batalla` AS `nombre_batalla`,`b`.`lugar_batalla` AS `lugar_batalla`,`b`.`fecha` AS `fecha` from ((`tanques` `t` join `tanques_batallas` `tb` on(`t`.`id_tanque` = `tb`.`id_tanque`)) join `batallas` `b` on(`tb`.`id_batalla` = `b`.`id_batalla`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-26  9:59:23
