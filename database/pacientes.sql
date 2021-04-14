-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.13-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para apirest
CREATE DATABASE IF NOT EXISTS `apirest` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `apirest`;

-- Volcando estructura para tabla apirest.pacientes
CREATE TABLE IF NOT EXISTS `pacientes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` char(50) NOT NULL,
  `apellido` char(50) NOT NULL,
  `DNI` int(10) unsigned NOT NULL DEFAULT 0,
  `edad` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `grupo` char(50) NOT NULL DEFAULT 'Sin clasificar',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `DNI` (`DNI`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla apirest.pacientes: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `pacientes` DISABLE KEYS */;
REPLACE INTO `pacientes` (`ID`, `nombre`, `apellido`, `DNI`, `edad`, `grupo`) VALUES
	(1, 'fabricio', 'rivarola', 41002508, 24, 'seguro'),
	(2, 'facundo', 'rivarola', 43021512, 20, 'seguro'),
	(3, 'bruno', 'diaz', 18513480, 55, 'riesgo'),
	(4, 'julia', 'campos', 25512401, 25, 'seguro'),
	(5, 'teresa', 'zarate', 10082416, 64, 'riesgo'),
	(6, 'rodrigo', 'de la horra', 40005216, 23, 'seguro');
/*!40000 ALTER TABLE `pacientes` ENABLE KEYS */;

-- Volcando estructura para tabla apirest.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` char(50) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla apirest.usuarios: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
REPLACE INTO `usuarios` (`ID`, `usuario`, `pass`) VALUES
	(40, 'admi', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
