-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.34-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for mas-d-order
DROP DATABASE IF EXISTS `mas-d-order`;
CREATE DATABASE IF NOT EXISTS `mas-d-order` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `mas-d-order`;

-- Dumping structure for table mas-d-order.access_menu
DROP TABLE IF EXISTS `access_menu`;
CREATE TABLE IF NOT EXISTS `access_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_access_menu_level_id` (`level_id`),
  KEY `fk_access_menu_menu_id` (`menu_id`),
  KEY `fk_access_menu_created_by` (`created_by`),
  KEY `fk_access_menu_modified_by` (`modified_by`),
  CONSTRAINT `fk_access_menu_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_access_menu_level_id` FOREIGN KEY (`level_id`) REFERENCES `level_lookup` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_access_menu_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_access_menu_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.access_menu: ~6 rows (approximately)
/*!40000 ALTER TABLE `access_menu` DISABLE KEYS */;
REPLACE INTO `access_menu` (`id`, `created_on`, `modified_on`, `created_by`, `modified_by`, `level_id`, `menu_id`) VALUES
	(1, '2019-02-12 18:14:39', '2019-02-12 18:20:03', NULL, NULL, 1, 1),
	(2, '2019-02-12 18:20:08', '2019-02-12 18:20:13', NULL, NULL, 1, 2),
	(3, '2019-02-12 18:20:55', '2019-02-12 18:20:55', NULL, NULL, 1, 3),
	(4, '2019-02-12 18:21:04', '2019-02-12 18:21:04', NULL, NULL, 1, 4),
	(5, '2019-02-12 18:21:10', '2019-02-13 11:00:33', NULL, NULL, 2, 2),
	(7, '2019-02-12 18:22:06', '2019-02-13 11:00:59', NULL, NULL, 2, 5);
/*!40000 ALTER TABLE `access_menu` ENABLE KEYS */;

-- Dumping structure for table mas-d-order.active_status_lookup
DROP TABLE IF EXISTS `active_status_lookup`;
CREATE TABLE IF NOT EXISTS `active_status_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.active_status_lookup: ~2 rows (approximately)
/*!40000 ALTER TABLE `active_status_lookup` DISABLE KEYS */;
REPLACE INTO `active_status_lookup` (`id`, `created_on`, `modified_on`, `name`, `description`) VALUES
	(1, '2019-02-12 18:14:19', '2019-02-12 18:14:19', 'ACTIVE', NULL),
	(2, '2019-02-12 18:14:26', '2019-02-12 18:14:26', 'NON ACTIVE', NULL);
/*!40000 ALTER TABLE `active_status_lookup` ENABLE KEYS */;

-- Dumping structure for function mas-d-order.f_get_increment
DROP FUNCTION IF EXISTS `f_get_increment`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `f_get_increment`(table_name_param varchar(255)) RETURNS int(11)
    DETERMINISTIC
BEGIN
        DECLARE table_id_param int;
        DECLARE last_increment_param int;

        SELECT id INTO table_id_param FROM menu WHERE table_name = table_name_param;
        SELECT last_increment INTO last_increment_param FROM increment WHERE menu_id = table_id_param;

        UPDATE increment SET last_increment = last_increment_param + 1;

        RETURN last_increment_param + 1;
    END//
DELIMITER ;

-- Dumping structure for table mas-d-order.increment
DROP TABLE IF EXISTS `increment`;
CREATE TABLE IF NOT EXISTS `increment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `menu_id` int(11) NOT NULL,
  `mask` varchar(255) DEFAULT NULL,
  `last_increment` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_id` (`menu_id`),
  KEY `fk_increment_created_by` (`created_by`),
  KEY `fk_increment_modified_by` (`modified_by`),
  CONSTRAINT `fk_increment_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_increment_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_increment_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.increment: ~1 rows (approximately)
/*!40000 ALTER TABLE `increment` DISABLE KEYS */;
REPLACE INTO `increment` (`id`, `created_on`, `modified_on`, `created_by`, `modified_by`, `menu_id`, `mask`, `last_increment`, `description`) VALUES
	(1, '2019-02-13 10:15:40', '2019-02-13 14:54:19', NULL, NULL, 1, 'ORD-yyyy-000', 91, NULL);
/*!40000 ALTER TABLE `increment` ENABLE KEYS */;

-- Dumping structure for table mas-d-order.items
DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(12,2) DEFAULT NULL,
  `description` text,
  `image` text,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_items_created_by` (`created_by`),
  KEY `fk_items_modified_by` (`modified_by`),
  KEY `fk_items_status` (`status`),
  CONSTRAINT `fk_items_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_items_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_items_status` FOREIGN KEY (`status`) REFERENCES `active_status_lookup` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.items: ~0 rows (approximately)
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
REPLACE INTO `items` (`id`, `created_on`, `modified_on`, `created_by`, `modified_by`, `name`, `price`, `description`, `image`, `status`) VALUES
	(1, '2019-02-13 13:36:48', '2019-02-13 15:19:09', NULL, NULL, 'Nasi Goreng Aceh', 16000.00, NULL, NULL, 1);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;

-- Dumping structure for table mas-d-order.level_lookup
DROP TABLE IF EXISTS `level_lookup`;
CREATE TABLE IF NOT EXISTS `level_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.level_lookup: ~2 rows (approximately)
/*!40000 ALTER TABLE `level_lookup` DISABLE KEYS */;
REPLACE INTO `level_lookup` (`id`, `created_on`, `modified_on`, `name`, `description`) VALUES
	(1, '2019-02-12 18:14:04', '2019-02-12 18:14:04', 'ADMIN', NULL),
	(2, '2019-02-12 18:14:09', '2019-02-12 18:14:09', 'MEMBERS', NULL);
/*!40000 ALTER TABLE `level_lookup` ENABLE KEYS */;

-- Dumping structure for table mas-d-order.menu
DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `position` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menu_created_by` (`created_by`),
  KEY `fk_menu_modified_by` (`modified_by`),
  CONSTRAINT `fk_menu_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.menu: ~5 rows (approximately)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
REPLACE INTO `menu` (`id`, `created_on`, `modified_on`, `created_by`, `modified_by`, `name`, `table_name`, `url`, `class`, `icon`, `position`) VALUES
	(1, '2019-02-12 18:14:56', '2019-02-13 13:29:38', NULL, NULL, 'Orders List', 'orders', 'orders', 'menu-orders-list', NULL, 1),
	(2, '2019-02-12 18:15:25', '2019-02-13 11:11:00', NULL, NULL, 'Orders Form', NULL, 'orders/form', 'menu-orders-form', NULL, 2),
	(3, '2019-02-12 18:16:39', '2019-02-13 11:11:12', NULL, NULL, 'Menu Items', 'items', 'items', 'menu-items', NULL, 4),
	(4, '2019-02-12 18:17:01', '2019-02-13 11:11:16', NULL, NULL, 'User', 'user', 'user', 'menu-user', NULL, 5),
	(5, '2019-02-12 18:49:37', '2019-02-13 11:11:07', NULL, NULL, 'Orders History', NULL, 'orders/history', 'menu-orders-history', NULL, 3);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- Dumping structure for table mas-d-order.menu_detail
DROP TABLE IF EXISTS `menu_detail`;
CREATE TABLE IF NOT EXISTS `menu_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `permission` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menu_detail_menu_id` (`menu_id`),
  KEY `fk_menu_detail_created_by` (`created_by`),
  KEY `fk_menu_detail_modified_by` (`modified_by`),
  CONSTRAINT `fk_menu_detail_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_detail_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_detail_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.menu_detail: ~15 rows (approximately)
/*!40000 ALTER TABLE `menu_detail` DISABLE KEYS */;
REPLACE INTO `menu_detail` (`id`, `created_on`, `modified_on`, `created_by`, `modified_by`, `menu_id`, `permission`) VALUES
	(1, '2019-02-12 18:17:22', '2019-02-12 18:17:29', NULL, NULL, 1, '1'),
	(2, '2019-02-12 18:17:34', '2019-02-12 18:17:34', NULL, NULL, 1, '2'),
	(3, '2019-02-12 18:17:38', '2019-02-12 18:17:38', NULL, NULL, 1, '3'),
	(4, '2019-02-12 18:17:42', '2019-02-12 18:17:45', NULL, NULL, 1, '4'),
	(5, '2019-02-12 18:17:51', '2019-02-12 18:17:51', NULL, NULL, 1, '5'),
	(6, '2019-02-12 18:17:57', '2019-02-12 18:17:57', NULL, NULL, 3, '1'),
	(7, '2019-02-12 18:18:19', '2019-02-12 18:18:19', NULL, NULL, 3, '2'),
	(8, '2019-02-12 18:18:48', '2019-02-12 18:18:48', NULL, NULL, 3, '3'),
	(9, '2019-02-12 18:18:55', '2019-02-12 18:18:55', NULL, NULL, 3, '4'),
	(10, '2019-02-12 18:19:00', '2019-02-12 18:19:00', NULL, NULL, 3, '5'),
	(11, '2019-02-12 18:19:09', '2019-02-12 18:19:09', NULL, NULL, 4, '1'),
	(12, '2019-02-12 18:19:13', '2019-02-12 18:19:13', NULL, NULL, 4, '2'),
	(13, '2019-02-12 18:19:18', '2019-02-12 18:19:18', NULL, NULL, 4, '3'),
	(14, '2019-02-12 18:19:23', '2019-02-12 18:19:23', NULL, NULL, 4, '4'),
	(15, '2019-02-12 18:19:29', '2019-02-12 18:19:29', NULL, NULL, 4, '5');
/*!40000 ALTER TABLE `menu_detail` ENABLE KEYS */;

-- Dumping structure for table mas-d-order.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `money` double(12,2) DEFAULT NULL,
  `total` double(12,2) DEFAULT NULL,
  `change_money` double(12,2) DEFAULT NULL,
  `notes` text,
  `status` int(11) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_order_status` (`status`),
  KEY `fk_order_user` (`user`),
  KEY `fk_order_created_by` (`created_by`),
  KEY `fk_order_modified_by` (`modified_by`),
  CONSTRAINT `fk_order_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_order_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_order_status` FOREIGN KEY (`status`) REFERENCES `order_status_lookup` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_order_user` FOREIGN KEY (`user`) REFERENCES `user` (`username`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.orders: ~2 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
REPLACE INTO `orders` (`id`, `created_on`, `modified_on`, `created_by`, `modified_by`, `date`, `money`, `total`, `change_money`, `notes`, `status`, `user`) VALUES
	('ORD-2019089', '2019-02-13 14:42:16', '2019-02-13 14:42:16', 'hidayat', 'hidayat', '2019-02-13', 50000.00, 18000.00, 32000.00, 'Yang manis-manis eaaa', 1, 'hidayat'),
	('ORD-2019090', '2019-02-13 14:42:50', '2019-02-13 14:42:50', 'hidayat', 'hidayat', '2019-02-13', 50000.00, 10000.00, 40000.00, '', 1, 'hidayat');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table mas-d-order.order_detail
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE IF NOT EXISTS `order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `order_item` varchar(255) DEFAULT NULL,
  `price_item` double(12,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` double(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_detail_order_id` (`order_id`),
  KEY `fk_order_detail_order_item` (`item`),
  KEY `fk_order_detail_created_by` (`created_by`),
  KEY `fk_order_detail_modified_by` (`modified_by`),
  CONSTRAINT `fk_order_detail_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_order_detail_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_order_detail_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_order_detail_order_item` FOREIGN KEY (`item`) REFERENCES `items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.order_detail: ~2 rows (approximately)
/*!40000 ALTER TABLE `order_detail` DISABLE KEYS */;
REPLACE INTO `order_detail` (`id`, `created_on`, `modified_on`, `created_by`, `modified_by`, `order_id`, `item`, `order_item`, `price_item`, `qty`, `subtotal`) VALUES
	(7, '2019-02-13 14:42:16', '2019-02-13 14:42:16', 'hidayat', 'hidayat', 'ORD-2019089', NULL, 'Nasi goreng mafia di bandung', 18000.00, 1, 18000.00),
	(8, '2019-02-13 14:42:50', '2019-02-13 14:42:50', 'hidayat', 'hidayat', 'ORD-2019090', NULL, 'Nasi goreng mafia di bandung', 10000.00, 1, 10000.00);
/*!40000 ALTER TABLE `order_detail` ENABLE KEYS */;

-- Dumping structure for table mas-d-order.order_status_lookup
DROP TABLE IF EXISTS `order_status_lookup`;
CREATE TABLE IF NOT EXISTS `order_status_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_status_lookup_created_by` (`created_by`),
  KEY `fk_order_status_lookup_modified_by` (`modified_by`),
  CONSTRAINT `fk_order_status_lookup_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_order_status_lookup_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.order_status_lookup: ~4 rows (approximately)
/*!40000 ALTER TABLE `order_status_lookup` DISABLE KEYS */;
REPLACE INTO `order_status_lookup` (`id`, `created_on`, `modified_on`, `created_by`, `modified_by`, `name`, `description`) VALUES
	(1, '2019-02-13 14:00:34', '2019-02-13 14:00:34', NULL, NULL, 'PENDING', NULL),
	(2, '2019-02-13 14:00:40', '2019-02-13 14:00:40', NULL, NULL, 'PROCESS', NULL),
	(3, '2019-02-13 14:00:46', '2019-02-13 14:00:46', NULL, NULL, 'REJECT', NULL),
	(4, '2019-02-13 14:00:51', '2019-02-13 14:00:51', NULL, NULL, 'DONE', NULL);
/*!40000 ALTER TABLE `order_status_lookup` ENABLE KEYS */;

-- Dumping structure for procedure mas-d-order.p_add_order
DROP PROCEDURE IF EXISTS `p_add_order`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_add_order`(
	in id_param varchar(50),
	in date_param date,
	in money_param double(12,2),
	in total_param double(12,2),
	in change_money_param double(12,2),
	in notes_param text,
	in status_param int,
	in user_param varchar(50)
)
BEGIN

	INSERT INTO orders 
		(id, date, money, total, change_money, notes, status, user, created_by, modified_by) 
	VALUES 
		(id_param, date_param, money_param, total_param, 
		change_money_param, notes_param, status_param, user_param, user_param, user_param);

END//
DELIMITER ;

-- Dumping structure for procedure mas-d-order.p_add_order_detail
DROP PROCEDURE IF EXISTS `p_add_order_detail`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_add_order_detail`(
	in order_id_param varchar(50),
	in item_param int,
	in order_item_param varchar(255),
	in price_item_param double(12,2),
	in qty_param int,
	in subtotal_param double(12,2),
	in created_by_param varchar(50) 
)
BEGIN

	-- insert order detail
	INSERT INTO order_detail 
		(order_id, item, order_item, price_item, qty, subtotal, created_by, modified_by) 
	VALUES 
		(order_id_param, item_param, order_item_param, price_item_param, 
		qty_param, subtotal_param, created_by_param, created_by_param);

END//
DELIMITER ;

-- Dumping structure for procedure mas-d-order.p_delete_order
DROP PROCEDURE IF EXISTS `p_delete_order`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_delete_order`(
	in id_param int
)
BEGIN

	DELETE FROM order_detail WHERE order_id = id_param;
	DELETE FROM orders WHERE id = id_param;

END//
DELIMITER ;

-- Dumping structure for procedure mas-d-order.p_delete_order_detail
DROP PROCEDURE IF EXISTS `p_delete_order_detail`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_delete_order_detail`(
	in id_param int
)
BEGIN

	DELETE FROM order_detail WHERE id = id_param;

END//
DELIMITER ;

-- Dumping structure for procedure mas-d-order.p_edit_order
DROP PROCEDURE IF EXISTS `p_edit_order`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_edit_order`(
	in id_param varchar(50),
	in date_param date,
	in money_param double(12,2),
	in total_param double(12,2),
	in change_money_param double(12,2),
	in notes_param text,
	in status_param int,
	in modified_by_param varchar(50)
)
BEGIN

	UPDATE orders SET
		date = date_param,
		money = money_param,
		total = total_param,
		change_money = change_money_param,
		notes = notes_param,
		status = status_param,
		modified_by = modified_by_param
	WHERE id = id_param;

END//
DELIMITER ;

-- Dumping structure for procedure mas-d-order.p_edit_order_detail
DROP PROCEDURE IF EXISTS `p_edit_order_detail`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_edit_order_detail`(
	in id_param int,
	in order_id_param varchar(50),
	in item_param int,
	in order_item_param varchar(255),
	in price_item_param double(12,2),
	in qty_param int,
	in subtotal_param double(12,2),
	in modified_by_param varchar(50)
)
BEGIN

	UPDATE order_detail SET
		item = item_param,
		order_item = order_item_param,
		price_item = price_item_param,
		qty = qty_param,
		subtotal = subtotal_param,
		modified_by = modified_by_param
	WHERE id = id_param;

END//
DELIMITER ;

-- Dumping structure for procedure mas-d-order.p_edit_status_order
DROP PROCEDURE IF EXISTS `p_edit_status_order`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_edit_status_order`(
	in id_param varchar(50),
	in status_param int,
	in modified_by_param varchar(50)
)
BEGIN

	UPDATE orders SET
		status = status_param,
		modified_by = modified_by_param
	WHERE id = id_param;

END//
DELIMITER ;

-- Dumping structure for table mas-d-order.role_permission
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE IF NOT EXISTS `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_role_permission_user` (`user`),
  KEY `fk_role_permission_permission_id` (`permission_id`),
  KEY `fk_role_permission_created_by` (`created_by`),
  KEY `fk_role_permission_modified_by` (`modified_by`),
  CONSTRAINT `fk_role_permission_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_role_permission_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_role_permission_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `menu_detail` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_role_permission_user` FOREIGN KEY (`user`) REFERENCES `user` (`username`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.role_permission: ~15 rows (approximately)
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
REPLACE INTO `role_permission` (`id`, `created_on`, `modified_on`, `created_by`, `modified_by`, `user`, `permission_id`) VALUES
	(1, '2019-02-12 18:24:19', '2019-02-12 18:26:08', NULL, NULL, 'hidayat', 1),
	(2, '2019-02-12 18:26:14', '2019-02-12 18:26:14', NULL, NULL, 'hidayat', 2),
	(3, '2019-02-12 18:26:27', '2019-02-12 18:26:27', NULL, NULL, 'hidayat', 3),
	(4, '2019-02-12 18:26:32', '2019-02-12 18:26:32', NULL, NULL, 'hidayat', 4),
	(5, '2019-02-12 18:26:41', '2019-02-12 18:26:41', NULL, NULL, 'hidayat', 5),
	(6, '2019-02-12 18:26:46', '2019-02-12 18:26:46', NULL, NULL, 'hidayat', 6),
	(7, '2019-02-12 18:26:52', '2019-02-12 18:26:52', NULL, NULL, 'hidayat', 7),
	(8, '2019-02-12 18:26:59', '2019-02-12 18:26:59', NULL, NULL, 'hidayat', 8),
	(9, '2019-02-12 18:27:05', '2019-02-12 18:27:05', NULL, NULL, 'hidayat', 9),
	(10, '2019-02-12 18:27:11', '2019-02-12 18:27:11', NULL, NULL, 'hidayat', 10),
	(11, '2019-02-12 18:27:17', '2019-02-12 18:27:17', NULL, NULL, 'hidayat', 11),
	(12, '2019-02-12 18:27:21', '2019-02-12 18:27:24', NULL, NULL, 'hidayat', 12),
	(13, '2019-02-12 18:27:29', '2019-02-12 18:27:29', NULL, NULL, 'hidayat', 13),
	(14, '2019-02-12 18:27:34', '2019-02-12 18:27:34', NULL, NULL, 'hidayat', 14),
	(15, '2019-02-12 18:27:38', '2019-02-12 18:27:41', NULL, NULL, 'hidayat', 15);
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;

-- Dumping structure for table mas-d-order.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `password` text,
  `name` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `image` text,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username` (`username`),
  KEY `fk_user_level` (`level`),
  KEY `fk_user_status` (`status`),
  KEY `fk_user_created_by` (`created_by`),
  KEY `fk_user_modified_by` (`modified_by`),
  CONSTRAINT `fk_user_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_level` FOREIGN KEY (`level`) REFERENCES `level_lookup` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_user_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_status` FOREIGN KEY (`status`) REFERENCES `active_status_lookup` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mas-d-order.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
REPLACE INTO `user` (`username`, `created_on`, `modified_on`, `created_by`, `modified_by`, `password`, `name`, `level`, `status`, `image`) VALUES
	('alibaba', '2019-02-12 18:23:11', '2019-02-12 18:23:11', NULL, NULL, 'alibaba', 'M. Ali Imron', 2, 1, NULL),
	('hidayat', '2019-02-12 18:22:38', '2019-02-12 18:22:38', NULL, NULL, 'hidayat', 'M. Hidayat', 1, 1, NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for view mas-d-order.v_access_menu
DROP VIEW IF EXISTS `v_access_menu`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_access_menu` (
	`id` INT(11) NOT NULL,
	`level_id` INT(11) NULL,
	`level_name` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`menu_id` INT(11) NULL,
	`menu_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`url` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`class` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`icon` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`position` TINYINT(4) NULL
) ENGINE=MyISAM;

-- Dumping structure for view mas-d-order.v_increment
DROP VIEW IF EXISTS `v_increment`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_increment` (
	`id` INT(11) NOT NULL,
	`menu_id` INT(11) NOT NULL,
	`menu_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`table_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`mask` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`last_increment` INT(11) NULL,
	`description` TEXT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view mas-d-order.v_items
DROP VIEW IF EXISTS `v_items`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_items` (
	`id` INT(11) NOT NULL,
	`name` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`price` DOUBLE(12,2) NULL,
	`description` TEXT NULL COLLATE 'latin1_swedish_ci',
	`image` TEXT NULL COLLATE 'latin1_swedish_ci',
	`created_on` DATETIME NOT NULL,
	`created_by` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`created_by_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`modified_on` DATETIME NOT NULL,
	`modified_by` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`modified_by_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view mas-d-order.v_menu_permission
DROP VIEW IF EXISTS `v_menu_permission`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_menu_permission` (
	`menu_id` INT(11) NOT NULL,
	`menu_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`permission_id` INT(11) NOT NULL,
	`permission_name` VARCHAR(13) NULL COLLATE 'utf8mb4_general_ci',
	`permission` CHAR(1) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view mas-d-order.v_orders
DROP VIEW IF EXISTS `v_orders`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_orders` (
	`order_number` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`order_date` DATE NULL,
	`money` DOUBLE(12,2) NULL,
	`total` DOUBLE(12,2) NULL,
	`change_money` DOUBLE(12,2) NULL,
	`notes` TEXT NULL COLLATE 'latin1_swedish_ci',
	`status_id` INT(11) NULL,
	`status_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`user` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`user_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`created_on` DATETIME NOT NULL,
	`created_by` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`created_by_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`modified_on` DATETIME NOT NULL,
	`modified_by` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`modified_by_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view mas-d-order.v_order_detail
DROP VIEW IF EXISTS `v_order_detail`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_order_detail` (
	`id` INT(11) NOT NULL,
	`order_number` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`item_id` INT(11) NULL,
	`item_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`order_item` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`price_item` DOUBLE(12,2) NULL,
	`qty` INT(11) NULL,
	`subtotal` DOUBLE(12,2) NULL,
	`created_on` DATETIME NOT NULL,
	`created_by` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`created_by_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`modified_on` DATETIME NOT NULL,
	`modified_by` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`modified_by_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view mas-d-order.v_role_permission
DROP VIEW IF EXISTS `v_role_permission`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_role_permission` (
	`id` INT(11) NOT NULL,
	`username` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`user_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`menu_id` INT(11) NULL,
	`menu_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`permission_id` INT(11) NULL,
	`permission_name` VARCHAR(13) NULL COLLATE 'utf8mb4_general_ci',
	`permission` CHAR(1) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view mas-d-order.v_user
DROP VIEW IF EXISTS `v_user`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_user` (
	`username` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`password` TEXT NULL COLLATE 'latin1_swedish_ci',
	`name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`image` TEXT NULL COLLATE 'latin1_swedish_ci',
	`level_id` INT(11) NULL,
	`level_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`status_id` INT(11) NULL,
	`status_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`created_on` DATETIME NOT NULL,
	`created_by` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`created_by_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`modified_on` DATETIME NOT NULL,
	`modified_by` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`modified_by_name` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view mas-d-order.v_access_menu
DROP VIEW IF EXISTS `v_access_menu`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_access_menu`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_access_menu` AS select `am`.`id` AS `id`,`am`.`level_id` AS `level_id`,`ll`.`name` AS `level_name`,`am`.`menu_id` AS `menu_id`,`m`.`name` AS `menu_name`,`m`.`url` AS `url`,`m`.`class` AS `class`,`m`.`icon` AS `icon`,`m`.`position` AS `position` from ((`access_menu` `am` join `level_lookup` `ll` on((`ll`.`id` = `am`.`level_id`))) join `menu` `m` on((`m`.`id` = `am`.`menu_id`)));

-- Dumping structure for view mas-d-order.v_increment
DROP VIEW IF EXISTS `v_increment`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_increment`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_increment` AS select `i`.`id` AS `id`,`i`.`menu_id` AS `menu_id`,`m`.`name` AS `menu_name`,`m`.`table_name` AS `table_name`,`i`.`mask` AS `mask`,`i`.`last_increment` AS `last_increment`,`i`.`description` AS `description` from (`increment` `i` join `menu` `m` on((`m`.`id` = `i`.`menu_id`)));

-- Dumping structure for view mas-d-order.v_items
DROP VIEW IF EXISTS `v_items`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_items`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_items` AS select `i`.`id` AS `id`,`i`.`name` AS `name`,`i`.`price` AS `price`,`i`.`description` AS `description`,`i`.`image` AS `image`,`i`.`created_on` AS `created_on`,`i`.`created_by` AS `created_by`,`ucb`.`name` AS `created_by_name`,`i`.`modified_on` AS `modified_on`,`i`.`modified_by` AS `modified_by`,`umb`.`name` AS `modified_by_name` from ((`items` `i` left join `user` `ucb` on((`ucb`.`username` = `i`.`created_by`))) left join `user` `umb` on((`umb`.`username` = `i`.`modified_by`)));

-- Dumping structure for view mas-d-order.v_menu_permission
DROP VIEW IF EXISTS `v_menu_permission`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_menu_permission`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_menu_permission` AS select `m`.`id` AS `menu_id`,`m`.`name` AS `menu_name`,`md`.`id` AS `permission_id`,(case when (`md`.`permission` = '1') then 'READ' when (`md`.`permission` = '2') then 'ADD' when (`md`.`permission` = '3') then 'UPDATE' when (`md`.`permission` = '4') then 'DELETE' when (`md`.`permission` = '5') then 'UPDATE STATUS' else 'EXPORT' end) AS `permission_name`,`md`.`permission` AS `permission` from (`menu` `m` join `menu_detail` `md` on((`md`.`menu_id` = `m`.`id`)));

-- Dumping structure for view mas-d-order.v_orders
DROP VIEW IF EXISTS `v_orders`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_orders`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_orders` AS select `o`.`id` AS `order_number`,`o`.`date` AS `order_date`,`o`.`money` AS `money`,`o`.`total` AS `total`,`o`.`change_money` AS `change_money`,`o`.`notes` AS `notes`,`o`.`status` AS `status_id`,`osl`.`name` AS `status_name`,`o`.`user` AS `user`,`u`.`name` AS `user_name`,`o`.`created_on` AS `created_on`,`o`.`created_by` AS `created_by`,`ucb`.`name` AS `created_by_name`,`o`.`modified_on` AS `modified_on`,`o`.`modified_by` AS `modified_by`,`umb`.`name` AS `modified_by_name` from ((((`orders` `o` left join `order_status_lookup` `osl` on((`osl`.`id` = `o`.`status`))) left join `user` `u` on((`u`.`username` = `o`.`user`))) left join `user` `ucb` on((`ucb`.`username` = `o`.`created_by`))) left join `user` `umb` on((`umb`.`username` = `o`.`modified_by`)));

-- Dumping structure for view mas-d-order.v_order_detail
DROP VIEW IF EXISTS `v_order_detail`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_order_detail`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_order_detail` AS select `od`.`id` AS `id`,`od`.`order_id` AS `order_number`,`od`.`item` AS `item_id`,`i`.`name` AS `item_name`,`od`.`order_item` AS `order_item`,`od`.`price_item` AS `price_item`,`od`.`qty` AS `qty`,`od`.`subtotal` AS `subtotal`,`od`.`created_on` AS `created_on`,`od`.`created_by` AS `created_by`,`ucb`.`name` AS `created_by_name`,`od`.`modified_on` AS `modified_on`,`od`.`modified_by` AS `modified_by`,`umb`.`name` AS `modified_by_name` from (((`order_detail` `od` left join `items` `i` on((`i`.`id` = `od`.`item`))) left join `user` `ucb` on((`ucb`.`username` = `od`.`created_by`))) left join `user` `umb` on((`umb`.`username` = `od`.`modified_by`)));

-- Dumping structure for view mas-d-order.v_role_permission
DROP VIEW IF EXISTS `v_role_permission`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_role_permission`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_role_permission` AS select `rm`.`id` AS `id`,`rm`.`user` AS `username`,`u`.`name` AS `user_name`,`md`.`menu_id` AS `menu_id`,`m`.`name` AS `menu_name`,`rm`.`permission_id` AS `permission_id`,(case when (`md`.`permission` = '1') then 'READ' when (`md`.`permission` = '2') then 'ADD' when (`md`.`permission` = '3') then 'UPDATE' when (`md`.`permission` = '4') then 'DELETE' when (`md`.`permission` = '5') then 'UPDATE STATUS' else 'EXPORT' end) AS `permission_name`,`md`.`permission` AS `permission` from (((`role_permission` `rm` join `user` `u` on((`u`.`username` = `rm`.`user`))) join `menu_detail` `md` on((`md`.`id` = `rm`.`permission_id`))) join `menu` `m` on((`m`.`id` = `md`.`menu_id`)));

-- Dumping structure for view mas-d-order.v_user
DROP VIEW IF EXISTS `v_user`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user` AS select `u`.`username` AS `username`,`u`.`password` AS `password`,`u`.`name` AS `name`,`u`.`image` AS `image`,`u`.`level` AS `level_id`,`ll`.`name` AS `level_name`,`u`.`status` AS `status_id`,`asl`.`name` AS `status_name`,`u`.`created_on` AS `created_on`,`u`.`created_by` AS `created_by`,`ucb`.`name` AS `created_by_name`,`u`.`modified_on` AS `modified_on`,`u`.`modified_by` AS `modified_by`,`umb`.`name` AS `modified_by_name` from ((((`user` `u` left join `level_lookup` `ll` on((`ll`.`id` = `u`.`level`))) left join `active_status_lookup` `asl` on((`asl`.`id` = `u`.`status`))) left join `user` `ucb` on((`ucb`.`username` = `u`.`created_by`))) left join `user` `umb` on((`umb`.`username` = `u`.`modified_by`)));

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
