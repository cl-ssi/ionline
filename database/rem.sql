-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         11.4.0-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla rem.2017establecimientos
CREATE TABLE IF NOT EXISTS `2017establecimientos` (
  `id_establecimiento` int(11) NOT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `Codigo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `alias_estab` varchar(255) DEFAULT NULL,
  `comuna` varchar(255) DEFAULT NULL,
  `codigo_comuna` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `meta_san` tinyint(4) DEFAULT NULL,
  `comuna_id_comuna` int(11) NOT NULL,
  PRIMARY KEY (`id_establecimiento`,`comuna_id_comuna`),
  KEY `fk_establecimiento_comuna_idx` (`comuna_id_comuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2017prestaciones
CREATE TABLE IF NOT EXISTS `2017prestaciones` (
  `id_prestacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `Nserie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_prestacion`),
  KEY `SERIE` (`serie`,`codigo_prestacion`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2507 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2017rems
CREATE TABLE IF NOT EXISTS `2017rems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mes` int(11) DEFAULT NULL,
  `IdServicio` varchar(2) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `IdEstablecimiento` varchar(7) DEFAULT NULL,
  `CodigoPrestacion` varchar(50) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `Col01` double DEFAULT NULL,
  `Col02` double DEFAULT NULL,
  `Col03` double DEFAULT NULL,
  `Col04` double DEFAULT NULL,
  `Col05` double DEFAULT NULL,
  `Col06` double DEFAULT NULL,
  `Col07` double DEFAULT NULL,
  `Col08` double DEFAULT NULL,
  `Col09` double DEFAULT NULL,
  `Col10` double DEFAULT NULL,
  `Col11` double DEFAULT NULL,
  `Col12` double DEFAULT NULL,
  `Col13` double DEFAULT NULL,
  `Col14` double DEFAULT NULL,
  `Col15` double DEFAULT NULL,
  `Col16` double DEFAULT NULL,
  `Col17` double DEFAULT NULL,
  `Col18` double DEFAULT NULL,
  `Col19` double DEFAULT NULL,
  `Col20` double DEFAULT NULL,
  `Col21` double DEFAULT NULL,
  `Col22` double DEFAULT NULL,
  `Col23` double DEFAULT NULL,
  `Col24` double DEFAULT NULL,
  `Col25` double DEFAULT NULL,
  `Col26` double DEFAULT NULL,
  `Col27` double DEFAULT NULL,
  `Col28` double DEFAULT NULL,
  `Col29` double DEFAULT NULL,
  `Col30` double DEFAULT NULL,
  `Col31` double DEFAULT NULL,
  `Col32` double DEFAULT NULL,
  `Col33` double DEFAULT NULL,
  `Col34` double DEFAULT NULL,
  `Col35` double DEFAULT NULL,
  `Col36` double DEFAULT NULL,
  `Col37` double DEFAULT NULL,
  `Col38` double DEFAULT NULL,
  `Col39` double DEFAULT NULL,
  `Col40` double DEFAULT NULL,
  `Col41` double DEFAULT NULL,
  `Col42` double DEFAULT NULL,
  `Col43` double DEFAULT NULL,
  `Col44` double DEFAULT NULL,
  `Col45` double DEFAULT NULL,
  `Col46` double DEFAULT NULL,
  `Col47` double DEFAULT NULL,
  `Col48` double DEFAULT NULL,
  `Col49` double DEFAULT NULL,
  `Col50` double DEFAULT NULL,
  `establecimiento_id_establecimiento` int(11) NOT NULL DEFAULT 0,
  `prestacion_id_prestacion` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`establecimiento_id_establecimiento`,`prestacion_id_prestacion`),
  KEY `codigoprestacion` (`CodigoPrestacion`),
  KEY `fk_rem_establecimiento1_idx` (`establecimiento_id_establecimiento`),
  KEY `fk_rem_prestacion1_idx` (`prestacion_id_prestacion`)
) ENGINE=InnoDB AUTO_INCREMENT=82642 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2017secciones
CREATE TABLE IF NOT EXISTS `2017secciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `nserie` varchar(50) NOT NULL,
  `supergroups` text DEFAULT NULL,
  `supergroups_inline` tinyint(1) NOT NULL DEFAULT 0,
  `discard_group` tinyint(1) NOT NULL DEFAULT 0,
  `thead` text DEFAULT NULL,
  `cols` text DEFAULT NULL,
  `cods` text DEFAULT NULL,
  `totals` tinyint(1) NOT NULL DEFAULT 0,
  `totals_by_prestacion` text DEFAULT NULL,
  `totals_by_group` text DEFAULT NULL,
  `totals_first` tinyint(1) NOT NULL DEFAULT 0,
  `subtotals` text DEFAULT NULL,
  `subtotals_first` tinyint(1) NOT NULL DEFAULT 0,
  `tfoot` text DEFAULT NULL,
  `precision` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2018establecimientos
CREATE TABLE IF NOT EXISTS `2018establecimientos` (
  `id_establecimiento` int(11) NOT NULL,
  `servicio_salud` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `Codigo` varchar(255) DEFAULT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `alias_estab` varchar(255) DEFAULT NULL,
  `comuna` varchar(255) DEFAULT NULL,
  `codigo_comuna` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `comges19` tinyint(4) DEFAULT NULL,
  `meta_san` tinyint(4) DEFAULT NULL,
  `meta_san_18834` tinyint(4) DEFAULT NULL,
  `meta_san_18834_hosp` tinyint(4) DEFAULT NULL,
  `comuna_id_comuna` int(11) NOT NULL,
  PRIMARY KEY (`id_establecimiento`,`comuna_id_comuna`),
  KEY `fk_establecimiento_comuna_idx` (`comuna_id_comuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2018prestaciones
CREATE TABLE IF NOT EXISTS `2018prestaciones` (
  `id_prestacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `Nserie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_prestacion`),
  KEY `SERIE` (`serie`,`codigo_prestacion`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4515 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2018rems
CREATE TABLE IF NOT EXISTS `2018rems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mes` int(11) DEFAULT NULL,
  `IdServicio` varchar(2) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `IdEstablecimiento` varchar(7) DEFAULT NULL,
  `CodigoPrestacion` varchar(50) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `Col01` double(11,2) DEFAULT 0.00,
  `Col02` double(11,2) DEFAULT 0.00,
  `Col03` double(11,2) DEFAULT 0.00,
  `Col04` double(11,2) DEFAULT 0.00,
  `Col05` double(11,2) DEFAULT 0.00,
  `Col06` double(11,2) DEFAULT 0.00,
  `Col07` double(11,2) DEFAULT 0.00,
  `Col08` double(11,2) DEFAULT 0.00,
  `Col09` double(11,2) DEFAULT 0.00,
  `Col10` double(11,2) DEFAULT 0.00,
  `Col11` double(11,2) DEFAULT 0.00,
  `Col12` double(11,2) DEFAULT 0.00,
  `Col13` double(11,2) DEFAULT 0.00,
  `Col14` double(11,2) DEFAULT 0.00,
  `Col15` double(11,2) DEFAULT 0.00,
  `Col16` double(11,2) DEFAULT 0.00,
  `Col17` double(11,2) DEFAULT 0.00,
  `Col18` double(11,2) DEFAULT 0.00,
  `Col19` double(11,2) DEFAULT 0.00,
  `Col21` double(11,2) DEFAULT 0.00,
  `Col20` double(11,2) DEFAULT 0.00,
  `Col22` double(11,2) DEFAULT 0.00,
  `Col23` double(11,2) DEFAULT 0.00,
  `Col24` double(11,2) DEFAULT 0.00,
  `Col25` double(11,2) DEFAULT 0.00,
  `Col26` double(11,2) DEFAULT 0.00,
  `Col27` double(11,2) DEFAULT 0.00,
  `Col28` double(11,2) DEFAULT 0.00,
  `Col29` double(11,2) DEFAULT 0.00,
  `Col30` double(11,2) DEFAULT 0.00,
  `Col31` double(11,2) DEFAULT 0.00,
  `Col32` double(11,2) DEFAULT 0.00,
  `Col33` double(11,2) DEFAULT 0.00,
  `Col34` double(11,2) DEFAULT 0.00,
  `Col35` double(11,2) DEFAULT 0.00,
  `Col36` double(11,2) DEFAULT 0.00,
  `Col37` double(11,2) DEFAULT 0.00,
  `Col38` double(11,2) DEFAULT 0.00,
  `Col39` double(11,2) DEFAULT 0.00,
  `Col40` double(11,2) DEFAULT 0.00,
  `Col41` double(11,2) DEFAULT 0.00,
  `Col42` double(11,2) DEFAULT 0.00,
  `Col43` double(11,2) DEFAULT 0.00,
  `Col44` double(11,2) DEFAULT 0.00,
  `Col45` double(11,2) DEFAULT 0.00,
  `Col46` double(11,2) DEFAULT 0.00,
  `Col47` double(11,2) DEFAULT 0.00,
  `Col48` double(11,2) DEFAULT 0.00,
  `Col49` double(11,2) DEFAULT 0.00,
  `Col50` double(11,2) DEFAULT 0.00,
  `establecimiento_id_establecimiento` int(11) NOT NULL DEFAULT 0,
  `prestacion_id_prestacion` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`establecimiento_id_establecimiento`,`prestacion_id_prestacion`),
  KEY `codigoprestacion` (`CodigoPrestacion`),
  KEY `fk_rem_establecimiento1_idx` (`establecimiento_id_establecimiento`),
  KEY `fk_rem_prestacion1_idx` (`prestacion_id_prestacion`)
) ENGINE=InnoDB AUTO_INCREMENT=99870 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2018secciones
CREATE TABLE IF NOT EXISTS `2018secciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `nserie` varchar(50) NOT NULL,
  `supergroups` text DEFAULT NULL,
  `supergroups_inline` tinyint(1) NOT NULL DEFAULT 0,
  `discard_group` tinyint(1) NOT NULL DEFAULT 0,
  `thead` text DEFAULT NULL,
  `cols` text DEFAULT NULL,
  `cods` text DEFAULT NULL,
  `totals` tinyint(1) NOT NULL DEFAULT 0,
  `totals_by_prestacion` text DEFAULT NULL,
  `totals_by_group` text DEFAULT NULL,
  `totals_first` tinyint(1) NOT NULL DEFAULT 0,
  `subtotals` text DEFAULT NULL,
  `subtotals_first` tinyint(1) NOT NULL DEFAULT 0,
  `tfoot` text DEFAULT NULL,
  `precision` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=279 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2019establecimientos
CREATE TABLE IF NOT EXISTS `2019establecimientos` (
  `id_establecimiento` int(11) NOT NULL,
  `servicio_salud` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `Codigo` varchar(255) DEFAULT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `alias_estab` varchar(255) DEFAULT NULL,
  `comuna` varchar(255) DEFAULT NULL,
  `codigo_comuna` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `comges19` tinyint(4) DEFAULT NULL,
  `meta_san` tinyint(4) DEFAULT NULL,
  `meta_san_18834` tinyint(4) DEFAULT NULL,
  `meta_san_18834_hosp` tinyint(4) DEFAULT NULL,
  `p_chcc` tinyint(4) DEFAULT NULL,
  `p_depsev` tinyint(4) DEFAULT NULL,
  `p_equidad_rural` tinyint(4) DEFAULT NULL,
  `comuna_id_comuna` int(11) NOT NULL,
  `p_saserep` tinyint(4) DEFAULT NULL,
  `p_respiratorio` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_establecimiento`,`comuna_id_comuna`),
  KEY `fk_establecimiento_comuna_idx` (`comuna_id_comuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2019prestaciones
CREATE TABLE IF NOT EXISTS `2019prestaciones` (
  `id_prestacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `Nserie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_prestacion`),
  KEY `SERIE` (`serie`,`codigo_prestacion`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13361 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2019rems
CREATE TABLE IF NOT EXISTS `2019rems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mes` int(11) DEFAULT NULL,
  `IdServicio` varchar(2) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `IdEstablecimiento` varchar(7) DEFAULT NULL,
  `CodigoPrestacion` varchar(50) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `Col01` double(11,2) DEFAULT 0.00,
  `Col02` double(11,2) DEFAULT 0.00,
  `Col03` double(11,2) DEFAULT 0.00,
  `Col04` double(11,2) DEFAULT 0.00,
  `Col05` double(11,2) DEFAULT 0.00,
  `Col06` double(11,2) DEFAULT 0.00,
  `Col07` double(11,2) DEFAULT 0.00,
  `Col08` double(11,2) DEFAULT 0.00,
  `Col09` double(11,2) DEFAULT 0.00,
  `Col10` double(11,2) DEFAULT 0.00,
  `Col11` double(11,2) DEFAULT 0.00,
  `Col12` double(11,2) DEFAULT 0.00,
  `Col13` double(11,2) DEFAULT 0.00,
  `Col14` double(11,2) DEFAULT 0.00,
  `Col15` double(11,2) DEFAULT 0.00,
  `Col16` double(11,2) DEFAULT 0.00,
  `Col17` double(11,2) DEFAULT 0.00,
  `Col18` double(11,2) DEFAULT 0.00,
  `Col19` double(11,2) DEFAULT 0.00,
  `Col21` double(11,2) DEFAULT 0.00,
  `Col20` double(11,2) DEFAULT 0.00,
  `Col22` double(11,2) DEFAULT 0.00,
  `Col23` double(11,2) DEFAULT 0.00,
  `Col24` double(11,2) DEFAULT 0.00,
  `Col25` double(11,2) DEFAULT 0.00,
  `Col26` double(11,2) DEFAULT 0.00,
  `Col27` double(11,2) DEFAULT 0.00,
  `Col28` double(11,2) DEFAULT 0.00,
  `Col29` double(11,2) DEFAULT 0.00,
  `Col30` double(11,2) DEFAULT 0.00,
  `Col31` double(11,2) DEFAULT 0.00,
  `Col32` double(11,2) DEFAULT 0.00,
  `Col33` double(11,2) DEFAULT 0.00,
  `Col34` double(11,2) DEFAULT 0.00,
  `Col35` double(11,2) DEFAULT 0.00,
  `Col36` double(11,2) DEFAULT 0.00,
  `Col37` double(11,2) DEFAULT 0.00,
  `Col38` double(11,2) DEFAULT 0.00,
  `Col39` double(11,2) DEFAULT 0.00,
  `Col40` double(11,2) DEFAULT 0.00,
  `Col41` double(11,2) DEFAULT 0.00,
  `Col42` double(11,2) DEFAULT 0.00,
  `Col43` double(11,2) DEFAULT 0.00,
  `Col44` double(11,2) DEFAULT 0.00,
  `Col45` double(11,2) DEFAULT 0.00,
  `Col46` double(11,2) DEFAULT 0.00,
  `Col47` double(11,2) DEFAULT 0.00,
  `Col48` double(11,2) DEFAULT 0.00,
  `Col49` double(11,2) DEFAULT 0.00,
  `Col50` double(11,2) DEFAULT 0.00,
  `establecimiento_id_establecimiento` int(11) NOT NULL DEFAULT 0,
  `prestacion_id_prestacion` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`establecimiento_id_establecimiento`,`prestacion_id_prestacion`),
  KEY `codigoprestacion` (`CodigoPrestacion`),
  KEY `fk_rem_establecimiento1_idx` (`establecimiento_id_establecimiento`),
  KEY `fk_rem_prestacion1_idx` (`prestacion_id_prestacion`),
  KEY `programacion_aps` (`IdEstablecimiento`,`CodigoPrestacion`,`Mes`)
) ENGINE=InnoDB AUTO_INCREMENT=454667 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2020establecimientos
CREATE TABLE IF NOT EXISTS `2020establecimientos` (
  `id_establecimiento` int(11) NOT NULL,
  `servicio_salud` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `Codigo` varchar(255) DEFAULT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `alias_estab` varchar(255) DEFAULT NULL,
  `comuna` varchar(255) DEFAULT NULL,
  `codigo_comuna` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `comges19` tinyint(4) DEFAULT NULL,
  `meta_san` tinyint(4) DEFAULT NULL,
  `meta_san_18834` tinyint(4) DEFAULT NULL,
  `meta_san_18834_hosp` tinyint(4) DEFAULT NULL,
  `p_masama` tinyint(4) DEFAULT NULL,
  `p_chcc` tinyint(4) DEFAULT NULL,
  `p_depsev` tinyint(4) DEFAULT NULL,
  `p_saserep` tinyint(4) DEFAULT NULL,
  `p_ges_odont` tinyint(4) DEFAULT NULL,
  `p_sembrando_sonrisas` tinyint(4) DEFAULT NULL,
  `p_mejor_aten_odont` tinyint(4) DEFAULT NULL,
  `p_odont_integral` tinyint(4) DEFAULT NULL,
  `p_equidad_rural` tinyint(4) DEFAULT NULL,
  `p_respiratorio` tinyint(4) DEFAULT NULL,
  `tablero_poblacion` tinyint(4) DEFAULT NULL,
  `comuna_id_comuna` int(11) NOT NULL,
  PRIMARY KEY (`id_establecimiento`,`comuna_id_comuna`),
  KEY `fk_establecimiento_comuna_idx` (`comuna_id_comuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2020percapita
CREATE TABLE IF NOT EXISTS `2020percapita` (
  `RUN` int(11) NOT NULL,
  `DV` char(1) NOT NULL,
  `NOMBRES` varchar(255) DEFAULT NULL,
  `APELLIDO_PATERNO` varchar(255) DEFAULT NULL,
  `APELLIDO_MATERNO` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `EDAD` int(11) DEFAULT NULL,
  `GENERO` char(1) DEFAULT NULL,
  `TRAMO` char(1) DEFAULT NULL,
  `FECHA_CORTE` date NOT NULL,
  `COD_CENTRO` int(11) NOT NULL,
  `NOMBRE_CENTRO` varchar(255) NOT NULL,
  `CODIGO_CENTRO_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_CENTRO_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_DESTINO` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_DESTINO` varchar(255) DEFAULT NULL,
  `TRASLADO_POSITIVO` enum('X') NOT NULL,
  `TRASLADO_NEGATIVO` enum('X') NOT NULL,
  `NUEVO_INSCRITO` enum('X') NOT NULL,
  `EXBLOQUEADO` enum('X') NOT NULL,
  `RECHAZADO_PREVISIONAL` enum('X') NOT NULL,
  `RECHAZADO_FALLECIDO` enum('X') NOT NULL,
  `AUTORIZADO` enum('X') NOT NULL,
  `ACEPTADO_RECHAZADO` enum('ACEPTADO','RECHAZADO','INGRESO RECHAZO SIMULTÁNEO') NOT NULL,
  `MOTIVO` varchar(128) NOT NULL,
  PRIMARY KEY (`RUN`,`FECHA_CORTE`,`COD_CENTRO`,`ACEPTADO_RECHAZADO`),
  KEY `ACEPTADO_RECHAZADO` (`ACEPTADO_RECHAZADO`),
  KEY `COD_CENTRO` (`COD_CENTRO`),
  KEY `consulta_comunal` (`EDAD`,`FECHA_CORTE`,`AUTORIZADO`,`COD_CENTRO`),
  KEY `FECHA_CORTE` (`FECHA_CORTE`),
  KEY `FECHA_NACIMIENTO` (`FECHA_NACIMIENTO`),
  KEY `indexGenero` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`,`GENERO`),
  KEY `indexquery` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`),
  KEY `Índice 10` (`FECHA_NACIMIENTO`),
  KEY `MOTIVO` (`MOTIVO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2020prestaciones
CREATE TABLE IF NOT EXISTS `2020prestaciones` (
  `id_prestacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `Nserie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_prestacion`),
  KEY `SERIE` (`serie`,`codigo_prestacion`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=70261825 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2020rems
CREATE TABLE IF NOT EXISTS `2020rems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mes` int(11) DEFAULT NULL,
  `IdServicio` varchar(2) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `IdEstablecimiento` varchar(7) DEFAULT NULL,
  `CodigoPrestacion` varchar(50) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `Col01` double(11,2) DEFAULT 0.00,
  `Col02` double(11,2) DEFAULT 0.00,
  `Col03` double(11,2) DEFAULT 0.00,
  `Col04` double(11,2) DEFAULT 0.00,
  `Col05` double(11,2) DEFAULT 0.00,
  `Col06` double(11,2) DEFAULT 0.00,
  `Col07` double(11,2) DEFAULT 0.00,
  `Col08` double(11,2) DEFAULT 0.00,
  `Col09` double(11,2) DEFAULT 0.00,
  `Col10` double(11,2) DEFAULT 0.00,
  `Col11` double(11,2) DEFAULT 0.00,
  `Col12` double(11,2) DEFAULT 0.00,
  `Col13` double(11,2) DEFAULT 0.00,
  `Col14` double(11,2) DEFAULT 0.00,
  `Col15` double(11,2) DEFAULT 0.00,
  `Col16` double(11,2) DEFAULT 0.00,
  `Col17` double(11,2) DEFAULT 0.00,
  `Col18` double(11,2) DEFAULT 0.00,
  `Col19` double(11,2) DEFAULT 0.00,
  `Col21` double(11,2) DEFAULT 0.00,
  `Col20` double(11,2) DEFAULT 0.00,
  `Col22` double(11,2) DEFAULT 0.00,
  `Col23` double(11,2) DEFAULT 0.00,
  `Col24` double(11,2) DEFAULT 0.00,
  `Col25` double(11,2) DEFAULT 0.00,
  `Col26` double(11,2) DEFAULT 0.00,
  `Col27` double(11,2) DEFAULT 0.00,
  `Col28` double(11,2) DEFAULT 0.00,
  `Col29` double(11,2) DEFAULT 0.00,
  `Col30` double(11,2) DEFAULT 0.00,
  `Col31` double(11,2) DEFAULT 0.00,
  `Col32` double(11,2) DEFAULT 0.00,
  `Col33` double(11,2) DEFAULT 0.00,
  `Col34` double(11,2) DEFAULT 0.00,
  `Col35` double(11,2) DEFAULT 0.00,
  `Col36` double(11,2) DEFAULT 0.00,
  `Col37` double(11,2) DEFAULT 0.00,
  `Col38` double(11,2) DEFAULT 0.00,
  `Col39` double(11,2) DEFAULT 0.00,
  `Col40` double(11,2) DEFAULT 0.00,
  `Col41` double(11,2) DEFAULT 0.00,
  `Col42` double(11,2) DEFAULT 0.00,
  `Col43` double(11,2) DEFAULT 0.00,
  `Col44` double(11,2) DEFAULT 0.00,
  `Col45` double(11,2) DEFAULT 0.00,
  `Col46` double(11,2) DEFAULT 0.00,
  `Col47` double(11,2) DEFAULT 0.00,
  `Col48` double(11,2) DEFAULT 0.00,
  `Col49` double(11,2) DEFAULT 0.00,
  `Col50` double(11,2) DEFAULT 0.00,
  `establecimiento_id_establecimiento` int(11) NOT NULL DEFAULT 0,
  `prestacion_id_prestacion` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`establecimiento_id_establecimiento`,`prestacion_id_prestacion`),
  KEY `codigoprestacion` (`CodigoPrestacion`),
  KEY `fk_rem_establecimiento1_idx` (`establecimiento_id_establecimiento`),
  KEY `fk_rem_prestacion1_idx` (`prestacion_id_prestacion`),
  KEY `programacion_aps` (`IdEstablecimiento`,`CodigoPrestacion`,`Mes`)
) ENGINE=InnoDB AUTO_INCREMENT=980349 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2021establecimientos
CREATE TABLE IF NOT EXISTS `2021establecimientos` (
  `id_establecimiento` int(11) NOT NULL,
  `servicio_salud` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `Codigo` varchar(255) DEFAULT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `alias_estab` varchar(255) DEFAULT NULL,
  `comuna` varchar(255) DEFAULT NULL,
  `codigo_comuna` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `comges19` tinyint(4) DEFAULT NULL,
  `meta_san` tinyint(4) DEFAULT NULL,
  `meta_san_18834` tinyint(4) DEFAULT NULL,
  `meta_san_18834_hosp` tinyint(4) DEFAULT NULL,
  `p_masama` tinyint(4) DEFAULT NULL,
  `p_chcc` tinyint(4) DEFAULT NULL,
  `p_depsev` tinyint(4) DEFAULT NULL,
  `p_saserep` tinyint(4) DEFAULT NULL,
  `p_ges_odont` tinyint(4) DEFAULT NULL,
  `p_sembrando_sonrisas` tinyint(4) DEFAULT NULL,
  `p_mejor_aten_odont` tinyint(4) DEFAULT NULL,
  `p_odont_integral` tinyint(4) DEFAULT NULL,
  `p_equidad_rural` tinyint(4) DEFAULT NULL,
  `tablero_poblacion` tinyint(4) DEFAULT NULL,
  `comuna_id_comuna` int(11) NOT NULL,
  PRIMARY KEY (`id_establecimiento`,`comuna_id_comuna`),
  KEY `fk_establecimiento_comuna_idx` (`comuna_id_comuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2021percapita
CREATE TABLE IF NOT EXISTS `2021percapita` (
  `RUN` int(11) NOT NULL,
  `DV` char(1) NOT NULL,
  `NOMBRES` varchar(255) DEFAULT NULL,
  `APELLIDO_PATERNO` varchar(255) DEFAULT NULL,
  `APELLIDO_MATERNO` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `EDAD` int(11) DEFAULT NULL,
  `GENERO` char(1) DEFAULT NULL,
  `TRAMO` char(1) DEFAULT NULL,
  `FECHA_CORTE` date NOT NULL,
  `COD_CENTRO` int(11) NOT NULL,
  `NOMBRE_CENTRO` varchar(255) NOT NULL,
  `CODIGO_CENTRO_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_CENTRO_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_DESTINO` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_DESTINO` varchar(255) DEFAULT NULL,
  `TRASLADO_POSITIVO` enum('X') NOT NULL,
  `TRASLADO_NEGATIVO` enum('X') NOT NULL,
  `NUEVO_INSCRITO` enum('X') NOT NULL,
  `EXBLOQUEADO` enum('X') NOT NULL,
  `RECHAZADO_PREVISIONAL` enum('X') NOT NULL,
  `RECHAZADO_FALLECIDO` enum('X') NOT NULL,
  `AUTORIZADO` enum('X') NOT NULL,
  `ACEPTADO_RECHAZADO` enum('ACEPTADO','RECHAZADO','INGRESO RECHAZO SIMULTÁNEO') NOT NULL,
  `MOTIVO` varchar(128) NOT NULL,
  PRIMARY KEY (`RUN`,`FECHA_CORTE`,`COD_CENTRO`,`ACEPTADO_RECHAZADO`),
  KEY `ACEPTADO_RECHAZADO` (`ACEPTADO_RECHAZADO`),
  KEY `COD_CENTRO` (`COD_CENTRO`),
  KEY `consulta_comunal` (`EDAD`,`FECHA_CORTE`,`AUTORIZADO`,`COD_CENTRO`),
  KEY `FECHA_CORTE` (`FECHA_CORTE`),
  KEY `FECHA_NACIMIENTO` (`FECHA_NACIMIENTO`),
  KEY `indexGenero` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`,`GENERO`),
  KEY `indexquery` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`),
  KEY `Índice 10` (`FECHA_NACIMIENTO`),
  KEY `MOTIVO` (`MOTIVO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2021prestaciones
CREATE TABLE IF NOT EXISTS `2021prestaciones` (
  `id_prestacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `Nserie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_prestacion`),
  KEY `SERIE` (`serie`,`codigo_prestacion`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9279 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2021rems
CREATE TABLE IF NOT EXISTS `2021rems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mes` int(11) DEFAULT NULL,
  `IdServicio` varchar(2) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `IdEstablecimiento` varchar(7) DEFAULT NULL,
  `CodigoPrestacion` varchar(50) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `Col01` double(11,2) DEFAULT 0.00,
  `Col02` double(11,2) DEFAULT 0.00,
  `Col03` double(11,2) DEFAULT 0.00,
  `Col04` double(11,2) DEFAULT 0.00,
  `Col05` double(11,2) DEFAULT 0.00,
  `Col06` double(11,2) DEFAULT 0.00,
  `Col07` double(11,2) DEFAULT 0.00,
  `Col08` double(11,2) DEFAULT 0.00,
  `Col09` double(11,2) DEFAULT 0.00,
  `Col10` double(11,2) DEFAULT 0.00,
  `Col11` double(11,2) DEFAULT 0.00,
  `Col12` double(11,2) DEFAULT 0.00,
  `Col13` double(11,2) DEFAULT 0.00,
  `Col14` double(11,2) DEFAULT 0.00,
  `Col15` double(11,2) DEFAULT 0.00,
  `Col16` double(11,2) DEFAULT 0.00,
  `Col17` double(11,2) DEFAULT 0.00,
  `Col18` double(11,2) DEFAULT 0.00,
  `Col19` double(11,2) DEFAULT 0.00,
  `Col21` double(11,2) DEFAULT 0.00,
  `Col20` double(11,2) DEFAULT 0.00,
  `Col22` double(11,2) DEFAULT 0.00,
  `Col23` double(11,2) DEFAULT 0.00,
  `Col24` double(11,2) DEFAULT 0.00,
  `Col25` double(11,2) DEFAULT 0.00,
  `Col26` double(11,2) DEFAULT 0.00,
  `Col27` double(11,2) DEFAULT 0.00,
  `Col28` double(11,2) DEFAULT 0.00,
  `Col29` double(11,2) DEFAULT 0.00,
  `Col30` double(11,2) DEFAULT 0.00,
  `Col31` double(11,2) DEFAULT 0.00,
  `Col32` double(11,2) DEFAULT 0.00,
  `Col33` double(11,2) DEFAULT 0.00,
  `Col34` double(11,2) DEFAULT 0.00,
  `Col35` double(11,2) DEFAULT 0.00,
  `Col36` double(11,2) DEFAULT 0.00,
  `Col37` double(11,2) DEFAULT 0.00,
  `Col38` double(11,2) DEFAULT 0.00,
  `Col39` double(11,2) DEFAULT 0.00,
  `Col40` double(11,2) DEFAULT 0.00,
  `Col41` double(11,2) DEFAULT 0.00,
  `Col42` double(11,2) DEFAULT 0.00,
  `Col43` double(11,2) DEFAULT 0.00,
  `Col44` double(11,2) DEFAULT 0.00,
  `Col45` double(11,2) DEFAULT 0.00,
  `Col46` double(11,2) DEFAULT 0.00,
  `Col47` double(11,2) DEFAULT 0.00,
  `Col48` double(11,2) DEFAULT 0.00,
  `Col49` double(11,2) DEFAULT 0.00,
  `Col50` double(11,2) DEFAULT 0.00,
  `establecimiento_id_establecimiento` int(11) NOT NULL DEFAULT 0,
  `prestacion_id_prestacion` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`establecimiento_id_establecimiento`,`prestacion_id_prestacion`),
  KEY `codigoprestacion` (`CodigoPrestacion`),
  KEY `fk_rem_establecimiento1_idx` (`establecimiento_id_establecimiento`),
  KEY `fk_rem_prestacion1_idx` (`prestacion_id_prestacion`),
  KEY `programacion_aps` (`IdEstablecimiento`,`CodigoPrestacion`,`Mes`)
) ENGINE=InnoDB AUTO_INCREMENT=3195883 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2021secciones
CREATE TABLE IF NOT EXISTS `2021secciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `nserie` varchar(50) NOT NULL,
  `supergroups` text DEFAULT NULL,
  `supergroups_inline` tinyint(1) NOT NULL DEFAULT 0,
  `discard_group` tinyint(1) NOT NULL DEFAULT 0,
  `thead` text DEFAULT NULL,
  `cols` text DEFAULT NULL,
  `cods` text DEFAULT NULL,
  `totals` tinyint(1) NOT NULL DEFAULT 0,
  `totals_by_prestacion` text DEFAULT NULL,
  `totals_by_group` text DEFAULT NULL,
  `totals_first` tinyint(1) NOT NULL DEFAULT 0,
  `subtotals` text DEFAULT NULL,
  `subtotals_first` tinyint(1) NOT NULL DEFAULT 0,
  `tfoot` text DEFAULT NULL,
  `precision` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=675 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2022establecimientos
CREATE TABLE IF NOT EXISTS `2022establecimientos` (
  `id_establecimiento` int(11) NOT NULL,
  `servicio_salud` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `Codigo` varchar(255) DEFAULT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `alias_estab` varchar(255) DEFAULT NULL,
  `comuna` varchar(255) DEFAULT NULL,
  `codigo_comuna` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `comges19` tinyint(4) DEFAULT NULL,
  `meta_san` tinyint(4) DEFAULT NULL,
  `meta_san_18834` tinyint(4) DEFAULT NULL,
  `meta_san_18834_hosp` tinyint(4) DEFAULT NULL,
  `p_masama` tinyint(4) DEFAULT NULL,
  `p_chcc` tinyint(4) DEFAULT NULL,
  `p_depsev` tinyint(4) DEFAULT NULL,
  `p_saserep` tinyint(4) DEFAULT NULL,
  `p_ges_odont` tinyint(4) DEFAULT NULL,
  `p_sembrando_sonrisas` tinyint(4) DEFAULT NULL,
  `p_mejor_aten_odont` tinyint(4) DEFAULT NULL,
  `p_odont_integral` tinyint(4) DEFAULT NULL,
  `p_equidad_rural` tinyint(4) DEFAULT NULL,
  `tablero_poblacion` tinyint(4) DEFAULT NULL,
  `comuna_id_comuna` int(11) NOT NULL,
  PRIMARY KEY (`id_establecimiento`,`comuna_id_comuna`),
  KEY `fk_establecimiento_comuna_idx` (`comuna_id_comuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2022percapita
CREATE TABLE IF NOT EXISTS `2022percapita` (
  `RUN` int(11) NOT NULL,
  `DV` char(1) NOT NULL,
  `NOMBRES` varchar(255) DEFAULT NULL,
  `APELLIDO_PATERNO` varchar(255) DEFAULT NULL,
  `APELLIDO_MATERNO` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `EDAD` int(11) DEFAULT NULL,
  `GENERO` char(1) DEFAULT NULL,
  `TRAMO` char(1) DEFAULT NULL,
  `FECHA_CORTE` date NOT NULL,
  `COD_CENTRO` int(11) NOT NULL,
  `NOMBRE_CENTRO` varchar(255) NOT NULL,
  `CODIGO_CENTRO_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_CENTRO_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_DESTINO` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_DESTINO` varchar(255) DEFAULT NULL,
  `TRASLADO_POSITIVO` enum('X','') DEFAULT NULL,
  `TRASLADO_NEGATIVO` enum('X','') DEFAULT NULL,
  `NUEVO_INSCRITO` enum('X','') DEFAULT NULL,
  `EXBLOQUEADO` enum('X','') DEFAULT NULL,
  `RECHAZADO_PREVISIONAL` enum('X','') DEFAULT NULL,
  `RECHAZADO_FALLECIDO` enum('X','') DEFAULT NULL,
  `AUTORIZADO` enum('X','') DEFAULT NULL,
  `ACEPTADO_RECHAZADO` enum('ACEPTADO','RECHAZADO','INGRESO RECHAZO SIMULTÁNEO') NOT NULL,
  `MOTIVO` varchar(128) NOT NULL,
  PRIMARY KEY (`RUN`,`FECHA_CORTE`,`COD_CENTRO`,`ACEPTADO_RECHAZADO`),
  KEY `ACEPTADO_RECHAZADO` (`ACEPTADO_RECHAZADO`),
  KEY `COD_CENTRO` (`COD_CENTRO`),
  KEY `consulta_comunal` (`EDAD`,`FECHA_CORTE`,`AUTORIZADO`,`COD_CENTRO`),
  KEY `FECHA_CORTE` (`FECHA_CORTE`),
  KEY `FECHA_NACIMIENTO` (`FECHA_NACIMIENTO`),
  KEY `indexGenero` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`,`GENERO`),
  KEY `indexquery` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`),
  KEY `Índice 10` (`FECHA_NACIMIENTO`),
  KEY `MOTIVO` (`MOTIVO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2022percapitaoficial
CREATE TABLE IF NOT EXISTS `2022percapitaoficial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Región` int(11) NOT NULL,
  `Región` varchar(12) DEFAULT NULL,
  `Id_Serv._Salud` int(11) NOT NULL,
  `Servicio_Salud` varchar(12) DEFAULT NULL,
  `Id_Comuna` int(11) NOT NULL,
  `Comuna` varchar(25) DEFAULT NULL,
  `Id_Centro_APS` int(11) NOT NULL,
  `Centro_APS` varchar(255) DEFAULT NULL,
  `Sexo` varchar(12) DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `Inscritos` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Id_Serv._Salud_index` (`Id_Serv._Salud`),
  KEY `Id_Comuna_index` (`Id_Comuna`),
  KEY `Id_Centro_APS_index` (`Id_Centro_APS`)
) ENGINE=InnoDB AUTO_INCREMENT=4067 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2022prestaciones
CREATE TABLE IF NOT EXISTS `2022prestaciones` (
  `id_prestacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `Nserie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_prestacion`),
  KEY `SERIE` (`serie`,`codigo_prestacion`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3900 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2022rems
CREATE TABLE IF NOT EXISTS `2022rems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mes` int(11) DEFAULT NULL,
  `IdServicio` varchar(2) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `IdEstablecimiento` varchar(7) DEFAULT NULL,
  `CodigoPrestacion` varchar(50) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `Col01` double(11,2) DEFAULT 0.00,
  `Col02` double(11,2) DEFAULT 0.00,
  `Col03` double(11,2) DEFAULT 0.00,
  `Col04` double(11,2) DEFAULT 0.00,
  `Col05` double(11,2) DEFAULT 0.00,
  `Col06` double(11,2) DEFAULT 0.00,
  `Col07` double(11,2) DEFAULT 0.00,
  `Col08` double(11,2) DEFAULT 0.00,
  `Col09` double(11,2) DEFAULT 0.00,
  `Col10` double(11,2) DEFAULT 0.00,
  `Col11` double(11,2) DEFAULT 0.00,
  `Col12` double(11,2) DEFAULT 0.00,
  `Col13` double(11,2) DEFAULT 0.00,
  `Col14` double(11,2) DEFAULT 0.00,
  `Col15` double(11,2) DEFAULT 0.00,
  `Col16` double(11,2) DEFAULT 0.00,
  `Col17` double(11,2) DEFAULT 0.00,
  `Col18` double(11,2) DEFAULT 0.00,
  `Col19` double(11,2) DEFAULT 0.00,
  `Col21` double(11,2) DEFAULT 0.00,
  `Col20` double(11,2) DEFAULT 0.00,
  `Col22` double(11,2) DEFAULT 0.00,
  `Col23` double(11,2) DEFAULT 0.00,
  `Col24` double(11,2) DEFAULT 0.00,
  `Col25` double(11,2) DEFAULT 0.00,
  `Col26` double(11,2) DEFAULT 0.00,
  `Col27` double(11,2) DEFAULT 0.00,
  `Col28` double(11,2) DEFAULT 0.00,
  `Col29` double(11,2) DEFAULT 0.00,
  `Col30` double(11,2) DEFAULT 0.00,
  `Col31` double(11,2) DEFAULT 0.00,
  `Col32` double(11,2) DEFAULT 0.00,
  `Col33` double(11,2) DEFAULT 0.00,
  `Col34` double(11,2) DEFAULT 0.00,
  `Col35` double(11,2) DEFAULT 0.00,
  `Col36` double(11,2) DEFAULT 0.00,
  `Col37` double(11,2) DEFAULT 0.00,
  `Col38` double(11,2) DEFAULT 0.00,
  `Col39` double(11,2) DEFAULT 0.00,
  `Col40` double(11,2) DEFAULT 0.00,
  `Col41` double(11,2) DEFAULT 0.00,
  `Col42` double(11,2) DEFAULT 0.00,
  `Col43` double(11,2) DEFAULT 0.00,
  `Col44` double(11,2) DEFAULT 0.00,
  `Col45` double(11,2) DEFAULT 0.00,
  `Col46` double(11,2) DEFAULT 0.00,
  `Col47` double(11,2) DEFAULT 0.00,
  `Col48` double(11,2) DEFAULT 0.00,
  `Col49` double(11,2) DEFAULT 0.00,
  `Col50` double(11,2) DEFAULT 0.00,
  `establecimiento_id_establecimiento` int(11) NOT NULL DEFAULT 0,
  `prestacion_id_prestacion` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`establecimiento_id_establecimiento`,`prestacion_id_prestacion`),
  KEY `codigoprestacion` (`CodigoPrestacion`),
  KEY `fk_rem_establecimiento1_idx` (`establecimiento_id_establecimiento`),
  KEY `fk_rem_prestacion1_idx` (`prestacion_id_prestacion`),
  KEY `programacion_aps` (`IdEstablecimiento`,`CodigoPrestacion`,`Mes`)
) ENGINE=InnoDB AUTO_INCREMENT=3008330 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2022secciones
CREATE TABLE IF NOT EXISTS `2022secciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `nserie` varchar(50) NOT NULL,
  `supergroups` text DEFAULT NULL,
  `supergroups_inline` tinyint(1) NOT NULL DEFAULT 0,
  `discard_group` tinyint(1) NOT NULL DEFAULT 0,
  `thead` text DEFAULT NULL,
  `cols` text DEFAULT NULL,
  `cods` text DEFAULT NULL,
  `totals` tinyint(1) NOT NULL DEFAULT 0,
  `totals_by_prestacion` text DEFAULT NULL,
  `totals_by_group` text DEFAULT NULL,
  `totals_first` tinyint(1) NOT NULL DEFAULT 0,
  `subtotals` text DEFAULT NULL,
  `subtotals_first` tinyint(1) NOT NULL DEFAULT 0,
  `tfoot` text DEFAULT NULL,
  `precision` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=391 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2023establecimientos
CREATE TABLE IF NOT EXISTS `2023establecimientos` (
  `id_establecimiento` int(11) NOT NULL,
  `servicio_salud` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `Codigo` varchar(255) DEFAULT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `alias_estab` varchar(255) DEFAULT NULL,
  `comuna` varchar(255) DEFAULT NULL,
  `codigo_comuna` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `comges19` tinyint(4) DEFAULT NULL,
  `meta_san` tinyint(4) DEFAULT NULL,
  `meta_san_18834` tinyint(4) DEFAULT NULL,
  `meta_san_18834_hosp` tinyint(4) DEFAULT NULL,
  `p_masama` tinyint(4) DEFAULT NULL,
  `p_chcc` tinyint(4) DEFAULT NULL,
  `p_depsev` tinyint(4) DEFAULT NULL,
  `p_saserep` tinyint(4) DEFAULT NULL,
  `p_ges_odont` tinyint(4) DEFAULT NULL,
  `p_sembrando_sonrisas` tinyint(4) DEFAULT NULL,
  `p_mejor_aten_odont` tinyint(4) DEFAULT NULL,
  `p_odont_integral` tinyint(4) DEFAULT NULL,
  `p_equidad_rural` tinyint(4) DEFAULT NULL,
  `tablero_poblacion` tinyint(4) DEFAULT NULL,
  `comuna_id_comuna` int(11) NOT NULL,
  PRIMARY KEY (`id_establecimiento`,`comuna_id_comuna`),
  KEY `fk_establecimiento_comuna_idx` (`comuna_id_comuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2023percapita
CREATE TABLE IF NOT EXISTS `2023percapita` (
  `RUN` int(11) NOT NULL,
  `DV` char(1) NOT NULL,
  `NOMBRES` varchar(255) DEFAULT NULL,
  `APELLIDO_PATERNO` varchar(255) DEFAULT NULL,
  `APELLIDO_MATERNO` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `EDAD` int(11) DEFAULT NULL,
  `GENERO` char(1) DEFAULT NULL,
  `TRAMO` char(1) DEFAULT NULL,
  `FECHA_CORTE` date NOT NULL,
  `COD_CENTRO` int(11) NOT NULL,
  `NOMBRE_CENTRO` varchar(255) NOT NULL,
  `CODIGO_CENTRO_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_CENTRO_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_DESTINO` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_DESTINO` varchar(255) DEFAULT NULL,
  `TRASLADO_POSITIVO` enum('X','') DEFAULT NULL,
  `TRASLADO_NEGATIVO` enum('X','') DEFAULT NULL,
  `NUEVO_INSCRITO` enum('X','') DEFAULT NULL,
  `EXBLOQUEADO` enum('X','') DEFAULT NULL,
  `RECHAZADO_PREVISIONAL` enum('X','') DEFAULT NULL,
  `RECHAZADO_FALLECIDO` enum('X','') DEFAULT NULL,
  `AUTORIZADO` enum('X','') DEFAULT NULL,
  `ACEPTADO_RECHAZADO` enum('ACEPTADO','RECHAZADO','INGRESO RECHAZO SIMULTÁNEO') NOT NULL,
  `MOTIVO` varchar(128) NOT NULL,
  PRIMARY KEY (`RUN`,`FECHA_CORTE`,`COD_CENTRO`,`ACEPTADO_RECHAZADO`),
  KEY `ACEPTADO_RECHAZADO` (`ACEPTADO_RECHAZADO`),
  KEY `COD_CENTRO` (`COD_CENTRO`),
  KEY `consulta_comunal` (`EDAD`,`FECHA_CORTE`,`AUTORIZADO`,`COD_CENTRO`),
  KEY `FECHA_CORTE` (`FECHA_CORTE`),
  KEY `FECHA_NACIMIENTO` (`FECHA_NACIMIENTO`),
  KEY `indexGenero` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`,`GENERO`),
  KEY `indexquery` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`),
  KEY `Índice 10` (`FECHA_NACIMIENTO`),
  KEY `MOTIVO` (`MOTIVO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2023percapitaoficial
CREATE TABLE IF NOT EXISTS `2023percapitaoficial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Región` int(11) NOT NULL,
  `Región` varchar(12) DEFAULT NULL,
  `Id_Serv._Salud` int(11) NOT NULL,
  `Servicio_Salud` varchar(12) DEFAULT NULL,
  `Id_Comuna` int(11) NOT NULL,
  `Comuna` varchar(25) DEFAULT NULL,
  `Id_Centro_APS` int(11) NOT NULL,
  `Centro_APS` varchar(255) DEFAULT NULL,
  `Sexo` varchar(12) DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `Inscritos` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Id_Serv._Salud_index` (`Id_Serv._Salud`),
  KEY `Id_Comuna_index` (`Id_Comuna`),
  KEY `Id_Centro_APS_index` (`Id_Centro_APS`)
) ENGINE=InnoDB AUTO_INCREMENT=5189 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2023prestaciones
CREATE TABLE IF NOT EXISTS `2023prestaciones` (
  `id_prestacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `Nserie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_prestacion`) USING BTREE,
  KEY `SERIE` (`serie`,`codigo_prestacion`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8826 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2023rems
CREATE TABLE IF NOT EXISTS `2023rems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mes` int(11) DEFAULT NULL,
  `IdServicio` varchar(2) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `IdEstablecimiento` varchar(7) DEFAULT NULL,
  `CodigoPrestacion` varchar(50) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `Col01` double(11,2) DEFAULT 0.00,
  `Col02` double(11,2) DEFAULT 0.00,
  `Col03` double(11,2) DEFAULT 0.00,
  `Col04` double(11,2) DEFAULT 0.00,
  `Col05` double(11,2) DEFAULT 0.00,
  `Col06` double(11,2) DEFAULT 0.00,
  `Col07` double(11,2) DEFAULT 0.00,
  `Col08` double(11,2) DEFAULT 0.00,
  `Col09` double(11,2) DEFAULT 0.00,
  `Col10` double(11,2) DEFAULT 0.00,
  `Col11` double(11,2) DEFAULT 0.00,
  `Col12` double(11,2) DEFAULT 0.00,
  `Col13` double(11,2) DEFAULT 0.00,
  `Col14` double(11,2) DEFAULT 0.00,
  `Col15` double(11,2) DEFAULT 0.00,
  `Col16` double(11,2) DEFAULT 0.00,
  `Col17` double(11,2) DEFAULT 0.00,
  `Col18` double(11,2) DEFAULT 0.00,
  `Col19` double(11,2) DEFAULT 0.00,
  `Col21` double(11,2) DEFAULT 0.00,
  `Col20` double(11,2) DEFAULT 0.00,
  `Col22` double(11,2) DEFAULT 0.00,
  `Col23` double(11,2) DEFAULT 0.00,
  `Col24` double(11,2) DEFAULT 0.00,
  `Col25` double(11,2) DEFAULT 0.00,
  `Col26` double(11,2) DEFAULT 0.00,
  `Col27` double(11,2) DEFAULT 0.00,
  `Col28` double(11,2) DEFAULT 0.00,
  `Col29` double(11,2) DEFAULT 0.00,
  `Col30` double(11,2) DEFAULT 0.00,
  `Col31` double(11,2) DEFAULT 0.00,
  `Col32` double(11,2) DEFAULT 0.00,
  `Col33` double(11,2) DEFAULT 0.00,
  `Col34` double(11,2) DEFAULT 0.00,
  `Col35` double(11,2) DEFAULT 0.00,
  `Col36` double(11,2) DEFAULT 0.00,
  `Col37` double(11,2) DEFAULT 0.00,
  `Col38` double(11,2) DEFAULT 0.00,
  `Col39` double(11,2) DEFAULT 0.00,
  `Col40` double(11,2) DEFAULT 0.00,
  `Col41` double(11,2) DEFAULT 0.00,
  `Col42` double(11,2) DEFAULT 0.00,
  `Col43` double(11,2) DEFAULT 0.00,
  `Col44` double(11,2) DEFAULT 0.00,
  `Col45` double(11,2) DEFAULT 0.00,
  `Col46` double(11,2) DEFAULT 0.00,
  `Col47` double(11,2) DEFAULT 0.00,
  `Col48` double(11,2) DEFAULT 0.00,
  `Col49` double(11,2) DEFAULT 0.00,
  `Col50` double(11,2) DEFAULT 0.00,
  `establecimiento_id_establecimiento` int(11) NOT NULL DEFAULT 0,
  `prestacion_id_prestacion` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`establecimiento_id_establecimiento`,`prestacion_id_prestacion`) USING BTREE,
  KEY `codigoprestacion` (`CodigoPrestacion`) USING BTREE,
  KEY `fk_rem_establecimiento1_idx` (`establecimiento_id_establecimiento`) USING BTREE,
  KEY `fk_rem_prestacion1_idx` (`prestacion_id_prestacion`) USING BTREE,
  KEY `programacion_aps` (`IdEstablecimiento`,`CodigoPrestacion`,`Mes`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3708181 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2023secciones
CREATE TABLE IF NOT EXISTS `2023secciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `nserie` varchar(50) NOT NULL,
  `supergroups` text DEFAULT NULL,
  `supergroups_inline` tinyint(1) NOT NULL DEFAULT 0,
  `discard_group` tinyint(1) NOT NULL DEFAULT 0,
  `thead` text DEFAULT NULL,
  `cols` text DEFAULT NULL,
  `cods` text DEFAULT NULL,
  `totals` tinyint(1) NOT NULL DEFAULT 0,
  `totals_by_prestacion` text DEFAULT NULL,
  `totals_by_group` text DEFAULT NULL,
  `totals_first` tinyint(1) NOT NULL DEFAULT 0,
  `subtotals` text DEFAULT NULL,
  `subtotals_first` tinyint(1) NOT NULL DEFAULT 0,
  `tfoot` text DEFAULT NULL,
  `precision` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=464 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2024establecimientos
CREATE TABLE IF NOT EXISTS `2024establecimientos` (
  `id_establecimiento` int(11) NOT NULL,
  `servicio_salud` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `Codigo` varchar(255) DEFAULT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `alias_estab` varchar(255) DEFAULT NULL,
  `comuna` varchar(255) DEFAULT NULL,
  `codigo_comuna` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `comges19` tinyint(4) DEFAULT NULL,
  `meta_san` tinyint(4) DEFAULT NULL,
  `meta_san_18834` tinyint(4) DEFAULT NULL,
  `meta_san_18834_hosp` tinyint(4) DEFAULT NULL,
  `p_masama` tinyint(4) DEFAULT NULL,
  `p_chcc` tinyint(4) DEFAULT NULL,
  `p_depsev` tinyint(4) DEFAULT NULL,
  `p_saserep` tinyint(4) DEFAULT NULL,
  `p_ges_odont` tinyint(4) DEFAULT NULL,
  `p_sembrando_sonrisas` tinyint(4) DEFAULT NULL,
  `p_mejor_aten_odont` tinyint(4) DEFAULT NULL,
  `p_odont_integral` tinyint(4) DEFAULT NULL,
  `p_equidad_rural` tinyint(4) DEFAULT NULL,
  `tablero_poblacion` tinyint(4) DEFAULT NULL,
  `comuna_id_comuna` int(11) NOT NULL,
  PRIMARY KEY (`id_establecimiento`,`comuna_id_comuna`),
  KEY `fk_establecimiento_comuna_idx` (`comuna_id_comuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2024percapita
CREATE TABLE IF NOT EXISTS `2024percapita` (
  `RUN` int(11) NOT NULL,
  `DV` char(1) NOT NULL,
  `NOMBRES` varchar(255) DEFAULT NULL,
  `APELLIDO_PATERNO` varchar(255) DEFAULT NULL,
  `APELLIDO_MATERNO` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `EDAD` int(11) DEFAULT NULL,
  `GENERO` char(1) DEFAULT NULL,
  `TRAMO` char(1) DEFAULT NULL,
  `FECHA_CORTE` date NOT NULL,
  `COD_CENTRO` int(11) NOT NULL,
  `NOMBRE_CENTRO` varchar(255) NOT NULL,
  `CODIGO_CENTRO_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_CENTRO_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_DESTINO` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_DESTINO` varchar(255) DEFAULT NULL,
  `TRASLADO_POSITIVO` enum('X','') DEFAULT NULL,
  `TRASLADO_NEGATIVO` enum('X','') DEFAULT NULL,
  `NUEVO_INSCRITO` enum('X','') DEFAULT NULL,
  `EXBLOQUEADO` enum('X','') DEFAULT NULL,
  `RECHAZADO_PREVISIONAL` enum('X','') DEFAULT NULL,
  `RECHAZADO_FALLECIDO` enum('X','') DEFAULT NULL,
  `AUTORIZADO` enum('X','') DEFAULT NULL,
  `ACEPTADO_RECHAZADO` enum('ACEPTADO','RECHAZADO','INGRESO RECHAZO SIMULTÁNEO') NOT NULL,
  `MOTIVO` varchar(128) NOT NULL,
  PRIMARY KEY (`RUN`,`FECHA_CORTE`,`COD_CENTRO`,`ACEPTADO_RECHAZADO`),
  KEY `ACEPTADO_RECHAZADO` (`ACEPTADO_RECHAZADO`),
  KEY `COD_CENTRO` (`COD_CENTRO`),
  KEY `consulta_comunal` (`EDAD`,`FECHA_CORTE`,`AUTORIZADO`,`COD_CENTRO`),
  KEY `FECHA_CORTE` (`FECHA_CORTE`),
  KEY `FECHA_NACIMIENTO` (`FECHA_NACIMIENTO`),
  KEY `indexGenero` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`,`GENERO`),
  KEY `indexquery` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`),
  KEY `Índice 10` (`FECHA_NACIMIENTO`),
  KEY `MOTIVO` (`MOTIVO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2024percapitaoficial
CREATE TABLE IF NOT EXISTS `2024percapitaoficial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Región` int(11) NOT NULL,
  `Región` varchar(12) DEFAULT NULL,
  `Id_Serv._Salud` int(11) NOT NULL,
  `Servicio_Salud` varchar(12) DEFAULT NULL,
  `Id_Comuna` int(11) NOT NULL,
  `Comuna` varchar(25) DEFAULT NULL,
  `Id_Centro_APS` int(11) NOT NULL,
  `Centro_APS` varchar(255) DEFAULT NULL,
  `Sexo` varchar(12) DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `Inscritos` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Id_Serv._Salud_index` (`Id_Serv._Salud`),
  KEY `Id_Comuna_index` (`Id_Comuna`),
  KEY `Id_Centro_APS_index` (`Id_Centro_APS`)
) ENGINE=InnoDB AUTO_INCREMENT=8192 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2024prestaciones
CREATE TABLE IF NOT EXISTS `2024prestaciones` (
  `id_prestacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `Nserie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_prestacion`) USING BTREE,
  KEY `SERIE` (`serie`,`codigo_prestacion`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3144 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2024rems
CREATE TABLE IF NOT EXISTS `2024rems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mes` int(11) DEFAULT NULL,
  `IdServicio` varchar(2) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `IdEstablecimiento` varchar(7) DEFAULT NULL,
  `CodigoPrestacion` varchar(50) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `Col01` double(11,2) DEFAULT 0.00,
  `Col02` double(11,2) DEFAULT 0.00,
  `Col03` double(11,2) DEFAULT 0.00,
  `Col04` double(11,2) DEFAULT 0.00,
  `Col05` double(11,2) DEFAULT 0.00,
  `Col06` double(11,2) DEFAULT 0.00,
  `Col07` double(11,2) DEFAULT 0.00,
  `Col08` double(11,2) DEFAULT 0.00,
  `Col09` double(11,2) DEFAULT 0.00,
  `Col10` double(11,2) DEFAULT 0.00,
  `Col11` double(11,2) DEFAULT 0.00,
  `Col12` double(11,2) DEFAULT 0.00,
  `Col13` double(11,2) DEFAULT 0.00,
  `Col14` double(11,2) DEFAULT 0.00,
  `Col15` double(11,2) DEFAULT 0.00,
  `Col16` double(11,2) DEFAULT 0.00,
  `Col17` double(11,2) DEFAULT 0.00,
  `Col18` double(11,2) DEFAULT 0.00,
  `Col19` double(11,2) DEFAULT 0.00,
  `Col21` double(11,2) DEFAULT 0.00,
  `Col20` double(11,2) DEFAULT 0.00,
  `Col22` double(11,2) DEFAULT 0.00,
  `Col23` double(11,2) DEFAULT 0.00,
  `Col24` double(11,2) DEFAULT 0.00,
  `Col25` double(11,2) DEFAULT 0.00,
  `Col26` double(11,2) DEFAULT 0.00,
  `Col27` double(11,2) DEFAULT 0.00,
  `Col28` double(11,2) DEFAULT 0.00,
  `Col29` double(11,2) DEFAULT 0.00,
  `Col30` double(11,2) DEFAULT 0.00,
  `Col31` double(11,2) DEFAULT 0.00,
  `Col32` double(11,2) DEFAULT 0.00,
  `Col33` double(11,2) DEFAULT 0.00,
  `Col34` double(11,2) DEFAULT 0.00,
  `Col35` double(11,2) DEFAULT 0.00,
  `Col36` double(11,2) DEFAULT 0.00,
  `Col37` double(11,2) DEFAULT 0.00,
  `Col38` double(11,2) DEFAULT 0.00,
  `Col39` double(11,2) DEFAULT 0.00,
  `Col40` double(11,2) DEFAULT 0.00,
  `Col41` double(11,2) DEFAULT 0.00,
  `Col42` double(11,2) DEFAULT 0.00,
  `Col43` double(11,2) DEFAULT 0.00,
  `Col44` double(11,2) DEFAULT 0.00,
  `Col45` double(11,2) DEFAULT 0.00,
  `Col46` double(11,2) DEFAULT 0.00,
  `Col47` double(11,2) DEFAULT 0.00,
  `Col48` double(11,2) DEFAULT 0.00,
  `Col49` double(11,2) DEFAULT 0.00,
  `Col50` double(11,2) DEFAULT 0.00,
  `establecimiento_id_establecimiento` int(11) NOT NULL DEFAULT 0,
  `prestacion_id_prestacion` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`establecimiento_id_establecimiento`,`prestacion_id_prestacion`) USING BTREE,
  KEY `codigoprestacion` (`CodigoPrestacion`) USING BTREE,
  KEY `fk_rem_establecimiento1_idx` (`establecimiento_id_establecimiento`) USING BTREE,
  KEY `fk_rem_prestacion1_idx` (`prestacion_id_prestacion`) USING BTREE,
  KEY `programacion_aps` (`IdEstablecimiento`,`CodigoPrestacion`,`Mes`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3715194 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.2024secciones
CREATE TABLE IF NOT EXISTS `2024secciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `nserie` varchar(50) NOT NULL,
  `supergroups` text DEFAULT NULL,
  `supergroups_inline` tinyint(1) NOT NULL DEFAULT 0,
  `discard_group` tinyint(1) NOT NULL DEFAULT 0,
  `thead` text DEFAULT NULL,
  `cols` text DEFAULT NULL,
  `cods` text DEFAULT NULL,
  `totals` tinyint(1) NOT NULL DEFAULT 0,
  `totals_by_prestacion` text DEFAULT NULL,
  `totals_by_group` text DEFAULT NULL,
  `totals_first` tinyint(1) NOT NULL DEFAULT 0,
  `subtotals` text DEFAULT NULL,
  `subtotals_first` tinyint(1) NOT NULL DEFAULT 0,
  `tfoot` text DEFAULT NULL,
  `precision` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=447 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.comunas
CREATE TABLE IF NOT EXISTS `comunas` (
  `id_comuna` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_comuna` varchar(255) DEFAULT NULL,
  `nombre_comuna` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_comuna`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.establecimientos
CREATE TABLE IF NOT EXISTS `establecimientos` (
  `id_establecimiento` int(11) NOT NULL,
  `servicio_salud` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `Codigo` varchar(255) DEFAULT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `alias_estab` varchar(255) DEFAULT NULL,
  `comuna` varchar(255) DEFAULT NULL,
  `codigo_comuna` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `comges19` tinyint(4) DEFAULT NULL,
  `meta_san` tinyint(4) DEFAULT NULL,
  `meta_san_18834` tinyint(4) DEFAULT NULL,
  `meta_san_18834_hosp` tinyint(4) DEFAULT NULL,
  `comuna_id_comuna` int(11) NOT NULL,
  PRIMARY KEY (`id_establecimiento`,`comuna_id_comuna`),
  KEY `fk_establecimiento_comuna_idx` (`comuna_id_comuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.percapita
CREATE TABLE IF NOT EXISTS `percapita` (
  `RUN` int(11) NOT NULL,
  `DV` char(1) NOT NULL,
  `NOMBRES` varchar(255) DEFAULT NULL,
  `APELLIDO_PATERNO` varchar(255) DEFAULT NULL,
  `APELLIDO_MATERNO` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `EDAD` int(11) DEFAULT NULL,
  `GENERO` char(1) DEFAULT NULL,
  `TRAMO` char(1) DEFAULT NULL,
  `FECHA_CORTE` date NOT NULL,
  `COD_CENTRO` int(11) NOT NULL,
  `NOMBRE_CENTRO` varchar(255) NOT NULL,
  `CODIGO_CENTRO_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_CENTRO_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_DESTINO` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_DESTINO` varchar(255) DEFAULT NULL,
  `TRASLADO_POSITIVO` enum('X') NOT NULL,
  `TRASLADO_NEGATIVO` enum('X') NOT NULL,
  `NUEVO_INSCRITO` enum('X') NOT NULL,
  `EXBLOQUEADO` enum('X') NOT NULL,
  `RECHAZADO_PREVISIONAL` enum('X') NOT NULL,
  `RECHAZADO_FALLECIDO` enum('X') NOT NULL,
  `AUTORIZADO` enum('X') NOT NULL,
  `ACEPTADO_RECHAZADO` enum('ACEPTADO','RECHAZADO','INGRESO RECHAZO SIMULTÁNEO') NOT NULL,
  `MOTIVO` varchar(128) NOT NULL,
  PRIMARY KEY (`RUN`,`FECHA_CORTE`,`COD_CENTRO`,`ACEPTADO_RECHAZADO`),
  KEY `FECHA_CORTE` (`FECHA_CORTE`),
  KEY `COD_CENTRO` (`COD_CENTRO`),
  KEY `ACEPTADO_RECHAZADO` (`ACEPTADO_RECHAZADO`),
  KEY `MOTIVO` (`MOTIVO`),
  KEY `FECHA_NACIMIENTO` (`FECHA_NACIMIENTO`),
  KEY `indexquery` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`),
  KEY `indexGenero` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`,`GENERO`),
  KEY `consulta_comunal` (`EDAD`,`FECHA_CORTE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.percapita_pro
CREATE TABLE IF NOT EXISTS `percapita_pro` (
  `RUN` int(11) NOT NULL,
  `DV` char(1) NOT NULL,
  `NOMBRES` varchar(255) DEFAULT NULL,
  `APELLIDO_PATERNO` varchar(255) DEFAULT NULL,
  `APELLIDO_MATERNO` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `EDAD` int(11) DEFAULT NULL,
  `GENERO` char(1) DEFAULT NULL,
  `TRAMO` char(1) DEFAULT NULL,
  `FECHA_CORTE` date NOT NULL,
  `COD_CENTRO` int(11) NOT NULL,
  `NOMBRE_CENTRO` varchar(255) NOT NULL,
  `CODIGO_CENTRO_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_PROCEDENCIA` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_PROCEDENCIA` varchar(255) DEFAULT NULL,
  `CODIGO_CENTRO_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_CENTRO_DESTINO` varchar(255) DEFAULT NULL,
  `CODIGO_COMUNA_DESTINO` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA_DESTINO` varchar(255) DEFAULT NULL,
  `TRASLADO_POSITIVO` enum('X') NOT NULL,
  `TRASLADO_NEGATIVO` enum('X') NOT NULL,
  `NUEVO_INSCRITO` enum('X') NOT NULL,
  `EXBLOQUEADO` enum('X') NOT NULL,
  `RECHAZADO_PREVISIONAL` enum('X') NOT NULL,
  `RECHAZADO_FALLECIDO` enum('X') NOT NULL,
  `AUTORIZADO` enum('X') NOT NULL,
  `ACEPTADO_RECHAZADO` enum('ACEPTADO','RECHAZADO','INGRESO RECHAZO SIMULTÁNEO') NOT NULL,
  `MOTIVO` varchar(128) NOT NULL,
  PRIMARY KEY (`RUN`,`FECHA_CORTE`,`COD_CENTRO`,`ACEPTADO_RECHAZADO`),
  KEY `FECHA_CORTE` (`FECHA_CORTE`),
  KEY `COD_CENTRO` (`COD_CENTRO`),
  KEY `ACEPTADO_RECHAZADO` (`ACEPTADO_RECHAZADO`),
  KEY `MOTIVO` (`MOTIVO`),
  KEY `FECHA_NACIMIENTO` (`FECHA_NACIMIENTO`),
  KEY `indexquery` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`),
  KEY `indexGenero` (`COD_CENTRO`,`FECHA_CORTE`,`EDAD`,`ACEPTADO_RECHAZADO`,`GENERO`),
  KEY `Índice 10` (`FECHA_NACIMIENTO`),
  KEY `consulta_comunal` (`EDAD`,`FECHA_CORTE`,`AUTORIZADO`,`COD_CENTRO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.prestaciones
CREATE TABLE IF NOT EXISTS `prestaciones` (
  `id_prestacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_prestacion` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `Nserie` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_prestacion`),
  KEY `SERIE` (`serie`,`codigo_prestacion`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4042 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.sigte
CREATE TABLE IF NOT EXISTS `sigte` (
  `SERV_SALUD` int(11) NOT NULL,
  `RUN` int(11) NOT NULL,
  `DV` char(1) NOT NULL,
  `NOMBRES` varchar(255) NOT NULL,
  `PRIMER_APELLIDO` varchar(255) NOT NULL,
  `SEGUNDO_APELLIDO` varchar(255) NOT NULL,
  `FECHA_NAC` date DEFAULT NULL,
  `SEXO` int(11) DEFAULT NULL,
  `PREVISION` int(11) DEFAULT NULL,
  `TIPO_PREST` tinyint(4) DEFAULT NULL,
  `PRESTA_MIN` varchar(255) DEFAULT NULL,
  `PLANO` varchar(255) DEFAULT NULL,
  `EXTREMIDAD` varchar(255) DEFAULT NULL,
  `PRESTA_EST` varchar(255) DEFAULT NULL,
  `F_ENTRADA` date DEFAULT NULL,
  `ESTAB_ORIG` varchar(50) DEFAULT NULL,
  `ESTAB_DEST` varchar(50) NOT NULL,
  `F_SALIDA` date DEFAULT NULL,
  `C_SALIDA` int(11) NOT NULL,
  `E_OTOR_AT` date NOT NULL,
  `PRESTA_MIN_SALIDA` varchar(255) DEFAULT NULL,
  `PRAIS` int(11) NOT NULL,
  `REGION` int(11) NOT NULL,
  `COMUNA` int(11) NOT NULL,
  `SOSPECHA_DIAG` varchar(25) NOT NULL,
  `CONFIR_DIAG` varchar(1) NOT NULL,
  `CIUDAD` varchar(13) NOT NULL,
  `COND_RURALIDAD` varchar(30) DEFAULT NULL,
  `VIA_DIRECCION` int(11) NOT NULL,
  `NOM_CALLE` varchar(255) DEFAULT NULL,
  `NUM_DIRECCION` varchar(255) DEFAULT NULL,
  `RESTO_DIRECCION` varchar(255) NOT NULL,
  `FONO_FIJO` bit(1) NOT NULL,
  `FONO_MOVIL` bit(1) NOT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `F_CITACION` varchar(255) DEFAULT NULL,
  `RUN_PROF_SOL` bit(1) NOT NULL,
  `DV_PROF_SOL` varchar(255) DEFAULT NULL,
  `RUN_PROF_RESOL` varchar(255) DEFAULT NULL,
  `DV_PROF_RESOL` varchar(255) DEFAULT NULL,
  `ID_LOCAL` varchar(255) NOT NULL,
  `RESULTADO` int(11) NOT NULL,
  `SIGTE_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla rem.sigte2
CREATE TABLE IF NOT EXISTS `sigte2` (
  `SERV_SALUD` int(11) NOT NULL,
  `RUN` int(11) NOT NULL,
  `DV` varchar(1) NOT NULL,
  `NOMBRES` varchar(256) NOT NULL,
  `PRIMER_APELLIDO` varchar(128) NOT NULL,
  `SEGUNDO_APELLIDO` varchar(128) DEFAULT NULL,
  `FECHA_NAC` date DEFAULT NULL,
  `SEXO` int(11) NOT NULL,
  `PREVISION` int(11) NOT NULL,
  `TIPO_PREST` bit(1) NOT NULL,
  `PRESTA_MIN` varchar(6) NOT NULL,
  `PLANO` varchar(30) DEFAULT NULL,
  `EXTREMIDAD` varchar(30) DEFAULT NULL,
  `PRESTA_EST` varchar(48) NOT NULL,
  `F_ENTRADA` date NOT NULL,
  `ESTAB_ORIG` varchar(50) NOT NULL,
  `ESTAB_DEST` varchar(50) NOT NULL,
  `F_SALIDA` date DEFAULT NULL,
  `C_SALIDA` int(11) DEFAULT NULL,
  `E_OTOR_AT` varchar(50) DEFAULT NULL,
  `PRESTA_MIN_SALIDA` varchar(30) DEFAULT NULL,
  `PRAIS` int(11) NOT NULL,
  `REGION` int(11) NOT NULL,
  `COMUNA` int(11) DEFAULT NULL,
  `SOSPECHA_DIAG` varchar(500) NOT NULL,
  `CONFIR_DIAG` varchar(90) DEFAULT NULL,
  `CIUDAD` varchar(13) DEFAULT NULL,
  `COND_RURALIDAD` int(11) DEFAULT NULL,
  `VIA_DIRECCION` int(11) NOT NULL,
  `NOM_CALLE` varchar(52) DEFAULT NULL,
  `NUM_DIRECCION` varchar(19) DEFAULT NULL,
  `RESTO_DIRECCION` varchar(50) DEFAULT NULL,
  `FONO_FIJO` int(11) DEFAULT NULL,
  `FONO_MOVIL` int(11) DEFAULT NULL,
  `EMAIL` varchar(30) DEFAULT NULL,
  `F_CITACION` date DEFAULT NULL,
  `RUN_PROF_SOL` int(11) DEFAULT NULL,
  `DV_PROF_SOL` varchar(1) DEFAULT NULL,
  `RUN_PROF_RESOL` varchar(30) DEFAULT NULL,
  `DV_PROF_RESOL` varchar(30) DEFAULT NULL,
  `ID_LOCAL` varchar(15) NOT NULL,
  `RESULTADO` int(11) DEFAULT NULL,
  `SIGTE_ID` int(11) NOT NULL,
  PRIMARY KEY (`SERV_SALUD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
