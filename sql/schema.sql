-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: edulecto
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividad` (
  `id_actividad` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('crucigrama','ordenar_palabras','sopa_letras','adivinanza') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` tinyint unsigned NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  `id_docente_creador` int unsigned NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_actividad`),
  KEY `fk_actividad_docente` (`id_docente_creador`),
  CONSTRAINT `fk_actividad_docente` FOREIGN KEY (`id_docente_creador`) REFERENCES `docente` (`id_docente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calificacion_clase`
--

DROP TABLE IF EXISTS `calificacion_clase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calificacion_clase` (
  `id_calificacion` int unsigned NOT NULL AUTO_INCREMENT,
  `id_clase` int unsigned NOT NULL,
  `id_estudiante` int unsigned NOT NULL,
  `estrellas` tinyint unsigned NOT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_calificacion`),
  KEY `fk_cc_clase` (`id_clase`),
  KEY `fk_cc_estudiante` (`id_estudiante`),
  CONSTRAINT `fk_cc_clase` FOREIGN KEY (`id_clase`) REFERENCES `clase` (`id_clase`) ON DELETE CASCADE,
  CONSTRAINT `fk_cc_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE,
  CONSTRAINT `chk_estrellas` CHECK ((`estrellas` between 1 and 5))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificacion_clase`
--

LOCK TABLES `calificacion_clase` WRITE;
/*!40000 ALTER TABLE `calificacion_clase` DISABLE KEYS */;
/*!40000 ALTER TABLE `calificacion_clase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clase`
--

DROP TABLE IF EXISTS `clase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clase` (
  `id_clase` int unsigned NOT NULL AUTO_INCREMENT,
  `id_docente` int unsigned NOT NULL,
  `tema` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` enum('futura','hoy','pasada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'futura',
  PRIMARY KEY (`id_clase`),
  KEY `fk_clase_docente` (`id_docente`),
  CONSTRAINT `fk_clase_docente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clase`
--

LOCK TABLES `clase` WRITE;
/*!40000 ALTER TABLE `clase` DISABLE KEYS */;
/*!40000 ALTER TABLE `clase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clase_estudiante`
--

DROP TABLE IF EXISTS `clase_estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clase_estudiante` (
  `id_clase` int unsigned NOT NULL,
  `id_estudiante` int unsigned NOT NULL,
  `asistio` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_clase`,`id_estudiante`),
  KEY `fk_ce_estudiante` (`id_estudiante`),
  CONSTRAINT `fk_ce_clase` FOREIGN KEY (`id_clase`) REFERENCES `clase` (`id_clase`) ON DELETE CASCADE,
  CONSTRAINT `fk_ce_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clase_estudiante`
--

LOCK TABLES `clase_estudiante` WRITE;
/*!40000 ALTER TABLE `clase_estudiante` DISABLE KEYS */;
/*!40000 ALTER TABLE `clase_estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostico`
--

DROP TABLE IF EXISTS `diagnostico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagnostico` (
  `id_diagnostico` int unsigned NOT NULL AUTO_INCREMENT,
  `id_estudiante` int unsigned NOT NULL,
  `tipo` enum('inicial','final') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel_resultado` tinyint unsigned NOT NULL,
  `puntaje` decimal(5,2) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_diagnostico`),
  KEY `fk_diagnostico_estudiante` (`id_estudiante`),
  CONSTRAINT `fk_diagnostico_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostico`
--

LOCK TABLES `diagnostico` WRITE;
/*!40000 ALTER TABLE `diagnostico` DISABLE KEYS */;
/*!40000 ALTER TABLE `diagnostico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docente`
--

DROP TABLE IF EXISTS `docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docente` (
  `id_docente` int unsigned NOT NULL,
  `especialidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_docente`),
  CONSTRAINT `fk_docente_usuario` FOREIGN KEY (`id_docente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docente`
--

LOCK TABLES `docente` WRITE;
/*!40000 ALTER TABLE `docente` DISABLE KEYS */;
/*!40000 ALTER TABLE `docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante`
--

DROP TABLE IF EXISTS `estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiante` (
  `id_estudiante` int unsigned NOT NULL,
  `edad` tinyint unsigned NOT NULL,
  `nivel_actual` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_estudiante`),
  CONSTRAINT `fk_estudiante_usuario` FOREIGN KEY (`id_estudiante`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante_insignia`
--

DROP TABLE IF EXISTS `estudiante_insignia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiante_insignia` (
  `id_estudiante` int unsigned NOT NULL,
  `id_insignia` int unsigned NOT NULL,
  `fecha_obtencion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_estudiante`,`id_insignia`),
  KEY `fk_ei_insignia` (`id_insignia`),
  CONSTRAINT `fk_ei_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE,
  CONSTRAINT `fk_ei_insignia` FOREIGN KEY (`id_insignia`) REFERENCES `insignia` (`id_insignia`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante_insignia`
--

LOCK TABLES `estudiante_insignia` WRITE;
/*!40000 ALTER TABLE `estudiante_insignia` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiante_insignia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante_tutor`
--

DROP TABLE IF EXISTS `estudiante_tutor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiante_tutor` (
  `id_estudiante` int unsigned NOT NULL,
  `id_tutor` int unsigned NOT NULL,
  PRIMARY KEY (`id_estudiante`,`id_tutor`),
  KEY `fk_et_tutor` (`id_tutor`),
  CONSTRAINT `fk_et_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE,
  CONSTRAINT `fk_et_tutor` FOREIGN KEY (`id_tutor`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante_tutor`
--

LOCK TABLES `estudiante_tutor` WRITE;
/*!40000 ALTER TABLE `estudiante_tutor` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiante_tutor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insignia`
--

DROP TABLE IF EXISTS `insignia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `insignia` (
  `id_insignia` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icono_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_insignia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insignia`
--

LOCK TABLES `insignia` WRITE;
/*!40000 ALTER TABLE `insignia` DISABLE KEYS */;
/*!40000 ALTER TABLE `insignia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `intento_foro`
--

DROP TABLE IF EXISTS `intento_foro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `intento_foro` (
  `id_intento` int unsigned NOT NULL AUTO_INCREMENT,
  `id_pregunta` int unsigned NOT NULL,
  `id_estudiante` int unsigned NOT NULL,
  `respuesta_dada` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correcta` tinyint(1) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_intento`),
  KEY `fk_if_pregunta` (`id_pregunta`),
  KEY `fk_if_estudiante` (`id_estudiante`),
  CONSTRAINT `fk_if_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE,
  CONSTRAINT `fk_if_pregunta` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta_foro` (`id_pregunta`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intento_foro`
--

LOCK TABLES `intento_foro` WRITE;
/*!40000 ALTER TABLE `intento_foro` DISABLE KEYS */;
/*!40000 ALTER TABLE `intento_foro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificacion`
--

DROP TABLE IF EXISTS `notificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificacion` (
  `id_notificacion` int unsigned NOT NULL AUTO_INCREMENT,
  `id_clase` int unsigned DEFAULT NULL,
  `id_usuario` int unsigned NOT NULL,
  `mensaje` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enviado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_envio` datetime DEFAULT NULL,
  PRIMARY KEY (`id_notificacion`),
  KEY `fk_notif_clase` (`id_clase`),
  KEY `fk_notif_usuario` (`id_usuario`),
  CONSTRAINT `fk_notif_clase` FOREIGN KEY (`id_clase`) REFERENCES `clase` (`id_clase`) ON DELETE SET NULL,
  CONSTRAINT `fk_notif_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificacion`
--

LOCK TABLES `notificacion` WRITE;
/*!40000 ALTER TABLE `notificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pregunta_foro`
--

DROP TABLE IF EXISTS `pregunta_foro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pregunta_foro` (
  `id_pregunta` int unsigned NOT NULL AUTO_INCREMENT,
  `dibujo_emoji` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respuesta_correcta` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_docente_creador` int unsigned NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id_pregunta`),
  KEY `fk_pf_docente` (`id_docente_creador`),
  CONSTRAINT `fk_pf_docente` FOREIGN KEY (`id_docente_creador`) REFERENCES `docente` (`id_docente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregunta_foro`
--

LOCK TABLES `pregunta_foro` WRITE;
/*!40000 ALTER TABLE `pregunta_foro` DISABLE KEYS */;
/*!40000 ALTER TABLE `pregunta_foro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `progreso_actividad`
--

DROP TABLE IF EXISTS `progreso_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `progreso_actividad` (
  `id_progreso` int unsigned NOT NULL AUTO_INCREMENT,
  `id_estudiante` int unsigned NOT NULL,
  `id_actividad` int unsigned NOT NULL,
  `puntaje` tinyint unsigned NOT NULL DEFAULT '0',
  `intentos` tinyint unsigned NOT NULL DEFAULT '0',
  `completado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_progreso`),
  UNIQUE KEY `uq_progreso` (`id_estudiante`,`id_actividad`),
  KEY `fk_progreso_actividad` (`id_actividad`),
  CONSTRAINT `fk_progreso_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`) ON DELETE CASCADE,
  CONSTRAINT `fk_progreso_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE,
  CONSTRAINT `chk_puntaje` CHECK ((`puntaje` between 0 and 100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `progreso_actividad`
--

LOCK TABLES `progreso_actividad` WRITE;
/*!40000 ALTER TABLE `progreso_actividad` DISABLE KEYS */;
/*!40000 ALTER TABLE `progreso_actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `racha`
--

DROP TABLE IF EXISTS `racha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `racha` (
  `id_estudiante` int unsigned NOT NULL,
  `racha_actual` smallint unsigned NOT NULL DEFAULT '0',
  `racha_maxima` smallint unsigned NOT NULL DEFAULT '0',
  `ultima_fecha_actividad` date DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`),
  CONSTRAINT `fk_racha_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `racha`
--

LOCK TABLES `racha` WRITE;
/*!40000 ALTER TABLE `racha` DISABLE KEYS */;
/*!40000 ALTER TABLE `racha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasena_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_usuario` enum('estudiante','docente','tutor') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-23 16:36:28
