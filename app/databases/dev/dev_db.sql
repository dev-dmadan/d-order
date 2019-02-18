# Database Mas D Order #
# mas-d-order #
# Version 1.0 for DBMS MySQL and MariaDB #

DROP DATABASE IF EXISTS `mas-d-order`;
CREATE DATABASE `mas-d-order`;
USE `mas-d-order`;

# ============================= Lookup Table ============================= #

-- Table lookup level
	DROP TABLE IF EXISTS level_lookup;
	CREATE TABLE IF NOT EXISTS level_lookup (
		id int NOT NULL AUTO_INCREMENT,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

		name varchar(255) NOT NULL,
		description varchar(255),

		CONSTRAINT pk_level_lookup_id PRIMARY KEY(id)
	)ENGINE=InnoDb;
-- End Table lookup level

-- Table lookup status aktif
	DROP TABLE IF EXISTS active_status_lookup;
	CREATE TABLE IF NOT EXISTS active_status_lookup (
		id int NOT NULL AUTO_INCREMENT,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

		name varchar(255) NOT NULL,
		description varchar(255),

		CONSTRAINT pk_active_status_lookup_id PRIMARY KEY(id)
	)ENGINE=InnoDb;
-- End Table lookup status aktif

-- Table User
	DROP TABLE IF EXISTS user;
	CREATE TABLE IF NOT EXISTS user (
		username varchar(50) NOT NULL UNIQUE,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		password text,
		name varchar(255),
		level int, -- fk level lookup
		status int, -- fk active status lookup
		image text,

		CONSTRAINT pk_user_username PRIMARY KEY(username),
		CONSTRAINT fk_user_level FOREIGN KEY(level) REFERENCES level_lookup(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_user_status FOREIGN KEY(status) REFERENCES active_status_lookup(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_user_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_user_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table user

-- Table lookup status order
	DROP TABLE IF EXISTS order_status_lookup;
	CREATE TABLE IF NOT EXISTS order_status_lookup (
		id int NOT NULL AUTO_INCREMENT,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		name varchar(255) NOT NULL,
		description varchar(255),

		CONSTRAINT pk_order_status_lookup_id PRIMARY KEY(id),
		CONSTRAINT fk_order_status_lookup_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_order_status_lookup_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table lookup status order

# =========================== End Lookup Table =========================== #

# ============================== Base Table ============================== #

-- Table Items
	DROP TABLE IF EXISTS items;
	CREATE TABLE IF NOT EXISTS items (
		id int NOT NULL AUTO_INCREMENT,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		name varchar(255) NOT NULL,
		price double(12,2),
		description text,
		image text,
		status int, -- fk

		CONSTRAINT pk_items_id PRIMARY KEY(id),
		CONSTRAINT fk_items_status FOREIGN KEY(status) REFERENCES active_status_lookup(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_items_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_items_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table Items

-- Table Order
	DROP TABLE IF EXISTS orders;
	CREATE TABLE IF NOT EXISTS orders (
		id varchar(50) NOT NULL UNIQUE,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		date date,
		money double(12,2),
		total double(12,2),
		change_money double(12,2),
		notes text,
		status int, -- fk order status lookup
		user varchar(50), -- fk user

		CONSTRAINT pk_order_id PRIMARY KEY(id),
		CONSTRAINT fk_order_status FOREIGN KEY(status) REFERENCES order_status_lookup(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_order_user FOREIGN KEY(user) REFERENCES user(username)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_order_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_order_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table Order

-- Table Detail Order
	DROP TABLE IF EXISTS order_detail;
	CREATE TABLE IF NOT EXISTS order_detail (
		id int NOT NULL AUTO_INCREMENT,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		order_id varchar(50), -- fk order
		item int, -- fk menu
		order_item varchar(255),
		price_item double(12,2),
		qty int,
		subtotal double(12,2),

		CONSTRAINT pk_order_detail_id PRIMARY KEY(id),
		CONSTRAINT fk_order_detail_order_id FOREIGN KEY(order_id) REFERENCES orders(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_order_detail_order_item FOREIGN KEY(item) REFERENCES items(id)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_order_detail_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_order_detail_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table Detail Order

-- Tabel Menu
	DROP TABLE IF EXISTS menu;
	CREATE TABLE IF NOT EXISTS menu(
		id int NOT NULL AUTO_INCREMENT,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		name varchar(255),
		table_name varchar(255),
		url varchar(255),
		class varchar(50),
		icon varchar(50),
		position tinyint,

		CONSTRAINT pk_menu_id PRIMARY KEY(id),
		CONSTRAINT fk_menu_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_menu_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table Menu

-- Tabel Detail Menu
	DROP TABLE IF EXISTS menu_detail;
	CREATE TABLE IF NOT EXISTS menu_detail(
		id int NOT NULL AUTO_INCREMENT,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		menu_id int, -- fk
		permission char(1),
		-- 1: Read, 2: Add, 3: Update, 4: Delete, 5: Update Status, 6: Export

		CONSTRAINT pk_menu_detail_id PRIMARY KEY(id),
		CONSTRAINT fk_menu_detail_menu_id FOREIGN KEY(menu_id) REFERENCES menu(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_menu_detail_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_menu_detail_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table Detail Menu

-- Tabel Access Menu
	DROP TABLE IF EXISTS access_menu;
	CREATE TABLE IF NOT EXISTS access_menu (
		id int NOT NULL AUTO_INCREMENT,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		level_id int, -- fk level lookup
		menu_id int, -- fk menu

		CONSTRAINT pk_access_menu_id PRIMARY KEY(id),
		CONSTRAINT fk_access_menu_level_id FOREIGN KEY(level_id) REFERENCES level_lookup(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_access_menu_menu_id FOREIGN KEY(menu_id) REFERENCES menu(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_access_menu_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_access_menu_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table Access Menu

-- Tabel Role Permission
	DROP TABLE IF EXISTS role_permission;
	CREATE TABLE IF NOT EXISTS role_permission(
		id int NOT NULL AUTO_INCREMENT,
		
		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		user varchar(50), -- fk
		permission_id int, -- fk

		CONSTRAINT pk_role_permission_id PRIMARY KEY(id),
		CONSTRAINT fk_role_permission_user FOREIGN KEY(user) REFERENCES user(username)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_role_permission_permission_id FOREIGN KEY(permission_id) REFERENCES menu_detail(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_role_permission_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_role_permission_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table Role Permission

-- Table Increment
	DROP TABLE IF EXISTS increment;
	CREATE TABLE IF NOT EXISTS increment(
		id int NOT NULL AUTO_INCREMENT,

		created_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		modified_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		created_by varchar(50), -- who created first
		modified_by varchar(50), -- who last edit

		menu_id int NOT NULL UNIQUE, -- nama tabel yang ingin ada increment
		mask varchar(255), -- format increment
		last_increment int,
		description text,

		CONSTRAINT pk_increment_id PRIMARY KEY(id),
		CONSTRAINT fk_increment_menu_id FOREIGN KEY(menu_id) REFERENCES menu(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_increment_created_by FOREIGN KEY(created_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE,
		CONSTRAINT fk_increment_modified_by FOREIGN KEY(modified_by) REFERENCES user(username)
			ON DELETE SET NULL ON UPDATE CASCADE
	)ENGINE=InnoDb;
-- End Table Increment

# ============================ End Base Table ============================ #

# ============================== Feed Lookup ============================== #

-- Feed active_status_lookup
	INSERT INTO active_status_lookup 
		(id, name, description) 
	VALUES
		(1, 'ACTIVE', NULL),
		(2, 'NON ACTIVE', NULL);
-- End Feed active_status_lookup

-- Feed level_lookup
	INSERT INTO level_lookup 
		(id, name, description) 
	VALUES
		(1, 'ADMIN', NULL),
		(2, 'MEMBERS', NULL);
-- End Feed level_lookup

-- Feed order_status_lookup
	INSERT INTO order_status_lookup 
		(id, name, description) 
	VALUES
		(1, 'PENDING', NULL),
		(2, 'PROCESS', NULL),
		(3, 'REJECT', NULL),
		(4, 'DONE', NULL);
-- End Feed order_status_lookup

-- Feed menu
	INSERT INTO menu
		(id, name, table_name, url, class, icon, position) 
	VALUES
		(1, 'Orders List', 'orders', 'orders', 'menu-orders-list', NULL, 1),
		(2, 'Orders Form', NULL, 'orders/form', 'menu-orders-form', NULL, 2),
		(3, 'Menu Items', 'items', 'items', 'menu-items', NULL, 4),
		(4, 'User', 'user', 'user', 'menu-user', NULL, 5),
		(5, 'Orders History', NULL, 'orders/history', 'menu-orders-history', NULL, 3);
-- End Feed menu

-- Feed menu_detail
	INSERT INTO menu_detail
		(id, menu_id, permission) 
	VALUES
		(1, 1, '1'),
		(2, 1, '2'),
		(3, 1, '3'),
		(4, 1, '4'),
		(5, 1, '5'),
		(6, 3, '1'),
		(7, 3, '2'),
		(8, 3, '3'),
		(9, 3, '4'),
		(10, 3, '5'),
		(11, 4, '1'),
		(12, 4, '2'),
		(13, 4, '3'),
		(14, 4, '4'),
		(15, 4, '5');
-- End Feed menu_detail

-- Feed Increment
	INSERT INTO increment 
		(id, menu_id, mask, last_increment, description) 
	VALUES
		(1, 1, 'ORD-yyyy-000', 6, NULL);
-- End Feed Increment

# ============================ End Feed Lookup ============================ #