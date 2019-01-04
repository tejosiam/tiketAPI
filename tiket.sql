-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.37-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for tiket
DROP DATABASE IF EXISTS `tiket`;
CREATE DATABASE IF NOT EXISTS `tiket` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `tiket`;

-- Dumping structure for table tiket.customers
DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nm_customer` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table tiket.event
DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nm_event` varchar(150) DEFAULT NULL,
  `id_location` int(5) DEFAULT NULL,
  `start_schedule` datetime NOT NULL,
  `end_schedule` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table tiket.events
DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_event` int(5) NOT NULL,
  `id_tiket` int(5) DEFAULT NULL,
  `id_customer` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table tiket.locations
DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nm_location` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table tiket.tikets
DROP TABLE IF EXISTS `tikets`;
CREATE TABLE IF NOT EXISTS `tikets` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nm_tiket` varchar(150) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `quota` bigint(10) DEFAULT NULL,
  `id_event` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table tiket.transactions
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nm_transaction` varchar(150) DEFAULT NULL,
  `id_customer` int(5) DEFAULT NULL,
  `id_event` int(5) DEFAULT NULL,
  `id_tiket` int(5) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'process',
  `qty` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
