CREATE DATABASE `mas-d-order`

-- Table lookup level
CREATE TABLE IF NOT EXISTS level_lookup (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description varchar(255),

    CONSTRAINT pk_level_lookup_id PRIMARY KEY(id)
)ENGINE=InnoDb;

-- Table lookup status aktif
CREATE TABLE IF NOT EXISTS active_status_lookup (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description varchar(255),

    CONSTRAINT pk_active_status_lookup_id PRIMARY KEY(id)
)ENGINE=InnoDb;

-- Table lookup status order
CREATE TABLE IF NOT EXISTS order_status_lookup (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description varchar(255),

    CONSTRAINT pk_order_status_lookup_id PRIMARY KEY(id)
)ENGINE=InnoDb;

-- Table User
CREATE TABLE IF NOT EXISTS user (
    username varchar(50) NOT NULL UNIQUE,
    password text,
    name varchar(255),
    level int, -- fk level lookup
	status int, -- fk active status lookup

	CONSTRAINT pk_user_username PRIMARY KEY(username),
    CONSTRAINT fk_user_level FOREIGN KEY(level) REFERENCES level_lookup(id)
		ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_user_status FOREIGN KEY(status) REFERENCES active_status_lookup(id)
		ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=InnoDb;

-- Table Menu
CREATE TABLE IF NOT EXISTS menu (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    price double(12,2),
    description text,
    image text,

    CONSTRAINT pk_menu_id PRIMARY KEY(id)
)ENGINE=InnoDb;

-- Table Order
CREATE TABLE IF NOT EXISTS orders (
    id varchar(50) NOT NULL UNIQUE,
    date date,
    money double(12,2),
    total double(12,2),
    change_money double(12,2),
    notes text,
    status int, -- fk order status lookuo
    user varchar(50), -- fk user

    CONSTRAINT pk_order_id PRIMARY KEY(id),
    CONSTRAINT fk_order_status FOREIGN KEY(status) REFERENCES order_status_lookup(id)
		ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_order_user FOREIGN KEY(user) REFERENCES user(username)
		ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=InnoDb;

-- Table Detail Order
CREATE TABLE IF NOT EXISTS order_detail (
    id int NOT NULL AUTO_INCREMENT,
    order_id varchar(50), -- fk order
    menu int, -- fk menu
    order_item varchar(255),
    notes varchar(255),
    qty int,
    subtotal double(12,2),

    CONSTRAINT pk_order_detail_id PRIMARY KEY(id),
    CONSTRAINT fk_order_detail_order_id FOREIGN KEY(order_id) REFERENCES orders(id)
		ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_order_detail_order_item FOREIGN KEY(menu) REFERENCES menu(id)
		ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDb;