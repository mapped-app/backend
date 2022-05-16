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


-- Volcando estructura de base de datos para mapped
CREATE DATABASE IF NOT EXISTS `mapped` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `mapped`;

-- Volcando estructura para tabla mapped.communities
CREATE TABLE IF NOT EXISTS `communities` (
  `community_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`community_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mapped.provinces
CREATE TABLE IF NOT EXISTS `provinces` (
  `province_id` int(11) NOT NULL AUTO_INCREMENT,
  `community_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`province_id`),
  KEY `provinces_ibfk_1` (`community_id`),
  CONSTRAINT `provinces_ibfk_1` FOREIGN KEY (`community_id`) REFERENCES `communities` (`community_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mapped.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `province_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `cities_ibfk_1` (`province_id`),
  CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mapped.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mapped.stays
CREATE TABLE IF NOT EXISTS `stays` (
  `stay_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stay_id`),
  KEY `city_id` (`city_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `FK_stays_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_stays_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mapped.sites
CREATE TABLE IF NOT EXISTS `sites` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`site_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `FK_sites_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mapped.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mapped.travels
CREATE TABLE IF NOT EXISTS `travels` (
  `travel_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `start_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `end_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `city_origen` varchar(50) DEFAULT NULL,
  `transport` varchar(100) DEFAULT NULL,
  `transport_cost` decimal(20,6) DEFAULT NULL,
  `transport_time` int(11) DEFAULT NULL,
  `travel_cost` decimal(20,6) DEFAULT NULL,
  `travel_time` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`travel_id`),
  KEY `city_id` (`city_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK__cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mapped.sites_visited
CREATE TABLE IF NOT EXISTS `sites_visited` (
  `travel_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `cost` decimal(20,6) DEFAULT NULL,
  `rate` decimal(4,2) DEFAULT NULL,
  KEY `FK_sites_visited_sites` (`site_id`),
  KEY `FK_sites_visited_travels` (`travel_id`),
  CONSTRAINT `FK_sites_visited_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sites_visited_travels` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`travel_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mapped.booked_stays
CREATE TABLE IF NOT EXISTS `booked_stays` (
  `travel_id` int(11) DEFAULT NULL,
  `stay_id` int(11) DEFAULT NULL,
  `cost` decimal(20,6) DEFAULT NULL,
  `rate` decimal(4,2) DEFAULT NULL,
  KEY `FK_booked_stays_stays` (`stay_id`),
  KEY `FK_booked_stays_travels` (`travel_id`),
  CONSTRAINT `FK_booked_stays_stays` FOREIGN KEY (`stay_id`) REFERENCES `stays` (`stay_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_booked_stays_travels` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`travel_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
