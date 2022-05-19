
CREATE DATABASE IF NOT EXISTS `mapped_db`;
USE `mapped_db`;


CREATE TABLE IF NOT EXISTS `communities` (
  `community_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`community_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `provinces` (
  `province_id` int(11) NOT NULL AUTO_INCREMENT,
  `community_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`province_id`),
  KEY `provinces_ibfk_1` (`community_id`),
  CONSTRAINT `provinces_ibfk_1` FOREIGN KEY (`community_id`) REFERENCES `communities` (`community_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `cities` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `province_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `cities_ibfk_1` (`province_id`),
  CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `stays` (
  `stay_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`stay_id`),
  KEY `city_id` (`city_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `FK_stays_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_stays_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `sites` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`site_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `FK_sites_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(50) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `sites_visited` (
  `travel_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `cost` decimal(20,6) DEFAULT NULL,
  `rate` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`travel_id`,`site_id`),
  KEY `FK_sites_visited_sites` (`site_id`),
  KEY `FK_sites_visited_travels` (`travel_id`),
  CONSTRAINT `FK_sites_visited_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_sites_visited_travels` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`travel_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `booked_stays` (
  `travel_id` int(11) NOT NULL,
  `stay_id` int(11) NOT NULL,
  `cost` decimal(20,6) DEFAULT NULL,
  `rate` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`travel_id`,`stay_id`),
  KEY `FK_booked_stays_stays` (`stay_id`),
  KEY `FK_booked_stays_travels` (`travel_id`),
  CONSTRAINT `FK_booked_stays_stays` FOREIGN KEY (`stay_id`) REFERENCES `stays` (`stay_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_booked_stays_travels` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`travel_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
