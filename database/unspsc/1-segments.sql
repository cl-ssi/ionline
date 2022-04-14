-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.33 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando datos para la tabla unspsc.unspsc_segments: ~59 rows (aproximadamente)
/*!40000 ALTER TABLE `unspsc_segments` DISABLE KEYS */;
INSERT INTO `unspsc_segments` (`id`, `code`, `name`, `experies_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 10, 'Artículos para plantas y animales', NULL, '2022-04-12 19:39:29', '2022-04-12 19:39:29', NULL),
	(2, 11, 'Productos derivados de minerales, plantas y animales', NULL, '2022-04-12 19:39:32', '2022-04-12 19:39:32', NULL),
	(3, 12, 'Productos químicos industriales', NULL, '2022-04-12 19:39:34', '2022-04-12 19:39:34', NULL),
	(4, 13, 'Resinas, cauchos, espumas y elastómeros', NULL, '2022-04-12 19:39:37', '2022-04-12 19:39:37', NULL),
	(5, 14, 'Productos de papel', NULL, '2022-04-12 19:39:39', '2022-04-12 19:39:39', NULL),
	(6, 15, 'Combustibles, lubricantes y anticorrosivos', NULL, '2022-04-12 19:39:40', '2022-04-12 19:39:40', NULL),
	(7, 20, 'Maquinaria para minería y perforación', NULL, '2022-04-12 19:39:40', '2022-04-12 19:39:40', NULL),
	(8, 21, 'Maquinaria para agricultura, pesca y silvicultura', NULL, '2022-04-12 19:39:45', '2022-04-12 19:39:45', NULL),
	(9, 22, 'Maquinaria para construcción y edificación', NULL, '2022-04-12 19:39:46', '2022-04-12 19:39:46', NULL),
	(10, 23, 'Maquinaria para fabricación y transformación industrial', NULL, '2022-04-12 19:39:47', '2022-04-12 19:39:47', NULL),
	(11, 24, 'Equipamiento para manejo y estiba de materiales', NULL, '2022-04-12 19:39:51', '2022-04-12 19:39:51', NULL),
	(12, 25, 'Vehículos y equipamiento en general', NULL, '2022-04-12 19:39:53', '2022-04-12 19:39:53', NULL),
	(13, 26, 'Maquinaria para generación y distribución de energía', NULL, '2022-04-12 19:39:58', '2022-04-12 19:39:58', NULL),
	(14, 27, 'Herramientas y maquinaria en general', NULL, '2022-04-12 19:40:02', '2022-04-12 19:40:02', NULL),
	(15, 30, 'Artículos para estructuras, obras y construcciones', NULL, '2022-04-12 19:40:05', '2022-04-12 19:40:05', NULL),
	(16, 31, 'Artículos de fabricación y producción', NULL, '2022-04-12 19:40:11', '2022-04-12 19:40:11', NULL),
	(17, 32, 'Artículos de electrónica', NULL, '2022-04-12 19:40:32', '2022-04-12 19:40:32', NULL),
	(18, 39, 'Artículos eléctricos y de iluminación', NULL, '2022-04-12 19:40:34', '2022-04-12 19:40:34', NULL),
	(19, 40, 'Equipamiento para el acondicionamiento, distribución y filtrado de fluidos', NULL, '2022-04-12 19:40:37', '2022-04-12 19:40:37', NULL),
	(20, 41, 'Equipamiento para laboratorios', NULL, '2022-04-12 19:40:41', '2022-04-12 19:40:41', NULL),
	(21, 42, 'Equipamiento y suministros médicos', NULL, '2022-04-12 19:40:57', '2022-04-12 19:40:57', NULL),
	(22, 43, 'Tecnologías de la información, telecomunicaciones y radiodifusión', NULL, '2022-04-12 19:41:27', '2022-04-12 19:41:27', NULL),
	(23, 44, 'Equipos, accesorios y suministros de oficina', NULL, '2022-04-12 19:41:34', '2022-04-12 19:41:34', NULL),
	(24, 45, 'Equipos y suministros de imprenta, fotográficos y audiovisuales', NULL, '2022-04-12 19:41:38', '2022-04-12 19:41:38', NULL),
	(25, 46, 'Equipos y suministros de defensa, orden público, protección y seguridad', NULL, '2022-04-12 19:41:40', '2022-04-12 19:41:40', NULL),
	(26, 47, 'Equipos y suministros de limpieza', NULL, '2022-04-12 19:41:44', '2022-04-12 19:41:44', NULL),
	(27, 48, 'Maquinarias, equipos y suministros para la industria de servicios', NULL, '2022-04-12 19:41:46', '2022-04-12 19:41:46', NULL),
	(28, 49, 'Equipos, suministros y accesorios deportivos y recreativos', NULL, '2022-04-12 19:41:48', '2022-04-12 19:41:48', NULL),
	(29, 50, 'Alimentos, bebidas y tabaco', NULL, '2022-04-12 19:41:51', '2022-04-12 19:41:51', NULL),
	(30, 51, 'Medicamentos y productos farmacéuticos', NULL, '2022-04-12 19:41:54', '2022-04-12 19:41:54', NULL),
	(31, 52, 'Muebles, accesorios, electrodomésticos y productos electrónicos', NULL, '2022-04-12 19:42:19', '2022-04-12 19:42:19', NULL),
	(32, 53, 'Ropa, maletas y productos de aseo personal', NULL, '2022-04-12 19:42:23', '2022-04-12 19:42:23', NULL),
	(33, 54, 'Productos para relojería, joyería y gemas', NULL, '2022-04-12 19:42:27', '2022-04-12 19:42:27', NULL),
	(34, 55, 'Productos impresos y publicaciones', NULL, '2022-04-12 19:42:28', '2022-04-12 19:42:28', NULL),
	(35, 56, 'Muebles y mobiliario', NULL, '2022-04-12 19:42:29', '2022-04-12 19:42:29', NULL),
	(36, 60, 'Instrumentos musicales, juegos, juguetes, artesanías y materiales educativos', NULL, '2022-04-12 19:42:32', '2022-04-12 19:42:32', NULL),
	(37, 70, 'Servicios agrícolas, pesqueros, forestales y relacionados con la fauna', NULL, '2022-04-12 19:42:49', '2022-04-12 19:42:49', NULL),
	(38, 71, 'Servicios de perforación de minería, petróleo y gas', NULL, '2022-04-12 19:42:53', '2022-04-12 19:42:53', NULL),
	(39, 72, 'Servicios de construcción y mantenimiento', NULL, '2022-04-12 19:43:00', '2022-04-12 19:43:00', NULL),
	(40, 73, 'Servicios de producción y fabricación industrial', NULL, '2022-04-12 19:43:02', '2022-04-12 19:43:02', NULL),
	(41, 76, 'Servicios de limpieza industrial', NULL, '2022-04-12 19:43:06', '2022-04-12 19:43:06', NULL),
	(42, 77, 'Servicios medioambientales', NULL, '2022-04-12 19:43:06', '2022-04-12 19:43:06', NULL),
	(43, 78, 'Servicios de transporte, almacenaje y correo', NULL, '2022-04-12 19:43:08', '2022-04-12 19:43:08', NULL),
	(44, 80, 'Servicios profesionales, administrativos y consultorías de gestión empresarial', NULL, '2022-04-12 19:43:09', '2022-04-12 19:43:09', NULL),
	(45, 81, 'Servicios basados en ingeniería, ciencias sociales y tecnología de la información', NULL, '2022-04-12 19:43:12', '2022-04-12 19:43:12', NULL),
	(46, 82, 'Servicios editoriales, de diseño, publicidad, gráficos y artistas', NULL, '2022-04-12 19:43:15', '2022-04-12 19:43:15', NULL),
	(47, 83, 'Servicios básicos y de información pública', NULL, '2022-04-12 19:43:17', '2022-04-12 19:43:17', NULL),
	(48, 84, 'Servicios financieros, pensiones y seguros', NULL, '2022-04-12 19:43:18', '2022-04-12 19:43:18', NULL),
	(49, 85, 'Salud, servicios sanitarios y alimentación', NULL, '2022-04-12 19:43:20', '2022-04-12 19:43:20', NULL),
	(50, 86, 'Educación, formación, entrenamiento y capacitación', NULL, '2022-04-12 19:43:23', '2022-04-12 19:43:23', NULL),
	(51, 90, 'Servicios de Viajes, alimentación, alojamiento y entretenimiento', NULL, '2022-04-12 19:43:24', '2022-04-12 19:43:24', NULL),
	(52, 91, 'Servicios de cuidado personal y domésticos', NULL, '2022-04-12 19:43:26', '2022-04-12 19:43:26', NULL),
	(53, 92, 'Servicios de defensa nacional, orden público y seguridad', NULL, '2022-04-12 19:43:26', '2022-04-12 19:43:26', NULL),
	(54, 93, 'Organizaciones y consultorías políticas, demográficas, económicas, sociales y de administración públ', NULL, '2022-04-12 19:43:28', '2022-04-12 19:43:28', NULL),
	(55, 94, 'Organizaciones sociales, laborales y clubes', NULL, '2022-04-12 19:43:32', '2022-04-12 19:43:32', NULL),
	(56, 99, 'x', NULL, '2022-04-12 19:43:34', '2022-04-12 19:43:34', NULL),
	(57, 101, 'Obras', NULL, '2022-04-12 19:43:34', '2022-04-12 19:43:34', NULL),
	(58, 102, 'Consultoria', NULL, '2022-04-12 19:43:38', '2022-04-12 19:43:38', NULL),
	(59, 103, 'eCommerce', NULL, '2022-04-12 19:43:43', '2022-04-12 19:43:43', NULL);
/*!40000 ALTER TABLE `unspsc_segments` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
